 /*********************************************************************
Project			: 
Purpose			: This page contains some common javascript functions use to validate forms
Method			: checkNumericVals      => validate for numeric numbers only
				  objChecked		    => check if a checkbox is checked or not
				  fn_ValidateZipPhone   => validate zip/phone for a fixed no. of characters
				  CheckConfirmPassword  => matches the password and confirm password
				  CheckAll			=> Used to check a set of checkboxes
				  fnRemoveSpaces		=> Used to remove spaces from the string
				  fnFixSpace			=> Used to remove spaces
				  ValidateEMail			=> Used to validate an email address
				  changeCase			=> Changes first letter to upper case and other to lower case
				  ValidateForm			=> Validate form controls 
				 	
Organization		: E2 Solutions
Created On			: May 01, 2006

*********************************************************************/

var sInvalidChars
sInvalidChars = "1234567890";
var iTotalChecked = 0;

var vowelRegx = /[a|e|i|o|u]/
//variables added to allow spaces and plus sign validation for phone and faxes
var iAllowPlus  = 1;
var iAllowSpace = 1;

function strtrim() {
    return this.replace(/^\s+/,'').replace(/\s+$/,'');
}

String.prototype.trim = strtrim;

//function to keep a countdown of the no. of characters entered in the textarea/textfield
function textCounter(theField,theCharCounter,maxChars)
{
	var strTemp = "";
	var strCharCounter = 0;
	var currentLength = theField.value.length;
	if(currentLength>maxChars)
	{
		alert("You are not allowed to enter more than "+maxChars+" characters. Your text has been truncated.")
		theField.value = theField.value.substring(0, maxChars);
		theCharCounter.value = "Countdown 0";
		return false;
	}
	else
	{
		for (var i = 0; i < theField.value.length; i++)
		{
			var strChar = theField.value.substring(i, i + 1);
			if (strChar == '\n')
			{
				strTemp += strChar;
				strCharCounter = 1;
				
			}
			else
			{
				strTemp += strChar;
				strCharCounter ++;
			}
		}
		var remainingChars = maxChars - strTemp.length;
		var string = "Countdown "+remainingChars;
		theCharCounter.value = string;
	}
}
//function to check whether the email and confirm email are same or not
function checkConfirmEmail(emailObj,confirmEmailObj)
{
	if(emailObj.value!=confirmEmailObj.value)
	{
		alert("Email Address and Confirm Email Address don't match!")
		confirmEmailObj.focus();
		return false;
	}
}

//function to check whether no. of characters typed exceed the no. of characters allowed
function checkMaxLength(obj, maxChar,fldName)
{
	
	if(obj.value.length>1 && obj.value.length>maxChar)
	{
		alert("You are not allowed to enter more than "+maxChar+" characters in the "+fldName+" field. Your text has been truncated.")
		obj.value = obj.value.substring(0, maxChar);
		return false;
	}
}

//function to check whether no. of characters typed is less than the min. characters allowed
function checkMinLength(obj, minChar,fldName)
{
	var objVal = fnFixSpace(obj.value);
	if(objVal.length>0 && objVal.length<minChar)
	{
		alert(fldName+" should have at least "+ minChar+" characters.")
		return false;
	}
	if(objVal.length==0)
	{
		obj.value="";
	}
}

