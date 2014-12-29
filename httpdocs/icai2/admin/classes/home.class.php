<?php

class Home extends Backend{

	function __construct()
	{
	
		
		
	}
	
	function index()
	{
		$this->login();
	}
	
	//@function to login the admin section
	function login()
	{
	
		if($_SESSION['Admin']['uid']!= "")
		{
			$this->adminRedirect($this->baseUrl.'index.php?module=welcome');	
			
		}
		
		$this->_bodyTemplate="login";
		$this->_title="Login";
		$this->_meta_description="Home Page";
		$this->_meta_keywords="Home Page";		
		$this->addFeilds();		
		
		if(isset($_POST['submit']))
		{
	  		// validate the form 
			if($this->validatPost())
			{
				$data = $this->db->getResult("select * from tbl_admin where adminUserName='".mysql_real_escape_string(trim($_POST['adminUserName']))."' and adminPassword='".mysql_real_escape_string(trim($_POST['adminPassword']))."' and status='1'	");			
				//echo "<pre>"; print_r($data);  exit;
				if($this->db->mysqlrows==0)
				{
					$this->adminRedirect("","error","Username or password doesnot match");
				
				}
				else
				{	
					unset($_SESSION['Admin']);
					$_SESSION['Admin']['uid'] = $data['id'];
					$_SESSION['Admin']['uname'] = $data['adminUserName'];
					//$_SESSION['Admin']['admin_role']=$data['admin_role'];
					$this->adminRedirect($this->baseUrl.'index.php?module=welcome');				
				}
			}
		}
 
		$this->show();
		
	}
	
	
	
	
	
	private function addFeilds()
	{
		$this->validate("adminUserName","text","1","","Username");
		$this->validate("adminPassword","password","1","","Password");
		$this->getValidFeilds();
					
	}
	
	function logout()
	{
		 	
		unset($_SESSION['Admin']);
		$this->adminRedirect($this->baseUrl,'success','Logout successfully');
	}
 
 
 	// function to send password mail to admin user
/* 	function forgetAdminPassword()
	{
		$adminData = $this->db->getResult("select * from tbl_admin where id=1 and status='1' ");	
		
		$to = $adminData['adminEmail'];
		$subject = "Password Recovery Mail";
		$body =  '<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="50%" align="left"><h3>Your '.$this->siteconfig->admin_title.' Login Details: </h3>  </td>   
  </tr>
  <tr>
    <td align="left">&nbsp;</td>   
  </tr>
  <tr>
    <td align="left">Username: <strong>'.$adminData['adminUserName'].'</strong></td>  
  </tr>
  <tr>
    <td align="left">Password: <strong>'.$adminData['adminPassword'].'</strong></td>   
  </tr>
  <tr>
    <td align="left">&nbsp;</td>   
  </tr>
  <tr>
    <td align="left">'.$this->siteconfig->site_title.' Team. &nbsp; </td>   
  </tr>
</table>';
		$fromname = $this->siteconfig->from_name;
		$fromemail = $this->siteconfig->mail_from;						
		
		$this->SendMail($to,$subject,$body,$attachment="",$fromname,$fromemail);
		$this->adminRedirect($this->baseUrl.'index.php?module=home', 'success', 'Password has been sent successfully!');
		exit;
		
		//echo "<pre>"; print_r($adminData);
	}*/
	
 	// function to send password mail to admin user
 	function forgetAdminPassword()
	{
		
		$this->_bodyTemplate="email";
		$this->validData[]=array("feild_code" =>"email",
									 "feild_type" =>"text",
									 "is_required" =>"1",
									 "validate"=>"email",
									 "feild_label" =>"Email",
									 );
	
		$this->getValidFeilds();
		


	if(isset($_POST['forget']))
		{

	  		// validate the form 
			if($this->validatPost())
			{
				

				
				if($_POST['email']==$this->siteconfig->admin_email)
				{
					
		$adminData = $this->db->getResult("select * from tbl_admin where id=1 and status='1' ");	
//		print_r($adminData);
//		exit;
	    $to = $this->siteconfig->admin_email;
		$subject = "Password Recovery Mail";
		$body =  '<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="50%" align="left"><h3>Your '.$this->siteconfig->admin_title.' Login Details: </h3>  </td>   
  </tr>
  <tr>
    <td align="left">&nbsp;</td>   
  </tr>
  <tr>
    <td align="left">Username: <strong>'.$adminData['adminUserName'].'</strong></td>  
  </tr>
  <tr>
    <td align="left">Password: <strong>'.$adminData['adminPassword'].'</strong></td>   
  </tr>
  <tr>
    <td align="left">&nbsp;</td>   
  </tr>
  <tr>
    <td align="left">'.$this->siteconfig->site_title.' Team. &nbsp; </td>   
  </tr>
</table>';
		$fromname = $this->siteconfig->from_name;
		$fromemail = $this->siteconfig->mail_from;						
		
		$this->SendMail($to,$subject,$body,$attachment="",$fromname,$fromemail);
		$this->adminRedirect($this->baseUrl.'index.php?module=home', 'success', 'Password has been sent successfully!');
		exit;
		
			}
			else
				{
					$this->adminRedirect($this->baseUrl.'index.php?module=home', 'error', 'Admin Email does not exist!');
					
				}
			
			}
			
			
	}
		$this->show();
		
		
		//echo "<pre>"; print_r($adminData);
	}	
	

}

?>