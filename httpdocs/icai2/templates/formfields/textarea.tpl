 <div class="control-group"><label class="control-label">{$formParams.feild_label}{if $formParams.is_required eq '1'} <sup style="color:#F00;">*</sup>{/if}:</label><div class="controls">{if $Form_Params.editor}

{editor  id=$formParams.feild_code Instancefeild_code=$formParams.feild_code width="740px" height="200px" Value=$formParams.value}
{else}

<textarea name="{$formParams.feild_code}" id="{$formParams.feild_code}" style="height: 175px;width: 700px;" class="{$formParams.class}">{$formParams.value}</textarea>
{/if}</div>
{if $formParams.feild_note}<br />
{$formParams.feild_note}{/if}</span> 
<span id="error_{$formParams.feild_code}" {$formParams.errorClass}>{$formParams.errorMessage}</span>