function checkfeildEditor(id,message,value)
{ 
	if(isEmpty(value)) {		
			jQuery("#"+id).addClass('error');
			jQuery("#error_"+id).addClass('validation-advice');
			jQuery("#error_"+id).html(message);
			return false;
			 
			 
		} else {
			jQuery("#error_"+id).html('');
			jQuery("#"+id).removeClass('error'); 
			jQuery("#error_"+id).removeClass('validation-advice'); 
			return true;
	}
	
}

function checkfeild(id,message,blank,type,blankCondition)
{
	var checkExtra ="";			
	var extravalues=type.split('|');
	if(extravalues[1]!="")
	{
		type = extravalues[0];
		extravalue = extravalues[1];
		 
	}

 
	if(type!="checkbox" && type!="radio" && type!="dob")
	{
		
		var checkvalue =  trim(jQuery("#"+id).val());
	}
	else
	{
		var checkvalue =  jQuery("#"+id).val();
	}

	if(blank=="1" && type!="checkbox" && type!="radio" && type!="dob" && type!="onlyif")
	{
		
		 if(blankCondition.code!="")
			 {
			
				if(jQuery("#"+blankCondition.code).val()!=blankCondition.matchValue)
				{
				//alert(blankCondition.matchValue);
					checkExtra = 1 ;
				}
			 }
	
		if(checkExtra=="")
		{
				if(isEmpty(checkvalue)) {		
					jQuery("#"+id).addClass('error');
					jQuery("#error_"+id).addClass('validation-advice');
					jQuery("#error_"+id).html(message);
					return false;
					 
					 
				} else {
					jQuery("#error_"+id).html('');
					jQuery("#"+id).removeClass('error'); 
					jQuery("#error_"+id).removeClass('validation-advice'); 
								 
				}
		}
	}
	else
	{
		jQuery("#"+id).removeClass('error'); 
		jQuery("#error_"+id).html('');
		jQuery("#error_"+id).removeClass('validation-advice'); 
	}
	
	if(type=="email")
	{
 
		if(!isEmpty(checkvalue)) {	
		
			if (emailcheck(checkvalue)==false)
               {
				 
			jQuery("#"+id).addClass('error');
			jQuery("#error_"+id).addClass('validation-advice');
			jQuery("#error_"+id).html('Invalid email address.');
			return false;
			   }
			   else
			   {
			jQuery("#error_"+id).html('');
			jQuery("#"+id).removeClass('error'); 
			jQuery("#error_"+id).removeClass('validation-advice'); 
			return true;
	 
			   }
		}  
	}
	else if(type=="phone")
	{
 
		if(!isEmpty(checkvalue)) {
		
		if(checkInternationalPhone(checkvalue)==false)
               {
				 
			jQuery("#"+id).addClass('error');
			jQuery("#error_"+id).addClass('validation-advice');
			jQuery("#error_"+id).html('Invalid number');
			return false;
			   }
			   else
			   {
		
			jQuery("#error_"+id).html('');
			jQuery("#"+id).removeClass('error'); 
			jQuery("#error_"+id).removeClass('validation-advice'); 
			return true;
	 
			   }
	 
		} 
	}
	else if(type=="weburl")
	{
 	//alert(checkvalue)
		checkvalue = checkvalue.toLowerCase();
		if(!isEmpty(checkvalue)) {
		
		if(isValidURL(checkvalue)==false)
               {
				 
			jQuery("#"+id).addClass('error');
			jQuery("#error_"+id).addClass('validation-advice');
			jQuery("#error_"+id).html('Please enter url with http://');
			return false;
			   }
			   else
			   {
		
			jQuery("#error_"+id).html('');
			jQuery("#"+id).removeClass('error'); 
			jQuery("#error_"+id).removeClass('validation-advice'); 
			return true;
	 
			   }
	 
		} 
	}
	else if(type=="match")
	{
 
		if(checkvalue!=jQuery("#"+extravalue).val()) {		
			jQuery("#"+id).addClass('error');
			jQuery("#error_"+id).addClass('validation-advice');
			jQuery("#error_"+id).html("Does not match");
			return false;
			 
			 
		} else {
			jQuery("#error_"+id).html('');
			jQuery("#"+id).removeClass('error'); 
			jQuery("#error_"+id).removeClass('validation-advice'); 
						 
		}
	}
	
	else if(type=="datenotless")
	{
  var start =checkvalue;
  start =checkvalue.split(" "+10);
var end =trim(jQuery("#"+extravalue).val()); 
if(start<=end) {
				 
			jQuery("#"+id).addClass('error');
			jQuery("#error_"+id).addClass('validation-advice');
			jQuery("#error_"+id).html('Start date can not be greter than End date.');
			return false;
			   }
			   else
			   {
		
			jQuery("#error_"+id).html('');
			jQuery("#"+id).removeClass('error'); 
			jQuery("#error_"+id).removeClass('validation-advice'); 
			return true;
	 
			   }
	}
	else if(type=="date")
	{
 
		if(!isEmpty(checkvalue)) {
		
		if(isDate(checkvalue)==false)
               {
				 
			jQuery("#"+id).addClass('error');
			jQuery("#error_"+id).addClass('validation-advice');
			jQuery("#error_"+id).html('invalid date');
			return false;
			   }
			   else
			   {
		
			jQuery("#error_"+id).html('');
			jQuery("#"+id).removeClass('error'); 
			jQuery("#error_"+id).removeClass('validation-advice'); 
			return true;
	 
			   }
	 
		} 
	}
	
	else if(type=="dob")
	{
		
		var day = jQuery("#"+id+"Day").val();
		var month = jQuery("#"+id+"Month").val();
		var year = jQuery("#"+id+"Year").val();
 		
		if(blank=="1")
		{
			if(day=="" || month=="" || year=="")
			{
				jQuery("#"+id+"Day").addClass('error');
				jQuery("#"+id+"Month").addClass('error');
				jQuery("#"+id+"Year").addClass('error');
				jQuery("#error_"+id).addClass('validation-advice');
				jQuery("#error_"+id).html(message);
				return false;
				 
				 
			} else {
				checkvalue = day+"-"+month+"-"+year
					if(isDate(checkvalue)==false)
					{
					
						jQuery("#"+id+"Day").addClass('error');
						jQuery("#"+id+"Month").addClass('error');
						jQuery("#"+id+"Year").addClass('error');
						jQuery("#error_"+id).addClass('validation-advice');
						jQuery("#error_"+id).html('invalid date');
						return false;
					}
					else
					{
					
						jQuery("#error_"+id).html('');
						jQuery("#"+id+"Day").removeClass('error');
						jQuery("#"+id+"Month").removeClass('error');
						jQuery("#"+id+"Year").removeClass('error');
						jQuery("#error_"+id).removeClass('validation-advice'); 
						return true;
						
					} 
							 
			}
		
			
		}
		
		
		/*if(!isEmpty(checkvalue)) {
		
		if(isDate(checkvalue)==false)
               {
				 
			jQuery("#"+id).addClass('error');
			jQuery("#error_"+id).addClass('validation-advice');
			jQuery("#error_"+id).html('invalid date');
			return false;
			   }
			   else
			   {
		
			jQuery("#error_"+id).html('');
			jQuery("#"+id).removeClass('error'); 
			jQuery("#error_"+id).removeClass('validation-advice'); 
			return true;
	 
			   }
	 
		} */
	}
	
	else if(type=="minimum")
	{
 
		 
	if(!isEmpty(checkvalue)) {	
		if(checkvalue.length<extravalue)
               {
				 
			jQuery("#"+id).addClass('error');
			jQuery("#error_"+id).addClass('validation-advice');
			jQuery("#error_"+id).html('Minimum '+extravalue+' character.');
			return false;
			   }
			   else
			   {
		
			jQuery("#error_"+id).html('');
			jQuery("#"+id).removeClass('error'); 
			jQuery("#error_"+id).removeClass('validation-advice'); 
			return true;
	 
			   }
	}
	}
	else if(type=="checkbox" || type=="radio")
	{
 
		 
		
		if(jQuery('input[name='+id+']').is(':checked')==false) {	
           
				 
			jQuery("#"+id).addClass('error');
			jQuery("#error_"+id).addClass('validation-advice');
			jQuery("#error_"+id).html(message);
			return false;
			   }
			   else
			   {
		
			jQuery("#error_"+id).html('');
			jQuery("#"+id).removeClass('error'); 
			jQuery("#error_"+id).removeClass('validation-advice'); 
			return true;
	 
			   }
	   
	}
	else if(type=="numeric")
	{
 
		if(!isEmpty(checkvalue)) {	
		
			if (IsNumeric(checkvalue)==false)
               {
				 
			jQuery("#"+id).addClass('error');
			jQuery("#error_"+id).addClass('validation-advice');
			jQuery("#error_"+id).html('Invalid number');
			return false;
			   }
			   else
			   {
			jQuery("#error_"+id).html('');
			jQuery("#"+id).removeClass('error'); 
			jQuery("#error_"+id).removeClass('validation-advice'); 
			return true;
	 
			   }
		}  
	}
	else if(type=="decimal")
	{
 
		if(!isEmpty(checkvalue)) {	
		//alert(checkvalue);
			if( (checkvalue <0 )||(IsFloat(checkvalue)==false && (IsNumeric(checkvalue)==false) )  )	
               {
				 
				jQuery("#"+id).addClass('error');
				jQuery("#error_"+id).addClass('validation-advice');
				jQuery("#error_"+id).html('Invalid number');
				return false;
			   }
			   else
			   {
				jQuery("#error_"+id).html('');
				jQuery("#"+id).removeClass('error'); 
				jQuery("#error_"+id).removeClass('validation-advice'); 
				return true;
	 
			   }
		}  
	}
	else if(type=="onlyif")
	{
		
		var sourcevalues=extravalues[2].split(':');	
		
		if(jQuery.inArray(jQuery("#"+extravalue).val(),sourcevalues) !=-1){
			if(isEmpty(checkvalue)) {	
				jQuery("#"+id).addClass('error');
				jQuery("#error_"+id).addClass('validation-advice');
				jQuery("#error_"+id).html(message);
				return false;
			} else {
			
				jQuery("#error_"+id).html('');
				jQuery("#"+id).removeClass('error'); 
				jQuery("#error_"+id).removeClass('validation-advice'); 
			}
		}
	}
	else if(type=="file")
	{
		
		
		if(!isEmpty(checkvalue)) {			
		
			var fileName = jQuery("#"+id).val();
			var ext = fileName.split('.').pop().toLowerCase();
			var allow=extravalue.split(',');	
			  
			if(jQuery.inArray(ext, allow) == -1) {
				 
				jQuery("#"+id).addClass('error');
				jQuery("#error_"+id).addClass('validation-advice');
				jQuery("#error_"+id).html('Please select a '+extravalue+' file to upload.');
				return false;
			}
			else
			{		
					jQuery("#error_"+id).html('');
					jQuery("#"+id).removeClass('error'); 
					jQuery("#error_"+id).removeClass('validation-advice'); 
			}
		
		}
		 
	}
	
	
return true;
}
function isValidURL(url) 
{
	var urlRegxp = /^(http:\/\/|https:\/\/){1}/;
//		var urlRegxp = /^(http:\/\/www.|https:\/\/www.){1}([\w]+)(.[\w]+){1,2}$/;
	if (urlRegxp.test(url) != true)
		 {
		return false;
		} else {
			return true;
			}
	}  
	
