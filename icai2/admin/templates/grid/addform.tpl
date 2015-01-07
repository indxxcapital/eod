{literal}

<script language="javascript" type="text/javascript">
$("form").submit(function() {
if ($('#loading_image').length == 0) { //is the image on the form yet?
                // add it just before the submit button
$(':submit').before('<img src="{/literal}{$BASE_URL}{literal}assets/images/ajax-loader2.gif" style="display: none;" alt="loading" id="loading_image">')
}
    $('#loading_image').show(); // show the animated image
    $(':submit',this).attr('disabled','disabled'); // disable double submits
    return true; // allow regular form submission
});
</script>
{/literal}


 {if $error!="" }
 <div>
<span class="notification n-<?=$error?>"><?=$msg?></span>
</div>
{/if}
                        <form name="reserve" id="reserve" method="post" onsubmit="return ValidateForm();" enctype="multipart/form-data" >
				<div class="grid_6" style="width:445px;">
				
				 
				{foreach from=$fields key=p item=item}
				{if $p == $fieldsCount}
				</div><div class="grid_6" style="width:445px;">
				{/if}
				{if $item.feild_type!='hidden'}
				
				<p  {foreach from=$item.blockOption key=block item=blockitem} {$block}="{$blockitem}"{/foreach} id="block_{$item.feild_code}"><label><strong>{$item.feild_label}</strong> {if $item.is_required==1}<span class="red">*</span>{/if}</label>
				{/if}
				
				
				{formfield type=$item.feild_type itemData=$item  name=$item.feild_code model=$item.model feild_note= $item.feild_note onChange=$item.onChange value=$postData staticValue= $item.value class="input-long"}{/formfield}
				
			<!--	{formfield type=$item.feild_type  name=$item.feild_code model=$item.model feildOptions=$item.feildOptions value=$postData staticValue= $item.value class="input-long"}{/formfield}-->

				{if $item.feild_type!='hidden'}
				</p>
				{/if}
				
				{/foreach}
				</div> 
				<div style="clear:both"></div>
                 <fieldset>
                                <input class="submit-green" type="submit" name="submit" value="Submit" /> 
                                <input class="submit-gray" type="button" onclick="window.location='index.php?module={$currentClass}{if $smarty.get.pid}&pid={$smarty.get.pid}{/if}'" value="Cancel" />
                            </fieldset>            
                           
                        </form>