//This function validates the date taking date and format as parameters
function isValidDate(dateStr, format)
{
  dArr2 = dateStr.split('-');
  cnt2 = dArr2.length;
  pname2 = dArr2[ cnt2 -1];
  ylen = pname2.length;
  if(ylen < 4)return false;
   if (format == null) { format = "MDY"; }
   format = format.toUpperCase();
   if (format.length != 3) { format = "MDY"; }
   if ((format.indexOf("M") == -1) || (format.indexOf("D") == -1) || (format.indexOf("Y") == -1)) { format = "MDY"; }
   if (format.substring(0, 1) == "Y") { // If the year is first
	 var reg1 = /^\d{2}(\-|\/|\.)\d{1,2}\1\d{1,2}$/
	 var reg2 = /^\d{4}(\-|\/|\.)\d{1,2}\1\d{1,2}$/
   } else if (format.substring(1, 2) == "Y") { // If the year is second
	 var reg1 = /^\d{1,2}(\-|\/|\.)\d{2}\1\d{1,2}$/
	 var reg2 = /^\d{1,2}(\-|\/|\.)\d{4}\1\d{1,2}$/
   } else { // The year must be third
	 var reg1 = /^\d{1,2}(\-|\/|\.)\d{1,2}\1\d{2}$/
	 var reg2 = /^\d{1,2}(\-|\/|\.)\d{1,2}\1\d{4}$/
   }
   // If it doesn't conform to the right format (with either a 2 digit year or 4 digit year), fail
   if ((reg1.test(dateStr) == false) && (reg2.test(dateStr) == false)) { return false; }
   var parts = dateStr.split(RegExp.$1); // Split into 3 parts based on what the divider was
   // Check to see if the 3 parts end up making a valid date
   if (format.substring(0, 1) == "M") { var mm = parts[0]; } 
   else if (format.substring(1, 2) == "M") { var mm = parts[1]; } else { var mm = parts[2]; }
   if (format.substring(0, 1) == "D") { var dd = parts[0]; } 
   else if (format.substring(1, 2) == "D") { var dd = parts[1]; } else { var dd = parts[2]; }
   if (format.substring(0, 1) == "Y") { var yy = parts[0]; } 
   else if (format.substring(1, 2) == "Y") { var yy = parts[1]; } else { var yy = parts[2]; }
   if (parseFloat(yy) <= 50) { yy = (parseFloat(yy) + 2000).toString(); }
   if (parseFloat(yy) <= 99) { yy = (parseFloat(yy) + 1900).toString(); }
   var dt = new Date(parseFloat(yy), parseFloat(mm)-1, parseFloat(dd), 0, 0, 0, 0);
   if (parseFloat(dd) != dt.getDate()) { return false; }
   if (parseFloat(mm)-1 != dt.getMonth()) { return false; }
   return true;
}
	
function checkNumericVals(objV,  msg)
{
	for(var i = 0;i < sInvalidChars.length;i++)
	{
		if(objV.value.indexOf(sInvalidChars.charAt(i)) != -1)
		{
			alert(msg);
			objV.focus();
			return false;
		}
	}
	return true;
}//end of the function


totalDocumentsSelected = 0;
function objChecked(obj,checkAllObj,formObj)
{ 
	if(obj.checked)
	{
		iTotalChecked = iTotalChecked + 1
	}
	else
	{
		iTotalChecked = iTotalChecked - 1
		if(checkAllObj!="")
		checkAllObj.checked= false;
	}
	
}//end of the function


function fn_ValidateZipPhone(obj, iLen, sMsg)
{
	if(obj.value.length < iLen)
	{
		alert(sMsg);
		obj.select();
		obj.focus();
		return false;
	}
	return true;
}//end of the function



function fnRemoveSpaces(sFldval)
{
	var sTemp = sFldval;
	var sNewval = sTemp;
	for(var i = 0;i < sTemp.length;i++)
	{	
		if(sTemp.charAt(i)!= " ")
			break;
		else
			sNewval = sTemp.substring(i+1);
	}
	return sNewval;
}//end of the function


//Purpose	: This function is used to remove spaces. 
//Arguments : text field object value
function fnFixSpace(sFldval)
{
	
	var sTemp = sFldval;
	  var sReversedString = "";
	  var sTemp1;
	  
	  //remove spaces from the front
	  sNewval = fnRemoveSpaces(sTemp);
	  
	  // reverse n remove spaces from the front
	  for(var i = sNewval.length-1;i >= 0;i--)
		sReversedString = sReversedString + sNewval.charAt(i);
	sTemp1 = fnRemoveSpaces(sReversedString);
	//reverse again
	sReversedString = "";
	for(var i = sTemp1.length-1;i >= 0;i--)
		sReversedString = sReversedString + sTemp1.charAt(i);
	sNewval = sReversedString;
	return sNewval;
}


//Purpose	: This function is used to validate email. 
//Arguments : Email object
/*function ValidateEMail(objName) { 
	var sobjValue;
	
	sobjValue = objName.trim(); 
		
	if(sobjValue.match(">")){	
		sobjValue = sobjValue.replace(/>/g,'');				
	}
	
	if(sobjValue.match("<")){	
		sobjValue = sobjValue.replace(/</g,'');			
	}
	
	if(sobjValue.match('"')){		
		sobjValue = sobjValue.replace(/"[^"]*"/g,'');		
	}
	
	sobjValue = sobjValue.trim();	
	var reEmail = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i
	
	if(sobjValue.length > 5 && reEmail.test(sobjValue)) {
		return true;
	} else {
		return false;
	}
}*/

