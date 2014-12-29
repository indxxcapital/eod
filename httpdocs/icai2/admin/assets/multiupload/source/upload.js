if((typeof(siteCode) != "undefined") && (siteCode =='KP' || siteCode =='EL'))
    var swfobj = commonImageUrl +'/Swiff.Uploader.swf';
else
    var swfobj ='source/Swiff.Uploader.swf';

function addBrowseEvent()
{
//<![CDATA[
    /**
    * FancyUpload Showcase
    *
    * @license     MIT License
    * @author      Harald Kirschner <mail [at] digitarald [dot] de>
    * @copyright   Authors
    */
    var up = new FancyUpload2($('flash_upload_status'), $('list'), { // options object
        // we console.log infos, remove that in production!!
        verbose: false,

        // url is read from the form, so you just have to change one place
        url: $('form-demo').action,

       // data: 'hash=' + document.attachimg.hash.value,

        //upload button input tag name or id
        fieldName: 'photoupload',

        // path to the SWF file
        path: swfobj,

        // remove that line to select all files, or edit it, add more items
        typeFilter: {
            'Images (*.jpg, *.jpeg, *.gif, *.png, *.bmp)': '*.jpg; *.jpeg; *.gif; *.png; *.bmp'
        },

        fileSizeMax: 2 * 1024 * 1024, // Official limit is 100 MB for FileReference, but I tested up to 2Gb!

        // this is our browse button, *target* is overlayed with the Flash movie
        target: 'browse',
        debug: true,

        // graceful degradation, onLoad is only called if all went well with Flash
        onLoad: function () {
            $('flash_upload_status').removeClass('hide'); // we show the actual UI
            if($('fallback')) $('fallback').destroy(); // ... and hide the plain form

            // We relay the interactions with the overlayed flash to the link
            this.target.addEvents({
                click: function() {
                    return false;
                },
                mouseenter: function() {
                    this.addClass('hover');
                },
                mouseleave: function() {
                    this.removeClass('hover');
                    //this.blur();
                },
                mousedown: function() {
                    this.focus();
                }
            });

            // Interactions for the 2 other buttons
            $('clear').addEvent('click', function() {
                $('upload_clear').style.display = 'none';

                up.remove();
                return false;
            });
        },

        /**
         * This one was directly in FancyUpload2 before, the event makes it
         * easier for you, to add your own response handling (you probably want
         * to send something else than JSON or different items).
         */
        onFileSuccess: function(file, response) {
            var json = new Hash(JSON.decode(response, true) || {});
            if (json.get('status') == '1')
                file.element.addClass('file-success');
            else
                file.element.addClass('file-failed');
        },

        /**
         * onFail is called when the Flash movie got bashed by some browser plugin
         * like Adblock or Flashblock.
         */
        onFail: function(error) {
            switch (error) {
                case 'hidden': // works after enabling the movie and clicking refresh
                    alert('Salliaksesi kuvansiirtotoiminnon sinun tulee sallia se Adblockissa ja päivittää sivu.');
//                     alert('To enable the embedded uploader, unblock it in your browser and refresh (see Adblock).');
                    break;
                case 'blocked': // This no *full* fail, it works after the user clicks the button
                    alert('Salliaksesi kuvansiirtotoiminnon sinun tulee sallia se Flashblockissa ja päivittää sivu.');
//                     alert('To enable the embedded uploader, enable the blocked Flash movie (see Flashblock).');
                    break;
                case 'empty': // Oh oh, wrong path
                    alert('Sivun latautumisessa tapahtui odottamaton virhe, ole hyvä ja yritä uudestaan.');
//                     alert('A required file was not found, please be patient and we fix this.');
                    break;
                case 'flash': // no flash 9+ :(
//                     alert('To enable the embedded uploader, install the latest Adobe Flash plugin.')
                    alert('Kuvansiirtotoiminto vaatii Abode Flash laajennuksen, ole hyvä ja asenna Flash.')
            }
        }

    });

    window.addEvent('domready', function() { // wait for the content
        up;
    });
//]]>
}

/* To check browser version of IE */
function isBrowserIE()
{
    var detect = navigator.userAgent.toLowerCase();
    var version = '0.0';

    var place = detect.indexOf('msie') + 1;
    if (place) {
        version = detect.substring((place + 4), (place + 7));
    }

    if (place && version == '6.0') {
        return true;
    }

    return false;
}

