<?php
class Block_thingstodo extends Block
{
     function __construct($smarty)
	{
    parent::__construct($smarty);
		  $dayesagodate=date('Y-m-d', strtotime($this->_date.'+7 days'));
		$task=$this->db->getResult("SELECT name FROM tbl_ca_todo order by name asc",true);
	//$this->pr($task);
	$array=array();
	if(!empty($task))
	{
	foreach($task as $item)
	{
		//echo "SELECT count(id) as totalindxx FROM tbl_ca where mnemonic='".$item['name']."' and eff_date between '".date("Y-m-d")."' and '".$dayesagodate."' ";
		 $indxx=$this->db->getResult("SELECT count(id) as totalindxx FROM tbl_ca where mnemonic='".$item['name']."' and eff_date between '".date("Y-m-d")."' and '".$dayesagodate."' ");
	//$this->pr($indxx);	
	if($indxx['totalindxx']) 
	$array[$item['name']]=$indxx['totalindxx'];
	
	
	}
	}
	$this->smarty->assign("thingstodo",$array);
	}
	
}
?>