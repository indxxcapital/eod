<?php
class Block_gifts extends Block
{
     function __construct($smarty)
	{
    parent::__construct($smarty);
	
	$block_gifts=$this->db->getResult("SELECT * FROM tbl_gifts WHERE status='1' ",true);
    $this->smarty->assign("gifts",$block_gifts);
	}
}
?>