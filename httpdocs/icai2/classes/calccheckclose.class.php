<?php 

class Calccheckclose extends Application{
		
		function __construct()
		{
			parent::__construct();
		}
		
		function index()
		{
		
		$indxxs=$this->db->getResult("select id,code from tbl_indxx where 1=1 ",true);
	//	$this->pr($indxxs);
		$date=date("Y-m-d",strtotime($this->_date)-86400);
		//$date="2014-04-17";
		$text='';
		if(!empty($indxxs))
		{
		foreach($indxxs as $indxx)
		{
			//echo "select indxx_value from tbl_indxx_value where code='".$indxx['code']."' and date='".$date."'";
			//echo "<br>";
			
		$values=$this->db->getResult("select indxx_value from tbl_indxx_value where code='".$indxx['code']."' and date='".$date."'");
		
	//	$this->pr($values);
		if(empty($values))
		{
		$text.=$indxx['code']."<br>";
		}
		
		}	
		
		}
		
		if($text)
		{
			
			$emailQueries='select email from tbl_ca_user where status="1" ';
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
			
			$msg='Hi <br> Index Values not Calculated for Following Index <br>'.$text." <br>Thanks <br>";
					
					// To send HTML mail, the Content-type header must be set
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			
			// Additional headers
			//$headers .= 'To: '.$dbuser['name'].' <'.$dbuser['email'].'>'. "\r\n";
$headers .= 'From: Indexing <indexing@indxx.com>' . "\r\n"."CC: indexing@indxx.com". "\r\n";
					//echo $emailsids;
						if(mail( $emailsids,"Indxx Values Not Calculated ",$msg,$headers))
					{
						echo "Mail Send ";
						
						//echo "Mail sent to : ".$dbuser['name']."<br>";	
					}
					else
					{
						echo "Mail not sent";	
					}
					
			
			
		}
		$str=file_get_contents("https://voiceapi.mvaayoo.com/voiceapi/SendVoice?user=dbajpai@indxx.com:Reset930&da=918860427207,919654735363,919868915460,919999646314,919990350993&campaign_name=try&voice_file=53c757f695722.wav");

echo $str;	
		}
		
		
		}
}
?>