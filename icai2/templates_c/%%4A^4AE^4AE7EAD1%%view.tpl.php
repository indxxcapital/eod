<?php /* Smarty version 2.6.14, created on 2014-12-19 07:38:46
         compiled from myca/view.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', 'myca/view.tpl', 118, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'notice.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?><!-- BEGIN Main Content -->
 <?php echo '
 <script type=\'text/javascript\'>
 
   function confirmdelete(id)
 {

 var temp=confirm("Are you sure you want to delete this record ")
  if(temp)
   {	
	
	window.location.href=\'index.php?module=viewfields&event=delete&id=\'+id;
	}
	else{
	return false;
	}
 }
 
 



$(document).ready(function(){
 $("#deleteSelected").click(function(){
	 
	 var temp=confirm("Are you sure you want to delete this record ")
  if(temp)
   {	
	 
	 
	 
 var checkedArray=Array();
 var i=0;
  $(\'input[name="checkboxid"]:checked\').each(function() {
i++;
checkedArray[i]=$(this).val();
});
var parameters = {
  "array1":checkedArray
};


$.ajax({
    url : "index.php?module=viewfields&event=deleteindex",
    type: "POST",
    data : parameters,
    success: function(data, textStatus, jqXHR)
    {
        //data - response from server
    },
    error: function (jqXHR, textStatus, errorThrown)
    {
 
    }
});

}
	else{
	return false;
	}


});
	 
	 
	
	 
 
}); 
 
</script>
 
 '; ?>

               
<div class="row-fluid">
                    <div class="span12">
                        <div class="box">
                            <div class="box-title">
                                
                            </div>
                            
                           
                            
                            
                            
                            
                            
                            <div class="box-content">
                            
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
                                    
                                    <?php $_from = $this->_tpl_vars['viewdata']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['point']):
?>
        <tr>
             <td></td>
            <td><?php echo $this->_tpl_vars['point']['identifier']; ?>
</td>
<!--            <td><a data-original-title="<?php echo $this->_tpl_vars['point']['mnemonic']; ?>
" data-content="<?php echo $this->_tpl_vars['sessData']['variable'][$this->_tpl_vars['point']['mnemonic']]; ?>
" data-placement="top" data-trigger="hover" class="show-popover" href="#"><?php echo $this->_tpl_vars['point']['mnemonic']; ?>
</a></td>-->
            <td><?php echo $this->_tpl_vars['sessData']['variable'][$this->_tpl_vars['point']['mnemonic']]; ?>
</td>
            <td><?php echo $this->_tpl_vars['point']['company_name']; ?>
</td>
           
        </tr>
        <?php endforeach; endif; unset($_from); ?>
                                    
                                    
                                      
                                    </tbody>
                                </table>
                            <?php if (count($this->_tpl_vars['indxxd']) > 0): ?>  <div class="box">  <div class="box-title">
                                Live Index
                            </div></div>
                            
                            <table class="table table-striped table-hover fill-head">
                                    <thead>
                                        <tr>
                                            <th>Indxx</th>
                                            <th>Name</th>
                                            <th>Code</th>
                                           
                                          
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                    <?php $_from = $this->_tpl_vars['indxxd']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['point']):
?>
        <tr>
             <td><?php echo $this->_tpl_vars['k']+1; ?>
</td>
            <td><?php echo $this->_tpl_vars['point']['name']; ?>
</td>
            <td><?php echo $this->_tpl_vars['point']['code']; ?>
</td>
           
        </tr>
        <?php endforeach; endif; unset($_from); ?>
                                    
                                    
                                      
                                    </tbody>
                                </table>
                                <?php endif; ?>
                                
                            <?php if (count($this->_tpl_vars['indxxt']) > 0): ?>      <div class="box">  <div class="box-title">
                                Upcoming Index
                            </div></div>
                            
                            <table class="table table-striped table-hover fill-head">
                                    <thead>
                                        <tr>
                                            <th>Indxx</th>
                                            <th>Name</th>
                                            <th>Code</th>
                                           
                                          
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                    <?php $_from = $this->_tpl_vars['indxxt']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['point']):
?>
        <tr>
             <td><?php echo $this->_tpl_vars['k']+1; ?>
</td>
            <td><?php echo $this->_tpl_vars['point']['name']; ?>
</td>
            <td><?php echo $this->_tpl_vars['point']['code']; ?>
</td>
           
        </tr>
        <?php endforeach; endif; unset($_from); ?>
                                    
                                    
                                      
                                    </tbody>
                                </table>
                                <?php endif; ?>
                                <div class="btn-toolbar pull-right clearfix">
                                    <div class="btn-group">
                                  
                                      
                                    </div>
                                
                                </div>
                                <div class="clearfix"></div>
<table class="table table-advance" id="table1">
    <thead>
        <tr>
             <th style="width:18px"></th>
          
             <th>Field Name</th>
             <th>Field Name Meaning</th>
              <th>Field Value</th>
            <!--<th>Effective Date</th>
            <th>Announce Date</th>-->
         
        </tr>
    </thead>
    <tbody>
    	<?php $_from = $this->_tpl_vars['viewdata2']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['point']):
?>
        <tr>
             <td></td>
          
<!--            <td><a data-original-title="<?php echo $this->_tpl_vars['point']['field_name']; ?>
" data-content="<?php echo $this->_tpl_vars['sessData']['variable'][$this->_tpl_vars['point']['field_name']]; ?>
" data-placement="top" data-trigger="hover" class="show-popover" href="#"><?php echo $this->_tpl_vars['point']['field_name']; ?>
</a></td>-->
            <td><?php echo $this->_tpl_vars['point']['field_name']; ?>
</td>
                        <td><?php echo $this->_tpl_vars['sessData']['variable'][$this->_tpl_vars['point']['field_name']]; ?>
</td>
            
            <td><?php echo $this->_tpl_vars['point']['field_value']; ?>
</td>
            <!--<td><?php echo $this->_tpl_vars['point']['eff_date']; ?>
</td>
            <td><?php echo $this->_tpl_vars['point']['ann_date']; ?>
</td>-->
           
        </tr>
        <?php endforeach; endif; unset($_from); ?>
      
    </tbody>
</table>

<?php if (count($this->_tpl_vars['viewdata3']) > 0): ?>
            <div class="clearfix">Old Values </div>
<table class="table table-advance" id="table1">
    <thead>
        <tr>
             <th style="width:18px"></th>
          
             <th>Field Name</th>
             <th>Field Name Meaning</th>
              <th>Field Value</th>
            <!--<th>Effective Date</th>
            <th>Announce Date</th>-->
         
        </tr>
    </thead>
    <tbody>
    	<?php $_from = $this->_tpl_vars['viewdata3']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['point']):
?>
    	<?php $_from = $this->_tpl_vars['diffkey']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k2'] => $this->_tpl_vars['dif']):
?>



<?php if ($this->_tpl_vars['k2'] == $this->_tpl_vars['k']): ?>

        <tr>
             <td></td>
          
<!--            <td><a data-original-title="<?php echo $this->_tpl_vars['point']['field_name']; ?>
" data-content="<?php echo $this->_tpl_vars['sessData']['variable'][$this->_tpl_vars['point']['field_name']]; ?>
" data-placement="top" data-trigger="hover" class="show-popover" href="#"><?php echo $this->_tpl_vars['point']['field_name']; ?>
</a></td>-->
            <td><?php echo $this->_tpl_vars['point']['field_name']; ?>
</td>
                        <td><?php echo $this->_tpl_vars['sessData']['variable'][$this->_tpl_vars['point']['field_name']]; ?>
</td>
            
            <td><?php echo $this->_tpl_vars['point']['field_value']; ?>
</td>
            <!--<td><?php echo $this->_tpl_vars['point']['eff_date']; ?>
</td>
            <td><?php echo $this->_tpl_vars['point']['ann_date']; ?>
</td>-->
           
        </tr>
        <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?>
        <?php endforeach; endif; unset($_from); ?>
      
    </tbody>
</table>
<?php endif; ?>
                 <table class="table table-advance">   <tr><td>
                     <a href="index.php?module=myca"><button class="btn btn-inverse">Back</button></a>
                     
                 
                 
               <?php if (count($this->_tpl_vars['indxxd']) > 0 && $this->_tpl_vars['approveLive']): ?>
                  <a href="index.php?module=myca&event=approve&id=<?php echo $_GET['id']; ?>
">  <button class="btn btn-info">Approve For Live</button></a>
                 <?php endif; ?>
              
                 <?php if ($this->_tpl_vars['viewdata']['0']['mnemonic'] == 'SPIN'): ?>
           
           <a href="index.php?module=myca&event=addStockforSpin&id=<?php echo $_GET['id']; ?>
">  <button class="btn btn-info">Stock Addition </button></a>
                 <?php endif; ?>
                 
                
                 
                     <?php if (count($this->_tpl_vars['indxxt']) > 0 && $this->_tpl_vars['approveTemp']): ?>
                  <a href="index.php?module=myca&event=approvetemp&id=<?php echo $_GET['id']; ?>
">  <button class="btn btn-info">Approve For Upcomming</button></a>
                 <?php endif; ?> 
                 
                 
                 
                  <!-- <a href="index.php?module=myca&event=notifyclient&id=<?php echo $_GET['id']; ?>
"><button class="btn btn-success">Notify to Client</button></a>-->
                      
                   <?php if ($this->_tpl_vars['sessData']['User']['type'] == '1'): ?>    <a href="index.php?module=myca&event=ignoreindex&id=<?php echo $_GET['id']; ?>
"><button class="btn btn-warning">Ignore Index</button></a>
                      
                     <?php if (count($this->_tpl_vars['indxxd']) > 0): ?>   <a href="index.php?module=myca&event=edit&id=<?php echo $_GET['id']; ?>
"><button class="btn btn-info">Edit/Insert Value For Live Index</button></a>
<?php endif; ?>                     <?php if (count($this->_tpl_vars['indxxt']) > 0): ?>    <a href="index.php?module=myca&event=editfortemp&id=<?php echo $_GET['id']; ?>
"><button class="btn btn-info">Edit/Insert Value for Upcoming Index</button></a> 
                     <?php endif; ?>
                        <?php if ($this->_tpl_vars['viewdata']['0']['mnemonic'] == 'SPIN' || $this->_tpl_vars['viewdata']['0']['mnemonic'] == 'ACQUIS' || $this->_tpl_vars['viewdata']['0']['mnemonic'] == 'DELIST'): ?>
           
           <a href="index.php?module=myca&event=adddividendplaceholder&id=<?php echo $_GET['id']; ?>
">  <button class="btn btn-info">Dividend Placeholder Request </button></a>
                 <?php endif; ?>
                     
                     <?php endif; ?>
                 
                 </td></tr>
                    </table>

                 
                             </div>
                             
                             
                             
                             
                             
                             
                        </div>
                    </div>
                </div>
                
                  <!-- END Main Content -->