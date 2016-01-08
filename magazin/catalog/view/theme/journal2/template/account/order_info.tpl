<?php echo $header; ?>
<div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
</div>
<?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><h1 class="heading-title"><?php echo $heading_title; ?></h1><?php echo $content_top; ?>
  <table class="list">
    <thead>
      <tr>
        <td class="left" colspan="2"><?php echo $text_order_detail; ?></td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="left" style="width: 50%;"><?php if ($invoice_no) { ?>
          <b><?php echo $text_invoice_no; ?></b> <?php echo $invoice_no; ?><br />
          <?php } ?>
          <b><?php echo $text_order_id; ?></b> #<?php echo $order_id; ?><br />
          <b><?php echo $text_date_added; ?></b> <?php echo $date_added; ?></td>
        <td class="left" style="width: 50%;"><?php if ($payment_method) { ?>
          <b><?php echo $text_payment_method; ?></b> <?php echo $payment_method; ?><br />
          <?php } ?>
          <?php if ($shipping_method) { ?>
          <b><?php echo $text_shipping_method; ?></b> <?php echo $shipping_method; ?>
          <?php } ?></td>
      </tr>
    </tbody>
  </table>
  <table class="list">
    <thead>
      <tr>
        <td class="left"><?php echo $text_payment_address; ?></td>
        <?php if ($shipping_address) { ?>
        <td class="left"><?php echo $text_shipping_address; ?></td>
        <?php } ?>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="left"><?php echo $payment_address; ?></td>
        <?php if ($shipping_address) { ?>
        <td class="left"><?php echo $shipping_address; ?></td>
        <?php } ?>
      </tr>
    </tbody>
  </table>
  <table class="list">
    <thead>
      <tr>
        <td class="left t-1"><?php echo $column_name; ?></td>
        <td class="left t-2"><?php echo $column_model; ?></td>
        <td class="right t-3"><?php echo $column_quantity; ?></td>
        <td class="right t-4"><?php echo $column_price; ?></td>
        <td class="right t-5"><?php echo $column_total; ?></td>
        <?php if ($products) { ?>
        <td style="width: 1px;" class="t-6"></td>
        <?php } ?>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($products as $product) { ?>
      <tr>
        <td class="left t-1"><?php echo $product['name']; ?>
          <?php foreach ($product['option'] as $option) { ?>
          <br />
          &nbsp;<small> - <?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
          <?php } ?></td>
        <td class="left t-2"><?php echo $product['model']; ?></td>
        <td class="right t-3"><?php echo $product['quantity']; ?></td>
        <td class="right t-4"><?php echo $product['price']; ?></td>
        <td class="right t-5"><?php echo $product['total']; ?></td>
        <td class="right t-6"><a href="<?php echo $product['return']; ?>"><img src="catalog/view/theme/default/image/return.png" alt="<?php echo $button_return; ?>" title="<?php echo $button_return; ?>" /></a></td>
      </tr>
      <?php } ?>
      <?php foreach ($vouchers as $voucher) { ?>
      <tr>
        <td class="left t-1"><?php echo $voucher['description']; ?></td>
        <td class="left t-2"></td>
        <td class="right t-3">1</td>
        <td class="right t-4"><?php echo $voucher['amount']; ?></td>
        <td class="right t-5"><?php echo $voucher['amount']; ?></td>
        <?php if ($products) { ?>
        <td class="t-6"></td>
        <?php } ?>
      </tr>
      <?php } ?>
    </tbody>
    <tfoot>
      <?php foreach ($totals as $total) { ?>
      <tr>
        <td class="t-span-3" colspan="3"></td>
        <td class="t-span-1" colspan="1"></td>
        <td class="right"><b><?php echo $total['title']; ?>:</b></td>
        <td class="right"><?php echo $total['text']; ?></td>
        <?php if ($products) { ?>
        <td class="t-6"></td>
        <?php } ?>
      </tr>
      <?php } ?>
    </tfoot>
  </table>
  <?php if ($cart_support) { ?>
  <table class="list">
    <thead>
      <tr>
        <td class="left"><?php echo "Discutii"; ?></td>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($cart_support as $support) { ?>
      <tr>
        <td class="left">
          <div class="support_head">
            <div class="customer_name"><?= $support['lastname']." ".$support['firstname'] ?></div>
            <div class="date_added"> - <?= $support['date_added'] ?> - </div>
          </div>
          <div class="support_content <?= $support['cart_owner'] ?>">
            <p><?= $support['subject'] ?></p>
            <p id="<?= $support['cart_support_message_id'] ?>"><?= $support['message'] ?></p>
            <?php if ($support['product_id']) { ?>
            <form id="<?= $support['cart_support_id'] ?>_cart_support_product" class="cart_support_product">
              <input type="hidden" name="product_id" value="<?= $support['product_id'] ?>" />
              <div class="cart_support_product_name">
                <p><?= $support['name'] ?></p>
                <div class="cart_support_product_option">
                  <?php foreach ($support['option'] as $option) { ?>
                  <input type="hidden" name="option[<?= $option['product_option_id'] ?>]" value="<?= $option['product_option_value_id'] ?>" />
                  <p><small> -    <?= $option['od_name'] ?>: </small>
                    <small><?= $option['ovd_name'] ?></small></p>
                  <?php } ?>
                </div>
              </div>
              <div class="cart_support_product_model"><?= $support['model'] ?></div>
              <div class="cart_support_product_quantity">
                <input disabled type="text" name="quantity" value="<?= $support['quantity'] ?>">
              </div>
              <div class="cart_support_price">
              </div>
              <div class="asked_sup_pr_to_cart">

              </div>
            </form>
            <?php } ?>
          </div>
        </td>
      </tr>
    <?php } ?>
    </tbody>
  </table>
  <?php } ?>
<!-- Cart support BEGIN -->
  <?php if ($comment) { ?>
  <table class="list">
    <thead>
      <tr>
        <td class="left"><?php echo $text_comment; ?></td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="left"><?php echo $comment; ?></td>
      </tr>
    </tbody>
  </table>
  <?php } ?>
  <!-- Cart support END -->
  <?php if ($histories) { ?>
  <div class="box-heading"><?php echo $text_history; ?></div>
  <table class="list">
    <thead>
      <tr>
        <td class="left"><?php echo $column_date_added; ?></td>
        <td class="left"><?php echo $column_status; ?></td>
        <td class="left"><?php echo $column_comment; ?></td>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($histories as $history) { ?>
      <tr>
        <td class="left"><?php echo $history['date_added']; ?></td>
        <td class="left"><?php echo $history['status']; ?></td>
        <td class="left"><?php echo $history['comment']; ?></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
  <?php } ?>
  <div class="buttons">
    <div class="right"><a href="<?php echo $continue; ?>" class="button"><?php echo $button_continue; ?></a></div>
  </div>
  <?php echo $content_bottom; ?></div>
<?php echo $footer; ?> 