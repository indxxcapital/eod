<pre><?php
 date_default_timezone_set("Asia/Kolkata"); 

$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;

include("function.php");
$date=date("Y-m-d",strtotime(date('Ymd'))-86400);
//$date='2013-11-04';

$filecontent=file_get_contents("../files/ca-input/multicurr.csv.".date("Ymd",strtotime($date)));
if($filecontent){
//$filecontent=file_get_contents("ftp://97.74.65.27/request.csv.20130905");
//print_r($filecontent);
$csvdatas=explode('\n',$filecontent);
//print_r($csvdatas);
$csvdata=explode("\n",$csvdatas[0]);
//print_r($csvdata);
//exit;
$i=0;
if(!empty($csvdata))
{
		foreach($csvdata as $key=>$securities)
		{
		
			if($key>20 && $key<86)
			{
			//print_r($securities);
			$security=explode("|",$securities);
			//print_r($security);
			$data['ticker']="'".$security[0]."'";
			$data['isin']="'".$security[6]."'";
			$data['price']="'".$security[3]."'";
			$data['curr']="'".$security[4]."'";
			$data['date']="'".$date."'";
			
			//$currency=selectrow(array('id'),'tbl_currency',array('localsymbol'=>$security[4]));
			//$data['curr']="'".$currency[0]['id']."'";
			qry_insert('tbl_prices_local_curr',$data);
		//echo "<br>";	//$query="insert into tbl_prices_local (isin,price,curr,date) values ('".$isin."','".$price."','".$currency."','".$date."');";	
			//mysql_query($query);
			$i++;
			}
		}
}



echo $i."=> Records Inserted";

}
else{
echo "Error File not exist";
mail("dbajpai@indxx.com","File Read Error!","multicurr.csv. for today is not available ");
exit;
}
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);
mysql_close();
echo 'Page generated in '.$total_time.' seconds. ';

echo '<script>document.location.href="convertprice.php";</script>';

?>

