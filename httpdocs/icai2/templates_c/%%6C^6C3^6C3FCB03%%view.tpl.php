<?php /* Smarty version 2.6.14, created on 2014-09-11 12:04:34
         compiled from spinstockadd/view.tpl */ ?>
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
                                Spin off Stock  Addition Request
                            </div>
                            
                           
                            
                            
                            
                            
                            
                            <div class="box-content">
                            
                            <table class="table table-striped table-hover fill-head">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Identifier</th>
                                            <th>Company Name</th>
                                            <th>Effective Date</th>
                                           
                                          
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                        <tr>
             <td></td>
            <td><?php echo $this->_tpl_vars['ca_data']['identifier']; ?>
</td>
<!--            <td><a data-original-title="<?php echo $this->_tpl_vars['point']['mnemonic']; ?>
" data-content="<?php echo $this->_tpl_vars['sessData']['variable'][$this->_tpl_vars['point']['mnemonic']]; ?>
" data-placement="top" data-trigger="hover" class="show-popover" href="#"><?php echo $this->_tpl_vars['point']['mnemonic']; ?>
</a></td>-->
                 <td><?php echo $this->_tpl_vars['ca_data']['company_name']; ?>
</td>
                  <td><?php echo $this->_tpl_vars['ca_data']['eff_date']; ?>
</td>
        </tr>
                                        
                                    
                                      
                                    </tbody>
                                </table>
                         
                                
                    
                                <div class="btn-toolbar pull-right clearfix">
                                    <div class="btn-group">
                                  
                                      
                                    </div>
                                
                                </div>
                                <div class="clearfix"></div>
<table class="table table-advance" id="table1">
    <thead>
        <tr>
             <th style="width:18px"></th>
          
             <th>Indxx Name</th>
             <th>Company Name</th>
              <th>Ticker</th>
                <th>ISIN</th>
                         <th>Currency</th>
                           <th>Div. Currency</th>
            <!--<th>Effective Date</th>
            <th>Announce Date</th>-->
         
        </tr>
    </thead>
    <tbody>
    	<?php $_from = $this->_tpl_vars['ca_values']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['point']):
?>
        <tr>
             <td></td>
          
<!--            <td><a data-original-title="<?php echo $this->_tpl_vars['point']['field_name']; ?>
" data-content="<?php echo $this->_tpl_vars['sessData']['variable'][$this->_tpl_vars['point']['field_name']]; ?>
" data-placement="top" data-trigger="hover" class="show-popover" href="#"><?php echo $this->_tpl_vars['point']['field_name']; ?>
</a></td>-->
            <td><?php echo $this->_tpl_vars['point']['indxx_name']; ?>
 (<?php echo $this->_tpl_vars['point']['indxx_code']; ?>
)</td>
                        <td><?php echo $this->_tpl_vars['point']['name']; ?>
</td>
            
            <td><?php echo $this->_tpl_vars['point']['ticker']; ?>
</td>            <td><?php echo $this->_tpl_vars['point']['isin']; ?>
</td>            <td><?php echo $this->_tpl_vars['point']['curr']; ?>
</td>            <td><?php echo $this->_tpl_vars['point']['divcurr']; ?>
</td>
            <!--<td><?php echo $this->_tpl_vars['point']['eff_date']; ?>
</td>
            <td><?php echo $this->_tpl_vars['point']['ann_date']; ?>
</td>-->
           
        </tr>
        <?php endforeach; endif; unset($_from); ?>
      
    </tbody>
</table>
     <table class="table table-advance">   <tr><td>
                     <a href="index.php?module=myca"><button class="btn btn-inverse">Back</button></a>
                     
                 
                 
               <?php if ($this->_tpl_vars['ca_data']['dbApprove'] == 0 && $this->_tpl_vars['sessData']['User']['type'] == 3): ?>
                  <a href="index.php?module=spinstockadd&event=approve&id=<?php echo $_GET['id']; ?>
">  <button class="btn btn-info">Approve</button></a>
                 <?php endif; ?>
                 </td></tr>
                    </table>

                 
                             </div>
                             
                             
                             
                             
                             
                             
                        </div>
                    </div>
                </div>
                
                  <!-- END Main Content -->