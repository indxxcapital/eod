<?php /* Smarty version 2.6.14, created on 2013-05-22 11:39:01
         compiled from formfields/date.tpl */ ?>

<link rel="stylesheet" href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
assets/css/ui-lightness/jquery.css">
	<script src="<?php echo $this->_tpl_vars['BASE_URL']; ?>
assets/js/jquery-ui-1.8.8.custom.min.js"></script> 
	<script>
	<?php echo '
	jQuery(function() {
		var date = new Date();
		var currentMonth = date.getMonth();
		var currentDate = date.getDate();
		var currentYear = date.getFullYear();
		jQuery( '; ?>
".date-pick<?php echo $this->_tpl_vars['Form_Params']['name']; ?>
"<?php echo ' ).datepicker({
		dateFormat: "dd-MM-yy",
		
		changeMonth: true,
		changeYear: true
	 
		'; ?>

		
		<?php if ($this->_tpl_vars['Form_Params']['name'] == 'dob'): ?>
			,
			yearRange: "c-50",
		   	changeMonth: true,
			changeYear: true,
			maxDate: new Date(currentYear, currentMonth, currentDate)
				<?php endif; ?>
		<?php echo '
		
		});
	});
	'; ?>

	</script>


<input type="text" name="<?php echo $this->_tpl_vars['Form_Params']['name']; ?>
" id="<?php echo $this->_tpl_vars['Form_Params']['name']; ?>
" value="<?php echo $this->_tpl_vars['Form_Params']['value']; ?>
" class="date-pick<?php echo $this->_tpl_vars['Form_Params']['name'];  if ($this->_tpl_vars['Form_Params']['class'] != ""): ?> <?php echo $this->_tpl_vars['Form_Params']['class'];  endif; ?>"/>
<span id="error_<?php echo $this->_tpl_vars['Form_Params']['name']; ?>
" <?php echo $this->_tpl_vars['Form_Params']['errorClass']; ?>
><?php echo $this->_tpl_vars['Form_Params']['errorMessage']; ?>
</span>