<?php 

class Cadissapprove extends Application{
		
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
	$this->_bodyTemplate="cadissapprove/index";
		$this->_title=$this->siteconfig->site_title;
		$this->_meta_description=$this->siteconfig->default_meta_description;
		$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
		
		
	$cas=$this->db->getResult("select tbl_ca_dissapprove.* from tbl_ca_dissapprove where 1=1",true);
	
	$this->smarty->assign('cas',$cas);
		
		
		
		$this->show();
		}
		
	function addNew()
	{
			$this->_baseTemplate="inner-template";
			$this->_bodyTemplate="cadissapprove/add";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
		
			
			
			$this->smarty->assign('pagetitle','Index');
		$this->smarty->assign('bredcrumssubtitle','AddIndex');
		
		
	$cas=$this->db->getResult("select tbl_ca.* from tbl_ca where 1=1",true);
	$this->smarty->assign('cas',$cas);
		
	if(isset($_POST['submit']))
	{
		//$this->pr($_POST,true);
		$i=0;
		if(!empty($_POST['checkboxid']))
		{
		foreach($_POST['checkboxid'] as $ca_id)
		{	
			$check=$this->db->getResult("select tbl_ca_dissapprove.* from tbl_ca_dissapprove where ca_id='".$ca_id."'");
				$check2=$this->db->getResult("select tbl_ca.* from tbl_ca where action_id='".$ca_id."'");
		if(!empty($check))
		{
			echo "Allready Exist";
		
		}else{
		
		
		//$this->pr($check2,true);
//		echo "In Insert Section";
		$this->db->query("INSERT into tbl_ca_dissapprove set ca_id='".$ca_id."', identifier='".$check2['identifier']."', name='".$check2['company_name']."', ca='".$check2['mnemonic']."', ann_date='".$check2['ann_date']."' ,eff_date='".$check2['eff_date']."'");
		
		$i++;
		}
		
		
		
		}
		}
		$this->Redirect("index.php?module=cadissapprove&event=index",$i. " Record added successfully!!!","success");	
		
	}
		
	
			
		//	$this->addfield();
			 $this->show();
	}
	
	
	
	function delete(){
	
	//$this->pr($_POST);
	if(!empty($_POST['array1']))
	{
	foreach ($_POST['array1'] as $id)
	{
	if($id)
	{
	$this->db->query("Delete from tbl_ca_dissapprove where id='".$id."'");
	}
	}
	
	}	
	
	return true;
	}
	

		
		
}?>