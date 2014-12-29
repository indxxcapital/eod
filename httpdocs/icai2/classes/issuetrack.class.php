<?php

class Issuetrack extends Application{

	function __construct()
	{
		parent::__construct();
		$this->checkUserSession();
	}
	
	
	function index()
	{
		
		$this->_baseTemplate="inner-template";
	$this->_bodyTemplate="issuetrack/index";
		$this->_title=$this->siteconfig->site_title;
		$this->_meta_description=$this->siteconfig->default_meta_description;
		$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
//	$this->addfield();

		$this->smarty->assign('pagetitle','Support Request List');
		$this->smarty->assign('bredcrumssubtitle','Support Request List');

$this->addCss('assets/data-tables/DT_bootstrap.css');
$this->addJs('assets/bootstrap/bootstrap.min.js');
$this->addJs('assets/nicescroll/jquery.nicescroll.min.js');
$this->addJs('assets/data-tables/jquery.dataTables.js');
$this->addJs('assets/data-tables/DT_bootstrap.js');
$this->addJs('js/flaty.js');



		$userdata1=$this->db->getResult("select tbl_issue_request.* from tbl_issue_request where 1=1 ",true);
		$this->smarty->assign("userdata1",$userdata1);

	//$this->pr($indexdata,true);
	
		//$this->pr($_SESSION);
		 $this->show();
	}
	
