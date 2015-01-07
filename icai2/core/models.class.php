<?php 
//// to add the Static Function 
class Models{	

	 
	 var $_depth= 0;
	
	
	function checkUserSession()
	{
						 
	//		$this->pr($_SESSION);
	
		if(!isset($_SESSION['User']['id']) && $_SESSION['User']['id'] == '' )
		{
			
			$_SESSION['redirect_url'] = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	
		   $this->Redirect("index.php",$this->l("Please Login or Sign up on the site."),"error");
					
			
			
		}
		 
		
		
	}
			 
		
		
	
	function createUserSession()
	{
						 
	 		
		if(isset($_SESSION['User']['UserID']) && $_SESSION['User']['UserID'] != '' )
		{
		  	$this->smarty->assign('sessData', $_SESSION['User']);
			
		}
		
		
	}


	
	
	
	
	## function to get product Custion Option array
	## @parms : animalid
	## @ return array
	

	
 function intcheck($int)
	{
		if(is_numeric($int) === TRUE)
		{
         if((int)$int == $int)
			{
				return 1;
             }
			else
			{
				
             return 0;
            }
              
		}
		else
		{
        
            return 0;
        }
    }
function GetAdmin_group ()
	{
		$groupArray	=	$this->db->getResult("select  id,name from tbl_admin_group where system!='1' order by Name ",true);
		//$this->pr($catArray);	
		if(is_array($groupArray) > 0){ 
			$ShowList = array();
			foreach($groupArray as $data){
				$ShowList[$data['id']]	=	$data['name'];
			}
		}
		
		
		
	return $ShowList;	
	}
	
	function getEmployee($select='')
	{
		$groupArray	=	$this->db->getResult("select  id,fname,lname from tbl_employee where status='1' order by fname ",true);
		//$this->pr($catArray);	
		if(is_array($groupArray) > 0){ 
			$ShowList = array();
			if ($select)
			$ShowList1['']=$select;
			else
			$ShowList['']="Select";
			foreach($groupArray as $data){
				$ShowList[$data['id']]	=	$data['fname']." ".$data['lname'];
			}
		}
	return $ShowList;	
	
	}	function getEmployee2()
	{
	$groupArray	=	$this->db->getResult("select  id,fname,lname from tbl_employee where status='1' order by fname ",true);
		//$this->pr($catArray);	
		if(is_array($groupArray) > 0){ 
			$ShowList = array();
			foreach($groupArray as $data){
				$ShowList[$data['id']]	=	$data['fname']." ".$data['lname'];
			}
		}
	return $ShowList;
	}
	
		function getVeryfyStatusArray(){
			return	array('1'=>'Yes', '0'=>'No' ) ; 
		}
		
	function getPriorityArray(){
			return	array('1'=>'1', '2'=>'2', '3'=>'3', '4'=>'4', '5'=>'5', '6'=>'6', '7'=>'7', '8'=>'8', '9'=>'9', '10'=>'10' ) ; 
		}	
		
		
	function	getReturnTypes()
	{
			return	array('0'=>'TR', '1'=>'PR' ) ; 
	
	}
		function getStateName($stateid="")
		{
			$query	=	$this->db->getResult("select name from tbl_states  where id='$stateid'");
			$name=$query['name'];
			return $name;
		}
		function getCityName($cityid="")
		{
			$query	=	$this->db->getResult("select name from tbl_cities  where id='$cityid'");
			$name=$query['name'];
			return $name;
		}
		
		
	function 	setSessionvariable()
	{
			$values=	$this->db->getResult("select code ,name from tbl_ca_subcategory  union select field_name as code ,definition as name from tbl_ca_action_fields   ");
if(!empty($values))
{
$array=array();
foreach($values as $value)
{
$array[$value['code']]=$value['name'];
}
return $array;

}
	
	}		
		
		function getActionTypes()
	{
		$groupArray	=	$this->db->getResult("select  id,name from tbl_ca_action_event_type order by name ",true);
		//$this->pr($catArray);	
		if(is_array($groupArray) > 0){ 
			$ShowList = array();
			$ShowList['']="Select";
			foreach($groupArray as $data){
				$ShowList[$data['id']]	=	$data['name'];
			}
		}
	return $ShowList;	
	
	}
		
		function getActionEvents()
	{
		$groupArray	=	$this->db->getResult("select  id,name from tbl_ca_subcategory order by name ",true);
		//$this->pr($catArray);	
		if(is_array($groupArray) > 0){ 
			$ShowList = array();
			$ShowList['']="Select";
			foreach($groupArray as $data){
				$ShowList[$data['id']]	=	$data['name'];
			}
		}
	return $ShowList;	
	
	}
	
	
		function getEvents()
	{
		$groupArray	=	$this->db->getResult("select  id,name from tbl_ca_action_event_type order by name ",true);
		//$this->pr($catArray);	
		if(is_array($groupArray) > 0){ 
			$ShowList = array();
			$ShowList['']="Select";
			foreach($groupArray as $data){
				$ShowList[$data['id']]	=	$data['name'];
			}
		}
	return $ShowList;	
	
	}
	
		
		function getParentUser($id)
		{
			$catArray	=	$this->db->getResult("select u.parent from tbl_users u where u.id = '".$id."'  and u.status='1' ",true);	
	
		if($catArray){
			
			foreach($catArray as $data){	
					if($data['parent'] !='0')
					{	
						$this->finalArray[] = $data['parent'];
						 $this->getParentUser($data['parent']);
					}
			}
			
		}
		return $this->finalArray;
		
		}
function getLevel($key)
{
			$catArray	=	$this->db->getResult("select * from tbl_level ",true);	
	
		if($catArray){
		return $catArray[$key];
		}
}
function getChildUsers($id)		
{
$userArray=$this->db->getResult("select count(u.id) as users from tbl_users u  where u.parent = '$id'  and u.status='1'",true);
if($userArray){
		return $userArray[0];
		}
}		

function GetChildReferals($id)		
{
	 
		for($i=1; $i<=$this->siteconfig->site_user_level; $i++)
		{ if($id!='')
			{$data = $this->GetChildReferals2($id,$i);
			 
			$id = $data['ids'] ;
			$returnData[] = $data;
			}
		}
		
 
	return $returnData;
}



function GetChildReferals2($id,$level)		
{
// echo $id;
	if($level<=$this->siteconfig->site_user_level)
	{
	//	echo "select count(u.id) as total , group_concat(u.id) as ids from tbl_users u  where u.parent IN ($id)  and u.status='1'";
		$userArray=$this->db->getResult("select count(u.id) as total , group_concat(u.id) as ids from tbl_users u  where u.parent IN ($id)  and u.status='1'");
//	$this->pr($userArray);
	}
		return $userArray;
}



		
function GetChildReferalsusers($id,$level,$orderBy)
	{
		
		for($i=$level; $i<=$this->siteconfig->site_user_level; $i++)
		{ if($id!='')
		{
				$data = $this->GetChildReferals3($id,$i,$orderBy);
				//$this->pr($data);
				$id = $data['ids'] ;
				$returnData[] = $data;
			}
		}
		
 
	return $returnData;
	
	}
function GetChildReferals3($id,$level,$orderBy)		
{
 
	if($level<=$this->siteconfig->site_user_level)
	{
	//	echo "select u.id from tbl_users u  where u.parent IN ($id)  and u.status='1' order by dateAdded  ASC";
		$userArray1=$this->db->getResult("select count(u.id) as total, group_concat(u.id) as ids  from tbl_users u  where u.parent IN ($id)  and u.status='1'");
		$userArray2	=$this->db->getResult("select u.id from tbl_users u  where u.parent IN ($id)  and u.status='1' order by dateAdded  ASC");
		$userArray=$userArray1;
		$userArray['users']=$userArray2;
		//$this->pr($userArray2);

	}
		return $userArray;

}
	
function getRefferedUserDetails($userId)
{
	
 if(empty($userId)){
		 	return array();
		 }	
		// echo "SELECT U.*,U.name as fname, DATE_FORMAT(dateAdded,'%a %b %e %Y %r') as joinDate  FROM `tbl_users` U where U.id = '".$userId."'  AND U.status = '1' ";exit;
		 $userData = $this->db->getResult("SELECT U.*, DATE_FORMAT(dateAdded,'%a %b %e %Y %r') as joinDate  FROM `tbl_users` U where U.id = '".$userId."'  AND U.status = '1' ");	
		$userData1=$this->db->getResult("select count(u.id) as total from tbl_users u  where u.parent ='".$userId."'  and u.status='1'");
	 $userData['totalChild']=	$userData1['total'];	
		return $userData;
}	

