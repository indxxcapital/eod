<?php
class Runindex extends Application 
{
	function __construct() 
	{
		parent::__construct ();
		$this->checkUserSession ();
		$this->addJs ( 'assets/bootstrap/bootstrap.min.js' );
		$this->addJs ( 'assets/nicescroll/jquery.nicescroll.min.js' );
		$this->addJs ( 'assets/flot/jquery.flot.js' );
		$this->addJs ( 'assets/flot/jquery.flot.resize.js' );
		$this->addJs ( 'assets/flot/jquery.flot.pie.js' );
		$this->addJs ( 'assets/flot/jquery.flot.stack.js' );
		$this->addJs ( 'assets/flot/jquery.flot.crosshair.js' );
		$this->addJs ( 'assets/flot/jquery.flot.tooltip.min.js' );
		$this->addJs ( 'assets/sparkline/jquery.sparkline.min.js' );
		$this->addJs ( 'js/flaty.js' );
	}
	
	function index() 
	{
		$this->_baseTemplate = "inner-template";
		$this->_bodyTemplate = "runindex/index";
		$this->_title = $this->siteconfig->site_title;
		$this->_meta_description = $this->siteconfig->default_meta_description;
		$this->_meta_keywords = $this->siteconfig->default_meta_keyword;
		$this->addfield ();

		$indxxs = $this->db->getResult ( "select tbl_indxx_temp.* from tbl_indxx_temp  where status='1' and usersignoff='1' and dbusersignoff='1' and submitted='1' and id='" . $_GET ['id'] . "'", false, 1 );
		// $this->pr($indxxs,true);
		$this->smarty->assign ( 'indxx', $indxxs );
		
		$this->show ();
		
		if (! empty ( $_POST )) 
		{	
			$url = '';

			if ($_POST ['db'] && $_POST ['date']) 
			{
				$res = $this->Redirect ( $this->siteconfig->base_url . 'index.php?module=calcindxxclosingid&date=' . $_POST ['date'] . "&id=" . $_POST ['id'] );
			}			
		}
	}
	private function addfield($edit = false) 
	{
		$this->validData [] = array (
				"feild_label" => "Date",
				"feild_code" => "date",
				"feild_type" => "date",
				"is_required" => "1" 
		);
		
		$this->getValidFeilds ();
	}
}
?>