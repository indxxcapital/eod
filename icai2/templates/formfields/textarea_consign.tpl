<label>{$formParams.feild_label}{if $formParams.is_required eq '1'} <em class="redalert">*</em>{/if} </label><br />{if $formParams.editor}
<span>
{editor  id=$formParams.name InstanceName=$formParams.name width="740px" height="200px" Value=$formParams.value}
{else}

<textarea name="{$formParams.feild_code}" id="{$formParams.feild_code}" style="height: 54px;width: 269px;" class="{$formParams.class}">{$formParams.value}</textarea></span> 
{/if}
{if $formParams.feild_note}<label>&nbsp;</label>
{$formParams.feild_note}{/if}
<br>
<span id="error_{$formParams.feild_code}" {$formParams.errorClass}>{$Form_Params.errorMessage}</span>