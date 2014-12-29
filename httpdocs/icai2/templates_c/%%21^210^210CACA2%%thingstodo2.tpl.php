<?php /* Smarty version 2.6.14, created on 2014-07-30 11:16:31
         compiled from blocks/thingstodo2.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', 'blocks/thingstodo2.tpl', 13, false),)), $this); ?>
<div class="span7">
                        <div class="box box-black">
                            <!--<div class="box-title">
                                <h3><i class="icon-retweet"></i> Thing To Do for Next 7 days </h3>
                                <div class="box-tool">
                                    <a data-action="collapse" href="#"><i class="icon-chevron-up"></i></a>
                                    <a data-action="close" href="#"><i class="icon-remove"></i></a>
                                </div>
                            </div>-->
                            <div class="box-content">
                            
                                <ul class="things-to-do">
                                  <?php if (count($this->_tpl_vars['thingstodo']) > 0): ?>
                                  <?php $_from = $this->_tpl_vars['thingstodo']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['task']):
?>
                                    <li>
                                        <p>
                                            <span class="value"><?php echo $this->_tpl_vars['task'];  echo $this->_tpl_vars['k']; ?>
</span>
                                 <a class="btn btn-success" href="index.php?module=viewca&event=viewtype&id=<?php echo $this->_tpl_vars['k']; ?>
">Go</a>
                                        </p>
                                    </li>
                                    <?php endforeach; endif; unset($_from);  else: ?>
                                    <li>
                                        <p>
                                            <span class="value">There is no task for upcomming 7 Days .</span>
                                        </p>
                                    </li>
                                    <?php endif; ?>
                                  
                                </ul>
                            </div>
                        </div>
                    </div>