<?php

class Viewfields2 extends Application{

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


		$indexdata=$this->db->getResult("select tbl_ca.*,tbl_ca_values.field_name,tbl_ca_values.field_value from tbl_ca left join tbl_ca_values on tbl_ca_values.ca_id=tbl_ca.id where tbl_ca_values.ca_id='".$_GET['id']."'");
		$this->smarty->assign("indexdata",$indexdata);

	//$this->pr($indexdata,true);
	
		//$this->pr($_SESSION);
		 $this->show();
	}
	
	function addNew()
	{
			$this->_baseTemplate="inner-template2";
			$this->_bodyTemplate="casecurities2/add";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','Index');
		$this->smarty->assign('bredcrumssubtitle','AddIndex');
		
		
		if(isset($_POST['submit']))
		{
		$this->db->query("INSERT into tbl_indxx_ticker set name='".mysql_real_escape_string($_POST['name'])."',isin='".mysql_real_escape_string($_POST['isin'])."',ticker='".mysql_real_escape_string($_POST['ticker'])."',weight='".mysql_real_escape_string($_POST['weight'])."',curr='".mysql_real_escape_string($_POST['curr'])."',indxx_id='".mysql_real_escape_string($_POST['indxx_id'])."'");
		
			$this->Redirect("index.php?module=casecurities2&event=addNew","Record added successfully!!!","success");	
		}
		
	
			
			$this->addfield();
			 $this->show();
	}
	
	
	private function addfield()
	{	
	   /*$this->validData[]=array("feild_label" =>"Identifier",
	   								"feild_code" =>"identifier",
								 "feild_type" =>"text",
								 "is_required" =>"1",
								
								 );
		 $this->validData[]=array("feild_label" =>"Mnemonic",
		 							"feild_code" =>"mnemonic",
								 "feild_type" =>"text",
								 "is_required" =>"1",
								
								 );
								 
		 $this->validData[]=array("feild_label" =>"Company Name",
		 							"feild_code" =>"company_name",
								 "feild_type" =>"text",
								 "is_required" =>"1",
								
								 );
								 
		
	 <!--$this->validData[]=array("feild_label" =>"Index",
	 							"feild_code" =>"indxx_id",
								 "feild_type" =>"select",
								 "is_required" =>"1",
								 //"feild_tpl" =>"selectsearch",
								  "model"=>$this->getIndexes(),
								 );-->*/
								 
								 
	 $this->validData[]=array("feild_label" =>"Field Name",
		 							"feild_code" =>"field_name",
								 "feild_type" =>"text3",
								 "is_required" =>"1",
								
								 );
								 
	 $this->validData[]=array(	"feild_label"=>"Field Value",
	 							"feild_code" =>"field_value",
								 "feild_type" =>"text3",
								 "is_required" =>"1",
								
								 );	 
	
	$this->getValidFeilds();
	}
	
	
	
	 protected function view(){
		 
		$this->_baseTemplate="inner-template2";
			$this->_bodyTemplate="viewfields2/view";
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
		
		$viewdata=$this->db->getResult("select tbl_ca.*,tbl_ca_values.field_name,tbl_ca_values.field_value from tbl_ca left join tbl_ca_values on tbl_ca_values.ca_id=tbl_ca.id where tbl_ca_values.ca_id='".$_GET['id']."'");
		
		$this->smarty->assign("viewdata",$viewdata);
		
		
		
		 $this->show();
			
	}
	
	protected function edit(){
		 
		$this->_baseTemplate="inner-template2";
			$this->_bodyTemplate="viewfields2/edit";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','Index');
		$this->smarty->assign('bredcrumssubtitle','EditIndex');
		$this->addfield();
		
		
		if(isset($_POST['submit']))
		{
				
			
		
		$this->db->query("UPDATE tbl_ca_values set field_name='".mysql_real_escape_string($_POST['field_name'])."',field_value='".mysql_real_escape_string($_POST['field_value'])."' where id='".$_GET['id']."'");
		
		
			$this->Redirect("index.php?module=viewca","Record updated successfully!!!","success");	
		}
		
		
		
		$editdata=$this->db->getResult("select tbl_ca.*,tbl_ca_values.field_name,tbl_ca_values.field_value from tbl_ca left join tbl_ca_values on tbl_ca_values.ca_id=tbl_ca.id where tbl_ca_values.id='".$_GET['id']."'");
		//$this->pr($editdata,true);
		$this->smarty->assign("postData",$editdata);
		
		
		
		
		 $this->show();
			
	}
	
	
	protected function delete(){
		
		$strQuery = "delete from tbl_ca_values where tbl_ca_values.id='".$_GET['id']."'";
			$this->db->query($strQuery);
			
			$this->Redirect("index.php?module=viewfields2","Records deleted successfully!!!","success");
			
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
					
					$strQuery =  "delete from tbl_ca_values where tbl_ca_values.id='".$_GET['id']."'";
					$this->db->query($strQuery);
			
			}
			}
		}
		
		$this->Redirect("index.php?module=viewfields2","Records deleted successfully!!!","success");
		$this->show();	
	}
	
	
	
} // class ends here

?>