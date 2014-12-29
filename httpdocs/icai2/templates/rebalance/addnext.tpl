<div class="row-fluid">
                    <div class="span22">
                        <div class="box box-magenta">
                            <div class="box-title">
                                <h3><i class="icon-reorder"></i>{$smarty.get.id} Securities added for Rebalance </h3>
                                <div class="box-tool">
                                    <a href="#" data-action="collapse"><i class="icon-chevron-up"></i></a>
                                    <a href="#" data-action="close"><i class="icon-remove"></i></a>
                                </div>
                            </div>
                           
                            <div class="box-content" >
                            <div class="form-actions">
                                        <button class="btn btn-primary"  id="addScnt" type="submit" onclick="document.location.href='{$BASE_URL}index.php?module=rebalance&event=addSecurities';"><i class="icon-plus"></i> Add More Securities</button>
                                         <button class="btn btn-primary"  id="addScnt" type="submit" onclick="document.location.href='{$BASE_URL}index.php?module=caindex&event=viewupcoming&id={$sessData.rebalance.newindxx}';"><i class="icon-plus"></i>View</button>
                                          <button class="btn btn-primary" name='submit' value="submit" type="submit" onclick="document.location.href='{$BASE_URL}index.php?module=caindex&event=subindextemp&id={$sessData.rebalance.newindxx}';"><i class="icon-ok"></i> Submit Index for Approval</button>
                                       
                                    </div>
                            </div>
                          <!--  <h2><a href="#" id="addScnt">Add Another Input Box</a></h2>-->
                       
                        </div>
                    </div>
                </div>