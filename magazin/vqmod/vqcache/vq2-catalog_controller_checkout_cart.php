<?php

class ControllerCheckoutCart extends Controller
{

    private $error = array( );

    public function index()
    {
        $this->language->load( 'checkout/cart' );

        // If parameter received in link, delete the cart data
        if( ! empty( $this->session->data['login_auto_clear_cart'] ) )
        {
            $this->cart->clear();
            unset( $this->session->data['login_auto_clear_cart'] );

            $this->redirect( $this->url->link( 'checkout/cart' ) );
        }

        if( !isset( $this->session->data['vouchers'] ) )
        {
            $this->session->data['vouchers'] = array( );
        }

        // Update
        if( !empty( $this->request->post['quantity'] ) )
        {
            foreach( $this->request->post['quantity'] as $key => $value )
            {
                $this->cart->update( $key, $value );
            }

            unset( $this->session->data['shipping_method'] );
            unset( $this->session->data['shipping_methods'] );
            unset( $this->session->data['payment_method'] );
            unset( $this->session->data['payment_methods'] );
            unset( $this->session->data['reward'] );

            $this->redirect( $this->url->link( 'checkout/cart' ) );
        }

        // Remove
        if( isset( $this->request->get['remove'] ) )
        {
            $this->cart->remove( $this->request->get['remove'] );

            unset( $this->session->data['vouchers'][$this->request->get['remove']] );

            $this->session->data['success'] = $this->language->get( 'text_remove' );

            unset( $this->session->data['shipping_method'] );
            unset( $this->session->data['shipping_methods'] );
            unset( $this->session->data['payment_method'] );
            unset( $this->session->data['payment_methods'] );
            unset( $this->session->data['reward'] );

            $this->redirect( $this->url->link( 'checkout/cart' ) );
        }

        // Coupon    
        if( isset( $this->request->post['coupon'] ) && $this->validateCoupon() )
        {
            $this->session->data['coupon'] = $this->request->post['coupon'];

            $this->session->data['success'] = $this->language->get( 'text_coupon' );

            $this->redirect( $this->url->link( 'checkout/cart' ) );
        }

        // Voucher
        if( isset( $this->request->post['voucher'] ) && $this->validateVoucher() )
        {
            $this->session->data['voucher'] = $this->request->post['voucher'];

            $this->session->data['success'] = $this->language->get( 'text_voucher' );

            $this->redirect( $this->url->link( 'checkout/cart' ) );
        }

        // Reward
        if( isset( $this->request->post['reward'] ) && $this->validateReward() )
        {
            $this->session->data['reward'] = abs( $this->request->post['reward'] );

            $this->session->data['success'] = $this->language->get( 'text_reward' );

            $this->redirect( $this->url->link( 'checkout/cart' ) );
        }

        $B2B = false;
        if ( in_array( $this->customer->getCustomerGroupId(), array( 3,4 ) )  ) // B2B 
        {
            $B2B = true;
        }
        $this->data['B2B'] = $B2B;

        $this->data['takata'] = false;
        if(strpos($_SERVER['SERVER_NAME'], 'akata')){
            $this->data['takata'] = true;
        }
            
//        if ( !$B2B )
//        {
            // Shipping
            if( isset( $this->request->post['shipping_method'] ) && $this->validateShipping() )
            {
                $shipping = explode( '.', $this->request->post['shipping_method'] );

                $this->session->data['shipping_method'] = $this->session->data['shipping_methods'][$shipping[0]]['quote'][$shipping[1]];

                $this->session->data['success'] = $this->language->get( 'text_shipping' );

                $this->redirect( $this->url->link( 'checkout/cart' ) );
            }
//        }

        $this->document->setTitle( $this->language->get( 'heading_title' ) );
        $this->document->addScript( 'catalog/view/javascript/jquery/colorbox/jquery.colorbox-min.js' );
        $this->document->addStyle( 'catalog/view/javascript/jquery/colorbox/colorbox.css' );

        $this->data['breadcrumbs'] = array( );

        $this->data['breadcrumbs'][] = array(
            'href' => $this->url->link( 'common/home' ),
            'text' => $this->language->get( 'text_home' ),
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'href' => $this->url->link( 'checkout/cart' ),
            'text' => $this->language->get( 'heading_title' ),
            'separator' => $this->language->get( 'text_separator' )
        );

        if( $this->cart->hasProducts() || !empty( $this->session->data['vouchers'] ) )
        {
            $points = $this->customer->getRewardPoints();

            $points_total = 0;

            foreach( $this->cart->getProducts() as $product )
            {
                if( $product['points'] )
                {
                    $points_total += $product['points'];
                }
            }

            $this->data['heading_title'] = $this->language->get( 'heading_title' );

            $this->data['text_next'] = $this->language->get( 'text_next' );
            $this->data['text_next_choice'] = $this->language->get( 'text_next_choice' );
            $this->data['text_use_coupon'] = $this->language->get( 'text_use_coupon' );
            $this->data['text_use_voucher'] = $this->language->get( 'text_use_voucher' );
            $this->data['text_use_reward'] = sprintf( $this->language->get( 'text_use_reward' ), $points );
            $this->data['text_shipping_estimate'] = $this->language->get( 'text_shipping_estimate' );
            $this->data['text_shipping_detail'] = $this->language->get( 'text_shipping_detail' );
            $this->data['text_shipping_method'] = $this->language->get( 'text_shipping_method' );
            $this->data['text_select'] = $this->language->get( 'text_select' );
            $this->data['text_none'] = $this->language->get( 'text_none' );
            $this->data['text_until_cancelled'] = $this->language->get( 'text_until_cancelled' );
            $this->data['text_freq_day'] = $this->language->get( 'text_freq_day' );
            $this->data['text_freq_week'] = $this->language->get( 'text_freq_week' );
            $this->data['text_freq_month'] = $this->language->get( 'text_freq_month' );
            $this->data['text_freq_bi_month'] = $this->language->get( 'text_freq_bi_month' );
            $this->data['text_freq_year'] = $this->language->get( 'text_freq_year' );

            $this->data['text_save_cart'] = $this->language->get( 'text_save_cart' );
            $this->data['text_cart_name'] = $this->language->get( 'text_cart_name' );
            $this->data['text_error'] = $this->language->get( 'text_empty' );

            $this->data['save_cart_action'] = $this->url->link( 'checkout/cart/save_cart' );
            $this->data['delete_cart_action'] = $this->url->link( 'checkout/cart/delete_cart' );

            $this->data['customer_B2B']  = false;

            if( $this->customer->getCustomerGroupId() == 3 || $this->customer->getCustomerGroupId() == 4 )
            {
                $this->data['customer_B2B']  = true;
            }
            

            $this->data['column_image'] = $this->language->get( 'column_image' );
            $this->data['column_name'] = $this->language->get( 'column_name' );
            $this->data['column_model'] = $this->language->get( 'column_model' );
            $this->data['column_quantity'] = $this->language->get( 'column_quantity' );
            $this->data['column_price'] = $this->language->get( 'column_price' );
            $this->data['column_total'] = $this->language->get( 'column_total' );

            $this->data['entry_coupon'] = $this->language->get( 'entry_coupon' );
            $this->data['entry_voucher'] = $this->language->get( 'entry_voucher' );
            $this->data['entry_reward'] = sprintf( $this->language->get( 'entry_reward' ), $points_total );
            $this->data['entry_country'] = $this->language->get( 'entry_country' );
            $this->data['entry_zone'] = $this->language->get( 'entry_zone' );
            $this->data['entry_postcode'] = $this->language->get( 'entry_postcode' );

            $this->data['button_update'] = $this->language->get( 'button_update' );
            $this->data['button_remove'] = $this->language->get( 'button_remove' );
            $this->data['button_coupon'] = $this->language->get( 'button_coupon' );
            $this->data['button_voucher'] = $this->language->get( 'button_voucher' );
            $this->data['button_reward'] = $this->language->get( 'button_reward' );
            $this->data['button_quote'] = $this->language->get( 'button_quote' );
            $this->data['button_shipping'] = $this->language->get( 'button_shipping' );
            $this->data['button_shopping'] = $this->language->get( 'button_shopping' );
            $this->data['button_checkout'] = $this->language->get( 'button_checkout' );

            $this->data['text_trial'] = $this->language->get( 'text_trial' );
            $this->data['text_recurring'] = $this->language->get( 'text_recurring' );
            $this->data['text_length'] = $this->language->get( 'text_length' );
            $this->data['text_recurring_item'] = $this->language->get( 'text_recurring_item' );
            $this->data['text_payment_profile'] = $this->language->get( 'text_payment_profile' );

            if( isset( $this->error['warning'] ) )
            {
                $this->data['error_warning'] = $this->error['warning'];
            }
            elseif( !$this->cart->hasStock() && (!$this->config->get( 'config_stock_checkout' ) || $this->config->get( 'config_stock_warning' )) )
            {
                $this->data['error_warning'] = $this->language->get( 'error_stock' );
            }
            else
            {
                $this->data['error_warning'] = '';
            }

            if( $this->config->get( 'config_customer_price' ) && !$this->customer->isLogged() )
            {
                $this->data['attention'] = sprintf( $this->language->get( 'text_login' ), $this->url->link( 'account/login' ), $this->url->link( 'account/register' ) );
            }
            else
            {
                $this->data['attention'] = '';
            }

            if( isset( $this->session->data['success'] ) )
            {
                $this->data['success'] = $this->session->data['success'];

                unset( $this->session->data['success'] );
            }
            else
            {
                $this->data['success'] = '';
            }

            $this->data['action'] = $this->url->link( 'checkout/cart' );

            if( $this->config->get( 'config_cart_weight' ) )
            {
                $this->data['weight'] = $this->weight->format( $this->cart->getWeight(), $this->config->get( 'config_weight_class_id' ), $this->language->get( 'decimal_point' ), $this->language->get( 'thousand_point' ) );
            }
            else
            {
                $this->data['weight'] = '';
            }

            $this->load->model( 'tool/image' );

            $this->data['products'] = array( );

            $products = $this->cart->getProducts();

            foreach( $products as $product )
            {
                $product_total = 0;

                foreach( $products as $product_2 )
                {
                    if( $product_2['product_id'] == $product['product_id'] )
                    {
                        $product_total += $product_2['quantity'];
                    }
                }

                if( $product['minimum'] > $product_total )
                {
                    $this->data['error_warning'] = sprintf( $this->language->get( 'error_minimum' ), $product['name'], $product['minimum'] );
                }

                if( $product['image'] )
                {
                    $image = $this->model_tool_image->resize( $product['image'], $this->config->get( 'config_image_cart_width' ), $this->config->get( 'config_image_cart_height' ) );
                }
                else
                {
                    $image = $this->model_tool_image->resize('no_image.jpg', $this->config->get('config_image_cart_width'), $this->config->get('config_image_cart_height'));
                }

                $option_data = array( );

                foreach( $product['option'] as $option )
                {
                    if( $option['type'] != 'file' )
                    {
                        $value = $option['option_value'];
                    }
                    else
                    {
                        $filename = $this->encryption->decrypt( $option['option_value'] );

                        $value = utf8_substr( $filename, 0, utf8_strrpos( $filename, '.' ) );
                    }

                    $option_data[] = array(
                        'name' => $option['name'],
                        'value' => (utf8_strlen( $value ) > 20 ? utf8_substr( $value, 0, 20 ).'..' : $value)
                    );
                }

                // Display prices
                if( ($this->config->get( 'config_customer_price' ) && $this->customer->isLogged()) || !$this->config->get( 'config_customer_price' ) )
                {
                    $price = $this->currency->format( $this->tax->calculate( $product['price'], $product['tax_class_id'], $this->config->get( 'config_tax' ) ) );
                }
                else
                {
                    $price = false;
                }

                // Display prices
                if( ($this->config->get( 'config_customer_price' ) && $this->customer->isLogged()) || !$this->config->get( 'config_customer_price' ) )
                {
                    $total = $this->currency->format( $this->tax->calculate( $product['price'], $product['tax_class_id'], $this->config->get( 'config_tax' ) ) * $product['quantity'] );
                }
                else
                {
                    $total = false;
                }

                $profile_description = '';

                if( $product['recurring'] )
                {
                    $frequencies = array(
                        'day' => $this->language->get( 'text_day' ),
                        'week' => $this->language->get( 'text_week' ),
                        'semi_month' => $this->language->get( 'text_semi_month' ),
                        'month' => $this->language->get( 'text_month' ),
                        'year' => $this->language->get( 'text_year' ),
                    );

                    if( $product['recurring_trial'] )
                    {
                        $recurring_price = $this->currency->format( $this->tax->calculate( $product['recurring_trial_price'] * $product['quantity'], $product['tax_class_id'], $this->config->get( 'config_tax' ) ) );
                        $profile_description = sprintf( $this->language->get( 'text_trial_description' ), $recurring_price, $product['recurring_trial_cycle'], $frequencies[$product['recurring_trial_frequency']], $product['recurring_trial_duration'] ).' ';
                    }

                    $recurring_price = $this->currency->format( $this->tax->calculate( $product['recurring_price'] * $product['quantity'], $product['tax_class_id'], $this->config->get( 'config_tax' ) ) );

                    if( $product['recurring_duration'] )
                    {
                        $profile_description .= sprintf( $this->language->get( 'text_payment_description' ), $recurring_price, $product['recurring_cycle'], $frequencies[$product['recurring_frequency']], $product['recurring_duration'] );
                    }
                    else
                    {
                        $profile_description .= sprintf( $this->language->get( 'text_payment_until_canceled_description' ), $recurring_price, $product['recurring_cycle'], $frequencies[$product['recurring_frequency']], $product['recurring_duration'] );
                    }
                }


                $this->load->model( 'checkout/cart' );
                $ax_code = '';
                //echo "<pre>"; print_r($product); die('212');

                if (sizeof($option_data) == 2) {
                    $type = 3;
                    $ax_code = $this->model_checkout_cart->getProductAxCode(3, $product, $product['option'], '');
                    if ($product['model'] == '81016-00L') {
                        //die('get ax_code 1'.$ax_code);
                    }
                } elseif (sizeof($option_data) == 1) {
                    $type = 2;
                    $ax_code = $this->model_checkout_cart->getProductAxCode(2, $product, '', $product['option'][0]['product_option_value_id']);
                    if ($product['model'] == '81016-00L') {
                        //die('get ax_code 2 '.$ax_code);
                    }
                } else {
                    $type = 1;
                    $ax_code = $this->model_checkout_cart->getProductAxCode(1, $product, '', '');
                    if ($product['model'] == '81016-00L') {
                        //die('get ax_code 3 '.$ax_code);
                    }
                }

                if (!$ax_code) {
                    $mail = new Mail();
                    $mail->protocol = $this->config->get( 'config_mail_protocol' );
                    $mail->parameter = $this->config->get( 'config_mail_parameter' );
                    $mail->hostname = $this->config->get( 'config_smtp_host' );
                    $mail->username = $this->config->get( 'config_smtp_username' );
                    $mail->password = $this->config->get( 'config_smtp_password' );
                    $mail->port = $this->config->get( 'config_smtp_port' );
                    $mail->timeout = $this->config->get( 'config_smtp_timeout' );

                    $mail->setTo( 'attila@grafx.ro;claudia.grec@renania.ro' );

                    $mail->setFrom($this->config->get('config_email'));
                    $mail->setSender('DEV Renania ax code');

                    $subject = "ax code";
                    $message = "Date ax incorrecte la produsul cu model <strong>".$product['model']."</strong>";
                    $mail->setSubject( html_entity_decode( $subject, ENT_QUOTES, 'UTF-8' ) );
                    $mail->setHtml( html_entity_decode( $message, ENT_QUOTES, 'UTF-8' ) );
                    $mail->send();
                }
            


                $this->load->model('catalog/product');

                if(isset($result['product_id']))

                {

                    $product['product_id'] = $result['product_id'];

                }

                $option_combo_setting = $this->model_catalog_product->getProductOptionComboSetting($product['product_id']);

                $option_combo_quantity_box = isset($option_combo_setting['quantity_box']) ? $option_combo_setting['quantity_box'] : true;

            
                $this->data['products'][] = array(


                'quantity_box' => $option_combo_quantity_box,

            
                    'key' => $product['key'],
                  'ax_code' => $ax_code,
                    'thumb' => $image,
                    'name' => $product['name'],
                    'model' => $product['model'],
                    'option' => $option_data,
                    'quantity' => $product['quantity'],
                    'stock' => $product['stock'] ? true : !(!$this->config->get( 'config_stock_checkout' ) || $this->config->get( 'config_stock_warning' )),
                    'reward' => ($product['reward'] ? sprintf( $this->language->get( 'text_points' ), $product['reward'] ) : ''),
                    'price' => $price,
                    'total' => $total,
                    'href' => $this->url->link( 'product/product', 'product_id='.$product['product_id'] ),
                    'remove' => $this->url->link( 'checkout/cart', 'remove='.$product['key'] ),
                    'recurring' => $product['recurring'],
                    'profile_name' => $product['profile_name'],
                    'profile_description' => $profile_description,
                );
            }



            //echo "<pre>"; print_r($this->data); /*print_r($this->cart);*/ die('1212');
            
            $this->data['products_recurring'] = array( );

            // Gift Voucher
            $this->data['vouchers'] = array( );


            if ($B2B) {
                $this->load->model( 'checkout/cart' );
                $this->load->model( 'setting_email_address/setting_email_address' );

                $this->language->load('total/sub_total');
                $this->language->load('total/total');

                $taxes = $this->cart->getTaxes();

                $this->data['text_sub_total'] = $this->language->get('text_sub_total');
                //$this->data['text_tax'] = $this->db->query("SElECT * FROM `oc_tax_rate` WHERE `tax_rate_id` = ".key($taxes).";")->row['name'];
                $this->data['text_tax'] = $this->db->query("SElECT * FROM `oc_tax_rate` WHERE `tax_rate_id` = 86;")->row['name'];
                $this->data['text_total'] = $this->language->get('text_total');

                //$store_id = $this->config->get('config_store_id');
                $store_id = 1;
                $customer_group_id = $this->customer->getCustomerGroupId();

                $customer_email = $this->customer->getEmail();

                $support_email = $this->model_setting_email_address_setting_email_address->getEmailAddress( "SUPPORT_DIRECT" );

                $match = strpos("  ".$support_email['email'], $customer_email);

                if ($match) {
                    $this->data['support_admin'] = true;
                    $this->data['support_carts'] = $this->model_checkout_cart->getSupportCarts($customer_group_id);
                    $this->data['B2B_customers_to_support'] = $this->model_checkout_cart->getB2BUsers();
                    // echo "<pre>"; print_r($this->data['support_carts']); die('contr dfadfba');
                } else {
                    $this->data['support_admin'] = false;
                    $this->data['support_carts'] = "";
                    $this->data['B2B_customers_to_support'] = "";
                }

                $this->data['connected_carts'] = $this->model_checkout_cart->getConnectedCarts($this->session->data['customer_id'], $customer_group_id);
                // echo "<pre>"; print_r($this->data['connected_carts']); die('opencart/vqmod/xml/multiple_cart.xml:109');
                if ($this->data['connected_carts']) {
                    foreach ($this->data['connected_carts'] as &$cart) {

                        $cart['sub_total'] = 0;
                        $cart['tax'] = 0;

                        foreach ($cart['products'] as &$product) {
                            if( $product['image'] )
                            {
                                $product['image'] = $this->model_tool_image->resize( $product['image'], $this->config->get( 'config_image_cart_width' ), $this->config->get( 'config_image_cart_height' ) );
                            }
                            else
                            {
                                $product['image'] = '';
                            }

                            if( $product['tax_class_id'] )
                            {
                                $tax_rates = $this->tax->getRates( $product['price'], $product['tax_class_id'] );

                                foreach( $tax_rates as $tax_rate )
                                {
                                    /*if( !isset( $tax_data[$tax_rate['tax_rate_id']] ) )
                                    {
                                        $cart['tax'] = ($tax_rate['amount'] * $product['quantity']);
                                    }
                                    else
                                    {
                                        $cart['tax'] += ($tax_rate['amount'] * $product['quantity']);
                                    }*/

                                    $cart['tax'] += ($tax_rate['amount'] * $product['quantity']);
                                }
                            }

                            if( ($this->config->get( 'config_customer_price' ) && $this->customer->isLogged()) || !$this->config->get( 'config_customer_price' ) )
                            {
                                $product['total'] = $this->currency->format( $this->tax->calculate( $product['price'], $product['tax_class_id'], $this->config->get( 'config_tax' ) ) * $product['quantity'] );
                                $cart['sub_total'] += $this->tax->calculate( $product['price'], $product['tax_class_id'], $this->config->get( 'config_tax' ) ) * $product['quantity'];
                            }
                            else
                            {
                                $product['total'] = false;
                            }

                            if( ($this->config->get( 'config_customer_price' ) && $this->customer->isLogged()) || !$this->config->get( 'config_customer_price' ) )
                            {
                                $product['price'] = $this->currency->format( $this->tax->calculate( $product['price'], $product['tax_class_id'], $this->config->get( 'config_tax' ) ) );
                            }
                            else
                            {
                                $product['price'] = false;
                            }

                            //echo "cart tax/product<pre>"; print_r($cart['tax']);

                            //$this->url->link( 'product/product', 'product_id='.$product['product_id'] )\

                        } // die('sadvs');
                        $cart['total'] = $cart['sub_total'] + $cart['tax'];
                    }
                }

                /*echo $this->session->data['customer_id']." ".$customer_group_id." ".$store_id."<br>";
                die('advsdvsadvs');*/

                $this->data['saved_carts'] = $this->model_checkout_cart->getCarts($this->session->data['customer_id'], $customer_group_id, $store_id);

                // echo "<pre>"; print_r($this->data['saved_carts']); die('opencart/vqmod/xml/multiple_cart.xml:175');

                if ($this->data['support_carts']) {
                    foreach ($this->data['support_carts'] as &$cart) {

                        $cart['sub_total'] = 0;
                        $cart['tax'] = 0;

                        foreach ($cart['products'] as &$product) {
                            if( $product['image'] )
                            {
                                $product['image'] = $this->model_tool_image->resize( $product['image'], $this->config->get( 'config_image_cart_width' ), $this->config->get( 'config_image_cart_height' ) );
                            }
                            else
                            {
                                $product['image'] = '';
                            }

                            if( $product['tax_class_id'] )
                            {
                                $tax_rates = $this->tax->getRates( $product['price'], $product['tax_class_id'] );

                                foreach( $tax_rates as $tax_rate )
                                {
                                    /*if( !isset( $tax_data[$tax_rate['tax_rate_id']] ) )
                                    {
                                        $cart['tax'] = ($tax_rate['amount'] * $product['quantity']);
                                    }
                                    else
                                    {
                                        $cart['tax'] += ($tax_rate['amount'] * $product['quantity']);
                                    }*/

                                    $cart['tax'] += ($tax_rate['amount'] * $product['quantity']);
                                }
                            }

                            if( ($this->config->get( 'config_customer_price' ) && $this->customer->isLogged()) || !$this->config->get( 'config_customer_price' ) )
                            {
                                $product['total'] = $this->currency->format( $this->tax->calculate( $product['price'], $product['tax_class_id'], $this->config->get( 'config_tax' ) ) * $product['quantity'] );
                                $cart['sub_total'] += $this->tax->calculate( $product['price'], $product['tax_class_id'], $this->config->get( 'config_tax' ) ) * $product['quantity'];
                            }
                            else
                            {
                                $product['total'] = false;
                            }

                            if( ($this->config->get( 'config_customer_price' ) && $this->customer->isLogged()) || !$this->config->get( 'config_customer_price' ) )
                            {
                                $product['price'] = $this->currency->format( $this->tax->calculate( $product['price'], $product['tax_class_id'], $this->config->get( 'config_tax' ) ) );
                            }
                            else
                            {
                                $product['price'] = false;
                            }

                            //echo "cart tax/product<pre>"; print_r($cart['tax']);

                            //$this->url->link( 'product/product', 'product_id='.$product['product_id'] )\

                        } // die('sadvs');
                        $cart['total'] = $cart['sub_total'] + $cart['tax'];
                    }
                }
                //print_r($this->data['saved_carts']); die('opencart/vqmod/xml/multiple_cart.xml:239');

                foreach ($this->data['saved_carts'] as &$cart) {

                    $cart['sub_total'] = 0;
                    $cart['tax'] = 0;

                    foreach ($cart['products'] as &$product) {
                        if( $product['image'] )
                        {
                            $product['image'] = $this->model_tool_image->resize( $product['image'], $this->config->get( 'config_image_cart_width' ), $this->config->get( 'config_image_cart_height' ) );
                        }
                        else
                        {
                            $product['image'] = '';
                        }

                        if( $product['tax_class_id'] )
                        {
                            $tax_rates = $this->tax->getRates( $product['price'], $product['tax_class_id'] );

                            foreach( $tax_rates as $tax_rate )
                            {
                                /*if( !isset( $tax_data[$tax_rate['tax_rate_id']] ) )
                                {
                                    $cart['tax'] = ($tax_rate['amount'] * $product['quantity']);
                                }
                                else
                                {
                                    $cart['tax'] += ($tax_rate['amount'] * $product['quantity']);
                                }*/

                                $cart['tax'] += ($tax_rate['amount'] * $product['quantity']);
                            }
                        }

                        if( ($this->config->get( 'config_customer_price' ) && $this->customer->isLogged()) || !$this->config->get( 'config_customer_price' ) )
                        {
                            $product['total'] = $this->currency->format( $this->tax->calculate( $product['price'], $product['tax_class_id'], $this->config->get( 'config_tax' ) ) * $product['quantity'] );
                            $cart['sub_total'] += $this->tax->calculate( $product['price'], $product['tax_class_id'], $this->config->get( 'config_tax' ) ) * $product['quantity'];
                        }
                        else
                        {
                            $product['total'] = false;
                        }

                        if( ($this->config->get( 'config_customer_price' ) && $this->customer->isLogged()) || !$this->config->get( 'config_customer_price' ) )
                        {
                            $product['price'] = $this->currency->format( $this->tax->calculate( $product['price'], $product['tax_class_id'], $this->config->get( 'config_tax' ) ) );
                        }
                        else
                        {
                            $product['price'] = false;
                        }

                        //echo "cart tax/product<pre>"; print_r($cart['tax']);

                        //$this->url->link( 'product/product', 'product_id='.$product['product_id'] )\

                    } // die('sadvs');
                    $cart['total'] = $cart['sub_total'] + $cart['tax'];
                }
                // echo "<pre>"; print_r($this->data['saved_carts']); die('1sfvdf');
            }
            
            if( !empty( $this->session->data['vouchers'] ) )
            {
                foreach( $this->session->data['vouchers'] as $key => $voucher )
                {
                    $this->data['vouchers'][] = array(
                        'key' => $key,
                        'description' => $voucher['description'],
                        'amount' => $this->currency->format( $voucher['amount'] ),
                        'remove' => $this->url->link( 'checkout/cart', 'remove='.$key )
                    );
                }
            }

            if( isset( $this->request->post['next'] ) )
            {
                $this->data['next'] = $this->request->post['next'];
            }
            else
            {
                $this->data['next'] = '';
            }

            $this->data['coupon_status'] = $this->config->get( 'coupon_status' );

            if( isset( $this->request->post['coupon'] ) )
            {
                $this->data['coupon'] = $this->request->post['coupon'];
            }
            elseif( isset( $this->session->data['coupon'] ) )
            {
                $this->data['coupon'] = $this->session->data['coupon'];
            }
            else
            {
                $this->data['coupon'] = '';
            }

            $this->data['voucher_status'] = $this->config->get( 'voucher_status' );

            if( isset( $this->request->post['voucher'] ) )
            {
                $this->data['voucher'] = $this->request->post['voucher'];
            }
            elseif( isset( $this->session->data['voucher'] ) )
            {
                $this->data['voucher'] = $this->session->data['voucher'];
            }
            else
            {
                $this->data['voucher'] = '';
            }

            $this->data['reward_status'] = ($points && $points_total && $this->config->get( 'reward_status' ));

            if( isset( $this->request->post['reward'] ) )
            {
                $this->data['reward'] = $this->request->post['reward'];
            }
            elseif( isset( $this->session->data['reward'] ) )
            {
                $this->data['reward'] = $this->session->data['reward'];
            }
            else
            {
                $this->data['reward'] = '';
            }

            $this->data['shipping_status'] = $this->config->get( 'shipping_status' ) && $this->config->get( 'shipping_estimator' ) && $this->cart->hasShipping();

            if( isset( $this->request->post['country_id'] ) )
            {
                $this->data['country_id'] = $this->request->post['country_id'];
            }
            elseif( isset( $this->session->data['shipping_country_id'] ) )
            {
                $this->data['country_id'] = $this->session->data['shipping_country_id'];
            }
            else
            {
                $this->data['country_id'] = $this->config->get( 'config_country_id' );
            }

            $this->load->model( 'localisation/country' );

            $this->data['countries'] = $this->model_localisation_country->getCountries();

            if( isset( $this->request->post['zone_id'] ) )
            {
                $this->data['zone_id'] = $this->request->post['zone_id'];
            }
            elseif( isset( $this->session->data['shipping_zone_id'] ) )
            {
                $this->data['zone_id'] = $this->session->data['shipping_zone_id'];
            }
            else
            {
                $this->data['zone_id'] = '';
            }

            if( isset( $this->request->post['postcode'] ) )
            {
                $this->data['postcode'] = $this->request->post['postcode'];
            }
            elseif( isset( $this->session->data['shipping_postcode'] ) )
            {
                $this->data['postcode'] = $this->session->data['shipping_postcode'];
            }
            else
            {
                $this->data['postcode'] = '';
            }
//print $this->session->data['shipping_method']['code'];;
//die();
            if( isset( $this->request->post['shipping_method'] ) )
            {
                $this->data['shipping_method'] = $this->request->post['shipping_method'];
            }
            elseif( isset( $this->session->data['shipping_method'] ) )
            {
                $this->data['shipping_method'] = ''; $this->session->data['shipping_method']['code'];
            }
            else
            {
                $this->data['shipping_method'] = '';
            }

            // Totals
            $this->load->model( 'setting/extension' );

            $total_data = array( );
            $total = 0;
            $taxes = $this->cart->getTaxes();
            
            
//            $B2B = false;
//            if ( in_array( $this->customer->getCustomerGroupId(), array( 3,4 ) )  ) // B2B 
//            {
//                $B2B = true;
//            }
//            $this->data['B2B'] = $B2B;

            // Display prices
            if( ($this->config->get( 'config_customer_price' ) && $this->customer->isLogged()) || !$this->config->get( 'config_customer_price' ) )
            {
                $sort_order = array( );

                $results = $this->model_setting_extension->getExtensions( 'total' );

                foreach( $results as $key => $value )
                {
                    $sort_order[$key] = $this->config->get( $value['code'].'_sort_order' );
                }

                array_multisort( $sort_order, SORT_ASC, $results );
//print_r( $results );

                foreach( $results as $result )
                {
                    if( $this->config->get( $result['code'].'_status' ) )
                    {
                        $this->load->model( 'total/'.$result['code'] );

                        $this->{'model_total_'.$result['code']}->getTotal( $total_data, $total, $taxes );
                    }

                    $sort_order = array( );

                    foreach( $total_data as $key => $value )
                    {
                        $sort_order[$key] = $value['sort_order'];
                    }
                    
//                    print_r( $total_data );
//                    die();

                    array_multisort( $sort_order, SORT_ASC, $total_data );
                }
            }

            $this->data['totals'] = $total_data;

            $this->data['continue'] = $this->url->link( 'common/home' );

            $this->data['checkout'] = $this->url->link( 'checkout/checkout', '', 'SSL' );

            $this->load->model( 'setting/extension' );

            $this->data['checkout_buttons'] = array( );

            if( file_exists( DIR_TEMPLATE.$this->config->get( 'config_template' ).'/template/checkout/cart.tpl' ) )
            {
                $this->template = $this->config->get( 'config_template' ).'/template/checkout/cart.tpl';
            }
            else
            {
                $this->template = 'default/template/checkout/cart.tpl';
            }

            $this->children = array(

        'common/dream_column_header_top', 'common/dream_column_header_bottom', 'common/dream_column_footer_top', 'common/dream_column_footer_bottom',
      
                'common/column_left',
                'common/column_right',
                'common/content_bottom',
                'common/content_top',
                'common/footer',
                'common/header'
            );

            $this->response->setOutput( $this->render() );
        }
        else
        {
            $this->data['heading_title'] = $this->language->get( 'heading_title' );

            $this->data['text_error'] = $this->language->get( 'text_empty' );

            $this->data['button_continue'] = $this->language->get( 'button_continue' );

            $this->data['continue'] = $this->url->link( 'common/home' );

            unset( $this->session->data['success'] );

            if( file_exists( DIR_TEMPLATE.$this->config->get( 'config_template' ).'/template/error/not_found.tpl' ) )
            {
                $this->template = $this->config->get( 'config_template' ).'/template/error/not_found.tpl';
            }
            else
            {
                $this->template = 'default/template/error/not_found.tpl';
            }

            $this->children = array(

        'common/dream_column_header_top', 'common/dream_column_header_bottom', 'common/dream_column_footer_top', 'common/dream_column_footer_bottom',
      
                'common/column_left',
                'common/column_right',
                'common/content_top',
                'common/content_bottom',
                'common/footer',
                'common/header'
            );

            $this->response->setOutput( $this->render() );
        }
    }


