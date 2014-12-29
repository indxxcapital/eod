<label>{$formParams.feild_label}{if $formParams.is_required} <em class="redalert">*</em>{/if}</label><select  name="{$formParams.feild_code}" id="{$formParams.feild_code}" {if $formParams.class}class="{$formParams.class}"{/if} {if $formParams.feild_code=='product'} style="width:350px !important; background:#D3CBED;"{elseif $formParams.feild_code=='ptype'}style="background:#b3a8d5;"{/if} {$formParams.feildValues}>	
{html_options options=$formParams.options selected=$formParams.value}
</select>
