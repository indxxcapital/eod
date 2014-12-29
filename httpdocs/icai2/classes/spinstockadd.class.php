<?php 

class Spinstockadd extends Application{
		
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
		$this->_bodyTemplate="spinstockadd/index";
		$this->_title=$this->siteconfig->site_title;
		$this->_meta_description=$this->siteconfig->default_meta_description;
		$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
		
	$data=	$this->db->getResult("Select ssa.dbApprove,ssa.action_id,ssa.id,tbl_ca.identifier,tbl_ca.company_name,tbl_ca.mnemonic,tbl_ca.eff_date from tbl_spin_stock_add ssa 
	left join tbl_ca on ssa.action_id=tbl_ca.action_id 
	
	 ",true);
		//$this->pr($data,true);
		
				$this->smarty->assign("ca_array",$data);
				 $this->show();

		
		}
		
		function view(){
		$data=	$this->db->getResult("Select ssa.dbApprove,ssa.action_id,ssa.id,tbl_ca.identifier,tbl_ca.company_name,tbl_ca.mnemonic,tbl_ca.eff_date from tbl_spin_stock_add ssa 
	left join tbl_ca on ssa.action_id=tbl_ca.action_id 
	where ssa.id=".$_GET['id']."
	 ",false,1);
	 if(!empty($data))
	 {
		$data2=	$this->db->getResult("Select ssas.*,tbl_indxx.name as indxx_name,tbl_indxx.code as indxx_code from tbl_spin_stock_add_securities ssas 
	left join tbl_indxx on tbl_indxx.id=ssas.indxx_id
	where ssas.req_id=".$data['action_id']."
	 ",true);
	//$this->pr($data2,true);
	}
	 $this->smarty->assign("ca_data",$data);
			
$this->smarty->assign("ca_values",$data2);


		$this->_baseTemplate="inner-template";
		$this->_bodyTemplate="spinstockadd/view";
		$this->_title=$this->siteconfig->site_title;
		$this->_meta_description=$this->siteconfig->default_meta_description;
		$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
		

				 $this->show();

	 
	 
	 
	 
		}
		
		
		
		function approve()
		{
			
			
			if($_GET['id'])
			{
			$this->db->query('update tbl_spin_stock_add set dbApprove="1"  where id="'.$_GET['id'].'"');
				$data=	$this->db->getResult("Select ssa.user_id,tbl_ca_user.email,ssa.action_id,ssa.id,tbl_ca.identifier,tbl_ca.company_name,tbl_ca.mnemonic,tbl_ca.eff_date from tbl_spin_stock_add ssa 
	left join tbl_ca on ssa.action_id=tbl_ca.action_id 
	left join tbl_ca_user on tbl_ca_user.id=ssa.user_id
	where ssa.id=".$_GET['id']."
	 ",false,1);
			
			//$this->pr($data,true);
			
			$to=$data['email'];		
			$to="dbajpai@indxx.com";
		$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'From: Indexing <indexing@indxx.com>' . "\r\n"."CC: indexing@indxx.com". "\r\n";
$body='Hi <br>';
$body.='Corporate Action '.$data['identifier'].'('.$data['mnemonic'].') Stock addition has been approved by DB user , <br> Please visit  '.$this->siteconfig->base_url.'index.php?module=myca&event=view&id='.$_GET['id'].' to check it.<br>Thanks ';
mail($to,"Spin-off Stock Addition Approval ",$body,$headers);
			
			
			$this->Redirect("index.php?module=spinstockadd","","");		
			
			
			
			
			}
		
		}
}