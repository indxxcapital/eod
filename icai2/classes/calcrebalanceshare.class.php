<?php

class Calcrebalanceshare extends Application{

	function __construct()
	{
		parent::__construct();
	}
	
	
	function index()
	{
	$date= $this->_date;
	
			$indxxs=$this->db->getResult("select tbl_indxx_temp.* from tbl_indxx_temp  where calcdate='".$date."' and status='1' and usersignoff='1' and dbusersignoff='1' and submitted='1' ",true);	
	//$this->pr($indxxs);	
		
		$final_array=array();
		
		if(!empty($indxxs))
		{
			foreach($indxxs as $row)
			{
				$final_array[$row['id']]=$row;
				$liveindexid=$this->db->getResult("select tbl_indxx.id from tbl_indxx where code='".$row['code']."' ",true);
				//echo "select tbl_indxx_value.* from tbl_indxx_value where indxx_id='".$liveindexid['0']['id']."' order by date desc ";
				
				$indxx_value=$this->db->getResult("select tbl_indxx_value.* from tbl_indxx_value where indxx_id='".$liveindexid['0']['id']."' order by date desc ",false,1);	
				//$this->pr($indxx_value);	
				$final_array[$row['id']]['index_value']=$indxx_value['indxx_value'];
				$final_array[$row['id']]['market_value']=$indxx_value['market_value'];
				$datevalue=$indxx_value['date'];
				
				
					$query="SELECT  it.name,it.isin,it.ticker,weight,(select price from tbl_final_price_temp fp where fp.isin=it.isin  and fp.date='".$datevalue."' and fp.indxx_id='".$row['id']."') as calcprice FROM `tbl_indxx_ticker_temp` it where it.indxx_id='".$row['id']."'";	
				$indxxprices=	$this->db->getResult($query,true);
				$final_array[$row['id']]['values']=$indxxprices;
					
			}
		}
		//$this->pr($final_array);
		
		if(!empty($final_array))
		{
			foreach($final_array as $finalrow)
			{
				$marketvalue=$finalrow['market_value'];
				$share=array();
				$checkshare=$this->db->getResult("select tbl_share_temp.* from tbl_share_temp where indxx_id='".$finalrow['id']."'",true);
				if(!empty($checkshare))
				{
					//$this->pr($checkshare);
					$this->db->query("delete from tbl_share_temp where indxx_id='".$finalrow['id']."'");
					
				
				}
				if(!empty($finalrow['values']))
				{
					foreach($finalrow['values'] as $data)
					{
						$share[$data['isin']]=($marketvalue*$data['weight'])/$data['calcprice'];	
					}	
				}
				
			//$this->pr($finalrow);
				$i=0;
				if(!empty($share))
				{
					
					foreach($share as $isin=>$sharevalue)
					{
						$i++;
						$this->db->query("insert into tbl_share_temp set indxx_id='".$finalrow['id']."', isin='".$isin."', share='".$sharevalue."', date='".$finalrow['calcdate']."'");	
					}
					if($i>0)
					{
						$this->db->query("update tbl_indxx_temp set runindex='1' where id='".$finalrow['id']."'");		
					}	
				}
			}
			
		}
		
		$this->Redirect("index.php?module=calcindxxopening","","");
		
	}
}?>