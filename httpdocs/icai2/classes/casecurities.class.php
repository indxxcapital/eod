<?php

class Casecurities extends Application{

	function __construct()
	{
		parent::__construct();
		$this->addCss('assets/data-tables/DT_bootstrap.css');
$this->addJs('assets/bootstrap/bootstrap.min.js');
$this->addJs('assets/nicescroll/jquery.nicescroll.min.js');
$this->addJs('assets/data-tables/jquery.dataTables.js');
$this->addJs('assets/data-tables/DT_bootstrap.js');
$this->addJs('js/flaty.js');


	}
	
	
	function index()
	{
		
		$this->_baseTemplate="inner-template";
	$this->_bodyTemplate="casecurities/index";
		$this->_title=$this->siteconfig->site_title;
		$this->_meta_description=$this->siteconfig->default_meta_description;
		$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
//	$this->addfield();

		$this->smarty->assign('pagetitle','Index');
		$this->smarty->assign('bredcrumssubtitle','Index');



		$indexdata=$this->db->getResult("select tbl_indxx_ticker.*,tbl_indxx.code as indexname from tbl_indxx_ticker left join tbl_indxx on tbl_indxx.id=tbl_indxx_ticker.indxx_id where 1=1 ");
		$this->smarty->assign("indexdata",$indexdata);

	//$this->pr($indexdata,true);
	
		//$this->pr($_SESSION);
		 $this->show();
	}
	
