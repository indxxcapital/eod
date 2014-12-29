<?php

class Cashindextemp extends Application{

	function __construct()
	{
	$this->addCss('assets/data-tables/DT_bootstrap.css');
	$this->addJs('assets/bootstrap/bootstrap.min.js');
$this->addJs('assets/nicescroll/jquery.nicescroll.min.js');
$this->addJs('assets/data-tables/jquery.dataTables.js');
$this->addJs('assets/data-tables/DT_bootstrap.js');
$this->addJs('js/flaty.js');
	$this->checkUserSession();
		parent::__construct();
	}
	
	
	function index()
	{
		
		$this->_baseTemplate="inner-template";
	$this->_bodyTemplate="cashindex_temp/index";
		$this->_title=$this->siteconfig->site_title;
		$this->_meta_description=$this->siteconfig->default_meta_description;
		$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
//	$this->addfield();

		$this->smarty->assign('pagetitle','cash Index List');
		$this->smarty->assign('bredcrumssubtitle','cash Index list');




		$userdata1=$this->db->getResult("select tbl_cash_index_temp.* from tbl_cash_index_temp where 1=1 ",true);
		$this->smarty->assign("userdata1",$userdata1);

	//$this->pr($indexdata,true);
	
		//$this->pr($_SESSION);
		 $this->show();
	}
	
	function addNew()
	{
			$this->_baseTemplate="inner-template";
			$this->_bodyTemplate="cashindex/add";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','Database Users');
		$this->smarty->assign('bredcrumssubtitle','Add Database User');
		
		
		if(isset($_POST['submit']))
		{
		$this->db->query("INSERT into tbl_cash_index_temp set status='1',name='".mysql_real_escape_string($_POST['name'])."',code='".mysql_real_escape_string($_POST['code'])."',ticker='".mysql_real_escape_string($_POST['ticker'])."',isin='".mysql_real_escape_string($_POST['isin'])."',zone='".mysql_real_escape_string($_POST['zone'])."',client_id='".mysql_real_escape_string($_POST['client_id'])."',base_value='".mysql_real_escape_string($_POST['base_value'])."',dateStart='".mysql_real_escape_string($_POST['dateStart'])."'");
		$insert_id=mysql_insert_id();
		
		
		
		$this->db->query("INSERT into tbl_cash_indxx_value_temp set  	indxx_id='".$insert_id."',code='".mysql_real_escape_string($_POST['code'])."',date='".$this->_date."',indxx_value='".mysql_real_escape_string($_POST['base_value'])."'");
		
		$emailQueries='select email from tbl_database_users where status="1"';
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
		
	
		$msg='Hi '."<br>New cash Index ".$_POST['name']." added , Pleas visit  ". $this->siteconfig->base_url ." to download all cash isin to upload in cash Request File.<br> thanks ";
				$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'From: Indexing <indexing@indxx.com>' . "\r\n"."CC: indexing@indxx.com". "\r\n";
			//echo $emailsids;
		if(mail($emailsids,"New cash isin  ",$msg,$headers))
		{
			echo "Mail sent to : ".$to."<br>";	
		}
		}
		
			
			$this->Redirect("index.php?module=cashindex&event=addNew","Record added successfully!!!","success");	
		}
			
