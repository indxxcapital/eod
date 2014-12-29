<link type="text/css" href="{$BASE_URL}assets/multiupload/imageupload.css" rel="stylesheet"  media="all"/>
<script type="text/javascript" src="{$BASE_URL}assets/multiupload/source/mootools.js"></script>
<script type="text/javascript" src="{$BASE_URL}assets/multiupload/source/Swiff.Uploader.js"></script>
<script type="text/javascript" src="{$BASE_URL}assets/multiupload/source/Fx.ProgressBar.js"></script>
<script type="text/javascript" src="{$BASE_URL}assets/multiupload/source/Lang.js"></script>
<script type="text/javascript" src="{$BASE_URL}assets/multiupload/source/FancyUpload2.js"></script>

<script type="text/javascript">
		//<![CDATA[

{literal}
window.addEvent('domready', function() { // wait for the content

	// our uploader instance 
	
	 
	var up = new FancyUpload2($('image-status'), $('upload-list'), { // options object
		// we console.log infos, remove that in production!!
		verbose: true,
		
		// url is read from the form, so you just have to change one place
		
		{/literal}
		
		url: '{$BASE_URL}index.php?module=ajax&event=multiUpload',
		
		// path to the SWF file
		path: '{$BASE_URL}assets/multiupload/source/Swiff.Uploader.swf',
		{literal}
		// remove that line to select all files, or edit it, add more items
		typeFilter: {
			'Images (*.jpg, *.jpeg, *.gif, *.png)': '*.jpg; *.jpeg; *.gif; *.png'
		},
		
		// this is our browse button, *target* is overlayed with the Flash movie
		target: 'image-browser',
		
		// graceful degradation, onLoad is only called if all went well with Flash
		onLoad: function() {
			$('image-status').removeClass('hide'); // we show the actual UI
			$('image-fallback').destroy(); // ... and hide the plain form
			
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
			
			$('list-clear').addEvent('click', function() {
				up.remove(); // remove all files
				return false;
			});

			 
		},
		
		// Edit the following lines, it is your custom event handling
		
		/**
		 * Is called when files were not added, "files" is an array of invalid File classes.
		 * 
		 * This example creates a list of error elements directly in the file list, which
		 * hide on click.
		 */ 
		onSelectFail: function(files) {
			files.each(function(file) {
				new Element('li', {
					'class': 'validation-error',
					html: file.validationErrorMessage || file.validationError,
					title: MooTools.lang.get('FancyUpload', 'removeTitle'),
					events: {
						click: function() {
							this.destroy();
						}
					}
				}).inject(this.list, 'top');
			}, this);
		},
		
		/**
		 * This one was directly in FancyUpload2 before, the event makes it
		 * easier for you, to add your own response handling (you probably want
		 * to send something else than JSON or different items).
		 */
		onFileSuccess: function(file, response) { 
			var json = new Hash(JSON.decode(response, true) || {});
			
			if (json.get('status') == '1') {
			
			
				var rowCount = jQuery('#productImage tr').length;
				
				 
			/*jQuery('#productImage > tbody:last').append('<tr id=tr_'+(rowCount)+' ><td    align="center"><img src="'+ json.get('imageUrl') +'"><input id=usrId_'+(rowCount)+' type="hidden" name="resellersIds[]" value=""></td><td  align="center"><input type="radio" name="baseImage"></td><td align="center"><input type="radio" name="thumbImage"></td><td  align="center"><input type="radio" name="cartImage"></td><td     align="center"><img class="delete" src="assets/images/close.png"  onclick="deleteRow('+rowCount+')" /></td></tr>');  */
		 
		 
		 jQuery('#productImage > tbody:last').append('<tr id=tr-image_'+(rowCount)+' ><td    align="center"><img src="'+ json.get('imageUrl') +'"><input id=imgId_'+(rowCount)+' type="hidden" name="productImages[]" value="'+ json.get('name')+ '" ></td><td  align="center"><input  checked="checked" type="radio" name="baseImage" value="'+ json.get('name')+ '"></td><td  align="center"><img class="delete" src="assets/images/close.png"  onclick="deleteImageRow('+rowCount+')" /></td></tr>');  
			
				file.element.addClass('file-success');
				file.info.set('html', '<strong>Image was uploaded:</strong> ' + json.get('width') + ' x ' + json.get('height') + 'px, <em>' + json.get('mime') + '</em>)');
			} else {
				file.element.addClass('file-failed');
				file.info.set('html', '<strong>An error occured:</strong> ' + (json.get('error') ? (json.get('error') + ' #' + json.get('code')) : response));
			}
		},
		
		/**
		 * onFail is called when the Flash movie got bashed by some browser plugin
		 * like Adblock or Flashblock.
		 */
		onFail: function(error) {
			switch (error) {
				case 'hidden': // works after enabling the movie and clicking refresh
					alert('To enable the embedded uploader, unblock it in your browser and refresh (see Adblock).');
					break;
				case 'blocked': // This no *full* fail, it works after the user clicks the button
					alert('To enable the embedded uploader, enable the blocked Flash movie (see Flashblock).');
					break;
				case 'empty': // Oh oh, wrong path
					alert('A required file was not found, please be patient and we fix this.');
					break;
				case 'flash': // no flash 9+ :(
					alert('To enable the embedded uploader, install the latest Adobe Flash plugin.')
			}
		}
		
	});
	
});
		//]]>
		// function to delete the row  from database ad well
	function deleteImageDatabaseRow(rowId, imageId){		
			
			if(confirm("Are you sure you want to delete this image?")){
				jQuery.post(BASEURL+"index.php?module=ajax&event=deteteProductImage", {product_image_id: ""+imageId+""}, function(data){
																																 jQuery('#tr-image_'+rowId).remove();
					
				});
			}
			
			
	}
{/literal}
	</script>

