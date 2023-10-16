<?php
chdir(dirname(__FILE__));
$clog_file = "cron_log.log";

$mk_bd = fopen($clog_file,"a") or exit("Невозможно открыть файл!");
flock($mk_bd,LOCK_EX);
fwrite($mk_bd,"\n-- Cron for xp_aws.php started at ".date("d/m/Y H:i")." --");
flock($mk_bd,LOCK_UN);
fclose($mk_bd);

require "aws-autoloader.php";
require "config.php";

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
// use Aws\S3\Transfer;

class AWS
{
	private $s3;
	
	public function __construct($l, $p)
	{
		$this->s3 = S3Client::factory(array(
			'credentials' => array(
					'key'		=> $l,
					'secret'	=> $p,
									),
			'region'	=> "us-east-2",
			'version'	=> "latest",
		));
	}
	
	

	public function getFile($s3Path)
	{
		$vals = array();
		try
		{
			$result = $this->s3->getObject(array(
				'Bucket'		=> "physioq-files-cache-qa",
				'Key'			=> $s3Path,
			));
		}
		catch (S3Exception $e)
		{
			return Err::errWithInfo("ERR_S3_FAILED_TO_GET_FILE", $e->getMessage());
		}

		$vals["file_body"] = $result['Body'];
		$vals["content_type"] = (isset($result['ContentType']) ? $result['ContentType'] : "");

		return $vals;
	}

	public function doesFileExist($s3Path)
	{
		$vals = array();

		try
		{
			$result = $this->s3->doesObjectExist("physioq-files-cache-qa", $s3Path);
		}
		catch (S3Exception $e)
		{
			return Err::errWithInfo("ERR_S3_FAILED_TO_GET_FILE", $e->getMessage());
		}

		$vals["file_exists"] = $result;

		return $vals;
	}
	
	public function transferre($source, $dest)
	{
		$vals = array();

		try
		{
			// $s3Client = (new \Aws\Sdk)->createMultiRegionS3(['version' => 'latest']);

			// Where the files will be sourced from
			// $source = 's3://bucket';
			
			// Where the files will be transferred to
			// $dest = '/path/to/destination/dir';
			
			$manager = new \Aws\S3\Transfer($this->s3, $source, $dest);
			$manager->transfer();
				
		}
		catch (S3Exception $e)
		{
			return Err::errWithInfo("ERR_S3_FAILED_TO_GET_FILE", $e->getMessage());
		}

		return $vals;
	}

	public static function getBucketUrl()
	{
		return "https://s3.us-east-2.amazonaws.com/physioq-files-cache-qa/";
	}
}

