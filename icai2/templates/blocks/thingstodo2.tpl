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
                                  {if $thingstodo|@count>0}
                                  {foreach from=$thingstodo item=task key=k}
                                    <li>
                                        <p>
                                            <span class="value">{$task}{$k}</span>
                                 <a class="btn btn-success" href="index.php?module=viewca&event=viewtype&id={$k}">Go</a>
                                        </p>
                                    </li>
                                    {/foreach}{else}
                                    <li>
                                        <p>
                                            <span class="value">There is no task for upcomming 7 Days .</span>
                                        </p>
                                    </li>
                                    {/if}
                                  
                                </ul>
                            </div>
                        </div>
                    </div>