	function addNew()
	{
			$this->_baseTemplate="inner-template";
			$this->_bodyTemplate="casecurities/add";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','Index');
		$this->smarty->assign('bredcrumssubtitle','AddIndex');
		
		if(!empty($_POST))
		{
				//	$this->pr($_POST,true);
	
	
	
		$this->db->query("INSERT into tbl_indxx_ticker set name='".mysql_real_escape_string($_POST['name'])."',isin='".mysql_real_escape_string($_POST['isin'])."',ticker='".mysql_real_escape_string($_POST['ticker'])."',weight='".mysql_real_escape_string($_POST['weight'])."',curr='".mysql_real_escape_string($_POST['curr'])."',indxx_id='".mysql_real_escape_string($_POST['indxx_id'])."'");
		
	/*	if($_SESSION['NewIndxxId'])	*/

if($_POST['saveandnext'])
{
	//$this->pr( $_SESSION,true);
	//exit;
	
		$this->Redirect("index.php?module=casecurities&event=addNew","Record added successfully!! <br>".(++$_SESSION['NewIndxxsecurities'])." Security(s) Added for Indxx ".$_SESSION['indxx_code'],"success");	
}
else
{
	//$this->pr($_SESSION,true);
	
	
	 $indexname=$_POST['name'];
		 $indexticker=$_POST['ticker'];
		 $indexid=$_POST['indxx_id'];
		 
		 
		 if($_SESSION['indxx_type']=='0')
		{
			
			
				$this->db->query("INSERT into tbl_project_task set name='Closing File for ".mysql_real_escape_string($_SESSION['indxx_code'])."',indxx_id='".$indexid."'");
		}
		else if($_SESSION['indxx_type']=='1')
		{
			
			$this->db->query("INSERT into tbl_project_task set name='Opening File for ".mysql_real_escape_string($_SESSION['indxx_code'])."',indxx_id='".$indexid."'");
			
			
			$this->db->query("INSERT into tbl_project_task set name='Closing File for ".mysql_real_escape_string($_SESSION['indxx_code'])."',indxx_id='".$indexid."'");	
		}

	$this->db->query("UPDATE tbl_indxx set submitted='1' where id='".$_POST['indxx_id']."''");
	
	/*$databaseuserdata=$this->db->getResult("select tbl_database_users.* from tbl_database_users where 1=1");
	
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
					<p>A new index $indexname with ticker $indexticker has been added.</p>
					<p>Please update the respective files.</p>
				</body>
				</html>");	
			}
			
	$adminuserdata=$this->db->getResult("select tbl_ca_user.* from tbl_ca_user where type='1'",true);
	
	foreach($adminuserdata as $key=>$val)
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
			}
	
	
	
	$assigneduserdata=$this->db->getResult("select tbl_assign_index.*,tbl_ca_user.name as username,tbl_indxx.* from tbl_assign_index left join tbl_ca_user on tbl_assign_index.user_id=tbl_ca_user.id left join tbl_indxx on tbl_indxx.id=tbl_assign_index.indxx_id where indxx_id='".$_POST['indxx_id']."'",true);
	
	foreach($assigneduserdata as $key=>$val)
			{
				
				$headers = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

				// Additional headers
				//$headers .= 'From: Jyoti Sharma <jsharma@indxx.com>' . "\r\n";

				//$headers .= 'Reply-To: jsharma@indxx.com' . "\r\n" ;
				
				
				$to=$val['email'];
				$name=$val['username'];
				mail($to,"New Index Added","<html>
				<body>
					<p>Hello $name,</p>
					<p>Your index $indexname with ticker $indexticker has been added.</p>
				</body>
				</html>");	
			}*/
	
	

///mail send to admin as well as db user 
//$this->pr($_SESSION,true);
unset($_SESSION['indxx_type']);
unset($_SESSION['indxx_code']);
unset($_SESSION['NewIndxxId']);
unset($_SESSION['NewIndxxsecurities']);
	$this->Redirect("index.php?module=caindex","Index added successfully!!! <br> Please Wait for Approval","success");	

	}


		}
		
	
			
			$this->addfield();
			 $this->show();
	}
		function addNew2()
	{
			$this->_baseTemplate="inner-template";
			$this->_bodyTemplate="casecurities/add2";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','Index');
		$this->smarty->assign('bredcrumssubtitle','Add Securities');
		
		$totalfields=30;
		$this->smarty->assign('totalfields',$totalfields);
		
		$this->addfield2($totalfields);
		
		$added=0;
		
		
		if($_POST['submit'])
		{
			for($i=1;$i<$_POST['totalfields'];$i++)
			{
				if($_POST['name'][$i] && $_POST['isin'][$i] && $_POST['ticker'][$i] && $_POST['weight'][$i] && $_POST['curr'][$i])
				{
					//$this->pr($_POST,true);	
					$this->db->query("INSERT into tbl_indxx_ticker_temp set status='0',name='".mysql_real_escape_string($_POST['name'][$i])."',isin='".mysql_real_escape_string($_POST['isin'][$i])."',ticker='".mysql_real_escape_string($_POST['ticker'][$i])."',weight='".mysql_real_escape_string($_POST['weight'][$i])."',curr='".mysql_real_escape_string($_POST['curr'][$i])."',indxx_id='".mysql_real_escape_string($_SESSION['NewIndxxId'])."'");
					$added++;
		
				}	
			}
			
			
			if($added>=1)
		{
			$this->Redirect("index.php?module=casecurities&event=addNewNext&id=".$added,"Index added successfully!!! <br> Please Wait for Approval","success");	
		}
		else
		{
			$this->Redirect("index.php?module=casecurities&event=addNew2","No security added!!! <br> Please add again","error");	
		}
		}
		
		
		
			 $this->show();
	}
	
