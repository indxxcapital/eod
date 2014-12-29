<div class="container_12"><div class="grid_12">
 
                <div class="module">
                     <h2><span>{$title}</span></h2>
                                
                     <div class="module-body">
                    
                    {include file="grid/addform.tpl"}
                     </div> <!-- End .module-body -->

                </div>  <!-- End .module -->
        		<div style="clear:both;"></div>
            </div>

</div>

<script language="javascript">

{foreach from=$fields key=p item=item}
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
</script>
