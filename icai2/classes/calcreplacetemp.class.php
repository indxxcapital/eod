<?php

class Calcreplacetemp extends Application{

	function __construct()
	{
		parent::__construct();
	}
		
	function index()
	{
		/* TODO: Convert all getresult calls into mysql calls, paging isn;t needed */
		/* TODO: This logic can be optimized more */
		
		$datevalue2 = $this->_date;
		
		if($_GET['log_file'])
			define("log_file", $_GET['log_file']);
		
		if($_GET['DEBUG'])
			define("DEBUG", $_GET['DEBUG']);
		
		$this->log_info(log_file, "CA [replace upcoming index] process started");
		
		$final_array=array();
		 	
		$indxxs = $this->db->getResult("select id, indxx_id from tbl_replace_tempindex_req where 
					startdate='".$datevalue2."' and adminapprove='1' and dbapprove='1'",true);
	
		if(!empty($indxxs))	
		{
			foreach ($indxxs as $indxx)
			{
				$indxx_data=$this->db->getResult("select * from tbl_indxx_temp where id='".$indxx['indxx_id']."'");	
				if(!empty($indxx_data))
					$final_array [$indxx ['indxx_id']]['details']=$indxx_data;
	
				$indxx_value=$this->db->getResult("select * from tbl_indxx_value_temp where indxx_id='".$indxx['indxx_id']."' order by date desc ",false,1);	
				if(!empty($indxx_value))
				{
					$final_array [$indxx ['indxx_id']]['index_value']=$indxx_value;
					$datevalue=$indxx_value['date'];
				}
				else
				{
					$this->log_error("datevalue not defined, next MYSQL query will fail");
					$this->mail_exit(__FILE__, __LINE__);
				}

				$query = "Select it.id, it.name, it.isin, it.ticker, it.curr, it.divcurr, it.sedol, it.cusip, it.countryname, 
					fp.price as calcprice, fp.localprice, fp.currencyfactor, sh.share as calcshare from
					tbl_indxx_ticker_temp it left join tbl_final_price_temp fp on fp.isin=it.isin
					left join tbl_share_temp sh on sh.isin=it.isin where
					fp.date='" .$datevalue. "' and fp.indxx_id='" .$indxx ['indxx_id'].
					" and sh.indxx_id='" .$indxx ['indxx_id']. "and it.indxx_id='" . $indxx ['indxx_id'];				
				$indxxprices=	$this->db->getResult($query,true);
			
				$final_array [$indxx ['indxx_id']]['olddata']=$indxxprices;
	
				$oldsecurity=	$this->db->getResult("select security_id from tbl_replace_tempsecurity where req_id='".$indxx['id']."' and  indxx_id='".$indxx['indxx_id']."' ",true);
				$final_array [$indxx ['indxx_id']]['replacesecurity']=$oldsecurity;

				$newsecurities=	$this->db->getResult("select name, 	isin,ticker,curr,divcurr,sedol,cusip,countryname from tbl_tempsecurities_replaced where req_id='".$indxx['id']."' and  indxx_id='".$indxx['indxx_id']."' ",true);	
				if(!empty($newsecurities))
				{
					foreach ($newsecurities as $key=>$security)
					{
						$prices=$this->getSecurtyPrices($security['isin'],$security['curr'],$indxx_data['curr'],$datevalue);
						$newsecurities[$key]['calcprice']=$prices['calcprice'];
						$newsecurities[$key]['localprice']=$prices['localprice'];
						$newsecurities[$key]['currencyfactor']=$prices['currencyfactor'];
					}
				}
	
				$final_array [$indxx ['indxx_id']]['newsecurity']=$newsecurities;
			}
		}
	
		if (!empty($final_array))
		{
			foreach($final_array as $id=> $indxx_array)
			{			
				$countnewSeurities= count($indxx_array['newsecurity']);		
				
				if($countnewSeurities)
				{
					if(!empty($indxx_array['replacesecurity']))
					{
						$tempmarketcap=0;
						$TempWeight=0;
			
						foreach($indxx_array['replacesecurity'] as $replaceSecurity)
						{
							foreach($indxx_array['olddata'] as  $oldsecuritykey=>$oldsecurity)
							{
								if($oldsecurity['id']==$replaceSecurity['security_id'])
								{
									$tempmarketcap+=$oldsecurity['calcshare']*$oldsecurity['calcprice'];
								
									$deleteSecurityQuery='Delete from tbl_indxx_ticker_temp where id="'.$oldsecurity['id'].'"'; 
									$this->db->query($deleteSecurityQuery);	
								
									$deletepriceQuery='Delete from tbl_final_price_temp where indxx_id="'.$id.'" and  isin ="'.$oldsecurity['isin'].'" and date ="'.$indxx_array['index_value']['date'].'" '; 
									$this->db->query($deletepriceQuery);	
								
									$deleteshareQuery='Delete from tbl_share_temp where indxx_id="'.$id.'" and  isin ="'.$oldsecurity['isin'].'" '; 								
									$this->db->query($deleteshareQuery);	
									unset($final_array[$id]['olddata'][$oldsecuritykey]);						
								}
							}
						}

						if($tempmarketcap)
							$TempWeight=$tempmarketcap/$countnewSeurities;
	
						if(!empty($indxx_array['newsecurity']))
						{
							foreach($indxx_array['newsecurity'] as $newsecuritykey=> $newsecurity)
							{
								$share=$TempWeight/$newsecurity['calcprice'];
								$final_array[$id]['newsecurity'][$newsecuritykey]['calcshare']=$share;
								$newsecurity['calcshare']=$share;
								
								$final_array[$id]['olddata'][]=$newsecurity;
								
								$insertTicker='Insert into tbl_indxx_ticker_temp set name="'.$newsecurity['name'].'", isin="'.$newsecurity['isin'].'", ticker="'.$newsecurity['ticker'].'", curr="'.$newsecurity['curr'].'", divcurr="'.$newsecurity['divcurr'].'",countryname="'.$newsecurity['countryname'].'",cusip="'.$newsecurity['cusip'].'",sedol="'.$newsecurity['sedol'].'",indxx_id="'.$id.'", status="1",weight="0"'; 
								$this->db->query($insertTicker);	
		
								$insertPrice='Insert into tbl_final_price_temp set date="'.$indxx_array['index_value']['date'].'", isin="'.$newsecurity['isin'].'", localprice="'.$newsecurity['localprice'].'", price="'.$newsecurity['calcprice'].'", currencyfactor="'.$newsecurity['currencyfactor'].'",indxx_id="'.$id.'"'; 	
								$this->db->query($insertPrice);
		
								$insertshare='Insert into tbl_share_temp set date="'.$indxx_array['index_value']['date'].'", isin="'.$newsecurity['isin'].'", share="'.$newsecurity['calcshare'].'",indxx_id="'.$id.'"'; 
								$this->db->query($insertshare);	
							}
						}
					}
				}
			}
		}
	
		$this->log_info(log_file, "CA [replace upcoming index] process finished");
		
		//$this->saveProcess ( 1 );
		$this->Redirect("index.php?module=calcdelist&DEBUG=" .DEBUG. "&date=" .$datevalue2. "&log_file=" . basename(log_file), "", "" );
	}
}?>