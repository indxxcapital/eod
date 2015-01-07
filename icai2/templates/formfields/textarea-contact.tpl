<textarea name="{$formParams.feild_code}" id="{$formParams.feild_code}" {$formParams.option}   value="{$formParams.feild_label}" {if $formParams.class}class="{$formParams.class}"{/if}{$formParams.feildValues}>{$formParams.feild_label}</textarea>
<span id="error_{$formParams.feild_code}" {$formParams.errorClass}>{$formParams.errorMessage}</span>
		
