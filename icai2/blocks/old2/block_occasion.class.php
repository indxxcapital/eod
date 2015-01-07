<?php
class Block_occasion extends Block
{
     function __construct($smarty)
	{
    parent::__construct($smarty);
	
	$block_occasion=$this->db->getResult("SELECT * FROM tbl_occasion WHERE status='1' limit 0,6 ",true);
    $this->smarty->assign("occasions",$block_occasion);
	}
}
?>