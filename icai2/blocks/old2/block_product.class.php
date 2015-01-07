<?php
class Block_product extends Block
{
     function __construct($smarty)
	{
    parent::__construct($smarty);
	
	$block_product1=$this->db->getResult("SELECT * FROM tbl_product WHERE status='1' AND bestseller='1' limit 0,8 ",true);
    $this->smarty->assign("bestseller",$block_product1);
	
	$block_product2=$this->db->getResult("SELECT * FROM tbl_product WHERE status='1'  and specialoffer='1' limit 0,8 ",true);
    $this->smarty->assign("specialoffer",$block_product2);
	
	$block_product3=$this->db->getResult("SELECT * FROM tbl_product WHERE status='1' and infocus='1' limit 0,8 ",true);
    $this->smarty->assign("infocus",$block_product3);
	
	$block_product4=$this->db->getResult("SELECT * FROM tbl_product WHERE status='1' AND newarrivals='1' limit 0,8 ",true);
    $this->smarty->assign("newarrivals",$block_product4);
	
	}
}
?>