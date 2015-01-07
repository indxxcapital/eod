<?php

function smarty_modifier_getid($params)
{
	$check = preg_match("/\(.*?\)/",$params,$matchs);
	$data= explode(",",$matchs[0]);
	return str_replace("'","",$data[3]);
}
?>