/*--------------------------------------------------------------------------------------
	this sub routine checks for the mandatory fields, their data types and maximum length
	also validates valid email entered or not
	Return : True/False
	Input : objFrm ( form object name)
	**** new validateForm that check numerics in first name, last name etc  ---TRC,TLN  ,,      
	PHR, PHN -  phone numbers along with hyper and spaces , 
----------------------------------------------------------------------------------------*/

function ValidateImg(objName,objImg, isRequired)
{
	if(isRequired == 1 && objImg.value == '')
	{
		alert("Please select the "+objName+" using browse button");
		//objImg.focus();
		return false;
	}
	if(objImg.value.length!=0)
	{
		if(objImg.value.length<5)
		{
			alert("Please select valid "+objName+".");
			//objImg.focus();
			//objImg.select();
			return false;
		}
		var iPos = objImg.value.lastIndexOf(".")
		var sExt = objImg.value.substring(iPos);
//		if((sExt.toUpperCase()=='.JPEG') || (sExt.toUpperCase()=='.JPG') || (sExt.toUpperCase()=='.GIF') || (sExt.toUpperCase()=='.BMP') )
		if((sExt.toUpperCase()=='.JPEG') || (sExt.toUpperCase()=='.JPG'))
		{
			return true;
		}
		else
		{
			alert("Please select valid "+objName+". Only JPEG/JPG images are allowed.");
			//objImg.focus();
			//objImg.select();
			return false;
		}
	}
	return true;
}



function ValidateNumber(objName) {
	var h;
	var x;
	
	h=objName.length;
	x = objName;
	if (h==0)
	{
		alert("Price cannot be left blank");
		return false;
	}			
	for( i=0;i<h;i++)
	{
		z = x.substring(i,i+1);
		if ( z=="'"||z=='"' || (z >= "a" && z <= "z" ) || (z >= "A" && z <= "Z") )
		{
			alert("Price Can be numeric only");
			return false;
		}			
	}
	jj=x.indexOf(".");
	if (jj != "-1") 
		{
		hh=x.substring(jj);
		ll=hh.length;
		if (ll > 3) 
			{
			alert("Price Can have upto 2 decimal places");
			return false;
			}
		}
	return true;
	
}


function getFormattedmsg(sVal) {
	sVal = sVal.trim(); 
	while(sVal.indexOf("_") != -1) {
		sVal = sVal.replace("_", " ");
		getFormattedmsg(sVal);
	} 
	var b;
	b = sVal.charAt(0).toUpperCase();
	b = b + sVal.substring(1);
	return b;
}


function isURL(argvalue) { 
	urlRegEx = /http[s]?:\/\/([-\w\.]+)+(:\d+)?(\/([\w\/_\.]*(\?\S+)?)?)?/;
	var testVal = argvalue.trim(); 
	if(testVal.length > 9 && urlRegEx.test(testVal)) { 
		return true;
	} else { 
		return false; 
	}
}


//Purpose	: This function is used to validate price. 
//Arguments : price object
function ValidatePrice(objName)
{
	var sobjValue;
	var iobjLength;
	
	sobjValue=objName;
	iobjLength=sobjValue.length;
	iSposition=sobjValue.indexOf(".");
	iTmp=sobjValue.lastIndexOf(".");	
	iPosition=sobjValue.indexOf(",");
	iPos=sobjValue.indexOf(";");
	
	if (iobjLength!=0)
	{
		if(sobjValue.charAt(0)==".")
		{
			return false;				
		}
		else if(sobjValue.charAt(iobjLength)==".")
		{
			return false;				
		}	
		else if ((iTmp!=-1) && ((iobjLength-(iTmp+1)>2) || (iobjLength==(iTmp+1))))
		{
			return false;
		}
		else if ((iPosition!=-1) || (iPos!=-1))
		{
			return false;
		}
		else
		{
			return true;
		}		
	}		
}

//Description: This Function checks that the string value passed to the function does contains some characters.
function onlyno()
{
	if (event.keyCode < 45 || event.keyCode > 57) 
		event.returnValue = false;
}


//Description: This Function checks that the character entered is only character
function onlychar()
{
	if((event.keyCode >= 65 && event.keyCode <= 90) || (event.keyCode >= 97 && event.keyCode <= 122) || event.keyCode == 32 )
	{
	}
	else
	{
		event.returnValue = false;
	}
}



