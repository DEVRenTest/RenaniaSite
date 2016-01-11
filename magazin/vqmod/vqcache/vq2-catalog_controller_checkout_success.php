<?php
class ControllerCheckoutSuccess extends Controller { 

				private $_googleanalytics_code = '';

				public function __construct($registry)
				{
					parent::__construct($registry);
		
					// Set the UA-XXXXXXXX-X id.
					$profile_id = html_entity_decode(trim($this->config->get('config_google_analytics')), ENT_QUOTES, 'UTF-8');

					// Write header code.
					$tracking_code = "<script type='text/javascript'>\n" .
					  		    	 "var _gaq = _gaq || [];\n" .
					  		    	 "_gaq.push(['_setAccount', '$profile_id']);\n" .
					  		    	 "_gaq.push(['_trackPageview']);\n";

					// Check for order_id ie Ecommerce code.
					if (isset($this->session->data['order_id'])) {
						$ecommerce_data = array();

						$ecommerce_data['products'] = $this->cart->getProducts();

						$this->load->model('catalog/category');
						$this->load->model('account/order');
						$this->load->model('catalog/product');
		
						$order = $this->model_account_order->get_order_details($this->session->data['order_id']);
			
						// Set the shipping cost.
						$order['shipping'] = isset($this->session->data['shipping_method']['cost']) ? $this->session->data['shipping_method']['cost'] : 0;
		
						$ecommerce_code = "_gaq.push(['_addTrans'," .
										  "'" . $this->session->data['order_id'] . "'," .
										  "'" . HTTP_SERVER . "'," .
										  "'" . $order['total'] . "'," .
						  				  "'" . $order['tax'] . "'," .
										  "'" . $order['shipping'] . "'," .
										  "'" . $order['payment_city'] . "'," .
										  "'" . $order['payment_zone'] . "'," .
										  "'" . $order['payment_country'] . "'" .
										  "]);\n";
			
						// Build the javascript snippet for each item in the order.
						foreach ($ecommerce_data['products'] as $product) {
							// Get the products parent category name, set to uncateforzed if not found.
							$category = $this->model_catalog_category->get_category_name($product['product_id']);
			
							// Lookup the order details for the product.
							$product_details = $this->model_catalog_product->get_product_details($this->session->data['order_id'], $product['product_id']);
				
							$ecommerce_code .= "_gaq.push(['_addItem'," .
											   "'" . $this->session->data['order_id'] . "'," .
											   "'" . $product_details['model'] . "'," .
											   "'" . $product_details['name'] . "'," .
											   "'" . $category . "'," .
											   "'" . $product_details['price'] . "'," .
											   "'" . $product_details['quantity'] . "'" .
											   "]);\n";
						}
			
						$ecommerce_code .= "_gaq.push(['_trackTrans']);\n";
			
						// Concat the ecommerce snippet onto the existing javascript snippet.
						$tracking_code .= $ecommerce_code;
					}

					// Write footer code.
					$tracking_code .= "(function() {\n" .
			  		 		     	  "var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;\n" .
			  		 		     	  "ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';\n" .
			  		 		     	  "var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);\n" .
			  		 		     	  "})();\n" .
			  		 		     	  "</script>";

			  		$this->_googleanalytics_code = $tracking_code;
				}
			
	public function index() { 	
		if (isset($this->session->data['order_id'])) {
			$this->cart->clear();

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
    		$this->data['text_message'] = sprintf($this->language->get('text_customer'), $this->url->link('account/account', '', 'SSL'), $this->url->link('account/order', '', 'SSL'), $this->url->link('account/download', '', 'SSL'), $this->url->link('information/contact'));
		} else {
    		$this->data['text_message'] = sprintf($this->language->get('text_guest'), $this->url->link('information/contact'));
		}
		
    	$this->data['button_continue'] = $this->language->get('button_continue');

    	$this->data['continue'] = $this->url->link('common/home');
$this->data['googleanalytics_code'] = $this->_googleanalytics_code;

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/success.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/common/success.tpl';
		} else {
			$this->template = 'default/template/common/success.tpl';
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
}
?>