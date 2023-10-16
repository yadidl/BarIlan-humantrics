<?
require "config.php";

$DistributionID = $_REQUEST["DistributionID"];
$SurveyID = $_REQUEST["SurveyID"];
$RecipientID = $_REQUEST["RecipientID"];
$CreatorID = $_REQUEST["CreatorID"];
$CompletedDate = $_REQUEST["CompletedDate"];

$slct = mysql_query("select * from completed where DistributionID = '".$DistributionID."'");
if (mysql_num_rows($slct) == 0)
	mysql_query("insert into completed (SurveyID, RecipientID, DistributionID, CreatorID, CompletedDate) values ('".$SurveyID."', '".$RecipientID."', '".$DistributionID."', '".$CreatorID."', '".$CompletedDate."')");
else
	mysql_query("update completed set RecipientID = '".$RecipientID."', CompletedDate = '".$CompletedDate."' where DistributionID = '".$DistributionID."'");

if ($DistributionID != "")
	{
	mysql_query("update twilios set state = 'completed' where distr_id = '".$DistributionID."' or is_reminder_for = '".$DistributionID."'");
	mysql_query("update twilios_sms set state = 'completed' where distr_id = '".$DistributionID."' or is_reminder_for = '".$DistributionID."'");
}

$log = "Distr ".$topic." ".$DistributionID." (Survey ".$SurveyID.") for ".$RecipientID." (".$CreatorID.") was completed at ".$CompletedDate."\r\n";

$mk_bd = fopen("input".date("Ymd").".log","a") or exit("No file!");
flock($mk_bd,LOCK_EX);
fwrite($mk_bd,$log);
flock($mk_bd,LOCK_UN);
fclose($mk_bd);
?>