/* To write ajax response after delete or image order chage */
function changeImageDetail(opt, myId, myOrd, yourId, yourOrd)
{
    var scriptName = location.href.substring((location.protocol.length + location.hostname.length + 3)).split('?');
    var xmlHttpReq=createXHR();
    var frmObj = document.forms.attachimg;
    var l = frmObj.elements.length;

    frmObj.opt.value = opt;
    frmObj.myId.value = myId;
    frmObj.myOrd.value = myOrd;
    frmObj.yourId.value = yourId;
    frmObj.yourOrd.value = yourOrd;

    var params = '';
    for (var i = 0; i < l; i++)
    {
        var e = frmObj.elements[i];
        if (e.name && e.value && e.name != 'undefined' && e.type != 'checkbox' && e.type != 'radio') {
            params += e.name + '=' + e.value + '&';
        }
    }
    xmlHttpReq.open('POST', '/' + scriptName[0], true);
    xmlHttpReq.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttpReq.setRequestHeader("Content-length", params.length);
    xmlHttpReq.setRequestHeader("Connection", "close");
    xmlHttpReq.onreadystatechange = function ()
    {
        if (xmlHttpReq.readyState == 4)
        {
            frmObj.opt.value = '';
            responseTxt = xmlHttpReq.responseText;
            responseArr = responseTxt.split('**#12345#**');
            document.getElementById('uploaded_image').innerHTML = responseArr[0];

            if (responseArr[1]) {
                document.getElementById('cont_button').innerHTML = responseArr[1];
            }

            if (opt == 'delete')
            {
                if (!(isBrowserIE()) && hasReqestedVersion && document.getElementById('attachimg').ol.value != 1) {
                    document.getElementById('new_upload').style.display = 'inline';
                    document.getElementById('new_upload').innerHTML = responseArr[3];
                }
                else {
                    document.getElementById('old_upload').style.display = 'inline';
                    document.getElementById('old_upload').innerHTML = responseArr[2];
                }

                document.getElementById('all_upload').style.display = 'none';

                if (!(isBrowserIE()) && hasReqestedVersion && document.getElementById('attachimg').ol.value != 1)
                {
                    total_uploaded = total_uploaded - 1;
                    total_remain = total_remain + 1;
                    document.getElementById('id_tot_loaded').innerHTML = total_uploaded;

                    addBrowseEvent();
                }
            }
        }
    };
    xmlHttpReq.send(params);
    return false;
}

// Flash Player Version Detection - Rev 1.6
// Detect Client Browser type
// Copyright(c) 2005-2006 Adobe Macromedia Software, LLC. All rights reserved.
var isIE  = (navigator.appVersion.indexOf("MSIE") != -1) ? true : false;
var isWin = (navigator.appVersion.toLowerCase().indexOf("win") != -1) ? true : false;
var isOpera = (navigator.userAgent.indexOf("Opera") != -1) ? true : false;

function ControlVersion()
{
	var version;
	var axo;
	var e;

	// NOTE : new ActiveXObject(strFoo) throws an exception if strFoo isn't in the registry

	try {
		// version will be set for 7.X or greater players
		axo = new ActiveXObject("ShockwaveFlash.ShockwaveFlash.7");
		version = axo.GetVariable("$version");
	} catch (e) {
	}

	if (!version)
	{
		try {
			// version will be set for 6.X players only
			axo = new ActiveXObject("ShockwaveFlash.ShockwaveFlash.6");

			// installed player is some revision of 6.0
			// GetVariable("$version") crashes for versions 6.0.22 through 6.0.29,
			// so we have to be careful.

			// default to the first public version
			version = "WIN 6,0,21,0";

			// throws if AllowScripAccess does not exist (introduced in 6.0r47)
			axo.AllowScriptAccess = "always";

			// safe to call for 6.0r47 or greater
			version = axo.GetVariable("$version");

		} catch (e) {
		}
	}

	if (!version)
	{
		try {
			// version will be set for 4.X or 5.X player
			axo = new ActiveXObject("ShockwaveFlash.ShockwaveFlash.3");
			version = axo.GetVariable("$version");
		} catch (e) {
		}
	}

	if (!version)
	{
		try {
			// version will be set for 3.X player
			axo = new ActiveXObject("ShockwaveFlash.ShockwaveFlash.3");
			version = "WIN 3,0,18,0";
		} catch (e) {
		}
	}

	if (!version)
	{
		try {
			// version will be set for 2.X player
			axo = new ActiveXObject("ShockwaveFlash.ShockwaveFlash");
			version = "WIN 2,0,0,11";
		} catch (e) {
			version = -1;
		}
	}

	return version;
}

