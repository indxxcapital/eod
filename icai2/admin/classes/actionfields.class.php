<?php

/**
 * Class Content
 * @created by Arun Kumar
 * Created On  01-12-2011
 * Last modified 01-12-2011
 */

class ActionFields extends Backend{

	var $_table ="tbl_ca_action_fields";
	var $_keyId="id";  //Primary Key
	var $_statusField="status";
	var $_section="Action Events";  //Primary Key


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
		
		$search = "select tbl_ca_action_fields.*,tbl_ca_subcategory.name as eventname,  if(tbl_ca_action_fields.status ='1','<font color=\'#e07503\'>active</font>','Inactive') as chr_status from ".$this->_table." left join tbl_ca_subcategory on tbl_ca_action_fields.action_id=tbl_ca_subcategory.id";
		
		$search .= " where 1='1' ";
		
		$this->tabHeading[]=array("title" =>"Event Name",
										  "coloum" =>"eventname",
										  "sortby" =>"eventname",
										  "search"=> array('name'=>'eventname',
										  					'type'=>'text' )
										  );
										  
		$this->tabHeading[]=array("title" =>"Field Name",
										  "coloum" =>"field_name",
										  "sortby" =>"field_name",
										  "search"=> array('name'=>'field_name',
										  					'type'=>'text' )
										  );
										  
	
		$this->tabHeading[]=array("title" =>"Definition",
										  "coloum" =>"definition",
										  "sortby" =>"definition",
										  "search"=> array('name'=>'definition',
										  					'type'=>'text' )
										  );
		
										  $this->tabHeading[]=array("title" =>"Standard Width",
										  "coloum" =>"standard_width",
										  "sortby" =>"standard_width",
										  "search"=> array('name'=>'standard_width',
										  					'type'=>'text' )
										  );
										  
										  
		$this->tabHeading[]=array("title" =>"Standard Decimal Places",
										  "coloum" =>"standard_decimal_places",
										  "sortby" =>"standard_decimal_places",
										  "search"=> array('name'=>'standard_decimal_places',
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
		
		$this->validData[]=array("feild_code" =>"action_event_type_id",
									 "feild_type" =>"select",
									 "is_required" =>"1",
									 "model" =>$this->getActionEvents(),
									   
									 "feild_label" =>"Action Event Type",
			);
			
			$this->validData[]=array("feild_code" =>"field_name",
									 "feild_type" =>"text",
									 "is_required" =>"",
									 "feild_label" =>"Field Name",
									 );
			$this->validData[]=array("feild_code" =>"field_id",
									 "feild_type" =>"text",
									 "is_required" =>"",
									 "feild_label" =>"Field Id",
									 );
									 $this->validData[]=array("feild_code" =>" 	definition",
									 "feild_type" =>"text",
									 "is_required" =>"",
									 "feild_label" =>"Definition",
									 );
									 $this->validData[]=array("feild_code" =>"field_type",
									 "feild_type" =>"text",
									 "is_required" =>"",
									 "feild_label" =>"Field Type",
									 );
									 $this->validData[]=array("feild_code" =>" 	standard_width",
									 "feild_type" =>"text",
									 "is_required" =>"",
									 "feild_label" =>"Standard Width",
									 );
									 $this->validData[]=array("feild_code" =>"standard_decimal_places",
									 "feild_type" =>"text",
									 "is_required" =>"",
									 "feild_label" =>"Standard Decimal Places",
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
			$this->sql= "select tbl_ca_action_fields.*,tbl_ca_subcategory.name as eventname,  if(tbl_ca_action_fields.status ='1','<font color=\'#e07503\'>active</font>','Inactive') as chr_status from ".$this->_table." left join tbl_ca_subcategory on tbl_ca_action_fields.action_event_id=tbl_ca_subcategory.id where  tbl_ca_action_fields.".$this->_keyId."='".$this->id."'";
			$this->viewData = $this->db->getResult($this->sql);
			//print_r($this->viewData);
			//$this->viewFeilds("Display On","websiteName");
			$this->viewFeilds("Action Name","eventname");
			$this->viewFeilds("Field name","field_name");
			
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
				
						
				
					
						//$_POST['dob']=date("Y-m-d h:m:s",strtotime($_POST['dob']));
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


	function upload()
	{
		
		$this->_title="Upload ".$this->_section;			
		$this->smarty->assign("title",$this->_title);		
		$this->adduploadFeilds();	
	 
	 	
		if(isset($_POST['submit'])){
		
			if($this->validatPost()){	
			$fields=array("1",'2','3','4','5','6','7');		
				$data = csv::import($fields,$_FILES['product_file']['tmp_name']);	
//$this->pr($data,true);

				$total=0;
					$insert=0;
					$update=0;  
				if(!empty($data))
				{
					$total;
					$insert;
					$update; 
					$trreturn=0;
					$prreturn=0;
					foreach($data as $key=> $users)
					{
					
					//$this->pr($users);
					
					$total++;
					
					//number_format(1.2378147769392E+14,0,'','')
					if($this->checkFields(mysql_real_escape_string($users[2]),mysql_real_escape_string($users[3]))){
					
						$actionid=$this->getActionId($users['1']);
					
					
					
					$insertData="INSERT INTO `tbl_ca_action_fields` (`action_id`, `field_name`, `field_id`, `definition`, `field_type`, `standard_width`, `standard_decimal_places`) VALUES ('".$actionid."','".$users['2']."','".$users['3']."','".$users['4']."','".$users['5']."','".$users['6']."','".$users['7']."');";
				    $this->db->query($insertData);
					}
					}
				//exit;	
			  }
			  $this->adminRedirect("index.php?module=".strtolower(get_class())."&event=upload",'success',"Total ".$total." Records inserted"."<br/>"."<br/>" );
			 // header("location:".$this->baseUrl."index.php?module=addproduct&total=".$total."&insert=".$insert."&update=".$update); 
		     exit;
			}
		 }	 
     $this->makeAddForm();	
	 
	
	}
	function adduploadFeilds()
	{			
	
	
	
	
							$this->validData[]=array("feild_code" =>"product_file",
									 "feild_type" =>"file",
									 "is_required" =>"1",
									  "feild_note" =>"<a href='".$this->siteconfig->base_url."index.php?module=".strtolower(get_class())."&event=downloadFile' target='_blank'>download sample</a>",
									 "validate" =>"file|csv",		
									 "feild_label" =>"Upload File",
									 );
	
	}
	
	
	function getActionId($code)
	{
		//echo "Jyoti";
			$data=$this->db->getResult("select id from  tbl_ca_subcategory where code='".$code."'");				
		//$this->pr($data);
		return $data['id'];
	}
function checkFields($fieldname,$fieldid){
	 $sql =  'SELECT *  from tbl_ca_action_fields where field_name="'.$fieldname.'" and field_id="'.$fieldid.'"';
	//$sql .=  ' order by name asc ';
	//exit;
	$get_options = $this->db->getResult($sql,true);
	//$this->pr($get_options,true);
	if ($get_options > 0) {
		//echo $sql; exit;
	return false;
	}	return true;
	}
}

?>