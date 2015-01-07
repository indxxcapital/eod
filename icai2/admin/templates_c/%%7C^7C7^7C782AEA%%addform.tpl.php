<?php /* Smarty version 2.6.14, created on 2013-05-22 11:53:42
         compiled from grid/addform.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'formfield', 'grid/addform.tpl', 40, false),)), $this); ?>
<?php echo '

<script language="javascript" type="text/javascript">
$("form").submit(function() {
if ($(\'#loading_image\').length == 0) { //is the image on the form yet?
                // add it just before the submit button
$(\':submit\').before(\'<img src="';  echo $this->_tpl_vars['BASE_URL'];  echo 'assets/images/ajax-loader2.gif" style="display: none;" alt="loading" id="loading_image">\')
}
    $(\'#loading_image\').show(); // show the animated image
    $(\':submit\',this).attr(\'disabled\',\'disabled\'); // disable double submits
    return true; // allow regular form submission
});
</script>
'; ?>



 <?php if ($this->_tpl_vars['error'] != ""): ?>
 <div>
<span class="notification n-<?php echo '<?='; ?>
$error<?php echo '?>'; ?>
"><?php echo '<?='; ?>
$msg<?php echo '?>'; ?>
</span>
</div>
<?php endif; ?>
                        <form name="reserve" id="reserve" method="post" onsubmit="return ValidateForm();" enctype="multipart/form-data" >
				<div class="grid_6" style="width:445px;">
				
				 
				<?php $_from = $this->_tpl_vars['fields']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['p'] => $this->_tpl_vars['item']):
?>
				<?php if ($this->_tpl_vars['p'] == $this->_tpl_vars['fieldsCount']): ?>
				</div><div class="grid_6" style="width:445px;">
				<?php endif; ?>
				<?php if ($this->_tpl_vars['item']['feild_type'] != 'hidden'): ?>
				
				<p  <?php $_from = $this->_tpl_vars['item']['blockOption']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['block'] => $this->_tpl_vars['blockitem']):
?> <?php echo $this->_tpl_vars['block']; ?>
="<?php echo $this->_tpl_vars['blockitem']; ?>
"<?php endforeach; endif; unset($_from); ?> id="block_<?php echo $this->_tpl_vars['item']['feild_code']; ?>
"><label><strong><?php echo $this->_tpl_vars['item']['feild_label']; ?>
</strong> <?php if ($this->_tpl_vars['item']['is_required'] == 1): ?><span class="red">*</span><?php endif; ?></label>
				<?php endif; ?>
				
				
				<?php $this->_tag_stack[] = array('formfield', array('type' => $this->_tpl_vars['item']['feild_type'],'itemData' => $this->_tpl_vars['item'],'name' => $this->_tpl_vars['item']['feild_code'],'model' => $this->_tpl_vars['item']['model'],'feild_note' => $this->_tpl_vars['item']['feild_note'],'onChange' => $this->_tpl_vars['item']['onChange'],'value' => $this->_tpl_vars['postData'],'staticValue' => $this->_tpl_vars['item']['value'],'class' => "input-long")); $_block_repeat=true;smarty_block_formfield($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start();  $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_formfield($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
				
			<!--	<?php $this->_tag_stack[] = array('formfield', array('type' => $this->_tpl_vars['item']['feild_type'],'name' => $this->_tpl_vars['item']['feild_code'],'model' => $this->_tpl_vars['item']['model'],'feildOptions' => $this->_tpl_vars['item']['feildOptions'],'value' => $this->_tpl_vars['postData'],'staticValue' => $this->_tpl_vars['item']['value'],'class' => "input-long")); $_block_repeat=true;smarty_block_formfield($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start();  $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_formfield($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>-->

				<?php if ($this->_tpl_vars['item']['feild_type'] != 'hidden'): ?>
				</p>
				<?php endif; ?>
				
				<?php endforeach; endif; unset($_from); ?>
				</div> 
				<div style="clear:both"></div>
                 <fieldset>
                                <input class="submit-green" type="submit" name="submit" value="Submit" /> 
                                <input class="submit-gray" type="button" onclick="window.location='index.php?module=<?php echo $this->_tpl_vars['currentClass'];  if ($_GET['pid']): ?>&pid=<?php echo $_GET['pid'];  endif; ?>'" value="Cancel" />
                            </fieldset>            
                           
                        </form>