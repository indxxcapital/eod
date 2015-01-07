<?php
class Block_top extends Block
{
    function __construct($smarty)
	{
		
		parent::__construct($smarty);
		$this->smarty->assign('menutype', $_SESSION['type']);
	}
}
?>