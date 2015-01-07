<?php
 
 
 
 function smarty_function_editor($params, &$smarty) {
  
  	if($smarty->siteconfig->admin_folder=="")
	{
		$adminFolder = "admin";
	}
	else
	{
		$adminFolder = $smarty->siteconfig->admin_folder;
	}
 
	include_once $smarty->siteconfig->base_path.$adminFolder.'/libs/ckeditor/ckeditor.php';
	include_once $smarty->siteconfig->base_path.$adminFolder.'/libs/ckfinder/ckfinder.php';
	$ckeditor = new CKEditor();
 //   $ckeditor->basePath = $adminFolder.'/libs/ckeditor/';
 
 
 
 
 if($smarty->siteconfig->site_url!="")
 {
	 $ckeditor->basePath = $smarty->siteconfig->site_url.$adminFolder.'/libs/ckeditor/';
	 CKFinder::SetupCKEditor($ckeditor, 'libs/ckfinder/');

 }
 else
 {
	  $ckeditor->basePath = $smarty->siteconfig->base_url.$adminFolder.'/libs/ckeditor/';
	  CKFinder::SetupCKEditor($ckeditor, $adminFolder.'/ckfinder/');

 }
 
 if(strtolower($params['type'])=='basic')
 {
	$config['toolbar'] = array(
	array( 'Bold', 'Italic', 'Underline', 'Strike','Format','Font','fontSize' ,'Link' ),
	
	); 

 }
 if(strtolower($params['type'])=='withoutlink')
 {
	$config['toolbar'] = array(
	array( 'Bold', 'Italic', 'Underline', 'Strike','Format','Font','fontSize'  ),
	
	); 

 }

	$config['skin'] = 'v2';
	$config['contentsCss'] = '../css/editor.css';
 if($params['Value']=="")
 {
		$params['Value']="<p>&nbsp;</p>"; 
 }
	echo $ckeditor->editor($params['InstanceName'], $params['Value'], $config);
	
}

?>