    public function save_cart() {
        if( isset( $this->request->post['cart_name'] ) && !empty( $this->request->post['cart_name']  ) && $this->customer->isLogged() ) {
            $this->load->model( 'checkout/cart' );
            $this->load->model( 'setting/extension' );
            $this->load->model( 'setting/setting' );
            $this->load->model( 'account/customer' );

            $cart_to_save['cart_name'] = $this->request->post['cart_name'];
            $cart_to_save['store_id'] = $this->config->get('config_store_id');
            $cart_to_save['customer_id'] = $this->session->data['customer_id'];

            $customer_info = $this->model_account_customer->getCustomer( $this->session->data['customer_id'] );

            if ( $customer_info ) {
                $cart_to_save['customer_group_id'] = $customer_info['customer_group_id'];
            }

            $cart_to_save['currency_id'] = $this->currency->getId();
            $cart_to_save['currency_code'] = $this->session->data['currency'];
            $cart_to_save['currency_value'] = $this->currency->getValue( $this->currency->getCode() );
            $cart_to_save['language_id'] = $this->config->get( 'config_language_id' );

            $total_data = array( );
            $total = 0;
            $taxes = $this->cart->getTaxes();

            // echo "<pre>";

//            $B2B = false;
//            if ( in_array( $this->customer->getCustomerGroupId(), array( 3,4 ) )  ) // B2B
//            {
//                $B2B = true;
//            }
//            $this->data['B2B'] = $B2B;

            // Display prices
            if( ($this->config->get( 'config_customer_price' ) && $this->customer->isLogged()) || !$this->config->get( 'config_customer_price' ) )
            {
                $sort_order = array( );

                $results = $this->model_setting_extension->getExtensions( 'total' );

                foreach( $results as $key => $value )
                {
                    $sort_order[$key] = $this->config->get( $value['code'].'_sort_order' );
                }

                array_multisort( $sort_order, SORT_ASC, $results );
                //print_r( $results );

                foreach( $results as $result )
                {
                    if( $this->config->get( $result['code'].'_status' ) )
                    {
                        $this->load->model( 'total/'.$result['code'] );

                        $this->{'model_total_'.$result['code']}->getTotal( $total_data, $total, $taxes );
                    }

                    $sort_order = array( );

                    foreach( $total_data as $key => $value )
                    {
                        $sort_order[$key] = $value['sort_order'];
                    }

                    array_multisort( $sort_order, SORT_ASC, $total_data );
                }
            }

            foreach ($total_data as $data) {
                if ($data['code'] == 'total') {
                    $cart_to_save['total'] = $data['value'];
                }
            }

            $this->load->model('tool/image');
            //echo "<pre>"; print_r($this->cart->getProducts()); die('sdvs');

            foreach( $this->cart->getProducts() as $product )
            {
                if( $product['image'] )
                {
                    $image = $this->model_tool_image->resize( $product['image'], $this->config->get( 'config_image_cart_width' ), $this->config->get( 'config_image_cart_height' ) );
                }
                else
                {
                    $image = '';
                }

                $option_data = array( );

                foreach( $product['option'] as $option )
                {
                    if( $option['type'] != 'file' )
                    {
                        $value = $option['option_value'];
                    }
                    else
                    {
                        $value = $this->encryption->decrypt( $option['option_value'] );
                    }

                    $option_data[] = array(
                        'product_option_id' => $option['product_option_id'],
                        'product_option_value_id' => $option['product_option_value_id'],
                        'option_id' => $option['option_id'],
                        'option_value_id' => $option['option_value_id'],
                        'name' => $option['name'],
                        'value' => $value,
                        'type' => $option['type']
                    );
                }

                $product_data[] = array(
                    'product_id' => $product['product_id'],
                    'name' => $product['name'],
                    'image' => $image,
                    'model' => $product['model'],
                    'option' => $option_data,
                    'download' => $product['download'],
                    'quantity' => $product['quantity'],
                    'subtract' => $product['subtract'],
                    'price' => $product['price'],
                    'total' => $product['total'],
                    'tax' => $this->tax->getTax( $product['price'], $product['tax_class_id'] ),
                    'reward' => $product['reward']
                );
            }
            $cart_to_save['products'] = $product_data;
            $cart_to_save['totals'] = $total_data;

            //echo "<pre>"; print_r($cart_to_save); die('2');

            $cart_id = $this->model_checkout_cart->saveCart($cart_to_save);


        }

        $this->clear_cart();

        if(isset($_POST['dont_redirect']) && $_POST['dont_redirect']) {
            echo $cart_id;
        }
        else
        {

            if (isset($_POST['support_subject']) && isset($_POST['support_message']) && $_POST['support_subject'] && $_POST['support_message'])
            {
                $support_data = $_POST;
                $support_data['cart_id'] = $cart_id;
                echo $cart_id." opencart/vqmod/xml/multiple_cart.xml:519 <pre>"; print_r($support_data);

                $new_support = $this->new_support_content($support_data);
            }

            $this->redirect( $this->url->link( 'checkout/cart' ) );
        }
    }

