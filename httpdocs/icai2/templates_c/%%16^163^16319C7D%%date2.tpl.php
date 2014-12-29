<?php /* Smarty version 2.6.14, created on 2014-08-01 11:46:21
         compiled from C:/Inetpub/vhosts/indxx.secureserver.net/httpdocs/icai2/templates//formfields/date2.tpl */ ?>
<script type="text/javascript" src="http://97.74.65.118/icai/assets/assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <link rel="stylesheet" type="text/css" href="http://97.74.65.118/icai/assets/assets/bootstrap-datepicker/css/datepicker.css" />
    <div class="holder">
                           <div class="form-div-1 clearfix" style=" width:550px !important; padding-left:420px !important;">
                                   
  <label class="name" style="margin-top:10px !important;"><?php echo $this->_tpl_vars['formParams']['feild_label'];  if ($this->_tpl_vars['formParams']['is_required'] == '1'): ?> <sup style="color:#F00;">*</sup><?php endif; ?>:</label>
 </div>
                            <div class="form-div-2 clearfix"><input type="text" placeholder="YYYY-MM-DD"  name="<?php echo $this->_tpl_vars['formParams']['feild_code']; ?>
" id="<?php echo $this->_tpl_vars['formParams']['feild_code']; ?>
" value="<?php echo $this->_tpl_vars['formParams']['value']; ?>
" class="date-pick<?php echo $this->_tpl_vars['formParams']['name'];  if ($this->_tpl_vars['formParams']['class'] != ""): ?> <?php echo $this->_tpl_vars['formParams']['class'];  endif; ?> date-picker"/>
<span id="error_<?php echo $this->_tpl_vars['formParams']['feild_code']; ?>
" <?php echo $this->_tpl_vars['formParams']['errorClass']; ?>
><?php echo $this->_tpl_vars['formParams']['errorMessage']; ?>
</span>
</div>
</div>
