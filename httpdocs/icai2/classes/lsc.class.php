<?php

class Lsc extends Application{

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
	$this->smarty->assign('pagetitle','Long Short Cash Index');
	$this->smarty->assign('bredcrumssubtitle','Long Short Cash Index');	
	
	$this->_baseTemplate="inner-template";
	$this->_bodyTemplate="lsc/index";
			$this->_title='Long Short Cash Index';
	$indxxdata=$this->db->getResult("select * from tbl_indxx_lsc",true);
	
	
	//$this->pr($indxxdata,true);
	$this->smarty->assign("indexdata",$indxxdata);
	
		
	 $this->show();
	}
	 function addNew()
	{
			$this->_baseTemplate="inner-template";
			$this->_bodyTemplate="lsc/add";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','Index');
		$this->smarty->assign('bredcrumssubtitle','AddIndex');
		
		
		if(isset($_POST['saveandnext']))
		{
	//	$this->db->query("INSERT into tbl_indxx_ticker set name='".mysql_real_escape_string($_POST['name'])."',isin='".mysql_real_escape_string($_POST['isin'])."',ticker='".mysql_real_escape_string($_POST['ticker'])."',weight='".mysql_real_escape_string($_POST['weight'])."',curr='".mysql_real_escape_string($_POST['curr'])."',indxx_id='".mysql_real_escape_string($_POST['indxx_id'])."'");
	
	$_SESSION['CSI']=$_POST;
	
		
			$this->Redirect("index.php?module=lsc&event=addAdjfactor","Please Select Index and Submit Fraction !!!","success");	
		}
		
	
			
			$this->addfield();
			 $this->show();
	}
	
	
	private function addfield()
	{	
	   $this->validData[]=array("feild_label" =>"Index Name",
	   								"feild_code" =>"name",
								 "feild_type" =>"text",
								 "is_required" =>"1",
								
								 );
		 $this->validData[]=array("feild_label" =>"Index Code",
		 							"feild_code" =>"code",
								 "feild_type" =>"text",
								 "is_required" =>"1",
								
								 );
		/*$this->validData[]=array("feild_label" =>"Base Index value",
		 							"feild_code" =>"bvalue",
								 "feild_type" =>"text",
								 "is_required" =>"1",
								
								 );	*/					 
		$this->validData[]=array("feild_label" =>"Zone",
	 							"feild_code" =>"zone",
								 "feild_type" =>"select",
								 "is_required" =>"1",
								 //"feild_tpl" =>"selectsearch",
								  "model"=>$this->getCalendarZone(),
								 );
	
	 $this->validData[]=array("feild_label" =>"Client",
	 							"feild_code" =>"client_id",
								 "feild_type" =>"select",
								 "is_required" =>"1",
								 //"feild_tpl" =>"selectsearch",
								  "model"=>$this->getAllClients(),
								 ); 
	/*$this->validData[]=array("feild_label" =>"Priority",
	 							"feild_code" =>"priority",
								 "feild_type" =>"select",
								 "is_required" =>"1",
								 //"feild_tpl" =>"selectsearch",
								  "model"=>$this->getPriorityArray(),
								 );		*/
	$this->getValidFeilds();
	}
	
	 
	 function addAdjfactor(){
		
	
//	$this->pr($_SESSION,true);
	
	$this->_baseTemplate="inner-template";
			$this->_bodyTemplate="lsc/addnext";
			$this->_title="Add Long Short Cash Factor";
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','Index');
		$this->smarty->assign('bredcrumssubtitle','AddIndex');
	
	
	if(isset($_POST['submit']))
		{
			
			//	$this->pr($_POST,true);
	//	$this->db->query("INSERT into tbl_indxx_ticker set name='".mysql_real_escape_string($_POST['name'])."',isin='".mysql_real_escape_string($_POST['isin'])."',ticker='".mysql_real_escape_string($_POST['ticker'])."',weight='".mysql_real_escape_string($_POST['weight'])."',curr='".mysql_real_escape_string($_POST['curr'])."',indxx_id='".mysql_real_escape_string($_POST['indxx_id'])."'");
	
	foreach($_POST['indxx_id'] as $indxx_key=>$indxx_id)
	{
	if(!$indxx_id)
	unset($_POST['indxx_id'][$indxx_key]);
	}
	foreach($_POST['fraction'] as $fraction_key=>$fraction_id)
	{
	if(!$fraction_id || !is_numeric($fraction_id))
	unset($_POST['fraction'][$fraction_key]);
	}
	if(count($_POST['indxx_id'])!=count($_POST['fraction']))
	{
	echo "Values are Incorrect, Please Check";
	exit;
	}
	
	foreach($_POST['indxx_id'] as $index_key=>$index_id)
	{
		if(!$_POST['fraction'][$index_key])
		{
		echo "Index and Fraction value Mismatch";
	exit;
	
		}
	
	}
		$this->db->query("INSERT into tbl_indxx_lsc set status='0', name='".mysql_real_escape_string($_SESSION['CSI']['name'])."',code='".mysql_real_escape_string($_SESSION['CSI']['code'])."',zone='".mysql_real_escape_string($_SESSION['CSI']['zone'])."',client_id='".mysql_real_escape_string($_SESSION['CSI']['client_id'])."',priority='".mysql_real_escape_string($_SESSION['CSI']['priority'])."',user_id='".mysql_real_escape_string($_SESSION['User']['id'])."'");

	$newIndxx_id=mysql_insert_id();
	
	
	$indxxdata1=$this->db->getResult("select code from tbl_indxx where id = '".$_POST['indxx_id'][1]."' ",false,1);
	$indxxdata2=$this->db->getResult("select code from tbl_indxx where id = '".$_POST['indxx_id'][2]."' ",false,1);
	$indxxdata3=$this->db->getResult("select code from tbl_cash_index where id = '".$_POST['indxx_id'][3]."' ",false,1);
	
	$this->db->query("INSERT into tbl_lsc_adj_factor set lsc_indxx_id='".mysql_real_escape_string($newIndxx_id)."',long_indxx_id='".mysql_real_escape_string($_POST['indxx_id'][1])."',long_code='".mysql_real_escape_string($indxxdata1['code'])."',long_fraction='".mysql_real_escape_string($_POST['fraction'][1])."',short_indxx_id='".mysql_real_escape_string($_POST['indxx_id'][2])."',short_code='".mysql_real_escape_string($indxxdata2['code'])."',short_fraction='".mysql_real_escape_string($_POST['fraction'][2])."',cash_indxx_id='".mysql_real_escape_string($_POST['indxx_id'][3])."',cash_code='".mysql_real_escape_string($indxxdata3['code'])."',cash_fraction='".mysql_real_escape_string($_POST['fraction'][3])."'");
	
	
	
	//$this->db->query("INSERT into tbl_indxx_lsc_value set indxx_id='".$newIndxx_id."',code='".mysql_real_escape_string($_SESSION['CSI']['code'])."',indxx_value='".mysql_real_escape_string($_SESSION['CSI']['bvalue'])."',date='".mysql_real_escape_string($this->_date)."'");
//	$this->pr($_SESSION['CSI']);
	
	
	
	$emailQueries='select email from tbl_ca_user where status="1" and type="1" ';
		$email_res=mysql_query($emailQueries);
		if(mysql_num_rows($email_res)>0)
		{
			
			while($email=mysql_fetch_assoc($email_res))
			{
			$emailsids[]=$email['email'];
			}
		}
		
		
		if(!empty($emailsids))	
		{
			 $emailsids	=implode(',',$emailsids);
			 
			//$emailsids.=',dbajpai@indxx.com';
			
			
			$text="New  Long Short Cash Index  : ".$_SESSION['CSI']['name']." (".$_SESSION['CSI']['code'].") added by ".$_SESSION['User']['name']."\r\n Please View and Approve It to Run";
			 
			
			
			$msg='Hi <br>'.$text." <br>Thanks <br>";
					
					// To send HTML mail, the Content-type header must be set
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			
			// Additional headers
			//$headers .= 'To: '.$dbuser['name'].' <'.$dbuser['email'].'>'. "\r\n";
$headers .= 'From: Indexing <indexing@indxx.com>' . "\r\n"."CC: indexing@indxx.com". "\r\n";
					//echo $emailsids;
						if(mail($emailsids,"New Long Short Cash Index ",$msg,$headers))
					{
						echo "Mail Send ";
						
						//echo "Mail sent to : ".$dbuser['name']."<br>";	
					}
					else
					{
						echo "Mail not sent";	
					}
					
			
			
		}
	
	
	
	
	
	//if(!empty())
	
	
	
	
	
	//echo count($_POST['indxx_id'])."-". count($_POST['fraction']);
	
	
//	$this->pr($_POST,true);
	
	
	
	//exit;
	//$_SESSION['CSI']=$_POST;
	
		unset($_SESSION['CSI']);
			$this->Redirect("index.php?module=lsc","Record added successfully!!!","success");	
		}
		
	
	
			$this->addfield2(2);
			 $this->show();
			 
			 
			 
			 
	
	
	}
	
	
	
	function edit()
	{
			$this->_baseTemplate="inner-template";
			$this->_bodyTemplate="lsc/addnext";
			$this->_title="Edit Long Short Cash Factor";
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','Index');
		$this->smarty->assign('bredcrumssubtitle','AddIndex');
	
		
		
		$tickerdata=$this->db->getResult("select tbl_lsc_adj_factor.* from tbl_lsc_adj_factor where lsc_indxx_id='".$_GET['id']."' ",false,1);
	
		
		$array=array();
			$array['indxx_id[1]']=$tickerdata['long_indxx_id'];
			
			$array['fraction[1]']=$tickerdata['long_fraction'];
			$array['indxx_id[2]']=$tickerdata['short_indxx_id'];
			
			$array['fraction[2]']=$tickerdata['short_fraction'];
			$array['indxx_id[3]']=$tickerdata['cash_indxx_id'];
			
			$array['fraction[3]']=$tickerdata['cash_fraction'];
			//$array[]=	
		
		$this->smarty->assign('postData',$array);
		$this->addfield2(2);
		
		
		
		
		
	if(isset($_POST['submit']))
		{
	//	$this->db->query("INSERT into tbl_indxx_ticker set name='".mysql_real_escape_string($_POST['name'])."',isin='".mysql_real_escape_string($_POST['isin'])."',ticker='".mysql_real_escape_string($_POST['ticker'])."',weight='".mysql_real_escape_string($_POST['weight'])."',curr='".mysql_real_escape_string($_POST['curr'])."',indxx_id='".mysql_real_escape_string($_POST['indxx_id'])."'");
	
	foreach($_POST['indxx_id'] as $indxx_key=>$indxx_id)
	{
	if(!$indxx_id)
	unset($_POST['indxx_id'][$indxx_key]);
	}
	foreach($_POST['fraction'] as $fraction_key=>$fraction_id)
	{
	if(!$fraction_id || !is_numeric($fraction_id))
	unset($_POST['fraction'][$fraction_key]);
	}
	if(count($_POST['indxx_id'])!=count($_POST['fraction']))
	{
	echo "Values are Incorrect, Please Check";
	exit;
	}
	
	foreach($_POST['indxx_id'] as $index_key=>$index_id)
	{
		if(!$_POST['fraction'][$index_key])
		{
		echo "Index and Fraction value Mismatch";
	exit;
	
		}
		
	
	
	}
	
	
	
	$this->db->query("update tbl_indxx_lsc set status='0' where  id ='".$_GET['id']."'");
	$strQuery = "delete from tbl_lsc_adj_factor where cs_indxx_id='".$_GET['id']."'";
					$this->db->query($strQuery);
					
		$indxxdata1=$this->db->getResult("select code from tbl_indxx where id = '".$_POST['indxx_id'][1]."' ",false,1);
	$indxxdata2=$this->db->getResult("select code from tbl_indxx where id = '".$_POST['indxx_id'][2]."' ",false,1);
	$indxxdata3=$this->db->getResult("select isin from tbl_cash_index where id = '".$_POST['indxx_id'][3]."' ",false,1);
	
	$this->db->query("INSERT into tbl_lsc_adj_factor set lsc_indxx_id='".mysql_real_escape_string($newIndxx_id)."',long_indxx_id='".mysql_real_escape_string($_POST['indxx_id'][1])."',long_code='".mysql_real_escape_string($indxxdata1['code'])."',long_fraction='".mysql_real_escape_string($_POST['fraction'][1])."',short_indxx_id='".mysql_real_escape_string($_POST['indxx_id'][2])."',short_code='".mysql_real_escape_string($indxxdata2['code'])."',short_fraction='".mysql_real_escape_string($_POST['fraction'][2])."',cash_indxx_id='".mysql_real_escape_string($_POST['indxx_id'][3])."',cash_code='".mysql_real_escape_string($indxxdata3['isin'])."',cash_fraction='".mysql_real_escape_string($_POST['fraction'][3])."'");
	
	
	$emailQueries='select email from tbl_ca_user where status="1" and type="1" ';
		$email_res=mysql_query($emailQueries);
		if(mysql_num_rows($email_res)>0)
		{
			
			while($email=mysql_fetch_assoc($email_res))
			{
			$emailsids[]=$email['email'];
			}
		}
		
		
		if(!empty($emailsids))	
		{
			 $emailsids	=implode(',',$emailsids);
			 
			//$emailsids.=',dbajpai@indxx.com';
			
			
			$text="Long Short Cash Index  : ".$_SESSION['CSI']['name']." (".$_SESSION['CSI']['code'].") Updated by ".$_SESSION['User']['name']."\r\n Please View and Approve It to Run";
			 
			
			
			$msg='Hi <br>'.$text." <br>Thanks <br>";
					
					// To send HTML mail, the Content-type header must be set
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			
			// Additional headers
			//$headers .= 'To: '.$dbuser['name'].' <'.$dbuser['email'].'>'. "\r\n";
$headers .= 'From: Indexing <indexing@indxx.com>' . "\r\n"."CC: indexing@indxx.com". "\r\n";
					//echo $emailsids;
						if(mail($emailsids,"New Long Short Cash Index ",$msg,$headers))
					{
						echo "Mail Send ";
						
						//echo "Mail sent to : ".$dbuser['name']."<br>";	
					}
					else
					{
						echo "Mail not sent";	
					}
					
			
			
		}
	
	
	
	
	
	//if(!empty())
	
	
	
	
	
	//echo count($_POST['indxx_id'])."-". count($_POST['fraction']);
	
	
//	$this->pr($_POST,true);
	
	
	
	//exit;
	//$_SESSION['CSI']=$_POST;
	
		unset($_SESSION['CSI']);
			$this->Redirect("index.php?module=lsc","Record Updated  successfully!!!<br> Please Wait for Admin Approval.","success");	
		}
		
		
		
		
		
			 $this->show();
	}
	
	 
		private function addfield2($count)
	{	
	   for($i=1;$i<=$count;$i++)
{	   
	 
	   $this->validData[]=array("feild_label" =>"Index",
	 							"feild_code" =>"indxx_id[".$i.']',
								 "feild_type" =>"select",
								 "is_required" =>"0",
								  "feild_tpl" =>"place_select2",
								  "model"=>$this->getIndexesNew(),
								 );
	
	  if($i==1)
	  {
	  
	  $this->validData[]=array("feild_label" =>"Adjustment Factor",
		 							"feild_code" =>"fraction[".$i.']',
								 "feild_type" =>"text",
								 "is_required" =>"",
								  "feild_tpl" =>"place_text2",
								 "feild_note" =>"Long Index Factor",

								);
	

	  }else{
	
	  $this->validData[]=array("feild_label" =>"Adjustment Factor",
		 							"feild_code" =>"fraction[".$i.']',
								 "feild_type" =>"text",
								 "is_required" =>"",
								  "feild_tpl" =>"place_text2",
								 "feild_note" =>"Short Index Factor",

								);
		 
		 }

}

$this->validData[]=array("feild_label" =>"Index",
	 							"feild_code" =>"indxx_id[3]",
								 "feild_type" =>"select",
								 "is_required" =>"0",
								  "feild_tpl" =>"place_select2",
								  "model"=>$this->getCashIndex(),
								 );
	
	  
	  
	  $this->validData[]=array("feild_label" =>"Adjustment Factor",
		 							"feild_code" =>"fraction[3]",
								 "feild_type" =>"text",
								 "is_required" =>"",
								  "feild_tpl" =>"place_text2",
								  "feild_note" =>"Cash Factor- Factor Can be negative ",
								);
	

	$this->getValidFeilds();
	}


	protected function delete(){
		
		 	$strQuery1 = "delete from tbl_indxx_lsc where id='".$_GET['id']."'";
					$this->db->query($strQuery1);
					
									
					$strQuery = "delete from tbl_lsc_adj_factor where lsc_indxx_id='".$_GET['id']."'";
					$this->db->query($strQuery);
			
			$this->Redirect("index.php?module=lsc","Record deleted successfully!!!","success");
			
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
				$strQuery1 = "delete from tbl_indxx_lsc where id='".$_GET['id']."'";
					$this->db->query($strQuery1);
					
									
					$strQuery = "delete from tbl_lsc_adj_factor where lsc_indxx_id='".$_GET['id']."'";
					$this->db->query($strQuery);
			}
			}
		}
		$this->Redirect("index.php?module=lsc","Records deleted successfully!!!","success");
		$this->show();	
	}
	
	function view()
{
	
	
	$this->_baseTemplate="inner-template";
			$this->_bodyTemplate="lsc/view";
			$this->_title="View Long Short Cash Index";
	
	$indxxdata=$this->db->getResult("select * from tbl_indxx_lsc where id = '".$_GET['id']."' ",true);
	

	
	$indxxfactordata=$this->db->getResult("select * from tbl_lsc_adj_factor where lsc_indxx_id = '".$_GET['id']."' ",false,1);
if(!empty($indxxfactordata))
{
$indxxname=$this->db->getResult("select name from tbl_indxx where code = '". $indxxfactordata['long_code']."' ",false,1);
$indxxfactordata2[1]['name']=$indxxname['name'];
$indxxfactordata2[1]['fraction']=$indxxfactordata['long_fraction'];
$indxxfactordata2[1]['code']=$indxxfactordata['long_code'];

$indxxname=$this->db->getResult("select name from tbl_indxx where code = '". $indxxfactordata['short_code']."' ",false,1);
$indxxfactordata2[2]['name']=$indxxname['name'];
$indxxfactordata2[2]['fraction']=$indxxfactordata['short_fraction'];
$indxxfactordata2[2]['code']=$indxxfactordata['short_code'];

$indxxname=$this->db->getResult("select name from tbl_cash_index where isin = '". $indxxfactordata['cash_code']."' ",false,1);
$indxxfactordata2[3]['name']=$indxxname['name'];

$indxxfactordata2[3]['fraction']=$indxxfactordata['cash_fraction'];
$indxxfactordata2[3]['code']=$indxxfactordata['cash_code'];
}
		
		
	$this->smarty->assign("indxxdata",$indxxdata);
			
	$this->smarty->assign("indxxfactordatacount",count($indxxfactordata2));
	$this->smarty->assign("indxxfactordata",$indxxfactordata2);
	
		$this->show();
}	
	
	
	function approve(){
	
	$indxxdata=$this->db->getResult("select * from tbl_indxx_lsc where id = '".$_GET['id']."' ",false,1);
	
	//$this->pr($indxxdata,true);
	
			
			
			$strQuery1 = "update tbl_indxx_lsc set status='1' where id='".$_GET['id']."'";
					$this->db->query($strQuery1);
			
				$emailQueries=$this->db->getResult('select email from tbl_ca_user where status="1" and id="'.$indxxdata['user_id'].'" ',false,1);
			
			$text="Your  Long Short Cash Index  : ".$indxxdata['name']." (".$indxxdata['code'].") approved  by ".$_SESSION['User']['name']."\r\n ";
			 
			
			
			$msg='Hi <br>'.$text." <br>Thanks <br>";
					
					// To send HTML mail, the Content-type header must be set
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			
			// Additional headers
			//$headers .= 'To: '.$dbuser['name'].' <'.$dbuser['email'].'>'. "\r\n";
$headers .= 'From: Indexing <indexing@indxx.com>' . "\r\n"."CC: indexing@indxx.com". "\r\n";
					//echo $emailQueries['email'];
//exit;
						if(mail($emailQueries['email'],"Long Short Cash Index Approved",$msg,$headers))
					{
						echo "Mail Send ";
						
						//echo "Mail sent to : ".$dbuser['name']."<br>";	
					}
					else
					{
						echo "Mail not sent";	
					}
					
			
	$this->Redirect("index.php?module=lsc","Records Approved successfully!!!","success");
	}
	

}