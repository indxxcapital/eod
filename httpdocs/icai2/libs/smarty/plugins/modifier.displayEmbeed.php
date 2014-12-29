<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty indent modifier plugin
 *
 * Type:     modifier<br>
 * Name:     indent<br>
 * Purpose:  indent lines of text
 * @link http://smarty.php.net/manual/en/language.modifier.indent.php
 *          indent (Smarty online manual)
 * @author   Monte Ohrt <monte at ohrt dot com>
 * @param string
 * @param integer
 * @param string
 * @return string
 */
function smarty_modifier_displayEmbeed($code,$w,$h)
{
    $code=preg_replace('/width="(\d+)?"/','width="'.$w.'"', $code);
	$code=preg_replace('/height="(\d+)?"/','height="'.$h.'"', $code);	
	return  $code;
}

?>
