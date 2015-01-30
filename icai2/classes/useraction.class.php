<?php

class Useraction extends Application{

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
		$this->_bodyTemplate="useraction/index";
		$this->_title=$this->siteconfig->site_title;
		$this->_meta_description=$this->siteconfig->default_meta_description;
		$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
	$this->addfield();
	
	
	
	
		 $this->show();
		 
		 if(!empty($_POST))
	{
	
	$url='';
	//$this->pr($_POST,true);
	if($_POST['ca'] && $_POST['date'])
	{
	$url='http://191.238.229.176/eod/multicurrency2/read_input_ca.php?DEBUG=1&date='.$_POST['date'];
		//$url='http://localhost/eod/multicurrency2/read_input_ca.php?DEBUG=1&date='.$_POST['date'];
		
	}
	if($_POST['open'] && $_POST['date'])
	{
	
	$url='http://191.238.229.176/eod/icai2/index.php?module=calcindxxopening&DEBUG=1&date='.$_POST['date'];
		//$url='http://localhost/eod/icai2/index.php?module=calcindxxopening&DEBUG=1&date='.$_POST['date'];
		
	}
	if($_POST['close'] && $_POST['date'])
	{
	$url='http://191.238.229.176/eod/multicurrency2/read_input_files.php?DEBUG=1&date='.$_POST['date'];
		//$url='http://localhost/eod/multicurrency2/read_input_files.php?DEBUG=1&date='.$_POST['date'];
		
	}
	
	
	$link="<script type='text/javascript'>
window.open('".$url."');  
</script>";
echo $link;
	
	}
	
		 
	}
   private function addfield($edit=false)
	{	
	   $this->validData[]=array("feild_label" =>"Date",
	   								"feild_code" =>"date",
								 "feild_type" =>"date",
								 "is_required" =>"1",
								
								 );
								 
	
								 
	
	$this->getValidFeilds();
	}
} // class ends here

?>