	function addNew()
	{
			$this->_baseTemplate="inner-template";
			$this->_bodyTemplate="issuetrack/add";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','Support ');
		$this->smarty->assign('bredcrumssubtitle','Support');
		
		
		if(isset($_POST['submit']))
		{
						
						if(!empty($_FILES['attachmentfile']))
						{$upload = "";			
						$upload['file'] = 'attachmentfile';
						$upload['type'] = 'file';
						$upload['folder'] = 'attachmentfile';
							//$upload['crop']= true;								
						$fileUpload = $this->upload($upload);	
					//	$this->pr($fileUpload,true);
						
						}
			
			
			$this->db->query("INSERT into tbl_issue_request set status='0',username='".mysql_real_escape_string($_SESSION['User']['name'])."',user_id='".mysql_real_escape_string($_SESSION['User']['id'])."',title='".mysql_real_escape_string($_POST['title'])."',content='".mysql_real_escape_string($_POST['content'])."',file='".mysql_real_escape_string($fileUpload['name'])."'");
		
		$msg='Hi , New Issue Request is added on Protal, <br>  Subject : '.$_POST['title']."<br> Please Visit <a href='". $this->siteconfig->base_url ."'>". $this->siteconfig->base_url ."</a><br> thanks ";
				$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'From: Indexing <indexing@indxx.com>' . "\r\n"."CC: indexing@indxx.com". "\r\n";\


$users=$this->db->getResult("select tbl_it_users.email from tbl_it_users where 1=1 ",true);
$emails=array();
if(!empty($users))
{
foreach($users as $user)
{
$emails[]=$user['email'];
}
}
$email='';
if(!empty($emails))
$email=implode(',',$emails);
		
		if(mail($email,"New Issue Request",$msg,$headers))
		{
			echo "Mail sent to : ".$to."<br>";	
		}	
			//$this->pr($_POST);
			//$this->pr($_FILES,true);
			
		/*$this->db->query("INSERT into tbl_issue_request set status='1',name='".mysql_real_escape_string($_POST['name'])."',email='".mysql_real_escape_string($_POST['email'])."',password='".mysql_real_escape_string($_POST['password'])."'");
		
				$msg='Hi '.$_POST['name'].', You are added to ICAI Portal as database User, <br> Login Email  : '.$_POST['email']."<br>Login Passowrd : ".$_POST['password']."<br> Please Visit <a href='". $this->siteconfig->base_url ."'>". $this->siteconfig->base_url ."</a><br> thanks ";
				$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'From: Indexing <indexing@indxx.com>' . "\r\n"."CC: indexing@indxx.com". "\r\n";		
		if(mail($_POST['email'],"ICAI Database Account Details ",$msg,$headers))
		{
			echo "Mail sent to : ".$to."<br>";	
		}*/
			//exit;
			
			$this->Redirect("index.php?module=issuetrack","Record added successfully!!!","success");	
		}
			
			$this->addfield();
			 $this->show();
	}
	
	
	private function addfield()
	{	
	   $this->validData[]=array("feild_label" =>"Title",
	   								"feild_code" =>"title",
								 "feild_type" =>"text",
								 "is_required" =>"1",
								
								 );
		 $this->validData[]=array("feild_label" =>"Description",
		 							"feild_code" =>"content",
								 "feild_type" =>"textarea",
								 "is_required" =>"1",
								 );
		$this->validData[]=array("feild_label" =>"Attachment",
		 							"feild_code" =>"attachmentfile",
								 "feild_type" =>"file",
								 "is_required" =>"",
								
								 );				 
		
								 
								 
	
	$this->getValidFeilds();
	}
	
	
	function exportExcel()
	{
		
		require 'php-excel.class.php';
		
		//echo "select * from tbl_ca_user where 1=1";
		$excelres=mysql_query("select tbl_ca_user.*,tbl_indxx.name as indexname, tbl_user_types.name as usertypes from tbl_ca_user left join tbl_indxx on tbl_indxx.id=tbl_ca_user.indxx_id left join tbl_user_types on tbl_user_types.id=tbl_ca_user.type where 1=1");
		$rowdata=array();
		while($exceldata=mysql_fetch_assoc($excelres))
		{
				//print_r($exceldata);
				$rowdata[]=array($exceldata['name'],$exceldata['email'],$exceldata['usertypes'],$exceldata['indexname']);
		}

		
		// create a simple 2-dimensional array
		$data = array(
        1 => array ('Name', 'Email', 'Type', 'Index'),
        //array('Schwarz', 'Oliver'),
        //array('Test', 'Peter')
        );
		
		// generate file (constructor parameters are optional)
		$xls = new Excel_XML('UTF-8', false, 'User Data');
		$xls->addArray($data);
		foreach($rowdata as $key1=>$val1)
		{
			$excelarray = array(
        	1 => $val1,
        	);
			//print_r($excelarray);
			$xls->addArray($excelarray);
		}
		
		
		$xls->generateXML('UserData');	
	}
	
	
	
	
	protected function edit(){
		 
		$this->_baseTemplate="inner-template";
			$this->_bodyTemplate="issuetrack/edit";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','Issue Request');
		$this->smarty->assign('bredcrumssubtitle','Edit Issue Request');
		$this->addfield();
		
		
		if(isset($_POST['submit']))
		{
			
	if(!empty($_FILES['attachmentfile']))
						{$upload = "";			
						$upload['file'] = 'attachmentfile';
						$upload['type'] = 'file';
						$upload['folder'] = 'attachmentfile';
							//$upload['crop']= true;								
						$fileUpload = $this->upload($upload);	
					//	$this->pr($fileUpload,true);
						
						}
			
			
			$this->db->query("update tbl_issue_request set status='0',username='".mysql_real_escape_string($_SESSION['User']['name'])."',title='".mysql_real_escape_string($_POST['title'])."',content='".mysql_real_escape_string($_POST['content'])."',file='".mysql_real_escape_string($fileUpload['name'])."'");
		
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
				
		$msg='Hi , Issue Request is updated on Protal, <br>  Subject : '.$_POST['title']."<br> Please Visit <a href='". $this->siteconfig->base_url ."'>". $this->siteconfig->base_url ."</a><br> thanks ";
				$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'From: Indexing <indexing@indxx.com>' . "\r\n"."CC: indexing@indxx.com". "\r\n";\


$users=$this->db->getResult("select tbl_it_users.email from tbl_it_users where 1=1 ",true);
$emails=array();
if(!empty($users))
{
foreach($users as $user)
{
$emails[]=$user['email'];
}
}
$email='';
if(!empty($emails))
$email=implode(',',$emails);
		
		if(mail($email,"Issue Request Updated",$msg,$headers))
		{
			echo "Mail sent to : ".$to."<br>";	
		}
		
			
			
			$this->Redirect("index.php?module=issuetrack","Record updated successfully!!!","success");	
			
			
			
			
			
			
			
			
			
		}
		
		
		
		$editdata=$this->db->getResult("select tbl_issue_request.* from tbl_issue_request  where tbl_issue_request.id='".$_GET['id']."'");
		//$this->pr($editdata,true);
		$this->smarty->assign("postData",$editdata);
		
		
		
		
		 $this->show();
			
	}
	
	
	
