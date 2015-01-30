<pre><?php
// date_default_timezone_set("Asia/Kolkata"); 

$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;

include("function.php");

$date=date("Y-m-d");
//$date='2014-12-30';



 //$query="SELECT it.isin,it.ticker,(select price from tbl_prices_local_curr pf where pf.isin=it.isin  and pf.date='".$date."') as localprice ,(select curr from tbl_prices_local_curr pf where pf.isin=it.isin  and pf.date='".$date."') as local_currency,it.curr as ticker_currency FROM `tbl_indxx_ticker` it where it.indxx_id='".$index['id']."'";
 
  $query="SELECT distinct it.ticker,it.isin, pf.price as  localprice ,pf.curr as local_currency,it.curr as ticker_currency FROM `tbl_indxx_ticker` it left join tbl_prices_local_curr pf on pf.isin=it.isin   where   pf.date='".$date."'
  union SELECT distinct itt.ticker,itt.isin, pff.price as  localprice ,pff.curr as local_currency,itt.curr as ticker_currency FROM `tbl_indxx_ticker_temp` itt
 left join tbl_prices_local_curr pff on pff.isin=itt.isin 
  where   pff.date='".$date."'";
 //exit;
 
 $dataArray=array();
$res=mysql_query($query);
if(mysql_num_rows($res)>0)
{$i=2;
$dataArray[1]['ticker']='ticker';
$dataArray[1]['isin']='isin';
$dataArray[1]['localcurrency']='localcurrency';
$dataArray[1]['localprice']='localprice';

$dataArray[1]['convertedprice']='convertedprice';
	$dataArray[1]['currencyfactor']='currencyfactor';
		while($priceRow=mysql_fetch_assoc($res))
		{
		//	print_r($priceRow);
		//exit;	
				
		 $dataArray[$i]['ticker']=$priceRow['ticker'];
		 $dataArray[$i]['isin']=$priceRow['isin'];
		 $dataArray[$i]['localcurrency']=$priceRow['local_currency'];
		 $dataArray[$i]['localprice']=$priceRow['localprice'];
		
			$currencyPrice=0;
		//print_r($priceRow);
		//exit;
			if($priceRow['local_currency']!=$priceRow['ticker_currency'])
			{
				
				echo "Currency Mismatch at : ".$priceRow['ticker'];
				//exit;	
				$indexarray[$index['id']]=$priceRow['ticker'];				
			}
			
			if("USD"!=$priceRow['local_currency'])
			{//print_r($priceRow);
		//exit;
				
			//echo "Conversion Required for ".$index['curr'].$priceRow['local_currency']."<br>";
			
			 $cfactor=getPriceforCurrency("USD".$priceRow['local_currency'],$date);
			$currencyPrice=$cfactor;
			//exit;
			//echo "<br>";
			//$final_price_array[$index['id']][$i]['price']=number_format($priceRow['localprice']/$cfactor,50,'.','');
			if(strcmp("USD".$priceRow['local_currency'],strtoupper("USD".$priceRow['local_currency']))==0)
			{//$final_price_array[$index['id']][$i]['price']=$priceRow['localprice']/$cfactor;
			 $dataArray[$i]['price']=$priceRow['localprice']/$cfactor;
			
			}
			else{
				//echo "Got it<br>";
			//	$final_price_array[$index['id']][$i]['price']=$priceRow['localprice']/($cfactor*100);
				
				 $dataArray[$i]['price']=$priceRow['localprice']/($cfactor*100);
				}
			}else
			{
				$currencyPrice=1;
		 $dataArray[$i]['price']=$priceRow['localprice'];
			}
		 $dataArray[$i]['currencyfactor']=$currencyPrice;
		$i++;
				
			}
		
		/*
		if($index['curr']!=$priceRow['local_currency'])
		{
		$final_price_array[$index['id']][$i]['price']=number_format($priceRow['localprice']/$currency[$priceRow['local_currency']],50,'.','');
		}
		else{
		$final_price_array[$index['id']][$i]['price']=$priceRow['localprice'];
		}*/
		 
		
		}





//echo $totalindexes."<=".$page;



//print_r($dataArray);
//exit;
		$backup_folder = "../files/output/";
		if (!file_exists($backup_folder))
			mkdir($backup_folder, 0777, true);
		

	$fp = fopen($backup_folder. 'converted_price-'.$date.'.csv', 'w');

foreach ($dataArray as $fields) {
    fputcsv($fp, $fields);
}

fclose($fp);	




$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);

echo 'Page generated in '.$total_time.' seconds. ';
//saveProcess(2);
mysql_close();
/*echo '<script>document.location.href="convertprice_temp.php";</script>';
*/
?>

