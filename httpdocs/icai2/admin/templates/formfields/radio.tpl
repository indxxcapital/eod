<!--
{foreach from=$Form_Params.options key=k item=item}
	 
	<label><input style="width:10px" type="radio" name="{$Form_Params.name}" id="{$Form_Params.name}_{$k}" value="{$k}" class="{$Form_Params.class}"
    {if $Form_Params.value==$k} checked="checked"{/if}/> {$item}</label>
	{/foreach}

<span id="error_{$Form_Params.name}" {$Form_Params.errorClass}>{$Form_Params.errorMessage}</span>-->


<label>{if $Form_Params.is_required}<sup class="redalert">*</sup>{/if}</label>

{foreach from=$Form_Params.options key=k item=item}

	<span class="search-radio"><input style="width:10px" type="radio" name="{$Form_Params.name}" id="{$Form_Params.name}_{$k}" value="{$k}" class="{$Form_Params.class}" {if $Form_Params.value == $k} checked="checked"{/if} {$Form_Params.feildValues}/> {$item}</span>
	{/foreach}

<span id="error_{$Form_Params.feild_code}" {$Form_Params.errorClass}>{$Form_Params.errorMessage}</span>
