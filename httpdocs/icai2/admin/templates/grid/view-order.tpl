{literal}
<script language="javascript" type="text/javascript">
	
function openPopUpWindow(URL, width,height ){

	
	window.open (URL, "mywindow","scrollbars=1, top=100,left=300,width="+width+",height="+height+ "");
	
}

</script>
{/literal}

<div class="container_12"><div class="grid_12">
 
                <div class="module">
                     <h2><span>{$title}</span></h2>
                                
                     <div class="module-body">
                     {if $error!="" }
 <div>
<span class="notification n-<?=$error?>"><?=$msg?></span>
</div>
{/if}
 
						
						 	<fieldset>
                                 
								  
                                <input class="submit-gray" type="button" onclick="window.location='index.php?module={$currentClass}&event=index&filter={$filter}&DisplayRecords={$DisplayRecords}&ShowThisPage={$ShowThisPage}&sortby={$sortby}&sortDirection={$sortDirection}&page={$page}&pagegroup={$pagegroup}'"  value="Back" />
                               
								
							<!--	<input class="submit-green" type="button" onclick="window.location='index.php?module=order&event=deleteOrder'" value="Delete" />-->
							<input class="submit-gray" type="button" value="Print" onclick="openPopUpWindow('{$BASE_URL}index.php?module=order&event=printorder&id={$orderData.Order.id}', '650', '700');" />
                                </fieldset>
						
				<div align="center">
                
              
        {if $orderData.Order|@count >0}
         <table width="100%" border="0" cellspacing="0" cellpadding="0">
        
          <tr>
            <th align="left" valign="middle" colspan="4"    >Order Information  </th>            
                    
          </tr> 
          <tr>
           <td align="left" valign="middle" width="20%" > Order Date</td>
           <td align="left" valign="middle" width="30%"> {$orderData.Order.dateModified}&nbsp;</td> 
           <td align="left" valign="middle" width="20%"> Order #</td>
           <td align="left" valign="middle" width="30%"> {$orderData.Order.id}&nbsp;</td>         
          </tr>
          
           <tr>
           <td align="left" valign="middle" > Name</td>
           <td align="left" valign="middle" > {$orderData.Order.userName}&nbsp;</td> 
           <td align="left" valign="middle" > Order Total </td>
           <td align="left" valign="middle" > {$orderData.Order.totalOrderPrice} Points</td>         
          </tr>
         <!-- <tr>
          
           <td align="left" valign="middle" > Payment Status</td>
           <td align="left" valign="middle" > {$orderData.Order.paymentStatus}&nbsp;</td> 
             
          </tr>-->
          <tr>
          
           <td align="left" valign="middle" > Order Status</td>
           <td align="left" valign="middle" > {$orderData.Order.orderStatusName}&nbsp;</td>         
           <td align="left" valign="middle" >&nbsp;</td>
           <td align="left" valign="middle" >&nbsp; </td>         
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
           <td align="left" valign="middle" > {$orderData.Order.billinglName}&nbsp;{$orderData.Order.shippinglName}</td>         
          </tr>
          <tr>
           <td align="left" valign="middle"  > Address&nbsp;</td>
           <td align="left" valign="middle" > {$orderData.Order.billingStreet}&nbsp;{$orderData.Order.billingAddress}</td> 
             <td align="left" valign="middle" > Address&nbsp;</td>
           <td align="left" valign="middle" > {$orderData.Order.shippingStreet}&nbsp;{$orderData.Order.shippingAddress}</td>         
          </tr>
           <tr>
           <td align="left" valign="middle"  > State&nbsp;</td>
           <td align="left" valign="middle" > {$orderData.Order.billingStateName}&nbsp;</td> 
             <td align="left" valign="middle" > State&nbsp;</td>
           <td align="left" valign="middle" > {$orderData.Order.shippingStateName}&nbsp;</td>         
          </tr>
                    <tr>
           <td align="left" valign="middle"  > City&nbsp;</td>
           <td align="left" valign="middle" > {$orderData.Order.billingCityName}&nbsp;</td> 
             <td align="left" valign="middle" > City&nbsp;</td>
           <td align="left" valign="middle" > {$orderData.Order.shippingCityName}&nbsp;</td>         
          </tr>
          <!-- <tr>
           <td align="left" valign="middle"  > Phone&nbsp;</td>
           <td align="left" valign="middle" > {$orderData.Order.billingPhone}&nbsp;</td> 
             <td align="left" valign="middle" > Phone&nbsp;</td>
           <td align="left" valign="middle" > {$orderData.Order.shippingPhone}&nbsp;</td>         
          </tr> -->         
           <tr>
           <td align="left" valign="middle"  > Zip code&nbsp;</td>
           <td align="left" valign="middle" > {$orderData.Order.billingZipcode}&nbsp;</td> 
             <td align="left" valign="middle" > Zip code&nbsp;</td>
           <td align="left" valign="middle" > {$orderData.Order.shippingZipcode}&nbsp;</td>         
          </tr>          
            <tr>
          <td align="left" valign="middle"  > Country&nbsp;</td>
           <td align="left" valign="middle" > {$orderData.Order.billingCountryName}&nbsp;</td> 
             <td align="left" valign="middle" > Country&nbsp;</td>
           <td align="left" valign="middle" > {$orderData.Order.shippingCountryName}&nbsp;</td>         
          </tr>         
      </table>
     
      <br />
       {if $orderData.OrderDetail|@count >0}
        <table width="100%" cellspacing="0" cellpadding="0" class="tableborder">        
            <tr>
                <th align="left" valign="middle"></th>  
                <th align="left" valign="middle">Items</th>                   
                <th align="center" valign="middle" >Quantity</th>  
                <th align="center" valign="middle" >Unit Price Rs </th>  
                <th align="center" valign="middle"  >Total Price  Rs </th>                      
          </tr> 
           {foreach from=$orderData.OrderDetail key=p item=cart name=basket}
            <tr>
                <td align="center" valign="middle"  >
               	{if $cart.productImage}                
               <img src="{$cart.productImage}" width="60" height="60" alt="Product" />
              {/if}  </td> 
                <td align="left" valign="middle"  >{$cart.productName|truncate:50:'..'}</td>
                <td align="center" valign="middle"  >{$cart.quantity}</td>
                <td align="center" valign="middle"  >{$cart.price} Points</td>
                <td align="center" valign="middle"  > {$cart.price*$cart.quantity} Points</td>  
                </tr>                              
            {/foreach}  
                   {if count($orderData.shippingDetailData)>0}
