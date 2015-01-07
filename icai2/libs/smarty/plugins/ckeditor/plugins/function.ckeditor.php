<?php 
/** 
 * Smarty plugin 
 * @package Smarty 
 * @subpackage plugins 
 */ 

/** 
* Smarty function plugin 
* Requires PHP >= 4.3.0 
* ------------------------------------------------------------- 
* Type:     function 
* Name:     ckeditor 
* Version:  0.9 
* Author:   cezaryece based on plugin for fckeditor by gazoot (gazoot care of gmail dot com) 
* Purpose:  Creates a CKeditor, a very powerful textarea replacement. 
* ------------------------------------------------------------- 
* @param InstanceName Editor instance name (form field name) [ plugin has feature of multiply instances of CKEditor, but not tested yet] 
* @param BasePath optional Path to the FCKeditor directory. Need only be set once on page. Default: /FCKeditor/ 
* @param Value optional data that control will start with, default is taken from the javascript file 
* 
* params from CKEDITOR.config fields list 
* @param width optional width (css units) 
* @param height optional height (css units) 
* @param toolbar optional what toolbar to use from configuration 
* 
*/ 
function smarty_function_ckeditor($params, &$smarty) { 
   if(!isset($params['InstanceName']) || empty($params['InstanceName'])) { 
      $smarty->trigger_error('ckeditor: required parameter "InstanceName" missing'); 
   } 

   $CKEditor = 'CK_'.$params['InstanceName']; 
   $base_arguments = array(); 
   $config_arguments = array(); 

   // Test if editor has been loaded before 
   if(!count($base_arguments)) $init = TRUE; 
   else $init = FALSE; 

   // BasePath must be specified once. 
   if(isset($params['BasePath'])) { 
      $base_arguments['BasePath'] = $params['BasePath']; 
   } 
   else if(empty($base_arguments['BasePath'])) { 
      $base_arguments['BasePath'] = 'js/ckeditor/'; 
   } 
    
   require_once($base_arguments['BasePath']."/ckeditor.php"); 

   $base_arguments['InstanceName'] = $params['InstanceName']; 

   if(isset($params['Value'])) $base_arguments['Value'] = $params['Value']; 

   // Use all other parameters for the config array (replace if needed) 
   $config_arguments = array_diff_assoc($params, $base_arguments); 

   $out = ''; 

   if($init) { 
      $out .= '<script type="text/javascript" src="' . $base_arguments['BasePath'] . 'ckeditor.js"></script>'; 
   } 

   $out .= "\n<script type=\"text/javascript\">\n//<![CDATA[\n"; 
   $out .= "var ".$CKEditor." = CKEDITOR.replace('".$base_arguments['InstanceName']."');\n"; 
   $out .= $CKEditor.".basePath = '".$base_arguments['BasePath']."';\n"; 
//    $out .= $CKEditor.".setData = '".htmlspecialchars($base_arguments['Value'])."';\n"; 

   foreach($config_arguments as $key => $value) { 
      if(!is_bool($value)) { 
      // Fix newlines, javascript cannot handle multiple line strings very well. 
         $value = '"' . preg_replace("/[\r\n]+/", '" + $0"', addslashes($value)) . '"'; 
      } 
      $out .= "$CKEditor.config.$key = $value; "; 
   } 

   $out .= "//]]>\n</script>\n"; 
   $out = "<textarea name='".$base_arguments['InstanceName']."'>".$base_arguments['Value']."</textarea>\n".$out; 
   return $out; 
} 
?>