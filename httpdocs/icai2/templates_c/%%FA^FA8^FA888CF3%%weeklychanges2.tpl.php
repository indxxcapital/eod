<?php /* Smarty version 2.6.14, created on 2014-07-30 11:19:16
         compiled from blocks/weeklychanges2.tpl */ ?>
<div class="span5">
                        <div class="box box-orange">
                            <!--<div class="box-title">
                                <h3><i class="icon-bar-chart"></i> Weekly Changes</h3>
                                <div class="box-tool">
                                    <a data-action="collapse" href="#"><i class="icon-chevron-up"></i></a>
                                    <a data-action="close" href="#"><i class="icon-remove"></i></a>
                                </div>
                            </div>-->
                            <div class="box-content">
                                <ul class="weekly-changes">
                                    <li>
                                        <p>
                                         <!--   <i class="icon-arrow-up light-green"></i>-->
                                            <span class="light-green"><?php echo $this->_tpl_vars['wchtotalActiveindxx']; ?>
</span>
                                            New Index
                                        </p>
                                    </li>
                                    <li>
                                        <p>
                                         <!--   <i class="icon-minus light-blue"></i>-->
                                            <span class="light-green"><?php echo $this->_tpl_vars['wchtotalca']; ?>
</span>
                                            New Corporate Actions
                                        </p>
                                    </li>
                                    <li>
                                        <p>
                                            <!--<i class="icon-arrow-down light-red"></i>-->
                                            <span class="light-green"><?php echo $this->_tpl_vars['wchtotalTicker']; ?>
</span>
                                            New Securities
                                        </p>
                                    </li>
                                    <li>
                                        <p>
                                           <!-- <i class="icon-arrow-up light-green"></i>-->
                                            <span class="light-green"><?php echo $this->_tpl_vars['wchtotalcavals']; ?>
</span>
                                            New Corporate Actions Updates
                                        </p>
                                    </li>
                                    <!--<li>
                                        <p>
                                            <i class="icon-arrow-down light-red"></i>
                                            <span class="light-red">74</span>
                                            New Orders
                                        </p>
                                    </li>-->
                                </ul>
                            </div>
                        </div>
                    </div>