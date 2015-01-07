<?php

class Checkout extends Application{

	function __construct()
	{
		parent::__construct();
		
		$currentClass  = $_GET['module'];
		$currentMathod = $_GET['event'];
		$this->smarty->assign('currentClass', $currentClass);
		$this->smarty->assign('currentMathod', $currentMathod);
		
		
	}
	
	function index(){
		$this->revieworder();
	}
	
	/**
	@description:	listing of all the cart products added with billing shipping options
	@Created by: 	Kulvinder Singh
	@Created Date:	27-07-2011
	*/	
	
	function revieworder(){
		$this->addJs("custom.js");
		
		$userId = $_SESSION['User']['UserID'];
		unset($_SESSION['redirect_url']);
		unset($_SESSION['order_complate']);
		if($userId == ''){ // not logedin then send to login box		
			$_SESSION['redirect_url'] = 'index.php?module=checkout&event=revieworder';
			$this->Redirect("index.php?module=user&event=index",'Please login','error');
		
		}	
		$this->_baseTemplate="required_template";
		$this->_bodyTemplate="checkout/revieworder";		
		$this->_meta_description="Shopping Cart";
		$this->_meta_keywords="Review Basket";
		
		$this->_title="Review Basket";
		$this->addJs('validation.js');		
	
		
		$userData = $this->getUserDetails($userId);
		
		if($userData['billingAddress']=='' || $userData['billingCity']=='' || $userData['billingState']=='' || $userData['billingZipCode']==''||
		$userData['billingCountry']=='' || $userData['billingStreet']=='' || $userData['shippingAddress']=='' || $userData['shippingCity']==''||
		$userData['shippingState']=='' || $userData['shippingZipCode']=='' || $userData['shippingCountry']=='' || $userData['shippingStreet']=='')
		{
			$_SESSION['redirect_url'] = 'index.php?module=checkout&event=revieworder';
			$this->Redirect("index.php?module=users&event=updateAddress",'Please Complete Your Billing Shipping Address First','error');
		}
		$this->smarty->assign('userData', $userData);	
		$cartItems = $this->getCartItems(); // get product cart items 
		$this->smarty->assign('cartData', $cartItems);	
		
		$topBannerData = $this->db->getResult("SELECT *  FROM `tbl_add_banners`  where page = 'checkout'  AND position = 'top' ",true);	
	 $bottomBannerData = $this->db->getResult("SELECT *  FROM `tbl_add_banners`  where page = 'checkout'  AND position = 'bottom' ",true);	
	$this->smarty->assign("topBannerData",$topBannerData);
	$this->smarty->assign("bottomBannerData",$bottomBannerData);
		
		$this->show();
	
	
	}
	
