

{foreach from=$Form_Params.options key=k item=item}
	 {$Form_Params.value}
	<label><input style="width:10px" type="radio" name="{$Form_Params.name}" id="{$Form_Params.name}_{$k}" value="{$k}" class="{$Form_Params.class}"{if $Form_Params.value==$item.id} checked="checked"{/if}/> {$item}</label>
	{/foreach}

<span id="error_{$Form_Params.name}" {$Form_Params.errorClass}>{$Form_Params.errorMessage}</span>
