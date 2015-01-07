{if $Message|@count>0 } 	
<div class="alert alert-{$Message.type}">
                                                                      <p>{$Message.msg}</p>
                                </div>

{/if}