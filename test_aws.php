<?
$ts = 1645395255628/1000;
$hour = date("G", $ts);
$minute = $hour*60 + intval(date("i", $ts));
echo $hour."|".$minute;
?>
