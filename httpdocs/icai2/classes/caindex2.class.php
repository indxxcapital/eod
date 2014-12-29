<?php

class Caindex2 extends Application{

	function __construct()
	{
		parent::__construct();
		$this->checkUserSession();
		
$this->addCss('assets/data-tables/DT_bootstrap.css');
$this->addJs('assets/bootstrap/bootstrap.min.js');
$this->addJs('assets/nicescroll/jquery.nicescroll.min.js');
$this->addJs('assets/data-tables/jquery.dataTables.js');
$this->addJs('assets/data-tables/DT_bootstrap.js');
$this->addJs('js/flaty.js');
	}
	
	
	function index()
	{
		
		
		$this->_baseTemplate="inner-template2";
	$this->_bodyTemplate="caindex2/index";
		$this->_title=$this->siteconfig->site_title;
		$this->_meta_description=$this->siteconfig->default_meta_description;
		$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
//	$this->addfield();

		$this->smarty->assign('pagetitle','Index');
		$this->smarty->assign('bredcrumssubtitle','Index');

//$this->pr($_SESSION,true);

if($_SESSION['User']['type']=='2')
{
	if(!empty($_SESSION['Index']))
$ids=$ids = implode(',',$_SESSION['Index']); 
//$ids=substr($ids, 0, -1); echo $ids;
//exit;
if(!empty($ids))
$indexdata=$this->db->getResult("select tbl_indxx.*,tbl_index_types.name as indexname from tbl_indxx left join tbl_index_types on tbl_index_types.id=tbl_indxx.type where tbl_indxx.id in (".$ids .") ",true);
}
else{		$indexdata=$this->db->getResult("select tbl_indxx.*,tbl_index_types.name as indexname from tbl_indxx left join tbl_index_types on tbl_index_types.id=tbl_indxx.type where 1=1  ",true);
}
		$this->smarty->assign("indexdata",$indexdata);

	//$this->pr($indexdata,true);
	
		//$this->pr($_SESSION);
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
					
					
					
					
					 $deleteddata=$this->db->getResult("select * from tbl_indxx where tbl_indxx.id='".$val2."'");
		$this->smarty->assign("deleteddata",$deleteddata);
		
		 $indexname=$deleteddata['name'];
		 $indexticker=$deleteddata['ticker'];
	
		
		 	$indxx=$deleteddata;
		//$this->pr($indxx,true);
		
		$indxxadmins =	$this->db->getResult('Select  user_id from tbl_assign_index where indxx_id="'.$val2.'" ',true);
$indxxadmin='';
//print_r($indxxadmins );
$emailto=array();

if(!empty($indxxadmins))
{
foreach($indxxadmins as $array)
{
	$emailto[]=$array['user_id'];
}


}

//print_r($emailto);

	//exit;
	if(!empty($emailto))
	{	
//	echo  'Select  email from tbl_ca_user where type="1" or id in ('.implode(',',$emailto).') ';
	$admins =	$this->db->getResult('Select  email from tbl_ca_user where type="1" or id in ('.implode(',',$emailto).') ',true);
	}
else
{	$admins =	$this->db->getResult('Select  email from tbl_ca_user where 1=1 ',true);
}
//$this->pr($admins,true);	
	
	$user=array();
	if(!empty($admins))	
	foreach($admins as $admin)
	{
	$user[]=$admin['email'];
	}
		
  $to=implode(',',$user);		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'From: Indexing <indexing@indxx.com>' . "\r\n"."CC: indexing@indxx.com". "\r\n";
$body='Hi <br>';
$body.='Your Indxx '.$indxx['name'].'('.$indxx['code'].') has been deleted by admin , <br> Please  <a href="'.$this->siteconfig->base_url.'index.php?module=caindex&event=view&id='.$val2.'">Click here </a> to do more.<br>Thanks ';


		mail($to,"ICAI : Indxx Deleted " ,$body,$headers);
		
					
					
					
					
					$strQuery = "delete from tbl_indxx where tbl_indxx.id='".$val2."'";
					$this->db->query($strQuery);
			
			
					$strQuery2 = "delete from tbl_indxx_ticker where tbl_indxx_ticker.indxx_id='".$val2."'";
					$this->db->query($strQuery2);
					
					
					$strQuery3 = "delete from tbl_project_task where tbl_project_task.indxx_id='".$val2."'";
			$this->db->query($strQuery3);
			
			$strQuery4 = "delete from tbl_assign_index where tbl_assign_index.indxx_id='".$val2."'";
			$this->db->query($strQuery4);
			
			$strQuery5 = "delete from tbl_indxx_value where tbl_indxx_value.indxx_id='".$val2."'";
			$this->db->query($strQuery4);
					
			
			}
			}
		}
		
		$this->Redirect("index.php?module=caindex","Records deleted successfully!!!","success");
		$this->show();	
	}
	
	
	function addNew()
	{
			$this->_baseTemplate="inner-template2";
			$this->_bodyTemplate="caindex2/add";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
		
			
			
			$this->smarty->assign('pagetitle','Index');
		$this->smarty->assign('bredcrumssubtitle','AddIndex');
		
		
		$databaseuserdata=$this->db->getResult("select tbl_database_users.* from tbl_database_users where 1=1");
		
		if(isset($_POST['submit']))
		{
			//$indexname=$_POST['name'];
			//$indexticker=$_POST['ticker'];
			
			//$_SESSION['InsertedData']=$_POST;
			
		$this->db->query("INSERT into tbl_indxx_temp set status='0',name='".mysql_real_escape_string($_POST['name'])."',code='".mysql_real_escape_string($_POST['code'])."',investmentammount='".mysql_real_escape_string($_POST['investmentammount'])."',divisor='".mysql_real_escape_string($_POST['divisor'])."',type='".mysql_real_escape_string($_POST['type'])."',curr='".mysql_real_escape_string($_POST['curr'])."',lastupdated='".date("Y-m-d h:i:s")."',dateStart='".$_POST['dateStart']."'");
		
		$indexid=mysql_insert_id();
		
		
		if($_SESSION['User']['type']=='1')
		{
		$this->db->query("INSERT into tbl_assign_index set user_id='".mysql_real_escape_string($_SESSION['User']['id'])."',indxx_id='".mysql_real_escape_string($indexid)."',isAdmin='1'");
		$this->db->query("INSERT into tbl_assign_index_temp set user_id='".mysql_real_escape_string($_SESSION['User']['id'])."',indxx_id='".mysql_real_escape_string($indexid)."',isAdmin='1'");
		
		}
		else
		{
				$this->db->query("INSERT into tbl_assign_index set user_id='".mysql_real_escape_string($_SESSION['User']['id'])."',indxx_id='".mysql_real_escape_string($indexid)."'");
		$this->db->query("INSERT into tbl_assign_index_temp set user_id='".mysql_real_escape_string($_SESSION['User']['id'])."',indxx_id='".mysql_real_escape_string($indexid)."'");
		}
		$_SESSION['Index'][]=$indexid;
		
		$_SESSION['NewIndxxName']=mysql_real_escape_string($_POST['name']);
		$_SESSION['NewIndxxId']=$indexid;
		$_SESSION['NewIndxxsecurities']=0;
		$_SESSION['indxx_code']=mysql_real_escape_string($_POST['code']);
		$_SESSION['indxx_type']=mysql_real_escape_string($_POST['type']);
		
		/*if($_POST['type']=='0')
		{
				$this->db->query("INSERT into tbl_project_task set name='Closing File for ".mysql_real_escape_string($_POST['code'])."',indxx_id='".$indexid."'");
		}
		else if($_POST['type']=='1')
		{
			$this->db->query("INSERT into tbl_project_task set name='Opening File for ".mysql_real_escape_string($_POST['code'])."',indxx_id='".$indexid."'");
			
			$this->db->query("INSERT into tbl_project_task set name='Closing File for ".mysql_real_escape_string($_POST['code'])."',indxx_id='".$indexid."'");	
		}*/
		
		
		
				//$fields=array(1,2,3,4,5);		
				//$uploadsecuritydata = csv::import($fields,$_FILES['product_file']['tmp_name']);		
				//$_SESSION['SecurityData']=$uploadsecuritydata;
				
				

			
			/*foreach($databaseuserdata as $key=>$val)
			{
				
				$headers = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

				// Additional headers
				//$headers .= 'From: Jyoti Sharma <jsharma@indxx.com>' . "\r\n";

				//$headers .= 'Reply-To: jsharma@indxx.com' . "\r\n" ;
				
				
				$to=$val['email'];
				$name=$val['name'];
				mail($to,"New Index Added","<html>
				<body>
					<p>Hello $name,</p>
					<p>A new index $indexname with ticker $indexticker has been added.</p>
					<p>Please update the respective files.</p>
				</body>
				</html>");	
			}*/
			
			$this->Redirect("index.php?module=casecurities&event=addNew2","Index added successfully!!!","success");	
		}
		
	
			
			$this->addfield();
			 $this->show();
	}
	
	
	private function addfield()
	{	
	   $this->validData[]=array("feild_label" =>"Index Name",
	   								"feild_code" =>"name",
								 "feild_type" =>"text3",
								 "is_required" =>"1",
								
								 );
		 $this->validData[]=array("feild_label" =>"Index Ticker",
		 							"feild_code" =>"code",
								 "feild_type" =>"text3",
								 "is_required" =>"1",
								
								 );
								 
		 $this->validData[]=array("feild_label" =>"Investment Amount",
		 							"feild_code" =>"investmentammount",
								 "feild_type" =>"text3",
								 "is_required" =>"1",
								
								 );
								 
		 $this->validData[]=array("feild_label" =>"Index Value",
		 							"feild_code" =>"indexvalue",
								 "feild_type" =>"text3",
								 "is_required" =>"1",
								
								 );
								 
								 
		$this->validData[]=array("feild_label" =>"Return Type",
	 							"feild_code" =>"ireturn",
								 "feild_type" =>"select2",
								 "is_required" =>"1",
								 //"feild_tpl" =>"selectsearch",
								  "model"=>$this->getReturnTypes(),
								 );		
								 
	 $this->validData[]=array("feild_label" =>"Type",
	 							"feild_code" =>"type",
								 "feild_type" =>"select2",
								 "is_required" =>"1",
								 //"feild_tpl" =>"selectsearch",
								  "model"=>$this->getTypes(),
								 );
								 
															 
	$this->validData[]=array("feild_label" =>"Dividend Amount",
	 							"feild_code" =>"div_type",
								 "feild_type" =>"select2",
								 "is_required" =>"",
								 //"feild_tpl" =>"selectsearch",
								  "model"=>array("0"=>"Gross Amount","1"=>"Net Ammount"),
								 );											 
	 $this->validData[]=array("feild_label" =>"Ignore Corporate Actions",
	 							"feild_code" =>"ica",
								 "feild_type" =>"select2",
								 "is_required" =>"",
								 //"feild_tpl" =>"selectsearch",
								  "model"=>$this->GetYesNo(),
								 );
								 	
									
		$this->validData[]=array("feild_label" =>"Currency Hedged Index",
	 							"feild_code" =>"currency_hedged",
								 "feild_type" =>"select2",
								 "is_required" =>"",
								 //"feild_tpl" =>"selectsearch",
								  "model"=>array("0"=>"No","1"=>"Yes"),
								 );									
														 
	 $this->validData[]=array(	"feild_label"=>"Currency",
	 							"feild_code" =>"curr",
								 "feild_type" =>"text3",
								 "is_required" =>"",
								
								 );
								 	 
	 $this->validData[]=array(	"feild_label"=>"Index Start Date",
	 							"feild_code" =>"dateStart",
								 "feild_type" =>"date2",
								 "is_required" =>"1",
								);
								
 $this->validData[]=array("feild_label" =>"Client",
	 							"feild_code" =>"client_id",
								 "feild_type" =>"select2",
								 "is_required" =>"1",
								 //"feild_tpl" =>"selectsearch",
								  "model"=>$this->getAllClients(),
								 ); 
									 
	/*$this->validData[]=array("feild_code" =>"product_file",
									 "feild_type" =>"file",
									 "is_required" =>"1",
									 "validate" =>"file|csv",		
									 "feild_label" =>"Upload File",
									 );*/
								 
								 
	 	 $this->validData[]=array("feild_label" =>"Display Currency ",
	 							"feild_code" =>"display_currency",
								 "feild_type" =>"select2",
								 "is_required" =>"",
								 //"feild_tpl" =>"selectsearch",
								  "model"=>$this->GetYesNo(),
								 );
								 
	/*	$this->validData[]=array("feild_label" =>"Priority",
	 							"feild_code" =>"priority",
								 "feild_type" =>"select",
								 "is_required" =>"1",
								 //"feild_tpl" =>"selectsearch",
								  "model"=>$this->getPriorityArray(),
								 );		*/					 
	
	$this->getValidFeilds();
	}
	
	private function addfieldadjfactor($name)
	{	
	   $this->validData[]=array("feild_label" =>$name,
	   								"feild_code" =>"factor",
								 "feild_type" =>"text2",
								 "is_required" =>"1",
								
								 );
		 
	
	$this->getValidFeilds();
	}
	
	function addNewRunning()
	{
			$this->_baseTemplate="inner-template2";
			$this->_bodyTemplate="caindex2/add";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
		
			
			
			$this->smarty->assign('pagetitle','Index');
		$this->smarty->assign('bredcrumssubtitle','AddIndex');
		
		
		$databaseuserdata=$this->db->getResult("select tbl_database_users.* from tbl_database_users where 1=1");
		
		if(isset($_POST['submit']))
		{
			//$indexname=$_POST['name'];
			//$indexticker=$_POST['ticker'];
			
			//$_SESSION['InsertedData']=$_POST;
			
			
		$this->db->query("INSERT into tbl_indxx_temp set addtype='1', status='0',name='".mysql_real_escape_string($_POST['name'])."',code='".mysql_real_escape_string($_POST['code'])."',investmentammount='0',divisor='0',type='".mysql_real_escape_string($_POST['type'])."',zone='".mysql_real_escape_string($_POST['zone'])."',curr='".mysql_real_escape_string($_POST['curr'])."',lastupdated='".date("Y-m-d h:i:s")."',dateStart='".$_POST['dateStart']."',cash_adjust='".$_POST['cash_adjust']."',client_id='".$_POST['client_id']."',display_currency='".$_POST['display_currency']."',ireturn='".$_POST['ireturn']."',div_type='".$_POST['div_type']."',currency_hedged='".$_POST['currency_hedged']."'");
		//
		$indexid=mysql_insert_id();
		
		
		if($_SESSION['User']['type']=='1')
		{
		$this->db->query("INSERT into tbl_assign_index set user_id='".mysql_real_escape_string($_SESSION['User']['id'])."',indxx_id='".mysql_real_escape_string($indexid)."',isAdmin='1'");
		$this->db->query("INSERT into tbl_assign_index_temp set user_id='".mysql_real_escape_string($_SESSION['User']['id'])."',indxx_id='".mysql_real_escape_string($indexid)."',isAdmin='1'");
		
		}
		else
		{
				$this->db->query("INSERT into tbl_assign_index set user_id='".mysql_real_escape_string($_SESSION['User']['id'])."',indxx_id='".mysql_real_escape_string($indexid)."'");
		$this->db->query("INSERT into tbl_assign_index_temp set user_id='".mysql_real_escape_string($_SESSION['User']['id'])."',indxx_id='".mysql_real_escape_string($indexid)."'");
		}
		$_SESSION['Index'][]=$indexid;
		
		$_SESSION['NewIndxxName']=mysql_real_escape_string($_POST['name']);
		$_SESSION['NewIndxxId']=$indexid;
		$_SESSION['NewIndxxsecurities']=0;
		$_SESSION['indxx_code']=mysql_real_escape_string($_POST['code']);
		$_SESSION['indxx_type']=mysql_real_escape_string($_POST['type']);
		
		/*if($_POST['type']=='0')
		{
				$this->db->query("INSERT into tbl_project_task set name='Closing File for ".mysql_real_escape_string($_POST['code'])."',indxx_id='".$indexid."'");
		}
		else if($_POST['type']=='1')
		{
			$this->db->query("INSERT into tbl_project_task set name='Opening File for ".mysql_real_escape_string($_POST['code'])."',indxx_id='".$indexid."'");
			
			$this->db->query("INSERT into tbl_project_task set name='Closing File for ".mysql_real_escape_string($_POST['code'])."',indxx_id='".$indexid."'");	
		}*/
		
		
		
				//$fields=array(1,2,3,4,5);		
				//$uploadsecuritydata = csv::import($fields,$_FILES['product_file']['tmp_name']);		
				//$_SESSION['SecurityData']=$uploadsecuritydata;
				
				

			
			/*foreach($databaseuserdata as $key=>$val)
			{
				
				$headers = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

				// Additional headers
				//$headers .= 'From: Jyoti Sharma <jsharma@indxx.com>' . "\r\n";

				//$headers .= 'Reply-To: jsharma@indxx.com' . "\r\n" ;
				
				
				$to=$val['email'];
				$name=$val['name'];
				mail($to,"New Index Added","<html>
				<body>
					<p>Hello $name,</p>
					<p>A new index $indexname with ticker $indexticker has been added.</p>
					<p>Please update the respective files.</p>
				</body>
				</html>");	
			}*/
			
			$this->Redirect("index.php?module=casecurities&event=addNewforRunning","Index added successfully!!!","success");	
		}
		
	
			
			$this->addfieldrunning();
			 $this->show();
	}
	
	
	private function addfieldrunning()
	{	
	   $this->validData[]=array("feild_label" =>"Index Name",
	   								"feild_code" =>"name",
								 "feild_type" =>"text3",
								 "is_required" =>"1",
								
								 );
		 $this->validData[]=array("feild_label" =>"Index Ticker",
		 							"feild_code" =>"code",
								 "feild_type" =>"text3",
								 "is_required" =>"1",
								
								 );
		/*						 
		 $this->validData[]=array("feild_label" =>"Investment Amount",
		 							"feild_code" =>"investmentammount",
								 "feild_type" =>"text",
								 "is_required" =>"1",
								
								 );
								 
		 $this->validData[]=array("feild_label" =>"Divisor",
		 							"feild_code" =>"divisor",
								 "feild_type" =>"text",
								 "is_required" =>"1",
								
								 );*/
	 $this->validData[]=array("feild_label" =>"Type",
	 							"feild_code" =>"type",
								 "feild_type" =>"select2",
								 "is_required" =>"1",
								 //"feild_tpl" =>"selectsearch",
								  "model"=>$this->getTypes(),
								 );
	 $this->validData[]=array("feild_label" =>"Return Type",
	 							"feild_code" =>"ireturn",
								 "feild_type" =>"select2",
								 "is_required" =>"1",
								 //"feild_tpl" =>"selectsearch",
								  "model"=>$this->getReturnTypes(),
								 );							 
	$this->validData[]=array("feild_label" =>"Zone",
	 							"feild_code" =>"zone",
								 "feild_type" =>"select2",
								 "is_required" =>"1",
								 //"feild_tpl" =>"selectsearch",
								  "model"=>$this->getCalendarZone(),
								 );
	$this->validData[]=array("feild_label" =>"Cash Dividend Adjustment",
	 							"feild_code" =>"cash_adjust",
								 "feild_type" =>"select2",
								 "is_required" =>"",
								 //"feild_tpl" =>"selectsearch",
								  "model"=>array("0"=>"Divisor","1"=>"Stock"),
								 );							 
	$this->validData[]=array("feild_label" =>"Dividend Amount",
	 							"feild_code" =>"div_type",
								 "feild_type" =>"select2",
								 "is_required" =>"",
								 //"feild_tpl" =>"selectsearch",
								  "model"=>array("0"=>"Gross Amount","1"=>"Net Ammount"),
								 );		
								 
								 
		$this->validData[]=array("feild_label" =>"Currency Hedged Index",
	 							"feild_code" =>"currency_hedged",
								 "feild_type" =>"select2",
								 "is_required" =>"",
								 //"feild_tpl" =>"selectsearch",
								  "model"=>array("0"=>"No","1"=>"Yes"),
								 );								 
								 						 
	 $this->validData[]=array(	"feild_label"=>"Currency",
	 							"feild_code" =>"curr",
								 "feild_type" =>"text3",
								 "is_required" =>"",
								
								 );
								 	 
	 $this->validData[]=array(	"feild_label"=>"Index Start Date",
	 							"feild_code" =>"dateStart",
								 "feild_type" =>"date2",
								 "is_required" =>"1",
								);
									
									
	 $this->validData[]=array("feild_label" =>"Client",
	 							"feild_code" =>"client_id",
								 "feild_type" =>"select2",
								 "is_required" =>"1",
								 //"feild_tpl" =>"selectsearch",
								  "model"=>$this->getAllClients(),
								 ); 
								 
								 
	$this->validData[]=array("feild_label" =>"Display Currency",
	 							"feild_code" =>"display_currency",
								 "feild_type" =>"select2",
								 "is_required" =>"1",
								 //"feild_tpl" =>"selectsearch",
								  "model"=>array("0"=>"No","1"=>"Yes"),
								 );
/*	$this->validData[]=array("feild_label" =>"Priority",
	 							"feild_code" =>"priority",
								 "feild_type" =>"select",
								 "is_required" =>"1",
								 //"feild_tpl" =>"selectsearch",
								  "model"=>$this->getPriorityArray(),
								 );	*/						 
	/*$this->validData[]=array("feild_code" =>"product_file",
									 "feild_type" =>"file",
									 "is_required" =>"1",
									 "validate" =>"file|csv",		
									 "feild_label" =>"Upload File",
									 );*/
								 
								 
	 
	
	$this->getValidFeilds();
	}
	
	 protected function view(){
		 
		$this->_baseTemplate="inner-template2";
			$this->_bodyTemplate="caindex2/view";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','Index');
		$this->smarty->assign('bredcrumssubtitle','ViewIndex');
		
		//$this->pr($_SESSION,true);
		
		$viewdata=$this->db->getResult("select tbl_indxx.*,tbl_index_types.name as indexname from tbl_indxx left join tbl_index_types on tbl_index_types.id=tbl_indxx.type where tbl_indxx.id='".$_GET['id']."'",true);
		//$this->pr($viewdata,true);
		$this->smarty->assign("viewindexdata",$viewdata);
		
		
		$sequruityData=$this->db->getResult('SELECT * FROM tbl_indxx_ticker where indxx_id="'.$_GET['id'].'"',true);
	//	$this->pr($sequruityData,true);
		$this->smarty->assign("indexSecurity",$sequruityData);
		$this->smarty->assign("totalindexSecurityrows",count($sequruityData));
		
		
		 $this->show();
			
	}
	
	
	 protected function viewupcoming(){
		 
		$this->_baseTemplate="inner-template2";
			$this->_bodyTemplate="caindex2/viewupcoming";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','Index');
		$this->smarty->assign('bredcrumssubtitle','ViewIndex');
		
		//$this->pr($_SESSION,true);
		
		$viewadmindata=$this->db->getResult("select isAdmin from tbl_assign_index_temp where indxx_id='".$_GET['id']."' and user_id='".$_SESSION['User']['id']."'",true);
		//$this->pr($viewadmindata,true);
		$this->smarty->assign("viewadmindata",$viewadmindata);
		
		$viewdata=$this->db->getResult("select tbl_indxx_temp.*,tbl_index_types.name as indexname from tbl_indxx_temp left join tbl_index_types on tbl_index_types.id=tbl_indxx_temp.type where tbl_indxx_temp.id='".$_GET['id']."'",true);
		//$this->pr($viewdata,true);
		$this->smarty->assign("viewindexdata",$viewdata);
		
		
		$sequruityData=$this->db->getResult('SELECT * FROM tbl_indxx_ticker_temp where indxx_id="'.$_GET['id'].'"',true);
	//	$this->pr($sequruityData,true);
		$this->smarty->assign("indexSecurity",$sequruityData);
		$this->smarty->assign("totalindexSecurityrows",count($sequruityData));
		
		
		 $this->show();
			
	}
	
	
	 protected function viewsecurity(){
		 
		$this->_baseTemplate="inner-template2";
			$this->_bodyTemplate="caindex2/viewsecurity";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','Index');
		$this->smarty->assign('bredcrumssubtitle','View Securities to be uploaded');
		
	
		
		
		
		$fields=array(1,2,3,4,5);		
				$uploadsecuritydata = csv::import($fields,$_SESSION['UploadFile']['tmp_name']);	
//$this->pr($data,true);

//$this->smarty->assign("uploadsecuritydata",$uploadsecuritydata);
		$this->pr($_SESSION['UploadFile'],true);
		
		 $this->show();
			
	}
	
	
	function addSecurity()
	{
		if($_SESSION['User']['type']=='2' && $_GET['id'])
		{
			//$_SESSION['Index'][]=$_GET['id'];
		
		
		$_SESSION['NewIndxxId']=$_GET['id'];
		
		$codequery=$this->db->getResult("select code,type from tbl_indxx where id='".$_GET['id']."'",true);
		$_SESSION['indxx_code']=$codequery['0']['code'];
		$_SESSION['indxx_type']=$codequery['0']['type'];
		
		$secquery=$this->db->getResult("select count(id) as securitycount from tbl_indxx_ticker where indxx_id='".$_GET['id']."'",true);
		$_SESSION['NewIndxxsecurities']=$secquery['0']['securitycount'];
		$this->Redirect("index.php?module=casecurities&event=addNew","","");
		}
	}
	
	protected function inserteddata(){
		 
		$this->_baseTemplate="inner-template2";
			$this->_bodyTemplate="caindex2/inserted";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','Index');
		$this->smarty->assign('bredcrumssubtitle','View Inserted New Index');
		

		
		
		if(isset($_POST['submit']))
		{
			
			
		$this->db->query("INSERT into tbl_indxx set name='".mysql_real_escape_string($_SESSION['InsertedData']['name'])."',code='".mysql_real_escape_string($_SESSION['InsertedData']['code'])."',investmentammount='".mysql_real_escape_string($_SESSION['InsertedData']['investmentammount'])."',divisor='".mysql_real_escape_string($_SESSION['InsertedData']['divisor'])."',type='".mysql_real_escape_string($_SESSION['InsertedData']['type'])."',curr='".mysql_real_escape_string($_SESSION['InsertedData']['curr'])."'");
		
		$indexid=mysql_insert_id();
		
		foreach($_SESSION['SecurityData'] as $key=>$val)
		{
			$this->db->query("INSERT into tbl_indxx_ticker set name='".mysql_real_escape_string($val['1'])."',isin='".mysql_real_escape_string($val['2'])."',ticker='".mysql_real_escape_string($val['3'])."',weight='".mysql_real_escape_string($val['4'])."',curr='".mysql_real_escape_string($val['5'])."',indxx_id='".$indexid."'");	
		}
			$this->Redirect("index.php?module=caindex&event=inserteddata","Record added successfully!!!","success");	
		}
		
		
		
		$inserteddata=$this->db->getResult("select tbl_indxx.*,tbl_index_types.name as indexname from tbl_indxx left join tbl_index_types on tbl_index_types.id=tbl_indxx.type where tbl_indxx.id='".$_GET['id']."'");
				
		$this->smarty->assign("inserteddata",$inserteddata);
		
		 $this->show();
			
	}
	
	
	protected function edit(){
		 
		$this->_baseTemplate="inner-template2";
			$this->_bodyTemplate="caindex2/edit";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','Index');
		$this->smarty->assign('bredcrumssubtitle','EditIndex');
		$this->addfield();
		
		
		
		if(isset($_POST['submit']))
		{
			$olddata=$this->db->getResult("select tbl_indxx.* from tbl_indxx  where tbl_indxx.id='".$_GET['id']."'");
			$oldtaskdata=$this->db->getResult("select tbl_project_task.name from tbl_project_task  where tbl_project_task.indxx_id='".$_GET['id']."'");
			//$this->pr($oldtaskdata);
		
		
		
			
		$this->db->query("UPDATE tbl_indxx set name='".mysql_real_escape_string($_POST['name'])."',code='".mysql_real_escape_string($_POST['code'])."',investmentammount='".mysql_real_escape_string($_POST['investmentammount'])."',divisor='".mysql_real_escape_string($_POST['divisor'])."',type='".mysql_real_escape_string($_POST['type'])."',curr='".mysql_real_escape_string($_POST['curr'])."',lastupdated='".date("Y-m-d H:i:s")."' where tbl_indxx.id='".$_GET['id']."'");
		
		$strQuery3 = "delete from tbl_project_task where tbl_project_task.indxx_id='".$_GET['id']."'";
			$this->db->query($strQuery3);
			
		
		
		 if($_POST['type']=='0')
		{
			
			
				$this->db->query("INSERT into tbl_project_task set name='Closing File for ".mysql_real_escape_string($_POST['code'])."',indxx_id='".$_GET['id']."'");
		}
		else if($_POST['type']=='1')
		{
			
			$this->db->query("INSERT into tbl_project_task set name='Opening File for ".mysql_real_escape_string($_POST['code'])."',indxx_id='".$_GET['id']."'");
			
			
			$this->db->query("INSERT into tbl_project_task set name='Closing File for ".mysql_real_escape_string($_POST['code'])."',indxx_id='".$_GET['id']."'");	
		}
		
		
		/*if($olddata['type']=='0')
		{
			if($_POST['type']=='1')
			{			
					
				$this->db->query("INSERT into tbl_project_task set name='Opening File for ".mysql_real_escape_string($_POST['code'])."',indxx_id='".$_GET['id']."'");
				
			
			}		
		}
		
		else if($olddata['type']=='1')
		{
			if($_POST['type']=='0')
			{
				$this->db->query("DELETE from tbl_project_task where indxx_id='".$_GET['id']."' and name='Opening File for ".mysql_real_escape_string($_POST['code'])."'");		
			}		
		}*/
		
		
		
		
		
			$this->Redirect("index.php?module=caindex&event=edit&id=".$_GET['id'],"Record updated successfully!!!","success");	

			//$_SESSION['UpdatedData']=$_POST;
			//$_SESSION['UpdatedId']=$_GET['id'];
			
		
				//$fields=array(1,2,3,4,5);		
				//$uploadsecuritydata = csv::import($fields,$_FILES['product_file']['tmp_name']);		
				//$_SESSION['UpdatedSecurityData']=$uploadsecuritydata;
				
				
		
		}
		
		
		
		
		
		
		
		
		$editdata=$this->db->getResult("select tbl_indxx.* from tbl_indxx  where tbl_indxx.id='".$_GET['id']."'");
		//$this->pr($editdata,true);
		$this->smarty->assign("postData",$editdata);
		
		
		
		
		 $this->show();
			
	}
	
	
	
	protected function editfornext(){
		 
		$this->_baseTemplate="inner-template2";
			$this->_bodyTemplate="caindex2/edit";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','Index');
		$this->smarty->assign('bredcrumssubtitle','Edit For Next Index');
		$this->addfield();
		$editdata=$this->db->getResult("select tbl_indxx.* from tbl_indxx  where tbl_indxx.id='".$_GET['id']."'");
		//$this->pr($editdata,true);
		$this->smarty->assign("postData",$editdata);
		
		
		
		
		$tempindexid=0;
		
		if(isset($_POST['submit']))
		{
			
			
			//$_SESSION['Index'][]=$indexid;
		
		$_SESSION['NewIndxxName']=$editdata['name'];
		$_SESSION['NewIndxxId']=$editdata['id'];
		$_SESSION['indxx_code']=$editdata['code'];
		$_SESSION['indxx_type']=$editdata['type'];
			
			
			$checkdata=$this->db->getResult("select tbl_indxx_temp.* from tbl_indxx_temp  where tbl_indxx_temp.code='".$_POST['code']."' and tbl_indxx_temp.dateStart='".$_POST['dateStart']."'");
			if(empty($checkdata))
			{
					
					
					
					
					
					$this->db->query("INSERT into tbl_indxx_temp set status='0',recalc='1',name='".mysql_real_escape_string($_POST['name'])."',code='".mysql_real_escape_string($_POST['code'])."',investmentammount='".mysql_real_escape_string($_POST['investmentammount'])."',indexvalue='".mysql_real_escape_string($_POST['indexvalue'])."',type='".mysql_real_escape_string($_POST['type'])."',curr='".mysql_real_escape_string($_POST['curr'])."',lastupdated='".date("Y-m-d H:i:s")."',dateStart='".$_POST['dateStart']."',client_id='".mysql_real_escape_string($_POST['client_id'])."',display_currency='".mysql_real_escape_string($_POST['display_currency'])."',ireturn='".mysql_real_escape_string($_POST['ireturn'])."',ica='".mysql_real_escape_string($_POST['ica'])."',currency_hedged='".mysql_real_escape_string($_POST['currency_hedged'])."'");
					
					$tempindexid=mysql_insert_id();
					
					if($_SESSION['User']['type']=='1')
					{
					$this->db->query("INSERT into tbl_assign_index_temp set user_id='".$_SESSION['User']['id']."',indxx_id='".mysql_real_escape_string($tempindexid)."',isAdmin='1'");
					}
					else
					{
						$this->db->query("INSERT into tbl_assign_index_temp set user_id='".$_SESSION['User']['id']."',indxx_id='".mysql_real_escape_string($tempindexid)."'");	
					}
					
			}
			
			else
			{
				//$this->pr($checkdata,true);	
				
				
				$tempindexid=$checkdata['id'];
				
				$this->db->query("UPDATE tbl_indxx_temp set status='0',recalc='1',name='".mysql_real_escape_string($_POST['name'])."',code='".mysql_real_escape_string($_POST['code'])."',investmentammount='".mysql_real_escape_string($_POST['investmentammount'])."',indexvalue='".mysql_real_escape_string($_POST['indexvalue'])."',type='".mysql_real_escape_string($_POST['type'])."',curr='".mysql_real_escape_string($_POST['curr'])."',lastupdated='".date("Y-m-d H:i:s")."',dateStart='".$_POST['dateStart']."',client_id='".mysql_real_escape_string($_POST['client_id'])."',display_currency='".mysql_real_escape_string($_POST['display_currency'])."',ireturn='".mysql_real_escape_string($_POST['ireturn'])."',ica='".mysql_real_escape_string($_POST['ica'])."',currency_hedged='".mysql_real_escape_string($_POST['currency_hedged'])."' where id='".$checkdata['id']."'");
				
				
			}
			
			$_SESSION['liveindexid']=$_GET['id'];
		$_SESSION['tempindexid']=$tempindexid;
		
			$this->Redirect("index.php?module=casecurities&event=edit2","Index updated successfully!!!<br> Please update associated securities!!!","success");
			
			}
		
		
		
		
		
		
		
		
		
		
		
		
		 $this->show();
			
	}
	
	
	
	
	protected function updateddata(){
		 
		$this->_baseTemplate="inner-template2";
			$this->_bodyTemplate="caindex2/updated";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','Index');
		$this->smarty->assign('bredcrumssubtitle','View Updated New Index');
		

		
		
		if(isset($_POST['submit']))
		{
			$this->db->query("UPDATE tbl_indxx set name='".mysql_real_escape_string($_SESSION['UpdatedData']['name'])."',code='".mysql_real_escape_string($_SESSION['UpdatedData']['code'])."',investmentammount='".mysql_real_escape_string($_SESSION['UpdatedData']['investmentammount'])."',divisor='".mysql_real_escape_string($_SESSION['UpdatedData']['divisor'])."',type='".mysql_real_escape_string($_SESSION['UpdatedData']['type'])."',curr='".mysql_real_escape_string($_SESSION['UpdatedData']['curr'])."' where tbl_indxx.id='".$_SESSION['UpdatedId']."'");
		
		
		foreach($_SESSION['UpdatedSecurityData'] as $key=>$val)
		{
			
			
			$this->db->query("UPDATE tbl_indxx_ticker set name='".mysql_real_escape_string($val['1'])."',isin='".mysql_real_escape_string($val['2'])."',ticker='".mysql_real_escape_string($val['3'])."',weight='".mysql_real_escape_string($val['4'])."',curr='".mysql_real_escape_string($val['5'])."',indxx_id='".$_SESSION['UpdatedId']."' where tbl_indxx_ticker.indxx_id='".$_SESSION['UpdatedId']." and isin='".mysql_real_escape_string($val['2'])."'");	
		}
			$this->Redirect("index.php?module=caindex&event=updateddata","Record updated successfully!!!","success");	
		}
		
		
		
		$updateddata=$this->db->getResult("select tbl_indxx.*,tbl_index_types.name as indexname from tbl_indxx left join tbl_index_types on tbl_index_types.id=tbl_indxx.type where tbl_indxx.id='".$_GET['id']."'");
				
		$this->smarty->assign("updateddata",$updateddata);
		
		 $this->show();
			
	}
	
	
	
	protected function delete(){
		 
		 $this->_baseTemplate="inner-template2";
			$this->_bodyTemplate="caindex2/delete";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','Index');
		$this->smarty->assign('bredcrumssubtitle','Deleted Index');
		
		if($_SESSION['User']['type']=='1' && $_GET['id'])
		{
		 $deleteddata=$this->db->getResult("select * from tbl_indxx where tbl_indxx.id='".$_GET['id']."'");
		$this->smarty->assign("deleteddata",$deleteddata);
		
		 $indexname=$deleteddata['name'];
		 $indexticker=$deleteddata['ticker'];
	
		
		 	$indxx=$deleteddata;
		//$this->pr($indxx,true);
		
		$indxxadmins =	$this->db->getResult('Select  user_id from tbl_assign_index where indxx_id="'.$_GET['id'].'" ',true);
$indxxadmin='';
//print_r($indxxadmins );
$emailto=array();

if(!empty($indxxadmins))
{
foreach($indxxadmins as $array)
{
	$emailto[]=$array['user_id'];
}


}

//print_r($emailto);

	//exit;
	if(!empty($emailto))
	{	
//	echo  'Select  email from tbl_ca_user where type="1" or id in ('.implode(',',$emailto).') ';
	$admins =	$this->db->getResult('Select  email from tbl_ca_user where type="1" or id in ('.implode(',',$emailto).') ',true);
	}
else
{	$admins =	$this->db->getResult('Select  email from tbl_ca_user where 1=1 ',true);
}
//$this->pr($admins,true);	
	
	$user=array();
	if(!empty($admins))	
	foreach($admins as $admin)
	{
	$user[]=$admin['email'];
	}
		
  $to=implode(',',$user);		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'From: Indexing <indexing@indxx.com>' . "\r\n"."CC: indexing@indxx.com". "\r\n";
$body='Hi <br>';
$body.='Your Indxx '.$indxx['name'].'('.$indxx['code'].') has been deleted by admin , <br> Please  <a href="'.$this->siteconfig->base_url.'index.php?module=caindex&event=view&id='.$_GET['id'].'">Click here </a> to do more.<br>Thanks ';


		mail($to,"ICAI : Indxx Deleted " ,$body,$headers);
		
		
	
		 
		 
		 
		 
		$strQuery = "delete from tbl_indxx where tbl_indxx.id='".$_GET['id']."'";
			$this->db->query($strQuery);
			
			
			$strQuery2 = "delete from tbl_indxx_ticker where tbl_indxx_ticker.indxx_id='".$_GET['id']."'";
			$this->db->query($strQuery2);
			
			$strQuery3 = "delete from tbl_project_task where tbl_project_task.indxx_id='".$_GET['id']."'";
			$this->db->query($strQuery3);
			
			$strQuery4 = "delete from tbl_assign_index where tbl_assign_index.indxx_id='".$_GET['id']."'";
			$this->db->query($strQuery4);
			
			$strQuery5 = "delete from tbl_indxx_value where tbl_indxx_value.indxx_id='".$_GET['id']."'";
			$this->db->query($strQuery4);
			
			
						
	//	echo "select * tbl_indxx where tbl_indxx.id='".$_GET['id']."'";
				
			
			
			
			
			
			
		}
		else
		{
				$this->Redirect("index.php?module=caindex","You are not authorized to perofrm this task!","error");
		}
			
			$this->show();
	}
	
	protected function deleteselected(){
		
		
		 
		 $this->_baseTemplate="inner-template2";
			$this->_bodyTemplate="caindex2/delete";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','Index');
		$this->smarty->assign('bredcrumssubtitle','Deleted Index');
		
		 $deleteddata=$this->db->getResult("select * from tbl_indxx where tbl_indxx.id='".$_GET['id']."'");
		$this->smarty->assign("deleteddata",$deleteddata);
		 
		$strQuery = "delete from tbl_indxx where tbl_indxx.id='".$_GET['id']."'";
			$this->db->query($strQuery);
			
			
			$strQuery2 = "delete from tbl_indxx_ticker where tbl_indxx_ticker.indxx_id='".$_GET['id']."'";
			$this->db->query($strQuery2);
			
			$strQuery3 = "delete from tbl_project_task where tbl_project_task.indxx_id='".$_GET['id']."'";
			$this->db->query($strQuery3);
			
			$strQuery4 = "delete from tbl_assign_index where tbl_assign_index.indxx_id='".$_GET['id']."'";
			$this->db->query($strQuery4);
			
			
			$this->show();
	}
	
	
	
	function upload()
	{
		
		//$this->_title="Upload ".$this->_section;			
		//$this->smarty->assign("title",$this->_title);		
		//$this->adduploadFeilds();	
	 
	 	$this->_baseTemplate="inner-template2";
			$this->_bodyTemplate="caindex2/upload";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','Index');
		$this->smarty->assign('bredcrumssubtitle','UploadedSecurities');
		
				
				
			$fields=array(1,2,3,4,5);		
				$uploadsecuritydata = csv::import($fields,$_FILES['product_file']['tmp_name']);	
//$this->pr($data,true);

$this->smarty->assign("uploadsecuritydata",$uploadsecuritydata);

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
					foreach($data as $key=> $row)
					{
					
					
					//$this->pr($users);
					
					
					//number_format(1.2378147769392E+14,0,'','')
					if($key>3)
					{ 
					///$row=explode(";",$users[0]);
					
					if(!empty($row) && $row[1]  && $row[5])
					{$total++;
				if($this->checkcamergent(mysql_real_escape_string($row[4]),mysql_real_escape_string($row[5]),date("Y-m-d",strtotime(mysql_real_escape_string($row[9]))),mysql_real_escape_string($row[10]))){	
				 $indxxs=$this->getIndxxnumbers($row['5']);
						
				if(!empty($indxxs))
						{foreach ($indxxs as $indxxv)
						{
							$indxx=$indxxv['indxx'];
				  $query="INSERT INTO `corporate_actions` (`name`, `isin`, `securityname`, `securityticker`, `securitysedol`, `securitycusip`, `securityric`, `type`, `effectivedate`, `amount`, `currency`, `furtherdetails`, `comment`, `totalsharesnew`, `freefloatfactornew`, `weightingcapfactornew`, `lastmodified`, `withholdingtax`,`indxx`,`source`) VALUES ('".mysql_real_escape_string($row[1])."', '".mysql_real_escape_string($row[2])."', '".mysql_real_escape_string($row[3])."', '".mysql_real_escape_string($row[4])."', '".mysql_real_escape_string($row[5])."', '".mysql_real_escape_string($row[6])."', '".mysql_real_escape_string($row[7])."', '".mysql_real_escape_string($row[8])."', '".date("Y-m-d",strtotime(mysql_real_escape_string($row[9])))."', '".mysql_real_escape_string($row[10])."', '".mysql_real_escape_string($row[11])."', '".mysql_real_escape_string($row[12])."', '".mysql_real_escape_string($row[13])."', '".mysql_real_escape_string($row[14])."', '".mysql_real_escape_string($row[15])."', '".mysql_real_escape_string($row[16])."', '".mysql_real_escape_string($row[17])."', '".mysql_real_escape_string($row[18])."','".$indxx."','Structured Sol.');";
					  //$this->db->query($query);
					   $insert++;
				}}}else{
					$update++; 
				}}
					
					
			
					}
					}
			//exit;	
			  }
			  $this->adminRedirect("index.php?module=".strtolower(get_class())."&event=upload",'success',"Total ".$total." Records "."<br/>".$insert." Records Inserted<br/>".$update." Records Skipped<br/>"  );
			 // header("location:".$this->baseUrl."index.php?module=addproduct&total=".$total."&insert=".$insert."&update=".$update); 
		     exit;
			
		  
     $this->show();	
	 
	
	}
