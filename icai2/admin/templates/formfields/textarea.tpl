{if $Form_Params.editor}

{editor  id=$Form_Params.name InstanceName=$Form_Params.name width="740px" height="200px" Value=$Form_Params.value}
{else}

<textarea name="{$Form_Params.name}" id="{$Form_Params.name}" {if $Form_Params.maxlength}maxlength="{$Form_Params.maxlength}"{/if} class="{$Form_Params.class}">{$Form_Params.value}</textarea>
{/if}
{if $Form_Params.feild_note}<br />
{$Form_Params.feild_note}{/if}</span> 
<span id="error_{$Form_Params.name}" {$Form_Params.errorClass}>{$Form_Params.errorMessage}</span>