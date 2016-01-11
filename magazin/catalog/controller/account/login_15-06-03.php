<?php

class ControllerAccountLogin extends Controller
{

    private $error = array( );

    public function index()
    {

        $this->load->model( 'account/customer' );
        $this->load->model( 'account/customer_auto_login' );
        $this->load->model( 'account/customer_api_messages' );

        //echo session_id(); print_r($this->session);exit();

        if ( $_SERVER['SERVER_NAME'] == substr(B2B_HTTP_SERVER, 7, -1)) {
            //echo session_name(); print_r($this->session); die('sdfvs');
        }

        // Login override for admin users
        if( !empty( $this->request->get['token'] ) )
        {
            $this->customer->logout();
            $this->cart->clear();

            $this->deleteLoginSession( FALSE );

            $customer_info = $this->model_account_customer->getCustomerByToken( $this->request->get['token'] );

            if( $customer_info && $this->customer->login( $customer_info['email'], '', true ) )
            {
                // Default Addresses
                $this->load->model( 'account/address' );

                $address_info = $this->model_account_address->getAddress( $this->customer->getAddressId() );

                if( $address_info )
                {
                    if( $this->config->get( 'config_tax_customer' ) == 'shipping' )
                    {
                        $this->session->data['shipping_country_id'] = $address_info['country_id'];
                        $this->session->data['shipping_zone_id'] = $address_info['zone_id'];
                        $this->session->data['shipping_postcode'] = $address_info['postcode'];
                    }

                    if( $this->config->get( 'config_tax_customer' ) == 'payment' )
                    {
                        $this->session->data['payment_country_id'] = $address_info['country_id'];
                        $this->session->data['payment_zone_id'] = $address_info['zone_id'];
                    }
                }
                else
                {
                    unset( $this->session->data['shipping_country_id'] );
                    unset( $this->session->data['shipping_zone_id'] );
                    unset( $this->session->data['shipping_postcode'] );
                    unset( $this->session->data['payment_country_id'] );
                    unset( $this->session->data['payment_zone_id'] );
                }

                $this->redirect( $this->url->link( 'account/account', '', 'SSL' ) );
            }
        }
        // Try an auto login
        elseif( ! empty( $this->request->get['al'] ) )
        {
            $this->tryToAutoLogin();
        }

        $this->checkIfCustomerIsLoggedIn();

        $this->language->load( 'account/login' );

        $this->document->setTitle( $this->language->get( 'heading_title' ) );
               
        $login_from_b2b = 0;

        if ( isset($_SERVER['HTTP_REFERER']) &&  ( $_SERVER['HTTP_REFERER'] == "http://magazin.renania.ro/login" || $_SERVER['HTTP_REFERER']  == "http://magazin.renania.ro/login" ) )
        {
            // check if the URL where is come is http://magazin.renania.ro/login or https://magazin.renania.ro/login
            $login_from_b2b = 1;

//            $this->deleteLoginSession();
                            
            $this->data['b2b_login_explanation_text'] = $this->language->get( 'text_client_b2b_login' );                
        }
        $this->data['login_from_b2b'] = $login_from_b2b;

        /*if($_SERVER['REMOTE_ADDR'] == "5.2.202.87") {
            die($_SERVER['SERVER_NAME'].' '.B2B_HTTP_SERVER);
        }*/

        // verify if the client is B2B client

        /*if($_SERVER['REMOTE_ADDR'] == "5.2.202.87") {
            echo 'SERVER_NAME <br>'.$_SERVER['SERVER_NAME'];
            echo '<br>HTTP_SERVER <br>'.HTTP_SERVER;
            echo '<br>HTTP_SERVER substr <br>'.substr(HTTP_SERVER, 7, -1);
            echo '<br>HTTPS_SERVER <br>'.HTTPS_SERVER;
            echo '<br>HTTPS_SERVER substr <br>'.substr(HTTPS_SERVER, 7, -1);
            die('<br>no validateion than redirect');
        }*/

        if ( $_SERVER['SERVER_NAME'] == substr(HTTP_SERVER, 8, -1) || $_SERVER['SERVER_NAME'] == substr(HTTPS_SERVER, 8, -1) )
        {
            if( $this->customer->isLoggedB2BWithoutValidationCode() || $this->customer->isLogged() )
            {
                //$this->customer->logout();
                //$this->cart->clear();

                //$this->deleteLoginSession();

                // redirection to b2b.renania.ro
                //$this->session->data[ 'cheese' ] = "test";
                $this->sendValidationCode();
                //print_r($this->session);exit();
                header('Location: ' . B2B_HTTP_SERVER."login" );
            }
        }

        $this->data['B2B_login'] = false; 
        if( ($this->request->server['REQUEST_METHOD'] == 'POST') )
        {
            if ( $this->request->post['B2B_authentication'] == 1 )
            {
                $this->data['B2B_login'] = true;
            }
        }

        
        if( ($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate() )
        {
            unset( $this->session->data['guest'] );
            
            if ( $_SERVER['SERVER_NAME'] != substr(HTTP_SERVER, 8, -1) || $_SERVER['SERVER_NAME'] != substr(HTTPS_SERVER, 8, -1) )
            {      
                // send validation code
                if ( empty($this->session->data['login_validation_code_sent']) && ( $this->customer->getCustomerGroupId() == 3 || $this->customer->getCustomerGroupId() == 4) )
                {

                    if($_SERVER['REMOTE_ADDR'] == "5.2.202.87") {
                        //die('that is 2 it');
                    }
                    $this->sendValidationCode();
                }
            }
         

            // Default Shipping Address
            $this->load->model( 'account/address' );

            $address_info = $this->model_account_address->getAddress( $this->customer->getAddressId() );
               
            if( $address_info )
            {
                if( $this->config->get( 'config_tax_customer' ) == 'shipping' )
                {
                    $this->session->data['shipping_country_id'] = $address_info['country_id'];
                    $this->session->data['shipping_zone_id'] = $address_info['zone_id'];
                    $this->session->data['shipping_postcode'] = $address_info['postcode'];
                }

                if( $this->config->get( 'config_tax_customer' ) == 'payment' )
                {
                    $this->session->data['payment_country_id'] = $address_info['country_id'];
                    $this->session->data['payment_zone_id'] = $address_info['zone_id'];
                }
            }
            else
            {
                unset( $this->session->data['shipping_country_id'] );
                unset( $this->session->data['shipping_zone_id'] );
                unset( $this->session->data['shipping_postcode'] );
                unset( $this->session->data['payment_country_id'] );
                unset( $this->session->data['payment_zone_id'] );
            }


            // Added strpos check to pass McAfee PCI compliance test (http://forum.opencart.com/viewtopic.php?f=10&t=12043&p=151494#p151295)
            if( isset( $this->request->post['redirect'] ) && (strpos( $this->request->post['redirect'], $this->config->get( 'config_url' ) ) !== false || strpos( $this->request->post['redirect'], $this->config->get( 'config_ssl' ) ) !== false) )
            {
                $this->redirect( str_replace( '&amp;', '&', $this->request->post['redirect'] ) );
            }
            else
            {
                if ( $this->request->post['B2B_authentication'] == 1 )
                {
                    $this->redirect( $this->url->link('account/login/index', 'type=B2B', 'SSL') );
                }
                else
                {
                    //print_r($this->session); die('2');
                    if($this->customer->getCustomerGroupId() == 3 || $this->customer->getCustomerGroupId() == 4) {

                        /*if($_SERVER['REMOTE_ADDR'] == '5.2.202.87'){
                            die('sdsv');
                        }*/

                        $this->redirect( $this->url->link( 'account/account', '', 'SSL' ) );
                    } else { //  If normal user logged in from b2b.renania.ro , redirected to magazin.renania.ro
                        header('Location: ' . HTTP_SERVER."account" );
                    }

                }
            }
        }
        
        
       
        $this->data['breadcrumbs'] = array( );

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get( 'text_home' ),
            'href' => $this->url->link( 'common/home' ),
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get( 'text_account' ),
            'href' => $this->url->link( 'account/account', '', 'SSL' ),
            'separator' => $this->language->get( 'text_separator' )
        );

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get( 'text_login' ),
            'href' => $this->url->link( 'account/login', '', 'SSL' ),
            'separator' => $this->language->get( 'text_separator' )
        );

