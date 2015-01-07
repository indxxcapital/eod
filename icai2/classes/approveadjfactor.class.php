<?php

class Approveadjfactor extends Application{

	function __construct()
	{
		parent::__construct();
		$this->checkUserSession();
	}
	
	
	function index()
	{
		
		$this->_baseTemplate="inner-template";
	$this->_bodyTemplate="caindex/approveadjfac";
		$this->_title=$this->siteconfig->site_title;
		$this->_meta_description=$this->siteconfig->default_meta_description;
		$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
//	$this->addfield();

		$this->smarty->assign('pagetitle','Approve');
		$this->smarty->assign('bredcrumssubtitle','Adjustment Factor');

$this->addCss('assets/data-tables/DT_bootstrap.css');
$this->addJs('assets/bootstrap/bootstrap.min.js');
$this->addJs('assets/nicescroll/jquery.nicescroll.min.js');
$this->addJs('assets/data-tables/jquery.dataTables.js');
$this->addJs('assets/data-tables/DT_bootstrap.js');
$this->addJs('js/flaty.js');



		$adjfactordata=$this->db->getResult("SELECT * FROM `tbl_user_ca_adj_factor` WHERE date='".date("Y-m-d")."'",true);
		$indexes=array();
		if(!empty($adjfactordata))
		{
		foreach($adjfactordata as $key=>$value)
		{
			$tickerdetails=$this->db->getResult("select tbl_indxx_ticker.name,tbl_indxx_ticker.ticker from  tbl_indxx_ticker  where tbl_indxx_ticker.id='".$value['ticker_id']."'",true);
						
			$indexdetails=$this->db->getResult("select tbl_indxx.name from  tbl_indxx  where tbl_indxx.id='".$value['indxx_id']."'",true);
			
			
			if(!empty($indexdetails['0']['name']) || !empty($tickerdetails['0']['name']) || !empty($tickerdetails['0']['ticker']))
			
			$indexdata[$indexdetails['0']['name']][$value['id']][$tickerdetails['0']['ticker']]['factor']=$value['factor'];
			$indexdata[$indexdetails['0']['name']][$value['id']][$tickerdetails['0']['ticker']]['status']=$value['status'];
		}
		}
	
		//$this->pr($indexdata,true);

		$this->smarty->assign("adjfactordata",$indexdata);
		

	//$this->pr($indexdata,true);
	
		//$this->pr($_SESSION);
		 $this->show();
	}
	
	
	function approve()
	{
				
			if($_SESSION['User']['type']=='1' && $_GET['id'])
		{
		
		$users=$this->db->getResult('Select user_id,ticker_id from tbl_user_ca_adj_factor where id="'.$_GET['id'].'"',true);
		
		$ticker=$this->db->getResult('Select ticker from tbl_indxx_ticker where id="'.$users['0']['ticker_id'].'"',true);
				
		$this->db->query("UPDATE tbl_user_ca_adj_factor set status='1' where tbl_user_ca_adj_factor.id='".$_GET['id']."'");
		
	$admins =	$this->db->getResult('Select  email from tbl_ca_user where id='.$users['0']['user_id'].'',true);
	
//$this->pr($admins,true);	
	
	$user=array();
	if(!empty($admins))	
	foreach($admins as $admin)
	{
	$user[]=$admin['email'];
	}
		
  $to=implode(',',$user);		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'From: Indexing <indexing@indxx.com>' . "\r\n"."CC: indexing@indxx.com". "\r\n";
$body='Hi <br>';
$body.='Adjustment Factor for ticker '.$ticker['0']['ticker'].' has been approved by admin.<br>Thanks ';


		mail($to,"ICAI : Adjustment Factor Approved " ,$body,$headers);
		
		
		
		
		
		
		}
		else
		{
				$this->Redirect("index.php?module=approveadjfactor","You are not authorized to perofrm this task!","error");
		}
		
		
		$this->Redirect("index.php?module=approveadjfactor","Adjustment Factor approved succesfully!","success");
		
		 $this->show();	
	}	
	
	
	
		function approveassigned()
	{
		
	
	$finalArray=array();
	$userdetailsArray=array();
	$userfilesArray=array();
		if($_SESSION['User']['type']=='1')
		{
				foreach($_POST as $key=>$val)
			{
				foreach($val as $key2=>$val2)
				{
					if(!empty($val2))
					{
							
						$this->db->query("UPDATE tbl_user_ca_adj_factor set status='1' where tbl_user_ca_adj_factor.id='".$val2."'");
						
						$tickerdetails=$this->db->getResult("select user_id,ticker_id from tbl_user_ca_adj_factor where id='".$val2."'",true);
						
						$userdetailsArray[$tickerdetails['0']['user_id']][]=$tickerdetails['0']['ticker_id'];
						
					}
				}
			}
					foreach($userdetailsArray as $userid=>$tickerids)
					{
						
						
						$admins =$this->db->getResult('Select email from tbl_ca_user where id="'.$userid.'"',true);	
						$to=$admins['0']['email'];
										  
						$headers  = 'MIME-Version: 1.0' . "\r\n";
						$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					
						// Additional headers
						$headers .= 'From: Indexing <indexing@indxx.com>' . "\r\n"."CC: indexing@indxx.com". "\r\n";
						$body='Hi <br>';
						$body.='Adjustment Factor for following tickers has been approved by admin : <br>';
						
						foreach($tickerids as $keyticker=>$tickerid)
						{
							$ticker=$this->db->getResult("select ticker from tbl_indxx_ticker where id='".$tickerid."'",true);
							$body.=$ticker['0']['ticker']."<br>";	
						}
						
						$body.='Thanks ';
					
					
					
							mail($to,"ICAI : Adjustment Factor Approved " ,$body,$headers);
									
		
					}
					
					
		}
			
		

			$this->Redirect("index.php?module=approveadjfactor","Adjustment Factor approved successfully!!!","success");		
	
	
		
	}
	
	
} // class ends here

?>