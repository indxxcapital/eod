<?php

class Viewca2 extends Application{

	function __construct()
	{
		parent::__construct();
	}
	
	
	function index()
	{
		
		$this->_baseTemplate="inner-template2";
	$this->_bodyTemplate="viewca2/index";
		$this->_title=$this->siteconfig->site_title;
		$this->_meta_description=$this->siteconfig->default_meta_description;
		$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
//	$this->addfield();

		$this->smarty->assign('pagetitle','Corporate Actions');
		$this->smarty->assign('bredcrumssubtitle','View Corporate Actions');

$this->addCss('assets/data-tables/DT_bootstrap.css');
$this->addJs('assets/bootstrap/bootstrap.min.js');
$this->addJs('assets/nicescroll/jquery.nicescroll.min.js');
$this->addJs('assets/data-tables/jquery.dataTables.js');
$this->addJs('assets/data-tables/DT_bootstrap.js');
$this->addJs('js/flaty.js');

	$tickerdata=$this->db->getResult("select ticker from tbl_indxx_ticker where id = '".$_GET['ticker_id']."' ",false,1);
	//$this->pr($tickerdata,true);
	
	
		$indexdata=$this->db->getResult("select tbl_ca.* from tbl_ca where identifier = '".$tickerdata['ticker']."' ",true);
		$this->smarty->assign("indexdata",$indexdata);
		
		//$indexdata2=$this->db->getResult("select tbl_ca_values.* from tbl_ca_values where ca_id = '".$_GET['ticker_id']."' ");
		//$this->smarty->assign("indexdata2",$indexdata2);

	//$this->pr($indexdata2,true);
	
		//$this->pr($_SESSION);
		 $this->show();
	}
	
	function addNew()
	{
			$this->_baseTemplate="inner-template2";
			$this->_bodyTemplate="casecurities/add";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','Index');
		$this->smarty->assign('bredcrumssubtitle','AddIndex');
		
		
		if(isset($_POST['submit']))
		{
		$this->db->query("INSERT into tbl_indxx_ticker set name='".mysql_real_escape_string($_POST['name'])."',isin='".mysql_real_escape_string($_POST['isin'])."',ticker='".mysql_real_escape_string($_POST['ticker'])."',weight='".mysql_real_escape_string($_POST['weight'])."',curr='".mysql_real_escape_string($_POST['curr'])."',indxx_id='".mysql_real_escape_string($_POST['indxx_id'])."'");
		
			$this->Redirect("index.php?module=casecurities&event=addNew","Record added successfully!!!","success");	
		}
		
	
			
			$this->addfield();
			 $this->show();
	}
	
	
	private function addfield()
	{	
	   $this->validData[]=array("feild_label" =>"Identifier",
	   								"feild_code" =>"identifier",
								 "feild_type" =>"text3",
								 "is_required" =>"1",
								
								 );
		 $this->validData[]=array("feild_label" =>"Mnemonic",
		 							"feild_code" =>"mnemonic",
								 "feild_type" =>"text3",
								 "is_required" =>"1",
								
								 );
								 
		 $this->validData[]=array("feild_label" =>"Company Name",
		 							"feild_code" =>"company_name",
								 "feild_type" =>"text3",
								 "is_required" =>"1",
								
								 );
								 
		 $this->validData[]=array("feild_label" =>"Effective Date",
		 							"feild_code" =>"eff_date",
								 "feild_type" =>"text3",
								 "is_required" =>"1",
								
								 );
	 /*<!--$this->validData[]=array("feild_label" =>"Index",
	 							"feild_code" =>"indxx_id",
								 "feild_type" =>"select",
								 "is_required" =>"1",
								 //"feild_tpl" =>"selectsearch",
								  "model"=>$this->getIndexes(),
								 );-->*/
								 
								 
	 $this->validData[]=array(	"feild_label"=>"Announce Date",
	 							"feild_code" =>"ann_date",
								 "feild_type" =>"text3",
								 "is_required" =>"1",
								
								 );	 
	
	$this->getValidFeilds();
	}
	
	
	