//Description: This Function checks that the character entered is only character or space used in validate form function
function onlyString(TempString)
{
	bb11= TempString.length;
	x= TempString;
	flag=0;

	for( p=0;p<bb11;p++)
	{
		vAscii = x.charCodeAt(p)
		
		//z = x.substring(p,p+1);
		 if((vAscii >= 65 && vAscii <= 90) || (vAscii >= 97 && vAscii <= 122))
			{
				flag=1;		
			}
			else
			{
				flag=0;
				break;
			}
	}
	if(flag==0)
	{
		return false;
	}
	else
	{
		return true;
	}
}

//Converts the First letter of each word to upper case and rest of the letters to lower case
function changeCase(frmObj) 
{
	var index;
	var tmpStr;
	var tmpChar;
	var preString;
	var postString;
	var strlen;
	tmpStr = frmObj.value.toLowerCase();
	strLen = tmpStr.length;
	if (strLen > 0)  
	{
		for (index = 0; index < strLen; index++)  
		{
			if (index == 0)  
			{
				tmpChar = tmpStr.substring(0,1).toUpperCase();
				postString = tmpStr.substring(1,strLen);
				tmpStr = tmpChar + postString;
			}
			else 
			{
				tmpChar = tmpStr.substring(index, index+1);
				if (tmpChar == " " && index < (strLen-1))  
				{
					
					tmpChar = tmpStr.substring(index+1, index+2).toUpperCase();
					preString = tmpStr.substring(0, index+1);
					postString = tmpStr.substring(index+2,strLen);
					tmpStr = preString + tmpChar + postString;
		        }
			}
		}
	}
	frmObj.value = tmpStr;
}



//Purpose	: This function is used to check all the checkboxes based on state of chk checkbox. 
//Arguments : checkbox object
var chkBoxCount = 0;

function frm_selectAll(chkObj, frmObj, nameObj, nameObjLen) { 
       // alert(frmObj);
        var lclVar1 = frmObj.length;
        for (var i = 0; i < lclVar1; i++) {
                if (frmObj.elements[i].type == "checkbox"  && frmObj.elements[i].name.substr(0, nameObjLen) == nameObj) {
                        frmObj.elements[i].checked = chkObj.checked;
                }
        }
} //End of Function

function frm_deselectAll(chkObj, frmObj, nameObj, nameObjLen) {
        if (chkObj.checked) {
                chkObj.checked = false;
        }

        var lclVar1 = frmObj.length;
        var lclVar2 = false;
        var lclVar3 = false;

        for (var i = 0; i < lclVar1; i++) {
                if (frmObj.elements[i].type == "checkbox"  && frmObj.elements[i].name.substr(0, nameObjLen) == nameObj) {
                        lclVar2 = true;
                        if (lclVar2 == true && frmObj.elements[i].checked) {
                                lclVar3 = true;
                        }
                        else {
                                lclVar3 = false;
                                break;
                        }
                } else {
                        lclVar2 = false;
                }
        }

        if (lclVar3) {
                chkObj.checked = true;
        }
}  //End of Function

function checkchkb(chkObj, frmObj) {
        chkBoxCount = 0; 

        for (var i = 0; i < frmObj.elements.length; i++) {	
                if (frmObj.elements[i].type == "checkbox" && frmObj.elements[i].name != chkObj.name) {
                        if(frmObj.elements[i].checked == true) {
                                chkBoxCount = parseInt(chkBoxCount) + 1;
                        }
                }
        }

        if (chkBoxCount == 0) {
                return false;
        }
        return true;
}  //End of Function

function frm_actDactDel(chkObj, frmObj) { 
        var result = checkchkb(chkObj, frmObj);

        if(!result) {
                alert("Please select atleast one checkbox.");
                return false;
        } 
        return true; 
}  //End of Function


function upload_image(imgObj, ctrlLabel, isRequired) {
	var imgStr = imgObj.value;

	if(isRequired == "1") { 
		if(imgStr.trim().length <= 0) { 
			alert(ctrlLabel+" image is required.");
			return false; 
		}
	} 
        
	if(imgStr.trim().length > 0) { 
		var imgArr = imgStr.split('.'); 
		var count = imgArr.length;
		var ext = imgArr[ count -1].toLowerCase();

		if(ext == 'jpg' || ext == 'jpeg' || ext == 'gif' || ext == 'png')  {
			if(imgObj.value == '')  {
				alert("Select the image using browse button");
				return false;
			} 
 		} else {
			alert("Only jpg, gif, png images are allowed");
			return false;
		}
	}

	return true;
}

// This function is to check 

