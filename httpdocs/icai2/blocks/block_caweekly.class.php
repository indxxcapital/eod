<?php
class Block_caweekly extends Block
{
     function __construct($smarty)
	{
    parent::__construct($smarty);
	//echo $this->_date;
	
	
	if($_SESSION['User']['type']=='1')
	{
			$result=$this->getcaforweek($_SESSION['User']['id'],$_SESSION['User']['type']); 	
	}
	
	else if($_SESSION['User']['type']=='2')
	{
			 $result=$this->getcaforweek($_SESSION['User']['id'],$_SESSION['User']['type']);
	}
	 
	 $this->smarty->assign("totalweeklycarows",count($result));
	$this->smarty->assign("totalweeklyca",$result);
		
		//$_SESSION['totalweeklycarows'] = count($totalweeklyca);
		//$_SESSION['totalweeklyca']=$totalweeklyca;
	
	}
	
}
?>