	// $ function add order details in order table and order details table
	public function processorder(){		
		
		 
	//$this->pr($_SESSION);
	
		$this->checkUserSession();
		$userId = $_SESSION['User']['UserID'];
		$sessUserType    = $_SESSION['User']['type'];
		
		$userData  = $this->getUserDetails($userId); //  get user details
//	$this->pr($userData);
		$checkoutData = $this->getCheckoutDetails();		// get checkout data such as  total price of order
		//$this->pr($checkoutData,true);
		
		if(is_array($checkoutData) ){
			$order_cost = $checkoutData['order_total'];
			$shappingTotal= $this->shappingTotal;
			$totalOrderPrice=$shappingTotal+$order_cost;
		}else{
			$order_cost =  0;			
		}
		
		
	//	print_r($_SESSION);
	
		if($order_cost>$_SESSION['User']['points'])
		{
			$this->Redirect("index.php?module=cart",'Order Can Not be Processed , Please Check Your Points .',"error");
		}
		
	//$this->pr($userData); exit;
		$session_id = session_id();
		// inset the data into order table
		$strOrderQuery = "INSERT INTO tbl_orders SET 
		sessionId   				= '".$session_id."',
		userId   					= '".$userId."',
		userType   					= '".$userData['userType']."',	
		userName 	  				= '".$userData['name']."',	
		userEmail 	  				= '".$userData['email']."',	
		billingfName 	  		= '".$userData['billingfName']."',	
		billinglName 	  		= '".$userData['billinglName']."',	
		billingStreet 	  		= '".$userData['billingStreet']."',	
		billingAddress 	  		= '".$userData['billingAddress']."',	
		billingCity 	  			= '".$userData['billingCity']."',	
		billingState 	  			= '".$userData['billingState']."',	
		billingCountry 	  			= '".$userData['billingCountry']."',	
		billingPhone 	  			= '".$userData['billingPhone']."',	
		billingZipcode 	  			= '".$userData['billingZipCode']."',	
		shippingfName 	  		= '".$userData['shippingfName']."',	
		shippinglName 	  		= '".$userData['shippinglName']."',	
		shippingStreet 	  		= '".$userData['shippingStreet']."',	
		shippingAddress 	  		= '".$userData['shippingAddress']."',	
		shippingState 	  			= '".$userData['shippingState']."',	
		shippingCity     	  		= '".$userData['shippingCity']."',	
		shippingCountry 	  		= '".$userData['shippingCountry']."',	
		shippingPhone 	  			= '".$userData['shippingPhone']."',	
		shippingZipcode 	  		= '".$userData['shippingZipCode']."',	
		totalShippingPrice 	  		= '".$shappingTotal."',
		totalOrderPrice 	  		= '".$totalOrderPrice."',
		paymentStatus 	  			= '0',	
		orderStatus 	  			= '1',		
		paymentType 	  			= '".$_POST['paymentOption']."',		
		dateAdded 	  	    = '".date("Y-m-d h:m:s",time())."',
		dateModified 	  	= '".date("Y-m-d h:m:s",time())."' ";
	//	exit;
		$this->db->query($strOrderQuery); 
		$orderId = mysql_insert_id();		//  get the order id of order inserted
	
	////////////////////////////////////////Reduse Points start ////////////////////////////////////////////////////
		$query="UPDATE  tbl_users SET directPoint=directPoint-'".$totalOrderPrice."' where id='".$userId."' ;";
		$this->db->query($query);
		$objuser =new users();
		$objuser->setUserSessionData($this->getUserDetails($userId));
		
/////////////////////////////////////////// Reduce Points Ends //////////////////////////////////////////////////	
		$cartItems = $this->getCartItems(); // get product cart items 	
	//$this->pr($cartItems,true);
		$carTotal=0;
		if(is_array($cartItems) ){			
				foreach($cartItems as $key=>$data){
					$insertSqlStr = "insert into tbl_order_details SET
							orderId = '".$orderId."',
							productId = '".$data['productId']."',
							itemId = '".$data['item_id']."',
							productName = '".$data['productName']."',
							productCode = '".$data['productCode']."',
							productImage = '".$data['productImage']."',
							quantity    = '".$data['quantity']."',
							price 		= '".$data['price']."',
							shippingPrice = '0.00',
							dateAdded   = '".date('Y-m-d H:i:s')."'
							";						
						//exit;
						$this->db->query($insertSqlStr);
						$carTotal=$carTotal+$data['lineTotal'];
					//echo $data['quantity'];
					
						
					
					
					unset($insertSqlStr);					
					unset($updateSqlStr);					
						
				}
			
		}
	
		
		//print_r($carTotal);
	$this->sendOrderNotificationEmail($orderId);
			
			
		$this->Redirect("index.php?module=checkout&event=successorder",'Your order has been sent.','success');
		
	}
	

	
	/**
	@description:	listing of all the cart products added with billing shipping options
	@Created by: 	Kulvinder Singh
	@Created Date:	27-07-2011
	*/		
	function successorder(){		
		
		$this->checkUserSession();
		$this->_breadcrumbshow = 0;
		$this->_baseTemplate="required_template";
		$this->_bodyTemplate="checkout/successorder";		
		//$this->_meta_description="Shopping Cart";
		//$this->_meta_keywords="Review Basket";
		
		 $lang=$_SESSION['lang'];
		 $this->smarty->assign('language', $lang);
	    $sql_pageData="select id , pageName_$lang as pageName , metaDesc_$lang as metaDesc, metaKey_$lang as metaKey, metaTitle_$lang as
		 metaTitle, pageContent_$lang as pageContent   from tbl_pages where linkId= 'successorder' AND status='1'";
	
		$pageData = $this->db->getResult($sql_pageData);
		$sqlPageName=$this->db->getResult("select pageName_$lang as pageName from tbl_pages where linkId= 'successorder' AND status='1'");
		$nameArray=explode(" ",$sqlPageName['pageName']);
	    $firstword = $nameArray['0'];
        $this->smarty->assign("firstword",$firstword);
		unset($nameArray['0']);
		$lastword=implode(" ",$nameArray);
		$this->smarty->assign("lastword",$lastword);
		$this->smarty->assign('pageData',$pageData);
		$this->_title=$pageData['metaTitle'];
		$this->_meta_description=$pageData['metaDesc'];
		$this->_meta_keywords=$pageData['metaKey'];
		 
		 
		 
		 
	/*	$pageData = $this->db->getResult("select * from tbl_pages where linkId= 'successorder' AND status='1'");	
		 
			$this->_title		= $pageData['pageName'];
			$this->_metaTitle = $pageData['metaTitle'];
			$this->_meta_keywords=$pageData['metaKey'];
			$this->_meta_description=$pageData['metaDesc'];
			$this->smarty->assign('pageName', $pageData['pageName']);
			$this->smarty->assign('pageContent', $pageData['pageContent']);
			
		 
			
			$this->_meta_description="Order Successfull";
		$this->_meta_keywords="Order Successfull";
		
		$this->_title="Order Successfull";*/
		 
		 $topBannerData = $this->db->getResult("SELECT *  FROM `tbl_add_banners`  where page = 'checkout'  AND position = 'top' ",true);	
	 $bottomBannerData = $this->db->getResult("SELECT *  FROM `tbl_add_banners`  where page = 'checkout'  AND position = 'bottom' ",true);	
	$this->smarty->assign("topBannerData",$topBannerData);
	$this->smarty->assign("bottomBannerData",$bottomBannerData);
		$orderId = base64_decode($_GET['id']);		
		$this->clearCartSessionData();
		$this->show();
	
	
	}
	
