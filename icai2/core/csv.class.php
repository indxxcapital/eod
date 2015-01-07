<?php
 
class csv
{
	static function export($list,$filename="data.csv") {

		if(!empty($list['data']))
		{
			if(!empty($list['heading']) )
			{
					print '"' . stripslashes(implode('","',$list['heading'])) . "\"\n";	
					
			}
			else
			{
					
					print '"' . stripslashes(implode('","',array_keys($list['data'][0]))) . "\"\n";	
			}
		
		 	header("Content-type:text/octect-stream");
		 	header("Content-Disposition:attachment;filename=".$filename);
			foreach($list['data'] as $data)
			{
				print '"' . stripslashes(implode('","',$data)) . "\"\n";
			}
			exit;
		}
		return;
	}

//Import the contents of a CSV file after uploading it
//http://www.bin-co.com/php/scripts/csv_import_export/
//Aruguments : $table - The name of the table the data must be imported to
//                $fields - An array of fields that will be used
//                $csv_fieldname - The name of the CSV file field
static	function import($fields, $csv_fieldname='csv') 
{
 $fileData = @filesize($csv_fieldname);

		if(!file_exists($csv_fieldname))return false;
		$handle = fopen($csv_fieldname,'r');
		
		if(!$handle) return false;
 
		while (($data = fgetcsv($handle, $fileData, ",")) !== FALSE) {
			if($row_count>0)
			{
				foreach($data as $key=>$value) {
					$data1[$fields[$key]] =  addslashes($value);
				}
					
				$returnData[]=$data1;
			}
			$row_count++; 
		}
	 
		fclose($handle);
		//exit;
	 	return $returnData;
	} 


} 

?>