<?php
require "config.php";
ini_set('memory_limit', '4096M'); 
set_time_limit(600000);

// $replyToEmail = "l.yadid@gmail.com";

// LOGS SETUP
$curl_log = "curl".date("ymd").".log";

// distribution create
$writeclog = 1;
$clog_file = "clog".date("ymd").".log";

// distribution delete
$writedlog = 0;
$dlog_file = "dlog".date("ymd").".log";

$writeplog = 0;
$plog_file = "plog".date("ymd").".log";

$writeqlog = 0;
$qlog_file = "qlog".date("ymd").".log";

$writeulog = 0;
$ulog_file = "ulog.log";

// link request and twilio set and delete
$writetwlog = 1;
$twlog_file = "twlog".date("ymd").".log";

// LOGS SETUP END

$lang = "he";
$http_address = $main_url;
$action = urldecode($_REQUEST["action"]);
@$method = urldecode($_REQUEST["method"]);
@$offset = $_REQUEST["offset"];
@$sendStartDate = urldecode($_REQUEST["sendStartDate"]);
@$sendEndDate = urldecode($_REQUEST["sendEndDate"]);
@$distributionRequestType = urldecode($_REQUEST["distributionRequestType"]);

// pattern for replaces
$pattern = "/\\\$\\{.*\\}/i";