    public function clear_cart() {
		$this->cart->clear();
	}

	public function get_axcodes_and_quantitys() {
	    if (in_array($this->customer->getCustomerGroupId(), array(3,4)) && isset($_POST['cart_id']) && !empty($_POST['cart_id'])) {
	        $get_axcode_and_quantitys = "SELECT ax_code, quantity FROM `oc_cart_product` WHERE `cart_id` = ".$_POST['cart_id'].";";
	        $get_axcode_and_quantitys = $this->db->query($get_axcode_and_quantitys);

	        if ($get_axcode_and_quantitys->num_rows) {
	            $get_axcode_and_quantitys = $get_axcode_and_quantitys->rows;

	            echo json_encode($get_axcode_and_quantitys);
	        } else {
	            die('get_axcode_and_quantitys error 1');
	        }
	    } else {
            die('get_axcode_and_quantitys error 2');
        }
	}

    public function update_saved_cart() {
        if (isset( $this->request->post['cart_id'] ) && !empty( $this->request->post['cart_id']  ) && $this->customer->isLogged()) {

            $this->load->model( 'checkout/cart' );
            $customer_group_id = $this->customer->getCustomerGroupId();

            if ( isset($_POST['action']) && $_POST['action'] == 'insert') {

                $insert = $this->model_checkout_cart->insert_to_saved_cart($_POST['cart_id'], $_POST['ax_code'], $_POST['quantity']);

                //$cart_data = $this->model_checkout_cart->getCartTotalData($customer_group_id, $_POST['cart_id']);
                //print_r($cart_data); die('update insert saved cart');
                echo $insert;

            } elseif (isset($_POST['action']) && $_POST['action'] == 'update') {

                $response = $this->model_checkout_cart->update_cart($_POST['cart_id'], $_POST['ax_code'], $_POST['quantity']);

                //$cart_data = $this->model_checkout_cart->getCartTotalData($customer_group_id, $_POST['cart_id']);
                //print_r($cart_data); die('update update saved cart');
                echo '1';

            } else {
                print('something is wrong');
            }
        }
    }

