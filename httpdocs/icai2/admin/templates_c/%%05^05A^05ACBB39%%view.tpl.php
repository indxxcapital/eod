<?php /* Smarty version 2.6.14, created on 2012-06-12 13:54:50
         compiled from grid/view.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'nl2br', 'grid/view.tpl', 51, false),)), $this); ?>
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
 
						
						 	<fieldset>
                                 
								  
                                <input class="submit-gray" type="button" onclick="window.location='index.php?module=<?php echo $this->_tpl_vars['currentClass']; ?>
&event=index&filter=<?php echo $this->_tpl_vars['filter']; ?>
&DisplayRecords=<?php echo $this->_tpl_vars['DisplayRecords']; ?>
&ShowThisPage=<?php echo $this->_tpl_vars['ShowThisPage']; ?>
&sortby=<?php echo $this->_tpl_vars['sortby']; ?>
&sortDirection=<?php echo $this->_tpl_vars['sortDirection']; ?>
&page=<?php echo $this->_tpl_vars['page']; ?>
&pagegroup=<?php echo $this->_tpl_vars['pagegroup']; ?>
'" value="Back" />
							 
								 
								<?php $_from = $this->_tpl_vars['gridButtons']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['p'] => $this->_tpl_vars['item']):
?>
								
								<input class="submit-green" type="button" onclick="window.location='<?php echo $this->_tpl_vars['item']['action']; ?>
&DisplayRecords=<?php echo $this->_tpl_vars['DisplayRecords']; ?>
&ShowThisPage=<?php echo $this->_tpl_vars['ShowThisPage']; ?>
&sortby=<?php echo $this->_tpl_vars['sortby']; ?>
&sortDirection=<?php echo $this->_tpl_vars['sortDirection']; ?>
&page=<?php echo $this->_tpl_vars['page']; ?>
&pagegroup=<?php echo $this->_tpl_vars['pagegroup']; ?>
'" value="<?php echo $this->_tpl_vars['item']['label']; ?>
" />
								<?php endforeach; endif; unset($_from); ?>
								
                            </fieldset>
						
				<div align="center">
				<?php echo $this->_tpl_vars['viewTopData']; ?>

				</div>
				<div class="grid_6" style="width:445px;">
				
				 
				<?php $_from = $this->_tpl_vars['fields']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['p'] => $this->_tpl_vars['item']):
?>
				<?php if ($this->_tpl_vars['p'] == $this->_tpl_vars['fieldsCount']): ?>
				</div><div class="grid_6" style="width:445px;">
				<?php endif; ?>
				<?php if ($this->_tpl_vars['item']['feild_type'] != 'hidden'): ?>
				
				<p><label><strong><?php echo $this->_tpl_vars['item']['feild_label']; ?>
</strong></label>
				<?php endif; ?>
				
				
				 <?php if ($this->_tpl_vars['viewData'][$this->_tpl_vars['item']['feild_code']] && $this->_tpl_vars['viewData'][$this->_tpl_vars['item']['feild_code']] != "00/00/0000"): ?>
                 		<?php if ($this->_tpl_vars['item']['feild_type'] == 'image'): ?>
                       	 <img src="<?php echo $this->_tpl_vars['SITE_URL']; ?>
media/<?php echo $this->_tpl_vars['item']['folder']; ?>
/thumb/<?php echo $this->_tpl_vars['viewData'][$this->_tpl_vars['item']['feild_code']]; ?>
" />
                        <?php else: ?>
					 	<?php echo $this->_tpl_vars['item']['feild_prefix'];  echo ((is_array($_tmp=$this->_tpl_vars['viewData'][$this->_tpl_vars['item']['feild_code']])) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp));  echo $this->_tpl_vars['item']['feild_sufix']; ?>

                        <?php endif; ?>
				 
               
                 
                 <?php else: ?>
				 n/a
				 <?php endif; ?>
				
				
				
				
				<?php if ($this->_tpl_vars['item']['feild_type'] != 'hidden'): ?>
				</p>
				<?php endif; ?>
				
				<?php endforeach; endif; unset($_from); ?>
				</div> 
				<div style="clear:both"></div>
				
				
				<div>
				<?php echo $this->_tpl_vars['viewBottomData']; ?>

				</div>
                 <fieldset>
                                 
								  
                                <input class="submit-gray" type="button" onclick="window.location='index.php?module=<?php echo $this->_tpl_vars['currentClass']; ?>
&event=index&filter=<?php echo $this->_tpl_vars['filter']; ?>
&DisplayRecords=<?php echo $this->_tpl_vars['DisplayRecords']; ?>
&ShowThisPage=<?php echo $this->_tpl_vars['ShowThisPage']; ?>
&sortby=<?php echo $this->_tpl_vars['sortby']; ?>
&sortDirection=<?php echo $this->_tpl_vars['sortDirection']; ?>
&page=<?php echo $this->_tpl_vars['page']; ?>
&pagegroup=<?php echo $this->_tpl_vars['pagegroup']; ?>
'" value="Back" />
								 
								<?php $_from = $this->_tpl_vars['gridButtons']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['p'] => $this->_tpl_vars['item']):
?>
								
								<input class="submit-green" type="button" onclick="window.location='<?php echo $this->_tpl_vars['item']['action']; ?>
&DisplayRecords=<?php echo $this->_tpl_vars['DisplayRecords']; ?>
&ShowThisPage=<?php echo $this->_tpl_vars['ShowThisPage']; ?>
&sortby=<?php echo $this->_tpl_vars['sortby']; ?>
&sortDirection=<?php echo $this->_tpl_vars['sortDirection']; ?>
&page=<?php echo $this->_tpl_vars['page']; ?>
&pagegroup=<?php echo $this->_tpl_vars['pagegroup']; ?>
'" value="<?php echo $this->_tpl_vars['item']['label']; ?>
" />
								<?php endforeach; endif; unset($_from); ?>
                            </fieldset>    
							        
                           
                         
                     </div> <!-- End .module-body -->

                </div>  <!-- End .module -->
        		<div style="clear:both;"></div>
            </div>

</div>