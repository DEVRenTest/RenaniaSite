<?php   
class ControllerCronAbandonedCartReminder extends Controller {
	private $default_language_id;
	
	public function index() {
		
		$this->load->model('module/abandoned_cart_reminder');		
		$this->load->model('catalog/product');
		
		if (!isset($this->request->get['secret_code'])){
			echo "You forgot secret code";
			exit;
		}
		
		if ($this->request->get['secret_code'] != $this->config->get('abandoned_cart_reminder_secret_code')){
			echo "Access Denied: Wrong secret code";
			exit;
		}
		
		$this->default_language_id = $this->config->get('config_language_id');
		
		$operation = 'send';
		
		if (isset($this->request->get['op_type'])){
			$operation = $this->request->get['op_type'];
		}
		
		if (isset($this->request->get['filter_customer_id'])) {
			$data = array('filter_customer_id' => $this->request->get['filter_customer_id']);
		} else {
			$data = array();
		}
		
		// will remove customers with cart content: 
		// - products not available anymore in store 
		// - or same products from prevoius order (related to some payment extensions who forgot to claer cart after order is complete )
		$customers = $this->filterCustomers($this->model_module_abandoned_cart_reminder->getCustomersForReminder($data));
		
		if ($customers){
			if ($operation == 'send') {
				$this->sendACREmail($customers);
			}
			
			if ($operation == 'preview') {
				$this->previewACREmail(end($customers));
			}
		} else {
				echo "No customer need to be informed yet. <br />";
		}	
		
		$this->model_module_abandoned_cart_reminder->deleteExpiredCoupons();
	}
	
	private function sendACREmail($customers) {
	
		$mail = new Mail(); 
		$mail->protocol = $this->config->get('config_mail_protocol');
		$mail->parameter = $this->config->get('config_mail_parameter');
		$mail->hostname = $this->config->get('config_smtp_host');
		$mail->username = $this->config->get('config_smtp_username');
		$mail->password = $this->config->get('config_smtp_password');
		$mail->port = $this->config->get('config_smtp_port');
		$mail->timeout = $this->config->get('config_smtp_timeout');	
		$mail->setFrom($this->config->get('config_email'));
		$mail->setSender($this->config->get('config_name'));
	
		foreach($customers as $customer){
			if ( $this->config->get('abandoned_cart_reminder_add_coupon') && ((int)$this->config->get('abandoned_cart_reminder_reward_limit') == 0 || $customer['number_reward_sent'] == 0 || (int)$this->config->get('abandoned_cart_reminder_reward_limit') > $customer['number_reward_sent'] )) {
				$coupon_attached = true;
			} else {
				$coupon_attached = false;
			}
		
			$email_template_languages = $this->config->get('abandoned_cart_reminder_mail');
			
			if ($customer['acr_mail_language_id'] && isset($email_template_languages[$customer['acr_mail_language_id']]) && $this->isLanguageEnabled($customer['acr_mail_language_id'])) {
				$used_language_id = $customer['acr_mail_language_id'];
			} else {
				$used_language_id = $this->config->get('config_language_id');
			}
			
			$email_template = $email_template_languages[$used_language_id];
			$subject = html_entity_decode($email_template['subject'], ENT_QUOTES, 'UTF-8');
		
			$html = $this->getReminderHtml($customer, 'send', $coupon_attached);
			
			$mail->setSubject($subject);
			$mail->setTo($customer['email']);
			$mail->setHtml($html);
			$mail->send();
			
			echo "Reminder sent to " . $customer['email'];
			
			if (!$coupon_attached) {
				echo " WITHOUT COUPON (Reason: Already sent until now " . $customer['number_reward_sent'] . " coupons )";
			}
			
			echo "<br />";
			
			$this->model_module_abandoned_cart_reminder->increaseNumberReminderSent($customer['customer_id']);
			
			if ($coupon_attached) {
				$this->model_module_abandoned_cart_reminder->increaseNumberRewardSent($customer['customer_id']);
			}

			$this->model_module_abandoned_cart_reminder->addHistory($customer, $coupon_attached, $html);	
		}
	}
	