function chkMaxLen(objName,maxLen)
{
	if(document.getElementById(objName).value.length > maxLen)	{ 
		var content = document.getElementById(objName).value;
		alert('You can not enter more then ' + maxLen + ' character');
		var content = content.substring(0,maxLen);
		document.getElementById(objName).value = content;
	}
}

function createXMLHttpRequest() {
		var ua;
		if(window.XMLHttpRequest) {
			try {
				ua = new XMLHttpRequest();
			} catch(e) {
				ua = false;
			}
		} else if(window.ActiveXObject) {
			try {
				ua = new ActiveXObject("Microsoft.XMLHTTP");
			} catch(e) {
				ua = false;
			}
		}
		return ua;
	}

function AddToOptionList(OptionList, OptionValue, OptionText) { 
		OptionList[eval(OptionList.length)] = new Option(OptionText, OptionValue);
	}

function ClearOptions(OptionList) { 
		for(x=eval(OptionList.length); x>=0; x--) {
			OptionList[x] = null;
		}
	}
	
function checkEmails(email_field){
		
	var email = email_field.split(',');
	
	for (var i = 0; i < email.length; i++) {
		if (!ValidateEMail(email[i], 1, 0)) {			
			alert('E-mail address '+ email[i] +' is not valid. Please enter a valid email address.')
			return false;
		}
	}
	return true;
}	

/* custom function for universal replace  */
function replace(argvalue, x, y) {

  if ((x == y) || (parseInt(y.indexOf(x)) > -1)) {
    errmessage = "replace function error: \n";
    errmessage += "Second argument and third argument could be the same ";
    errmessage += "or third argument contains second argument.\n";
    errmessage += "This will create an infinite loop as it's replaced globally.";
    alert(errmessage);
    return false;
  }
    
  while (argvalue.indexOf(x) != -1) {
    var leading = argvalue.substring(0, argvalue.indexOf(x));
    var trailing = argvalue.substring(argvalue.indexOf(x) + x.length, 
	argvalue.length);
    argvalue = leading + y + trailing;
  }

  return argvalue;

}

function getEditorValue(obj) {
	var browserName = navigator.appName; 
	if (browserName=="Netscape") { 
		return obj.textContent;
	} else { 
		if (browserName=="Microsoft Internet Explorer") {
			return obj.innerText;
		} else  {
			return  obj.innerText;
		}
	}	
}


/*++++++ Added on 24 Feb 2011 +++++++*/
/*++++++		This funciton is for Create Dropdown List start here	 */
function CreateDropDownList(combo, result){
	
	if(result != 'NULL'){			
								
		var result_body = result.split('||');
		
		var div_id_list = result_body[0];			
		var div_id_list_body = div_id_list.split(',');			
		
		var div_name_list = result_body[1];			
		var div_name_list_body = div_name_list.split(',');
					
		var div_id_length = div_id_list_body.length;					
		
		AddToOptionList(combo, '', 'Select');	
		
		for(var i=0; i<div_id_length; i++){
		
			var divId = div_id_list_body[i];
			
			var divName = div_name_list_body[i];
							
			AddToOptionList(combo, divId, divName);							
		}
	}else{
		
		var option = document.createElement("option");
		
		option.text = 'Select';
		option.value = '';
		
		try {
			combo.add(option, null); //Standard
		}catch(error) {
			combo.add(option); // IE only
		}
	}
	
}
/*++++++		This funciton is for Create Dropdown List start here */



/*++++++ Added on 01 March 2011 +++++++*/
/*++++++		This funciton is for Create Dropdown List start here	 */
function CreateDropDownListLatest(combo, result, otherval){
	
	if(result != 'NULL'){			
		
		var result_body = result.split('||');
		
		var div_id_list = result_body[0];			
		var div_id_list_body = div_id_list.split('##');			
		
		var div_name_list = result_body[1];			
		var div_name_list_body = div_name_list.split('##');
					
		var div_id_length = div_id_list_body.length;					
		
		AddToOptionList(combo, '', 'Select');	
		
		for(var i=0; i<div_id_length; i++){
		
			var divId = div_id_list_body[i];
			
			var divName = div_name_list_body[i];
							
			AddToOptionList(combo, divId, divName);							
		}
		
		
		if(otherval == 'other'){
			AddToOptionList(combo, 'other', 'Other');
		}
		
	}else{
		
		var option = document.createElement("option");
		
		option.text = 'Select';
		option.value = '';
		
		try {
			combo.add(option, null); //Standard
		}catch(error) {
			combo.add(option); // IE only
		}
	}
	
}
/*++++++		This funciton is for Create Dropdown List start here */