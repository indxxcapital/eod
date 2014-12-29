<?php

/**
 * Class Content
 * @created by Arun Kumar
 * Created On  01-12-2011
 * Last modified 01-12-2011
 */

class Bankholidays extends Backend{

	var $_table ="tbl_bankholidays";
	var $_keyId="id";  //Primary Key
	var $_statusField="status";
	var $_section="bankholidays";  //Primary Key


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
		
		$search = "select tbl_bankholidays.*,  if(tbl_bankholidays.status ='1','<font color=\'#e07503\'>active</font>','Inactive') as chr_status ,if(tbl_bankholidays.groups ='1','Group-A','Group-B') as chr_group from ".$this->_table." ";
		
		$search .= " where 1='1' ";
		
	
									 			
		$this->tabHeading[]=array("title" =>"Name",
										  "coloum" =>"name",
										  "sortby" =>"name",
										  "search"=> array('name'=>'name',
										  					'type'=>'text' )
										  );
										  
		$this->tabHeading[]=array("title" =>"Date",
										  "coloum" =>"ondate",
										  "sortby" =>"ondate",
										  "search"=> array('name'=>'ondate',
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
									 "is_required" =>"1",
									 "feild_label" =>"Name",
									 );
									 
			$this->validData[]=array("feild_code" =>"ondate",
									 "feild_type" =>"date",
									 "is_required" =>"1",
									 "feild_label" =>"Date",
									 );
			
													 
			$this->validData[]=array("feild_code" =>"groups",
									 "feild_type" =>"multiselect",
									 "is_required" =>"",
									 "feild_label" =>"Group",
									 "model" =>array("1"=>"Group-A","0"=>"Group-B"),
									 );
									 								
									 
			$this->validData[]=array("feild_code" =>"status",
									 "feild_type" =>"select",
									 "is_required" =>"0",
									 "feild_label" =>"status",
									 "model" =>$this->getStatus(),
									 );
									 
									
									 
			
			//------------------------------------------------------------//
		
	
			
		  
			
	}
	 protected function view(){
			$this->_title="View ".$this->_section;
	 		$this->id= $_GET['id'];		
			$this->sql= "select tbl_bankholidays.*, if(tbl_bankholidays.status ='1','<font color=\'#e07503\'>active</font>','Inactive') as chr_status from ".$this->_table." where  tbl_bankholidays.".$this->_keyId."='".$this->id."'";
			$this->viewData = $this->db->getResult($this->sql);
			//print_r($this->viewData);
			//$this->viewFeilds("Display On","websiteName");
			$this->viewFeilds("Name","name");
			$this->viewFeilds("Date","ondate");
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
				
						$_POST['ondate']=date("Y-m-d",strtotime($_POST['ondate']));
				$_POST['groups']=implode(",",$_POST['groups']);
					
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
			$this->smarty->assign("postData",$edit);
			$this->addFeilds(1);
			
			if(isset($_POST['submit'])){
			
				if($this->validatPost()){
									$_POST['ondate']=date("Y-m-d",strtotime($_POST['ondate']));
				$_POST['groups']=implode(",",$_POST['groups']);
							$this->updateRecord();						
							header("location:".$this->baseUrl."index.php?module=".strtolower(get_class())); 
							exit;
					
				}
			}
			$this->makeEditForm();
	}

}

?>