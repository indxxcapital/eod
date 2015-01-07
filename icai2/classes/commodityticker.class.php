<?php

class Commodityticker extends Application{

	function __construct()
	{
		parent::__construct();
		
	$this->addCss('assets/data-tables/DT_bootstrap.css');
$this->addJs('assets/bootstrap/bootstrap.min.js');
$this->addJs('assets/nicescroll/jquery.nicescroll.min.js');
$this->addJs('assets/data-tables/jquery.dataTables.js');
$this->addJs('assets/data-tables/DT_bootstrap.js');
$this->addJs('js/flaty.js');
		$this->checkUserSession();
	}
	
	
	function index()
	{
		
		$this->_baseTemplate="inner-template";
	$this->_bodyTemplate="commodity/index";
		$this->_title=$this->siteconfig->site_title;
		$this->_meta_description=$this->siteconfig->default_meta_description;
		$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
//	$this->addfield();

		$this->smarty->assign('pagetitle','Commodity Ticker List');
		$this->smarty->assign('bredcrumssubtitle','Commodity Ticker');



		
		$userdata=$this->db->getResult("select * from tbl_commodity_ticker " ,true);
		
		$this->smarty->assign("tickerdata",$userdata);

	//$this->pr($userdata,true);
	
		//$this->pr($_SESSION);
		 $this->show();
	}
	
	
	function addNew()
	{
			$this->_baseTemplate="inner-template";
			$this->_bodyTemplate="commodity/add";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','Users');
		$this->smarty->assign('bredcrumssubtitle','AddUser');
		
		
		if(isset($_POST['submit']))
		{
		$this->db->query("INSERT into tbl_commodity_ticker set name='".mysql_real_escape_string($_POST['name'])."',code='".mysql_real_escape_string($_POST['code'])."'");
	
		$emailQueries='select email from tbl_ca_user where status="1" and type="1"';
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
		
	
		$msg='Hi '."<br>New Commodity Ticker ".$_POST['name']." added , Please Visit ". $this->siteconfig->base_url ." to approve .<br> thanks ";
				$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'From: Indexing <indexing@indxx.com>' . "\r\n"."CC: indexing@indxx.com". "\r\n";
			//echo $emailsids;
		if(mail( $emailsids	,"New Commodity Ticker  ",$msg,$headers))
		{
			echo "Mail sent to : ".$to."<br>";	
		}
		}
		
			$this->Redirect("index.php?module=commodityticker","Record added successfully!!!","success");	
		}
			
			$this->addfield();
			 $this->show();
	}
	
	
	private function addfield($edit=false)
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
			
					 
		

								 
								 
	
								 
	
	$this->getValidFeilds();
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
					$strQuery1 = "delete from tbl_commodity_ticker where id='".$val2."'";
					$this->db->query($strQuery1);
					
					
					
			}
			}
		}
		$this->Redirect("index.php?module=commodityticker","Records deleted successfully!!!","success");
		$this->show();	
	}
	
	
	
	protected function delete(){
		
		 	$strQuery1 = "delete from tbl_commodity_ticker where id='".$_GET['id']."'";
					$this->db->query($strQuery1);
					
									
			
			
			$this->Redirect("index.php?module=commodityticker","Record deleted successfully!!!","success");
			
			$this->show();
			
			
	}
	
	
		
	function exportExcel()
	{
		
		require 'php-excel.class.php';
		
		//echo "select * from tbl_ca_user where 1=1";
		$excelres=mysql_query("select * from tbl_commodity_ticker where status ='1' and dbstatus='1'");
		$rowdata=array();
		while($exceldata=mysql_fetch_assoc($excelres))
		{
				//print_r($exceldata);
				$rowdata[]=array($exceldata['name'],$exceldata['code']);
		}

		
		// create a simple 2-dimensional array
		$data = array(
        1 => array ('Name', 'Code'),
        //array('Schwarz', 'Oliver'),
        //array('Test', 'Peter')
        );
		
		// generate file (constructor parameters are optional)
		$xls = new Excel_XML('UTF-8', false, 'User Data');
		$xls->addArray($data);
		foreach($rowdata as $key1=>$val1)
		{
			$excelarray = array(
        	1 => $val1,
        	);
			//print_r($excelarray);
			$xls->addArray($excelarray);
		}
		
		
		$xls->generateXML('UserData');	
	}
	function view(){
		$strQuery1 = "select * from tbl_commodity_ticker where id='".$_GET['id']."'";
			$userdata=		$this->db->getResult($strQuery1);
					
		$this->_baseTemplate="inner-template";
	$this->_bodyTemplate="commodity/view";
		$this->_title=$this->siteconfig->site_title;
		$this->_meta_description=$this->siteconfig->default_meta_description;
		$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
//	$this->addfield();

if($_POST['submit']  && $_POST['statusfield'])
{
	$strQuery1 = "update  tbl_commodity_ticker set status='1' where id='".$_POST['id']."'";
					$this->db->query($strQuery1);



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
		
	
		$msg='Hi '."<br>New Commodity Ticker ".$_POST['name']." added , Please Upload on Request File and visit  ". $this->siteconfig->base_url ." to approve .<br> thanks ";
				$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'From: Indexing <indexing@indxx.com>' . "\r\n"."CC: indexing@indxx.com". "\r\n";
			//echo $emailsids;
		if(mail($emailsids,"New Commodity Ticker  ",$msg,$headers))
		{
			echo "Mail sent to : ".$to."<br>";	
		}
		}

$this->Redirect("index.php?module=commodityticker","Record updated successfully!!!","success");
//$this->pr($_POST,true);
}
if($_POST['submit']  && $_POST['dbstatusfield'])
{
	$strQuery1 = "update  tbl_commodity_ticker set dbstatus='1' where id='".$_POST['id']."'";
					$this->db->query($strQuery1);


$this->Redirect("index.php?module=commodityticker","Record Updated successfully!!!","success");
//$this->pr($_POST,true);
}


		$this->smarty->assign('pagetitle','Commodity Ticker List');
		$this->smarty->assign('bredcrumssubtitle','Commodity Ticker');
			$this->smarty->assign("tickerdata",$userdata);

		 $this->show();
	}
}
?>