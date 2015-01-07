<?php

class Login2 extends Application{

	function __construct()
	{
		parent::__construct();
	}
	
	
	function index()
	{
		
		//$this->pr($_SESSION,true);
		//echo "aa";
		//exit;
		
		$this->_baseTemplate="login-template2";
//$this->_bodyTemplate="login";
		$this->_title=$this->siteconfig->site_title;
		$this->_meta_description=$this->siteconfig->default_meta_description;
		$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
//	$this->addfield();
$this->addJs('assets/bootstrap/bootstrap.min.js');

	//$this->pr($_POST,true);
	if (!empty($_POST)){
		//unset($_SESSION);
		//0echo "select * from tbl_ca_user where email='".$_POST['Username']."' ";
		//exit;
	$user=$this->db->getResult("select * from tbl_ca_user where email='".$_POST['Username']."' ");
	//
	
	if (empty($user))
	{
	$this->setMessage("error",$this->l("Email not exist !"));
	//exit;
	}else{
		if($user['status']==0)
		{
			$this->setMessage("error",$this->l("Your Account is Inactive ! Please Contact to Admin."));

		}
		
	elseif($user['password']!=$_POST['Password'])
	{
	$this->setMessage("error",$this->l("Incorrect Password"));

	}
	else{
		
		//unset($_SESSION);
		$this->setUserSessionData($user);
		
			//echo "select distinct(indxx_id) as indxx from tbl_assign_index where user_id='".$user['id']."'";
		
	//	echo "select distinct(indxx_id) as indxx from tbl_assign_index where user_id='".$user['id']."' ";
		$userindexes=$this->db->getResult("select distinct(indxx_id) as indxx from tbl_assign_index where user_id='".$user['id']."' ",true);
		$usertempindexes=$this->db->getResult("select distinct(indxx_id) as indxx from tbl_assign_index_temp where user_id='".$user['id']."' ",true);
	//$this->pr($user,true);//	
		//$this->pr($usertempindexes,true);
		$this->setUserIndexSessionData($userindexes);
		$this->setUserTempIndexSessionData($usertempindexes);
	//$this->pr($_SESSION,true);
		
		
		mysql_query("insert into tbl_ca_user_login_time(status,type,user_id) values('1','1','".$_SESSION['User']['id']."')");
		
		/*$usernamequery=mysql_query("select * from tbl_ca_user where email='".$_SESSION['User']['email']."'");
		$username=mysql_fetch_assoc($usernamequery);
		$this->smarty->assign("username",$username['name']);
		$this->smarty->assign("type",$username['type']);
	*/
		$lastlogintimequery=mysql_query("select * from tbl_ca_user_login_time where user_id='".$_SESSION['User']['id']."' and type='1' order by dateAdded desc limit 0,1");
		$lastlogintimearray=mysql_fetch_assoc($lastlogintimequery);
		$lastlogintime=date("H:i",strtotime($lastlogintimearray['dateAdded']));
				$_SESSION['User']['time']=$lastlogintime;
		
		
		
		
		
	$this->Redirect($this->baseUrl."index.php?module=home2",'success','Logged in successfully');
	}
	
	}
	
		}else{
			
			 session_unset();
    session_destroy();
    session_write_close();
			}
		
		//echo "aa";
		//exit;
		
		//$this->pr($_POST,true);
		 $this->show();
	}
	function getIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
	
	function setUserSessionData($objData){			
				$_SESSION['User']['id'] = $objData['id'];
				$_SESSION['User']['name']=$objData['name'];
				$_SESSION['User']['email']=$objData['email'];
				$_SESSION['User']['type']=$objData['type'];		
			return true;	
	}
	
	
	function setUserIndexSessionData($obj){			
				
				if(!empty($obj))
				{
				
				foreach($obj as $indxx)
				{
					if($indxx['indxx'])
				$_SESSION['Index'][]=$indxx['indxx'];		
		
				}
				
	}
				
					return true;	
	}
	
	
	
   	 private function addfield()
	{	
			$this->validData[]=array("feild_code" =>"email",
								 "feild_type" =>"text",
								 "feild_tpl" =>"leave_text",
								 "is_required" =>"1",
								 "validate"=>"email",
								 "feild_label" =>$this->l("Email"),
								 );
			$this->validData[]=array("feild_code" =>"type",
								 "feild_type" =>"radio",
								 "is_required" =>"1",
								 "feild_label" =>$this->l("Type"),
								 "model"=>array(0=>"In",1=>"Out"),
								 );
					
		   
		$this->getValidFeilds();
}
	function myprofile()
	{
		
			$this->_baseTemplate="main-template";
			$this->_bodyTemplate="home/editprofile";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
//$this->pr($_SESSION);
//echo "select * from tbl_employee where id='".$_SESSION['User']['id']."'";
	$user=$this->db->getResult("select * from tbl_employee where id='".$_SESSION['User']['id']."'",true);
		
		
	$user[0]['dob']=date("d-F-Y",strtotime($user[0]['dob']));
		$this->smarty->assign("postData",$user[0]);
		
		if (!empty($_POST) && $_POST['submit']){
			
			
			$this->db->query("update tbl_adminemployee set fname ='".$_POST['fname']."', lname='".$_POST['lname']."',dob='".date("Y-m-d h:m:s",strtotime($_POST['dob']))."' where id='".$_SESSION['User']['id']."' and email ='".$_POST['email']."' ");
		
		
			$this->Redirect($this->baseUrl."index.php?module=leave",'success','Profile Updated successfully');
		}
		
	$this->addprofilefield();
	$this->show();
	}
	
	
	
	   	 private function addprofilefield()
	{	
				$this->validData[]=array("feild_code" =>"fname",
								 "feild_type" =>"text",
								 "feild_tpl" =>"leave_text",
								 "is_required" =>"1",
								 "validate"=>"",
								 "feild_label" =>$this->l("First name"),
								 );
						$this->validData[]=array("feild_code" =>"lname",
								 "feild_type" =>"text",
								 "feild_tpl" =>"leave_text",
								 "is_required" =>"",
								 "validate"=>"",
								 "feild_label" =>$this->l("Last Name"),
								 );
					 $this->validData[]=array("feild_code" =>"email",
								 "feild_type" =>"text",
								 "feild_tpl" =>"leave_text",
								 "is_required" =>"1",
								 "validate"=>"email",
								 "feild_label" =>$this->l("Email"),
								  "feildOptions" => array("readonly"=>"READONLY"),
								
								 );
			$this->validData[]=array("feild_code" =>"dob",
								 "feild_type" =>"date",
								 "is_required" =>"1",
								 "validate"=>"date",
								 "feild_label" =>$this->l("Date of Birth"),
							
								 );
			
		   
		$this->getValidFeilds();
}
	
	function logout()
	{
		mysql_query("insert into tbl_ca_user_login_time(status,type,user_id) values('1','0','".$_SESSION['User']['id']."')");
		
		 session_unset();
    session_destroy();
    session_write_close();
		
	$this->Redirect($this->baseUrl,'success','Logout successfully');
	}

} // class ends here

?>