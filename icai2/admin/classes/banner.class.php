<?php

/**
 * Class Content
 * @created by Arun Kumar
 * Created On  01-12-2011
 * Last modified 01-12-2011
 */

class banner extends Backend{

	var $_table ="tbl_banner";
	var $_keyId="id";  //Primary Key
	var $_statusField="status";
	var $_section="banner";  //Primary Key


	function __construct()
	{
	
	 	$this->checkAdminSession();
		//$this->gridItemDiabled['add'] = false;
		//$this->gridItemDiabled['status'] = false;
		//$this->gridItemDiabled['delete'] = false;
		
	}
	
	
	
	function index()
	{
		
		$this->_title="Manage ".$this->_section;			
		
		$search = "select tbl_banner.*,  if(tbl_banner.status ='1','<font color=\'#e07503\'>active</font>','Inactive') as chr_status from ".$this->_table." ";
		
		$search .= " where 1='1' ";
		
		
		$this->tabHeading[]=array("title" =>"title",
										  "coloum" =>"title",
										  "sortby" =>"title",
										  "search"=> array('name'=>'title',
										  					'type'=>'text' )
										  );
	
		
										
										$this->tabHeading[]=array("title" =>"status",
										  "coloum" =>"chr_status",
										  "sortby" =>"chr_status",
										  "search"=> array('name'=>'status',
										  					'type'=>'select',
															"values"=>$this->getStatus() )
										);
										  
		$this->tabHeading[]=array("title" =>"Last Update On",
										  "coloum" =>"dateUpdated",
										  "sortby" =>"dateUpdated",
										  									  
										  );		
										  		 			
		if(count($_GET['searchFeilds'])>0)
		{		
			foreach($_GET['searchFeilds'] as $key => $value)
			{
				if($value!="" && $this->in_array_search($key,$this->tabHeading))
				{
						if($key=="owner")
						{
								$search.=" and (var_lname like '%".$value."%' or var_fname like '%".$value."%')";
						}
						else
						{
							$search.=" and ".$key." like '%".$value."%'";
						}
				}
			
			}
		}
		$this->sql = $search; //  fetch the records 		
	 	$this->makeGrid();
		$this->show(); 
	}
	
	
	private function addFeilds($edit="")
	{
		
		//----------------------contect Name----------------------------//
			$this->validData[]=array("feild_code" =>"title",
									 "feild_type" =>"text",
									 "is_required" =>"1",
									 "feild_label" =>"title",
									 );
			
			
			$this->validData[]=array("feild_code" =>"image",
									 "feild_type" =>"file",
									 "is_required" =>"2",
									 "feild_label" =>"image",
									 "validate" =>"file|jpg,jpeg,gif,png",
									 );
									
									
									 
			$this->validData[]=array("feild_code" =>"status",
									 "feild_type" =>"select",
									 "is_required" =>"1",
									 "feild_label" =>"status",
									 "model" =>$this->getStatus(),
									 );
									 
									
									 
			
			//------------------------------------------------------------//
		
	
			
		  
			
	}
	 protected function view(){
			$this->_title="View".$this->_section;
	 		$this->id= $_GET['id'];		
			$this->sql= "select tbl_banner.*, if(tbl_banner.status ='1','<font color=\'#e07503\'>active</font>','Inactive') as chr_status from ".$this->_table." where  tbl_banner.".$this->_keyId."='".$this->id."'";
			$this->viewData = $this->db->getResult($this->sql);
			//print_r($this->viewData);
			//$this->viewFeilds("Display On","websiteName");
			$this->viewFeilds("title","title");
			$this->viewFeilds("Status","status");
			
			
			$this->addButtons("Edit","index.php?module=".strtolower(get_class())."&event=edit&id=".$this->viewData['id']);	  		
			$this->makeView();	
	}
	
	protected function addNew(){
					
			$this->_title="Add  ".$this->_section;
			$this->smarty->assign("title",$this->_title);			
			$this->addFeilds();
			
			if(isset($_POST['submit'])){
				//echo "<pre>";print_r($_POST);die;
				if($this->validatPost()){
					if($this->checkcontectlink()){
						
							
				    $upload['file'] = 'image';
					$upload['type'] = 'image';
					$upload['folder'] = 'banner';
					$upload['createThumb'] = '1';
					$upload['w'] = '80';
					$upload['h'] = '64';
					$upload['crop']= 'true';
					$imageUpload = $this->upload($upload); 
			        $_POST['image']=$imageUpload['name'];
					
					
					 {
						 $destPath = $this->siteconfig->base_path."media/banner/";
					//	$_POST['image']=$imageUpload['name'];
						$this->objThumb = new Thumb();
						$fileName = $_POST['image'];	
						$upload2="";
						            $upload2['src'] = $this->siteconfig->base_path."media/banner/orignal/".$imageUpload['name'];
									$upload2['type'] = 'image';
									$upload2['resize']=1;
									$upload2['crop']="false";
									$upload2['folder'] = 'newbanner';
									
									
						            $upload2['w'] = '200';
									$upload2['h'] = '150';
									$upload2['thumb_name'] = 'mybanner';
									$imageUpload_new = $this->newUpload($upload2);
			         }
						//$_POST['dateUpdated']=date("Y-m-d h:i:s");
						$this->saveRecord();
						header("location:".$this->baseUrl."index.php?module=".strtolower(get_class())); 
						exit;	
					}
				}
			}
			
			$this->makeAddForm();
	}
	protected function edit(){
					
			$this->_title="Edit ".$this->_section;
			$this->smarty->assign("title",$this->_title);			
			$edit=$this->db->getResult("select * from ".$this->_table." where ".$this->_keyId."=".$_GET['id']);					
			$this->smarty->assign("postData",$edit);
			$this->addFeilds(1);
			
			if(isset($_POST['submit'])){
			
				if($this->validatPost()){
					if($this->checkcontectlink()){
					 	//$_POST['dateUpdated']=date("Y-m-d h:i:s");		
							$this->updateRecord();						
							header("location:".$this->baseUrl."index.php?module=".strtolower(get_class())); 
							exit;
					}
				}
			}
			$this->makeEditForm();
	}
	// function to check the existing linkid 
	private function checkcontectlink(){
	
	   $sql="select * from ".$this->_table." where linkId = '".trim($_POST['linkId'])."' ";
	if($_GET['id']<>"")
	{
		$sql.=" and id!='".$_GET['id']."'";
		
	}
	
		$this->db->getResult($sql);		
		if($this->db->mysqlrows>0)
		{ 
			$error['type']= "error";
			$error['msg'] ="Link id already exists, Please enter another";
			$this->smarty->assign("AdminMessage",$error);			 
			$this->smarty->assign("postData",$_POST);
			return false;
		}
		else
		{
			return true;
		}	
		
	
	}
}

?>