	private function previewACREmail($customer_info) {
		
		if ( $this->config->get('abandoned_cart_reminder_add_coupon') && ((int)$this->config->get('abandoned_cart_reminder_reward_limit') == 0 || $customer_info['number_reward_sent'] == 0 || (int)$this->config->get('abandoned_cart_reminder_reward_limit') < $customer_info['number_reward_sent'] )) {
			$coupon_attached = true;
		} else {
			$coupon_attached = false;
		}
	
		$html = $this->getReminderHtml($customer_info, 'preview', $coupon_attached);
		
		echo $html;
	}
	
	public function getHistoryEmail() {
		if (!isset($this->request->get['secret_code'])){
			echo "You forgot secret code";
			exit;
		}
		
		if ($this->request->get['secret_code'] != $this->config->get('abandoned_cart_reminder_secret_code')){
			echo "Access Denied: Wrong secret code";
			exit;
		}
		
		$this->load->model('module/abandoned_cart_reminder');

		if (isset($this->request->get['acr_history_id'])) {
			$acr_history_id = (int)$this->request->get['acr_history_id'];
		} else {
			$acr_history_id = 0;
		}      

		$reminder_info = $this->model_module_abandoned_cart_reminder->getHistory($acr_history_id);

		if ($reminder_info) {
			$output = html_entity_decode($reminder_info['email_description'], ENT_QUOTES, 'UTF-8');		

			$this->response->setOutput($output);
		}
	}

	private function getReminderHtml($customer_info, $operation, $coupon_attached){
		
		$this->load->model('module/abandoned_cart_reminder');
		$this->load->model('catalog/product');
		
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$server = $this->config->get('config_ssl');
		} else {
			$server = $this->config->get('config_url');
		}
		
		$template = new Template();
		
		$template->data['logo'] = $server . 'image/' . $this->config->get('config_logo');		
		$template->data['store_name'] = $this->config->get('config_name');	
		$template->data['store_url'] = $this->config->get('config_use_ssl') ? $this->config->get('config_ssl') : $this->config->get('config_url');
		
		$email_template_languages = $this->config->get('abandoned_cart_reminder_mail');
		
		if ($customer_info['acr_mail_language_id'] && isset($email_template_languages[$customer_info['acr_mail_language_id']]) && $this->isLanguageEnabled($customer_info['acr_mail_language_id'])) {
			$used_language_id = $customer_info['acr_mail_language_id'];
		} else {
			$used_language_id = $this->config->get('config_language_id');
		}
		
		$email_template = $email_template_languages[$used_language_id];
		
		if ( $this->config->get('abandoned_cart_reminder_add_coupon') && ((int)$this->config->get('abandoned_cart_reminder_reward_limit') == 0 || $customer_info['number_reward_sent'] == 0 || (int)$this->config->get('abandoned_cart_reminder_reward_limit') > $customer_info['number_reward_sent'] )) {
			$allow_coupon = true;
		} else {
			$allow_coupon = false;
		}
		
		$coupon_code = ($operation == 'preview')? 'preview' : $this->generateCode($customer_info);
		$cart_products = $this->getCartProducts($customer_info['cart'], $used_language_id);
		
		if ($allow_coupon && $operation != 'preview') {
			$this->model_module_abandoned_cart_reminder->addCoupon($coupon_code, $customer_info, $cart_products);
		}
		
		$find = array(
			'{firstname}',
			'{lastname}',
			'{shopping_cart_content}',
			'{coupon_code}',
			'{discount}',
			'{total_amount}',
			'{validity_days}',
			'{store_name}',
		);
		
		$replace = array(
			'firstname'        		   => $customer_info['firstname'],
			'lastname'         		   => $customer_info['lastname'],
			'shopping_cart_content'    => $this->getHTMLCart($cart_products),
			'coupon_code'              => $coupon_code,
			'discount'                 => ($this->config->get('abandoned_cart_reminder_coupon_type') == 0) ? $this->currency->format($this->config->get('abandoned_cart_reminder_coupon_amount')) : $this->config->get('abandoned_cart_reminder_coupon_amount') . '%',
			'total_amount'			   => $this->currency->format($this->config->get('abandoned_cart_reminder_coupon_total')),
			'validity_days'            => $this->config->get('abandoned_cart_reminder_coupon_expire'),
			'store_name'               => $this->config->get('config_name')	
		);
		