		function addNewforRunning()
	{
			$this->_baseTemplate="inner-template";
			$this->_bodyTemplate="casecurities/addforrunning";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','Index');
		$this->smarty->assign('bredcrumssubtitle','Add Securities');
		
		$totalfields=30;
		$this->smarty->assign('totalfields',$totalfields);
		
		$this->addfieldforrunning($totalfields);
		
		$added=0;
		
		
		if($_POST['submit'])
		{
			for($i=1;$i<=$_POST['totalfields'];$i++)
			{
				if($_POST['name'][$i] && $_POST['isin'][$i] && $_POST['ticker'][$i] && $_POST['curr'][$i])
				{
					//$this->pr($_POST,true);	
					$this->db->query("INSERT into tbl_indxx_ticker_temp set status='0',name='".mysql_real_escape_string($_POST['name'][$i])."',isin='".mysql_real_escape_string($_POST['isin'][$i])."',ticker='".mysql_real_escape_string($_POST['ticker'][$i])."',weight='0',curr='".mysql_real_escape_string($_POST['curr'][$i])."',divcurr='".mysql_real_escape_string($_POST['divcurr'][$i])."',indxx_id='".mysql_real_escape_string($_SESSION['NewIndxxId'])."'");
					//$this->db->query("INSERT into tbl_share_temp set isin='".mysql_real_escape_string($_POST['isin'][$i])."',share='".mysql_real_escape_string($_POST['share'][$i])."',date='".$this->_date."',indxx_id='".mysql_real_escape_string($_SESSION['NewIndxxId'])."'");
					
					
					
					$added++;
		
				}	
			}
			
			
			if($added>=1)
		{
			$this->Redirect("index.php?module=casecurities&event=addNewNextrunning&id=".$added,"Index added successfully!!! <br> Please Wait for Approval","success");	
		}
				else
		{
			$this->Redirect("index.php?module=casecurities&event=addNewforRunning","No security added!!! <br> Please add again","error");	
		}
		}
		
		
		
			 $this->show();
	}
	
		function uploadSecuritiesforRunning2()
	{
			
		//	$this->pr($_SESSION,true);
			
			$this->_baseTemplate="inner-template";
			$this->_bodyTemplate="casecurities/uploadforrunning";
			
			
			if(isset($_POST['submit'])){
		
		//$this->pr($_FILES);
			if($this->validatPost()){	
			$fields=array("1",'2','3','4','5','6','7','8');		
				$data = csv::import($fields,$_FILES['inputfile']['tmp_name']);	
//$this->pr($data,true);
	$added=0;
		
				if(!empty($data))
				{
					foreach($data as $security)
					{
						if($security[2]!='' && $security[3]!='')
						{
						$this->db->query("INSERT into tbl_indxx_ticker_temp set status='0',name='".mysql_real_escape_string($security[1])."',isin='".mysql_real_escape_string($security[2])."',ticker='".mysql_real_escape_string($security[3])."',weight='0',curr='".mysql_real_escape_string($security[4])."',divcurr='".mysql_real_escape_string($security[5])."',sedol='".mysql_real_escape_string($security[6])."',cusip='".mysql_real_escape_string($security[7])."',countryname='".mysql_real_escape_string($security[8])."',indxx_id='".mysql_real_escape_string($_SESSION['tempindexid'])."'");
						
							$added++;
		
						}
					}
				}

	if($added>=1)
		{
			$this->Redirect("index.php?module=casecurities&event=addNewNextrunning&id=".$added,"Index added successfully!!! <br> Please Wait for Approval","success");	
		}
				else
		{
			$this->Redirect("index.php?module=casecurities&event=addNewforRunning","No security added!!! <br> Please add again","error");	
		}

			}
			}
			
		
	$this->uploadfield2();
	
	 $this->show();
	
	}
	function uploadSecuritiesforRunning()
	{
		$this->_baseTemplate="inner-template";
			$this->_bodyTemplate="casecurities/uploadforrunning";
			
			
			if(isset($_POST['submit'])){
		
		//$this->pr($_FILES);
			if($this->validatPost()){	
			$fields=array("1",'2','3','4','5','6','7','8');		
				$data = csv::import($fields,$_FILES['inputfile']['tmp_name']);	
//$this->pr($data,true);
	$added=0;
		
				if(!empty($data))
				{
					foreach($data as $security)
					{
						if($security[2]!='' && $security[3]!='')
						{
						$this->db->query("INSERT into tbl_indxx_ticker_temp set status='0',name='".mysql_real_escape_string($security[1])."',isin='".mysql_real_escape_string($security[2])."',ticker='".mysql_real_escape_string($security[3])."',weight='0',curr='".mysql_real_escape_string($security[4])."',divcurr='".mysql_real_escape_string($security[5])."',sedol='".mysql_real_escape_string($security[6])."',cusip='".mysql_real_escape_string($security[7])."',countryname='".mysql_real_escape_string($security[8])."',indxx_id='".mysql_real_escape_string($_SESSION['NewIndxxId'])."'");
						
							$added++;
		
						}
					}
				}

	if($added>=1)
		{
			$this->Redirect("index.php?module=casecurities&event=addNewNextrunning&id=".$added,"Index added successfully!!! <br> Please Wait for Approval","success");	
		}
				else
		{
			$this->Redirect("index.php?module=casecurities&event=addNewforRunning","No security added!!! <br> Please add again","error");	
		}

			}
			}
			
		
	$this->uploadfield2();
	
	 $this->show();
	
	}
	
