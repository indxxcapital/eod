<?php

class Home extends Application{

	function __construct()
	{
		parent::__construct();
		$this->checkUserSession();
	}
	
	
	function index()
	{
		//$this->pr($_SESSION,true);
		
		


		$this->_baseTemplate="main-template";
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
		
		
		 $this->show();
	}
	

} // class ends here

?>