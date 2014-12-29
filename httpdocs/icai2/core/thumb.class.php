<?php
	/**
	* Image Component
	* 
	*
	* PHP versions 5.1.4
	* @filesource
	
	*/

 class Thumb  {
	/**
	* If set to true new image will be saved to a  file
	* @access var
	*/
	var $save_to_file = true;
	/**
	* Quality for jpeg and png
	* @access var
	*/
	var $image_quality = 100;
	/**
	* Resulting image type
	* @access var
	*/
	var $image_type = 0;
	/**
	* Maximum Image size
	* @access var
	*/
	var $max_x = 100;
	var $max_y = 100;
	/**
	* Image folder
	* @access var
	*/
	var $image_folder = 'img';
	/**
	* Thumb image folder
	* @access var
	*/
	var $thumb_folder ='';
	/**
	* image resource
	* @access var
	*/
	var $img_res  =NULL;


	
	
	function getResized($id, &$mime, $imgFolder, $newWidth=false, $newHeight=false, $bgcolor="#F8B031", $resample=true, $cache=false, $cacheFolder=false, $cacheClear=false, $tempFolder=false)
	{
	
		$img = $imgFolder . $id;
		list($oldWidth, $oldHeight, $type) = getimagesize($img); 
		$ext = $this->image_type_to_extension($type);
		$mime = image_type_to_mime_type($type);

		if ($cache AND is_writeable($cacheFolder))
		{
			$dest = $cacheFolder . $id;
			//. '_' . $newWidth . 'x' . $newHeight;
		}
		else if (is_writeable($tempFolder))
		{
			$dest = $tempFolder . $id;
		}
		else
		{
			echo "You must set either a cache folder or temporal folder for image processing. And the folder has to be writable.";
			exit();
		}
		
		if ($newWidth OR $newHeight)
		{
			if($cacheClear && file_exists($dest))
			{	
				unlink($dest);
			}
			
			
			
				if(($newWidth > $oldWidth) && ($newHeight > $oldHeight)) 
				{
					$applyWidth = $oldWidth;
					$applyHeight = $oldHeight;
				} 
				else
				{
					if(($newWidth/$newHeight) < ($oldWidth/$oldHeight)) 
					{
						$applyHeight = $newWidth*$oldHeight/$oldWidth;
						$applyWidth = $newWidth;
					} 
					else
					{
						$applyWidth = $newHeight*$oldWidth/$oldHeight;
						$applyHeight = $newHeight;
					}
				}
				
				switch($ext)
				{
					case 'gif' :
						$oldImage = imagecreatefromgif($img);
						//$newImage = imagecreate($newWidth, $newHeight);
						$newImage = imagecreatetruecolor($newWidth, $newHeight);
						break;
					case 'png' :
						$oldImage = imagecreatefrompng($img);
						$newImage = imagecreatetruecolor($newWidth, $newHeight);
						break;
					case 'jpg' :
						$oldImage = imagecreatefromjpeg($img);
						$newImage = imagecreatetruecolor($newWidth, $newHeight);
						break;
					case 'jpeg' :
						$oldImage = imagecreatefromjpeg($img);
						$newImage = imagecreatetruecolor($newWidth, $newHeight);
						break;
					default :
						return false;
						break;
				}
				$red	=	15;
				$green	=	117;
				$blue	=	188;
				sscanf($bgcolor, "%2x%2x%2x", $red, $green, $blue);
				$newColor = ImageColorAllocate($newImage, $red, $green, $blue); 
				imagefill($newImage,0,0,$newColor);
				
				if ($resample==true)
				{
					
					imagecopyresampled($newImage, $oldImage, ($newWidth-$applyWidth)/2, ($newHeight-$applyHeight)/2, 0, 0, $applyWidth, $applyHeight, $oldWidth, $oldHeight);
				}
				else
				{
					//echo $newImage;
					//echo  $oldImage;
					imagecopyresized($newImage, $oldImage, ($newWidth-$applyWidth)/2, ($newHeight-$applyHeight)/2, 0, 0, $applyWidth, $applyHeight, $oldWidth, $oldHeight);
				}
	//die;
				
					switch($ext)
					{
						case 'gif' :
							//imagegif($newImage, $dest);
						imagepng($newImage, $dest);
							break;
						case 'png' :
							imagepng($newImage, $dest);
							break;
						case 'jpg' :
							imagejpeg($newImage, $dest);
							break;
						case 'jpeg' :
							imagejpeg($newImage, $dest);
							break;
						default :
							return false;
							break;
					}
				
		}
		else
		{
			
		}
		
		
	}

	
	function image_type_to_extension($imagetype)
	{
	if(empty($imagetype)) return false;
		switch($imagetype)
		{
			case IMAGETYPE_GIF    : return 'gif';
			case IMAGETYPE_JPEG    : return 'jpg';
			case IMAGETYPE_PNG    : return 'png';
			case IMAGETYPE_SWF    : return 'swf';
			case IMAGETYPE_PSD    : return 'psd';
			case IMAGETYPE_BMP    : return 'bmp';
			case IMAGETYPE_TIFF_II : return 'tiff';
			case IMAGETYPE_TIFF_MM : return 'tiff';
			case IMAGETYPE_JPC    : return 'jpc';
			case IMAGETYPE_JP2    : return 'jp2';
			case IMAGETYPE_JPX    : return 'jpf';
			case IMAGETYPE_JB2    : return 'jb2';
			case IMAGETYPE_SWC    : return 'swc';
			case IMAGETYPE_IFF    : return 'aiff';
			case IMAGETYPE_WBMP    : return 'wbmp';
			case IMAGETYPE_XBM    : return 'xbm';
			default                : return false;
		}
	}
	
	
//EXPLANATION OF PARAMETERS For:getResized
/*
$id, String with name of the image file. Example: myphoto.jpg, 33.gif, file0000, etc... The file is analysed for image headers, so file extensions are not important)

&$mime, Var thats passed as a reference, the function assigns the mime type to it, so the view can output the header.

$imgFolder, String with the complete path to the image file. 

$newWidth=false, New width, in pixels, of the image... if none is passed, then the image is rendered at the original size.

$newHeight=false, New height, in pixels, of the image... if none is passed, then the image is rendered at the original size.

$bgcolor="000000", hexadecimal color for the background of the image. This shows when you resize an image to a new proportion. Instead of distortion, bars with this color are rendered. If the var is ommited, black bars are rendered

$resample=true, Boolean for resampling the image when resizing, if set to false image is resized without interpolating pixels, While this uses less computing resources, the visual result is poor.

$cache=false, If set true, a file is written for each resizing job, so in case its called twice, the saved files is passed, avoiding a repeated computing job.

$cacheFolder=false, The folder where cached files should be written, must be writable.

$cacheClear=false, If set true, the function will delete the cached image and write a new one. Useful for administration backends.

$tempFolder=false, in case cache is set false, a temporal folder is required for rendered images, i havent coded yet the function that cleans the temporal folder.
)
*/	
 }