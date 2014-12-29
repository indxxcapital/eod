<pre><?php
 date_default_timezone_set("Asia/Kolkata"); 
ini_set('max_execution_time',60*60);
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;

include("core/function.php");
delete_old_ca();
//exit;
 $date=date("Y-m-d",strtotime(date("Y-m-d"))-86400);
//echo $date;
//exit;
//$date=$_GET['date'];

$filecontent=file_get_contents("../files/ca-input/ca_test.csv.".date("Ymd",strtotime($date)));
//echo $filecontent;
//exit;
if($filecontent){
$csvdatas=explode('\n',$filecontent);
//print_r($csvdatas);
$csvdata=explode("\n",$csvdatas[0]);
//print_r($csvdata);
//exit;

$i=18;
$skipped=0;
$inserted=0;
$updated=0;
$empty=0;
$emptyRecords=array();
if(!empty($csvdata))
{
	//print_r($csvdata);
	//exit;
	while($i<(count($csvdata)-4))
	{
		$security=explode("|",$csvdata[$i]);
		//print_r($security);
		//exit;	
			$checkArray=array();
			
			$checkTickerArray=array();
			$data['status']="'1'";
			$data['identifier']="'".mysql_real_escape_string($security['0'])."'";
			$checkArray['identifier']=$security['0'];

			$data['company_id']="'".mysql_real_escape_string($security['1'])."'";
			$data['security_id']="'".mysql_real_escape_string($security['2'])."'";
			
			$data['rcode']="'".mysql_real_escape_string($security['3'])."'";
			$data['action_id']="'".mysql_real_escape_string($security['4'])."'";
			$checkArray['action_id']=$security['4'];
			$data['mnemonic']="'".mysql_real_escape_string($security['5'])."'";
			$checkArray['mnemonic']=$security['5'];
			$ca_field_id=selectrow(array('id'),'tbl_ca_subcategory',array('code'=>$security['5']));	
			
			$data['field_id']="'".mysql_real_escape_string($ca_field_id['0']['id'])."'";
			$data['company_name']="'".mysql_real_escape_string($security['7'])."'";
			
			$data['secid_type']="'".mysql_real_escape_string($security['8'])."'";
			$data['secid']="'".mysql_real_escape_string($security['9'])."'";
			$data['currency']="'".mysql_real_escape_string($security['10'])."'";
			
			$data['market_sector_desc']="'".mysql_real_escape_string($security['11'])."'";
			$data['bloomberg_unique_id']="'".mysql_real_escape_string($security['12'])."'";
			
			
			if($security['13']=='')
				$data['ann_date']='0000-00-00';
			else
				$data['ann_date']="'".date("Y-m-d",strtotime($security['13']))."'";
			
			$checkArray['ann_date']=str_replace("'","",$data['ann_date']);
			
				$security['14']=str_replace('N.A.',"",$security['14']);		
			if($security['14']==''  )
				$data['eff_date']='0000-00-00';
			else
				$data['eff_date']="'".date("Y-m-d",strtotime($security['14']))."'";
				
			$checkArray['eff_date']=str_replace("'","",$data['eff_date']);	
			
			
			if($security['15']=='')
				$data['amd_date']='0000-00-00';
			else
				$data['amd_date']="'".date("Y-m-d",strtotime($security['15']))."'";
				
			
			//$checkArray['amd_date']=str_replace("'","",$data['amd_date']);
			
			
			
			$data['bloomberg_global_id']="'".mysql_real_escape_string($security['16'])."'";
			$data['bl_global_company_id']="'".mysql_real_escape_string($security['17'])."'";
			$data['bl_security_id_num']="'".mysql_real_escape_string($security['18'])."'";
			$data['feed_source']="'".mysql_real_escape_string($security['19'])."'";
			$data['nfields']="'".mysql_real_escape_string($security['20'])."'";

			
		//	$checkTickerArray['ticker']=$security['0'];;
			//$tickerid=selectrow(array('id'),'tbl_indxx_ticker',$checkTickerArray);	
			//$currency=selectrow(array('identifier','company_id','security_id','rcode','action_id','mnemonic','flag','company_name','secid_type','secid','currency','market_sector_desc','bloomberg_unique_id','ann_date','eff_date','amd_date','bloomberg_global_id','bl_global_company_id','bl_security_id_num','feed_source','nfields'),'tbl_ca',array('localsymbol'=>$security[4]));
			
			//$data['ticker_id']=$tickerid['0']['id'];		
		
			
		if($ids=selectrow(array('id','amd_date'),'tbl_ca',$checkArray))
		{
			if($ids['0']['amd_date']!=str_replace("'","",$data['amd_date']))
			{
				qry_update('tbl_ca',$data,array('id'=>$ids['0']['id'],'action_id'=>$security['4']));
				qry_delete('tbl_ca_values',array('ca_id'=>$ids['0']['id'],'ca_action_id'=>$security['4']));
				
				$relatedindxx=getIndxx($checkArray['identifier']);
	
			
				
				 $num_fields=$security['20'];
				 
					for($k=1;$k<($num_fields*2)+1;$k=$k+2)
				{
				//echo ($k+20)."<br>";
						$field_id=selectrow(array('id'),'tbl_ca_action_fields',array('field_name'=>$security[$k+20]));	
				$data2['ca_id']="'".$ids['0']['id']."'";
				$data2['ca_action_id']=$data['action_id'];
				$data2['field_name']="'".$security[$k+20]."'";
				$data2['field_id']="'".$field_id['0']['id']."'";
				$data2['field_value']="'".mysql_real_escape_string($security[$k+20+1])."'";
				if($security[$k+21]!='N.A.' && $security[$k+21]!='' && $security[$k+21]!=' ')
				qry_insert('tbl_ca_values',$data2);	
				
				}
				
				$updated++;		
			}
			else
			{
				$skipped++;	
			}
			
		}
		else
		{
			if($checkArray['mnemonic']=='' || $checkArray['ann_date']=='0000-00-00' || $checkArray['eff_date']=='0000-00-00'  )
			{
				$empty++;
				$emptyRecords=$data;
			}
			else
			{
		//print_r($data);

				$ca_id= qry_insert('tbl_ca',$data);	
				// $num_fields=0;
				  $num_fields=$security['20'];
				echo "<br>";
				//echo ($num_fields*2)+1;
				
			
			
				
				for($k=1;$k<($num_fields*2)+1;$k=$k+2)
				{
				//echo ($k+20)."<br>";
					$field_id=selectrow(array('id'),'tbl_ca_action_fields',array('field_name'=>$security[$k+20]));	
				$data2['ca_id']="'".$ca_id."'";
				$data2['ca_action_id']=$data['action_id'];
				$data2['field_name']="'".$security[$k+20]."'";
				$data2['field_id']="'".$field_id['0']['id']."'";
				$data2['field_value']="'".mysql_real_escape_string($security[$k+20+1])."'";
							if($security[$k+21]!='N.A.' && trim($security[$k+21])!=''  && $security[$k+21]!=' ')
							qry_insert('tbl_ca_values',$data2);	
				
				}
			
				
	//			exit;
			
				//echo "New Record";
				
								
				
				//print_r($data);
				$inserted++;
				
				
				
				
				
			}
		}
		
		//echo "<br>";	$query="insert into tbl_prices_local (isin,price,curr,date) values ('".$isin."','".$price."','".$currency."','".$date."');";	
			//mysql_query($query);
			
			$i++;
		
	}
	
}


if($empty!=0)
{
	echo "Following records are empty!!!<br>";
	//print_r($emptyRecords);	
}

echo "<br>Total ".$inserted." records inserted , ".$skipped." records skipped and !!!!".$updated." records updated!!!<br>"; 	
//echo $i."=> Records Inserted<br>";

}
else{
echo "Error File not exist";
mail("dbajpai@indxx.com","File Read Error!","corporate actions file not available for today . ");
exit;
}

$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);
mysql_close();
echo 'Page generated in '.$total_time.' seconds. ';
/*echo '<script>document.location.href="http://97.74.65.118/icai/checkcurrency.php";</script>';
*/echo '<script>document.location.href="http://97.74.65.118/icai/index.php?module=replaceindex";</script>';



?>

