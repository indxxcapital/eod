<?php

class Cacalendar extends Application{

	function __construct()
	{
		parent::__construct();
		$this->checkUserSession();
	}
	
	
	function index()
	{
		
		$this->_baseTemplate="inner-template";
$this->_bodyTemplate="calender/index";
		$this->_title=$this->siteconfig->site_title;
		$this->_meta_description=$this->siteconfig->default_meta_description;
		$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
		
		$this->smarty->assign('pagetitle','Corporate Actions Calendar');
		$this->smarty->assign('bredcrumssubtitle','Calendar');
		$data=$this->db->getResult("select id,identifier,mnemonic,eff_date,company_name from tbl_ca");
		//$this->pr($data,true);
$ca_array=array();
if(!empty($data))
{
	
foreach($data as $value)
{
	$ca_id=$value['id'];
$ca_array[]='{title: "'.$value['company_name'].'('.$value['identifier'].')-'.$value['mnemonic'].'",
                start: new Date("'.$value['eff_date'].'"),
                className: "label label-default",url:"'.$this->siteconfig->base_url.'index.php?module=viewca&event=view&id='.$ca_id.'"
            }';
}
}
 $str=implode(",",$ca_array);
	$this->smarty->assign('cadata',$str);

/*{
                title: "All Day Event",
                start: new Date(p, h, 1),
                className: "label label-default"
            },
			*/


//	$this->addfield();
$this->addJs('assets/bootstrap/bootstrap.min.js');
$this->addJs('assets/nicescroll/jquery.nicescroll.min.js');
$this->addJs('assets/jquery-ui/jquery-ui.min.js');
$this->addJs('assets/fullcalendar/fullcalendar/fullcalendar.min.js');
$this->addJs('js/flaty.js');
$this->addCss('assets/jquery-ui/jquery-ui.min.css');
$this->addCss('assets/fullcalendar/fullcalendar/fullcalendar.css');
$this->show();
	}
	
} // class ends here

?>