function emailcheck(str)
       {
               var at="@"
               var dot="."
               var lat=str.indexOf(at)
               var lstr=str.length
               var ldot=str.indexOf(dot)
 
               if (str.indexOf(at)==-1){
               
                  return false
               }
               if (str.indexOf(at)==-1 || str.indexOf(at)==0 || str.indexOf(at)==lstr){
               
                  return false
               }
			  
               if (str.indexOf(dot)==-1 || str.indexOf(dot)==0 || str.indexOf(dot)==lstr){
               
                   return false
               }
                if (str.indexOf(at,(lat+1))!=-1){
               
                   return false
                }
                if (str.substring(lat-1,lat)==dot || str.substring(lat+1,lat+2)==dot){
               
                   return false
                }
                if (str.indexOf(dot,(lat+2))==-1){
               
                   return false
                }
                if (str.indexOf(" ")!=-1){
					
                   return false
                }
				
       }
// Declaring required variables
var digits = "0123456789";
// non-digit characters which are allowed in phone numbers
var phoneNumberDelimiters = "()- ";
// characters which are allowed in international phone numbers
// (a leading + is OK)
var validWorldPhoneChars = phoneNumberDelimiters + "+";
// Minimum no of digits in an international phone no.
var minDigitsInIPhoneNumber = 8;

