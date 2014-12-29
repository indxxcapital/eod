<?php

class Compositclose extends Application{

	function __construct()
	{
		parent::__construct();
	
	}
	
	function index()
	{
		
		//echo $this->_date;
		
	$clientData=$this->db->getResult("select id,ftpusername from tbl_ca_client where status='1'");
	//$this->pr($clientData,true);
	
	$date=date('Y-m-d',strtotime($this->_date)-86400);
	
	//$date="2014-03-28";
	if(!empty($clientData))
	{
		foreach($clientData as $client)
		{
				$file="../files2/ca-output/".$client['ftpusername']."/compositclosing-".$date.".txt";
				$entry1="Date".",".$date.",\r\n";
				$entry1.="Name,Code,Market Value,Index value,\r\n";
				
				$indexes=$this->db->getResult("select id,name,code from tbl_indxx where client_id='".$client['id']."'",true);
				if(!empty($indexes))
				{
				
				foreach($indexes as $index)
				{
					
				$data=	$this->db->getResult("select market_value,indxx_value from tbl_indxx_value where indxx_id='".$index['id']."' and date='".$date."'");
				$entry1.=$index['name'].','.$index['code'].','.$data['market_value'].','.$data['indxx_value'].",\r\n";
				
				
				//$this->pr($data);
				}	
								
				}
				
				$open=fopen($file,"w+");
					if($open){   
 if(   fwrite($open,$entry1))
{
	echo "file Written Successfully ";
	
	
	}
}	
				//$this->pr($indexes);
		
		}
	}
	$this->saveProcess(2);
	
	
	$this->Redirect2("index.php?module=calccash","","");	
	
//	$this->Redirect("index.php?module=calccsi","","");	
	}
	
	
}
?>