    public function update_saved_cart_name () {
        if (isset($_POST['cart_id']) && !empty($_POST['cart_id']) && isset($_POST['cart_new_name']) && !empty($_POST['cart_new_name'])) {
            $update = "UPDATE `oc_cart` SET `cart_name` = '".$_POST['cart_new_name']."' WHERE `cart_id` = ".$_POST['cart_id'].";";
            $update = $this->db->query($update);

            echo $update;
        } else {
            echo "update failed";
        }
    }

    public function update_saved_cart_product_quantity () {
        if (isset($_POST['cart_id']) && !empty($_POST['cart_id']) && isset($_POST['ax_code']) && !empty($_POST['ax_code']) && isset($_POST['quantity']) && !empty($_POST['quantity'])) {
            $update = "UPDATE `oc_cart_product` SET `quantity` = ".$_POST['quantity']." WHERE `cart_id` = ".$_POST['cart_id']." AND `ax_code` = '".$_POST['ax_code']."';";
            $update = $this->db->query($update);

            echo $update;
        } else {
            echo "update failed";
        }
    }

    public function get_saved_cart_data($cart_id) {
        $store_id = $this->config->get('config_store_id');
        $customer_group_id = $this->customer->getCustomerGroupId();

        $cart_total_data = $this->model_checkout_cart->getCartTotalData($this->session->data['customer_id'], $customer_group_id, $store_id, $cart_id);
    }

