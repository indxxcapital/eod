<div class="control-group"><label for="password2" class="control-label">{$formParams.feild_label}{if $formParams.is_required eq '1'} <sup style="color:#F00;">*</sup>{/if}:</label><div class="controls">
		 <input type="password" name="{$formParams.feild_code}" id="{$formParams.feild_code}" class="input-xlarge" {$formParams.feildValues}/></div>
<!--<label></label>--><span id="error_{$formParams.feild_code}" {$formParams.errorClass}>{$formParams.errorMessage}</span></div>
