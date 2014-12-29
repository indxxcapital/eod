<?php

class calendarzone extends Application{

	function __construct()
	{
		parent::__construct();
		
		$this->checkusersession();

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
	$this->_bodyTemplate="calendarzone/index";
		$this->_title=$this->siteconfig->site_title;
		$this->_meta_description=$this->siteconfig->default_meta_description;
		$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
//	$this->addfield();

		$this->smarty->assign('pagetitle','calendarzone List');
		$this->smarty->assign('bredcrumssubtitle','calendarzone');


		//$username=$_SESSION['User']['name'];
		//$zonedata=$this->db->getResult("select tbl_calendarzone.id as userid,tbl_calendarzone.name as username,tbl_calendarzone.email,tbl_calendarzone.type,count(tbl_indxx.name) as indexes from tbl_holidays left join tbl_calendarzone on tbl_calendarzone.id=tbl_holidays.zone_id left join tbl_indxx on tbl_indxx.id=tbl_holidays.indxx_id group by tbl_calendarzone.name");
		
		$zonedata=$this->db->getResult("select * from tbl_calendarzone " ,true);
		
		$this->smarty->assign("zonedata",$zonedata);

	//$this->pr($zonedata,true);
	
		//$this->pr($_SESSION);
		 $this->show();
	}
	
	function addNew()
	{
			$this->_baseTemplate="inner-template";
			$this->_bodyTemplate="calendarzone/add";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','calendarzone');
		$this->smarty->assign('bredcrumssubtitle','Add Calendar Zone');
		
		
		if(isset($_POST['submit']))
		{
		$this->db->query("INSERT into tbl_calendarzone set status='1',name='".mysql_real_escape_string($_POST['name'])."'");
		
			$this->Redirect("index.php?module=calendarzone&event=addNew","Record added successfully!!!","success");	
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
		
								 
								 
	
	$this->getValidFeilds();
	}
	
	
	protected function edit(){
		 
		$this->_baseTemplate="inner-template";
			$this->_bodyTemplate="calendarzone/edit";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','calendarzone');
		$this->smarty->assign('bredcrumssubtitle','Edit Calendar Zone');
		$this->addfield("true");
		
		
		if(isset($_POST['submit']))
		{
			
			
		$this->db->query("UPDATE tbl_calendarzone set name='".mysql_real_escape_string($_POST['name'])."' where id='".$_GET['id']."'");
					
			$this->Redirect("index.php?module=calendarzone","Record updated successfully!!!","success");	
		}
		
		
		
		$editdata=$this->db->getResult("select tbl_calendarzone.* from tbl_calendarzone  where tbl_calendarzone.id='".$_GET['id']."'");
		//$this->pr($editdata,true);
		$this->smarty->assign("postData",$editdata);
		
		
		
		
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
					$strQuery1 = "delete from tbl_calendarzone where tbl_calendarzone.id='".$val2."'";
					$this->db->query($strQuery1);
					
					$strQuery = "delete from tbl_holidays where tbl_holidays.zone_id='".$val2."'";
					$this->db->query($strQuery);
			}
			}
		}
		$this->Redirect("index.php?module=calendarzone","Records deleted successfully!!!","success");
		$this->show();	
	}
	
	
	
	protected function delete(){
		
		 	$strQuery1 = "delete from tbl_calendarzone where tbl_calendarzone.id='".$_GET['id']."'";
					$this->db->query($strQuery1);
					
									
					$strQuery = "delete from tbl_holidays where tbl_holidays.zone_id='".$_GET['id']."'";
					$this->db->query($strQuery);
			
			$this->Redirect("index.php?module=calendarzone","Record deleted successfully!!!","success");
			
			$this->show();
			
			
	}
	
	
} // class ends here

?>