<?php

/**
 * Class Content
 * @created by Arun Kumar
 * Created On  01-12-2011
 * Last modified 01-12-2011
 */

class Actioneventtype extends Backend{

	var $_table ="tbl_ca_action_event_type";
	var $_keyId="id";  //Primary Key
	var $_statusField="status";
	var $_section="Action Event Type";  //Primary Key


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
		
		$search = "select tbl_ca_action_event_type.*,  if(tbl_ca_action_event_type.status ='1','<font color=\'#e07503\'>active</font>','Inactive') as chr_status from ".$this->_table." ";
		
		$search .= " where 1='1' ";
		
			
		$this->tabHeading[]=array("title" =>"Action Event Type",
										  "coloum" =>"name",
										  "sortby" =>"name",
										  "search"=> array('name'=>'name',
										  					'type'=>'text' )
										  );
		
		
										
		$this->tabHeading[]=array("title" =>"Status",
										  "coloum" =>"chr_status",
										  "sortby" =>"chr_status",
										  "search"=> array('name'=>'status',
										  					'type'=>'select',
															"values"=>$this->getStatus() )
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
			$this->validData[]=array("feild_code" =>"name",
									 "feild_type" =>"text",
									 "is_required" =>"",
									 "feild_label" =>"Action Event Type",
									 );
									 
			 
			$this->validData[]=array("feild_code" =>"status",
									 "feild_type" =>"select",
									 "is_required" =>"",
									 "feild_label" =>"Status",
									 "model" =>$this->getStatus(),
									 );
									 
									
									 
			
			//------------------------------------------------------------//
		
	
			
		  
			
	}
	 protected function view(){
			$this->_title="View ".$this->_section;
	 		$this->id= $_GET['id'];		
			$this->sql= "select tbl_ca_action_event_type.*, if(tbl_ca_action_event_type.status ='1','<font color=\'#e07503\'>active</font>','Inactive') as chr_status from ".$this->_table." where  tbl_ca_action_event_type.".$this->_keyId."='".$this->id."'";
			$this->viewData = $this->db->getResult($this->sql);
			//print_r($this->viewData);
			//$this->viewFeilds("Display On","websiteName");
			$this->viewFeilds("Action Event Type","name");
			
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
				
						
				
					
						$_POST['dob']=date("Y-m-d h:m:s",strtotime($_POST['dob']));
						$this->saveRecord();
			
						header("location:".$this->baseUrl."index.php?module=".strtolower(get_class())); 
						exit;	
				
				}
			}
			
			$this->makeAddForm();
	}
	protected function edit(){
					
			$this->_title="Edit ".$this->_section;
			$this->smarty->assign("title",$this->_title);			
			$edit=$this->db->getResult("select * from ".$this->_table." where ".$this->_keyId."=".$_GET['id']);					
			//$edit['dob']=date("d-F-Y",strtotime($edit['dob']));
			$this->smarty->assign("postData",$edit);
			$this->addFeilds(1);
			
			if(isset($_POST['submit'])){
			
				if($this->validatPost()){
							
							//$_POST['dob']=date("Y-m-d h:m:s",strtotime($_POST['dob']));
								$this->updateRecord();						
							header("location:".$this->baseUrl."index.php?module=".strtolower(get_class())); 
							exit;
					
				}
			}
			$this->makeEditForm();
	}

}

?>