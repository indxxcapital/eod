 <div class="control-group"><span id="feildHtml_{$formParams.feild_code}"> <label class="control-label">{$formParams.feild_label}{if $formParams.is_required eq '1'} <sup style="color:#F00;">*</sup>{/if}:</label><div class="controls"><input type="file" name="{$formParams.feild_code}" id="{$formParams.feild_code}"   class="{$formParams.class}" /></div></span> {if $formParams.feild_note}
<span class="validation-note" style="margin-left:180px !important;">{$formParams.feild_note}</span>{/if}
{if $formParams.value}<br /> 

{if $formParams.feild_option.type=="image"}<BR /><img src="{$SITE_URL}media/{$formParams.feild_option.folder}/orignal/{$formParams.value}"  width="50%" height="50%"/>
{else}
<a href="index.php?module=ajax&event=downloadFile&folder={$formParams.itemData.feild_option.folder}&file={$formParams.value}&type={$formParams.itemData.feild_option.type}" target="_blank">{$formParams.value}</a>
{/if}
<input type="checkbox" name="delete_file[]" value="{$formParams.feild_code}" /> delete file<br />
{/if}
<span id="error_{$formParams.feild_code}" {$formParams.errorClass}>{$formParams.errorMessage}</span></div>