function	submitapprove()
{
	
		 
		$this->_baseTemplate="inner-template2";
			$this->_bodyTemplate="caindex2/approve";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','Index');
		$this->smarty->assign('bredcrumssubtitle','Approved Index');
		
			if($_SESSION['User']['type']=='1' && $_GET['id'])
		{
		
		$viewdata=$this->db->getResult("select tbl_indxx_temp.name from tbl_indxx_temp where tbl_indxx_temp.id='".$_GET['id']."'",true);
		//$this->pr($viewdata,true);
		$this->smarty->assign("viewapprovedindex",$viewdata);
		
		
		$sequruityData=$this->db->getResult('SELECT * FROM tbl_indxx_ticker_temp where indxx_id="'.$_GET['id'].'"',true);
	//	$this->pr($sequruityData,true);
		//$this->smarty->assign("approvedindexSecurity",$sequruityData);
		$this->smarty->assign("approvedindexSecurityrows",count($sequruityData));
		
		
		
		$this->db->query("UPDATE tbl_indxx_temp set status='1' , submitted='1' where tbl_indxx_temp.id='".$_GET['id']."'");
		$this->db->query("UPDATE tbl_indxx_ticker_temp set status='1'  where indxx_id='".$_GET['id']."'");
		
		
		
		
		
		
		
		
				
	//	echo "select * tbl_indxx where tbl_indxx.id='".$_GET['id']."'";
			$indxx=$this->db->getResult("select * from tbl_indxx_temp  where id='".$_GET['id']."'");
		//$this->pr($indxx,true);
		
		$indxxadmins =	$this->db->getResult('Select  user_id from tbl_assign_index where indxx_id="'.$_GET['id'].'" union Select  user_id from tbl_assign_index_temp where indxx_id="'.$_GET['id'].'" ',true);
$indxxadmin='';
//print_r($indxxadmins );
$emailto=array();

if(!empty($indxxadmins))
{
foreach($indxxadmins as $array)
{
	$emailto[]=$array['user_id'];
}


}

//print_r($emailto);

//	exit;
	if(!empty($emailto))
	{	
//	echo  'Select  email from tbl_ca_user where type="1" or id in ('.implode(',',$emailto).') ';
	$admins =	$this->db->getResult('Select  email from tbl_ca_user where type="1" or id in ('.implode(',',$emailto).') ',true);
	}
else
{	$admins =	$this->db->getResult('Select  email from tbl_ca_user where 1=1 ',true);
}
//$this->pr($admins,true);	
	
	$user=array();
	if(!empty($admins))	
	foreach($admins as $admin)
	{
	$user[]=$admin['email'];
	}
		
  $to=implode(',',$user);		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'From: Indexing <indexing@indxx.com>' . "\r\n"."CC: indexing@indxx.com". "\r\n";
$body='Hi <br>';
$body.='Your Upcoming Indxx '.$indxx['name'].'('.$indxx['code'].') has been approved by admin , <br> Please  <a href="'.$this->siteconfig->base_url.'index.php?module=caindex2&event=viewupcoming&id='.$_GET['id'].'">Click here </a> to check it.<br>Thanks ';


		mail($to,"ICAI : Indxx Approved " ,$body,$headers);
		
		
		
		
		
		
		}
		else
		{
				$this->Redirect("index.php?module=caupcomingindex2","You are not authorized to perofrm this task!","error");
		}
		
		 $this->show();
			
	

}	
	 protected function approve(){
		 
		$this->_baseTemplate="inner-template2";
			$this->_bodyTemplate="caindex2/approve";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','Index');
		$this->smarty->assign('bredcrumssubtitle','Approved Index');
		
			if($_SESSION['User']['type']=='1' && $_GET['id'])
		{
		
		$viewdata=$this->db->getResult("select tbl_indxx.name from tbl_indxx where tbl_indxx.id='".$_GET['id']."'",true);
		//$this->pr($viewdata,true);
		$this->smarty->assign("viewapprovedindex",$viewdata);
		
		
		$sequruityData=$this->db->getResult('SELECT * FROM tbl_indxx_ticker where indxx_id="'.$_GET['id'].'"',true);
	//	$this->pr($sequruityData,true);
		//$this->smarty->assign("approvedindexSecurity",$sequruityData);
		$this->smarty->assign("approvedindexSecurityrows",count($sequruityData));
		
		
		
		$this->db->query("UPDATE tbl_indxx set status='1' where tbl_indxx.id='".$_GET['id']."'");
			$this->db->query("UPDATE tbl_indxx_ticker set status='1' where indxx_id='".$_GET['id']."'");
		
		
		
		
		
		
		
		
				
	//	echo "select * tbl_indxx where tbl_indxx.id='".$_GET['id']."'";
			$indxx=$this->db->getResult("select * from tbl_indxx  where tbl_indxx.id='".$_GET['id']."'");
		//$this->pr($indxx,true);
		
		$indxxadmins =	$this->db->getResult('Select  user_id from tbl_assign_index where indxx_id="'.$_GET['id'].'" union Select  user_id from tbl_assign_index_temp where indxx_id="'.$_GET['id'].'" ',true);
$indxxadmin='';
//print_r($indxxadmins );
$emailto=array();

if(!empty($indxxadmins))
{
foreach($indxxadmins as $array)
{
	$emailto[]=$array['user_id'];
}


}

//print_r($emailto);

	//exit;
	if(!empty($emailto))
	{	
//	echo  'Select  email from tbl_ca_user where type="1" or id in ('.implode(',',$emailto).') ';
	$admins =	$this->db->getResult('Select  email from tbl_ca_user where type="1" or id in ('.implode(',',$emailto).') ',true);
	}
else
{	$admins =	$this->db->getResult('Select  email from tbl_ca_user where 1=1 ',true);
}
//$this->pr($admins,true);	
	
	$user=array();
	if(!empty($admins))	
	foreach($admins as $admin)
	{
	$user[]=$admin['email'];
	}
		
  $to=implode(',',$user);		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'From: Indexing <indexing@indxx.com>' . "\r\n"."CC: indexing@indxx.com". "\r\n";
$body='Hi <br>';
$body.='Your Indxx '.$indxx['name'].'('.$indxx['code'].') has been approved by admin , <br> Please  <a href="'.$this->siteconfig->base_url.'index.php?module=caindex&event=view&id='.$_GET['id'].'">Click here </a> to check it.<br>Thanks ';


		mail($to,"ICAI : Indxx Approved " ,$body,$headers);
		
		
		
		
		
		
		}
		else
		{
				$this->Redirect("index.php?module=caindex","You are not authorized to perofrm this task!","error");
		}
		
		 $this->show();
			
	}
	
	
	
	protected function approvetemp(){
		 
		$this->_baseTemplate="inner-template2";
			$this->_bodyTemplate="caindex2/approve";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','Index');
		$this->smarty->assign('bredcrumssubtitle','Approved Index');
		
			if($_SESSION['User']['type']=='1' && $_GET['id'])
		{
		
		$viewdata=$this->db->getResult("select tbl_indxx_temp.name from tbl_indxx_temp where tbl_indxx_temp.id='".$_GET['id']."'",true);
		//$this->pr($viewdata,true);
		$this->smarty->assign("viewapprovedindex",$viewdata);
		
		
		$sequruityData=$this->db->getResult('SELECT * FROM tbl_indxx_ticker_temp where indxx_id="'.$_GET['id'].'" ',true);
	//	$this->pr($sequruityData,true);
		//$this->smarty->assign("approvedindexSecurity",$sequruityData);
		$this->smarty->assign("approvedindexSecurityrows",count($sequruityData));
		
		
		
		$this->db->query("UPDATE tbl_indxx_temp set status='1' where tbl_indxx_temp.id='".$_GET['id']."'");
		
		$this->db->query("UPDATE tbl_indxx_ticker_temp set status='1' where indxx_id='".$_GET['id']."'");
		
		
		
		
		
		
				
	//	echo "select * tbl_indxx where tbl_indxx.id='".$_GET['id']."'";
			$indxx=$this->db->getResult("select * from tbl_indxx_temp  where tbl_indxx_temp.id='".$_GET['id']."'");
		//$this->pr($indxx,true);
		
		$indxxadmins =	$this->db->getResult('Select  user_id from tbl_assign_index where indxx_id="'.$_GET['id'].'" union Select  user_id from tbl_assign_index_temp where indxx_id="'.$_GET['id'].'" ',true);
$indxxadmin='';
//print_r($indxxadmins );
$emailto=array();

if(!empty($indxxadmins))
{
foreach($indxxadmins as $array)
{
	$emailto[]=$array['user_id'];
}


}

//print_r($emailto);

	//exit;
	if(!empty($emailto))
	{	
//	echo  'Select  email from tbl_ca_user where type="1" or id in ('.implode(',',$emailto).') ';
	$admins =	$this->db->getResult('Select  email from tbl_ca_user where type="1" or id in ('.implode(',',$emailto).') ',true);
	}
else
{	$admins =	$this->db->getResult('Select  email from tbl_ca_user where 1=1 ',true);
}
//$this->pr($admins,true);	

$dbusers =	$this->db->getResult('Select  email from tbl_database_users where 1=1 ',true);

	
	$user=array();
	if(!empty($admins))	
	foreach($admins as $admin)
	{
	$user[]=$admin['email'];
	}
	if(!empty($dbusers))	
	foreach($dbusers as $admin)
	{
	$user[]=$admin['email'];
	}
$user=array_unique($user);
 $to=implode(',',$user);		
	$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'From: Indexing <indexing@indxx.com>' . "\r\n"."CC: indexing@indxx.com". "\r\n";
$body='Hi <br>';
$body.='New Upcoming Indxx '.$indxx['name'].'('.$indxx['code'].') has been approved by admin , <br> Please  <a href="'.$this->siteconfig->base_url.'index.php?module=caindex2&event=view&id='.$_GET['id'].'">Click here </a> to check it.<br>Thanks ';


		mail($to,"ICAI : Indxx Approved " ,$body,$headers);
		
		
		
		
		
		
		}
		else
		{
				$this->Redirect("index.php?module=caindex2","You are not authorized to perofrm this task!","error");
		}
		
		 $this->show();
			
	}
	
	
	
	 protected function reject(){
		 
		$this->_baseTemplate="inner-template2";
			$this->_bodyTemplate="caindex2/reject";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','Index');
		$this->smarty->assign('bredcrumssubtitle','Approved Index');
		
		
		 //$indexname=$['name'];
		// $indexticker=$_POST['ticker'];
		if($_SESSION['User']['type']=='1' && $_GET['id'])
		{
		
		
		$this->db->query("update tbl_indxx_temp set submitted='0' where id='".$_GET['id']."'");
		
	//	echo "select * tbl_indxx where tbl_indxx.id='".$_GET['id']."'";
			$indxx=$this->db->getResult("select * from tbl_indxx_temp  where tbl_indxx_temp.id='".$_GET['id']."'");
		//$this->pr($indxx,true);
		
		$indxxadmins =	$this->db->getResult('Select  user_id from tbl_assign_index_temp where indxx_id="'.$_GET['id'].'" union Select  user_id from tbl_assign_index_temp where indxx_id="'.$_GET['id'].'" ',true);
$indxxadmin='';
//print_r($indxxadmins );
$emailto=array();

if(!empty($indxxadmins))
{
foreach($indxxadmins as $array)
{
	$emailto[]=$array['user_id'];
}


}

//print_r($emailto);

	//exit;
	if(!empty($emailto))
	{	
//	echo  'Select  email from tbl_ca_user where type="1" or id in ('.implode(',',$emailto).') ';
	$admins =	$this->db->getResult('Select  email from tbl_ca_user where type="1" or id in ('.implode(',',$emailto).') ',true);
	}
else
{	$admins =	$this->db->getResult('Select  email from tbl_ca_user where 1=1 ',true);
}
//$this->pr($admins,true);	
	
	$user=array();
	if(!empty($admins))	
	foreach($admins as $admin)
	{
	$user[]=$admin['email'];
	}
		
  $to=implode(',',$user);		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'From: Indexing <indexing@indxx.com>' . "\r\n"."CC: indexing@indxx.com". "\r\n";
$body='Hi <br>';
$body.='Your Indxx '.$indxx['name'].'('.$indxx['code'].') has been rejected by admin , <br> Please  <a href="'.$this->siteconfig->base_url.'index.php?module=caindex&event=view&id='.$_GET['id'].'">Click here </a> to check it.<br>Thanks ';


		mail($to,"ICAI : Indxx rejected " ,$body,$headers);
		
		
		
		
		}
			else
		{
				$this->Redirect("index.php?module=caindex","You are not authorized to perofrm this task!","error");
		}
		
		 $this->show();
			
	}
	
	
	
		
	 protected function finalsignoff(){
		 
		$this->_baseTemplate="inner-template2";
			$this->_bodyTemplate="caindex2/finalsignoff";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','Index');
		$this->smarty->assign('bredcrumssubtitle','Approved Index');
		
		
		 //$indexname=$['name'];
		// $indexticker=$_POST['ticker'];
		if($_SESSION['User']['type']=='1' && $_GET['id'])
		{
		
		
		$this->db->query("update tbl_indxx_temp set finalsignoff='1' where id='".$_GET['id']."'");
		
	//	echo "select * tbl_indxx where tbl_indxx.id='".$_GET['id']."'";
			$indxx=$this->db->getResult("select * from tbl_indxx_temp  where tbl_indxx_temp.id='".$_GET['id']."'");
		//$this->pr($indxx,true);
		
		$indxxadmins =	$this->db->getResult('Select  user_id from tbl_assign_index_temp where indxx_id="'.$_GET['id'].'" union Select  user_id from tbl_assign_index_temp where indxx_id="'.$_GET['id'].'" ',true);
$indxxadmin='';
//print_r($indxxadmins );
$emailto=array();

if(!empty($indxxadmins))
{
foreach($indxxadmins as $array)
{
	$emailto[]=$array['user_id'];
}


}

//print_r($emailto);

	//exit;
	if(!empty($emailto))
	{	
//	echo  'Select  email from tbl_ca_user where type="1" or id in ('.implode(',',$emailto).') ';
	$admins =	$this->db->getResult('Select  email from tbl_ca_user where type="1" or id in ('.implode(',',$emailto).') ',true);
	}
else
{	$admins =	$this->db->getResult('Select  email from tbl_ca_user where 1=1 ',true);
}
//$this->pr($admins,true);	
	
	$user=array();
	if(!empty($admins))	
	foreach($admins as $admin)
	{
	$user[]=$admin['email'];
	}
		
  $to=implode(',',$user);		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'From: Indexing <indexing@indxx.com>' . "\r\n"."CC: indexing@indxx.com". "\r\n";
$body='Hi <br>';
$body.='Your Indxx '.$indxx['name'].'('.$indxx['code'].') - Final Signoff has been done  by admin , <br><br>Thanks ';


		mail($to,"ICAI : Indxx Final Signoff done " ,$body,$headers);
		
		
		
		
		}
			else
		{
				$this->Redirect("index.php?module=caindex2","You are not authorized to perofrm this task!","error");
		}
		
		 $this->show();
			
	}
	
	
	
	 protected function rejectbydbuser(){
		 
		$this->_baseTemplate="inner-template2";
			$this->_bodyTemplate="caindex2/reject";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','Index');
		$this->smarty->assign('bredcrumssubtitle','Rejected Index');
		
		
		 //$indexname=$['name'];
		// $indexticker=$_POST['ticker'];
		if($_SESSION['User']['type']=='3' && $_GET['id'])
		{
			//	echo "select * tbl_indxx where tbl_indxx.id='".$_GET['id']."'";
			$indxx=$this->db->getResult("select * from tbl_indxx_temp  where tbl_indxx_temp.id='".$_GET['id']."'");
		//$this->pr($indxx,true);
		
		$indxxadmins =	$this->db->getResult('Select  user_id from tbl_assign_index_temp where indxx_id="'.$_GET['id'].'" union Select  user_id from tbl_assign_index_temp where indxx_id="'.$_GET['id'].'" ',true);
$indxxadmin='';
//print_r($indxxadmins );
$emailto=array();

if(!empty($indxxadmins))
{
foreach($indxxadmins as $array)
{
	$emailto[]=$array['user_id'];
}


}

//print_r($emailto);

	//exit;
	if(!empty($emailto))
	{	
//	echo  'Select  email from tbl_ca_user where type="1" or id in ('.implode(',',$emailto).') ';
	$admins =	$this->db->getResult('Select  email from tbl_ca_user where type="1" or id in ('.implode(',',$emailto).') ',true);
	}
else
{	$admins =	$this->db->getResult('Select  email from tbl_ca_user where 1=1 ',true);
}
//$this->pr($admins,true);	
	
	$user=array();
	if(!empty($admins))	
	foreach($admins as $admin)
	{
	$user[]=$admin['email'];
	}
		
  $to=implode(',',$user);		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'From: Indexing <indexing@indxx.com>' . "\r\n"."CC: indexing@indxx.com". "\r\n";
$body='Hi <br>';
$body.='Your upcoming indxx '.$indxx['name'].'('.$indxx['code'].') has been rejected by database user , <br> Please  <a href="'.$this->siteconfig->base_url.'index.php?module=caindex2&event=viewupcoming&id='.$_GET['id'].'">Click here </a> to check it.<br>Thanks ';


		mail($to,"ICAI : Upcoming Indxx Rejected " ,$body,$headers);
		
		
		
		
		}
			else
		{
				$this->Redirect("index.php?module=caupcomingindex2","You are not authorized to perofrm this task!","error");
		}
		
		 $this->show();
			
	}
	
	
	
	function signoff()
	{
		if($_SESSION['User']['type']=='2' && $_GET['id'])
		{
		$query=$this->db->Query("update tbl_indxx set usersignoff='1' where tbl_indxx.id='".$_GET['id']."'");
		//echo "deepak";
		
		
		
					
		$indxx=$this->db->getResult("select * from tbl_indxx where tbl_indxx.id='".$_GET['id']."'");
	$indxxadmins =	$this->db->getResult('Select  user_id from tbl_assign_index where indxx_id="'.$_GET['id'].'" ',true);
$indxxadmin='';
//print_r($indxxadmins );
$emailto=array();

if(!empty($indxxadmins))
{
foreach($indxxadmins as $array)
{
	$emailto[]=$array['user_id'];
}


}

//print_r($emailto);

	//exit;
	if(!empty($emailto))
	{	
//	echo  'Select  email from tbl_ca_user where type="1" or id in ('.implode(',',$emailto).') ';
	$admins =	$this->db->getResult('Select  email from tbl_ca_user where type="1" or id in ('.implode(',',$emailto).') ',true);
	}
else
{	$admins =	$this->db->getResult('Select  email from tbl_ca_user where type="1" ',true);
}
//$this->pr($admins,true);	
	
	$user=array();
	if(!empty($admins))	
	foreach($admins as $admin)
	{
	$user[]=$admin['email'];
	}
 $to=implode(',',$user);	
	
//		exit;	

		
//		mail()
		//echo $admins;
		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'From: Indexing <indexing@indxx.com>' . "\r\n"."CC: indexing@indxx.com". "\r\n";
$body='Hi <br>';
$body.='Signoff has been done for indxx '.$indxx['name'].'('.$indxx['code'].') by '.$_SESSION['User']['name'].', <br> Please  <a href="'.$this->siteconfig->base_url.'index.php?module=caindex&event=view&id='.$_GET['id'].'">Click here </a> to check it.<br>Thanks ';


		mail($to,"ICAI : Index Signoff done " ,$body,$headers);
		
		
		
		
		$this->Redirect("index.php?module=caindex","Record updated successfully!!!","success");	
		}
		else
		{
				$this->Redirect("index.php?module=caindex","You are not authorized to perofrm this task!","error");
		}
		//
	}
	
	
	
	function signofftemp()
	{
	
		$indxx=$this->db->getResult("select * from tbl_indxx_temp where tbl_indxx_temp.id='".$_GET['id']."'");
	
	if(($indxx['indexvalue']=='' || $indxx['indexvalue']==0 )&& $indxx['recalc']!=1)
	{
		
		$this->Redirect("index.php?module=caupcomingindex2&event=editfornext&id=".$_GET['id'],"You are not authorized to perofrm this task!","error");
	}
	
	
		if($_SESSION['User']['type']=='2' && $_GET['id'])
		{
		$query=$this->db->Query("update tbl_indxx_temp set usersignoff='1' where tbl_indxx_temp.id='".$_GET['id']."'");
		//echo "deepak";
		
		
		
					
		$indxx=$this->db->getResult("select * from tbl_indxx_temp where tbl_indxx_temp.id='".$_GET['id']."'");
	$indxxadmins =	$this->db->getResult('Select  user_id from tbl_assign_index_temp where indxx_id="'.$_GET['id'].'"  union Select  user_id from tbl_assign_index_temp where indxx_id="'.$_GET['id'].'"',true);
$indxxadmin='';
//print_r($indxxadmins );
$emailto=array();

if(!empty($indxxadmins))
{
foreach($indxxadmins as $array)
{
	$emailto[]=$array['user_id'];
}


}

//print_r($emailto);

	//exit;
	if(!empty($emailto))
	{	
//	echo  'Select  email from tbl_ca_user where type="1" or id in ('.implode(',',$emailto).') ';
	$admins =	$this->db->getResult('Select  email from tbl_ca_user where type="1" or id in ('.implode(',',$emailto).') ',true);
	}
else
{	$admins =	$this->db->getResult('Select  email from tbl_ca_user where type="1" ',true);
}
//$this->pr($admins,true);	
	
	$user=array();
	if(!empty($admins))	
	foreach($admins as $admin)
	{
	$user[]=$admin['email'];
	}
 $to=implode(',',$user);	
	
//		exit;	

		
//		mail()
		//echo $admins;
		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'From: Indexing <indexing@indxx.com>' . "\r\n"."CC: indexing@indxx.com". "\r\n";
$body='Hi <br>';
$body.='Signoff has been done for indxx '.$indxx['name'].'('.$indxx['code'].') by '.$_SESSION['User']['name'].', <br> Please  <a href="'.$this->siteconfig->base_url.'index.php?module=caupcomingindex2&event=view&id='.$_GET['id'].'">Click here </a> to check it.<br>Thanks ';


	mail($to,"ICAI : Index Signoff done " ,$body,$headers);
		
		
		/*echo "<script>window.open('http://97.74.65.118/icai/index.php?module=calcindxxclosingid&id=".$_GET['id']."');</script>";*/
		
	
		
		
		$this->Redirect("index.php?module=caupcomingindex2","Record updated successfully!!!".$filetext,"success");	
		}
		else
		{
				$this->Redirect("index.php?module=caupcomingindex2","You are not authorized to perofrm this task!","error");
		}
		//
	}
	
	
	
	
	function subrequest()
	{
		if($_SESSION['User']['type']=='3' && $_GET['id'])
		{
		$query=$this->db->Query("update tbl_indxx set dbusersignoff='1' where tbl_indxx.id='".$_GET['id']."'");
		//echo "deepak";
		
				
		$indxx=$this->db->getResult("select * from tbl_indxx where tbl_indxx.id='".$_GET['id']."'");
	$indxxadmins =	$this->db->getResult('Select  user_id from tbl_assign_index where indxx_id="'.$_GET['id'].'" ',true);
$indxxadmin='';
//print_r($indxxadmins );
$emailto=array();

if(!empty($indxxadmins))
{
foreach($indxxadmins as $array)
{
	$emailto[]=$array['user_id'];
}


}

//print_r($emailto);

	//exit;
	if(!empty($emailto))
	{	
//	echo  'Select  email from tbl_ca_user where type="1" or id in ('.implode(',',$emailto).') ';
	$admins =	$this->db->getResult('Select  email from tbl_ca_user where type="1" or id in ('.implode(',',$emailto).') ',true);
	}
else
{	$admins =	$this->db->getResult('Select  email from tbl_ca_user where type="1" ',true);
}
//$this->pr($admins,true);	
	
	$user=array();
	if(!empty($admins))	
	foreach($admins as $admin)
	{
	$user[]=$admin['email'];
	}
 $to=implode(',',$user);	
	
//		exit;	

		
//		mail()
		//echo $admins;
		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'From: Indexing <indexing@indxx.com>' . "\r\n"."CC: indexing@indxx.com". "\r\n";
$body='Hi <br>';
$body.='Request File Submission has been done for indxx '.$indxx['name'].'('.$indxx['code'].') by IT Team, <br> Please  <a href="'.$this->siteconfig->base_url.'index.php?module=caindex&event=view&id='.$_GET['id'].'">Click here </a> to check it.<br>Thanks ';


		mail($to,"ICAI : Request File Submission Done by Database Team" ,$body,$headers);
		
		
		
		
		$this->Redirect("index.php?module=caindex","Record updated successfully!!!","success");	
		}
		else
		{
				$this->Redirect("index.php?module=caindex","You are not authorized to perofrm this task!","error");
		}
		//
	}
	
	
	function subrequesttemp()
	{
		if($_SESSION['User']['type']=='3' && $_GET['id'])
		{
		$query=$this->db->Query("update tbl_indxx_temp set dbusersignoff='1' where tbl_indxx_temp.id='".$_GET['id']."'");
		//echo "deepak";
		
				
		$indxx=$this->db->getResult("select * from tbl_indxx_temp where tbl_indxx_temp.id='".$_GET['id']."'");
	$indxxadmins =	$this->db->getResult('Select  user_id from tbl_assign_index_temp where indxx_id="'.$_GET['id'].'"   union Select  user_id from tbl_assign_index_temp where indxx_id="'.$_GET['id'].'"',true);
$indxxadmin='';
//print_r($indxxadmins );
$emailto=array();

if(!empty($indxxadmins))
{
foreach($indxxadmins as $array)
{
	$emailto[]=$array['user_id'];
}


}

//print_r($emailto);

	//exit;
	if(!empty($emailto))
	{	
//	echo  'Select  email from tbl_ca_user where type="1" or id in ('.implode(',',$emailto).') ';
	$admins =	$this->db->getResult('Select  email from tbl_ca_user where type="1" or id in ('.implode(',',$emailto).') ',true);
	}
else
{	$admins =	$this->db->getResult('Select  email from tbl_ca_user where type="1" ',true);
}
//$this->pr($admins,true);	
	
	$user=array();
	if(!empty($admins))	
	foreach($admins as $admin)
	{
	$user[]=$admin['email'];
	}
 $to=implode(',',$user);	
	
//		exit;	

		
//		mail()
		//echo $admins;
		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'From: Indexing <indexing@indxx.com>' . "\r\n"."CC: indexing@indxx.com". "\r\n";
$body='Hi <br>';
$body.='Request File Submission has been done for indxx '.$indxx['name'].'('.$indxx['code'].') by IT Team, <br> Please  <a href="'.$this->siteconfig->base_url.'index.php?module=caindex&event=view&id='.$_GET['id'].'">Click here </a> to check it.<br>Thanks ';


		mail($to,"ICAI : Request File Submission Done by Database Team" ,$body,$headers);
		
		
		
		
		$this->Redirect("index.php?module=caupcomingindex2","Record updated successfully!!!","success");	
		}
		else
		{
				$this->Redirect("index.php?module=caupcomingindex2","You are not authorized to perofrm this task!","error");
		}
		//
	}
	
	
	
	function subindex()
	{
		if($_SESSION['User']['type']=='2' && $_GET['id'])
		{
$query=$this->db->Query("update tbl_indxx set submitted='1' where tbl_indxx.id='".$_GET['id']."'");
		//echo "deepak";
		
		
		$indxx=$this->db->getResult("select * from tbl_indxx where tbl_indxx.id='".$_GET['id']."'");
	$admins =	$this->db->getResult('Select  email from tbl_ca_user where type="1" ');
//$this->pr($admins,true);	
	if(!empty($admins))	
	 $to=implode(',',$admins);
	//exit;	
		
//		mail()
		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'From: Indexing <indexing@indxx.com>' . "\r\n"."CC: indexing@indxx.com". "\r\n";
$body='Hi <br>';
$body.='You have new indxx for Approval, <br> Please  <a href="'.$this->siteconfig->base_url.'index.php?module=caindex&event=view&id='.$_GET['id'].'">Click here </a> to check it.<br>Thanks ';


		mail($to,"ICAI : New indxx submitted for Approval" ,$body,$headers);
		
		
		$this->Redirect("index.php?module=caindex","Record updated successfully!!!","success");	
		}
		else
		{
				$this->Redirect("index.php?module=caindex","You are not authorized to perofrm this task!","error");
		}
		//
	}
	
	
	function subindextemp()
	{
		
		if($_GET['id'])
		{
$query=$this->db->Query("update tbl_indxx_temp set submitted='1' where tbl_indxx_temp.id='".$_GET['id']."'");
		//echo "deepak";
		
		
		$indxx=$this->db->getResult("select * from tbl_indxx_temp where tbl_indxx_temp.id='".$_GET['id']."'");
		$this->smarty->assign("indxx",$indxx);
	$admins =	$this->db->getResult('Select  email from tbl_ca_user where type="1" ');
//$this->pr($admins,true);	
	if(!empty($admins))	
	 $to=implode(',',$admins);
	//exit;	
		
//		mail()
		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'From: Indexing <indexing@indxx.com>' . "\r\n"."CC: indexing@indxx.com". "\r\n";
$body='Hi <br>';
$body.='You have new upcoming indxx for Approval, <br> Please  <a href="'.$this->siteconfig->base_url.'index.php?module=caindex2&event=viewupcoming&id='.$_GET['id'].'">Click here </a> to check it.<br>Thanks ';


		mail($to,"ICAI : New Upcoming indxx submitted for Approval" ,$body,$headers);
		
		
		$this->Redirect("index.php?module=caupcomingindex2","Record updated successfully!!!","success");	
		}
		else
		{
				$this->Redirect("index.php?module=caupcomingindex2","You are not authorized to perofrm this task!","error");
		}
		//
	}
	
	
	function calcshare()
	{
		
		$this->_baseTemplate="inner-template2";
			$this->_bodyTemplate="caindex2/calcshare";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','Shares');
		$this->smarty->assign('bredcrumssubtitle','Calculated Shares');
		
		
		
		$viewdata=$this->db->getResult("select tbl_indxx_temp.*,tbl_index_types.name as indexname from tbl_indxx_temp left join tbl_index_types on tbl_index_types.id=tbl_indxx_temp.type where tbl_indxx_temp.id='".$_GET['id']."'",true);
		//$this->pr($viewdata,true);
		$this->smarty->assign("viewindexdata",$viewdata);
		
		
		$sequruityData=$this->db->getResult('SELECT * FROM tbl_indxx_ticker_temp where indxx_id="'.$_GET['id'].'"',true);
	//	$this->pr($sequruityData,true);
		$this->smarty->assign("indexSecurity",$sequruityData);
		$this->smarty->assign("totalindexSecurityrows",count($sequruityData));
		
		
		
		$selectIndexQuery="Select * from tbl_indxx_temp where id='".$_GET['id']."'";
		$resIndxx=mysql_query($selectIndexQuery);
		$datevalue=date("Y-m-d",strtotime($this->_date )-86400);
	$price_array=array();
	
		$insert=0;
		$update=0;

		if (mysql_num_rows($resIndxx)>0)
		{
			while($row=mysql_fetch_assoc($resIndxx))
			{
				
				$sharetotal=0;
				$investAmmount=$row['investmentammount'];
				
				$query="SELECT  fp.isin, fp.price,(select weight from tbl_indxx_ticker_temp it where it.isin=fp.isin and it.indxx_id=fp.indxx_id) as 					calcweight from tbl_final_price fp where fp.date='".$datevalue."' and fp.indxx_id='".$row['id']."'";
				
				$res=mysql_query($query);
		
				$share=array();
		//echo "<pre>";
				//	echo "Displaying ".mysql_num_rows($res)." records for id=".$row['id']."<br>";
				while($result=mysql_fetch_assoc($res))
				{
					//print_r($result);
					$share[$result['isin']]['isin']=$result['isin'];
					$share[$result['isin']]['finalprice']=number_format($result['price'],10, '.', '');
					$share[$result['isin']]['weight']=number_format($result['calcweight'],10, '.', '');
					$share[$result['isin']]['share']=number_format((($investAmmount*$result['calcweight'])/$result['price']),10, '.', '');				$share[$result['isin']]['ticker']=$this->getTickerfromISIN($row['id'],$result['isin']);
				//	$share[$row['id']][$result['isin']]=number_format((($investAmmount*$result['calcweight'])/$result['price']),50, '.', '');
			
				}
	//	exit;
				
		
				
			}

		}
		
				
		//$this->pr($sharedata,true);
		$this->smarty->assign("sharedata",$share);
		
		
 $this->show();
	
	}
	
	function exportupcomming()
	{
	
	$viewdata=$this->db->getResult("select tbl_indxx_temp.*,tbl_index_types.name as indextype from tbl_indxx_temp left join tbl_index_types on tbl_index_types.id=tbl_indxx_temp.type where tbl_indxx_temp.id='".$_GET['id']."'",true);
	//$this->pr($viewdata,true);
	$sequruityData=$this->db->getResult('SELECT * FROM tbl_indxx_ticker_temp where indxx_id="'.$_GET['id'].'"',true);
	$shareData=$this->db->getResult('SELECT * FROM tbl_share_temp where indxx_id="'.$_GET['id'].'"',true);
	
	$shares=array();
	if(!empty($shareData))
	{
	foreach($shareData as $share)
	{
	$shares[$share['isin']]=$share['share'];
	}
	}
	
	require 'php-excel.class.php';
	
	$data = array(
        1 => array ('Name', 'Code', 'Investment Amount', 'Index Value', 'Currency'),
        2 => array ($viewdata[0]['name'],$viewdata[0]['code'], $viewdata[0]['investmentammount'], $viewdata[0]['indexvalue'],$viewdata[0]['curr']),
        3 => array ('Security Name', 'Ticker', 'ISIN', 'Weight','Share', 'Currency'),
	  
	    );
	



//$rowdata[]=array($share[$exceldata['isin']]['ticker'],$exceldata['isin'],$exceldata['calcweight'],$share[$exceldata['isin']]['share'],number_format($exceldata['price'],10,'.',''));	
		// generate file (constructor parameters are optional)

		$xls = new Excel_XML('UTF-8', false, 'indxx-data-'.$viewdata[0]['code']."-".$this->_date);
		$xls->addArray($data);
		$moredata=array();
	$k=4;
foreach($sequruityData as $data)
		{
			$moredata[$k++]=array($data['name'],$data['ticker'],$data['isin'],$data['weight'],$shares[$data['isin']],$data['curr']);
			
		
		}
		$xls->addArray(	$moredata);
		
		
		
		
$xls->generateXML('indxx-data-'.$viewdata[0]['code']."-".$this->_date);		
	}
	
	
	 function getTickerfromISIN($indxx_id,$isin)
	 {
		$sharedata=$this->db->getResult("Select ticker from tbl_indxx_ticker_temp where indxx_id='".$indxx_id."' and isin='".$isin."'",true);
	return $sharedata[0]['ticker'];
	}
	
	
	
	
	function download()
	{
		require 'php-excel.class.php';
		$datevalue=date("Y-m-d",strtotime($this->_date )-86400);
		
		
		
		$selectIndexQuery="Select * from tbl_indxx_temp where id='".$_GET['id']."'";
		$resIndxx=mysql_query($selectIndexQuery);
		$row=mysql_fetch_assoc($resIndxx);
		$investAmmount=$row['investmentammount'];
		
		
			
		//echo "select * from tbl_ca_user where 1=1";
		$excelres=mysql_query(
		
		
		
		
		
		"SELECT  fp.isin, fp.price,(select weight from tbl_indxx_ticker_temp it where it.isin=fp.isin and it.indxx_id=fp.indxx_id) as 					calcweight from tbl_final_price fp where fp.date='".$datevalue."' and fp.indxx_id='".$_GET['id']."'");
		
		$share=array();		
		$rowdata=array();
		while($exceldata=mysql_fetch_assoc($excelres))
		{
				
				
				$share[$exceldata['isin']]['isin']=$exceldata['isin'];
					$share[$exceldata['isin']]['finalprice']=number_format($exceldata['price'],10, '.', '');
					$share[$exceldata['isin']]['weight']=number_format($exceldata['calcweight'],10, '.', '');
					$share[$exceldata['isin']]['share']=number_format((($investAmmount*$exceldata['calcweight'])/$exceldata['price']),10, '.', '');				$share[$exceldata['isin']]['ticker']=$this->getTickerfromISIN($_GET['id'],$exceldata['isin']);
				
				$rowdata[]=array($share[$exceldata['isin']]['ticker'],$exceldata['isin'],$exceldata['calcweight'],$share[$exceldata['isin']]['share'],number_format($exceldata['price'],10,'.',''));
		}

		
		// create a simple 2-dimensional array
		$data = array(
        1 => array ('Ticker', 'Isin', 'Weight', 'Share', 'Last Price'),
        //array('Schwarz', 'Oliver'),
        //array('Test', 'Peter')
        );
		
		// generate file (constructor parameters are optional)
		$xls = new Excel_XML('UTF-8', false, 'Share Data');
		$xls->addArray($data);
		foreach($rowdata as $key1=>$val1)
		{
			$excelarray = array(
        	1 => $val1,
        	);
			//print_r($excelarray);
			$xls->addArray($excelarray);
		}
		
		
		$xls->generateXML('Share Data');		
	}
	
	
	
	
	function update()
	{
		
		
			$selectIndexQuery="Select * from tbl_indxx_temp where id='".$_GET['id']."'";
		$resIndxx=mysql_query($selectIndexQuery);
		$datevalue=date("Y-m-d",strtotime($this->_date )-86400);
	$price_array=array();
	
		$insert=0;
		$update=0;

		if (mysql_num_rows($resIndxx)>0)
		{
			while($row=mysql_fetch_assoc($resIndxx))
			{
				
				$sharetotal=0;
				$investAmmount=$row['investmentammount'];
				
				$query="SELECT  fp.isin, fp.price,(select weight from tbl_indxx_ticker_temp it where it.isin=fp.isin and it.indxx_id=fp.indxx_id) as 					calcweight from tbl_final_price fp where fp.date='".$datevalue."' and fp.indxx_id='".$row['id']."'";
				
				$res=mysql_query($query);
		
				$share=array();
		//echo "<pre>";
				//	echo "Displaying ".mysql_num_rows($res)." records for id=".$row['id']."<br>";
				while($result=mysql_fetch_assoc($res))
				{
					//print_r($result);
					$share[$result['isin']]['isin']=$result['isin'];
					$share[$result['isin']]['finalprice']=number_format($result['price'],10, '.', '');
					$share[$result['isin']]['weight']=number_format($result['calcweight'],10, '.', '');
					$share[$result['isin']]['share']=number_format((($investAmmount*$result['calcweight'])/$result['price']),10, '.', '');				$share[$result['isin']]['ticker']=$this->getTickerfromISIN($row['id'],$result['isin']);
				//	$share[$row['id']][$result['isin']]=number_format((($investAmmount*$result['calcweight'])/$result['price']),50, '.', '');
				
				
				}
		//exit;
				$sharedata=$this->db->query("delete from tbl_share_temp where indxx_id='".$row['id']."'",true);
				
					foreach($share as $key2=>$value2)
					{
						//echo $key2."=>".$value2."<br>";
						
						$check=$this->Checkvalues($key2,$row['id'],$datevalue);
						 if($check)
						{
						
							$updatesharequery="update tbl_share_temp set dateAdded=SYSDATE(),share='".$value2['share']."' where indxx_id='".$row['id']."' and isin='".$key2."' and date='".$datevalue."'";
				
							mysql_query($updatesharequery);
				
						$update++;	
						}
						else
						{
							$inshareQuery="insert into tbl_share_temp(indxx_id,isin,date,share) values('".$row['id']."','".$key2."','".$datevalue.	"','".$value2['share']."')";
							mysql_query($inshareQuery);
						$insert++;
						}
					
		//	echo number_format($sharetotal ,50, '.', '')."<br>";
				}
				
				
			}

		}

		
		$this->Redirect("index.php?module=caindex&event=calcshare&id=".$_GET['id'],"Record updated successfully!!!","success");	
		$this->show();
			
	}
	
	
	function Checkvalues($isin,$indxxid,$dateval)
		{
			
			
		 	 $matchfilequery="select * from tbl_share_temp where isin='".$isin."' and date='".$dateval."' and indxx_id='".$indxxid."' ";
			$resmatchfile=mysql_query($matchfilequery);
		
			if(mysql_num_rows($resmatchfile)>0)	
			{
				return true;
			}
			else
			{
				return false;	
			}		
		}
	
	function viewtemp()
	{
		echo "Jyoti";		
	}
	
	
	
	
	protected function subadjfactor(){
		 
		$this->_baseTemplate="inner-template2";
			$this->_bodyTemplate="caindex2/adjfactor";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','Adjustment Factor');
		$this->smarty->assign('bredcrumssubtitle','Submit Adjustment Factor');
		
		
		
		
		if(isset($_POST['submit']))
		{
				$this->db->query("INSERT into tbl_user_ca_adj_factor set status='0',date='".date("Y-m-d")."',ticker_id='".$_GET['id']."',indxx_id='".$_GET['indxx_id']."',user_id='".$_SESSION['User']['id']."',factor='".$_POST['factor']."'");
		
		
		$securityname=$this->db->getResult("Select name,ticker from tbl_indxx_ticker where id='".$_GET['id']."'",true);
		
		
		$admins =$this->db->getResult("Select  email from tbl_ca_user where type='1'",true);

//$this->pr($admins,true);	
	
	$user=array();
	if(!empty($admins))	
	foreach($admins as $admin)
	{
	$user[]=$admin['email'];
	}
		
  $to=implode(',',$user);	
  
		$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'From: Indexing <indexing@indxx.com>' . "\r\n"."CC: indexing@indxx.com". "\r\n";
$body='Hi <br>';
$body.=$_SESSION['User']['name'].' has added adjustment factor for security '.$securityname['0']['name'].'('.$securityname['0']['ticker'].')  , <br> Please approve the same. <br> Please visit '.$this->siteconfig->base_url.'index.php?module=approveadjfactor to do more.<br>Thanks ';


		mail($to,"ICAI : Approve Adjacent Factor " ,$body,$headers);
		
		
		
			$this->Redirect("index.php?module=caindex&event=view&id=".$_GET['indxx_id'],"Record updated successfully!!!","success");	

			}
		
		
		
		
		
		
		
		
		$editdata=$this->db->getResult("select tbl_indxx_ticker.isin,tbl_indxx_ticker.ticker,tbl_indxx_ticker.name from tbl_indxx_ticker  where tbl_indxx_ticker.id='".$_GET['id']."'");
		//$this->pr($editdata,true);
		$this->smarty->assign("postData",$editdata);
		
		$this->addfieldadjfactor($editdata['name']);
		
		
		 $this->show();
			
	}
	
} // class ends here

?>