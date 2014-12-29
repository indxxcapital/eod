<?php /* Smarty version 2.6.14, created on 2013-05-22 11:38:42
         compiled from formfields/text.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'replace', 'formfields/text.tpl', 36, false),)), $this); ?>
<span id="feildHtml_<?php echo $this->_tpl_vars['Form_Params']['name']; ?>
"><input type="text" name="<?php echo $this->_tpl_vars['Form_Params']['name']; ?>
" id="<?php echo $this->_tpl_vars['Form_Params']['name']; ?>
" value="<?php echo $this->_tpl_vars['Form_Params']['value']; ?>
" class="<?php echo $this->_tpl_vars['Form_Params']['class']; ?>
" <?php echo $this->_tpl_vars['Form_Params']['feildValues']; ?>
/></span><?php if ($this->_tpl_vars['Form_Params']['feild_note']): ?><br />
<?php echo $this->_tpl_vars['Form_Params']['feild_note'];  endif; ?></span> 
<span id="error_<?php echo $this->_tpl_vars['Form_Params']['name']; ?>
" <?php echo $this->_tpl_vars['Form_Params']['errorClass']; ?>
><?php echo $this->_tpl_vars['Form_Params']['errorMessage']; ?>
</span>



<?php if ($this->_tpl_vars['Form_Params']['autoSuggest']): ?>

<link href="<?php echo $this->_tpl_vars['ADMIN_BASE_URL']; ?>
assets/auto/css/autosuggest_inquisitor.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo $this->_tpl_vars['ADMIN_BASE_URL']; ?>
assets/auto/js/bsn.AutoSuggest_c_2.0.js"></script>
<?php echo '
<script language="javascript" type="text/javascript">


jQuery('; ?>
'#<?php echo $this->_tpl_vars['Form_Params']['name']; ?>
'<?php echo ').attr("autocomplete","off") ;
jQuery('; ?>
'#<?php echo $this->_tpl_vars['Form_Params']['name']; ?>
'<?php echo ').bind("keypress",function(){
'; ?>
																	   
 
lookup<?php echo $this->_tpl_vars['Form_Params']['name']; ?>
(this.value)		
<?php echo '
});
function '; ?>
lookup<?php echo $this->_tpl_vars['Form_Params']['name'];  echo '(inputString) {
 
	var options = {
		'; ?>

		script: BASEURL+"index.php?module=ajax&event=<?php echo $this->_tpl_vars['Form_Params']['autoSuggest']['function']; ?>
& ",
		<?php echo '
		varname:"input",
		json:true,
		callback: function (obj) { 
		
		'; ?>

					<?php $_from = $this->_tpl_vars['Form_Params']['callBack']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['callback']):
?>
						jQuery('#<?php echo $this->_tpl_vars['Form_Params']['autoSuggest']['id']; ?>
') .val(obj.id);
					 
						<?php echo ((is_array($_tmp=$this->_tpl_vars['callback'])) ? $this->_run_mod_handler('replace', true, $_tmp, 'this.value', 'obj.id') : smarty_modifier_replace($_tmp, 'this.value', 'obj.id')); ?>

					<?php endforeach; endif; unset($_from); ?>
		<?php echo '
		
		}
	};
	
	jQuery(\'[name=reset]\').bind("click",function(){ });
	'; ?>
	
	 
	var as_json = new AutoSuggest('<?php echo $this->_tpl_vars['Form_Params']['name']; ?>
', options);	
	
	
	<?php echo '
}


	 
 
	</script>

'; ?>


<?php endif; ?>
