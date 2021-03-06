<?php

class ControllerMyocLivePriceUpdate extends Controller
{

    public function index()
    {
        $this->language->load( 'myoc/live_price_update' );

        $json = array( );

        $cart_session = $this->session->data['cart'];

        $this->cart->clear();          
        

        if( isset( $this->request->post['product_id'] ) )
        {
            $product_id = $this->request->post['product_id'];
        }
        else
        {
            $product_id = 0;
        }
            
        if( isset( $this->request->post['profile_id'] ) )
        {
            $profile_id = $this->request->post['profile_id'];
        }
        else
        {
            $profile_id = 0;
        }

        $this->load->model( 'catalog/product' );

        $option = array( );
        if( isset( $this->request->post['option'] ) )
        {
            $option = array_filter( $this->request->post['option'] );
        }
        
        $product_info = $this->model_catalog_product->getProduct( $product_id, $option );
        
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



            $this->cart->add( $product_id, $quantity, $option, $profile_id );
        }
        else
        {
            $json['error'] = $this->language->get( 'error_product' );
        }

        //$calculatedPrice = $this->tax->calculate( $this->cart->getSubTotal() + ($product_info['price'] - $product_info['special']), $product_info['tax_class_id'], $this->config->get( 'config_tax' ) );
        $calculatedPrice = $this->tax->calculate( ($product_info['special']), $product_info['tax_class_id'], TRUE /*$this->config->get( 'config_tax' )*/ );
        $finalPrice = $product_info['special'] ? $calculatedPrice : $this->cart->getTotal();

        $taxOfOneProduct = $this->tax->calculate( $product_info['price'], $product_info['tax_class_id'], TRUE );

        if ($product_info['special']) {
            $product_info['special'] = $this->currency->format( $this->tax->calculate( $product_info['special'], $product_info['tax_class_id'], TRUE /*$this->config->get( 'config_tax' )*/ ) );
        } else {
            $product_info['special'] = false;
        }

        if($this->model_catalog_product->customerCanBuyBulk($product_id)) {
       		$verbosePrice = $this->currency->format( $taxOfOneProduct )." (".$this->language->get( 'text_withouth_vat' )." ".$this->currency->format( $product_info['price'] )." ".")" ."<br>". $this->language->get( 'text_price_per_package' ) ." ". $this->currency->format( ($taxOfOneProduct * $product_info['container_size']) - (($taxOfOneProduct * $product_info['container_size'] * $product_info['package_discount']) / 100) ) ." (".$this->language->get( 'text_withouth_vat' )." ".$this->currency->format(($product_info['price'] * $product_info['container_size']) - (($product_info['price'] * $product_info['container_size'] * $product_info['package_discount']) / 100) )." ".")";
    	} else {
    		$verbosePrice = $this->currency->format( $taxOfOneProduct )." (".$this->language->get( 'text_withouth_vat' )." ".$this->currency->format( $product_info['price'] )." ".")";
    	}
//    $verbosePrice = $this->currency->format( $finalPrice );

        /*if($_SERVER['REMOTE_ADDR'] == '5.2.202.87'){
            echo "<pre> taxofoneproduct ".$taxOfOneProduct." price ".$product_info['price']." tax-id ".$product_info['tax_class_id'];   die(' sdvsd');
        }*/