        $this->data['heading_title'] = $this->language->get( 'heading_title' );

        $this->data['text_new_customer'] = $this->language->get( 'text_new_customer' );
        $this->data['text_register'] = $this->language->get( 'text_register' );
        $this->data['text_register_account'] = $this->language->get( 'text_register_account' );
        $this->data['text_returning_customer'] = $this->language->get( 'text_returning_customer' );
        $this->data['text_i_am_returning_customer'] = $this->language->get( 'text_i_am_returning_customer' );
        $this->data['text_forgotten'] = $this->language->get( 'text_forgotten' );
        
        //$this->data['B2B_login'] = false;
        if ( isset($this->request->get['type']) && $this->request->get['type'] == 'B2B')
        {
            $this->data['B2B_login'] = true;
        }
            
        if ( $this->data['B2B_login'] == true )
        {
            $this->data['heading_title_b2b'] = $this->language->get( 'heading_title_b2b' );
            $this->data['text_returning_customer_b2b'] = $this->language->get( 'text_returning_customer_b2b' );
        }
                
        $this->data['entry_email'] = $this->language->get( 'entry_email' );
        $this->data['entry_password'] = $this->language->get( 'entry_password' );
        $this->data['entry_validation_code'] = $this->language->get( 'entry_validation_code' );
        $this->data['text_login_whit_different_account'] = $this->language->get( 'text_login_whit_different_account' );

