<?php
class Block_banner extends Block
{
    function __construct($smarty)
	{
		
		parent::__construct($smarty);
		
	$this->smarty->assign("bannertype",$_SESSION['type']);
	
	}
}
?>