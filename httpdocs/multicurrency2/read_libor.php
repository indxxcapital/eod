<pre><?php
 date_default_timezone_set("Asia/Kolkata"); 
 ini_set('max_execution_time',60*60);
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;

include("function.php");
//echo date('d-m-Y H:i:s');
//exit;
$date=date("Y-m-d",strtotime(date("Y-m-d"))-86400);
//$date='2014-01-10';



$filecontent=file_get_contents("../files/ca-input/libr.csv.".date("Ymd",strtotime($date)));
if($filecontent){
//$filecontent=file_get_contents("ftp://97.74.65.27/request.csv.20130905");
//print_r($filecontent);
$csvdatas=explode('\n',$filecontent);
//print_r($csvdatas);
$csvdata=explode("\n",$csvdatas[0]);
//print_r($csvdata);
//exit;

$i=20;
if(!empty($csvdata))
{
	//print_r($csvdata);
//	exit;
	while($i<(count($csvdata)-4))
	{	$security=explode("|",$csvdata[$i]);
				
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
				mail("dbajpai@indxx.com","Non Numeric Price for Libor file!","Price is not a number for ".$security[0]);
				$i++;	
			}
			}
		}




echo $i."=> Records Inserted";

}
else{
echo "Error File not exist";
mail("dbajpai@indxx.com","File Read Error!","libr.csv for today is not available ");
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
/*echo '<script>document.location.href="read_cashindex.php";</script>';
*/
?>

