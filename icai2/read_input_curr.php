<pre><?php

$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;

include("function.php");

$date=date("Y-m-d",strtotime(date("Y-m-d")));




$filecontent=file_get_contents("../webtest2/curr1.csv.".date("Ymd",strtotime($date)));
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
		
			if($key>20 && $key<23)
			{
					$security=explode("|",$securities);
				
			
			//$data['isin']="'".$security[6]."'";
			$data['price']="'".$security[3]."'";
			$data['currency']="'".$security[4]."'";
			$data['date']="'".$date."'";
			
			$currency=selectrow(array('id'),'tbl_currency',array('localsymbol'=>$security[4]));
			$data['curr_id']="'".$currency[0]['id']."'";
			qry_insert('tbl_curr_prices',$data);
		//echo "<br>";	//$query="insert into tbl_prices_local (isin,price,curr,date) values ('".$isin."','".$price."','".$currency."','".$date."');";	
			//mysql_query($query);
			$i++;
			}
		}
}



echo $i."=> Records Inserted";

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