			$this->addfield();
			 $this->show();
	}
	
	
	private function addfield()
	{	
	   $this->validData[]=array("feild_label" =>"Name",
	   								"feild_code" =>"name",
								 "feild_type" =>"text",
								 "is_required" =>"1",
								
								 );
		 $this->validData[]=array("feild_label" =>"Code",
	   								"feild_code" =>"code",
								 "feild_type" =>"text",
								 "is_required" =>"1",
								
								 ); 
		$this->validData[]=array("feild_label" =>"Ticker",
	   								"feild_code" =>"ticker",
								 "feild_type" =>"text",
								 "is_required" =>"1",
								
								 );
		 $this->validData[]=array("feild_label" =>"ISIN",
		 							"feild_code" =>"isin",
								 "feild_type" =>"text",
								 "is_required" =>"1",
								
								 );
			 
		$this->validData[]=array("feild_label" =>"Zone",
	 							"feild_code" =>"zone",
								 "feild_type" =>"select",
								 "is_required" =>"1",
								 //"feild_tpl" =>"selectsearch",
								  "model"=>$this->getCalendarZone(),
								 );
	
	 $this->validData[]=array("feild_label" =>"Client",
	 							"feild_code" =>"client_id",
								 "feild_type" =>"select",
								 "is_required" =>"1",
								 //"feild_tpl" =>"selectsearch",
								  "model"=>$this->getAllClients(),
								 ); 
								 
		$this->validData[]=array("feild_label" =>"Base Index Value",
		 							"feild_code" =>"base_value",
								 "feild_type" =>"text",
								 "is_required" =>"1",
								 );					
								 
								 
	  $this->validData[]=array(	"feild_label"=>"Start Date",
	 							"feild_code" =>"dateStart",
								 "feild_type" =>"date",
								 "is_required" =>"1",
								);
									 
	
	$this->getValidFeilds();
	}
	
	
	function exportExcel()
	{
		
		require 'php-excel.class.php';
		
		//echo "select * from tbl_ca_user where 1=1";
		$excelres=mysql_query("select isin from tbl_cash_index union select isin from tbl_cash_index_temp ");
		$rowdata=array();
		while($exceldata=mysql_fetch_assoc($excelres))
		{
				//print_r($exceldata);
				$rowdata[]=array($exceldata['isin']."|ISIN");
		}

		
		// create a simple 2-dimensional array
		$data = array(
        1 => array ('isin'),
        //array('Schwarz', 'Oliver'),
        //array('Test', 'Peter')
        );
		
		
		//print_r($rowdata);
		//exit;
		
		// generate file (constructor parameters are optional)
		$xls = new Excel_XML('UTF-8', false, 'cash Index');
		$xls->addArray($data);
		foreach($rowdata as $key1=>$val1)
		{
			$excelarray = array(
        	1 => $val1,
        	);
			//print_r($excelarray);
			$xls->addArray($excelarray);
		}
		
		
		$xls->generateXML('cash_index');	
	}
	
	
	
	
	protected function edit(){
		 
		$this->_baseTemplate="inner-template";
			$this->_bodyTemplate="cashindex/edit";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','cash Index ');
		$this->smarty->assign('bredcrumssubtitle','Edit cash Index');
		$this->addfield();
		
		
		if(isset($_POST['submit']))
		{
			
		$this->db->query("insert into tbl_cash_index_temp set name='".mysql_real_escape_string($_POST['name'])."',code='".mysql_real_escape_string($_POST['code'])."',ticker='".mysql_real_escape_string($_POST['ticker'])."',isin='".mysql_real_escape_string($_POST['isin'])."',zone='".mysql_real_escape_string($_POST['zone'])."',client_id='".mysql_real_escape_string($_POST['client_id'])."',base_value='".mysql_real_escape_string($_POST['base_value'])."' ,dateStart='".mysql_real_escape_string($_POST['dateStart'])."'");
		
	$insert_id=mysql_insert_id();	
		
		$this->db->query("INSERT into tbl_cash_indxx_value_temp set  	indxx_id='".$insert_id."',code='".mysql_real_escape_string($_POST['code'])."',date='".$this->_date."',indxx_value='".mysql_real_escape_string($_POST['base_value'])."'");
		
			$emailQueries='select email from tbl_database_users where status="1"';
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
		
	
		$msg='Hi '."<br>Cash Index ".$_POST['name']." updated  , Please visit  ". $this->siteconfig->base_url ." to download all cash isin to upload in cash Request File.<br> thanks ";
				$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'From: Indexing <indexing@indxx.com>' . "\r\n"."CC: indexing@indxx.com". "\r\n";
			//echo $emailsids;
		if(mail($emailsids,"cash Index update ",$msg,$headers))
		{
			echo "Mail sent to : ".$to."<br>";	
		}
		}
		
		
			$this->Redirect("index.php?module=cashindex","Record updated successfully!!!","success");	
		}
		
		
		
		$editdata=$this->db->getResult("select tbl_cash_index_.* from tbl_cash_index  where tbl_cash_index.id='".$_GET['id']."'");
		//$this->pr($editdata,true);
		$this->smarty->assign("postData",$editdata);
		
		
		
		
		 $this->show();
			
	}
	
	
	
	protected function delete(){
		 
		
			$strQuery = "delete from tbl_cash_index_temp where tbl_cash_index.id='".$_GET['id']."'";
			$this->db->query($strQuery);
			$this->Redirect("index.php?module=cashindex_temp","Record deleted successfully!!!","success");
			
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
					
					$strQuery2 = "delete from tbl_cash_index_temp where tbl_cash_index.id='".$val2."'";
					$this->db->query($strQuery2);
			
			}
			}
		}
		
		$this->Redirect("index.php?module=cashindextemp","Records deleted successfully!!!","success");
		$this->show();	
	}
	
	function view(){
		
			$this->_baseTemplate="inner-template";
			$this->_bodyTemplate="cashindex_temp/view";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','cash Index ');
		$this->smarty->assign('bredcrumssubtitle','View cash Index');
		
	$editdata=$this->db->getResult("select tbl_cash_index_temp.* from tbl_cash_index_temp  where tbl_cash_index_temp.id='".$_GET['id']."'",false,1);
		//$this->pr($editdata,true);
		$this->smarty->assign("data",$editdata);
		
		
		
		
		 $this->show();
	}
	
	
	function approve(){
	$strQuery = "update  tbl_cash_index_temp set db_approve='1' where tbl_cash_index_temp.id='".$_GET['id']."'";
			$this->db->query($strQuery);
				$this->Redirect("index.php?module=cashindextemp","Records deleted successfully!!!","success");
		$this->show();
	}
	
	
	
} // class ends here

?>