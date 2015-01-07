<?php
class Block_category1 extends Block
{
     function __construct($smarty)
	{
    parent::__construct($smarty);
	
	$block_categories1=$this->db->getResult("SELECT * FROM tbl_category1 WHERE status='1' ",true);
    $this->smarty->assign("category1_block",$block_categories1);
	}
}
?>