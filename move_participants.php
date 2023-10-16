<?
require "config.php";

$slct = mysql_query("select * from users where user_login = '".mysql_real_escape_string($_SESSION["s_login"])."' and user_password = '".mysql_real_escape_string($_SESSION["s_password"])."'") or die(mysql_error());
if (mysql_num_rows($slct) == 1 || (@$_SESSION["s_login"] == $log && @$_SESSION["s_password"] == md5($pass)))
	{
	$arr = mysql_fetch_assoc($slct);
	$token = $arr["q_token"];
	$url = $arr["user_url"];
}
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
	$arr_result = json_decode($result, JSON_UNESCAPED_UNICODE);
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
			$arr_result1 = json_decode($result1, JSON_UNESCAPED_UNICODE);
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
			$arr_result = json_decode($result, JSON_UNESCAPED_UNICODE);
			foreach ($arr_result["result"]["elements"] as $m => $mailinglist)
				{
				$ml_id = $mailinglist["id"];
				$lid = $mailinglist["libraryId"];
				curl_setopt($ch, CURLOPT_URL, "https://".$url.".qualtrics.com/API/v3/mailinglists/".$ml_id."/contacts");
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

				$result1 = curl_exec($ch);
				if (curl_errno($ch)) {
					echo "Error: ".curl_error($ch);
				}
				else {
					$arr_result1 = json_decode($result1, JSON_UNESCAPED_UNICODE);
					foreach ($arr_result1["result"]["elements"] as $c => $contact)
						{
						$contact["mailinglistID"] = $ml_id;
						$contact["libraryId"] = $lid;
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
foreach ($total_result["result"]["elements"] as $arr)
	{
	$surveyID = $arr["embeddedData"]["surveyID"];
	$ml_id = $arr["mailinglistID"];
	$customer_id = $arr["id"];
	$contact_id = $arr["embeddedData"]["contact_id"];
	$Dyad_ID = $arr["embeddedData"]["Dyad_ID"];
	$dontsendwa = $arr["embeddedData"]["dontsendwa"];
	$name = $arr["firstName"];
	$lastname = $arr["lastName"];
	$phone = $arr["embeddedData"]["phone"];
	$email = $arr["email"];
	$lid = $arr["libraryId"];
	$messageID = $arr["embeddedData"]["mid"];
	$reminder_messageID = $arr["embeddedData"]["rmid"];
	$start_date = $arr["embeddedData"]["start_date"];
	$days = $arr["embeddedData"]["days"];
	$start_time = $arr["embeddedData"]["start_time"];
	$start_time_we = $arr["embeddedData"]["start_time_we"];
	mysql_query("insert into participants (s_id, ml_id, c_id, p_number, Dyad_ID, dwa,
	fname, lname, phone, email, lid, mid, rmid,
	start_date, num_days, start_time, start_time_we, created)
	values ('".$surveyID."', '".$ml_id."', '".$customer_id."', '".$contact_id."', '".$Dyad_ID."', '".$dontsendwa."', 
	'".mysql_real_escape_string($name)."', '".mysql_real_escape_string($lastname)."', '".$phone."', '".$email."', '".$lid."', '".$messageID."', '".$reminder_messageID."',
	'".$start_date."', '".$days."', '".$start_time."', '".$start_time_we."', NOW())") or die(mysql_error());
}
?>