        $finalValue = $finalPrice != 0 ? $verbosePrice : $this->language->get( 'text_price_ask' );
        // $this->language->get('text_withouth_vat')
        if( !$json )
        {
            // if the logged customer is B2B or Gallery + B2B
            $priceB2B = 0;
            $B2B = false;
            $have_b2b_price = 0;
            $b2b_product_stoc = 0;
            $concatenated_code = '';
            $optionNr = 0;
                       
            $this->language->load('module/cart');
            $this->language->load( 'product/product' );  
            
            $optionNr = sizeof( $this->model_catalog_product->getProductOptions($product_id) );
            $option_data = $this->cart->buildOptionDataArray( $product_id, $option );
            
            if( $this->customer->getCustomerGroupId() == 3 || $this->customer->getCustomerGroupId() == 4  || $this->customer->getCustomerGroupId() == 770) //770 - pentru Zentiva
            {
                //$option_data = $this->cart->buildOptionDataArray( $product_id, $option );
                $priceB2B = $this->cart->calculatePriceB2B( $product_id, $option_data );
                
                
                $B2B = true;
                $pr = 0;                      
               
                if( $priceB2B == 0 && $optionNr == 0 )
                {
                    $pr = $this->language->get('text_no_price_specified_for_b2b');
                    $have_b2b_price = 0;                  
                        
                    // send mail to it@renania.ro
                    $subject = $this->language->get('text_no_price_for_b2b_clients'); 

                    //$message = $this->language->get('text_hello');
                    $message = "<br><br>".$this->language->get('text_customer');
                    $message .= "<strong>".$this->customer->getFirstName() ." ". $this->customer->getFirstName(). "</strong>,".$this->language->get('text_with_ax_code')." - <strong>". $this->customer->getAxCode()."</strong> - ";
                    $message .= $this->language->get('text_looked_at_product').": ";
                    $message .= "<strong>".$product_info['name']."</strong>";

                    $product_ax_code = $this->cart->getProductAxCode( $product_id, $option_data );
                    if ( !empty($product_ax_code) )
                    {
                        $message .= ", ".$this->language->get('text_with_concatenated_code').": ";
                        $message .= "<strong>".$this->cart->getProductAxCode( $product_id, $option_data )."</strong>" ;
                    }

                    $message .= $this->language->get('text_not_yet_been_defined_special_price');
        
                    //$this->sendAlertMail( $subject, $message );
                    
                }
                else if( $priceB2B == 0 && $optionNr >0 && sizeof( $option ) > 0 )
                {

                    $pr = $this->language->get('text_no_price_specified_for_b2b');
                    $have_b2b_price = 0;
                                           
                    if ( $optionNr == sizeof( $option ) )
                    {
                        $subject = $this->language->get('text_no_price_for_b2b_clients');

                        //$message = $this->language->get('text_hello');
                        $message = "<br><br>".$this->language->get('text_customer');
                        $message .= "<strong>".$this->customer->getFirstName() ." ". $this->customer->getFirstName(). "</strong>,".$this->language->get('text_with_ax_code')." - <strong>". $this->customer->getAxCode()."</strong> - ";
                        $message .= $this->language->get('text_looked_at_product').": ";
                        $message .= "<strong>".$product_info['name']."</strong> ";
                                            
                        $product_ax_code = $this->cart->getProductAxCode( $product_id, $option_data );
                                            
                        if ( empty( $product_ax_code ) )
                        {
                            $message .= "(";
                            foreach( $option_data as $option )
                            {
                                $message .= $option['name']." ".$option['option_value'] .", ";
                            }
                            $message = substr($message, 0, strlen($message)-2 );
                            $message .= ")";
                            
                            $b2b_product_stoc = $this->getB2BProductStock( $product_ax_code );
                            
                        }
//                        if ( sizeof( $option_data ) == 1 )
//                        {
//                            $message .= $option_data[0]['name']." ".$option_data[0]['option_value'];
//                        }
                        else
                        {
                            $message .= $this->language->get('text_with_concatenated_code').": ";
                            $message .= "<strong>".$product_ax_code."</strong>" ;
                        }

                        $message .= $this->language->get('text_not_yet_been_defined_special_price');                       

                       //$this->sendAlertMail( $subject, $message );      
                    }

                }
                else if( $priceB2B == 0 && $optionNr > 0 )
                {
                    $pr = $this->language->get('text_select_option_to_show_price');
                    $have_b2b_price = 0;
                }
                else
                {
                    $taxOfOneProductB2B = $this->tax->calculate( $priceB2B, $product_info['tax_class_id'], TRUE );

                    $pr = $this->currency->format( $taxOfOneProductB2B ) ." (".$this->language->get( 'text_withouth_vat' )." "
                    .$this->currency->format( $priceB2B )." ".")";

                    if ($this->model_catalog_product->customerCanBuyBulk($product_id)) {
                        $pr .= "<br>"
                            . $this->language->get('text_price_per_package') 
                            . " "
                            . $this->currency->format($taxOfOneProductB2B * $product_info['container_size'] * (100 - $product_info['package_discount']) / 100)
                            . " (" . $this->language->get('text_withouth_vat') . " " . $this->currency->format($priceB2B * $product_info['container_size'] * (100 - $product_info['package_discount']) / 100) . " )";
                    }
                    
                    $concatenated_code = $this->cart->getProductAxCode( $product_id, $option_data );
                    
                    if ( !empty($concatenated_code) )
                    {
                        $b2b_product_stoc = $this->getB2BProductStock( $concatenated_code );
                    }
                
                    $have_b2b_price = 1;
                }                                 
            }
            $product_ax_code = $this->cart->getProductAxCode( $product_id, $option_data );
            $b2b_product_stoc = $this->getB2BProductStock( $product_ax_code );

            $json['have_b2b_price'] = $have_b2b_price;
            $json['price'] = ( $B2B ? $pr : $finalValue ); // $finalValue;
            $json['price'] = substr_replace($json['price'], ' <span class="price_currency">', strcspn($json['price'], 'ABCDEFGHJIJKLMNOPQRSTUVWXYZ'), 0). '</span>';
            //$newstr = substr_replace($oldstr, $str_to_insert, $pos, 0);
            //$json['special'] = $this->currency->format( $this->cart->getTotal() );
            $json['special'] = $product_info['special'];
            $json['extax'] = $this->currency->format( $this->cart->getSubTotal() );
            //$json['stock'] = ($B2B ? $b2b_product_stoc : $product_info['stock_status']);
            if ($B2B)
            {
                $json['stock'] = $b2b_product_stoc;
            }
            else if ($b2b_product_stoc == 0)
            {
                $json['stock'] = $this->language->get('text_no_stock');
            } 
            else 
            {
                $json['stock'] = $this->language->get('text_in_stock');
            }
            //$json['stock'] = $product_info['stock_status']; //$product_info['product_option_quantity'];//$product_info['stock_status'];
            // $json['stock'] = $product_info['quantity'];
            $json['text_qty'] =  $this->language->get('text_qty');// '  CODE='.$concatenated_code. " ** "
            $json['b2b_product_stoc'] =  (int) $b2b_product_stoc;
            $json['customer_group_id'] = $this->customer->getCustomerGroupId();
            $json['product_optionNr'] = $optionNr;
            $json['text_no_stock'] = $this->language->get('text_no_stock');
            $json['text_add_to_cart'] = $this->language->get('button_cart');
            $json['text_out_of_stock'] = $this->language->get('text_out_of_stock');
            $json['text_delivery'] = $this->language->get('text_delivery');
            $json['text_please_select_desired_options'] = $this->language->get('text_please_select_desired_options');
            $json['raw_price_data'] = array('base_price' => round((($B2B && $priceB2B) ? $priceB2B : $product_info['price']), 2));
            $json['raw_price_data']['vat_price'] = round($this->tax->calculate($json['raw_price_data']['base_price'], $product_info['tax_class_id'], TRUE), 2);
        }

