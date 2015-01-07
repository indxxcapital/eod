
		<label>{$formParams.feild_label}{if $formParams.is_required} <sup class="redalert">*</sup>{/if}</label>
		 <input type="password" name="{$formParams.feild_code}" id="{$formParams.feild_code}" {if $formParams.class}class="{$formParams.class}"{/if} {$formParams.feildValues}/>
		<span id="error_{$formParams.feild_code}" {$formParams.errorClass}>{$formParams.errorMessage}</span>
	
    
    