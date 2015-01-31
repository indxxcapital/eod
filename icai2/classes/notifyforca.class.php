<?php
class Notifyforca extends Application 
{
	function __construct() 
	{
		parent::__construct ();
	}
	
	function index() 
	{
			if($_GET['log_file'])
				define("log_file", $_GET['log_file']);

			$this->log_info(log_file, "Notify for CA started(TO BE IMPLEMENTED)");

			/* TODO: Check if this is getting used or not?, Why this is needed?, Update this accordingly */
			if (false)
			{
					
			if (date('D', $this->_date) == "Mon") 
			{
				$text = 'Please change CA request file date range from: ' 
						.date("Y-m-d", strtotime($this->_date) - (7 * 86400)). '  to ' 
						.date("Y-m-d", strtotime($this->_date) + (60 * 86400) );

				$this->mail_info(log_file, $text);
			}
			
			}
			$this->log_info(log_file, "Notify for CA done");
				
		//$this->saveProcess ( 1 );
		$this->Redirect("index.php?module=calcftpopen&date=" .$this->_date. "&log_file=" . log_file, "", "");
	}
}
?>