	 protected function view(){
		
		$this->_baseTemplate="inner-template2";
			$this->_bodyTemplate="viewca2/view";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','Index');
		$this->smarty->assign('bredcrumssubtitle','ViewIndex');
		
		$this->addCss('assets/data-tables/DT_bootstrap.css');
$this->addJs('assets/bootstrap/bootstrap.min.js');
$this->addJs('assets/nicescroll/jquery.nicescroll.min.js');
$this->addJs('assets/data-tables/jquery.dataTables.js');
$this->addJs('assets/data-tables/DT_bootstrap.js');
$this->addJs('js/flaty.js');
		$scflag=0;
	//	echo $this->_date;
//exit;
		$viewdata=$this->db->getResult("select tbl_ca.*  from tbl_ca where tbl_ca.id='".$_GET['id']."'",true);
		
				$viewdata2=$this->db->getResult("select tbl_ca_values.field_name,tbl_ca_values.field_value,tbl_ca_values.id as fieldid from  tbl_ca_values  where tbl_ca_values.ca_id='".$_GET['id']."'",true);
				
				$valuesArray=array();
				foreach($viewdata2 as $key=>$value)
				{
				//	echo "select * from  tbl_ca_action_fields_values  where tbl_ca_action_fields_values.field_name='".$value['field_name']."' and data='".$value['field_value']."'";
					
					
					if(($value['field_value']!='1001' && $value['field_name']=='CP_DVD_TYP') && $viewdata[0]['mnemonic']=="DVD_CASH" && $viewdata[0]['eff_date']==$this->_date)
						$scflag=1;
					$valuesArray[$key]=$value;
					$synonymvalues=$this->db->getResult("select * from  tbl_ca_action_fields_values  where tbl_ca_action_fields_values.field_name='".$value['field_name']."' and data='".str_replace("'","",$value['field_value'])."'",true);
					
					if(!empty($synonymvalues) && $synonymvalues['0']['value']!='Unknown')
					{
						//print_r($synonymvalues);
						$valuesArray[$key]['syn']=$synonymvalues['0']['value'];	
					}
					
				}
				//exit;
	//	$this->pr($viewdata,true);
	$tickers=$this->db->getResult("select distinct(indxx_id) from  tbl_indxx_ticker  where ticker like '".$viewdata[0]['identifier']."%'",true);
//	$this->pr($tickers,true);
	$liveindxx=array();
	$tempindxx=array();
	if(!empty($tickers))
	{
	foreach($tickers as $tic)
	{
	$liveindxx[]=$this->db->getResult("select * from  tbl_indxx  where id ='".$tic['indxx_id']."'");
	}
	}
	
	//$this->pr($liveindxx,true);
	
	//echo "select distinct(indxx_id) from  tbl_indxx_ticker_temp  where ticker like '%".$viewdata[0]['identifier']."%'";
	$tickers2=$this->db->getResult("select distinct(indxx_id) from  tbl_indxx_ticker_temp  where ticker like '".$viewdata[0]['identifier']."%'",true);
	//$this->pr($tickers2,true);
	if(!empty($tickers2))
	{
	foreach($tickers2 as $tic2)
	{
	$tempindxx[]=$this->db->getResult("select * from  tbl_indxx_temp  where id ='".$tic2['indxx_id']."'");
	}
	}
	
	
	
//$this->pr($liveindxx);
//$this->pr($tempindxx);
	
	//echo $scflag;
	//exit;
		$this->smarty->assign("scflag",$scflag);
		$this->smarty->assign("viewdata",$viewdata);
		$this->smarty->assign("viewdata2",$valuesArray);
		$this->smarty->assign("liveindxx",$liveindxx);
		$this->smarty->assign("tempindxx",$tempindxx);
		
		//$this->smarty->assign("synonymsArray",$valuesArray);
		
	
	if(!empty($_POST))
	{
//	$this->pr($_POST,true);
	$newStatus='';

if($_POST['submit'])
{	if($_POST['status']==1)
	{
		$this->db->query("UPDATE tbl_ca set status='0' where action_id='".$_POST['id']."'");
		
	}
	else{
		$this->db->query("UPDATE tbl_ca set status='1' where action_id='".$_POST['id']."'");
		
	}

}

if($_POST['scflagbtn'])
{
	if($_POST['spcash'])
	{
		
	//	echo "UPDATE tbl_ca_values set field_value='1001' where ca_action_id='".$_POST['id']."' and field_name='CP_DVD_TYP'";
$this->db->query("UPDATE tbl_ca_values set field_value='1001' where ca_action_id='".$_POST['id']."' and field_name='CP_DVD_TYP'");
//	exit;
	
	
	}
}
	
	
	if($_POST['iactive'])
{
		$this->Redirect("index.php?module=viewca&event=addinactiveRequest&id=".$_POST['caid']."&action_id=".$_POST['id'],'','');	
	
	}
	
	//if($_POST[''])
	$this->Redirect("index.php?module=viewca&event=view&id=".$_POST['caid'],"Record updated successfully!!!","success");	
	
	}
	
	
		//$this->pr($viewdata2,true);
		
		 $this->show();
			
	}
	
	
	function addinactiveRequest(){
	
	//$this->pr($_GET,true);
	$this->_baseTemplate="inner-template2";
	$this->_bodyTemplate="viewca2/addinactivereq";
	
	$this->addforInactivefield();
	
	}
	
	
	
