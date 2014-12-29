<?php 

class Ajax extends Application{
		
		function __construct()
		{
			parent::__construct();
	
		}
		
	
		function statecityname()
		{	
			if($_GET['fname'] == 'GetCities'){
			$query	=	$this->db->getResult("select id,name as value,countryID from tbl_states where id = '".$_GET['current']."' and countryID !=10",	true);
			if(($query[0]['value']) && ($query[0]['countryID'] !=10)){
			echo json_encode(array("name"=>$query[0]['value']));
			
			}else{
				echo json_encode(array("name"=>''));
			}
			}else{
			$query	=	$this->db->getResult("select c.id,c.name as value,s.countryID from tbl_cities c LEFT JOIN tbl_states s ON c.stateID = s.id where c.id = '".$_GET['current']."'",	true);
	 
				if($query[0]['countryID'] ==10){
					echo json_encode(array("name"=>''));
				}else{
					echo json_encode(array("name"=>$query[0]['value']));
				}
			}
			
		}
		function GetStates()
		{
			 
			$query	=	$this->db->getResult("select id,name as value from tbl_states where countryID = '".$_GET['value']."' order by name ASC",true);
				$html= $this->makeOptions($query,$_GET['current']);
				
				if($_GET['objectID']!="")
				{	
					$html.="<option value='otherOption'>Other</option>";
				}
		 
				echo json_encode(array("html"=>$html));	
			
		}
		
		function GetCities()
		{
			if($_GET['value'])
			{$query	=	$this->db->getResult("select id,name as value from tbl_cities where  stateID = '".$_GET['value']."' order by name ASC",true);
		
			$html= $this->makeOptions($query,$_GET['current']);
			if($_GET['objectID']!="")
				{	
					$html.="<option value='otherOption'>Other</option>";
				}
			}
			echo json_encode(array("html"=>$html));	
		
		}
		
function getmoreproperty()
{
	
	$id=0;
	$query="SELECT p.*, s.statename as statename,c.cityname as cityname,a.areaname as areaname,pb.name as powerbackupname FROM tbl_property p
		left  join  tbl_states s on  s.id=p.state
		left  join tbl_cities c on c.id=p.city
		left  join  tbl_areas a on a.id=p.locality
		left join  tbl_powerbackup pb on pb.id =p.powerbackup
		 WHERE p.status='1' and p.id<".$_GET['id']." ORDER BY p.id desc";
		 
 
		$propertyData=$this->db->getResult($query,true,5);
	//	$news=$this->db->getResult($query,true,10);
if(!empty($propertyData))
{
foreach($propertyData as $property)
{
		$templateFormat = file_get_contents($this->siteconfig->base_path.'templates/property/more.tpl');
	$imagePath  = $this->siteconfig->base_url.'assets/images/';	
	$templateFormat		= str_replace( '{IMAGE_PATH}', $imagePath , $templateFormat);
	$templateFormat		= str_replace( '{$property.areaname}', $property['areaname'] ,$templateFormat);
$templateFormat		= str_replace( '{$property.cityname}', $property['cityname'] ,$templateFormat);
$templateFormat		= str_replace( '{$property.statename}', $property['statename'] ,$templateFormat);
$templateFormat		= str_replace( '{$property.society}', $property['society'] ,$templateFormat);
$templateFormat		= str_replace( '{$property.area}', $property['area'] ,$templateFormat);
$templateFormat		= str_replace( '{$property.areaunit}', $property['areaunit'] ,$templateFormat);
$templateFormat		= str_replace( '{$property.bedroom}', $property['bedroom'] ,$templateFormat);
$templateFormat		= str_replace( '{$property.bathroom}', $property['bathroom'] ,$templateFormat);
$templateFormat		= str_replace( '{$property.description|strip_tags:true|substr:0:300}', substr(strip_tags($property['description']),0,300) ,$templateFormat);
$templateFormat		= str_replace( '{$property.name}', $property['name'] ,$templateFormat);
$templateFormat		= str_replace( '{$property.phone}', $property['phone'] ,$templateFormat);
$templateFormat		= str_replace( '{$property.email}', $property['email'] ,$templateFormat);
$templateFormat		= str_replace( '{$property.price_per_unit}', $property['price_per_unit'] ,$templateFormat);
$templateFormat		= str_replace( '{$property.id}', $property['id'] ,$templateFormat);
$templateFormat		= str_replace( '{$property.powerbackupname}', $property['powerbackupname'] ,$templateFormat);
$templateFormat		= str_replace( '{$property.dateAdded}', $property['dateAdded'] ,$templateFormat);
if ($property['image'])
{
$templateFormat		= str_replace( '{$PROPERTY_IMAGE}',$this->siteconfig->base_url."media/property/thumb/".$property['image'],$templateFormat);
	}
else{
$templateFormat		= str_replace( '{$PROPERTY_IMAGE}', $imagePath."no-property.gif" ,$templateFormat);

}

	
	
echo $templateFormat;
$id=$property['id'];
}

echo '
<div id="more'.$id.'" class="morebox">
<a href="#" id="'.$id.'" class="more">more</a>
</div>
';


}

}
	
	
		function GetCity(){
		
			if($_GET['item'])
			{
				$query	=	$this->db->getResult("select id,cityname as value from  tbl_cities where  	stateid = '".$_GET['item']."' order by cityname ASC",true);
		
			$html= $this->makeOptions($query,$_GET['current']);
			if($_GET['objectID']!="")
				{	
					//$html.="<option value='otherOption'>Other</option>";
				}
			}
			echo json_encode(array("html"=>$html));	
		
		}
		
function Getarea(){


			if($_GET['item'])
			{
				//echo "select id,areaname as value from   tbl_areas where  	cityid = '".$_GET['item']."' order by areaname ASC";
				$query	=	$this->db->getResult("select id,areaname as value from   tbl_areas where  	cityid = '".$_GET['item']."' order by areaname ASC",true);
		
			$html= $this->makeOptions($query,$_GET['current']);
			if($_GET['objectID']!="")
				{	
					//$html.="<option value='otherOption'>Other</option>";
				}
			}
			echo json_encode(array("html"=>$html));	
		


}		
		
	
	
 
 
	
	
	
	
	
		
		
		
	
		
