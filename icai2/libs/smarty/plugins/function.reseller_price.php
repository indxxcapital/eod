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
function smarty_function_reseller_price($params, &$smarty)
{
  	
		$dbData['host']=$smarty->siteconfig->db_host;
		$dbData['user']=$smarty->siteconfig->db_user;
		$dbData['password']=$smarty->siteconfig->db_password;
		$dbData['name']=$smarty->siteconfig->db_name;
		$smarty->db = new Db($dbData,$smarty);
		
		$productId  = $params['product_id'];
		$userId  	= $params['user_id'];
		//$userId = $_SESSION['User']['UserID'];
		
		$priceQuery = " select price from tbl_product_price where productId = $productId  AND  userId = $userId ";
		$priceArray	=	$smarty->db->getResult($priceQuery,true);
		//echo "<pre>"; print_r($priceArray);
		if(is_array( $priceArray) ){
			return $priceArray['0']['price'];
		}else{
			return false;
		}
		
  
}



?>
