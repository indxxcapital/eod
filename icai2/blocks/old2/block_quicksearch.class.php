<?php
class Block_quicksearch extends Block
{
     function __construct($smarty)
	{
    parent::__construct($smarty);
	$this->addQsearchFeild();
	}
	
	function addQsearchFeild()
	{
	 $this->validData["Qsearch"][]=array("feild_code" =>"qlocation",
									 "feild_tpl" =>"select",
									 "class"=>"location",
									 "feild_label" =>"Location",
									 "model"=>$this->GetLocation());
	$this->getValidFeilds('Qsearch');								 
	}
	
}
?>