	function uploadfield2(){
		 $this->validData[]=array("feild_label" =>"Security input sheet",
		 							"feild_code" =>"inputfile",
								 "feild_type" =>"file",
								 "is_required" =>"1",
								
								 );
		
	$this->getValidFeilds();
	}
	
	function edit2()
	{
		//$this->pr($_SESSION,true);
			$this->_baseTemplate="inner-template";
			$this->_bodyTemplate="casecurities/add2";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','Index');
		$this->smarty->assign('bredcrumssubtitle','Add Securities');
		
		
		$indexdata=$this->db->getResult("select tbl_indxx_temp.* from tbl_indxx_temp where id='".$_SESSION['tempindexid']."' ");
		
	//	echo "select tbl_indxx_ticker.* from tbl_indxx_ticker where indxx_id='".$_SESSION['liveindexid']."' ";
		$tickerdata=$this->db->getResult("select tbl_indxx_ticker.* from tbl_indxx_ticker where indxx_id='".$_SESSION['liveindexid']."' ",true);
		//$this->pr($tickerdata,true);
		//$this->smarty->assign("indexdata",$indexdata);

		
		if(count($tickerdata)>0)
		{
			$totalfields=count($tickerdata);	
		}
		else
		{
		$totalfields=30;
		}
		
		$array=array();
		$remainingfieldsarray=array();
		
		for($i=0;$i<$totalfields;$i++)
		{
			$array['name['.($i+1).']']=$tickerdata[$i]['name'];
			
			$array['isin['.($i+1).']']=$tickerdata[$i]['isin'];
			$array['ticker['.($i+1).']']=$tickerdata[$i]['ticker'];
			$array['weight['.($i+1).']']=$tickerdata[$i]['weight'];
			$array['curr['.($i+1).']']=$tickerdata[$i]['curr'];
			$array['divcurr['.($i+1).']']=$tickerdata[$i]['divcurr'];
			
			$remainingfieldsarray[$tickerdata[$i]['isin']]['sedol']=$tickerdata[$i]['sedol'];
			$remainingfieldsarray[$tickerdata[$i]['isin']]['cusip']=$tickerdata[$i]['cusip'];
			$remainingfieldsarray[$tickerdata[$i]['isin']]['countryname']=$tickerdata[$i]['countryname'];
			
			//$array[]=	
		}
		
		
		$this->smarty->assign('postData',$array);
		$this->smarty->assign('totalfields',$totalfields);
		
		$this->addfield2($totalfields);
		
		$added=0;
		
		
		if($_POST['submit'])
		{
			
			
			
				$this->db->query("delete from tbl_indxx_ticker_temp where indxx_id='".$_SESSION['NewIndxxId']."'");
			
			for($i=1;$i<=$_POST['totalfields'];$i++)
			{
				if($_POST['name'][$i] && $_POST['isin'][$i] && $_POST['ticker'][$i] && $_POST['divcurr'][$i] && $_POST['curr'][$i])
				{
					if(array_key_exists($_POST['isin'][$i],$remainingfieldsarray))
					{
						$this->db->query("INSERT into tbl_indxx_ticker_temp set status='0',name='".mysql_real_escape_string($_POST['name'][$i])."',isin='".mysql_real_escape_string($_POST['isin'][$i])."',ticker='".mysql_real_escape_string($_POST['ticker'][$i])."',weight='".mysql_real_escape_string($_POST['weight'][$i])."',curr='".mysql_real_escape_string($_POST['curr'][$i])."',divcurr='".mysql_real_escape_string($_POST['divcurr'][$i])."',indxx_id='".mysql_real_escape_string($_SESSION['tempindexid'])."',sedol='".$remainingfieldsarray[$_POST['isin'][$i]]['sedol']."',cusip='".$remainingfieldsarray[$_POST['isin'][$i]]['cusip']."',countryname='".$remainingfieldsarray[$_POST['isin'][$i]]['countryname']."'");	
					}
					else
					{
						$this->db->query("INSERT into tbl_indxx_ticker_temp set status='0',name='".mysql_real_escape_string($_POST['name'][$i])."',isin='".mysql_real_escape_string($_POST['isin'][$i])."',ticker='".mysql_real_escape_string($_POST['ticker'][$i])."',weight='".mysql_real_escape_string($_POST['weight'][$i])."',curr='".mysql_real_escape_string($_POST['curr'][$i])."',divcurr='".mysql_real_escape_string($_POST['divcurr'][$i])."',indxx_id='".mysql_real_escape_string($_SESSION['tempindexid'])."'");
							
					}					
						
					//$this->db->query("INSERT into tbl_indxx_ticker_temp set status='0',name='".mysql_real_escape_string($_POST['name'][$i])."',isin='".mysql_real_escape_string($_POST['isin'][$i])."',ticker='".mysql_real_escape_string($_POST['ticker'][$i])."',weight='".mysql_real_escape_string($_POST['weight'][$i])."',curr='".mysql_real_escape_string($_POST['curr'][$i])."',divcurr='".mysql_real_escape_string($_POST['divcurr'][$i])."',indxx_id='".mysql_real_escape_string($_SESSION['tempindexid'])."',sedol='".$remainingfieldsarray['sedol[$i]']."',cusip='".$remainingfieldsarray['cusip[$i]']."',countryname='".$remainingfieldsarray['countryname[$i]']."'");
					
					$added++;
		
				}	
			}
			
			
			
			if($added>=1)
		{
			
			
			
			
			$this->Redirect("index.php?module=casecurities&event=addNewNext&id=".$added,"Index added successfully!!! <br> Please Wait for Approval","success");	
		}
		else
		{
			$this->Redirect("index.php?module=casecurities&event=addNew2","No security added!!! <br> Please add again","error");	
		}
		}
		
		
		
			 $this->show();
	}
	
