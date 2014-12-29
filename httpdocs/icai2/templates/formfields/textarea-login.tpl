
<label>{$formParams.feild_label}{if $formParams.is_required eq '1'} <em class="redalert">*</em>{/if}</label>
<span class="" id="feildHtml_{$formParams.feild_code}"><textarea name="{$formParams.feild_code}" id="{$formParams.feild_code}" {$formParams.option}   value="{$formParams.feild_label}" {if $formParams.class}class="{$formParams.class}"{/if}>{$formParams.feildValues}</textarea>
</span>
<span id="error_{$formParams.feild_code}" {$formParams.errorClass}>{$formParams.errorMessage}</span>
		
