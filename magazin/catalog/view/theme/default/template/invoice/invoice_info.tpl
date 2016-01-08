<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
   <div class="breadcrumb">
      <?php foreach ($breadcrumbs as $breadcrumb) { ?>
      <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
      <?php } ?>
   </div>
   <h1><?php echo $heading_title; ?></h1>
   <table class="list">
      <thead>
         <tr>
            <td class="left" colspan="2"><?php echo $text_invoice_detail; ?></td>
         </tr>
      </thead>
      <tbody>
         <tr>
            <td class="left" style="width: 50%;">
               <b><?php echo $text_invoice; ?></b> <?php echo $invoice_id; ?><br />
               <b><?php echo $text_date; ?></b> <?php echo $invoice_date; ?><br />
               <b><?php echo $text_due_date; ?></b> <?php echo $invoice_duedate; ?><br />
            </td>
            <td class="left" style="width: 50%;">
               <b><?php echo $text_invoice_amount; ?></b> <?php echo $invoice_amount; ?><br />
               <b><?php echo $text_currencycode; ?></b> <?php echo $invoice_currencycode; ?><br />
            </td>
         </tr>
      </tbody>
   </table>
<!--   <table class="list">
      <thead>
         <tr>
            <td class="left"><?php echo $text_billing_address; ?></td>
            <td class="left"><?php echo $text_bank_accounts; ?></td>
         </tr>
      </thead>
      <tbody>
         <tr>
            <td class="left"><?php echo $billing_address; ?></td>        
            <?php if ($bank_accounts) { ?>
            <td class="left" valign="top">
               <?php foreach ($bank_accounts as $value) { ?>
               <?php echo $value;?><br />
               <?php } ?>
            </td>
            <?php } ?>
         </tr>
      </tbody>
   </table>-->
   <table class="list">
      <thead>
         <tr>
            <td class="left"><?php echo $text_number; ?></td>
            <td class="left"><?php echo $text_article_code; ?></td>
            <td class="right"><?php echo $text_article_name; ?></td>
            <td class="right"><?php echo $text_quantity; ?></td>
            <td class="right"><?php echo $text_sales_unit; ?></td>
            <td class="left"><?php echo $text_calc_net_unit_price; ?></td>
            <td class="left"><?php echo $text_line_amount; ?></td>
         </tr>
      </thead>
      <tbody>
         <?php foreach ($invoice_lines as $line) { ?>
         <tr>
            <td class="left"><?php echo $line['linenum']; ?>.</td>
            <td class="left"><?php echo $line['codart']; ?></td>
            <td class="right"><?php echo $line['itemname']; ?></td>
            <td class="right"><?php echo $line['qty']; ?></td>
            <td class="right"><?php echo $line['salesunit']; ?></td>
            <td class="right"><?php echo $line['calcnetunitprice']; ?></td>
            <td class="right"><?php echo $line['lineamount']; ?></td>
         </tr>
         <?php } ?>
      </tbody>
      <tfoot>
         <tr>
            <td colspan="5"></td>
            <td class="right"><b><?php echo $text_line_amount; ?>:</b></td>
            <td class="right"><?php echo $total; ?></td>
         </tr>         
      </tfoot>
   </table>

   <?php if ( $invoice_type == "green" || $invoice_type == "red" ) { ?> 
   <div class="buttons">	<a class="button"  href="<?php echo HTTP_SERVER.'index.php?route=invoice/invoice/export_to_xls&id='.$invoice_id ?>">Descarca in Excel</a>
      <div class="right">
           <form action="https://renania.ro/plata" method="post">    
              <input type="hidden" name="nume_firma" value="<?php echo $company_name; ?>" />
              <input type="hidden" name="email_firma" value="<?php echo $company_email; ?>" />
              <input type="hidden" name="phone_firma" value="<?php echo $company_phone; ?>" />
              <input type="hidden" name="nr_factura" value="<?php echo $invoice_id; ?>" />
              <input type="hidden" name="cod_fiscal" value="<?php echo $company_tax_id; ?>" />
              <input type="hidden" name="pret" value="<?php echo $total; ?>" />
            <input type="submit" value="<?php echo $text_pay_online; ?>" class="button" />
           </form>
      </div>
   </div>
   <?php } else { ?>
   <div class="buttons">
      <a class="button"  href="<?php echo HTTP_SERVER.'index.php?route=invoice/invoice/export_to_xls&id='.$invoice_id ?>">Descarca in Excel</a>
   </div>
   <?php } ?>
   
   <?php echo $content_bottom; ?></div>
<?php echo $footer; ?> 