<div class="container_12"><div class="grid_12">
 
                <div class="module">
                     <h2><span>{$title}</span></h2>
                                
                     <div class="module-body">
                     {if $error!="" }
 <div>
<span class="notification n-<?=$error?>"><?=$msg?></span>
</div>
{/if}
 
						
						 	<fieldset>
                                 
								  
                                <input class="submit-gray" type="button" onclick="window.location='index.php?module={$currentClass}&event=index&filter={$filter}&DisplayRecords={$DisplayRecords}&ShowThisPage={$ShowThisPage}&sortby={$sortby}&sortDirection={$sortDirection}&page={$page}&pagegroup={$pagegroup}'" value="Back" />
							 
								 
								{foreach from=$gridButtons key=p item=item}
								
								<input class="submit-green" type="button" onclick="window.location='{$item.action}&DisplayRecords={$DisplayRecords}&ShowThisPage={$ShowThisPage}&sortby={$sortby}&sortDirection={$sortDirection}&page={$page}&pagegroup={$pagegroup}'" value="{$item.label}" />
								{/foreach}
								
                            </fieldset>
						
				<div align="center">
				{$viewTopData}
				</div>
				<div class="grid_6" style="width:445px;">
				
				 
				{foreach from=$fields key=p item=item}
				{if $p == $fieldsCount}
				</div><div class="grid_6" style="width:445px;">
				{/if}
				{if $item.feild_type!='hidden'}
				
				<p><label><strong>{$item.feild_label}</strong> {if $item.is_required==1}<span class="red">*</span>{/if}</label>
				{/if}
				
				
				 {if $viewData[$item.feild_code] && $viewData[$item.feild_code]!="00/00/0000"}
				 {$item.feild_prefix}{$viewData[$item.feild_code]|nl2br}{$item.feild_sufix}
				 {else}
				 n/a
				 {/if}
				
				
				
				
				{if $item.feild_type!='hidden'}
				</p>
				{/if}
				
				{/foreach}
				</div> 
				<div style="clear:both"></div>
				
				
				<div>
				{$viewBottomData}
				</div>
                 <fieldset>
                                 
								  
                                <input class="submit-gray" type="button" onclick="window.location='index.php?module={$currentClass}&event=index&filter={$filter}&DisplayRecords={$DisplayRecords}&ShowThisPage={$ShowThisPage}&sortby={$sortby}&sortDirection={$sortDirection}&page={$page}&pagegroup={$pagegroup}'" value="Back" />
								 
								{foreach from=$gridButtons key=p item=item}
								
								<input class="submit-green" type="button" onclick="window.location='{$item.action}&DisplayRecords={$DisplayRecords}&ShowThisPage={$ShowThisPage}&sortby={$sortby}&sortDirection={$sortDirection}&page={$page}&pagegroup={$pagegroup}'" value="{$item.label}" />
								{/foreach}
                            </fieldset>    
							        
                           
                         
                     </div> <!-- End .module-body -->

                </div>  <!-- End .module -->
        		<div style="clear:both;"></div>
            </div>

</div>