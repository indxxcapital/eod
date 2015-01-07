<?php

class Benchmarkindex extends Application{

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
	$this->_bodyTemplate="benchmarkindex/index";
		$this->_title=$this->siteconfig->site_title;
		$this->_meta_description=$this->siteconfig->default_meta_description;
		$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
//	$this->addfield();

		$this->smarty->assign('pagetitle','Benchmark Index List');
		$this->smarty->assign('bredcrumssubtitle','Benchmark Index list');




		$userdata1=$this->db->getResult("select tbl_benchmark_index.* from tbl_benchmark_index where 1=1 ",true);
		$this->smarty->assign("userdata1",$userdata1);

	//$this->pr($indexdata,true);
	
		//$this->pr($_SESSION);
		 $this->show();
	}
	
	function addNew()
	{
			$this->_baseTemplate="inner-template";
			$this->_bodyTemplate="benchmarkindex/add";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','Database Users');
		$this->smarty->assign('bredcrumssubtitle','Add Database User');
		
		
		if(isset($_POST['submit']))
		{
		$this->db->query("INSERT into tbl_benchmark_index set status='1',name='".mysql_real_escape_string($_POST['name'])."',ticker='".mysql_real_escape_string($_POST['ticker'])."'");
		
		
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
		
	
		$msg='Hi '."<br>New Benchmark Ticker ".$_POST['name']." added , Pleas visit  ". $this->siteconfig->base_url ." to download all Benchmark tickers to upload in Benchmark Request File.<br> thanks ";
				$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'From: Indexing <indexing@indxx.com>' . "\r\n"."CC: indexing@indxx.com". "\r\n";
			//echo $emailsids;
		if(mail($emailsids,"New Benchmark Ticker  ",$msg,$headers))
		{
			echo "Mail sent to : ".$to."<br>";	
		}
		}
		
			
			$this->Redirect("index.php?module=benchmarkindex&event=addNew","Record added successfully!!!","success");	
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
		 $this->validData[]=array("feild_label" =>"Ticker",
		 							"feild_code" =>"ticker",
								 "feild_type" =>"text",
								 "is_required" =>"1",
								
								 );
			 
		
								 
								 
	
	$this->getValidFeilds();
	}
	
	
	function exportExcel()
	{
		
		require 'php-excel.class.php';
		
		//echo "select * from tbl_ca_user where 1=1";
		$excelres=mysql_query("select ticker from tbl_benchmark_index");
		$rowdata=array();
		while($exceldata=mysql_fetch_assoc($excelres))
		{
				//print_r($exceldata);
				$rowdata[]=array($exceldata['ticker']);
		}

		
		// create a simple 2-dimensional array
		$data = array(
        1 => array ('Ticker'),
        //array('Schwarz', 'Oliver'),
        //array('Test', 'Peter')
        );
		
		// generate file (constructor parameters are optional)
		$xls = new Excel_XML('UTF-8', false, 'Benchmark Index');
		$xls->addArray($data);
		foreach($rowdata as $key1=>$val1)
		{
			$excelarray = array(
        	1 => $val1,
        	);
			//print_r($excelarray);
			$xls->addArray($excelarray);
		}
		
		
		$xls->generateXML('Benchmark_index');	
	}
	
	
	
	
	protected function edit(){
		 
		$this->_baseTemplate="inner-template";
			$this->_bodyTemplate="benchmarkindex/edit";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','Benchmark Index ');
		$this->smarty->assign('bredcrumssubtitle','Edit Benchmark Index');
		$this->addfield();
		
		
		if(isset($_POST['submit']))
		{
			
		$this->db->query("UPDATE tbl_benchmark_index set name='".mysql_real_escape_string($_POST['name'])."',ticker='".mysql_real_escape_string($_POST['ticker'])."' where id='".$_GET['id']."'");
		
		
		
		
		
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
		
	
		$msg='Hi '."<br>Benchmark Ticker ".$_POST['name']." updated  , Please visit  ". $this->siteconfig->base_url ." to download all Benchmark tickers to upload in Benchmark Request File.<br> thanks ";
				$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'From: Indexing <indexing@indxx.com>' . "\r\n"."CC: indexing@indxx.com". "\r\n";
			//echo $emailsids;
		if(mail($emailsids,"Benchmark Ticker update ",$msg,$headers))
		{
			echo "Mail sent to : ".$to."<br>";	
		}
		}
		
		
			$this->Redirect("index.php?module=benchmarkindex","Record updated successfully!!!","success");	
		}
		
		
		
		$editdata=$this->db->getResult("select tbl_benchmark_index.* from tbl_benchmark_index  where tbl_benchmark_index.id='".$_GET['id']."'");
		//$this->pr($editdata,true);
		$this->smarty->assign("postData",$editdata);
		
		
		
		
		 $this->show();
			
	}
	
	
	
	protected function delete(){
		 
		
			$strQuery = "delete from tbl_benchmark_index where tbl_benchmark_index.id='".$_GET['id']."'";
			$this->db->query($strQuery);
			$this->Redirect("index.php?module=benchmarkindex","Record deleted successfully!!!","success");
			
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
					
					$strQuery2 = "delete from tbl_benchmark_index where tbl_benchmark_index.id='".$val2."'";
					$this->db->query($strQuery2);
			
			}
			}
		}
		
		$this->Redirect("index.php?module=benchmarkindex","Records deleted successfully!!!","success");
		$this->show();	
	}
	
	
} // class ends here

?>