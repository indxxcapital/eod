
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
{literal}
<script language="javascript" type="text/javascript">
function printDocument( ){
	window.print();	
}
</script>
<style>@media print {
.noPrint {
    display:none;
}
}
</style>
{/literal}
{if $siteconfig->activate_rs_symbol=='1'}
<script src="http://cdn.webrupee.com/js" type="text/javascript"></script>
{/if}

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>::. Pony Craft Store .::</title>
</head>
<body bgcolor="#fff">
<table align="center" cellpadding="0" cellspacing="0" style=" background:#888888; border:1px solid #474747;">
  <tr>
    <td align="left" style="padding:15px;">
    
    <table border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><img src="{$BASE_URL}assets/images/mail-header.jpg" alt="Free Smart shopper" border="0"/></td>
        </tr>
        <tr>
          <td align="left" valign="top"  style="background:#fff;  border-left:1px solid #474747; border-right:1px solid #474747; padding:15px;">															 			<table width="544" border="0" cellspacing="0" >
            <tr>
              <td align="left" valign="top">
              
              
              
          
             {if $orderData.Order|@count >0}
         <table width="100%" border="0" cellspacing="0" cellpadding="0">
        
          <tr>
            <th align="left" valign="middle" colspan="4" width="50%"  >Order Information  <a href="#" class='noprint' onClick="printDocument();" >Print </a></th>            
                    
          </tr> 
          <tr>
           <td align="left" valign="middle" > Order Date</td>
           <td align="left" valign="middle" > {$orderData.Order.orderDate}&nbsp;</td> 
           <td align="left" valign="middle" > Order #</td>
           <td align="left" valign="middle" > {$orderData.Order.id}&nbsp;</td>         
          </tr>
          
           <tr>
           <td align="left" valign="middle" > Name</td>
           <td align="left" valign="middle" > {$orderData.Order.userName}&nbsp;</td> 
           <td align="left" valign="middle" > Order Total </td>
           <td align="left" valign="middle" > {$orderData.Order.totalOrderPrice} Points</td>         
          </tr>
          <tr>
          <!-- <td align="left" valign="middle" > Payment Status</td>
           <td align="left" valign="middle" > {$orderData.Order.paymentStatus}&nbsp;</td> -->
           <td align="left" valign="middle" > Order Status</td>
           <td align="left" valign="middle" > {$orderData.Order.orderStatusName}&nbsp;</td> 
           <td colspan="2">&nbsp;</td>        
          </tr>
          
          
          </table>
          <br />
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
        
          <tr>
            <th align="left" valign="middle" colspan="2" width="50%"  >Billing Information</th>            
            <th align="left" valign="middle" colspan="2">Shipping Information</th>           
          </tr> 
         <tr>
           <td align="left" valign="middle" width="20%"  > Name&nbsp;</td>
           <td align="left" valign="middle" > {$orderData.Order.billingfName}&nbsp; {$orderData.Order.billinglName}</td> 
             <td align="left" valign="middle" width="20%"   > Name&nbsp;</td>
           <td align="left" valign="middle" > {$orderData.Order.shippingfName}&nbsp;{$orderData.Order.shippinglName}</td>         
          </tr>
          <tr>
           <td align="left" valign="middle"  > Address&nbsp;</td>
           <td align="left" valign="middle" > {$orderData.Order.billingStreet}&nbsp;{$orderData.Order.billingAddress}</td> 
             <td align="left" valign="middle" > Address&nbsp;</td>
           <td align="left" valign="middle" > {$orderData.Order.shippingStreet}&nbsp;{$orderData.Order.shippingAddress}</td>         
          </tr>
            <tr>
           <td align="left" valign="top"  > City&nbsp;</td>
           <td align="left" valign="top" > {$orderData.Order.billingCityName}&nbsp;</td> 
             <td align="left" valign="top" > City&nbsp;</td>
           <td align="left" valign="top" > {$orderData.Order.shippingCityName}&nbsp;</td>         
          </tr>
           <tr>
         <td align="left" valign="top"  > State&nbsp;</td>
           <td align="left" valign="top"> {$orderData.Order.billingStateName}&nbsp;</td> 
             <td align="left" valign="top" > State&nbsp;</td>
           <td align="left" valign="top" > {$orderData.Order.shippingStateName}&nbsp;</td>         
          </tr>
         <tr>
           <td align="left" valign="top"  > Country&nbsp;</td>
           <td align="left" valign="top" > {$orderData.Order.billingCountryName}&nbsp;</td> 
             <td align="left" valign="top" > Country&nbsp;</td>
           <td align="left" valign="top" > {$orderData.Order.shippingCountryName}&nbsp;</td>         
          </tr>     
       <!-- <tr>
           <td align="left" valign="top" > Phone&nbsp;</td>
           <td align="left" valign="top" > {$orderData.Order.billingPhone}&nbsp;</td> 
             <td align="left" valign="top" > Phone&nbsp;</td>
           <td align="left" valign="top" > {$orderData.Order.shippingPhone}&nbsp;</td>         
          </tr>   -->       
           <tr>
           <td align="left" valign="top"  > Zip code&nbsp;</td>
           <td align="left" valign="top" > {$orderData.Order.billingZipcode}&nbsp;</td> 
             <td align="left" valign="top" > Zip code&nbsp;</td>
           <td align="left" valign="top" > {$orderData.Order.shippingZipcode}&nbsp;</td>         
          </tr>          
         </table>

      <br />
       {if $orderData.OrderDetail|@count >0}
        <table width="100%" border="0" cellspacing="0" cellpadding="0">        
            <tr>
                <th align="left" valign="middle"></th>  
                <th align="left" valign="middle">Items</th>                   
                <th align="center" valign="middle" >Quantity</th>  
                <th align="center" valign="middle" width="100px" >Unit Price </th>  
                <th align="center" valign="middle"  >Total Price </th>                      
          </tr> 
           {foreach from=$orderData.OrderDetail key=p item=cart name=basket}
            <tr>
                <td align="center" valign="middle"  >
               	{if $cart.productImage}                
               <img src="{$cart.productImage}" width="60" height="60" alt="Product" />
              {/if}
                </td> 
                <td align="left" valign="middle"  >{$cart.productName|truncate:50:'..'}</td>
                <td align="center" valign="middle"  >{$cart.quantity}</td>
                <td align="center" valign="middle"  >{$cart.price}</td>
                <td align="center" valign="middle"  >{$cart.price*$cart.quantity}</td>  
                 
                </tr>                              
            {/foreach} {if count($orderData.shippingDetailData)>0}
 <!--{foreach from=$orderData.shippingDetailData key=p item=carriers name=carrier}
 <tr>
                 <td align="right" valign="middle"  colspan="4" ><strong>Delivery Charges for {$carriers.carrierName}: </strong></td>
                 <td align="center" valign="middle"  >Product(s): {$carriers.productName}<br />
       	  Amount :<img src="{$BASE_URL}assets/{$ASSESTS_FOLDER}/images/nigerian-currency.gif" alt="Nigerian Currency" width="8" height="12" />&nbsp;{$carriers.amount} <br />
       	Insurance :<img src="{$BASE_URL}assets/{$ASSESTS_FOLDER}/images/nigerian-currency.gif" alt="Nigerian Currency" width="8" height="12" />&nbsp;{$carriers.insurancePrice} <br />
        Forword Rate :<img src="{$BASE_URL}assets/{$ASSESTS_FOLDER}/images/nigerian-currency.gif" alt="Nigerian Currency" width="8" height="12" />&nbsp;{$carriers.on_forword_rate} <br />
             Total Amount :<img src="{$BASE_URL}assets/{$ASSESTS_FOLDER}/images/nigerian-currency.gif" alt="Nigerian Currency" width="8" height="12" />&nbsp;{$carriers.totalAmount}</td>                
              </tr>  
 {/foreach}-->
            {/if}              
                <tr>
                 <td align="right" valign="middle"  colspan="4" >Sub Total:</td>
                 <td align="center" valign="middle"  > {$orderData.Order.totalOrderPrice-$orderData.Order.totalShippingPrice-$orderData.Order.giftprice} Points </td>                
              </tr>  
             <tr>
                 <td align="right" valign="middle"  colspan="4" >Shipping Price:</td>
                 <td align="center" valign="middle"  >{$orderData.Order.totalShippingPrice} Points</td>                
              </tr>  
              {if $orderData.Order.gift}
             <tr>
                 <td align="right" valign="middle"  colspan="4" >Gift Packing Charges:</td>
                 <td align="center" valign="middle"  >{$orderData.Order.giftprice} Points</td>                
              </tr>  
              
              {/if}
             <tr>
                 <td align="right" valign="middle"  colspan="4" >Order Total:</td>
                 <td align="center" valign="middle"  >{$orderData.Order.totalOrderPrice} Points</td>                
              </tr>   
            
       </table>
       {/if}
      {else}
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
    	<tr>
   		<td align="center" valign="middle" ><h4>No data found.</h4>&nbsp;</td>    
 	 </tr>
       </table>
 	{/if}
    
    
    </td>
            </tr>
          </table>
          </td>
        </tr>
        <tr>
          <td><img src="{$BASE_URL}assets/images/mail-footer.jpg" alt="&copy; 2011 Reserved With Pony Craft Store" border="0" /></td>
        </tr>
      </table>
    
    </td>
  </tr>
</table>
</body>
</html>

   