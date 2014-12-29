<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 * Smarty summarize modifier plugin
 * 
 * Type:     modifier<br>
 * Name:     sumamrize<br>
 * Purpose:  summarize a string down to $limit words<br>
 *  @link http://smarty.incutio.com/?page=Smarty
 *          summarize (Smarty Plugins Wiki)
 * Input:<br>
 *         - string: input string of words
 *         - limit: number of words to return
 * @param string
 * @param int
 * @return string
 */
function smarty_modifier_summarize($string,$limit=20)
{
	//the default limit is 20 as in the old saying, "describe it in 20 words or less"
    $words = 0;
	$return = "";
	//initialize those values
	if($limit<1 || !is_int($limit)) return $return;
	//limits less than one and non-integer values return an empty string;
	$word = strtok($string, " \n\t");
	$return .= $word;
	//get the first word, initialize strtok
    while($word && (++$words < $limit)) {
	//while there's more words to get and we're still under the limit
    $word = strtok(" \n\t");
	$return .= " $word";
	//continue with strtok and append the next word. Note we use spaces as separators here.
    }
	return $return;
}

/* vim: set expandtab: */

?>