{foreach from=$Form_Params.options item=item}
	 
	<label><input style="width:10px" type="checkbox" name="{$Form_Params.name}" id="{$Form_Params.name}_{$item.id}" value="{$item.id}" class="{$Form_Params.class}" {if $Form_Params.value==$item.id} checked="checked"{/if}/> {$Form_Params.staticValue}</label>
	{/foreach}
<span id="error_{$Form_Params.name}" {$Form_Params.errorClass}>{$Form_Params.errorMessage}</span>