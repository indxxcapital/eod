<?php
class Block_downloadchart extends Block
{
     function __construct($smarty)
	{
    parent::__construct($smarty);
//	echo $_GET['id'];
	 $downloadData = $this->db->getResult("SELECT *  FROM `tbl_chart`  where id = '".$_GET['id']."' ",true);
	$this->smarty->assign("factsheet", $downloadData[0]['factsheet']);
	$this->smarty->assign("methodology", $downloadData[0]['methodology']);
	$this->smarty->assign("constituents", $downloadData[0]['constituents']);
	}
}
?>