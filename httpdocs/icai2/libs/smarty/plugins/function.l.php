<?php 

function smarty_function_l($params, &$smarty)
{ 
	     $string = $params["text"];
		if($smarty->lang[$string]!="")
		{
			$string = $smarty->lang[$string];
		}
		
		return $string;
		
}

/* vim: set expandtab: */

?>
