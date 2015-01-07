function showhide(id,id1){

	document.getElementById('a1').className="";
	
	document.getElementById('a2').className="";		
	
	document.getElementById(id1).className="tab-active";
	
	document.getElementById('overseas').style.display ='none';

	document.getElementById('india').style.display ='none';
		
	document.getElementById(id).style.display ='block';
	
}



function showHideTabs(tabId, DivId){
	//alert(DivId);
	if(tabId == ''){	
	
		jQuery('#leftTabs li').removeClass('tab-active');
		jQuery('#leftTabs li:first').addClass('tab-active');
		
	
	}else{
		jQuery('#leftTabs li').removeClass('tab-active');
		jQuery('#'+tabId).addClass('tab-active');
		
		jQuery('#rightTabs div').hide();
		jQuery('#'+DivId ).show();
		jQuery('#'+DivId+' div').show();
		
		/*if(tabId == 'images' || tabId == 'category'){
			jQuery('#submitButtons').hide();	
		}else{
			jQuery('#submitButtons').show();	
		}*/
	}
		
}




/*
function showhide1(id,id1){
	
	
	document.getElementById('o1').className="";
	
	document.getElementById('swift').style.display ='none';
	
	
	
	document.getElementById(id1).className="tab-active";
		
	document.getElementById(id).style.display ='block';
	
}

*/
function showhide2(id,id1){

	document.getElementById('i1').className="";
	
	document.getElementById('i2').className="";	
	
	document.getElementById('i3').className="";	
	
	document.getElementById(id1).className="tab-active";
	
	document.getElementById('direct').style.display ='none';

	document.getElementById('chequedd').style.display ='none';
	
	document.getElementById('periodic').style.display ='none';
		
	document.getElementById(id).style.display ='block';
	
}









