<div class="prefix_3 grid_6 suffix_3" style="height:400px;">
    <div class="module">
      <h2><span>Forgot Password</span></h2>
      <div class="module-body">
        <form method="post"  style="height: 200px;" action="" class="login" onsubmit="return ValidateForm();">
           
          <fieldset>
          {foreach from=$fields key=p item=item}
			 
				<p><label><strong>{$item.feild_label}</strong> {if $item.is_required==1}<span class="red">*</span>{/if}</label>
			 
				
				{formfield itemData=$item class="input-medium"  value=$postData}{/formfield}
			 
 
				</p>
				 	
				
				{/foreach}
           <input class="submit-green" type="submit" name="forget" value="Submit"/> <a href="index.php?module=home">Click here to login</a>
          </fieldset>
        </form>
        
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