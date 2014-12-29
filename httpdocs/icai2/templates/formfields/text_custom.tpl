<label>{$formParams.feild_label}{if $formParams.is_required eq '1'} <sup class="redalert">*</sup>{/if}:</label><input type="text" name="{$formParams.name}" id="{$formParams.name}" onblur="focusvalueatr_number(this.value)" onfocus="focusvalueatr_number(this.value)" value="{$formParams.value}" class="{$formParams.class}" {$formParams.feildValues}/></span>
<span id="error_{$formParams.name}" {$Form_Params.errorClass}>{$formParams.errorMessage}</span>

{$BASEURL}

{if $formParams.autoSuggest}

<link href="{$ADMIN_BASE_URL}assets/auto/css/autosuggest_inquisitor.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{$ADMIN_BASE_URL}assets/auto/js/bsn.AutoSuggest_c_2.0.js"></script>
{literal}
<script language="javascript" type="text/javascript">


jQuery({/literal}'#{$formParams.name}'{literal}).attr("autocomplete","off") ;
jQuery({/literal}'#{$formParams.name}'{literal}).bind("keypress",function(){
{/literal}																	   
 
lookup{$formParams.name}(this.value)		
{literal}
});
function remove_space(space) { return space.replace(/^\s+|\s+$/, ''); };
function focusvalueatr_number(inputString) {
	
	jQuery.get(BASEURL+"index.php?module=ajax&event=selectearticalnumber",{articalnumber: inputString},
		function(data){
			var response=remove_space(data)
			
			if(data!=0)
			{
			document.getElementById("image_detail").style.display='';
				var response_arr=response.split('__and__');
				document.getElementById("id").value=remove_space(response_arr[0]);
				document.getElementById("prtype_id").value=remove_space(response_arr[1]);
				document.getElementById("count").value=remove_space(response_arr[2]);
				document.getElementById("pack_id").value=remove_space(response_arr[3]);
				document.getElementById("factory_id").value=remove_space(response_arr[4]);
				document.getElementById("artical_head").innerHTML='#'+remove_space(response_arr[5]);
					document.getElementById("product_image").src=BASEURL+'media/product_image/order/'+remove_space(response_arr[6]);
				
		//	alert(data);
				
				
				
			}
		}); 
	
}
function {/literal}lookup{$formParams.name}{literal}(inputString) {
 
	var options = {
		{/literal}
		script: BASEURL+"index.php?module=ajax&event={$formParams.autoSuggest.function}& ",
		{literal}
		varname:"input",
		json:true,
		callback: function (obj) { 
		
		{/literal}
					{foreach from=$Form_Params.callBack item=callback}
						jQuery('#{$formParams.autoSuggest.id}') .val(obj.id);
					alert(obj.id);
						{$callback|replace:'this.value':'obj.id'}
					{/foreach}
		{literal}
		
		}
	};
	
	jQuery('[name=reset]').bind("click",function(){ });
	
	
	{/literal}	
	 
	var as_json = new AutoSuggest('{$formParams.name}', options);	
	
	
	{literal}
}


	 
 
	</script>

{/literal}

{/if}

