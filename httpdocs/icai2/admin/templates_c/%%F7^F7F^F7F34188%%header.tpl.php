<?php /* Smarty version 2.6.14, created on 2013-10-11 09:06:09
         compiled from header.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', 'header.tpl', 3, false),)), $this); ?>
<div id="header">
  <div id="header-status">
    <div class="container_12"> <?php if (count($this->_tpl_vars['Admin']) > 0): ?>
      <div class="grid_8"> <span id="text-invitation"> </span>
        <!-- Messages displayed through the thickbox -->
      </div>
      <div class="grid_4" id="chatpanel"> <a href="index.php?module=home&event=logout" id="logout"> Logout </a> </div>
      <?php endif; ?> </div>
    <div style="clear:both;"></div>
  </div>
  <div id="header-main">
    <div class="container_12">
      <div class="grid_12">
        <div id="logo"> <?php if (count($this->_tpl_vars['Admin']) > 0): ?>
          <ul id="nav">
          
            <!--<li <?php if ($this->_tpl_vars['currentClass'] == 'employee'): ?> id="current" <?php endif; ?> >
            <a href="index.php?module=employee">Employee</a></li>-->
            <li <?php if ($this->_tpl_vars['currentClass'] == 'category' || $this->_tpl_vars['currentClass'] == 'subcategory'): ?> id="current" <?php endif; ?> >     <a href="index.php?module=category">Category</a></li>
             <li <?php if ($this->_tpl_vars['currentClass'] == 'actioneventtype' || $this->_tpl_vars['currentClass'] == 'actionevent' || $this->_tpl_vars['currentClass'] == 'actionfields'): ?> id="current" <?php endif; ?> >     <a href="index.php?module=actioneventtype">Action</a></li>
             </ul>
          <?php endif; ?> </div>
      </div>
    </div>
    <div class="clear"></div>
  </div>
  <div id="subnav">
    <div class="container_12">
      <div class="grid_12"> </div>
    
     
      
        <?php if ($this->_tpl_vars['currentClass'] == 'category' || $this->_tpl_vars['currentClass'] == 'subcategory'): ?>
      <ul>
       <li <?php if ($this->_tpl_vars['currentClass'] == 'category'): ?> id="current" <?php endif; ?> > <a href="index.php?module=category">Category</a></li>
      <li <?php if ($this->_tpl_vars['currentClass'] == 'subcategory'): ?> id="current" <?php endif; ?> > <a href="index.php?module=subcategory">SubCategory</a></li>

      </ul>
      <?php endif; ?>
      <?php if ($this->_tpl_vars['currentClass'] == 'actioneventtype' || $this->_tpl_vars['currentClass'] == 'actionevent' || $this->_tpl_vars['currentClass'] == 'actionfields' || $this->_tpl_vars['currentClass'] == 'cconstituents'): ?>
        <ul><li <?php if ($this->_tpl_vars['currentClass'] == 'actioneventtype'): ?> id="current" <?php endif; ?> > <a href="index.php?module=actioneventtype">Event Type </a></li>
        	<li <?php if ($this->_tpl_vars['currentClass'] == 'actionevent'): ?> id="current" <?php endif; ?> > <a href="index.php?module=actionevent">Event </a></li>
            <li <?php if ($this->_tpl_vars['currentClass'] == 'actionfields'): ?> id="current" <?php endif; ?> > <a href="index.php?module=actionfields">Fields </a></li>
           
		</ul>

      <?php endif; ?>
	
    </div>
    <!-- End. .container_12 -->
  </div>
</div>