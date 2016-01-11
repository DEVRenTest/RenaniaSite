<?php
class ControllerAccountEdit extends Controller {
	private $error = array();

	public function index() {
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/edit', '', 'SSL');

			$this->redirect($this->url->link('account/login', '', 'SSL'));
		}

		$this->language->load('account/edit');
		
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('account/customer');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
        
			$this->model_account_customer->editCustomer($this->request->post);
			
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
      $email_address_info = $this->model_setting_email_address_setting_email_address->getEmailAddress( "MODIFICARI_DATE" ); // Modificari date
      
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
      
      $subject = $this->language->get('text_subject_notification');
      $message = $this->language->get('text_client'). "<strong>".$this->customer->getAxCode() ."</strong> (".$this->customer->getEmail()."), ";
      $message .= $this->language->get('text_change_account_info');
            
			$mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
			$mail->setHtml(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
			$mail->send();

			$this->redirect($this->url->link('account/account', '', 'SSL'));
		}

      	$this->data['breadcrumbs'] = array();

      	$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),     	
        	'separator' => false
      	); 

      	$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_account'),
			'href'      => $this->url->link('account/account', '', 'SSL'),        	
        	'separator' => $this->language->get('text_separator')
      	);

      	$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_edit'),
			'href'      => $this->url->link('account/edit', '', 'SSL'),       	
        	'separator' => $this->language->get('text_separator')
      	);
		
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_your_details'] = $this->language->get('text_your_details');

		$this->data['entry_firstname'] = $this->language->get('entry_firstname');


				$this->data['entry_middlename'] = $this->language->get('entry_middlename');

				$this->data['entry_identity_card_number'] = $this->language->get('entry_identity_card_number');

				$this->data['entry_mobile_phone'] = $this->language->get('entry_mobile_phone');

            
		$this->data['entry_lastname'] = $this->language->get('entry_lastname');
		$this->data['entry_email'] = $this->language->get('entry_email');
		$this->data['entry_telephone'] = $this->language->get('entry_telephone');
		$this->data['entry_fax'] = $this->language->get('entry_fax');

		$this->data['button_continue'] = $this->language->get('button_continue');
		$this->data['button_back'] = $this->language->get('button_back');

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



				if (isset($this->error['middlename'])) {

					$this->data['error_middlename'] = $this->error['middlename'];

				} else {

					$this->data['error_middlename'] = '';

				}

            if (isset($this->error['identity_card_number'])) {

					$this->data['error_identity_card_number'] = $this->error['identity_card_number'];

				} else {

					$this->data['error_identity_card_number'] = '';

				}

            if (isset($this->error['mobile_phone'])) {

					$this->data['error_mobile_phone'] = $this->error['mobile_phone'];

				} else {

					$this->data['error_mobile_phone'] = '';

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

		$this->data['action'] = $this->url->link('account/edit', '', 'SSL');

		if ($this->request->server['REQUEST_METHOD'] != 'POST') {
			$customer_info = $this->model_account_customer->getCustomer($this->customer->getId());
		}



                if (isset($this->request->post['middlename'])) {

                    $this->data['middlename'] = $this->request->post['middlename'];

                } elseif (isset($customer_info)) {

                    $this->data['middlename'] = $customer_info['middlename'];

                } else {

                    $this->data['middlename'] = '';

                }

                 if (isset($this->request->post['identity_card_number'])) {

                    $this->data['identity_card_number'] = $this->request->post['identity_card_number'];

                } elseif (isset($customer_info)) {

                    $this->data['identity_card_number'] = $customer_info['identity_card_number'];

                } else {

                    $this->data['identity_card_number'] = '';

                }

                 if (isset($this->request->post['mobile_phone'])) {

                    $this->data['mobile_phone'] = $this->request->post['mobile_phone'];

                } elseif (isset($customer_info)) {

                    $this->data['mobile_phone'] = $customer_info['mobile_phone'];

                } else {

                    $this->data['mobile_phone'] = '';

                }

            
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

		$this->data['back'] = $this->url->link('account/account', '', 'SSL');
	 	$this->data['permission'] = $this->customer->getPermission();
    
    $this->language->load('agent/agent');
	 	$this->data['text_limited_permision'] = $this->language->get( 'text_limited_permision' );

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/edit.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/account/edit.tpl';
		} else {
			$this->template = 'default/template/account/edit.tpl';
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
						
		$this->response->setOutput($this->render());	
	}

	protected function validate() {
		if ((utf8_strlen($this->request->post['firstname']) < 1) || (utf8_strlen($this->request->post['firstname']) > 32)) {
			$this->error['firstname'] = $this->language->get('error_firstname');
		}



				if ( (utf8_strlen($this->request->post['middlename']) > 32)) {

					$this->error['middlename'] = $this->language->get('error_middlename');

				}

            

            if ( (utf8_strlen($this->request->post['identity_card_number']) > 15) || (!preg_match('/^[a-zA-Z0-9]+$/', $this->request->post['identity_card_number'])) )

            {

					$this->error['identity_card_number'] = $this->language->get('error_identity_card_number');

				}

            if ( (utf8_strlen($this->request->post['mobile_phone']) > 15 ) || (!is_numeric( $this->request->post['mobile_phone'] ) )) {

					$this->error['mobile_phone'] = $this->language->get('error_mobile_phone');

				}           

            
		if ((utf8_strlen($this->request->post['lastname']) < 1) || (utf8_strlen($this->request->post['lastname']) > 32)) {
			$this->error['lastname'] = $this->language->get('error_lastname');
		}

		if ((utf8_strlen($this->request->post['email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['email'])) {
			$this->error['email'] = $this->language->get('error_email');
		}
		
		if (($this->customer->getEmail() != $this->request->post['email']) && $this->model_account_customer->getTotalCustomersByEmail($this->request->post['email'])) {
			$this->error['warning'] = $this->language->get('error_exists');
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
  
  
  
  /*public function saveContactPersonInfo() {
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/edit', '', 'SSL');

			$this->redirect($this->url->link('account/login', '', 'SSL'));
		}

		$this->language->load('account/edit');
		
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('account/customer');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateContactPersonInfo()) {
        
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
      $email_address_info = $this->model_setting_email_address_setting_email_address->getEmailAddress( "MODIFICARI_DATE" ); // Modificari date
      
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
      
      $subject = $this->language->get('text_subject_notification');
      $message = $this->language->get('text_client'). "<strong>".$this->customer->getAxCode() ."</strong> (".$this->customer->getEmail()."), ";
      $message .= $this->language->get('text_change_account_info');
            
			$mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
			$mail->setHtml(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
			$mail->send();

			$this->redirect($this->url->link('account/account', '', 'SSL'));
		}

      	$this->data['breadcrumbs'] = array();

      	$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),     	
        	'separator' => false
      	); 

      	$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_account'),
			'href'      => $this->url->link('account/account', '', 'SSL'),        	
        	'separator' => $this->language->get('text_separator')
      	);

      	$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_edit'),
			'href'      => $this->url->link('account/edit', '', 'SSL'),       	
        	'separator' => $this->language->get('text_separator')
      	);
		
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_your_details'] = $this->language->get('text_your_details');

		$this->data['entry_firstname'] = $this->language->get('entry_firstname');


				$this->data['entry_middlename'] = $this->language->get('entry_middlename');

				$this->data['entry_identity_card_number'] = $this->language->get('entry_identity_card_number');

				$this->data['entry_mobile_phone'] = $this->language->get('entry_mobile_phone');

            
		$this->data['entry_lastname'] = $this->language->get('entry_lastname');
		$this->data['entry_email'] = $this->language->get('entry_email');
		$this->data['entry_telephone'] = $this->language->get('entry_telephone');
		$this->data['entry_fax'] = $this->language->get('entry_fax');

		$this->data['button_continue'] = $this->language->get('button_continue');
		$this->data['button_back'] = $this->language->get('button_back');

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



				if (isset($this->error['middlename'])) {

					$this->data['error_middlename'] = $this->error['middlename'];

				} else {

					$this->data['error_middlename'] = '';

				}

            if (isset($this->error['identity_card_number'])) {

					$this->data['error_identity_card_number'] = $this->error['identity_card_number'];

				} else {

					$this->data['error_identity_card_number'] = '';

				}

            if (isset($this->error['mobile_phone'])) {

					$this->data['error_mobile_phone'] = $this->error['mobile_phone'];

				} else {

					$this->data['error_mobile_phone'] = '';

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

		$this->data['action'] = $this->url->link('account/edit', '', 'SSL');

		if ($this->request->server['REQUEST_METHOD'] != 'POST') {
			$customer_info = $this->model_account_customer->getCustomer($this->customer->getId());
		}



                if (isset($this->request->post['middlename'])) {

                    $this->data['middlename'] = $this->request->post['middlename'];

                } elseif (isset($customer_info)) {

                    $this->data['middlename'] = $customer_info['middlename'];

                } else {

                    $this->data['middlename'] = '';

                }

                 if (isset($this->request->post['identity_card_number'])) {

                    $this->data['identity_card_number'] = $this->request->post['identity_card_number'];

                } elseif (isset($customer_info)) {

                    $this->data['identity_card_number'] = $customer_info['identity_card_number'];

                } else {

                    $this->data['identity_card_number'] = '';

                }

                 if (isset($this->request->post['mobile_phone'])) {

                    $this->data['mobile_phone'] = $this->request->post['mobile_phone'];

                } elseif (isset($customer_info)) {

                    $this->data['mobile_phone'] = $customer_info['mobile_phone'];

                } else {

                    $this->data['mobile_phone'] = '';

                }

            
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

		$this->data['back'] = $this->url->link('account/account', '', 'SSL');
	 	$this->data['permission'] = $this->customer->getPermission();
    
    $this->language->load('agent/agent');
	 	$this->data['text_limited_permision'] = $this->language->get( 'text_limited_permision' );

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/edit.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/account/edit.tpl';
		} else {
			$this->template = 'default/template/account/edit.tpl';
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
						
		$this->response->setOutput($this->render());	
	}*/
}
?>