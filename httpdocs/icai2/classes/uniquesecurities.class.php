<?php

class Uniquesecurities extends Application{

	function __construct()
	{
		parent::__construct();
		
		$this->checkUserSession();
	}
	
	
	function index()
	{
		
		$this->_baseTemplate="inner-template";
	$this->_bodyTemplate="uniquesecurities/index";
		$this->_title=$this->siteconfig->site_title;
		$this->_meta_description=$this->siteconfig->default_meta_description;
		$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
//	$this->addfield();

		$this->smarty->assign('pagetitle','Unique Securities List');
		$this->smarty->assign('bredcrumssubtitle','Unique Securities');

$this->addCss('assets/data-tables/DT_bootstrap.css');
$this->addJs('assets/bootstrap/bootstrap.min.js');
$this->addJs('assets/nicescroll/jquery.nicescroll.min.js');
$this->addJs('assets/data-tables/jquery.dataTables.js');
$this->addJs('assets/data-tables/DT_bootstrap.js');
$this->addJs('js/flaty.js');

		//$username=$_SESSION['User']['name'];
		//$userdata=$this->db->getResult("select tbl_ca_user.id as userid,tbl_ca_user.name as username,tbl_ca_user.email,tbl_ca_user.type,count(tbl_indxx.name) as indexes from tbl_assign_index left join tbl_ca_user on tbl_ca_user.id=tbl_assign_index.user_id left join tbl_indxx on tbl_indxx.id=tbl_assign_index.indxx_id group by tbl_ca_user.name");
		
		$userdata=$this->db->getResult("(select distinct(ticker) as ticker from tbl_indxx_ticker where tbl_indxx_ticker.status='1' )union (select distinct(ticker) as ticker from tbl_indxx_ticker_temp where tbl_indxx_ticker_temp.status='1' ) union (select distinct(ticker) as ticker from tbl_runnsecurities_replaced) union (select distinct(ticker) as ticker from tbl_tempsecurities_replaced ) union (select distinct(ticker) as ticker from tbl_spin_stock_add_securities ) union (select distinct(ticker) as ticker from tbl_spin_stock_add_securities_temp )",true);
		
		$this->smarty->assign("userdata",$userdata);

	//$this->pr($userdata,true);
	
		//$this->pr($_SESSION);
		 $this->show();
	}
	
