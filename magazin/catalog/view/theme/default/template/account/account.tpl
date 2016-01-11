<?php echo $header; ?>
<?php if ($success) { ?>
<div class="success"><?php echo $success; ?></div>
<?php } ?>
<?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <h1><?php echo $heading_title; ?>  <?php echo $user; ?></h1>

<!--  <?php if ( $customer_B2B ) { ?>
    (
  <?php if ( $payment_term ) {?>
  <?php echo $text_payment_term; ?>: <strong><?php echo $payment_term." ". $text_days; ?></strong>; 
<?php } ?>
  <?php echo $text_percentage; ?>: <strong><?php echo $nivel_payment_term;?></strong>;
  <?php echo $text_credit_limit; ?>: <strong>
     <?php if ( $credit_limit == 0 ) 
     { 
         echo $text_undefined;
     }
     else
     {
      echo $credit_limit;
     }?>
  </strong>)
  <?php } ?>-->
     
<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
<table class="list" cellspacing="3">
   <thead>
      <tr>
         <td class="left" width='50%'>
            1. <?php echo $text_contact_person; ?>
         </td>
         <td>
            <a href="<?php echo $edit; ?>"><?php echo $text_edit; ?></a>
         </td>
      </tr>
      </thead>
      <tbody>
         <tr>
            <td class="left"><?php echo $text_firstname; ?>:</td>
            <td>
               <input type="text" name="firstname" value="<?php echo $customer_firstname; ?>" />
               <?php if ($error_firstname) { ?>
               <span class="error"><?php echo $error_firstname; ?></span>
               <?php } ?>
            </td>            
         </tr>
         <tr>
            <td class="left"><?php echo $text_lastname; ?>:</td>
            <td>
               <input type="text" name="lastname" value="<?php echo $customer_lastname; ?>" />
               <?php if ($error_lastname) { ?>
               <span class="error"><?php echo $error_lastname; ?></span>
               <?php } ?>
            </td>            
         </tr>
         <tr>
            <td class="left"><?php echo $text_mobile_phone; ?>:</td>
            <td>
               <input type="text" name="mobile_phone" value="<?php echo $customer_mobile_phone; ?>" />
               <?php if ($error_mobile_phone) { ?>
               <span class="error"><?php echo $error_mobile_phone; ?></span>
               <?php } ?>
            </td>            
         </tr>
         <tr>
            <td class="left"><?php echo $text_landline_phone; ?>:</td>
            <td>
               <input type="text" name="telephone" value="<?php echo $customer_landline_name; ?>" />
                <?php if ($error_telephone) { ?>
                <span class="error"><?php echo $error_telephone; ?></span>
                <?php } ?>
            </td>            
         </tr>
         <tr>
            <td class="left">&nbsp;</td>
            <td><input type="submit" value="<?php echo $button_continue; ?>" class="button" /></td>            
         </tr>
      </tbody>
</table>  
</form>

<table class="list">
   <thead>
      <tr>
         <td width='50%'>
            2. <?php echo $text_account_password; ?>
         </td>
         <td class="right">
            <a href="<?php echo $password; ?>"><?php echo $text_password; ?></a>
         </td>
      </tr>
      </thead>
</table>   

<?php if ( $customer_B2B ) { ?>
   <!-- Customer type = B2B -->
<table class="list">
   <thead>
      <tr>
         <td width='50%'>
            3. <?php echo $text_available_delivery_addresses; ?>
         </td>
         <td class="right">
            <a href="<?php echo $add_new_b2b_address; ?>"><?php echo $text_add_new_address; ?></a>
         </td>
      </tr>
      </thead>
      <tbody>
          <?php foreach ($b2b_addresses as $result) { ?>
         <tr>
            <td class="left">
               <?php echo $result['b2b_address']; ?>
            </td>     
            <td class="right">
               <a href="<?php echo $result['b2b_update']; ?>"><?php echo $button_edit;?></a> / <a class="confirm" href="<?php echo $result['b2b_delete']; ?>"><?php echo $button_delete; ?></a>
            </td>     
         </tr>
           <?php } ?>
      </tbody>
</table>  

<!--<table class="list">
   <thead>
      <tr>
         <td class="left" colspan="2">
            4. <?php echo $text_company_details; ?>
         </td>
      </tr>
      </thead>
      <tbody>
          <?php foreach ($b2b_bank_accounts as $result) 
          { 
            ?>
            <tr>
               <td width='50%' class="left">
                  <?php echo $result['b2b_bank_account']; ?>
               </td>     
               <td class="right">
                  <a class="confirm" href="<?php echo $result['b2b_bank_account_delete']; ?>"><?php echo $button_delete; ?></a>
               </td>     
            </tr>
            <?php
         } ?>
      </tbody>
</table>-->
<?php } else { ?>
   <!-- Customer type = B2C -->
<?php } ?>