        $this->data['button_continue'] = $this->language->get( 'button_continue' );
        $this->data['button_login'] = $this->language->get( 'button_login' );
       
        if( isset( $this->error['warning'] ) || isset( $this->session->data['error_login_b2b'] ) )
        {
            if( isset( $this->error['warning'] ) )
            {
                $this->data['error_warning'] = $this->error['warning'];
            }
            else if ( isset( $this->session->data['error_login_b2b'] ) )
            {
                $this->data['error_warning'] = $this->session->data['error_login_b2b'];
                unset ( $this->session->data['error_login_b2b'] );
            }            
        }
        else
        {
            $this->data['error_warning'] = '';
        }
    
        $this->data['action'] = $this->url->link( 'account/login', '', 'SSL' );
        $this->data['register'] = $this->url->link( 'account/register', '', 'SSL' );
        $this->data['forgotten'] = $this->url->link( 'account/forgotten', '', 'SSL' );
        
        $this->data['login_with_different_account'] = $this->url->link( 'account/logout', '', 'SSL' );

        // Added strpos check to pass McAfee PCI compliance test (http://forum.opencart.com/viewtopic.php?f=10&t=12043&p=151494#p151295)
        if( isset( $this->request->post['redirect'] ) && (strpos( $this->request->post['redirect'], $this->config->get( 'config_url' ) ) !== false || strpos( $this->request->post['redirect'], $this->config->get( 'config_ssl' ) ) !== false) )
        {
            $this->data['redirect'] = $this->request->post['redirect'];
        }
        elseif( isset( $this->session->data['redirect'] ) )
        {
            $this->data['redirect'] = $this->session->data['redirect'];

            unset( $this->session->data['redirect'] );
        }
        else
        {
            $this->data['redirect'] = '';
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

        if( isset( $this->request->post['email'] ) )
        {
            $this->data['email'] = $this->request->post['email'];
        }
        else
        {
            $this->data['email'] = '';
        }

        if( isset( $this->request->post['password'] ) )
        {
            $this->data['password'] = $this->request->post['password'];
        }
        else
        {
            $this->data['password'] = '';
        }
        
        
          
          
        if( file_exists( DIR_TEMPLATE.$this->config->get( 'config_template' ).'/template/account/login.tpl' ) )
        {
            $this->template = $this->config->get( 'config_template' ).'/template/account/login.tpl';
        }
        else
        {
            $this->template = 'default/template/account/login.tpl';
        }

        $this->children = array(
            'common/column_left',
            'common/column_right',
            'common/content_top',
            'common/content_bottom',
            'common/footer',
            'common/header'
        );
        
        $this->response->setOutput( $this->render() );
    }

