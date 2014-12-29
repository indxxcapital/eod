<?php

class Error extends Application{

	function __construct()
	{
		parent::__construct();
	}
	
	
	function index()
	{
		
		$this->_baseTemplate="error-template";
		//$this->_bodyTemplate="404";
		$this->_title=$this->siteconfig->site_title;
		$this->_meta_description=$this->siteconfig->default_meta_description;
		$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
	$this->addJs('assets/bootstrap/bootstrap.min.js');
		 $this->show();
	}
   
} // class ends here

?>