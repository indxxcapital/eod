<label class="statetxt">{$formParams.feild_label}{if $formParams.is_required} <em class="redalert">*</em>{/if}</label>
		<span class="statbg" id="feildHtml_{$formParams.feild_code}">
		<select  name="{$formParams.feild_code}" id="{$formParams.feild_code}" {if $formParams.class}class="{$formParams.class}"{/if} {$formParams.feildValues}>	
	{html_options options=$formParams.options selected=$formParams.value}
</select></span>
<span  id="error_{$formParams.feild_code}" {$formParams.errorClass}>{$formParams.errorMessage}</span>
		
