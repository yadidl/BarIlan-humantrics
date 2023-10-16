<?php
$surveyID = $_REQUEST["sid"];

header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=survey".$surveyID.".csv");
header("Pragma: no-cache");
header("Expires: 0");

// ini_set("display_errors", "1");
// ini_set("display_startup_errors", "1");
ini_set("error_reporting", E_PARSE);

date_default_timezone_set('Asia/Jerusalem');
$timezone = "Asia/Jerusalem";

$http_address = "http://survey.ironcommunication.com";



$ch = curl_init();

$headers = array();
$headers[] = "X-Api-Token: ".$token;
$headers[] = "Content-Type: application/json";

curl_setopt($ch, CURLOPT_URL, "https://biusocialsciences.eu.qualtrics.com/API/v3/distributions?surveyId=".$surveyID);
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
		echo $distr["id"].",";
		echo $distr["requestStatus"].",";
		echo $distr["requestType"].",";
		echo $distr["sendDate"].",";
		echo $distr["surveyLink"]["expirationDate"].",";
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

$offset = "";
if ($arr_result["result"]["nextPage"] != "")
	$offset = str_replace("https://biusocialsciences.eu.qualtrics.com/API/v3/distributions?surveyId=".$surveyID."&offset=", "", $arr_result["result"]["nextPage"]);

while ($offset != "")
	{
	if ($offset != "")
		$offset_text = "&offset=".$offset;
	curl_setopt($ch, CURLOPT_URL, "https://biusocialsciences.eu.qualtrics.com/API/v3/distributions?surveyId=".$surveyID.$offset_text);
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
			echo $distr["id"].",";
			echo $distr["requestStatus"].",";
			echo $distr["requestType"].",";
			echo $distr["sendDate"].",";
			echo $distr["surveyLink"]["expirationDate"].",";
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

	$offset = "";
	if ($arr_result["result"]["nextPage"] != "")
		$offset = str_replace("https://biusocialsciences.eu.qualtrics.com/API/v3/distributions?surveyId=".$surveyID."&offset=", "", $arr_result["result"]["nextPage"]);
}

curl_close ($ch);
?>
