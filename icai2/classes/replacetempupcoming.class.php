<?php

class Replacetempupcoming extends Application{

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
		
		$this->_baseTemplate="inner-template";
	$this->_bodyTemplate="replacetempupcoming/index";
		$this->_title=$this->siteconfig->site_title;
		$this->_meta_description=$this->siteconfig->default_meta_description;
		$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
//	$this->addfield();

		$this->smarty->assign('pagetitle','Index');
		$this->smarty->assign('bredcrumssubtitle','Index');
		$indexdata=$this->db->getResult("select tbl_indxx_temp.name,tbl_replace_tempindex_req.* from tbl_replace_tempindex_req left join tbl_indxx_temp on tbl_indxx_temp.id=tbl_replace_tempindex_req.indxx_id where 1=1  ",true);

		$this->smarty->assign("indexdata",$indexdata);

	//$this->pr($indexdata,true);
	
		//$this->pr($_SESSION);
		 $this->show();
	}
	
	
	
	protected function editfornext(){
		 
		
		$this->_baseTemplate="inner-template";
			$this->_bodyTemplate="replacetempupcoming/edit";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','Index');
		$this->smarty->assign('bredcrumssubtitle','Edit Index');
		$this->addeditfield();
		
		
		unset($_SESSION['NewIndxxName']);
		unset($_SESSION['NewIndxxId']);
		unset($_SESSION['indxx_code']);
		unset($_SESSION['indxx_type']);
		
		
		$editdata=$this->db->getResult("select tbl_replace_tempindex_req.*,tbl_indxx_temp.name as indexname from tbl_replace_tempindex_req left join  tbl_indxx_temp on tbl_indxx_temp.id=tbl_replace_tempindex_req.indxx_id where tbl_replace_tempindex_req.id='".$_GET['id']."'");
		//$this->pr($editdata,true);
		$this->smarty->assign("postData",$editdata);
		
		
		
		
		$tempindexid=0;
		
		if(isset($_POST['submit']))
		{
			$checkdata=$this->db->getResult("select tbl_replace_tempindex_req.* from tbl_replace_tempindex_req  where tbl_replace_tempindex_req.indxx_id='".$_POST['indxx_id']."' and tbl_replace_tempindex_req.startdate='".$_POST['dateStart']."'");
			if(empty($checkdata))
			{
					$this->db->query("INSERT into tbl_replace_tempindex_req set indxx_id='".mysql_real_escape_string($_POST['indxx_id'])."',startdate='".$_POST['dateStart']."'");
					
					$tempindexid=mysql_insert_id();
					
					
			}
			
			else
			{
				//$this->pr($checkdata,true);	
				
				
				$tempindexid=$checkdata['id'];
				
				$this->db->query("UPDATE tbl_replace_tempindex_req set indxx_id='".mysql_real_escape_string($_POST['indxx_id'])."',startdate='".$_POST['dateStart']."' where id='".$checkdata['id']."'");
				
				
			}
			
		
		
			$this->Redirect("index.php?module=replacetempupcoming&event=edit2&id=".$tempindexid,"Index updated successfully!!!<br> Please update associated securities!!!","success");
			
			}
		
		 $this->show();
			
	}



function addNew3()
	{
			$this->_baseTemplate="inner-template";
			$this->_bodyTemplate="replacetempupcoming/add3";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','Index');
		$this->smarty->assign('bredcrumssubtitle','Add Securities');
		
		$totalfields=30;
		$this->smarty->assign('totalfields',$totalfields);
		
		
		$editdata=$this->db->getResult("select tbl_indxx_temp.* from tbl_indxx_temp  where tbl_indxx_temp.id='".$_GET['id']."'");
		//$this->pr($editdata,true);
		$this->smarty->assign("postData",$editdata);
		
		$this->addfield2($totalfields);
		
		$added=0;
		
		
		if($_POST['submit'])
		{
			
			
			
			for($i=1;$i<$_POST['totalfields'];$i++)
			{
				if($_POST['name'][$i] && $_POST['isin'][$i] && $_POST['ticker'][$i] && $_POST['divcurr'][$i] && $_POST['curr'][$i])
				{
					//$this->pr($_POST,true);	
					$this->db->query("INSERT into tbl_tempsecurities_replaced set status='0',name='".mysql_real_escape_string($_POST['name'][$i])."',isin='".mysql_real_escape_string($_POST['isin'][$i])."',ticker='".mysql_real_escape_string($_POST['ticker'][$i])."',curr='".mysql_real_escape_string($_POST['curr'][$i])."',divcurr='".mysql_real_escape_string($_POST['divcurr'][$i])."',indxx_id='".mysql_real_escape_string($_GET['indxx_id'])."',req_id='".mysql_real_escape_string($_GET['reqid'])."'");
					$added++;
		
				}	
			}
			
			
			if($added>=1)
		{
			$indexxname=$this->db->getResult("select tbl_indxx_temp.name from tbl_indxx_temp  where tbl_indxx_temp.id='".$_GET['indxx_id']."'");
			
			$this->smarty->assign('indexxname',$indexxname['0']['name']);
			$this->Redirect("index.php?module=replacetempupcoming&event=addNewNext&total=".$added."&id=".$_GET['indxx_id']."&reqid=".$_GET['reqid'],"Securities added successfully!!! <br> Please Wait for Approval","success");	
		}
		else
		{
			$this->Redirect("index.php?module=replacetempupcoming&event=addNew2&id=".$_GET['indxx_id']."&reqid=".$_GET['reqid'],"No security added!!! <br> Please add again","error");	
		}
		}
		
		
		
			 $this->show();
	}
	






