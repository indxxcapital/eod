<?php /* Smarty version 2.6.14, created on 2014-12-17 19:47:01
         compiled from caupcomingindex/addedrunning.tpl */ ?>
<div class="row-fluid">
                    <div class="span22">
                        <div class="box box-magenta">
                            <div class="box-title">
                                <h3><i class="icon-reorder"></i><?php echo $_GET['id']; ?>
 Securities added for index <?php echo $this->_tpl_vars['sessData']['NewIndxxName']; ?>
 </h3>
                                <div class="box-tool">
                                    <a href="#" data-action="collapse"><i class="icon-chevron-up"></i></a>
                                    <a href="#" data-action="close"><i class="icon-remove"></i></a>
                                </div>
                            </div>
                           
                            <div class="box-content" >
                            <div class="form-actions">
                                      <?php if ($this->_tpl_vars['indexdata']['status'] == '1'): ?>  <button class="btn btn-primary"  id="addScnt" type="submit" onclick="document.location.href='<?php echo $this->_tpl_vars['BASE_URL']; ?>
index.php?module=casecurities&event=addNew2';"><i class="icon-plus"></i> Add More Securities</button>
                                       <?php endif; ?>  <button class="btn btn-primary"  id="addScnt" type="submit" onclick="document.location.href='<?php echo $this->_tpl_vars['BASE_URL']; ?>
index.php?module=caindex&event=viewupcoming&id=<?php echo $this->_tpl_vars['sessData']['tempindexid']; ?>
';"><i class="icon-plus"></i>View</button>
  <?php if ($this->_tpl_vars['indexdata']['status'] == '0'): ?>                                         <button class="btn btn-primary" name='submit' value="submit" type="submit" onclick="document.location.href='<?php echo $this->_tpl_vars['BASE_URL']; ?>
index.php?module=caindex&event=subindextemp&id=<?php echo $this->_tpl_vars['sessData']['tempindexid']; ?>
';"><i class="icon-ok"></i> Submit Index</button><?php endif; ?>
                                       
                                    </div>
                            </div>
                          <!--  <h2><a href="#" id="addScnt">Add Another Input Box</a></h2>-->
                       
                        </div>
                    </div>
                </div>