	protected function delete(){
		 
		
			$strQuery = "delete from tbl_issue_request where tbl_issue_request.id='".$_GET['id']."'";
			$this->db->query($strQuery);
			$this->Redirect("index.php?module=issuetrack","Record deleted successfully!!!","success");
			
			$this->show();
			
			
	}
	
	
	function deleteindex()
	{
		//$this->pr($_POST);
	 
		foreach($_POST as $key=>$val)
		{
			foreach($val as $key2=>$val2)
			{
				if(!empty($val2))
				{
					
					$strQuery2 = "delete from tbl_issue_request where tbl_issue_request.id='".$val2."'";
					$this->db->query($strQuery2);
			
			}
			}
		}
		
		$this->Redirect("index.php?module=issuetrack","Records deleted successfully!!!","success");
		$this->show();	
	}
	
	function view(){
		
$userdata1=$this->db->getResult("select tbl_issue_request.* from tbl_issue_request where 1=1 and id='".$_GET['id']."' ",false,1);
		$this->smarty->assign("userdata1",$userdata1);
		
		if(!empty($_POST))
		{
		//$this->pr($_POST,true);
		
		/*echo "INSERT into tbl_issue_request_comment set status='1',username='".mysql_real_escape_string($_SESSION['User']['name'])."',request_id='".mysql_real_escape_string($_GET['id'])."',comment='".mysql_real_escape_string($_POST['comment'])."'";
		exit;
		*/
		$this->db->query("INSERT into tbl_issue_request_comment set status='1',username='".mysql_real_escape_string($_SESSION['User']['name'])."',request_id='".mysql_real_escape_string($_GET['id'])."',comment='".mysql_real_escape_string($_POST['comment'])."'");
		
		
		
			
		$msg='Hi , New Comment on Issue Request is added on Protal, <br>  Subject : '.$userdata1['title']."<br> Please Visit <a href='". $this->siteconfig->base_url ."'>". $this->siteconfig->base_url ."</a><br> thanks ";
				$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'From: Indexing <indexing@indxx.com>' . "\r\n"."CC: indexing@indxx.com". "\r\n";\


if($_SESSION['User']['type']==4)
$users=$this->db->getResult("select tbl_ca_user.email from tbl_ca_user where 1=1 and id= '".$userdata1['user_id']."'",true);
else
$users=$this->db->getResult("select tbl_it_users.email from tbl_it_users where 1=1 ",true);
$emails=array();
if(!empty($users))
{
foreach($users as $user)
{
$emails[]=$user['email'];
}
}
$email='';
if(!empty($emails))
$email=implode(',',$emails);
		
		if(mail($email,"New Comment on  Issue Request",$msg,$headers))
		{
			echo "Mail sent to : ".$to."<br>";	
		}
		
		
		}
		
		
		$userdata2=$this->db->getResult("select tbl_issue_request_comment.* from tbl_issue_request_comment where 1=1 and request_id='".$_GET['id']."' ",true);
		$this->smarty->assign("usercomments",$userdata2);
		
		 
		$this->_baseTemplate="inner-template";
			$this->_bodyTemplate="issuetrack/view";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','Issue Request ');
		$this->smarty->assign('bredcrumssubtitle','View Issue Request');
			$this->addcommentfield();
		
		
	
		
		$this->show();	
	}
	
	
	function addcommentfield(){
		 $this->validData[]=array("feild_label" =>"Comment",
		 							"feild_code" =>"comment",
								 "feild_type" =>"textarea",
								 "is_required" =>"1",
								 );
		
	$this->getValidFeilds();
	}
	
} // class ends here

?>