    private function tryToAutoLogin()
    {
        if( empty( $this->request->get['hash'] ) )
        {
            return FALSE;
        }

        $login_hash = $this->request->get['hash'];
        if( strlen( $login_hash ) != 50 )
        {
            $this->error['warning'] = $this->language->get( 'error_auto_login_hash_code' );
            return FALSE;
        }

        $customer_auto_login = $this->model_account_customer_auto_login->getCustomerIdByHash( $login_hash );
        if( empty( $customer_auto_login ) )
        {
            $this->error['warning'] = $this->language->get( 'error_login' );
            return FALSE;
        }

        $customer_info = $this->model_account_customer->getCustomer( $customer_auto_login["customer_id"] );
        if( empty( $customer_info ) )
        {
            $this->error['warning'] = $this->language->get( 'error_login' );
            return FALSE;
        }

        if( ! $this->customer->login( $customer_info['email'], "", TRUE ) )
        {
            $this->error['warning'] = $this->language->get( 'error_login' );
            return FALSE;
        }

        // save last login date
        $this->model_account_customer_auto_login->setUpdateDateNow( $customer_auto_login["user_auto_login_id"] );

        $data = array(
          "customer_id"       => $this->customer->getId(),
          "push_url"          => html_entity_decode( $_SERVER["REQUEST_URI"] ),
          "message_sent"      => "",
          "message_received"  => "<pre>"
                                    .print_r( $_POST, TRUE )."<br />"
                                    .print_r( $_GET, TRUE )."<br />"
                                    .print_r( $_SERVER, TRUE )."<br />"
                                ."</pre>",
        );

        $this->model_account_customer_api_messages->addApiMessage( $data );

        $this->session->data['login_auto_with_hash'] = TRUE;
        $this->session->data['login_auto_details']   = $customer_auto_login;
        $this->session->data['login_auto_hook_url']  = urldecode( $this->request->get["HOOK_URL"] );
        if( ! empty( $this->request->get["keepBasketAtExport"] ) && $this->request->get["keepBasketAtExport"] == "false" )
        {
            $this->session->data['login_auto_clear_cart']  = TRUE;
        }
        if( ! empty( $this->request->get["ociButtonName"] ) )
        {
            $this->session->data['login_auto_button_name']  = $this->request->get["ociButtonName"];
        }

        return TRUE;
    }

    private function checkIfCustomerIsLoggedIn()
    {
        if( ! $this->customer->isLogged() )
        {
            return FALSE;
        }

        if( isset( $this->session->data['login_auto_with_hash'] ) )
        {
            $this->redirect( $this->url->link( 'checkout/cart', '', 'SSL' ) );
        }

        $this->redirect( $this->url->link( 'account/account', '', 'SSL' ) );
    }

