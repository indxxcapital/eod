<?php
class Block_holiday extends Block
{
     function __construct($smarty)
	{
    parent::__construct($smarty);
	
	$block_holiday=$this->db->getResult("SELECT * FROM tbl_holiday WHERE status='1' ",true);
    $this->smarty->assign("holiday",$block_holiday);
	}
}
?>