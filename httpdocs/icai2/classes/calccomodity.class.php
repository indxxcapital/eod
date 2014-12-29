<?php

class Calccomodity extends Application{

	function __construct()
	{
		parent::__construct();
	}
	
	
	function index()
	{
		
		//echo "select * from tbl_indxx_cs  where status='1' ";
		$indxxs=$this->db->getResult("select * from tbl_commodity_indxx  where status='1' ",true);	
		//$this->pr($indxxs);
		 $datevalue2=$this->_date;
		//$datevalue2='2014-05-01';
		
		$array=array();
		if(!empty($indxxs))
		{
		foreach($indxxs as $k=>$indxx)
		{
		
		
			if($this->checkHoliday($indxx['zone'], $datevalue2)){
		
		
		$array[$indxx['id']]=$indxx;
		//$client=$this->db->getResult("select tbl_ca_client.ftpusername from tbl_ca_client where id='".$indxx['client_id']."'",false,1);	
		//	
		//$array[$indxx['id']]['client']=$client['ftpusername'];
			
		
		//echo "select cit.*,(select price from tbl_commodity_price cp where cit.ticker_id=cp.ticker_id  and cp.date='".$datevalue2."') as calcprice from tbl_commodity_indxx_ticker cit  where indxx_id='".$indxx['id']."' ";
		
		$results=$this->db->getResult("select cit.*,(select price from tbl_commodity_price cp where cit.ticker_id=cp.ticker_id  and cp.date='".$datevalue2."') as calcprice from tbl_commodity_indxx_ticker cit  where indxx_id='".$indxx['id']."' ",true);
//$array[]
	//	$this->pr($results);
		$array[$indxx['id']]['values']=$results;
				}
		}
		}
		
		//$this->pr($array,true);
		
	$text='';
	
		if(!empty($array))
		{
		foreach($array as $ikey=> $index)
		{
				if(!empty($index['values']))
				{
					
					foreach($index['values'] as $ticker)
					{
					if($ticker['weight'] && $ticker['calcprice'] )
					{
				//	echo "Active<br>";
					}
					else{
					//echo "Inactiv<br>";
					
					$text.=$index['name']."(".$index['code'].")";
					
					unset($array[$ikey]);
					
					
					}
					}
					
				
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
		
		
			
			}
			
			
				if(!empty($array))
		{
		foreach($array as $ikey=> $index)
		{
			$indexvalue=0;
			
			
				if(!empty($index['values']))
				{
					
					foreach($index['values'] as $ticker)
					{
						$indexvalue+=$ticker['weight']*$ticker['calcprice'];
						}
						}
						
						if($indexvalue)
			{
			
				$this->db->query("insert into tbl_commodity_index_values set status='1',  	indxx_id='".$index['id']."', date='".$datevalue2."', value='".$indexvalue."'");	
			
			}
						
						}
						
						
						}
			
			
			//$this->pr($array);
		
	
	
	
		$clients=$this->db->getResult("select distinct(client_id) from tbl_commodity_indxx where 1=1 ",true);
		
		foreach($clients as $key=>$clientid)
		{
			$rowdata=array();
			
			$clientftp=$this->db->getResult("select ftpusername from tbl_ca_client where id='".$clientid['client_id']."' ",false);
			
			$indxx=$this->db->getResult("select id,(select value from tbl_commodity_index_values where date='".$datevalue2."' and indxx_id=cit.id) as value from tbl_commodity_indxx  cit where cit.client_id='".$clientid['client_id']."' ",true);
			
			
	//$this->pr($indxx, true);	
	//		$indxxxvalue=$this->db->getResult("select value,id from tbl_commodity_index_values where date='2014-04-22' and indxx_id='".$clientid['indxx_id']."'",true);
			
			
			require 'php-excel.class.php';
		
		//echo "select * from tbl_ca_user where 1=1";
				//print_r($exceldata);
				
			foreach($indxx as $key1=>$value)
			{	
				$rowdata[]=array($value['id'],$value['value']);
			}

		
		// create a simple 2-dimensional array
		$data = array(
        1 => array ('Index', 'Value'),
        //array('Schwarz', 'Oliver'),
        //array('Test', 'Peter')
        );
		
		// generate file (constructor parameters are optional)
		$xls = new Excel_XML('UTF-8', false, 'Client Data');
		$xls->addArray($data);
		foreach($rowdata as $key1=>$val1)
		{
			$excelarray = array(
        	1 => $val1,
        	);
			//print_r($excelarray);
			$xls->addArray($excelarray);
		}
		
		
		$data=$xls->generateXML2('CommodityData');
			$file = fopen( '../files2/ca-output/'.$clientftp['ftpusername'].'/values-'.$datevalue2.'.xls',"w");;
fwrite($file,$data);

fclose($file);			
			
		}
	
$this->saveProcess(3);
//exit;
	$this->Redirect("index.php?module=calccomoditytemp","","");	
	
		 
	}
	
	
}
?>