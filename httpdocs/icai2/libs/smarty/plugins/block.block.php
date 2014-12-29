<?php   
 
function smarty_block_block($params, $content, &$smarty, &$repeat)
{
				   
		 
	if(!$repeat){ 
 
			if(file_exists($smarty->siteconfig->base_path."blocks/".$params['class'].".class.php"))
			{
		 		$block = new $params['class']($smarty);
		 	 	$output= $block->initBlock();
				
				$output.= $smarty->fetch("blocks/".$params['file'].".tpl");
				
				
				
				
				
				
				return $output;
			 }
			 return;
			 
	
	}
   return;
	 
}

?>