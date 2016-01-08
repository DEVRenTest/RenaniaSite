<?php echo $header; ?>
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
<div id="content"><?php echo $content_top; ?>
    <div class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
        <?php } ?>
    </div>
    <h1>
        <?= $heading_title; ?>
    </h1>
    <?php /* if ($saved_carts) { ?>
        <?php foreach ($saved_carts as $cart) { ?>
        <div class="saved_cart_name_container">
            <input class="saved_cart_name" type="text" value="<?= $cart['cart_name']; ?>" name="cart_name_<?= $cart['cart_id']; ?>" cart="<?= $cart['cart_id']; ?>" />
            <a class="button update_saved_cart_name_btn" id="name_update_btn_<?= $cart['cart_id']; ?>">Renumire cos</a>
            <span class="success" style="display: none; margin-left: 10px;">Actualizarea numelui cosului s-a efectuat cu success!</span>
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
        <div class="cart-total ok">
            <a class="button ask_delete_saved_cart"><?= $button_remove; ?></a>
            <span class="confirm_delete_saved_cart" style="display:none;">
                <span>Sunteti sigur?</span>
                <a class="button" href="<?= $delete_cart_action; ?>&cart_id=<?= $cart['cart_id']; ?>">DA</a>
                <a class="button dont_delete_saved_cart">NU</a>
            </span>
            <a class="button button_blue ask_activate_cart" cart_id="<?= $cart['cart_id']; ?>">Activeaza cos</a>
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
        <?php } ?>
    <?php } */ ?>

    <?php  if ($B2B && $connected_carts) { ?>
        <?php foreach ($connected_carts as $cart) {  ?>
        <div class="saved_cart_name_container">
            <p class="saved_cart_name"><strong><?= $cart['cart_name']; ?></strong> de la <?= $cart['firstname']." ".$cart['lastname']; ?></p>
        </div>
        <div class="cart-info connected_cart">
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
                <?php echo "<pre>"; var_dump($cart); /* foreach ($cart['products'] as $product) { ?>
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
            <?php foreach ($cart['support'] as $support) {  ?>
            <div class="support_message">
                <?php if ($support['cart_owner']) { ?>
                <div class="support_culomn_left"></div>
                <div class="support_culomn_right active_msg">
                    <div class="support_head">
                        <div class="customer_name"><?= $support['lastname']." ".$support['firstname'] ?></div>
                        <div class="date_added"> - <?= $support['date_added'] ?> - </div>
                    </div>
                    <div class="support_content <?= $support['cart_owner'] ?> supp1">
                        <p><?= $support['subject'] ?></p>
                        <p><?= $support['message'] ?></p>
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
                                <input type="text" name="quantity" value="<?= $support['quantity'] ?>">
                            </div>
                            <div class="cart_support_price">
                            </div>
                            <div class="asked_sup_pr_to_cart">
                                <a class="button sup_pr_to_cart_btn" id="<?= $cart['cart_id'] ?>">Adauga la cos</a>
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
                    <div class="support_content <?= $support['cart_owner'] ?> supp2">
                        <p><?= $support['subject'] ?></p>
                        <p><?= $support['message'] ?></p>
                    </div>
                </div>
                <div class="support_culomn_right"></div>
                <?php } ?>
            </div>
            <?php } ?>
        </div>
        <form class="support_direct_body" id="<?= $cart['cart_id'] ?>support_direct_body" style="display: none;" method="POST">
            <input type="hidden" value="<?= $cart['cart_id'] ?>" name="cart_id" >
            <div class="support_search_form" id="<?= $cart['cart_id'] ?>">
                <div class="support_search_part">
                    <div class="support_model">
                        <input type="text" value="" name="filter_model" class="ui-autocomplete-input" id="<?= $cart['cart_id'] ?>support_model" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true" placeholder="Cod produs">
                        <input type="hidden" value="" id="<?= $cart['cart_id'] ?>support_product_id" name="product_id" >
                    </div>
                    <div class="support_name">
                        <input type="text" value="" name="filter_name" class="ui-autocomplete-input" id="<?= $cart['cart_id'] ?>support_name" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true" placeholder="Denumire">
                    </div>
                    <div class="support_color">
                        <input type="hidden" value="" id="<?= $cart['cart_id'] ?>color_product_option_id" name="color_product_option_id">
                        <select disabled name="filter_color" id="<?= $cart['cart_id'] ?>color_product_option_value_id" class="<?= $cart['cart_id'] ?>options" name="option">
                            <option value=""></option>
                        </select>
                    </div>
                    <div class="support_size">
                        <input type="text" value="" id="<?= $cart['cart_id'] ?>size_product_option_id" name="size_product_option_id" style="display: none;">
                        <select disabled name="filter_size" id="<?= $cart['cart_id'] ?>size_product_option_value_id" class="<?= $cart['cart_id'] ?>options" name="option">
                            <option value=""><?= $select_size; ?></option>
                        </select>
                    </div>
                    <div class="support_config">
                        <input type="text" disabled value="" name="filter_config" class="ui-autocomplete-input" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true">
                    </div>
                </div>
                <div class="support_search_part">
                    <div class="support_stoc">
                        <div>Stoc</div>
                    </div>
                    <div class="support_price">
                        <div id="<?= $cart['cart_id'] ?>support_price">Pret</div>
                    </div>
                    <div class="support_quantity">
                        <input type="text" disabled value="" name="quantity" class="ui-autocomplete-input" id="<?= $cart['cart_id'] ?>support_quantity" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true" placeholder="Cantitate">
                    </div>
                    <div class="support_total_price">
                        <div id="<?= $cart['cart_id'] ?>support_total_price">Total</div>
                        <input type="hidden" disabled value="" name="total_price">
                        <input type="hidden" disabled value="" name="currency">
                    </div>
                </div>
            </div>
            <input type="text" name="support_subject" class="support_subject" id="<?= $cart['cart_id'] ?>support_subject" placeholder="Subiect" />
            <span class="error" style="display: none;">Subiectul trebuie sa fie inter 3 si 250 charactere!</span>
            <textarea name="support_message" class="support_message" id="<?= $cart['cart_id'] ?>support_message" placeholder="Mesaj"></textarea>
            <span class="error" style="display: none;">Mesajul trebuie sa fie inter 3 si 250 charactere!</span>
            <a class="button new_support_direct_btn fff" data-cart_id="<?= $cart[cart_id]; ?>">Trimite</a>
            <span class="success support_sent_alert" id="<?= $cart['cart_id'] ?>support_sent" style="display: none;">Supportul a fost trimis!</span>
        </form>

        <?php } ?>
    <?php } ?>
    <?php if ($B2B && $support_carts) { ?>
        <?php foreach ($support_carts as $cart) { ?>
        <div class="saved_cart_name_container">
            <p class="saved_cart_name"><strong><?= $cart['cart_name']; ?></strong> de la <?= $cart['firstname']." ".$cart['lastname']; ?></p>
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
                <?php /* ?>
                <div class="saved_bottom_buttons">
                    <a class="button ask_delete_saved_cart"><?= $button_remove; ?></a>
                                <span class="confirm_delete_saved_cart" style="display:none;">
                                    <span>Sunteti sigur?</span>
                                    <a class="button" href="<?= $delete_cart_action; ?>&cart_id=<?= $cart['cart_id']; ?>">DA</a>
                                    <a class="button dont_delete_saved_cart">NU</a>
                                </span>
                    <a class="button button_blue ask_activate_cart" cart_id="<?= $cart['cart_id']; ?>">Activeaza cos</a>
                </div>
                <?php */ ?>
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
            <?php foreach ($cart['support'] as $support) {  ?>
            <div class="support_message">
                <?php if ($support['cart_owner']) { ?>
                <div class="support_culomn_left"></div>
                <div class="support_culomn_right active_msg">
                    <div class="support_head">
                        <div class="customer_name"><?= $support['lastname']." ".$support['firstname'] ?></div>
                        <div class="date_added"> - <?= $support['date_added'] ?> - </div>
                    </div>
                    <div class="support_content <?= $support['cart_owner'] ?> supp3">
                        <p><?= $support['subject'] ?></p>
                        <p><?= $support['message'] ?></p>
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
                                <input type="text" name="quantity" value="<?= $support['quantity'] ?>">
                            </div>
                            <div class="cart_support_price">
                            </div>
                            <div class="asked_sup_pr_to_cart">
                                <!-- admin cant add product to cart -->
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
                                <input type="text" name="quantity" value="<?= $support['quantity'] ?>">
                            </div>
                            <div class="cart_support_price">
                            </div>
                            <div class="asked_sup_pr_to_cart">

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
            <div class="support_search_form" id="<?= $cart['cart_id'] ?>">
                <div class="support_search_part">
                    <div class="support_model">
                        <input type="text" value="" name="filter_model" class="ui-autocomplete-input" id="<?= $cart['cart_id'] ?>support_model" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true" placeholder="Cod produs">
                        <input type="hidden" value="" id="<?= $cart['cart_id'] ?>support_product_id" name="product_id" >
                    </div>
                    <div class="support_name">
                        <input type="text" value="" name="filter_name" class="ui-autocomplete-input" id="<?= $cart['cart_id'] ?>support_name" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true" placeholder="Denumire">
                    </div>
                    <div class="support_color">
                        <input type="hidden" value="" id="<?= $cart['cart_id'] ?>color_product_option_id" name="color_product_option_id">
                        <select disabled name="filter_color" id="<?= $cart['cart_id'] ?>color_product_option_value_id" class="<?= $cart['cart_id'] ?>options" name="option">
                            <option value=""></option>
                        </select>
                    </div>
                    <div class="support_size">
                        <input type="text" value="" id="<?= $cart['cart_id'] ?>size_product_option_id" name="size_product_option_id" style="display: none;">
                        <select disabled name="filter_size" id="<?= $cart['cart_id'] ?>size_product_option_value_id" class="<?= $cart['cart_id'] ?>options" name="option">
                            <option value=""><?= $select_size; ?></option>
                        </select>
                    </div>
                    <div class="support_config">
                        <input type="text" disabled value="" name="filter_config" class="ui-autocomplete-input" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true">
                    </div>
                </div>
                <div class="support_search_part">
                    <div class="support_stoc">
                        <div>Stoc</div>
                    </div>
                    <div class="support_price">
                        <div id="<?= $cart['cart_id'] ?>support_price">Pret</div>
                    </div>
                    <div class="support_quantity">
                        <input type="text" disabled value="" name="quantity" class="ui-autocomplete-input" id="<?= $cart['cart_id'] ?>support_quantity" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true" placeholder="Cantitate">
                    </div>
                    <div class="support_total_price">
                        <div id="<?= $cart['cart_id'] ?>support_total_price">Total</div>
                        <input type="hidden" disabled value="" name="total_price">
                        <input type="hidden" disabled value="" name="currency">
                    </div>
                </div>
            </div>
            <?php /*if ($support_admin) { ?>
            <div id="<?= $cart['cart_id'] ?>add_customer_to_support_container" class="add_customer_to_support_container">
                <input type="hidden" value="<?= $cart['cart_id'] ?>" name="cart_id" >
                <select name="customer_to_support" id="<?= $cart[cart_id]; ?>_customer_to_support_select">
                    <option value="">Adauga B2B</option>
                    <?php foreach ($B2B_customers_to_support as $customer) { ?>
                    <option value="<?= $customer['customer_id'] ?>"><?= $customer['firstname']." ".$customer['lastname']." - ".$customer['ax_code'] ?></option>
                    <?php } ?>
                </select>
                <span class="error" id="<?= $cart[cart_id]; ?>_client_add_error" style="display:none; margin-left: 10px;">Va rugam sa selectati un client!</span>
                <a class="button add_customer_to_support_btn" data-cart_id="<?= $cart[cart_id]; ?>">Adauga</a>
                <span class="success support_client_added_success" id="<?= $cart[cart_id]; ?>_client_added_success" style="display:none; margin-left: 10px;">Client B2B a fost adaugat la support!</span>
            </div>
            <?php } */ ?>
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

    <?php /* START #popup_activate_saved_cart Must be the same on the checkout/cart.tpl */ ?>
    <div class="popup_background" id="popup_activate_saved_cart">
        <div class="popup_container">
            <div class="popup_head">
                <h2>Doriti sa salvati cosul de cumparator?<a class="close_popup_x close_popup">X</a></h2>
            </div>
            <div class="popup_body">
                <div class="buttons">
                    <a class="button" id="get_save_default_cart">DA</a>
                    <a class="button right" id="dont_save_default_cart">NU</a>
                </div>
                <form action="" method="POST" id="save_new_cart_form" style="display: none;">
                    <input type="text" name="cart_name" value="" placeholder="<?= $text_cart_name; ?>" style="width: 90%;">
                    <?php /* ?>
                    <input type="submit" class="button" id="save_new_cart_before_clear_btn" value="<?= $text_save_cart; ?>"/>
                    <?php */ ?>
                    <a class="button" id="save_new_cart_before_clear_btn"><?= $text_save_cart; ?></a>
                    <a class="close_popup button">Anulare</a>
                </form>
            </div>
        </div>
    </div>
    <?php /* END #popup_activate_saved_cart Must be the same on the checkout/cart.tpl */ ?>



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
                        html  = '<h2><?php echo $text_shipping_method; ?></h2>';
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
    <script type="text/javascript">
        $(document).ready(function() {
            $("#default_cart tr:not(.disabled), .saved_cart tr:not(.disabled)").draggable({
                helper: 'clone',
                revert: 'invalid',
                start: function (event, ui) {
                    //$(this).css('opacity', '.5');
                    //var ax_code = $(this).attr('ax_code');
                },
                stop: function (event, ui) {
                    //$(this).css('opacity', '1');
                }
            });

            $("#default_cart, .saved_cart").droppable({
                drop: function (event, ui) {

                    var redirect = false;
                    var target_cart = $(this);
                    var ax_code = ui.draggable.attr("ax_code");
                    var attr = ui.draggable.attr('cart'); // cart_id if come from saved cart
                    var target_saved_cart = false;

                    console.log('ccart id '+attr);

                    if($(this).hasClass("saved_cart")) {
                        var target_cart_id = $(this).find('tbody').attr('id');
                        target_saved_cart = true

                        console.log('target saved cart ' + target_cart_id);
                    } else {
                        console.log('target default '+attr);
                        if (typeof attr === typeof undefined) {
                            return;
                        }
                    }

                    if (target_saved_cart && target_cart_id == attr) { // if both cart is the same saved cart do nothing
                        return;
                    }

                    if (typeof attr !== typeof undefined && attr !== false) { // product come from saved cart

                        var from_default_cart = false;
                        delete_from_saved_cart(attr, ax_code);
                        console.log('from saved cart '+from_default_cart+' '+attr);

                    } else { // product come from default cart

                        //console.log('dddd '+target_cart.find('tbody').attr('class'));

                        if ($(this).hasClass("default_cart")) { // if both cart is the same default cart do nothing
                            return;
                        }

                        var from_default_cart = true;
                        console.log('from default cart '+from_default_cart);

                    }
                    var new_quantity = parseInt(ui.draggable.find(".quantity").find("input").val());

                    if (target_cart.find("[ax_code="+ax_code+"]").length){ // increase quantity if product exist in target cart

                        var exist_quantity = parseInt(target_cart.find("[ax_code=" + ax_code + "]").find(".quantity").find("input").val());

                        var final_quantity = exist_quantity + new_quantity;
                        target_cart.find("[ax_code=" + ax_code + "]").find(".quantity").find("input").attr('value', final_quantity);

                        console.log("product exist "+target_cart.find("[ax_code="+ax_code+"]")+' new quantity: '+new_quantity+' exist quantity: '+exist_quantity);
                        $(ui.draggable).remove();

                        if(from_default_cart) {
                            var remove_link = ui.draggable.find(".quantity").find("a").attr('href');
                            console.log('delete from cart '+remove_link);
                            delete_from_default_cart(remove_link);
                        }

                        update_saved_cart(target_cart_id, ax_code, final_quantity, 'update');

                        redirect = true;

                    } else { // add new product to cart

                        if(target_saved_cart) {
                            console.log('target saved cart ' + $(this).find('tbody').attr('id') + ' new product data: '+ax_code);
                            update_saved_cart(target_cart_id, ax_code, new_quantity, 'insert');
                        } else {
                            add_to_default_cart(ax_code, new_quantity);
                        }

                        if(from_default_cart) {
                            var remove_link = ui.draggable.find(".quantity").find("a").attr('href');
                            //console.log('delete from Default cart '+remove_link);
                            delete_from_default_cart(remove_link);
                        } else {
                            console.log('delete from saved cart');
                        }

                        $(ui.draggable).appendTo(this);

                        $(this).find("[ax_code="+ax_code+"]").attr('cart', target_cart_id);
                        console.log("new product");

                        redirect = true;
                    }

                    //console.log('class '+$(this).attr('class'));

                    console.log('coming '+ax_code);

                    if (redirect == true) {
                        location.reload();
                    }
                }

            });

            function delete_from_saved_cart(cart_id, ax_code) {
                $.ajax({
                    url: 'index.php?route=checkout/cart/delete_from_saved_cart',
                    type: 'post',
                    async: false,
                    data: {cart_id:cart_id, ax_code:ax_code},
                    dataType: 'json',
                    success: function (json) {

                    }
                });
            }

            function add_to_default_cart(ax_code, quantity) {
                console.log('new product to default cart');

                var product_to_add = "";

                $.ajax({
                    url: 'index.php?route=checkout/cart/get_option_data',
                    type: 'post',
                    async: false,
                    data: {ax_code: ax_code},
                    dataType: 'json',
                    success: function(json) {

                        console.log(json.product_id);

                        $.ajax({
                            url: 'index.php?route=checkout/cart/add',
                            type: 'post',
                            async: false,
                            data: {product_id:json.product_id, option:json.option, quantity:quantity},
                            dataType: 'json',
                            success: function(json) {
                                $('.success, .warning, .attention, information, .error').remove();

                                if (json['error']) {
                                    if (json['error']['option']) {

                                        if(!jQuery.isEmptyObject(json['error']))
                                        {
                                            $('.option-combo-warning').html('<span class="error">Selectati cel putin 1 optiune!</span>');
                                        }

                                        for (i in json['error']['option']) {
                                            $('#option-' + i).after('<span class="error">' + json['error']['option'][i] + '</span>');
                                        }
                                    }

                                    if (json['error']['profile']) {
                                        $('select[name="profile_id"]').after('<span class="error">' + json['error']['profile'] + '</span>');
                                    }
                                }

                                if (json['success']) {
                                    $('#notification').html('<div class="success" style="display: none;">' + json['success'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');

                                    $('.success').fadeIn('slow');

                                    $('#cart-total').html(json['total']);

                                    $('html, body').animate({ scrollTop: 0 }, 'slow');
                                }
                            }
                        });
                    }
                });


            }

            function delete_from_default_cart(remove_link) {
                $.ajax({
                    url: 'index.php?route=checkout/cart/delete_from_default_cart',
                    type: 'POST',
                    async: false,
                    data: { remove_link: remove_link} ,
                    dataType: 'json',
                    success: function (response) {
                        console.log('deleted from default cart '+response+ " id");
                        //var obj = jQuery.parseJSON(response);
                        if (response) {
                            //alert('Success '+response);
                        }

                    },
                    error: function (response) {
                        console.log("error delete from default cart "+response);
                    }
                });
            }

            $('.saved_update_btn').on('click', function() {
                var ax_code = $(this).closest('tr').attr('ax_code');
                var cart_id = $(this).closest('tr').attr('cart');
                var quantity = $(this).prev().attr('value');

                if(typeof(ax_code) != "undefined" && ax_code !== null && typeof(cart_id) != "undefined" && cart_id !== null && typeof(quantity) != "undefined" && quantity !== null) {
                    $.ajax({
                        url: 'index.php?route=checkout/cart/update_saved_cart_product_quantity',
                        type: 'POST',
                        async: false,
                        data: {ax_code: ax_code, cart_id: cart_id, quantity:quantity},
                        dataType: 'json',
                        success: function (response) {
                            console.log('Updated saved cart product quantity ' + response + " id");
                            //var obj = jQuery.parseJSON(response);
                            location.reload();

                        },
                        error: function (response) {
                            console.log("Quantity update failed " + response);
                        }
                    });
                }
            });

            $('.saved_delete_product_btn').on('click', function() {
                var ax_code = $(this).closest('tr').attr('ax_code');
                var cart_id = $(this).closest('tr').attr('cart');

                if(typeof(ax_code) != "undefined" && ax_code !== null && typeof(cart_id) != "undefined" && cart_id !== null) {
                    $.ajax({
                        url: 'index.php?route=checkout/cart/delete_from_saved_cart',
                        type: 'POST',
                        async: false,
                        data: {ax_code: ax_code, cart_id: cart_id},
                        dataType: 'json',
                        success: function (response) {
                            console.log('Cart product deleted ' + response + " id");
                            //var obj = jQuery.parseJSON(response);
                            location.reload();

                        },
                        error: function (response) {
                            console.log("Delete failed " + response);
                        }
                    });
                }
            });

            function update_saved_cart(cart_id, ax_code, quantity, action) {
                console.log(cart_id+' '+ax_code+' '+quantity+' '+action);
                $.ajax({
                    url: 'index.php?route=checkout/cart/update_saved_cart',
                    type: 'POST',
                    async: false,
                    data: { cart_id: cart_id, ax_code : ax_code, quantity : quantity, action : action} ,
                    dataType: 'json',
                    success: function (response) {
                        //var obj = jQuery.parseJSON(response);
                        if (response) {
                            console.log('Success '+response);
                        } else {
                            console.log('Update2 '+response);
                        }

                    },
                    error: function (response) {
                        console.log("error "+response);
                    }
                });
            }

            function cart_page_addToCart(product_id, quantity) {

                quantity = typeof(quantity) != 'undefined' ? quantity : 1;

                $.ajax({
                    url: 'index.php?route=checkout/cart/add',
                    type: 'post',
                    async: false,
                    data: 'product_id=' + product_id + '&quantity=' + quantity,
                    dataType: 'json',
                    success: function(json) {
                        $('.success, .warning, .attention, .information, .error').remove();

                        if (json['redirect']) {
                            location = json['redirect'];
                        }

                        if (json['success']) {
                            $('#notification').html('<div class="success" style="display: none;">' + json['success'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');

                            $('.success').fadeIn('slow');

                            $('#cart-total').html(json['total']);

                            $('html, body').animate({ scrollTop: 0 }, 'slow');
                        }
                    }
                });
            }
        });
    </script>
    <?php } ?>
    <?php echo $footer; ?>