<!-- {foreach from=$orderData.shippingDetailData key=p item=carriers name=carrier}
 <tr>
                 <td align="right" valign="middle"  colspan="4" ><strong>Delivery Charges for {$carriers.carrierName}: </strong></td>
                 <td align="center" valign="middle"  >Product(s): {$carriers.productName}<br />
       	  Amount :<img src="{$BASE_URL}assets/{$ASSESTS_FOLDER}/images/nigerian-currency.gif" alt="Nigerian Currency" width="8" height="12" />&nbsp;{$carriers.amount|currency} <br />
       	Insurance :<img src="{$BASE_URL}assets/{$ASSESTS_FOLDER}/images/nigerian-currency.gif" alt="Nigerian Currency" width="8" height="12" />&nbsp;{$carriers.insurancePrice|currency} <br />
        Forword Rate :<img src="{$BASE_URL}assets/{$ASSESTS_FOLDER}/images/nigerian-currency.gif" alt="Nigerian Currency" width="8" height="12" />&nbsp;{$carriers.on_forword_rate|currency} <br />
             Total Amount :<img src="{$BASE_URL}assets/{$ASSESTS_FOLDER}/images/nigerian-currency.gif" alt="Nigerian Currency" width="8" height="12" />&nbsp;{$carriers.totalAmount|currency}</td>                
              </tr>  
 {/foreach}-->
            {/if}   
             <tr>
                 <td align="right" valign="middle"  colspan="4" >Order Total:</td>
                 <td align="center" valign="middle"  > {$orderData.Order.totalOrderPrice} Points </td>                
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
 
				</div>
				
				<div style="clear:both"></div>
				
                 				<fieldset>
                            <input class="submit-gray" type="button" onclick="window.location='index.php?module={$currentClass}&event=index&filter={$filter}&DisplayRecords={$DisplayRecords}&ShowThisPage={$ShowThisPage}&sortby={$sortby}&sortDirection={$sortDirection}&page={$page}&pagegroup={$pagegroup}'" value="Back" />
                 {if $orderData.Order.orderStatus==0 || $orderData.Order.orderStatus==1 }          	<input class="submit-gray" type="button" value="Upload" onclick="openPopUpWindow('{$BASE_URL}index.php?module=order&event=upload&id={$orderData.Order.id}', '650', '700');" />{/if}
                    			</fieldset>    
							        
                           
                         
                     </div> <!-- End .module-body -->

                </div>  <!-- End .module -->
        		<div style="clear:both;"></div>
            </div>

</div>