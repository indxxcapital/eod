<span id="feildHtml_{$Form_Params.name}"><input type="text" name="{$Form_Params.name}" id="{$Form_Params.name}" value="{$Form_Params.value}" class="{$Form_Params.class}" {$Form_Params.feildValues}/></span>{if $Form_Params.feild_note}<br />
{$Form_Params.feild_note}{/if}</span> 
<span id="error_{$Form_Params.name}" {$Form_Params.errorClass}>{$Form_Params.errorMessage}</span>



{if $Form_Params.autoSuggest}

<link href="{$ADMIN_BASE_URL}assets/auto/css/autosuggest_inquisitor.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{$ADMIN_BASE_URL}assets/auto/js/bsn.AutoSuggest_c_2.0.js"></script>
{literal}
<script language="javascript" type="text/javascript">


jQuery({/literal}'#{$Form_Params.name}'{literal}).attr("autocomplete","off") ;
jQuery({/literal}'#{$Form_Params.name}'{literal}).bind("keypress",function(){
{/literal}																	   
 
lookup{$Form_Params.name}(this.value)		
{literal}
});
function {/literal}lookup{$Form_Params.name}{literal}(inputString) {
 
	var options = {
		{/literal}
		script: BASEURL+"index.php?module=ajax&event={$Form_Params.autoSuggest.function}& ",
		{literal}
		varname:"input",
		json:true,
		callback: function (obj) { 
		
		{/literal}
					{foreach from=$Form_Params.callBack item=callback}
						jQuery('#{$Form_Params.autoSuggest.id}') .val(obj.id);
					 
						{$callback|replace:'this.value':'obj.id'}
					{/foreach}
		{literal}
		
		}
	};
	
	jQuery('[name=reset]').bind("click",function(){ });
	{/literal}	
	 
	var as_json = new AutoSuggest('{$Form_Params.name}', options);	
	
	
	{literal}
}


	 
 
	</script>

{/literal}

{/if}

