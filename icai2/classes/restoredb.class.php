<?php

class Restoredb extends Application{

	function __construct()
	{
		parent::__construct();
		$this->checkUserSession();
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
	}
	
	
	function index()
	{
		
		$this->_baseTemplate="inner-template";
		$this->_bodyTemplate="dbbackup/index";
		$this->_title=$this->siteconfig->site_title;
		$this->_meta_description=$this->siteconfig->default_meta_description;
		$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
	$this->addfield();
	
	
	
	
		 $this->show();
		 
		 if(!empty($_POST))
	{
	
	$url='';
	//$this->pr($_POST,true);
	if($_POST['db'] && $_POST['dbbackupfilename'])
	{
	//$url='http://191.238.229.176/eod/multicurrency2/restore_db.php?DBNAME='.$_POST['dbbackupfilename'];
	//$res = $this->Redirect2('http://191.238.229.176/eod/multicurrency2/restore_db.php?DBNAME='.$_POST['dbbackupfilename']);
		$res = $this->Redirect2('http://localhost/eod/multicurrency2/restore_db.php?DBNAME='.$_POST['dbbackupfilename']);
		
	//TODO: if res = false, display error popoup to user, else display success popup
	}
	
	
	
	//$link="<script type='text/javascript'>
//window.open('".$url."');  
//</script>";
//echo $link;
	
	}
	
		 
	}
   private function addfield($edit=false)
	{	
	  
								   $this->validData[]=array("feild_label" =>"DB backup File name",
	   								"feild_code" =>"dbbackupfilename",
								 "feild_type" =>"text",
								 "is_required" =>"1",
								
								 );
	
								 
	
	$this->getValidFeilds();
	}
} // class ends here

?>