<?php

class ControllerAgentAgent extends Controller
{
    private $error = array();
    
    public function edit()
    {
        if (!$this->customer->isLogged()) 
        {
            $this->session->data['redirect'] = $this->url->link( 'agent/agent/edit', 'id='.$id, 'SSL' );
            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }
    
        $this->language->load( 'agent/agent' );
        $this->document->setTitle( $this->language->get( 'text_listing_agent_data' ) );
        
        if( ($this->request->server['REQUEST_METHOD'] == 'GET') && isset( $this->request->get['id'] ) )
        {
            $id = $this->request->get['id'];
        }
        else if ($this->request->server['REQUEST_METHOD'] == 'POST')
        {
            $id = $this->request->post['id'];
        }  
        
        $this->load->model('account/customer');
        $customer_info = $this->model_account_customer->getCustomer( $id );
        $this->data['id'] = $id;
        $this->data['old_email'] = $customer_info['email'];
		
		    
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) 
        {
            $this->model_account_customer->saveAgentModifiedData($this->request->post);
            
            // if the master client want to changed the email address for slave client
            if ( $customer_info['email'] != $this->request->post['email'] )
            {
              $this->sendChangeEmailAdressForAdmin( $id, $customer_info );
            }
    
            $this->session->data['success'] = $this->language->get('text_success_agent');

            $this->redirect($this->url->link('account/account', '', 'SSL'));
        }

        
        if( $customer_info )
        {             
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

            $url = '';

            if( isset( $this->request->get['page'] ) )
            {
                $url .= '&page='.$this->request->get['page'];
            }

            $this->data['breadcrumbs'][] = array(
                'text' => $this->language->get( 'text_edit_agent_information' ),
                'href' => $this->url->link( 'agent/agent/edit', 'id='.$id.$url, 'SSL' ),
                'separator' => $this->language->get( 'text_separator' )
            );


            $this->data['heading_title'] = $this->language->get( 'heading_title' );
            $this->data['text_your_details'] = $this->language->get( 'text_your_details' );

            $this->data['entry_firstname'] = $this->language->get( 'entry_firstname' );
            $this->data['entry_lastname'] = $this->language->get('entry_lastname');
            $this->data['entry_email'] = $this->language->get( 'entry_email' );
            $this->data['entry_telephone'] = $this->language->get( 'entry_telephone' );
            $this->data['entry_fax'] = $this->language->get( 'entry_fax' );
            $this->data['entry_status'] = $this->language->get( 'entry_status' );
            $this->data['text_enabled'] = $this->language->get( 'text_enabled' );
            $this->data['text_disabled'] = $this->language->get( 'text_disabled' );

            $this->data['button_continue'] = $this->language->get( 'button_continue' );
            $this->data['button_back'] = $this->language->get( 'button_back' );
            $this->data['back'] = $this->url->link('account/account', '', 'SSL');
            
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

            if (isset($this->error['email'])) {
            $this->data['error_email'] = $this->error['email'];
            } else {
            $this->data['error_email'] = '';
            }	

            if (isset($this->error['telephone'])) {
            $this->data['error_telephone'] = $this->error['telephone'];
            } else {
            $this->data['error_telephone'] = '';
            }	

            $this->data['action'] = $this->url->link('agent/agent/edit', '', 'SSL');
            
            if (isset($this->request->post['firstname'])) {
            $this->data['firstname'] = $this->request->post['firstname'];
            } elseif (isset($customer_info)) {
            $this->data['firstname'] = $customer_info['firstname'];
            } else {
            $this->data['firstname'] = '';
            }

            if (isset($this->request->post['lastname'])) {
            $this->data['lastname'] = $this->request->post['lastname'];
            } elseif (isset($customer_info)) {
            $this->data['lastname'] = $customer_info['lastname'];
            } else {
            $this->data['lastname'] = '';
            }

            if (isset($this->request->post['email'])) {
            $this->data['email'] = $this->request->post['email'];
            } elseif (isset($customer_info)) {
            $this->data['email'] = $customer_info['email'];
            } else {
            $this->data['email'] = '';
            }

            if (isset($this->request->post['telephone'])) {
            $this->data['telephone'] = $this->request->post['telephone'];
            } elseif (isset($customer_info)) {
            $this->data['telephone'] = $customer_info['telephone'];
            } else {
            $this->data['telephone'] = '';
            }

            if (isset($this->request->post['fax'])) {
            $this->data['fax'] = $this->request->post['fax'];
            } elseif (isset($customer_info)) {
            $this->data['fax'] = $customer_info['fax'];
            } else {
            $this->data['fax'] = '';
            }
            
            if( isset( $this->request->post['status'] ) )
            {
                $this->data['status'] = $this->request->post['status'];
            }
            elseif( !empty( $customer_info ) )
            {
                $this->data['status'] = $customer_info['status'];
            }
            else
            {
                $this->data['status'] = 1;
            }

            if( file_exists( DIR_TEMPLATE.$this->config->get( 'config_template' ).'/template/agent/edit_agent_info.tpl' ) )
            {
                $this->template = $this->config->get( 'config_template' ).'/template/agent/edit_agent_info.tpl';
            }
            else
            {
                $this->template = 'default/template/invoice/edit_agent_info.tpl';
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
        else
        {
            $this->document->setTitle( $this->language->get( 'text_invoice' ) );
            $this->data['heading_title'] = $this->language->get( 'text_invoice' );
            $this->data['text_error'] = $this->language->get( 'text_error' );
            $this->data['button_continue'] = $this->language->get( 'text_button_continue' );

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
                'text' => $this->language->get( 'text_invoice_detail' ),
                'href' => $this->url->link( 'agent/agent/edit', 'id='.$id, 'SSL' ),
                'separator' => $this->language->get( 'text_separator' )
            );

            if( file_exists( DIR_TEMPLATE.$this->config->get( 'config_template' ).'/template/error/not_found.tpl' ) )
            {
                $this->template = $this->config->get( 'config_template' ).'/template/error/not_found.tpl';
            }
            else
            {
                $this->template = 'default/template/error/not_found.tpl';
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
    }


   protected function validate() {
       
		if ((utf8_strlen($this->request->post['firstname']) < 1) || (utf8_strlen($this->request->post['firstname']) > 32)) {
			$this->error['firstname'] = $this->language->get('error_firstname');
		}

		if ((utf8_strlen($this->request->post['lastname']) < 1) || (utf8_strlen($this->request->post['lastname']) > 32)) {
			$this->error['lastname'] = $this->language->get('error_lastname');
		}

		if ((utf8_strlen($this->request->post['email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['email'])) {
			$this->error['email'] = $this->language->get('error_email');
		}
    
		if ((utf8_strlen($this->request->post['telephone']) < 3) || (utf8_strlen($this->request->post['telephone']) > 32)) {
			$this->error['telephone'] = $this->language->get('error_telephone');
		}
       
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
  
  private function sendChangeEmailAdressForAdmin( $id, $customer_info )
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
        $email_address_info = $this->model_setting_email_address_setting_email_address->getEmailAddress( 'SCHIMBAREA_ADRESEI_DE_EMAIL_A_CLIENTULUI' ); // Schimbarea adresei de email a clientului
        
        if ( isset( $email_address_info ) && !empty($email_address_info['email']) )
        { 
            $mail->setTo( $email_address_info['email'] );
        }
        else
        {
            $mail->setTo( $this->config->get( 'config_email' ) );
        }
          
        $mail->setFrom($this->config->get('config_email'));
        $mail->setSender($this->config->get('config_name'));

        $this->language->load( 'agent/agent' );
        $subject =  $this->language->get( 'text_change_emailaddress' );
        $mail->setSubject(html_entity_decode( $subject , ENT_QUOTES, 'UTF-8'));

        $message = $this->language->get( 'text_customer' );

        //get the company name
        $this->load->model( 'account/address' );
        $address = $this->model_account_address->getAddress( $this->customer->getAddressId() );
        if ( empty($address['company']) ) $company_name = $this->customer->getFirstName()." ".$this->customer->getLastName();
            else $company_name = $address['company'];

        $message .= $company_name;
        $message .= $this->language->get( 'text_full_access' );
        $message .= $this->language->get( 'text_change_emailaddress_for_customer' );        

        $address2 = $this->model_account_address->getCustomerAddress( $customer_info['address_id'] );
        if ( empty($address2['company']) ) $company_name2 = $customer_info['firstname']. " ".$customer_info['lastname'];
            else $company_name2 = $address2['company'];
        $message .= $company_name2;
        $message .= $this->language->get( 'text_limited_access' );

        $mail->setHtml(html_entity_decode( $message, ENT_QUOTES, 'UTF-8'));
        $mail->send();
  }

}

?>