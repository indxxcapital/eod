
		<label>{$formParams.feild_label}{if $formParams.is_required} <em class="redalert">*</em>{/if}</label>
		<span class="" id="feildHtml_{$formParams.feild_code}"> <input type="password" name="{$formParams.feild_code}" id="{$formParams.feild_code}" {if $formParams.class}class="{$formParams.class}"{/if} {$formParams.feildValues}/></span>
        <span id="strength"></span>
		<span id="error_{$formParams.feild_code}" {$formParams.errorClass}  class="error">{$formParams.errorMessage}</span>
	
    
    