
<label>{$formParams.feild_label}{if $formParams.is_required eq '1'} <sup class="redalert">*</sup>{/if}:</label>
		<input type="{$formParams.feild_type}" name="{$formParams.feild_code}" id="{$formParams.feild_code}" value="{$formParams.value}" {if $formParams.class}class="{$formParams.class}"{/if} {$formParams.feildValues}/>
<span id="error_{$formParams.feild_code}" {$formParams.errorClass}>{$formParams.errorMessage}</span>