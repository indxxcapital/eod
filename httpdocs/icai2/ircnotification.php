<pre><?php
 date_default_timezone_set("Asia/Kolkata"); 
ini_set('max_execution_time',60*60);
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;

include("core/function.php");

$datevalue=date("Y-m-d",strtotime(date("Y-m-d") . "+7 days"));

$txt='';
$ca_query=mysql_query("select identifier,action_id,id,mnemonic,field_id,company_name,ann_date,eff_date,amd_date,currency from tbl_ca cat where  eff_date<='".$datevalue."'   and status='1' and action_id in (select ca_action_id from tbl_ca_admin_approve where ca_action_id=cat.action_id) and action_id not in (select ca_action_id from tbl_ca_client_notified where ca_action_id=cat.action_id) ");
if(mysql_num_rows($ca_query)>0)
{

$txt.='Hi , Following Corporate Action having Exdate '.$datevalue.'  is not approved yet <br> ';
while($row=mysql_fetch_assoc($ca_query))
{
$adminmsg.="".$row['company_name'].'(<strong>'.$row['identifier'].'</strong>): "'.$row['mnemonic'].'" <br> ';



//print_r($row);
}




}

echo $adminmsg;

/*if($adminmsg)
{
	
	$sub='Corporate Action Approval Pending';
	
	$mailArray=array();
	
	$query1='Select email  from tbl_ca_user where status = "1" ';
$result1=mysql_query($query1);
if(mysql_num_rows($result1)>0)
{
while($row=mysql_fetch_assoc($result1))
{

$mailArray[]=$row['email'];
}
}



//$mailArray[]='nkumar@indxx.com';

$mailArray=array_unique($mailArray);
$emails= implode("," , $mailArray);


$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'To: '.$emails.''. "\r\n";
$headers .= 'From: Indexing <indexing@indxx.com>' . "\r\n";
		
		
		if(mail($users['email'],$sub,$adminmsg,$headers))
		{
			echo "Mail sent to ".$emails."<br>";	
		}

}
*/
/*echo '<script>document.location.href="http://97.74.65.118/icai2/canotification3day.php";</script>';
*/
?>