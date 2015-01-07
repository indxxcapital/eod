<?php  /**
 * Smarty plugin callback to generate a sidebar block.
 *
 * @param $params
 *   Array containing the parameters in the opening tag.
 * @param $content
 *   The content between the opening and close tag.
 * @param $smarty
 *   Reference to a Smarty object.
 * @param $repeat
 *   Repeat count, not used here.
 * @return
 *   HTML content, the sidebar block.
 */
function smarty_block_field($params, $content, &$smarty, &$repeat)
{

	if(!$repeat){
 				 
		 
		/* if(is_array($params['value']))
		{
		
			$params['errorMessage']=$params['value']['error'][$params['name']];
			if($params['errorMessage']!="")
			{
				$params['errorClass']="class=\"validation-advice\"";
				$params['class']=$params['class']." error";
			}
			
			if($params['type']!="password")
			{
				
				$params['value']=$params['value'][$params['name']];
			}
			
			else
			{
				$params['value']="";
			}
			
			//if($_POST['error'][$params['name']])
			
			
		}
		
		if($params['type']=="hidden")
			{
			 
				  
				$params['value']=$params['staticValue'];
			}
		
		if($params['model']!="")
		{
			 

		  	if(!is_array($params['model']))
			{
		
			 $class= new Functions;
		
		 if(method_exists($class,$params['model']))
			{
				 
		  		 $params['options'] =$class->$params['model']();
		  
		   }
		   else
		   {
		   	$params['options']=array(""=>"Select");
		   }
		   
		   }
		   else
		   {
		   
		   	$params['options'] = $params['model'];
		   }
		 
		} else
		   {
		   	$params['options']=array(""=>"Select");
		   }*/
		 
 
		 $params['data']['feildValues'] = "";
		if($params['data']['feildOptions']){
		
			foreach($params['data']['feildOptions'] as $key => $value){
			
			$params['data']['feildValues'].=$key.'="'.$value.'" ';
			
			}
		
		
		} 
		unset($params['data']['feildOptions']);
		
		if(is_array($params['value']))
		{
 
			$params['data']['errorMessage']=$params['value']['error'][$params['data']['feild_code']];
			if($params['data']['errorMessage']!="")
			{
				$params['data']['errorClass']="class=\"validation-advice\"";
				$params['data']['class']=$params['data']['class']." error";
			}
			
			if($params['data']['type']!="password")
			{
				
				$params['data']['value']=$params['value'][$params['data']['feild_code']];
			}
			
			else
			{
				$params['data']['value']="";
			}
			
		 
		}
	 
		if($params['data']['model']!="")
		{

		   	$params['data']['options'] = $params['data']['model'];
		   
		} 
		else
		{
		   	$params['data']['options']=array(""=>"Select");
		}
		
		
		if(!is_array($params['data']['value']))
		{
		$params['data']['value'] = htmlentities($params['data']['value']);
		}
		
 
		 $type = $params['data']['feild_type'];
 
         $smarty->assign('formParams', $params['data']);
		
		 
        // Generate the block.
		if($params['data']['feild_tpl']!="")
		{
			$type =  $params['data']['feild_tpl'];
		}
 

        $output = $smarty->fetch($smarty->template_dir."/formfields/".$type.".tpl");
		
		/*if($params['data']['container']=="")
		{
			$output = "<p>".$output."</p>";
		}
		else
		{
			$output = "<".$params['data']['container'].">".$output."</".$params['data']['container'].">";
		}*/
		
		
        // Clean up.
       	$smarty->clear_assign('formParams');

        return $output;
		
		
 	/*if($params['template']!="")
	{
        // Add the block content to the tag parameters list.
	 	
		if($params['type']=="menu")
		{
        $params['content'] = getMainMenu($smarty,$params['menu'],$params);
 
		}
		
		if($params['type']=="breadcrumb")
		{
			 
		 
      		  $params['content'] = $smarty->registry->router->location;
			   $smarty->assign('Block_Class',$params['class']);
 
		}
        // Create a $Block_Params template variable that contains these settings.
	if(count($params['content'])==0)
	{
	return;
	}
        $smarty->assign('Block_Params', $params);
		
		
        // Generate the block.
        $output = $smarty->fetch($params['template']);

        // Clean up.
       $smarty->clear_assign('Block_Params');

        return $output;
		}	*/
	}
   return;
	 
}

 
  