<label>{$formParams.feild_label}:{if $formParams.is_required} <sup class="redalert">*</sup>{/if}</label>
	<span class="slct" id="feildHtml_{$formParams.feild_code}">
		<select  name="{$formParams.feild_code}" id="{$formParams.feild_code}" {if $formParams.class}class="{$formParams.class}"{/if} {$formParams.feildValues}>	
	{html_options options=$formParams.options selected=$formParams.value}
</select></span>
		 <span class="error" id="error_{$formParams.feild_code}" {$formParams.errorClass}>{$formParams.errorMessage}</span>
		