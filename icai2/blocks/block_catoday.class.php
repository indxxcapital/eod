<?php
class Block_catoday extends Block
{
     function __construct($smarty)
	{
    parent::__construct($smarty);
		$result=$this->getcafortoday($_SESSION['User']['id'],1);
		
			
	
	$this->smarty->assign("totalcarows",count($result));
	$this->smarty->assign("caquery",$result);
		
		//$_SESSION['totalcarows'] = ;
		//$_SESSION['caquery']=$caquery;
	
	}
	
}
?>