function editrunning(){
///echo "deepak";

		//$this->pr($_SESSION,true);
			$this->_baseTemplate="inner-template";
			$this->_bodyTemplate="replacetempupcoming/editrunning";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','Index');
		$this->smarty->assign('bredcrumssubtitle','Add Securities');
		//$this->pr($_SESSION,true);
		//echo "select tbl_indxx_ticker_temp.* from tbl_indxx_ticker_temp where indxx_id='".$_SESSION['liveindexid']."' ";
		//exit;
		$indexdata=$this->db->getResult("select tbl_indxx_temp2.* from tbl_indxx_temp2 where id='".$_SESSION['tempindexid']."' ");
		
		$tickerdata=$this->db->getResult("select tbl_indxx_ticker_temp.* from tbl_indxx_ticker_temp where indxx_id='".$_SESSION['liveindexid']."' ",true);
		//$this->pr($indexdata,true);
		$this->smarty->assign("runningindexdata",$indexdata);
		
		$sharedata=$this->db->getResult("select tbl_share_temp.* from tbl_share_temp where indxx_id='".$_SESSION['liveindexid']."' ",true);
	//$this->pr($sharedata,true);
	$tempShareArray=array();
	
	if(!empty($sharedata))
	{
	foreach($sharedata as $share)
	{
	$tempShareArray[$share['isin']]=$share['share'];
	}
	}
		if(count($tickerdata)>0 && count($tickerdata)<=30)
		{
			$totalfields=30;	
		}elseif(count($tickerdata)>=30)
		{
			$totalfields=count($tickerdata);	
		}
		else
		{
		$totalfields=30;
		}
		
		$array=array();
		
		for($i=0;$i<$totalfields;$i++)
		{
			$array['name['.($i+1).']']=$tickerdata[$i]['name'];
			
			$array['isin['.($i+1).']']=$tickerdata[$i]['isin'];
			$array['ticker['.($i+1).']']=$tickerdata[$i]['ticker'];
			$array['share['.($i+1).']']=$tempShareArray[$tickerdata[$i]['isin']];
			$array['curr['.($i+1).']']=$tickerdata[$i]['curr'];
			$array['divcurr['.($i+1).']']=$tickerdata[$i]['divcurr'];
			
			//$array[]=	
		}
		
		$this->smarty->assign('postData',$array);
		$this->smarty->assign('totalfields',$totalfields);
		
		$this->addfieldrunning($totalfields,$indexdata['status'],$indexdata['dbusersignoff']);
		
		$added=0;
		
		
		if($_POST['submit'])
		{
			
			
			
				$this->db->query("delete from tbl_indxx_ticker_temp where indxx_id='".$_SESSION['tempindexid']."'");
			//$this->db->query("delete from tbl_share_temp where indxx_id='".$_SESSION['tempindexid']."'");
			
			for($i=1;$i<=$_POST['totalfields'];$i++)
			{
				if($_POST['name'][$i] && $_POST['isin'][$i] && $_POST['ticker'][$i]  && $_POST['curr'][$i])
				{
					//$this->pr($_POST,true);
					
						
					$this->db->query("INSERT into tbl_indxx_ticker_temp set status='1',name='".mysql_real_escape_string($_POST['name'][$i])."',isin='".mysql_real_escape_string($_POST['isin'][$i])."',ticker='".mysql_real_escape_string($_POST['ticker'][$i])."',weight='0',curr='".mysql_real_escape_string($_POST['curr'][$i])."',divcurr='".mysql_real_escape_string($_POST['divcurr'][$i])."',indxx_id='".mysql_real_escape_string($_SESSION['tempindexid'])."'");
					
					//$this->db->query("INSERT into tbl_share_temp set isin='".mysql_real_escape_string($_POST['isin'][$i])."',date='".$this->_date."',share='".mysql_real_escape_string($_POST['share'][$i])."',indxx_id='".mysql_real_escape_string($_SESSION['tempindexid'])."'");
					$added++;
		
				}	
			}
			
			
			if($added>=1)
		{
			$this->Redirect("index.php?module=replacetempupcoming&event=addedrunning&id=".$added,"Index added successfully!!! <br> Please Wait for Approval","success");	
		}
		else
		{
			$this->Redirect("index.php?module=replacetempupcoming&event=addNew2","No security added!!! <br> Please add again","error");	
		}
		}
		
		
		
			 $this->show();
	


}

	
	function edit2()
	{
		//$this->pr($_SESSION,true);
			$this->_baseTemplate="inner-template";
			$this->_bodyTemplate="replacetempupcoming/add2";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','Index');
		$this->smarty->assign('bredcrumssubtitle','Edit Securities');
		//$this->pr($_SESSION,true);
		//echo "select tbl_indxx_ticker_temp.* from tbl_indxx_ticker_temp where indxx_id='".$_SESSION['liveindexid']."' ";
		//exit;
		$indexdata=$this->db->getResult("select tbl_replace_tempindex_req.* from tbl_replace_tempindex_req where indxx_id='".$_GET['id']."' ");
		
		$tickerdata=$this->db->getResult("select tbl_tempsecurities_replaced.*,tbl_indxx_ticker_temp.* from tbl_tempsecurities_replaced left join tbl_indxx_ticker_temp on tbl_indxx_ticker_temp.indxx_id=tbl_tempsecurities_replaced.indxx_id where indxx_id='".$_GET['id']."' ",true);
		//$this->pr($indexdata,true);
		//$this->smarty->assign("indexdata",$indexdata);

		
		if(count($tickerdata)>0 && count($tickerdata)<=30)
		{
			$totalfields=30;	
		}elseif(count($tickerdata)>=30)
		{
			$totalfields=count($tickerdata);	
		}
		else
		{
		$totalfields=30;
		}
		
		$array=array();
		
		for($i=0;$i<$totalfields;$i++)
		{
			$array['name['.($i+1).']']=$tickerdata[$i]['name'];
			
			$array['isin['.($i+1).']']=$tickerdata[$i]['isin'];
			$array['ticker['.($i+1).']']=$tickerdata[$i]['ticker'];
			$array['weight['.($i+1).']']=$tickerdata[$i]['weight'];
			$array['curr['.($i+1).']']=$tickerdata[$i]['curr'];
			$array['divcurr['.($i+1).']']=$tickerdata[$i]['divcurr'];
			
			//$array[]=	
		}
		
		$this->smarty->assign('postData',$array);
		$this->smarty->assign('totalfields',$totalfields);
		
		$this->addfield2($totalfields);
		
		$added=0;
		
		
		if($_POST['submit'])
		{
				
			
			for($i=1;$i<=$_POST['totalfields'];$i++)
			{
				if($_POST['name'][$i] && $_POST['isin'][$i] && $_POST['ticker'][$i] && $_POST['weight'][$i] && $_POST['curr'][$i])
				{
					//$this->pr($_POST,true);
					
						
					$this->db->query("UPDATE into tbl_indxx_ticker_temp set status='0',name='".mysql_real_escape_string($_POST['name'][$i])."',isin='".mysql_real_escape_string($_POST['isin'][$i])."',ticker='".mysql_real_escape_string($_POST['ticker'][$i])."',weight='".mysql_real_escape_string($_POST['weight'][$i])."',curr='".mysql_real_escape_string($_POST['curr'][$i])."',indxx_id='".mysql_real_escape_string($_SESSION['tempindexid'])."'");
					
					$added++;
		
				}	
			}
			
			
			if($added>=1)
		{
			$this->Redirect("index.php?module=replacetempupcoming&event=addNewNext&id=".$added,"Index added successfully!!! <br> Please Wait for Approval","success");	
		}
		else
		{
			$this->Redirect("index.php?module=replacetempupcoming&event=addNew2","No security added!!! <br> Please add again","error");	
		}
		}
		
		
		
			 $this->show();
	}
	
	
	
	function addNew2()
	{
			$this->_baseTemplate="inner-template";
			$this->_bodyTemplate="replacetempupcoming/add2";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','Index');
		$this->smarty->assign('bredcrumssubtitle','Add Securities');
		
		$cas=$this->db->getResult("select tbl_indxx_ticker_temp.* from tbl_indxx_ticker_temp where indxx_id='".$_GET['id']."'",true);
	$this->smarty->assign('cas',$cas);
		
	if(isset($_POST['submit']))
	{
		//$this->pr($_POST,true);
		$i=0;
		if(!empty($_POST['checkboxid']))
		{
		foreach($_POST['checkboxid'] as $ca_id)
		{	
		
		//echo "select tbl_replace_tempsecurity.* from tbl_replace_tempsecurity where security_id='".$ca_id."' and req_id='".$_GET['reqid']."' and indxx_id='".$_GET['id']."' ";
		
			$check=$this->db->getResult("select tbl_replace_tempsecurity.* from tbl_replace_tempsecurity where security_id='".$ca_id."' and req_id='".$_GET['reqid']."' and indxx_id='".$_GET['id']."' ");
				
		if(!empty($check))
		{
			echo "Allready Exist";
		
		}else{
			
		$this->db->query("INSERT into tbl_replace_tempsecurity set status='1',security_id='".$ca_id."', indxx_id='".$_GET['id']."', req_id='".$_GET['reqid']."'");
		
		$i++;
		}
		
		
		
		}
		}
	//	echo $i;
	//	exit;
		$this->Redirect("index.php?module=replacetempupcoming&event=addNew3&indxx_id=".$_GET['id']."&reqid=".$_GET['reqid'],"Securities to be replaced added successfully!!! <br> Please add new securities","success");
	}
		
			 $this->show();
	
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
								 
								 
								  $this->validData[]=array(	"feild_label"=>"Currency",
	 							"feild_code" =>"curr[".$i.']',
								 "feild_type" =>"text",
								  "feild_tpl" =>"place_text2",
								 "is_required" =>"",
								
								 );	 
	 
								 
		 $this->validData[]=array("feild_label" =>"Div Currency",
		 							"feild_code" =>"divcurr[".$i.']',
								 "feild_type" =>"text",
								 "is_required" =>"",
								  "feild_tpl" =>"place_text2",
								);
	
	
	 /*$this->validData[]=array("feild_label" =>"Index",
	 							"feild_code" =>"indxx_id[".$i.']',
								 "feild_type" =>"hidden",
								 "is_required" =>"",
								   "feild_tpl" =>"hidden2",
								 'value'=>$_SESSION['NewIndxxId']
								 );*/
								 
								 
								 
	$this->validData[]=array("feild_label" =>"Index",
	 							"feild_code" =>"indxx_id",
								 "feild_type" =>"hidden",
								 "is_required" =>"",
								   "feild_tpl" =>"hidden2",
								 'value'=>$_GET['indxx_id']
								 );
	
	
}
	$this->getValidFeilds();
	}
	
	private function addfieldrunning($count,$status=0,$dbusersignoff=0)
	{	
	//echo $status.$dbusersignoff;
		//exit;
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
								 
		/*if($dbusersignoff==1 && $status==1)
		{ $this->validData[]=array("feild_label" =>"Share",
		 							"feild_code" =>"share[".$i.']',
								 "feild_type" =>"text",
								 "is_required" =>"",
								  "feild_tpl" =>"place_text2",
								);
		}
	else{
	 $this->validData[]=array("feild_label" =>"Share",
		 							"feild_code" =>"share[".$i.']',
								 "feild_type" =>"hidden",
								 "is_required" =>"",
								  
								);
		
	}*/
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
							// "feildValues"=>array("onclick"=>"checkvalue('".$id."')"),
								
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
	
	
	
	function addNew()
	{
			$this->_baseTemplate="inner-template";
			$this->_bodyTemplate="replacetempupcoming/add";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
		
			
			
			$this->smarty->assign('pagetitle','Index');
		$this->smarty->assign('bredcrumssubtitle','AddIndex');
		
		
		unset($_SESSION['NewIndxxName']);
		unset($_SESSION['NewIndxxId']);
		unset($_SESSION['indxx_code']);
		unset($_SESSION['indxx_type']);
		
		
		
		if(isset($_POST['submit']))
		{
			$this->db->query("INSERT into tbl_replace_tempindex_req set indxx_id='".mysql_real_escape_string($_POST['indxx_id'])."',startdate='".mysql_real_escape_string($_POST['startdate'])."',user_id='".$_SESSION['User']['id']."' ");
			
			$reqid=mysql_insert_id();
			
			$this->Redirect("index.php?module=replacetempupcoming&event=addNew2&id=".$_POST['indxx_id']."&reqid=".$reqid,"Index added successfully!!!","success");	
		}
		
	
			
			$this->addfieldreplace();
			 $this->show();
	}
	
	
	private function addfieldreplace()
	{	
	   $this->validData[]=array("feild_label" =>"Index Name",
	   								"feild_code" =>"indxx_id",
								 "feild_type" =>"select",
								 "is_required" =>"1",
								 "model"=>$this->getTempIndexes(),
								
								 );
		
								 
		 
	 $this->validData[]=array(	"feild_label"=>"Index Start Date",
	 							"feild_code" =>"startdate",
								 "feild_type" =>"date",
								 "is_required" =>"1",
								);
									 

	
	$this->getValidFeilds();
	}
	
	
	
	
	
	
function addedrunning()
{
	
	$indexdata=$this->db->getResult("select tbl_indxx_temp2.* from tbl_indxx_temp2 where id='".$_SESSION['tempindexid']."' ");
	//$this->pr($indexdata,true);
		$this->_baseTemplate="inner-template";
			$this->_bodyTemplate="replacetempupcoming/addedrunning";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','Securities');
					
			$this->smarty->assign('indexdata',$indexdata);
		$this->smarty->assign('bredcrumssubtitle','Add/Submit Securities');
		
		
		
			
		$this->show();

	
	}	
	function addNewNext()
	{
		$this->_baseTemplate="inner-template";
			$this->_bodyTemplate="replacetempupcoming/addnext";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','Securities');
		$this->smarty->assign('bredcrumssubtitle','Add/Submit Securities');
		
		
		
			
		$this->show();
	}
	
	
	
	
	
	private function addfield()
	{	
	   $this->validData[]=array("feild_label" =>"Index Name",
	   								"feild_code" =>"name",
								 "feild_type" =>"text",
								 "is_required" =>"1",
								
								 );
		 $this->validData[]=array("feild_label" =>"Index Ticker",
		 							"feild_code" =>"code",
								 "feild_type" =>"text",
								 "is_required" =>"1",
								
								 );
								 
		 $this->validData[]=array("feild_label" =>"Investment Amount",
		 							"feild_code" =>"investmentammount",
								 "feild_type" =>"text",
								 "is_required" =>"",
								
								 );
								 
		 $this->validData[]=array("feild_label" =>"Index value",
		 							"feild_code" =>"indexvalue",
								 "feild_type" =>"text",
								 "is_required" =>"1",
								
								 );
	 $this->validData[]=array("feild_label" =>"Type",
	 							"feild_code" =>"type",
								 "feild_type" =>"select",
								 "is_required" =>"1",
								 //"feild_tpl" =>"selectsearch",
								  "model"=>$this->getTypes(),
								 );
								 
								 $this->validData[]=array("feild_label" =>"Zone",
	 							"feild_code" =>"zone",
								 "feild_type" =>"select",
								 "is_required" =>"1",
								 //"feild_tpl" =>"selectsearch",
								  "model"=>$this->getCalendarZone(),
								 );
								 
	 $this->validData[]=array(	"feild_label"=>"Currency",
	 							"feild_code" =>"curr",
								 "feild_type" =>"text",
								 "is_required" =>"1",
								
								 );
								 	 
	 $this->validData[]=array(	"feild_label"=>"Index Start Date",
	 							"feild_code" =>"dateStart",
								 "feild_type" =>"date",
								 "is_required" =>"1",
								);
									 
	/*$this->validData[]=array("feild_code" =>"product_file",
									 "feild_type" =>"file",
									 "is_required" =>"1",
									 "validate" =>"file|csv",		
									 "feild_label" =>"Upload File",
									 );*/
								 
								 
	 
	
	$this->getValidFeilds();
	}
	
	
	private function addeditfield()
	{	
	  	 $this->validData[]=array("feild_label" =>"Index",
	 							"feild_code" =>"indexname",
								 "feild_type" =>"select",
								 "is_required" =>"1",
								 //"feild_tpl" =>"selectsearch",
								  "model"=>$this->getTempIndexes(),
								 );
		
								 	 
	 $this->validData[]=array(	"feild_label"=>"Index Start Date",
	 							"feild_code" =>"dateStart",
								 "feild_type" =>"date",
								 "is_required" =>"1",
								);
									 
	
	
	$this->getValidFeilds();
	}
	
	
	
	
	
	 protected function view(){
		 
		$this->_baseTemplate="inner-template";
			$this->_bodyTemplate="replacetempupcoming/view";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','Index');
		$this->smarty->assign('bredcrumssubtitle','ViewIndex');
		
		
		
		$viewdata=$this->db->getResult("select * from tbl_indxx where tbl_indxx.id='".$_GET['id']."'",true);
		//$this->pr($viewdata,true);
		$this->smarty->assign("viewindexdata",$viewdata);
		
		
		
		
		
		
		
		
		$userdata=$this->db->getResult("select tbl_ca_user.*,tbl_assign_index.* from tbl_assign_index left join tbl_ca_user on tbl_ca_user.id=tbl_assign_index.user_id where tbl_assign_index.indxx_id='".$_GET['id']."'",true);
		//$this->pr($viewdata,true);
		//$this->smarty->assign("totalusers",count($userdata));
		$this->smarty->assign("userdata",$userdata);
		
		
		
		$sequruityData=$this->db->getResult('SELECT * FROM tbl_indxx_ticker where indxx_id="'.$_GET['id'].'"',true);
	//	$this->pr($sequruityData,true);
		$this->smarty->assign("indexSecurity",$sequruityData);
		$this->smarty->assign("totalindexSecurityrows",count($sequruityData));
		
		
		 $this->show();
			
	}
		protected function delete(){
		 
		 //$this->_baseTemplate="inner-template";
			//$this->_bodyTemplate="replacetempupcoming/delete";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','Index');
		$this->smarty->assign('bredcrumssubtitle','Deleted Index');
		
		
		
		
		if($_SESSION['User']['type']=='1' && $_GET['id'])
		{
		 $deleteddata=$this->db->getResult("select tbl_replace_tempindex_req.*,tbl_indxx_temp2.name from tbl_replace_tempindex_req left join tbl_indxx_temp2 on tbl_replace_tempindex_req.indxx_id=tbl_indxx_temp2.id where tbl_replace_tempindex_req.id='".$_GET['id']."'");
		$this->smarty->assign("deleteddata",$deleteddata);
		
		 	$indxx=$deleteddata;
		//$this->pr($indxx,true);
		
		/*$indxxadmins =	$this->db->getResult('Select  user_id from tbl_assign_index_temp2 where indxx_id="'.$_GET['id'].'" ',true);
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
$headers .= 'From: Indexing <indexing@indxx.com>' . "\r\n";
$body='Hi <br>';
$body.='Your Indxx '.$indxx['name'].'('.$indxx['code'].') has been deleted by admin , <br> Please  <a href="'.$this->siteconfig->base_url.'index.php?module=replacetempupcoming">Click here </a> to do more.<br>Thanks ';


		mail($to,"ICAI :Upcoming Indxx Deleted " ,$body,$headers);*/
		
		
	
		 
		 
		 
		 
		$strQuery = "delete from tbl_replace_tempindex_req where tbl_replace_tempindex_req.id='".$_GET['id']."'";
			$this->db->query($strQuery);
			
			
			$strQuery2 = "delete from tbl_tempsecurities_replaced where tbl_tempsecurities_replaced.indxx_id='".$_GET['id']."'";
			$this->db->query($strQuery2);
			
			
			$strQuery3 = "delete from tbl_replace_tempsecurity where tbl_replace_tempsecurity.indxx_id='".$_GET['id']."'";
			$this->db->query($strQuery3);
			
			
			
			$this->Redirect("index.php?module=replacetempupcoming","Index deleted successfully!","success");
			
			
						
	//	echo "select * tbl_indxx where tbl_indxx.id='".$_GET['id']."'";
				
			
			
			
			
			
			
		}
		else
		{
			$checkdata=$this->db->getResult("select tbl_replace_tempindex_req.* from tbl_replace_tempindex_req where tbl_replace_tempindex_req.id='".$_GET['id']."'");
		
		if($checkdata['status']=='1')
		{
		
				$this->Redirect("index.php?module=replacetempupcoming","You are not authorized to perofrm this task!","error");
		}
		else
		{
				$strQuery = "delete from tbl_replace_tempindex_req where tbl_replace_tempindex_req.id='".$_GET['id']."'";
			$this->db->query($strQuery);
			
			
			$strQuery2 = "delete from tbl_tempsecurities_replaced where tbl_tempsecurities_replaced.indxx_id='".$_GET['id']."'";
			$this->db->query($strQuery2);
			
			
			$strQuery3 = "delete from tbl_replace_tempsecurity where tbl_replace_tempsecurity.indxx_id='".$_GET['id']."'";
			$this->db->query($strQuery3);
			
			
			
			$this->Redirect("index.php?module=replacetempupcoming","Index deleted successfully!","success");
			
		}
		}
			
			$this->show();
	}
	
	
	
	
	
	protected function deleteindex(){
		 
		 $this->_baseTemplate="inner-template";
			$this->_bodyTemplate="replacetempupcoming/delete";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','Index');
		$this->smarty->assign('bredcrumssubtitle','Deleted Index');
		
		
			if(!empty($_POST))
			{
				//$this->pr($_POST,true);
				
			foreach($_POST['array1'] as $key2=>$val2)
			{
				if(!empty($val2) && $val2)
				{
			
		 $deleteddata=$this->db->getResult("select tbl_replace_tempindex_req.*,tbl_indxx_temp2.name from tbl_replace_tempindex_req left join tbl_indxx_temp2 on tbl_replace_tempindex_req.indxx_id=tbl_indxx_temp2.id where tbl_replace_tempindex_req.id='".$val2."'");
		$this->smarty->assign("deleteddata",$deleteddata);
		
		 $indexname=$deleteddata['name'];
		 $indexticker=$deleteddata['ticker'];
	
		
		 	$indxx=$deleteddata;
		//$this->pr($indxx,true);
		
	/*	$indxxadmins =	$this->db->getResult('Select  user_id from tbl_assign_index_temp2 where indxx_id="'.$val2.'" ',true);
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
$headers .= 'From: Indexing <indexing@indxx.com>' . "\r\n";
$body='Hi <br>';
$body.='Your Upcoming Indxx '.$indxx['name'].'('.$indxx['code'].') has been deleted by admin , <br> Please  <a href="'.$this->siteconfig->base_url.'index.php?module=replacetempupcoming">Click here </a> to do more.<br>Thanks ';


		mail($to,"ICAI :Upcoming Indxx Deleted " ,$body,$headers);
		*/
		
	
		 
		 
		 
		 
		 
		$strQuery = "delete from tbl_replace_tempindex_req where tbl_replace_tempindex_req.id='".$val2."'";
			$this->db->query($strQuery);
			
			
			$strQuery2 = "delete from tbl_tempsecurities_replaced where tbl_tempsecurities_replaced.req_id='".$val2."'";
			$this->db->query($strQuery2);
			
			
			$strQuery3 = "delete from tbl_replace_tempsecurity where tbl_replace_tempsecurity.req_id='".$val2."'";
			$this->db->query($strQuery3);
			
			
			
						
	//	echo "select * tbl_indxx where tbl_indxx.id='".$_GET['id']."'";
				
			
			
			
			
			
			
			
		
		}
			}
		}
		
		else
		{
			$checkdata=$this->db->getResult("select tbl_replace_tempindex_req.* from tbl_replace_tempindex_req where tbl_replace_tempindex_req.id='".$_GET['id']."'");
		
		if($checkdata['status']=='1')
		{
			
				$this->Redirect("index.php?module=replacetempupcoming","You are not authorized to perofrm this task!","error");
		}
		else
		{
				$strQuery = "delete from tbl_replace_tempindex_req where tbl_replace_tempindex_req.id='".$val2."'";
			$this->db->query($strQuery);
			
			
			$strQuery2 = "delete from tbl_tempsecurities_replaced where tbl_tempsecurities_replaced.req_id='".$val2."'";
			$this->db->query($strQuery2);
			
			
			$strQuery3 = "delete from tbl_replace_tempsecurity where tbl_replace_tempsecurity.req_id='".$val2."'";
			$this->db->query($strQuery3);
			$this->Redirect("index.php?module=replacetempupcoming","Index deleted successfully","success");
		}
		}
			
			$this->show();
	}
	
	
	function subindextemp()
	{
		
		if($_GET['id'])
		{

		
		
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
$body.='You have new upcoming indxx for Replacement, <br> Please  <a href="'.$this->siteconfig->base_url.'index.php?module=replacetempupcoming&event=viewupcoming&id='.$_GET['id'].'">Click here </a> to check it.<br>Thanks ';


		mail($to,"ICAI : New upcoming indxx submitted for Replacement Approval" ,$body,$headers);
		
		$this->db->query("UPDATE tbl_replace_tempindex_req set status='1' where tbl_replace_tempindex_req.id='".$_GET['reqid']."'");
		
		
		$this->Redirect("index.php?module=replacetempupcoming","Record updated successfully!!!","success");	
		}
		else
		{
				$this->Redirect("index.php?module=replacetempupcoming","You are not authorized to perofrm this task!","error");
		}
		//
	}
	
	
	
	protected function viewupcoming(){
		 
		$this->_baseTemplate="inner-template";
			$this->_bodyTemplate="replacetempupcoming/viewupcoming";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','Index');
		$this->smarty->assign('bredcrumssubtitle','View Index');
		
		//$this->pr($_SESSION,true);
		
		///$viewadmindata=$this->db->getResult("select isAdmin from tbl_assign_index_temp where indxx_id='".$_GET['id']."' and user_id='".$_SESSION['User']['id']."'",true);
		//$this->pr($viewadmindata,true);
		//$this->smarty->assign("viewadmindata",$viewadmindata);
		
	
		
		$viewdata=$this->db->getResult("select tbl_replace_tempindex_req.*,tbl_indxx_temp.name as indexname,tbl_indxx_temp.code from tbl_replace_tempindex_req left join tbl_indxx_temp on tbl_indxx_temp.id=tbl_replace_tempindex_req.indxx_id where tbl_replace_tempindex_req.id='".$_GET['id']."'",true);
		//$this->pr($viewdata,true);
		$this->smarty->assign("viewindexdata",$viewdata);
		
//echo		"select tbl_indxx_ticker_temp.*  from tbl_replace_tempsecurity left join tbl_indxx_ticker_temp on tbl_indxx_ticker_temp.id=tbl_replace_tempsecurity.security_id where tbl_replace_tempsecurity.req_id='".$_GET['id']."' and  tbl_replace_tempsecurity.indxx_id='".$viewdata[0]['indxx_id']."'";

		$securitytobereplaced=$this->db->getResult("select tbl_indxx_ticker_temp.*  from tbl_replace_tempsecurity left join tbl_indxx_ticker_temp on tbl_indxx_ticker_temp.id=tbl_replace_tempsecurity.security_id where tbl_replace_tempsecurity.req_id='".$_GET['id']."' and  tbl_replace_tempsecurity.indxx_id='".$viewdata[0]['indxx_id']."'",true);
		//$this->pr($securitytobereplaced);
		$this->smarty->assign("securitytobereplaced",$securitytobereplaced);
		
		
		$newsecurities=$this->db->getResult('SELECT tbl_tempsecurities_replaced. * FROM tbl_tempsecurities_replaced where tbl_tempsecurities_replaced.req_id="'.$_GET['id'].'"',true);
		//$this->pr($newsecurities,true);
		$this->smarty->assign("indexSecurity",$newsecurities);
		$this->smarty->assign("total1",count($securitytobereplaced));
		$this->smarty->assign("total2",count($newsecurities));
		
		
		 $this->show();
			
	}
	
	
	
	
	
	protected function approvetemp(){
		 
		$this->_baseTemplate="inner-template";
			$this->_bodyTemplate="replacetempupcoming/approve";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','Index');
		$this->smarty->assign('bredcrumssubtitle','Approved Index');
		
			if($_SESSION['User']['type']=='1' && $_GET['id'])
		{
		
		
		$this->db->query("UPDATE tbl_replace_tempindex_req set adminapprove='1' where tbl_replace_tempindex_req.id='".$_GET['id']."'");
		
		
		
		
		if($_GET['id'])
		{

		
		
		$indxx=$this->db->getResult("select * from tbl_indxx_temp where tbl_indxx_temp.id='".$_GET['id']."'");
		$this->smarty->assign("indxx",$indxx);
	$admins =	$this->db->getResult('Select  email from tbl_database_users');
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
$body.='There is a change in database. <br> Please upload new securities and currencies. ';


		mail($to,"ICAI : Change In Database" ,$body,$headers);
		
		
		$this->Redirect("index.php?module=replacetempupcoming","Record updated successfully!!!","success");	
		}
		else
		{
				$this->Redirect("index.php?module=replacetempupcoming","You are not authorized to perofrm this task!","error");
		}
		
		
		
		
		}
		 $this->show();
			
	}
	
	
	
	
	protected function dbapprove(){
		 
		$this->_baseTemplate="inner-template";
			$this->_bodyTemplate="replacetempupcoming/approve";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','Index');
		$this->smarty->assign('bredcrumssubtitle','Approved Index');
		
			if($_SESSION['User']['type']=='3' && $_GET['id'])
		{
		
		
		
		$viewdata=$this->db->getResult("select tbl_replace_tempindex_req.*,tbl_indxx_temp.name as indexname,tbl_indxx_temp.code from tbl_replace_tempindex_req left join tbl_indxx_temp on tbl_indxx_temp.id=tbl_replace_tempindex_req.indxx_id where tbl_replace_tempindex_req.id='".$_GET['id']."'",true);
		//$this->pr($viewdata,true);
		$this->smarty->assign("viewindexdata",$viewdata);
		
		
		
		$securitytobereplaced=$this->db->getResult("select tbl_replace_tempsecurity.*,tbl_indxx_ticker_temp.*,tbl_replace_tempindex_req.id as indxxid from tbl_replace_tempsecurity left join tbl_indxx_ticker_temp on tbl_indxx_ticker_temp.id=tbl_replace_tempsecurity.security_id left join tbl_replace_tempindex_req on tbl_replace_tempindex_req.indxx_id=tbl_replace_tempsecurity.indxx_id where tbl_replace_tempindex_req.id='".$_GET['id']."'",true);
		//$this->pr($viewdata,true);
		$this->smarty->assign("securitytobereplaced",$securitytobereplaced);
		
		
		$newsecurities=$this->db->getResult('SELECT tbl_replace_tempindex_req.id as indxxid,tbl_tempsecurities_replaced. * FROM tbl_tempsecurities_replaced  left join tbl_replace_tempindex_req on tbl_replace_tempindex_req.indxx_id=tbl_tempsecurities_replaced.indxx_id where tbl_replace_tempindex_req.id="'.$_GET['id'].'"',true);
	//	$this->pr($sequruityData,true);
		$this->smarty->assign("indexSecurity",$newsecurities);
		$this->smarty->assign("total1",count($securitytobereplaced));
		$this->smarty->assign("total2",count($newsecurities));
		
		
		
					$this->db->query("UPDATE tbl_replace_tempindex_req set dbapprove='1' where tbl_replace_tempindex_req.id='".$_GET['id']."'");
		
		
		
		
		
		}
		 $this->show();
			
	}
	
	
	
	
} // class ends here

?>