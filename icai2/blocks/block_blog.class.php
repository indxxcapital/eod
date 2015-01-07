<?php
class Block_blog extends Block
{
     function __construct($smarty)
	{
    parent::__construct($smarty);
	
	$block_main_menu=$this->db->getResult("SELECT id,title  FROM tbl_publications WHERE status='1' order by id desc",true,10);
   // $this->pr($block_main_menu);
	$menu=array();
	if (!empty($block_main_menu))
	{
		foreach ($block_main_menu as $key=>$value)
		{
		$menu[$value['id']]=$value['title'];
		}
		//$this->pr($menu);
		//exit;
	}
	$this->smarty->assign("blogs",$menu);
	//echo "deepak";
	}
	
}
?>