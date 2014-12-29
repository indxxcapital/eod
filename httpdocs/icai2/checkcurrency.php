<pre><?php
 date_default_timezone_set("Asia/Kolkata"); 
ini_set('max_execution_time',60*60);
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;
include("core/function.php");


$securities =selectrow(array('ticker','curr','divcurr','indxx_id'),'tbl_indxx_ticker');	
//print_r($securities);
$text='Currency Mismatch <br>';
$flag=false;
$indxx_array=array();


if(!empty($securities))
{
foreach ($securities as $security)
{
	
$cas=	selectrow(array('currency','action_id','id'),'tbl_ca' ,array('identifier'=>$security['ticker'],'mnemonic'=>'DVD_CASH'));
	// code to match securty currency and bloomberg return currency
	
	
	if(!empty($cas))
	{
	foreach ($cas as $ca)
	{
		
			if($security['curr']!=$ca['currency'])
			{
				
			$text.=$security['ticker']." Default Price Currency : ". $security['curr']." , Bloomberg Return Price Currency : ".$ca['currency'] ."<br>";
			
			$flag=true;
			
			$indxx_array[]=$security['indxx_id'];
			
			$chkindexstartdate=selectrow(array('name','code'),'tbl_indxx' ,array('dateStart'=>date("Y-m-d"),'id'=>$security['indxx_id']));
			//print_r($chkindexstartdate);
			
			if(!empty($chkindexstartdate['0']['name']) || !empty($chkindexstartdate['0']['code']))
			{
				mysql_query("update tbl_indxx set status='0' where id='".$security['indxx_id']."'");
				$text.="Index ".$chkindexstartdate['0']['name']." (".$chkindexstartdate['0']['code'].") is deactivated.<br>";	
			}
			
			}
		
		
			$ca_values=	selectrow(array('field_value'),'tbl_ca_values' ,array('ca_action_id'=>$ca['action_id'],'field_name'=>'CP_DVD_CRNCY'));
	
	
			if($security['divcurr']!=$ca_values[0]['field_value'])
			{
			$text.=$security['ticker']." Default Dividend Currency : ". $security['divcurr']." , Bloomberg Return Dividend Currency : ".$ca_values[0]['field_value'];
			
			$chkindexxstartdate=selectrow(array('name','code'),'tbl_indxx' ,array('dateStart'=>date("Y-m-d"),'id'=>$security['indxx_id']));
			
			if(!empty($chkindexxstartdate['0']['name']) || !empty($chkindexxstartdate['0']['code']))
			{
				mysql_query("update tbl_indxx set status='0' where id='".$security['indxx_id']."'");
				$text.="<br>Index ".$chkindexxstartdate['0']['name']." (".$chkindexxstartdate['0']['code'].") is deactivated.<br>";	
			}
			
			$flag=true;
			$indxx_array[]=$security['indxx_id'];
			
			}
	
	
//	print_r($ca_values);
	
	}
	} 	
	
	
	
	
//$query="Select currency,action_id,id from tbl_ca where identifier like ''";
}
//exit;
}





if($flag)
{
//echo "Send Mail";

$users_array=array();
//print_r($indxx_array);

if(!empty($indxx_array))
{
$indxx_array=array_unique($indxx_array);

//print_r($indxx_array);
foreach($indxx_array as $indxx)
{
$users_array[]=getIndxxUsertemp($indxx);
}

}

//print_r($users_array);

//exit;

$emailsids=array(); 
$newuser_array=array();
if(!empty($users_array))
{
$newuser_array=	array_values_recursive($users_array);
//	print_r($newuser_array);
	if(!empty($newuser_array))
	{
		$users_list=implode(',', $newuser_array);
		$emailQueries='select email from tbl_ca_user where id in ('.$users_list.') or type="1"';
		$email_res=mysql_query($emailQueries);
		if(mysql_num_rows($email_res)>0)
		{
			
			while($email=mysql_fetch_assoc($email_res))
			{
			$emailsids[]=$email['email'];
			}
		}
	}
	
	
	
	}
	
	
//print_r($emailsids);

//
//$query=''

if(!empty($emailsids))	
{
 $emailsids	=implode(',',$emailsids);

//$emailsids.=',dbajpai@indxx.com';

 $msg='Hi '.$text." <br>Thanks <br>";
		
		// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
//$headers .= 'To: '.$dbuser['name'].' <'.$dbuser['email'].'>'. "\r\n";
$headers .= 'From: Indexing <indexing@indxx.com>' . "\r\n"."CC: indexing@indxx.com". "\r\n";		
		
		if(mail($emailsids,"Dividend Currency Notification",$msg,$headers))
		{
			echo "Mail Send ";
			
			echo "Mail sent to : ".$dbuser['name']."<br>";	
		}


}




}

$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);
echo 'Page generated in '.$total_time.' seconds. ';
saveProcess();
mysql_close();

echo '<script>document.location.href="http://97.74.65.118/icai2/checkcurrencytemp.php";</script>';
/*http://97.74.65.118/icai/dbbackup.php

*/?>

