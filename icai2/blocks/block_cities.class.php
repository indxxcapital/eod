<?php
class Block_cities extends Block
{
     function __construct($smarty)
	{
    parent::__construct($smarty);
	
	$block_main_menu=$this->db->getResult("SELECT linkUrl,name FROM tbl_city WHERE status='1' order by view desc",true);
   // $this->pr($block_main_menu);
	$menu=array();
	if (!empty($block_main_menu))
	{
		foreach ($block_main_menu as $key=>$value)
		{
		$menu[$value['linkUrl']]=$value['name'];
		}
		//$this->pr($menu);
		//exit;
	}
	$this->smarty->assign("cities",$menu);
	}
	
}
?>