    public function get_option_data() {
        if ( isset($_POST['ax_code']) && !empty($_POST['ax_code']) && in_array($this->customer->getCustomerGroupId(), array(3,4)) ) {
            $ax_data = $this->db->query("SELECT ax.*, p.product_id FROM `ax_code` AS ax, oc_product AS p WHERE ax.`ax_code` = '".$_POST['ax_code']."' AND p.upc = ax.upc;")->row;

            /*echo "asfbdf<pre>";
            print_r($ax_data);
            die('asfbdf');*/

            $product_id = $ax_data['product_id'];

            if ( $ax_data ) {

                if ($ax_data['type'] == 3) {

                    $get_options = "SELECT `pocv`.*, ovd.`option_id`, `od`.`name`, `ovd`.`name` AS `value`
                                            FROM `oc_product_option_combination_value` AS pocv, `oc_option_value_description` AS `ovd`, `".DB_PREFIX."option_description` AS `od`
                                            WHERE pocv.`product_option_combination_id` = ".$ax_data['id']."
                                            AND ovd.`language_id` = '".( int ) $this->config->get( 'config_language_id' )."'
                                            AND ovd.`option_value_id` = pocv.`option_value_id`
                                            AND `od`.`option_id` = `ovd`.`option_id`;";

                    $get_options = $this->db->query($get_options)->rows;

                    foreach ($get_options as &$option) {
                        //print_r($option);
                        $option_data = "SELECT * FROM oc_product_option_value WHERE product_id = ".$ax_data['product_id']." AND option_value_id = ".$option['option_value_id'].";";
                        //print_r($option_data);
                        $option_data = $this->db->query($option_data)->rows;

                        //print_r($option_data); die('sfbdf 3 model');
                        $option = array_merge($option, $option_data[0]);
                    }

                    $ax_data = array();

                    $ax_data['product_id'] = $product_id;
                    $ax_data['option'][$get_options[0]['product_option_id']] = $get_options[0]['product_option_value_id'];
                    $ax_data['option'][$get_options[1]['product_option_id']] = $get_options[1]['product_option_value_id'];



                } elseif ($ax_data['type'] == 2) {

                    $get_options = "SELECT `pov`.*, `od`.`name`, `ovd`.`name` AS `value`
                                            FROM `".DB_PREFIX."product_option_value` AS `pov`, `".DB_PREFIX."option_description` AS `od`, `".DB_PREFIX."option_value_description` AS `ovd`
                                            WHERE `product_option_value_id` = ".$ax_data['id']."
                                            AND `od`.`option_id` = `pov`.`option_id`
                                            AND `ovd`.`option_value_id` = `pov`.`option_value_id`;";

                    $get_options = $this->db->query($get_options)->rows;

                    $ax_data = array();

                    $ax_data['product_id'] = $product_id;
                    $ax_data['option'][$get_options[0]['product_option_id']] = $get_options[0]['product_option_value_id'];

                } else {

                    $ax_data = array();
                    $ax_data['product_id'] = $product_id;
                }

                //print_r($ax_data); die('done sfbdf');
                echo json_encode($ax_data);
            }
        }
    }

