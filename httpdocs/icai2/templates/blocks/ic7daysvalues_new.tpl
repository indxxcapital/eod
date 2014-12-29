<div class="span7">
                        <div class="box box-green">
                            <div class="box-title">
                                <h3><i class="icon-check"></i>Last Closing Index Values</h3>
                               
                            </div>
                            <div class="box-content">
                                <ul class="todo-list">
                                {foreach from=$indxxvaluesarray item=point key=k}
                                    <li>
                                    
                                        <div class="todo-desc">
                                            <p><a href="#">{$point.0.name}({$point.0.code})</a></p>
                                        </div>
                                        <div class="todo-actions">
                                            <span class="label {if $point.0.indxx_value>=$point.1.indxx_value}label-success{else}label-important{/if}">{$point.0.indxx_value|number_format:2:",":"."}</span>
                                            <span class="label {if $point.0.indxx_value>=$point.1.indxx_value}label-success{else}label-important{/if}">
   {math equation="x - y" x=$point.0.indxx_value y=$point.1.indxx_value format="%.2f"}</span>
                                           
                                            <span class="label">{$point.0.date}</span>
                                            <!--<a class="show-tooltip" href="#" title="It's done"><i class="icon-ok"></i></a>
                                            <a class="show-tooltip" href="#" title="Remove"><i class="icon-remove"></i></a>-->
                                        </div>
                                    </li>
                                    {/foreach}<!--
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