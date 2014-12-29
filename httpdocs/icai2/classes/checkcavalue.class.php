<?php

class Checkcavalue extends Application{

	function __construct()
	{
		parent::__construct();
	}
	
	
	function index()
	{
		
		
		
	//$this->pr($_SESSION,true);
		
		//$this->_baseTemplate="main-template";
		//$this->_bodyTemplate="404";
		$this->_title=$this->siteconfig->site_title;
		$this->_meta_description=$this->siteconfig->default_meta_description;
		$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
		
		//echo "select tbl_indxx.* from tbl_indxx  where status='1' and usersignoff='1' and dbusersignoff='1' and submitted='1 and id='1'";
		$indxxs=$this->db->getResult("select tbl_indxx.* from tbl_indxx  where status='1' and usersignoff='1' and dbusersignoff='1' and submitted='1' ",true);	
		
		
		$checkArray=array();
		$checkArray['DVD_CASH']=array('CP_NET_AMT','CP_GROSS_AMT','CP_DVD_CRNCY','CP_DVD_TYP');
		$checkArray['CHG_NAME']=array('CP_OLD_NAME','CP_NEW_NAME');
		$checkArray['CHG_ID']=array('CP_OLD_ISIN','CP_NEW_ISIN');
		$checkArray['SPIN']=array('CP_ADJ');
		$checkArray['DVD_STOCK']=array('CP_AMT');
		$checkArray['STOCK_SPLT']=array('CP_ADJ');
		$checkArray['RIGHTS_OFFER']=array('CP_RATIO','CP_ADJ','CP_PX','CP_CRNCY');		
		 $datevalue2=$this->_date;
		//$this->pr($checkArray,true);
		 
		 //print_r(array_keys($checkArray));
		 //exit;
		 $text='';
		 
	$final_array=array();
		
		if(!empty($indxxs))
		{
			foreach($indxxs as $row)
			{
					if($this->checkHoliday($row['zone'], $datevalue2)){
			$final_array[$row['id']]=$row;
			

			
		
			
			
			//echo $datevalue;
		//	exit;
			$query="SELECT  it.ticker  FROM `tbl_indxx_ticker` it where it.indxx_id='".$row['id']."'";			
		
		
		
			$indxxprices=	$this->db->getResult($query,true);
			//$this->pr($indxxprices,true);	
			if(!empty($indxxprices))
			{
			foreach($indxxprices as $key=> $indxxprice)
			{
		  $ca_query="select identifier,action_id,id,mnemonic,company_name,eff_date,currency from tbl_ca cat where  eff_date='".$datevalue2."' and identifier='".$indxxprice['ticker']."' ";
			
			//exit;
			$cas=$this->db->getResult($ca_query,true);	
			
	//		echo "<br>";
			//$caflag=false;
			
			
			if(!empty($cas))
			{
			foreach($cas as $cakey=> $ca)
			{
			
			
			
		
		if(array_key_exists($ca['mnemonic'],$checkArray))
		{
		foreach($checkArray[$ca['mnemonic']] as $fieldname)
		{
			
				 $ca_value_query="Select id from tbl_ca_values where ca_id='".$ca['id']."'  and ca_action_id='".$ca['action_id']."' and field_name='".$fieldname."' ";
			$ca_values=$this->db->getResult($ca_value_query);	
			if( count($ca_values)<=0)
			{
			$text.=$ca['company_name']."(".$ca['identifier'].")=>".$_SESSION['variable'][$ca['mnemonic']]."=>".$_SESSION['variable'][$fieldname]."=>".$fieldname."<br>";
			}
						
		}
		
		}
			
			
		
			
			}
			}
			
			
			$indxxprices[$key]['ca']=$cas;
			}
			}
			
		//	$final_array[$row['id']]['values']=$indxxprices;
		
		
	//$this->pr($indxxprices);	
			
					}
			}	
		
		}
	//	}
	//echo $text;
//exit;
if($text!='' && $text)
{
	
	$useremails=$this->db->getResult("select email from tbl_ca_user where 1=1",true);
	$emailids=array();
	foreach($useremails as $key=>$users)
	{
		$emailids[]=$users['email'];
	}
	
	$to=implode(',',$emailids);
	$from = "Indexing <indexing@indxx.com>"; 
    $subject ="Corporate Actions Value Not Inserted"; 
    $message = 'Hi <br>';
	$message.='Values for following corporate actions has not been inserted :<br>' ;
	$message.=$text;
	$message.='Thanks.';
	
    $headers = "From: $from" . "\r\n"."CC: indexing@indxx.com". "\r\n";
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
	mail($to,$subject,$message,$headers);
	
}

	
	
	
$this->saveProcess();

$this->Redirect("index.php?module=calcspinstockadd","","");	



}
   
} 
?>