	// send order notifiaction email
	function sendOrderNotificationEmail($orderId){
		
		
 
		//$objOrder = new  Order();
		$orderData= $this->getOrderDetails($orderId);
		
	$str_billing_block = '<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td colspan="2"><strong>Billing Information</strong></td></tr>
        
		<!--<tr>
        <td align="left" width="35%">Name:&nbsp;</td>
        <td align="left">'.$orderData['Order']['billingFirstName'].' ' .$orderData['Order']['billingLastName'].' </td>
      </tr>-->
      <tr>
        <td align="left">Address</td>
       <td align="left">'.$orderData['Order']['billingStreet'].' '.$orderData['Order']['billingAddress'].'</td>
      </tr><tr>
        <td align="left">State</td>
        <td align="left">'.$orderData['Order']['billingState'].'</td>
      </tr><tr>
        <td align="left">Zipcode</td>
        <td align="left">'.$orderData['Order']['billingZipcode'].'</td>
      </tr><!--<tr>
        <td align="left">Phone</td>
        <td align="left">'.$orderData['Order']['billingPhone'].'</td>
      </tr>--><tr>
        <td align="left">Country</td>
         <td align="left">'.$orderData['Order']['billingCountry'].'</td>
      </tr><tr>
        <td align="left">&nbsp;</td>
        <td align="left">&nbsp;</td>
      </tr></table>';
	
	 $str_shipping_block = '<table width="100%" border="0" cellspacing="0" cellpadding="0">
	 		<tr><td colspan="2"><strong>Shipping Information</strong></td></tr>
	<!--	<tr>
        <td align="left" width="35%" >Name:&nbsp;</td>
        <td align="left">'.$orderData['Order']['shippingFirstName'].' ' .$orderData['Order']['shippingLastName'].' </td>
      </tr>-->
      <tr>
        <td align="left">Address</td>
       <td align="left">'.$orderData['Order']['billingStreet'].' '.$orderData['Order']['shippingAddress'].'</td>
      </tr><tr>
        <td align="left">State</td>
        <td align="left">'.$orderData['Order']['shippingState'].'</td>
      </tr><tr>
        <td align="left">Zipcode</td>
        <td align="left">'.$orderData['Order']['shippingZipcode'].'</td>
      </tr><!--<tr>
        <td align="left">Phone</td>
        <td align="left">'.$orderData['Order']['shippingPhone'].'</td>
      </tr>--><tr>
        <td align="left">Country</td>
         <td align="left">'.$orderData['Order']['shippingCountry'].'</td>
      </tr><tr>
        <td align="left">&nbsp;</td>
        <td align="left">&nbsp;</td>
      </tr></table>';
	  
	   $str_cart_block = '<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="2">ITEM</td>
        <td align="center">QUANTITY</td>
        <td align="center">PRICE </td>
        <td align="center">TOTAL POINTS</td>
      </tr>';
   
 
	  if(is_array($orderData['OrderDetail']) ){
		 	 $BASE_URL = $this->siteconfig->base_url;
			 $orderSubTotal = 0;
		  	foreach( $orderData['OrderDetail'] as $ordetDetails){
			
		    	$updateSqlStr = "update  tbl_products SET
								qty_avail 	 = 	qty_avail 	-".$ordetDetails['quantity']."
							where id = '".$ordetDetails['productId']."'
							";						
			 				
							 
					 	$this->db->query($updateSqlStr);
			
			
			$str_cart_block .= '<tr>
					<td align="left"><img src="'.$ordetDetails['productImage'].'" width="60" height="60" alt="Product" />&nbsp;</td>
					<td align="left">'.$ordetDetails['productName'].'&nbsp;</td>
					<td align="center">'.$ordetDetails['quantity'].'&nbsp;</td>
					<td align="center">'.$ordetDetails['price'].'&nbsp;</td>
					<td align="center">'.number_format($ordetDetails['quantity']*$ordetDetails['price'],0).'&nbsp;</td>
				  </tr>';	
				  
				  $orderSubTotal  = $orderSubTotal+($ordetDetails['quantity']*$ordetDetails['price']);
				
			}
			
		$str_cart_block .= 	'<tr>
							
								<td align="right" colspan="4">Sub Total</td>
								<td align="center">'.$orderSubTotal.'&nbsp;</td>
							  </tr>
							  <tr>
								
								<td align="right" colspan="4">Delivery Cost</td>
								<td align="center">'.$orderData['Order']['totalShippingPrice'].'&nbsp;</td>
							  </tr>
							  <tr>
							
								<td align="right" colspan="4">Order Total</td>
							   <td align="center"><strong>'.$orderData['Order']['totalOrderPrice'].'</strong>&nbsp;</td>
							  </tr>';
			$str_cart_block .= '</table>';
		  
	  }
	  
	 	
			################# SEND REGISTRSTION EMAIL ##########
			$fromname = $this->siteconfig->from_name;
			$fromemail = $this->siteconfig->mail_from;						
			$data['CUSTOMER_NAME'] 	 	= $orderData['Order']['userName'];
			 $data['BILLING_BLOCK'] 		= $str_billing_block;
		 	 	$data['SHIPPING_BLOCK'] 	= $str_shipping_block;
			  $data['PRODUCT_BLOCK'] 	 	= $str_cart_block;
			$data['SITENAME']  			= $this->siteconfig->site_title;
			
		//  echo $orderData['Order']['userEmail'];
			$this->SendMailId('12', $data, $orderData['Order']['userEmail'], $fromname,$fromemail);	
			
			if($this->siteconfig->order_notify == '1'){ // send notification mail to order
				$this->SendMailId('13', $data, $this->siteconfig->admin_email, $fromname,$fromemail);				
			}
			 
			
		
	}
	
	
	// clear the sesion cart data

	
	
	
	
	
	// send order notifiaction email to reseller
	function processResellerOrder(){
		
		$this->checkUserSession();
		
		/*if($_SESSION['order_complate'] == 'yes'){
			
			return true;			
		}
		*/
		$userId = $_SESSION['User']['id'];		
		$userData = $this->getUserDetails($userId);		
		$orderData = $this->getCartItems(); // get product cart items 
		
	
		
		
		
		//print_r($orderData);
		//exit;
		
		if(is_array($userData) ){
			
			 $str_user_block = '<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td colspan="2" bgcolor="#E5E5E5" height="30"><strong>Reseller Information</strong></td></tr>        
				<tr>
				<td align="left" width="35%">Name:&nbsp;</td>
				<td align="left">'.$userData['name'].'&nbsp; </td>
			  </tr>
			  <tr>
				<td align="left">Email</td>
			   <td align="left">'.$userData['email'].' &nbsp;</td>
			  </tr>
			 <tr>  <td align="left">Phone</td>
				<td align="left">'.$userData['phone'].'&nbsp;</td>
			  </tr><tr>
				<td align="left">&nbsp;</td>
				<td align="left">&nbsp;</td>
			  </tr></table>';
		}	  
	  
	  
	   $str_cart_block = '<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td colspan="5" bgcolor="#E5E5E5" height="30"><strong>Order Information</strong></td></tr>
      <tr>
        <td colspan="2">ITEM</td>
        <td align="center">QUANTITY</td>
        <td align="center">PRICE<img src="'.$this->siteconfig->base_url.'assets/'.$this->tempFolder.'/images/nigerian-currency.gif" alt="Nigerian Currency" width="8" height="12" /></td>
        <td align="center">TOTAL PRICE<img src="'.$this->siteconfig->base_url.'assets/'.$this->tempFolder.'/images/nigerian-currency.gif" alt="Nigerian Currency" width="8" height="12" /></td>
      </tr>';
  
 
	  if(is_array($orderData) ){
			$BASE_URL = $this->siteconfig->base_url;
			$orderSubTotal = 0;
			foreach( $orderData as $ordetDetails){				
			$str_cart_block .= '<tr>
					<td align="left"><img src="'.$BASE_URL.'/media/product/images/thumb/'.$ordetDetails['productImage'].'" width="60" height="60" alt="Product" />&nbsp;</td>
					<td align="left">'.$ordetDetails['productName'].'&nbsp;</td>
					<td align="center">'.$ordetDetails['quantity'].'&nbsp;</td>
					<td align="center">'.$ordetDetails['price'].'&nbsp;</td>
					<td align="center">'.number_format($ordetDetails['quantity']*$ordetDetails['price'],2).'&nbsp;</td>
				  </tr>';	
				  
				  $orderSubTotal  = $orderSubTotal+($ordetDetails['quantity']*$ordetDetails['price']);
				
			}
			
		$str_cart_block .= 	'<tr>							
								<td align="right" colspan="4"> Total</td>
								<td align="center"><img src="'.$this->siteconfig->base_url.'assets/'.$this->tempFolder.'/images/nigerian-currency.gif" alt="Nigerian Currency" width="8" height="12" /><strong>'.$orderSubTotal.'</strong>&nbsp;</td>
							  </tr>';
		$str_cart_block .= '</table>';
		  
	  }
	
			################# SEND REGISTRSTION EMAIL ##########
			$fromname = $this->siteconfig->from_name;
			$fromemail = $this->siteconfig->mail_from;						
			$data['ADMIN_NAME'] 	 	= "Admin";
			 $data['USER_INFO_BLOCK'] 	= $str_user_block;		
			$data['PRODUCT_DATA_BLOCK'] = $str_cart_block;
			$data['SITENAME']  			= $this->siteconfig->site_title;
		//	print_r($data);			
	//exit;
			//$this->siteconfig->admin_email =  "info@localhost.com";
			//$this->SendMailId('4', $data, $orderData['Order']['userEmail'], $fromname,$fromemail);	
			$this->SendMailId('4', $data, $this->siteconfig->admin_email, $fromname,$fromemail); //  send mail to admin
			
			
			
			$data2['CUSTOMER_NAME'] 	 	= $_SESSION['User']['name'];
			 $data2['BILLING_BLOCK'] 		= "";
		 	 	$data2['SHIPPING_BLOCK'] 	= "";
			  $data2['PRODUCT_BLOCK'] 	 	= $str_cart_block;
			$data2['SITENAME']  			= $this->siteconfig->site_title;
			
		  
			$this->SendMailId('3', $data2, $_SESSION['User']['email'], $fromname,$fromemail);	
			
			
			$_SESSION['order_complate'] == 'yes';
			$this->clearCartSessionData();	
			$this->Redirect('index.php?module=checkout&event=thankyou');
			exit;
		
	}
	
	
	// send order notifiaction email to reseller
	function thankyou(){
		
		$this->checkUserSession();
		if($this->siteconfig->website_id!="3")
		{
		$this->_breadcrumbshow = 0;
		}
		$this->_meta_description="Order Successfull";
		$this->_meta_keywords="Order Successfull";
		
		$this->_title="Order Successfull";
		
		$this->_baseTemplate="page-template";
		$this->_bodyTemplate="checkout/success-reseller-order";		
		$this->_title="Success Order";
		
		
		
		$this->show();
	}
	
	
	
	
	
	

} // class ends here

?>