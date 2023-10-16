<?php
/*
$time1 = date("Y-m-d H:i:s");
$locale = "America/Los_Angeles";
date_default_timezone_set($locale);
echo gmdate_to_mydate($time1)."<br />";
echo mydate_to_gmdate($time1)."<br />";
echo make_time(strtotime($time1))."<br />";
$locale = "Europe/Moscow";
date_default_timezone_set($locale);
echo gmdate_to_mydate($time1)."<br />";
echo mydate_to_gmdate($time1)."<br />";
echo make_time(strtotime($time1))."<br />";
*/
$locale = "Europe/Moscow";
date_default_timezone_set($locale);
echo date("Y-m-d H:i:s")."<br />";
echo make_time(date("Y-m-d H:i:s"))."<br />";
echo gmdate_to_mydate(date("Y-m-d H:i:s"))."<br />";
echo mydate_to_gmdate(date("Y-m-d H:i:s"))."<br />";
function make_time($dt) {
	/* $dt must be in YYYY-mm-dd H:i:s format*/
	$timezone = date_default_timezone_get();
	$userTimezone = new DateTimeZone($timezone);
	// return gmdate("Y-m-d", strtotime($dt))."T".gmdate("H:i:s", strtotime($dt))."Z";
	// return date("Y-m-d", strtotime($dt))."T".date("H:i:s", strtotime($dt))."Z";
	$kolkata_date_time = new DateTime('now', $userTimezone);
	return date("Y-m-d", strtotime($dt))."T".date("H:i:s", strtotime($dt)).$kolkata_date_time->format('P');
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
