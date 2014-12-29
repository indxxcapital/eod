<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty {popup} function plugin
 *
 * Type:     function<br>
 * Name:     popup<br>
 * Purpose:  make text pop up in windows via overlib
 * @link http://smarty.php.net/manual/en/language.function.popup.php {popup}
 *          (Smarty online manual)
 * @author   Monte Ohrt <monte at ohrt dot com>
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_isdelete($params, &$smarty)
{		
	$dbData['host']=$smarty->siteconfig->db_host;
	$dbData['user']=$smarty->siteconfig->db_user;
	$dbData['password']=$smarty->siteconfig->db_password;
	$dbData['name']=$smarty->siteconfig->db_name;
	$smarty->db = new Db($dbData,$smarty);
	$isDelete =0;
	/*if($_SESSION['User']['UserID'] != $params['user_id']){
	$isFri = $smarty->db->getResult("select id from tbl_friends where ((user_id ='".$params['user_id']."' AND friend_id ='".$_SESSION['User']['UserID']."') OR (user_id ='".$_SESSION['User']['UserID']."' AND friend_id ='".$params['user_id']."')) AND status='1'",true);
	}*/
	$itemId = $smarty->db->getResult("select id,user_to from tbl_user_wall where  user_to='".$_SESSION['User']['UserID']."' AND 	
		id='".$params['itemId']."' AND posttype='".$params['itemType']."'",true);
	
	if(($itemId[0]['id']) && ($itemId[0]['user_to']  != $params['user_id'])){
		$isDelete ='posted';
	}	
	$shareId = $smarty->db->getResult("select id from tbl_share where user_to='".$_SESSION['User']['UserID']."' AND user_from='".$params['user_id']."' AND 	
		itemId='".$params['itemId']."' AND itemType='".$params['itemType']."'",true);
	if($shareId[0]['id']){
		$isDelete ='shared';
	}
	
	return $isDelete;
	

}

/* vim: set expandtab: */

?>
