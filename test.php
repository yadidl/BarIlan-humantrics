<?
ini_set("error_reporting", E_PARSE);

require "config.php";

$test_log = "test.log";

$exit = 0;

$userId = (int)$_REQUEST["userId"];

$slct = mysql_query("select * from users where user_id = ".$userId) or die(mysql_error());
if ($arr = mysql_fetch_assoc($slct))
	{
	
	$token = $arr["q_token"];
	$url = $arr["user_url"];
	$locale = $arr["locale"];
	if ($locale == "")
		$locale = "Asia/Jerusalem";
	date_default_timezone_set($locale);

	$surveyId = $_REQUEST["surveyId"];
	$maillistId = $_REQUEST["maillistId"];

	if ($surveyId != "" && $maillistId != "")
		{
		$ch = curl_init();
		$nextPage = "https://".$url.".qualtrics.com/API/v3/distributions?surveyId=".$surveyId."&mailingListId=".$maillistId."&offset=0";
		while ($nextPage != "")
			{
			curl_setopt($ch, CURLOPT_URL, $nextPage);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

			$headers = array();
			$headers[] = "X-Api-Token: ".$token;
			$headers[] = "Content-Type: application/json";
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

			$result = curl_exec($ch);
			
			$surveys = json_decode($result, 1, JSON_UNESCAPED_UNICODE);
			
			// print_r($surveys["result"]);
			// print "<br />-------------------------------------------------------<br />";
			
			$NumberOfDay = 0;
			$NumberInDay = 0;
			$prevNumberOfDay = "";
			$cnt = 0;
			foreach ($surveys["result"]["elements"] as $distrs)
				{
				// print_r($distrs);
				if ($distrs["recipients"]["mailingListId"] != "")
					{
					// if ($distrs["recipients"]["mailingListId"] == $maillistId)
					if ($distrs["recipients"]["mailingListId"] == $maillistId && $distrs["stats"]["sent"] == 1 && date("Y-m-d H:i:s", strtotime($distrs["sendDate"])) < date("Y-m-d H:i:s"))
						{
						// echo "<span title=\"".date("Y-m-d H:i:s", strtotime($distrs["sendDate"]))."\">SendTime = ".date("H:i", strtotime($distrs["sendDate"]))."</span><br />";
						$NumberInDay++;
						if ($prevNumberOfDay != date("d", strtotime($distrs["sendDate"])))
							{
							$prevNumberOfDay = date("d", strtotime($distrs["sendDate"]));
							$NumberOfDay++;
							$NumberInDay = 1;
						}
						$MaxDays = $NumberOfDay;
						$MaxInDays[$NumberOfDay] = $NumberInDay;
						$items[$cnt]["SendDate"] = date("Y-m-d", strtotime($distrs["sendDate"]));
						$items[$cnt]["SendTime"] = date("H:i", strtotime($distrs["sendDate"]));
						$items[$cnt]["NumberOfDay"] = $NumberOfDay;
						$items[$cnt]["NumberInDay"] = $NumberInDay;
						$items[$cnt]["distrId"] = $distrs["id"];
						$cnt++;
						// exit();
					}
				}
			}
			$nextPage = "";
			if ($surveys["result"]["nextPage"] != "")
				$nextPage = $surveys["result"]["nextPage"];
		}
		foreach ($items as $item)
			{
			// echo "SendDate=".$item["SendDate"];
			// echo "MaxDays=".$MaxDays;
			// echo "MaxInDays=".$MaxInDays[$item["NumberOfDay"]];
			// echo "SendTime=".$item["SendTime"]."&NumberOfDay=".($MaxDays - $item["NumberOfDay"] + 1)."&NumberInDay=".($MaxInDays[$item["NumberOfDay"]] - $item["NumberInDay"] + 1);
			// echo "<br />";
			$exit = 1;
		}
		$item = $items[0];
		// echo "!".$locale."!";
		// echo "SendTime=".$item["SendTime"]."&NumberOfDay=".($MaxDays - $item["NumberOfDay"] + 1)."&NumberInDay=".($MaxInDays[$item["NumberOfDay"]] - $item["NumberInDay"] + 1)."&distributionId=".$item["distrId"];
		echo "SendTime=".$item["SendTime"]."&NumberOfDay=".($MaxDays - $item["NumberOfDay"] + 1)."&NumberInDay=".($MaxInDays[$item["NumberOfDay"]] - $item["NumberInDay"] + 1)."&distributionId=".$item["distrId"];

		$mk_bd = fopen($test_log,"a") or exit("Невозможно открыть файл!");
		flock($mk_bd,LOCK_EX);
		fwrite($mk_bd, "\n--new request: user_id=".$userId."&surveyId=".$surveyId."&maillistId=".$maillistId.", result: SendTime=".$item["SendTime"]."&NumberOfDay=".($MaxDays - $item["NumberOfDay"] + 1)."&NumberInDay=".($MaxInDays[$item["NumberOfDay"]] - $item["NumberInDay"] + 1)."&distributionId=".$item["distrId"]."--");
		flock($mk_bd,LOCK_UN);
		fclose($mk_bd);

		if ($exit == 0)
			echo "No distrs sent yet!";
	}
	else
		echo "Please, provide surveyId and contact_id!";

	curl_close ($ch);
}
else
	echo "Please, provide userId!";
?>