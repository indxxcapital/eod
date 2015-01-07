<?php
class Block_category extends Block
{
     function __construct($smarty)
	{
    parent::__construct($smarty);
	
	$block_categories=$this->db->getResult("SELECT * FROM tbl_category WHERE status='1' ",true);
    $this->smarty->assign("category_block",$block_categories);
	}
}
?>