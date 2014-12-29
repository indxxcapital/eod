<?php
class Block_indxxstatics2 extends Block
{
     function __construct($smarty)
	{
		   parent::__construct($smarty);
	$indxx=$this->db->getResult("SELECT count(id) as totalindxx FROM tbl_indxx WHERE status='1' order by id desc");
		$this->smarty->assign("totalActiveindxx",$indxx['totalindxx']);
		$indxx=$this->db->getResult("SELECT count(id) as totalindxx FROM tbl_indxx_ticker ");
		$this->smarty->assign("totalTicker",$indxx['totalindxx']);	
		$indxx=$this->db->getResult("SELECT count(id) as totalindxx FROM tbl_ca where eff_date>='".date('Y-m-d')."' ");
		$this->smarty->assign("totalca",$indxx['totalindxx']);
		$indxx=$this->db->getResult("SELECT count(id) as totalindxx FROM tbl_ca_user where status='1' ");
		$this->smarty->assign("totalauser",$indxx['totalindxx']);
	}
	
}
?>