
<input type="text" name="{$formParams.feild_code}" {$formParams.option} id="{$formParams.feild_code}"   value="{$formParams.feild_label}" {if $formParams.class}class="{$formParams.class}"{/if} {$formParams.feildValues}/>
<span id="error_{$formParams.feild_code}" {$formParams.errorClass}>{$formParams.errorMessage}</span>