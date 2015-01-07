<pre><?php
echo '<script>document.location.href="read_input_price.php";</script>';
exit;
date_default_timezone_set('Asia/Kolkata');
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;
include('dbconfig.php');
//echo date("Y-m-d H:i:s");
//exit;
$date=date("Y-m-d",strtotime(date("Y-m-d"))-86400);
//$date='2013-12-13';

//echo "../files/cm".date("d",strtotime($date)).strtoupper(date("MY",strtotime($date)))."bhav.csv";
//exit;
$string=file_get_contents("../files/cm".date("d",strtotime($date)).strtoupper(date("MY",strtotime($date)))."bhav.csv");
//$string=file_get_contents("../files/cm12SEP2013bhav.csv");
if($string){

$data=explode("\n",$string);
$prices=array();
if(!empty($data))
{
foreach($data as $key=>$value)
{
	if ($key>0	)
{	
$data2=explode(',',$value);
$prices[$data2['12']]=$data2;
}
}
}
//print_r($prices);
//exit;
$insert=0;
$update=0;
$isinarray=array();
$query="select distinct(isin) as isin from tbl_indxx_ticker where 1=1 union select distinct(isin) as isin from tbl_indxx_ticker_temp where status='1' ";
$res=mysql_query($query);
if($res)
{$i=0;
	while($row=mysql_fetch_assoc($res))
	{

	if(array_key_exists($row['isin'],$prices))
			{	
			$checkpricequery="Select * from tbl_prices_local_curr where date ='".$date."' and isin ='".$row['isin']."'";
			$checkRes=mysql_query($checkpricequery);
			if(mysql_num_rows($checkRes)==0)
			{
			$insertQuery="Insert into tbl_prices_local_curr set  date ='".$date."',isin='".$row['isin']."',ticker='".$row['ticker']."',price='".$prices[$row['isin']][5]."',curr='INR'";
			mysql_query($insertQuery);
			}
			
			}

}

}
}else{
echo "Error Bhavcopy File not exist";
mail("dbajpai@indxx.com","File Read Error!","Bhavcopy for today is not available ");
exit;
}

$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);
mysql_close();
echo 'Page generated in '.$total_time.' seconds.';
echo '<script>document.location.href="read_input_price.php";</script>';
?>