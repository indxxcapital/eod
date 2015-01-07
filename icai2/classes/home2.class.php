<?php

class Home2 extends Application{

	function __construct()
	{
		parent::__construct();
		$this->checkUserSession();
	}
	
	
	function index()
	{
		//$this->pr($_SESSION,true);
		
		


		$this->_baseTemplate="main-template2";
//$this->_bodyTemplate="login";
		$this->_title=$this->siteconfig->site_title;
		$this->_meta_description=$this->siteconfig->default_meta_description;
		$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
//	$this->addfield();
$this->addJs('assets/bootstrap/bootstrap.min.js');
$this->addJs('assets/nicescroll/jquery.nicescroll.min.js');
$this->addJs('assets/flot/jquery.flot.js');
$this->addJs('assets/flot/jquery.flot.resize.js');
$this->addJs('assets/flot/jquery.flot.pie.js');
$this->addJs('assets/flot/jquery.flot.stack.js');
$this->addJs('assets/flot/jquery.flot.crosshair.js');
$this->addJs('assets/flot/jquery.flot.tooltip.min.js');
$this->addJs('assets/sparkline/jquery.sparkline.min.js');
$this->addJs('js/flaty.js');

$result=$this->getcafortoday($_SESSION['User']['id'],1);
$this->smarty->assign("totalcarows",count($result));


if($_SESSION['User']['type']=='1')
	{
			$result1=$this->getcaforweek($_SESSION['User']['id'],$_SESSION['User']['type']); 	
	}
	
	else if($_SESSION['User']['type']=='2')
	{
			 $result1=$this->getcaforweek($_SESSION['User']['id'],$_SESSION['User']['type']);
	}
	 
	 $this->smarty->assign("totalweeklycarows",count($result1));
	 
	 
	 if($_SESSION['User']['type']!='1' && $_SESSION['User']['type']!='3'  )
{if(!empty($_SESSION['Index']))
$ids = implode(',',$_SESSION['Index']);
//$ids=substr($ids, 0, -1);


	if(!empty($ids))	
		$block_main_menu=$this->db->getResult("SELECT count(id)  as uindex FROM tbl_indxx WHERE submitted='0' and id in  ($ids)",true);
}else{
		$block_main_menu=$this->db->getResult("SELECT count(id)   as uindex  FROM tbl_indxx WHERE submitted='0'",true);
}
	
//	$this->pr($block_main_menu,true);
		$this->smarty->assign("admin_message",$block_main_menu);
		
		
		 $this->show();
	}
	

} // class ends here

?>