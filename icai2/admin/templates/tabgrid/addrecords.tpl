<div class="container_12"><div class="grid_12">
 
           <div class="module">
                     <h2><span>{$title}</span></h2>
                                
                     <div class="module-body">
                     {if $error!="" }
						 <div><span class="notification n-<?=$error?>"><?=$msg?></span>
						</div>
					{/if}
 
		
			
				
		<div class="tab-panel-content">
			
		<div class="overseastab">
	<ul id="leftTabs">
	{foreach from=$tabKeys key=indexKey item=tabs name=tabs}
	
	<li id="{$tabs}" { if $smarty.foreach.tabs.first} class="tab-active" {/if}>
		<a href="javascript:;" onclick="javascript:showHideTabs('{$tabs}', 'rght-{$tabs}');" title="{$fields[$tabs].name}">{$fields[$tabs].name}</a>
	</li>
	{/foreach}
	
	
	</ul>
</div>
		
			
			
		<div class="overseasrt" id="rightTabs">
        
         
		<span class="notification n-error" id="other-error-message" style="display:none;"></span>
		<form name="reserve" id="reserve" action="index.php?module={$currentClass}&event=addNew" method="post" enctype="multipart/form-data" >
				<fieldset id="submitButtons">
					<input class="submit-green" type="submit" name="submit" value="Submit" /> 
					<input class="submit-gray" type="button" onclick="window.location='index.php?module={$currentClass}'" value="Cancel" />
				</fieldset> 
			
					
			{foreach from=$fields key=p item=feilds  name=fieldsArr}
			
			
				<div id="rght-{$p}" { if !$smarty.foreach.fieldsArr.first} style="display:none;" {/if} >			
			{if $fields[$p].file !=""}
				
                {include file = $fields[$p].file}
                {else}
				
					<p>
						{foreach from=$feilds.validData key=i item=item}
				
								{if $p == $fieldsCount}
								</div><div class="grid_6" style="width:584px;">
								{/if}
								
								{if $item.feild_type!='hidden'}				
								<p  {foreach from=$item.blockOption key=block item=blockitem} {$block}="{$blockitem}"{/foreach} id="block_{$item.feild_code}"><label><strong>{$item.feild_label}</strong> {if $item.is_required==1}<span class="red">*</span>{/if}</label>
								{/if}			
								
								{formfield type=$item.feild_type itemData=$item  name=$item.feild_code model=$item.model feild_note= $item.feild_note onChange=$item.onChange value=$postData staticValue= $item.value class="input-long"}{/formfield}	
				
								{if $item.feild_type!='hidden'}
								</p>
								{/if}
						
						{/foreach}	
							{if $p == 'price'}	
							{ include file="product/price.tpl" }
							{/if}
					</p> 
					{/if}
				</div>
				
			{/foreach}			
			
			
			
		  
		
				<fieldset id="submitButtons">
					<input class="submit-green" type="submit" name="submit" value="Submit" /> 
					<input class="submit-gray" type="button" onclick="window.location='index.php?module={$currentClass}'" value="Cancel" />
				</fieldset> 
				
		 </form>
		    
		   
						
							
		</div>		
		
						
				
				<div style="clear:both"></div>
                 
                     </div> <!-- End .module-body -->

                </div>  <!-- End .module -->
        		<div style="clear:both;"></div>
            </div>

</div>


 
<script language="javascript">

{foreach from=$fields key=p item=feilds  name=fieldsArr}
			
{foreach from=$feilds->validData key=p item=item}
{if $item.feildOptions.onChange}
var {$item.feild_code} = '{$postData[$item.feild_code]}';


if({$item.feild_code}!="")
{literal}
{
{/literal}	
{capture name="ajaxCurrentValue"}{$item.feildOptions.onChange|updateid}{/capture}

{capture name="ajaxChange"}{$item.feild_code} , '{$postData[$smarty.capture.ajaxCurrentValue]}'{/capture}
{$item.feildOptions.onChange|replace:'this.value':$smarty.capture.ajaxChange}
{literal}
}
{/literal}
{/if}
{/foreach}
{/foreach}
</script>

