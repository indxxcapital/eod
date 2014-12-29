<?php

class Itusers extends Application{

	function __construct()
	{
		parent::__construct();
		$this->checkUserSession();
	
$this->addCss('assets/data-tables/DT_bootstrap.css');
$this->addJs('assets/bootstrap/bootstrap.min.js');
$this->addJs('assets/nicescroll/jquery.nicescroll.min.js');
$this->addJs('assets/data-tables/jquery.dataTables.js');
$this->addJs('assets/data-tables/DT_bootstrap.js');
$this->addJs('js/flaty.js');
	}
	
	
	function index()
	{
		
		$this->_baseTemplate="inner-template";
	$this->_bodyTemplate="it/index";
		$this->_title=$this->siteconfig->site_title;
		$this->_meta_description=$this->siteconfig->default_meta_description;
		$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
//	$this->addfield();

		$this->smarty->assign('pagetitle','it Users List');
		$this->smarty->assign('bredcrumssubtitle','it Users');




		$userdata1=$this->db->getResult("select tbl_it_users.* from tbl_it_users where 1=1 ",true);
		$this->smarty->assign("userdata1",$userdata1);

	//$this->pr($indexdata,true);
	
		//$this->pr($_SESSION);
		 $this->show();
	}
	
	function addNew()
	{
			$this->_baseTemplate="inner-template";
			$this->_bodyTemplate="it/add";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','it Users');
		$this->smarty->assign('bredcrumssubtitle','Add it User');
		
		
		if(isset($_POST['submit']))
		{
		$this->db->query("INSERT into tbl_it_users set status='1',name='".mysql_real_escape_string($_POST['name'])."',email='".mysql_real_escape_string($_POST['email'])."',password='".mysql_real_escape_string($_POST['password'])."'");
		
				$msg='Hi '.$_POST['name'].', You are added to ICAI Portal as it User, <br> Login Email  : '.$_POST['email']."<br>Login Passowrd : ".$_POST['password']."<br> Please Visit <a href='". $this->siteconfig->base_url ."'>". $this->siteconfig->base_url ."</a><br> thanks ";
				$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'From: Indexing <indexing@indxx.com>' . "\r\n"."CC: indexing@indxx.com". "\r\n";		
		if(mail($_POST['email'],"ICAI it Account Details ",$msg,$headers))
		{
			echo "Mail sent to : ".$to."<br>";	
		}
			//exit;
			
			$this->Redirect("index.php?module=itusers","Record added successfully!!!","success");	
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
		 $this->validData[]=array("feild_label" =>"Email",
		 							"feild_code" =>"email",
								 "feild_type" =>"text",
								 "is_required" =>"1",
								
								 );
		$this->validData[]=array("feild_label" =>"Password",
		 							"feild_code" =>"password",
								 "feild_type" =>"password",
								 "is_required" =>"1",
								
								 );				 
		
								 
								 
	
	$this->getValidFeilds();
	}
	
	
	function exportExcel()
	{
		
		require 'php-excel.class.php';
		
		//echo "select * from tbl_ca_user where 1=1";
		$excelres=mysql_query("select tbl_ca_user.*,tbl_indxx.name as indexname, tbl_user_types.name as usertypes from tbl_ca_user left join tbl_indxx on tbl_indxx.id=tbl_ca_user.indxx_id left join tbl_user_types on tbl_user_types.id=tbl_ca_user.type where 1=1");
		$rowdata=array();
		while($exceldata=mysql_fetch_assoc($excelres))
		{
				//print_r($exceldata);
				$rowdata[]=array($exceldata['name'],$exceldata['email'],$exceldata['usertypes'],$exceldata['indexname']);
		}

		
		// create a simple 2-dimensional array
		$data = array(
        1 => array ('Name', 'Email', 'Type', 'Index'),
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
	
	
	
	
	protected function edit(){
		 
		$this->_baseTemplate="inner-template";
			$this->_bodyTemplate="it/edit";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','it Users');
		$this->smarty->assign('bredcrumssubtitle','Edit it Users');
		$this->addfield();
		
		
		if(isset($_POST['submit']))
		{
			
		$this->db->query("UPDATE tbl_it_users set name='".mysql_real_escape_string($_POST['name'])."',email='".mysql_real_escape_string($_POST['email'])."' where id='".$_GET['id']."'");
		
			$this->Redirect("index.php?module=itusers","Record updated successfully!!!","success");	
		}
		
		
		
		$editdata=$this->db->getResult("select tbl_it_users.* from tbl_it_users  where tbl_it_users.id='".$_GET['id']."'");
		//$this->pr($editdata,true);
		$this->smarty->assign("postData",$editdata);
		
		
		
		
		 $this->show();
			
	}
	
	
	
	protected function delete(){
		 
		
			$strQuery = "delete from tbl_it_users where tbl_it_users.id='".$_GET['id']."'";
			$this->db->query($strQuery);
			$this->Redirect("index.php?module=itusers","Record deleted successfully!!!","success");
			
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
					
					$strQuery2 = "delete from tbl_it_users where tbl_it_users.id='".$val2."'";
					$this->db->query($strQuery2);
			
			}
			}
		}
		
		$this->Redirect("index.php?module=itusers","Records deleted successfully!!!","success");
		$this->show();	
	}
	
	
} // class ends here

?>