    private function deleteLoginSession( $deleteLoginSession = TRUE )
    {
        if( $deleteLoginSession )
        {
            unset( $this->session->data['login_validation_code_sent'] );
            unset( $this->session->data['login_validation_code_ok'] );
            unset( $this->session->data['login_validation_code'] );
            unset( $this->session->data['login_auto_with_hash'] );
            unset( $this->session->data['login_auto_details'] );
            unset( $this->session->data['login_auto_hook_url'] );
            unset( $this->session->data["show_xml_for_auto_login"]);
            unset( $this->session->data["xml_data_for_auto_login"]);
            unset( $this->session->data["keepBasketAtExport"]);
            unset( $this->session->data["ociButtonName"]);
        }

        unset( $this->session->data['wishlist'] );
        unset( $this->session->data['shipping_address_id'] );
        unset( $this->session->data['shipping_country_id'] );
        unset( $this->session->data['shipping_zone_id'] );
        unset( $this->session->data['shipping_postcode'] );
        unset( $this->session->data['shipping_method'] );
        unset( $this->session->data['shipping_methods'] );
        unset( $this->session->data['payment_address_id'] );
        unset( $this->session->data['payment_country_id'] );
        unset( $this->session->data['payment_zone_id'] );
        unset( $this->session->data['payment_method'] );
        unset( $this->session->data['payment_methods'] );
        unset( $this->session->data['comment'] );

        unset( $this->session->data['confirm']['comment'] );
        unset( $this->session->data['confirm']['agree'] );
        unset( $this->session->data['confirm']['requisition_number'] );
        unset( $this->session->data['confirm']['reference'] );

        unset( $this->session->data['order_id'] );
        unset( $this->session->data['coupon'] );
        unset( $this->session->data['reward'] );
        unset( $this->session->data['voucher'] );
        unset( $this->session->data['vouchers'] );
    }

    protected function validate()
    {            
        if ( $this->request->post['B2B_authentication'] == 1 && ( !empty( $this->request->post['email'] ) || !empty( $this->request->post['password'] ) ) )
        {
            $is_b2b_customer = $this->isB2BCustomer( $this->request->post['email'] );
            if ( $is_b2b_customer == 0 )
            {
                $this->session->data['error_login_b2b'] = $this->language->get( 'error_login_b2b' );
                $this->redirect( $this->url->link('account/login/index', 'type=B2B', 'SSL') );
            }
        }

        $this->session->data['login_validation_code_ok'] = FALSE;
        
        
        // we have validation code 
        if ( isset(  $this->request->post['validation_code']) )
        {
            // the codes correspond
            if( !empty($this->session->data['login_validation_code'] ) 
             && strtoupper($this->session->data['login_validation_code']) == strtoupper($this->request->post['validation_code']) )
            {
                $this->session->data['login_validation_code_ok'] = TRUE;
                return true;
            }
            else
            {
                $this->error['warning'] = $this->language->get( 'error_validation_code' );
                return false;
            }
        }
        
        
                        
        if( !$this->customer->login( $this->request->post['email'], $this->request->post['password'] ) )
        {
            $this->error['warning'] = $this->language->get( 'error_login' );
        }
        
        $isLoggedButNoValidation = $this->customer->isLoggedB2BWithoutValidationCode();        
        if ( !empty($isLoggedButNoValidation ) )
        {
            if ( $_SERVER['SERVER_NAME'] == substr(HTTP_SERVER, 7, -1) || $_SERVER['SERVER_NAME'] == substr(HTTPS_SERVER, 7, -1) )
            {
                // $this->session->data['success'] = $this->language->get( 'text_send_sms_with_validation_code' );
//                $msg = $this->language->get( 'text_client_b2b_login' );
//                $msg .= '<br><a href="'.B2B_HTTP_SERVER.'index.php?route=account/login/index&type=B2B">';
//                $msg .= B2B_HTTP_SERVER.'index.php?route=account/login/index&type=B2B';
//                $msg .= '</a>';
            }
            else
            {
                $msg = $this->language->get( 'text_send_sms_with_validation_code' );
            }
            
            $this->session->data['success'] = $msg;
        }

        $customer_info = $this->model_account_customer->getCustomerByEmail( $this->request->post['email'] );

        if( $customer_info && !$customer_info['approved'] )
        {
            $this->error['warning'] = $this->language->get( 'error_approved' );
        }
        
        if( !$this->error )
        {
           // $this->data['password']
            return true;
        }
        else
        {
            return false;
        }
    }

