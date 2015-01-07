<pre><?php
 date_default_timezone_set("Asia/Kolkata"); 

$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;

include("function.php");

$date=date("Y-m-d",strtotime(date("Y-m-d"))-86400);
//$date='2014-01-24';

//$currency=getCurrencyNew($date);
//print_r($currency);
//exit;
$final_price_array=array();
$indexarray=array();
$emailsids='';
$dbuseremailsids='';
$indxx=selectrow(array('id','name','code','curr'),'tbl_indxx');
if(!empty($indxx))
{
foreach($indxx as $key=>$index)
{
//print_r($index);

 $query="SELECT it.isin,it.ticker,(select price from tbl_prices_local_curr pf where pf.isin=it.isin  and pf.date='".$date."') as localprice ,(select curr from tbl_prices_local_curr pf where pf.isin=it.isin  and pf.date='".$date."') as local_currency,it.curr as ticker_currency FROM `tbl_indxx_ticker` it where it.indxx_id='".$index['id']."'";
$res=mysql_query($query);
if(mysql_num_rows($res)>0)
{$i=0;
	
		while($priceRow=mysql_fetch_assoc($res))
		{
		//	print_r($priceRow);
			
			
			$currencyPrice=0;
		//print_r($priceRow);
		//exit;
			if($priceRow['local_currency']!=$priceRow['ticker_currency'])
			{
				
				echo "Currency Mismatch at : ".$priceRow['ticker'];
				//exit;	
				$indexarray[$index['id']]=$priceRow['ticker'];				
			}
			
			if($index['curr']!=$priceRow['local_currency'])
			{
				
			//echo "Conversion Required for ".$index['curr'].$priceRow['local_currency']."<br>";
			
			 $cfactor=getPriceforCurrency($index['curr'].$priceRow['local_currency'],$date);
			$currencyPrice=$cfactor;
			
			//echo "<br>";
			//$final_price_array[$index['id']][$i]['price']=number_format($priceRow['localprice']/$cfactor,50,'.','');
			if(strcmp($index['curr'].$priceRow['local_currency'],strtoupper($index['curr'].$priceRow['local_currency']))==0)
			{$final_price_array[$index['id']][$i]['price']=$priceRow['localprice']/$cfactor;
			}
			else{
				//echo "Got it<br>";
				$final_price_array[$index['id']][$i]['price']=$priceRow['localprice']/($cfactor*100);
				}
			}else
			{
				$currencyPrice=1;
			$final_price_array[$index['id']][$i]['price']=$priceRow['localprice'];
			}	
		
		
		/*
		if($index['curr']!=$priceRow['local_currency'])
		{
		$final_price_array[$index['id']][$i]['price']=number_format($priceRow['localprice']/$currency[$priceRow['local_currency']],50,'.','');
		}
		else{
		$final_price_array[$index['id']][$i]['price']=$priceRow['localprice'];
		}*/
		$final_price_array[$index['id']][$i]['isin']=$priceRow['isin'];
		$final_price_array[$index['id']][$i]['localprice']=$priceRow['localprice'];
		$final_price_array[$index['id']][$i]['currencyfactor']=$currencyPrice;
		$i++;
		
		}

}

}

$indexarray=array_unique($indexarray);
foreach($indexarray as $keyindex=>$valueindex)
{
	$indexnamequery="select name from tbl_indxx where id='".$keyindex."'";
	$indexnameres=mysql_query($indexnamequery);
	$indexname=mysql_fetch_assoc($indexnameres);
	//print_r($indexname);
	$usersemailquery="select name,email from tbl_ca_user where status='1'";
	$useremailres=mysql_query($usersemailquery);
	while($users=mysql_fetch_assoc($useremailres))
	{
		if(!empty($users['email']))
		{
			$emailsids.=$users['email'].",";	
		}
	}
		$emailsids=substr($emailsids,0, -1);
		//echo $emailsids;
		if(!empty($emailsids))	
		{
			
			$sub='ICAI Currency Mismatch Notification';
			$msg='Hi,<br>There is a currency mismatch in index <strong>'.$indexname['name'].'</strong> for security <strong>'.$valueindex.'</strong>.<br>Thanks';
					
					// To send HTML mail, the Content-type header must be set
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			
			
			// Additional headers
			//$headers .= 'To: '.$users['name'].' <'.$users['email'].'>'. "\r\n";
			$headers .= 'From: Indexing <indexing@indxx.com>' . "\r\n";
					
					
					if(mail($emailsids,$sub,$msg,$headers))
					{
						echo "Mail sent ";	
					}
					
		
	}
		
	$dbusersemailquery="select name,email from tbl_database_users where status='1'";
	$dbuseremailres=mysql_query($dbusersemailquery);
	while($dbusers=mysql_fetch_assoc($dbuseremailres))
	{
		if(!empty($dbusers['email']))
		{
			$dbuseremailsids.=$dbusers['email'].",";	
		}
	}
	$dbuseremailsids=substr($dbuseremailsids,0, -1);
		//$dbuseremailsids[]=$dbusers['email'];
		if(!empty($dbuseremailsids))	
		{
			// $dbuseremailsids	=implode(',',$dbuseremailsids);
			$sub='ICAI Currency Mismatch Notification';
			$msg='Hi,<br>There is a currency mismatch in index <strong>'.$indexname['name'].'</strong> for security <strong>'.$valueindex.'</strong>.<br>Thanks';
					
			// To send HTML mail, the Content-type header must be set
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			
			// Additional headers
			//$headers .= 'To: '.$dbusers['name'].' <'.$dbusers['email'].'>'. "\r\n";
			$headers .= 'From: Indexing <indexing@indxx.com>' . "\r\n";
					
					
					if(mail($dbuseremailsids,$sub,$msg,$headers))
					{
						echo "Mail sent ";	
					}
				
		}

		//echo "update tbl_indxx set status='0' where id='".$keyindex."'";
		mysql_query("update tbl_indxx set status='0' where id='".$keyindex."'");	
	
}

//exit;
}



//print_r($final_price_array);
//exit;
if(!empty($final_price_array))
{
foreach($final_price_array as $indxx_id =>$ival)
{
if(!empty($ival))
{
	foreach($ival as $tempKey=>$ivalue)
	{
$fpquery="INSERT into tbl_final_price  (indxx_id,isin,date,price,localprice,currencyfactor) values ('".$indxx_id."','".$ivalue['isin']."','".$date."','".$ivalue['price']."','".$ivalue['localprice']."','".$ivalue['currencyfactor']."') ";
mysql_query($fpquery);

	}
}

}
}


$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);

echo 'Page generated in '.$total_time.' seconds. ';
saveProcess(2);
mysql_close();
echo '<script>document.location.href="convertprice_temp.php";</script>';

?>

