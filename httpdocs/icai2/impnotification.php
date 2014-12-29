<pre><?php
 date_default_timezone_set("Asia/Kolkata"); 
ini_set('max_execution_time',60*60);
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;

include("core/function.php");

$userArray=array();
$dbuserArray=array();
$IndxxArray=array();
$dbusermsg='';
$adminmsg='';
$website='http://97.74.65.118/icai/index.php';
	  $dayesagodate=date('Y-m-d', strtotime(date("Y-m-d").'+2 days'));
 $query3='Select *  from tbl_indxx where  dateStart between "'.date("Y-m-d").'" and "'.$dayesagodate.'" ';
$result3=mysql_query($query3);
if(mysql_num_rows($result3)>0)
{
while($row=mysql_fetch_assoc($result3))
{
//print_r($row);

if($row['status']==0)
{
$adminmsg.=" Approval Not done : ".$row['name']."(".$row['code'].").<br>";
}
if($row['submitted']==0)
{
$adminmsg.=" Index Submission Required : ".$row['name']."(".$row['code'].").<br>";
}
if($row['usersignoff']==0)
{
$adminmsg.=" Index User Signoff Required : ".$row['name']."(".$row['code'].").<br>";
}
if($row['dbusersignoff']==0)
{
$adminmsg.=" Index Request File Status Required : ".$row['name']."(".$row['code'].").<br>";
}

}
}

if($adminmsg!='')
{


$query1='Select email  from tbl_ca_user where tbl_ca_user.status = "1" union  Select email  from tbl_database_users where tbl_database_users.status = "1" ';
$result1=mysql_query($query1);

if(mysql_num_rows($result1)>0)
{
while($row=mysql_fetch_assoc($result1))
{

$userArray[]=$row['email'];

}
}
//print_r($userArray);
$sub='ICAI Important notification';
$to=implode(',',$userArray);
$msg='Hi,<br>Following task are pending<br> '.$adminmsg.' <br>Please visit <a href="'.$website.'">'.$website.'</a> to Update. <br>Thanks';
		
		// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
//$headers .= 'To: '.$dbuser['name'].' <'.$dbuser['email'].'>'. "\r\n";
$headers .= 'From: Indexing <indexing@indxx.com>' . "\r\n"."CC: indexing@indxx.com". "\r\n";		
		
		if(mail($to,$sub,$msg,$headers))
		{
			echo "Mail sent to : ".$to."<br>";	
		}


}



$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);
mysql_close();
echo 'Page generated in '.$total_time.' seconds. ';

?>


