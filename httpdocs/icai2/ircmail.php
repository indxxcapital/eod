<pre><?php
 date_default_timezone_set("Asia/Kolkata"); 
ini_set('max_execution_time',60*60);
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;

include("core/function.php");
//,strtotime(date("Y-m-d"))-(86400)
$datevalue=date("Y-m-d");
//$datevalue='2014-09-05';
if($_GET['tbl']=='temp')
{
 $query="Select tbl_ca.identifier,tbl_ca.identifier,tbl_ca.action_id,tbl_ca.mnemonic,tbl_ca.company_name,tbl_ca.currency,tbl_ca.eff_date ,tbl_indxx_ticker_temp.indxx_id,tbl_indxx_temp.name,tbl_indxx_temp.code from tbl_ca_admin_approve_temp
left join tbl_ca on tbl_ca_admin_approve_temp.ca_action_id=tbl_ca.action_id
left join tbl_indxx_ticker_temp on tbl_indxx_ticker_temp.ticker = tbl_ca.identifier
left join tbl_indxx_temp on tbl_indxx_temp.id=tbl_indxx_ticker_temp.indxx_id
 where tbl_ca_admin_approve_temp.ca_action_id = '".$_GET['id']."'  ";
 
}else{
$query="Select tbl_ca.identifier,tbl_ca.identifier,tbl_ca.action_id,tbl_ca.mnemonic,tbl_ca.company_name,tbl_ca.currency,tbl_ca.eff_date ,tbl_indxx_ticker.indxx_id,tbl_indxx.name,tbl_indxx.code from tbl_ca_admin_approve
left join tbl_ca on tbl_ca_admin_approve.ca_action_id=tbl_ca.action_id
left join tbl_indxx_ticker on tbl_indxx_ticker.ticker = tbl_ca.identifier
left join tbl_indxx on tbl_indxx.id=tbl_indxx_ticker.indxx_id
 where tbl_ca_admin_approve.ca_action_id = '".$_GET['id']."'  ";
}
 // and (tbl_ca.mnemonic='DELIST' || tbl_ca.mnemonic='ACQUIS' || tbl_ca.mnemonic='DVD_STOCK' || tbl_ca.mnemonic='RIGHTS_OFFER' || tbl_ca.mnemonic='SPIN' || tbl_ca.mnemonic='STOCK_SPLIT')

//echo $query;

