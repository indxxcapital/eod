<?php

class Commodityindxx extends Application{

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
	$this->smarty->assign('pagetitle','Commodity Index');
	$this->smarty->assign('bredcrumssubtitle','Commodity Index');	
	
	$this->_baseTemplate="inner-template";
	$this->_bodyTemplate="commodityindxx/index";
			$this->_title='Commodity Index';
	$indxxdata=$this->db->getResult("select * from tbl_commodity_indxx",true);
	
	
	//$this->pr($indxxdata,true);
	$this->smarty->assign("indexdata",$indxxdata);
	
		
	 $this->show();
	}
	 function addNew()
	{
			$this->_baseTemplate="inner-template";
			$this->_bodyTemplate="commodityindxx/add";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','Index');
		$this->smarty->assign('bredcrumssubtitle','AddIndex');
		
		
		if(isset($_POST['saveandnext']))
		{
	//	$this->db->query("INSERT into tbl_indxx_ticker set name='".mysql_real_escape_string($_POST['name'])."',isin='".mysql_real_escape_string($_POST['isin'])."',ticker='".mysql_real_escape_string($_POST['ticker'])."',weight='".mysql_real_escape_string($_POST['weight'])."',curr='".mysql_real_escape_string($_POST['curr'])."',indxx_id='".mysql_real_escape_string($_POST['indxx_id'])."'");
	
	$_SESSION['CSI']=$_POST;
	
		
			$this->Redirect("index.php?module=commodityindxx&event=addAdjfactor","Please Select Index and Submit Weight !!!","success");	
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
								 
								 
	 $this->validData[]=array(	"feild_label"=>"Index Start Date",
	 							"feild_code" =>"dateStart",
								 "feild_type" =>"date",
								 "is_required" =>"1",
								);
								  
								 
	$this->getValidFeilds();
	}
	
	 
	 function addAdjfactor(){
		
	
//	$this->pr($_SESSION,true);
	
	$this->_baseTemplate="inner-template";
			$this->_bodyTemplate="commodityindxx/addnext";
			$this->_title="Add Commodity Weights";
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','Index');
		$this->smarty->assign('bredcrumssubtitle','AddIndex');
	
	
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
	
	
		$this->db->query("INSERT into tbl_commodity_indxx set status='0', name='".mysql_real_escape_string($_SESSION['CSI']['name'])."',code='".mysql_real_escape_string($_SESSION['CSI']['code'])."',zone='".mysql_real_escape_string($_SESSION['CSI']['zone'])."',client_id='".mysql_real_escape_string($_SESSION['CSI']['client_id'])."',datestart='".mysql_real_escape_string($_SESSION['CSI']['dateStart'])."',user_id='".mysql_real_escape_string($_SESSION['User']['id'])."'");
//	$this->pr($_SESSION['CSI']);
	$newIndxx_id=mysql_insert_id();
	foreach($_POST['indxx_id'] as $index_key=>$index_id)
	{
//	$indxxdata=$this->db->getResult("select code from tbl_indxx where id = '".$index_id."' ",false,1);
	
	$this->db->query("INSERT into tbl_commodity_indxx_ticker set indxx_id='".mysql_real_escape_string($newIndxx_id)."',ticker_id='".mysql_real_escape_string($index_id)."',weight='".mysql_real_escape_string($_POST['fraction'][$index_key])."'");
//	$this->pr($_SESSION['CSI']);
	//$this->pr($indxxdata);
	}
	
	
	
	
	
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
			
			
			$text="New  Commodity Index  : ".$_SESSION['CSI']['name']." (".$_SESSION['CSI']['code'].") added by ".$_SESSION['User']['name']."\r\n Please View 
			
			". $this->siteconfig->base_url."
			
			 and Approve It to Run";
			 
			
			
			$msg='Hi <br>'.$text." <br>Thanks <br>";
					
					// To send HTML mail, the Content-type header must be set
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			
			// Additional headers
			//$headers .= 'To: '.$dbuser['name'].' <'.$dbuser['email'].'>'. "\r\n";
$headers .= 'From: Indexing <indexing@indxx.com>' . "\r\n"."CC: indexing@indxx.com". "\r\n";
					//echo $emailsids;
						if(mail( $emailsids,"New Commodity Index ",$msg,$headers))
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
	
		
			$this->Redirect("index.php?module=commodityindxx","Record added successfully!!!","success");	
		}
		
	
	
			$this->addfield2($this->getActiveCommodityTickerCount());
			 $this->show();
			 
			 
			 
			 
	
	
	}
	
	
	
	function edit()
	{
			$this->_baseTemplate="inner-template";
			$this->_bodyTemplate="commodityindxx/addnext";
			$this->_title="Edit Commodity Factor";
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','Index');
		$this->smarty->assign('bredcrumssubtitle','AddIndex');
	
		
		
		$tickerdata=$this->db->getResult("select tbl_commodity_indxx_ticker.* from tbl_commodity_indxx_ticker where indxx_id='".$_GET['id']."' ",true);
	
	if(count($tickerdata)>0)
		{
			$totalfields=count($tickerdata);	
		}
		else
		{
		$totalfields=$this->getActiveCommodityTickerCount();
		}
		
		$array=array();
		
		for($i=0;$i<$totalfields;$i++)
		{
			$array['indxx_id['.($i+1).']']=$tickerdata[$i]['ticker_id'];
			
			$array['fraction['.($i+1).']']=$tickerdata[$i]['weight'];
			//$array[]=	
		}
		
		$this->smarty->assign('postData',$array);
		$this->addfield2($totalfields);
		
		
		
		
		
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
	
	//echo "updated tbl_commodity_indxx set status='0' where  id ='".$_GET['id']."'";
	//exit;
		$this->db->query("update tbl_commodity_indxx set status='0' where  id ='".$_GET['id']."'");
//	$this->pr($_SESSION['CSI']);
	//$newIndxx_id=mysql_insert_id();
	$strQuery = "delete from tbl_commodity_indxx_ticker where indxx_id='".$_GET['id']."'";
					$this->db->query($strQuery);
	foreach($_POST['indxx_id'] as $index_key=>$index_id)
	{
	//$indxxdata=$this->db->getResult("select code from tbl_indxx where id = '".$index_id."' ",false,1);
	
	$this->db->query("INSERT into tbl_commodity_indxx_ticker set indxx_id='".mysql_real_escape_string($_GET['id'])."',ticker_id='".mysql_real_escape_string($index_id)."',weight='".mysql_real_escape_string($_POST['fraction'][$index_key])."'");
	
	
	//	$this->pr($_SESSION['CSI']);
	//$this->pr($indxxdata);
	}
	
	
	
	
	
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
			
			
			$text="Commodity Index  : ".$_SESSION['CSI']['name']." (".$_SESSION['CSI']['code'].") Updated by ".$_SESSION['User']['name']."\r\n Please View 
			
			". $this->siteconfig->base_url."
			
			and Approve It to Run";
			 
			
			
			$msg='Hi <br>'.$text." <br>Thanks <br>";
					
					// To send HTML mail, the Content-type header must be set
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			
			// Additional headers
			//$headers .= 'To: '.$dbuser['name'].' <'.$dbuser['email'].'>'. "\r\n";
$headers .= 'From: Indexing <indexing@indxx.com>' . "\r\n"."CC: indexing@indxx.com". "\r\n";
					//echo $emailsids;
						if(mail($emailsids,"New Commodity Index ",$msg,$headers))
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
	
		
			$this->Redirect("index.php?module=commodityindxx","Record Updated  successfully!!!<br> Please Wait for Admin Approval.","success");	
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
								  "model"=>$this->getCommodityIndexesNew(),
								 );
	
	  
	  
	  $this->validData[]=array("feild_label" =>"Weight",
		 							"feild_code" =>"fraction[".$i.']',
								 "feild_type" =>"text",
								 "is_required" =>"",
								  "feild_tpl" =>"place_text2",
								);
	



}
	$this->getValidFeilds();
	}


	protected function delete(){
		
		 	$strQuery1 = "delete from tbl_commodity_indxx where id='".$_GET['id']."'";
					$this->db->query($strQuery1);
					
									
					$strQuery = "delete from tbl_commodity_indxx_ticker where indxx_id='".$_GET['id']."'";
					$this->db->query($strQuery);
			
			$this->Redirect("index.php?module=commodityindxx","Record deleted successfully!!!","success");
			
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
				$strQuery1 = "delete from tbl_commodity_indxx where id='".$_GET['id']."'";
					$this->db->query($strQuery1);
					
									
					$strQuery = "delete from tbl_commodity_indxx_ticker where indxx_id='".$_GET['id']."'";
					$this->db->query($strQuery);
			}
			}
		}
		$this->Redirect("index.php?module=commodityindxx","Records deleted successfully!!!","success");
		$this->show();	
	}
	
	function view()
{
	
	
	$this->_baseTemplate="inner-template";
			$this->_bodyTemplate="commodityindxx/view";
			$this->_title="View Commodity Index";
	
	$indxxdata=$this->db->getResult("select * from tbl_commodity_indxx where id = '".$_GET['id']."' ",true);
	

	
	$indxxfactordata=$this->db->getResult("select * from tbl_commodity_indxx_ticker where indxx_id = '".$_GET['id']."' ",true);
if(!empty($indxxfactordata))
{
foreach($indxxfactordata as $key=> $data)
{
$indxxname=$this->db->getResult("select name from tbl_commodity_ticker where id = '". $data['ticker_id']."' ",false,1);
$indxxfactordata[$key]['name']=$indxxname['name'];
}
}
		
		
	$this->smarty->assign("indxxdata",$indxxdata);
			
	$this->smarty->assign("indxxfactordatacount",count($indxxfactordata));
	$this->smarty->assign("indxxfactordata",$indxxfactordata);
	
		$this->show();
}	
	
	
	function approve(){
	
	$indxxdata=$this->db->getResult("select * from tbl_commodity_indxx where id = '".$_GET['id']."' ",false,1);
	
	//$this->pr($indxxdata,true);
	
			
			
			$strQuery1 = "update tbl_commodity_indxx set status='1' where id='".$_GET['id']."'";
					$this->db->query($strQuery1);
			
				$emailQueries=$this->db->getResult('select email from tbl_ca_user where status="1" and id="'.$indxxdata['user_id'].'" ',false,1);
			
			$text="Your  Commodity Index  : ".$indxxdata['name']." (".$indxxdata['code'].") approved  by ".$_SESSION['User']['name']."\r\n ";
			 
			
			
			$msg='Hi <br>'.$text." <br>Thanks <br>";
					
					// To send HTML mail, the Content-type header must be set
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			
			// Additional headers
			//$headers .= 'To: '.$dbuser['name'].' <'.$dbuser['email'].'>'. "\r\n";
$headers .= 'From: Indexing <indexing@indxx.com>' . "\r\n"."CC: indexing@indxx.com". "\r\n";
					//echo $emailQueries['email'];
//exit;
						if(mail($emailQueries['email'],"Commodity Index Approved",$msg,$headers))
					{
						echo "Mail Send ";
						
						//echo "Mail sent to : ".$dbuser['name']."<br>";	
					}
					else
					{
						echo "Mail not sent";	
					}
					
			
	$this->Redirect("index.php?module=commodityindxx","Records Approved successfully!!!","success");
	}
	

}