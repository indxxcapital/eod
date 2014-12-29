<?php /* Smarty version 2.6.14, created on 2014-08-25 16:16:16
         compiled from cashindex_temp/view.tpl */ ?>

<div class="row-fluid">
                    <div class="span12">
                        <div class="box">
                            <div class="box-title">
                                <h3><i class="icon-table"></i>Cash Index</h3>
                            </div>
                            <div class="box-content">
                                
                                    
                                <div class="clearfix"></div>
<table class="table table-advance" id="table1">
    <thead>
        
    </thead>
    <tbody>
    
        <tr>
     
            <td>Name</td>
            <td><?php echo $this->_tpl_vars['data']['name']; ?>
</td>
          </tr><tr>   <td>Code</td>
            <td><?php echo $this->_tpl_vars['data']['code']; ?>
</td>
           </tr><tr>
            <td>ISIN</td>
            <td><?php echo $this->_tpl_vars['data']['isin']; ?>
</td>
           </tr><tr>
            <td>Ticker</td>
            <td><?php echo $this->_tpl_vars['data']['ticker']; ?>
</td> </tr><tr><td>
         <?php if ($this->_tpl_vars['sessData']['User']['type'] == 3): ?>    <button type="button" class="btn" name="cancel" id="cancel" onClick="document.location.href='<?php echo $this->_tpl_vars['BASE_URL']; ?>
index.php?module=cashindextemp&event=approve&id=<?php echo $this->_tpl_vars['data']['id']; ?>
';" >Approve</button>
        <?php endif; ?>  
        </td><td>  <button type="button" class="btn" name="cancel" id="cancel" onClick="document.location.href='<?php echo $this->_tpl_vars['BASE_URL']; ?>
index.php?module=cashindextemp';" >Back</button>
        </td></tr>
     
    </tbody>
</table>
                            </div>
                        </div>
                    </div>
                </div>
                
                  <!-- END Main Content -->