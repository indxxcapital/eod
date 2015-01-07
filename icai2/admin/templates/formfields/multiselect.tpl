
<select class="{$Form_Params.class}" multiple="multiple"  name="{$Form_Params.name}[]" id="{$Form_Params.name}" {if $Form_Params.onChange}onchange="{$Form_Params.onChange}"{/if}>
	
	{html_options options=$Form_Params.options selected=$Form_Params.value}
	
	
	 

</select>
<span id="error_{$Form_Params.name}" {$Form_Params.errorClass}>{$Form_Params.errorMessage}</span>