<?php if ( !$customer_B2B ) { ?>
<table class="list">
   <thead>
      <tr>
         <td width='50%'>
            3. <?php echo $text_available_delivery_addresses; ?>
         </td>
         <td class="right">
            <a href="<?php echo $add_new_address; ?>"><?php echo $text_add_new_address; ?></a>
         </td>
      </tr>
      </thead>
      <tbody>
          <?php foreach ($addresses as $result) { ?>
         <tr>
            <td class="left">
               <?php echo $result['address']; ?>
            </td>     
            <td class="right">
               <a href="<?php echo $result['update']; ?>"><?php echo $button_edit;?></a> / <a class="confirm" href="<?php echo $result['delete']; ?>"><?php echo $button_delete; ?></a>
            </td>     
         </tr>
           <?php } ?>
      </tbody>
</table>  
<?php }?>

<table class="list">
   <thead>
      <tr>
         <td class="left" colspan="2">
            4. <?php echo $text_company_details; ?>
         </td>
      </tr>
      </thead>
      <tbody>
          <?php 
          if ( isset($company_details_info) )
          {
               foreach ($company_details_info as $result) 
               { 
                  ?>
                  <tr>
                     <td width='50%' class="left">
                        <?php echo $result['company_info']; ?>
                     </td>     
                     <td class="right">
                        <a href="<?php echo $result['update']; ?>"><?php echo $button_edit;?></a> / <a class="confirm" href="<?php echo $result['delete']; ?>"><?php echo $button_delete; ?></a>
                     </td>     
                  </tr>
                  <?php
               }
            }
            ?>
      </tbody>
</table> 
  


<!--<table class="list">
   <thead>
      <tr>
         <td class="">
            5. <?php echo $text_wishlist; ?>
         </td>
         <td class="right">
            <a href="<?php echo $wishlist; ?>"><?php echo $text_password; ?></a>
         </td>
      </tr>
      </thead>
</table>  -->


<table class="list">
   <thead>
      <tr>
         <td class="left">
            5. <?php echo $text_my_orders; ?>
         </td>
      </tr>
      </thead>
      <tbody>
         <tr>
            <td class="left"><a href="<?php echo $order; ?>"><?php echo $text_order; ?></a></td>
         </tr>
         <tr>
            <td class="left"><a href="<?php echo $return; ?>"><?php echo $text_return; ?></a></td>        
         </tr>
         <tr>
            <td class="left"><a href="<?php echo $transaction; ?>"><?php echo $text_transaction; ?></a></td>         
         </tr>
      </tbody>
