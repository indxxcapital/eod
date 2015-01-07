
		<span class="chkbox">
         <input type="checkbox" name="{$Form_Params.feild_code}" id="{$Form_Params.feild_code}" value="1" {if $Form_Params.class}class="{$Form_Params.class}"{/if} {if $Form_Params.value=='1'} checked="checked"{/if}  {$Form_Params.feildValues} />
         </span>
	<span id="error_{$Form_Params.feild_code}" {$formParams.errorClass}>{$Form_Params.errorMessage}</span>