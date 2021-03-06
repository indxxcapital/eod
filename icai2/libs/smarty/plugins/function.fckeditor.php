<?php
   /**
   * Smarty plugin
   * @package Smarty
   * @subpackage plugins
    */
   
   /** 
    * Smarty function plugin (function.fckeditor.php)
   * Requires PHP >= 4.3.0
* ------------------------------------------------------------- 
 * Type:     function 
 * Name:     fckeditor
   * Version:  1.0
  15 * Author:   gazoot (gazoot care of gmail dot com)
  16 * Purpose:  Creates a FCKeditor, a very powerful textarea replacement.
  17 * ------------------------------------------------------------- 
  18 * @param InstanceName Editor instance name (form field name)
  19 * @param BasePath optional Path to the FCKeditor directory. Need only be set once on page. Default: /FCKeditor/
  20 * @param Value optional data that control will start with, default is taken from the javascript file
  21 * @param Width optional width (css units)
  22 * @param Height optional height (css units)
  23 * @param ToolbarSet optional what toolbar to use from configuration
  24 * @param CheckBrowser optional check the browser compatibility when rendering the editor
  25 * @param DisplayErrors optional show error messages on errors while rendering the editor
  26 *
  27 * Default values for optional parameters (except BasePath) are taken from fckeditor.js.
  28 *
  29 * All other parameters used in the function will be put into the configuration section, 
  30 * CustomConfigurationsPath is useful for example.
  31 * See http://wiki.fckeditor.net/Developer%27s_Guide/Configuration/Configurations_File for more configuration info.
  32 */ 
   function smarty_function_fckeditor($params, &$smarty)
   {
           if(!isset($params['InstanceName']) || empty($params['InstanceName']))
           { 
                   $smarty->trigger_error('fckeditor: required parameter "InstanceName" missing');
           }
   
           static $base_arguments = array();
           static $config_arguments = array();
   
           // Test if editor has been loaded before
           if(!count($base_arguments)) $init = TRUE;
           else $init = FALSE;
           
           // BasePath must be specified once.
           if(isset($params['BasePath']))
           {
                   $base_arguments['BasePath'] = $params['BasePath'];
           }
           else if(empty($base_arguments['BasePath']))
           {
                   $base_arguments['BasePath'] = '/FCKeditor/';
           }
   
           $base_arguments['InstanceName'] = $params['InstanceName'];
   
           if(isset($params['Value'])) $base_arguments['Value'] = $params['Value'];
           if(isset($params['Width'])) $base_arguments['Width'] = $params['Width'];
           if(isset($params['Height'])) $base_arguments['Height'] = $params['Height'];
           if(isset($params['ToolbarSet'])) $base_arguments['ToolbarSet'] = $params['ToolbarSet'];
           if(isset($params['CheckBrowser'])) $base_arguments['CheckBrowser'] = $params['CheckBrowser'];
         if(isset($params['DisplayErrors'])) $base_arguments['DisplayErrors'] = $params['DisplayErrors'];
   
           // Use all other parameters for the config array (replace if needed)
           $other_arguments = array_diff_assoc($params, $base_arguments);
           $config_arguments = array_merge($config_arguments, $other_arguments);
   
           $out = '';
   
           if($init)
           {
                   $out .= '<script type="text/javascript" src="' . $base_arguments['BasePath'] . 'fckeditor.js"></script>';
           }
   
           $out .= "\n<script type=\"text/javascript\">\n";
           $out .= "var oFCKeditor = new FCKeditor('" . $base_arguments['InstanceName'] . "');\n";
   
           foreach($base_arguments as $key => $value)
           {
                   if(!is_bool($value))
                   {
                           // Fix newlines, javascript cannot handle multiple line strings very well.
                           $value = '"' . preg_replace("/[\r\n]+/", '" + $0"', addslashes($value)) . '"';
                   }
                   $out .= "oFCKeditor.$key = $value; ";
           }
   
           foreach($config_arguments as $key => $value)
           {
                   if(!is_bool($value))
                   {
                           $value = '"' . preg_replace("/[\r\n]+/", '" + $0"', addslashes($value)) . '"';
                   }
                   $out .= "oFCKeditor.Config[\"$key\"] = $value; ";
           }
   
           $out .= "\noFCKeditor.Create();\n";
          $out .= "</script>\n"; 
          
          return $out;
  } 
  
 /* vim: set expandtab: */
 
  ?>