	function addNewNextrunning()
	{
		$this->_baseTemplate="inner-template";
			$this->_bodyTemplate="casecurities/addnextrunning";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
		//$this->pr($_SESSION,true);	
			$this->smarty->assign('pagetitle','Securities');
		$this->smarty->assign('bredcrumssubtitle','Add/Submit Securities');
		
		
		
			
		$this->show();
	}
	
	
	
	function addNewNext()
	{
		$this->_baseTemplate="inner-template";
			$this->_bodyTemplate="casecurities/addnext";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
		//$this->pr($_SESSION,true);	
			$this->smarty->assign('pagetitle','Securities');
		$this->smarty->assign('bredcrumssubtitle','Add/Submit Securities');
		
		
		
			
		$this->show();
	}
	
	function subindex()
	{
		echo "Submitted";	
	}
	
	private function addfield2($count)
	{	
	   for($i=1;$i<=$count;$i++)
{	   
	   $this->validData[]=array("feild_label" =>"Security Name",
	   								"feild_code" =>"name[".$i.']',
								 "feild_type" =>"text",
								 "feild_tpl" =>"place_text3",
								 "is_required" =>"",
								
								 );
		 $this->validData[]=array("feild_label" =>"Security Isin",
		 							"feild_code" =>"isin[".$i.']',
								 "feild_type" =>"text",
								 "feild_tpl" =>"place_text2",
								 "is_required" =>"",
								
								 );
								 
		 $this->validData[]=array("feild_label" =>"Security Ticker",
		 							"feild_code" =>"ticker[".$i.']',
								 "feild_type" =>"text",
								  "feild_tpl" =>"place_text2",
								 "is_required" =>"",
								
								 );
								 
		
	
	 $this->validData[]=array("feild_label" =>"Index",
	 							"feild_code" =>"indxx_id[".$i.']',
								 "feild_type" =>"hidden",
								 "is_required" =>"",
								   "feild_tpl" =>"hidden2",
								 'value'=>$_SESSION['NewIndxxId']
								 );
	
	 $this->validData[]=array(	"feild_label"=>"Currency",
	 							"feild_code" =>"curr[".$i.']',
								 "feild_type" =>"text",
								  "feild_tpl" =>"place_text2",
								 "is_required" =>"",
								
								 );	 
	  $this->validData[]=array("feild_label" =>"Dividend Currency",
		 							"feild_code" =>"divcurr[".$i.']',
								 "feild_type" =>"text",
								 "is_required" =>"",
								  "feild_tpl" =>"place_text2",
								);
	
}
	$this->getValidFeilds();
	}
	
