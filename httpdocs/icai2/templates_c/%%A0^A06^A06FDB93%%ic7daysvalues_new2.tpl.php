<?php /* Smarty version 2.6.14, created on 2014-07-30 11:06:39
         compiled from blocks/ic7daysvalues_new2.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'number_format', 'blocks/ic7daysvalues_new2.tpl', 16, false),array('function', 'math', 'blocks/ic7daysvalues_new2.tpl', 18, false),)), $this); ?>
<div class="span7">
                        <div class="box box-green">
                            <!--<div class="box-title">
                                <h3><i class="icon-check"></i>Last Closing Index Values</h3>
                               
                            </div>-->
                            <div class="box-content">
                                <ul class="todo-list">
                                <?php $_from = $this->_tpl_vars['indxxvaluesarray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['point']):
?>
                                    <li>
                                    
                                        <div class="todo-desc">
                                            <p><a href="#"><?php echo $this->_tpl_vars['point']['0']['code']; ?>
</a></p>
                                        </div>
                                        <div class="todo-actions">
                                            <span class="label <?php if ($this->_tpl_vars['point']['0']['indxx_value'] >= $this->_tpl_vars['point']['1']['indxx_value']): ?>label-success<?php else: ?>label-important<?php endif; ?>"><?php echo ((is_array($_tmp=$this->_tpl_vars['point']['0']['indxx_value'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2, ",", ".") : number_format($_tmp, 2, ",", ".")); ?>
</span>
                                            <span class="label <?php if ($this->_tpl_vars['point']['0']['indxx_value'] >= $this->_tpl_vars['point']['1']['indxx_value']): ?>label-success<?php else: ?>label-important<?php endif; ?>">
   <?php echo smarty_function_math(array('equation' => "x - y",'x' => $this->_tpl_vars['point']['0']['indxx_value'],'y' => $this->_tpl_vars['point']['1']['indxx_value'],'format' => "%.2f"), $this);?>
</span>
                                           
                                            <span class="label"><?php echo $this->_tpl_vars['point']['0']['date']; ?>
</span>
                                            <!--<a class="show-tooltip" href="#" title="It's done"><i class="icon-ok"></i></a>
                                            <a class="show-tooltip" href="#" title="Remove"><i class="icon-remove"></i></a>-->
                                        </div>
                                    </li>
                                    <?php endforeach; endif; unset($_from); ?><!--
                                    <li>
                                        <div class="todo-desc">
                                            <p>Add new product's description post</p>
                                        </div>
                                        <div class="todo-actions">
                                            <span class="label label-important">Today</span>
                                            <a class="show-tooltip" href="#" title="It's done"><i class="icon-ok"></i></a>
                                            <a class="show-tooltip" href="#" title="Remove"><i class="icon-remove"></i></a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="todo-desc">
                                            <p><a href="#">Remove some posts</a></p>
                                        </div>
                                        <div class="todo-actions">
                                            <span class="label label-warning">Tommorow</span>
                                            <a class="show-tooltip" href="#" title="It's done"><i class="icon-ok"></i></a>
                                            <a class="show-tooltip" href="#" title="Remove"><i class="icon-remove"></i></a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="todo-desc">
                                            <p>Shedule backups</p>
                                        </div>
                                        <div class="todo-actions">
                                            <span class="label label-success">This week</span>
                                            <a class="show-tooltip" href="#" title="It's done"><i class="icon-ok"></i></a>
                                            <a class="show-tooltip" href="#" title="Remove"><i class="icon-remove"></i></a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="todo-desc">
                                            <p>Weekly sell report</p>
                                        </div>
                                        <div class="todo-actions">
                                            <span class="label label-success">This week</span>
                                            <a class="show-tooltip" href="#" title="It's done"><i class="icon-ok"></i></a>
                                            <a class="show-tooltip" href="#" title="Remove"><i class="icon-remove"></i></a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="todo-desc">
                                            <p><a href="#">Hire developers</a></p>
                                        </div>
                                        <div class="todo-actions">
                                            <span class="label label-info">Next week</span>
                                            <a class="show-tooltip" href="#" title="It's done"><i class="icon-ok"></i></a>
                                            <a class="show-tooltip" href="#" title="Remove"><i class="icon-remove"></i></a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="todo-desc">
                                            <p><a href="#">New frontend design</a></p>
                                        </div>
                                        <div class="todo-actions">
                                            <span class="label label-info">Next week</span>
                                            <a class="show-tooltip" href="#" title="It's done"><i class="icon-ok"></i></a>
                                            <a class="show-tooltip" href="#" title="Remove"><i class="icon-remove"></i></a>
                                        </div>
                                    </li>-->
                                </ul>
                            </div>
                        </div>
                    </div>