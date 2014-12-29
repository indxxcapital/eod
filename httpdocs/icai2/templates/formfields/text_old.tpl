<label>{$formParams.feild_label}{if $formParams.is_required eq '1'} <sup class="redalert">*</sup>{/if}:</label><input type="text" name="{$formParams.feild_code}" id="{$formParams.feild_code}" value="{$formParams.value}" class="{$formParams.class}" {$formParams.feildValues}/></span>
<span id="error_{$formParams.feild_code}" {$Form_Params.errorClass}>{$formParams.errorMessage}</span>

{$BASEURL}

{if $formParams.autoSuggest}

<link href="{$ADMIN_BASE_URL}assets/auto/css/autosuggest_inquisitor.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{$ADMIN_BASE_URL}assets/auto/js/bsn.AutoSuggest_c_2.0.js"></script>
{literal}
<script language="javascript" type="text/javascript">


jQuery({/literal}'#{$formParams.feild_code}'{literal}).attr("autocomplete","off") ;
jQuery({/literal}'#{$formParams.feild_code}'{literal}).bind("keypress",function(){
{/literal}																	   
 
lookup{$formParams.feild_code}(this.value)		
{literal}
});
function {/literal}lookup{$formParams.feild_code}{literal}(inputString) {
 
	var options = {
		{/literal}
		script: BASEURL+"index.php?module=ajax&event={$formParams.autoSuggest.function}& ",
		{literal}
		varfeild_code:"input",
		json:true,
		callback: function (obj) { 
		
		{/literal}
					{foreach from=$Form_Params.callBack item=callback}
						jQuery('#{$formParams.autoSuggest.id}') .val(obj.id);
					 
						{$callback|replace:'this.value':'obj.id'}
					{/foreach}
		{literal}
		
		}
	};
	
	jQuery('[feild_code=reset]').bind("click",function(){ });
	{/literal}	
	 
	var as_json = new AutoSuggest('{$formParams.feild_code}', options);	
	
	
	{literal}
}


	 
 
	</script>

{/literal}

{/if}

