<?
ini_set("error_reporting", E_PARSE);

require "config.php";

$ch = curl_init();

$q1 = mysql_query("select * from users") or die(mysql_error());
while ($arr1 = mysql_fetch_array($q1))
	{
	$user_id = $arr1["user_id"];
	$username = $arr1["user_name"];
	print "----------- user ".$username.",  user_id = ".$user_id." -----------<br />";
	$token = $arr1["q_token"];
	$url_part = $arr1["user_url"];
	
	$url = "https://".$url_part.".qualtrics.com/API/v3/directories";
	print "Request: ".$url."<br />";
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

	$headers = array();
	$headers[] = "X-Api-Token: ".$token;
	$headers[] = "Content-Type: application/json";
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

	$result = curl_exec($ch);
		
	print_r($result);
	print "<br />";
}
curl_close ($ch);
?>