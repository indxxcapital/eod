	  
function showVideo(id)
{
	
	
	
	if(id==0)
		{
			jQuery("#block_file").hide();
			jQuery("#block_source").show();			
			
		}
	else
		{
			jQuery("#block_file").show();
			jQuery("#block_source").hide();
		}
		
		
	
	
}

$(document).ready(function() {
					//alert (jQuery("#videotype_0").attr("checked"))	 
					//alert(jQuery("#videotype_0").attr("checked"));
if(jQuery("#videotype_0").attr("checked"))
{
//alert('true');
jQuery("#block_source").show();
jQuery("#block_file").hide();
}
else
{
//	alert('true1');
 jQuery("#block_file").show();
 jQuery("#block_source").hide();
 }
//jQuery("#block_source").hide();
 });