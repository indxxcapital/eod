<div class="container_12"><div class="grid_12">
 
                <div class="module">
                     <h2><span>{$title}</span></h2>
                                
                     <div class="module-body">
                     {if $error!="" }
 <div>
<span class="notification n-<?=$error?>"><?=$msg?></span>
</div>
{/if}
                        <form name="reserve" id="reserve" action="index.php?module={$currentClass}&event=edit&id={$postData.id}{$backVars}" method="post" onsubmit="return ValidateForm();" enctype="multipart/form-data" >
				
				<input type="hidden" id="id" name="id" value="{$postData.id}" />
					<input type="hidden" id="pid" name="pid" value="{$smarty.get.pid}" />
				
				<div class="grid_6" style="width:445px;">
				
				 
				{foreach from=$fields key=p item=item}
				{if $p == $fieldsCount}
				</div><div class="grid_6" style="width:445px;">
				{/if}
				{if $item.feild_type!='hidden'}
				
				<p  id="block_{$item.feild_code}"><label><strong>{$item.feild_label}</strong> {if $item.is_required==1}<span class="red">*</span>{/if}</label>
				{/if}
				
				
				 
				{formfield type=$item.feild_type itemData=$item  name=$item.feild_code model=$item.model feild_note= $item.feild_note onChange=$item.onChange value=$postData staticValue= $item.value class="input-long"}{/formfield}
				
				
				
				
				
				{if $item.feild_type!='hidden'}
				</p>
				{/if}
				
				{/foreach}
				</div> 
				<div style="clear:both"></div>
                 <fieldset>
                                <input class="submit-green" type="submit" name="submit" value="Submit" /> 
                                <input class="submit-gray" type="button" onclick="window.location='index.php?module={$currentClass}{$backVars}{if $smarty.get.pid}&pid={$smarty.get.pid}{/if}'" value="Cancel" />
                            </fieldset>            
                           
                        </form>
                     </div> <!-- End .module-body -->

                </div>  <!-- End .module -->
        		<div style="clear:both;"></div>
            </div>

</div>

<script language="javascript">

{foreach from=$fields key=p item=item}
{if $item.feildOptions.onChange}
{capture name="ajaxCurrentValue"}{$item.feildOptions.onChange|updateid}{/capture}
	{if $smarty.capture.ajaxCurrentValue}
		var {$item.feild_code} = '{$postData[$item.feild_code]}';
		
		
		if({$item.feild_code}!="")
		{literal}
		{
		{/literal}	
		
		
		{capture name="ajaxChange"}{$item.feild_code} , '{$postData[$smarty.capture.ajaxCurrentValue]}'{/capture}
		{$item.feildOptions.onChange|replace:'this.value':$smarty.capture.ajaxChange}
		{literal}
		}
		{/literal}
	
	{/if}
{/if}
{/foreach}
</script>