    protected function sendValidationCode()
    {
        //send validation code for client
        $mail = new Mail();
        $mail->protocol = $this->config->get('config_mail_protocol');
        $mail->parameter = $this->config->get('config_mail_parameter');
        $mail->hostname = $this->config->get('config_smtp_host');
        $mail->username = $this->config->get('config_smtp_username');
        $mail->password = $this->config->get('config_smtp_password');
        $mail->port = $this->config->get('config_smtp_port');
        $mail->timeout = $this->config->get('config_smtp_timeout');	
                
        $phone_number = $this->customer->getTelephone();
        $mobile_phone_number = $this->customer->getMobilePhone();


        if ( !empty($mobile_phone_number) )
        {
            $mail->setTo($mobile_phone_number."@vectorsms.ro");
        }
        else
        {
            $mail->setTo($phone_number."@vectorsms.ro");
        }
        
        $validationcode = $this->randString(6);
        
        $this->session->data['login_validation_code'] = $validationcode;
        $this->session->data['login_validation_code_sent'] = TRUE;
                        
        $mail->setFrom("colectare@renania.ro"); //$this->config->get('config_email')
        $mail->setSender("colectare@renania.ro"); // $this->config->get('config_name')

        $this->language->load( 'account/login' );
        $subject =  $this->language->get( 'mail_subject_validation_code' );
        $mail->setSubject(html_entity_decode( $subject , ENT_QUOTES, 'UTF-8'));
        
        $message = $this->language->get( 'mail_message_validation_code' );
        $mail->setText(html_entity_decode( $message. " ".$validationcode, ENT_QUOTES, 'UTF-8'));
        $mail->send();
        
        $subject =  $this->language->get( 'mail_subject_validation_code' );

            $message = " ORIGINAL_TARGET_ADDRESS: "
                    . $mobile_phone_number."@vectorsms.ro" 
                    ." ORIGINAL_SUBJECT: "
                    . $subject
                    . ", ORIGINAL MESSAGE BODY: " 
                    .$this->language->get( 'mail_message_validation_code' );

            $mail->setText(html_entity_decode( $message. " ".$validationcode, ENT_QUOTES, 'UTF-8'));
            $subject = "Email Debug - VectorTelecom";
            $mail->setSubject(html_entity_decode( $subject , ENT_QUOTES, 'UTF-8'));
            $mail->setTo( "it@renania.ro" );
            $mail->send();


        if($_SERVER['REMOTE_ADDR'] == "5.2.202.87") {
            $mail->setText(html_entity_decode( $message. " ".$validationcode, ENT_QUOTES, 'UTF-8'));
            $mail->setSubject(html_entity_decode( $subject , ENT_QUOTES, 'UTF-8'));
            $mail->setTo( "attila@grafx.ro" );
            $mail->send();
        }
        /*$mail->setText(html_entity_decode( $message. " ".$validationcode, ENT_QUOTES, 'UTF-8'));
        $mail->setSubject(html_entity_decode( $subject , ENT_QUOTES, 'UTF-8'));
        $mail->setTo( "attila@grafx.ro" );
        $mail->send();*/
    }
    
    protected function randString( $length )
    {
        $result           = "";
        
        $result = mt_rand();   
        $result           = mb_substr($result, 0, $length);
        return $result;
    }
    
    
    protected function isB2BCustomer( $email )
    {
        $is_b2b_customer = 0;
        $query = $this->db->query("SELECT customer_group_id FROM " . DB_PREFIX . "customer WHERE email = '" . $email . "' ");

        $customer_group_id = "";
        if ( $query->row )
        {
            $customer_group_id = $query->row['customer_group_id'];
        }
        
        if ( in_array( $customer_group_id, array( 3,4 ) )  )  // is B2B client
        {
            $is_b2b_customer = 1;
        }
        
        return $is_b2b_customer;
    }
    
    
}

?>