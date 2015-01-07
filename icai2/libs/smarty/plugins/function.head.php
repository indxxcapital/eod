<?php
 
 
 
function smarty_function_head($params, &$smarty) {
 
  
 $page_name= strtoupper($params['page']);
 

echo '<title>'.replaceifempty($page_name."_TITLE",$smarty->_config[0]['vars']['SITE_TITLE'])."</title>\n";


$keyword=replaceifempty($page_name."_KEYWORD",'');
 $meta_desc=replaceifempty($page_name."_DESCRIPTION",'');
 
if($keyword) echo "<meta name =\"keywords\" content=\"".$keyword."\">\n";
	
if($meta_desc)	echo "<meta name =\"description\" content=\"".$meta_desc."\">\n";
	 
	 
}

function replaceifempty($check,$replace)
{

	if(preg_match('/_/',$check))
	{
	 
		 if (!defined($check)) {
		 $check="";
		 }
		 else
		 {
		 $check = constant($check);
		 }
	}

	if($check=="")
	{
		return $replace;
	}
	else
	{
		return $check;
	}
}


?>