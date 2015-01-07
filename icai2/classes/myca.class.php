<?php 

class Myca extends Application{
		
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
		function array_diff_assoc_recursive($array1, $array2) {
    $difference=array();
    foreach($array1 as $key => $value) {
        if( is_array($value) ) {
            if( !isset($array2[$key]) || !is_array($array2[$key]) ) {
                $difference[$key] = $value;
            } else {
                $new_diff = $this->array_diff_assoc_recursive($value, $array2[$key]);
                if( !empty($new_diff) )
                    $difference[$key] = $new_diff;
            }
        } else if( !array_key_exists($key,$array2) || $array2[$key] !== $value ) {
            $difference[$key] = $value;
        }
    }
    return $difference;
}
		function index()
		{
			$id=$_SESSION['User']['id'];
$type=$_SESSION['User']['type'];
//$users=
if(date('D')!="Mon")
{
$date=date("Y-m-d",strtotime($this->_date)-86400);
}else{
$date=date("Y-m-d",strtotime($this->_date)-(86400*3));

}

	if($type=='2')
	$indxx=	$this->db->getResult("select distinct(indxx_id) as indxx from tbl_assign_index where user_id = '".$id."'",	true);
	else
	$indxx=	$this->db->getResult("select distinct(indxx_id) as indxx from tbl_assign_index",	true);
	//$this->pr($indxx,true);
		$array=array();
		
		if(!empty($indxx))
		{
		foreach($indxx as $ind)
		{
	//	$this->pr($ind);
		$indxxticker=	$this->db->getResult("select distinct(ticker) as indxxticker from tbl_indxx_ticker where indxx_id ='".$ind['indxx']."'",	true);
		
		if(!empty($indxxticker))
		{
		foreach($indxxticker as $ticker)
		{
		$array[]=$ticker['indxxticker'];
		}
		}
		
			//	$this->pr($indxxticker);
		}
		}
		
		if(!empty($array))
		{$array=array_unique($array);
		$ca_array=array();
		{
		foreach ($array as $identifier)
		{
			//echo "select id,identifier,mnemonic,company_name,ann_date,eff_date,action_id,(if(action_id in (select ca_action_id from tbl_ca_admin_notified where ca_id=cat.id),1,0)) as notifiedtoadmin ,(if(action_id in (select ca_action_id from tbl_ca_client_notified where ca_id=cat.id),1,0)) as notifiedtoclient,status,(if(action_id in (select ca_action_id from tbl_ca_admin_approve where ca_id=cat.id),1,0)) as approved from tbl_ca cat where identifier ='".$identifier."' and eff_date>='".$this->_date."'";
			
			//echo "<br>";
			//echo "select id,action_id,identifier,mnemonic,company_name,ann_date,eff_date,action_id,status,(if(action_id in (select ca_action_id from tbl_ca_admin_approve where ca_action_id=cat.action_id),1,0)) as approved from tbl_ca cat where identifier ='".$identifier."' and eff_date>='".$date."'";
			//echo "<br>";
		$ca=	$this->db->getResult("select id,action_id,identifier,mnemonic,company_name,ann_date,eff_date,action_id,status,(if(action_id in (select ca_action_id from tbl_ca_admin_approve where ca_action_id=cat.action_id),1,0)) as approved from tbl_ca cat where identifier ='".$identifier."' and eff_date>='".$date."'",true);
		
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
		//$this->pr($ca_array,true);	
		if(!empty($ca_array))
		{foreach($ca_array as $key=>$value)
		{
		
		///$this->pr($value,true);
		
		$currentvalues=$this->db->getResult("select tbl_ca_values.field_value,tbl_ca_values.field_name from  tbl_ca_values  where tbl_ca_values.ca_action_id='".$value['action_id']."'",true);
		//$this->pr($currentvalues,true);
		
		
		$uservalues=$this->db->getResult("select tbl_ca_values_user.field_value,tbl_ca_values_user.field_name from  tbl_ca_values_user  where tbl_ca_values_user.ca_action_id='".$value['action_id']."'",true);
//$uservalues=array(1=>array("a"=>1));



//$this->pr($uservalues);
if(!empty($currentvalues) && !empty($uservalues))
	{
		$res=	$this->array_diff_assoc_recursive($currentvalues,$uservalues);
		//print_r($res);
		
		if(!empty($res))
		{$ca_array[$key]['valuechange']="yes";	
		}
	}
		
			$dividendvalue=$this->db->getResult("select tbl_ca_values.field_value,ca_id from  tbl_ca_values  where tbl_ca_values.ca_id='".$value['id']."' and field_name='CP_DVD_TYP' and field_value!='1000'",true);
			
			if(!empty($dividendvalue['0']['field_value']))
			$ca_array[$key]['notregularcash']=	$dividendvalue['0']['field_value'];	
		
		
		
		
		
		}}
		//exit;
		//$this->pr($ca_array,true);	
			
		$this->_baseTemplate="inner-template";
	$this->_bodyTemplate="myca/index";
		$this->_title=$this->siteconfig->site_title;
		$this->_meta_description=$this->siteconfig->default_meta_description;
		$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
		
		
				$this->smarty->assign("ca_array",$ca_array);
				 $this->show();
	
		
		
		}
		
		
		function upcomming()
		{
			$id=$_SESSION['User']['id'];
$type=$_SESSION['User']['type'];
//$users=
if(date('D')!="Mon")
{
$date=date("Y-m-d",strtotime($this->_date)-86400);
}else{
$date=date("Y-m-d",strtotime($this->_date)-(86400*3));

}

	if($type=='2')
	$indxx=	$this->db->getResult("select distinct(indxx_id) as indxx from tbl_assign_index_temp where user_id = '".$id."'",	true);
	else
	$indxx=	$this->db->getResult("select distinct(indxx_id) as indxx from tbl_assign_index_temp",	true);
	//$this->pr($indxx,true);
		$array=array();
		
		if(!empty($indxx))
		{
		foreach($indxx as $ind)
		{
	//	$this->pr($ind);
		$indxxticker=	$this->db->getResult("select distinct(ticker) as indxxticker from tbl_indxx_ticker_temp where indxx_id ='".$ind['indxx']."'",	true);
		
		if(!empty($indxxticker))
		{
		foreach($indxxticker as $ticker)
		{
		$array[]=$ticker['indxxticker'];
		}
		}
		
			//	$this->pr($indxxticker);
		}
		}
		
		if(!empty($array))
		{$array=array_unique($array);
		$ca_array=array();
		{
		foreach ($array as $identifier)
		{
			//echo "select id,identifier,mnemonic,company_name,ann_date,eff_date,action_id,(if(action_id in (select ca_action_id from tbl_ca_admin_notified where ca_id=cat.id),1,0)) as notifiedtoadmin ,(if(action_id in (select ca_action_id from tbl_ca_client_notified where ca_id=cat.id),1,0)) as notifiedtoclient,status,(if(action_id in (select ca_action_id from tbl_ca_admin_approve where ca_id=cat.id),1,0)) as approved from tbl_ca cat where identifier ='".$identifier."' and eff_date>='".$this->_date."'";
			
			//echo "<br>";
			//echo "select id,action_id,identifier,mnemonic,company_name,ann_date,eff_date,action_id,status,(if(action_id in (select ca_action_id from tbl_ca_admin_approve where ca_action_id=cat.action_id),1,0)) as approved from tbl_ca cat where identifier ='".$identifier."' and eff_date>='".$date."'";
			//echo "<br>";
		$ca=	$this->db->getResult("select id,action_id,identifier,mnemonic,company_name,ann_date,eff_date,action_id,status,(if(action_id in (select ca_action_id from tbl_ca_admin_approve_temp where ca_action_id=cat.action_id),1,0)) as approved from tbl_ca cat where identifier ='".$identifier."' and eff_date>='".$date."'",true);
		
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
		//$this->pr($ca_array,true);	
		
		if(!empty($ca_array)){
		foreach($ca_array as $key=>$value)
		{
		
		///$this->pr($value,true);
		
		$currentvalues=$this->db->getResult("select tbl_ca_values.field_value,tbl_ca_values.field_name from  tbl_ca_values  where tbl_ca_values.ca_action_id='".$value['action_id']."'",true);
		//$this->pr($currentvalues,true);
		
		
		$uservalues=$this->db->getResult("select tbl_ca_values_user.field_value,tbl_ca_values_user.field_name from  tbl_ca_values_user  where tbl_ca_values_user.ca_action_id='".$value['action_id']."'",true);
//$uservalues=array(1=>array("a"=>1));



//$this->pr($uservalues);
if(!empty($currentvalues) && !empty($uservalues))
	{
		$res=	$this->array_diff_assoc_recursive($currentvalues,$uservalues);
		//print_r($res);
		
		if(!empty($res))
		{$ca_array[$key]['valuechange']="yes";	
		}
	}
		
			$dividendvalue=$this->db->getResult("select tbl_ca_values.field_value,ca_id from  tbl_ca_values  where tbl_ca_values.ca_id='".$value['id']."' and field_name='CP_DVD_TYP' and field_value!='1000'",true);
			
			if(!empty($dividendvalue['0']['field_value']))
			$ca_array[$key]['notregularcash']=	$dividendvalue['0']['field_value'];	
		
		
		
		
		
		}}
		//exit;
		//$this->pr($ca_array,true);	
			
		$this->_baseTemplate="inner-template";
	$this->_bodyTemplate="myca/index";
		$this->_title=$this->siteconfig->site_title;
		$this->_meta_description=$this->siteconfig->default_meta_description;
		$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
		
		
				$this->smarty->assign("ca_array",$ca_array);
				 $this->show();
	
		
		
		}
		
		function view(){
			$this->_baseTemplate="inner-template";
	$this->_bodyTemplate="myca/view";
		$this->_title=$this->siteconfig->site_title;
		$this->_meta_description=$this->siteconfig->default_meta_description;
		$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
//	$this->addfield();

		$this->smarty->assign('pagetitle','Corporate Actions');
		$this->smarty->assign('bredcrumssubtitle','View Corporate Actions');


$this->db->query("update tbl_ca set status='1' where id='".$_GET['id']."' ");
//echo "select tbl_ca.* from tbl_ca where id = '".$_GET['id']."' ";
		$cadata=$this->db->getResult("select tbl_ca.* from tbl_ca where id = '".$_GET['id']."' ",true);
		//$this->pr($cadata,true);
		$this->smarty->assign("viewdata",$cadata);
		
		$indexdata2=$this->db->getResult("select tbl_ca_values.* from tbl_ca_values where ca_id = '".$_GET['id']."' ",true);
		$this->smarty->assign("viewdata2",$indexdata2);
		//echo "select tbl_ca_values_user.* from tbl_ca_values_user where ca_action_id = '".$cadata[0]['ca_action_id']."' ";
		$indexdata3=$this->db->getResult("select tbl_ca_values_user.* from tbl_ca_values_user where ca_action_id = '".$cadata[0]['action_id']."' ",true);
		
		if(!empty($indexdata2) && !empty($indexdata3))
	{
		$res=	$this->array_diff_assoc_recursive($indexdata2,$indexdata3);
		//print_r($res);
		
		if(!empty($res))
		{
				$this->smarty->assign("viewdata3",$indexdata3);
				$this->smarty->assign("diffkey",$res);
	
	//$this->pr($indexdata3,true);
	
			//$ca_array[$key]['valuechange']="yes";	
		}
	}
		
		
		
		
//$this->pr($cadata,true);
$ticker=$cadata[0]['identifier'];
$tickerdata=$this->db->getResult("select tbl_indxx_ticker.indxx_id from tbl_indxx_ticker where ticker = '".$ticker."' ",true);
//$this->pr($tickerdata,true);	
	if(!empty($tickerdata))
	$indxes=array();
	if(!empty($tickerdata))
	{
	foreach($tickerdata as $data)
	{
	$indxes[]=$data['indxx_id'];
	}
	}
	$ids='';
	if(!empty($indxes))
	$ids=implode(',',$indxes);
	
//	echo "select tbl_indxx.name,tbl_indxx.code from tbl_indxx where id in (".$ids.")";
	
		//	echo "select tbl_indxx.name,tbl_indxx.code from tbl_indxx where id = '".$ticker['indxx_id']."' ";
	$indxxd=array();
	if($ids)
	$indxxd=$this->db->getResult("select tbl_indxx.name,tbl_indxx.code from tbl_indxx where id in (".$ids.")",true);
//$this->pr(	$indxxd);
$tickerdata2=$this->db->getResult("select tbl_indxx_ticker_temp.indxx_id from tbl_indxx_ticker_temp where ticker = '".$ticker."' ",true);
//$this->pr($tickerdata,true);	
	
	$indxes2=array();
	if(!empty($tickerdata2))
	{
	foreach($tickerdata2 as $data)
	{
	$indxes2[]=$data['indxx_id'];
	}
	}
	$idst='';
	if(!empty($indxes2))
	$idst=implode(',',$indxes2);
	
//	echo "select tbl_indxx.name,tbl_indxx.code from tbl_indxx where id in (".$ids.")";
	
		//	echo "select tbl_indxx.name,tbl_indxx.code from tbl_indxx where id = '".$ticker['indxx_id']."' ";
		$indxxt=array();
	if($idst)
	$indxxt=$this->db->getResult("select tbl_indxx_temp.name,tbl_indxx_temp.code from tbl_indxx_temp where id in (".$idst.")",true);
		
	$clients=array();
	
	//echo"select id from tbl_ca_admin_approve where ca_id= '".$cadata[0]['id']."' and  ca_action_id= '".$cadata[0]['action_id']."'";
	//exit;
	
$adminApproveLive=$this->db->getResult("select id from tbl_ca_admin_approve where  ca_action_id= '".$cadata[0]['action_id']."'",false);
//echo count($adminApproveLive);

if(count($adminApproveLive)>0)
{
$this->smarty->assign("approveLive",0);
}else{
$this->smarty->assign("approveLive",1);
}		
$adminApproveTemp=$this->db->getResult("select id from tbl_ca_admin_approve_temp where  ca_action_id= '".$cadata[0]['action_id']."'",false);
if(count($adminApproveTemp)>0)
{
$this->smarty->assign("approveTemp",0);
}else{
$this->smarty->assign("approveTemp",1);
}
	
//$this->pr( $indxxt,true);
	
		//	echo "select tbl_indxx.name,tbl_indxx.code from tbl_indxx where id = '".$ticker['indxx_id']."' ";
//	$clientdata=$this->db->getResult("select distinct(tbl_client_index.user_id) as clientid from tbl_client_index  where indxx_id in (".$ids.")",true);
	
		
//$this->pr($clientdata,true);
$this->smarty->assign("indxxd",$indxxd);
$this->smarty->assign("indxxt",$indxxt);

	//$this->pr($indxxd,true);
	
		//$this->pr($_SESSION);
		 $this->show();
		}
		
	
	
	function notifyadmin()
	{
		$cadata=$this->db->getResult("select tbl_ca.* from tbl_ca where id = '".$_GET['id']."' ",true);
		if($cadata[0]['mnemonic']=='DVD_CASH')
		{
			$this->db->query("update tbl_ca set notifiedtoadmin='1' where id='".$_GET['id']."' ");
			$this->db->query("update tbl_ca set notifiedtoclient='1' where id='".$_GET['id']."' ");
			$this->db->query("update tbl_ca set approved='1' where id='".$_GET['id']."' ");	
		}
		//$this->smarty->assign("viewdata",$cadata);
		
		$indexdata2=$this->db->getResult("select tbl_ca_values.* from tbl_ca_values where ca_id = '".$_GET['id']."' ",true);
		//$this->smarty->assign("viewdata2",$indexdata2);	
	//$this->pr($_SESSION,true);	
		$data='<table width="200" border="1">
  <tr>
    <td>Name</td>
    <td>'.$cadata[0]['company_name'].'</td>
  </tr>
  <tr>
     <td>Ticker</td>
    <td>'.$cadata[0]['identifier'].'</td>
  </tr>
  <tr>
     <td>Corporate action</td>
    <td>'.$cadata[0]['mnemonic'].'</td>
  </tr>
  <tr>
     <td>Announce Date</td>
    <td>'.$cadata[0]['ann_date'].'</td>
  </tr>  <tr>
     <td>Effective Date</td>
    <td>'.$cadata[0]['eff_date'].'</td>
  </tr> 
  
  <tr>
     <td>Update Date</td>
    <td>'.$cadata[0]['amd_date'].'</td>
  </tr>';
if(!empty($indexdata2))
{
foreach ($indexdata2 as $ca)
{
	if($_SESSION['variable'][$ca['field_name']])
	$value=$_SESSION['variable'][$ca['field_name']];
	else
	$value=$ca['field_name'];
	
	
$data.='  <tr>
     
    <td>'.$value.'</td>
	<td>'.$ca['field_value'].'</td>
  </tr>';
}
}


 $data.='</table>';
		
		
		$admins =	$this->db->getResult('Select  email from tbl_ca_user where type="1" ',true);

//$this->pr($admins,true);	
	
	$user=array();
	if(!empty($admins))	
	foreach($admins as $admin)
	{
	$user[]=$admin['email'];
	}
		
  $to=implode(',',$user);		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'From: Indexing <indexing@indxx.com>' . "\r\n"."CC: indexing@indxx.com". "\r\n";
$body='Hi <br>';
$body.='New corporate Action  for <b>'.$cadata[0]['company_name'].'</b> has been Notified by '.$_SESSION['User']['name'].' ,'.$data.' <br> 
Thanks ';


		mail($to,"ICAI :New Corporate Action " ,$body,$headers);
		
		$this->db->query("update tbl_ca set notifiedtoadmin='1' where id='".$_GET['id']."' ");
		
		$this->Redirect("index.php?module=myca&event=view&id=".$_GET['id']."","Corporate Action Notified successfully!!!","success");	
		
		
	}
	
	
	
	
	function notifyadminassigned()
	{
	
	$finalArray=array();
		if($_SESSION['User']['type']!='1')
		{
			foreach($_POST as $key=>$val)
		{
			foreach($val as $key2=>$val2)
			{
				if(!empty($val2))
				{
					$cadata=explode("_",$val2);
					$ca_id=$cadata['0'];
					$ca_ticker=$cadata['1'];
					$ca_action_id=$cadata['2'];
					
						$CAentry=$this->getCaStr($ca_ticker,$this->_date, $ca_id);
						
						$checkcashdividend=explode(";",$CAentry);
						if($checkcashdividend['3']=='Cash Dividend')
						{
							$this->db->query("update tbl_ca set notifiedtoadmin='1' where id='".$ca_id."' ");
							$this->db->query("update tbl_ca set notifiedtoclient='1' where id='".$ca_id."' ");
							$this->db->query("update tbl_ca set approved='1' where id='".$ca_id."' ");	
						}
						
						$this->db->query("update tbl_ca set notifiedtoadmin='1' where id='".$ca_id."' ");
						
						$checkca=$this->db->getResult("select id from tbl_ca_admin_notified where ca_action_id = '".$ca_action_id."'",true);
						
						if(empty($checkca))
						{
							$this->db->query("insert into tbl_ca_admin_notified(ca_id,ca_action_id) values ('".$ca_id."','".$ca_action_id."')");	
						}
						
					
					$tickerdetails=$this->db->getResult("select indxx_id from tbl_indxx_ticker where ticker LIKE '".$ca_ticker."%'",true);
					
					//print_r(	$tickerdetails);
					
					if(!empty($tickerdetails))
					{
					foreach($tickerdetails as $indxx_id)
					{
						$indxx=$this->db->getResult("select code from tbl_indxx where id= '".$indxx_id['indxx_id']."'");
					//print_r($indxx_id);
					
					//$finalArray['code']=$indxx['code'];
				//	$finalArray['code']['ticker'][$ca_id]=$ca_ticker;
					$finalArray[$indxx['code']][$ca_ticker]['ca']=$CAentry;
					
					
					
					}
					}
				
				
				
				}}}}
				//print_r($finalArray);
				//$this->pr($finalArray);
				$filenames=array();
							
				foreach($finalArray as $code=>$values)
				{
					//$cavaluesdata.='Index Name'.";";
					//$cavaluesdata.=$ind['name'].";";	
					$cavaluesdata='';
					$cavaluesdata.='Security Ticker'.";";		
					$cavaluesdata.='Company Ticker'.";";	
					$cavaluesdata.='ISIN'.";";
					$cavaluesdata.='Action'.";";
					$cavaluesdata.='Ex Date'.";";		
					$cavaluesdata.='Amount'.";";		
					$cavaluesdata.='Currency;';		
					$cavaluesdata.='Further Details;';		
					$cavaluesdata.='Factor;';
					$cavaluesdata.="\n";	
					
					$file="../files2/ca-output_upcomming/test/CA-".$code."-".$this->_date."-".time().".csv";
					
					foreach($values as $ticker=>$cavalues)
					{
						
						$cavaluesdata.=$cavalues['ca'];
					}
						$open=fopen($file,"w+");
						if($open){   
							if(fwrite($open,$cavaluesdata))
							{
								echo "File written for ".$code."-".$this->_date."-".time()."<br>";
								$filenames[]="CA-".$code."-".$this->_date."-".time().".csv";
							}
						}
		
				}
				
				//print_r($filenames);
				
			$useremails=$this->db->getResult("select email from tbl_ca_user where type='1'",true);	
			
			foreach($useremails as $users)
			{
			$user[]=$users['email'];
			}
			
			    // array with filenames to be sent as attachment
    //$files = array("file1.jpg","file2.pdf","file3.txt");

    // email fields: to, from, subject, and so on
    $to=implode(',',$user);
    $from = "Indexing <indexing@indxx.com>"; 
    $subject ="New Corporate Actions"; 
    $message = 'Hi <br>';
	$message.='New corporate Actions has been notified for admin by '.$_SESSION['User']['name'].'.<br>' ;
	$message.='Thanks ';
    $headers = "From: $from" . "\r\n"."CC: indexing@indxx.com". "\r\n";

    // boundary 
    $semi_rand = md5(time()); 
    $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x"; 

    // headers for attachment 
    $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" .   "
                 boundary=\"{$mime_boundary}\""; 

    // multipart boundary 
    $message = "This is a multi-part message in MIME format.\n\n" . "--{$mime_boundary}\n"
               . "Content-Type: text/html; charset=\"iso-8859-1\"\n" . 
                 "Content-Transfer-Encoding: 7bit\n\n" . $message . "\n\n"; 
    $message .= "--{$mime_boundary}\n";

    // preparing attachments
	$filecount=count($filenames);
    for($x=0;$x<count($filenames);$x++){
            $file = fopen('../files2/ca-output_upcomming/test/'.$filenames[$x],"rb");
            $data = fread($file,filesize('../files2/ca-output_upcomming/test/'.$filenames[$x]));
            fclose($file);
            $data = chunk_split(base64_encode($data));
			
			
            $message .= "Content-Type: {\"application/octet-stream\"};\n" .  

                        " name=\"$filenames[$x]\"\n" . 
            "Content-Disposition: attachment;\n" . " filename=\"$filenames[$x]\"\n" . 
            "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
			
			if($x<($filecount-1))
            $message .= "--{$mime_boundary}\n";
			else
			$message .= "--{$mime_boundary}--\n";
			
			
			
    }

    // send

   $success = @mail($to, $subject, $message, $headers); 
    if ($success) { 
            echo "<p>mail sent to $to!</p>"; 
    } else { 
            echo "<p>mail could not be sent!</p>"; 
  } 
			
			

			//mail($to,"ICAI : Corporate Action File Generated",$body,$headers);

			$this->Redirect("index.php?module=myca","Corporate Actions Notified successfully!!!","success");	
	
	
	}
	
	
	
	
	function notifyclient()
	{
		$cadata=$this->db->getResult("select tbl_ca.* from tbl_ca where id = '".$_GET['id']."' ",true);
		
		$indexdata2=$this->db->getResult("select tbl_ca_values.* from tbl_ca_values where ca_id = '".$_GET['id']."' ",true);
		
$ticker=$cadata[0]['identifier'];
$tickerdata=$this->db->getResult("select tbl_indxx_ticker.indxx_id from tbl_indxx_ticker where ticker = '".$ticker."' ",true);
//$this->pr($tickerdata,true);	
	
	$indxes=array();
	if(!empty($tickerdata))
	{
	foreach($tickerdata as $data)
	{
	$indxes[]=$data['indxx_id'];
	}
	}
	
	 $ids=implode(',',$indxes);
	 
	 
	 //echo "select tbl_indxx.name,tbl_indxx.code from tbl_indxx where id in (".$ids.")";
	$indxxd=$this->db->getResult("select tbl_indxx.name,tbl_indxx.code from tbl_indxx where id in (".$ids.")",true);
//echo "select distinct(tbl_client_index.user_id) as clientid from tbl_client_index  where indxx_id in (".$ids.")";

	$clientdata=$this->db->getResult("select distinct(tbl_client_index.user_id) as clientid from tbl_client_index  where indxx_id in (".$ids.")",true);
	
//$this->pr($clientdata,true);
		$data='<table width="200" border="1">
  <tr>
    <td>Name</td>
    <td>'.$cadata[0]['company_name'].'</td>
  </tr>
  <tr>
     <td>Ticker</td>
    <td>'.$cadata[0]['identifier'].'</td>
  </tr>
  <tr>
     <td>Corporate action</td>
    <td>'.$cadata[0]['mnemonic'].'</td>
  </tr>
  <tr>
     <td>Announce Date</td>
    <td>'.$cadata[0]['ann_date'].'</td>
  </tr>  <tr>
     <td>Effective Date</td>
    <td>'.$cadata[0]['eff_date'].'</td>
  </tr> 
  
  <tr>
     <td>Update Date</td>
    <td>'.$cadata[0]['amd_date'].'</td>
  </tr>';
  
 if(!empty($indexdata2))
{
foreach ($indexdata2 as $ca)
{
	if($_SESSION['variable'][$ca['field_name']])
	$value=$_SESSION['variable'][$ca['field_name']];
	else
	$value=$ca['field_name'];
	
	
$data.='  <tr>
     
    <td>'.$value.'</td>
	<td>'.$ca['field_value'].'</td>
  </tr>';
}
}


 $data.='</table>';
 
 
  
  $clients=array();
  
	if(!empty($clientdata))
	{
	foreach($clientdata as $clientsdata)
	{
	$clients[]=$clientsdata['clientid'];
	}
	}
	
	$clientids=implode(',',$clients);
	
	
	//$this->pr($clients);
	
	
	

	
	$clientemails=$this->db->getResult("select email from tbl_ca_client where id in (".$clientids.")",true);
	
	
	$clientemail=array();
	if(!empty($clientemails))	
	foreach($clientemails as $client)
	{
	$clientemail[]=$client['email'];
	}
		
  $to=implode(',',$clientemail);
  		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'From: Indexing <indexing@indxx.com>' . "\r\n"."CC: indexing@indxx.com". "\r\n";
$body='Hi <br>';
$body.='New corporate Action  for <b>'.$cadata[0]['company_name'].'</b> has been Notified by '.$_SESSION['User']['name'].' ,'.$data.' <br> 
Thanks ';


		mail($to,"ICAI :New Corporate Action " ,$body,$headers);
		
		$this->db->query("update tbl_ca set notifiedtoclient='1' where id='".$_GET['id']."' ");
		
		//echo "insert into tbl_ca_client_notified(ca_id,ca_action_id,user_id) values ('".$_GET['id']."','".$cadata[0]['action_id']."','".$_SESSION['User']['id']."')";
		//exit;
			
		$this->db->query("insert into tbl_ca_client_notified(ca_id,ca_action_id,client_id) values ('".$_GET['id']."','".$cadata[0]['action_id']."','".$_SESSION['User']['id']."')");
		$this->Redirect("index.php?module=myca","Corporate Action Notified successfully!!!","success");
	
	
	
	}
	
	
	function notifyclientassigned()
	{
		
		$finalArray=array();
		$finalClientArray=array();
		$clientfilenames=array();
			foreach($_POST as $key=>$val)
		{
			foreach($val as $key2=>$val2)
			{
				if(!empty($val2))
				{
					$userids=array();	
					$cadata=explode("_",$val2);
					$ca_id=$cadata['0'];
					$ca_ticker=$cadata['1'];
					$ca_action_id=$cadata['2'];
					
							
					$this->db->query("update tbl_ca set notifiedtoclient='1' where id='".$ca_id."' ");
					
					$CAentry=$this->getCaStr($ca_ticker,$this->_date, $ca_id);
					
					
					$tickerdetails=$this->db->getResult("select indxx_id from tbl_indxx_ticker where ticker LIKE '".$ca_ticker."%'",true);
					
					//print_r(	$tickerdetails);
					
					if(!empty($tickerdetails))
					{
					foreach($tickerdetails as $indxx_id)
					{
						$indxx=$this->db->getResult("select code from tbl_indxx where id= '".$indxx_id['indxx_id']."'");
					//print_r($indxx_id);
					
					//$finalArray['code']=$indxx['code'];
				//	$finalArray['code']['ticker'][$ca_id]=$ca_ticker;
					$finalArray[$indxx['code']][$ca_ticker]['ca']=$CAentry;
					
					
					$clientsdata=$this->db->getResult("select client_id as clientid from tbl_indxx where id = '".$indxx_id['indxx_id']."'",true);
					
					
					if(empty($clientsdata))
					{
						$finalClientArray[''][''][$indxx['code']][]=$CAentry;	
					}
					else
					{
							
							foreach($clientsdata as $keyclient=>$valueclient)
							{
								
								$checkca=$this->db->getResult("select client_id from tbl_ca_client_notified where ca_action_id = '".$ca_action_id."'",true);
						
								if(empty($checkca))
								{
									$this->db->query("insert into tbl_ca_client_notified(ca_id,ca_action_id,client_id) values ('".$ca_id."','".$ca_action_id."','".$valueclient['clientid']."')");	
								}
								
								
								$clientemails=$this->db->getResult("select email from tbl_ca_client where id = '".$valueclient['clientid']."'",true);
								//print_r($clientemails);
								//$userids[]=$valueclient['clientid']."-".$valueclient['indxx_id']."-".$clientemails['0']['email'];
						
								$finalClientArray[$valueclient['clientid']][$clientemails['0']['email']][$indxx['code']][]=$CAentry;
								
							}
					}
						
					
					}
					}
				}}}
				
			
				//print_r($finalClientArray);
				//exit;
				
				//$this->pr($finalArray);
				
				foreach($finalClientArray as $clientid=>$values)
				{
					
					foreach($values as $clientemail=>$cavaluesarray)
					{
						
						foreach($cavaluesarray as $indxxcode=>$caindxxvalues)
						{
							
							$cavaluesdata='';
							//$cavaluesdata.='Index Name'.";";
							//$cavaluesdata.=$ind['name'].";";		
							//$cavaluesdata.="\n";		
							$cavaluesdata.='Security Ticker'.";";		
							$cavaluesdata.='Company Ticker'.";";	
							$cavaluesdata.='ISIN'.";";
							$cavaluesdata.='Action'.";";
							$cavaluesdata.='Ex Date'.";";		
							$cavaluesdata.='Amount'.";";		
							$cavaluesdata.='Currency;';		
							$cavaluesdata.='Further Details;';		
							$cavaluesdata.='Factor;';
							$cavaluesdata.="\n";
							if(empty($clientemail))
							{
								$cavaluesdata='';
								//$cavaluesdata.='Index Name'.";";
								//$cavaluesdata.=$ind['name'].";";		
								//$cavaluesdata.="\n";		
								$cavaluesdata.='Security Ticker'.";";		
								$cavaluesdata.='Company Ticker'.";";	
								$cavaluesdata.='ISIN'.";";
								$cavaluesdata.='Action'.";";
								$cavaluesdata.='Ex Date'.";";		
								$cavaluesdata.='Amount'.";";		
								$cavaluesdata.='Currency;';		
								$cavaluesdata.='Further Details;';		
								$cavaluesdata.='Factor;';
								$cavaluesdata.="\n";	
							}
							foreach($caindxxvalues as $keycaindex=>$cavalues)
							{
								$cavaluesdata.=$cavalues;
							}
							
							$file="../files2/ca-output_upcomming/test/CA-".$indxxcode."-".$this->_date."-".time().".csv";
							$open=fopen($file,"w+");
							if($open)
							{   
								if(fwrite($open,$cavaluesdata))
								{
									echo "File written for ".$indxxcode."-".$this->_date."-".time()."<br>";
									$clientfilenames[$clientemail][$indxxcode]="CA-".$indxxcode."-".$this->_date."-".time().".csv";
									$filenames[]="CA-".$indxxcode."-".$this->_date."-".time().".csv";
								}
							}
						}
					}
						
		
				}
				
				
				foreach($clientfilenames as $clientemailid=>$clientindexcode)
				{
					 	
					//$to=implode(',',$user);
					$from = "Indexing <indexing@indxx.com>"; 
					$subject ="New Corporate Actions"; 
					$message='Hi <br>';
					$message.='New corporate actions has been notified.' ;	
					$message.='Thanks ';
					
					$headers = "From: $from" . "\r\n"."CC: indexing@indxx.com". "\r\n";
				
					// boundary 
					$semi_rand = md5(time()); 
					$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x"; 
				
					// headers for attachment 
					$headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" .   "
								 boundary=\"{$mime_boundary}\""; 
				
					// multipart boundary 
					$message = "This is a multi-part message in MIME format.\n\n" . "--{$mime_boundary}\n"
							   . "Content-Type: text/html; charset=\"iso-8859-1\"\n" . 
								 "Content-Transfer-Encoding: 7bit\n\n" . $message . "\n\n"; 
					$message .= "--{$mime_boundary}\n";
				
					// preparing attachments
					$x=0;
					foreach($clientindexcode as $indexcode=>$clientfiles)
					{
							$filecount=count($clientindexcode);							
							$file = fopen('../files2/ca-output_upcomming/test/'.$clientfiles,"rb");
							$data = fread($file,filesize('../files2/ca-output_upcomming/test/'.$clientfiles));
							fclose($file);
							$data = chunk_split(base64_encode($data));
							
							
							$message .= "Content-Type: {\"application/octet-stream\"};\n" .  
				
										" name=\"$clientfiles\"\n" . 
							"Content-Disposition: attachment;\n" . " filename=\"$clientfiles\"\n" . 
							"Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
							
							if($x<($filecount-1))
							$message .= "--{$mime_boundary}\n";
							else
							$message .= "--{$mime_boundary}--\n";
							
							$x++;
							
					}
				
					// send
				
				   $success = @mail($clientemailid, $subject, $message, $headers); 
				   if ($success) { 
						 echo "<p>mail sent to $clientemailid!</p>"; 
				   } else { 
						   echo "<p>mail could not be sent!</p>"; 
				    } 
									
								}
				
				$this->Redirect("index.php?module=myca","Corporate Actions Notified successfully!!!","success");	

	}
	
	
	function approve()
	{
		$this->_baseTemplate="inner-template";
			$this->_bodyTemplate="myca/approve";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','Corporate Actions');
		$this->smarty->assign('bredcrumssubtitle','Approved Corporate Actions');
		
	$indxx=$this->db->getResult("select * from tbl_ca  where tbl_ca.id='".$_GET['id']."'");
	
			if($_GET['id'])
		{$this->db->query("insert into tbl_ca_admin_approve(ca_id,ca_action_id,user_id) values ('".$_GET['id']."','".$indxx['action_id']."','".$_SESSION['User']['id']."')");	
		
		$this->db->query("insert into tbl_ca_values_user select * from tbl_ca_values where tbl_ca_values.ca_action_id='".$indxx['action_id']."'");	
		
		//echo $this->siteconfig->base_url."ircmail.php?id=".$indxx['action_id'];
		//exit;
		
		file_get_contents($this->siteconfig->base_url."ircmail.php?id=".$indxx['action_id']);
			$this->Redirect("index.php?module=myca","Corporate Action Approved!","success");
		
		}
		/*	if($_SESSION['User']['type']=='1' && $_GET['id'])
		{
		
		$viewdata=$this->db->getResult("select tbl_ca.company_name from tbl_ca where tbl_ca.id='".$_GET['id']."'",true);
		//$this->pr($viewdata,true);
		$this->smarty->assign("viewapprovedca",$viewdata);
		
		
		$FieldsData=$this->db->getResult('SELECT * FROM tbl_ca_values where ca_id="'.$_GET['id'].'"',true);
	//	$this->pr($sequruityData,true);
		//$this->smarty->assign("approvedindexSecurity",$sequruityData);
		$this->smarty->assign("approvedcaSecurityrows",count($FieldsData));
		
		
		
		$this->db->query("UPDATE tbl_ca set approved='1' where tbl_ca.id='".$_GET['id']."'");
		
				
	//	echo "select * tbl_indxx where tbl_indxx.id='".$_GET['id']."'";
			$indxx=$this->db->getResult("select * from tbl_ca  where tbl_ca.id='".$_GET['id']."'");
	//	$this->pr($indxx,true);
		
		$indxxadmins =	$this->db->getResult('Select  user_id from tbl_assign_index where indxx_id="'.$_GET['id'].'" union Select  user_id from tbl_assign_index_temp where indxx_id="'.$_GET['id'].'" ',true);
$indxxadmin='';
//print_r($indxxadmins );
$emailto=array();

if(!empty($indxxadmins))
{
foreach($indxxadmins as $array)
{
	$emailto[]=$array['user_id'];
}


}

//print_r($emailto);

	//exit;
	if(!empty($emailto))
	{	
//	echo  'Select  email from tbl_ca_user where type="1" or id in ('.implode(',',$emailto).') ';
	$admins =	$this->db->getResult('Select  email from tbl_ca_user where type="1" or id in ('.implode(',',$emailto).') ',true);
	}
else
{	$admins =	$this->db->getResult('Select  email from tbl_ca_user where 1=1 ',true);
}
//$this->pr($admins,true);	
	
	$user=array();
	if(!empty($admins))	
	foreach($admins as $admin)
	{
	$user[]=$admin['email'];
	}
		
  $to=implode(',',$user);		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'From: Indexing <indexing@indxx.com>' . "\r\n"."CC: indexing@indxx.com". "\r\n";
$body='Hi <br>';
$body.='Corporate Action '.$indxx['company_name'].'('.$indxx['mnemonic'].') has been approved by admin , <br> Please  <a href="'.$this->siteconfig->base_url.'index.php?module=myca&event=view&id='.$_GET['id'].'">Click here </a> to check it.<br>Thanks ';


		mail($to,"ICAI : Corporate Action Approved " ,$body,$headers);
		
		
		
		
		
		
		}
		else
		{
				$this->Redirect("index.php?module=upcomingca","You are not authorized to perofrm this task!","error");
		}*/
		
		 $this->show();	
	}	
	
		
	function approvetemp()
	{
		$this->_baseTemplate="inner-template";
			$this->_bodyTemplate="myca/approve";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','Corporate Actions');
		$this->smarty->assign('bredcrumssubtitle','Approved Corporate Actions');
		
	$indxx=$this->db->getResult("select * from tbl_ca  where tbl_ca.id='".$_GET['id']."'");
	
			if($_GET['id'])
		{
		
			$this->db->query("insert into tbl_ca_admin_approve_temp(ca_id,ca_action_id,user_id) values ('".$_GET['id']."','".$indxx['action_id']."','".$_SESSION['User']['id']."')");	
		
		$this->db->query("insert into tbl_ca_values_user select * from tbl_ca_values where tbl_ca_values.ca_action_id='".$indxx['action_id']."'");	
		
			//echo $this->siteconfig->base_url."ircmail.php?id=".$indxx['action_id'];
			//exit;
			
		
		file_get_contents($this->siteconfig->base_url."ircmail.php?&tbl=temp&id=".$indxx['action_id']);
		
			$this->Redirect("index.php?module=myca&event=upcomming","Corporate Action Approved!","success");
		
		}
		/*	if($_SESSION['User']['type']=='1' && $_GET['id'])
		{
		
		$viewdata=$this->db->getResult("select tbl_ca.company_name from tbl_ca where tbl_ca.id='".$_GET['id']."'",true);
		//$this->pr($viewdata,true);
		$this->smarty->assign("viewapprovedca",$viewdata);
		
		
		$FieldsData=$this->db->getResult('SELECT * FROM tbl_ca_values where ca_id="'.$_GET['id'].'"',true);
	//	$this->pr($sequruityData,true);
		//$this->smarty->assign("approvedindexSecurity",$sequruityData);
		$this->smarty->assign("approvedcaSecurityrows",count($FieldsData));
		
		
		
		$this->db->query("UPDATE tbl_ca set approved='1' where tbl_ca.id='".$_GET['id']."'");
		
				
	//	echo "select * tbl_indxx where tbl_indxx.id='".$_GET['id']."'";
			$indxx=$this->db->getResult("select * from tbl_ca  where tbl_ca.id='".$_GET['id']."'");
	//	$this->pr($indxx,true);
		
		$indxxadmins =	$this->db->getResult('Select  user_id from tbl_assign_index where indxx_id="'.$_GET['id'].'" union Select  user_id from tbl_assign_index_temp where indxx_id="'.$_GET['id'].'" ',true);
$indxxadmin='';
//print_r($indxxadmins );
$emailto=array();

if(!empty($indxxadmins))
{
foreach($indxxadmins as $array)
{
	$emailto[]=$array['user_id'];
}


}

//print_r($emailto);

	//exit;
	if(!empty($emailto))
	{	
//	echo  'Select  email from tbl_ca_user where type="1" or id in ('.implode(',',$emailto).') ';
	$admins =	$this->db->getResult('Select  email from tbl_ca_user where type="1" or id in ('.implode(',',$emailto).') ',true);
	}
else
{	$admins =	$this->db->getResult('Select  email from tbl_ca_user where 1=1 ',true);
}
//$this->pr($admins,true);	
	
	$user=array();
	if(!empty($admins))	
	foreach($admins as $admin)
	{
	$user[]=$admin['email'];
	}
		
  $to=implode(',',$user);		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'From: Indexing <indexing@indxx.com>' . "\r\n"."CC: indexing@indxx.com". "\r\n";
$body='Hi <br>';
$body.='Corporate Action '.$indxx['company_name'].'('.$indxx['mnemonic'].') has been approved by admin , <br> Please  <a href="'.$this->siteconfig->base_url.'index.php?module=myca&event=view&id='.$_GET['id'].'">Click here </a> to check it.<br>Thanks ';


		mail($to,"ICAI : Corporate Action Approved " ,$body,$headers);
		
		
		
		
		
		
		}
		else
		{
				$this->Redirect("index.php?module=upcomingca","You are not authorized to perofrm this task!","error");
		}*/
		
		 $this->show();	
	}	
	
	
	function approveassignedold(){
	
	$finalArray=array();
		if($_SESSION['User']['type']=='1')
		{
			foreach($_POST as $key=>$val)
		{
			foreach($val as $key2=>$val2)
			{
				if(!empty($val2))
				{
					$cadata=explode("_",$val2);
					$ca_id=$cadata['0'];
					$ca_ticker=$cadata['1'];
					
					
						$CAentry=$this->getCaStr($ca_ticker,$this->_date, $ca_id);
						
						//$this->db->query("UPDATE tbl_ca set approved='1' where tbl_ca.id='".$ca_id."'");
					
					$tickerdetails=$this->db->getResult("select indxx_id from tbl_indxx_ticker where ticker LIKE '".$ca_ticker."%'",true);
					
					//print_r(	$tickerdetails);
					
					if(!empty($tickerdetails))
					{
					foreach($tickerdetails as $indxx_id)
					{
						$indxx=$this->db->getResult("select code from tbl_indxx where id= '".$indxx_id['indxx_id']."'");
					//print_r($indxx_id);
					
					//$finalArray['code']=$indxx['code'];
				//	$finalArray['code']['ticker'][$ca_id]=$ca_ticker;
					$finalArray[$indxx['code']][$ca_ticker]['ca']=$CAentry;
					
					
					
					}
					}
				
				}}}}
				//print_r($finalArray);
				//$this->pr($finalArray);
				$filenames=array();
				$cavaluesdata.='Security Ticker'.";";		
				$cavaluesdata.='Company Ticker'.";";	
				$cavaluesdata.='ISIN'.";";
				$cavaluesdata.='Action'.";";
				$cavaluesdata.='Ex Date'.";";		
				$cavaluesdata.='Amount'.";";		
				$cavaluesdata.='Currency;';		
				$cavaluesdata.='Further Details;';		
				$cavaluesdata.='Factor;';
				$cavaluesdata.="\n";	
				foreach($finalArray as $code=>$values)
				{
					//$cavaluesdata.='Index Name'.";";
					//$cavaluesdata.=$ind['name'].";";		
					//$cavaluesdata.="\n";		
					
					$file="../files2/ca-output_upcomming/test/CA-".$code."-".$this->_date."-".time().".csv";
					
					foreach($values as $ticker=>$cavalues)
					{
						
						$cavaluesdata.=$cavalues['ca'];
					}
						$open=fopen($file,"w+");
						if($open){   
							if(fwrite($open,$cavaluesdata))
							{
								echo "File written for ".$code."-".$this->_date."-".time()."<br>";
								$filenames[]="CA-".$code."-".$this->_date."-".time().".csv";
							}
						}
		
				}
				
				//print_r($filenames);
				
			$useremails=$this->db->getResult("select email from tbl_ca_user where type='1'",true);	
			
			foreach($useremails as $users)
			{
			$user[]=$users['email'];
			}
		
  			$to=implode(',',$user);
			$from = "Indexing <indexing@indxx.com>"; 
			$subject ="New Corporate Actions"; 
			$message = 'Hi <br>';
			$message.='New Corporate Actions has been approved by admin. Following files are published on ftp at files2/ca-output_upcomming/test/ folder : <br><br>' ;
			$message.='<table>';
			foreach($filenames as $keyfiles=>$valuefiles)
			{
				$message.='<tr>';
				$message.=$valuefiles;
				$message.='</tr>';	
			}
			$message.='</table><br>';	
			$message.='Thanks ';
			$headers = "From: $from";
		
			// boundary 
			$semi_rand = md5(time()); 
			$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x"; 
		
			// headers for attachment 
			$headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" .   "
						 boundary=\"{$mime_boundary}\""; 
		
			// multipart boundary 
			$message = "This is a multi-part message in MIME format.\n\n" . "--{$mime_boundary}\n"
					   . "Content-Type: text/html; charset=\"iso-8859-1\"\n" . 
						 "Content-Transfer-Encoding: 7bit\n\n" . $message . "\n\n"; 
			$message .= "--{$mime_boundary}\n";
		
			// preparing attachments
			$filecount=count($filenames);
			for($x=0;$x<count($filenames);$x++){
					$file = fopen('../files2/ca-output_upcomming/test/'.$filenames[$x],"rb");
					$data = fread($file,filesize('../files2/ca-output_upcomming/test/'.$filenames[$x]));
					fclose($file);
					$data = chunk_split(base64_encode($data));
					
					
					$message .= "Content-Type: {\"application/octet-stream\"};\n" .  
		
								" name=\"$filenames[$x]\"\n" . 
					"Content-Disposition: attachment;\n" . " filename=\"$filenames[$x]\"\n" . 
					"Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
					
					if($x<($filecount-1))
					$message .= "--{$mime_boundary}\n";
					else
					$message .= "--{$mime_boundary}--\n";
					
					
					
			}
		
			// send
		
		   // $success = @mail($to, $subject, $message, $headers); 
		   // if ($success) { 
			//	    echo "<p>mail sent to $to!</p>"; 
		   // } else { 
			//	    echo "<p>mail could not be sent!</p>"; 
		   // } 
		

			$this->Redirect("index.php?module=myca","Corporate Actions Notified successfully!!!","success");		
	
	
	}
	
	
	function approveassigned()
	{
		
	
	$finalArray=array();
	$userdetailsArray=array();
	$userfilesArray=array();
		if($_SESSION['User']['type']=='1')
		{
			foreach($_POST as $key=>$val)
		{
			foreach($val as $key2=>$val2)
			{
				if(!empty($val2))
				{
					$cadata=explode("_",$val2);
					$ca_id=$cadata['0'];
					$ca_ticker=$cadata['1'];
					$ca_action_id=$cadata['2'];
					
					$CAentry=$this->getCaStr($ca_ticker,$this->_date, $ca_id);
						
					$this->db->query("UPDATE tbl_ca set approved='1' where tbl_ca.id='".$ca_id."'");
					
					$tickerdetails=$this->db->getResult("select indxx_id from tbl_indxx_ticker where ticker LIKE '".$ca_ticker."%'",true);
					
					//print_r($tickerdetails);
					
					if(!empty($tickerdetails))
					{
					foreach($tickerdetails as $indxx_id)
					{
						//print_r($indxx_id);
						$indxx=$this->db->getResult("select code from tbl_indxx where id= '".$indxx_id['indxx_id']."'");
						
						$assigneduserslist =$this->db->getResult('Select user_id from tbl_assign_index where indxx_id="'.$indxx_id['indxx_id'].'"',true);
						//print_r($assigneduserslist);
						
						foreach($assigneduserslist as $keyuser=>$valueuser)
						{
							
							$checkca=$this->db->getResult("select user_id from tbl_ca_admin_approve where ca_action_id = '".$ca_action_id."' ",true);
						
								if(empty($checkca))
								{
									$this->db->query("insert into tbl_ca_admin_approve(ca_id,ca_action_id,user_id) values ('".$ca_id."','".$ca_action_id."','".$valueuser['user_id']."')");	
								}
							
							if(!empty($valueuser['user_id']))
							{
							$assignedusersemails =$this->db->getResult('Select email from tbl_ca_user where id="'.$valueuser['user_id'].'"',true);	
							}
							else
							{
								$assignedusersemails =$this->db->getResult('Select email from tbl_ca_user where 1=1"',true);		
							}
							$userdetailsArray[$valueuser['user_id']][$assignedusersemails['0']['email']][$indxx['code']][]=$CAentry;
							
						}
					
					//$finalArray['code']=$indxx['code'];
				//	$finalArray['code']['ticker'][$ca_id]=$ca_ticker;
					$finalArray[$indxx['code']][$ca_ticker]['ca']=$CAentry;
					
					
					
					}
					}
				
				}}}}
				
				
				
				foreach($userdetailsArray as $userid=>$userdetails)
				{
					foreach($userdetails as $useremail=>$detailsuser)
					{				
						foreach($detailsuser as $indxxcode=>$cadata)
						{
							$file="../files2/ca-output_upcomming/test/CA-".$indxxcode."-".$this->_date."-".time().".csv";
							
							$cavaluesdata='';
							$cavaluesdata.='Security Ticker'.";";		
							$cavaluesdata.='Company Ticker'.";";	
							$cavaluesdata.='ISIN'.";";
							$cavaluesdata.='Action'.";";
							$cavaluesdata.='Ex Date'.";";		
							$cavaluesdata.='Amount'.";";		
							$cavaluesdata.='Currency;';		
							$cavaluesdata.='Further Details;';		
							$cavaluesdata.='Factor;';
							$cavaluesdata.="\n";
							foreach($cadata as $cakey=>$cavalues)
							{	//$cavaluesdata.='Index Name'.";";
									//$cavaluesdata.=$ind['name'].";";		
									//$cavaluesdata.="\n";		
									
								$cavaluesdata.=$cavalues;
						
							}
							
							$open=fopen($file,"w+");
							if($open){   
							if(fwrite($open,$cavaluesdata))
							{
									echo "File written for ".$indxxcode."-".$this->_date."-".time()."<br>";
									$userfilesArray[$useremail][$indxxcode]="CA-".$indxxcode."-".$this->_date."-".time().".csv";
									$filenames[]="CA-".$indxxcode."-".$this->_date."-".time().".csv";
							}
							}
						
						}
				
					}
				
				}
				
				foreach($userfilesArray as $useremailid=>$userindexcode)
				{
					$from = "Indexing <indexing@indxx.com>"; 
					$subject ="New Corporate Actions"; 
					$message='Hi <br>';
					$message.='New corporate Actions has been approved by admin. <br>' ;
					$message.='Thanks ';
					
					$headers = "From: $from" . "\r\n"."CC: indexing@indxx.com". "\r\n";
				
					// boundary 
					$semi_rand = md5(time()); 
					$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x"; 
				
					// headers for attachment 
					$headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" .   "
								 boundary=\"{$mime_boundary}\""; 
				
					// multipart boundary 
					$message = "This is a multi-part message in MIME format.\n\n" . "--{$mime_boundary}\n"
							   . "Content-Type: text/html; charset=\"iso-8859-1\"\n" . 
								 "Content-Transfer-Encoding: 7bit\n\n" . $message . "\n\n"; 
					$message .= "--{$mime_boundary}\n";
				
					// preparing attachments
					$x=0;
					foreach($userindexcode as $indexcode=>$userfiles)
					{
							$filecount=count($userindexcode);							
							$file = fopen('../files2/ca-output_upcomming/test/'.$userfiles,"rb");
							$data = fread($file,filesize('../files2/ca-output_upcomming/test/'.$userfiles));
							fclose($file);
							$data = chunk_split(base64_encode($data));
							
							
							$message .= "Content-Type: {\"application/octet-stream\"};\n" .  
				
										" name=\"$userfiles\"\n" . 
							"Content-Disposition: attachment;\n" . " filename=\"$userfiles\"\n" . 
							"Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
							
							if($x<($filecount-1))
							$message .= "--{$mime_boundary}\n";
							else
							$message .= "--{$mime_boundary}--\n";
							
							$x++;
							
					}
				
					// send
				
			   $success = @mail($useremailid, $subject, $message, $headers); 
				  if ($success) { 
						 echo "<p>mail sent to $useremailid!</p>"; 
				   } else { 
					  echo "<p>mail could not be sent!</p>"; 
				    } 
									
								
						
				}
				
			
		

			$this->Redirect("index.php?module=myca","Corporate Actions Notified successfully!!!","success");		
	
	
		
	}
	
	function approveassigned2()
	{
		
			$this->_baseTemplate="inner-template";
			$this->_bodyTemplate="myca/approve";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','Corporate Actions');
		$this->smarty->assign('bredcrumssubtitle','Approved Corporate Actions');
		
		//$this->pr($_POST,true);
		
		
		
					$indxxdetails=array();
					$useridss=array();
					$users=array();
		
			if($_SESSION['User']['type']=='1')
		{
			foreach($_POST as $key=>$val)
		{
			foreach($val as $key2=>$val2)
			{
				if(!empty($val2))
				{
					$cadata=explode("_",$val2);
					echo $ca_id=$cadata['0'];
					echo $ca_ticker=$cadata['1'];
					
					$viewdata=$this->db->getResult("select tbl_ca.company_name from tbl_ca where tbl_ca.id='".$ca_id."'",true);
		//$this->pr($viewdata,true);
		$this->smarty->assign("viewapprovedca",$viewdata);
		
		
		$FieldsData=$this->db->getResult('SELECT * FROM tbl_ca_values where ca_id="'.$ca_id.'"',true);
	//	$this->pr($sequruityData,true);
		//$this->smarty->assign("approvedindexSecurity",$sequruityData);
		$this->smarty->assign("approvedcaSecurityrows",count($FieldsData));
		
		
		
		$this->db->query("UPDATE tbl_ca set approved='1' where tbl_ca.id='".$ca_id."'");
		
		
				
	//	echo "select * tbl_indxx where tbl_indxx.id='".$_GET['id']."'";
			$cadetails=$this->db->getResult("select * from tbl_ca  where tbl_ca.id='".$ca_id."'");
			
			$tickerdetails=$this->db->getResult("select * from tbl_indxx_ticker where ticker LIKE '%".$ca_ticker."%'");
		//	$this->pr($tickerdetails);
			foreach($tickerdetails as $tickers)
			{
				//$this->pr($tickerdetails);
				$indxxdetails[]=$this->db->getResult("select * from tbl_indxx where id='".$tickers['indxx_id']."'");
			}
			//$this->pr($indxxdetails);
			
			
			
			
			//echo $val2."=>".$cadetails['identifier']."<br>";
			//$this->pr($useridss);
		
		$indxxadmins =	$this->db->getResult('Select  user_id from tbl_assign_index where indxx_id="'.$_GET['id'].'" union Select  user_id from tbl_assign_index_temp where indxx_id="'.$_GET['id'].'" ',true);
$indxxadmin='';
//print_r($indxxadmins );
$emailto=array();

if(!empty($indxxadmins))
{
foreach($indxxadmins as $array)
{
	$emailto[]=$array['user_id'];
}


}

//print_r($emailto);

	//exit;
	if(!empty($emailto))
	{	
//	echo  'Select  email from tbl_ca_user where type="1" or id in ('.implode(',',$emailto).') ';
	$admins =	$this->db->getResult('Select  email from tbl_ca_user where type="1" or id in ('.implode(',',$emailto).') ',true);
	}
else
{	$admins =	$this->db->getResult('Select  email from tbl_ca_user where 1=1 ',true);
}
//$this->pr($admins,true);	
	
	$user=array();
	if(!empty($admins))	
	foreach($admins as $admin)
	{
	$user[]=$admin['email'];
	}
		
  $to=implode(',',$user);		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'From: Indexing <indexing@indxx.com>' . "\r\n"."CC: indexing@indxx.com". "\r\n";
$body='Hi <br>';
$body.='Corporate Action '.$indxx['company_name'].'('.$indxx['mnemonic'].') has been approved by admin , <br> Please  <a href="'.$this->siteconfig->base_url.'index.php?module=myca&event=view&id='.$_GET['id'].'">Click here </a> to check it.<br>Thanks ';


		//mail($to,"ICAI : Corporate Action Approved " ,$body,$headers);
				}
			}
		}
		exit;
		}
		else
		{
				$this->Redirect("index.php?module=upcomingca","You are not authorized to perofrm this task!","error");
		}
		
		 $this->show();	
	
	}
	
	
	function adddividendplaceholder(){
	
		
		
		if($_POST)
		{
			
			
			//$this->pr($_POST,true);
			foreach($_POST as $key=>$value)
			{
				
			//	echo $key;
			//	exit;
				
				if($key=='array1')
				{
				foreach($value as $key2=>$val)
				{
					if(!empty($val))
					{
						$ignoredata=explode("_",$val);
						$indxx_id=$ignoredata['0'];
						$ca_id=$ignoredata['1'];
						
						$action_id=$this->db->getResult("select action_id from tbl_ca where id = '".$ca_id."' ",true);
						//echo "insert into tbl_ignore_index(ca_id,ca_action_id,indxx_id) values('".$ca_id."','".$action_id['0']['action_id']."','".$indxx_id."')";
						$this->db->query("insert into tbl_dividend_ph_req(ca_id,ca_action_id,indxx_id) values('".$ca_id."','".$action_id['0']['action_id']."','".$indxx_id."')");
						
					}
				}	
				}
				if($key=='array2')
				{
				foreach($value as $key2=>$val)
				{
					if(!empty($val))
					{
						$ignoredata=explode("_",$val);
						$indxx_id=$ignoredata['0'];
						$ca_id=$ignoredata['1'];
						
						$action_id=$this->db->getResult("select action_id from tbl_ca where id = '".$ca_id."' ",true);
					//	echo "insert into tbl_ignore_index_temp(ca_id,ca_action_id,indxx_id) values('".$ca_id."','".$action_id['0']['action_id']."','".$indxx_id."')";
						$this->db->query("insert into tbl_dividend_ph_req_temp(ca_id,ca_action_id,indxx_id) values('".$ca_id."','".$action_id['0']['action_id']."','".$indxx_id."')");
						
					}
				}	
				}
			}
			
			
			//exit;
			$this->Redirect("index.php?module=myca","Index Ignored Successfully","success");
				
		}
		
			$this->_baseTemplate="inner-template";
	$this->_bodyTemplate="myca/dividendplaceholder";
		$this->_title=$this->siteconfig->site_title;
		$this->_meta_description=$this->siteconfig->default_meta_description;
		$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
//	$this->addfield();

		$this->smarty->assign('pagetitle','Corporate Actions');
		$this->smarty->assign('bredcrumssubtitle','Ignore Index');


		$cadata=$this->db->getResult("select tbl_ca.* from tbl_ca where id = '".$_GET['id']."' ",true);
		//$this->pr($cadata,true);
		$this->smarty->assign("viewdata",$cadata);
		
		
//$this->pr($indexdata2,true);
$ticker=$cadata[0]['identifier'];
$tickerdata=$this->db->getResult("select tbl_indxx_ticker.indxx_id from tbl_indxx_ticker where ticker = '".$ticker."' ",true);
//$this->pr($tickerdata,true);	
	
	$indxes=array();
	if(!empty($tickerdata))
	{
	foreach($tickerdata as $data)
	{
	$indxes[]=$data['indxx_id'];
	}
	}
	
	$ids=implode(',',$indxes);
	
		//	echo "select tbl_indxx.name,tbl_indxx.code from tbl_indxx where id = '".$ticker['indxx_id']."' ";
	$indxxd=$this->db->getResult("select tbl_indxx.name,tbl_indxx.code,tbl_indxx.id as indxx_id from tbl_indxx where id in (".$ids.")",true);
	


	
		
//$this->pr($clientdata,true);
$this->smarty->assign("indxxd",$indxxd);






$tickerdata2=$this->db->getResult("select tbl_indxx_ticker_temp.indxx_id from tbl_indxx_ticker_temp where ticker = '".$ticker."' ",true);
//$this->pr($tickerdata,true);	
	if(!empty($tickerdata2))
	$indxes2=array();
	if(!empty($tickerdata2))
	{
	foreach($tickerdata2 as $data)
	{
	$indxes2[]=$data['indxx_id'];
	}
	}
	$idst='';
	
	if(!empty($indxes2))
	$idst=implode(',',$indxes2);
	
		//	echo "select tbl_indxx.name,tbl_indxx.code from tbl_indxx where id = '".$ticker['indxx_id']."' ";
	if($idst)
		$indxxt=$this->db->getResult("select tbl_indxx_temp.name,tbl_indxx_temp.code,tbl_indxx_temp.id as indxx_id from tbl_indxx_temp where id in (".$idst.")",true);
	


	
		

$this->smarty->assign("indxxt",$indxxt);








	//$this->pr($indxxd,true);
	
		//$this->pr($_SESSION);
		
		
		 $this->show();
		
	}
	
	
	function ignoreindex(){
		
		
		if($_POST)
		{
			
			
			//$this->pr($_POST,true);
			foreach($_POST as $key=>$value)
			{
				
			//	echo $key;
			//	exit;
				
				if($key=='array1')
				{
				foreach($value as $key2=>$val)
				{
					if(!empty($val))
					{
						$ignoredata=explode("_",$val);
						$indxx_id=$ignoredata['0'];
						$ca_id=$ignoredata['1'];
						
						$action_id=$this->db->getResult("select action_id from tbl_ca where id = '".$ca_id."' ",true);
						//echo "insert into tbl_ignore_index(ca_id,ca_action_id,indxx_id) values('".$ca_id."','".$action_id['0']['action_id']."','".$indxx_id."')";
						$this->db->query("insert into tbl_ignore_index(ca_id,ca_action_id,indxx_id) values('".$ca_id."','".$action_id['0']['action_id']."','".$indxx_id."')");
						
					}
				}	
				}
				if($key=='array2')
				{
				foreach($value as $key2=>$val)
				{
					if(!empty($val))
					{
						$ignoredata=explode("_",$val);
						$indxx_id=$ignoredata['0'];
						$ca_id=$ignoredata['1'];
						
						$action_id=$this->db->getResult("select action_id from tbl_ca where id = '".$ca_id."' ",true);
					//	echo "insert into tbl_ignore_index_temp(ca_id,ca_action_id,indxx_id) values('".$ca_id."','".$action_id['0']['action_id']."','".$indxx_id."')";
						$this->db->query("insert into tbl_ignore_index_temp(ca_id,ca_action_id,indxx_id) values('".$ca_id."','".$action_id['0']['action_id']."','".$indxx_id."')");
						
					}
				}	
				}
			}
			
			
			//exit;
			$this->Redirect("index.php?module=myca","Index Ignored Successfully","success");
				
		}
		
			$this->_baseTemplate="inner-template";
	$this->_bodyTemplate="myca/ignore";
		$this->_title=$this->siteconfig->site_title;
		$this->_meta_description=$this->siteconfig->default_meta_description;
		$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
//	$this->addfield();

		$this->smarty->assign('pagetitle','Corporate Actions');
		$this->smarty->assign('bredcrumssubtitle','Ignore Index');


		$cadata=$this->db->getResult("select tbl_ca.* from tbl_ca where id = '".$_GET['id']."' ",true);
		//$this->pr($cadata,true);
		$this->smarty->assign("viewdata",$cadata);
		
		
//$this->pr($indexdata2,true);
$ticker=$cadata[0]['identifier'];
$tickerdata=$this->db->getResult("select tbl_indxx_ticker.indxx_id from tbl_indxx_ticker where ticker = '".$ticker."' ",true);
//$this->pr($tickerdata,true);	
	
	$indxes=array();
	if(!empty($tickerdata))
	{
	foreach($tickerdata as $data)
	{
	$indxes[]=$data['indxx_id'];
	}
	}
	
	$ids=implode(',',$indxes);
	
		//	echo "select tbl_indxx.name,tbl_indxx.code from tbl_indxx where id = '".$ticker['indxx_id']."' ";
	$indxxd=$this->db->getResult("select tbl_indxx.name,tbl_indxx.code,tbl_indxx.id as indxx_id from tbl_indxx where id in (".$ids.")",true);
	


	
		
//$this->pr($clientdata,true);
$this->smarty->assign("indxxd",$indxxd);






$tickerdata2=$this->db->getResult("select tbl_indxx_ticker_temp.indxx_id from tbl_indxx_ticker_temp where ticker = '".$ticker."' ",true);
//$this->pr($tickerdata,true);	
	if(!empty($tickerdata2))
	$indxes2=array();
	if(!empty($tickerdata2))
	{
	foreach($tickerdata2 as $data)
	{
	$indxes2[]=$data['indxx_id'];
	}
	}
	$idst='';
	
	if(!empty($indxes2))
	$idst=implode(',',$indxes2);
	
		//	echo "select tbl_indxx.name,tbl_indxx.code from tbl_indxx where id = '".$ticker['indxx_id']."' ";
	if($idst)
		$indxxt=$this->db->getResult("select tbl_indxx_temp.name,tbl_indxx_temp.code,tbl_indxx_temp.id as indxx_id from tbl_indxx_temp where id in (".$idst.")",true);
	


	
		

$this->smarty->assign("indxxt",$indxxt);








	//$this->pr($indxxd,true);
	
		//$this->pr($_SESSION);
		
		
		 $this->show();
		}
		
		
		
		
		protected function edit(){
		 
		$this->_baseTemplate="inner-template";
			$this->_bodyTemplate="myca/edit";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','Index');
		$this->smarty->assign('bredcrumssubtitle','EditIndex');
		
		
		if(isset($_POST['submit']))
		{
			
			
			$checkArray=array();
			$checkArray['DVD_CASH']=array('CP_NET_AMT','CP_GROSS_AMT','CP_DVD_CRNCY','CP_DVD_TYP','CP_ADJ');
			$checkArray['CHG_NAME']=array('CP_OLD_NAME','CP_NEW_NAME');
			$checkArray['CHG_ID']=array('CP_OLD_ISIN','CP_NEW_ISIN');
			$checkArray['SPIN']=array('CP_ADJ');
			$checkArray['DVD_STOCK']=array('CP_AMT');
			$checkArray['STOCK_SPLT']=array('CP_ADJ');
			$checkArray['RIGHTS_OFFER']=array('CP_RATIO','CP_ADJ','CP_PX','CP_CRNCY');		
			$datevalue2=$this->_date;
		
		
		
			$cavaluesdata=array();
			
			$cadata=$this->db->getResult("select tbl_ca.* from tbl_ca where tbl_ca.id='".$_GET['id']."'");
			//$this->pr($editdata,true);
			
			if(array_key_exists($cadata['mnemonic'],$checkArray))
			{
				$this->addfield($checkArray[$cadata['mnemonic']]);	
				foreach($checkArray[$cadata['mnemonic']] as $fields)
				{
					$array=$this->db->getResult("select tbl_ca_values.field_value from tbl_ca_values where tbl_ca_values.ca_action_id='".$cadata['action_id']."' and tbl_ca_values.field_name = '".$fields."'");
					$cavaluesdata[$fields]=$array['field_value'];
					
				}
				
				
				$prefiledata[$cadata['action_id']]=$cavaluesdata;
				
			}
		
		
			
					
			file_put_contents('../files2/backup/preEDITcavaluesdata'.date("Y-m-d-H-i-s").'.json', json_encode($prefiledata));
			
			foreach($_POST as $field=>$values)
			{
				//$this->pr($_POST,true);
				if(!empty($_POST['checkboxid']))
				foreach($_POST['checkboxid'] as $indxx_ca)
				{
					$indxxids=explode("_",$indxx_ca);
					$indxxid=$indxxids[0];
					
					
				if($field!='submit' && !is_array($field) && $field!='checkboxid')
				{
					$fieldname=substr($field,0,-6);
					
					//echo "DELETE from tbl_ca_values_user_edited where tbl_ca_values.field_name='".$fieldname."' and ca_action_id='".$cadata['action_id']."'  ";
					//exit;
					$this->db->query("DELETE from tbl_ca_values_user_edited where tbl_ca_values_user_edited.field_name='".$fieldname."' and ca_action_id='".$cadata['action_id']."' and indxx_id='".$indxxid."'  ");
					
					
					
					$this->db->query("INSERT into tbl_ca_values_user_edited(field_name,field_value,ca_id,ca_action_id,indxx_id) values('".$fieldname."','".$values."','".$_GET['id']."','".$cadata['action_id']."','".$indxxid."')");
					
					$cavaluesdata2[$fieldname]=$values;
					
					
				}
				}
			}
			
			
			
			$postfiledata[$cadata['action_id']]=$cavaluesdata2;
			
			
			
			file_put_contents('../files2/backup/postEDITcavaluesdata'.date("Y-m-d-H-i-s").'.json', json_encode($postfiledata));
		
		
			$this->Redirect("index.php?module=myca","Record updated successfully!!!","success");	

			
				
				
		
		}
		
		
		$checkArray=array();
		$checkArray['DVD_CASH']=array('CP_NET_AMT','CP_GROSS_AMT','CP_DVD_CRNCY','CP_DVD_TYP','CP_ADJ');
		$checkArray['CHG_NAME']=array('CP_OLD_NAME','CP_NEW_NAME');
		$checkArray['CHG_ID']=array('CP_OLD_ISIN','CP_NEW_ISIN');
		$checkArray['SPIN']=array('CP_ADJ');
		$checkArray['DVD_STOCK']=array('CP_AMT');
		$checkArray['STOCK_SPLT']=array('CP_ADJ');
		$checkArray['RIGHTS_OFFER']=array('CP_RATIO','CP_ADJ','CP_PX','CP_CRNCY');		
		$datevalue2=$this->_date;
		
		
		
		$cavaluesdata=array();
		
		$cadata=$this->db->getResult("select tbl_ca.* from tbl_ca where tbl_ca.id='".$_GET['id']."'");
		//$this->pr($editdata,true);
		
		if(array_key_exists($cadata['mnemonic'],$checkArray))
		{
			$this->addfield($checkArray[$cadata['mnemonic']]);	
			foreach($checkArray[$cadata['mnemonic']] as $fields)
			{
				$array=$this->db->getResult("select tbl_ca_values.field_value from tbl_ca_values where tbl_ca_values.ca_action_id='".$cadata['action_id']."' and tbl_ca_values.field_name = '".$fields."'");
				$cavaluesdata[$fields.'_value']=$array['field_value'];
				
			}
			
			
			
			
		}
		
		
		
		
			$cadata=$this->db->getResult("select tbl_ca.* from tbl_ca where id = '".$_GET['id']."' ",true);
		//$this->pr($cadata,true);
		$this->smarty->assign("viewdata",$cadata);
		
		
//$this->pr($indexdata2,true);
$ticker=$cadata[0]['identifier'];
$tickerdata=$this->db->getResult("select tbl_indxx_ticker.indxx_id from tbl_indxx_ticker where ticker = '".$ticker."' ",true);
//$this->pr($tickerdata,true);	
	
	$indxes=array();
	if(!empty($tickerdata))
	{
	foreach($tickerdata as $data)
	{
	$indxes[]=$data['indxx_id'];
	}
	}
	
	$ids=implode(',',$indxes);
	
		//	echo "select tbl_indxx.name,tbl_indxx.code from tbl_indxx where id = '".$ticker['indxx_id']."' ";
	$indxxd=$this->db->getResult("select tbl_indxx.name,tbl_indxx.code,tbl_indxx.id as indxx_id from tbl_indxx where id in (".$ids.")",true);
	


	
		
//$this->pr($clientdata,true);
$this->smarty->assign("indxxd",$indxxd);


















		
		$this->smarty->assign("postData",$cavaluesdata);
		
		
		
		
		 $this->show();
			
	}
	
	private function addfieldforrunning($count,$action_id)
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
								 
		$this->validData[]=array("feild_label" =>"Share",
		 							"feild_code" =>"share[".$i.']',
								 "feild_type" =>"hidden",
								 "is_required" =>"",
								
								);
	//  "feild_tpl" =>"place_text2",
	
	 $this->validData[]=array("feild_label" =>"Ca Action ",
	 							"feild_code" =>"ca_action_id[".$i.']',
								 "feild_type" =>"hidden",
								 "is_required" =>"",
								   "feild_tpl" =>"hidden2",
								 'value'=>$action_id
								 );
	
	 $this->validData[]=array(	"feild_label"=>"Ticker Currency",
	 							"feild_code" =>"curr[".$i.']',
								 "feild_type" =>"text",
								  "feild_tpl" =>"place_text2",
								 "is_required" =>"",
								
								 );	 
	$this->validData[]=array(	"feild_label"=>"Dividend Currency",
	 							"feild_code" =>"divcurr[".$i.']',
								 "feild_type" =>"text",
								  "feild_tpl" =>"place_text2",
								 "is_required" =>"",
								
								 );	 
}
	$this->getValidFeilds();
	}
function 	addStockforSpin()
{
	
		 
		$this->_baseTemplate="inner-template";
			$this->_bodyTemplate="myca/addStockforSpin";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','Index');
		$this->smarty->assign('bredcrumssubtitle','EditIndex');
			
			$cadata=$this->db->getResult("select tbl_ca.* from tbl_ca where tbl_ca.id='".$_GET['id']."'");
		
		if(isset($_POST['submit']))
		{
			
			
			//$this->pr($_POST,true);
			$indxeArray=array();
			if(!empty($_POST['checkboxid']))
			{
			$this->db->query("insert into tbl_spin_stock_add (action_id,user_id) values ('".$cadata['action_id']."','".$_SESSION["User"]['id']."')");
			
			if(!empty($_POST['checkboxid']))	
			{foreach($_POST['checkboxid'] as $indxxs)
			{
				
			 $cadata['action_id']."<br>";
				
			$indxeArray=explode("_",$indxxs);
			//$this->pr($cadata);
			for($i=1;$i<=count($_POST['name']) ; $i++)
			{
			if($_POST['name'][$i] && $_POST['isin'][$i] && $_POST['ticker'][$i] && $_POST['curr'][$i] && $_POST['divcurr'][$i])
			{
				
				//echo "Insert ";
				$this->db->query("INSERT INTO `tbl_spin_stock_add_securities` (`id`, `name`, `isin`, `ticker`, `curr`, `divcurr`, `indxx_id`, `dateAdded`, `status`, `req_id`) VALUES (NULL, '".mysql_real_escape_string($_POST['name'][$i])."', '".mysql_real_escape_string($_POST['isin'][$i])."', '".mysql_real_escape_string($_POST['ticker'][$i])."', '".mysql_real_escape_string($_POST['curr'][$i])."', '".mysql_real_escape_string($_POST['divcurr'][$i])."', '".$indxeArray[0]."', CURRENT_TIMESTAMP, '1', '".$cadata['action_id']."');");
			}
			}
			
			}
			}
			if(!empty($_POST['checkboxtempid'])){
			foreach($_POST['checkboxtempid'] as $indxxs)
			{
				
			 $cadata['action_id']."<br>";
				
			$indxeArray=explode("_",$indxxs);
			//$this->pr($cadata);
			for($i=1;$i<=count($_POST['name']) ; $i++)
			{
			if($_POST['name'][$i] && $_POST['isin'][$i] && $_POST['ticker'][$i] && $_POST['curr'][$i] && $_POST['divcurr'][$i])
			{
				
				//echo "Insert ";
				$this->db->query("INSERT INTO `tbl_spin_stock_add_securities_temp` (`id`, `name`, `isin`, `ticker`, `curr`, `divcurr`, `indxx_id`, `dateAdded`, `status`, `req_id`) VALUES (NULL, '".mysql_real_escape_string($_POST['name'][$i])."', '".mysql_real_escape_string($_POST['isin'][$i])."', '".mysql_real_escape_string($_POST['ticker'][$i])."', '".mysql_real_escape_string($_POST['curr'][$i])."', '".mysql_real_escape_string($_POST['divcurr'][$i])."', '".$indxeArray[0]."', CURRENT_TIMESTAMP, '1', '".$cadata['action_id']."');");
			}
			}
			}
			}
			
			}
			
			$emailQueries='select email from tbl_database_users where status="1"';
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
			
		$msg='Hi '."<br>New Stock Addition for spinoff is added  Pleas visit  ". $this->siteconfig->base_url ." to download and approve new Request File.<br> thanks ";
				$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'From: Indexing <indexing@indxx.com>' . "\r\n"."CC: indexing@indxx.com". "\r\n";
			//echo $emailsids;
		if(mail($emailsids,"New Stock Addition ",$msg,$headers))
		{
			echo "Mail sent to : ".$to."<br>";	
		}
		}
		
			//exit;
			
			$this->Redirect("index.php?module=myca","Record updated successfully!!!","success");	

			
				
				
		
		}
		
		
		$checkArray=array();
		$datevalue2=$this->_date;
		
		
		
		$cavaluesdata=array();
		
		
		//$this->pr($editdata,true);
		
		
		
		
		
		$cadata=$this->db->getResult("select tbl_ca.* from tbl_ca where id = '".$_GET['id']."' ",true);
		//$this->pr($cadata,true);
		$this->smarty->assign("viewdata",$cadata);
		
		
//$this->pr($indexdata2,true);
$ticker=$cadata[0]['identifier'];
$this->addfieldforrunning(10,$cadata[0]['action_id']);
$tickerdata=$this->db->getResult("select tbl_indxx_ticker.indxx_id from tbl_indxx_ticker where ticker = '".$ticker."' ",true);
//$this->pr($tickerdata,true);	
	
	$indxes=array();
	if(!empty($tickerdata))
	{
	foreach($tickerdata as $data)
	{
	$indxes[]=$data['indxx_id'];
	}
	}
	if(!empty($indxes)){
	$ids=implode(',',$indxes);
	
		//	echo "select tbl_indxx.name,tbl_indxx.code from tbl_indxx where id = '".$ticker['indxx_id']."' ";
	$indxxd=$this->db->getResult("select tbl_indxx.name,tbl_indxx.code,tbl_indxx.id as indxx_id from tbl_indxx where id in (".$ids.")",true);
	


	
		
//$this->pr($indxxd,true);
$this->smarty->assign("indxxd",$indxxd);
	}


$tickertempdata=$this->db->getResult("select tbl_indxx_ticker_temp.indxx_id from tbl_indxx_ticker_temp where ticker = '".$ticker."' ",true);
//$this->pr($tickertempdata,true);	
	
	$indxes=array();
	if(!empty($tickertempdata))
	{
	foreach($tickertempdata as $data)
	{
	$indxes[]=$data['indxx_id'];
	}
	}
	if(!empty($indxes)){
	$idsu=implode(',',$indxes);
	
		//	echo "select tbl_indxx.name,tbl_indxx.code from tbl_indxx where id = '".$ticker['indxx_id']."' ";
	
	
	$indxxu=$this->db->getResult("select tbl_indxx_temp.name,tbl_indxx_temp.code,tbl_indxx_temp.id as indxx_id from tbl_indxx_temp where id in (".$idsu.")",true);
	
	}

	
		
//$this->pr($clientdata,true);
$this->smarty->assign("indxxu",$indxxu);














		
	//	$this->smarty->assign("postData",$cavaluesdata);
		
		
		
		
		 $this->show();
			
	
	}		
		protected function editfortemp(){
		 
		$this->_baseTemplate="inner-template";
			$this->_bodyTemplate="myca/edit";
			$this->_title=$this->siteconfig->site_title;
			$this->_meta_description=$this->siteconfig->default_meta_description;
			$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
			
			$this->smarty->assign('pagetitle','Index');
		$this->smarty->assign('bredcrumssubtitle','EditIndex');
		
		
		if(isset($_POST['submit']))
		{
			
			
			$checkArray=array();
			$checkArray['DVD_CASH']=array('CP_NET_AMT','CP_GROSS_AMT','CP_DVD_CRNCY','CP_DVD_TYP','CP_ADJ');
			$checkArray['CHG_NAME']=array('CP_OLD_NAME','CP_NEW_NAME');
			$checkArray['CHG_ID']=array('CP_OLD_ISIN','CP_NEW_ISIN');
			$checkArray['SPIN']=array('CP_ADJ');
			$checkArray['DVD_STOCK']=array('CP_AMT');
			$checkArray['STOCK_SPLT']=array('CP_ADJ');
			$checkArray['RIGHTS_OFFER']=array('CP_RATIO','CP_ADJ','CP_PX','CP_CRNCY');		
			$datevalue2=$this->_date;
		
		
		
			$cavaluesdata=array();
			
			$cadata=$this->db->getResult("select tbl_ca.* from tbl_ca where tbl_ca.id='".$_GET['id']."'");
			//$this->pr($editdata,true);
			
			if(array_key_exists($cadata['mnemonic'],$checkArray))
			{
				$this->addfield($checkArray[$cadata['mnemonic']]);	
				foreach($checkArray[$cadata['mnemonic']] as $fields)
				{
					$array=$this->db->getResult("select tbl_ca_values.field_value from tbl_ca_values where tbl_ca_values.ca_action_id='".$cadata['action_id']."' and tbl_ca_values.field_name = '".$fields."'");
					$cavaluesdata[$fields]=$array['field_value'];
					
				}
				
				
				$prefiledata[$cadata['action_id']]=$cavaluesdata;
				
			}
		
		
			
					
			file_put_contents('../files2/backup/preEDITcavaluesdata'.date("Y-m-d-H-i-s").'.json', json_encode($prefiledata));
			
			foreach($_POST as $field=>$values)
			{
				//$this->pr($_POST,true);
				if(!empty($_POST['checkboxid']))
				foreach($_POST['checkboxid'] as $indxx_ca)
				{
					$indxxids=explode("_",$indxx_ca);
					$indxxid=$indxxids[0];
					
					
				if($field!='submit' && !is_array($field) && $field!='checkboxid')
				{
					$fieldname=substr($field,0,-6);
					
					//echo "DELETE from tbl_ca_values_user_edited where tbl_ca_values.field_name='".$fieldname."' and ca_action_id='".$cadata['action_id']."'  ";
					//exit;
					$this->db->query("DELETE from tbl_ca_values_user_edited_temp where tbl_ca_values_user_edited.field_name='".$fieldname."' and ca_action_id='".$cadata['action_id']."' and indxx_id='".$indxxid."'  ");
					
					
					
					$this->db->query("INSERT into tbl_ca_values_user_edited_temp(field_name,field_value,ca_id,ca_action_id,indxx_id) values('".$fieldname."','".$values."','".$_GET['id']."','".$cadata['action_id']."','".$indxxid."')");
					
					$cavaluesdata2[$fieldname]=$values;
					
					
				}
				}
			}
			
			
			
			$postfiledata[$cadata['action_id']]=$cavaluesdata2;
			
			
			
			file_put_contents('../files2/backup/postEDITcavaluesdata'.date("Y-m-d-H-i-s").'.json', json_encode($postfiledata));
		
		
			$this->Redirect("index.php?module=myca","Record updated successfully!!!","success");	

			
				
				
		
		}
		
		
		$checkArray=array();
		$checkArray['DVD_CASH']=array('CP_NET_AMT','CP_GROSS_AMT','CP_DVD_CRNCY','CP_DVD_TYP','CP_ADJ');
		$checkArray['CHG_NAME']=array('CP_OLD_NAME','CP_NEW_NAME');
		$checkArray['CHG_ID']=array('CP_OLD_ISIN','CP_NEW_ISIN');
		$checkArray['SPIN']=array('CP_ADJ');
		$checkArray['DVD_STOCK']=array('CP_AMT');
		$checkArray['STOCK_SPLT']=array('CP_ADJ');
		$checkArray['RIGHTS_OFFER']=array('CP_RATIO','CP_ADJ','CP_PX','CP_CRNCY');		
		$datevalue2=$this->_date;
		
		
		
		$cavaluesdata=array();
		
		$cadata=$this->db->getResult("select tbl_ca.* from tbl_ca where tbl_ca.id='".$_GET['id']."'");
		//$this->pr($editdata,true);
		
		if(array_key_exists($cadata['mnemonic'],$checkArray))
		{
			$this->addfield($checkArray[$cadata['mnemonic']]);	
			foreach($checkArray[$cadata['mnemonic']] as $fields)
			{
				$array=$this->db->getResult("select tbl_ca_values.field_value from tbl_ca_values where tbl_ca_values.ca_action_id='".$cadata['action_id']."' and tbl_ca_values.field_name = '".$fields."'");
				$cavaluesdata[$fields.'_value']=$array['field_value'];
				
			}
			
			
			
			
		}
		
		
		
		
			$cadata=$this->db->getResult("select tbl_ca.* from tbl_ca where id = '".$_GET['id']."' ",true);
		//$this->pr($cadata,true);
		$this->smarty->assign("viewdata",$cadata);
		
		
//$this->pr($indexdata2,true);
$ticker=$cadata[0]['identifier'];
$tickerdata=$this->db->getResult("select tbl_indxx_ticker_temp.indxx_id from tbl_indxx_ticker_temp where ticker = '".$ticker."' ",true);
//$this->pr($tickerdata,true);	
	
	$indxes=array();
	if(!empty($tickerdata))
	{
	foreach($tickerdata as $data)
	{
	$indxes[]=$data['indxx_id'];
	}
	}
	
	$ids=implode(',',$indxes);
	
		//	echo "select tbl_indxx.name,tbl_indxx.code from tbl_indxx where id = '".$ticker['indxx_id']."' ";
	$indxxd=$this->db->getResult("select tbl_indxx_temp.name,tbl_indxx_temp.code,tbl_indxx_temp.id as indxx_id from tbl_indxx_temp where id in (".$ids.")",true);
	


	
		
//$this->pr($clientdata,true);
$this->smarty->assign("indxxd",$indxxd);


















		
		$this->smarty->assign("postData",$cavaluesdata);
		
		
		
		
		 $this->show();
			
	}
	private function addfield($array)
	{	
		foreach($array as $value)
		{
	 
		 $this->validData[]=array("feild_label" =>$value,
		 							"feild_code" =>$value."_value",
								 "feild_type" =>"text",
								 "is_required" =>"0",
								
								 );
		}
	
	$this->getValidFeilds();
	}
		
		
}?>