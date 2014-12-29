<?php

class Updatesedol extends Application{

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
function index(){
	$this->_baseTemplate="inner-template";
			$this->_bodyTemplate="updatesedol/index";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','Index');
		$this->smarty->assign('bredcrumssubtitle','Add Sedol');
			
			if(!empty($_POST))
			{
			$fields=array("name",'isin','sedol');		
				$data = csv::import($fields,$_FILES['name']['tmp_name']);	
			//$this->pr($data,true);
			
			$i=0;
			if(!empty($data))
			{
			foreach($data as $security)
			{
				
				if($security['sedol']!='N.A.' && $security['sedol'])
		 { $updateQuery="Update tbl_indxx_ticker set sedol='".$security['sedol']."' where isin='".$security['isin']."'  and indxx_id='".$_POST['indxx_id']."'";
			    $this->db->query($updateQuery);
				
		/*  $updatetempQuery="Update tbl_indxx_ticker_temp set sedol='".$security['sedol']."' where isin='".$security['isin']."'";
			    $this->db->query($updatetempQuery);
				
			 $updatetempReplaceQuery="Update tbl_tempsecurities_replaced set sedol='".$security['sedol']."' where isin='".$security['isin']."'";
			    $this->db->query($updatetempReplaceQuery);
							
			 $updaterunnReplaceQuery="Update tbl_runnsecurities_replaced set sedol='".$security['sedol']."' where isin='".$security['isin']."'";
			    $this->db->query($updaterunnReplaceQuery);	*/
				
				$i++;
		 }
		 }
		//	exit;
			}
			
			
			}
			
			if($i)
			$this->setMessage($i." Records Updated ","success");	
			$this->addfield();
			 $this->show();
			 
}

	
	private function addfield()
	{	
	
	
	 $this->validData[]=array("feild_label" =>"Index Name",
	   								"feild_code" =>"indxx_id",
								 "feild_type" =>"select",
								 "is_required" =>"1",
								 "model"=>$this->getRunningIndexes(),
								
								 );
		
	
	   $this->validData[]=array("feild_label" =>"Sedol Data file",
	   								"feild_code" =>"name",
								 "feild_type" =>"file",
								 "is_required" =>"1",
								"feild_note" =>"<a href='".$this->siteconfig->base_url."media/sample-files/sedol-sample-file.csv' target='_blank'>View Sample</a>",
								 );
		
	
	$this->getValidFeilds();
	}
	


}