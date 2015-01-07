<?php
class Block_heading extends Block
{
    function __construct($smarty)
	{
		
		parent::__construct($smarty);
		 
		 if ($_GET['id'])
		 {	
		 $pageData = $this->db->getResult("SELECT *  FROM `tbl_pages`  where id = '".$_GET['id']."'  ",true);
		if ($pageData[0]['type']=="1"){
		$this->smarty->assign("heading",$pageData[0]['name']);
		}
		 }
		 
		
	}
}
?>