<?php
class Block_menu extends Block
{
     function __construct($smarty)
	{
    parent::__construct($smarty);
	
	$block_main_menu=$this->db->getResult("SELECT id,name FROM tbl_menucategory WHERE type like '%".$_SESSION['type']."%' ",true);
   // $this->pr($block_main_menu);
	$menu=array();
	if (!empty($block_main_menu))
	{
		foreach ($block_main_menu as $key=>$value)
		{
		$menu[$key]=$value;
		$childs=$this->GetChildPages($value['id']);
		//	$this->pr($childs);
		$menu[$key]['childs']=$childs;
		 
		}
		//$this->pr($menu);
		//exit;
	}
	$this->smarty->assign("menu",$menu);
	}
	
}
?>