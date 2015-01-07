{include file="notice.tpl"}


<div class="row-fluid">
                    <div class="span22">
                        <div class="box box-magenta">
                            <div class="box-title">
                                <h3><i class="icon-reorder"></i>Add New Security for index {$sessData.NewIndxxName}</h3>
                                <div class="box-tool">
                                    <a href="#" data-action="collapse"><i class="icon-chevron-up"></i></a>
                                    <a href="#" data-action="close"><i class="icon-remove"></i></a>
                                </div>
                            </div>
                            <form class="form-wizard" method="post"> 
                            <div class="box-content done"  id="p_scents">
                                
                               {foreach from=$fields key=p item=item}
             {if $p%6==0}  <div class="controls step controls-row">
                                    <span class="formnumber">{$p/6+1}</span>
            {/if}                         {field data=$item value=$postData}{/field}
                                      
                {if $p%6==5}  </div>{/if}                    
                 {/foreach}    
                            </div>
                            
                            <div class="box-content" >
                            <div class="form-actions">
                                        <button class="btn btn-primary"  id="addScnt" type="submit"><i class="icon-plus"></i> Add More</button>
                                          <button class="btn btn-primary" name='submit' value="submit" type="submit"><i class="icon-ok"></i> Save</button>
                                       <button class="btn" type="button">Cancel</button>
                                    </div>
                            </div>
                          <!--  <h2><a href="#" id="addScnt">Add Another Input Box</a></h2>-->
                        <input type="hidden" id="totalfields" name="totalfields" value="{$totalfields}" />
                        </form>
                        </div>
                    </div>
                </div>
                
                
                
                
{literal}
<script type="text/javascript">

$(function() {
        var scntDiv = $('#p_scents');
        var i = $('#p_scents div').size() + 1;
        $('#addScnt').click( function() {
             $('<div class="controls step  controls-row"> <span class="formnumber">'+i+'</span><input type="text" placeholder="Security Name" class="span3" name="name['+i+']"><input type="text" name="isin['+i+']" placeholder="ISIN" class="span2"><input  name="ticker['+i+']" type="text" placeholder="Ticker" class="span2"><input name="curr['+i+']" type="text" placeholder="Currency" class="span2"><input type="text" placeholder="Div Curr"  name="divcurr['+i+']" class="span2">').appendTo(scntDiv);
                $('#totalfields').val(i);
				i++;
                return false;
        });

});
</script>
{/literal}                