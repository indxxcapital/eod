<script type="text/javascript" src="http://97.74.65.118/icai/assets/assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <link rel="stylesheet" type="text/css" href="http://97.74.65.118/icai/assets/assets/bootstrap-datepicker/css/datepicker.css" />
    <div class="holder">
                           <div class="form-div-1 clearfix" style=" width:550px !important; padding-left:420px !important;">
                                   
  <label class="name" style="margin-top:10px !important;">{$formParams.feild_label}{if $formParams.is_required eq '1'} <sup style="color:#F00;">*</sup>{/if}:</label>
 </div>
                            <div class="form-div-2 clearfix"><input type="text" placeholder="YYYY-MM-DD"  name="{$formParams.feild_code}" id="{$formParams.feild_code}" value="{$formParams.value}" class="date-pick{$formParams.name}{if $formParams.class!=""} {$formParams.class}{/if} date-picker"/>
<span id="error_{$formParams.feild_code}" {$formParams.errorClass}>{$formParams.errorMessage}</span>
</div>
</div>