		private function addforInactivefield()
	{	
	   $this->validData[]=array("feild_label" =>"Index",
	   								"feild_code" =>"index",
								 "feild_type" =>"select",
								 "is_required" =>"1",
								 );
								 	
	$this->getValidFeilds();
	
	}
	
	function viewtype(){
		
		
		
		$this->_baseTemplate="inner-template2";
	$this->_bodyTemplate="upcomingca/index";
		$this->_title=$this->siteconfig->site_title;
		$this->_meta_description=$this->siteconfig->default_meta_description;
		$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
//	$this->addfield();

		$this->smarty->assign('pagetitle','Corporate Action');
		$this->smarty->assign('bredcrumssubtitle','Corporate Action');

$this->addCss('assets/data-tables/DT_bootstrap.css');
$this->addJs('assets/bootstrap/bootstrap.min.js');
$this->addJs('assets/nicescroll/jquery.nicescroll.min.js');
$this->addJs('assets/data-tables/jquery.dataTables.js');
$this->addJs('assets/data-tables/DT_bootstrap.js');
$this->addJs('js/flaty.js');

 $dayesagodate=date('Y-m-d', strtotime($this->_date.'+7 days'));

		$indexdata=$this->db->getResult("SELECT * FROM `tbl_ca` WHERE mnemonic='".$_GET['id']."' and eff_date between '".date("Y-m-d")."' and '".$dayesagodate."'  ",true);
		$this->smarty->assign("indexdata",$indexdata);

	//$this->pr($indexdata,true);
	
		//$this->pr($_SESSION);
		 $this->show();
	
		
	
	}
	
	protected function viewcorporateactions(){
		 
		$this->_baseTemplate="inner-template2";
			$this->_bodyTemplate="viewca2/viewcorpac";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','Today');
		$this->smarty->assign('bredcrumssubtitle','Corporate Actions');
		
		$this->addCss('assets/data-tables/DT_bootstrap.css');
$this->addJs('assets/bootstrap/bootstrap.min.js');
$this->addJs('assets/nicescroll/jquery.nicescroll.min.js');
$this->addJs('assets/data-tables/jquery.dataTables.js');
$this->addJs('assets/data-tables/DT_bootstrap.js');
$this->addJs('js/flaty.js');
			
			
			if($_SESSION['User']['type']=='1')
	{
			
			
		$viewcorpaction=$this->db->getResult("select tbl_ca.company_name,tbl_ca.identifier,tbl_ca.mnemonic,tbl_ca.id as corpactionid ,tbl_assign_index.user_id,tbl_assign_index.indxx_id,tbl_indxx_ticker.ticker,tbl_ca_values.field_name,tbl_ca_values.field_value,tbl_ca_values.id as fieldid  from tbl_assign_index left join tbl_indxx_ticker on tbl_assign_index.indxx_id=tbl_indxx_ticker.indxx_id left join tbl_ca on tbl_ca.identifier=tbl_indxx_ticker.ticker left join tbl_ca_values on tbl_ca_values.ca_id=tbl_ca.id where tbl_ca.eff_date='".$this->_date."'",true);
		
	}
	
	else if($_SESSION['User']['type']=='2')
	{
			$viewcorpaction=$this->db->getResult("select tbl_ca.company_name,tbl_ca.identifier,tbl_ca.mnemonic,tbl_ca.id as corpactionid ,tbl_assign_index.user_id,tbl_assign_index.indxx_id,tbl_indxx_ticker.ticker,tbl_ca_values.field_name,tbl_ca_values.field_value,tbl_ca_values.id as fieldid  from tbl_assign_index left join tbl_indxx_ticker on tbl_assign_index.indxx_id=tbl_indxx_ticker.indxx_id left join tbl_ca on tbl_ca.identifier=tbl_indxx_ticker.ticker left join tbl_ca_values on tbl_ca_values.ca_id=tbl_ca.id where tbl_assign_index.user_id='".$_SESSION['User']['id']."' and tbl_ca.eff_date='".$this->_date."'",true);
	}
		
		$this->smarty->assign("viewcorpaction",$viewcorpaction);
		
		//$this->pr($viewdata,true);
		
		 $this->show();
			
	}
	