$log = "";
$pass = "";
$slct = mysql_query("select * from users where user_login = '".mysql_real_escape_string($_SESSION["s_login"])."' and user_password = '".mysql_real_escape_string($_SESSION["s_password"])."'") or die(mysql_error());
if (mysql_num_rows($slct) == 1 || (@$_SESSION["s_login"] == $log && @$_SESSION["s_password"] == md5($pass)))
	{
	$arr = mysql_fetch_assoc($slct);
	$locale = $arr["locale"];
	if ($locale == "")
		$locale = "Asia/Jerusalem";
	date_default_timezone_set($locale);
	$user_id_tw = $arr["user_id"];
	$token = $arr["q_token"];
	$ph_username = $arr["ph_username"];
	$ph_password = $arr["ph_password"];
	$phys_username = $arr["phys_username"];
	$phys_password = $arr["phys_password"];
	$phys_root = $arr["phys_root"];
	$tinyurl = $arr["tinyurl"];
	if ($tinyurl == "")
		$tinyurl = "http://l.arlab.org.il/";
	$url = $arr["user_url"];
	// $q = mysql_query("select * from wa_messages where wam_id = ".(int)$arr["wa_message"]) or die(mysql_error());
	// if ($arr1 = mysql_fetch_assoc($q))
		// $wa_message = stripslashes($arr1["wam"]);
	// $q = mysql_query("select * from wa_messages where wam_id = ".(int)$arr["wa_rmessage"]) or die(mysql_error());
	// if ($arr2 = mysql_fetch_assoc($q))
		// $wa_rmessage = stripslashes($arr2["wam"]);
	$username = stripslashes($arr["user_name"]);
	$q = mysql_query("select * from wa_messages") or die("Get wams :".mysql_error());
	while($arr = mysql_fetch_assoc($q))
		$allwams[$arr["wam_id"]] = $arr["wam"];

	

	if ($method == "ADD" && $action == "wams")
		{
		$data = explode("&", urldecode($_REQUEST["data"]));
		foreach($data as $val)
			{
			$arr = explode("=", $val);
			$newdata[$arr[0]] = $arr[1];
		}
		$wam_name = $newdata["wam_name"];
		$wam = $newdata["wam"];
		if ($wam != "" && $wam_name != "")
			{
			$slct = mysql_query("insert into wa_messages (wam_name, wam) values ('".$wam_name."', '".$wam."')") or die(mysql_error());
			$newam["id"] = mysql_insert_id();
			$newam["wam_name"] = $wam_name;
			$newam["wam"] = $wam;
			echo json_encode($newam, JSON_UNESCAPED_UNICODE);
		}
		else
			echo "{\"result\":\"Error\"}";
	}
	elseif ($method == "DELETE" && $action == "wams")
		{
		$id = $_REQUEST["id"];
		$slct = mysql_query("delete from wa_messages where wam_id = ".$id) or die(mysql_error());
		echo "{\"result\":\"OK\"}";
	}
	elseif ($method == "GET" && $action == "wams")
		{
		$q = mysql_query("select * from wa_messages") or die("Get wams :".mysql_error());
		while($arr = mysql_fetch_assoc($q))
			$alldata["result"]["elements"][$arr["wam_id"]] = $arr;
		$content = json_encode($alldata, JSON_UNESCAPED_UNICODE);
		if ($content != "")
			echo $content;
		else
			echo "null";
	}
	elseif ($method == "GET" && $action == "bulks")
		{
		$sid = $_REQUEST["sid"];
		$q = mysql_query("select * from bulks where surveyId = '".$sid."'") or die("Get bulks :".mysql_error());
		while($arr = mysql_fetch_assoc($q))
			$alldata["result"]["elements"][] = $arr;
		$content = json_encode($alldata, JSON_UNESCAPED_UNICODE);
		if ($content != "")
			echo $content;
		else
			echo "null";
	}
	elseif ($method == "DELETE" && $action == "bulk")
		{
		$sid = $_REQUEST["sid"];
		$q = mysql_query("delete from bulks where surveyId = '".$sid."'") or die("Get bulks :".mysql_error());
		echo "{\"result\":\"OK\"}";
	}
	elseif ($method == "GET" && $action == "customer")
		{
		$id = $_REQUEST["id"];
		$mid = $_REQUEST["mid"];

		$ch = curl_init();

		// getting mailinglists first	
		curl_setopt($ch, CURLOPT_URL, "https://".$url.".qualtrics.com/API/v3/mailinglists/".$mid);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 0);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

		$headers = array();
		$headers[] = "X-Api-Token: ".$token;
		$headers[] = "Content-Type: application/json";
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$mk_bd = fopen($qlog_file,"a") or exit("No file to open!");
		flock($mk_bd,LOCK_EX);
		fwrite($mk_bd,"\n-- Qualtrics request https://".$url.".qualtrics.com/API/v3/mailinglists/".$mid." was at ".date("d/m/Y H:i")." --");
		flock($mk_bd,LOCK_UN);
		fclose($mk_bd);
		$result = curl_exec($ch);
		if (curl_errno($ch))
			echo curl_error($ch);
		else
			{
			$json = json_decode($result, true);
			$lid = $json["result"]["libraryId"];

			curl_setopt($ch, CURLOPT_URL, "https://".$url.".qualtrics.com/API/v3/mailinglists/".$mid."/contacts/".$id);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_TIMEOUT, 0);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

			$headers = array();
			$headers[] = "X-Api-Token: ".$token;
			$headers[] = "Content-Type: application/json";
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

			$mk_bd = fopen($qlog_file,"a") or exit("No file to open!");
			flock($mk_bd,LOCK_EX);
			fwrite($mk_bd,"\n-- Qualtrics request https://".$url.".qualtrics.com/API/v3/mailinglists/".$mid."/contacts/".$id." was at ".date("d/m/Y H:i")." --");
			flock($mk_bd,LOCK_UN);
			fclose($mk_bd);
			$result = curl_exec($ch);
			if (curl_errno($ch))
				echo curl_error($ch);
			else
				{
				$json = json_decode($result, true);
				$json["result"]["libraryId"] = $lid;
				$result = json_encode($json, JSON_UNESCAPED_UNICODE);
				echo $result;
			}
		}
		curl_close ($ch);
	}
	elseif ($method == "GET" && $action == "user")
		{
		$id = $_REQUEST["id"];
		$slct = mysql_query("select * from users where user_id = ".$id) or die(mysql_error());
		if ($arr = mysql_fetch_assoc($slct))
			echo json_encode($arr, JSON_UNESCAPED_UNICODE);
	}
	elseif ($method == "ADD" && $action == "user")
		{
		$data = explode("&", urldecode($_REQUEST["data"]));
		foreach($data as $val)
			{
			$arr = explode("=", $val);
			$newdata[$arr[0]] = $arr[1];
		}
		$user_name = $newdata["user_name"];
		$user_login = $newdata["user_login"];
		$user_password = $newdata["user_password"];
		$user_url = $newdata["user_url"];
		$q_token = $newdata["q_token"];
		$ph_username = $newdata["ph_username"];
		$ph_password = $newdata["ph_password"];
		$phys_username = $newdata["phys_username"];
		$phys_password = $newdata["phys_password"];
		$phys_root = $newdata["phys_root"];
		$tinyurl = $newdata["tinyurl"];
		if ($tinyurl == "")
			$tinyurl = "http://l.arlab.org.il/";
		$locale = $newdata["locale"];
		// $wa_message = $newdata["wa_message"];
		// $wa_rmessage = $newdata["wa_rmessage"];

		if ($user_name != "" && $user_login != "" && $user_password != "" && $user_url != "" && $q_token != "")
			{
			$slct = mysql_query("select * from users where user_name = '".$user_name."' or user_login = '".$user_login."'") or die(mysql_error());
			if (mysql_num_rows($slct) == 0)
				{
				mysql_query("insert into users (user_name, user_login, user_password, user_url, q_token, ph_username, ph_password, locale)
				values ('".mysql_real_escape_string($user_name)."', '".mysql_real_escape_string($user_login)."', '".md5($user_password)."', '".mysql_real_escape_string($user_url)."', '".$q_token."', '".$ph_username."', '".$ph_password."', '".$locale."')") or die(mysql_error());
				$id = mysql_insert_id();
				echo "{\"id\":\"".$id."\",\"name\":\"".$user_name."\",\"login\":\"".$user_login."\"}";
				if ($writeulog == 1) {
					$mk_bd = fopen($ulog_file,"a") or exit("No file to open!");
					flock($mk_bd,LOCK_EX);
					fwrite($mk_bd,"\n-- User ".$user_name." (".$id.") was added at ".date("d/m/Y H:i")." --");
					flock($mk_bd,LOCK_UN);
					fclose($mk_bd);
				}
			}
			else
				echo "{\"error\":\"Such name or login already in use\"}";
		}
		else
			echo "{\"error\":\"Not enough data\"}";
	}
	elseif ($method == "UPDATE" && $action == "user")
		{
		$data = explode("&", urldecode($_REQUEST["data"]));
		foreach($data as $val)
			{
			$arr = explode("=", $val);
			$newdata[$arr[0]] = $arr[1];
		}
		$user_id = (int)$newdata["user_id"];
		$user_name = $newdata["user_name"];
		$user_login = $newdata["user_login"];
		$user_password = $newdata["user_password"];
		if ($user_password != "")
			$pswd_txt = "user_password = '".md5($user_password)."',";
		$user_url = $newdata["user_url"];
		$q_token = $newdata["q_token"];
		$ph_username = $newdata["ph_username"];
		$ph_password = $newdata["ph_password"];
		$phys_username = $newdata["phys_username"];
		$phys_password = $newdata["phys_password"];
		$phys_root = $newdata["phys_root"];
		$tinyurl = $newdata["tinyurl"];
		if ($tinyurl == "")
			$tinyurl = "http://l.arlab.org.il/";
		$locale = $newdata["locale"];
		// $wa_message = $newdata["wa_message"];
		// $wa_rmessage = $newdata["wa_rmessage"];

		if ($user_name != "" && $user_login != "" && ($user_id != "" || $user_password != "") && $user_url != "" && $q_token != "")
			{
			mysql_query("update users set
			user_name = '".mysql_real_escape_string($user_name)."',
			user_login = '".mysql_real_escape_string($user_login)."',
			".$pswd_txt."
			user_url = '".$user_url."',
			q_token = '".$q_token."',
			ph_username = '".$ph_username."',
			ph_password = '".$ph_password."',
			phys_username = '".$phys_username."',
			phys_password = '".$phys_password."',
			phys_root = '".$phys_root."',
			tinyurl = '".$tinyurl."',
			locale = '".$locale."'
			where user_id = ".$user_id) or die(mysql_error());
			echo "{\"id\":\"".$user_id."\",\"name\":\"".$user_name."\",\"login\":\"".$user_login."\"}";
			if ($writeulog == 1) {
				$mk_bd = fopen($ulog_file,"a") or exit("No file to open!");
				flock($mk_bd,LOCK_EX);
				fwrite($mk_bd,"\n-- User ".$user_name." (".$id.") was updated at ".date("d/m/Y H:i")." --");
				flock($mk_bd,LOCK_UN);
				fclose($mk_bd);
			}
		}
		else
			echo "{\"error\":\"Not enough data\"}";
	}
	elseif ($method == "DELETE" && $action == "user")
		{
		$id = $_REQUEST["id"];
		$slct = mysql_query("select * from users where user_id = ".$id) or die(mysql_error());
		if ($arr = mysql_fetch_assoc($slct))
			{
			mysql_query("delete from users where user_id = ".$id);
			if ($writeulog == 1) {
				$mk_bd = fopen($ulog_file,"a") or exit("No file to open!");
				flock($mk_bd,LOCK_EX);
				fwrite($mk_bd,"\n-- User ".$arr["user_name"]." (".$id.") was deleted at ".date("d/m/Y H:i")." --");
				flock($mk_bd,LOCK_UN);
				fclose($mk_bd);
			}
			echo "{\"result\":\"OK\"}";
		}
		else
			echo "{\"error\":\"No user to delete\"}";
	}
	elseif ($method == "DELETE" && $action == "wrong")
		{
		$surveyID = $_REQUEST["sid"];
		
		if ($sendStartDate != "")
			$sendStart_text = "&sendStartDate=".make_time($sendStartDate." 00:00:00");
		if ($sendEndDate != "")
			$sendEnd_text = "&sendEndDate=".make_time($sendEndDate." 23:59:59");
		if ($surveyID != "")
			{
			$ch = curl_init();

			// getting mailinglists first	
			curl_setopt($ch, CURLOPT_URL, "https://".$url.".qualtrics.com/API/v3/mailinglists");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_TIMEOUT, 0);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

			$headers = array();
			$headers[] = "X-Api-Token: ".$token;
			$headers[] = "Content-Type: application/json";
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

			$mk_bd = fopen($qlog_file,"a") or exit("No file to open!");
			flock($mk_bd,LOCK_EX);
			fwrite($mk_bd,"\n-- Qualtrics request https://".$url.".qualtrics.com/API/v3/mailinglists was at ".date("d/m/Y H:i")." --");
			flock($mk_bd,LOCK_UN);
			fclose($mk_bd);
			$result = curl_exec($ch);
			if (curl_errno($ch)) {
				$func_result["mailinglists"]["error"][] = curl_error($ch);
			}
			else
				{
				$json = json_decode($result, true);
				foreach ($json["result"]["elements"] as $customer)
					$allcustomers[] = $customer["id"];
				$func_result["mailinglists"][] = $json;
			}

			curl_setopt($ch, CURLOPT_URL, "https://".$url.".qualtrics.com/API/v3/distributions?surveyId=".$surveyID.$sendStart_text.$sendEnd_text);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_TIMEOUT, 0);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

			$headers = array();
			$headers[] = "X-Api-Token: ".$token;
			$headers[] = "Content-Type: application/json";
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

			$mk_bd = fopen($qlog_file,"a") or exit("No file to open!");
			flock($mk_bd,LOCK_EX);
			fwrite($mk_bd,"\n-- Qualtrics request https://".$url.".qualtrics.com/API/v3/distributions?surveyId=".$surveyID.$sendStart_text.$sendEnd_text." was at ".date("d/m/Y H:i")." --");
			flock($mk_bd,LOCK_UN);
			fclose($mk_bd);
			$result = curl_exec($ch);
			if (curl_errno($ch)) {
				echo "Error: ".curl_error($ch);
			}
			else {
				// list distributions for surveys
				$distributions = json_decode($result, true);
				foreach ($distributions["result"]["elements"] as $distribution)
					{
					$func_result["distributions"][$distribution["id"]]["id"] = $distribution["recipients"]["mailingListId"];
					
					// compare maillistID of distribution
					if ($distribution["recipients"]["mailingListId"] == null || !in_array($distribution["recipients"]["mailingListId"], $allcustomers))
						{
						// $func_result["distributions"][$distribution["id"]]["message"] = "Will be deleted (".$survey["name"].")!";
						curl_setopt($ch, CURLOPT_URL, "https://".$url.".qualtrics.com/API/v3/distributions/".$distribution["id"]);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
						curl_setopt($ch, CURLOPT_TIMEOUT, 0);
						curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");

						$mk_bd = fopen($qlog_file,"a") or exit("No file to open!");
						flock($mk_bd,LOCK_EX);
						fwrite($mk_bd,"\n-- Qualtrics request https://".$url.".qualtrics.com/API/v3/distributions/".$distribution["id"]." was at ".date("d/m/Y H:i")." --");
						flock($mk_bd,LOCK_UN);
						fclose($mk_bd);
						$result = curl_exec($ch);
						if (curl_errno($ch)) {
							echo "Error: ".curl_error($ch);
						}
						else {
							$func_result["distributions"][$distribution["id"]]["message"] = "deleted successfully";
						}
					}
					else
						$func_result["distributions"][$distribution["id"]]["message"] = "Will NOT be deleted (".$survey["name"].")...";
				}
			}
			echo json_encode($func_result, JSON_UNESCAPED_UNICODE);
			curl_close($ch);
		}
	}
	elseif ($action == "roles")
		{
		// getting roles
		if ($method == "GET")
			{
			if ($_REQUEST["sid"] != "")
				$q = mysql_query("select * from roles where SurveyID = '".$_REQUEST["sid"]."'") or die(mysql_error());
			else
				$q = mysql_query("select * from roles") or die(mysql_error());
			while ($arr = mysql_fetch_assoc($q))
				$alldata["result"]["elements"][$arr["SurveyID"]] = $arr;
			$content = json_encode($alldata, JSON_UNESCAPED_UNICODE);
			if ($content != "")
				echo $content;
			else
				echo "null";
		}
		elseif ($method == "POST")
			{
			// adding role
			$data = explode("&", $_REQUEST["data"]);
			foreach($data as $val)
				{
				$arr = explode("=", $val);
				$newdata[$arr[0]] = $arr[1];
			}
			$q = mysql_query("select * from roles where SurveyID = '".$newdata["surveyId"]."'") or die(mysql_error());
			if (mysql_num_rows($q) == 0) {
				mysql_query("insert into roles (SurveyID, times, pause, snooze, expire, email_subj, from_name, random_interval, reply_to, phonicID, send_option, min_time_between, max_time_between) values ('".$newdata["surveyId"]."', '".$newdata["times"]."', '".$newdata["pause"]."', '".$newdata["snooze"]."', '".$newdata["expire"]."', '".$newdata["email_subj"]."', '".$newdata["from_name"]."', '".$newdata["random_interval"]."', '".$newdata["reply_to"]."', '".$newdata["phonicID"]."', '".$newdata["send_option"]."', '".$newdata["min_time_between"]."', '".$newdata["max_time_between"]."')") or die(mysql_error());
				$ch = curl_init();

				$params = '{';
				$params .= '"topics": "surveyengine.completedResponse.'.$newdata["surveyId"].'",';
				$params .= '"publicationUrl": "'.$http_address.'/xp_eventlistener.php",';
				$params .= '"encrypt": false';
				$params .= '}';
					
				curl_setopt($ch, CURLOPT_URL, "https://".$url.".qualtrics.com/API/v3/eventsubscriptions");
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_TIMEOUT, 0);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");

				$headers = array();
				$headers[] = "X-Api-Token: ".$token;
				$headers[] = "Content-Type: application/json";
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

				$mk_bd = fopen($qlog_file,"a") or exit("No file to open!");
				flock($mk_bd,LOCK_EX);
				fwrite($mk_bd,"\n-- Qualtrics request https://".$url.".qualtrics.com/API/v3/eventsubscriptions for ".$newdata["surveyId"]." was at ".date("d/m/Y H:i")." --");
				flock($mk_bd,LOCK_UN);
				fclose($mk_bd);
				$result = curl_exec($ch);
				if (curl_errno($ch)) {
					echo "Error: ".curl_error($ch);
					$mk_bd = fopen($plog_file,"a") or exit("No file to open!");
					flock($mk_bd,LOCK_EX);
					fwrite($mk_bd,"\nError subscription set: ".curl_error($ch));
					flock($mk_bd,LOCK_UN);
					fclose($mk_bd);
				}
				else
					{
					$func_result["eventsubscription"]["result"] = $result;
					$mk_bd = fopen($plog_file,"a") or exit("Cannot open file!");
					flock($mk_bd,LOCK_EX);
					fwrite($mk_bd,"\nResult at ".date("Y-m-d H:i:s").": ".$result);
					flock($mk_bd,LOCK_UN);
					fclose($mk_bd);
				}
			}
			else
				mysql_query("update roles set 
					times =  '".$newdata["times"]."',
					pause = '".$newdata["pause"]."',
					snooze = '".$newdata["snooze"]."',
					expire = '".$newdata["expire"]."',
					email_subj = '".$newdata["email_subj"]."',
					from_name = '".mysql_real_escape_string($newdata["from_name"])."',
					random_interval = '".$newdata["random_interval"]."',
					reply_to = '".mysql_real_escape_string($newdata["reply_to"])."',
					phonicID = '".$newdata["phonicID"]."',
					phonic_questionID = '".$newdata["phonic_questionID"]."',
					physioqID = '".$newdata["physioqID"]."',
					send_option = '".mysql_real_escape_string($newdata["send_option"])."',
					min_time_between = '".mysql_real_escape_string($newdata["min_time_between"])."',
					max_time_between = '".mysql_real_escape_string($newdata["max_time_between"])."'
					where SurveyID = '".$newdata["surveyId"]."'") or die(mysql_error());
			echo "{\"result\":\"OK\"}";
		}
	}
	elseif ($action == "surveys_states")
		{
		$q = mysql_query("select * from completed") or die(mysql_error());
		while($arr = mysql_fetch_assoc($q))
			$alldata["result"]["elements"][$arr["DistributionID"]] = $arr;
		$content = json_encode($alldata, JSON_UNESCAPED_UNICODE);
		if ($content != "")
			echo $content;
		else
			echo "null";
	}
	elseif ($action == "twilio_sms_states")
		{
		$q = mysql_query("select * from twilios_sms");
		while($arr = mysql_fetch_assoc($q))
			$alldata["result"]["elements"][$arr["distr_id"]] = $arr;
		$content = json_encode($alldata, JSON_UNESCAPED_UNICODE);
		if ($content != "")
			echo $content;
		else
			echo "null";
	}
	elseif ($action == "twilio_states")
		{
		$q = mysql_query("select * from twilios");
		while($arr = mysql_fetch_assoc($q))
			$alldata["result"]["elements"][$arr["distr_id"]] = $arr;
		$content = json_encode($alldata, JSON_UNESCAPED_UNICODE);
		if ($content != "")
			echo $content;
		else
			echo "null";
	}
	elseif ($method == "DELETE" && $action == "futdistr")
		{
		$ch = curl_init();

		$ml_id = $_REQUEST["ml_id"];
		$sid = $_REQUEST["sid"];
		$nextPage = "";
		$offset = "";
		$starting = 1;
		$alldistrs = array();

		while ($nextPage != "" && $nextPage != $prevNextPage || $starting == 1)
			{
			$starting = 0;
			if ($nextPage != "")
				{
				$prevNextPage = $nextPage;
				$parts = parse_url($nextPage);
				parse_str($parts["query"], $query);
				$offset = urlencode($query["skipToken"]);
			}
			$offset_text = "";
			if ($offset != "")
				$offset_text = "&skipToken=".$offset;
			if ($writedlog == 1) {
				$mk_bd = fopen($plog_file,"a") or exit("No file to open!");
				flock($mk_bd,LOCK_EX);
				fwrite($mk_bd,"\n-- Started deletion on ".$offset." offset at ".date("Y-m-d H:i:s")." --");
				flock($mk_bd,LOCK_UN);
				fclose($mk_bd);
			}

			curl_setopt($ch, CURLOPT_URL, "https://".$url.".qualtrics.com/API/v3/distributions?surveyId=".$sid.$offset_text);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_TIMEOUT, 0);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

			$headers = array();
			$headers[] = "X-Api-Token: ".$token;
			$headers[] = "Content-Type: application/json";
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

			$result = curl_exec($ch);
			if ($writedlog == 1) {
				$mk_bd = fopen($qlog_file,"a") or exit("No file to open!");
				flock($mk_bd,LOCK_EX);
				fwrite($mk_bd,"\n-- Qualtrics request https://".$url.".qualtrics.com/API/v3/distributions?surveyId=".$sid.$offset_text." was at ".date("d/m/Y H:i")." --");
				flock($mk_bd,LOCK_UN);
				fclose($mk_bd);
			}
			if ($writedlog == 1) {
				$mk_bd = fopen($plog_file,"a") or exit("No file to open!");
				flock($mk_bd,LOCK_EX);
				fwrite($mk_bd,"\nResult at ".date("Y-m-d H:i:s").": ".$result);
				flock($mk_bd,LOCK_UN);
				fclose($mk_bd);
			}
			if (curl_errno($ch)) {
				echo "Error: ".curl_error($ch);
			}
			else {
				// list distributions for surveys
				$distributions = json_decode($result, true);
				$nextPage = "";
				if ($distributions["result"]["nextPage"] != "" && $distributions["result"]["nextPage"] != "undefined" && $distributions["result"]["nextPage"] != null)
					{
					$nextPage = $distributions["result"]["nextPage"];
					if ($writedlog == 1) {
						$mk_bd = fopen($plog_file,"a") or exit("No file to open!");
						flock($mk_bd,LOCK_EX);
						fwrite($mk_bd,"\nNext page at ".date("Y-m-d H:i:s")." is ".$nextPage);
						flock($mk_bd,LOCK_UN);
						fclose($mk_bd);
					}
				}
				foreach ($distributions["result"]["elements"] as $distribution)
					{
					// $func_result["distributions"][$distribution["id"]] = $distribution["sendDate"]."|".make_time(time());
					$mk_bd = fopen($plog_file,"a") or exit("No file to open!");
					flock($mk_bd,LOCK_EX);
					fwrite($mk_bd,"\nChecking date ".$distribution["sendDate"]." and ".mydate_to_gmdate(date("Y-m-d H:i:s")).", result is ".($distribution["sendDate"] > mydate_to_gmdate(date("Y-m-d H:i:s"))));
					flock($mk_bd,LOCK_UN);
					fclose($mk_bd);
					if ($distribution["sendDate"] > mydate_to_gmdate(date("Y-m-d H:i:s")))
						$alldistrs[] = $distribution;
				}
			}
		}
		foreach ($alldistrs as $distribution)
			{
			$mk_bd = fopen($plog_file,"a") or exit("No file to open!");
			flock($mk_bd,LOCK_EX);
			fwrite($mk_bd,"\nCompairing ".$ml_id." and ".$distribution["recipients"]["mailingListId"]);
			flock($mk_bd,LOCK_UN);
			fclose($mk_bd);
			// compare maillistID of distribution
			if ($ml_id == $distribution["recipients"]["mailingListId"])
				{
				curl_setopt($ch, CURLOPT_URL, "https://".$url.".qualtrics.com/API/v3/distributions/".$distribution["id"]);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_TIMEOUT, 0);
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");

				$mk_bd = fopen($qlog_file,"a") or exit("No file to open!");
				flock($mk_bd,LOCK_EX);
				fwrite($mk_bd,"\n-- Qualtrics request https://".$url.".qualtrics.com/API/v3/distributions/".$distribution["id"]." was at ".date("d/m/Y H:i")." --");
				flock($mk_bd,LOCK_UN);
				fclose($mk_bd);
				$result = curl_exec($ch);
				if (curl_errno($ch)) {
					echo "Error: ".curl_error($ch);
				}
				else {
					$func_result["distributions"][$distribution["id"]]["message"] = "deleted successfully";
					$mk_bd = fopen($plog_file,"a") or exit("No file to open!");
					flock($mk_bd,LOCK_EX);
					fwrite($mk_bd,"\nDistribution ".$distribution["id"]." deleted successfully at ".date("Y-m-d H:i:s"));
					flock($mk_bd,LOCK_UN);
					fclose($mk_bd);
				}
				mysql_query("delete from twilios where distr_id = '".$distribution["id"]."'");
				mysql_query("delete from twilios_sms where distr_id = '".$distribution["id"]."'");
				mysql_query("delete from twilios where is_reminder_for = '".$distribution["id"]."'");
				mysql_query("delete from twilios_sms where is_reminder_for = '".$distribution["id"]."'");
			}
		}
		echo json_encode($func_result, JSON_UNESCAPED_UNICODE);
		curl_close ($ch);
	}
	elseif ($method == "DELETE" && $action == "distributions")
		{
		// deleting all distributions that has ml_id in recipients
		$ch = curl_init();

		if ($sendStartDate != "")
			$sendStart_text = "&sendStartDate=".urlencode(make_time($sendStartDate." 00:00:00"));
		if ($sendEndDate != "")
			$sendEnd_text = "&sendEndDate=".urlencode(make_time($sendEndDate." 23:59:59"));
		$ml_id = $_REQUEST["ml_id"];
		$sid = $_REQUEST["sid"];
		$nextPage = "";
		$offset = "";
		$starting = 1;
		$filescount = 0;
		$alldistrs = array();

		while ($filescount < 100 && $nextPage != "" && $nextPage != $prevNextPage || $starting == 1)
			{
			$starting = 0;
			if ($nextPage != "")
				{
				$prevNextPage = $nextPage;
				$parts = parse_url($nextPage);
				parse_str($parts["query"], $query);
				$offset = urlencode($query["skipToken"]);
			}
			$offset_text = "";
			if ($offset != "")
				$offset_text = "&skipToken=".$offset;
			if ($writeplog == 1) {
				$mk_bd = fopen($plog_file,"a") or exit("No file to open!");
				flock($mk_bd,LOCK_EX);
				fwrite($mk_bd,"\n-- Started deletion on ".$offset." offset at ".date("Y-m-d H:i:s")." --");
				flock($mk_bd,LOCK_UN);
				fclose($mk_bd);
			}

			curl_setopt($ch, CURLOPT_URL, "https://".$url.".qualtrics.com/API/v3/distributions?mailingListId=".$ml_id."&surveyId=".$sid.$offset_text.$sendStart_text.$sendEnd_text);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_TIMEOUT, 0);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

			$headers = array();
			$headers[] = "X-Api-Token: ".$token;
			$headers[] = "Content-Type: application/json";
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

			if ($writeqlog == 1) {
				$mk_bd = fopen($qlog_file,"a") or exit("No file to open!");
				flock($mk_bd,LOCK_EX);
				fwrite($mk_bd,"\n-- Qualtrics request https://".$url.".qualtrics.com/API/v3/distributions?mailingListId=".$ml_id."&surveyId=".$sid.$offset_text." was at ".date("d/m/Y H:i")." --");
				flock($mk_bd,LOCK_UN);
				fclose($mk_bd);
			}
			$result = curl_exec($ch);
			if ($writeplog == 1) {
				$mk_bd = fopen($plog_file,"a") or exit("No file to open!");
				flock($mk_bd,LOCK_EX);
				fwrite($mk_bd,"\nResult at ".date("Y-m-d H:i:s").": ".$result);
				flock($mk_bd,LOCK_UN);
				fclose($mk_bd);
			}
			if (curl_errno($ch)) {
				echo "Error: ".curl_error($ch);
			}
			else {
				// list distributions for surveys
				$distributions = json_decode($result, true);
				$nextPage = "";
				if ($distributions["result"]["nextPage"] != "" && $distributions["result"]["nextPage"] != "undefined" && $distributions["result"]["nextPage"] != null)
					{
					$nextPage = $distributions["result"]["nextPage"];
					if ($writeplog == 1) {
						$mk_bd = fopen($plog_file,"a") or exit("No file to open!");
						flock($mk_bd,LOCK_EX);
						fwrite($mk_bd,"\nNext page at ".date("Y-m-d H:i:s")." is ".$nextPage);
						flock($mk_bd,LOCK_UN);
						fclose($mk_bd);
					}
				}
				foreach ($distributions["result"]["elements"] as $distribution)
					{
					// compare maillistID of distribution
					// if ($ml_id == $distribution["recipients"]["mailingListId"])
						// {
						// $filescount++;
						$alldistrs[] = $distribution;
					// }
				}
			}
		}
		foreach ($alldistrs as $distribution)
			{
			curl_setopt($ch, CURLOPT_URL, "https://".$url.".qualtrics.com/API/v3/distributions/".$distribution["id"]);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_TIMEOUT, 0);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");

			// if ($writeqlog == 1) {
				$mk_bd = fopen($qlog_file,"a") or exit("No file to open!");
				flock($mk_bd,LOCK_EX);
				fwrite($mk_bd,"\n-- Qualtrics delete request https://".$url.".qualtrics.com/API/v3/distributions/".$distribution["id"]." was at ".date("d/m/Y H:i")." --");
				flock($mk_bd,LOCK_UN);
				fclose($mk_bd);
			// }
			$result = curl_exec($ch);
			if (curl_errno($ch)) {
				echo "Error: ".curl_error($ch);
			}
			else {
				mysql_query("delete from twilios where distr_id = '".$distribution["id"]."'");
				mysql_query("delete from twilios_sms where distr_id = '".$distribution["id"]."'");
				mysql_query("delete from twilios where is_reminder_for = '".$distribution["id"]."'");
				mysql_query("delete from twilios_sms where is_reminder_for = '".$distribution["id"]."'");
				$func_result["distributions"][$distribution["id"]]["message"] = "deleted successfully";
				if ($writeplog == 1) {
					$mk_bd = fopen($plog_file,"a") or exit("No file to open!");
					flock($mk_bd,LOCK_EX);
					fwrite($mk_bd,"\nDistribution ".$distribution["id"]." deleted successfully at ".date("Y-m-d H:i:s"));
					flock($mk_bd,LOCK_UN);
					fclose($mk_bd);
				}
			}
		}
		echo json_encode($func_result, JSON_UNESCAPED_UNICODE);
		curl_close ($ch);
	}
	elseif ($method == "START" && $action == "twilio")
		{
		$sid = "";
		$token = "";

		$ch = curl_init();
		
		$params = array();
		$params["Body"] = "Hello checking twilio";
		
		
		
		// echo $params;

		curl_setopt($ch, CURLOPT_URL, "https://api.twilio.com/2010-04-01/Accounts/".$sid."/Messages.json");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 0);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");

		$headers = array();
		$headers[] = "Authorization: Basic ".base64_encode("$sid:$token");
		// $headers[] = "Content-Type: application/json";
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		if ($writeqlog == 1) {
			$mk_bd = fopen($qlog_file,"a") or exit("No file to open!");
			flock($mk_bd,LOCK_EX);
			fwrite($mk_bd,"\n-- Qualtrics request https://api.twilio.com/2010-04-01/Accounts/".$sid."/Messages.json was at ".date("d/m/Y H:i")." --");
			flock($mk_bd,LOCK_UN);
			fclose($mk_bd);
		}
		$result = curl_exec($ch);
		if (curl_errno($ch)) {
			echo "Error: ".curl_error($ch);
		}
		else
			echo $result;

		curl_close ($ch);
	}
	elseif ($method == "TEST" && $action == "customer")
		{
		if ($writedlog == 1) {
			$mk_bd = fopen($plog_file,"a") or exit("No file to open!");
			flock($mk_bd,LOCK_EX);
			fwrite($mk_bd,"\n\n--- Started making schedule for new participant at ".date("Y-m-d H:i:s")." ---");
			flock($mk_bd,LOCK_UN);
			fclose($mk_bd);
		}

		$data = explode("&", urldecode($_REQUEST["data"]));
		foreach($data as $val)
			{
			$arr = explode("=", $val);
			$newdata[$arr[0]] = $arr[1];
			$func_result[$arr[0]] = $arr[1];
		}

		if ($writedlog == 1) {
			$mk_bd = fopen($plog_file,"a") or exit("No file to open!");
			flock($mk_bd,LOCK_EX);
			fwrite($mk_bd,"\nParams sent at ".date("Y-m-d H:i:s").": ".json_encode($newdata,  JSON_UNESCAPED_UNICODE));
			flock($mk_bd,LOCK_UN);
			fclose($mk_bd);
		}
		
		$surveyID = $newdata["survey_id"];
		$start_date = $newdata["start_date"];
		$days = $newdata["days"];
		$start_time_all = str_replace("%3A", ":", $newdata["start_time_all"]);
		$start_time[0] = str_replace("%3A", ":", $newdata["start_time_su"]);
		$start_time[1] = str_replace("%3A", ":", $newdata["start_time_mo"]);
		$start_time[2] = str_replace("%3A", ":", $newdata["start_time_tu"]);
		$start_time[3] = str_replace("%3A", ":", $newdata["start_time_we"]);
		$start_time[4] = str_replace("%3A", ":", $newdata["start_time_th"]);
		$start_time[5] = str_replace("%3A", ":", $newdata["start_time_fr"]);
		$start_time[6] = str_replace("%3A", ":", $newdata["start_time_sa"]);
		$end_time_all = str_replace("%3A", ":", $newdata["end_time_all"]);
		$end_time[0] = str_replace("%3A", ":", $newdata["end_time_su"]);
		$end_time[1] = str_replace("%3A", ":", $newdata["end_time_mo"]);
		$end_time[2] = str_replace("%3A", ":", $newdata["end_time_tu"]);
		$end_time[3] = str_replace("%3A", ":", $newdata["end_time_we"]);
		$end_time[4] = str_replace("%3A", ":", $newdata["end_time_th"]);
		$end_time[5] = str_replace("%3A", ":", $newdata["end_time_fr"]);
		$end_time[6] = str_replace("%3A", ":", $newdata["end_time_sa"]);

		$q = mysql_query("select * from roles where SurveyID = '".$surveyID."'") or die(mysql_error());
		if ($arr = mysql_fetch_assoc($q))
			{
			$times = $arr["times"];
			$pause = $arr["pause"];
			$snooze = $arr["snooze"];
			$expire = $arr["expire"];
			$random_interval = (int)urldecode($arr["random_interval"]);
			$send_option = (int)$arr["send_option"];
			$min_time_between = (int)$arr["min_time_between"];
			$max_time_between = (int)$arr["max_time_between"];
		}
		else
			$func_result["messages"]["error"][] = "No data for Survey!";
		
		if ($times > 0)
			{
			$cnt = 0;
			$icnt = 0;
			$start_time_now = "";
			$end_time_now = "";
			// start all distributions!				
			for ($day = 0; $day < $days; $day++)
				{
				if ($random_interval > 0)
					$rand = mt_rand(0, $random_interval);
				else
					$rand = 0;
				$sendingTime = 0;
				// what day of week is it today?
				$dayofweek = date("w", strtotime("+".$day." days", strtotime($start_date)));
				// what is start time for today
				if ($start_time[$dayofweek] != "")
					{
					$start_time_now = $start_time[$dayofweek];
					$end_time_now = $end_time[$dayofweek];
				}
				else
					{
					$start_time_now = $start_time_all;
					$end_time_now = $end_time_all;
				}
				$ch_send_option = 0;
				$timesforday = $times;
				if ($send_option == 3) {
					// calculate time between start and end for today
					$calc_time_between = strtotime($start_date." ".$end_time_now) - strtotime($start_date." ".$start_time_now);
					// calculate optimal pause for today (in minutes)
					$FrameSize = ($calc_time_between/$times)/60;
					if ($FrameSize < $min_time_between)
						{
						$func_result["comment"] .= "We can only show ".ceil($calc_time_between/60/$min_time_between)." times a day of ".$times." for day ".($day + 1)."!<br />";
						$timesforday = $calc_time_between/60/$min_time_between;
						$pause = $min_time_between;
						$ch_send_option = 1;
					}
				}
				$sendingTimeArray = [];
				// start one day distributions
				$func_result["times_a_day"] = $times;
				$func_result["send_option"] = $send_option;
				$func_result["min_time_between"] = $min_time_between;
				$func_result["max_time_between"] = $max_time_between;
				$func_result["calc_time_between"] = $calc_time_between;
				$func_result["calc_optimal_time"] = $FrameSize;
				$func_result["rand"] = $rand;
				$func_result["pause"] = $pause;

				$tcnt = 0;
				$func_result["tries"] = array();
				$sendingTimeArray = array();

				if ($start_time_now != "")
				for ($timesaday = 0; $timesaday < $timesforday; $timesaday++)
					{
					if ($send_option == 1 || $ch_send_option == 1) {
						if ($timesaday > 0)
							$sendingTime = $sendingTime + $pause;
					}
					if ($send_option == 2) {
						$pause = mt_rand($min_time_between, $max_time_between);
						if ($timesaday > 0)
							$sendingTime = $sendingTime + $pause;
					}
					if ($send_option == 3 && $ch_send_option != 1) {
						$rand = 0;
						// my old way
						// $pause = mt_rand($min_time_between, $max_time_between);
						// if ($FrameSize < $min_time_between)
							// $pause = $min_time_between;
						// if ($FrameSize > $max_time_between)
							// $pause = $max_time_between;

						// Yadid new way
						$frameStart = $timesaday * $FrameSize;
						if ($timesaday > 0)
							{
							$prevSendingTime = $sendingTimeArray[$timesaday - 1];
							$diffTimeFromPrevSending = $frameStart - $prevSendingTime;
							// res vvv
							$func_result["tries"][$tcnt]["diffTimeFromPrevSending_start"] = $diffTimeFromPrevSending;
							// res ^^^
							if ($diffTimeFromPrevSending < $min_time_between)
								$frameStart = $frameStart + ($min_time_between - $diffTimeFromPrevSending);
						}
						// res vvv
						$func_result["tries"][$tcnt]["frame_start"] = $frameStart;
						// res ^^^
						$frameEnd = $timesaday * $FrameSize + $FrameSize;
						if ($timesaday > 0)
							{
							$prevSendingTime = $sendingTimeArray[$timesaday - 1];
							$diffTimeFromPrevSending = $frameEnd - $prevSendingTime;
							// res vvv
							$func_result["tries"][$tcnt]["diffTimeFromPrevSending_end"] = $diffTimeFromPrevSending;
							// res ^^^
							if ($diffTimeFromPrevSending > $max_time_between)
								$frameEnd = $frameEnd - ($diffTimeFromPrevSending - $max_time_between);
						}
						// res vvv
						$func_result["tries"][$tcnt]["prevSendingTime"] = $prevSendingTime;
						$func_result["tries"][$tcnt]["frame_end"] = $frameEnd;
						// res ^^^
						if ($frameEnd < $frameStart)
							$frameStart = $frameEnd;
						$sendingTime = mt_rand($frameStart, $frameEnd);
					}
					$sendingTimeArray[$timesaday] = $sendingTime;
					// my old way too
					// if ($timesaday > 0)
						// $sendingTime = $sendingTime + $pause;
					$rand_snooze = $snooze + $rand;
					$gap = 5;
					if ($day > 0) {
						$send_time = make_etime(strtotime("+".$day." days ".($sendingTime + $rand)." minutes", strtotime($start_date." ".$start_time_now)));
						$expiration_date = make_etime(strtotime("+".$day." days ".($sendingTime + $rand + $expire)." minutes", strtotime($start_date." ".$start_time_now)));
						$reminder_send_time = make_etime(strtotime("+".$day." days ".($sendingTime + $rand_snooze)." minutes", strtotime($start_date." ".$start_time_now)));
					}
					else {
						$send_time = make_etime(strtotime("+".($sendingTime + $rand)." minutes", strtotime($start_date." ".$start_time_now)));
						$expiration_date = make_etime(strtotime("+".($sendingTime + $rand + $expire)." minutes", strtotime($start_date." ".$start_time_now)));
						$reminder_send_time = make_etime(strtotime("+".($sendingTime + $rand_snooze)." minutes", strtotime($start_date." ".$start_time_now)));
					}
					$func_result["tries"][$tcnt]["compare1"] = $send_time;
					$func_result["tries"][$tcnt]["compare2"] = make_etime(time());
					$func_result["tries"][$tcnt]["compare3"] = $send_time;
					$func_result["tries"][$tcnt]["compare4"] = make_etime(time());
					$tcnt++;
					if ($send_time > make_etime(time()))
						{
						$func_result["distributions"][$cnt]["sendingTime"] = $sendingTime;
						$func_result["distributions"][$cnt]["send_time"] = $send_time;
						$func_result["distributions"][$cnt]["expiration_time"] = $expiration_date;
						$func_result["distributions"][$cnt]["reminder_send_time"] = $reminder_send_time;
						$cnt++;
					}
					else {
						$func_result["comment"] = "Some times were ignored!";
						$func_result["ignored"][$icnt]["sendingTime"] = $sendingTime;
						$func_result["ignored"][$icnt]["send_time"] = $send_time;
						$icnt++;
					}
				}
			}
		}
		else
			$func_result["messages"]["error"][] = "No times set for Survey!";

		if ($writedlog == 1) {
			$mk_bd = fopen($plog_file,"a") or exit("No file to open!");
			flock($mk_bd,LOCK_EX);
			fwrite($mk_bd,"\n\n--- Ended making schedule for new participant at ".date("Y-m-d H:i:s")." ---");
			flock($mk_bd,LOCK_UN);
			fclose($mk_bd);
		}

		echo json_encode($func_result, JSON_UNESCAPED_UNICODE);
	}
	elseif ($method == "ADD" && $action == "bulk")
		{
		if ($writedlog == 1) {
			$mk_bd = fopen($plog_file,"a") or exit("No file to open!");
			flock($mk_bd,LOCK_EX);
			fwrite($mk_bd,"\n\n--- Started adding new bulk at ".date("Y-m-d H:i:s")." ---");
			flock($mk_bd,LOCK_UN);
			fclose($mk_bd);
		}

		$data = explode("&", urldecode($_REQUEST["bulk"]));
		foreach($data as $val)
			{
			$arr = explode("=", $val);
			$newdata[$arr[0]] = $arr[1];
		}
		$mk_bd = fopen($plog_file,"a") or exit("No file to open!");
		flock($mk_bd,LOCK_EX);
		fwrite($mk_bd,"\n\n--- Raw data sent: ".json_encode($newdata, JSON_UNESCAPED_UNICODE)." ---");
		flock($mk_bd,LOCK_UN);
		fclose($mk_bd);

		$bulk = $_REQUEST["bulk"];
		// print_r($data);
		$sid = $newdata["survey_id"];

		mysql_query("insert into bulks (surveyId, bulk, date_add) values ('".$sid."', '".$bulk."', NOW())") or die(mysql_error());

		// $func_result["bulks"] = $bulk;

		echo "{\"result\":\"OK\"}";
	}
	elseif ($method == "ADD" && $action == "customer")
		{
		if ($writeclog == 1) {
			$mk_bd = fopen($clog_file,"a") or exit("No file to open!");
			flock($mk_bd,LOCK_EX);
			$timestampstart = time();
			fwrite($mk_bd,"--- Started adding new participant at ".date("Y-m-d H:i:s")." ---\n");
			flock($mk_bd,LOCK_UN);
			fclose($mk_bd);
		}

		// adding customer (maillist first)
		$ch = curl_init();

		$data = explode("&", urldecode($_REQUEST["data"]));
		foreach($data as $val)
			{
			$arr = explode("=", $val);
			$newdata[$arr[0]] = $arr[1];
		}
		// if ($writeclog == 1) {
			// $mk_bd = fopen($clog_file,"a") or exit("No file to open!");
			// flock($mk_bd,LOCK_EX);
			// fwrite($mk_bd,"\n\n--- Raw data sent: ".json_encode($newdata, JSON_UNESCAPED_UNICODE)." ---");
			// flock($mk_bd,LOCK_UN);
			// fclose($mk_bd);
		// }

		$surveyID = $newdata["survey_id"];
		$name = $newdata["name"];
		$lastname = $newdata["lastname"];
		$email = $newdata["email"];
		$phone = $newdata["phone"];
		$lid = $newdata["lid"];
		$dontsendr = $newdata["dontsendr"]?1:0;
		$dontsendsms = $newdata["dontsendsms"]?1:0;
		$dontsendwa = $newdata["dontsendwa"]?1:0;
		$contact_id = $newdata["contact_id"];
		$Dyad_ID = $newdata["Dyad_ID"];
		$start_date = $newdata["start_date"];
		$days = $newdata["days"];
		$start_time_all = str_replace("%3A", ":", $newdata["start_time_all"]);
		$start_time_su = str_replace("%3A", ":", $newdata["start_time_su"]);
		$start_time_mo = str_replace("%3A", ":", $newdata["start_time_mo"]);
		$start_time_tu = str_replace("%3A", ":", $newdata["start_time_tu"]);
		$start_time_we = str_replace("%3A", ":", $newdata["start_time_we"]);
		$start_time_th = str_replace("%3A", ":", $newdata["start_time_th"]);
		$start_time_fr = str_replace("%3A", ":", $newdata["start_time_fr"]);
		$start_time_sa = str_replace("%3A", ":", $newdata["start_time_sa"]);
		$end_time_all = str_replace("%3A", ":", $newdata["end_time_all"]);
		$end_time_su = str_replace("%3A", ":", $newdata["end_time_su"]);
		$end_time_mo = str_replace("%3A", ":", $newdata["end_time_mo"]);
		$end_time_tu = str_replace("%3A", ":", $newdata["end_time_tu"]);
		$end_time_we = str_replace("%3A", ":", $newdata["end_time_we"]);
		$end_time_th = str_replace("%3A", ":", $newdata["end_time_th"]);
		$end_time_fr = str_replace("%3A", ":", $newdata["end_time_fr"]);
		$end_time_sa = str_replace("%3A", ":", $newdata["end_time_sa"]);
		$messageID = $newdata["mid"];
		$reminder_messageID = $newdata["rmid"];
		$wamid = $newdata["wamid"];
		$warmid = $newdata["warmid"];
		$smsid = $newdata["smsid"];
		$smsrid = $newdata["smsrid"];
		$wa_message = $allwams[$wamid];
		$wa_rmessage = $allwams[$warmid];
		$sms_message = $allwams[$smsid];
		$sms_rmessage = $allwams[$smsrid];

		$params = '{';
		$params .= '"category":"All Customers",';
		$params .= '"name":"'.$name.' '.$lastname.'",';
		$params .= '"libraryId":"'.$lid.'"';
		$params .= '}';
		
		// echo $params;
		curl_setopt($ch, CURLOPT_URL, "https://".$url.".qualtrics.com/API/v3/mailinglists");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 0);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");

		$headers = array();
		$headers[] = "X-Api-Token: ".$token;
		$headers[] = "Content-Type: application/json";
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$mk_bd = fopen($clog_file,"a") or exit("No file to open!");
		flock($mk_bd,LOCK_EX);
		fwrite($mk_bd,"-- Qualtrics request https://".$url.".qualtrics.com/API/v3/mailinglists was at ".date("d/m/Y H:i")." --\n");
		flock($mk_bd,LOCK_UN);
		fclose($mk_bd);
		$result = curl_exec($ch);
		if (curl_errno($ch)) {
			$func_result["mailinglists"]["error"][] = curl_error($ch);
			if ($writeclog == 1) {
				$mk_bd = fopen($clog_file,"a") or exit("No file to open!");
				flock($mk_bd,LOCK_EX);
				fwrite($mk_bd,"Error ML add at ".date("Y-m-d H:i:s").": ".curl_error($ch)."\n");
				flock($mk_bd,LOCK_UN);
				fclose($mk_bd);
			}
		}
		else
			{
			$json = json_decode($result, true);
			if ($writeclog == 1) {
				$mk_bd = fopen($clog_file,"a") or exit("No file to open!");
				flock($mk_bd,LOCK_EX);
				fwrite($mk_bd,"ML ".$lid." added at ".date("Y-m-d H:i:s").", it took ".(time() - $timestampstart)." seconds\n");
				flock($mk_bd,LOCK_UN);
				fclose($mk_bd);
			}

			$func_result["mailinglists"][$json["result"]["id"]]["name"] = $name." ".$lastname;
			$func_result["mailinglists"][$json["result"]["id"]]["libraryID"] = $lid;
			
			// print_r($params);
			// print "\n----------------------\n";
			// print_r($json);
			
			$ml_id = $json["result"]["id"];
			
			if ($ml_id != "")
				{
				$params = '{';
				$params .= '"firstName":"'.$name.'",';
				$params .= '"lastName":"'.$lastname.'",';
				$params .= '"email":"'.str_replace("%40", "@", $email).'",';
				$params .= '"embeddedData":{';
				$params .= '"surveyID":"'.$surveyID.'",';
				$params .= '"phone":"'.$phone.'",';
				$params .= '"start_date":"'.$start_date.'",';
				$params .= '"dontsendsms":"'.$dontsendsms.'",';
				$params .= '"dontsendwa":"'.$dontsendwa.'",';
				$params .= '"dontsendr":"'.$dontsendr.'",';
				$params .= '"days":"'.$days.'",';
				$params .= '"created":"'.date("Y-m-d H:i:s").'",';
				$params .= '"mid":"'.$messageID.'",';
				$params .= '"rmid":"'.$reminder_messageID.'",';
				$params .= '"wamid":"'.$wamid.'",';
				$params .= '"warmid":"'.$warmid.'",';
				$params .= '"smsid":"'.$smsid.'",';
				$params .= '"smsrid":"'.$smsrid.'",';
				$params .= '"start_time_all":"'.$start_time_all.'",';
				$params .= '"start_time_su":"'.$start_time_su.'",';
				$params .= '"start_time_mo":"'.$start_time_mo.'",';
				$params .= '"start_time_tu":"'.$start_time_tu.'",';
				$params .= '"start_time_we":"'.$start_time_we.'",';
				$params .= '"start_time_th":"'.$start_time_th.'",';
				$params .= '"start_time_fr":"'.$start_time_fr.'",';
				$params .= '"start_time_sa":"'.$start_time_sa.'",';
				$params .= '"end_time_all":"'.$end_time_all.'",';
				$params .= '"end_time_su":"'.$end_time_su.'",';
				$params .= '"end_time_mo":"'.$end_time_mo.'",';
				$params .= '"end_time_tu":"'.$end_time_tu.'",';
				$params .= '"end_time_we":"'.$end_time_we.'",';
				$params .= '"end_time_th":"'.$end_time_th.'",';
				$params .= '"end_time_fr":"'.$end_time_fr.'",';
				$params .= '"end_time_sa":"'.$end_time_sa.'",';
				if ($Dyad_ID != "")
					$params .= '"Dyad_ID":"'.$Dyad_ID.'",';
				$params .= '"contact_id":"'.$contact_id.'"';
				$params .= '}';
				$params .= '}';

				// print "\n-----------2-----------\n";
				// print_r($params);

				curl_setopt($ch, CURLOPT_URL, "https://".$url.".qualtrics.com/API/v3/mailinglists/".$ml_id."/contacts");
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_TIMEOUT, 0);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");

				$headers = array();
				$headers[] = "X-Api-Token: ".$token;
				$headers[] = "Content-Type: application/json; charset=utf-8";
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

				$mk_bd = fopen($clog_file,"a") or exit("No file to open!");
				flock($mk_bd,LOCK_EX);
				fwrite($mk_bd,"-- Qualtrics request https://".$url.".qualtrics.com/API/v3/mailinglists/".$ml_id."/contacts was at ".date("d/m/Y H:i:s")." --\n");
				flock($mk_bd,LOCK_UN);
				fclose($mk_bd);
				$result = curl_exec($ch);
				if (curl_errno($ch)) {
					$func_result["contacts"]["error"][] = curl_error($ch);
					if ($writeclog == 1) {
						$mk_bd = fopen($clog_file,"a") or exit("No file to open!");
						flock($mk_bd,LOCK_EX);
						fwrite($mk_bd,"Error contact add at ".date("Y-m-d H:i:s").": ".curl_error($ch)."\n");
						flock($mk_bd,LOCK_UN);
						fclose($mk_bd);
					}
				}
				else {
					$json = json_decode($result, true);

					$customer_id = $json["result"]["id"];

					if ($writeclog == 1) {
						$mk_bd = fopen($clog_file,"a") or exit("No file to open!");
						flock($mk_bd,LOCK_EX);
					}
					if ($customer_id != "")
						{
						if ($writeclog == 1) {
							fwrite($mk_bd,"Contact ".$customer_id." added at ".date("Y-m-d H:i:s")."\n");
							fwrite($mk_bd,"insert into participants (s_id, ml_id, c_id, p_number, Dyad_ID, dsms, dwa, dr,
							fname, lname, phone, email, lid, mid, rmid,
							start_date, num_days, start_time_all, start_time_su, start_time_mo, start_time_tu, start_time_we, start_time_th, start_time_fr, start_time_sa, created)
							values ('".$surveyID."', '".$ml_id."', '".$customer_id."', '".$contact_id."', '".$Dyad_ID."', '".$dontsendsms."',  '".$dontsendwa."',  '".$dontsendr."', 
							'".mysql_real_escape_string($name)."', '".mysql_real_escape_string($lastname)."', '".$phone."', '".$email."', '".$lid."', '".$messageID."', '".$reminder_messageID."',
							'".$start_date."', '".$days."', '".$start_time_all."', '".$start_time_su."', '".$start_time_mo."', '".$start_time_tu."', '".$start_time_we."', '".$start_time_th."', '".$start_time_fr."', '".$start_time_sa."', NOW())"."\n");
						}
						mysql_query("insert into participants (s_id, ml_id, c_id, p_number, Dyad_ID, dsms, dwa, dr,
						fname, lname, phone, email, lid, mid, rmid,
						start_date, num_days, start_time_all, start_time_su, start_time_mo, start_time_tu, start_time_we, start_time_th, start_time_fr, start_time_sa, created)
						values ('".$surveyID."', '".$ml_id."', '".$customer_id."', '".$contact_id."', '".$Dyad_ID."', '".$dontsendsms."',  '".$dontsendwa."',  '".$dontsendr."', 
						'".mysql_real_escape_string($name)."', '".mysql_real_escape_string($lastname)."', '".$phone."', '".$email."', '".$lid."', '".$messageID."', '".$reminder_messageID."',
						'".$start_date."', '".$days."', '".$start_time_all."', '".$start_time_su."', '".$start_time_mo."', '".$start_time_tu."', '".$start_time_we."', '".$start_time_th."', '".$start_time_fr."', '".$start_time_sa."', NOW())");
					}
					else
					{
						if ($writeclog == 1) {
							fwrite($mk_bd,"Contact ".$name." ".$lastname." for ".$ml_id." could not be added: ".$result."\n");
						}
					}
					if ($writeclog == 1) {
						flock($mk_bd,LOCK_UN);
						fclose($mk_bd);
					}

					$func_result["contacts"][$json["result"]["id"]]["name"] = $name." ".$lastname;
					$func_result["contacts"][$json["result"]["id"]]["email"] = str_replace("%40", "@", $email);
					$func_result["contacts"][$json["result"]["id"]]["phone"] = $phone;
					$func_result["contacts"][$json["result"]["id"]]["mailingListID"] = $ml_id;

					// get messageID from libraryID
					/*
					curl_setopt($ch, CURLOPT_URL, "https://".$url.".qualtrics.com/API/v3/libraries/".$lid."/messages");
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

					$headers = array();
					$headers[] = "X-Api-Token: ".$token;
					$headers[] = "Content-Type: application/json";
					curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

					$result = curl_exec($ch);
					if (curl_errno($ch)) {
						$func_result["messages"]["error"][] = curl_error($ch);
					}
					else {
						$json = json_decode($result, true);

						foreach ($json["result"]["elements"] as $message)
							{
							if ($message["category"] == "reminder")
								{
								$reminder_messageID = $message["id"];
								*/
					curl_close ($ch);
					$ch = curl_init();
					// get message for Twilio
					curl_setopt($ch, CURLOPT_URL, "https://".$url.".qualtrics.com/API/v3/libraries/".$lid."/messages/".$messageID);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch, CURLOPT_TIMEOUT, 0);
					curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

					$headers = array();
					$headers[] = "X-Api-Token: ".$token;
					$headers[] = "Content-Type: application/json";
					curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

					$mk_bd = fopen($qlog_file,"a") or exit("No file to open!");
					flock($mk_bd,LOCK_EX);
					fwrite($mk_bd,"-- Qualtrics request https://".$url.".qualtrics.com/API/v3/libraries/".$lid."/messages/".$messageID." was at ".date("d/m/Y H:i:s")." --\n");
					flock($mk_bd,LOCK_UN);
					fclose($mk_bd);
					$result1 = curl_exec($ch);
					if (curl_errno($ch)) {
						$func_result["message"]["error"][] = curl_error($ch);
						if ($writeclog == 1) {
							$mk_bd = fopen($clog_file,"a") or exit("No file to open!");
							flock($mk_bd,LOCK_EX);
							fwrite($mk_bd,"Error message get at ".date("Y-m-d H:i:s").": ".curl_error($ch)."\n");
							flock($mk_bd,LOCK_UN);
							fclose($mk_bd);
						}
					}
					else {
						$mjson1 = json_decode($result1, true);
						@$msg = urldecode($mjson1["result"]["messages"][$lang]);
						if ($msg == "")
							$msg = urldecode($mjson1["result"]["messages"]["en"]);
						if ($writeclog == 1) {
							$mk_bd = fopen($clog_file,"a") or exit("No file to open!");
							flock($mk_bd,LOCK_EX);
							fwrite($mk_bd,"Message got from Qualtrics libraries at ".date("Y-m-d H:i:s").": ".substr($msg, 0, 6)."..., it took ".(time() - $timestampstart)." seconds\n");
							flock($mk_bd,LOCK_UN);
							fclose($mk_bd);
						}
					}

					curl_close ($ch);
					$ch = curl_init();

					// get reminder message for Twilio
					curl_setopt($ch, CURLOPT_URL, "https://".$url.".qualtrics.com/API/v3/libraries/".$lid."/messages/".$reminder_messageID);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch, CURLOPT_TIMEOUT, 0);
					curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

					$headers = array();
					$headers[] = "X-Api-Token: ".$token;
					$headers[] = "Content-Type: application/json";
					curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

					$mk_bd = fopen($qlog_file,"a") or exit("No file to open!");
					flock($mk_bd,LOCK_EX);
					fwrite($mk_bd,"-- Qualtrics request https://".$url.".qualtrics.com/API/v3/libraries/".$lid."/messages/".$reminder_messageID." was at ".date("d/m/Y H:i")." --\n");
					flock($mk_bd,LOCK_UN);
					fclose($mk_bd);
					$result = curl_exec($ch);
					if (curl_errno($ch)) {
						$func_result["reminder_message"]["error"][] = curl_error($ch);
						if ($writeclog == 1) {
							$mk_bd = fopen($clog_file,"a") or exit("No file to open!");
							flock($mk_bd,LOCK_EX);
							fwrite($mk_bd,"Error reminder message get at ".date("Y-m-d H:i:s").": ".curl_error($ch)."\n");
							flock($mk_bd,LOCK_UN);
							fclose($mk_bd);
						}
					}
					else {
						$mjson = json_decode($result, true);
						$rmsg = urldecode($mjson["result"]["messages"][$lang]);
						if ($writeclog == 1) {
							$mk_bd = fopen($clog_file,"a") or exit("No file to open!");
							flock($mk_bd,LOCK_EX);
							fwrite($mk_bd,"Reminder message got from Qualtrics at ".date("Y-m-d H:i:s").": ".substr($rmsg, 0, 5)."..., it took ".(time() - $timestampstart)." seconds\n");
							flock($mk_bd,LOCK_UN);
							fclose($mk_bd);
						}
					}
						/*
						}
						else
							{
							$messageID = $message["id"];
							*/
							// get message for Twilio
						// }
					// }
					
					$func_result["messages"]["message_result"] = $result1;
					$func_result["messages"]["reminder_message_result"] = $result;
					$func_result["messages"]["messageID"] = $messageID;
					$func_result["messages"]["message"] = $msg;
					$func_result["messages"]["reminder_messageID"] = $reminder_messageID;
					$func_result["messages"]["reminder_message"] = $rmsg;
					
					// get and organise all the dates
					$q = mysql_query("select * from roles where SurveyID = '".$surveyID."'") or die(mysql_error());
					if ($arr = mysql_fetch_assoc($q))
						{
						$times = $arr["times"];
						$pause = $arr["pause"];
						$snooze = $arr["snooze"];
						$expire = $arr["expire"];
						$email_subj = urldecode($arr["email_subj"]);
						$from_name = urldecode($arr["from_name"]);
						if ($from_name == "" || $from_name == "undefined")
							$from_name = "Surveys manager";
						$random_interval = (int)urldecode($arr["random_interval"]);
						$reply_to = urldecode($arr["reply_to"]);
						$phonicID = $arr["phonicID"];
						$phonic_questionID = $arr["phonic_questionID"];
						$physioqID = $arr["physioqID"];
						$send_option = (int)$arr["send_option"];
						$min_time_between = (int)$arr["min_time_between"];
						$max_time_between = (int)$arr["max_time_between"];

						$distrs_count = $newdata["distrs_count"];

						$func_result["survey_id"] = $surveyID;
						$func_result["roles"] = $arr;
						$func_result["distrs_count"] = $distrs_count;
						
						if ($writeclog == 1) {
							$mk_bd = fopen($clog_file,"a") or exit("Cannot open file!");
							flock($mk_bd,LOCK_EX);
							fwrite($mk_bd,"--Starting ".$distrs_count." distributions at ".date("Y-m-d H:i:s")."\n");
							flock($mk_bd,LOCK_UN);
							fclose($mk_bd);
						}
						for ($i = 0; $i < $distrs_count; $i++)
							{
							$send_time = make_time($newdata["send_time".$i]);
							$local_send_time = $newdata["send_time".$i];
							$reminder_send_time = make_time($newdata["reminder_send_time".$i]);
							$local_reminder_send_time = $newdata["reminder_send_time".$i];
							$expiration_date = make_time($newdata["expiration_time".$i]);
							$local_expiration_date = $newdata["expiration_time".$i];
							
							if ($newdata["send_time".$i] != "" && $newdata["reminder_send_time".$i] != "" && $newdata["expiration_time".$i] != "")
								{									
								// $distr_name = $email_subj." שנשלח ב ".$local_send_time;
								$distr_name = $email_subj." שנשלח ב ".$send_time;
								// $reminder_name = "תזכורת. ".$email_subj." שנשלח ב ".$local_send_time;
								$reminder_name = "תזכורת. ".$email_subj." שנשלח ב ".$send_time;
								
								$params = '{';
								$params .= '"surveyLink": {"surveyId":"'.$surveyID.'","expirationDate":"'.$expiration_date.'"},';
								$params .= '"header": { "fromEmail": "noreply@qemailserver.com", "fromName": "'.$from_name.'", "subject": "'.$distr_name.'", "replyToEmail" : "'.$reply_to.'" },';
								$params .= '"message": { "libraryId":"'.$lid.'","messageId":"'.$messageID.'"},';
								$params .= '"recipients": { "mailingListId": "'.$ml_id.'"},';
								$params .= '"sendDate":"'.$send_time.'"}';
								
								if ($writeclog == 1) {
									$mk_bd = fopen($clog_file,"a") or exit("No file to open!");
									flock($mk_bd,LOCK_EX);
									fwrite($mk_bd,"Distribution create url https://".$url.".qualtrics.com/API/v3/distributions sent at ".date("Y-m-d H:i:s")." with params: ".$params."\n");
									flock($mk_bd,LOCK_UN);
									fclose($mk_bd);
								}
								// echo $params;

								curl_setopt($ch, CURLOPT_URL, "https://".$url.".qualtrics.com/API/v3/distributions");
								curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
								curl_setopt($ch, CURLOPT_TIMEOUT, 0);
								curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
								curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");

								$headers = array();
								$headers[] = "X-Api-Token: ".$token;
								$headers[] = "Content-Type: application/json";
								curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

								$result = curl_exec($ch);
								if (curl_errno($ch)) {
									$func_result["distributions"]["error"][] = curl_error($ch);
									if ($writeclog == 1) {
										$mk_bd = fopen($clog_file,"a") or exit("No file to open!");
										flock($mk_bd,LOCK_EX);
										fwrite($mk_bd,"Error distribution set at ".date("Y-m-d H:i:s").": ".curl_error($ch)."\n");
										flock($mk_bd,LOCK_UN);
										fclose($mk_bd);
									}
								}
								else {
									$json = json_decode($result, true);
									$distr_id = $json["result"]["id"];

									// make file for cron to send twilio messages
									if ($distr_id != "")
										{
										if ($writeclog == 1) {
											$mk_bd = fopen($clog_file,"a") or exit("No file to open!");
											flock($mk_bd,LOCK_EX);
											fwrite($mk_bd,"Distribution set at ".date("Y-m-d H:i:s").": ".$result."\n");
											flock($mk_bd,LOCK_UN);
											fclose($mk_bd);
										}
										$func_result["distributions"][$distr_id]["name"] = $distr_name;
										$func_result["distributions"][$distr_id]["send_time"] = $send_time;
										
										/*
										$link = "";
										// get distribution link
										curl_setopt($ch, CURLOPT_URL, "https://".$url.".qualtrics.com/API/v3/distributions/".$distr_id."/links?surveyId=".$surveyID);
										curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
										curl_setopt($ch, CURLOPT_TIMEOUT, 0);
										curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

										$headers = array();
										$headers[] = "X-Api-Token: ".$token;
										$headers[] = "Content-Type: application/json";
										curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

										if ($writetwlog == 1) {
											$mk_bd = fopen($twlog_file,"a") or exit("No file to open!");
											flock($mk_bd,LOCK_EX);
											fwrite($mk_bd,"\n-- Qualtrics link request https://".$url.".qualtrics.com/API/v3/distributions/".$distr_id."/links?surveyId=".$surveyID." was at ".date("d/m/Y H:i")." --");
											flock($mk_bd,LOCK_UN);
											fclose($mk_bd);
										}
										$result = curl_exec($ch);
										if ($writetwlog == 1) {
											$mk_bd = fopen($twlog_file,"a") or exit("No file to open!");
											flock($mk_bd,LOCK_EX);
											fwrite($mk_bd,"\nLink got from Qualtrics at ".date("Y-m-d H:i:s").": ".$result);
											flock($mk_bd,LOCK_UN);
											fclose($mk_bd);
										}
										if (!curl_errno($ch))
											{
											$json = json_decode($result, true);
											$link = $json["result"]["elements"][0]["link"];
											$tulink = file_get_contents($tinyurl.'?url='.urlencode($link));
											if ($tulink == "")
												{
												$tulink = $link;
												if ($writetwlog == 1) {
													$mk_bd = fopen($twlog_file,"a") or exit("No file to open!");
													flock($mk_bd,LOCK_EX);
													fwrite($mk_bd,"\nShort link got at ".date("Y-m-d H:i:s").": ".$tinyurl."?url=".$link."! TU:".$tulink);
													fwrite($mk_bd,"\nDontsendwa =  ".$dontsendwa." (".(!$dontsendwa || $dontsendwa != 1).")");
													fwrite($mk_bd,"\nDontsendsms =  ".$dontsendsms." (".(!$dontsendsms || $dontsendsms != 1).")");
													flock($mk_bd,LOCK_UN);
													fclose($mk_bd);
												}
											}
										}
										else
											{
											if ($writetwlog == 1) {
												$mk_bd = fopen($twlog_file,"a") or exit("No file to open!");
												flock($mk_bd,LOCK_EX);
												fwrite($mk_bd,"\nError link get at ".date("Y-m-d H:i:s")." (".$tinyurl."?url=".$link."): ".curl_error($ch));
												flock($mk_bd,LOCK_UN);
												fclose($mk_bd);
											}
										}
										*/
										if (!$dontsendsms || $dontsendsms != 1)
											{
											// set SMS message
											if ($writetwlog == 1) {
												$mk_bd = fopen($twlog_file,"a") or exit("No file to open!");
												flock($mk_bd,LOCK_EX);
												fwrite($mk_bd,"\nStarting new twilio SMS at ".date("Y-m-d H:i:s").": ".curl_error($ch));
												flock($mk_bd,LOCK_UN);
												fclose($mk_bd);
											}

											$twdata = array();

											$twdata["distr_name"] = $distr_name;
											$twdata["send_time"] = str_replace("T", " ", str_replace("Z", "", $send_time));
											// $timeonly = substr($local_send_time, 11, 5);
											$timeonly = substr($send_time, 11, 5);
											$expiration_timeonly = substr($local_expiration_date, 11, 5);
											
											$twdata["state"] = 0; // не отправлено
											$twdata["surveyID"] = $surveyID;
											$twdata["message"] = str_replace("{{1}}", $name, str_replace("{{3}}", $timeonly, str_replace("{{4}}", $expiration_timeonly, $sms_message)));
											// if ($tulink != "") {
												// $twdata["message"] = preg_replace($pattern, "", str_replace("\${m://FirstName}", $name, str_replace("\${m://LastName}", $lastname, str_replace("\${e://Field/contact_id}", $customer_id, str_replace("\${l://SurveyLink?d=Take the Survey}", "Take the Survey here: ".$link, str_replace("\${l://SurveyURL}", $link, $msg))))));
												// $twdata["message"] = str_replace("{{1}}", $name, str_replace("{{2}}", $tulink, str_replace("{{3}}", $timeonly, str_replace("{{4}}", $expiration_timeonly, $sms_message))));
											// }
											// else
												// $twdata["message"] = $sms_message." (no link found)";
											$twdata["distr_id"] = $distr_id;
											$twdata["customer_id"] = $customer_id;
											$twdata["snooze"] = $snooze;
											$twdata["name"] = $name." ".$lastname;
											$twdata["phone"] = str_replace("(", "", str_replace(")", "", str_replace(" ", "", str_replace("-", "", $phone))));
											
											// $alldata["result"]["elements"][$distr_id] = $twdata;
											
											mysql_query("insert into twilios_sms (user_id, twilio_surveyID, is_reminder_for, send_time, state, message, distr_id, customer_id, snooze, name, phone)
											values ('".$user_id_tw."', '".$surveyID."', '', '".make_jtime($twdata["send_time"])."', 'init', '".mysql_real_escape_string($twdata["message"])."', '".$distr_id."', '".$customer_id."', '".$snooze."', '".mysql_real_escape_string($twdata["name"])."', '".$twdata["phone"]."')");

											if ($writetwlog == 1) {
												$mk_bd = fopen($twlog_file,"a") or exit("No file to open!");
												flock($mk_bd,LOCK_EX);
												fwrite($mk_bd, "\n--new SMS twilio for ".$distr_id." was added with Jerusalem Time ".make_jtime($twdata["send_time"])."--");
												flock($mk_bd,LOCK_UN);
												fclose($mk_bd);
											}
											
											if (!$dontsendr || $dontsendr != 1)
												{
												// set SMS reminder
												$twdata = array();

												$twdata["distr_name"] = $reminder_name;
												$twdata["send_time"] = str_replace("T", " ", str_replace("Z", "", $reminder_send_time));
												// $timeonly = substr($local_send_time, 11, 5);
												$timeonly = substr($send_time, 11, 5);
												$expiration_timeonly = substr($local_expiration_date, 11, 5);

												$twdata["state"] = 'init'; // не отправлено
												$twdata["surveyID"] = $surveyID;
												$twdata["message"] = str_replace("{{1}}", $name, str_replace("{{3}}", $timeonly, str_replace("{{4}}", $expiration_timeonly, $sms_rmessage)));
												// if ($tulink != "") {
													// $twdata["message"] = preg_replace($pattern, "", str_replace("\${m://FirstName}", $name, str_replace("\${m://LastName}", $lastname, str_replace("\${e://Field/contact_id}", $customer_id, str_replace("\${l://SurveyLink?d=Take the Survey}", "Take the Survey here: ".$link, str_replace("\${l://SurveyURL}", $link, $rmsg))))));
													// $twdata["message"] = str_replace("{{1}}", $name, str_replace("{{2}}", $tulink, str_replace("{{3}}", $timeonly, str_replace("{{4}}", $expiration_timeonly, $sms_rmessage))));
												// }
												// else
													// $twdata["message"] = $sms_rmessage." (no link found)";
												$twdata["distr_id"] = $reminder_id;
												$twdata["customer_id"] = $customer_id;
												$twdata["snooze"] = $snooze;
												$twdata["is_reminder_for"] = $distr_id;
												$twdata["name"] = $name." ".$lastname;
												$twdata["phone"] = str_replace("(", "", str_replace(")", "", str_replace(" ", "", str_replace("-", "", $phone))));

												// $alldata["result"]["elements"][$reminder_id] = $twdata;

												mysql_query("insert into twilios_sms (user_id, twilio_surveyID, is_reminder_for, send_time, state, message, distr_id, customer_id, snooze, name, phone)
												values ('".$user_id_tw."', '".$surveyID."', '".$distr_id."', '".make_jtime($twdata["send_time"])."', 'init', '".mysql_real_escape_string($twdata["message"])."', '".$reminder_id."', '".$customer_id."', '".$snooze."', '".mysql_real_escape_string($twdata["name"])."', '".$twdata["phone"]."')");

												if ($writetwlog == 1) {
													$mk_bd = fopen($twlog_file,"a") or exit("No file to open!");
													flock($mk_bd,LOCK_EX);
													fwrite($mk_bd, "\n--new reminder SMS item for ".$distr_id." was added with Jerusalem Time ".make_jtime($twdata["send_time"])."--");
													flock($mk_bd,LOCK_UN);
													fclose($mk_bd);
												}
											}
										}

										$func_result["twilio_sms"] = $alldata;

										if (!$dontsendwa || $dontsendwa != 1)
											{
											// set WhatsApp message
											if ($writetwlog == 1) {
												$mk_bd = fopen($twlog_file,"a") or exit("No file to open!");
												flock($mk_bd,LOCK_EX);
												fwrite($mk_bd,"\nStarting new twilio WA at ".date("Y-m-d H:i:s").": ".curl_error($ch));
												flock($mk_bd,LOCK_UN);
												fclose($mk_bd);
											}

											$twdata = array();

											$twdata["distr_name"] = $distr_name;
											$twdata["send_time"] = str_replace("T", " ", str_replace("Z", "", $send_time));
											// $timeonly = substr($local_send_time, 11, 5);
											$timeonly = substr($send_time, 11, 5);
											$expiration_timeonly = substr($local_expiration_date, 11, 5);

											$twdata["state"] = 0; // не отправлено
											$twdata["surveyID"] = $surveyID;
											$twdata["message"] = str_replace("{{1}}", $name, str_replace("{{3}}", $timeonly, str_replace("{{4}}", $expiration_timeonly, $wa_message)));
											// if ($tulink != "") {
												// $twdata["message"] = preg_replace($pattern, "", str_replace("\${m://FirstName}", $name, str_replace("\${m://LastName}", $lastname, str_replace("\${e://Field/contact_id}", $customer_id, str_replace("\${l://SurveyLink?d=Take the Survey}", "Take the Survey here: ".$link, str_replace("\${l://SurveyURL}", $link, $msg))))));
												// $twdata["message"] = str_replace("{{1}}", $name, str_replace("{{2}}", $tulink, str_replace("{{3}}", $timeonly, str_replace("{{4}}", $expiration_timeonly, $wa_message))));
											// }
											// else
												// $twdata["message"] = $wa_message." (no link found)";
											$twdata["distr_id"] = $distr_id;
											$twdata["customer_id"] = $customer_id;
											$twdata["snooze"] = $snooze;
											$twdata["name"] = $name." ".$lastname;
											$twdata["phone"] = str_replace("(", "", str_replace(")", "", str_replace(" ", "", str_replace("-", "", $phone))));
											
											// $alldata["result"]["elements"][$distr_id] = $twdata;
											
											mysql_query("insert into twilios (user_id, twilio_surveyID, is_reminder_for, send_time, state, message, distr_id, customer_id, snooze, name, phone)
											values ('".$user_id_tw."', '".$surveyID."', '', '".make_jtime($twdata["send_time"])."', 'init', '".mysql_real_escape_string($twdata["message"])."', '".$distr_id."', '".$customer_id."', '".$snooze."', '".mysql_real_escape_string($twdata["name"])."', '".$twdata["phone"]."')");

											if ($writetwlog == 1) {
												$mk_bd = fopen($twlog_file,"a") or exit("No file to open!");
												flock($mk_bd,LOCK_EX);
												fwrite($mk_bd, "\n--new WhatsApp twilio for ".$distr_id." was added with Jerusalem Time ".make_jtime($twdata["send_time"])."--");
												flock($mk_bd,LOCK_UN);
												fclose($mk_bd);
											}
										}

										$func_result["twilio"] = $alldata;

										if (!$dontsendr || $dontsendr != 1)
											{
											// set the reminder
											$params = '{';
											$params .= '"header": { "fromEmail": "noreply@qemailserver.com", "fromName": "'.$from_name.'", "subject": "'.$reminder_name.'", "replyToEmail" : "'.$reply_to.'" },';
											$params .= '"message": { "libraryId":"'.$lid.'","messageId":"'.$reminder_messageID.'"},';
											$params .= '"sendDate":"'.$reminder_send_time.'"}';
											
											// echo $params;
											curl_close ($ch);
											$ch = curl_init();

											curl_setopt($ch, CURLOPT_URL, "https://".$url.".qualtrics.com/API/v3/distributions/".$distr_id."/reminders");
											curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
											curl_setopt($ch, CURLOPT_TIMEOUT, 0);
											curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
											curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");

											$headers = array();
											$headers[] = "X-Api-Token: ".$token;
											$headers[] = "Content-Type: application/json";
											curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

											if ($writeclog == 1) {
												$mk_bd = fopen($clog_file,"a") or exit("No file to open!");
												flock($mk_bd,LOCK_EX);
												fwrite($mk_bd,"-- Qualtrics request https://".$url.".qualtrics.com/API/v3/distributions/".$distr_id."/reminders was at ".date("d/m/Y H:i:s")." --\n");
												flock($mk_bd,LOCK_UN);
												fclose($mk_bd);
											}
											$result = curl_exec($ch);
											if (curl_errno($ch)) {
												$func_result["reminders"]["error"][] = curl_error($ch);
												if ($writeclog == 1) {
													$mk_bd = fopen($clog_file,"a") or exit("No file to open!");
													flock($mk_bd,LOCK_EX);
													fwrite($mk_bd,"Error reminder set: ".curl_error($ch)."\n");
													flock($mk_bd,LOCK_UN);
													fclose($mk_bd);
												}
											}
											else {
												$json = json_decode($result, true);
												$reminder_id = $json["result"]["distributionId"];

												// add to file for cron to send twilio reminders
												if ($reminder_id != "")
													{
													$func_result["reminders"][$reminder_id]["name"] = $reminder_name;
													$func_result["reminders"][$reminder_id]["send_time"] = $reminder_send_time;

													if ($dontsendwa != 1)
														{
														$twdata = array();

														$twdata["distr_name"] = $reminder_name;
														$twdata["send_time"] = str_replace("T", " ", str_replace("Z", "", $reminder_send_time));
														// $timeonly = substr($local_send_time, 11, 5);
														$timeonly = substr($send_time, 11, 5);
														$expiration_timeonly = substr($local_expiration_date, 11, 5);
														
														$twdata["state"] = 'init'; // не отправлено
														$twdata["surveyID"] = $surveyID;
														$twdata["message"] = str_replace("{{1}}", $name, str_replace("{{3}}", $timeonly, str_replace("{{4}}", $expiration_timeonly, $wa_rmessage)));
														// if ($tulink != "") {
															// $twdata["message"] = preg_replace($pattern, "", str_replace("\${m://FirstName}", $name, str_replace("\${m://LastName}", $lastname, str_replace("\${e://Field/contact_id}", $customer_id, str_replace("\${l://SurveyLink?d=Take the Survey}", "Take the Survey here: ".$link, str_replace("\${l://SurveyURL}", $link, $rmsg))))));
															// $twdata["message"] = str_replace("{{1}}", $name, str_replace("{{2}}", $tulink, str_replace("{{3}}", $timeonly, str_replace("{{4}}", $expiration_timeonly, $wa_rmessage))));
														// }
														// else
															// $twdata["message"] = $wa_rmessage." (no link found)";
														$twdata["distr_id"] = $reminder_id;
														$twdata["customer_id"] = $customer_id;
														$twdata["snooze"] = $snooze;
														$twdata["is_reminder_for"] = $distr_id;
														$twdata["name"] = $name." ".$lastname;
														$twdata["phone"] = str_replace("(", "", str_replace(")", "", str_replace(" ", "", str_replace("-", "", $phone))));

														// $alldata["result"]["elements"][$reminder_id] = $twdata;

														mysql_query("insert into twilios (user_id, twilio_surveyID, is_reminder_for, send_time, state, message, distr_id, customer_id, snooze, name, phone)
														values ('".$user_id_tw."', '".$surveyID."', '".$distr_id."', '".make_jtime($twdata["send_time"])."', 'init', '".mysql_real_escape_string($twdata["message"])."', '".$reminder_id."', '".$customer_id."', '".$snooze."', '".mysql_real_escape_string($twdata["name"])."', '".$twdata["phone"]."')");

														if ($writetwlog == 1) {
															$mk_bd = fopen($twlog_file,"a") or exit("No file to open!");
															flock($mk_bd,LOCK_EX);
															fwrite($mk_bd, "\n--new WhatsApp twilio reminder for ".$distr_id." was added with Jerusalem Time ".make_jtime($twdata["send_time"])."--");
															flock($mk_bd,LOCK_UN);
															fclose($mk_bd);
														}
													}
												}
												else
													{
													$func_result["reminders"]["error"][] = $result;
													if ($writeclog == 1) {
														$mk_bd = fopen($clog_file,"a") or exit("No file to open!");
														flock($mk_bd,LOCK_EX);
														fwrite($mk_bd,"Error reminder set: ".$result."\n");
														flock($mk_bd,LOCK_UN);
														fclose($mk_bd);
													}
												}

												$func_result["twilio_reminders"] = $alldata;
											}
										}
										if ($writeclog == 1) {
											$mk_bd = fopen($clog_file,"a") or exit("Cannot open file!");
											flock($mk_bd,LOCK_EX);
											fwrite($mk_bd,"Distribution finally set at ".date("Y-m-d H:i:s").", it took ".(time() - $timestampstart)." seconds\n");
											flock($mk_bd,LOCK_UN);
											fclose($mk_bd);
										}
									}
									else
										{
										$func_result["distributions"]["error"][] = $result;
										if ($writeclog == 1) {
											$mk_bd = fopen($clog_file,"a") or exit("No file to open!");
											flock($mk_bd,LOCK_EX);
											fwrite($mk_bd,"\nDistribution not set at ".date("Y-m-d H:i:s").": ".$result);
											flock($mk_bd,LOCK_UN);
											fclose($mk_bd);
										}
									}
								}
							}
							/*
							curl_close ($ch);
							$ch = curl_init();

							$params = '{';
							$params .= '"topics": "surveyengine.completedResponse.'.$surveyID.'",';
							$params .= '"publicationUrl": "'.$http_address.'/xp_eventlistener.php",';
							$params .= '"encrypt": false';
							$params .= '}';
								
							curl_setopt($ch, CURLOPT_URL, "https://".$url.".qualtrics.com/API/v3/eventsubscriptions");
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
							curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
							curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");

							$headers = array();
							$headers[] = "X-Api-Token: ".$token;
							$headers[] = "Content-Type: application/json";
							curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

							$mk_bd = fopen($qlog_file,"a") or exit("No file to open!");
							flock($mk_bd,LOCK_EX);
							fwrite($mk_bd,"\n-- Qualtrics request https://".$url.".qualtrics.com/API/v3/eventsubscriptions for ".$surveyID." was at ".date("d/m/Y H:i")." --");
							flock($mk_bd,LOCK_UN);
							fclose($mk_bd);
							$result = curl_exec($ch);
							if (curl_errno($ch)) {
								echo "Error: ".curl_error($ch);
								$mk_bd = fopen($plog_file,"a") or exit("No file to open!");
								flock($mk_bd,LOCK_EX);
								fwrite($mk_bd,"\nError subscription set: ".curl_error($ch));
								flock($mk_bd,LOCK_UN);
								fclose($mk_bd);
							}
							else
								$func_result["eventsubscription"]["result"] = $result;
							*/
						}
					}
					else
						$func_result["distributions"]["error"][] = "no roles data found or contact is not created";
					// }
				}
			}
			echo json_encode($func_result, JSON_UNESCAPED_UNICODE);
		}
		curl_close ($ch);
	}
	elseif ($method == "START" && $action == "eventsubscriptions")
		{
		$ch = curl_init();

		$surveyId = $_REQUEST["surveyId"];

		$params = '{';
		$params .= '"topics": "surveyengine.completedResponse.'.$surveyId.'",';
		$params .= '"publicationUrl": "'.$http_address.'/xp_eventlistener.php",';
		$params .= '"encrypt": false';
		$params .= '}';
			
		curl_setopt($ch, CURLOPT_URL, "https://".$url.".qualtrics.com/API/v3/".$action);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 0);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");

		$headers = array();
		$headers[] = "X-Api-Token: ".$token;
		$headers[] = "Content-Type: application/json";
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$mk_bd = fopen($qlog_file,"a") or exit("No file to open!");
		flock($mk_bd,LOCK_EX);
		fwrite($mk_bd,"\n-- Qualtrics request https://".$url.".qualtrics.com/API/v3/".$action." was at ".date("d/m/Y H:i")." --");
		flock($mk_bd,LOCK_UN);
		fclose($mk_bd);
		$result = curl_exec($ch);
		if (curl_errno($ch)) {
			echo "Error: ".curl_error($ch);
		}
		else
			echo $result;

		curl_close ($ch);
	}
	elseif ($method == "DELETE" && $action == "twilio")
		{
		$customer_id = $_REQUEST["customer_id"];

		mysql_query("delete from twilios where customer_id = '".$customer_id."'");
		mysql_query("delete from twilios_sms where customer_id = '".$customer_id."'");
		mysql_query("delete from participants where c_id = '".$customer_id."'");
		
		$tcnt = mysql_affected_rows();

		if ($writetwlog == 1) {
			$mk_bd = fopen($twlog_file,"a") or exit("No file to open!");
			flock($mk_bd,LOCK_EX);
			fwrite($mk_bd, "\n--".$tcnt." items was deleted--");
			flock($mk_bd,LOCK_UN);
			fclose($mk_bd);
		}

		echo "{\"result\":\"OK\"}";
	}
	elseif ($method == "GET" && $action == "distributions")
		{
		$ch = curl_init();

		$surveyID = $_REQUEST["surveyId"];
		if ($sendStartDate != "")
			$sendStart_text = "&sendStartDate=".urlencode(make_time($sendStartDate." 00:00:00"));
		if ($sendEndDate != "")
			$sendEnd_text = "&sendEndDate=".urlencode(make_time($sendEndDate." 23:59:59"));
		if ($distributionRequestType != "")
			$distributionRequestType = "&distributionRequestType=".$distributionRequestType;

		$headers = array();
		$headers[] = "X-Api-Token: ".$token;
		$headers[] = "Content-Type: application/json";

		$request = "https://".$url.".qualtrics.com/API/v3/distributions?surveyId=".$surveyID.$sendStart_text.$sendEnd_text.$distributionRequestType;

		$mk_bd = fopen($curl_log,"a") or exit("No file to open!");
		flock($mk_bd,LOCK_EX);
		fwrite($mk_bd, "\nCurl request: ".$request);
		flock($mk_bd,LOCK_UN);
		fclose($mk_bd);

		curl_setopt($ch, CURLOPT_URL, $request);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 0);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$mk_bd = fopen($qlog_file,"a") or exit("No file to open!");
		flock($mk_bd,LOCK_EX);
		fwrite($mk_bd,"\n-- Qualtrics request https://".$url.".qualtrics.com/API/v3/distributions?surveyId=".$surveyID.$sendStart_text.$sendEnd_text.$distributionRequestType." was at ".date("d/m/Y H:i")." --");
		flock($mk_bd,LOCK_UN);
		fclose($mk_bd);
		$result = curl_exec($ch);

		$mk_bd = fopen($curl_log,"a") or exit("No file to open!");
		flock($mk_bd,LOCK_EX);
		fwrite($mk_bd, "\nCurl result: ".substr($result, 0, 200)."...");
		flock($mk_bd,LOCK_UN);
		fclose($mk_bd);

		if (curl_errno($ch)) {
			echo "Error: ".curl_error($ch);
		}
		else {
			$arr_result = json_decode($result, true);
			$total_result["meta"]["httpStatus"] = $arr_result["meta"]["httpStatus"];
			foreach ($arr_result["result"]["elements"] as $d => $distr)
				{
				$total_result["result"]["elements"][] = $distr;
			}

			$offset = "";
			if ($arr_result["result"]["nextPage"] != "")
				{
				$url_components = parse_url($arr_result["result"]["nextPage"]);
				parse_str($url_components['query'], $url_params);
				$offset = urlencode($url_params["skipToken"]);
			}
			while ($offset != "")
				{
				curl_setopt($ch, CURLOPT_URL, "https://".$url.".qualtrics.com/API/v3/distributions?surveyId=".$surveyID."&skipToken=".$offset.$sendStart_text.$sendEnd_text.$distributionRequestType);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_TIMEOUT, 0);
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

				$mk_bd = fopen($qlog_file,"a") or exit("No file to open!");
				flock($mk_bd,LOCK_EX);
				fwrite($mk_bd,"\n-- Qualtrics request https://".$url.".qualtrics.com/API/v3/distributions?surveyId=".$surveyID."&skipToken=".$offset.$sendStart_text.$sendEnd_text.$distributionRequestType." was at ".date("d/m/Y H:i")." --");
				flock($mk_bd,LOCK_UN);
				fclose($mk_bd);
				$result = curl_exec($ch);
				if (curl_errno($ch)) {
					echo "Error: ".curl_error($ch);
				}
				else {
					$arr_result = json_decode($result, true);
					foreach ($arr_result["result"]["elements"] as $d => $distr)
						{
						$total_result["result"]["elements"][] = $distr;
					}
					// echo count($total_result["result"]["elements"])."|";
				}
				if ($arr_result["result"]["nextPage"] != "")
					{
					$url_components = parse_url($arr_result["result"]["nextPage"]);
					parse_str($url_components['query'], $params);
					$offset = urlencode($params["skipToken"]);
				}
				else
					$offset = "";
			}
			echo json_encode($total_result, JSON_UNESCAPED_UNICODE);
		}
		// $mk_bd = fopen($curl_log,"a") or exit("No file to open!");
		// flock($mk_bd,LOCK_EX);
		// fwrite($mk_bd, "\nCurl closed at ".date("Y-m-d H:i:s"));
		// flock($mk_bd,LOCK_UN);
		// fclose($mk_bd);
		curl_close ($ch);
	}
	elseif ($method == "GET" && $action == "physioq")
		{
		$physid = $_REQUEST["physid"];
		$q = mysql_query("select * from physioqs where physioqID = '".$physid."'") or die("Get physioqs :".mysql_error());
		while($arr = mysql_fetch_assoc($q))
			$alldata["result"]["elements"][] = $arr;
		$content = json_encode($alldata, JSON_UNESCAPED_UNICODE);
		if ($content != "")
			echo $content;
		else
			echo "null";
	}
	elseif ($method == "GET" && $action == "phonic")
		{
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'http://api.phonic.ai/login',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'GET',
		  CURLOPT_HTTPHEADER => array(
			'Authorization: Basic '.base64_encode($ph_username.':' .$ph_password)
		  ),
		));

		$response = curl_exec($curl);
		if (curl_errno($ch))
			echo curl_error($ch);
		else
			{
			$json = json_decode($response, true);
		}

		$idToken = $json["idToken"];
		// $idToken = "eyJhbGciOiJSUzI1NiIsImtpZCI6IjM1MDM0MmIwMjU1MDAyYWI3NWUwNTM0YzU4MmVjYzY2Y2YwZTE3ZDIiLCJ0eXAiOiJKV1QifQ.eyJuYW1lIjoiRFBMIEJJVSIsImlzcyI6Imh0dHBzOi8vc2VjdXJldG9rZW4uZ29vZ2xlLmNvbS9waG9uaWMtMiIsImF1ZCI6InBob25pYy0yIiwiYXV0aF90aW1lIjoxNjMzNTMwNjc4LCJ1c2VyX2lkIjoid2phTnlQQVk5RFBLUkkzTlhvRHpzeHdkd2xOMiIsInN1YiI6IndqYU55UEFZOURQS1JJM05Yb0R6c3h3ZHdsTjIiLCJpYXQiOjE2MzM1MzA2NzgsImV4cCI6MTYzMzUzNDI3OCwiZW1haWwiOiJkeW5hbWljLnByb2Nlc3Nlcy5sYWJAZ21haWwuY29tIiwiZW1haWxfdmVyaWZpZWQiOnRydWUsImZpcmViYXNlIjp7ImlkZW50aXRpZXMiOnsiZW1haWwiOlsiZHluYW1pYy5wcm9jZXNzZXMubGFiQGdtYWlsLmNvbSJdfSwic2lnbl9pbl9wcm92aWRlciI6InBhc3N3b3JkIn19.mOPNCOngMOHDDFoOhVHZy2E-kmES02JPntr8bCJtbRZHnDIf6R1jcue2F2ZaDIqApzmz9gqTiTD3ruGxqSzN74_jXH8QaC-FrajIFqzgak3vKegtdNYcfiIqqCcmWEGasWNONU-lEb7eTcWWrLEIhtHLSXrj2wLRj0L7SHveg2pkcCbPaXVWJX1wJgGVsXTmztrhm0lGnjwavcesNsrmR8ZxEZs8gfIoik0dt0v5eBaai4tyLgN3xHJ8LlPRUCpxbx0vYq69xOXKqv6xv9I-0x1FleBwtMl84pgmY9dRzOU-JAGWuM0IwqQzKSRr4XP-kXq5_Iq603a6R5rBcqqBlg";
		
		$phid = $_REQUEST["phid"];
		$phqid = $_REQUEST["phqid"];
		// echo $idToken;
		// echo "----------";
		// echo $phid;

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'http://api.phonic.ai/surveys/'.$phid.'/sessions',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'GET',
		  CURLOPT_HTTPHEADER => array(
			'Authorization: Bearer '.$idToken
		  ),
		));

		$response = curl_exec($curl);
		$json = json_decode($response, true);
		
		if (curl_errno($ch))
			echo curl_error($ch);
		else
			{
			curl_setopt_array($curl, array(
			  CURLOPT_URL => 'http://api.phonic.ai/surveys/'.$phid.'/question/'.$phqid.'/responses',
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'GET',
			  CURLOPT_HTTPHEADER => array(
				'Authorization: Bearer '.$idToken
			  ),
			));

			$response1 = curl_exec($curl);
			$json1 = json_decode($response1, true);
			$result = array();
			$result = $json1;
			$result["sessions"] = $json;
			echo json_encode($result, JSON_UNESCAPED_UNICODE);
		}

		curl_close($curl);
	}
	elseif ($method == "GET" && $action == "maxphysioqtimes")
		{
		$slct = mysql_query("select surveyID, physioqID, participantID, max(local_dttm) as maxdt from physioqs_csv where bt > 0 group by surveyID, physioqID, participantID") or die(mysql_error());
		while($arr = mysql_fetch_assoc($slct))
			$alldata[] = $arr;
		$content = json_encode($alldata, JSON_UNESCAPED_UNICODE);
		if ($content != "")
			echo $content;
		else
			echo "null";
	}
	elseif ($method == "GET" && $action == "mailinglists")
		{
		$alldata["result"]["elements"] = array();
		$q = mysql_query("select * from participants") or die(mysql_error());
		while ($arr = mysql_fetch_assoc($q))
			{
			$alldata["result"]["elements"][] = $arr;
		}
		$alldata["meta"]["httpStatus"] = "200 - OK";
		$content = json_encode($alldata, JSON_UNESCAPED_UNICODE);
		if ($content != "")
			echo $content;
		else
			echo "null";
		/*
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://".$url.".qualtrics.com/API/v3/mailinglists");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

		$headers = array();
		$headers[] = "X-Api-Token: ".$token;
		$headers[] = "Content-Type: application/json";
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$result = curl_exec($ch);
		if (curl_errno($ch)) {
			echo "Error: ".curl_error($ch);
		}
		else {
			$arr_result = json_decode($result, true);
			$total_result["meta"]["httpStatus"] = $arr_result["meta"]["httpStatus"];

			foreach ($arr_result["result"]["elements"] as $m => $mailinglist)
				{
				$ml_id = $mailinglist["id"];
				curl_setopt($ch, CURLOPT_URL, "https://".$url.".qualtrics.com/API/v3/mailinglists/".$ml_id."/contacts");
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

				$result1 = curl_exec($ch);
				if (curl_errno($ch)) {
					echo "Error: ".curl_error($ch);
				}
				else {
					$arr_result1 = json_decode($result1, true);
					foreach ($arr_result1["result"]["elements"] as $c => $contact)
						{
						$contact["mailinglistID"] = $ml_id;
						$total_result["result"]["elements"][] = $contact;
					}
				}
			}

			$offset = "";
			if ($arr_result["result"]["nextPage"] != "")
				{
				$url_components = parse_url($arr_result["result"]["nextPage"]);
				parse_str($url_components["query"], $url_params);
				$offset = $url_params["offset"];
			}
			while ($offset != "")
				{
				curl_setopt($ch, CURLOPT_URL, "https://".$url.".qualtrics.com/API/v3/mailinglists?offset=".$offset);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

				$result = curl_exec($ch);
				if (curl_errno($ch)) {
					echo "Error: ".curl_error($ch);
				}
				else {
					$arr_result = json_decode($result, true);
					foreach ($arr_result["result"]["elements"] as $m => $mailinglist)
						{
						$ml_id = $mailinglist["id"];
						curl_setopt($ch, CURLOPT_URL, "https://".$url.".qualtrics.com/API/v3/mailinglists/".$ml_id."/contacts");
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
						curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

						$result1 = curl_exec($ch);
						if (curl_errno($ch)) {
							echo "Error: ".curl_error($ch);
						}
						else {
							$arr_result1 = json_decode($result1, true);
							foreach ($arr_result1["result"]["elements"] as $c => $contact)
								{
								$contact["mailinglistID"] = $ml_id;
								$total_result["result"]["elements"][] = $contact;
							}
						}
					}
					// echo count($total_result["result"]["elements"])."|";
				}
				if ($arr_result1["result"]["nextPage"] != "")
					{
					$url_components = parse_url($arr_result1["result"]["nextPage"]);
					parse_str($url_components["query"], $params);
					$offset = $params["offset"];
				}
				else
					$offset = "";
			}
			echo json_encode($total_result, JSON_UNESCAPED_UNICODE);
		}

		curl_close ($ch);
		*/
	}
	elseif ($method == "GET" && $action == "surveys")
		{
		$ch = curl_init();

		$nextPage = "";
		$offset = "";
		$starting = 1;
		$allsurveys = array();

		while ($nextPage != "" || $starting == 1)
			{
			$starting = 0;
			if ($nextPage != "")
				{
				$parts = parse_url($nextPage);
				parse_str($parts["query"], $query);
				$offset = urlencode($query["offset"]);
			}
			$offset_text = "";
			if ($offset != "")
				$offset_text = "&offset=".$offset;

			curl_setopt($ch, CURLOPT_URL, "https://".$url.".qualtrics.com/API/v3/surveys?".$offset_text);
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
			}
			else {
				// list surveys
				$surveys = json_decode($result, true);
				foreach ($surveys["result"]["elements"] as $survey)
					{
					$allsurveys[] = $survey;
				}
				$meta = $surveys["meta"];
				$nextPage = "";
				if ($surveys["result"]["nextPage"] != "" && $surveys["result"]["nextPage"] != "undefined" && $surveys["result"]["nextPage"] != null)
					$nextPage = $surveys["result"]["nextPage"];
			}
		}
		$finalsurveys["meta"] = $meta;
		$finalsurveys["result"]["elements"] = $allsurveys;
		echo json_encode($finalsurveys, JSON_UNESCAPED_UNICODE);

		curl_close ($ch);
	}
	else
		{
		if ($sendStartDate != "")
			$sendStart_text = "&sendStartDate=".make_time($sendStartDate." 00:00:00");
		if ($sendEndDate != "")
			$sendEnd_text = "&sendEndDate=".make_time($sendEndDate." 23:59:59");
		if ($distributionRequestType != "")
			$distributionRequestType = "&distributionRequestType=".$distributionRequestType;
		if ($offset != "")
			$offset_text = "&skipToken=".$offset;
		
		$request = "https://".$url.".qualtrics.com/API/v3/".$action.$offset_text.$sendStart_text.$sendEnd_text.$distributionRequestType;

		// $mk_bd = fopen($curl_log,"a") or exit("No file to open!");
		// flock($mk_bd,LOCK_EX);
		// fwrite($mk_bd, "\nCurl request: ".$request);
		// flock($mk_bd,LOCK_UN);
		// fclose($mk_bd);

		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, $request);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 0);
		if ($method != "")
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

		$headers = array();
		$headers[] = "X-Api-Token: ".$token;
		$headers[] = "Content-Type: application/json";
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		// $mk_bd = fopen($qlog_file,"a") or exit("No file to open!");
		// flock($mk_bd,LOCK_EX);
		// fwrite($mk_bd,"\n-- Qualtrics request https://".$url.".qualtrics.com/API/v3/".$action.$offset_text.$sendStart_text.$sendEnd_text.$distributionRequestType." was at ".date("d/m/Y H:i")." --");
		// flock($mk_bd,LOCK_UN);
		// fclose($mk_bd);
		$result = curl_exec($ch);

		// $mk_bd = fopen($curl_log,"a") or exit("No file to open!");
		// flock($mk_bd,LOCK_EX);
		// fwrite($mk_bd, "\nCurl result: ".$result);
		// flock($mk_bd,LOCK_UN);
		// fclose($mk_bd);

		if (curl_errno($ch)) {
			echo "Error: ".curl_error($ch);
		}
		else {
			// if ($sendStart_text != "")
				// echo $sendStart_text.$sendEnd_text;
			// else
				echo $result;
		}

		curl_close ($ch);
	}
}
else
	echo "{\"error\":\"Authorisation failed!\"}";
