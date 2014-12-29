<div class="control-group"><label class="control-label">{$formParams.feild_label}{if $formParams.is_required eq '1'} <sup style="color:#F00;">*</sup>{/if}:</label>
<div class="controls"><select class="input-xlarge" style=" width:283px !important" tabindex="1"  name="{$formParams.feild_code}[]" id="{$formParams.feild_code}" {$Form_Params.feildValues} multiple="multiple">
	
	{html_options options=$formParams.options selected=$formParams.value}
	
	
	 

</select></div>
<span id="extra_{$formParams.name}" style="display:none"></span>
<span id="error_{$formParams.feild_code}" {$formParams.errorClass}>{$Form_Params.errorMessage}</span></div>