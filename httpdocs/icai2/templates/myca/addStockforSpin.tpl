
{include file="notice.tpl"}
<div class="row-fluid">
                    <div class="span12">
                        <div class="box">
                            <div class="box-title">
                                <h3><i class="icon-reorder"></i>Edit Corporate Action Value</h3>
                                                </div>
                            <div class="box-content">
                                 <form action="" method="post" onsubmit="return ValidateForm();" class="form-horizontal form-wizard" enctype="multipart/form-data">
                                 
                                  <div class="box-content done"  style="width:100%"  id="p_scents">
                                
                               {foreach from=$fields key=p item=item}
             {if $p%7==0}  <div class="step controls-row"   >
                                    <span class="formnumber" style="width:10px;" >{$p/7+1}</span>
            {/if}                         {field data=$item value=$postData}{/field}
                                      
                {if $p%7==6}  </div>{/if}                    
                 {/foreach}    
                            </div>
                                     <table class="table table-striped table-hover fill-head">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Identifier</th>
                                            <th>Type</th>
                                            <th>Company Name</th>
                                           
                                          
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                    {foreach from=$viewdata item=point key=k}
        <tr>
             <td></td>
            <td>{$point.identifier}</td>
<!--            <td><a data-original-title="{$point.mnemonic}" data-content="{$sessData.variable[$point.mnemonic]}" data-placement="top" data-trigger="hover" class="show-popover" href="#">{$point.mnemonic}</a></td>-->
            <td>{$sessData.variable[$point.mnemonic]}</td>
            <td>{$point.company_name}</td>
           
        </tr>
        {/foreach}
                                    
                                    
                                      
                                    </tbody>
                                </table>
                            {if $indxxd|@count>0}
                            <table class="table table-striped table-hover fill-head">
                                    <thead>
                                        <tr>
                                            <th width="20%">Live Indxx</th>
                                            <th>Name</th>
                                            <th>Code</th>
                                           
                                          
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                    {foreach from=$indxxd item=point key=k}
        <tr>
             <td><input type="checkbox" id="checkboxid"  name="checkboxid[]" value="{$point.indxx_id}_{$smarty.get.id}" /> </td>
            <td>{$point.name}</td>
            <td>{$point.code}</td>
           
        </tr>
        {/foreach}
                                    
                                    
                                      
                                    </tbody>
                                </table>
                                 {/if}
                                   {if $indxxu|@count>0}
                            <table class="table table-striped table-hover fill-head">
                                    <thead>
                                        <tr>
                                            <th  width="20%">Upcoming Indxx</th>
                                            <th>Name</th>
                                            <th>Code</th>
                                           
                                          
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                    {foreach from=$indxxu item=point key=k}
        <tr>
             <td><input type="checkbox" id="checkboxtempid"  name="checkboxtempid[]" value="{$point.indxx_id}_{$smarty.get.id}" /> </td>
            <td>{$point.name}</td>
            <td>{$point.code}</td>
           
        </tr>
        {/foreach}
                                    
                                    
                                      
                                    </tbody>
                                </table>
                                 {/if}
                              
                                   
                                    <div class="form-actions">
                                     <button class="btn btn-primary"  id="addScnt" type="submit"><i class="icon-plus"></i> Add More</button>
                                    <button type="submit" class="btn btn-primary" name="submit" id="submit"><i class="icon-ok"></i> Save</button>
                                       <button type="button" class="btn" name="cancel" id="cancel"  onclick="document.location.href='{$BASE_URL}index.php?module=myca&event=view&id={$smarty.get.id}';">Back</button>
                                    </div>
                                    
                                    
                               
                                 </form>
                            </div>
                        </div>
                    </div>
                </div>
                {literal}
<script type="text/javascript">

$(function() {
        var scntDiv = $('#p_scents');
        var i = $('#p_scents div').size() + 1;
        $('#addScnt').click( function() {
             $('<div class="step  controls-row" > <span class="formnumber" style="width:10px;">'+i+'</span><input type="text" placeholder="Security Name" class="span3" name="name['+i+']"><input type="text" name="isin['+i+']" placeholder="Security ISIN" class="span2"><input  name="ticker['+i+']" type="text" placeholder="Security Ticker" class="span2"><input type="hidden" placeholder="Share"  name="share['+i+']" class="span2"><input name="curr['+i+']" type="text" placeholder="Ticker Currency" class="span2"><input name="divcurr['+i+']" type="text" placeholder="Dividend Currency" class="span2">').appendTo(scntDiv);
                $('#totalfields').val(i);
				i++;
                return false;
        });

});
</script>
{/literal}   