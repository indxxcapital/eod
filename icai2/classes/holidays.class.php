<?php

class Holidays extends Application{

	function __construct()
	{
		parent::__construct();
		
		$this->checkusersession();
	}
	
	
	function index()
	{
		
		//echo "deepak";
		//exit;
		
		$this->_baseTemplate="inner-template";
	$this->_bodyTemplate="holidays/index";
		$this->_title=$this->siteconfig->site_title;
		$this->_meta_description=$this->siteconfig->default_meta_description;
		$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
//	$this->addfield();

		$this->smarty->assign('pagetitle','holidays List');
		$this->smarty->assign('bredcrumssubtitle','holidays');

$this->addCss('assets/data-tables/DT_bootstrap.css');
$this->addJs('assets/bootstrap/bootstrap.min.js');
$this->addJs('assets/nicescroll/jquery.nicescroll.min.js');
$this->addJs('assets/data-tables/jquery.dataTables.js');
$this->addJs('assets/data-tables/DT_bootstrap.js');
$this->addJs('js/flaty.js');

		//$username=$_SESSION['User']['name'];
		//$holidaydata=$this->db->getResult("select tbl_holidays.id as userid,tbl_holidays.name as username,tbl_holidays.email,tbl_holidays.type,count(tbl_indxx.name) as indexes from tbl_assign_index left join tbl_holidays on tbl_holidays.id=tbl_assign_index.user_id left join tbl_indxx on tbl_indxx.id=tbl_assign_index.indxx_id group by tbl_holidays.name");
		
		$holidaydata=$this->db->getResult("select tbl_holidays.*,tbl_calendarzone.name as zonename from tbl_holidays left join tbl_calendarzone on tbl_calendarzone.id=tbl_holidays.zone_id" ,true);
		
		$this->smarty->assign("holidaydata",$holidaydata);

	//$this->pr($holidaydata,true);
	
		//$this->pr($_SESSION);
		 $this->show();
	}
	
	function addNew()
	{
			$this->_baseTemplate="inner-template";
			$this->_bodyTemplate="holidays/add";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','holidays');
		$this->smarty->assign('bredcrumssubtitle','Add holidays');
		
		
		if(isset($_POST['submit']))
		{
		$this->db->query("INSERT into tbl_holidays set status='1',title='".mysql_real_escape_string($_POST['title'])."',zone_id='".mysql_real_escape_string($_POST['zone_id'])."',date='".mysql_real_escape_string($_POST['date'])."'");
		
		
			$this->Redirect("index.php?module=holidays&event=addNew","Record added successfully!!!","success");	
		}
			
			$this->addfield();
			 $this->show();
	}
	
	
	private function addfield()
	{	
	
	 $this->validData[]=array("feild_label" =>"Calendar Zone",
	 							"feild_code" =>"zone_id",
								 "feild_type" =>"select",
								 "is_required" =>"1",
								 //"feild_tpl" =>"selectsearch",
								  "model"=>$this->getCalendarZone(),
								 );
								 
	   $this->validData[]=array("feild_label" =>"Title",
	   								"feild_code" =>"title",
								 "feild_type" =>"text",
								 "is_required" =>"1",
								
								 );
								 
								  $this->validData[]=array("feild_label" =>"Date",
	   								"feild_code" =>"date",
								 "feild_type" =>"date",
								 "is_required" =>"1",
								
								 );
		 
	
								 
								 
	/*$this->validData[]=array("feild_label" =>"Indxx",
	 							"feild_code" =>"indxx_id",
								 "feild_type" =>"select",
								 "is_required" =>"1",
								 //"feild_tpl" =>"selectsearch",
								  "model"=>$this->getIndexes(),
								 );*/
								 
								 
	
	$this->getValidFeilds();
	}
		 
	
	
	protected function edit(){
		 
		$this->_baseTemplate="inner-template";
			$this->_bodyTemplate="holidays/edit";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','holidays');
		$this->smarty->assign('bredcrumssubtitle','Edit holidays');
		$this->addfield("true");
		
		
		if(isset($_POST['submit']))
		{
			
			
						
				$this->db->query("UPDATE tbl_holidays set title='".mysql_real_escape_string($_POST['title'])."',zone_id='".mysql_real_escape_string($_POST['zone_id'])."',date='".mysql_real_escape_string($_POST['date'])."' where id='".$_GET['id']."'");	
			
					
			$this->Redirect("index.php?module=holidays","Record updated successfully!!!","success");	
		}
		
		
		
		$editdata=$this->db->getResult("select tbl_holidays.* from tbl_holidays  where tbl_holidays.id='".$_GET['id']."'");
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
					$strQuery1 = "delete from tbl_holidays where tbl_holidays.id='".$val2."'";
					$this->db->query($strQuery1);
					
					
			}
			}
		}
		$this->Redirect("index.php?module=holidays","Records deleted successfully!!!","success");
		$this->show();	
	}
	
	
	
	protected function delete(){
		
		 	$strQuery1 = "delete from tbl_holidays where tbl_holidays.id='".$_GET['id']."'";
					$this->db->query($strQuery1);
					
									
				
			$this->Redirect("index.php?module=holidays","Record deleted successfully!!!","success");
			
			$this->show();
			
			
	}
	
	
	
	
	
	
	
} // class ends here

?>