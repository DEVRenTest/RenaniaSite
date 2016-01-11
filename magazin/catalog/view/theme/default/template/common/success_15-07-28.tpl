<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <h1><?php echo $heading_title; ?></h1>
  <?php echo $text_message; ?>

  <?php
  if( ! empty( $this->session->data["show_xml_for_auto_login"] ) )
  {
  ?>
    <div>
        <br /><br /><br />
        <?php if( isset( $this->session->data['login_auto_hook_url'] ) ) { ?>
            <label>Send products into your SAP system with the button below</label>
            <form action="<?php echo $this->session->data['login_auto_hook_url']; ?>" method="POST" id="quickcheckout">
                <br />
                <?php
                if( isset( $this->session->data['xml_data_for_auto_login']['products'] ) )
                {
                    $product_counter = 0;
                    foreach( $this->session->data['xml_data_for_auto_login']['products'] as $product_key => $product )
                    {
                        $product_counter = $product_key + 1;
                ?>
                        <input type="hidden" name="NEW_ITEM-DESCRIPTION[<?php echo $product_counter; ?>]"
                            value="<?php echo $product['name']; ?>" />
                        <input type="hidden" name="NEW_ITEM-MATNR[<?php echo $product_counter; ?>]"
                            value="">
                        <input type="hidden" name="NEW_ITEM-QUANTITY[<?php echo $product_counter; ?>]"
                            value="<?php echo $product['quantity']; ?>">
                        <input type="hidden" name="NEW_ITEM-UNIT[<?php echo $product_counter; ?>]"
                            value="PCE">
                        <input type="hidden" name="NEW_ITEM-PRICE[<?php echo $product_counter; ?>]"
                            value="<?php echo $product['price']; ?>">
                        <input type="hidden" name="NEW_ITEM-PRICEUNIT[<?php echo $product_counter; ?>]"
                            value="1">
                        <input type="hidden" name="NEW_ITEM-CURRENCY[<?php echo $product_counter; ?>]"
                            value="<?php echo $this->session->data['xml_data_for_auto_login']['currency_code']; ?>">
                        <input type="hidden" name="NEW_ITEM-VENDORMAT[<?php echo $product_counter; ?>]"
                            value="<?php echo $product['product_id']; ?>">
                        <input type="hidden" name="NEW_ITEM-CUST_FIELD1[<?php echo $product_counter; ?>]"
                            value="V1">
                <?php
                    }

                    $product_counter += 1;
                    foreach( $this->session->data["xml_data_for_auto_login"]["totals"] as $total )
                    {
                        if( $total["code"] != "shipping" )
                        {
                            continue;
                        }
                    ?>
                        <input type="hidden" name="NEW_ITEM-DESCRIPTION[<?php echo $product_counter; ?>]"
                            value="<?php echo $total['title']; ?>" />
                        <input type="hidden" name="NEW_ITEM-MATNR[<?php echo $product_counter; ?>]"
                            value="">
                        <input type="hidden" name="NEW_ITEM-QUANTITY[<?php echo $product_counter; ?>]"
                            value="1">
                        <input type="hidden" name="NEW_ITEM-UNIT[<?php echo $product_counter; ?>]"
                            value="PCE">
                        <input type="hidden" name="NEW_ITEM-PRICE[<?php echo $product_counter; ?>]"
                            value="<?php echo $total['value']; ?>">
                        <input type="hidden" name="NEW_ITEM-PRICEUNIT[<?php echo $product_counter; ?>]"
                            value="1">
                        <input type="hidden" name="NEW_ITEM-CURRENCY[<?php echo $product_counter; ?>]"
                            value="<?php echo $this->session->data['xml_data_for_auto_login']['currency_code']; ?>">
                        <input type="hidden" name="NEW_ITEM-VENDORMAT[<?php echo $product_counter; ?>]"
                            value="shipping-12345">
                        <input type="hidden" name="NEW_ITEM-CUST_FIELD1[<?php echo $product_counter; ?>]"
                            value="V1">
                    <?php
                    }
                }
                ?>
                <div id="payment_input">
                    <?php if( ! empty( $this->session->data['login_auto_button_name'] ) ) { ?>
                        <input type="submit" name="nxt"
                            class="button checkout_order" value="<?php echo $this->session->data['login_auto_button_name']; ?>">
                    <?php } else { ?>
                        <input type="submit" name="nxt" class="button checkout_order" value="SEND DATA">
                    <?php } ?>
                </div>
            </form>
            <br /><br />
        <?php } ?>
    </div>
  <?php
  }
  ?>
  <div class="buttons">
    <div class="right"><a href="<?php echo $continue; ?>" class="button"><?php echo $button_continue; ?></a></div>
  </div>
  <?php echo $content_bottom; ?></div>
<?php echo $footer; ?>