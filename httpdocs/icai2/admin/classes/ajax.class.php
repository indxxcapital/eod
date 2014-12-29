<?php 

class Ajax extends Backend{


	function __construct()
	{
//		 	$this->checkAdminSession();
			
	}
	
	
	
	// function to delete the Animal image data
	public function deteteAnimalImage(){
		$animal_image_id = $_POST['animal_image_id'];
		
		
		if(!empty($animal_image_id) ){ // remove the data
			$data = $this->db->getResult("select id, imageName from tbl_animal_images where id= ".$animal_image_id );
			if(is_array($data) ){
					
				$this->db->query("delete from tbl_animal_images where id='".$animal_image_id."' ");
				
				@unlink($this->siteconfig->base_path.'media/pet-photos/images/thumb/'.$data['imageName']);
				@unlink($this->siteconfig->base_path.'media/pet-photos/orignal/'.$data['imageName']);
				@unlink($this->siteconfig->base_path.'media/pet-photos/petoftheday/'.$data['imageName']);
				@unlink($this->siteconfig->base_path.'media/pet-photos/search/'.$data['imageName']);
				@unlink($this->siteconfig->base_path.'media/pet-photos/profile/'.$data['imageName']);
			
			}
			return  'yes';
		}else{
			return false;
		}
	}
	
	
	
	
	
	function GetCities()
	{

		$query	=	$this->db->getResult("select id,name as value from tbl_cities where status = '1' and stateID = '".$_GET['value']."' order by name ASC",true);
	
		$html= $this->makeOptions($query,$_GET['current']);
		if($_GET['objectID']!="")
			{	
				$html.="<option value='otherOption'>Other</option>";
			}
		echo json_encode(array("html"=>$html));	
	
	}
	
