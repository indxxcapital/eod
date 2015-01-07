<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty spacify modifier plugin
 *
 * Type:     modifier<br>
 * Name:     spacify<br>
 * Purpose:  add spaces between characters in a string
 * @link http://smarty.php.net/manual/en/language.modifier.spacify.php
 *          spacify (Smarty online manual)
 * @author   Monte Ohrt <monte at ohrt dot com>
 * @param string
 * @param string
 * @return string
 */
function smarty_modifier_currency($num)
{
return number_format($num); 
}

 
/* vim: set expandtab: */

?>