	private function addfieldforrunning($count)
	{	
	   for($i=1;$i<=$count;$i++)
{	   
	   $this->validData[]=array("feild_label" =>"Security Name",
	   								"feild_code" =>"name[".$i.']',
								 "feild_type" =>"text",
								 "feild_tpl" =>"place_text3",
								 "is_required" =>"",
								
								 );
		 $this->validData[]=array("feild_label" =>"Security Isin",
		 							"feild_code" =>"isin[".$i.']',
								 "feild_type" =>"text",
								 "feild_tpl" =>"place_text2",
								 "is_required" =>"",
								
								 );
								 
		 $this->validData[]=array("feild_label" =>"Security Ticker",
		 							"feild_code" =>"ticker[".$i.']',
								 "feild_type" =>"text",
								  "feild_tpl" =>"place_text2",
								 "is_required" =>"",
								
								 );
								 
		$this->validData[]=array("feild_label" =>"Share",
		 							"feild_code" =>"share[".$i.']',
								 "feild_type" =>"hidden",
								 "is_required" =>"",
								
								);
	//  "feild_tpl" =>"place_text2",
	
	 $this->validData[]=array("feild_label" =>"Index",
	 							"feild_code" =>"indxx_id[".$i.']',
								 "feild_type" =>"hidden",
								 "is_required" =>"",
								   "feild_tpl" =>"hidden2",
								 'value'=>$_SESSION['NewIndxxId']
								 );
	
	 $this->validData[]=array(	"feild_label"=>"Ticker Currency",
	 							"feild_code" =>"curr[".$i.']',
								 "feild_type" =>"text",
								  "feild_tpl" =>"place_text2",
								 "is_required" =>"",
								
								 );	 
	$this->validData[]=array(	"feild_label"=>"Dividend Currency",
	 							"feild_code" =>"divcurr[".$i.']',
								 "feild_type" =>"text",
								  "feild_tpl" =>"place_text2",
								 "is_required" =>"",
								
								 );	 
}
	$this->getValidFeilds();
	}
	