			function GetStates()
	{
		$query	=	$this->db->getResult("select id,name as value from tbl_states where status = '1' and countryID = '".$_GET['value']."' order by name ASC",true);
		
		 	 
			$html= $this->makeOptions($query,$_GET['current']);
			
			if($_GET['objectID']!="")
			{	
				$html.="<option value='otherOption'>Other</option>";
			}
			
			echo json_encode(array("html"=>$html));	
		 
		
		
	}
	function GetBreed($pettype_id = '')
	{ 
	
	$sql="select id, breed_name as value  from tbl_breed  where status='1'  ";
	
	$sql.="  and pettype_id ='".$_GET['value']."'";
	
	 $sql.=" order by breed_name ASC";
	 	$query	=	$this->db->getResult($sql,true);	
		
		$html= $this->makeOptions($query,$_GET['current']);
				
				
		 
		echo json_encode(array("html"=>$html));	
	}
		/*---------------------------------------added on 15 nov---------------------------------------------------------------------*/
		
		
		function GetPets()
		{
			 
			$query	=	$this->db->getResult("select id,pet_name as value from tbl_pets where status = '1' 
											 and user_id = '".$_GET['value']."' order by value ASC",true);
		
				$html= $this->makeOptions($query,$_GET['current']);
				echo json_encode(array("html"=>$html));	
			
		}
		
		function GetAlbum()
		{
	//echo "select id, album_name as value from tbl_petalbum where status = '1' and pet_id = '".$_GET['value']."' order by value ASC";
			$query	=$this->db->getResult("select id, album_name as value from tbl_petalbum where status = '1' and pet_id = '".$_GET['value']."' order by value ASC",true);
		
			$html= $this->makeOptions($query,$_GET['current']);
			
			echo json_encode(array("html"=>$html));	
		
		}
		function Getareas()
		{
	//echo "select id, album_name as value from tbl_petalbum where status = '1' and pet_id = '".$_GET['value']."' order by value ASC";
			$query	=$this->db->getResult("select id, name as value from tbl_area where status = '1' and city = '".$_GET['value']."' order by name ASC",true);
		
			$html= $this->makeOptions($query,$_GET['current']);
			
			echo json_encode(array("html"=>$html));	
		
		}
		
	/*---------------------------------------added on 15 nov---------------------------------------------------------------------*/	
		
		
		
		
	function multiUpload()
	{
	$filetype=$_GET['filetype'];
	if(!empty($_FILES['Filedata']['tmp_name']) ){ // upload file
		
		
						

						//#### upload brand file
						$upload = "";			
						$upload['file'] = 'Filedata';
						$upload['type'] = 'image';
						$upload['createThumb'] = '1';
						$upload['w'] = $_GET['imgwith'];
						$upload['h'] = $_GET['imgheight'];
						
						$upload['folder'] = $filetype;
						$upload['crop']= 't';								
						$imageUpload = $this->upload($upload);					
						 
						$info = @getimagesize($_FILES['Filedata']['tmp_name']);
						$return = array(
							'status' => '1',
							'name' =>  $imageUpload['name'],
							'imageUrl' =>  $this->siteconfig->site_url."media/".$upload['folder']."/thumb/".$imageUpload['name']
						);
						////////////////////////////////////
						       		$upload2="";
						            $upload2['src'] = $this->siteconfig->base_path."media/".$upload['folder']."/orignal/".$imageUpload['name'];
									$upload2['type'] = 'image';
									$upload2['resize']=1;
									$upload2['crop']="t";
						            $upload2['w'] = '649';
									$upload2['h'] = '335';
									$upload2['thumb_name'] = 'profile';
									$upload2['folder'] = $upload['folder'];
									$imageUpload_new = $this->newUpload($upload2);
									
									$upload2['w'] = '241';
									$upload2['h'] = '245';
									$upload2['thumb_name'] = 'petoftheday';
									$imageUpload_new = $this->newUpload($upload2);
									
									$upload2['w'] = '172';
									$upload2['h'] = '122';
									$upload2['thumb_name'] = 'search';
									$imageUpload_new = $this->newUpload($upload2);
									
									$upload2['w'] = '74';
									$upload2['h'] = '46';
									$upload2['thumb_name'] = 'small';
									$imageUpload_new = $this->newUpload($upload2);
									$upload2['w'] = '143';
									$upload2['h'] = '143';
									$upload2['thumb_name'] = 'albumRegularPet';
									$imageUpload_new = $this->newUpload($upload2);
									$upload2['w'] = '48';
									$upload2['h'] = '45';
									$upload2['thumb_name'] = 'albumRegularPet';
									$imageUpload_new = $this->newUpload($upload2);
						if ($info) {
							$return['width'] = $info[0];
							$return['height'] = $info[1];
							$return['mime'] = $info['mime'];
						}
						
						
						if (isset($_REQUEST['response']) && $_REQUEST['response'] == 'xml') {
						// header('Content-type: text/xml');
						
						// Really dirty, use DOM and CDATA section!
						echo '<response>';
						foreach ($return as $key => $value) {
						echo "<$key><![CDATA[$value]]></$key>";
						}
						echo '</response>';
						} else {
						// header('Content-type: application/json');
						
						echo json_encode($return);
						}
							
				}	
	
	
	}
	
	public function userName(){
	
	 	$users =$this->db->getResult("SELECT id,username,user_fname,user_lname from tbl_user where username like '%".$_GET['input']."%' order by username     " , true);		 
		$stIdArr = array();
		$stNameArr = array();
		$stCodeArr = array();
		if($users){			
			foreach($users as $user){
			
				array_push($stIdArr, $user['id']);	
				$name = '';			
				$name = $user['username']." (".ucfirst(strtolower($user['user_fname']." ".$user['user_lname'])).")";			
				array_push($stNameArr, $name);	
			}
		}	
	
		$input = strtolower($_GET['input'] );
		$len = strlen($input);
		
		$aResults = array();
		
		if ($len)
		{
			for ($i=0;$i<count($stNameArr);$i++)
			{
				//if (strtolower(substr(utf8_decode($stNameArr[$i]),0,$len)) == $input)
					$aResults[] = array( "id"=>($i+1) ,"value"=>htmlspecialchars($stNameArr[$i]), "info"=>htmlspecialchars($stIdArr[$i]), "type"=>htmlspecialchars($stCodeArr[$i]) );
			}
		}

	 
	 
		header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
		header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
		header ("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
		header ("Pragma: no-cache"); // HTTP/1.0
	
	
		header("Content-Type: application/json");
	
		echo "{\"results\": [";
		$arr = array();
		for ($i=0;$i<count($aResults);$i++)
		{
			$arr[] = "{\"id\": \"".$aResults[$i]['info']."\", \"value\": \"".$aResults[$i]['value']."\"}";
		}
		echo implode(", ", $arr);
		echo "]}";


}
	function downloadFile()
	{
		
		$this->checkAdminSession();
		
		 $file_path = $_GET['file'];
		 $file_type = $_GET['type'];
		 $folder_path = $_GET['folder'] ;
		 
		 
		$filename = $this->siteconfig->base_path."media/".$folder_path."/".$file_path; //server specific
		 
 
		  
		  if(!file_exists($filename) || $file_path=="")
		  {
					die("Sorry you have requested a invalid file");
		  }
 	 

  				header("Pragma: public"); // required
				header("Expires: 0");
				header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
				header("Cache-Control: private",false); // required for certain browsers
				header("Content-Type: application/force-download");
				header("Content-Disposition: attachment; filename=".basename($file_path).";" );
				header("Content-Transfer-Encoding: binary");
				header("Content-Length: ".@filesize($filename));
				@readfile("$filename") or die("File not found.");
				exit();
			
	}
}
?>
