<div class="row-fluid">
                    <div class="span22">
                        <div class="box box-magenta">
                            <div class="box-title">
                                <h3><i class="icon-reorder"></i>{$smarty.get.id} Securities added for index {$sessData.NewIndxxName} </h3>
                                <div class="box-tool">
                                    <a href="#" data-action="collapse"><i class="icon-chevron-up"></i></a>
                                    <a href="#" data-action="close"><i class="icon-remove"></i></a>
                                </div>
                            </div>
                           
                            <div class="box-content" >
                            <div class="form-actions">
                                      {if $indexdata.status=='1'}  <button class="btn btn-primary"  id="addScnt" type="submit" onclick="document.location.href='{$BASE_URL}index.php?module=casecurities&event=addNew2';"><i class="icon-plus"></i> Add More Securities</button>
                                       {/if}  <button class="btn btn-primary"  id="addScnt" type="submit" onclick="document.location.href='{$BASE_URL}index.php?module=caindex&event=viewupcoming&id={$sessData.tempindexid}';"><i class="icon-plus"></i>View</button>
  {if $indexdata.status=='0'}                                         <button class="btn btn-primary" name='submit' value="submit" type="submit" onclick="document.location.href='{$BASE_URL}index.php?module=caindex&event=subindextemp&id={$sessData.tempindexid}';"><i class="icon-ok"></i> Submit Index</button>{/if}
                                       
                                    </div>
                            </div>
                          <!--  <h2><a href="#" id="addScnt">Add Another Input Box</a></h2>-->
                       
                        </div>
                    </div>
                </div>