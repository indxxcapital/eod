var changedElementArray  = [];

function fireEvent(element,event){

    if (document.createEventObject){
        // dispatch for IE
        var evt = document.createEventObject();
        return element.fireEvent('on'+event,evt)
    }
    else{
        // dispatch for firefox + others
        var evt = document.createEvent("HTMLEvents");
        evt.initEvent(event, true, true ); // event type,bubbling,cancelable
        return !element.dispatchEvent(evt);
    }

}

function ajax(className,functionName,objectID,value,current)
{
	

	jQuery.get(BASEURL+"index.php?module="+className+"&event="+functionName,{ value: value ,current: current},
		function(data){
			
			 jQuery('#'+objectID).html('');
			 jQuery('#'+objectID).html(data.html);

	
		}, "json"); 
}


function ajaxNew(className,functionName,objectID,updateID,value,current)
{
	if(value=="otherOption")
	{
		 
		changedElementArray[objectID]=jQuery('#feildHtml_'+objectID).html();
		 
		jQuery('#feildHtml_'+objectID).html('<input type="text" name="other_'+objectID+'" id="'+objectID+'" value="" class="input-long" />');			 
		jQuery('#'+updateID).append('<option value="otherOption" selected="selected">Other</option>');
		fireEvent(document.getElementById(updateID),'change');
		 	  
		
	}
	else
	{
	
	 
	if(changedElementArray[updateID] && updateID!="")
	{
			jQuery('#feildHtml_'+updateID).html(changedElementArray[updateID]);
			jQuery("#"+updateID+" option[value='']").attr('selected', 'selected');
			delete changedElementArray[updateID];
			fireEvent(document.getElementById(updateID),'change');
		
	}
		 
 
	 
		if(className!="" && functionName!="")
		{
		
			jQuery.get(BASEURL+"index.php?module="+className+"&event="+functionName+"&objectID="+objectID,{ value: value ,current: current},
				function(data){
					 
					 jQuery('#'+updateID).html('');
					 jQuery('#'+updateID).html(data.html);
					
					 
			
				}, "json"); 
		}
	
	}
}

function ajaxMedicalOther(className,functionName,objectID,value,current)
{

	jQuery.get(BASEURL+"index.php?module="+className+"&event="+functionName,{ value: value ,current: current},
		function(data){
			
			 jQuery('#'+objectID).html('');
			 jQuery('#'+objectID).html(data.html);		
	
		}, "json"); 
}




function IsMedical(objectID,currentObjectId,NoBlockId,value){
//alert($('#competitive_exam').val());
	for( i=0; i < objectID.length; i++){
		
		if(jQuery('#'+currentObjectId).val() == 1){
			//alert($('#block_competitive_exam').val());
			if(objectID[i] != 'block_specializationID' && objectID[i] != 'block_relevant_specialization'){
	 	 		jQuery('#'+objectID[i]).css('display','block');
				jQuery('#'+NoBlockId).css('display','none');
			}
			
		}else{
//			alert(objectID[i]);
			jQuery('#'+NoBlockId).css('display','block');
 	 		jQuery('#'+objectID[i]).css('display','none');
		}
	}

}


function IsCompetitive(objectID,currentObjectId,NoBlockId,value){
	//alert("2"+NoBlockId);
	//alert($("input[@id='exam_course']:checked").val());
	//alert($('#exam_course').is('checked')); 
	//alert($('#specializationID').val());
	for( i=0; i < objectID.length; i++){
	
		if(jQuery('#'+currentObjectId).val() == 1){
			
			if(objectID[i] != 'block_specializationID'){
				jQuery('#'+objectID[i]).css('display','block');
				jQuery('#'+NoBlockId).css('display','none');
			}
		}else{
			//jQuery('#block_specializationID').css('display','none');
			jQuery('#'+NoBlockId).css('display','block');
 	 		jQuery('#'+objectID[i]).css('display','none');
		}
	}

}

function ajaxSpecializtion(className,functionName,objectID,blockId,value,current)
{
//alert("3");
	jQuery.get(BASEURL+"index.php?module="+className+"&event="+functionName,{ value: value ,current: current},
		function(data){
			//alert("here"+data.other);
			if(data.other=='hide'){
				jQuery('#feildHtml_'+objectID).html('');
				jQuery('#'+blockId).css('display','none');
				
			}else{
				
				//alert("here #feildHtml_"+blockId);
				jQuery('#'+blockId).css('display','block');
				jQuery('#feildHtml_'+objectID).html(data.html);
			}
		}, "json"); 
}