        $this->cart->clear();

        $this->session->data['cart'] = $cart_session;

        $this->response->setOutput( json_encode( $json ) );
    }
    
    
    private function sendAlertMail( $subject, $message )
    {
        $mail = new Mail();
        $mail->protocol = $this->config->get('config_mail_protocol');
        $mail->parameter = $this->config->get('config_mail_parameter');
        $mail->hostname = $this->config->get('config_smtp_host');
        $mail->username = $this->config->get('config_smtp_username');
        $mail->password = $this->config->get('config_smtp_password');
        $mail->port = $this->config->get('config_smtp_port');
        $mail->timeout = $this->config->get('config_smtp_timeout');			
        
        $this->load->model('setting_email_address/setting_email_address');
        $email_address_info = $this->model_setting_email_address_setting_email_address->getEmailAddress( "PRODUS_FARA_PRET_PT_CLIENTI_B2B" ); // Produs fara pret pt clienti B2B
        
        if ( isset( $email_address_info ) && !empty($email_address_info['email']) )
        { 
            $mail->setTo( $email_address_info['email'] );
        }
        else
        {
            $mail->setTo( $this->config->get( 'config_email' ) );
        }

//        if( $_SERVER['REMOTE_ADDR'] == '188.26.23.46' )       
        $mail->setFrom($this->config->get('config_email'));
        $mail->setSender($this->config->get('config_name'));

        $mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
        $mail->setHtml(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
        $mail->send();   
    }
    
    
    private function getB2BProductStock( $concatenated_code )
    {
        $b2b_product_stock = 0;

        $this->load->model( 'catalog/ax_stoc' );
        $stock_val = $this->model_catalog_ax_stoc->getStoc( $concatenated_code );
        if ( $stock_val != 0 )
        {
            $b2b_product_stock = $stock_val;
        }              

        return $b2b_product_stock;
    }

}

?>