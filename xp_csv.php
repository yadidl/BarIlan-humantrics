<?php
session_start();

ini_set("display_errors", "1");
ini_set("display_startup_errors", "1");
set_time_limit(50000);
ini_set("error_reporting", E_PARSE);

// mysql_connect("localhost", "eshraf_survey", "S4xrOD12pw", "eshraf_survey") or die("Connection error");
mysql_connect("localhost", "eshraf_survey_dev", "P7u83qSKud", "eshraf_survey_dev") or die("Connection error");
// mysql_query("use eshraf_survey");
mysql_query("use eshraf_survey_dev");

mysql_query("set character_set_client ='utf8'");
mysql_query("set character_set_results ='utf8'");
mysql_query("set collation_connection ='utf8_general_ci'");

$slct = mysql_query("select * from users where user_login = '".mysql_real_escape_string($_SESSION["s_login"])."' and user_password = '".mysql_real_escape_string($_SESSION["s_password"])."'") or die(mysql_error());
if (mysql_num_rows($slct) == 1)
	{
	$arr = mysql_fetch_assoc($slct);
	$token = $arr["q_token"];
	$url = $arr["user_url"];
	$wa_message = $arr["wa_message"];
	$wa_rmessage = $arr["wa_rmessage"];
	$username = $arr["user_name"];

	$surveyID = $_REQUEST["sid"];
	$ml_id = $_REQUEST["mid"];

	header("Content-type: text/csv");
	header("Content-Disposition: attachment; filename=".$ml_id.".csv");
	header("Pragma: no-cache");
	header("Expires: 0");

	// ini_set("display_errors", "1");
	// ini_set("display_startup_errors", "1");
	ini_set("error_reporting", E_PARSE);

	date_default_timezone_set('Asia/Jerusalem');
	$timezone = "Asia/Jerusalem";

	$ch = curl_init();

	$headers = array();
	$headers[] = "X-Api-Token: ".$token;
	$headers[] = "Content-Type: application/json";

	curl_setopt($ch, CURLOPT_URL, "https://".$url.".qualtrics.com/API/v3/distributions?surveyId=".$surveyID);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

	$result = curl_exec($ch);
	if (curl_errno($ch)) {
		echo "Error: ".curl_error($ch);
	}
	else {
		$arr_result = json_decode($result, JSON_UNESCAPED_UNICODE);
		
		foreach ($arr_result["result"]["elements"] as $distr)
			{
			if ($distr["recipients"]["mailingListId"] == $ml_id)
				{
				echo $distr["id"].",";
				echo $distr["requestStatus"].",";
				echo $distr["requestType"].",";
				echo date("Y-m-d H:i:s", strtotime($distr["sendDate"])).",";
				echo date("Y-m-d H:i:s", strtotime($distr["surveyLink"]["expirationDate"])).",";
				echo $distr["header"]["subject"].",";
				echo $distr["stats"]["sent"].",";
				echo $distr["stats"]["failed"].",";
				echo $distr["stats"]["started"].",";
				echo $distr["stats"]["bounced"].",";
				echo $distr["stats"]["opened"].",";
				echo $distr["stats"]["skipped"].",";
				echo $distr["stats"]["finished"].",";
				echo $distr["stats"]["complaints"].",";
				echo $distr["stats"]["blocked"]."\r\n";
			}
		}
	}

	$offset = "";
	if ($arr_result["result"]["nextPage"] != "")
		$offset = str_replace("https://".$url.".qualtrics.com/API/v3/distributions?surveyId=".$surveyID."&offset=", "", $arr_result["result"]["nextPage"]);

	while ($offset != "")
		{
		if ($offset != "")
			$offset_text = "&offset=".$offset;
		curl_setopt($ch, CURLOPT_URL, "https://".$url.".qualtrics.com/API/v3/distributions?surveyId=".$surveyID.$offset_text);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$result = curl_exec($ch);
		if (curl_errno($ch)) {
			echo "Error: ".curl_error($ch);
		}
		else {
			$arr_result = json_decode($result, JSON_UNESCAPED_UNICODE);

			foreach ($arr_result["result"]["elements"] as $distr)
				{
				if ($distr["recipients"]["mailingListId"] == $ml_id)
					{
					echo $distr["id"].",";
					echo $distr["requestStatus"].",";
					echo $distr["requestType"].",";
					echo date("Y-m-d H:i:s", strtotime($distr["sendDate"])).",";
					echo date("Y-m-d H:i:s", strtotime($distr["surveyLink"]["expirationDate"])).",";
					echo $distr["header"]["subject"].",";
					echo $distr["stats"]["sent"].",";
					echo $distr["stats"]["failed"].",";
					echo $distr["stats"]["started"].",";
					echo $distr["stats"]["bounced"].",";
					echo $distr["stats"]["opened"].",";
					echo $distr["stats"]["skipped"].",";
					echo $distr["stats"]["finished"].",";
					echo $distr["stats"]["complaints"].",";
					echo $distr["stats"]["blocked"]."\r\n";
				}
			}
		}

		$offset = "";
		if ($arr_result["result"]["nextPage"] != "")
			$offset = str_replace("https://".$url.".qualtrics.com/API/v3/distributions?surveyId=".$surveyID."&offset=", "", $arr_result["result"]["nextPage"]);
	}

	curl_close ($ch);
}
else
	echo "Wrong login!";
?>