</table>  
  
   
  <?php if ( $customer_B2B ) { ?>
  <table class="list" >
   <thead>
      <tr>
         <td class="left">
            6. <?php echo $text_me_invoices;  ?>
         </td>
      </tr>
      </thead>
      <tbody>
         <tr>
            <td class="left">
               <?php echo $text_lists; ?>
               <select id="invoice_type" name="invoice_type" >
                  <option value="0"><?php echo $text_choose_invoice_type; ?></option>
                  <option value="all"><?php echo $text_all; ?></option>
                  <option value="cashed"><?php echo $text_invoices_cashed; ?></option>
                  <option value="unpaid_in_due_date"><?php echo $text_unpaid_invoices_in_due_date; ?></option>
                  <option value="unpaid_over_due_date"><?php echo $text_unpaid_invoices_over_due_date; ?></option>
               </select>
            </td>
         </tr>
            <?php if( $_SERVER['REMOTE_ADDR'] == '188.26.23.46' ) { ?>
         <form action="<?php echo $list_invoices; ?>" method="post" >
         <tr>
            <td class="left">
               <?php echo $text_filter_invoice_by; ?>
               <select id="filter_by" name="filter_by" >
                  <option value="0"><?php echo $text_choose_filter_type; ?></option>
                  <option value="invoice_number" <?php echo $filter_by_invoice_number; ?> ><?php echo $text_invoice_number; ?></option>
                  <option value="invoice_date" <?php echo $filter_by_invoice_date; ?> ><?php echo $text_invoice_date; ?></option>
                  <option value="invoice_due_date" <?php echo $filter_by_invoice_due_date; ?> ><?php echo $text_invoice_due_date; ?></option>
               </select>
               <?php if ($error_filter_by) { ?>
               <span class="error"><?php echo $error_filter_by; ?></span>
               <?php } ?>  
               <input type="text" id="filter_value" name="filter_value" value="<?php echo $filter_value; ?>" />
               <?php if ($error_filter_value) { ?>
               <span class="error"><?php echo $error_filter_value; ?></span>
               <?php } ?>
               <input class="button" type="submit" value="Filtreaza">
            </td>
         </tr>
         </form>
         <?php } ?>
      </tbody>
   </table>
  <?php }?>
  
    
  <?php if ( $customer_B2B ) { ?>
  <table class="list">
   <thead>
      <tr>
         <td class="left">
            7. <?php echo $text_mailbox; ?>
         </td>
      </tr>
      </thead>
      <tbody>
         <tr>
            <td class="left"><a href="<?php echo $mailbox; ?>"><?php echo $text_mailbox; ?></a></td>
         </tr>
      </tbody>
   </table> 
  <?php }?>
     
  
  <?php if ( $customer_B2B ) { ?>
   <table class="list">
   <thead>
      <tr>
         <td class="left">
            8. <?php echo $text_reclamation;  ?>
         </td>
      </tr>
      </thead>
      <tbody>
         <tr>
            <td class="left"><a href="<?php echo $add; ?>"><?php echo $text_add_reclamation; ?></a></td>
         </tr>
         <tr>
            <td class="left"><a href="<?php echo $list; ?>"><?php echo $text_list_reclamation; ?></a></td>
         </tr>
      </tbody>
   </table> 
  <?php }?>
  
  
  <?php if ( $customer_B2B && $permission == $text_full_permision ) { ?>
  <table class="list">
   <thead>
      <tr>
         <td class="left">
            9. <?php echo $text_agents;  ?>
         </td>
      </tr>
      </thead>
      <tbody>
         <tr>
            <td class="left">
               <?php $text_listing_agent_data; ?>
               <select id="agent_id" name="agent_id" >
                  <option value="0"><?php echo $text_choose_agent; ?></option>
                  <?php foreach($agents as $agent) { ?>
                        <option value="<?php echo $agent['id']; ?>"><?php echo $agent['name']; ?></option>
                  <?php } ?>
               </select>
            </td>
         </tr>
      </tbody>
   </table> 
  <?php }?>
  
  
    <table class="list">
   <thead>
      <tr>
         <td class="left">
            10. <?php echo $text_my_newsletter; ?>
         </td>
      </tr>
      </thead>
      <tbody>
         <tr>
            <td class="left"><a href="<?php echo $newsletter; ?>"><?php echo $text_newsletter; ?></a></td>
         </tr>
      </tbody>
</table> 
  
  
    <?php if ( $customer_B2B ) { ?>
    <table class="list">
   <thead>
      <tr>
         <td class="left">
            11. <?php echo $text_useful_documents; ?>
         </td>
      </tr>
      </thead>
      <tbody>
         <tr>
            <td class="left"><a href="<?php echo $document; ?>"><?php echo $text_useful_documents; ?></a></td>
         </tr>
      </tbody>
   </table> 
  <?php }?>

   <table class="list">
      <thead>
      <tr>
         <td class="left">
            <?php echo $text_fast_order; ?>
         </td>
      </tr>
      </thead>
      <tbody>
      <tr>
         <td class="left"><a href="<?= $fast_order; ?>"><?php echo $text_fast_order; ?></a></td>
      </tr>
      </tbody>
   </table>
    
  <?php echo $content_bottom; ?></div>
<?php echo $footer; ?> 

<script>
   $("#invoice_type").change(function (e){  
      e.preventDefault();
      var invoice_type = $(this).attr('value');
      
      window.location.href ="<?php echo $list_invoices."&invoice_type="; ?>" + invoice_type;
   });
   
   $("#filter_by").change(function (e){  
      e.preventDefault();
      var filter_by = $(this).attr('value');
      if ( filter_by == 'invoice_date' || filter_by == 'invoice_due_date' )
      {
         $("#filter_value").val('AAAA-LL-ZZ');
      }
      else
      {
         $("#filter_value").val('');
      }
      
   });

   
   $("#agent_id").change(function (e){  
      e.preventDefault();
      var agent_id = $(this).attr('value');
      
      window.location.href ="<?php echo $show_agent_info."&id="; ?>" + agent_id;
   });
   
   $(document).ready(function(){
   
      $('.confirm').click(function(){
         var answer = confirm("<?php echo $text_are_you_sure; ?> ");
         if (answer)
         {
               return true;
         } 
         else 
         {
            return false;
         }
       });
   
   });
   
   
</script>