function isInteger(s)
{   var i;
    for (i = 0; i < s.length; i++)
    {   
        // Check that current character is number.
        var c = s.charAt(i);
        if (((c < "0") || (c > "9"))) return false;
    }
    // All characters are numbers.
    return true;
}
function trim(s)
{   var i;
    var returnString = "";
    // Search through string's characters one by one.
    // If character is not a whitespace, append to returnString.
	if(s){
		for (i = 0; i < s.length; i++)
		{   
			// Check that current character isn't whitespace.
			var c = s.charAt(i);
			if (c != " ") returnString += c;
		}
	}
    return returnString;
}
function stripCharsInBag(s, bag)
{   var i;
    var returnString = "";
    // Search through string's characters one by one.
    // If character is not in bag, append to returnString.
    for (i = 0; i < s.length; i++)
    {   
        // Check that current character isn't whitespace.
        var c = s.charAt(i);
        if (bag.indexOf(c) == -1) returnString += c;
    }
    return returnString;
}

function checkInternationalPhone(strPhone){
var bracket=3
strPhone=trim(strPhone)
if(strPhone.indexOf("+")>1) return false
if(strPhone.indexOf("-")!=-1)bracket=bracket+1
if(strPhone.indexOf("(")!=-1 && strPhone.indexOf("(")>bracket)return false
var brchr=strPhone.indexOf("(")
if(strPhone.indexOf("(")!=-1 && strPhone.charAt(brchr+2)!=")")return true
if(strPhone.indexOf("(")==-1 && strPhone.indexOf(")")!=-1)return true
s=stripCharsInBag(strPhone,validWorldPhoneChars);
return (isInteger(s) && s.length >= minDigitsInIPhoneNumber);
}
function isEmpty(s)
{
return((s==null)||(s.length==0));	
}