	protected function viewweeklycorporateactions(){
		 
		$this->_baseTemplate="inner-template2";
			$this->_bodyTemplate="viewca2/viewweeklyca";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','Today');
		$this->smarty->assign('bredcrumssubtitle','Corporate Actions');
		
		$this->addCss('assets/data-tables/DT_bootstrap.css');
$this->addJs('assets/bootstrap/bootstrap.min.js');
$this->addJs('assets/nicescroll/jquery.nicescroll.min.js');
$this->addJs('assets/data-tables/jquery.dataTables.js');
$this->addJs('assets/data-tables/DT_bootstrap.js');
$this->addJs('js/flaty.js');
		
		
		$date=date('Y-m-d', strtotime($this->_date.'+7 days'));
		
		if($_SESSION['User']['type']=='1')
	{
		
		$viewweeklyca=$this->db->getResult("select tbl_ca.company_name,tbl_ca.identifier,tbl_ca.mnemonic,tbl_ca.id as corpactionid ,tbl_assign_index.user_id,tbl_assign_index.indxx_id,tbl_indxx_ticker.ticker,tbl_ca_values.field_name,tbl_ca_values.field_value,tbl_ca_values.id as fieldid from tbl_assign_index left join tbl_indxx_ticker on tbl_assign_index.indxx_id=tbl_indxx_ticker.indxx_id left join tbl_ca on tbl_ca.identifier=tbl_indxx_ticker.ticker left join tbl_ca_values on tbl_ca_values.ca_id=tbl_ca.id where tbl_ca.eff_date between '".date("Y-m-d")."' and '".$date."'",true);
		
	}
	
	else if($_SESSION['User']['type']=='2')
	{
		
		$viewweeklyca=$this->db->getResult("select tbl_ca.company_name,tbl_ca.identifier,tbl_ca.mnemonic,tbl_ca.id as corpactionid ,tbl_assign_index.user_id,tbl_assign_index.indxx_id,tbl_indxx_ticker.ticker,tbl_ca_values.field_name,tbl_ca_values.field_value,tbl_ca_values.id as fieldid from tbl_assign_index left join tbl_indxx_ticker on tbl_assign_index.indxx_id=tbl_indxx_ticker.indxx_id left join tbl_ca on tbl_ca.identifier=tbl_indxx_ticker.ticker left join tbl_ca_values on tbl_ca_values.ca_id=tbl_ca.id where tbl_assign_index.user_id='".$_SESSION['User']['id']."' and tbl_ca.eff_date between '".date("Y-m-d")."' and '".$date."'",true);
		
		
	}
		
		$this->smarty->assign("viewweeklyca",$viewweeklyca);
		
		//$this->pr($viewdata,true);
		
		 $this->show();
			
	}
	
	
	
	
	protected function edit(){
		 
		$this->_baseTemplate="inner-template2";
			$this->_bodyTemplate="viewca2/edit";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','Index');
		$this->smarty->assign('bredcrumssubtitle','EditIndex');
		$this->addfield();
		
		
		if(isset($_POST['submit']))
		{
			
		$this->db->query("UPDATE tbl_ca set identifier='".mysql_real_escape_string($_POST['identifier'])."',mnemonic='".mysql_real_escape_string($_POST['mnemonic'])."',company_name='".mysql_real_escape_string($_POST['company_name'])."',eff_date='".mysql_real_escape_string($_POST['eff_date'])."',ann_date='".mysql_real_escape_string($_POST['ann_date'])."' where id='".$_GET['id']."'");
		
			$this->Redirect("index.php?module=viewca","Record updated successfully!!!","success");	
		}
		
		
		
		$editdata=$this->db->getResult("select tbl_ca.* from tbl_ca  where tbl_ca.id='".$_GET['id']."'");
		//$this->pr($editdata,true);
		$this->smarty->assign("postData",$editdata);
		
		
		
		
		 $this->show();
			
	}
	
	
	protected function delete(){
		
		
		
		$strQuery = "delete from tbl_ca where tbl_ca.id='".$_GET['id']."'";
			$this->db->query($strQuery);
			
		$strQuery2 = "delete from tbl_ca_values where tbl_ca_values.ca_id='".$_GET['id']."'";
			$this->db->query($strQuery2);
			
			$this->Redirect("index.php?module=casecurities","Record updated successfully!!!","success");
			
			$this->show();
		
	}
	
	
	
	function deleteindex()
	{
		//$this->pr($_POST);
	 
		foreach($_POST as $key=>$val)
		{
			foreach($val as $key2=>$val2)
			{
				if(!empty($val2))
				{
					
					$strQuery = "delete from tbl_ca where tbl_ca.id='".$_GET['id']."'";
					$this->db->query($strQuery);
					
					
					$strQuery2 = "delete from tbl_ca_values where tbl_ca_values.ca_id='".$val2."'";
					$this->db->query($strQuery2);
			
			}
			}
		}
		
		$this->Redirect("index.php?module=viewca","Records deleted successfully!!!","success");
		$this->show();	
	}
	
	
} // class ends here

?>