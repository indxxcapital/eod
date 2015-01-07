<?php 

class Notifyforca extends Application{
		
		function __construct()
		{
			parent::__construct();
		}
		
		function index()
		{
			if(date('D')=="Mon")
			{$text='<br>Please Change The Corporate Action Request File date range from  : '.date("Y-m-d",strtotime(date("Y-m-d"))-(7*86400)).'  to '.date("Y-m-d",strtotime(date("Y-m-d"))+(60*86400)).'<br>';
		
		$emailQueries='select email from tbl_ca_user where status="1" and type="1" union select email from tbl_database_users where status="1"';
		$email_res=mysql_query($emailQueries);
		if(mysql_num_rows($email_res)>0)
		{
			
			while($email=mysql_fetch_assoc($email_res))
			{
			$emailsids[]=$email['email'];
			}
		}
		
		
		if(!empty($emailsids))	
		{
			 $emailsids	=implode(',',$emailsids);
			 
			//$emailsids.=',dbajpai@indxx.com';
			
			$msg='Hi <br>'.$text." <br>Thanks <br>";
					
					// To send HTML mail, the Content-type header must be set
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			
			// Additional headers
			//$headers .= 'To: '.$dbuser['name'].' <'.$dbuser['email'].'>'. "\r\n";
$headers .= 'From: Indexing <indexing@indxx.com>' . "\r\n"."CC: indexing@indxx.com". "\r\n";
					//echo $emailsids;
					/*	if(mail( $emailsids,"Corporate Action Weekly Update",$msg,$headers))
					{
						echo "Mail Send ";
						
						//echo "Mail sent to : ".$dbuser['name']."<br>";	
					}
					else
					{
						echo "Mail not sent";	
					}*/
					
			
			
		}
			}
			$this->saveProcess(1);
		$this->Redirect2("index.php?module=calcftpopen","","");	
		}
}
?>