<div id="img_error"></div>
<fieldset id="image-fallback">
<input type="file" name="Filedata" />
</fieldset>
<div id="image-status" class="hide" style="margin-bottom:20px; float:right">
  <div  id="browse_link">
    <div> &nbsp;<a id="image-browser" href="javascript:;" style="float:left">Select images</a>&nbsp;
      <div style=" float:left" id="upload_clear">&nbsp; | &nbsp;<a id="list-clear" href="javascript:;">Clear</a> </div>
    </div>
    <div class="clear"></div>
  </div>
  <div> <strong class="overall-title"></strong><br />
    <img src="{$BASE_URL}assets/multiupload/progress-bar/bar.gif" class="progress overall-progress" /> </div>
  <div> <strong class="current-title"></strong><br />
    <img src="{$BASE_URL}assets/multiupload/progress-bar/bar.gif" class="progress current-progress" /> </div>
  <div class="current-text"></div>
</div>
<table id="animalImage" border="0"  style="width:95%; text-align:left; clear:both" cellpadding="0" cellspacing="0" align="center">
  <tr><th width="20%" align="center"  >&nbsp;</th>
    <th width="20%" align="center">Base Image </th>
   
    <th width="20%"  align="center">Delete   </th>
  <tbody>
 

  {if $animalImagesArray|@count>0}
  
  {foreach from=$animalImagesArray key=im item=imageDataArr}
  
  <tr id="tr-image_{$im}">
  <td align="center">
  <img src="{$SITE_URL}media/pet-photos/thumb/{$imageDataArr.imageName}">
  <input type="hidden" value="{$imageDataArr.imageName}" name="animalImages[]" id="imgId_{$im}">
  </td>
  <td align="center"><input type="radio" value="{$imageDataArr.imageName}" name="baseImage" {if $imageDataArr.imageType == 'base' } checked="checked" > {/if}</td>
  
  
  <td align="center"><img onclick="deleteImageDatabaseRow({$im}, {$imageDataArr.id})" src="assets/images/close.png" class="delete"></td>
  </tr>
  
 
  {/foreach}
  {/if}
  </tbody>
</table>
<ul id="upload-list">
</ul>
