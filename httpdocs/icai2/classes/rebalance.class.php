<?php

class Rebalance extends Application{

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
	
function index(){
	
	$this->addNew();
	
	}
function addNew(){
	
		$this->_baseTemplate="inner-template";
			$this->_bodyTemplate="caindex/add";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
		
			
			
			$this->smarty->assign('pagetitle','Index');
		$this->smarty->assign('bredcrumssubtitle','AddIndex');
		
		
		$databaseuserdata=$this->db->getResult("select tbl_database_users.* from tbl_database_users where 1=1");
		
		if(!empty($_POST))
		{
			
			//$indxxData=$this->db->getResult("select * from tbl_indxx where id='".$_POST['indxx_id']."'");
			$_SESSION['rebalance']['indxx']=$_POST['indxx_id'];	
			$_SESSION['rebalance']['dateStart']=$_POST['calcdate'];	
			$_SESSION['rebalance']['calcdate']=$_POST['calcdate'];
			$_SESSION['rebalance']['rebalance']=1;	
			
			$this->Redirect("index.php?module=rebalance&event=addSecurities","Index added successfully!!!","success");	
			
			}
		
	
			
			$this->addLivefield();
			 $this->show();
			 
			
			}
	
	
	function addLivefield(){
	
	
	$this->validData[]=array("feild_label" =>"Index Name",
	   								"feild_code" =>"indxx_id",
								 "feild_type" =>"select",
								 "is_required" =>"1",
								 "model"=>$this->getRunningIndexes(),
								
								 );
		 $this->validData[]=array(	"feild_label"=>"Index Start Date",
	 							"feild_code" =>"dateStart",
								 "feild_type" =>"date",
								 "is_required" =>"1",
								);
								
								
								
		 $this->validData[]=array(	"feild_label"=>"Index Live Date",
	 							"feild_code" =>"calcdate",
								 "feild_type" =>"date",
								 "is_required" =>"1",
								);
								
		$this->getValidFeilds();
								
	
	}
	
	function addSecurities(){
	
	
		//$this->pr($_SESSION,true);
			$this->_baseTemplate="inner-template";
			$this->_bodyTemplate="rebalance/add2";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','Index');
		$this->smarty->assign('bredcrumssubtitle','Add Securities');
		
		
		$indexdata=$this->db->getResult("select * from tbl_indxx where id='".$_SESSION['rebalance']['indxx']."' ");
		
		$tickerdata=$this->db->getResult("select tbl_indxx_ticker.* from tbl_indxx_ticker where indxx_id='".$_SESSION['rebalance']['indxx']."' ",true);
	//	$this->pr($tickerdata,true);
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
			
			
			
				//$this->db->query("delete from tbl_indxx_ticker_temp where indxx_id='".$_SESSION['NewIndxxId']."'");
			
			
			$this->db->query("INSERT into tbl_indxx_temp set status='0',name='".mysql_real_escape_string($indexdata['name'])."',code='".mysql_real_escape_string($indexdata['code'])."',investmentammount='".mysql_real_escape_string($indexdata['investmentammount'])."',divisor='".mysql_real_escape_string($indexdata['divisor'])."',type='".mysql_real_escape_string($indexdata['type'])."',curr='".mysql_real_escape_string($indexdata['curr'])."',lastupdated='".date("Y-m-d h:i:s")."',dateStart='".$_SESSION['rebalance']['dateStart']."',calcdate='".$_SESSION['rebalance']['calcdate']."',rebalance='".$_SESSION['rebalance']['rebalance']."'");
		
		$indexid=mysql_insert_id();
			$_SESSION['rebalance']['newindxx']=$indexid;	
		
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
			
			
			for($i=1;$i<=$_POST['totalfields'];$i++)
			{
				if($_POST['name'][$i] && $_POST['isin'][$i] && $_POST['ticker'][$i] && $_POST['weight'][$i] && $_POST['curr'][$i])
				{
					//$this->pr($_POST,true);
					
						
					$this->db->query("INSERT into tbl_indxx_ticker_temp set status='0',name='".mysql_real_escape_string($_POST['name'][$i])."',isin='".mysql_real_escape_string($_POST['isin'][$i])."',ticker='".mysql_real_escape_string($_POST['ticker'][$i])."',weight='".mysql_real_escape_string($_POST['weight'][$i])."',curr='".mysql_real_escape_string($_POST['curr'][$i])."',divcurr='".mysql_real_escape_string($_POST['divcurr'][$i])."',indxx_id='".mysql_real_escape_string($indexid)."'");
					
					$added++;
		
				}	
			}
			
			
			if($added>=1)
		{
			
			
			
			
			$this->Redirect("index.php?module=rebalance&event=addNewNext&id=".$added,"Index added successfully!!! <br> Please Wait for Approval","success");	
		}
		else
		{
			$this->Redirect("index.php?module=rebalance&event=addSecurities","No security added!!! <br> Please add again","error");	
		}
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
								 
		 $this->validData[]=array("feild_label" =>"Weight",
		 							"feild_code" =>"weight[".$i.']',
								 "feild_type" =>"text",
								 "is_required" =>"",
								  "feild_tpl" =>"place_text2",
								);
	
	
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
								  "feild_tpl" =>"place_text1",
								 "is_required" =>"",
								
								 );	 
	 $this->validData[]=array(	"feild_label"=>"Dividend Currency",
	 							"feild_code" =>"divcurr[".$i.']',
								 "feild_type" =>"text",
								  "feild_tpl" =>"place_text1",
								 "is_required" =>"",
								
								 );	 
}
	$this->getValidFeilds();
	}
	
	function addNewNext()
	{
		$this->_baseTemplate="inner-template";
			$this->_bodyTemplate="rebalance/addnext";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
		//$this->pr($_SESSION,true);	
			$this->smarty->assign('pagetitle','Securities');
		$this->smarty->assign('bredcrumssubtitle','Add/Submit Securities');
		
		
		
			
		$this->show();
	}
	
	
	
	}
   ?>