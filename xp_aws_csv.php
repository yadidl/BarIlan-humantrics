<?php
require "config.php";

$slct = mysql_query("select * from users where user_login = '".mysql_real_escape_string($_SESSION["s_login"])."' and user_password = '".mysql_real_escape_string($_SESSION["s_password"])."'") or die(mysql_error());
if (mysql_num_rows($slct) == 1)
	{
	$arr = mysql_fetch_assoc($slct);
	$uid = $arr["user_id"];
	$dt = $_REQUEST["dt"];
	$pnum = $_REQUEST["pnum"];
	$sid = $_REQUEST["sid"];

	header("Content-type: text/csv");
	header("Content-Disposition: attachment; filename=".$pnum."_".$dt.".csv");
	header("Pragma: no-cache");
	header("Expires: 0");

	// ini_set("display_errors", "1");
	// ini_set("display_startup_errors", "1");
	ini_set("error_reporting", E_PARSE);

	echo "hr,min,bbi,,";
	$slct1 = mysql_query("select * from physioqs where dt = '".mysql_real_escape_string($dt)."' and participantID = '".mysql_real_escape_string($pnum)."' and surveyID = '".$sid."'") or die(mysql_error());
	if ($arr1 = mysql_fetch_assoc($slct1))
		{
		echo "Date: ".$arr1["dt"].",";
		echo "N: ".$arr1["amount"].",";
		echo "Proportion: ".$arr1["proportion"].",";
		echo "M: ".$arr1["m"].",";
		echo "SD: ".$arr1["sd"].",";
		echo "Min: ".$arr1["min_val"].",";
		echo "Max: ".$arr1["max_val"]."\r\n";
	}
	// $slct1 = mysql_query("select * from physioqs_csv where userID = ".$uid." and local_dt = '".mysql_real_escape_string($dt)."' and participantID = '".mysql_real_escape_string($pnum)."' and surveyID = '".$sid."'") or die(mysql_error());
	$slct1 = mysql_query("select * from physioqs_csv where userID = ".$uid." and dt = '".mysql_real_escape_string($dt)."' and participantID = '".mysql_real_escape_string($pnum)."' and surveyID = '".$sid."'") or die(mysql_error());
	while ($arr1 = mysql_fetch_assoc($slct1))
		{
		echo $arr1["hr"].",";
		echo $arr1["mn"].",";
		echo $arr1["bt"]."\r\n";
	}
}
else
	echo "Wrong login!";
?>
