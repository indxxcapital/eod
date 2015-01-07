<?php
class Block_location extends Block
{
     function __construct($smarty)
	{
    parent::__construct($smarty);
	
	$block_location=$this->db->getResult("SELECT * FROM tbl_location WHERE status='1' ",true);
    $this->smarty->assign("locations",$block_location);
	}
}
?>