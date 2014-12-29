<?php
class Block_messages2 extends Block
{
     function __construct($smarty)
	{
    parent::__construct($smarty);
		
if($_SESSION['User']['type']!='1' && $_SESSION['User']['type']!='3'  )
{if(!empty($_SESSION['Index']))
$ids = implode(',',$_SESSION['Index']);
//$ids=substr($ids, 0, -1);


	if(!empty($ids))	
		$block_main_menu=$this->db->getResult("SELECT count(id)  as uindex FROM tbl_indxx WHERE submitted='0' and id in  ($ids)",true);
}else{
		$block_main_menu=$this->db->getResult("SELECT count(id)   as uindex  FROM tbl_indxx WHERE submitted='0'",true);
}
	
//	$this->pr($block_main_menu,true);
		$this->smarty->assign("admin_message",$block_main_menu);
	
	}
	
}?>