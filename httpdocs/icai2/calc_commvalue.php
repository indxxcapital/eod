<pre><?php
 date_default_timezone_set("Asia/Kolkata"); 
 ini_set('max_execution_time',60*60);
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;

include("core/function.php");

$date=date("Y-m-d",strtotime(date("Y-m-d"))-86400);
$pricedetails=selectrow((array("name","ticker_id","date","price")),"tbl_commodity_price",(array("date"=>$date)));
foreach($pricedetails as $key=>$value)
{
	$tickerdetails=selectrow((array("weight")),"tbl_commodity_indxx_ticker_temp",(array("ticker_id"=>$value['ticker_id'])));
	print_r($tickerdetails);	
}

$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);
mysql_close();
echo '<br>Page generated in '.$total_time.' seconds. ';



?>