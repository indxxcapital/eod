<?php

class Assignuser extends Application{

	function __construct()
	{
		parent::__construct();
		$this->checkUserSession();
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
		
		
					$strQuery = "delete from tbl_indxx where tbl_indxx.id='".$val2."'";
					$this->db->query($strQuery);
			
			
					$strQuery2 = "delete from tbl_indxx_ticker where tbl_indxx_ticker.indxx_id='".$val2."'";
					$this->db->query($strQuery2);
			
			}
			}
		}
		
		$this->Redirect("index.php?module=assignuser","Records deleted successfully!!!","success");
		$this->show();	
	}
	
	
	
	
	
	function index()
	{
		
		$this->_baseTemplate="inner-template";
	$this->_bodyTemplate="assignuser/index";
		$this->_title=$this->siteconfig->site_title;
		$this->_meta_description=$this->siteconfig->default_meta_description;
		$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
//	$this->addfield();

		$this->smarty->assign('pagetitle','Assign User');
		$this->smarty->assign('bredcrumssubtitle','Assign User');

$this->addCss('assets/data-tables/DT_bootstrap.css');
$this->addJs('assets/bootstrap/bootstrap.min.js');
$this->addJs('assets/nicescroll/jquery.nicescroll.min.js');
$this->addJs('assets/data-tables/jquery.dataTables.js');
$this->addJs('assets/data-tables/DT_bootstrap.js');
$this->addJs('js/flaty.js');




		if(isset($_POST['submit']))
		{
			print_r($_POST);
			foreach($_POST['user_id'] as $key=>$val)
			{
				$indexexists=$this->checkUserIndex($_POST['indxx_id'],$val);
				
				if($indexexists=='false')
				{	
				
			$this->db->query("INSERT into tbl_assign_index set user_id='".$val."',indxx_id='".mysql_real_escape_string($_POST['indxx_id'])."'");
				}
				
			
			}
			$this->Redirect("index.php?module=caindex","Record added successfully!!!","success");	
		}
		
			$this->addfield();
			 $this->show();

	}
	
	
	function addNew()
	{
			$this->_baseTemplate="inner-template";
			$this->_bodyTemplate="assignuser/add";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','User');
		$this->smarty->assign('bredcrumssubtitle','AddUser');
		
		
		
		
	
			
			$this->addfield();
			 $this->show();
	}
	
	
	private function addfield()
	{	
	   
	 $this->validData[]=array("feild_label" =>"Users",
	 							"feild_code" =>"user_id",
								 "feild_type" =>"select_multiple",
								 "is_required" =>"1",
								 //"feild_tpl" =>"selectsearch",
								  "model"=>$this->getAllUsers(),
								 );
							 
					
								 
	 $this->validData[]=array("feild_label" =>"Index",
	 							"feild_code" =>"indxx_id",
								 "feild_type" =>"select",
								 "is_required" =>"1",
								 //"feild_tpl" =>"selectsearch",
								  "model"=>$this->getIndex($_SESSION['NewIndxxId']),
								 );
								 		 
								 
	 
	
	$this->getValidFeilds();
	}
	
	
	
	 protected function view(){
		 
		$this->_baseTemplate="inner-template";
			$this->_bodyTemplate="assignuser/view";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','User');
		$this->smarty->assign('bredcrumssubtitle','View Assigned User');
		
		
		
		$viewdata=$this->db->getResult("select tbl_indxx.*,tbl_index_types.name as indexname from tbl_indxx left join tbl_index_types on tbl_index_types.id=tbl_indxx.type where tbl_indxx.id='".$_GET['id']."'");
		
		$this->smarty->assign("viewdata",$viewdata);
		
		 $this->show();
			
	}
	
	
	protected function edit(){
		 
		$this->_baseTemplate="inner-template";
			$this->_bodyTemplate="assignuser/edit";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','User');
		$this->smarty->assign('bredcrumssubtitle','Edit Assigned User');
		$this->addfield();
		
		
		
		if(isset($_POST['submit']) && $_FILES['product_file']!='')
		{
			$_SESSION['UpdatedData']=$_POST;
			$_SESSION['UpdatedId']=$_GET['id'];
			
		//$this->db->query("INSERT into tbl_indxx set name='".mysql_real_escape_string($_POST['name'])."',code='".mysql_real_escape_string($_POST['code'])."',investmentammount='".mysql_real_escape_string($_POST['investmentammount'])."',divisor='".mysql_real_escape_string($_POST['divisor'])."',type='".mysql_real_escape_string($_POST['type'])."',curr='".mysql_real_escape_string($_POST['curr'])."'");
		
		//$indexid=mysql_insert_id();
				$fields=array(1,2,3,4,5);		
				$uploadsecuritydata = csv::import($fields,$_FILES['product_file']['tmp_name']);		
				$_SESSION['UpdatedSecurityData']=$uploadsecuritydata;
				
				
/*		$_SESSION['UploadFile']['name'] = $_FILES['product_file']['name'];
		$_SESSION['UploadFile']['type']=$_FILES['product_file']['type'];
		$_SESSION['UploadFile']['tmp_name']=$_FILES['product_file']['tmp_name'];
		$_SESSION['UploadFile']['error']=$_FILES['product_file']['error'];
		$_SESSION['UploadFile']['size'] = $_FILES['product_file']['size'];	
*/		
//	$this->pr($uploadsecuritydata ,true);
	
			$this->Redirect("index.php?module=caindex&event=updateddata");	
		}
		
		
		
		
		
		/*if(isset($_POST['submit']))
		{
			
		$this->db->query("UPDATE tbl_indxx set name='".mysql_real_escape_string($_POST['name'])."',code='".mysql_real_escape_string($_POST['code'])."',investmentammount='".mysql_real_escape_string($_POST['investmentammount'])."',divisor='".mysql_real_escape_string($_POST['divisor'])."',type='".mysql_real_escape_string($_POST['type'])."',curr='".mysql_real_escape_string($_POST['curr'])."' where tbl_indxx.id='".$_GET['id']."'");
		
			$this->Redirect("index.php?module=caindex","Record updated successfully!!!","success");	
		}
		*/
		
		
		$editdata=$this->db->getResult("select tbl_indxx.* from tbl_indxx  where tbl_indxx.id='".$_GET['id']."'");
		//$this->pr($editdata,true);
		$this->smarty->assign("postData",$editdata);
		
		
		
		
		 $this->show();
			
	}
	
	protected function delete(){
		 
		 $this->_baseTemplate="inner-template";
			$this->_bodyTemplate="assignuser/delete";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','User');
		$this->smarty->assign('bredcrumssubtitle','Deleted Assigned User');
		
		 $deleteddata=$this->db->getResult("select * from tbl_indxx where tbl_indxx.id='".$_GET['id']."'");
		$this->smarty->assign("deleteddata",$deleteddata);
		 
		$strQuery = "delete from tbl_indxx where tbl_indxx.id='".$_GET['id']."'";
			$this->db->query($strQuery);
			
			
			$strQuery2 = "delete from tbl_indxx_ticker where tbl_indxx_ticker.indxx_id='".$_GET['id']."'";
			$this->db->query($strQuery2);
			
			
			$this->show();
	}
	
	
	function checkUserIndex($index, $user)
	{
	
		$checkquery=$this->db->getResult("select indxx_id from tbl_assign_index where tbl_assign_index.user_id='".$user."' and indxx_id='".$index."'");	
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