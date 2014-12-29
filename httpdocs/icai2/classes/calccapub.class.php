<?php 

class Calccapub extends Application{
		
		function __construct()
		{
		parent::__construct();
		}
		function index(){
		
		
		//$this->pr($_SESSION);
		
		$indxx=	$this->db->getResult("select tbl_indxx.* from tbl_indxx  where status='1' and usersignoff='1' and dbusersignoff='1' and submitted='1' ",	true);
	//$this->pr($indxx);
	
	$clients=array();
	
		$array=array();
		
		if(!empty($indxx))
		{
		foreach($indxx as $ind)
		{
			
			$client=$this->db->getResult("select tbl_ca_client.ftpusername from tbl_ca_client where id='".$ind['client_id']."'",false,1);	
		//	
		//$final_array[$row['id']]['client']=$client['ftpusername'];
			
			
			
	//	$this->pr($ind);
		$indxxticker=	$this->db->getResult("select distinct(ticker) as indxxticker from tbl_indxx_ticker where indxx_id ='".$ind['id']."'",	true);
		
$entry='';
$entry1='';
$entry.='Index Name'.";";
$entry.=$ind['name'].";";		
$entry.="\n";		
$entry.='Security Ticker'.";";		
$entry.='Company Ticker'.";";	
$entry.='ISIN'.";";
$entry.='Action'.";";
$entry.='Ex Date'.";";		
$entry.='Amount'.";";		
$entry.='Currency;';		
$entry.='Further Details;';		
$entry.='Factor;';		
$entry.="\n";
$entry1.='Index Name'.";";		
$entry1.='Security Ticker'.";";		
$entry1.='Company Ticker'.";";	
$entry1.='ISIN'.";";
$entry1.='Action'.";";
$entry1.='Ex Date'.";";		
$entry1.='Amount'.";";		
$entry1.='Currency;';		
$entry1.='Further Details;';		
$entry1.='Factor;';		
$entry1.="\n";		
	$clients[$client['ftpusername']]['heading']=$entry1;
		//$clients[$client['ftpusername']].=$entry1;	
		//$clients[$client['ftpusername']]['value'].=$ind['name'].";";
		if(!empty($indxxticker))
		{
		foreach($indxxticker as $ticker)
		{
			$castr=$this->getCaStr3($ticker['indxxticker'],$this->_date);
			
			$entry.=$castr;
			$clients[$client['ftpusername']]['value'].=$this->getCaStr3($ticker['indxxticker'],$this->_date,$ind['name']);
	
		
		
		}
		}
		
		
		if($client['ftpusername'])
		$file="../files2/ca-output/".$client['ftpusername']."/ca-".$ind['code']."-".$this->_date.".txt";
		else
		$file="../files2/ca-output/ca-".$ind['code']."-".$this->_date.".txt";
		
		
		
		
		
	//	$clients[$client['ftpusername']].=$entry1;
		
		
		
		
		
		
		$open=fopen($file,"w+");
	if($open){   
		if(   fwrite($open,$entry))
		{
			echo "file Written for ".$ind['code']."<br>";
		}
	}
		
		
			//	$this->pr($ca_array);
		}
		}
		
		
		
		//$this->pr($clients,true);
		if(!empty($clients))
		{
		foreach($clients as $clientname=> $caclients)
		{
			$file2="../files2/ca-output/".$clientname."/composit-ca-".$this->_date.".txt";
			
		$open2=fopen($file2,"w+");
	if($open2){   
		if(   fwrite($open2,$caclients['heading'].$caclients['value']))
		{
			echo "file Written for Composit Index<br>";
		}
	}
		}
		}
		
		
		$this->saveProcess();
		$this->Redirect("index.php?module=checkcavalue","","");	
		}
		
		
}