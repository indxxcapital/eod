<?php /* Smarty version 2.6.14, created on 2013-05-22 11:39:01
         compiled from grid/editrecords.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'formfield', 'grid/editrecords.tpl', 35, false),array('modifier', 'updateid', 'grid/editrecords.tpl', 66, false),array('modifier', 'replace', 'grid/editrecords.tpl', 78, false),)), $this); ?>
<div class="container_12"><div class="grid_12">
 
                <div class="module">
                     <h2><span><?php echo $this->_tpl_vars['title']; ?>
</span></h2>
                                
                     <div class="module-body">
                     <?php if ($this->_tpl_vars['error'] != ""): ?>
 <div>
<span class="notification n-<?php echo '<?='; ?>
$error<?php echo '?>'; ?>
"><?php echo '<?='; ?>
$msg<?php echo '?>'; ?>
</span>
</div>
<?php endif; ?>
                        <form name="reserve" id="reserve" action="index.php?module=<?php echo $this->_tpl_vars['currentClass']; ?>
&event=edit&id=<?php echo $this->_tpl_vars['postData']['id'];  echo $this->_tpl_vars['backVars']; ?>
" method="post" onsubmit="return ValidateForm();" enctype="multipart/form-data" >
				
				<input type="hidden" id="id" name="id" value="<?php echo $this->_tpl_vars['postData']['id']; ?>
" />
					<input type="hidden" id="pid" name="pid" value="<?php echo $_GET['pid']; ?>
" />
				
				<div class="grid_6" style="width:445px;">
				
				 
				<?php $_from = $this->_tpl_vars['fields']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['p'] => $this->_tpl_vars['item']):
?>
				<?php if ($this->_tpl_vars['p'] == $this->_tpl_vars['fieldsCount']): ?>
				</div><div class="grid_6" style="width:445px;">
				<?php endif; ?>
				<?php if ($this->_tpl_vars['item']['feild_type'] != 'hidden'): ?>
				
				<p  id="block_<?php echo $this->_tpl_vars['item']['feild_code']; ?>
"><label><strong><?php echo $this->_tpl_vars['item']['feild_label']; ?>
</strong> <?php if ($this->_tpl_vars['item']['is_required'] == 1): ?><span class="red">*</span><?php endif; ?></label>
				<?php endif; ?>
				
				
				 
				<?php $this->_tag_stack[] = array('formfield', array('type' => $this->_tpl_vars['item']['feild_type'],'itemData' => $this->_tpl_vars['item'],'name' => $this->_tpl_vars['item']['feild_code'],'model' => $this->_tpl_vars['item']['model'],'feild_note' => $this->_tpl_vars['item']['feild_note'],'onChange' => $this->_tpl_vars['item']['onChange'],'value' => $this->_tpl_vars['postData'],'staticValue' => $this->_tpl_vars['item']['value'],'class' => "input-long")); $_block_repeat=true;smarty_block_formfield($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start();  $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_formfield($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
				
				
				
				
				
				<?php if ($this->_tpl_vars['item']['feild_type'] != 'hidden'): ?>
				</p>
				<?php endif; ?>
				
				<?php endforeach; endif; unset($_from); ?>
				</div> 
				<div style="clear:both"></div>
                 <fieldset>
                                <input class="submit-green" type="submit" name="submit" value="Submit" /> 
                                <input class="submit-gray" type="button" onclick="window.location='index.php?module=<?php echo $this->_tpl_vars['currentClass'];  echo $this->_tpl_vars['backVars'];  if ($_GET['pid']): ?>&pid=<?php echo $_GET['pid'];  endif; ?>'" value="Cancel" />
                            </fieldset>            
                           
                        </form>
                     </div> <!-- End .module-body -->

                </div>  <!-- End .module -->
        		<div style="clear:both;"></div>
            </div>

</div>

<script language="javascript">

<?php $_from = $this->_tpl_vars['fields']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['p'] => $this->_tpl_vars['item']):
 if ($this->_tpl_vars['item']['feildOptions']['onChange']):  ob_start();  echo ((is_array($_tmp=$this->_tpl_vars['item']['feildOptions']['onChange'])) ? $this->_run_mod_handler('updateid', true, $_tmp) : smarty_modifier_updateid($_tmp));  $this->_smarty_vars['capture']['ajaxCurrentValue'] = ob_get_contents(); ob_end_clean(); ?>
	<?php if ($this->_smarty_vars['capture']['ajaxCurrentValue']): ?>
		var <?php echo $this->_tpl_vars['item']['feild_code']; ?>
 = '<?php echo $this->_tpl_vars['postData'][$this->_tpl_vars['item']['feild_code']]; ?>
';
		
		
		if(<?php echo $this->_tpl_vars['item']['feild_code']; ?>
!="")
		<?php echo '
		{
		'; ?>
	
		
		
		<?php ob_start();  echo $this->_tpl_vars['item']['feild_code']; ?>
 , '<?php echo $this->_tpl_vars['postData'][$this->_smarty_vars['capture']['ajaxCurrentValue']]; ?>
'<?php $this->_smarty_vars['capture']['ajaxChange'] = ob_get_contents(); ob_end_clean(); ?>
		<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['feildOptions']['onChange'])) ? $this->_run_mod_handler('replace', true, $_tmp, 'this.value', $this->_smarty_vars['capture']['ajaxChange']) : smarty_modifier_replace($_tmp, 'this.value', $this->_smarty_vars['capture']['ajaxChange'])); ?>

		<?php echo '
		}
		'; ?>

	
	<?php endif;  endif;  endforeach; endif; unset($_from); ?>
</script>