// JavaScript helper required to detect Flash Player PlugIn version information
function GetSwfVer(){
	// NS/Opera version >= 3 check for Flash plugin in plugin array
	var flashVer = -1;

	if (navigator.plugins != null && navigator.plugins.length > 0) {
		if (navigator.plugins["Shockwave Flash 2.0"] || navigator.plugins["Shockwave Flash"]) {
			var swVer2 = navigator.plugins["Shockwave Flash 2.0"] ? " 2.0" : "";
			var flashDescription = navigator.plugins["Shockwave Flash" + swVer2].description;
			var descArray = flashDescription.split(" ");
			var tempArrayMajor = descArray[2].split(".");
			var versionMajor = tempArrayMajor[0];
			var versionMinor = tempArrayMajor[1];
			var versionRevision = descArray[3];
			if (versionRevision == "") {
				versionRevision = descArray[4];
			}
			if (versionRevision[0] == "d") {
				versionRevision = versionRevision.substring(1);
			} else if (versionRevision[0] == "r") {
				versionRevision = versionRevision.substring(1);
				if (versionRevision.indexOf("d") > 0) {
					versionRevision = versionRevision.substring(0, versionRevision.indexOf("d"));
				}
			}
			var flashVer = versionMajor + "." + versionMinor + "." + versionRevision;
		}
	}
	// MSN/WebTV 2.6 supports Flash 4
	else if (navigator.userAgent.toLowerCase().indexOf("webtv/2.6") != -1) flashVer = 4;
	// WebTV 2.5 supports Flash 3
	else if (navigator.userAgent.toLowerCase().indexOf("webtv/2.5") != -1) flashVer = 3;
	// older WebTV supports Flash 2
	else if (navigator.userAgent.toLowerCase().indexOf("webtv") != -1) flashVer = 2;
	else if ( isIE && isWin && !isOpera ) {
		flashVer = ControlVersion();
	}
	return flashVer;
}

// When called with reqMajorVer, reqMinorVer, reqRevision returns true if that version or greater is available
function DetectFlashVer(reqMajorVer, reqMinorVer, reqRevision)
{
	versionStr = GetSwfVer();
	if (versionStr == -1 ) {
		return false;
	} else if (versionStr != 0) {
		if(isIE && isWin && !isOpera) {
			// Given "WIN 2,0,0,11"
			tempArray         = versionStr.split(" "); 	// ["WIN", "2,0,0,11"]
			tempString        = tempArray[1];			// "2,0,0,11"
			versionArray      = tempString.split(",");	// ['2', '0', '0', '11']
		} else {
			versionArray      = versionStr.split(".");
		}
		var versionMajor      = versionArray[0];
		var versionMinor      = versionArray[1];
		var versionRevision   = versionArray[2];

        	// is the major.revision >= requested major.revision AND the minor version >= requested minor
		if (versionMajor > parseFloat(reqMajorVer)) {
			return true;
		} else if (versionMajor == parseFloat(reqMajorVer)) {
			if (versionMinor > parseFloat(reqMinorVer))
				return true;
			else if (versionMinor == parseFloat(reqMinorVer)) {
				if (versionRevision >= parseFloat(reqRevision))
					return true;
			}
		}
		return false;
	}
}

// Major version of Flash required
var requiredMajorVersion = 8;
// Minor version of Flash required
var requiredMinorVersion = 0;
// Minor version of Flash required
var requiredRevision = 0;
// Version check based upon the values entered above in "Globals"
var hasReqestedVersion = DetectFlashVer(requiredMajorVersion, requiredMinorVersion, requiredRevision);

if(!(isBrowserIE()) && hasReqestedVersion && document.getElementById('attachimg').ol.value != 1)
{
    document.write('<script type="text/javascript" language="javascript" src="'+commonTempUrl+'/uploader/FancyUpload2.js" defer="defer"></script>');
}

if(total_uploaded != 12)
{
    if(!(isBrowserIE()) && hasReqestedVersion && document.getElementById('attachimg').ol.value != 1)
    {
        var date=new Date();
        date.setTime(date.getTime()+1000 * 60 * 60 * 24 * 30);
        document.cookie='__fsupport=1; expires='+date.toGMTString()+'; path=/;';

        document.getElementById('new_upload').style.display='inline';
        document.getElementById('old_upload').style.display='none';
    }
    else
    {
        document.getElementById('old_upload').style.display='inline';
        document.getElementById('new_upload').style.display='none';
    }
}
else
    document.getElementById('all_upload').style.display='inline';