		function getAjaxYearList()
		{
			if(($_GET['value'] !='0000') && ($_GET['value'] !='')){
			 $end = $_GET['value'] + 30;
				$years = array();
				for($i=$_GET['value']; $i<$end; $i++)
					{
						 
						$years[$i]['value']=$i;
						$years[$i]['id']=$i;
					}
				
				
				$years = $this->makeOptions($years,$_GET['current']);
				echo json_encode(array("html"=>$years));
			}else{
				$years1 = array();
				$years1 = $this->makeOptions($years1,$_GET['current']);
				echo json_encode(array("html"=>$years1));
			}
			
		
		}
		
		function multiUpload()
		{
	
		
		if(!empty($_FILES['Filedata']['tmp_name']) ){ // upload file
					 $data =  file_get_contents(ini_get('session.save_path')."/"."sess_".$_GET['key']);
					 $_SESSION = array();
					 session_decode($data);
		
					$upload2='';
					$upload2['file'] = 'Filedata';
					$upload2['type'] = 'image';
					$upload2['folder'] = 'albums/'.$_REQUEST['item'];
					$upload2['resize'] = '1';
					$upload2['w'] = '126';
					$upload2['h'] = '109';
					$upload2['crop']= true;	
					$imageUpload = $this->upload($upload2);
					 
					$this->db->query("insert into tbl_photo set `user_id`='".$_SESSION['User']['UserID']."',name='',filename='".$imageUpload['name']."',albumId='".$_REQUEST['item']."'");
 			
						 
						$info = @getimagesize($_FILES['Filedata']['tmp_name']);
						$return = array(
							'status' => '1',
							'name' =>  $imageUpload['name'],
							'imageUrl' =>  $this->siteconfig->site_url."media/".$upload2['folder']."/thumb/".$imageUpload['name']
						);
						
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
		
		public function atr_number(){
	
	 	$users =$this->db->getResult("SELECT atr_number 	 from tbl_products where atr_number   like '%".$_GET['input']."%' order by atr_number     " , true);		 
		$stIdArr = array();
		$stNameArr = array();
		$stCodeArr = array();
		if($users){			
			foreach($users as $user){
			
				array_push($stIdArr, $user['id']);	
				$name = '';			
				$name = $user['atr_number'];			
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
	
	function selectearticalnumber()
	{
		$sql_pageData="select tbl_products.id,image ,atr_number,factory_id ,prtype_id,count,pack_id";
		
		$sql_pageData.="  from tbl_products   where tbl_products.atr_number   = '".$_GET['articalnumber']."'";
		
	$users =$this->db->getResult($sql_pageData , true);		
		
		$count= count($users);
		if($count>0)
		{
		$users=$users[0];

		echo $id=$users['id'];
		echo '__and__';
		echo $prtype_id=$users['prtype_id'];
			echo '__and__';
			echo $count=$users['count'];
				echo '__and__';
			echo $pack_id=$users['pack_id'];
				echo '__and__';
			echo $factory_id=$users['factory_id'];
			echo '__and__';
			echo $atr_number=$users['atr_number'];
			echo '__and__';
			echo $image=$users['image'];
		}
		else
		{
		echo $count;	
		}
	}
	function GetProductType()
	
	{
	
	  $lang=$_SESSION['lang'];
	
	if($lang=='es')
	{
		
		
		$sql_Data="select tbl_producttype.id as id , if(tbl_producttype.prtype_name_es!='',tbl_producttype.prtype_name_es ,tbl_producttype.prtype_name_en) as value   ";
	}
	elseif($lang=='de')
	{
		
		$sql_Data="select tbl_producttype.id as id , if(tbl_producttype.prtype_name_de !='',tbl_producttype.prtype_name_de,tbl_producttype.prtype_name_en) as value ";
	}
	elseif($lang=='fr')
	{
		
		$sql_Data="select tbl_producttype.id as id, if(tbl_producttype.prtype_name_fr !='',tbl_producttype.prtype_name_fr,tbl_producttype.prtype_name_en) as value ";
	}
	elseif($lang=='en')
	{
		
		$sql_Data="select tbl_producttype.id as id , tbl_producttype.prtype_name_en as value ";
	}
	
	$sql_Data.="   from  tbl_products left join tbl_producttype on tbl_producttype.id=tbl_products.prtype_id where  tbl_producttype.status='1' and tbl_products.status='1' and tbl_products.factory_id='".$_GET['value']."' group by  tbl_products.prtype_id   order by value ASC";
	
	 	$query	=	$this->db->getResult($sql_Data,true);	
		
		 $html= $this->makeOptions($query,$_GET['current']);
				
				
		 
				echo json_encode(array("html"=>$html));	
	}	
	function GetPackingType()
	
	{
	
	  $lang=$_SESSION['lang'];
	
	if($lang=='es')
	{
		
		
		$sql_Data="select tbl_pack.id as id , if(tbl_pack.pack_name_es!='',tbl_pack.pack_name_es ,tbl_pack.pack_name_en) as value   ";
	}
	elseif($lang=='de')
	{
		
		$sql_Data="select tbl_pack.id as id , if(tbl_pack.pack_name_de !='',tbl_pack.pack_name_de,tbl_pack.pack_name_en) as value ";
	}
	elseif($lang=='fr')
	{
		
		$sql_Data="select tbl_pack.id as id, if(tbl_pack.pack_name_fr !='',tbl_pack.pack_name_fr,tbl_pack.pack_name_en) as value ";
	}
	elseif($lang=='en')
	{
		
		$sql_Data="select tbl_pack.id as id , tbl_pack.pack_name_en as value ";
	}
	
	$sql_Data.="   from  tbl_products left join tbl_pack on tbl_pack.id=tbl_products.pack_id 	 where  tbl_pack.status='1' and tbl_products.status='1' and tbl_products.prtype_id='".$_GET['value']."' and tbl_products.factory_id='".$_GET['factory_id']."' group by  tbl_products.pack_id 	   order by value ASC";
	
	 	$query	=	$this->db->getResult($sql_Data,true);	
		
		 $html= $this->makeOptions($query,$_GET['current']);
				
				
		 
				echo json_encode(array("html"=>$html));	
	}
	function GetProductcount()
	
	{
	
	
		
		$sql_Data="select tbl_products.count as id , tbl_products.count as value ";
	
	
	$sql_Data.="   from  tbl_products 	 where  tbl_products.status='1' and tbl_products.pack_id='".$_GET['value']."' and tbl_products.prtype_id='".$_GET['prtype_id']."' and tbl_products.factory_id='".$_GET['factory_id']."' group by  tbl_products.count 	   order by value ASC";
	
	 	$query	=	$this->db->getResult($sql_Data,true);	
		
		 $html= $this->makeOptions($query,$_GET['current']);
				
				
		 
				echo json_encode(array("html"=>$html));	
	}
	function GetProductartical()
	
	{
	
	  $lang=$_SESSION['lang'];
	
	if($lang=='es')
	{
		
		
		$sql_Data="select tbl_products.id as id ,if(tbl_products.productName_es !='',tbl_products.productName_es,tbl_products.productName_en) as productName_en, concat(tbl_products.atr_number ,'(',productName_en,')') as value ";
	}
	elseif($lang=='de')
	{
		
			$sql_Data="select tbl_products.id as id ,if(tbl_products.productName_de !='',tbl_products.productName_de,tbl_products.productName_en) as productName_en, concat(tbl_products.atr_number ,'(',productName_en,')') as value ";
	}
	elseif($lang=='fr')
	{
		
		
		$sql_Data="select tbl_products.id as id ,if(tbl_products.productName_fr !='',tbl_products.productName_fr,tbl_products.productName_en) as productName_en, concat(tbl_products.atr_number ,'(',productName_en,')') as value ";
	}
	elseif($lang=='en')
	{
		
		$sql_Data="select tbl_products.id as id , concat(tbl_products.atr_number ,'(',tbl_products.	productName_en,')') as value ";
	}
	
	 $sql_Data.="   from  tbl_products 	 where   tbl_products.status='1' and tbl_products.count='".$_GET['value']."' and tbl_products.pack_id='".$_GET['pack_id']."' and tbl_products.prtype_id='".$_GET['prtype_id']."' and tbl_products.factory_id='".$_GET['factory_id']."'  	   order by value ASC";
	
	 	$query	=	$this->db->getResult($sql_Data,true);	
		
		 $html= $this->makeOptions($query,$_GET['current']);
				
				
		 
				echo json_encode(array("html"=>$html));	
	}
	function checklistcosignee()
	{
		
		$sql_pageData="select consignee_details";
		
		$sql_pageData.="  from tbl_order   where tbl_order.user_id   = '".$_SESSION['User']['UserID']."' order by id desc limit 0,1";
		
	$order =$this->db->getResult($sql_pageData , true);		
		
	echo $consignee_details=	$order[0]['consignee_details'];
	
		
	}
	
	
	public function getCartItemCount(){	
		
			$sessionId = session_id();	
			//echo "select sum(quantity) as total_items from tbl_cart where sessionId = '".$sessionId."'  ";
					
			$cartData = $this->db->getResult("select sum(quantity) as total_items from tbl_cart where sessionId = '".$sessionId."'  ");
			
			if(is_array($cartData)  && $cartData['total_items'] > 0){
				echo $cartData['total_items'];
			}else{
				echo '0';
			}
			
		}
		public function getCartPointCount(){	
		
			$sessionId = session_id();	
			//echo "select sum(quantity) as total_items from tbl_cart where sessionId = '".$sessionId."'  ";
					
			$cartData = $this->db->getResult("select sum(quantity*price) as total_points from tbl_cart where sessionId = '".$sessionId."'  ");
			
			if(is_array($cartData)  && $cartData['total_points'] > 0){
				echo $cartData['total_points'];
			}else{
				echo '0';
			}
			
		}
		function updatelinkurl()
		{
					
			$cartData = $this->db->getResult("select * from tbl_company ",true);
		if(!empty($cartData))
		{
		foreach($cartData as $value)
		{
		$linkurl= $this->getLinkUrl($value['name']." ".$value['id']);
		$this->db->query("UPDATE `tbl_company` SET `linkUrl` = '".$linkurl."' WHERE `id` = '".$value['id']."';");
		
		}
			}
		}
		
		
	}
?>