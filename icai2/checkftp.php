<form name="form1" method="post">FTP User Name :  <input type="text" name="filename" id="filename" /><input type="submit" name="submit" id="submit" value="Submit" /></form>


<?php
if($_POST['submit'])
{
	if(is_dir($_SERVER['DOCUMENT_ROOT'] ."/files/ca-output/".$_POST['filename']))
	{
		//echo $_POST['filename'];
		//exit;
		$file_handle = fopen($_SERVER['DOCUMENT_ROOT'] . '/files/ca-output/'.$_POST['filename'].'/testFile.txt', "w");
		$file_contents = "name:" . $_POST['filename'];
		
		if(fwrite($file_handle, $file_contents))
		{
			echo "File Written";	
		}
		else
		{
			echo "File Not Written";	
		}
		fclose($file_handle);
			
	}	
	else
	{
		echo "No Directory of ".$_POST['filename']." exists";
		exit;	
	}
}

?>