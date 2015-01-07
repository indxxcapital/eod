<pre>
<?php

// date_default_timezone_set("Asia/Kolkata"); 
ini_set('max_execution_time',60*60);

$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;

include("function.php");

/* TODO: Fix this in LIVE setup */
//$date=date("Y-m-d");
$date='2014-08-27';

//$filecontent = file_get_contents("../bloomberg-input2/libr_sl.csv.".date("Ymd", strtotime($date)));
$filecontent= file_get_contents("../files/input/libr-header.csv.". date("Ymd", strtotime($date)));

if($filecontent)
{
	$csvdatas = explode('\n',$filecontent);
	//print_r($csvdatas);
	$csvdata = explode("\n",$csvdatas[0]);
	//print_r($csvdata);
	//exit;

	$i = 20;
	if(!empty($csvdata))
	{
		//print_r($csvdata);
		//	exit;
		
		while($i < (count($csvdata) - 4))
		{	
			$security = explode("|",$csvdata[$i]);					
			//	print_r($security);
				
			$data['ticker']="'".$security[0]."'";
			$data['price']="'".$security[3]."'";
			$data['date']="'".$date."'";
		
			if(is_numeric($security[3]))
			{
				qry_insert('tbl_libor_prices',$data);
				$i++;
			}
			else
			{
				mail("dbajpai@indxx.com","Softlayer - Non Numeric Price for Libor file!","Price is not a number for ".$security[0]);
				$i++;	
			}
		}
	}

	echo $i."=> Records Inserted";
}
else
{
	echo "Error File not exist";
	mail("dbajpai@indxx.com","Softlayer - File Read Error!","libr.csv for today is not available - ".date("Y-m-d"));
	exit;
}

$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);

echo 'Page generated in '.$total_time.' seconds. ';

saveProcess(2);
mysql_close();
webopen("read_cashindex.php");
/*echo '<script>document.location.href="read_cashindex.php";</script>'; */
?>