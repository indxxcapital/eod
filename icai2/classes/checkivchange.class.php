<?php

class Checkivchange extends Application{

	function __construct()
	{
		parent::__construct();
	}
	
	
	function index()
	{
		
		$liveindexes=$this->db->getResult("SELECT id,name,code  FROM tbl_indxx WHERE status='1' and usersignoff='1' and dbusersignoff='1' and submitted='1'",true);
	//$this->pr($liveindexes,true);
	
	$indxxvaluesarray=array();
	
	if(!empty($liveindexes)){
	foreach($liveindexes as $key=>$value)
	{
		
		$indxxvaluesarray[$key]=$value;
		
		$liveindexvalues=$this->db->getResult("SELECT  date,indxx_value from tbl_indxx_value where tbl_indxx_value.indxx_id='".$value['id']."'order by date desc limit 0,2",true);
		$indxxvaluesarray[$key]['values']=$liveindexvalues;
		
	}}
		
		//$this->pr($indxxvaluesarray,true);
	$str='';	
		if(!empty($indxxvaluesarray))
		{
		foreach($indxxvaluesarray as $indxx)
		{//echo $indxx['values'];
			
		if(count($indxx['values'])==2 )
		{
		
		//$this->pr($indxx);
		$value1=$indxx['values'][0]['indxx_value'];
		$value2=$indxx['values'][1]['indxx_value'];
		$diff=100*(($value1-$value2)/$value2);
//echo $indxx['code']."=>".$diff;
//echo "<br>";
	
	if($diff>=5 || $diff<=-5)
	{
	$str.= $indxx['name']."(".$indxx['code'].") " .$diff."%<br/>";
	
	
	}
	
		
		}
		}
		}
		
		if($str)
		{
			
			$emailQueries='select email from tbl_ca_user where status="1" and type!="1" ';
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
			
			$msg='Hi <br>
			Index Value Change Notification <br/>
			'.$str." <br>Thanks <br>";
					
					// To send HTML mail, the Content-type header must be set
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			
			// Additional headers
			//$headers .= 'To: '.$dbuser['name'].' <'.$dbuser['email'].'>'. "\r\n";
$headers .= 'From: Indexing <indexing@indxx.com>' . "\r\n"."CC: indexing@indxx.com". "\r\n";
					//echo $emailsids;
						if(mail( $emailsids,"Softlayer - Index Values Change Notification",$msg,$headers))
					{
						echo "Mail Send ";
						
						//echo "Mail sent to : ".$dbuser['name']."<br>";	
					}
					else
					{
						echo "Mail not sent";	
					}
					
			
			
		}
		}
		$this->saveProcess(2);
		$this->Redirect2("index.php?module=checkpvchange","","");	
		
	}

}?>