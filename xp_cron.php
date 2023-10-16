<?
require "config.php";

$walog_file = "/home/www/dev-survey.arlab.org.il/wa_".date("ymd").".log";

date_default_timezone_set('Asia/Jerusalem');

$from = "whatsapp:+";
$from_sms = "+";

$ch = curl_init();

$q = mysql_query("select * from twilios order by send_time") or die(mysql_error());
while($distr = mysql_fetch_array($q))
	{
	$id = $distr["twilio_id"];
	$user_id = $distr["user_id"];
	if (gmdate_to_mydate($distr["send_time"]) <= date("Y-m-d H:i:s"))
		echo "<hr><br />Try id ".$id." (survey ".$distr["twilio_surveyID"].", customer ".$distr["customer_id"].", distr ".$distr["distr_id"]."): ".gmdate_to_mydate($distr["send_time"])." | ".date("Y-m-d H:i:s")." (state: ".$distr["state"].") to ".$distr["phone"]."<br />";
	else
		echo "<hr><br /><strong>Try id ".$id.": ".gmdate_to_mydate($distr["send_time"])." | ".date("Y-m-d H:i:s")." (state: ".$distr["state"].") to ".$distr["phone"]."</strong><br />";

	if (gmdate_to_mydate($distr["send_time"]) <= date("Y-m-d H:i:s") && ($distr["state"] == 'init' || $distr["state"] == '0'))
		{
		echo "Really sending to ".$distr["phone"]." at ".date("Y-m-d H:i:s")."<br />";
		// send twilio message
		$sid = '';
		$tw_token = '';
		
		
		$params = array();

		$distr_id = $distr["distr_id"];
		$surveyID = $distr["twilio_surveyID"];
		$message = $distr["message"];
		
		if ($distr["is_reminder_for"] != "")
			{
			$distr_id = $distr["is_reminder_for"];
			echo "It is whatsapp reminder!<br />";
		}
		else
			echo "It is whatsapp main message!<br />";

		$slct = mysql_query("select * from users where user_id = ".(int)$user_id) or die(mysql_error());
		if ($arr = mysql_fetch_assoc($slct))
			{
			$token = $arr["q_token"];
			$url = $arr["user_url"];
			$tinyurl = $arr["tinyurl"];
			if ($tinyurl == "")
				$tinyurl = "http://l.arlab.org.il/";

			// get distribution link
			$link = "";
			curl_setopt($ch, CURLOPT_URL, "https://".$url.".qualtrics.com/API/v3/distributions/".$distr_id."/links?surveyId=".$surveyID);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_TIMEOUT, 0);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

			$headers = array();
			$headers[] = "X-Api-Token: ".$token;
			$headers[] = "Content-Type: application/json";
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

			$result = curl_exec($ch);
			if (curl_errno($ch)) {
				echo "Error: ".curl_error($ch);
				$mk_bd = fopen($walog_file,"a") or exit("No file to open!");
				flock($mk_bd,LOCK_EX);
				fwrite($mk_bd,"\n-- Link request is https://".$url.".qualtrics.com/API/v3/distributions/".$distr_id."/links?surveyId=".$surveyID." --");
				fwrite($mk_bd,"\n-- Link get failed at ".date("d/m/Y H:i").": ".curl_error($ch)." --");
				flock($mk_bd,LOCK_UN);
				fclose($mk_bd);
			}
			else {
				$json = json_decode($result, true);
				$link = $json["result"]["elements"][0]["link"];
				$mk_bd = fopen($walog_file,"a") or exit("No file to open!");
				flock($mk_bd,LOCK_EX);
				fwrite($mk_bd,"\n-- Link request is https://".$url.".qualtrics.com/API/v3/distributions/".$distr_id."/links?surveyId=".$surveyID." --");
				fwrite($mk_bd,"\n-- Link got at ".date("d/m/Y H:i").": ".$result." --");
				flock($mk_bd,LOCK_UN);
				fclose($mk_bd);
				
				$tulink = file_get_contents($tinyurl.'?url='.urlencode($link));
				$message = str_replace("{{2}}", $tulink, $message);
				
				$mk_bd = fopen($walog_file,"a") or exit("No file to open!");
				flock($mk_bd,LOCK_EX);
				
				fwrite($mk_bd,"\n-- file_get_contents of:".$tinyurl.'?url='.urlencode($link)." --");
				fwrite($mk_bd,"\n-- tulink:".$tulink." --");
				fwrite($mk_bd,"\n-- message:".$message." --");
				
				flock($mk_bd,LOCK_UN);
				fclose($mk_bd);
			}
		}
	
		$params["Body"] = strip_tags($message, "<a>");
		$params["From"] = $from;
		$params["To"] = "whatsapp:".$distr["phone"];
		$params["StatusCallback"] = $main_url."/xp_twiliowh.php";

		curl_setopt($ch, CURLOPT_URL, "https://api.twilio.com/2010-04-01/Accounts/".$sid."/Messages.json");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");

		$headers = array();
		$headers[] = "Authorization: Basic ".base64_encode("$sid:$tw_token");
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$result = curl_exec($ch);
		if (curl_errno($ch)) {
			echo "Error: ".curl_error($ch);
			$mk_bd = fopen($walog_file,"a") or exit("No file to open!");
			flock($mk_bd,LOCK_EX);
			fwrite($mk_bd,"\n-- WhatsApp send failed at ".date("d/m/Y H:i").": ".curl_error($ch)." --");
			flock($mk_bd,LOCK_UN);
			fclose($mk_bd);
		}
		else {
			echo $result;
			$arr_result = json_decode($result, JSON_UNESCAPED_UNICODE);
			if ($arr_result["sid"] != "")
				{
				echo "<br />sent, state changed to 'sending'<br />";
				mysql_query("update twilios set state = 'sending', sid = '".$arr_result["sid"]."' where twilio_id = ".$id) or die("Error: ".mysql_error());
				// $newdistr["state"] = 1;
			}
			else
				{
				echo "<br />problem, state changed to 'problem'<br />";
				$mk_bd = fopen($walog_file,"a") or exit("No file to open!");
				flock($mk_bd,LOCK_EX);
				fwrite($mk_bd,"\n-- WhatsApp auth is ".$sid.":".$token." --");
				fwrite($mk_bd,"\n-- WhatsApp send problem at ".date("d/m/Y H:i").": ".$result." --");
				flock($mk_bd,LOCK_UN);
				fclose($mk_bd);
				mysql_query("update twilios set state = 'problem', sid = '".mysql_real_escape_string($result)."' where twilio_id = ".$id) or die("Error: ".mysql_error());
			}
		}
	}
}