$res=mysql_query($query);
if(mysql_num_rows($res)>0)
{
while($row=mysql_fetch_assoc($res))
{
	
//print_r($row);

	
	if($row['mnemonic']=="DELIST" || $row['mnemonic']=="ACQUIS" || $row['mnemonic']=="DVD_STOCK" || $row['mnemonic']=="RIGHTS_OFFER" || $row['mnemonic']=="SPIN" || $row['mnemonic']=="STOCK_SPLT")
	{
	//print_r($row);
	
	
	

$ca_values=selectrow2(array('field_name','field_value'),'tbl_ca_values',array('ca_action_id'=>$row['action_id']));
//print_r($ca_values);
 $usersQuery=mysql_query("select tbl_ca_user.email,tbl_ca_user.name from tbl_assign_index
left join tbl_ca_user on tbl_ca_user.id=tbl_assign_index.user_id
 where tbl_assign_index.indxx_id='".$row['indxx_id']."' or tbl_ca_user.type='1' ");
$to='';
$emails=array();
if(mysql_num_rows($usersQuery)>0)
while($userList=mysql_fetch_assoc($usersQuery)){
//echo $userList['email'];

//echo "<br>";
$emails[] =$userList['email'];
}

 $usersQuery2=mysql_query("select tbl_ca_user.email,tbl_ca_user.name from  tbl_ca_user 
 where  tbl_ca_user.type='1' ");
$to='';

if(mysql_num_rows($usersQuery2)>0)
while($userList1=mysql_fetch_assoc($usersQuery2)){
//echo $userList['email'];

//echo "<br>";
$emails[] =$userList1['email'];
}



if(!empty($emails)){
$to=implode(',',array_unique($emails));
}else
$to="dbajpai@indxx.com";
//$to="dbajpai@indxx.com";

//echo $to;
//exit;
//$to="dbajpai@indxx.com";
if($row['mnemonic']=='DVD_STOCK')
{
	
	$subject="CA: Stock Dividend : ".$row['code'];
	
//	$to   = "dbajpai@indxx.com";
  $from = 'indexing@indxx.com';
 
  $headers = "From: " . strip_tags($from) . "\r\n";
  $headers .= "Reply-To: ". strip_tags($from) . "\r\n";
 // $headers .= "CC: info@phpgang.com\r\n";
  $headers .= "MIME-Version: 1.0\r\n";
  $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
$message = '<html><body>';
 
$message .= '<table width="100%";  cellpadding="10">';
 

 
$message .= "<tr><td colspan='2'>Dear All,<br /><br />
There is stock dividend in the ".$row['name']." ( ".$row['code']." ) effective ".date("F d, Y",strtotime($row['eff_date']))." <br>
</td></tr>";
$message .= "<tr><td width='20%'>Company Name </td><td>: ".$row['company_name']." <br></td></tr>";
$message .= "<tr><td   width='20%'>Ticker </td><td>: ".$row['identifier']." <br></td></tr>";
 $message .= "<tr><td colspan='2'><strong>Terms</strong> <br></td></tr>";
  $message .= "<tr><td  width='20%'>Adjustment Factor </td><td>: ".$ca_values['CP_ADJ']."% <br></td></tr>";
   $message .= "<tr><td colspan='2'><strong>Treatment</strong>................................................................................................................................................................................................................................................................</td></tr>";
  
$message .= "<tr><td colspan='2' font='colr:#999999;'>Please let us know in case of any queries.</td></tr>";
$message .= "<tr><td colspan='2' font='colr:#999999;'>Thanks<br><br></td></tr>";
$message .= "<tr><td colspan='2' font='colr:#999999;'>Best Regards</td></tr>";

$message .= "<tr><td colspan='2' font='colr:#999999;'>indxx<br>Phone: +91 124-4291430/31<br>Address: 930, B3, Spaze I Tech Park, Sec-49<br>Sohna Road, Gurgaon 120016, Haryana, India<br>www.indxx.com</td></tr>";

$message .= "<tr><td colspan='2' font='colr:#999999;'> <img src='http://www.processdo.com/corporate_actions/assets/images/logo-colored.jpg' alt='Indxx' /></td></tr>";
$message .= "</table>";
 
$message .= "</body></html>";
   mail($to, $subject, $message, $headers);
}


if($row['mnemonic']=='DELIST')
{
	
	$subject="CA: Delist : ".$row['code'];
	
//	$to   = "dbajpai@indxx.com";
  $from = 'indexing@indxx.com';
 
  $headers = "From: " . strip_tags($from) . "\r\n";
  $headers .= "Reply-To: ". strip_tags($from) . "\r\n";
 // $headers .= "CC: info@phpgang.com\r\n";
  $headers .= "MIME-Version: 1.0\r\n";
  $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
$message = '<html><body>';
 
$message .= '<table width="100%";  cellpadding="10">';
 

 
$message .= "<tr><td colspan='2'>Dear All,<br /><br />
There is delisting in the ".$row['name']." ( ".$row['code']." ) effective ".date("F d, Y",strtotime($row['eff_date']))." <br>
</td></tr>";
$message .= "<tr><td width='20%'>Company Name </td><td>: ".$row['company_name']." <br></td></tr>";
$message .= "<tr><td width='20%'>Ticker </td><td>: ".$row['identifier']." <br></td></tr>";
 $message .= "<tr><td colspan='2'><strong>Reason</strong> <br></td></tr>";
  $message .= "<tr><td> ............................................................................................................................................................................................................................................................<br></td></tr>";
  
   $message .= "<tr><td colspan='2'><strong>Terms</strong> <br></td></tr>";
  $message .= "<tr><td width='20%'>Action </td><td>: Delisting <br></td></tr>";
  
   $message .= "<tr><td colspan='2'><strong>Treatment</strong>................................................................................................................................................................................................................................................................</td></tr>";
  
$message .= "<tr><td colspan='2' font='colr:#999999;'>Please let us know in case of any queries.</td></tr>";
$message .= "<tr><td colspan='2' font='colr:#999999;'>Thanks<br><br></td></tr>";
$message .= "<tr><td colspan='2' font='colr:#999999;'>Best Regards</td></tr>";

$message .= "<tr><td colspan='2' font='colr:#999999;'>indxx<br>Phone: +91 124-4291430/31<br>Address: 930, B3, Spaze I Tech Park, Sec-49<br>Sohna Road, Gurgaon 120016, Haryana, India<br>www.indxx.com</td></tr>";

$message .= "<tr><td colspan='2'  font='colr:#999999;'> <img src='http://www.processdo.com/corporate_actions/assets/images/logo-colored.jpg' alt='Indxx' /></td></tr>";
$message .= "</table>";
 
$message .= "</body></html>";
//echo $to;


   mail($to, $subject, $message, $headers);
}


if($row['mnemonic']=='STOCK_SPLT')
{
	
	$subject="CA: Stock Split : ".$row['code'];
	
//	$to   = "dbajpai@indxx.com";
  $from = 'indexing@indxx.com';
 
  $headers = "From: " . strip_tags($from) . "\r\n";
  $headers .= "Reply-To: ". strip_tags($from) . "\r\n";
 // $headers .= "CC: info@phpgang.com\r\n";
  $headers .= "MIME-Version: 1.0\r\n";
  $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
$message = '<html><body>';
 
$message .= '<table width="100%";  cellpadding="10">';
 

 
$message .= "<tr><td colspan='2'>Dear All,<br /><br />
There is stock split in the ".$row['name']." ( ".$row['code']." ) effective ".date("F d, Y",strtotime($row['eff_date']))." <br>
</td></tr>";
$message .= "<tr><td width='20%'>Company Name </td><td>: ".$row['company_name']." <br></td></tr>";
$message .= "<tr><td width='20%'>Ticker </td><td>: ".$row['identifier']." <br></td></tr>";
 $message .= "<tr><td colspan='2'><strong>Terms</strong> <br></td></tr>";
  $message .= "<tr><td width='20%'>Action </td><td>: Stock Split <br></td></tr>";
   $message .= "<tr><td width='20%'>Amount </td><td>: ".$ca_values['CP_TERMS']." <br></td></tr>";
  $message .= "<tr><td width='20%'>Adjustment Factor </td><td>: ".$ca_values['CP_ADJ']." <br></td></tr>";
   $message .= "<tr><td colspan='2'><strong>Treatment</strong>................................................................................................................................................................................................................................................................</td></tr>";
  
$message .= "<tr><td colspan='2' font='colr:#999999;'>Please let us know in case of any queries.</td></tr>";
$message .= "<tr><td colspan='2' font='colr:#999999;'>Thanks<br><br></td></tr>";
$message .= "<tr><td colspan='2' font='colr:#999999;'>Best Regards</td></tr>";

$message .= "<tr><td colspan='2' font='colr:#999999;'>indxx<br>Phone: +91 124-4291430/31<br>Address: 930, B3, Spaze I Tech Park, Sec-49<br>Sohna Road, Gurgaon 120016, Haryana, India<br>www.indxx.com</td></tr>";

$message .= "<tr><td colspan='2' font='colr:#999999;'> <img src='http://www.processdo.com/corporate_actions/assets/images/logo-colored.jpg' alt='Indxx' /></td></tr>";
$message .= "</table>";
 
$message .= "</body></html>";
  mail($to, $subject, $message, $headers);
}
if($row['mnemonic']=='SPIN')
{
	
	$subject="CA: Spin-off : ".$row['code'];
	
	//$to   = "dbajpai@indxx.com";
  $from = 'indexing@indxx.com';
 
  $headers = "From: " . strip_tags($from) . "\r\n";
  $headers .= "Reply-To: ". strip_tags($from) . "\r\n";
 // $headers .= "CC: info@phpgang.com\r\n";
  $headers .= "MIME-Version: 1.0\r\n";
  $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
$message = '<html><body>';
 
$message .= '<table width="100%";  cellpadding="10">';
 

 
$message .= "<tr><td colspan='2'>Dear All,<br /><br />
There is spin-off in the ".$row['name']." ( ".$row['code']." ) effective ".date("F d, Y",strtotime($row['eff_date']))." <br>
</td></tr>";
$message .= "<tr><td width='20%'>Spin-off Company </td><td>: ".$row['company_name']." <br></td></tr>";
$message .= "<tr><td width='20%'>Ticker </td><td>: ".$row['identifier']." <br></td></tr>";
$message .= "<tr><td width='20%'>Spun-off Company </td><td>:".$ca_values['CP_SPINOFF_NAME']." <br></td></tr>";
$message .= "<tr><td width='20%'>Ticker </td><td>: ".$ca_values['CP_TKR']." <br></td></tr>";
 $message .= "<tr><td colspan='2'><strong>Terms</strong> <br></td></tr>";
  $message .= "<tr><td colspan='2'>Shareholder of ".$row['identifier']." recieve .... share of  ".$ca_values['CP_TKR']." per every share held ( ".$ca_values['CP_TERMS']." ) <br></td></tr>";
   $message .= "<tr><td colspan='2'><strong>Treatment</strong>................................................................................................................................................................................................................................................................</td></tr>";
  
$message .= "<tr><td colspan='2' font='colr:#999999;'>Please advice how to Proceed.</td></tr>";
$message .= "<tr><td colspan='2' font='colr:#999999;'>Thanks<br><br></td></tr>";
$message .= "<tr><td colspan='2' font='colr:#999999;'>Best Regards</td></tr>";
$message .= "<tr><td colspan='2' font='colr:#999999;'>indxx<br>Phone: +91 124-4291430/31<br>Address: 930, B3, Spaze I Tech Park, Sec-49<br>Sohna Road, Gurgaon 120016, Haryana, India<br>www.indxx.com</td></tr>";

$message .= "<tr><td colspan='2' font='colr:#999999;'> <img src='http://www.processdo.com/corporate_actions/assets/images/logo-colored.jpg' alt='Indxx' /></td></tr>";
$message .= "</table>";
 
$message .= "</body></html>";
   mail($to, $subject, $message, $headers);
}

if($row['mnemonic']=='RIGHTS_OFFER')
{
	
	$subject="CA: Rights Offering : ".$row['code'];
	
///	$to   = "dbajpai@indxx.com";
  $from = 'indexing@indxx.com';
 
  $headers = "From: " . strip_tags($from) . "\r\n";
  $headers .= "Reply-To: ". strip_tags($from) . "\r\n";
  //$headers .= "CC: info@phpgang.com\r\n";
  $headers .= "MIME-Version: 1.0\r\n";
  $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
$message = '<html><body>';
 
$message .= '<table width="100%";  cellpadding="10">';
 

 
$message .= "<tr><td colspan='2'>Dear All,<br /><br />
There is rights offering in the ".$row['name']." ( ".$row['code']." ) effective ".date("F d, Y",strtotime($row['eff_date']))." <br>
</td></tr>";
$message .= "<tr><td width='20%'>Company Name </td><td>: ".$row['company_name']." <br></td></tr>";
$message .= "<tr><td width='20%'>Ticker </td><td>: ".$row['identifier']." <br></td></tr>";
 $message .= "<tr><td colspan='2'><strong>Terms</strong> <br></td></tr>";
  $message .= "<tr><td width='20%'>Rights Ratio </td><td>: ".$ca_values['CP_TERMS']." <br></td></tr>";
    $message .= "<tr><td width='20%'>Price Offered</td><td>: ".$ca_values['CP_PX']."  ".$ca_values['CP_CRNCY']."<br></td></tr>";
	  $message .= "<tr><td width='20%'>CMP </td><td> : .... <br></td></tr>";
  $message .= "<tr><td width='20%' >Six Months Average Price</td><td> : .... <br></td></tr>";
   $message .= "<tr><td colspan='2'><strong>Treatment</strong>................................................................................................................................................................................................................................................................</td></tr>";
  
$message .= "<tr><td colspan='2' font='colr:#999999;'>Please let us know in case of any queries.</td></tr>";
$message .= "<tr><td colspan='2' font='colr:#999999;'>Thanks<br><br></td></tr>";
$message .= "<tr><td colspan='2' font='colr:#999999;'>Best Regards</td></tr>";

$message .= "<tr><td colspan='2' font='colr:#999999;'>indxx<br>Phone: +91 124-4291430/31<br>Address: 930, B3, Spaze I Tech Park, Sec-49<br>Sohna Road, Gurgaon 120016, Haryana, India<br>www.indxx.com</td></tr>";

$message .= "<tr><td colspan='2' font='colr:#999999;'> <img src='http://www.processdo.com/corporate_actions/assets/images/logo-colored.jpg' alt='Indxx' /></td></tr>";
$message .= "</table>";
 
$message .= "</body></html>";
   mail($to, $subject, $message, $headers);
}
if($row['mnemonic']=='ACQUIS' && $ca_values['CP_TARGET_TKR'] && strstr($row['identifier'],$ca_values['CP_TARGET_TKR']))
{
	
	
	
	
	$subject="CA: Acquistion : ".$row['code'];
	
	//$to   = "dbajpai@indxx.com";
  $from = 'indexing@indxx.com';
 
  $headers = "From: " . strip_tags($from) . "\r\n";
  $headers .= "Reply-To: ". strip_tags($from) . "\r\n";
 // $headers .= "CC: info@phpgang.com\r\n";
  $headers .= "MIME-Version: 1.0\r\n";
  $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
$message = '<html><body>';
 
$message .= '<table width="100%";  cellpadding="10">';
 

 
$message .= "<tr><td colspan='2'>Dear All,<br /><br />
There is an acquisition in the ".$row['name']." ( ".$row['code']." ) effective ".date("F d, Y",strtotime($row['eff_date']))." <br>
</td></tr>";
$message .= "<tr><td width='20%'>Acquirer Company Name </td><td>: ".$ca_values['CP_NAME']." <br></td></tr>";
$message .= "<tr><td width='20%'>Ticker</td><td> : ".$ca_values['CP_ACQ_TKR']." <br></td></tr>";
$message .= "<tr><td width='20%'>Target Company Name</td><td>: ".$ca_values['CP_UNIT']." <br></td></tr>";
$message .= "<tr><td width='20%'>Ticker </td><td>: ".$ca_values['CP_TARGET_TKR']." <br></td></tr>";
 $message .= "<tr><td colspan='2'><strong>Terms</strong> <br></td></tr>";
  $message .= "<tr><td width='20%'>Percentage Owned </td><td>: ".$ca_values['CP_PCT_OWNED']."%<br></td></tr>";
    $message .= "<tr><td width='20%'>Percentage Sought </td><td>: ".$ca_values['CP_PCT_SOUGHT']."%<br></td></tr>";
	    $message .= "<tr><td  width='20%'>Offered Price </td><td>: ".$ca_values['CP_CASH']."<br></td></tr>";
   $message .= "<tr><td colspan='2'><strong>Treatment</strong>................................................................................................................................................................................................................................................................</td></tr>";
  
$message .= "<tr><td colspan='2' font='colr:#999999;'>Please let us know in case of any queries.</td></tr>";
$message .= "<tr><td colspan='2' font='colr:#999999;'>Thanks<br><br></td></tr>";
$message .= "<tr><td colspan='2' font='colr:#999999;'>Best Regards</td></tr>";

$message .= "<tr><td colspan='2' font='colr:#999999;'>indxx<br>Phone: +91 124-4291430/31<br>Address: 930, B3, Spaze I Tech Park, Sec-49<br>Sohna Road, Gurgaon 120016, Haryana, India<br>www.indxx.com</td></tr>";

$message .= "<tr><td colspan='2' font='colr:#999999;'> <img src='http://www.processdo.com/corporate_actions/assets/images/logo-colored.jpg' alt='Indxx' /></td></tr>";
$message .= "</table>";
 
$message .= "</body></html>";
  mail($to, $subject, $message, $headers);
}

	}
}
}


?>