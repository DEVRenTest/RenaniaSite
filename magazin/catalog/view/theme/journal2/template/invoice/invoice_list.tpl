<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
</div>
<div id="content"><?php echo $content_top; ?>
  <h1 class="heading-title"><?php echo $heading_title; ?></h1>
  
  <?php if ($invoices) { ?>
  <table class="list">
      <thead>
         <tr>
            <td class="left"><?php echo $text_invoice_number; ?></td>
            <td class="left"><?php echo $text_release_date; ?></td>
            <td class="right"><?php echo $text_due_date; ?></td>
            <td class="right"><?php echo $text_total_invoice; ?></td>
            <td class="right"><?php echo $text_currencycode; ?></td>
            <td class="left"><?php echo $text_view_details; ?></td>
            <td class="left"><?php echo $text_view_copy_of_invoice; ?></td>
         </tr>
      </thead>
      <tbody>
         <?php foreach ($invoices as $invoice) { ?>
         <tr>
            <td class="left"><font color="<?php echo $invoice['payment_status']; ?>"><?php echo $invoice['invoice_id']; ?></font></td>
            <td class="left"><font color="<?php echo $invoice['payment_status']; ?>"><?php echo $invoice['invoicedate'];; ?></font></td>
            <td class="right"><font color="<?php echo $invoice['payment_status']; ?>"><?php echo $invoice['duedate']; ?></font></td>
            <td class="right"><font color="<?php echo $invoice['payment_status']; ?>"><?php echo $invoice['invoiceamount']; ?></font></td>
            <td class="right"><font color="<?php echo $invoice['payment_status']; ?>"><?php echo $invoice['currencycode']; ?></font></td>
            <td class="center">
               <?php if ( !empty($invoice['href']) ) { ?>
               <a href="<?php echo $invoice['href']; ?>">
                  <img src="catalog/view/theme/default/image/info.png" alt="<?php echo $button_view; ?>" title="<?php echo $button_view; ?>" />
               </a>
               <?php } ?>
            </td>
            <td class="center">
               <?php if( file_exists( $invoice['pdf'] ) ) { ?>
               <a href=" <?php echo HTTP_SERVER.'invoices/'.$invoice['invoice_id'].'.pdf'; ?> ">
                  <img src="catalog/view/theme/default/image/pdf.png" alt="<?php echo $button_view; ?>" title="<?php echo $button_view; ?>" />
               </a>
               <?php } ?>
            </td>
         </tr>
         <?php } ?>
      </tbody>

   </table>

  

<!--  <div class="invoice-list">
    <div class="invoice-id">
       <b><?php echo $text_invoice_id; ?></b> <?php echo $invoice['invoice_id']; ?>(<strong>  <?php echo $invoice['invoiceaccount']; ?>)</strong></div>
    <div class="invoice-status"><b><?php echo $text_status; ?></b> <?php //echo $invoice['status']; ?></div>
    <div class="invoice-content">
      <div>
        <b><?php echo $text_date; ?></b> <?php echo $invoice['invoicedate']; ?><br />
        <b><?php echo $text_due_date; ?></b> <?php echo $invoice['duedate']; ?></div>
      <div>
         <b><?php echo $text_invoice_amount; ?></b> <?php echo $invoice['invoiceamount']; ?><br />
        <b><?php echo $text_currencycode; ?></b> <?php echo $invoice['currencycode']; ?></div>
      <div class="invoice-info">
         <?php if ( !empty($invoice['href']) ) { ?>
         <a href="<?php echo $invoice['href']; ?>">
            <img src="catalog/view/theme/default/image/info.png" alt="<?php echo $button_view; ?>" title="<?php echo $button_view; ?>" />
         </a>
         <?php } ?>
      </div>
    </div>
  </div>-->

  
  <div class="pagination"><?php echo $pagination; ?></div>
  <?php } else { ?>
  <div class="content"><?php echo $text_empty; ?></div>
  <?php } ?>
  <div class="buttons">
    <div class="right"><a href="<?php echo $continue; ?>" class="button"><?php echo $button_continue; ?></a></div>
  </div>
  <?php echo $content_bottom; ?></div>
<?php echo $footer; ?>