$q = mysql_query("select * from twilios_sms order by send_time");
while($distr = mysql_fetch_array($q))
	{
	$id = $distr["twilio_id"];
	$user_id = $distr["user_id"];
	if (gmdate_to_mydate($distr["send_time"]) <= date("Y-m-d H:i:s"))
		echo "<hr><br />Try SMS id ".$id.": ".gmdate_to_mydate($distr["send_time"])." | ".date("Y-m-d H:i:s")." (state: ".$distr["state"].") to ".$distr["phone"]."<br />";
	else
		echo "<hr><br /><strong>Try SMS id ".$id.": ".gmdate_to_mydate($distr["send_time"])." | ".date("Y-m-d H:i:s")." (state: ".$distr["state"].") to ".$distr["phone"]."</strong><br />";
	if (gmdate_to_mydate($distr["send_time"]) <= date("Y-m-d H:i:s") && ($distr["state"] == 'init' || $distr["state"] == '0'))
		{
		echo "Really sending SMS to ".$distr["phone"]." at ".date("Y-m-d H:i:s")."<br />";
		// send twilio message
		$sid = '';
		$tw_token = '';

		$ch = curl_init();
		
		$distr_id = $distr["distr_id"];
		$surveyID = $distr["twilio_surveyID"];
		$message = $distr["message"];

		if ($distr["is_reminder_for"] != "")
			{
			$distr_id = $distr["is_reminder_for"];
			echo "It is SMS reminder!<br />";
		}
		else
			echo "It is SMS main message!<br />";

		$slct = mysql_query("select * from users where user_id = ".(int)$user_id) or die(mysql_error());
		if ($arr = mysql_fetch_assoc($slct))
			{
			$token = $arr["q_token"];
			$url = $arr["user_url"];
			$tinyurl = $arr["tinyurl"];
			if ($tinyurl == "")
				$tinyurl = "http://l.arlab.org.il/";

			// get distribution link
			$link = "";
			curl_setopt($ch, CURLOPT_URL, "https://".$url.".qualtrics.com/API/v3/distributions/".$distr_id."/links?surveyId=".$surveyID);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_TIMEOUT, 0);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

			$headers = array();
			$headers[] = "X-Api-Token: ".$token;
			$headers[] = "Content-Type: application/json";
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

			$result = curl_exec($ch);
			if (curl_errno($ch)) {
				echo "Error: ".curl_error($ch);
				$mk_bd = fopen($walog_file,"a") or exit("No file to open!");
				flock($mk_bd,LOCK_EX);
				fwrite($mk_bd,"\n-- Link request is https://".$url.".qualtrics.com/API/v3/distributions/".$distr_id."/links?surveyId=".$surveyID." --");
				fwrite($mk_bd,"\n-- Link get for SMS failed at ".date("d/m/Y H:i").": ".curl_error($ch)." --");
				flock($mk_bd,LOCK_UN);
				fclose($mk_bd);
			}
			else {
				$json = json_decode($result, true);
				$link = $json["result"]["elements"][0]["link"];
				$mk_bd = fopen($walog_file,"a") or exit("No file to open!");
				flock($mk_bd,LOCK_EX);
				fwrite($mk_bd,"\n-- Link request is https://".$url.".qualtrics.com/API/v3/distributions/".$distr_id."/links?surveyId=".$surveyID." --");
				fwrite($mk_bd,"\n-- Link for SMS got at ".date("d/m/Y H:i").": ".$result." --");
				flock($mk_bd,LOCK_UN);
				fclose($mk_bd);
				
				$tulink = file_get_contents($tinyurl.'?url='.urlencode($link));
				$message = str_replace("{{2}}", $tulink, $message);
				
				$mk_bd = fopen($walog_file,"a") or exit("No file to open!");
				flock($mk_bd,LOCK_EX);
				
				fwrite($mk_bd,"\n-- file_get_contents of:".$tinyurl.'?url='.urlencode($link)." --");
				fwrite($mk_bd,"\n-- tulink:".$tulink." --");
				fwrite($mk_bd,"\n-- message:".$message." --");
				
				flock($mk_bd,LOCK_UN);
				fclose($mk_bd);
			}
		}

		$params = array();
		$params["Body"] = strip_tags($message, "<a>");
		$params["From"] = $from_sms;
		$params["To"] = $distr["phone"];
		$params["StatusCallback"] = $main_url."/xp_twiliowh.php";

		curl_setopt($ch, CURLOPT_URL, "https://api.twilio.com/2010-04-01/Accounts/".$sid."/Messages.json");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");

		$headers = array();
		$headers[] = "Authorization: Basic ".base64_encode("$sid:$tw_token");
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$result = curl_exec($ch);
		if (curl_errno($ch)) {
			echo "Error: ".curl_error($ch);
			$mk_bd = fopen($walog_file,"a") or exit("No file to open!");
			flock($mk_bd,LOCK_EX);
			fwrite($mk_bd,"\n-- WhatsApp SMS send failed at ".date("d/m/Y H:i").": ".curl_error($ch)." --");
			flock($mk_bd,LOCK_UN);
			fclose($mk_bd);
		}
		else {
			echo $result;
			$arr_result = json_decode($result, JSON_UNESCAPED_UNICODE);
			if ($arr_result["sid"] != "")
				{
				echo "<br />sent, state changed to 'sending'<br />";
				mysql_query("update twilios_sms set state = 'sending', sid = '".$arr_result["sid"]."' where twilio_id = ".$id) or die("Error: ".mysql_error());
				// $newdistr["state"] = 1;
			}
			else
				{
				echo "<br />problem, state changed to 'problem'<br />";
				$mk_bd = fopen($walog_file,"a") or exit("No file to open!");
				flock($mk_bd,LOCK_EX);
				fwrite($mk_bd,"\n-- WhatsApp SMS auth is ".$sid.":".$token." --");
				fwrite($mk_bd,"\n-- WhatsApp SMS send problem at ".date("d/m/Y H:i").": ".$result." --");
				flock($mk_bd,LOCK_UN);
				fclose($mk_bd);
				mysql_query("update twilios_sms set state = 'problem', sid = '".mysql_real_escape_string($result)."' where twilio_id = ".$id) or die("Error: ".mysql_error());
			}
		}
	}
}
curl_close ($ch);
function gmdate_to_mydate($gmdate){
	/* $gmdate must be in YYYY-mm-dd H:i:s format*/
	$timezone=date_default_timezone_get();
	$userTimezone = new DateTimeZone($timezone);
	$gmtTimezone = new DateTimeZone('GMT');
	$myDateTime = new DateTime($gmdate, $gmtTimezone);
	$offset = $userTimezone->getOffset($myDateTime);
	return date("Y-m-d H:i:s", strtotime($gmdate)+$offset);
}
?>