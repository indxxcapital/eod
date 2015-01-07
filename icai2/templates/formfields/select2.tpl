<div class="holder">
                           <div class="form-div-1 clearfix" style=" width:550px !important; padding-left:420px !important;">
                                   
                                    <label class="name">{$formParams.feild_label}{if $formParams.is_required eq '1'} <sup style="color:#F00;">*</sup>{/if}:</label></div>
                            <div class="form-div-2 clearfix">
<select class="input-xlarge" style=" width:249px !important" tabindex="1"  name="{$formParams.feild_code}" id="{$formParams.feild_code}" {$Form_Params.feildValues}>
	
	{html_options options=$formParams.options selected=$formParams.value}
	
	
	 

</select><span class="empty-message">{$formParams.errorMessage}</span>
                            </div>
                            </div>