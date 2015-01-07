<?php

class Welcome extends Backend{

	function __construct()
	{
		// check admin session
	 	$this->checkAdminSession();
		
	}
	
	function index()
	{
	
		$this->_bodyTemplate="welcome";
		$this->_title="Welcome";
	
		 
		//$this->addJs("ajax.js");
		//$this->addCss("style.css");
		$this->show();
	}
	
	 
	
	
 

}

?>