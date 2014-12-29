
<label>{$formParams.feild_label}{if $formParams.is_required eq '1'} <sup class="redalert">*</sup>{/if}:</label>
		<input type="file" name="{$formParams.feild_code}" id="{$formParams.feild_code}" value="{$formParams.value}" {if $formParams.class}class="{$formParams.class}"{/if}/>
<span id="error_{$formParams.feild_code}" {$formParams.errorClass}>{$formParams.errorMessage}</span>