// for test
// $date = new DateTime("2022-03-25");
$date = new DateTime();
for ($t = 1; $t < 4; $t++)
	{
	switch ($t) {
		case 1:
			$date->sub(new DateInterval('P1D'));
		break;
		case 2:
			$date->sub(new DateInterval('P2D'));
		break;
		case 3:
			$date->sub(new DateInterval('P3D'));
		break;
	}
	$dt = $date->format('Y-m-d');
	mysql_query("delete from physioqs where dt = '".$dt."'") or die(mysql_error());
	mysql_query("delete from physioqs_csv where dt = '".$dt."'") or die(mysql_error());
	$q1 = mysql_query("select * from users") or die(mysql_error());
	while ($arr1 = mysql_fetch_array($q1))
		{
		$user_id = $arr1["user_id"];
		$phys_username = $arr1["phys_username"];
		$phys_password = $arr1["phys_password"];
		$phys_root = $arr1["phys_root"];
		$locale = $arr["locale"];
		if ($locale == "")
			$locale = "Asia/Jerusalem";
		date_default_timezone_set($locale);
		$timezone = date_default_timezone_get();
		$userTimezone = new DateTimeZone($timezone);
		$gmtTimezone = new DateTimeZone('GMT');
		$myDateTime = new DateTime($dt, $gmtTimezone);
		$offset = $userTimezone->getOffset($myDateTime);
		if ($phys_username != "" && $phys_password != "")
			{
			echo "user_id: ".$user_id."<br />";
			$mk_bd = fopen($clog_file,"a") or exit("Невозможно открыть файл!");
			flock($mk_bd,LOCK_EX);
			fwrite($mk_bd,"\nSearching: ".$phys_root);
			flock($mk_bd,LOCK_UN);
			fclose($mk_bd);
			$q2 = mysql_query("select * from roles") or die(mysql_error());
			while ($arr2 = mysql_fetch_array($q2))
				{
				$surveyID = $arr2["SurveyID"];
				$physioqID = $arr2["physioqID"];
				$data = array();
				if ($physioqID != "")
					{
					echo "physioqID: ".$physioqID."<br />";
					$mk_bd = fopen($clog_file,"a") or exit("Невозможно открыть файл!");
					flock($mk_bd,LOCK_EX);
					fwrite($mk_bd,"\nFor: ".$surveyID." on ".$dt);
					flock($mk_bd,LOCK_UN);
					fclose($mk_bd);
					// $aws = new AWS("AKIASDYFREW2BOS4FY6O", "gp9gPn3aUYrwLP33qbp+yYuwuPp7lYpEs05680LJ");
					$aws = new AWS($phys_username, $phys_password);
					$file_path = "downloaded_aws";
					// $dt = "2021-11-29";

					$res = $aws->doesFileExist($phys_root."/".$physioqID."/date_files/".$dt.".zip");
					if ($res["file_exists"] == 1)
						{
						$res = $aws->transferre("s3://physioq-files-cache-qa/".$phys_root."/".$physioqID."/date_files", "/home/www/dev-survey.arlab.org.il/downloaded_aws");
						$mk_bd = fopen($clog_file,"a") or exit("Невозможно открыть файл!");
						flock($mk_bd,LOCK_EX);
						fwrite($mk_bd,"\nFile searching: ".$file_path."/".$dt.".zip");
						flock($mk_bd,LOCK_UN);
						fclose($mk_bd);
						$file = $file_path."/".$dt.".zip";
						echo "file: ".$file."<br />";
						$zipp = zip_open($file);
						if (is_resource($zipp))
							{
							while ($zip_entry = zip_read($zipp))
								{
								if (zip_entry_open($zipp, $zip_entry, "r"))
									{
									if (strpos(zip_entry_name($zip_entry), "_Garmin_rr.txt"))
										{
										preg_match('/[^.]+\/(\d+)\/[^.]+/', zip_entry_name($zip_entry), $matches);
										$pid = $matches[1];
										echo "participantID: ".$pid."<br />";
										// $fp = fopen($file_path."/".zip_entry_name($zip_entry),"w");
										$buf = "";
										$buf = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
										// if ($pid == "12345678")
											echo "SIZE: ".zip_entry_filesize($zip_entry)."<br />";
										$lines = explode(PHP_EOL, $buf);
										$mk_bd = fopen($clog_file,"a") or exit("Невозможно открыть файл!");
										flock($mk_bd,LOCK_EX);
										fwrite($mk_bd,"\nFile found: ".$file_path."/".zip_entry_name($zip_entry));
										fwrite($mk_bd,"\nPID: ".$pid);
										fwrite($mk_bd,"\nCount: ".count($lines) - 12);
										flock($mk_bd,LOCK_UN);
										fclose($mk_bd);
										$signal = "unix_epoch_in_miliseconds,timezone_at_sync,bbi";
										$start = 0;
										$oldminute = "999999999";
										$cnt = 0;
										echo "lines: ".(count($lines) - 12)."<br />";
										foreach ($lines as $line)
											{
											if ($start == 1 && $line != "") {
												$arr = explode(",", $line);
												$ts = floor($arr[0]/1000);
												$tz = $arr[1];
												$hour = date("G", $ts);
												$minute = $hour*60 + intval(date("i", $ts));
												// if we need to use offset???
												// $minute = $hour*60 + intval(date("i", $ts)) - $tz*60;
												// echo date("Y-m-d H:i:s", $ts).": ".$minute."/".$oldminute."(".$cnt.")<br />";
												// echo $hour.":".intval(date("i", $ts))." (".$minute.")|".$tz."|<br />";
												if ($oldminute < "999999999")
													{
													if ($oldminute <> $minute)
														{
														$data[$oldminute] = $cnt;
														// if ($pid == "12345678")
															// echo "COUNT:".$oldminute."|".$cnt."<br />";
														$cnt = 0;
													}
												}
												$cnt++;
												$oldminute = $minute;
											}
											if ($line == $signal)
												$start = 1;
										}
										$data[$minute] = $cnt;
										// echo "data for 12:16: ".$data[736]."<br />";
										// echo "<pre>";
										// print_r($data);
										// echo "</pre>";
										$today_file = "made_csv/".$pid."_".$dt.".csv";
										$mk_bd = fopen($today_file,"a") or exit("Wrong file!");
										flock($mk_bd,LOCK_EX);
										// echo "Offset: ".$offset."<br />";
										for ($i = 0; $i < 1440;$i++)
											{
											$csv[$i][0] = intval($i/60);
											$csv[$i][1] = $i - intval($i/60)*60;
											$csv[$i][2] = date("H:i", mktime(intval($i/60), $i - intval($i/60)*60, 0,$date->format('m'), $date->format('d'), $date->format('Y')) + $offset);
											// $hr = date("H", mktime(intval($i/60), $i - intval($i/60)*60, 0,$date->format('m'), $date->format('d'), $date->format('Y')) + $offset);
											// $mn = date("i", mktime(intval($i/60), $i - intval($i/60)*60, 0,$date->format('m'), $date->format('d'), $date->format('Y')) + $offset);
											$hr = date("H", mktime(intval($i/60), $i - intval($i/60)*60, 0,$date->format('m'), $date->format('d'), $date->format('Y')));
											$mn = date("i", mktime(intval($i/60), $i - intval($i/60)*60, 0,$date->format('m'), $date->format('d'), $date->format('Y')));
											$csv[$i][4] = date("Y-m-d H:i", mktime(intval($i/60), $i - intval($i/60)*60, 0, $date->format('m'), $date->format('d'), $date->format('Y')) + $offset);
											$mysql_dt = date("Y-m-d", mktime(intval($i/60), $i - intval($i/60)*60, 0, $date->format('m'), $date->format('d'), $date->format('Y')) + $offset);
											// $mysql_dttm = date("Y-m-d H:i", mktime(intval($i/60), $i - intval($i/60)*60, 0, $date->format('m'), $date->format('d'), $date->format('Y')) + $offset);
											$mysql_dttm = date("Y-m-d H:i", mktime(intval($i/60), $i - intval($i/60)*60, 0, $date->format('m'), $date->format('d'), $date->format('Y')));
											$csv[$i][5] = date("Y-m-d H:i", mktime(intval($i/60), $i - intval($i/60)*60, 0, $date->format('m'), $date->format('d'), $date->format('Y')));
											if ($data[$i] != "")
												$csv[$i][3] = $data[$i];
											else
												$csv[$i][3] = "";
											// if ($pid == "12345678")
												// echo $i."|".$hr."|".$mn."|".$csv[$i][3]."<br />";
											fwrite($mk_bd, $csv[$i][0].",".$csv[$i][1].",".$csv[$i][2].",".$csv[$i][3]."\n");
											// if ($csv[$i][3] != 0)
												// {
												mysql_query("insert into physioqs_csv (userID, surveyID, physioqID, participantID, dt, local_dt, local_dttm, hr, mn, bt)
												values ('".$user_id."', '".$surveyID."', '".$physioqID."', '".$pid."', '".$dt."', '".$mysql_dt."', '".$mysql_dttm."', '".$hr."', '".$mn."', '".$csv[$i][3]."')") or die(mysql_error());
											// }
										}
										flock($mk_bd,LOCK_UN);
										fclose($mk_bd);
										// to filter more than 20 bits only
										// $data = array_filter($data, function($v) {return ($v > 20);});
										$amount = count($data);
										$proportion = round(count($data)/14.40)/100;
										$m = round(array_sum($data)/count($data)*100)/100;
										$sd = round(standard_deviation($data)*100)/100;
										$min_val = min($data);
										$max_val = max($data);
										echo "Date: ".$dt."<br />";
										echo "N: ".$amount."<br />";
										echo "Proportion: ".$proportion."<br />";
										echo "M: ".$m."<br />";
										echo "SD: ".$sd."<br />";
										echo "Min: ".$min_val."<br />";
										echo "Max: ".$max_val."<br /><hr><br />";
										mysql_query("insert into physioqs (userID, surveyID, physioqID, participantID, dt, amount, proportion, m, sd, min_val, max_val)
										values ('".$user_id."', '".$surveyID."', '".$physioqID."', '".$pid."', '".$dt."', '".$amount."', '".$proportion."', '".$m."', '".$sd."', '".$min_val."', '".$max_val."')") or die(mysql_error());
										// echo '<pre>';
										// print_r($data);
										// echo '</pre>';
									}
								}
							}
						}
					}
				}
			}
		}
	}
}
mysql_close();
function std_deviation($arr)
    {
	$num_of_elements = count($arr);
	  
	$variance = 0.0;
	  
	// calculating mean using array_sum() method
	$average = array_sum($arr)/$num_of_elements;
	  
	foreach($arr as $i)
	{
		// sum of squares of differences between 
					// all numbers and means.
		$variance += pow(($i - $average), 2);
	}	  
	return (float)sqrt($variance/$num_of_elements);
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
function standard_deviation($aValues)
	{
    $fMean = array_sum($aValues) / count($aValues);
    //print_r($fMean);
    $fVariance = 0.0;
    foreach ($aValues as $i)
    {
        $fVariance += pow($i - $fMean, 2);

    }       
    $size = count($aValues) - 1;
    return (float) sqrt($fVariance)/sqrt($size);
}
?>