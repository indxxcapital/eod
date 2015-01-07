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
function smarty_modifier_displaytimeago($timestamp)
{
 
	if(strtotime($timestamp)<=0)
	{
			   return "long ago";	
	}

	$format='%d days, %h hours, %m Min';
  	$difference =  time()- strtotime($timestamp);

        if($difference < 0)
            return false;
        else{
       
            $min_only = intval(floor($difference / 60));
            $hour_only = intval(floor($difference / 3600));
           
            $days = intval(floor($difference / 86400));
            $difference = $difference % 86400;
            $hours = intval(floor($difference / 3600));
            $difference = $difference % 3600;
            $minutes = intval(floor($difference / 60));
            if($minutes == 60){
                $hours = $hours+1;
                $minutes = 0;
            }
           
            if($days == 0){
                $format = str_replace('days', '?', $format);
                $format = str_replace('Ds', '?', $format);
                $format = str_replace('%d', '', $format);
            }
            if($hours == 0){
                $format = str_replace('hours', '?', $format);
                $format = str_replace('Hs', '?', $format);
                $format = str_replace('%h', '', $format);
            }
            if($minutes == 0){
                $format = str_replace('minutes', '?', $format);
                $format = str_replace('Min', '?', $format);
                $format = str_replace('Ms', '?', $format);       
                $format = str_replace('%m', '', $format);
            }
           	if($days>0){
                $format = str_replace('hours,', '?', $format);
				$format = str_replace('%h', '?', $format);
                $format = str_replace('Min', '?', $format);
				$format = str_replace('%m', '?', $format);
			}elseif($hours>0){
                $format = str_replace('Min', '?', $format);
				$format = str_replace(',', '?', $format);
				$format = str_replace('%m', '?', $format);
			}
			//echo $format; 
            $format = str_replace('?,', '', $format);
            $format = str_replace('?:', '', $format);
            $format = str_replace('?', '', $format);
			
            $timeLeft = str_replace('%d', number_format($days), $format);       
            $timeLeft = str_replace('%ho', number_format($hour_only), $timeLeft);
            $timeLeft = str_replace('%mo', number_format($min_only), $timeLeft);
            $timeLeft = str_replace('%h', number_format($hours), $timeLeft);
            $timeLeft = str_replace('%m', number_format($minutes), $timeLeft);
               
            if($days == 1){
                $timeLeft = str_replace('days', 'day', $timeLeft);
                $timeLeft = str_replace('Ds', 'D', $timeLeft);
            }
            if($hours == 1 || $hour_only == 1){
                $timeLeft = str_replace('hours', 'hour', $timeLeft);
                $timeLeft = str_replace('Hs', 'H', $timeLeft);
            }
            if($minutes == 1 || $min_only == 1){
                $timeLeft = str_replace('minutes', 'minute', $timeLeft);
                $timeLeft = str_replace('Min', 'Min', $timeLeft);
                $timeLeft = str_replace('Ms', 'M', $timeLeft);           
            }
			 
		if(trim($timeLeft)=='')
			$timeLeft='0 Min' ;  
          return str_replace(',','',$timeLeft)." ago";
        }
}

?>
