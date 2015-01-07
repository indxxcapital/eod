{include file="notice.tpl"}



<div class="row-fluid">
                    <div class="span22">
                        <div class="box box-magenta">
                            <div class="box-title">
                                <h3><i class="icon-reorder"></i>Upload Security for index {$sessData.NewIndxxName}</h3>
                                <div class="box-tool">
                                </div>
                            </div>
                            <form class="form-wizard" enctype="multipart/form-data" method="post"> 
                            <div class="box-content done"  id="p_scents">
                                
                               {foreach from=$fields key=p item=item}
           <div class="controls step controls-row">
                                
                                  {field data=$item value=$postData}{/field}
                                      
                 </div>                   
                 {/foreach}    
                            </div>
                            
                            <div class="box-content" >
                            <div class="form-actions">
                                   
                                          <button class="btn btn-primary" name='submit' value="submit" type="submit"><i class="icon-ok"></i> Save</button>
                                       <button class="btn" type="button">Cancel</button>
                                    </div>
                            </div>
                          <!--  <h2><a href="#" id="addScnt">Add Another Input Box</a></h2>-->
                    
                        </form>
                        </div>
                    </div>
                </div>
                
                
                