    public function delete_from_default_cart() {

        $id = substr($_POST['remove_link'], strpos($_POST['remove_link'], 'remove=') + 7);
        //die($id);
        //$product_id = $this->db->query("SELECT `oc_product`.`product_id` FROM `ax_code`, oc_product WHERE ax_code = '".$_POST['ax_code']."' AND oc_product.`upc` = `ax_code`.`upc`;")->row['product_id'];
        if( isset( $this->session->data['cart'][$id] ) ) {
            unset( $this->session->data['cart'][$id] );
            echo "1";
        } else {
            var_dump($_POST['remove_link']);
            echo "delete failed from default cart ".$id;
            print_r($this->cart);
        }
        //$this->cart->remove( $id );
    }

    public function delete_from_saved_cart() {

        if(isset($_POST['cart_id']) && !empty($_POST['cart_id']) && isset($_POST['ax_code']) && !empty($_POST['ax_code'])) {

            $delete = "DELETE FROM oc_cart_product WHERE cart_id = ".$_POST['cart_id']." AND ax_code = '".$_POST['ax_code']."';";
            $delete = $this->db->query($delete);

            $check_if_cart_have_support = "SELECT * FROM oc_cart_support WHERE cart_id = ".$_POST['cart_id'].";";
            //echo $check_if_cart_have_support."<br>";
            $check_if_cart_have_support = $this->db->query($check_if_cart_have_support)->row;

            /*
            echo "<pre>";
            print_r($check_if_cart_have_support);
            */

            if($check_if_cart_have_support){

                $get_prod_data_by_ax = "SELECT * FROM ax_code WHERE ax_code = '".$_POST['ax_code']."';";
                $prod_data_by_ax = $this->db->query($get_prod_data_by_ax)->row;

                $add_action = "INSERT INTO `oc_cart_support_message`
                                SET
                                `cart_support_id` = ".$check_if_cart_have_support['cart_support_id'].",
                                `customer_id` = ".$check_if_cart_have_support['customer_id'].",
                                `cart_id` = ".$_POST['cart_id'].",
                                `type` = 'history',
                                `message` = 'X a sters ".$prod_data_by_ax['product_name']." ".$prod_data_by_ax['upc']."',
                                `date_added` = NOW();";

                //die($add_action);

                $this->db->query($add_action);
            }

            die('sfvsafaf');

            $check_if_cart_have_product = "SELECT * FROM oc_cart_product WHERE cart_id = ".$_POST['cart_id'].";";
            $check_if_cart_have_product = $this->db->query($check_if_cart_have_product)->num_rows;

            if (!$check_if_cart_have_product) {
                 $delete_cart = "DELETE FROM oc_cart WHERE cart_id = ".$_POST['cart_id'].";";
                 $delete_cart = $this->db->query($delete_cart);
            }

            if ($delete) {
                echo "1";
            } else {
                echo "delete from saved cart failed";
            }
        }
    }

    public function delete_cart() {
        if ( isset( $this->request->get['cart_id'] ) && !empty( $this->request->get['cart_id']  ) && $this->customer->isLogged() ) {
            //echo "<pre>"; print_r($_GET); die('delete');
            $this->load->model( 'checkout/cart' );
            $this->model_checkout_cart->deleteCart($this->request->get['cart_id'], $this->session->data['customer_id']);

            echo 1;
            $this->redirect( $this->url->link( 'checkout/cart' ) );
        }
    }

    public function customer_has_saved_cart() {
        if ( $this->customer->isLogged() ) {
            $check_customer_carts = "SELECT COUNT(`customer_id`) AS `id` FROM `oc_cart` WHERE `customer_id` = ".$this->session->data['customer_id'].";";

            $check_customer_carts = $this->db->query($check_customer_carts)->row['id'];

            //die('fuggveny bent '.$check_customer_carts);

            return $check_customer_carts;
        } else {
            return false;
        }

    }

    public function check_if_default_cart_not_empty () {
        if ( $this->customer->isLogged() && in_array( $this->customer->getCustomerGroupId(), array( 3,4 ) )) {

            if ($this->cart->hasProducts()) {
                echo json_encode("not_empty");
            } else {
                echo json_encode("empty");
            }
        } else {
            echo "not logged";
            $this->redirect( $this->url->link( 'account/login' ) );
        }
    }

    private function get_total_data( &$total_data, &$total, &$taxes )
    {
        $total_data = array( );
        $total = 0;
        $taxes = $this->cart->getTaxes();
        $sort_order = array( );

        $results = $this->model_setting_extension->getExtensions( 'total' );

        foreach( $results as $key => $value )
        {
            $sort_order[$key] = $this->config->get( $value['code'].'_sort_order' );
        }

        array_multisort( $sort_order, SORT_ASC, $results );

        foreach( $results as $result )
        {
            if( $this->config->get( $result['code'].'_status' ) )
            {
                $this->load->model( 'total/'.$result['code'] );

                $this->{'model_total_'.$result['code']}->getTotal( $total_data, $total, $taxes );
            }
        }

        $sort_order = array( );

        foreach( $total_data as $key => $value )
        {
            $sort_order[$key] = $value['sort_order'];
        }

        array_multisort( $sort_order, SORT_ASC, $total_data );

        return $total_data;
    }

