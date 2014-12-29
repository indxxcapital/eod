<div class="row-fluid">
                    <div class="span22">
                        <div class="box box-magenta">
                            <div class="box-title">
                                <h3><i class="icon-reorder"></i>{$smarty.get.total} Securities added for index {$indexxname} </h3>
                                <div class="box-tool">
                                    <a href="#" data-action="collapse"><i class="icon-chevron-up"></i></a>
                                    <a href="#" data-action="close"><i class="icon-remove"></i></a>
                                </div>
                            </div>
                           
                            <div class="box-content" >
                            <div class="form-actions">
                                        <button class="btn btn-primary"  id="addScnt" type="submit" onclick="document.location.href='{$BASE_URL}index.php?module=replacetempupcoming&event=addNew2&id={$smarty.get.id}&reqid={$smarty.get.reqid};"><i class="icon-plus"></i> Add More Securities</button>
                                         <!--<button class="btn btn-primary"  id="addScnt" type="submit" onclick="document.location.href='{$BASE_URL}index.php?module=caindex&event=viewupcoming&id={$sessData.tempindexid}';"><i class="icon-plus"></i>View</button>-->
                                          <button class="btn btn-primary" name='submit' value="submit" type="submit" onclick="document.location.href='{$BASE_URL}index.php?module=replacetempupcoming&event=subindextemp&id={$smarty.get.id}&reqid={$smarty.get.reqid}';"><i class="icon-ok"></i> Submit Index</button>
                                       
                                    </div>
                            </div>
                          <!--  <h2><a href="#" id="addScnt">Add Another Input Box</a></h2>-->
                       
                        </div>
                    </div>
                </div>