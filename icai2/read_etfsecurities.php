<pre><?php
// date_default_timezone_set("Asia/Kolkata"); 
 ini_set('max_execution_time',60*60);
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;

include("core/function.php");

$date=date("Y-m-d");


$filecontent=file_get_contents("../files/ca-input/etfssecurities.csv.".date("Ymd",strtotime($date)));
if($filecontent){

$csvdatas=explode('\n',$filecontent);
//print_r($csvdatas);
$csvdata=explode("\n",$csvdatas[0]);


$i=20;
$insert=0;
if(!empty($csvdata))
{
	//print_r($csvdata);
//	exit;
	while($i<(count($csvdata)-4))
	{	$security=explode("|",$csvdata[$i]);
	
			$tickeridres=mysql_query("select id from tbl_commodity_ticker where name like '".$security[0]."'");
			$tickerid=mysql_fetch_assoc($tickeridres);
			//print_r($tickerid);
				
			$data['name']="'".$security[0]."'";
			$data['status']="'1'";
			$data['price']="'".$security[3]."'";
			$data['date']="'".$date."'";
			$data['ticker_id']="'".$tickerid['id']."'";
	if(is_numeric($security[3]))
			{
			qry_insert('tbl_commodity_price',$data);
			$insert++;
			$i++;
			}
			
			else
			{
				mail("dbajpai@indxx.com,jsharma@indxx.com","Non Numeric Price for Commodity!","Price is not a number for ".$security[0]);
				$i++;
			}
		}
				
}




echo $insert."=> Records Inserted";

}
else{
echo "Error File not exist";
mail("dbajpai@indxx.com,jsharma@indxx.com","File Read Error!","etfssecurities.csv for today is not available ");
exit;
}
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);

saveProcess(3);
mysql_close();
echo '<br>Page generated in '.$total_time.' seconds. ';


//exit;
echo '<script>document.location.href="http://97.74.65.118/icai2/index.php?module=replacecommodity";</script>';

?>

