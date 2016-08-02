<?php
class ControllerCheckoutSuccess extends Controller { 
	public function index() { 	
		$this->data['coupa_url'] = false;
		if (isset($this->session->data['order_id'])) {
			$this->cart->clear();
			/*if($_SERVER['REMOTE_ADDR'] == "81.12.228.226"){ 
				print 'ok';
				print '<pre>';
				var_dump($this->session->data);
				print '</pre>';
				
				print 'CART: ';
				print '<pre>';
				var_dump($this->cart);
				print '</pre>';
			}*/
			if (isset($this->session->data['remote_order_url'])) {
				$this->load->model('account/order');
				$this->load->model('account/customer');
				$customer = $this->model_account_customer->getCustomer($this->customer->getId());
				$this->data['customer_shared_secret'] = $customer['secret_code'];
				$this->data['coupa_url'] = $this->session->data['remote_order_url'];
				$this->data['remote_cookie'] = $this->session->data['remote_cookie'];
				$this->data['order_id'] = $this->session->data['order_id'];
				$order = $this->model_account_order->getOrder($this->session->data['order_id']);
				$this->data['currency_code'] = $order['currency_code'];
				$this->data['products'] = $this->model_account_order->getOrderProducts($this->session->data['order_id']);
				$this->data['total'] = $order['total'];
				$this->data['totals'] = $this->model_account_order->getOrderTotals($this->session->data['order_id']);
				$this->data['shipping_method'] = $order['shipping_method'];
				$this->template = 'default/template/api/orderdata.tpl';
				$this->data['cxml'] = base64_encode($this->render());
			}
			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);
			unset($this->session->data['payment_method']);
			unset($this->session->data['payment_methods']);
			unset($this->session->data['guest']);
			unset($this->session->data['comment']);
			unset($this->session->data['order_id']);	
			unset($this->session->data['coupon']);
			unset($this->session->data['reward']);
			unset($this->session->data['voucher']);
			unset($this->session->data['vouchers']);
		}	
									   
		$this->language->load('checkout/success');
		
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->data['breadcrumbs'] = array(); 

      	$this->data['breadcrumbs'][] = array(
        	'href'      => $this->url->link('common/home'),
        	'text'      => $this->language->get('text_home'),
        	'separator' => false
      	); 
		
      	$this->data['breadcrumbs'][] = array(
        	'href'      => $this->url->link('checkout/cart'),
        	'text'      => $this->language->get('text_basket'),
        	'separator' => $this->language->get('text_separator')
      	);
				
		$this->data['breadcrumbs'][] = array(
			'href'      => $this->url->link('checkout/checkout', '', 'SSL'),
			'text'      => $this->language->get('text_checkout'),
			'separator' => $this->language->get('text_separator')
		);	
					
      	$this->data['breadcrumbs'][] = array(
        	'href'      => $this->url->link('checkout/success'),
        	'text'      => $this->language->get('text_success'),
        	'separator' => $this->language->get('text_separator')
      	);

		$this->data['heading_title'] = $this->language->get('heading_title');
		
		if ($this->customer->isLogged()) {
    		$this->data['text_message'] = sprintf($this->language->get('text_customer'), $this->url->link('account/account', '', 'SSL'), $this->url->link('account/order', '', 'SSL'), str_replace('index.php?route=','',$this->url->link('contact', '', 'SSL')), $this->url->link('information/contact'));
		} else {
    		$this->data['text_message'] = sprintf($this->language->get('text_guest'), $this->url->link('information/contact'));
		}
		
    	$this->data['button_continue'] = $this->language->get('button_continue');

    	$this->data['continue'] = $this->url->link('common/home');

    	$this->data['button_coupa'] = $this->language->get('button_coupa');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/success.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/common/success.tpl';
		} else {
			$this->template = 'default/template/common/success.tpl';
		}
		
		$this->children = array(
			'common/column_left',
			'common/column_right',
			'common/content_top',
			'common/content_bottom',
			'common/footer',
			'common/header'			
		);
				
		$this->response->setOutput($this->render());
  	}
}
?>