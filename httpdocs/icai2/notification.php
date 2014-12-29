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


$query1='Select *  from tbl_ca_user where status = "1"';
$result1=mysql_query($query1);
if(mysql_num_rows($result1)>0)
{
while($row=mysql_fetch_assoc($result1))
{
$userArray[$row['id']]['name']=$row['name'];
$userArray[$row['id']]['email']=$row['email'];
$userArray[$row['id']]['type']=$row['type'];
}
}


$query2='Select *  from tbl_database_users where status = "1"';
$result2=mysql_query($query2);
if(mysql_num_rows($result2)>0)
{
while($row=mysql_fetch_assoc($result2))
{
$dbuserArray[$row['id']]['name']=$row['name'];
$dbuserArray[$row['id']]['email']=$row['email'];
$dbuserArray[$row['id']]['type']=3;
}
}


$query3='Select *  from tbl_indxx';
$result3=mysql_query($query3);
if(mysql_num_rows($result3)>0)
{
while($row=mysql_fetch_assoc($result3))
{
$IndxxArray[$row['id']]=$row;
$indxx_user_name_array=array();
$indxx_user_id_array=array();
$indxxuserResponce = mysql_query("Select user_id from tbl_assign_index where indxx_id='".$row['id']."'");
if(mysql_num_rows($indxxuserResponce)>0)
{

while($employee = mysql_fetch_assoc($indxxuserResponce))
{
	if($userArray[$employee['user_id']]['name'])
	{$indxx_user_name_array[]=$userArray[$employee['user_id']]['name'];
	$indxx_user_id_array[]=$employee['user_id'];
	}
}
}
//print_r(	$indxx_user_id_array);
 
$IndxxArray[$row['id']]['employees']=implode(',' , $indxx_user_name_array);
$IndxxArray[$row['id']]['employeesid']=$indxx_user_id_array;

}
}



if(!empty($IndxxArray))
{
foreach($IndxxArray as $indxx)
{
if($indxx['dbusersignoff']==0 && $indxx['status']==1 && $indxx['usersignoff']==1 && $indxx['submitted']==1)
{
//print_r($indxx);
$dbusermsg.=$indxx['name'].'(<strong>'.$indxx['code'].'</strong>) <br>';
}
if($indxx['submitted']==0)
{
$adminmsg.="Indxx Added But Not Submitted : ".$indxx['name'].'(<strong>'.$indxx['code'].'</strong>) by assigned members ( '.$indxx['employees'].' ).  <br> ';
}
if($indxx['status']==0 && $indxx['submitted']==1)
{
$adminmsg.="Approval Required : ".$indxx['name'].'(<strong>'.$indxx['code'].'</strong>)   <br> ';
}
if( $indxx['status']==1 && $indxx['submitted']==1 && $indxx['usersignoff']==0)
{
$adminmsg.="User Signoff Required : ".$indxx['name'].'(<strong>'.$indxx['code'].'</strong>)  by assigned members ( '.$indxx['employees'].')  <br> ';
}

if($indxx['status']==1 && $indxx['submitted']==1 && $indxx['usersignoff']==1  && $indxx['dbusersignoff']==0)
{
$adminmsg.="Request File Creation Pending : ".$indxx['name'].'(<strong>'.$indxx['code'].'</strong>)   by Database Users <br> ';
}


if($indxx['submitted']==0)
{
if(!empty($indxx['employeesid']))
{
foreach($indxx['employeesid'] as $id)
{
$userArray[$id]['mailmessage'][]='Index Submission Required for .'.$indxx['name']."(".$indxx['code'].")";
}
}
}

if($indxx['submitted']==1 && $indxx['usersignoff']==0)
{
if(!empty($indxx['employeesid']))
{
foreach($indxx['employeesid'] as $id)
{
$userArray[$id]['mailmessage'][]='Index Signoff Required for .'.$indxx['name']."(".$indxx['code'].")";
}
}
}

}

}


$sub='ICAI Notification';

//print_r($userArray);

if($dbusermsg!='')
{
	
	foreach($dbuserArray as $dbuser)
	{
		$msg='Hi '.$dbuser['name'].',<br>Request File Status is pending for '.$dbusermsg.' <br>Please visit <a href="'.$website.'">'.$website.'</a> to Update. <br>Thanks';
		
		// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'To: '.$dbuser['name'].' <'.$dbuser['email'].'>'. "\r\n";
$headers .= 'From: Indexing <indexing@indxx.com>' . "\r\n"."CC: indexing@indxx.com". "\r\n";		
		
		if(mail($dbuser['email'],$sub,$msg,$headers))
		{
			echo "Mail sent to : ".$dbuser['name']."<br>";	
		}
	}
}

//print_r($IndxxArray);


if($adminmsg)
{
	foreach($userArray as $user)
	{
	if($user['type']==1)
	{
		$msg='Hi '.$user['name'].',<br> '.$adminmsg.' <br>Please visit <a href="'.$website.'">'.$website.'</a> to Update. <br>Thanks';
		
		// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'To: '.$dbuser['name'].' <'.$dbuser['email'].'>'. "\r\n";
$headers .= 'From: Indexing <indexing@indxx.com>' . "\r\n";
		
		
		if(mail($user['email'],$sub,$msg,$headers))
		{
			echo "Mail sent to ".$user['email']."<br>";	
		}
		
	
	}
	}
	
	
}




if(!empty($userArray))
{
foreach($userArray as $users)
{
//print_r($users);
if(!empty($users['mailmessage']))
{
	$msg= implode('<br>',$users['mailmessage'])."<br>";
		$msg='Hi '.$users['name'].',<br> '.$msg.' <br>Please visit <a href="'.$website.'">'.$website.'</a> to Update. <br>Thanks';
		
		// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'To: '.$users['name'].' <'.$users['email'].'>'. "\r\n";
$headers .= 'From: Indexing <indexing@indxx.com>' . "\r\n";
		
		
		if(mail($users['email'],$sub,$msg,$headers))
		{
			echo "Mail sent to ".$users['email']."<br>";	
		}
}


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

