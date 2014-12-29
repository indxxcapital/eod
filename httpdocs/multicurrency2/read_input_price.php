<pre><?php
 date_default_timezone_set("Asia/Kolkata"); 
ini_set('max_execution_time',60*60);
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;

include("function.php");
 $date=date("Y-m-d",strtotime(date('Ymd'))-86400);
//$date='2014-01-10';
$filecontent=file_get_contents("../files/ca-input/multicurr.csv.".date("Ymd",strtotime($date)));
if($filecontent){
//$filecontent=file_get_contents("ftp://97.74.65.27/request.csv.20130905");
//print_r($filecontent);
$csvdatas=explode('\n',$filecontent);
//print_r($csvdatas);
$csvdata=explode("\n",$csvdatas[0]);

$start=$_GET['id'];
$limit=100;
$pagecount=count($csvdata)-4;

if(!$start)
{
	$start=23;	
}
while($start<$limit+($_GET['id'])   && $start<$pagecount)
{
	
	$security=explode("|",$csvdata[$start]);
		//	print_r($security);
		//	exit;
			$data['ticker']="'".$security[0]."'";
			$data['isin']="'".$security[6]."'";
			$data['price']="'".round($security[3],2)."'";
			$data['curr']="'".$security[4]."'";
			$data['date']="'".$date."'";
			
			
			if(is_numeric($security[3]))
			{
				$price=selectrow(array('id'),'tbl_prices_local_curr',array('isin'=>$security[6],'date'=>$date));
			if(empty($price))
			qry_insert('tbl_prices_local_curr',$data);
			
			}else{
			
			echo $security[3]."Non Numeric<br>";
			mail("dbajpai@indxx.com","Non Numeric Price in price file!","Price is not a number for ".$security[0]);	
			
			}
	
	
	$start++;
}

if($start>=$pagecount)
{
	saveProcess(2);
		webopen("convertprice.php");
/*echo '<script>document.location.href="convertprice.php";</script>';
*/}
else
{
	webopen("read_input_price.php?id=".($start)."");
/*echo '<script>document.location.href="read_input_price.php?id='.($start).'";</script>';		
*/}
}
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);
mysql_close();
echo 'Page generated in '.$total_time.' seconds. ';
/*
echo '<script>document.location.href="convertprice.php";</script>';
*/
?>