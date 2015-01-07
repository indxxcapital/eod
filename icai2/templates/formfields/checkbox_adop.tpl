
<input style="width:10px; margin-right:5px;" type="checkbox" name="{$formParams.feild_code}" id="{$formParams.feild_code}" value="{$formParams.value}" class="{$formParams.class}"/> {$Form_Params.staticValue}<label class="{$formParams.class}"> {l text="I agree to the"}  <a style="cursor:pointer;"  onclick="return optionwindow();">{$formParams.feild_label_1}</a>{if $formParams.is_required eq '1'} {/if}</label>
	<span id="error_{$formParams.feild_code}" {$formParams.errorClass}>{$Form_Params.errorMessage}</span>

		
