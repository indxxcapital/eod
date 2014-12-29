<?php

class Uniquecurrencies extends Application{

	function __construct()
	{
		parent::__construct();
		
		$this->checkUserSession();
	}
	
	
	function index()
	{
		
		$this->_baseTemplate="inner-template";
	$this->_bodyTemplate="uniquecurrencies/index";
		$this->_title=$this->siteconfig->site_title;
		$this->_meta_description=$this->siteconfig->default_meta_description;
		$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
//	$this->addfield();

		$this->smarty->assign('pagetitle','Unique Currencies List');
		$this->smarty->assign('bredcrumssubtitle','Unique Currencies');

$this->addCss('assets/data-tables/DT_bootstrap.css');
$this->addJs('assets/bootstrap/bootstrap.min.js');
$this->addJs('assets/nicescroll/jquery.nicescroll.min.js');
$this->addJs('assets/data-tables/jquery.dataTables.js');
$this->addJs('assets/data-tables/DT_bootstrap.js');
$this->addJs('js/flaty.js');

		//$username=$_SESSION['User']['name'];
		//$userdata=$this->db->getResult("select tbl_ca_user.id as userid,tbl_ca_user.name as username,tbl_ca_user.email,tbl_ca_user.type,count(tbl_indxx.name) as indexes from tbl_assign_index left join tbl_ca_user on tbl_ca_user.id=tbl_assign_index.user_id left join tbl_indxx on tbl_indxx.id=tbl_assign_index.indxx_id group by tbl_ca_user.name");
		
		$Indxxdata=$this->db->getResult("select distinct(curr) from tbl_indxx_temp union select distinct(curr) from tbl_indxx",true);
		$Tickerdata=$this->db->getResult("select distinct(curr) from tbl_indxx_ticker_temp union select distinct(curr) from tbl_indxx_ticker union select distinct(curr) from tbl_runnsecurities_replaced union select distinct(curr) from tbl_tempsecurities_replaced union select distinct(curr) from tbl_spin_stock_add_securities union select distinct(curr) from tbl_spin_stock_add_securities_temp ",true);	
		
		$array=array();
		
		foreach($Indxxdata as $key=>$val)
		{
			foreach($Tickerdata as $key1=>$val1)
			{
		
				if($val['curr']!=$val1['curr'] && $val['curr'] && $val1['curr'])
				{
			
					
					if(array_search($val['curr'].$val1['curr'],$array) || array_search($val1['curr'].$val['curr'],$array))
					{
						
					}
					else
					{
					$array[]=$val['curr'].$val1['curr'];
					}
				}
			}	
		}
		
		$Tickerdata2=$this->db->getResult("select distinct(divcurr) from tbl_indxx_ticker_temp union select distinct(divcurr) from tbl_indxx_ticker union select distinct(divcurr) from tbl_runnsecurities_replaced union select distinct(divcurr) from tbl_tempsecurities_replaced union select distinct(divcurr) from tbl_spin_stock_add_securities union select distinct(divcurr) from tbl_spin_stock_add_securities_temp ",true);	
		
	//	$array=array();
		
		foreach($Indxxdata as $key=>$val)
		{
			foreach($Tickerdata2 as $key1=>$val1)
			{
		
				if($val['curr']!=$val1['divcurr'] && $val['curr'] && $val1['divcurr'])
				{
			
					
					if(array_search($val['curr'].$val1['divcurr'],$array) || array_search($val1['divcurr'].$val['curr'],$array))
					{
						
					}
					else
					{
					$array[]=$val['curr'].$val1['divcurr'];
					}
				}
			}	
		}
		
		
		
		
			
		$exceldata4=$this->db->getResult("select divcurr,curr from tbl_indxx_ticker_temp union select divcurr,curr from tbl_indxx_ticker union select divcurr,curr from tbl_runnsecurities_replaced union select divcurr,curr from tbl_tempsecurities_replaced union select divcurr,curr from tbl_spin_stock_add_securities union select divcurr,curr from tbl_spin_stock_add_securities_temp",true);	
		//$this->pr($exceldata4,true);
		
			foreach($exceldata4 as $key1=>$val1)
			{
				if($val1['curr']!=$val1['divcurr']  && $val1['curr'] && $val1['divcurr'])
				{		
					if(array_search(array($val1['curr'].$val1['divcurr']),$array) || array_search(array($val1['divcurr'].$val1['curr']),$array))
					{
						
					}
					else
					{
					
					$array[]=$val1['divcurr'].$val1['curr'];
					
					}
				}
			
		}
		
		//$this->pr($array,true);
		$uniquearray=array_unique($array);
		
		$this->smarty->assign("currencydata",$uniquearray);

	//$this->pr($userdata,true);
	
		//$this->pr($_SESSION);
		 $this->show();
	}
	
	
	function exportExcel()
	{
		
		require 'php-excel.class.php';
		
		//echo "select * from tbl_ca_user where 1=1";
		
		$exceldata=$this->db->getResult("select distinct(curr) from tbl_indxx_temp union select distinct(curr) from tbl_indxx",true);
		$exceldata2=$this->db->getResult("select distinct(curr) from tbl_indxx_ticker_temp union select distinct(curr) from tbl_indxx_ticker union select distinct(curr) from tbl_runnsecurities_replaced union select distinct(curr) from tbl_tempsecurities_replaced
		union select distinct(curr) from tbl_spin_stock_add_securities
		union select distinct(curr) from tbl_spin_stock_add_securities_temp
		",true);	
		$rowdata=array();
		foreach($exceldata as $key=>$val)
		{
			foreach($exceldata2 as $key1=>$val1)
			{
				if($val['curr']!=$val1['curr']   && $val['curr'] && $val1['curr'])
				{		
					if(array_search(array($val['curr'].$val1['curr']),$rowdata) || array_search(array($val1['curr'].$val['curr']),$rowdata))
					{
						
					}
					else
					{
					
					$rowdata[]=array_unique(array(($val['curr'].$val1['curr'])));
					
					}
				}
			}
		}
		
		
		
		
		$exceldata3=$this->db->getResult("select distinct(divcurr) from tbl_indxx_ticker_temp union select distinct(divcurr) from tbl_indxx_ticker union select distinct(divcurr) from tbl_runnsecurities_replaced union select distinct(divcurr) from tbl_tempsecurities_replaced union select distinct(divcurr) from tbl_spin_stock_add_securities union select distinct(divcurr) from tbl_spin_stock_add_securities_temp",true);	
	//	$rowdata=array();
		foreach($exceldata as $key=>$val)
		{
			foreach($exceldata3 as $key1=>$val1)
			{
				if($val['curr']!=$val1['divcurr'] && $val['curr'] && $val1['divcurr'])
				{		
					if(array_search(array($val['curr'].$val1['divcurr']),$rowdata) || array_search(array($val1['divcurr'].$val['curr']),$rowdata))
					{
						
					}
					else
					{
					
					$rowdata[]=array_unique(array(($val['curr'].$val1['divcurr'])));
					
					}
				}
			}
		}
		
		
		$exceldata4=$this->db->getResult("select divcurr,curr from tbl_indxx_ticker_temp union select divcurr,curr from tbl_indxx_ticker union select divcurr,curr from tbl_runnsecurities_replaced union select divcurr,curr from tbl_tempsecurities_replaced union select divcurr,curr from tbl_spin_stock_add_securities union select divcurr,curr from tbl_spin_stock_add_securities_temp",true);	
		//$this->pr($exceldata4,true);
		
			foreach($exceldata4 as $key1=>$val1)
			{
				if($val1['curr']!=$val1['divcurr'] && $val1['curr'] && $val1['divcurr'])
				{		
					if(array_search(array($val1['curr'].$val1['divcurr']),$rowdata) || array_search(array($val1['divcurr'].$val1['curr']),$rowdata))
					{
						
					}
					else
					{
					
					$rowdata[]=array_unique(array(($val1['curr'].$val1['divcurr'])));
					
					}
				}
			
		}
		
		
		
		
	$data=array();


		if(!empty($rowdata))
		{
		foreach($rowdata as $securities)
		{
			$data[]=strtoupper($securities[0]);
			
		
		}
		}
		
		$data2=array_unique($data);
		//$this->pr(array_unique($data));
		//exit;
		
		
		
		
		
		
		
		//$rowdata2=array_unique($rowdata);
		//$this->pr($data2);
		//exit;
		
		// create a simple 2-dimensional array
		$data = array(
        1 => array ('Currency Symbols'),
        //array('Schwarz', 'Oliver'),
        //array('Test', 'Peter')
        );
		
	//	echo "<pre>";
		// generate file (constructor parameters are optional)
		$xls = new Excel_XML('UTF-8', false, 'Currency Symbol Data');
		$xls->addArray($data);
		foreach($data2 as $key1=>$val1)
		{
			$excelarray[0] = array(
        	1 => $val1,
        	);
			//print_r($excelarray);
			
			$xls->addArray($excelarray);
		}
		
	//	exit;
		$xls->generateXML('Currency Symbol Data');	
	}
	
} // class ends here

?>