<?php

class Upcomingca extends Application{

	function __construct()
	{
		parent::__construct();
		$this->checkUserSession();
	}
	
	
	function index()
	{
		
		$this->_baseTemplate="inner-template";
	$this->_bodyTemplate="myca/index";
		$this->_title=$this->siteconfig->site_title;
		$this->_meta_description=$this->siteconfig->default_meta_description;
		$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
//	$this->addfield();

		$this->smarty->assign('pagetitle','Index');
		$this->smarty->assign('bredcrumssubtitle','Index');

$this->addCss('assets/data-tables/DT_bootstrap.css');
$this->addJs('assets/bootstrap/bootstrap.min.js');
$this->addJs('assets/nicescroll/jquery.nicescroll.min.js');
$this->addJs('assets/data-tables/jquery.dataTables.js');
$this->addJs('assets/data-tables/DT_bootstrap.js');
$this->addJs('js/flaty.js');


$type=$_SESSION['User']['type'];
//$users=
if(date('D')!="Mon")
{
$date=date("Y-m-d",strtotime($this->_date)-86400);
}else{
$date=date("Y-m-d",strtotime($this->_date)-(86400*3));

}
		$indexdata=$this->db->getResult("SELECT id,action_id,identifier,mnemonic,company_name,ann_date,eff_date,action_id,status,(if(action_id in (select ca_action_id from tbl_ca_admin_approve where ca_action_id=cat.action_id),1,0)) as approved FROM `tbl_ca` cat WHERE `eff_date` >= '".$date."'  order by eff_date asc",true);
		$indexes=array();
		foreach($indexdata as $key=>$value)
		{
			$dividendvalue=$this->db->getResult("select tbl_ca_values.field_value,ca_id from  tbl_ca_values  where tbl_ca_values.ca_id='".$value['id']."' and field_name='CP_DVD_TYP' and field_value!='1000'",true);
			
			if(!empty($dividendvalue['0']['field_value']))
			$indexdata[$key]['notregularcash']=	$dividendvalue['0']['field_value'];
		}
	
		//$this->pr($indexdata,true);

		$this->smarty->assign("indexdata",$indexdata);
		
$this->smarty->assign("ca_array",$indexdata);
	//$this->pr($indexdata,true);
	
		//$this->pr($_SESSION);
		 $this->show();
	}
	
	function addNew()
	{
			$this->_baseTemplate="inner-template";
			$this->_bodyTemplate="upcomingca/add";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','Index');
		$this->smarty->assign('bredcrumssubtitle','AddIndex');
		
		
		if(isset($_POST['submit']))
		{
		$this->db->query("INSERT into tbl_indxx_ticker set name='".mysql_real_escape_string($_POST['name'])."',isin='".mysql_real_escape_string($_POST['isin'])."',ticker='".mysql_real_escape_string($_POST['ticker'])."',weight='".mysql_real_escape_string($_POST['weight'])."',curr='".mysql_real_escape_string($_POST['curr'])."',indxx_id='".mysql_real_escape_string($_POST['indxx_id'])."'");
		
			$this->Redirect("index.php?module=casecurities&event=addNew","Record added successfully!!!","success");	
		}
		
	
			
			$this->addfield();
			 $this->show();
	}
	
	
	private function addfield()
	{	
	   $this->validData[]=array("feild_label" =>"Identifier",
	   								"feild_code" =>"identifier",
								 "feild_type" =>"text",
								 "is_required" =>"1",
								
								 );
		 $this->validData[]=array("feild_label" =>"Mnemonic",
		 							"feild_code" =>"mnemonic",
								 "feild_type" =>"text",
								 "is_required" =>"1",
								
								 );
								 
		 $this->validData[]=array("feild_label" =>"Company Name",
		 							"feild_code" =>"company_name",
								 "feild_type" =>"text",
								 "is_required" =>"1",
								
								 );
								 
		 $this->validData[]=array("feild_label" =>"Effective Date",
		 							"feild_code" =>"eff_date",
								 "feild_type" =>"text",
								 "is_required" =>"1",
								
								 );
	 $this->validData[]=array("feild_label" =>"Announce Date",
	 							"feild_code" =>"ann_date",
								 "feild_type" =>"text",
								 "is_required" =>"1",
								 //"feild_tpl" =>"selectsearch",
								 // "model"=>$this->getIndexes(),
								 );
								 
							
	$this->getValidFeilds();
	}
	
	
	protected function edit(){
		 
		$this->_baseTemplate="inner-template";
			$this->_bodyTemplate="upcomingca/edit";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','Index');
		$this->smarty->assign('bredcrumssubtitle','EditIndex');
		$this->addfield();
		
		
		if(isset($_POST['submit']))
		{
			
		$this->db->query("UPDATE tbl_indxx_ticker set identifier='".mysql_real_escape_string($_POST['identifier'])."',mnemonic='".mysql_real_escape_string($_POST['mnemonic'])."',company_name='".mysql_real_escape_string($_POST['company_name'])."',eff_date='".mysql_real_escape_string($_POST['eff_date'])."',ann_date='".mysql_real_escape_string($_POST['ann_date'])."'");
		
			$this->Redirect("index.php?module=casecurities","Record updated successfully!!!","success");	
		}
		
		
		
		$editdata=$this->db->getResult("SELECT * FROM `tbl_ca` WHERE `eff_date` >= '".date("Y-m-d")."' and tbl_ca.id='".$_GET['id']."'");
		//$this->pr($editdata,true);
		$this->smarty->assign("postData",$editdata);
		
		
		
		
		 $this->show();
			
	}
	
	
	protected function delete(){
		 
		$strQuery = "delete from tbl_ca where tbl_ca.id='".$_GET['id']."'";
			//$this->db->query($strQuery);
			
		$strQuery1 = "delete from tbl_ca_values where tbl_ca_values.ca_id='".$_GET['id']."'";
			//$this->db->query($strQuery1);
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
		
		
					$strQuery = "delete from tbl_ca where tbl_ca.id='".$val2."'";
					$this->db->query($strQuery);
			
			
					$strQuery2 = "delete from tbl_ca_values where tbl_ca_values.ca_id='".$val2."'";
					$this->db->query($strQuery2);
			
			}
			}
		}
		
		$this->Redirect("index.php?module=upcomingca","Records deleted successfully!!!","success");
		$this->show();	
	}
	
	
} // class ends here

?>