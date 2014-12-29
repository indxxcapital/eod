<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$admin_title} {if $title!=""}- {$title}{/if}</title>

<link rel="stylesheet" type="text/css" href="{$BASE_URL}assets/css/reset.css" media="screen" />
<link rel="stylesheet" type="text/css" href="{$BASE_URL}assets/css/grid.css" media="screen" />
<!-- IE Fixes for the Fluid 960 Grid System -->
<!--[if IE 6]><link rel="stylesheet" type="text/css" href="{$BASE_URL}assets/css/ie6.css" media="screen" /><![endif]-->
<!--[if IE 7]><link rel="stylesheet" type="text/css" href="{$BASE_URL}assets/css/ie.css" media="screen" /><![endif]-->
<link rel="stylesheet" type="text/css" href="{$BASE_URL}assets/css/styles.css" media="screen" />
<link rel="stylesheet" type="text/css" href="{$BASE_URL}assets/css/theme-blue.css" media="screen" />
<script language="javascript" src="{$BASE_URL}assets/js/jquery-1.3.2.min.js"></script>
<script language="javascript" src="{$BASE_URL}assets/js/ajax.js"></script>



{if $meta_description!=""}
<meta name="description" content="{$meta_description}" />
{/if}
{if $meta_keywords!=""}
<meta name="keywords" content="{$meta_keywords}" />
{/if}

{if $head_css|@count > 0}{foreach from=$head_css item=css}
	<link href="{$BASE_URL}assets/css/{$css}" rel="stylesheet" type="text/css" />
{/foreach}
{/if}

{if $head_js|@count > 0}{foreach from=$head_js item=js}
	<script type="text/javascript" src="{$BASE_URL}assets/js/{$js}"></script>
{/foreach}
{/if}


{if $extraHead|@count > 0}{foreach from=$extraHead item=script}{$script}
{/foreach}
{/if}
<script language="javascript">
var BASEURL = '{$BASE_URL}';
</script>
</head>
<body>
{include file="header.tpl"}
<div class="container_12"> 
	
	{if $AdminMessage|@count>0 }<div> <span class="notification n-{$AdminMessage.type}">{$AdminMessage.msg}</span></div>{/if}
  
  {$body}
  <div class="clear"></div>
</div>
{include file="footer.tpl"}
</body>
</html>
