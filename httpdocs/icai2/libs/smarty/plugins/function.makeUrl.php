<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty capitalize modifier plugin
 *
 * Type:     modifier<br>
 * Name:     capitalize<br>
 * Purpose:  capitalize words in the string
 * @link http://smarty.php.net/manual/en/language.modifiers.php#LANGUAGE.MODIFIER.CAPITALIZE
 *      capitalize (Smarty online manual)
 * @author   Monte Ohrt <monte at ohrt dot com>
 * @param string
 * @return string
 */
function smarty_function_makeurl($params, &$smarty)
{
  	$url = $params['link'];
  	$url = str_replace($smarty->siteconfig->base_url,"",$url);
		 
 			if($smarty->siteconfig->rewrite==1)
			{
				if(preg_match("/index.php/",$url,$match))
				{
					$tempUrl = str_replace("index.php?","",$url);
					$tempUrl = str_replace("&amp;","&",$tempUrl);
					$tempUrl = explode("&",$tempUrl);
					
					$queryString="";
					$extraString="";
					foreach($tempUrl as $uri)
					{
					 
						$uriTemp = explode("=",$uri);
						$key= strtolower($uriTemp[0]);
						$queryString[$key]=$uriTemp[1];
						if($key!="module" && $key!="event")
						{
							$extraString.="/".$uriTemp[1];
						}
		  			}
					$url = $queryString['module']."/".$queryString['event'].$extraString; 
				}
				
			} 	
		 	  	$url = $smarty->siteconfig->base_url.$url;
			 
			return $url;

  
  
  
}



?>
