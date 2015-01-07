<div class="prefix_3 grid_6 suffix_3">
    <div class="module">
      <h2><span>Log in</span></h2>
      <div class="module-body">
        <form method="post" action="index.php" class="login" onsubmit="return ValidateForm();">
			<input type="hidden" name="module" value="home" />
			<input type="hidden" name="event" value="login" />
          <fieldset>
          {foreach from=$fields key=p item=item}
			 
				<p><label><strong>{$item.feild_label}</strong> {if $item.is_required==1}<span class="red">*</span>{/if}</label>
			 
				
				{formfield itemData=$item class="input-medium"  value=$postData}{/formfield}
			 
 
				</p>
				 	
				
				{/foreach}
           
          <input class="submit-green" type="submit" name="submit" value="Submit"/>
          </fieldset>
        </form>
        <ul>
          <li><a href="index.php?module=home&event=forgetAdminPassword">I forgot my password</a></li>
        </ul>
      </div>
    </div>
  </div>
  
  
{literal}
<script type="text/javascript"  language="javascript">
jQuery(document).ready(function (){
	jQuery('input[type=text]:enabled:first').focus();
});
</script>
{/literal}