<pre><?php
 //date_default_timezone_set("Asia/Kolkata"); 
ini_set('max_execution_time',60*60);
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;

include("core/function.php");

//delete_old_ca();

//
if($_GET['counter'])
{
$counter=$_GET['counter'];
}else{
$counter=0;
delete_old_ca();
}

$perReq=100;


$total =total_ca_lines();

if($counter*$perReq>=$total)
{
	saveProcess();
	/*echo '<script>document.location.href="http://97.74.65.118/icai2/checkcurrency.php";</script>';
	*/
}else{



if($counter)
$startLimit=($counter*$perReq);
else
$startLimit=$counter*$perReq;

//echo $startLimit;



//echo $startLimit;
$query="Select id,value from tbl_ca_plain_txt  limit ".$startLimit.",".$perReq."";
$res= mysql_query($query);

if(mysql_num_rows($res)>0)
{

while($row=mysql_fetch_assoc($res))
{
$security=json_decode($row['value']);
//print_r($security);



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


			if($checkArray['mnemonic']=='' || $checkArray['ann_date']=='0000-00-00' || $checkArray['eff_date']=='0000-00-00'  )
			{
				$empty++;
				$emptyRecords=$data;
			}
			else
			{
		//print_r($data);



$CheckQuery=mysql_query("select * from tbl_ca where action_id='".$security['4']."' and  eff_date='".date("Y-m-d",strtotime($security['14']))."'");
if(mysql_num_rows($CheckQuery)<=0)
{

				$ca_id= qry_insert('tbl_ca',$data);	
				// $num_fields=0;
				  $num_fields=$security['20'];
				//echo "<br>";
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
		

}



}




$counter++;

//exit;

echo '<script>document.location.href="http://97.74.65.118/icai2/testca.php?counter='.$counter.'";</script>';

}





?>