    public function add_support_history () {
        if ( $this->customer->isLogged() && in_array( $this->customer->getCustomerGroupId(), array( 3,4 ) )) {

            if ( $this->request->post['cart_id'] && $this->request->post['action'] && $this->request->post['ax_code'] ) {
                $add_action = "INSERT INTO oc_cart_support_history SET cart_id = ".$_POST['cart_id'].", action = '".$this->request->post['action']."', ax_code = '".$_POST['ax_code']."', added_at = NOW();";
                //die($add_action);
                $this->db->query($add_action);

                $product_data = $this->getProductDataByAxcode($_POST['ax_code'], 'not all');

                $add_action = "INSERT INTO oc_cart_support_message
                                SET `cart_support_id` = ".$_POST['cart_support_id'].",
                                    `customer_id` = ".$this->customer->getId().",
                                    `cart_id` = ".$_POST['cart_id'].",
                                    `type`='history',
                                    `message` = 'a adaugat in cos ".$product_data['product_name']." ".$product_data['upc']." ".$_POST['ax_code']."',
                                    `date_added` = NOW();";
                $this->db->query($add_action);
            }
        }
    }

    public function getProductDataByAxcode ($ax_code = "", $what = "") {

        $ax_data = "SELECT ax.*, p.product_id FROM `ax_code` AS ax, oc_product AS p WHERE ax.`ax_code` = '".$ax_code."' AND p.upc = ax.upc;";
        //die($ax_data);
        $ax_data = $this->db->query($ax_data)->row;

        $product_id = $ax_data['product_id'];

        if ( $ax_data && $what == 'all' ) {

            if ($ax_data['type'] == 3) {

                $get_options = "SELECT `pocv`.*, ovd.`option_id`, `od`.`name`, `ovd`.`name` AS `value`
                                        FROM `oc_product_option_combination_value` AS pocv, `oc_option_value_description` AS `ovd`, `".DB_PREFIX."option_description` AS `od`
                                        WHERE pocv.`product_option_combination_id` = ".$ax_data['id']."
                                        AND ovd.`language_id` = '".( int ) $this->config->get( 'config_language_id' )."'
                                        AND ovd.`option_value_id` = pocv.`option_value_id`
                                        AND `od`.`option_id` = `ovd`.`option_id`;";

                $get_options = $this->db->query($get_options)->rows;

                foreach ($get_options as &$option) {
                    //print_r($option);
                    $option_data = "SELECT * FROM oc_product_option_value WHERE product_id = ".$ax_data['product_id']." AND option_value_id = ".$option['option_value_id'].";";
                    //print_r($option_data);
                    $option_data = $this->db->query($option_data)->rows;

                    //print_r($option_data); die('sfbdf 3 model');
                    $option = array_merge($option, $option_data[0]);
                }

                $ax_data = array();

                $ax_data['product_id'] = $product_id;
                $ax_data['option'][$get_options[0]['product_option_id']] = $get_options[0]['product_option_value_id'];
                $ax_data['option'][$get_options[1]['product_option_id']] = $get_options[1]['product_option_value_id'];



            } elseif ($ax_data['type'] == 2) {

                $get_options = "SELECT `pov`.*, `od`.`name`, `ovd`.`name` AS `value`
                                        FROM `".DB_PREFIX."product_option_value` AS `pov`, `".DB_PREFIX."option_description` AS `od`, `".DB_PREFIX."option_value_description` AS `ovd`
                                        WHERE `product_option_value_id` = ".$ax_data['id']."
                                        AND `od`.`option_id` = `pov`.`option_id`
                                        AND `ovd`.`option_value_id` = `pov`.`option_value_id`;";

                $get_options = $this->db->query($get_options)->rows;

                $ax_data = array();

                $ax_data['product_id'] = $product_id;
                $ax_data['option'][$get_options[0]['product_option_id']] = $get_options[0]['product_option_value_id'];

            } else {

                $ax_data = array();
                $ax_data['product_id'] = $product_id;
            }

            echo "all data";
            //echo json_encode($ax_data);
        } else {
            return $ax_data;
        }
    }
           