var dtCh= "-";
var minYear=1900;
var maxYear=2100;
 
function daysInFebruary (year){
	// February has 29 days in any year evenly divisible by four,
    // EXCEPT for centurial years which are not also divisible by 400.
    return (((year % 4 == 0) && ( (!(year % 100 == 0)) || (year % 400 == 0))) ? 29 : 28 );
}
function DaysArray(n) {
	for (var i = 1; i <= n; i++) {
		this[i] = 31
		if (i==4 || i==6 || i==9 || i==11) {this[i] = 30}
		if (i==2) {this[i] = 29}
   } 
   return this
}
var monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];


function isDate(dtStr){
	var daysInMonth = DaysArray(12)
	var pos1=dtStr.indexOf(dtCh)
	var pos2=dtStr.indexOf(dtCh,pos1+1)
	var strMonth=dtStr.substring(pos1+1,pos2)
	if (strMonth.charAt(0)=="0" && strMonth.length>1) 
	{
		strMonth=strMonth.substring(1)
	}
	else if(strMonth.charAt(0)!="1")
	{

		strMonth = parseInt(monthNames.indexOf(strMonth))

	}
	var strDay=dtStr.substring(0,pos1)
	 
	 
		 strMonth="0"+strMonth;
	 
	var strYear=dtStr.substring(pos2+1)

	strYr=strYear
	if (strDay.charAt(0)=="0" && strDay.length>1) strDay=strDay.substring(1)
	if (strMonth.charAt(0)=="0" && strMonth.length>1) strMonth=strMonth.substring(1)
	for (var i = 1; i <= 3; i++) {
		if (strYr.charAt(0)=="0" && strYr.length>1) strYr=strYr.substring(1)
	}
	
	month=parseInt(strMonth)
	day=parseInt(strDay)
	year=parseInt(strYr)
 
	if (pos1==-1 || pos2==-1){
		 //alert("The date format should be : mm/dd/yyyy")
		return false
	}
	if (strMonth.length<1 || month<1 || month>12){
		//alert("Please enter a valid month")
		return false
	}
	if (strDay.length<1 || day<1 || day>31 || (month==2 && day>daysInFebruary(year)) || day > daysInMonth[month]){
		//alert("Please enter a valid day")
		return false
	}
	if (strYear.length != 4 || year==0 || year<minYear || year>maxYear){
		//alert("Please enter a valid 4 digit year between "+minYear+" and "+maxYear)
		return false
	}
	if (dtStr.indexOf(dtCh,pos2+1)!=-1){
	//	alert("Please enter a valid date")
		return false
	}
return true
}
 
 
function IsNumeric(sText)
{
   var ValidChars = "0123456789";
   var IsNumber=true;
   var Char;

 
   for (i = 0; i < sText.length && IsNumber == true; i++) 
      { 
      Char = sText.charAt(i); 
      if (ValidChars.indexOf(Char) == -1) 
         {
         IsNumber = false;
         }
      }
   return IsNumber;
   
   }
   
   
   function IsFloat(sText)
{
  
   if (/\./.test(sText)) {	   
		return true;	
   }else{
   	return false;   
   }
   
}
   
function cityListByState(tid,callback,selected)
{
	
	if(tid != ''){
		
		$.ajax({
			type: "POST",
			url: BASEURL + "application.php?module=ajax&event=GetCity", 
			data: "mtid="+tid+"&selected="+selected, 
						
			success: function(msg){
				
				//alert(msg);return false;
				
				result = msg;
				 
				comboObj  = document.getElementById(callback);
				ClearOptions(comboObj);
				
				//alert(result);
				
				document.getElementById(callback).innerHTML = result;
				
			},
			error: function(){
				alert('some error has occured...');	
			}
	  });
		
	}	
}

function ClearOptions(OptionList) { 
		for(x=eval(OptionList.length); x>=0; x--) {
			OptionList[x] = null;
		}
	}