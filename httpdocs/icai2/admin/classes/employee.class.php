<?php

/**
 * Class Content
 * @created by Arun Kumar
 * Created On  01-12-2011
 * Last modified 01-12-2011
 */

class Employee extends Backend{

	var $_table ="tbl_employee";
	var $_keyId="id";  //Primary Key
	var $_statusField="status";
	var $_section="Employee";  //Primary Key


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
		
		$search = "select tbl_employee.*,  if(tbl_employee.status ='1','<font color=\'#e07503\'>active</font>','Inactive') as chr_status,if(tbl_employee.groups ='1','Group-A','Group-B') as chr_group from ".$this->_table." ";
		
		$search .= " where 1='1' ";
		
			$this->tabHeading[]=array("title" =>"Group",
										  "coloum" =>"chr_group",
										  "sortby" =>"chr_group",
										  "search"=> array('name'=>'groups',
										  					'type'=>'select',
															"values"=>array("1"=>"Group-A","0"=>"Group-B"))
										);
		$this->tabHeading[]=array("title" =>"First Name",
										  "coloum" =>"fname",
										  "sortby" =>"fname",
										  "search"=> array('name'=>'fname',
										  					'type'=>'text' )
										  );
										  
		$this->tabHeading[]=array("title" =>"Last Name",
										  "coloum" =>"lname",
										  "sortby" =>"lname",
										  "search"=> array('name'=>'lname',
										  					'type'=>'text' )
										  );
										  
		$this->tabHeading[]=array("title" =>"Email",
										  "coloum" =>"email",
										  "sortby" =>"email",
										  "search"=> array('name'=>'email',
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
			$this->validData[]=array("feild_code" =>"fname",
									 "feild_type" =>"text",
									 "is_required" =>"",
									 "feild_label" =>"First name",
									 );
									 
			$this->validData[]=array("feild_code" =>"lname",
									 "feild_type" =>"text",
									 "is_required" =>"",
									 "feild_label" =>"last name",
									 );
			
			$this->validData[]=array("feild_code" =>"email",
									 "feild_type" =>"text",
									 "is_required" =>"1",
									 "feild_label" =>"Email",
									 );
			
			$this->validData[]=array("feild_code" =>"dob",
									 "feild_type" =>"date",
									 "is_required" =>"1",
									 "feild_label" =>"Date of Birth",
									 
									 );
									
											 
			$this->validData[]=array("feild_code" =>"groups",
									 "feild_type" =>"select",
									 "is_required" =>"",
									 "feild_label" =>"Group",
									 "model" =>array("1"=>"Group-A","0"=>"Group-B"),
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
			$this->sql= "select tbl_employee.*, if(tbl_employee.status ='1','<font color=\'#e07503\'>active</font>','Inactive') as chr_status from ".$this->_table." where  tbl_employee.".$this->_keyId."='".$this->id."'";
			$this->viewData = $this->db->getResult($this->sql);
			//print_r($this->viewData);
			//$this->viewFeilds("Display On","websiteName");
			$this->viewFeilds("First name","fname");
			$this->viewFeilds("Last name","fname");
			$this->viewFeilds("Email","email");
			$this->viewFeilds("dob","dob");
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
			$subject="Account Details for Leave application ";			
			$message = '<html><body>';
			$message .= '<table border="0" cellpadding="10">';
			$message .= "<tr style='background: #eee;'><td>Hello <strong>".ucwords($_POST['fname'])."</strong>, </td></tr>";
			$message .= "<tr><td><strong>Admin </strong>  has created your account for leave application </td></tr>";
			$message .= "<tr><td><strong>Email : </strong> ".$_POST['email']." </td></tr>";
			$message .= "<tr><td><strong>Date of Birth:</strong>  ".date("dmY",strtotime($_POST['dob']))."</td></tr>";
			$message .= "<tr><td>You can apply for leaves by <strong><a href='".$this->siteconfig->site_url."'>Click here</a> </strong> </td></tr>";
			$message .= "<tr><td>Thanks</td></tr>";
			$message .= "<tr><td>Indxx Capital</td></tr>";
			$message .= "</table>";
			$message .= "</body></html>";
			//echo  $message;
			//exit;
			//$to="deepakb48@gmail.com";
			
		$to = $_POST['email'];
			
			
			//$headers = "From: ". strip_tags($this->siteconfig->mail_from) . "\r\n";
		//	$headers .= "Reply-To: ". strip_tags($this->siteconfig->mail_from) . "\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

            if (mail($to, $subject, $message, $headers)) {
              echo 'Your message has been sent.';
            } else {
              echo 'There was a problem sending the email.';
            }
						
		//	exit;			
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
			$edit['dob']=date("d-F-Y",strtotime($edit['dob']));
			$this->smarty->assign("postData",$edit);
			$this->addFeilds(1);
			
			if(isset($_POST['submit'])){
			
				if($this->validatPost()){
							
							$_POST['dob']=date("Y-m-d h:m:s",strtotime($_POST['dob']));
								$this->updateRecord();						
							header("location:".$this->baseUrl."index.php?module=".strtolower(get_class())); 
							exit;
					
				}
			}
			$this->makeEditForm();
	}

}

?>