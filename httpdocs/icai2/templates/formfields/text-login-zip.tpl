
<label class="ziptxt">{$formParams.feild_label}{if $formParams.is_required eq '1'} <em class="redalert">*</em>{/if}</label>
		<span class="zipbg" id="feildHtml_{$formParams.feild_code}">	<input type="{$formParams.feild_type}" name="{$formParams.feild_code}" id="{$formParams.feild_code}" value="{$formParams.value}" {if $formParams.class}class="{$formParams.class}"{/if} class="zipbox" {$formParams.feildValues}/></span>
<!--<label>&nbsp;</label>	--><span id="error_{$formParams.feild_code}" {$formParams.errorClass} class="error">{$formParams.errorMessage}</span>


