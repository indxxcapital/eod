<?php /* Smarty version 2.6.14, created on 2012-08-13 12:16:01
         compiled from login.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'formfield', 'login.tpl', 14, false),)), $this); ?>
<div class="prefix_3 grid_6 suffix_3">
    <div class="module">
      <h2><span>Log in</span></h2>
      <div class="module-body">
        <form method="post" action="index.php" class="login" onsubmit="return ValidateForm();">
			<input type="hidden" name="module" value="home" />
			<input type="hidden" name="event" value="login" />
          <fieldset>
          <?php $_from = $this->_tpl_vars['fields']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['p'] => $this->_tpl_vars['item']):
?>
			 
				<p><label><strong><?php echo $this->_tpl_vars['item']['feild_label']; ?>
</strong> <?php if ($this->_tpl_vars['item']['is_required'] == 1): ?><span class="red">*</span><?php endif; ?></label>
			 
				
				<?php $this->_tag_stack[] = array('formfield', array('itemData' => $this->_tpl_vars['item'],'class' => "input-medium",'value' => $this->_tpl_vars['postData'])); $_block_repeat=true;smarty_block_formfield($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start();  $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_formfield($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
			 
 
				</p>
				 	
				
				<?php endforeach; endif; unset($_from); ?>
           
          <input class="submit-green" type="submit" name="submit" value="Submit"/>
          </fieldset>
        </form>
        <ul>
          <li><a href="index.php?module=home&event=forgetAdminPassword">I forgot my password</a></li>
        </ul>
      </div>
    </div>
  </div>
  
  
<?php echo '
<script type="text/javascript"  language="javascript">
jQuery(document).ready(function (){
	jQuery(\'input[type=text]:enabled:first\').focus();
});
</script>
'; ?>