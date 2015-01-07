
{include file="notice.tpl"}
<div class="row-fluid">
                    <div class="span12">
                        <div class="box">
                            <div class="box-title">
                                <h3><i class="icon-reorder"></i>Edit Corporate Action Value</h3>
                                                </div>
                            <div class="box-content">
                                 <form action="" method="post" onsubmit="return ValidateForm();" class="form-horizontal" enctype="multipart/form-data">
                                 
                                 
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
                            
                            <table class="table table-striped table-hover fill-head">
                                    <thead>
                                        <tr>
                                            <th>Indxx</th>
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
                                 
                                
                                 {foreach from=$fields key=p item=item}
               <p>   {field data=$item value=$postData}{/field}
                </p>  {/foreach}
                                   
                                    <div class="form-actions">
                                    <button type="submit" class="btn btn-primary" name="submit" id="submit"><i class="icon-ok"></i> Save</button>
                                       <button type="button" class="btn" name="cancel" id="cancel"  onclick="document.location.href='{$BASE_URL}index.php?module=myca&event=view&id={$smarty.get.id}';">Back</button>
                                    </div>
                                    
                                    
                               
                                 </form>
                            </div>
                        </div>
                    </div>
                </div>