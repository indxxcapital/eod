<?php
class Block_brands extends Block
{
     function __construct($smarty)
	{
    parent::__construct($smarty);
	
	$block_brands=$this->db->getResult("SELECT * FROM tbl_brand WHERE status='1' ",true);
    $this->smarty->assign("brands_block",$block_brands);
	}
}
?>