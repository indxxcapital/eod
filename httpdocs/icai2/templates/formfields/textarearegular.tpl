<label>{$formParams.feild_label}:{if $formParams.is_required} <sup class="redalert">*</sup>{/if} </label>
	<span>    
<textarea name="{$formParams.feild_code}" id="{$formParams.feild_code}" class="{$formParams.class}">{$formParams.value}</textarea>
</span>
<label></label><span id="error_{$formParams.feild_code}" {$formParams.errorClass}>{$formParams.errorMessage}</span>
		
