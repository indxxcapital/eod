<?php /* Smarty version 2.6.14, created on 2014-08-01 11:46:02
         compiled from C:/Inetpub/vhosts/indxx.secureserver.net/httpdocs/icai2/templates//formfields/text3.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'replace', 'C:/Inetpub/vhosts/indxx.secureserver.net/httpdocs/icai2/templates//formfields/text3.tpl', 46, false),)), $this); ?>
<div class="holder">
                           <div class="form-div-1 clearfix" style=" width:550px !important; padding-left:420px !important;">
                                   
                                    <label class="name" style="margin-top:10px !important;">
                                        
                                  <?php echo $this->_tpl_vars['formParams']['feild_label'];  if ($this->_tpl_vars['formParams']['is_required'] == '1'): ?> <sup style="color:#F00;">*</sup><?php endif; ?>:</label>
                                       
                            </div>
                            <div class="form-div-2 clearfix">
                                   <input type="text" data-constraints="@Required" name="<?php echo $this->_tpl_vars['formParams']['feild_code']; ?>
" id="<?php echo $this->_tpl_vars['formParams']['feild_code']; ?>
" value="<?php echo $this->_tpl_vars['formParams']['value']; ?>
" <?php echo $this->_tpl_vars['formParams']['feildValues']; ?>
 class="">
                                        <span class="empty-message"><?php echo $this->_tpl_vars['formParams']['errorMessage']; ?>
</span>
                            </div>
                            </div>
                            
<?php echo $this->_tpl_vars['BASEURL']; ?>


<?php if ($this->_tpl_vars['formParams']['autoSuggest']): ?>

<link href="<?php echo $this->_tpl_vars['ADMIN_BASE_URL']; ?>
assets/auto/css/autosuggest_inquisitor.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo $this->_tpl_vars['ADMIN_BASE_URL']; ?>
assets/auto/js/bsn.AutoSuggest_c_2.0.js"></script>
<?php echo '
<script language="javascript" type="text/javascript">


jQuery('; ?>
'#<?php echo $this->_tpl_vars['formParams']['feild_code']; ?>
'<?php echo ').attr("autocomplete","off") ;
jQuery('; ?>
'#<?php echo $this->_tpl_vars['formParams']['feild_code']; ?>
'<?php echo ').bind("keypress",function(){
'; ?>
																	   
 
lookup<?php echo $this->_tpl_vars['formParams']['feild_code']; ?>
(this.value)		
<?php echo '
});
function '; ?>
lookup<?php echo $this->_tpl_vars['formParams']['feild_code'];  echo '(inputString) {
 
	var options = {
		'; ?>

		script: BASEURL+"index.php?module=ajax&event=<?php echo $this->_tpl_vars['formParams']['autoSuggest']['function']; ?>
& ",
		<?php echo '
		varfeild_code:"input",
		json:true,
		callback: function (obj) { 
		
		'; ?>

					<?php $_from = $this->_tpl_vars['Form_Params']['callBack']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['callback']):
?>
						jQuery('#<?php echo $this->_tpl_vars['formParams']['autoSuggest']['id']; ?>
') .val(obj.id);
					 
						<?php echo ((is_array($_tmp=$this->_tpl_vars['callback'])) ? $this->_run_mod_handler('replace', true, $_tmp, 'this.value', 'obj.id') : smarty_modifier_replace($_tmp, 'this.value', 'obj.id')); ?>

					<?php endforeach; endif; unset($_from); ?>
		<?php echo '
		
		}
	};
	
	jQuery(\'[feild_code=reset]\').bind("click",function(){ });
	'; ?>
	
	 
	var as_json = new AutoSuggest('<?php echo $this->_tpl_vars['formParams']['feild_code']; ?>
', options);	
	
	
	<?php echo '
}


	 
 
	</script>

'; ?>


<?php endif; ?>
