<span id="feild_{$formParams.name}">
<select class="{$formParams.class}"  name="{$formParams.name}" id="{$formParams.name}" {$Form_Params.feildValues}>
	
	{html_options options=$formParams.options selected=$Form_Params.value}
	
	
	 

</select>
</span>
<span id="extra_{$formParams.name}" style="display:none"></span>
<span id="error_{$formParams.name}" {$formParams.errorClass}>{$Form_Params.errorMessage}</span>