	private function addfield()
	{	
	   $this->validData[]=array("feild_label" =>"Security Name",
	   								"feild_code" =>"name",
								 "feild_type" =>"text",
								 "is_required" =>"1",
								
								 );
		 $this->validData[]=array("feild_label" =>"Security Isin",
		 							"feild_code" =>"isin",
								 "feild_type" =>"text",
								 "is_required" =>"1",
								
								 );
								 
		 $this->validData[]=array("feild_label" =>"Security Ticker",
		 							"feild_code" =>"ticker",
								 "feild_type" =>"text",
								 "is_required" =>"1",
								
								 );
								 
		 $this->validData[]=array("feild_label" =>"Weight",
		 							"feild_code" =>"weight",
								 "feild_type" =>"text",
								 "is_required" =>"1",
								
								 );
	
	if(!$_SESSION['NewIndxxId'])
	{
	 $this->validData[]=array("feild_label" =>"Index",
	 							"feild_code" =>"indxx_id",
								 "feild_type" =>"select",
								 "is_required" =>"1",
								 //"feild_tpl" =>"selectsearch",
								  "model"=>$this->getIndexes(),
								 );
								 
	}else{
	 $this->validData[]=array("feild_label" =>"Index",
	 							"feild_code" =>"indxx_id",
								 "feild_type" =>"hidden",
								 "is_required" =>"",
								 'value'=>$_SESSION['NewIndxxId']
								 );
	}
	 $this->validData[]=array(	"feild_label"=>"Currency",
	 							"feild_code" =>"curr",
								 "feild_type" =>"text",
								 "is_required" =>"1",
								
								 );	 
	
	$this->getValidFeilds();
	}
	
	
	
	 protected function view(){
		 
		$this->_baseTemplate="inner-template";
			$this->_bodyTemplate="casecurities/view";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','Index');
		$this->smarty->assign('bredcrumssubtitle','ViewIndex');
		
		
		
		$viewdata=$this->db->getResult("select tbl_indxx_ticker.*,tbl_indxx.code as indexname from tbl_indxx_ticker left join tbl_indxx on tbl_indxx.id=tbl_indxx_ticker.indxx_id where tbl_indxx_ticker.id='".$_GET['id']."'");
		
		$this->smarty->assign("viewdata",$viewdata);
		
		 $this->show();
			
	}
	
	protected function edit(){
		 
		$this->_baseTemplate="inner-template";
			$this->_bodyTemplate="casecurities/edit";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','Index');
		$this->smarty->assign('bredcrumssubtitle','EditIndex');
		$this->addfield();
		
		
		if(isset($_POST['submit']))
		{
			
		$this->db->query("UPDATE tbl_indxx_ticker set name='".mysql_real_escape_string($_POST['name'])."',isin='".mysql_real_escape_string($_POST['isin'])."',ticker='".mysql_real_escape_string($_POST['ticker'])."',weight='".mysql_real_escape_string($_POST['weight'])."',curr='".mysql_real_escape_string($_POST['curr'])."',indxx_id='".mysql_real_escape_string($_POST['indxx_id'])." where id='".$_GET['id']."''");
		
			$this->Redirect("index.php?module=casecurities","Record updated successfully!!!","success");	
		}
		
		
		
		$editdata=$this->db->getResult("select tbl_indxx_ticker.* from tbl_indxx_ticker  where tbl_indxx_ticker.id='".$_GET['id']."'");
		//$this->pr($editdata,true);
		$this->smarty->assign("postData",$editdata);
		
		
		
		
		 $this->show();
			
	}
	
	
	protected function delete(){
		 
		
			$strQuery = "delete from tbl_indxx_ticker where tbl_indxx_ticker.id='".$_GET['id']."'";
			$this->db->query($strQuery);
			$this->Redirect("index.php?module=casecurities","Record updated successfully!!!","success");
			
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
					
					$strQuery2 = "delete from tbl_indxx_ticker where tbl_indxx_ticker.indxx_id='".$val2."'";
					$this->db->query($strQuery2);
			
			}
			}
		}
		
		$this->Redirect("index.php?module=casecurities","Records deleted successfully!!!","success");
		$this->show();	
	}
	
	
} // class ends here

?>