    protected function validateCoupon()
    {
        $this->load->model( 'checkout/coupon' );

        $coupon_info = $this->model_checkout_coupon->getCoupon( $this->request->post['coupon'] );

        if( !$coupon_info )
        {
            $this->error['warning'] = $this->language->get( 'error_coupon' );
        }

        if( !$this->error )
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    protected function validateVoucher()
    {
        $this->load->model( 'checkout/voucher' );
               
        $voucher_info = $this->model_checkout_voucher->getVoucher( $this->request->post['voucher'] );
        if( !$voucher_info )
        {
            $this->error['warning'] = $this->language->get( 'error_voucher' );
        }

        if( !$this->error )
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    protected function validateReward()
    {
        $points = $this->customer->getRewardPoints();

        $points_total = 0;

        foreach( $this->cart->getProducts() as $product )
        {
            if( $product['points'] )
            {
                $points_total += $product['points'];
            }
        }

        if( empty( $this->request->post['reward'] ) )
        {
            $this->error['warning'] = $this->language->get( 'error_reward' );
        }

        if( $this->request->post['reward'] > $points )
        {
            $this->error['warning'] = sprintf( $this->language->get( 'error_points' ), $this->request->post['reward'] );
        }

        if( $this->request->post['reward'] > $points_total )
        {
            $this->error['warning'] = sprintf( $this->language->get( 'error_maximum' ), $points_total );
        }

        if( !$this->error )
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    protected function validateShipping()
    {
        if( !empty( $this->request->post['shipping_method'] ) )
        {
            $shipping = explode( '.', $this->request->post['shipping_method'] );

            if( !isset( $shipping[0] ) || !isset( $shipping[1] ) || !isset( $this->session->data['shipping_methods'][$shipping[0]]['quote'][$shipping[1]] ) )
            {
                $this->error['warning'] = $this->language->get( 'error_shipping' );
            }
        }
        else
        {
            $this->error['warning'] = $this->language->get( 'error_shipping' );
        }

        if( !$this->error )
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function add()
    {
        $this->language->load( 'checkout/cart' );

        $json = array( );

        if( isset( $this->request->post['product_id'] ) )
        {
            $product_id = $this->request->post['product_id'];
        }
        else
        {
            $product_id = 0;
        }

        $this->load->model( 'catalog/product' );

        $product_info = $this->model_catalog_product->getProduct( $product_id );

        if( $product_info )
        {
            if( isset( $this->request->post['quantity'] ) )
            {
                $quantity = $this->request->post['quantity'];
            }
            else
            {
                $quantity = 1;
            }

            


                if(isset($this->request->post['option_combo']))

                {

                    $option_combo = $this->model_catalog_product->getProductOptionComboValues($this->request->post['product_id'], $this->request->post['option_combo']);



                    $option_combo_setting = $this->model_catalog_product->getProductOptionComboSetting($this->request->post['product_id']);

                    $option_combo_quantity_box = $option_combo_setting['quantity_box'];



                    if(!$option_combo_quantity_box)

                    {

                        $product_option_combo = $this->model_catalog_product->getProductOptionCombo($this->request->post['option_combo']);

                        if($product_option_combo['quantity'] > 0)

                        {

                            $quantity = $product_option_combo['quantity'];

                        }

                    }

                    if(!isset($this->request->post['option']))

                    {

                        $this->request->post['option'] = array();

                    }

                    $this->request->post['option'] += $option_combo;

                }

            
            if (isset($this->request->post['option'])) {
                $option = array_filter( $this->request->post['option'] );
            }
            else
            {
                $option = array( );
            }

            if( isset( $this->request->post['profile_id'] ) )
            {
                $profile_id = $this->request->post['profile_id'];
            }
            else
            {
                $profile_id = 0;
            }

            $product_options = $this->model_catalog_product->getProductOptions( $this->request->post['product_id'] );

            foreach( $product_options as $product_option )
            {
                if( $product_option['required'] && empty( $option[$product_option['product_option_id']] ) )
                {
                    $json['error']['option'][$product_option['product_option_id']] = sprintf( $this->language->get( 'error_required' ), $product_option['name'] );
                }
            }

            $profiles = $this->model_catalog_product->getProfiles( $product_info['product_id'] );

            if( $profiles )
            {
                $profile_ids = array( );

                foreach( $profiles as $profile )
                {
                    $profile_ids[] = $profile['profile_id'];
                }

                if( !in_array( $profile_id, $profile_ids ) )
                {
                    $json['error']['profile'] = $this->language->get( 'error_profile_required' );
                }
            }

            if( !$json )
            {
                
                if ( isset($this->request->post['cart_id']) && $this->request->post['cart_id'] )
                {
                    $cart_id = $this->request->post['cart_id'];
                }
                else
                {
                    $cart_id = 0;
                }

                $this->cart->add( $this->request->post['product_id'], $quantity, $option, $profile_id, $cart_id );
            

                $json['success'] = sprintf( $this->language->get( 'text_success' ), $this->url->link( 'product/product', 'product_id='.$this->request->post['product_id'] ), $product_info['name'], $this->url->link( 'checkout/cart' ) );

                unset( $this->session->data['shipping_method'] );
                unset( $this->session->data['shipping_methods'] );
                unset( $this->session->data['payment_method'] );
                unset( $this->session->data['payment_methods'] );

                // Totals
                $this->load->model( 'setting/extension' );

                $total_data = array( );
                $total = 0;
                $taxes = $this->cart->getTaxes();

                // Display prices
                if( ($this->config->get( 'config_customer_price' ) && $this->customer->isLogged()) || !$this->config->get( 'config_customer_price' ) )
                {
                    $sort_order = array( );

                    $results = $this->model_setting_extension->getExtensions( 'total' );

                    foreach( $results as $key => $value )
                    {
                        $sort_order[$key] = $this->config->get( $value['code'].'_sort_order' );
                    }

                    array_multisort( $sort_order, SORT_ASC, $results );

                    foreach( $results as $result )
                    {
                        if( $this->config->get( $result['code'].'_status' ) )
                        {
                            $this->load->model( 'total/'.$result['code'] );

                            $this->{'model_total_'.$result['code']}->getTotal( $total_data, $total, $taxes );
                        }

                        $sort_order = array( );

                        foreach( $total_data as $key => $value )
                        {
                            $sort_order[$key] = $value['sort_order'];
                        }

                        array_multisort( $sort_order, SORT_ASC, $total_data );
                    }
                    
                }

                $json['total'] = sprintf( $this->language->get( 'text_items' ), $this->cart->countProducts() + (isset( $this->session->data['vouchers'] ) ? count( $this->session->data['vouchers'] ) : 0), $this->currency->format( $total ) );
            }
            else
            {
                $json['redirect'] = str_replace( '&amp;', '&', $this->url->link( 'product/product', 'product_id='.$this->request->post['product_id'] ) );
            }
        }

        $this->response->setOutput( json_encode( $json ) );
    }

    public function quote()
    {
        $this->language->load( 'checkout/cart' );

        $json = array( );

        if( !$this->cart->hasProducts() )
        {
            $json['error']['warning'] = $this->language->get( 'error_product' );
        }

        if( !$this->cart->hasShipping() )
        {
            $json['error']['warning'] = sprintf( $this->language->get( 'error_no_shipping' ), $this->url->link( 'information/contact' ) );
        }

        if( $this->request->post['country_id'] == '' )
        {
            $json['error']['country'] = $this->language->get( 'error_country' );
        }

        if( !isset( $this->request->post['zone_id'] ) || $this->request->post['zone_id'] == '' )
        {
            $json['error']['zone'] = $this->language->get( 'error_zone' );
        }

        $this->load->model( 'localisation/country' );

        $country_info = $this->model_localisation_country->getCountry( $this->request->post['country_id'] );

        if( $country_info && $country_info['postcode_required'] && (utf8_strlen( $this->request->post['postcode'] ) < 2) || (utf8_strlen( $this->request->post['postcode'] ) > 10) )
        {
            $json['error']['postcode'] = $this->language->get( 'error_postcode' );
        }

        if( !$json )
        {
            $this->tax->setShippingAddress( $this->request->post['country_id'], $this->request->post['zone_id'] );

            // Default Shipping Address
            $this->session->data['shipping_country_id'] = $this->request->post['country_id'];
            $this->session->data['shipping_zone_id'] = $this->request->post['zone_id'];
            $this->session->data['shipping_postcode'] = $this->request->post['postcode'];

            if( $country_info )
            {
                $country = $country_info['name'];
                $iso_code_2 = $country_info['iso_code_2'];
                $iso_code_3 = $country_info['iso_code_3'];
                $address_format = $country_info['address_format'];
            }
            else
            {
                $country = '';
                $iso_code_2 = '';
                $iso_code_3 = '';
                $address_format = '';
            }

            $this->load->model( 'localisation/zone' );

            $zone_info = $this->model_localisation_zone->getZone( $this->request->post['zone_id'] );

            if( $zone_info )
            {
                $zone = $zone_info['name'];
                $zone_code = $zone_info['code'];
            }
            else
            {
                $zone = '';
                $zone_code = '';
            }

            $address_data = array(
                'firstname' => '',
                'lastname' => '',
                'company' => '',
                'address_1' => '',
                'address_2' => '',
                'postcode' => $this->request->post['postcode'],
                'city' => '',
                'zone_id' => $this->request->post['zone_id'],
                'zone' => $zone,
                'zone_code' => $zone_code,
                'country_id' => $this->request->post['country_id'],
                'country' => $country,
                'iso_code_2' => $iso_code_2,
                'iso_code_3' => $iso_code_3,
                'address_format' => $address_format
            );

            $quote_data = array( );

            $this->load->model( 'setting/extension' );

            $results = $this->model_setting_extension->getExtensions( 'shipping' );
			// se citeste valoarea de la care taxa de transpot este gratuita
			$this->load->model( 'setting/setting' );
			$setting_info_free = $this->model_setting_setting->getSetting('free', $this->config->get( 'config_store_id' ));
/*			print_r( $results );
			die();*/

            foreach( $results as $result )
            {
                if( $this->config->get( $result['code'].'_status' ) )
                {
                    $this->load->model( 'shipping/'.$result['code'] );

                    $quote = $this->{'model_shipping_'.$result['code']}->getQuote( $address_data );

                    if( $quote )
                    {
						if ( !in_array( $this->customer->getCustomerGroupId(), array( 3,4 ) )  ) // not B2B
						{
							if ( $this->cart->getTotal() >= $setting_info_free['free_total'])
							{
								//$this->settings['step']['shipping_method']['default_option'] = 'free';

								if ( $result['code'] == 'free' || $result['code'] == 'pickup' )
								{
									$quote_data[$result['code']] = array(
										'title' => $quote['title'],
										'quote' => $quote['quote'],
										'sort_order' => $quote['sort_order'],
										'error' => $quote['error']
									);
								}
							}
							else if ( $result['code'] != 'courier' ) //if ( $result['code'] != 'courier' )
								{
									$quote_data[$result['code']] = array(
										'title' => $quote['title'],
										'quote' => $quote['quote'],
										'sort_order' => $quote['sort_order'],
										'error' => $quote['error']
									);
								}
						}
						else // B2B
						{
							if ( $this->cart->getTotal() >= $setting_info_free['free_total_b2b'])
							{
								//$this->settings['step']['shipping_method']['default_option'] = 'free';

								if ( $result['code'] == 'free' || $result['code'] == 'pickup' )
								{
									$quote_data[$result['code']] = array(
										'title' => $quote['title'],
										'quote' => $quote['quote'],
										'sort_order' => $quote['sort_order'],
										'error' => $quote['error']
									);
								}
							}
							else
								if ( $result['code'] == 'courier'  )
								{
									$quote_data[$result['code']] = array(
										'title' => $quote['title'],
										'quote' => $quote['quote'],
										'sort_order' => $quote['sort_order'],
										'error' => $quote['error']
									);
								}
						}
/*         12 nov               $quote_data[$result['code']] = array(
                            'title' => $quote['title'],
                            'quote' => $quote['quote'],
                            'sort_order' => $quote['sort_order'],
                            'error' => $quote['error']
                        );*/
                    }
                }
            }


            $sort_order = array( );

            foreach( $quote_data as $key => $value )
            {
                $sort_order[$key] = $value['sort_order'];
            }

            array_multisort( $sort_order, SORT_ASC, $quote_data );

            $this->session->data['shipping_methods'] = $quote_data;

            if( $this->session->data['shipping_methods'] )
            {
                $json['shipping_method'] = $this->session->data['shipping_methods'];
            }
            else
            {
                $json['error']['warning'] = sprintf( $this->language->get( 'error_no_shipping' ), $this->url->link( 'information/contact' ) );
            }
        }

        $this->response->setOutput( json_encode( $json ) );
    }

    public function country()
    {
        $json = array( );

        $this->load->model( 'localisation/country' );

        $country_info = $this->model_localisation_country->getCountry( $this->request->get['country_id'] );

        if( $country_info )
        {
            $this->load->model( 'localisation/zone' );

            $json = array(
                'country_id' => $country_info['country_id'],
                'name' => $country_info['name'],
                'iso_code_2' => $country_info['iso_code_2'],
                'iso_code_3' => $country_info['iso_code_3'],
                'address_format' => $country_info['address_format'],
                'postcode_required' => $country_info['postcode_required'],
                'zone' => $this->model_localisation_zone->getZonesByCountryId( $this->request->get['country_id'] ),
                'status' => $country_info['status']
            );
        }

        $this->response->setOutput( json_encode( $json ) );
    }

}

?>