function make_time($dt) {
	/* $dt must be in YYYY-mm-dd H:i:s format*/
	$timezone = date_default_timezone_get();
	$userTimezone = new DateTimeZone($timezone);
	// return gmdate("Y-m-d", strtotime($dt))."T".gmdate("H:i:s", strtotime($dt))."Z";
	// return date("Y-m-d", strtotime($dt))."T".date("H:i:s", strtotime($dt))."Z";
	$kolkata_date_time = new DateTime('now', $userTimezone);
	return date("Y-m-d", strtotime($dt))."T".date("H:i:s", strtotime($dt)).$kolkata_date_time->format('P');
}
function make_jtime($dt) {
	/* $dt must be in YYYY-mm-dd H:i:s format*/
	return gmdate("Y-m-d", strtotime($dt))."T".gmdate("H:i:s", strtotime($dt))."+03:00";
}
function make_htime($dt) {
	return date("d/m/Y H:i", $dt);
}
function make_etime($dt) {
	return date("Y-m-d H:i", $dt);
}
function gmdate_to_mydate($dt){
	/* $dt must be in YYYY-mm-dd H:i:s format*/
	$timezone = date_default_timezone_get();
	$userTimezone = new DateTimeZone($timezone);
	$gmtTimezone = new DateTimeZone('GMT');
	$myDateTime = new DateTime($dt, $gmtTimezone);
	$offset = $userTimezone->getOffset($myDateTime);
	// return gmdate("Y-m-d H:i:s", strtotime($dt) + $offset);
	return date("Y-m-d H:i:s", strtotime($dt) + $offset);
}
function mydate_to_gmdate($mydate) {
	/* $mydate must be in YYYY-mm-dd H:i:s format*/
	// $timezone = date_default_timezone_get();
	// $userTimezone = new DateTimeZone($timezone);
	// $gmtTimezone = new DateTimeZone('GMT');
	// $myDateTime = new DateTime($mydate, $gmtTimezone);
	// $offset = $userTimezone->getOffset($myDateTime);
	return gmdate("Y-m-d", strtotime($mydate))."T".gmdate("H:i:s", strtotime($mydate))."Z";
}
?>