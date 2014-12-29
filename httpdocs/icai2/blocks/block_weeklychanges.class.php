<?php
class Block_weeklychanges extends Block
{
     function __construct($smarty)
	{
		   parent::__construct($smarty);
		  $date=date('Y-m-d', strtotime($this->_date.'-7 days'));
		//  echo "SELECT count(id) as totalindxx FROM tbl_ca where dateAdded>='".$date."' ";
		 $indxx=$this->db->getResult("SELECT count(id) as totalindxx FROM tbl_ca where dateAdded>='".$date."' ");
		//$this->pr($indxx);
		$this->smarty->assign("wchtotalca",$indxx['totalindxx']);
		$indxx=$this->db->getResult("SELECT count(id) as totalindxx FROM tbl_indxx WHERE status='1'  and  dateAdded>='".$date."'  order by id desc");
		$this->smarty->assign("wchtotalActiveindxx",$indxx['totalindxx']);
		
		$indxx=$this->db->getResult("SELECT count(id) as totalindxx FROM tbl_indxx_ticker where dateAdded>='".$date."'  ");
		$this->smarty->assign("wchtotalTicker",$indxx['totalindxx']);	
		
		 $indxx=$this->db->getResult("SELECT count(id) as totalindxx FROM tbl_ca where amd_date>='".$date."' ");
		//$this->pr($indxx);
		$this->smarty->assign("wchtotalcavals",$indxx['totalindxx']);
		
	}
}
?>