	function addNew()
	{
			$this->_baseTemplate="inner-template";
			$this->_bodyTemplate="uniquesecurities/add";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','Users');
		$this->smarty->assign('bredcrumssubtitle','AddUser');
		
		
		if(isset($_POST['submit']))
		{
		$this->db->query("INSERT into tbl_ca_user set status='1',name='".mysql_real_escape_string($_POST['name'])."',email='".mysql_real_escape_string($_POST['email'])."',password='".mysql_real_escape_string($_POST['password'])."',type='".mysql_real_escape_string($_POST['type'])."'");
		$msg='Hi '.$_POST['name'].', You are added to ICAI Portal, <br> Login Email  : '.$_POST['email']."<br>Login Passowrd : ".$_POST['password']."<br> Please Visit <a href='". $this->siteconfig->base_url ."'>". $this->siteconfig->base_url ."</a><br> thanks ";
				$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'From: Indexing <indexing@indxx.com>' . "\r\n"."CC: indexing@indxx.com". "\r\n";		
		if(mail($_POST['email'],"ICAI Account Details ",$msg,$headers))
		{
			echo "Mail sent to : ".$to."<br>";	
		}
		
		
			$this->Redirect("index.php?module=users&event=addNew","Record added successfully!!!","success");	
		}
			
			$this->addfield();
			 $this->show();
	}
	
	
	private function addfield($edit=false)
	{	
	   $this->validData[]=array("feild_label" =>"Name",
	   								"feild_code" =>"name",
								 "feild_type" =>"text",
								 "is_required" =>"1",
								
								 );
		 $this->validData[]=array("feild_label" =>"Email",
		 							"feild_code" =>"email",
								 "feild_type" =>"text",
								 "is_required" =>"1",
								
			 );
			
			if($edit=="true")
			{					
								 
		 $this->validData[]=array("feild_label" =>"Password",
		 							"feild_code" =>"password",
								 "feild_type" =>"password",								
								 );
								 
			}
			else
			{
				
				$this->validData[]=array("feild_label" =>"Password",
		 							"feild_code" =>"password",
								 "feild_type" =>"password",
								 "is_required" =>"1",
								
								 );
					
			}
								 
		
	 $this->validData[]=array("feild_label" =>"Type",
	 							"feild_code" =>"type",
								 "feild_type" =>"select",
								 "is_required" =>"1",
								 //"feild_tpl" =>"selectsearch",
								  "model"=>$this->getUsers(),
								 );
								 
								 
								 
	/*$this->validData[]=array("feild_label" =>"Indxx",
	 							"feild_code" =>"indxx_id",
								 "feild_type" =>"select",
								 "is_required" =>"1",
								 //"feild_tpl" =>"selectsearch",
								  "model"=>$this->getIndexes(),
								 );*/
								 
								 
	
	$this->getValidFeilds();
	}
	
	
	function exportExcel()
	{
		
		require 'php-excel.class.php';
		
		//echo "select * from tbl_ca_user where 1=1";
		$excelres=mysql_query(
		"select distinct(ticker) as ticker from tbl_indxx_ticker where  tbl_indxx_ticker.status='1' union select distinct(ticker) as ticker from tbl_indxx_ticker_temp where tbl_indxx_ticker_temp.status='1' union select distinct(ticker) as ticker from tbl_runnsecurities_replaced where 1=1 union select distinct(ticker) as ticker from tbl_tempsecurities_replaced union select distinct(ticker) as ticker from `tbl_spin_stock_add_securities`  union select distinct(ticker) as ticker from `tbl_spin_stock_add_securities_temp` where 1=1");
		$rowdata=array();
		while($exceldata=mysql_fetch_assoc($excelres))
		{
				//print_r($exceldata);
				$rowdata[]=array($exceldata['ticker']);
		}

		
		// create a simple 2-dimensional array
		$data = array(
        1 => array ('Name'),
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
		
		
		$xls->generateXML('UniqueSecuritiesData');	
	}
	
	
	
	 protected function view(){
		 
		$this->_baseTemplate="inner-template";
			$this->_bodyTemplate="uniquesecurities/view";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','User Index');
		$this->smarty->assign('bredcrumssubtitle','View Indexes');
	
	
	$this->addCss('assets/data-tables/DT_bootstrap.css');
$this->addJs('assets/bootstrap/bootstrap.min.js');
$this->addJs('assets/nicescroll/jquery.nicescroll.min.js');
$this->addJs('assets/data-tables/jquery.dataTables.js');
$this->addJs('assets/data-tables/DT_bootstrap.js');
$this->addJs('js/flaty.js');
	
		$viewdata=$this->db->getResult("select tbl_ca_user.id as userid,tbl_ca_user.name as username,tbl_ca_user.email,tbl_ca_user.type,tbl_assign_index.*,tbl_indxx.name as indexname,tbl_indxx.id as indexid from tbl_assign_index left join tbl_ca_user on tbl_ca_user.id=tbl_assign_index.user_id left join tbl_indxx on tbl_indxx.id=tbl_assign_index.indxx_id where tbl_assign_index.user_id='".$_GET['id']."'",true);
		
		$_SESSION['Delete']['UserId']=$viewdata['0']['userid'];
		
		$this->smarty->assign("viewdata",$viewdata);
		
		 $this->show();
			
	}
	
	
	protected function edit(){
		 
		$this->_baseTemplate="inner-template";
			$this->_bodyTemplate="uniquesecurities/edit";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','Users');
		$this->smarty->assign('bredcrumssubtitle','Edit Users');
		$this->addfield("true");
		
		
		if(isset($_POST['submit']))
		{
			
			if(!empty($_POST['password']))
			{
						
				$this->db->query("UPDATE tbl_ca_user set name='".mysql_real_escape_string($_POST['name'])."',email='".mysql_real_escape_string($_POST['email'])."',type='".mysql_real_escape_string($_POST['type'])."',password='".mysql_real_escape_string($_POST['password'])."' where id='".$_GET['id']."'");	
			}
			else
			{	
					
		$this->db->query("UPDATE tbl_ca_user set name='".mysql_real_escape_string($_POST['name'])."',email='".mysql_real_escape_string($_POST['email'])."',type='".mysql_real_escape_string($_POST['type'])."' where id='".$_GET['id']."'");
			}
					
			$this->Redirect("index.php?module=users","Record updated successfully!!!","success");	
		}
		
		
		
		$editdata=$this->db->getResult("select tbl_ca_user.* from tbl_ca_user  where tbl_ca_user.id='".$_GET['id']."'");
		//$this->pr($editdata,true);
		$this->smarty->assign("postData",$editdata);
		
		
		
		
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
					$strQuery1 = "delete from tbl_ca_user where tbl_ca_user.id='".$val2."'";
					$this->db->query($strQuery1);
					
					
					$strQuery = "delete from tbl_assign_index where tbl_assign_index.user_id='".$val2."'";
					$this->db->query($strQuery);
			}
			}
		}
		$this->Redirect("index.php?module=users","Records deleted successfully!!!","success");
		$this->show();	
	}
	
	
	
	protected function delete(){
		
		 	$strQuery1 = "delete from tbl_ca_user where tbl_ca_user.id='".$_GET['id']."'";
					$this->db->query($strQuery1);
					
									
					$strQuery = "delete from tbl_assign_index where tbl_assign_index.user_id='".$_GET['id']."'";
					$this->db->query($strQuery);
			
			$this->Redirect("index.php?module=users","Record deleted successfully!!!","success");
			
			$this->show();
			
			
	}
	
	protected function deleteassigned(){
		
								
					$indexdata = $this->db->getResult("select name,code from tbl_indxx  where tbl_indxx.id='".$_GET['id']."'");
					
					$indexname=$indexdata['name'];
					
					$indexticker=$indexdata['code'];
					
					$strQuery = "delete from tbl_assign_index where tbl_assign_index.user_id='".$_SESSION['Delete']['UserId']."' and indxx_id='".$_GET['id']."'";
					//$this->db->query($strQuery);
					
					
					$getmailid=$this->db->getResult("select name,email from tbl_ca_user  where tbl_ca_user.id='".$_SESSION['Delete']['UserId']."'");
										
					$to1=$getmailid['email'];
				$name1=$getmailid['name'];
				mail($to1,"New Index Added","<html>
				<body>
					<p>Hello $name1,</p>
					<p>Your assigned index $indexname with code $indexticker has been deleted.</p>
				</body>
				</html>");	
					
					
					$databaseuserdata=$this->db->getResult("select tbl_database_users.* from tbl_database_users where 1=1");
					
					foreach($databaseuserdata as $key=>$val)
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
					<p>Index $indexname with ticker $indexticker of user $name1 has been deleted.</p>
				</body>
				</html>");	
			}
					
					
			$this->Redirect("index.php?module=users","Record deleted successfully!!!","success");
			
			$this->show();
			
			
	}
	
	
	function deleteassignedindex()
	{
		//$this->pr($_POST);
		foreach($_POST as $key=>$val)
		{
			foreach($val as $key2=>$val2)
			{
				if(!empty($val2))
				{
					$indexdata = $this->db->getResult("select name,code from tbl_indxx  where tbl_indxx.id='".$val2."'");
					
					$indexname=$indexdata['name'];
					
					$indexticker=$indexdata['code'];	
					
					
					$strQuery = "delete from tbl_assign_index where tbl_assign_index.indxx_id='".$val2."' and user_id='".$_SESSION['Delete']['UserId']."'";
					//$this->db->query($strQuery);
					
					$getmailid=$this->db->getResult("select name,email from tbl_ca_user  where tbl_ca_user.id='".$_SESSION['Delete']['UserId']."'");
					
					$to1=$getmailid['email'];
				$name1=$getmailid['name'];
				mail($to1,"New Index Added","<html>
				<body>
					<p>Hello $name1,</p>
					<p>Your assigned index $indexname with code $indexticker has been deleted.</p>
					<p>Please update the respective files.</p>
				</body>
				</html>");	
				
				

				foreach($databaseuserdata as $key=>$val)
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
					<p>Index $indexname with ticker $indexticker of user $name1 has been deleted.</p>
					<p>Please update the respective files.</p>
				</body>
				</html>");	
			}
				
				
			}
			}
		}
		
		$this->Redirect("index.php?module=users","Records deleted successfully!!!","success");
		$this->show();	
	}
	
	
	
	
	
	
} // class ends here

?>