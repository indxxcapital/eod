<?php 

class Myindex extends Application{
		
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
			$id=$_SESSION['User']['id'];


	$indxx=	$this->db->getResult("select distinct(indxx_id) as indxx from tbl_assign_index where user_id = '".$id."'",	true);
	//	$this->pr($indxx);
		$array=array();
		
		if(!empty($indxx))
		{
		foreach($indxx as $ind)
		{
	//	$this->pr($ind);
		$indxxticker=	$this->db->getResult("select id,name,code from tbl_indxx where id ='".$ind['indxx']."'",	true);
		
		if(!empty($indxxticker))
		{
		foreach($indxxticker as $ticker)
		{
		$array[]=$ticker;
		}
		}
		
			//	$this->pr($indxxticker);
		}
		}
		
		
		
		$this->smarty->assign("indexarray",$array);
			
		$this->_baseTemplate="inner-template";
	$this->_bodyTemplate="myindex/index";
		$this->_title=$this->siteconfig->site_title;
		$this->_meta_description=$this->siteconfig->default_meta_description;
		$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
		
		
				$this->smarty->assign("ca_array",$ca_array);
				 $this->show();
	
		
		
		}
		
		
		function viewca(){
			
			if(date('D')!="Mon")
{
$date=date("Y-m-d",strtotime($this->_date)-86400);
}else{
$date=date("Y-m-d",strtotime($this->_date)-(86400*3));

}
			
			$this->_baseTemplate="inner-template";
	$this->_bodyTemplate="myca/index";
		$this->_title=$this->siteconfig->site_title;
		$this->_meta_description=$this->siteconfig->default_meta_description;
		$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
//	$this->addfield();

		$this->smarty->assign('pagetitle','Corporate Actions');
		$this->smarty->assign('bredcrumssubtitle','View Corporate Actions');

		
		$indxxData=	$this->db->getResult("select id,name,code from tbl_indxx where id ='".$_GET['id']."'",	true);
		$this->smarty->assign("indxxData",$indxxData[0]);
	//	$this->pr($indxxData,true);
		
		$array=array();
		$indxxticker=	$this->db->getResult("select distinct(ticker) as indxxticker from tbl_indxx_ticker where indxx_id ='".$_GET['id']."'",	true);
		
		if(!empty($indxxticker))
		{
		foreach($indxxticker as $ticker)
		{
		$array[]=$ticker['indxxticker'];
		}
		}
		if(!empty($array))
		{$array=array_unique($array);
		$ca_array=array();
		{
		foreach ($array as $identifier)
		{
		$ca=	$this->db->getResult("select tbl_ca.id,tbl_ca.identifier,tbl_ca.mnemonic,tbl_ca.company_name,tbl_ca.ann_date,tbl_ca.eff_date,tbl_ca.action_id, 	tbl_ca.notifiedtoadmin ,	tbl_ca.notifiedtoclient,tbl_ca.status,(if(action_id in (select ca_action_id from tbl_ca_admin_approve where ca_action_id=tbl_ca.action_id),1,0)) as approved from tbl_ca where identifier ='".$identifier."' ",true);
		//$this->pr($ca); 
		if(!empty($ca))
		{
		foreach($ca as $cas)
		{
		$ca_array[]=$cas;
		}
		}
		
		}
		}}
		
			
		foreach($ca_array as $key=>$value)
		{
			$dividendvalue=$this->db->getResult("select tbl_ca_values.field_value,ca_id from  tbl_ca_values  where tbl_ca_values.ca_id='".$value['id']."' and field_name='CP_DVD_TYP' and field_value!='1000'",true);
			
			if(!empty($dividendvalue['0']['field_value']))
			$ca_array[$key]['notregularcash']=	$dividendvalue['0']['field_value'];	
		}
		
		//$this->pr($ca_array,true);
		
	$this->smarty->assign("ca_array",$ca_array);
//	$this->pr($indxxd,true);
	
		//$this->pr($_SESSION);
		 $this->show();
		}
		
		
		
}?>