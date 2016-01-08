<?php

class ControllerAccountAccount extends Controller
{
    private $error = array();
    
    public function index()
    {        
	// if( $_SERVER['REMOTE_ADDR'] == '5.2.202.87' ){
	// print $this->customer->getAxCode(); die();
	// }
	
//        if( $_SERVER['REMOTE_ADDR'] == '188.26.23.46' ) 
//        { 
//                $query = $this->db->query("SELECT value  FROM `oc_setting` WHERE `group` = 'quickcheckout_b2b' ORDER BY `oc_setting`.`group` ASC ");
//                $array = unserialize( $query->row['value'] );
//                
//                print_r( $array );
//                die();
//
//                $array['option']['guest']['shipping_utannaddress']['fields']['postcode']['require'] = 0; 
//                $array['option']['guest']['shipping_address']['fields']['postcode']['display'] = 1; 
//                
//                $array['option']['logged']['shipping_address']['fields']['postcode']['require'] = 0; 
//                $array['option']['logged']['shipping_address']['fields']['postcode']['display'] = 1; 
//
//                $temp = serialize ( $array );
//                $this->db->query( "UPDATE `" . DB_PREFIX . "setting` SET `value` = '".$temp."'  WHERE `setting_id` = '3049'");
//
//                print "ok";
//                die();
//        }
        
      /*   if( $_SERVER['REMOTE_ADDR'] == '188.26.23.46' ) 
         {
            $query = $this->db->query("SELECT setting_id, value  FROM `oc_setting` WHERE `group` = 'quickcheckout_b2b' ORDER BY `oc_setting`.`group` ASC ");
            $array = unserialize( $query->row['value'] );
            
//            print "id=". $query->row['setting_id'] ;
//            print "****";
//            print_r ( $array );
//            die();
            
            
            $array['step']['confirm']['fields']['requisition_number']['sort_order'] = ''; 
            $array['step']['confirm']['fields']['reference']['sort_order'] = ''; 


            $array['option']['guest']['confirm']['fields']['requisition_number']['display'] = '1'; 
            $array['option']['guest']['confirm']['fields']['requisition_number']['require'] = '0'; 

            $array['option']['guest']['confirm']['fields']['reference']['display'] = '1'; 
            $array['option']['guest']['confirm']['fields']['reference']['require'] = '0'; 


            $array['option']['register']['confirm']['fields']['requisition_number']['display'] = '1'; 
            $array['option']['register']['confirm']['fields']['requisition_number']['require'] = '0'; 

            $array['option']['register']['confirm']['fields']['reference']['display'] = '1'; 
            $array['option']['register']['confirm']['fields']['reference']['require'] = '0'; 


            $array['option']['logged']['confirm']['fields']['requisition_number']['display'] = '1'; 
            $array['option']['logged']['confirm']['fields']['requisition_number']['require'] = '0'; 

            $array['option']['logged']['confirm']['fields']['reference']['display'] = '1'; 
            $array['option']['logged']['confirm']['fields']['reference']['require'] = '0'; 
            
//            print_r( $array );
//            die();

            $temp = serialize ( $array );

            $this->db->query( "UPDATE `" . DB_PREFIX . "setting` SET `value` = '".$temp."'  WHERE `setting_id` = '4188'");


            print "ok";
            die();
         }*/
        

        
        if( !$this->customer->isLogged() )
        {
            $this->session->data['redirect'] = $this->url->link( 'account/account', '', 'SSL' );

            $this->redirect( $this->url->link( 'account/login', '', 'SSL' ) );
        }
        
        $this->language->load( 'account/account' );

        $this->document->setTitle( $this->language->get( 'heading_title' ) );
        $this->data['user'] = $this->customer->getFirstName()." ".$this->customer->getLastName();

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
        
        
      $this->load->model('account/customer');
      if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) 
        {        
            $this->model_account_customer->saveContactPersonInfo($this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');
      
            // send a notification message to the site administrator
            $mail = new Mail();
            $mail->protocol = $this->config->get('config_mail_protocol');
            $mail->parameter = $this->config->get('config_mail_parameter');
            $mail->hostname = $this->config->get('config_smtp_host');
            $mail->username = $this->config->get('config_smtp_username');
            $mail->password = $this->config->get('config_smtp_password');
            $mail->port = $this->config->get('config_smtp_port');
            $mail->timeout = $this->config->get('config_smtp_timeout');	

            $this->load->model('setting_email_address/setting_email_address');
            $email_address_info = $this->model_setting_email_address_setting_email_address->getEmailAddress( "SCHIMBAREA_ADRESEI_DE_EMAIL_A_CLIENTULUI" ); // Modificari date

            $email_addresses = array();    
            if ( isset( $email_address_info ) && !empty($email_address_info['email']) )
            { 
//                $pos = strpos($email_address_info['email'], ";");
//                if ($pos !== false) 
//                {
//                    $email_addresses = explode (";", $email_address_info['email']);
//                }
//                else
//                {
//                    $email_addresses[] = $email_address_info['email'];
//                }
                $mail->setTo( $email_address_info['email'] );
            }
            else
            {
                //$email_addresses[] = $this->config->get( 'config_email' );
                $mail->setTo( $this->config->get( 'config_email' ) );
            }

//            foreach( $email_addresses as $email_address )
//            {
//                $mail->setTo( $email_address  );
//            }

            $mail->setFrom($this->config->get('config_email'));
            $mail->setSender($this->config->get('config_name'));

            $subject = $this->language->get('text_subject_notification');
            $message = $this->language->get('text_client'). "<strong>".$this->customer->getAxCode() ."</strong> (".$this->customer->getEmail()."), ";
            $message .= $this->language->get('text_change_account_info');

            $mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
            $mail->setHtml(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
            $mail->send();

            $this->redirect($this->url->link('account/account', '', 'SSL'));
        }
        
        if (isset($this->error['warning'])) {
        $this->data['error_warning'] = $this->error['warning'];
        } else {
        $this->data['error_warning'] = '';
        }
    
        if (isset($this->error['firstname'])) {
        $this->data['error_firstname'] = $this->error['firstname'];
        } else {
        $this->data['error_firstname'] = '';
        }
        
        if (isset($this->error['lastname'])) {
        $this->data['error_lastname'] = $this->error['lastname'];
        } else {
        $this->data['error_lastname'] = '';
        }

        if (isset($this->error['telephone'])) {
        $this->data['error_telephone'] = $this->error['telephone'];
        } else {
        $this->data['error_telephone'] = '';
        }	

        if (isset($this->error['mobile_phone'])) {
        $this->data['error_mobile_phone'] = $this->error['mobile_phone'];
        } else {
        $this->data['error_mobile_phone'] = '';
        }	
        
        if (isset($this->session->data['filter_by_error'])) {
        $this->data['error_filter_by'] = $this->session->data['filter_by_error'];
        } else {
        $this->data['error_filter_by'] = '';
        }
        
        if (isset($this->session->data['filter_value_error'])) {
        $this->data['error_filter_value'] = $this->session->data['filter_value_error'];
        } else {
        $this->data['error_filter_value'] = '';
        }

        if (isset($this->request->post['firstname'])) {
        $this->data['customer_firstname'] = $this->request->post['firstname'];
        } else {
        $this->data['customer_firstname'] = $this->customer->getFirstName();
        }      
        
        if (isset($this->request->post['lastname'])) {
        $this->data['customer_lastname'] = $this->request->post['lastname'];
        } else {
        $this->data['customer_lastname'] = $this->customer->getLastName();
        }      
        
        if (isset($this->request->post['telephone'])) {
        $this->data['customer_landline_name'] = $this->request->post['telephone'];
        } else {
        $this->data['customer_landline_name'] = $this->customer->getTelephone();
        } 

        if (isset($this->request->post['mobile_phone'])) {
        $this->data['customer_mobile_phone'] = $this->request->post['mobile_phone'];
        } else {
        $this->data['customer_mobile_phone'] = $this->customer->getMobilePhone();
        } 
        
        
        if (isset($this->session->data['filter_by'])) 
        {
            $this->data['filter_by'] = $this->session->data['filter_by']; 

            if ( $this->data['filter_by'] == "invoice_number")
            {
                $this->data['filter_by_invoice_number'] = "selected";
                $this->data['filter_by_invoice_date'] = "";
                $this->data['filter_by_invoice_due_date'] = "";
            }
            else if ( $this->data['filter_by'] == "invoice_date")
            {
                $this->data['filter_by_invoice_date'] = "selected";
                $this->data['filter_by_invoice_number'] = "";
                $this->data['filter_by_invoice_due_date'] = "";
            }
            if ( $this->data['filter_by'] == "invoice_due_date")
            {
                $this->data['filter_by_invoice_due_date'] = "selected";
                $this->data['filter_by_invoice_number'] = "";
                $this->data['filter_by_invoice_date'] = "";
            }
            else
            {
                $this->data['filter_by_invoice_due_date'] = "";
                $this->data['filter_by_invoice_number'] = "";
                $this->data['filter_by_invoice_date'] = "";
            }
        }
        else
        {
            $this->data['filter_by_invoice_due_date'] = "";
            $this->data['filter_by_invoice_number'] = "";
            $this->data['filter_by_invoice_date'] = "";
        }
        
        
        if (isset($this->session->data['filter_value'])) {
        $this->data['filter_value'] = $this->session->data['filter_value'];
        } 
        else
        {
            $this->data['filter_value'] = '';
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

        $this->data['heading_title'] = $this->language->get( 'heading_title' );
        $this->data['text_firstname'] = $this->language->get( 'text_firstname' );
        $this->data['text_lastname'] = $this->language->get( 'text_lastname' );
        $this->data['text_mobile_phone'] = $this->language->get( 'text_mobile_phone' );
        $this->data['text_landline_phone'] = $this->language->get( 'text_landline_phone' );
        $this->data['text_contact_person'] = $this->language->get( 'text_contact_person' );
        $this->data['text_account_password'] = $this->language->get( 'text_account_password' );
        $this->data['text_available_delivery_addresses'] = $this->language->get( 'text_available_delivery_addresses' );
        $this->data['text_add_new_address'] = $this->language->get( 'text_add_new_address' );
        $this->data['text_company_details'] = $this->language->get( 'text_company_details' );

        $this->data['text_my_account'] = $this->language->get( 'text_my_account' );
        $this->data['text_my_orders'] = $this->language->get( 'text_my_orders' );
        $this->data['text_my_newsletter'] = $this->language->get( 'text_my_newsletter' );
        $this->data['text_edit'] = $this->language->get( 'text_edit' );
        $this->data['text_password'] = $this->language->get( 'text_password' );
        $this->data['text_address'] = $this->language->get( 'text_address' );
        $this->data['text_wishlist'] = $this->language->get( 'text_wishlist' );
        $this->data['text_order'] = $this->language->get( 'text_order' );
        $this->data['text_download'] = $this->language->get( 'text_download' );
        $this->data['text_reward'] = $this->language->get( 'text_reward' );
        $this->data['text_return'] = $this->language->get( 'text_return' );
        $this->data['text_transaction'] = $this->language->get( 'text_transaction' );
        $this->data['text_newsletter'] = $this->language->get( 'text_newsletter' );
        $this->data['text_recurring'] = $this->language->get( 'text_recurring' );
        
        $this->data['text_payment_term'] = $this->language->get( 'text_payment_term' );
        $this->data['text_percentage'] = $this->language->get( 'text_percentage' );
        $this->data['text_credit_limit'] = $this->language->get( 'text_credit_limit' );
        $this->data['text_undefined'] = $this->language->get( 'text_undefined' );
        
        $this->data['text_mailbox'] = $this->language->get( 'text_mailbox' );
        $this->data['text_useful_documents'] = $this->language->get( 'text_useful_documents' );
        $this->data['text_reclamation'] = $this->language->get( 'text_reclamation' );
        $this->data['text_add_reclamation'] = $this->language->get( 'text_add_reclamation' );
        $this->data['text_list_reclamation'] = $this->language->get( 'text_list_reclamation' );
                       
       
        // address
        $this->load->model('account/address');
        $this->data['addresses'] = array();
        $results = $this->model_account_address->getAddresses();
        
        foreach ($results as $result) {
            if ($result['address_format']) 
                {
                    $format = $result['address_format'];
                } 
                else 
                {
                    $format = '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
                    $format_only_street = '{address_1}' . "\n" . '{address_2}';
                }
		
            $find = array(
                    '{address_1}',
                    '{address_2}',
                    '{city}',
                    '{postcode}',
                    '{zone}',
                    '{zone_code}',
                    '{country}'
           );
                      
           $find_only_street = array(
                '{address_1}',
                '{address_2}'
           );
	
            $replace = array(
                    'address_1' => $result['address_1'],
                    'address_2' => $result['address_2'],
                    'city'      => $result['city'],
                    'postcode'  => $result['postcode'],
                    'zone'      => $result['zone'],
                    'zone_code' => $result['zone_code'],
                    'country'   => $result['country']  
            );
                       
           $replace_only_street = array(
                'address_1'   => $result['address_1'],
                'address_2'   => $result['address_2']
            );

            $this->data['addresses'][] = array(
                'address_id' => $result['address_id'],
                'address'    => str_replace(array("\r\n", "\r", "\n"), ', ', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), ', ', trim(str_replace($find, $replace, $format)))),
                'update'     => $this->url->link('account/address/update', 'address_id=' . $result['address_id'], 'SSL'),
                'delete'     => $this->url->link('account/address/delete', 'address_id=' . $result['address_id'], 'SSL')
      		  );
    	 }
              
       $company_detail_results = $this->model_account_address->getCompanyDetails();
       $this->data['company_details_info'] = array();
               
       foreach ($company_detail_results as $result) {
            if ($result['address_format']) 
                {
                    $format = $result['address_format'];
                } 
                else 
                {
                    $format_company = '{company}'. "\n" . '{iban}'. " - " .'{banca}'."\n" . '{zone}'."\n" . '{city}'."\n" . '{address_1}'."\n" . '{address_2}'."\n" . '{postcode}';
                }
            
           $find_company = array(
                '{company}',
                '{iban}',
                '{banca}',
                '{zone}',
                '{city}',
                '{address_1}',
                '{address_2}',
                '{postcode}'
           );
                       
           $replace_company = array(
                'company'   => $result['company'],
                'iban'      => $result['iban'], 
                'banca'     => $result['banca'], 
                'zone'   => $result['zone'], 
                'city'      => $result['city'], 
                'address_1' => $result['address_1'], 
                'address_2' => $result['address_2'], 
                'postcode'  => $result['postcode'], 
            );
            
            $this->data['company_details_info'][] = array(
                'address_id' => $result['address_id'],
                'company_info'    => str_replace(array("\r\n", "\r", "\n"), ', ', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), ', ', trim(str_replace($find_company, $replace_company, $format_company)))),
                'update'     => $this->url->link('account/company_details/update', 'address_id=' . $result['address_id'], 'SSL'),
                'delete'     => $this->url->link('account/address/delete', 'address_id=' . $result['address_id'], 'SSL')
      		 );
    	 }  
       
        $this->data['button_edit'] = $this->language->get('button_edit');
        $this->data['button_delete'] = $this->language->get('button_delete');
        $this->data['text_are_you_sure'] = $this->language->get( 'text_are_you_sure' );

        
        $this->data['customer_B2B']  = false;
        //show for B2B customers the invoices
        if( $this->customer->getCustomerGroupId() == 3 || $this->customer->getCustomerGroupId() == 4 )
        {
            $this->data['customer_B2B']  = true;
            
            $this->language->load( 'invoice/invoice' );
            $this->data['text_me_invoices'] = $this->language->get( 'text_me_invoices' );
            $this->data['text_lists'] = $this->language->get( 'text_lists' );
            $this->data['text_choose_invoice_type'] = $this->language->get( 'text_choose_invoice_type' );
            $this->data['text_all'] = $this->language->get( 'text_all' );
            $this->data['text_invoices_cashed'] = $this->language->get( 'text_invoices_cashed' );
            $this->data['text_unpaid_invoices_in_due_date'] = $this->language->get( 'text_unpaid_invoices_in_due_date' );
            $this->data['text_unpaid_invoices_over_due_date'] = $this->language->get( 'text_unpaid_invoices_over_due_date' );                                    
            $this->data['list_invoices'] = $this->url->link( 'invoice/invoice/listinvoices', '', 'SSL' );
            
            $this->data['text_filter_invoice_by'] = $this->language->get( 'text_filter_invoice_by' );
            $this->data['text_choose_filter_type'] = $this->language->get( 'text_choose_filter_type' );
            $this->data['text_invoice_number'] = $this->language->get( 'text_invoice_number' );
            $this->data['text_invoice_date'] = $this->language->get( 'text_invoice_date' );
            $this->data['text_invoice_due_date'] = $this->language->get( 'text_invoice_due_date' );
            
            
            $this->data['permission'] = $this->customer->getPermission();
            $this->language->load( 'agent/agent' );
            $this->data['text_full_permision'] = $this->language->get( 'text_full_permision' );
            
            //$this->data['payment_term'] = substr($this->customer->getPaymentTerm(), 0, 10);
            
            
            $customer_ax_code = $this->customer->getAxCode();
            //$this->data['nivel_payment_term'] = $this->model_account_customer->returnDiscoutFromAxCustomerTable( $customer_ax_code );
            $this->data['text_days'] = $this->language->get( 'text_days' );
            //$this->data['payment_term'] = $this->model_account_customer->returnPaymentTermFromAxCustomerTable( $customer_ax_code );
            //$this->data['credit_limit'] = $this->currency->format ( $this->model_account_customer->returnCreditLimitFromAxCustomerTable( $customer_ax_code ) );
            
            // for master customers list the agents
            if ( $this->data['permission'] ==  $this->language->get( 'text_full_permision' ) )// "master"
            {
                $this->data['text_agents'] = $this->language->get( 'text_agents' );
                $this->data['text_listing_agent_data'] = $this->language->get( 'text_listing_agent_data' );
                $this->data['text_choose_the_agent'] = $this->language->get( 'text_choose_the_agent' );
                $this->data['text_choose_agent'] = $this->language->get( 'text_choose_agent' );
                                
                $company_info = array( );
                $company_info['ax_code'] = $customer_ax_code;
                
                $this->load->model('account/address');
                $address = $this->model_account_address->getAddress( $this->customer->getAddressId() );
                $company_info['tax_id'] = $address['tax_id'];
                
                
                $this->data['agents'] = $this->model_account_customer->getAgents( $company_info );
                
                $this->data['show_agent_info'] = $this->url->link( 'agent/agent/edit', '', 'SSL' );
            }
            
            // B2B_adresa
            $this->load->model('invoice/address');
            $this->data['b2b_addresses'] = array();
            $b2b_addresses = $this->model_invoice_address->getAllAddresses( $this->customer->getAxCode());
            
            foreach ($b2b_addresses as $value ) {
                
                $this->data['b2b_addresses'][] = array(
                'accountnum' => $value['accountnum'],
                'nrcrt' => $value['nrcrt'],
                'b2b_address'    => $value['street'].", " . $value['city'] .", " . $value['county'].", " . $value['zipcode'],
                'b2b_update'     => $this->url->link('account/b2b_address/update', 'accountnum=' . $value['accountnum'].'&nrcrt='.$value['nrcrt'], 'SSL'),
                'b2b_delete'     => $this->url->link('account/b2b_address/delete', 'accountnum=' . $value['accountnum'].'&nrcrt='.$value['nrcrt'], 'SSL')
      		      );
            }  
            
            $this->data['add_new_b2b_address'] = $this->url->link( 'account/b2b_address/insert', '', 'SSL' );
            
            // B2B_cont_bancar
            $this->load->model('invoice/bank_account');
            $this->data['b2b_bank_accounts'] = array();
            $b2b_bank_accounts = $this->model_invoice_bank_account->getAllBankAccount( $this->customer->getAxCode() );
            
            foreach ($b2b_bank_accounts as $value ) {
                
                $this->data['b2b_bank_accounts'][] = array(
                'accountnum' => $value['custaccount'],
                'iban' => $value['iban'],
                'b2b_bank_account'    => $value['iban'],
                'b2b_bank_account_delete'     => $this->url->link('account/b2b_bank_account/delete', 'accountnum=' . $value['custaccount'].'&iban='.$value['iban'], 'SSL')
      		      );
            }  
        }

        $this->data['edit'] = $this->url->link( 'account/edit', '', 'SSL' );
        $this->data['add_new_address'] = $this->url->link( 'account/address/insert', '', 'SSL' );
        $this->data['company_details'] = $this->url->link( 'account/company_details/update' );
        
        $this->data['password'] = $this->url->link( 'account/password', '', 'SSL' );
        $this->data['address'] = $this->url->link( 'account/address', '', 'SSL' );
        $this->data['wishlist'] = $this->url->link( 'account/wishlist' );
        $this->data['order'] = $this->url->link( 'account/order', '', 'SSL' );
        $this->data['download'] = $this->url->link( 'account/download', '', 'SSL' );
        $this->data['return'] = $this->url->link( 'account/return', '', 'SSL' );
        $this->data['transaction'] = $this->url->link( 'account/transaction', '', 'SSL' );
        $this->data['newsletter'] = $this->url->link( 'account/newsletter', '', 'SSL' );
        $this->data['recurring'] = $this->url->link( 'account/recurring', '', 'SSL' );
        
        $this->data['mailbox'] = $this->url->link( 'mailbox/mailbox', '', 'SSL' );
        $this->data['document'] = $this->url->link( 'document/document/listdocuments', '', 'SSL' );
        $this->data['add'] = $this->url->link( 'reclamation/reclamation/addreclamation', '', 'SSL' );
        $this->data['list'] = $this->url->link( 'reclamation/reclamation/listreclamation', '', 'SSL' );
        
        $this->data['action'] = $this->url->link('account/account/index', '', 'SSL');
        $this->data['button_continue'] = $this->language->get('text_edit');

        if( $this->config->get( 'reward_status' ) )
        {
            $this->data['reward'] = $this->url->link( 'account/reward', '', 'SSL' );
        }
        else
        {
            $this->data['reward'] = '';
        }

        if( file_exists( DIR_TEMPLATE.$this->config->get( 'config_template' ).'/template/account/account.tpl' ) )
        {
            $this->template = $this->config->get( 'config_template' ).'/template/account/account.tpl';
        }
        else
        {
            $this->template = 'default/template/account/account.tpl';
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
    
    
    protected function validate() {
		if ((utf8_strlen($this->request->post['firstname']) < 1) || (utf8_strlen($this->request->post['firstname']) > 32)) {
			$this->error['firstname'] = $this->language->get('error_firstname');
		}
    
		if ((utf8_strlen($this->request->post['lastname']) < 1) || (utf8_strlen($this->request->post['lastname']) > 32)) {
			$this->error['lastname'] = $this->language->get('error_lastname');
		}
		
		if ((utf8_strlen($this->request->post['telephone']) < 3) || (utf8_strlen($this->request->post['telephone']) > 32)) {
			$this->error['telephone'] = $this->language->get('error_telephone');
		}
    
    if ((utf8_strlen($this->request->post['mobile_phone']) > 15) || (!is_numeric( $this->request->post['mobile_phone'] ) ) ) 
    {
        $this->error['mobile_phone'] = $this->language->get('error_mobile_phone');
    }
    
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

}

?>