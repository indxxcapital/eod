<span id="feild_{$Form_Params.name}">
<select class="{$Form_Params.class}"  name="{$Form_Params.name}" id="{$Form_Params.name}" {$Form_Params.feildValues}>
	
	{html_options options=$Form_Params.options selected=$Form_Params.value}
	
	
	 

</select>
</span>
<span id="extra_{$Form_Params.name}" style="display:none"></span>
<span id="error_{$Form_Params.name}" {$Form_Params.errorClass}>{$Form_Params.errorMessage}</span>