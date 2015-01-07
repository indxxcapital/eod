<div class="container_12"><div class="grid_12">
 
                <div class="module">
                     <h2><span>{$title}</span></h2>
                                
                     <div class="module-body">
                     {if $error!="" }
 <div>
<span class="notification n-<?=$error?>"><?=$msg?></span>
</div>
{/if}
 
				<form name="{$currentFunction}" id="{$currentFunction}" action="index.php?module={$currentClass}&event={$currentFunction}" method="post" onsubmit="return ValidateForm();" >		
						 	<fieldset>
                                 
								  
                                <input class="submit-gray" type="button" onclick="window.location='index.php?module={$currentClass}&event=index&filter={$filter}&DisplayRecords={$DisplayRecords}&ShowThisPage={$ShowThisPage}&sortby={$sortby}&sortDirection={$sortDirection}&page={$page}&pagegroup={$pagegroup}'" value="Back" />
								<input class="submit-green" type="button" onclick="window.location='index.php?module={$currentClass}'" value="Cancel" />
								 
								{foreach from=$gridButtons key=p item=item}
								
								<input class="submit-green" type="button" onclick="window.location='{$item.action}&DisplayRecords={$DisplayRecords}&ShowThisPage={$ShowThisPage}&sortby={$sortby}&sortDirection={$sortDirection}&page={$page}&pagegroup={$pagegroup}'" value="{$item.label}" />
								{/foreach}
								
                            </fieldset>
						
				 {$viewData}
				   
				<div style="clear:both"></div>
				
				
				 
                 <fieldset>
                                 
								  
                                <input class="submit-gray" type="button" onclick="window.location='index.php?module={$currentClass}&event=index&filter={$filter}&DisplayRecords={$DisplayRecords}&ShowThisPage={$ShowThisPage}&sortby={$sortby}&sortDirection={$sortDirection}&page={$page}&pagegroup={$pagegroup}'" value="Back" />
								<input class="submit-green" type="button" onclick="window.location='index.php?module={$currentClass}'" value="Cancel" />
								{foreach from=$gridButtons key=p item=item}
								
								<input class="submit-green" type="button" onclick="window.location='{$item.action}&DisplayRecords={$DisplayRecords}&ShowThisPage={$ShowThisPage}&sortby={$sortby}&sortDirection={$sortDirection}&page={$page}&pagegroup={$pagegroup}'" value="{$item.label}" />
								{/foreach}
                            </fieldset>    
							        
           </form>                
                         
                     </div> <!-- End .module-body -->

                </div>  <!-- End .module -->
        		<div style="clear:both;"></div>
            </div>

</div>