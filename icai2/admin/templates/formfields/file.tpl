<span id="feildHtml_{$Form_Params.name}"><input type="file" name="{$Form_Params.name}" id="{$Form_Params.name}"   class="{$Form_Params.class}" />{if $Form_Params.feild_note}<br />
{$Form_Params.feild_note}{/if}</span> 
{if $Form_Params.value}<br /> 

{if $Form_Params.feild_option.type=="image"}<BR /><img src="{$SITE_URL}media/{$Form_Params.feild_option.folder}/orignal/{$Form_Params.value}"  width="50px" height="50px"/>
{else}
<a href="index.php?module=ajax&event=downloadFile&folder={$Form_Params.feild_option.folder}&file={$Form_Params.value}&type={$Form_Params.feild_option.type}" target="_blank">{$Form_Params.value}</a>
{/if}

{/if}
<span id="error_{$Form_Params.name}" {$Form_Params.errorClass}>{$Form_Params.errorMessage}</span>