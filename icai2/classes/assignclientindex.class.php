<?php

class Assignclientindex extends Application{

	function __construct()
	{
		parent::__construct();
		
		$this->checkUserSession();
	}
	
	
		
	function index()
	{
		
		$this->_baseTemplate="inner-template";
	$this->_bodyTemplate="assignclientindex/index";
		$this->_title=$this->siteconfig->site_title;
		$this->_meta_description=$this->siteconfig->default_meta_description;
		$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
//	$this->addfield();

		$this->smarty->assign('pagetitle','Assign Index');
		$this->smarty->assign('bredcrumssubtitle','Assign Index');

$this->addCss('assets/data-tables/DT_bootstrap.css');
$this->addJs('assets/bootstrap/bootstrap.min.js');
$this->addJs('assets/nicescroll/jquery.nicescroll.min.js');
$this->addJs('assets/data-tables/jquery.dataTables.js');
$this->addJs('assets/data-tables/DT_bootstrap.js');
$this->addJs('js/flaty.js');




		if(isset($_POST['submit']))
		{
			foreach($_POST['indxx_id'] as $key=>$val)
			{
				$indexexists=$this->checkClientIndex($_POST['user_id'],$val);
				
				if($indexexists=='false')
				{				
			$this->db->query("INSERT into tbl_client_index set user_id='".mysql_real_escape_string($_POST['user_id'])."',indxx_id='".mysql_real_escape_string($val)."'");
				}
			
			}
			$this->Redirect("index.php?module=clients","Record added successfully!!!","success");	
		}
		
			$this->addfield($_GET['id']);
			 $this->show();

	}
	
	
	function addNew()
	{
			$this->_baseTemplate="inner-template";
			$this->_bodyTemplate="assignclientindex/add";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','Index');
		$this->smarty->assign('bredcrumssubtitle','Add Client Index');
		
		
		
		
	
			
			$this->addfield();
			 $this->show();
	}
	
	
	private function addfield($i)
	{	
	
	if($i=='')
	{
	   
	 $this->validData[]=array("feild_label" =>"Clients",
	 							"feild_code" =>"user_id",
								 "feild_type" =>"select",
								 "is_required" =>"1",
								 //"feild_tpl" =>"selectsearch",
								  "model"=>$this->getAllClients(),
								 );
								 
								 
	 $this->validData[]=array("feild_label" =>"Index",
	 							"feild_code" =>"indxx_id",
								 "feild_type" =>"select_multiple",
								 "is_required" =>"1",
								 //"feild_tpl" =>"selectsearch",
								  "model"=>$this->getIndexes(),
								 );
								 		 
	}
	
	else if($i!='')
	{
			 $this->validData[]=array("feild_label" =>"Clients",
	 							"feild_code" =>"user_id",
								 "feild_type" =>"select",
								 "is_required" =>"1",
								 //"feild_tpl" =>"selectsearch",
								  "model"=>$this->getClientName($i),
								 );
								 
								 
	 $this->validData[]=array("feild_label" =>"Index",
	 							"feild_code" =>"indxx_id",
								 "feild_type" =>"select_multiple",
								 "is_required" =>"1",
								 //"feild_tpl" =>"selectsearch",
								  "model"=>$this->getIndexes(),
								 );
								 		 
	}
	 
	
	$this->getValidFeilds();
	}
	
	
	
	
	
	function checkClientIndex($user, $index)
	{
	
		$checkquery=$this->db->getResult("select indxx_id from tbl_client_index where tbl_client_index.user_id='".$user."' and indxx_id='".$index."'");	
		if(!empty($checkquery))
		{
			return "true";	
		}
		else
		{
			return "false";	
		}
	}
	
	
} // class ends here

?>