 function getUserDetails($userId)	{
		 if(empty($userId)){
		 	return array();
		 }	
		// echo "SELECT U.*,U.name as fname, DATE_FORMAT(dateAdded,'%a %b %e %Y %r') as joinDate  FROM `tbl_users` U where U.id = '".$userId."'  AND U.status = '1' ";exit;
		 $userData = $this->db->getResult(
		 "select A.*,c1.name as billingCityName, c2.name as shippingCityName ,s1.name as billingStateName
		,s2.name as shippingStateName,CO1.name as billingCountryName,CO2.name as shippingCountryName from tbl_users A
		left join tbl_cities c1 on c1.id=A.billingCity
		left join tbl_cities c2 on c2.id=A.shippingCity
		left join tbl_states s1 on s1.id=A.billingState
		left join tbl_states s2 on s2.id=A.shippingState
		left join tbl_countries CO1 on CO1.id=A.billingCountry
		left join tbl_countries CO2 on CO2.id=A.shippingCountry
		  where A.id = '".$userId."' AND A.status = '1' ");	
		return $userData;
	}	

public function getCartItems(){		
			$sessionId = session_id();	
			 $strSqlCart = " select *, (price*quantity) as lineTotal from tbl_cart   where sessionId = '".$sessionId."'  ";			
			$cartData = $this->db->getResult($strSqlCart, true);
			return $cartData;
			
		}

	
		function getCheckoutDetails(){
		
		$cartItems = 	$this->getCartItems();
		$orderTotal = 0;
		$cartTotal = 0;
		$shippingTotal = 0;
		
		if(is_array($cartItems) ){
			
				foreach($cartItems as $key=>$data){
					$cartTotal 		= $cartTotal+ ($data['quantity']*$data['price']);					
					
				}
			
		}
				$sessionId = session_id();
//		 $shippingTotal=$this->getshippingcharges();
	
		$checkoutData['cart_total'] = $cartTotal;
		$checkoutData['shipping_total'] = $shippingTotal;
		$checkoutData['order_total'] = $shippingTotal+$cartTotal;
		return $checkoutData;
		//$this->pr($checkoutData);
	}
	
	
		function clearCartSessionData()
		{
		unset($_SESSION['User']['order']['id']);	
		$strDelete = "delete from tbl_cart where sessionId ='".session_id()."'";
		$this->db->query($strDelete);
		return true;
		
	    }
		
function object_2_array($result) 
{ 
    $array = array(); 
    foreach ($result as $key=>$value) 
    { 
        if (is_object($value) || is_array($value)) 
        { 
            $array[$key]=$this->object_2_array($value); 
        } 
        else 
        { 
            $array[$key]=$value; 
        } 
    } 
    return $array; 
}
	

 function getPoint($price)
	 {
		  $totalprice=$price;
		
		$query=$this->db->getResult("SELECT * From tbl_pointvalue WHERE $totalprice BETWEEN min_value AND max_value");
		return $query['pointvalue'];
		 
	 }	
	 
	 
	 function getTypes(){
		
		 $sql="SELECT code,name FROM tbl_index_types WHERE status='1' order by name desc ";
		  
		  $get_options = $this->db->getResult($sql,true);
	//$this->pr($get_options,true);
	if ($get_options > 0) {
		foreach($get_options as $value) {
		$array[$value['code']] = $value['name'];
		}
	}
	
		return $array;  

	}
	
	 function getIndexes(){
		
		 $sql="SELECT id,name FROM tbl_indxx WHERE status='1' ";
		  
		  $get_options = $this->db->getResult($sql,true);
	//$this->pr($get_options,true);
	if ($get_options > 0) {
		foreach($get_options as $value) {
		$array[$value['id']] = $value['name'];
		}
	}
	
		return $array;  

	}
	
	function getCommodityIndexesNew(){
	 $sql="SELECT id,name,code FROM tbl_commodity_ticker WHERE status='1'  and dbstatus='1' order by name asc";
		  
		  $get_options = $this->db->getResult($sql,true);
	//$this->pr($get_options,true);
	
	$array[]="Select Commodity  Index";
	if ($get_options > 0) {
		foreach($get_options as $value) {
		$array[$value['id']] = $value['name']." (".$value['code'].")";
		}
	}
	
		return $array;  
	}
	
	
		 function getIndexesNew(){
		
		 $sql="SELECT id,name,code FROM tbl_indxx WHERE status='1' order by name asc ";
		  
		  $get_options = $this->db->getResult($sql,true);
	//$this->pr($get_options,true);
	
	$array[]="Select Index";
	if ($get_options > 0) {
		foreach($get_options as $value) {
		$array[$value['id']] = $value['name']." (".$value['code'].")";
		}
	}
	
		return $array;  

	}
	function getCashIndex(){
		 $sql="SELECT id,name,isin FROM tbl_cash_index WHERE status='1' order by name asc ";
		  
		  $get_options = $this->db->getResult($sql,true);
	//$this->pr($get_options,true);
	
	$array[]="Select Cash Index";
	if ($get_options > 0) {
		foreach($get_options as $value) {
		$array[$value['id']] = $value['name']." (".$value['isin'].")";
		}
	}
	
		return $array;  

	
	}
	
	
	
	 function getTempIndexes(){
		
		 $sql="SELECT id,name FROM tbl_indxx_temp WHERE status='1' ";
		  
		  $get_options = $this->db->getResult($sql,true);
	//$this->pr($get_options,true);
	if ($get_options > 0) {
		foreach($get_options as $value) {
		$array[$value['id']] = $value['name'];
		}
	}
	
		return $array;  

	}
	
	
	function getRunningIndexes(){
		
		 $sql="SELECT id,name FROM tbl_indxx WHERE status='1' ";
		  
		  $get_options = $this->db->getResult($sql,true);
	//$this->pr($get_options,true);
	if ($get_options > 0) {
		foreach($get_options as $value) {
		$array[$value['id']] = $value['name'];
		}
	}
	
		return $array;  

	}
	
	
		 function getCalendarZone(){
		
		 $sql="SELECT id,name FROM tbl_calendarzone where 1=1 ";
		  
		  $get_options = $this->db->getResult($sql,true);
	//$this->pr($get_options,true);
	if ($get_options > 0) {
		foreach($get_options as $value) {
		$array[$value['id']] = $value['name'];
		}
	}
	
		return $array;  

	}
	
	
	 function getIndex($id){
		
		 $sql="SELECT id,name FROM tbl_indxx WHERE id='".$id."' ";
		  
		  $get_options = $this->db->getResult($sql,true);
	//$this->pr($get_options,true);
	if ($get_options > 0) {
		foreach($get_options as $value) {
		$array[$value['id']] = $value['name'];
		}
	}
	
		return $array;  

	}
	
	
	 function getUsers(){
		
		 $sql="SELECT code,name FROM tbl_user_types WHERE status='1' ";
		  
		  $get_options = $this->db->getResult($sql,true);
	//$this->pr($get_options,true);
	if ($get_options > 0) {
		foreach($get_options as $value) {
		$array[$value['code']] = $value['name'];
		}
	}
	
	
		return $array;  

	}
	
	 function getUserName($id){
		
		 $sql="SELECT id,name FROM tbl_ca_user WHERE id='".$id."' ";
		  
		  $get_options = $this->db->getResult($sql,true);
	//$this->pr($get_options,true);
	if ($get_options > 0) {
		foreach($get_options as $value) {
		$array[$value['id']] = $value['name'];
		}
	}
	
	
		return $array;  

	}
	 
	 
	  function getAllUsers(){
		
		 $sql="SELECT id,name FROM tbl_ca_user WHERE status='1' ";
		  
		  $get_options = $this->db->getResult($sql,true);
	//$this->pr($get_options,true);
	if ($get_options > 0) {
		foreach($get_options as $value) {
		$array[$value['id']] = $value['name'];
		}
	}
	
	
		return $array;  

	}
	 
	 
	 
	  function getClientName($id){
		
		 $sql="SELECT id,name FROM tbl_ca_client WHERE id='".$id."' ";
		  
		  $get_options = $this->db->getResult($sql,true);
	//$this->pr($get_options,true);
	if ($get_options > 0) {
		foreach($get_options as $value) {
		$array[$value['id']] = $value['name'];
		}
	}
	
	
		return $array;  

	}
	 
	 
	  function getAllClients(){
		
		 $sql="SELECT id,name FROM tbl_ca_client WHERE status='1' ";
		  
		  $get_options = $this->db->getResult($sql,true);
	//$this->pr($get_options,true);
	if ($get_options > 0) {
		foreach($get_options as $value) {
		$array[$value['id']] = $value['name'];
		}
	}
	
	
		return $array;  

	}
	 
	 
	 
	
function toAscii($str, $replace=array(), $delimiter='-') {
	 @setlocale(LC_ALL, 'en_US.UTF8');
	if( !empty($replace) ) {
		$str = str_replace((array)$replace, ' ', $str);
	}

	$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
	$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
	$clean = strtolower(trim($clean, '-'));
	$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

	return $clean;
}	
function getmainMenu($pageType){
	 $sql =  'SELECT id, name from tbl_menucategory where '.$pageType.' IN (type)';
	//$sql .=  ' order by name asc ';
	$get_options = $this->db->getResult($sql,true);
	//$this->pr($get_options,true);
	if ($get_options > 0) {
		foreach($get_options as $value) {
		$array[$value['id']] = $value['name'];
		}
	}
	
	return $array;
	}

		 function GetChildPages($section='',$parentId=0)	{

		$catArray	=	$this->db->getResult("select p.id, p.parent, p.name,(select count(c.id) from tbl_pages c  where c.parent = p.id AND c.mainmenu = '".$section."' and c.status='1') chlids  from tbl_pages p where p.parent = $parentId AND p.mainmenu = '".$section."' and p.status='1' and p.onmenu='0' order by p.id  ",true);	
		 
		if($catArray){
			$i=0;
			 
			foreach($catArray as $data){	
				//$this->pr($data);
					$categoryArray[$i]['id'] = $data['id'];
					$categoryArray[$i]['name'] = $data['name'];
					if ($data['parent']){
					$categoryArray[$i]['indxx']=$this->getIndxx($data['id']);
					}
				
				
					if($data['chlids']>0)
					{	
						$categoryArray[$i]['childCount'] = $data['chlids'];
						$categoryArray[$i]['childs'] = $this->GetChildPages($section,$data['id']);
					}
					 
					$i++;
				 
			}
		}
		//print_r($categoryArray);
		return $categoryArray;
	}
	
	
	function getCurrencyPrice($date)
{
		$currencyarray=array();
		$currency=$this->db->getResult("select *  from tbl_currency ");
		foreach($currency as $row)
		{		
	
				//print_r($row);
				$query2='Select * from tbl_curr_prices where curr_id="'.$row['id'].'" and date ="'.$date.'"';
				$res2=mysql_query($query2);
				if(mysql_num_rows($res2)>0)
				{
				$row2=mysql_fetch_assoc($res2);
				$currencyarray[$row['id']]=$row2['price'];
				$currencyarray[$row['localsymbol']]=$row2['price'];
				}
				
					
			}	
		$currencys=$this->db->getResult("select distinct(curr)  as cno from tbl_indxx ",true);
	//	$this->pr($currencys,true);
		
		foreach($currencys as $row)
		{		
	
				//print_r($row);
				$query2='Select * from tbl_currency where id="'.$row['cno'].'" ';
				$res2=mysql_query($query2);
				if(mysql_num_rows($res2)>0)
				{
				$row2=mysql_fetch_assoc($res2);
				$currencyarray[$row2['id']]=1;
				$currencyarray[$row2['localsymbol']]=1;
				}
				
					
			}	
			
			
			return $currencyarray;
		}

	
	function getIndxx($id){
		
		 return $this->db->getResult("SELECT id,name FROM tbl_chart WHERE parent ='$id' and status='1' ",true);

	}
	
	function getActiveCommodityTickerCount(){
$var=	$this->db->getResult("SELECT id FROM tbl_commodity_ticker WHERE status ='1' and dbstatus='1' ",true);
return count($var);

	}
	
	function checkHoliday($zone,$date)
	{

	 $holiday= $this->db->getResult("SELECT id FROM tbl_holidays WHERE zone_id ='$zone' and date='$date' ");
if(empty($holiday))
{
return true;
}else{
return false;
}

	}
	
	
	function getSecurtyPrices($isin,$curr,$indxxcurr,$date){
	//	echo $isin."=>".$curr."=>".$indxxcurr;
//exit;
	 $ca_value_query="SELECT price,curr FROM tbl_prices_local_curr where isin='".$isin."' and date='".$date."'";
		$ca_values=$this->db->getResult($ca_value_query,false,1);
//$this->pr($ca_values);
if(empty($ca_values))
{
echo "Prices Not Available for ISIN : ".$isin;
exit;
}

$returnArray=array();
		$returnArray['localprice']=0;
		$returnArray['currencyfactor']=0;
		$returnArray['calcprice']=0;
		
		if($indxxcurr){
		if($indxxcurr==$ca_values['curr'] && $indxxcurr==$curr)
		{
		$returnArray['localprice']=$ca_values['price'];
		$returnArray['currencyfactor']=1;
		$returnArray['calcprice']=$ca_values['price'];
		}
		elseif($curr!=$indxxcurr)
		{
			 $cfactor=$this->getPriceforCurrency($indxxcurr,$curr,$date,$id,$action_id);
			
		$returnArray['localprice']=$ca_values['price'];
		$returnArray['currencyfactor']=$cfactor;
		
		if(strcmp(strtoupper($indxxcurr.$curr),$indxxcurr.$curr)==0)
		$returnArray['calcprice']=$ca_values['price']/$cfactor;
		else
		$returnArray['calcprice']=$ca_values['price']/($cfactor*100);
		
		//$returnArray['calcprice']=$ca_values['price'];
				
		}
		}else{
		$returnArray['localprice']=$ca_values['price'];
		$returnArray['currencyfactor']=1;
		$returnArray['calcprice']=$ca_values['price'];
		}
		return $returnArray;
	}
	
	function getOfferPrices($id,$action_id,$ca_currency,$index_currency,$date,$indxxKey=0,$temp=0)
	{

//echo $date;
//exit;

if($temp){
	$ca_value_query="Select field_name,field_value,field_id from tbl_ca_values_user_edited_temp where ca_id='".$id."'  and ca_action_id='".$action_id."'  and indxx_id='".$indxxKey."'";
		$ca_values=$this->db->getResult($ca_value_query,true);
}else{
	$ca_value_query="Select field_name,field_value,field_id from tbl_ca_values_user_edited where ca_id='".$id."'  and ca_action_id='".$action_id."'  and indxx_id='".$indxxKey."'";
		$ca_values=$this->db->getResult($ca_value_query,true);

}
//echo $date;

if(empty($ca_values))
{

	$ca_value_query="Select field_name,field_value,field_id from tbl_ca_values where ca_id='".$id."'  and ca_action_id='".$action_id."' ";
		$ca_values=$this->db->getResult($ca_value_query,true);
		
}//	$this->pr($ca_values,true);
		
		$localprice=0;
		$localcurrency='';
		$finalPrice=0;
		
		$returnArray=array();
		$returnArray['op_value_local_price']=0;
		$returnArray['op_value_local_currency']=0;
		$returnArray['op_price_in_ca_currency']=0;
		$returnArray['op_price_index_currency']=0;
		
		if(!empty($ca_values))	
		{
			
			foreach($ca_values as $ca_value)
			{
			//$this->pr($ca_value);
			
			if($ca_value['field_name']=='CP_PX')
			{
			$localprice=$ca_value['field_value'];
			}
			if($ca_value['field_name']=='CP_CRNCY')
			{
			$localcurrency=$ca_value['field_value'];
			}
		
			
			
			}
		
		
		
		}	

//echo $localcurrency."=>".$localprice;
//exit;

	if($index_currency){	
	if($ca_currency==$index_currency && $index_currency==$localcurrency)
	{
//echo "deepak";
//exit;		

$returnArray['op_value_local_price']=$localprice;
		$returnArray['op_value_local_currency']=$localcurrency;
		$returnArray['op_price_in_ca_currency']=$localprice;
		$returnArray['op_price_index_currency']=$localprice;

		return $returnArray;
		
	//return $localprice;
	}
	else{
		
		if($ca_currency==$localcurrency)
		{
		$cfactor=$this->getPriceforCurrency($index_currency,$ca_currency,$date,$id,$action_id);
		
		if(strcmp(strtoupper($index_currency.$ca_currency),$index_currency.$ca_currency)==0)
		$priceinlocal=$localprice/$cfactor;
		else
		$priceinlocal= $localprice/($cfactor*100);
		
		$returnArray['op_value_local_price']=$localprice;
		$returnArray['op_value_local_currency']=$localcurrency;
		$returnArray['op_price_in_ca_currency']=$priceinlocal;
		$returnArray['op_price_index_currency']=$priceinlocal;
		
		return $returnArray;
		
		}else
		{	
		//		echo "deepak";
		//exit;

		//echo $index_currency."=>".$ca_currency."=>".$localcurrency;
		//exit;
		$cfactor=$this->getPriceforCurrency($index_currency,$ca_currency,$date,$id,$action_id);
		
		if(strcmp(strtoupper($index_currency.$ca_currency),$index_currency.$ca_currency)==0)
		$indxxCurrecnyPrice=$localprice/$cfactor;
		else
		$indxxCurrecnyPrice=$localprice/($cfactor*100);
			
			
			$cfactor_local=$this->getPriceforCurrency($ca_currency,$localcurrency,$date,$id,$action_id);
				if(strcmp(strtoupper($index_currency.$ca_currency),$index_currency.$ca_currency)==0)
			$localcurrencyprice=($localprice/$cfactor_local);
			else
				$localcurrencyprice=$localprice/($cfactor_local*100);
			$returnArray['op_value_local_price']=$localprice;
			$returnArray['op_value_local_currency']=$localcurrency;
			$returnArray['op_price_in_ca_currency']=$localcurrencyprice;
			$returnArray['op_price_index_currency']=$indxxCurrecnyPrice;
			return $returnArray;

			//echo $index_currency."=>".$ca_currency."=>".$localcurrency;
			//return 
		}//return "Currency Conversion Required.<br>";
	}
	}else{
	
		
		if($ca_currency==$localcurrency)
		{
		
		$returnArray['op_value_local_price']=$localprice;
		$returnArray['op_value_local_currency']=$localcurrency;
		$returnArray['op_price_in_ca_currency']=$localprice;
		$returnArray['op_price_index_currency']=$localprice;
		
		return $returnArray;
		
		}else
		{	
			
			
			$cfactor_local=$this->getPriceforCurrency($ca_currency,$localcurrency,$date,$id,$action_id);
				if(strcmp(strtoupper($localcurrency.$ca_currency),$localcurrency.$ca_currency)==0)
			$localcurrencyprice=($localprice/$cfactor_local);
			else
				$localcurrencyprice=$localprice/($cfactor_local*100);
			$returnArray['op_value_local_price']=$localprice;
			$returnArray['op_value_local_currency']=$localcurrency;
			$returnArray['op_price_in_ca_currency']=$localcurrencyprice;
			$returnArray['op_price_index_currency']=$localcurrencyprice;
			return $returnArray;

			//echo $index_currency."=>".$ca_currency."=>".$localcurrency;
			//return 
		}//return "Currency Conversion Required.<br>";
	
	}
			
	}
	
	
		function getCaPrices2($id,$action_id,$ca_currency,$index_currency,$date,$div_type=0,$indxxKey=0,$temp=0)
	{
if($temp)
{
	$ca_value_query="Select field_name,field_value,field_id from tbl_ca_values_user_edited_temp where ca_id='".$id."'  and ca_action_id='".$action_id."'  and indxx_id='".$indxxKey."'";
		$ca_values=$this->db->getResult($ca_value_query,true);

}
else
{	$ca_value_query="Select field_name,field_value,field_id from tbl_ca_values_user_edited where ca_id='".$id."'  and ca_action_id='".$action_id."'  and indxx_id='".$indxxKey."'";
		$ca_values=$this->db->getResult($ca_value_query,true);
}
//echo $date;



if(empty($ca_values))
{	$ca_value_query="Select field_name,field_value,field_id from tbl_ca_values where ca_id='".$id."'  and ca_action_id='".$action_id."' ";
		$ca_values=$this->db->getResult($ca_value_query,true);
}
		//$this->pr($_SESSION);
		//$this->pr($ca_values,true);
		$localprice=0;
		$localcurrency='';
		$finalPrice=0;
		$adjfactor=0;
		$dvdtype=0;
		$returnArray=array();
		$returnArray['ca_value_local_price']=0;
		$returnArray['CP_DVD_TYP']=0;
			$returnArray['CP_ADJ']=0;
		$returnArray['ca_value_local_currency']=0;
		$returnArray['ca_price_in_ca_currency']=0;
		$returnArray['ca_price_index_currency']=0;
		if($div_type==1){
		if(!empty($ca_values))	
		{
			
			foreach($ca_values as $ca_value)
			{
			//$this->pr($ca_value);
			
			if($ca_value['field_name']=='CP_NET_AMT')
			{
			$localprice=$ca_value['field_value'];
			}
			if($ca_value['field_name']=='CP_DVD_CRNCY')
			{
			$localcurrency=$ca_value['field_value'];
			}
			if($ca_value['field_name']=='CP_DVD_TYP')
			{
			$dvdtype=$ca_value['field_value'];
			}
		if($ca_value['field_name']=='CP_ADJ')
			{
			$adjfactor=$ca_value['field_value'];
			}
			
			
			}
		
		if($localprice==0)
		{
		foreach($ca_values as $ca_value)
			{
			//$this->pr($ca_value);
			
			if($ca_value['field_name']=='CP_GROSS_AMT')
			{
			$localprice=$ca_value['field_value'];
			}
			
			
			}
		}
		
		
		}	

		}
		else{
		
			
			foreach($ca_values as $ca_value)
			{
			//$this->pr($ca_value);
			
			if($ca_value['field_name']=='CP_GROSS_AMT')
			{
			$localprice=$ca_value['field_value'];
			}
			if($ca_value['field_name']=='CP_DVD_CRNCY')
			{
			$localcurrency=$ca_value['field_value'];
			}
			if($ca_value['field_name']=='CP_DVD_TYP')
			{
			$dvdtype=$ca_value['field_value'];
			}
		if($ca_value['field_name']=='CP_ADJ')
			{
			$adjfactor=$ca_value['field_value'];
			}
			
			
			}
		
		if($localprice==0)
		{
		foreach($ca_values as $ca_value)
			{
			//$this->pr($ca_value);
			
			if($ca_value['field_name']=='CP_NET_AMT')
			{
			$localprice=$ca_value['field_value'];
			}
			
			
			}
		}
		
		
		
		}
		
		
		if($index_currency)
		{
		
	if($index_currency==$localcurrency)
	{
//echo "deepak";
//exit;		

$returnArray['ca_value_local_price']=$localprice;
	$returnArray['CP_DVD_TYP']=$dvdtype;
	$returnArray['CP_ADJ']=$adjfactor;
		$returnArray['ca_value_local_currency']=$localcurrency;
		$returnArray['ca_price_in_ca_currency']=$localprice;
		$returnArray['ca_price_index_currency']=$localprice;

		return $returnArray;
		
	//return $localprice;
	}
	else{
		$cfactor_local=$this->getPriceforCurrency($index_currency,$localcurrency,$date,$id,$action_id);
		if(strcmp(strtoupper($index_currency.$localcurrency),$index_currency.$localcurrency)==0)
			$localcurrencyprice=$localprice/$cfactor_local;
			else
				$localcurrencyprice=$localprice/($cfactor_local*100);
			$returnArray['ca_value_local_price']=$localprice;
			$returnArray['ca_value_local_currency']=$localcurrency;
			$returnArray['CP_DVD_TYP']=$dvdtype;
		$returnArray['CP_ADJ']=$adjfactor;

			
			$returnArray['ca_price_index_currency']=$localcurrencyprice;
			$returnArray['ca_price_in_ca_currency']=$localcurrencyprice;
		
			return $returnArray;
		}
		}	else{
		
		if($ca_currency==$localcurrency)
		{
		$returnArray['ca_value_local_price']=$localprice;
		$returnArray['CP_DVD_TYP']=$dvdtype;
		$returnArray['CP_ADJ']=$adjfactor;

		$returnArray['ca_value_local_currency']=$localcurrency;
		$returnArray['ca_price_in_ca_currency']=$localprice;
		$returnArray['ca_price_index_currency']=$localprice;
		
		return $returnArray;
		
		}else
		{	
				$cfactor_local=$this->getPriceforCurrency($ca_currency,$localcurrency,$date,$id,$action_id);
				if(strcmp(strtoupper($localcurrency.$ca_currency),$localcurrency.$ca_currency)==0)
			$localcurrencyprice=$localprice/$cfactor_local;
			else
				$localcurrencyprice=$localprice/($cfactor_local*100);
			$returnArray['ca_value_local_price']=$localprice;
			$returnArray['ca_value_local_currency']=$localcurrency;
			$returnArray['CP_DVD_TYP']=$dvdtype;
		$returnArray['CP_ADJ']=$adjfactor;

			
			$returnArray['ca_price_index_currency']=$localcurrencyprice;
			$returnArray['ca_price_in_ca_currency']=$localcurrencyprice;
		
			return $returnArray;

			//echo $index_currency."=>".$ca_currency."=>".$localcurrency;
			//return 
		}//return "Currency Conversion Required.<br>";
	}

			
	}
	
		function getCaPrices($id,$action_id,$ca_currency,$index_currency,$date,$div_type=0,$indxxKey=0)
	{

	$ca_value_query="Select field_name,field_value,field_id from tbl_ca_values_user_edited where ca_id='".$id."'  and ca_action_id='".$action_id."'  and indxx_id='".$indxxKey."'";
		$ca_values=$this->db->getResult($ca_value_query,true);

//echo $date;

if(empty($ca_values))
{	$ca_value_query="Select field_name,field_value,field_id from tbl_ca_values where ca_id='".$id."'  and ca_action_id='".$action_id."' ";
		$ca_values=$this->db->getResult($ca_value_query,true);
}
		//$this->pr($_SESSION);
		
		$localprice=0;
		$localcurrency='';
		$finalPrice=0;
		$adjfactor=0;
		$dvdtype=0;
		$returnArray=array();
		$returnArray['ca_value_local_price']=0;
		$returnArray['CP_DVD_TYP']=0;
			$returnArray['CP_ADJ']=0;
		$returnArray['ca_value_local_currency']=0;
		$returnArray['ca_price_in_ca_currency']=0;
		$returnArray['ca_price_index_currency']=0;
		if($div_type==1){
		if(!empty($ca_values))	
		{
			
			foreach($ca_values as $ca_value)
			{
			//$this->pr($ca_value);
			
			if($ca_value['field_name']=='CP_NET_AMT')
			{
			$localprice=$ca_value['field_value'];
			}
			if($ca_value['field_name']=='CP_DVD_CRNCY')
			{
			$localcurrency=$ca_value['field_value'];
			}
			if($ca_value['field_name']=='CP_DVD_TYP')
			{
			$dvdtype=$ca_value['field_value'];
			}
		if($ca_value['field_name']=='CP_ADJ')
			{
			$adjfactor=$ca_value['field_value'];
			}
			
			
			}
		
		if($localprice==0)
		{
		foreach($ca_values as $ca_value)
			{
			//$this->pr($ca_value);
			
			if($ca_value['field_name']=='CP_GROSS_AMT')
			{
			$localprice=$ca_value['field_value'];
			}
			
			
			}
		}
		
		
		}	

		}
		else{
		
			
			foreach($ca_values as $ca_value)
			{
			//$this->pr($ca_value);
			
			if($ca_value['field_name']=='CP_GROSS_AMT')
			{
			$localprice=$ca_value['field_value'];
			}
			if($ca_value['field_name']=='CP_DVD_CRNCY')
			{
			$localcurrency=$ca_value['field_value'];
			}
			if($ca_value['field_name']=='CP_DVD_TYP')
			{
			$dvdtype=$ca_value['field_value'];
			}
		if($ca_value['field_name']=='CP_ADJ')
			{
			$adjfactor=$ca_value['field_value'];
			}
			
			
			}
		
		if($localprice==0)
		{
		foreach($ca_values as $ca_value)
			{
			//$this->pr($ca_value);
			
			if($ca_value['field_name']=='CP_NET_AMT')
			{
			$localprice=$ca_value['field_value'];
			}
			
			
			}
		}
		
		
		
		}
		
		
		if($index_currency)
		{
		
	if($ca_currency==$index_currency && $index_currency==$localcurrency)
	{
//echo "deepak";
//exit;		

$returnArray['ca_value_local_price']=$localprice;
	$returnArray['CP_DVD_TYP']=$dvdtype;
	$returnArray['CP_ADJ']=$adjfactor;
		$returnArray['ca_value_local_currency']=$localcurrency;
		$returnArray['ca_price_in_ca_currency']=$localprice;
		$returnArray['ca_price_index_currency']=$localprice;

		return $returnArray;
		
	//return $localprice;
	}
	else{
		
		if($ca_currency==$localcurrency)
		{
		$cfactor=$this->getPriceforCurrency($index_currency,$ca_currency,$date,$id,$action_id);
		
		if(strcmp(strtoupper($index_currency.$ca_currency),$index_currency.$ca_currency)==0)
		$priceinlocal=$localprice/$cfactor;
		else
		$priceinlocal= $localprice/($cfactor*100);
		
		$returnArray['ca_value_local_price']=$localprice;
		$returnArray['CP_DVD_TYP']=$dvdtype;
		$returnArray['CP_ADJ']=$adjfactor;

		$returnArray['ca_value_local_currency']=$localcurrency;
		$returnArray['ca_price_in_ca_currency']=$priceinlocal;
		$returnArray['ca_price_index_currency']=$priceinlocal;
		
		return $returnArray;
		
		}
		elseif($ca_currency!=$localcurrency && $index_currency==$localcurrency ){
		//echo "bajpai";
		
		$cfactor=$this->getPriceforCurrency($ca_currency,$localcurrency,$date,$id,$action_id);
		
		if(strcmp(strtoupper($index_currency.$ca_currency),$index_currency.$ca_currency)==0)
		$priceinlocal=$localprice/$cfactor;
		else
		$priceinlocal= $localprice/($cfactor*100);
		
		$returnArray['ca_value_local_price']=$localprice;
		$returnArray['CP_DVD_TYP']=$dvdtype;
		$returnArray['CP_ADJ']=$adjfactor;

		$returnArray['ca_value_local_currency']=$localcurrency;
		$returnArray['ca_price_in_ca_currency']=$priceinlocal;
		$returnArray['ca_price_index_currency']=$localprice;
		
		return $returnArray;
		
		
		}
		else
		{	
		//echo "deepak";
		//exit;

		//echo $index_currency."=>".$ca_currency."=>".$localcurrency;
		//exit;
	//echo $indxxCurrecnyPrice;		
			//echo $ca_currency;
			$cfactor_local=$this->getPriceforCurrency($ca_currency,$localcurrency,$date,$id,$action_id);
				if(strcmp(strtoupper($index_currency.$ca_currency),$index_currency.$ca_currency)==0)
			$localcurrencyprice=$localprice/$cfactor_local;
			else
				$localcurrencyprice=$localprice/($cfactor_local*100);
		
		
		
		 $cfactor=$this->getPriceforCurrency($index_currency,$ca_currency,$date,$id,$action_id);
		
		if(strcmp(strtoupper($index_currency.$ca_currency),$index_currency.$ca_currency)==0)
		$indxxCurrecnyPrice=$localcurrencyprice/$cfactor;
		else
		$indxxCurrecnyPrice=$localcurrencyprice/($cfactor*100);
	
			$returnArray['ca_value_local_price']=$localprice;
			$returnArray['ca_value_local_currency']=$localcurrency;
			$returnArray['CP_DVD_TYP']=$dvdtype;
		$returnArray['CP_ADJ']=$adjfactor;

			
			if($index_currency==$ca_currency)
			{
			$returnArray['ca_price_index_currency']=$indxxCurrecnyPrice;
			}
			else
			$returnArray['ca_price_index_currency']=$indxxCurrecnyPrice;
			$returnArray['ca_price_in_ca_currency']=$localcurrencyprice;
		
			return $returnArray;

			//echo $index_currency."=>".$ca_currency."=>".$localcurrency;
			//return 
		}//return "Currency Conversion Required.<br>";
	}
		}	else{
		
		if($ca_currency==$localcurrency)
		{
		$returnArray['ca_value_local_price']=$localprice;
		$returnArray['CP_DVD_TYP']=$dvdtype;
		$returnArray['CP_ADJ']=$adjfactor;

		$returnArray['ca_value_local_currency']=$localcurrency;
		$returnArray['ca_price_in_ca_currency']=$localprice;
		$returnArray['ca_price_index_currency']=$localprice;
		
		return $returnArray;
		
		}else
		{	
				$cfactor_local=$this->getPriceforCurrency($ca_currency,$localcurrency,$date,$id,$action_id);
				if(strcmp(strtoupper($localcurrency.$ca_currency),$localcurrency.$ca_currency)==0)
			$localcurrencyprice=$localprice/$cfactor_local;
			else
				$localcurrencyprice=$localprice/($cfactor_local*100);
			$returnArray['ca_value_local_price']=$localprice;
			$returnArray['ca_value_local_currency']=$localcurrency;
			$returnArray['CP_DVD_TYP']=$dvdtype;
		$returnArray['CP_ADJ']=$adjfactor;

			
			$returnArray['ca_price_index_currency']=$localcurrencyprice;
			$returnArray['ca_price_in_ca_currency']=$localcurrencyprice;
		
			return $returnArray;

			//echo $index_currency."=>".$ca_currency."=>".$localcurrency;
			//return 
		}//return "Currency Conversion Required.<br>";
	}

			
	}
	
	  
  function getPriceforCurrency($ticker1,$ticker2,$date,$id=0,$action_id=0){
$query="SELECT price  FROM `tbl_curr_prices` WHERE `currencyticker` LIKE '".strtoupper($ticker1.$ticker2)."%' AND `date` = '$date'";
	$res=mysql_query($query);
if(mysql_num_rows($res)>0)
{
$row=mysql_fetch_assoc($res);
if($row['price'])
return $row['price'];
else
{
	return $this->getPriceforCurrency2($ticker1,$ticker2,$date,$id,$action_id);
}
}
else
{
return	$this->getPriceforCurrency2($ticker1,$ticker2,$date,$id,$action_id);
	
}



}
 function getPriceforCurrency2($ticker1,$ticker2,$date,$id,$action_id){
	$query="SELECT price  FROM `tbl_curr_prices` WHERE `currencyticker` LIKE '".strtoupper($ticker2.$ticker1)."%' AND `date` = '$date'";
	$res=mysql_query($query);
if(mysql_num_rows($res)>0)
{
$row=mysql_fetch_assoc($res);
if($row['price'])
return 1/$row['price'];
else
{
echo "Price Not Available for Currency Ticker ".$ticker2.$ticker1." of date.".$date."<br>".$id."=>".$action_id ;
exit;
}
}
else
{
echo "Price Not Available for Currency Ticker ".$ticker2.$ticker1." of date.".$date."<br>".$id."=>".$action_id ;
exit;
}



}
function getAcionValueName($field_name,$field_value){
$ca_value_query="Select value from tbl_ca_action_fields_values where field_name='".$field_name."'  and data='".$field_value."' ";
		$ca_values=$this->db->getResult($ca_value_query);
	return $ca_values['value'];
}

function getCa($id,$action_id){
	$ca_value_query="Select field_name,field_value,field_id from tbl_ca_values where ca_id='".$id."'  and ca_action_id='".$action_id."' ";
		$ca_values=$this->db->getResult($ca_value_query,true);
	return $ca_values;
}
	
	function getcpratio($id,$action_id,$indxxKey=0,$temp=0)
	{
	
	if($temp)
{		$ca_value_query="Select field_name,field_value,field_id from tbl_ca_values_user_edited_temp where ca_id='".$id."'  and ca_action_id='".$action_id."'  and indxx_id='".$indxxKey."'";
		$ca_values=$this->db->getResult($ca_value_query,true);
}else{
$ca_value_query="Select field_name,field_value,field_id from tbl_ca_values_user_edited where ca_id='".$id."'  and ca_action_id='".$action_id."'  and indxx_id='".$indxxKey."'";
		$ca_values=$this->db->getResult($ca_value_query,true);
}
//echo $date;

if(empty($ca_values))
{

		$ca_value_query="Select field_name,field_value,field_id from tbl_ca_values where ca_id='".$id."'  and ca_action_id='".$action_id."' ";
		$ca_values=$this->db->getResult($ca_value_query,true);
}//$this->pr($ca_values,true);
	
		$adj=0;
	if(!empty($ca_values))
	{
	foreach ($ca_values as $ca_value)
	{
		if($ca_value['field_name']=='CP_RATIO')
			{
			$adj=$ca_value['field_value'];
			}
	}
	}
	if($adj==0)
	{
	//echo "Adjustement Ammount is Not Available ";
	//exit;
	return 0;
	
	}
	else{
	return $adj;
	}
	
	
	}
	
	
	
		function getoldName($id,$action_id,$indxxKey=0)
	{
				$ca_value_query="Select field_name,field_value,field_id from tbl_ca_values_user_edited where ca_id='".$id."'  and ca_action_id='".$action_id."'  and indxx_id='".$indxxKey."'";
		$ca_values=$this->db->getResult($ca_value_query,true);

//echo $date;

if(empty($ca_values))
{
$ca_value_query="Select field_name,field_value,field_id from tbl_ca_values where ca_id='".$id."'  and ca_action_id='".$action_id."' ";
		$ca_values=$this->db->getResult($ca_value_query,true);
}//$this->pr($ca_values,true);
	
		$adj=0;
	if(!empty($ca_values))
	{
	foreach ($ca_values as $ca_value)
	{
		if($ca_value['field_name']=='CP_OLD_NAME')
			{
			$adj=$ca_value['field_value'];
			}
	}
	}
	if($adj=='')
	{
	//echo "Old Name Not Available ";
	//exit;
	return false;
	
	}
	else{
	return $adj;
	}
	
	
	}
	
		function getoldISIN($id,$action_id,$indxxKey=0)
	{
				$ca_value_query="Select field_name,field_value,field_id from tbl_ca_values_user_edited where ca_id='".$id."'  and ca_action_id='".$action_id."'  and indxx_id='".$indxxKey."'";
		$ca_values=$this->db->getResult($ca_value_query,true);

//echo $date;

if(empty($ca_values))
{	$ca_value_query="Select field_name,field_value,field_id from tbl_ca_values where ca_id='".$id."'  and ca_action_id='".$action_id."' ";
		$ca_values=$this->db->getResult($ca_value_query,true);
}//$this->pr($ca_values,true);
	
		$adj=0;
	if(!empty($ca_values))
	{
	foreach ($ca_values as $ca_value)
	{
		if($ca_value['field_name']=='CP_OLD_ISIN')
			{
			$adj=$ca_value['field_value'];
			}
	}
	}
	if($adj=='')
	{
	//echo "New ISIN Not Available ";
	//exit;
	return false;
	
	}
	else{
	return $adj;
	}
	
	
	}
	
	
	function getnewISIN($id,$action_id,$indxxKey=0)
	{
				$ca_value_query="Select field_name,field_value,field_id from tbl_ca_values_user_edited where ca_id='".$id."'  and ca_action_id='".$action_id."'  and indxx_id='".$indxxKey."'";
		$ca_values=$this->db->getResult($ca_value_query,true);

//echo $date;

if(empty($ca_values))
{	$ca_value_query="Select field_name,field_value,field_id from tbl_ca_values where ca_id='".$id."'  and ca_action_id='".$action_id."' ";
		$ca_values=$this->db->getResult($ca_value_query,true);
}//$this->pr($ca_values,true);
	
		$adj=0;
	if(!empty($ca_values))
	{
	foreach ($ca_values as $ca_value)
	{
		if($ca_value['field_name']=='CP_NEW_ISIN')
			{
			$adj=$ca_value['field_value'];
			}
	}
	}
	if($adj=='')
	{
	//echo "New ISIn Not Available ";
	//exit;
	return false;
	
	}
	else{
	return $adj;
	}
	
	
	}
	
	function getnewName($id,$action_id,$indxxKey=0)
	{
			$ca_value_query="Select field_name,field_value,field_id from tbl_ca_values_user_edited where ca_id='".$id."'  and ca_action_id='".$action_id."'  and indxx_id='".$indxxKey."'";
		$ca_values=$this->db->getResult($ca_value_query,true);

//echo $date;

if(empty($ca_values))
{		$ca_value_query="Select field_name,field_value,field_id from tbl_ca_values where ca_id='".$id."'  and ca_action_id='".$action_id."' ";
		$ca_values=$this->db->getResult($ca_value_query,true);
}//$this->pr($ca_values,true);
	
		$adj=0;
	if(!empty($ca_values))
	{
	foreach ($ca_values as $ca_value)
	{
		if($ca_value['field_name']=='CP_NEW_NAME')
			{
			$adj=$ca_value['field_value'];
			}
	}
	}
	if($adj=='')
	{
	//echo "New name Not Available ";
	//exit;
	 return false;
	
	}
	else{
	return $adj;
	}
	
	
	}
	
	
function getAdjFactorforSplit($id,$action_id,$indxxKey,$temp=0)
	{
		if($temp)
	{	
		$ca_value_query="Select field_name,field_value,field_id from tbl_ca_values_user_edited_temp where ca_id='".$id."'  and ca_action_id='".$action_id."'  and indxx_id='".$indxxKey."'";
		$ca_values=$this->db->getResult($ca_value_query,true);
	}
	else{
	$ca_value_query="Select field_name,field_value,field_id from tbl_ca_values_user_edited where ca_id='".$id."'  and ca_action_id='".$action_id."'  and indxx_id='".$indxxKey."'";
		$ca_values=$this->db->getResult($ca_value_query,true);
	}
//echo $date;

if(empty($ca_values))
{	$ca_value_query="Select field_name,field_value,field_id from tbl_ca_values where ca_id='".$id."'  and ca_action_id='".$action_id."' ";
		$ca_values=$this->db->getResult($ca_value_query,true);
}//$this->pr($ca_values,true);
	
		$adj=0;
	if(!empty($ca_values))
	{
	foreach ($ca_values as $ca_value)
	{
		if($ca_value['field_name']=='CP_ADJ')
			{
			$adj=$ca_value['field_value'];
			}
	}
	}
	if($adj==0)
	{
	//echo "Adjustement Ammount is Not Available ";
	//exit;
	return 0;
	}
	else{
	return $adj;
	}
	
	
	}	
	
function getAdjFactorforDvdStock($id,$action_id,$indxxKey=0,$temp=0)
	{

if($temp){
	$ca_value_query="Select field_name,field_value,field_id from tbl_ca_values_user_edited_temp where ca_id='".$id."'  and ca_action_id='".$action_id."'  and indxx_id='".$indxxKey."'";
		$ca_values=$this->db->getResult($ca_value_query,true);
}else{
	$ca_value_query="Select field_name,field_value,field_id from tbl_ca_values_user_edited where ca_id='".$id."'  and ca_action_id='".$action_id."'  and indxx_id='".$indxxKey."'";
		$ca_values=$this->db->getResult($ca_value_query,true);
}
//echo $date;

if(empty($ca_values))
{	$ca_value_query="Select field_name,field_value,field_id from tbl_ca_values where ca_id='".$id."'  and ca_action_id='".$action_id."' ";
		$ca_values=$this->db->getResult($ca_value_query,true);
}//$this->pr($ca_values,true);
	
		$adj=0;
	if(!empty($ca_values))
	{
	foreach ($ca_values as $ca_value)
	{
		if($ca_value['field_name']=='CP_AMT')
			{
			$adj=$ca_value['field_value'];
			}
	}
	}
	if($adj==0)
	{
	//echo "Adjustement Ammount is Not Available ";
	//exit;
	
	return 0;
	}
	else{
	return $adj;
	}
	
	
	}	
	function getAdjFactorforSpin($id,$action_id,$indxxKey=0,$temp=0)
	{
	
	if($temp){
	$ca_value_query="Select field_name,field_value,field_id from tbl_ca_values_user_edited_temp where ca_id='".$id."'  and ca_action_id='".$action_id."'  ";
		$ca_values=$this->db->getResult($ca_value_query,true);
	}else{
	$ca_value_query="Select field_name,field_value,field_id from tbl_ca_values_user_edited where ca_id='".$id."'  and ca_action_id='".$action_id."'  ";
		$ca_values=$this->db->getResult($ca_value_query,true);
	
	}
//echo $date;

if(empty($ca_values))
{	$ca_value_query="Select field_name,field_value,field_id from tbl_ca_values where ca_id='".$id."'  and ca_action_id='".$action_id."' ";
		$ca_values=$this->db->getResult($ca_value_query,true);
}//$this->pr($ca_values,true);
	
		$adj=0;
	if(!empty($ca_values))
	{
	foreach ($ca_values as $ca_value)
	{
		if($ca_value['field_name']=='CP_ADJ')
			{
			$adj=$ca_value['field_value'];
			}
	}
	}
	if($adj==0)
	{
	//echo "Adjustement Ammount is Not Available ";
	//exit;
	return 0;
	
	}
	else{
	return $adj;
	}
	
	
	}	
		function getLastDayLocalPriceValue($indxx,$curr,$date){
	//	echo $curr;
	$data =$this->db->getResult("select tbl_prices_local_curr.* from tbl_prices_local_curr where ticker='".$indxx['ticker']."' order by date desc ",false,1);
	//$this->pr($data,true);
	if(!empty($data)){
		return $data['price'];
		}
	else{
	
	return 0;
	}
	
	}
		function getLastDayPriceCurrencyValue($indxx,$curr,$date){
	//	echo $curr;
	$data =$this->db->getResult("select tbl_prices_local_curr.* from tbl_prices_local_curr where ticker='".$indxx['ticker']."' order by date desc ",false,1);
	//$this->pr($data,true);
	if(!empty($data)){
	if($data['curr']!=$curr)
	{
	$cfactor_local=$this->getPriceforCurrency($curr,$data['curr'],$date);
	
	return $cfactor_local;
	}else{
	return 1;
	}}
	else{
	
	return 0;
	}
	
	}
	function getLastDayPriceValue($indxx,$curr,$date){
	//	echo $curr;
	$data =$this->db->getResult("select tbl_prices_local_curr.* from tbl_prices_local_curr where ticker='".$indxx['ticker']."' order by date desc ",false,1);
	//$this->pr($data,true);
	if(!empty($data)){
	if($data['curr']!=$curr)
	{
	$cfactor_local=$this->getPriceforCurrency($curr,$data['curr'],$date);
	if(strcmp(strtoupper($curr.$data['curr']),$curr.$data['curr'])==0)
			 $data['price']= $data['price']/$cfactor_local;
			else
				 $data['price']= $data['price']/($cfactor_local*100);
	
	return $data['price'];
	}else{
	return $data['price'];
	}}
	else{
	
	return 0;
	}
	
	}
	function getLinkUrl($string){
	$string = preg_replace("`\[.*\]`U","",$string);
	$string = preg_replace('`&(amp;)?#?[a-z0-9]+;`i','-',$string);
	$string = htmlentities($string, ENT_COMPAT, 'utf-8');
	$string = preg_replace( "`&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);`i","\\1", $string );
	$string = preg_replace( array("`[^a-z0-9]`i","`[-]+`") , "-", $string);
	return strtolower(trim($string, '-')).".html";
}
function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
    $sort_col = array();
    foreach ($arr as $key=> $row) {
        $sort_col[$key] = $row[$col];
    }

    array_multisort($sort_col, $dir, $arr);
}

function get_days_in_month($month, $year)
{
   return $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year %400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31);
}
  function convertNumberToWordsForIndia($number){
        //A function to convert numbers into Indian readable words with Cores, Lakhs and Thousands.
        $words = array(
        '0'=> '' ,'1'=> 'one' ,'2'=> 'two' ,'3' => 'three','4' => 'four','5' => 'five',
        '6' => 'six','7' => 'seven','8' => 'eight','9' => 'nine','10' => 'ten',
        '11' => 'eleven','12' => 'twelve','13' => 'thirteen','14' => 'fouteen','15' => 'fifteen',
        '16' => 'sixteen','17' => 'seventeen','18' => 'eighteen','19' => 'nineteen','20' => 'twenty',
        '30' => 'thirty','40' => 'fourty','50' => 'fifty','60' => 'sixty','70' => 'seventy',
        '80' => 'eighty','90' => 'ninty');
       
        //First find the length of the number
        $number_length = strlen($number);
        //Initialize an empty array
        $number_array = array(0,0,0,0,0,0,0,0,0);       
        $received_number_array = array();
       
        //Store all received numbers into an array
        for($i=0;$i<$number_length;$i++){    $received_number_array[$i] = substr($number,$i,1);    }

        //Populate the empty array with the numbers received - most critical operation
        for($i=9-$number_length,$j=0;$i<9;$i++,$j++){ $number_array[$i] = $received_number_array[$j]; }
        $number_to_words_string = "";       
        //Finding out whether it is teen ? and then multiplying by 10, example 17 is seventeen, so if 1 is preceeded with 7 multiply 1 by 10 and add 7 to it.
        for($i=0,$j=1;$i<9;$i++,$j++){
            if($i==0 || $i==2 || $i==4 || $i==7){
                if($number_array[$i]=="1"){
                    $number_array[$j] = 10+$number_array[$j];
                    $number_array[$i] = 0;
                }       
            }
        }
       
        $value = "";
        for($i=0;$i<9;$i++){
            if($i==0 || $i==2 || $i==4 || $i==7){    $value = $number_array[$i]*10; }
            else{ $value = $number_array[$i];    }           
            if($value!=0){ $number_to_words_string.= $words["$value"]." "; }
            if($i==1 && $value!=0){    $number_to_words_string.= "Crores "; }
            if($i==3 && $value!=0){    $number_to_words_string.= "Lakhs ";    }
            if($i==5 && $value!=0){    $number_to_words_string.= "Thousand "; }
            if($i==6 && $value!=0){    $number_to_words_string.= "Hundred "; }
        }
        if($number_length>9){ $number_to_words_string = "Sorry This does not support more than 99 Crores"; }
        return ucwords(strtolower(" Rupees ".$number_to_words_string)." Only.");
    }



	function getcafortoday($id,$type)
	{
			if($type=='1')
			{
				$caquery=$this->db->getResult("select tbl_ca.company_name,tbl_ca.mnemonic,tbl_ca.id as corpid ,tbl_assign_index.user_id,tbl_assign_index.indxx_id,tbl_indxx_ticker.ticker from tbl_assign_index left join tbl_indxx_ticker on tbl_assign_index.indxx_id=tbl_indxx_ticker.indxx_id left join tbl_ca on tbl_ca.identifier=tbl_indxx_ticker.ticker where tbl_ca.eff_date='".$this->_date."' group by tbl_ca.company_name",true);	
			}
			else if($type=='2')
			{
				$caquery=$this->db->getResult("select tbl_ca.company_name,tbl_ca.mnemonic,tbl_ca.id as corpid ,tbl_assign_index.user_id,tbl_assign_index.indxx_id,tbl_indxx_ticker.ticker from tbl_assign_index left join tbl_indxx_ticker on tbl_assign_index.indxx_id=tbl_indxx_ticker.indxx_id left join tbl_ca on tbl_ca.identifier=tbl_indxx_ticker.ticker where tbl_assign_index.user_id='".$_SESSION['User']['id']."' and tbl_ca.eff_date='".$this->_date."'",true);	
			}
			
			return $caquery;
			
	}
	
	
	function getcaforweek($id,$type)
	{
		 $date=date('Y-m-d', strtotime($this->_date.'+7 days'));
		if($type=='1')
			{
				$totalweeklyca=$this->db->getResult("select tbl_ca.company_name,tbl_ca.mnemonic,tbl_ca.id as corpactionid ,tbl_assign_index.user_id,tbl_assign_index.indxx_id,tbl_indxx_ticker.ticker from tbl_assign_index left join tbl_indxx_ticker on tbl_assign_index.indxx_id=tbl_indxx_ticker.indxx_id left join tbl_ca on tbl_ca.identifier=tbl_indxx_ticker.ticker where tbl_ca.eff_date between '".date("Y-m-d")."' and '".$date."' group by tbl_ca.company_name",true);	
			}
			else if($type=='2')
			{
				 $totalweeklyca=$this->db->getResult("select tbl_ca.company_name,tbl_ca.mnemonic,tbl_ca.id as corpactionid ,tbl_assign_index.user_id,tbl_assign_index.indxx_id,tbl_indxx_ticker.ticker from tbl_assign_index left join tbl_indxx_ticker on tbl_assign_index.indxx_id=tbl_indxx_ticker.indxx_id left join tbl_ca on tbl_ca.identifier=tbl_indxx_ticker.ticker where tbl_assign_index.user_id='".$_SESSION['User']['id']."' and tbl_ca.eff_date between '".date("Y-m-d")."' and '".$date."'",true);
			}
			
			return $totalweeklyca;
			
	}
  
 function setUserTempIndexSessionData($obj){			
				
			//	$this->pr($obj,true);
			
				if(!empty($obj))
				{//$this->pr($obj,true);
				
				foreach($obj as $indxx)
				{
				
				$_SESSION['IndexTemp'][]=$indxx['indxx'];		
		
				}
				
	}
				//exit;
				return true;	
	}
	
  
  function arr_to_csv($data,$csv = '|') {

$array = array();

/* Epic amount of for each's. This could be done with recursion */
foreach($data as $key => &$value) {
    if (!is_array($value)) {
        $array[] = $key . $csv .(is_null($value)?'null':$value);
    } else {
        foreach ($value as $k => &$v) {
            if (!is_array($v)) {
                $array[] = $key . $csv . $k . $csv . (is_null($v) ? 'null' : $v);
            } else {
                foreach ($v as $kk => &$vv) {
                    if (!is_array($vv)) {
                        $array[] = $key . $csv . $k . $csv . $kk . $csv . (is_null($vv) ? 'null' : $vv);
                    } else {
                        foreach ($vv as $x => &$y) {
                            if (!is_array($y)) {
                                $array[] = $key . $csv . $k . $csv . $kk . $csv. $x . $csv . (is_null($y) ? 'null' : $y);
                            } else {
                                foreach ($y as $too => $long) {
                                    if(!is_array($long)) {
                                        $array[] = $key . $csv . $k . $csv . $kk . $csv. $x . $csv . $too . $csv. (is_null($long)?'null':$long);
                                    } else {
                                        foreach ($long as $omg => $why) {
                                            if(!is_array($why)) {
                                                $array[] = $key . $csv . $k . $csv . $kk . $csv. $x . $csv . $too . $csv . $omg . $csv . (is_null($why) ? 'null' : $why);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    } 
}    
return $array;
}


function getCaStr($indxxticker,$date, $caid){

	$entry='';	
	//$catype='("DVD_CASH","CHG_ID","CHG_NAME","CHG_TKR","DELIST","DVD_STOCK","RECLASS","RIGHTS_OFFER","SPIN","STOCK_SPLT")';
	
	
		$ca=	$this->db->getResult("select id,identifier,mnemonic,company_name,ann_date,eff_date,action_id, secid_type,secid,currency from tbl_ca where identifier ='".$indxxticker."' and eff_date>='".$date."' and id ='".$caid."'",true);
		if(!empty($ca))
		{
		foreach($ca as $cas)
		{
		
		$entry.=$cas['identifier'].";";	
		$entry.=$cas['company_name'].";";	
		if($cas['secid_type']=="ISIN")
		$entry.=$cas['secid'].";";	
		else
		$entry.=" ;";	
		
		
		$price="";
		$curr='';
		
		$notes='';
		$factor='';	
		$action_type=$_SESSION['variable'][$cas['mnemonic']];
		if($cas['id'] )
		{
		$values=$this->getCa($cas['id'],$cas['action_id']);
		//$this->pr($values,true);
		
		}
		
		
		if($cas['mnemonic']=="DVD_CASH")
		{
		if(!empty($values))
		{
		foreach($values as $ca_value)
		{
		if($ca_value['field_name']=='CP_GROSS_AMT')
		$price=$ca_value['field_value'];
		if($ca_value['field_name']=='CP_DVD_CRNCY')
		$curr=$ca_value['field_value'];
		if($ca_value['field_name']=='CP_DVD_TYP' && $ca_value['field_value']=='1001')
		$action_type=$this->getAcionValueName($ca_value['field_name'],$ca_value['field_value']);
		
		}
		}
		}
		
		
		
		if($cas['mnemonic']=="CHG_ID")
		{
		if(!empty($values))
		{
		foreach($values as $ca_value)
		{
		if($ca_value['field_name']=='CP_OLD_ISIN' && $ca_value['field_value'])
		$notes.=" OLD ISIN-".$ca_value['field_value'];
		
		if($ca_value['field_name']=='CP_NEW_ISIN' && $ca_value['field_value'])
		$notes.=" NEW ISIN-".$ca_value['field_value'];
		
		
		
		if($ca_value['field_name']=='CP_OLD_SEDOL' && $ca_value['field_value'])
		$notes.=" OLD SEDOL-".$ca_value['field_value'];
		
		if($ca_value['field_name']=='CP_NEW_SEDOL' && $ca_value['field_value'])
		$notes.=" NEW SEDOL-".$ca_value['field_value'];
		
		
		
		}}
		}
		
		
			
		if($cas['mnemonic']=="CHG_NAME")
		{
		if(!empty($values))
		{
		foreach($values as $ca_value)
		{
		if($ca_value['field_name']=='CP_OLD_NAME' && $ca_value['field_value'])
		$notes.=" OLD NAME-".$ca_value['field_value'];
		
		if($ca_value['field_name']=='CP_NEW_NAME' && $ca_value['field_value'])
		$notes.=" NEW NAME-".$ca_value['field_value'];
		
		
		
		}}
		}
		
			if($cas['mnemonic']=="CHG_TKR")
		{
		if(!empty($values))
		{
		foreach($values as $ca_value)
		{
		if($ca_value['field_name']=='CP_OLD_TKR' && $ca_value['field_value'])
		$notes.=" OLD TICKER-".$ca_value['field_value'];
		
		if($ca_value['field_name']=='CP_NEW_TKR' && $ca_value['field_value'])
		$notes.=" NEW TICKER-".$ca_value['field_value'];
		
		
		
		}}
		}
		
		
				if($cas['mnemonic']=="RECLASS")
		{
		if(!empty($values))
		{
		foreach($values as $ca_value)
		{
		if($ca_value['field_name']=='CP_OLD_CLASS' && $ca_value['field_value'])
		$notes.=" OLD CLASS-".$ca_value['field_value'];
		
		if($ca_value['field_name']=='CP_NEW_CLASS' && $ca_value['field_value'])
		$notes.=" NEW CLASS-".$ca_value['field_value'];
		
		
		
		}}
		}
		
		
			if($cas['mnemonic']=="DVD_STOCK")
		{
		if(!empty($values))
		{
		foreach($values as $ca_value)
		{
		if($ca_value['field_name']=='CP_AMT' && $ca_value['field_value'])
			$price=$ca_value['field_value'];
			$curr=$cas['currency'];
		if($ca_value['field_name']=='CP_ADJ' && $ca_value['field_value'])
			$factor=$ca_value['field_value'];
		
		
		}}
		}
		
		
				if($cas['mnemonic']=="SPIN")
		{
		if(!empty($values))
		{
		foreach($values as $ca_value)
		{
		if($ca_value['field_name']=='CP_ADJ' && $ca_value['field_value'])
			$factor=$ca_value['field_value'];
		
		
		}}
		}
			if($cas['mnemonic']=="STOCK_SPLT")
		{
		if(!empty($values))
		{
		foreach($values as $ca_value)
		{
		if($ca_value['field_name']=='CP_TERMS' && $ca_value['field_value'])
			$notes.=$ca_value['field_value'];
		if($ca_value['field_name']=='CP_ADJ' && $ca_value['field_value'])
			$factor=$ca_value['field_value'];
	
		
		}}
		}
		
		
				if($cas['mnemonic']=="RIGHTS_OFFER")
		{
		if(!empty($values))
		{
		foreach($values as $ca_value)
		{
		if($ca_value['field_name']=='CP_TERMS' && $ca_value['field_value'])
			$notes.=$ca_value['field_value'];
		if($ca_value['field_name']=='CP_NOTES' && $ca_value['field_value']!="N.A." && $ca_value['field_value'])
			$notes.=$ca_value['field_value'];
	if($ca_value['field_name']=='CP_ADJ' && $ca_value['field_value'])
			$factor=$ca_value['field_value'];
	if($ca_value['field_name']=='CP_CRNCY')
		$curr=$ca_value['field_value'];
		
		}}
		}
		
		if($cas['mnemonic']=="DELIST")
		{
		
		}
		
		
		
			$entry.=$action_type.";";	
		$entry.=$cas['eff_date'].";";	
	
		$entry.=$price.";";	
		$entry.=$curr.";";	
		$entry.=$notes.";";	
		$entry.=$factor.";";	
		$entry.="\n";	
		
		
		
		
		}
		}
		
return $entry;
}
function getCaStr2($indxxticker,$date){

	$entry='';	
	$catype='("DVD_CASH","CHG_ID","CHG_NAME","CHG_TKR","DELIST","DVD_STOCK","RECLASS","RIGHTS_OFFER","SPIN","STOCK_SPLT")';
		$ca=	$this->db->getResult("select id,identifier,mnemonic,company_name,ann_date,eff_date,action_id, secid_type,secid,currency from tbl_ca where identifier ='".$indxxticker."' and eff_date>='".$date."' and eff_date<='".date("Y-m-d",strtotime($date)+(15*68400))."'  and mnemonic in ".$catype."",true);
		if(!empty($ca))
		{
		foreach($ca as $cas)
		{
		
		$entry.=$cas['identifier'].";";	
		$entry.=$cas['company_name'].";";	
		if($cas['secid_type']=="ISIN")
		$entry.=$cas['secid'].";";	
		else
		$entry.=" ;";	
		
		
		$price="";
		$curr='';
		
		$notes='';
		$factor='';	
		$action_type=$_SESSION['variable'][$cas['mnemonic']];
		if($cas['id'] )
		{
		$values=$this->getCa($cas['id'],$cas['action_id']);
		//$this->pr($values,true);
		
		}
		
		
		if($cas['mnemonic']=="DVD_CASH")
		{
		if(!empty($values))
		{
		foreach($values as $ca_value)
		{
		if($ca_value['field_name']=='CP_GROSS_AMT')
		$price=$ca_value['field_value'];
		if($ca_value['field_name']=='CP_DVD_CRNCY')
		$curr=$ca_value['field_value'];
		if($ca_value['field_name']=='CP_DVD_TYP' && $ca_value['field_value']=='1001')
		$action_type=$this->getAcionValueName($ca_value['field_name'],$ca_value['field_value']);
		
		}
		}
		}
		
		
		
		if($cas['mnemonic']=="CHG_ID")
		{
		if(!empty($values))
		{
		foreach($values as $ca_value)
		{
		if($ca_value['field_name']=='CP_OLD_ISIN' && $ca_value['field_value'])
		$notes.=" OLD ISIN-".$ca_value['field_value'];
		
		if($ca_value['field_name']=='CP_NEW_ISIN' && $ca_value['field_value'])
		$notes.=" NEW ISIN-".$ca_value['field_value'];
		
		
		
		if($ca_value['field_name']=='CP_OLD_SEDOL' && $ca_value['field_value'])
		$notes.=" OLD SEDOL-".$ca_value['field_value'];
		
		if($ca_value['field_name']=='CP_NEW_SEDOL' && $ca_value['field_value'])
		$notes.=" NEW SEDOL-".$ca_value['field_value'];
		
		
		
		}}
		}
		
		
			
		if($cas['mnemonic']=="CHG_NAME")
		{
		if(!empty($values))
		{
		foreach($values as $ca_value)
		{
		if($ca_value['field_name']=='CP_OLD_NAME' && $ca_value['field_value'])
		$notes.=" OLD NAME-".$ca_value['field_value'];
		
		if($ca_value['field_name']=='CP_NEW_NAME' && $ca_value['field_value'])
		$notes.=" NEW NAME-".$ca_value['field_value'];
		
		
		
		}}
		}
		
			if($cas['mnemonic']=="CHG_TKR")
		{
		if(!empty($values))
		{
		foreach($values as $ca_value)
		{
		if($ca_value['field_name']=='CP_OLD_TKR' && $ca_value['field_value'])
		$notes.=" OLD TICKER-".$ca_value['field_value'];
		
		if($ca_value['field_name']=='CP_NEW_TKR' && $ca_value['field_value'])
		$notes.=" NEW TICKER-".$ca_value['field_value'];
		
		
		
		}}
		}
		
		
				if($cas['mnemonic']=="RECLASS")
		{
		if(!empty($values))
		{
		foreach($values as $ca_value)
		{
		if($ca_value['field_name']=='CP_OLD_CLASS' && $ca_value['field_value'])
		$notes.=" OLD CLASS-".$ca_value['field_value'];
		
		if($ca_value['field_name']=='CP_NEW_CLASS' && $ca_value['field_value'])
		$notes.=" NEW CLASS-".$ca_value['field_value'];
		
		
		
		}}
		}
		
		
			if($cas['mnemonic']=="DVD_STOCK")
		{
		if(!empty($values))
		{
		foreach($values as $ca_value)
		{
		if($ca_value['field_name']=='CP_AMT' && $ca_value['field_value'])
			$price=$ca_value['field_value'];
			$curr=$cas['currency'];
		if($ca_value['field_name']=='CP_ADJ' && $ca_value['field_value'])
			$factor=$ca_value['field_value'];
		
		
		}}
		}
		
		
				if($cas['mnemonic']=="SPIN")
		{
		if(!empty($values))
		{
		foreach($values as $ca_value)
		{
		if($ca_value['field_name']=='CP_ADJ' && $ca_value['field_value'])
			$factor=$ca_value['field_value'];
		
		
		}}
		}
			if($cas['mnemonic']=="STOCK_SPLT")
		{
		if(!empty($values))
		{
		foreach($values as $ca_value)
		{
		if($ca_value['field_name']=='CP_TERMS' && $ca_value['field_value'])
			$notes.=$ca_value['field_value'];
		if($ca_value['field_name']=='CP_ADJ' && $ca_value['field_value'])
			$factor=$ca_value['field_value'];
	
		
		}}
		}
		
		
				if($cas['mnemonic']=="RIGHTS_OFFER")
		{
		if(!empty($values))
		{
		foreach($values as $ca_value)
		{
		if($ca_value['field_name']=='CP_TERMS' && $ca_value['field_value'])
			$notes.=$ca_value['field_value'];
		if($ca_value['field_name']=='CP_NOTES' && $ca_value['field_value']!="N.A." && $ca_value['field_value'])
			$notes.=$ca_value['field_value'];
	if($ca_value['field_name']=='CP_ADJ' && $ca_value['field_value'])
			$factor=$ca_value['field_value'];
	if($ca_value['field_name']=='CP_CRNCY')
		$curr=$ca_value['field_value'];
		
		}}
		}
		
		if($cas['mnemonic']=="DELIST")
		{
		
		}
		
		
		
			$entry.=$action_type.";";	
		$entry.=$cas['eff_date'].";";	
	
		$entry.=$price.";";	
		$entry.=$curr.";";	
		$entry.=$notes.";";	
		$entry.=$factor.";";	
		$entry.="\n";	
		
		
		
		
		}
		}
		
return $entry;
}



function get_user_ca_adj_factor($indxx_id,$ticker){
//echo "select factor from tbl_user_ca_adj_factor where indxx_id ='".$indxx_id."' and ticker_id='".$ticker."' and status='1' and date='".$this->_date."'";
//exit;
	$ca=	$this->db->getResult("select factor from tbl_user_ca_adj_factor where indxx_id ='".$indxx_id."' and ticker_id='".$ticker."' and status='1' and date='".$this->_date."'",true);
if(!empty($ca))
{
return $ca[0]['factor'];
}
return 0;
}



function getCaStr3($indxxticker,$date,$indxxname=''){

	$entry='';	
	$catype='("DVD_CASH","CHG_ID","CHG_NAME","CHG_TKR","DELIST","DVD_STOCK","RECLASS","RIGHTS_OFFER","SPIN","STOCK_SPLT")';
		$ca=	$this->db->getResult("select id,identifier,mnemonic,company_name,ann_date,eff_date,action_id, secid_type,secid,currency from tbl_ca where identifier ='".$indxxticker."' and eff_date>='".date("Y-m-d",strtotime($date)-86400)."' and eff_date<='".date("Y-m-d",strtotime($date)+(15*68400))."'  and mnemonic in ".$catype."  and action_id in (select ca_action_id from tbl_ca_admin_approve where ca_action_id=tbl_ca.action_id) ",true);
		if(!empty($ca))
		{
		foreach($ca as $cas)
		{
		
		if($indxxname)
		{
		$entry.=$indxxname.";";	
		}
		
		
		$entry.=$cas['identifier'].";";	
		$entry.=$cas['company_name'].";";	
		if($cas['secid_type']=="ISIN")
		$entry.=$cas['secid'].";";	
		else
		$entry.=" ;";	
		
		
		$price="";
		$curr='';
		
		$notes='';
		$factor='';	
		$action_type=$_SESSION['variable'][$cas['mnemonic']];
		if($cas['id'] )
		{
		$values=$this->getCa($cas['id'],$cas['action_id']);
		//$this->pr($values,true);
		
		}
		
		
		if($cas['mnemonic']=="DVD_CASH")
		{
		if(!empty($values))
		{
		foreach($values as $ca_value)
		{
		if($ca_value['field_name']=='CP_GROSS_AMT')
		$price="Gross Amt.=".$ca_value['field_value'];
		if($ca_value['field_name']=='CP_NET_AMT')
		$price.="Net Amt.=".$ca_value['field_value'];
		if($ca_value['field_name']=='CP_DVD_CRNCY')
		$curr=$ca_value['field_value'];
		if($ca_value['field_name']=='CP_DVD_TYP' && $ca_value['field_value']=='1001')
		$action_type=$this->getAcionValueName($ca_value['field_name'],$ca_value['field_value']);
		
		}
		}
		}
		
		
		
		if($cas['mnemonic']=="CHG_ID")
		{
		if(!empty($values))
		{
		foreach($values as $ca_value)
		{
		if($ca_value['field_name']=='CP_OLD_ISIN' && $ca_value['field_value'])
		$notes.=" OLD ISIN-".$ca_value['field_value'];
		
		if($ca_value['field_name']=='CP_NEW_ISIN' && $ca_value['field_value'])
		$notes.=" NEW ISIN-".$ca_value['field_value'];
		
		
		
		if($ca_value['field_name']=='CP_OLD_SEDOL' && $ca_value['field_value'])
		$notes.=" OLD SEDOL-".$ca_value['field_value'];
		
		if($ca_value['field_name']=='CP_NEW_SEDOL' && $ca_value['field_value'])
		$notes.=" NEW SEDOL-".$ca_value['field_value'];
		
		
		
		}}
		}
		
		
			
		if($cas['mnemonic']=="CHG_NAME")
		{
		if(!empty($values))
		{
		foreach($values as $ca_value)
		{
		if($ca_value['field_name']=='CP_OLD_NAME' && $ca_value['field_value'])
		$notes.=" OLD NAME-".$ca_value['field_value'];
		
		if($ca_value['field_name']=='CP_NEW_NAME' && $ca_value['field_value'])
		$notes.=" NEW NAME-".$ca_value['field_value'];
		
		
		
		}}
		}
		
			if($cas['mnemonic']=="CHG_TKR")
		{
		if(!empty($values))
		{
		foreach($values as $ca_value)
		{
		if($ca_value['field_name']=='CP_OLD_TKR' && $ca_value['field_value'])
		$notes.=" OLD TICKER-".$ca_value['field_value'];
		
		if($ca_value['field_name']=='CP_NEW_TKR' && $ca_value['field_value'])
		$notes.=" NEW TICKER-".$ca_value['field_value'];
		
		
		
		}}
		}
		
		
				if($cas['mnemonic']=="RECLASS")
		{
		if(!empty($values))
		{
		foreach($values as $ca_value)
		{
		if($ca_value['field_name']=='CP_OLD_CLASS' && $ca_value['field_value'])
		$notes.=" OLD CLASS-".$ca_value['field_value'];
		
		if($ca_value['field_name']=='CP_NEW_CLASS' && $ca_value['field_value'])
		$notes.=" NEW CLASS-".$ca_value['field_value'];
		
		
		
		}}
		}
		
		
			if($cas['mnemonic']=="DVD_STOCK")
		{
		if(!empty($values))
		{
		foreach($values as $ca_value)
		{
		if($ca_value['field_name']=='CP_AMT' && $ca_value['field_value'])
			$price=$ca_value['field_value'];
			$curr=$cas['currency'];
		if($ca_value['field_name']=='CP_ADJ' && $ca_value['field_value'])
			$factor=$ca_value['field_value'];
		
		
		}}
		}
		
		
				if($cas['mnemonic']=="SPIN")
		{
		if(!empty($values))
		{
		foreach($values as $ca_value)
		{
		if($ca_value['field_name']=='CP_ADJ' && $ca_value['field_value'])
			$factor=$ca_value['field_value'];
		
		
		}}
		}
			if($cas['mnemonic']=="STOCK_SPLT")
		{
		if(!empty($values))
		{
		foreach($values as $ca_value)
		{
		if($ca_value['field_name']=='CP_TERMS' && $ca_value['field_value'])
			$notes.=$ca_value['field_value'];
		if($ca_value['field_name']=='CP_ADJ' && $ca_value['field_value'])
			$factor=$ca_value['field_value'];
	
		
		}}
		}
		
		
				if($cas['mnemonic']=="RIGHTS_OFFER")
		{
		if(!empty($values))
		{
		foreach($values as $ca_value)
		{
		if($ca_value['field_name']=='CP_TERMS' && $ca_value['field_value'])
			$notes.=$ca_value['field_value'];
		if($ca_value['field_name']=='CP_NOTES' && $ca_value['field_value']!="N.A." && $ca_value['field_value'])
			$notes.=$ca_value['field_value'];
	if($ca_value['field_name']=='CP_ADJ' && $ca_value['field_value'])
			$factor=$ca_value['field_value'];
	if($ca_value['field_name']=='CP_CRNCY')
		$curr=$ca_value['field_value'];
		
		}}
		}
		
		if($cas['mnemonic']=="DELIST")
		{
		
		}
		
		
		
			$entry.=$action_type.";";	
		$entry.=$cas['eff_date'].";";	
	
		$entry.=$price.";";	
		$entry.=$curr.";";	
		$entry.=$notes.";";	
		$entry.=$factor.";";	
		$entry.="\n";	
		
		
		
		
		}
		}
		
return $entry;
}

function saveProcess($type=0)
{
//print_r($_SERVER);

$query="Insert into tbl_system_progress (url,type,path,stime)  values ('".mysql_real_escape_string($_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'])."','".$type."','".mysql_real_escape_string($_SERVER['SCRIPT_FILENAME'])."','".date("Y-m-d H:i:s",$_SERVER['REQUEST_TIME'])."')";
$this->db->query($query);
}

}

?>

