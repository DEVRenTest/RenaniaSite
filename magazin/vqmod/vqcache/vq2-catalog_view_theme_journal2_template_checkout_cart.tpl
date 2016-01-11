<?php echo $header; ?>
<div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
</div>
<?php if ($attention) { ?>
<div class="attention"><?php echo $attention; ?><img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>
<?php } ?>
<?php if ($success) { ?>
<div class="success"><?php echo $success; ?><img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>
<?php } ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?><img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>
<?php } ?>
<?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content" class="sc-page">
  <h1 class="heading-title"><?php echo $heading_title; ?>
    <?php if ($weight) { ?>
    &nbsp;(<?php echo $weight; ?>)
    <?php } ?>
      <?php if($B2B && $products && !$activated_cart_id && $deelete == 'delete to saved carts') { // If default not empty and not activated from saved cart ?>
      <a id="get_cart_save_form" class="button button_blue">Creeaza cos nou de cumparaturi</a>
      <?php } elseif ($products && $activated_cart_id && $deelete == 'delete to saved carts') { // If default not empty and not activated from saved cart ?>
      <form id="restore_activated_cart_form" action="<?= $action_restore_activated_cart ?>" method="post">
          <input type="hidden" name="cart_id" value="<?= $activated_cart_id ?>">
          <input type="submit" id="save_back_default_cart" class="button button_blue" value="Creeaza cos nou de cumparaturi s <?= $activated_cart_id ?>">
      </form>
      <?php } ?>
      
  </h1>
  <?php echo $content_top; ?>

        <div class="popup_background" id="save_new_cart_popup">
            <div class="popup_container">
                <div class="popup_head">
                    <h2>Salvare cos de cumparaturi<a class="close_popup_x close_popup"></a></h2>
                </div>
                <div class="popup_body">
                    <form action="<?= $save_cart_action; ?>" method="POST" id="save_new_cart_form">
                        <input type="text" name="cart_name" value="" placeholder="<?= $text_cart_name; ?>" style="width: 90%;">
                        <input type="submit" class="button" id="save_new_cart_btn" value="<?= $text_save_cart; ?>"/>
                        <a class="close_popup button">Anulare</a>
                    </form>
                </div>
            </div>

        </div>
      
  <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
    <div class="cart-info">
      <table>
        <thead>
          <tr>
            <td class="image"><?php echo $column_image; ?></td>
            <td class="name"><?php echo $column_name; ?></td>
            <td class="model"><?php echo $column_model; ?></td>
            <td class="quantity"><?php echo $column_quantity; ?></td>
            <td class="price"><?php echo $column_price; ?></td>
            <td class="total"><?php echo $column_total; ?></td>
          </tr>
        </thead>
        <tbody class="default_cart">
          <?php foreach ($products as $product) { ?>
            <?php if(isset($product['recurring'])): /* v156 compatibility */ ?>
            <?php if($product['recurring']): ?>
              <tr>
                  <td colspan="6" style="border:none;"><image src="catalog/view/theme/default/image/reorder.png" alt="" title="" style="float:left;" /><span style="float:left;line-height:18px; margin-left:10px;"> 
                      <strong><?php echo $text_recurring_item ?></strong>
                      <?php echo $product['profile_description'] ?>
                  </td>
                </tr>
            <?php endif; ?>
            <?php endif; /* end v156 compatibility */ ?>
          <tr class="product <?= (!$product['ax_code']) ? "disabled" : "" ?>" ax_code="<?= $product['ax_code']; ?>">
            <td class="image"><?php if ($product['thumb']) { ?>
              <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" /></a>
              <?php } ?></td>
            <td class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
              <?php if (!$product['stock']) { ?>
              <span class="stock">***</span>
              <?php } ?>
              <div>
                <?php foreach ($product['option'] as $option) { ?>
                - <small><?php echo $option['name']; ?>: <?php echo $option['value']; ?></small><br />
                <?php } ?>
                <?php if(isset($product['recurring'])): /* v156 compatibility */ ?>
                <?php if($product['recurring']): ?>
                - <small><?php echo $text_payment_profile ?>: <?php echo $product['profile_name'] ?></small>
                <?php endif; ?>
                <?php endif; /* end v156 compatibility */ ?>
              </div>
              <?php if ($product['reward']) { ?>
              <small><?php echo $product['reward']; ?></small>
              <?php } ?></td>
            <td class="model"><?php echo $product['model']; ?></td>
            

                <td class="quantity"><input type="text"<?php if(!$product['quantity_box']) { ?> disabled="disabled"<?php } ?>

             name="quantity[<?php echo $product['key']; ?>]" value="<?php echo $product['quantity']; ?>" size="1" />
              &nbsp;
              <input type="image" src="catalog/view/theme/default/image/update.png" alt="<?php echo $button_update; ?>" title="<?php echo $button_update; ?>" />
              &nbsp;<a href="<?php echo $product['remove']; ?>"><img src="catalog/view/theme/default/image/remove.png" alt="<?php echo $button_remove; ?>" title="<?php echo $button_remove; ?>" /></a></td>
            <td class="price"><?php echo $product['price']; ?></td>
            <td class="total"><?php echo $product['total']; ?></td>
          </tr>
          <?php } ?>
          <?php foreach ($vouchers as $vouchers) { ?>
          <tr>
            <td class="image"></td>
            <td class="name"><?php echo $vouchers['description']; ?></td>
            <td class="model"></td>
            <td class="quantity"><input type="text" name="" value="1" size="1" disabled="disabled" />
              &nbsp;<a href="<?php echo $vouchers['remove']; ?>"><img src="catalog/view/theme/default/image/remove.png" alt="<?php echo $button_remove; ?>" title="<?php echo $button_remove; ?>" /></a></td>
            <td class="price"><?php echo $vouchers['amount']; ?></td>
            <td class="total"><?php echo $vouchers['amount']; ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </form>
  <?php if ($coupon_status || $voucher_status || $reward_status || $shipping_status) { ?>
  <div class="action-area">
  <h3><?php echo $text_next; ?></h3>
  <div class="content">
    <p><?php echo $text_next_choice; ?></p>
    <table class="radio">
      <?php if ($coupon_status) { ?>
      <tr class="highlight">
        <td><?php if ($next == 'coupon') { ?>
          <input type="radio" name="next" value="coupon" id="use_coupon" checked="checked" />
          <?php } else { ?>
          <input type="radio" name="next" value="coupon" id="use_coupon" />
          <?php } ?></td>
        <td><label for="use_coupon"><?php echo $text_use_coupon; ?></label></td>
      </tr>
      <?php } ?>
      <?php if ($voucher_status) { ?>
      <tr class="highlight">
        <td><?php if ($next == 'voucher') { ?>
          <input type="radio" name="next" value="voucher" id="use_voucher" checked="checked" />
          <?php } else { ?>
          <input type="radio" name="next" value="voucher" id="use_voucher" />
          <?php } ?></td>
        <td><label for="use_voucher"><?php echo $text_use_voucher; ?></label></td>
      </tr>
      <?php } ?>
      <?php if ($reward_status) { ?>
      <tr class="highlight">
        <td><?php if ($next == 'reward') { ?>
          <input type="radio" name="next" value="reward" id="use_reward" checked="checked" />
          <?php } else { ?>
          <input type="radio" name="next" value="reward" id="use_reward" />
          <?php } ?></td>
        <td><label for="use_reward"><?php echo $text_use_reward; ?></label></td>
      </tr>
      <?php } ?>
      <?php if ($shipping_status) { ?>
      <tr class="highlight">
        <td><?php if ($next == 'shipping') { ?>
          <input type="radio" name="next" value="shipping" id="shipping_estimate" checked="checked" />
          <?php } else { ?>
          <input type="radio" name="next" value="shipping" id="shipping_estimate" />
          <?php } ?></td>
        <td><label for="shipping_estimate"><?php echo $text_shipping_estimate; ?></label></td>
      </tr>
      <?php } ?>
    </table>
  </div>
  <div class="cart-module">
    <div id="coupon" class="content" style="display: <?php echo ($next == 'coupon' ? 'block' : 'none'); ?>;">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
        <?php echo $entry_coupon; ?>&nbsp;
        <input type="text" name="coupon" value="<?php echo $coupon; ?>" />
        <input type="hidden" name="next" value="coupon" />
        &nbsp;
        <input type="submit" value="<?php echo $button_coupon; ?>" class="button" />
      </form>
    </div>
    <div id="voucher" class="content" style="display: <?php echo ($next == 'voucher' ? 'block' : 'none'); ?>;">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
        <?php echo $entry_voucher; ?>&nbsp;
        <input type="text" name="voucher" value="<?php echo $voucher; ?>" />
        <input type="hidden" name="next" value="voucher" />
        &nbsp;
        <input type="submit" value="<?php echo $button_voucher; ?>" class="button" />
      </form>
    </div>
    <div id="reward" class="content" style="display: <?php echo ($next == 'reward' ? 'block' : 'none'); ?>;">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
        <?php echo $entry_reward; ?>&nbsp;
        <input type="text" name="reward" value="<?php echo $reward; ?>" />
        <input type="hidden" name="next" value="reward" />
        &nbsp;
        <input type="submit" value="<?php echo $button_reward; ?>" class="button" />
      </form>
    </div>
    <div id="shipping" class="content" style="display: <?php echo ($next == 'shipping' ? 'block' : 'none'); ?>;">
      <p><?php echo $text_shipping_detail; ?></p>
      <table>
        <tr>
          <td><span class="required">*</span> <?php echo $entry_country; ?></td>
          <td><select name="country_id">
              <option value=""><?php echo $text_select; ?></option>
              <?php foreach ($countries as $country) { ?>
              <?php if ($country['country_id'] == $country_id) { ?>
              <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
        </tr>
        <tr>
          <td><span class="required">*</span> <?php echo $entry_zone; ?></td>
          <td><select name="zone_id">
            </select></td>
        </tr>
        <tr>
          <td><span id="postcode-required" class="required">*</span> <?php echo $entry_postcode; ?></td>
          <td><input type="text" name="postcode" value="<?php echo $postcode; ?>" /></td>
        </tr>
      </table>
      <hr>
      <input type="button" value="<?php echo $button_quote; ?>" id="button-quote" class="button" />
    </div>
  </div>
  <?php } ?>
  <div class="cart-total">

            <?php if ( $B2B && !$activated_cart_support ) { ?>
      <div class="cart-total-left">
          <div class="saved_bottom_buttons">
              <?php /*  && $deelete == 'delete to saved carts' ?>
              <a class="button support_direct" id="default_ask_sup_from_btn">Solicita consultanta</a>
              <?php */ ?>
              <form id="default_support_form" action="action="<?= $save_cart_action; ?>"" style="display: none;">
                  <table>
                      <col width="130">
                      <col width="400">
                      <tr>
                          <td>
                              <label for="cart_name">Nume cos</label>
                          </td>
                          <td>
                              <input name="cart_name" id="cart_name" value="" type="text">
                              <span class="error" style="display: none;" id="cart_name_length_error">Numele cosului trebuie sa contine cel putin 3 caractere!</span>
                          </td>
                      </tr>
                      <tr>
                          <td>
                              <label for="support_subject">Subiect</label>
                          </td>
                          <td>
                              <input name="support_subject" id="support_subject" value="" type="text">
                              <span class="error" style="display: none;" id="support_subject_length_error">Subiectul trebuie sa contine cel putin 3 caractere!</span>
                          </td>
                      </tr>
                      <tr>
                          <td>
                              <label for="support_message">Mesaj</label>
                          </td>
                          <td>
                              <textarea name="support_message" id="support_message" value="" type="text"></textarea>
                              <span class="error" style="display: none;" id="support_message_length_error">Mesajul trebuie sa contine cel putin 15 caractere!</span>
                          </td>
                      </tr>
                      <tr>
                          <td></td>
                          <td>
                              <input type="hidden" name="saved_with_support" value="saved_with_support">
                              <a class="button" id="save_def_and_sup_btn_submit">Salveaza si trimite</a>
                          </td>
                      </tr>
                  </table>
              </form>
          </div>
      </div>
      <?php } elseif ( $B2B && $activated_cart_support ) { ?>
      <a class="button support_direct" id="default_ask_sup_from_btn">Solicita consultanta <?= sizeof($activated_cart_support) ? "(".sizeof($activated_cart_support).")" : "" ?></a>
      <?php } ?>
      
    <table id="total">
      <?php foreach ($totals as $total) { ?>
      <tr>
        <td class="right"><b><?php echo $total['title']; ?>:</b></td>
        <td class="right"><?php echo $total['text']; ?></td>
      </tr>
      <?php } ?>
    </table>
  </div>
  <div class="buttons">
      <div class="right"><a href="<?php echo $checkout; ?>" class="button button-checkout">      <?php if($products) { ?>
    <div class="right"><a id="order" href="<?php echo $checkout; ?>" class="button"><?php echo $button_checkout; ?></a></div>
    <div class="center"><a href="<?php echo $continue; ?>" class="button"><?php echo $button_shopping; ?></a></div>
    <?php } ?>
    </div></div>



    <?php if ($B2B && $saved_carts == 'delete to saved carts') { ?>
        <?php foreach ($saved_carts as $cart) { ?>
            <div class="saved_cart_name_container">
                <input class="saved_cart_name" type="text" value="<?= $cart['cart_name']; ?>" name="cart_name_<?= $cart['cart_id']; ?>" cart="<?= $cart['cart_id']; ?>" />
                <a class="button update_saved_cart_name_btn" id="name_update_btn_<?= $cart['cart_id']; ?>">Renumire cos</a>
                <span class="success" style="display:none; margin-left: 10px;">Actualizarea numelui cosului s-a efectuat cu success!</span>
            </div>
            <div class="cart-info">
                <table class="saved_cart">
                    <thead>
                        <tr>
                            <td class="image"><?php echo $column_image; ?></td>
                            <td class="name"><?php echo $column_name; ?></td>
                            <td class="model"><?php echo $column_model; ?></td>
                            <td class="quantity"><?php echo $column_quantity; ?></td>
                            <td class="price"><?php echo $column_price; ?></td>
                            <td class="total"><?php echo $column_total; ?></td>
                        </tr>
                    </thead>
                    <tbody id="<?= $cart['cart_id']; ?>">
                        <?php foreach ($cart['products'] as $product) { ?>
                        <tr class="product" ax_code="<?= $product['ax_code']; ?>" cart="<?= $cart['cart_id']; ?>">
                            <td class="image">
                                <?php if ($product['image']) { ?>
                                    <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" /></a>
                                <?php } ?>
                            </td>
                            <td class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
                                <div>
                                    <?php foreach ($product['option'] as $option) { ?>
                                    - <small><?php echo $option['name']; ?>: <?php echo $option['value']; ?></small><br />
                                    <?php } ?>
                                </div>
                                <?php if ($product['reward']) { ?>
                                    <small><?php echo $product['reward']; ?></small>
                                <?php } ?></td>
                            <td class="model"><?php echo $product['model']; ?></td>

                            <?php /* ?>
                            <td class="quantity"><?php echo $product['quantity']; ?></td>
                            <?php */ ?>

                            <td class="quantity"><input type="text" name="quantity_[<?php echo $product['product_id']; ?>]" value="<?php echo $product['quantity']; ?>" size="1" />
                                <input type="image" src="catalog/view/theme/default/image/update.png" class="saved_update_btn" alt="<?php echo $button_update; ?>" title="<?php echo $button_update; ?>" />
                                <a class="saved_delete_product_btn"><img src="catalog/view/theme/default/image/remove.png" alt="<?php echo $button_remove; ?>" title="<?php echo $button_remove; ?>" /></a>
                            </td>

                            <td class="price"><?php echo $product['price']; ?></td>
                            <td class="total"><?php echo $product['total']; ?></td>
                        </tr>
                        <?php } ?>
                      <?php foreach ($vouchers as $vouchers) { ?>
                      <tr>
                        <td class="image"></td>
                        <td class="name"><?php echo $vouchers['description']; ?></td>
                        <td class="model"></td>
                        <td class="quantity"><input type="text" name="" value="1" size="1" disabled="disabled" />
                          &nbsp;<a href="<?php echo $vouchers['remove']; ?>"><img src="catalog/view/theme/default/image/remove.png" alt="<?php echo $button_remove; ?>" title="<?php echo $button_remove; ?>" /></a></td>
                        <td class="price"><?php echo $vouchers['amount']; ?></td>
                        <td class="total"><?php echo $vouchers['amount']; ?></td>
                      </tr>
                      <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="cart-total">
                <div class="cart-total-left">
                    <div class="saved_bottom_buttons">
                        <a class="button ask_delete_saved_cart"><?= $button_remove; ?></a>
                        <span class="confirm_delete_saved_cart" style="display:none;">
                            <span>Sunteti sigur?</span>
                            <a class="button" href="<?= $delete_cart_action; ?>&cart_id=<?= $cart['cart_id']; ?>">DA</a>
                            <a class="button dont_delete_saved_cart">NU</a>
                        </span>
                        <a class="button button_blue ask_activate_cart" cart_id="<?= $cart['cart_id']; ?>">Activeaza cos</a>
                    </div>
                    <div class="saved_bottom_buttons">
                        <a class="button support_direct">Solicita consultanta <?= sizeof($cart['support']) ? "(".sizeof($cart['support']).")" : "" ?> </a>
                    </div>
                </div>
                <table id="total">
                      <tr>
                        <td class="right"><b><?php echo $text_sub_total; ?>:</b></td>
                        <td class="right"><?php echo round($cart['sub_total'], 2); ?><?php echo $this->session->data['currency']; ?></td>
                      <tr>
                      </tr>
                        <td class="right"><b><?php echo $text_tax; ?></b></td>
                        <td class="right"><?php echo round($cart['tax'], 2); ?><?php echo $this->session->data['currency']; ?></td>
                      <tr>
                      </tr>
                        <td class="right"><b><?php echo $text_total; ?></b></td>
                        <td class="right"><?php echo number_format((float)$cart['total'], 2, '.', ''); ?><?php echo $this->session->data['currency']; ?></td>
                      </tr>
                </table>
            </div>
            <div class="support_container" id="<?= $cart['cart_id'] ?>_support_container" style="display: none;">
                <?php foreach ($cart['support'] as $support) { ?>
                <div class="support_message">
                    <?php if ($support['cart_owner']) { ?>
                    <div class="support_culomn_left"></div>
                    <div class="support_culomn_right active_msg">
                        <div class="support_head">
                            <div class="customer_name"><?= $support['firstname']." ".$support['lastname'] ?></div>
                            <div class="date_added"> - <?= $support['date_added'] ?> - </div>
                        </div>
                        <div class="support_content <?= $support['cart_owner'] ?>">
                            <p><?= $support['subject'] ?></p>
                            <p><?= $support['message'] ?></p>
                            <?php if ($support['product_id']) { ?>

                            <form id="<?= $support['cart_support_id'] ?>_cart_support_product" class="cart_support_product">
                                <input type="hidden" name="cart_id" value="<?= $cart['cart_id'] ?>" />
                                <input type="hidden" name="product_id" value="<?= $support['product_id'] ?>" />
                                <input type="hidden" name="ax_code" value="<?= $support['ax_code'] ?>" />
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
                                    <input type="text" id="<?= $support['cart_support_message_id'] ?>quantity" name="quantity" value="<?= $support['quantity'] ?>">
                                </div>
                                <div class="cart_support_price">
                                </div>
                                <div class="asked_sup_pr_to_cart">
                                    <a class="button sup_pr_to_cart_btn" id="<?= $cart['cart_id'] ?>" ax_code="<?= $support['ax_code'] ?>" cart_support_id="<?= $support['cart_support_id'] ?>">Adauga la cos</a>
                                </div>
                            </form>
                            <?php } ?>
                        </div>
                    </div>
                    <?php } else { ?>
                    <div class="support_culomn_left active_msg">
                        <div class="support_head">
                            <div class="customer_name"><?= $support['lastname']." ".$support['firstname'] ?></div>
                            <div class="date_added"> - <?= $support['date_added'] ?> - </div>
                        </div>
                        <div class="support_content <?= $support['cart_owner'] ?>">
                            <p><?= $support['subject'] ?></p>
                            <p><?= $support['message'] ?></p>
                            <?php if ($support['product_id']) { ?>

                            <form id="<?= $support['cart_support_id'] ?>_cart_support_product" class="cart_support_product">
                                <input type="hidden" name="cart_id" value="<?= $cart['cart_id'] ?>" />
                                <input type="hidden" name="product_id" value="<?= $support['product_id'] ?>" />
                                <input type="hidden" name="ax_code" value="<?= $support['ax_code'] ?>" />
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
                                    <input type="text" id="<?= $support['cart_support_message_id'] ?>quantity" name="quantity" value="<?= $support['quantity'] ?>">
                                </div>
                                <div class="cart_support_price">
                                </div>
                                <div class="asked_sup_pr_to_cart">
                                    <a class="button sup_pr_to_cart_btn" id="<?= $cart['cart_id'] ?>" ax_code="<?= $support['ax_code'] ?>" cart_support_id="<?= $support['cart_support_id'] ?>" cart_support_msg_id="<?= $support['cart_support_message_id'] ?>">Adauga la cos</a>
                                </div>
                            </form>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="support_culomn_right"></div>
                    <?php } ?>
                </div>
                <?php } ?>
            </div>
            <form class="support_direct_body" id="<?= $cart['cart_id'] ?>support_direct_body" style="display: none;" method="POST">
                <input type="hidden" value="<?= $cart['cart_id'] ?>" name="cart_id" >

                <input type="text" name="support_subject" class="support_subject" id="<?= $cart['cart_id'] ?>support_subject" placeholder="Subiect" />
                <span class="error" style="display: none;">Subiectul trebuie sa fie inter 3 si 250 charactere!</span>
                <textarea name="support_message" class="support_message" id="<?= $cart['cart_id'] ?>support_message" placeholder="Mesaj"></textarea>
                <span class="error" style="display: none;">Mesajul trebuie sa fie inter 3 si 250 charactere!</span>
                <a class="button new_support_direct_btn" data-cart_id="<?= $cart[cart_id]; ?>">Trimite</a>
                <span class="success support_sent_alert" id="<?= $cart['cart_id'] ?>support_sent" style="display: none;">Supportul a fost trimis!</span>
            </form>
        <?php } ?>
    <?php } ?>
            
  <?php echo $content_bottom; ?></div>


            
<script type="text/javascript"><!--
$('input[name=\'next\']').bind('change', function() {
	$('.cart-module > div').hide();
	
	$('#' + this.value).show();
});
//--></script>
<?php if ($shipping_status) { ?>
<script type="text/javascript"><!--
$('#button-quote').live('click', function() {
	$.ajax({
		url: 'index.php?route=checkout/cart/quote',
		type: 'post',
		data: 'country_id=' + $('select[name=\'country_id\']').val() + '&zone_id=' + $('select[name=\'zone_id\']').val() + '&postcode=' + encodeURIComponent($('input[name=\'postcode\']').val()),
		dataType: 'json',		
		beforeSend: function() {
			$('#button-quote').attr('disabled', true);
			$('#button-quote').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
		},
		complete: function() {
			$('#button-quote').attr('disabled', false);
			$('.wait').remove();
		},		
		success: function(json) {
			$('.success, .warning, .attention, .error').remove();			
						
			if (json['error']) {
				if (json['error']['warning']) {
					$('#notification').html('<div class="warning" style="display: none;">' + json['error']['warning'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');
					
					$('.warning').fadeIn('slow');
					
					$('html, body').animate({ scrollTop: 0 }, 'slow'); 
				}	
							
				if (json['error']['country']) {
					$('select[name=\'country_id\']').after('<span class="error">' + json['error']['country'] + '</span>');
				}	
				
				if (json['error']['zone']) {
					$('select[name=\'zone_id\']').after('<span class="error">' + json['error']['zone'] + '</span>');
				}
				
				if (json['error']['postcode']) {
					$('input[name=\'postcode\']').after('<span class="error">' + json['error']['postcode'] + '</span>');
				}					
			}
			
			if (json['shipping_method']) {
				html  = '<h2 class="secondary-title"><?php echo $text_shipping_method; ?></h2>';
				html += '<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">';
				html += '  <table class="radio">';
				
				for (i in json['shipping_method']) {
					html += '<tr>';
					html += '  <td colspan="3"><b>' + json['shipping_method'][i]['title'] + '</b></td>';
					html += '</tr>';
				
					if (!json['shipping_method'][i]['error']) {
						for (j in json['shipping_method'][i]['quote']) {
							html += '<tr class="highlight">';
							
							if (json['shipping_method'][i]['quote'][j]['code'] == '<?php echo $shipping_method; ?>') {
								html += '<td><input type="radio" name="shipping_method" value="' + json['shipping_method'][i]['quote'][j]['code'] + '" id="' + json['shipping_method'][i]['quote'][j]['code'] + '" checked="checked" /></td>';
							} else {
								html += '<td><input type="radio" name="shipping_method" value="' + json['shipping_method'][i]['quote'][j]['code'] + '" id="' + json['shipping_method'][i]['quote'][j]['code'] + '" /></td>';
							}
								
							html += '  <td><label for="' + json['shipping_method'][i]['quote'][j]['code'] + '">' + json['shipping_method'][i]['quote'][j]['title'] + '</label></td>';
							html += '  <td style="text-align: right;"><label for="' + json['shipping_method'][i]['quote'][j]['code'] + '">' + json['shipping_method'][i]['quote'][j]['text'] + '</label></td>';
							html += '</tr>';
						}		
					} else {
						html += '<tr>';
						html += '  <td colspan="3"><div class="error">' + json['shipping_method'][i]['error'] + '</div></td>';
						html += '</tr>';						
					}
				}
				
				html += '  </table>';
				html += '  <br />';
				html += '  <input type="hidden" name="next" value="shipping" />';
				
				<?php if ($shipping_method) { ?>
				html += '  <input type="submit" value="<?php echo $button_shipping; ?>" id="button-shipping" class="button" />';	
				<?php } else { ?>
				html += '  <input type="submit" value="<?php echo $button_shipping; ?>" id="button-shipping" class="button" disabled="disabled" />';	
				<?php } ?>
							
				html += '</form>';
				
				$.colorbox({
					overlayClose: true,
					opacity: 0.5,
					width: '600px',
					height: '400px',
					href: false,
					html: html
				});
				
				$('input[name=\'shipping_method\']').bind('change', function() {
					$('#button-shipping').attr('disabled', false);
				});
			}
		}
	});
});
//--></script> 
<script type="text/javascript"><!--
$('select[name=\'country_id\']').bind('change', function() {
	$.ajax({
		url: 'index.php?route=checkout/cart/country&country_id=' + this.value,
		dataType: 'json',
		beforeSend: function() {
			$('select[name=\'country_id\']').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
		},
		complete: function() {
			$('.wait').remove();
		},			
		success: function(json) {
			if (json['postcode_required'] == '1') {
				$('#postcode-required').show();
			} else {
				$('#postcode-required').hide();
			}
			
			html = '<option value=""><?php echo $text_select; ?></option>';
			
			if (json['zone'] != '') {
				for (i = 0; i < json['zone'].length; i++) {
        			html += '<option value="' + json['zone'][i]['zone_id'] + '"';
	    			
					if (json['zone'][i]['zone_id'] == '<?php echo $zone_id; ?>') {
	      				html += ' selected="selected"';
	    			}
	
	    			html += '>' + json['zone'][i]['name'] + '</option>';
				}
			} else {
				html += '<option value="0" selected="selected"><?php echo $text_none; ?></option>';
			}
			
			$('select[name=\'zone_id\']').html(html);
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('select[name=\'country_id\']').trigger('change');
//--></script>
<?php } ?>
<?php echo $footer; ?>