		$subject = str_replace($find, $replace, html_entity_decode($email_template['subject'], ENT_QUOTES, 'UTF-8'));
		
		
		if ($coupon_attached) {
			$message = str_replace($find, $replace, html_entity_decode($email_template['message_reward'], ENT_QUOTES, 'UTF-8'));
		} else {
			$message = str_replace($find, $replace, html_entity_decode($email_template['message_no_reward'], ENT_QUOTES, 'UTF-8'));
		}		
		
		if ($this->config->get('abandoned_cart_reminder_use_html_email') && $this->isHTMLEmailExtensionInstalled()) {
			
			$this->load->model('tool/html_email');
			$html = $this->model_tool_html_email->getHTMLEmail($this->config->get('config_language_id'), $subject, $message, 'html');
			
		} else {
				
				$template->data['title'] = $subject;
				$template->data['message'] = $message;
				
				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/mail/acr.tpl')) {
					$html = $template->fetch($this->config->get('config_template') . '/template/mail/acr.tpl');
				} else {
					$html = $template->fetch('default/template/mail/acr.tpl');
				}
		}
		
		return $html;
	}
	
	private function getHTMLCart($products) {
		
		$template = new Template();
		
		
		if ($this->config->get('html_email_main_table_border_color')) {
			$template->data['table_border_color'] = $this->config->get('html_email_main_table_border_color');				
		} else {
			$template->data['table_border_color'] = '#DDDDDD';				
		}		
		
		if ($this->config->get('html_email_main_table_body_bg')) {
			$template->data['table_body_bg'] = $this->config->get('html_email_main_table_body_bg');		
		} else {	
			$template->data['table_body_bg'] = '#FFFFFF';		
		}	
		
		if ($this->config->get('html_email_main_table_body_text_color')) {
			$template->data['table_body_text_color'] = $this->config->get('html_email_main_table_body_text_color');
		} else {
			$template->data['table_body_text_color'] = '#000000';
		}	
		
		$template->data['products'] = $products;
		
		$template_file = 'acr_cart.tpl';
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/mail/' . $template_file)) {
			$html = $template->fetch($this->config->get('config_template') . '/template/mail/' . $template_file);
		} else {
			$html = $template->fetch('default/template/mail/' . $template_file);
		}
		
		return $html;
	}

	private function getCartProducts($customer_cart, $used_language_id){
		$this->load->model('tool/image');
		
		$this->config->set('config_language_id', $used_language_id);
		
		$cart_products = array();
		
		if ($customer_cart && is_string($customer_cart)) {
			$cart = unserialize($customer_cart);
			
			foreach ($cart as $key => $value) {
				$product = explode(':', $key);
				$product_id = $product[0];
	
				// Options
				if (isset($product[1])) {
					$options = unserialize(base64_decode($product[1]));
				} else {
					$options = array();
				} 
				
				$product_info = $this->model_catalog_product->getProduct($product_id);
				
				if ($product_info){ 
					if ($product_info['image']) {
						$image = $this->model_tool_image->resize($product_info['image'], 30,30);
					} else {
						$image = $this->model_tool_image->resize('no_image.jpg', 30,30);
					}
				
					$option_data = array();

					if ($options) {
						foreach ($options as $product_option_id => $option_value) {
							$option_query = $this->db->query("SELECT po.product_option_id, po.option_id, od.name, o.type FROM " . DB_PREFIX . "product_option po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) WHERE po.product_option_id = '" . (int)$product_option_id . "' AND po.product_id = '" . (int)$product_id . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "'");

							if ($option_query->num_rows) {
								if ($option_query->row['type'] == 'select' || $option_query->row['type'] == 'radio' || $option_query->row['type'] == 'image') {
									$option_value_query = $this->db->query("SELECT pov.option_value_id, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_option_value_id = '" . (int)$option_value . "' AND pov.product_option_id = '" . (int)$product_option_id . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

									if ($option_value_query->num_rows) {

										$option_data[] = array(
											'name'                    => $option_query->row['name'],
											'option_value'            => $option_value_query->row['name']
										);								
									}
								} elseif ($option_query->row['type'] == 'checkbox' && is_array($option_value)) {
									foreach ($option_value as $product_option_value_id) {
										$option_value_query = $this->db->query("SELECT pov.option_value_id, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_option_value_id = '" . (int)$product_option_value_id . "' AND pov.product_option_id = '" . (int)$product_option_id . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

										if ($option_value_query->num_rows) {

											$option_data[] = array(
												'name'                    => $option_query->row['name'],
												'option_value'            => $option_value_query->row['name']
											);								
										}
									}						
								} elseif ($option_query->row['type'] == 'text' || $option_query->row['type'] == 'textarea' || $option_query->row['type'] == 'file' || $option_query->row['type'] == 'date' || $option_query->row['type'] == 'datetime' || $option_query->row['type'] == 'time') {
									$option_data[] = array(
										'name'                    => $option_query->row['name'],
										'option_value'            => $option_value
									);						
								}
							}
						}
					}	
				
					$cart_products[] = array( 
						'product_id' => $product_info['product_id'],
						'name'       => $product_info['name'],
						'image'      => $image,
						'quantity'   => $value,
						'options'    => $option_data,
						'href'       => $this->url->link('product/product', 'product_id=' . $product_info['product_id'], 'SSL')
					);
				}
			}			
		}
		
		$this->config->set('config_language_id', $this->default_language_id);
		
		return $cart_products;
	}	
	
	private function hasActiveProducts($customer_info) {
		$active_products = 0;
		
		if ($customer_info['cart'] && is_string($customer_info['cart'])) {
			$cart = unserialize($customer_info['cart']);
			
			foreach ($cart as $key => $value) {
				$key_split = explode(":", $key);
				$product_id = $key_split[0];
				
				$product_info = $this->model_catalog_product->getProduct($product_id);
				
				if ($product_info){ 
					if ($this->config->get('abandoned_cart_reminder_hide_out_stock')) {
						if ($product_info['quantity'] > 0) {
							$active_products++;
						}
					} else {
						$active_products++;
					}	
				}
			}			
		}
		
		return $active_products;
	}
	
	private function isPreviousOrder($customer_info) {
		$is_previous_order = false;
		
		$last_order_id = $this->model_module_abandoned_cart_reminder->getLastOrderId($customer_info['customer_id']);
		
		if ($last_order_id) {
			$last_order_products = $this->model_module_abandoned_cart_reminder->getLastOrderProducts($last_order_id);
		
			if ($customer_info['cart'] && is_string($customer_info['cart'])) {
				$cart = unserialize($customer_info['cart']);
				
				if ($this->hasSameProducts($cart, $last_order_products)) {
					$is_previous_order = true;
				}				
			}
		}
	
		return $is_previous_order;
	}
	
	private function hasSameProducts($cart, $last_order_products) {
		$same_products = true;  
		
		if (count($cart) != count($last_order_products)) {
			$same_products = false;
		} else {
		
			foreach ($cart as $key => $value) {
				$key_split = explode(":", $key);
				$product_id = $key_split[0];
				
				if (!in_array($product_id, $last_order_products)) {
					$same_products = false;
				}
			}	
		}
		
		return $same_products;
	}
	
	private function filterCustomers($customers) {
		$filtred_customers = array();
		
		if ($customers) {
			foreach($customers as $customer) {
				if ($this->hasActiveProducts($customer) && !$this->isPreviousOrder($customer)) {
					$filtred_customers[] = $customer; 
				}
			}			
		}
		
		return $filtred_customers;
	}
	
	private function generateCode($customer_info){
		$code = 'C' . $customer_info['customer_id'];
		$temp_len = strlen($code);
		$diff = 10 - $temp_len;
		$ucode = md5(time());
		$code .= substr($ucode,0, $diff);
		
		return strtoupper($code);
	}
	
	private function isHTMLEmailExtensionInstalled() {
		$installed = false;
		
		if ($this->config->get('html_email_default_word') && file_exists(DIR_APPLICATION . 'model/tool/html_email.php')) {
			$installed = true;	
		}
		
		return $installed;
	}
	
	private function isLanguageEnabled($language_id) {
		$status = false;
		
		$this->load->model('localisation/language');
		$language_info = $this->model_localisation_language->getLanguage($language_id);
		
		if ($language_info) {
			$status = $language_info['status'];
		} 
		
		return $status;
	}
	
}
?>