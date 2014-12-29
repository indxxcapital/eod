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
									<!--	<input class="submit-gray" type="button" value="Print" onclick="openPopUpWindow('{$BASE_URL}index.php?module=order&event=printorder&id={$orderData.Order.id}', '650', '700');" />-->
                                </fieldset>
						
				<div align="center">
                
              
        {if $orderData.order|@count >0}
         <table width="100%" border="0" cellspacing="0" cellpadding="0">
        
          <tr>
            <th align="left" valign="middle" colspan="4"    >Order Information  </th>            
                    
          </tr> 
          <tr>
           <td align="left" valign="middle" width="20%" > Order Date</td>
           <td align="left" valign="middle" width="30%"> {$orderData.order.dateOrder}&nbsp;</td> 
           <td align="left" valign="middle" width="20%"> Order #</td>
           <td align="left" valign="middle" width="30%"> {$orderData.order.orderId}&nbsp;</td>         
          </tr>
          <tr>
           <td align="left" valign="middle" width="20%" >Doba Order id #</td>
           <td align="left" valign="middle" width="30%"> {$orderData.order.dobaOrderId}&nbsp;</td> 
           <td align="left" valign="middle" width="20%"> Drop Ship Fee </td>
           <td align="left" valign="middle" width="30%"> {$orderData.order.dropShipFee}&nbsp;</td>         
          </tr>
          <tr>
           <td align="left" valign="middle" width="20%" >Shipping Fee</td>
           <td align="left" valign="middle" width="30%"> {$orderData.order.shippingFee}&nbsp;</td> 
           <td align="left" valign="middle" width="20%"> Transaction Fee </td>
           <td align="left" valign="middle" width="30%"> {$orderData.order.transactionFee}&nbsp;</td>         
          </tr>
           <tr>
           <td align="left" valign="middle" width="20%" >Sub Total</td>
           <td align="left" valign="middle" width="30%"> {$orderData.order.subTotal}&nbsp;</td> 
           <td align="left" valign="middle" width="20%"> Order Total </td>
           <td align="left" valign="middle" width="30%"> {$orderData.order.orderTotal}&nbsp;</td>         
          </tr>
         </table>
          <br />
          
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <th align="left" valign="middle" colspan="4"    >User Information  </th>            
                    
          </tr> 
          <tr>
            <th align="left" valign="middle" colspan="2" width="50%"  >Billing Information</th>            
            <th align="left" valign="middle" colspan="2">Shipping Information</th>           
          </tr> 
          <tr>
           <td align="left" valign="middle" width="20%"  > Name&nbsp;</td>
           <td align="left" valign="middle" > {$orderData.orderDetails.billingfName}&nbsp; {$orderData.orderDetails.billinglName}</td> 
             <td align="left" valign="middle" width="20%"   > Name&nbsp;</td>
           <td align="left" valign="middle" > {$orderData.orderDetails.billinglName}&nbsp;{$orderData.orderDetails.shippinglName}</td>         
          </tr>
          <tr>
           <td align="left" valign="middle"  > Address&nbsp;</td>
           <td align="left" valign="middle" > {$orderData.orderDetails.billingStreet}&nbsp;{$orderData.orderDetails.billingAddress}</td> 
             <td align="left" valign="middle" > Address&nbsp;</td>
           <td align="left" valign="middle" > {$orderData.orderDetails.shippingStreet}&nbsp;{$orderData.orderDetails.shippingAddress}</td>         
          </tr>
           <tr>
           <td align="left" valign="middle"  > State&nbsp;</td>
           <td align="left" valign="middle" > {$orderData.orderDetails.billingStateName}&nbsp;</td> 
             <td align="left" valign="middle" > State&nbsp;</td>
           <td align="left" valign="middle" > {$orderData.orderDetails.shippingStateName}&nbsp;</td>         
          </tr>
                    <tr>
           <td align="left" valign="middle"  > City&nbsp;</td>
           <td align="left" valign="middle" > {$orderData.orderDetails.billingCityName}&nbsp;</td> 
             <td align="left" valign="middle" > City&nbsp;</td>
           <td align="left" valign="middle" > {$orderData.orderDetails.shippingCityName}&nbsp;</td>         
          </tr>
          <!-- <tr>
           <td align="left" valign="middle"  > Phone&nbsp;</td>
           <td align="left" valign="middle" > {$orderData.Order.billingPhone}&nbsp;</td> 
             <td align="left" valign="middle" > Phone&nbsp;</td>
           <td align="left" valign="middle" > {$orderData.Order.shippingPhone}&nbsp;</td>         
          </tr> -->         
           <tr>
           <td align="left" valign="middle"  > Zip code&nbsp;</td>
           <td align="left" valign="middle" > {$orderData.orderDetails.billingZipcode}&nbsp;</td> 
             <td align="left" valign="middle" > Zip code&nbsp;</td>
           <td align="left" valign="middle" > {$orderData.orderDetails.shippingZipcode}&nbsp;</td>         
          </tr>          
            <tr>
          <td align="left" valign="middle"  > Country&nbsp;</td>
           <td align="left" valign="middle" > {$orderData.orderDetails.billingCountryName}&nbsp;</td> 
             <td align="left" valign="middle" > Country&nbsp;</td>
           <td align="left" valign="middle" > {$orderData.orderDetails.shippingCountryName}&nbsp;</td>         
          </tr>         
      </table>
     
      <br />
       {if $orderData.orderProducts|@count >0}
      
           {foreach from=$orderData.orderProducts key=p item=suppilier name=basket}
             <table width="100%" cellspacing="0" cellpadding="0" class="tableborder">        
              <tr>
                <th align="left" valign="middle">Supplier Id</th>  
                <th align="left" valign="middle">supplier Name</th>                   
                <th align="center" valign="middle" >Supplier Order Id</th>  
                <th align="center" valign="middle" >drop Ship Fee</th>  
                <th align="center" valign="middle" >Transaction Fee</th>  
                <th align="center" valign="middle"  >Shipping Fee </th> 
                 <th align="center" valign="middle"  >Sub Total </th>      
                 <th align="center" valign="middle"  >Order Total </th>                                    
          </tr> 
           <tr>
                <td align="center" valign="middle"  >{$suppilier.supplierId}</td> 
                <td align="left" valign="middle"  >{$suppilier.supplierName}</td>
                <td align="center" valign="middle"  >{$suppilier.supplierOrderId}</td>
                <td align="center" valign="middle"  >{$suppilier.dropShipFee}</td>
                <td align="center" valign="middle"  > {$suppilier.transactionFee}</td>    
                <td align="center" valign="middle"  >{$suppilier.shippingFee}</td>
                <td align="center" valign="middle"  >{$suppilier.subTotal}</td>
                <td align="center" valign="middle"  > {$suppilier.orderTotal}</td> 
                </tr>   
                {if $suppilier.items|@count>0}
                
                <tr>
                <th align="left" valign="middle">Product Id #</th>  
                <th align="left" valign="middle">Item Id #</th>                   
                <th align="center" valign="middle" colspan="2">Product Name</th>  
                <th align="center" valign="middle" >SKU</th>  
                <th align="center" valign="middle" >Quantity</th>  
                <th align="center" valign="middle"  >Pre Pay Price  </th> 
                 <th align="center" valign="middle"  >Unit Price</th>      
                </tr> 
                
              {foreach from=$suppilier.items key=p0 item=item name=basket}
               
                <tr>
                <td align="left" valign="middle">{$item.productId}</td>  
                <td align="left" valign="middle">{$item.itemId}</td>                   
                <td align="center" valign="middle" colspan="2" >{$item.title}</td>  
                <td align="center" valign="middle" >{$item.sku}</td>  
                <td align="center" valign="middle" >{$item.quantity}</td>  
                <td align="center" valign="middle"  >{$item.prePayPrice}</td> 
                 <td align="center" valign="middle"  >{$item.price}</td>      
                </tr> 
               
                {/foreach}	                 
              {/if}              
                    </table>               
            {/foreach}  
                  
                       
     
       
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
                    			</fieldset>    
							        
                           
                         
                     </div> <!-- End .module-body -->

                </div>  <!-- End .module -->
        		<div style="clear:both;"></div>
            </div>

</div>