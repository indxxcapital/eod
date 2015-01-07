{include file="notice.tpl"}



<div class="row-fluid">
                    <div class="span22">
                        <div class="box box-magenta">
                            <div class="box-title">
                                <h3><i class="icon-reorder"></i>Select Tickers for Commodity Index </h3>
                                <div class="box-tool">
                                
                                  <!--  <a href="#" data-action="collapse"><i class="icon-chevron-up"></i></a>
                                    <a href="#" data-action="close"><i class="icon-remove"></i></a>-->
                                </div>
                            </div>
                            <form class="form-wizard" method="post"> 
                            <div class="box-content done"  id="p_scents">
                                
                               {foreach from=$fields key=p item=item}
             {if $p%2==0}  <div class="controls step controls-row">
                                    <span class="formnumber">{$p/2+1}</span>
            {/if}                         {field data=$item value=$postData}{/field}
                                      
                {if $p%2==1}  </div>{/if}                    
                 {/foreach}    
                            </div>
                            
                            <div class="box-content" >
                            <div class="form-actions">
                            <button class="btn btn-primary" name='submit' value="submit" type="submit"><i class="icon-ok"></i> Save</button>
                                <a href="index.php?module=commodityindxx"><button class="btn" type="button">Cancel</button></a>
                                    </div>
                            </div>
                          <!--  <h2><a href="#" id="addScnt">Add Another Input Box</a></h2>-->
                        <input type="hidden" id="totalfields" name="totalfields" value="{$totalfields}" />
                        </form>
                        </div>
                    </div>
                </div>
