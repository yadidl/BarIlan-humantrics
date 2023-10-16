<?
require "config.php";

date_default_timezone_set('Asia/Jerusalem');

$sid = $_REQUEST["SmsSid"];
$state = $_REQUEST["SmsStatus"];
if ($sid != "" && $state != "") {
	mysql_query("update twilios set state = '".$state."' where sid = '".$sid."'");
	mysql_query("update twilios_sms set state = '".$state."' where sid = '".$sid."'");
}
else
	{
	?>
	<a href="#mid">to now</a><br /><br /><br />
	<?
	$slct = mysql_query("select * from twilios where send_time > DATE_SUB(NOW(), INTERVAL 3 DAY) and send_time < DATE_ADD(NOW(), INTERVAL 1 DAY) union select * from twilios_sms where send_time > DATE_SUB(NOW(), INTERVAL 3 DAY) and send_time < DATE_ADD(NOW(), INTERVAL 1 DAY) order by send_time") or die(mysql_error());
	while ($arr = mysql_fetch_assoc($slct))
		{
		if (gmdate_to_mydate($arr["send_time"]) > date("Y-m-d H:i:s") && $stop != 1)
			{
			$stop = 1;
			echo "<div id=\"mid\">&nbsp;</div>";
		}
		if (gmdate_to_mydate($arr["send_time"]) > date("Y-m-d H:i:s"))
			echo "<strong>";
		$color = "";
		if ($arr["state"] == "delivered")
			$color = "#009900";
		if ($arr["state"] == "read")
			$color = "green";
		if ($arr["state"] == "problem")
			$color = "red";
		$problem = "";
		if ($arr["state"] == "problem")
			$problem = $arr["sid"];
		?>
		<span style="color: <?=$color;?>"><?=$arr["send_time"];?> | <?=$arr["twilio_surveyID"];?> | <?=$arr["distr_id"];?> (<?=($arr["is_reminder_for"]!=""?"reminder for ".$arr["is_reminder_for"]:'main');?>) to <?=$arr["phone"];?> | <?=$arr["state"];?> <?=$problem;?></span><br />
		<?
		if (gmdate_to_mydate($arr["send_time"]) > date("Y-m-d H:i:s"))
			echo "</strong>";
	}
}	
/*
$json = json_decode(file_get_contents($file), JSON_UNESCAPED_UNICODE);

// print_r($json);

$newjson = json_encode($_REQUEST, JSON_UNESCAPED_UNICODE);

$mk_bd = fopen($file,"a") or exit("Невозможно открыть файл!");
flock($mk_bd,LOCK_EX);
fwrite($mk_bd,$newjson);
flock($mk_bd,LOCK_UN);
fclose($mk_bd);
*/
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
