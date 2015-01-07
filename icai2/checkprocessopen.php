<pre><?php 
include("core/function.php");
$date1=date("Y-m-d");

$type=1;// open
$text='';

$date2='';
if(date("D")=="Mon")
{
$date2=date("Y-m-d",strtotime($date1)-3*86400);
}else{
$date2=date("Y-m-d",strtotime($date1)-86400);
}


$newValues=array();
$oldValues=array();

$qyery=mysql_query("  Select url,path from tbl_system_progress where type='".$type."'  and dateAdded like '".$date1."%'");
if(mysql_num_rows($qyery)>0)
{
while($row=mysql_fetch_assoc($qyery))
{

$newValues[$row['url']]=$row['path'];
}
}



$qyery2=mysql_query("  Select url,path from tbl_system_progress where type='".$type."'  and dateAdded like '".$date2."%'");
if(mysql_num_rows($qyery2)>0)
{
while($row2=mysql_fetch_assoc($qyery2))
{

$oldValues[$row2['url']]=$row2['path'];
}
}

if(empty($newValues))
{
	$text.="Processes not inserted for date : ".$date1."<br>";	
}

if(empty($oldValues))
{
	$text.="Processes not inserted for date : ".$date2."<br>";	
}

if($result=array_diff_assoc($newValues,$oldValues))
{
	$text.="Following new process added for date : ".$date1."<br>";
	foreach($result as $newkey=>$newpath)
	{
		$text.="URL : ".$newkey." and PATH : ".$newpath."<br>";	
	}		
}

if($result2=array_diff_assoc($oldValues,$newValues))
{
	$text.="Following old process skipped for date : ".$date1." from prevous date : ".$date2."<br>";	
	foreach($result2 as $oldkey=>$oldpath)
	{
		$text.="URL : ".$oldkey." and PATH : ".$oldpath."<br>";	
	}	
}


if($text!='')
{
	$to='';
	
	$emails=array();
	
	$usersdata=mysql_query("Select email from tbl_ca_user where 1=1");
	while($users=mysql_fetch_assoc($usersdata))
	{
		if(!empty($users['email']))
		{
			$emails[]=$users['email'];	
		}	
	}
	
	$to=implode(",",$emails);
	
	$sub="ICAI Opening System Process Notification";
	
	$message="Hi,<br>".$text."Thanks";
	
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
	// Additional headers
	$headers .= 'From: Indexing <indexing@indxx.com>' . "\r\n"."CC: indexing@indxx.com,dbajpai@indxx.com,jsharma@indxx.com". "\r\n";
	
	if(mail($to,$sub,$message,$headers))
	{
		echo "Mail sent to ".$to."<br>";	
	}
}
?>