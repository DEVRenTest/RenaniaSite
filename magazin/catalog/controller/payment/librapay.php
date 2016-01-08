<?php

class ControllerPaymentLibrapay extends Controller {
	protected function index() {
		$this->language->load('payment/librapay');
		
		$this->data['text_testmode'] = $this->language->get('text_testmode');		
    	
		$this->data['button_confirm'] = $this->language->get('button_confirm');

		$this->data['testmode'] = $this->config->get('librapay_test');
		
		if (!$this->config->get('librapay_test')) {
    		$this->data['action'] = 'https://secure.librapay.ro/pay_auth.php';
  		} else {
			$this->data['action'] = 'http://tcom.librapay.ro/pay_auth.php';
		}

		$this->load->model('checkout/order');

		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
		$order_id=$this->session->data['order_id'];

		
        if ($order_info) {				
          
			$ProductsData = array();			
			foreach ($this->cart->getProducts() as $product) {	
				$ProductsData[] = array(
					'ItemName'  => $product['name'],
					'ItemDesc'  => $product['model'],
					'Quantity'  => $product['quantity'],
					'Price'     => $this->currency->format($product['price'], $order_info['currency_code'], false, false),
					'ProductId' => $product['product_id']
				);
			}	
			
			
           $total_disc=0;
		   $types=array('coupon','voucher');
		   foreach($types as $type)
		   {   
				$query = $this->db->query("SELECT title,code,value FROM `" . DB_PREFIX . "order_total` WHERE `order_id` = '" .(int)$order_id."' AND `code` = '".$type."'");
				if($query)
				{				
				if(array_key_exists('title',$query->row)){				
				$titlu=$query->row['title'];				
				$cost=$query->row['value'];
				$cod=$query->row['code'];
	            $ProductsData[] = array(
					'ItemName'  => $titlu,
					'ItemDesc'  => 'Discount',
					'Quantity'  => '1',
					'Price'     => $cost,
					'ProductId' => '1'
							);
							$total_disc+=$cost;
				}
				}
            }
		    if(array_key_exists('shipping_method',$this->session->data)) {
				    $ship=$this->session->data['shipping_method']['cost'];	         
			 $ProductsData[]=array (
			'ItemName' => 'Livrare produse',
			'ItemDesc' => 'Costul livrarii',
			'Quantity' => '1',
			'Price'    => $ship);
			}
			else { 
			$ship=0; 			
			}
			
			
			$tax = $this->currency->format($order_info['total'] - $this->cart->getSubTotal()- $ship-$total_disc, $order_info['currency_code'], false, false);		
	    
		  
            if ($tax > 0) {
                $ProductsData[] = array(
					'ItemName'  => 'T.V.A.',
					'ItemDesc'  => '',
					'Quantity'  => 1,
					'Price'     => $tax,
					'ProductId' => 0
				);
			}      
       
            $UserData = array(                
                "LoginName" 	=> $order_info['lastname'].' '.$order_info['firstname'],
                "Email"     	=> $order_info['email'],
                "Name"	    	=> $order_info['lastname'].' '.$order_info['firstname'],
                "Cnp"			=> "",
                "Phone"			=> $order_info['telephone'],
           
                "ShippingName"			=> $order_info['shipping_lastname'].' '.$order_info['shipping_firstname'],
                "ShippingID"			=> '',
                "ShippingIDNumber"		=> '',
                "ShippingIssuedBy"		=> '',
                "ShippingEmail"			=> "",
                "ShippingPhone"			=> $order_info['telephone'],
                "ShippingAddress"		=> $order_info['shipping_address_1'].' '.$order_info['shipping_address_2'],
                "ShippingCity"			=> $order_info['shipping_city'],
                "ShippingPostalCode"	=> $order_info['shipping_postcode'],
                "ShippingDistrict"		=> $order_info['shipping_zone'],
                "ShippingCountry"		=> $order_info['shipping_country'],

                "BillingName"		=> $order_info['payment_lastname'].' '.$order_info['payment_firstname'],
                "BillingID"			=> "",
                "BillingIDNumber"	=> "",
                "BillingIssuedBy"	=> "",
                "BillingEmail"		=> "",
                "BillingPhone"		=> $order_info['telephone'],
                "BillingAddress"	=> $order_info['payment_address_1'].' '.$order_info['payment_address_2'],
                "BillingCity"		=> $order_info['payment_city'],
                "BillingPostalCode"	=> $order_info['payment_postcode'],
                "BillingDistrict"	=> $order_info['payment_zone'],
                "BillingCountry"	=> $order_info['payment_country']
            );
			
			if (!$this->config->get('librapay_transaction')) {
				$this->data['paymentaction'] = 'authorization';
			} else {
				$this->data['paymentaction'] = 'sale';
			}
			
			$this->data['custom'] = $this->encryption->encrypt($this->session->data['order_id']);
		
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/librapay.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/payment/librapay.tpl';
			} else {
				$this->template = 'default/template/payment/librapay.tpl';
			}
            
			 $order_prefix=2000000;
			
            $data_custom = array();
            $data_custom["ProductsData"] = $ProductsData;
            $data_custom["UserData"] 	 = $UserData;
                        
            $this->data['amount']       = sprintf('%.2f', $order_info['total'] * $order_info['currency_value'] );
            $this->data['currency']     = $order_info['currency_code'];
            $this->data['order']        = $order_info['order_id'] + $order_prefix;
            $this->data['desc']         = 'Comanda Nr.' . $order_info['order_id'];
            $this->data['terminal']     = $this->config->get('librapay_terminal');
            $this->data['timestamp']    = $order_info['total'];
            $this->data['nonce']        = md5("librabank_".rand(99999,9999999));
            $this->data['backhref']     = $this->url->link('payment/librapay/callback');
            $this->data['timestamp']    = gmdate("YmdHis");
            $this->data['data_custom']  = base64_encode(serialize($data_custom));
            $this->data['trtype']       = 0;
            $this->data['country']      = '-';
            $this->data['merch_gmt']    = '-';
         
		 $str_p_sign = 
                    strlen($this->data['amount']) . $this->data['amount'] .
					strlen($this->data['currency']) . $this->data['currency'] . 
                    strlen($this->data['order']) . $this->data['order'] .
					strlen($this->data['desc']) . $this->data['desc'] . 
                    strlen($this->config->get('librapay_merchant_name')) . $this->config->get('librapay_merchant_name') .
                    strlen($this->config->get('librapay_merchant_url')) . $this->config->get('librapay_merchant_url') .
                    strlen($this->config->get('librapay_merchant')) . $this->config->get('librapay_merchant') .
                    strlen($this->config->get('librapay_terminal')) . $this->config->get('librapay_terminal') .
                    strlen($this->config->get('librapay_email')) . $this->config->get('librapay_email') .
					strlen($this->data['trtype']) . $this->data['trtype'] . 
					$this->data['country'] . $this->data['merch_gmt'] . 
                    strlen($this->data['timestamp']) . $this->data['timestamp'] .
					strlen($this->data['nonce']) . $this->data['nonce'] . 
                    strlen($this->data['backhref']) . $this->data['backhref'];
            $p_sign = strtoupper(hash_hmac('sha1', $str_p_sign, pack('H*',$this->config->get('librapay_key'))));            
            $this->data['p_sign']       = $p_sign;
            $this->data['str_p_sign']       = $str_p_sign;
            
			$this->render();
		}
	}
	
	public function callback() {		
		$this->language->load('payment/librapay');
		$this->data['title'] = sprintf($this->language->get('heading_title'), $this->config->get('config_name'));
		if (!isset($this->request->server['HTTPS']) || ($this->request->server['HTTPS'] != 'on')) {
			$this->data['base'] = HTTP_SERVER;
		} else {
			$this->data['base'] = HTTPS_SERVER;
		}
		$this->data['language'] = $this->language->get('code');
		$this->data['direction'] = $this->language->get('direction');
		$this->data['heading_title'] = sprintf($this->language->get('heading_title'), $this->config->get('config_name'));
		$this->data['text_response'] = $this->language->get('text_response');
		$this->data['text_failure'] = $this->language->get('text_failure');
		$this->data['text_failure_wait'] = sprintf($this->language->get('text_failure_wait'), $this->url->link('checkout/cart'));
		$this->data['text_success'] = $this->language->get('text_success');
		$this->data['text_success_wait'] = sprintf($this->language->get('text_success_wait'), $this->url->link('checkout/cart'));
		$order_prefix=2000000;		
		$data = $_POST;		
		if(trim($data["APPROVAL"]) == '') {
			$txt_approval = "-";
		} else {
			$txt_approval = strlen($data["APPROVAL"]).$data["APPROVAL"];
		}
		if(trim($data["RRN"]) == '') {
			$txt_rrn = "-";
		} else {
			$txt_rrn = strlen($data["RRN"]).$data["RRN"];
		}
		if(trim($data["INT_REF"]) == '') {
			$txt_int_ref = "-";
		} else {
			$txt_int_ref = strlen($data["INT_REF"]).$data["INT_REF"];
		}
		$str_p_sign = strlen($data["TERMINAL"]).$data["TERMINAL"] .
		strlen($data["TRTYPE"]).$data["TRTYPE"] . strlen($data["ORDER"]).$data["ORDER"] .
		strlen($data["AMOUNT"]).$data["AMOUNT"] .strlen($data["CURRENCY"]).$data["CURRENCY"] .
		strlen($data["DESC"]).$data["DESC"] .strlen($data["ACTION"]).$data["ACTION"] .
		strlen($data["RC"]).$data["RC"] .strlen($data["MESSAGE"]).$data["MESSAGE"] .
		$txt_rrn .$txt_int_ref .
		$txt_approval .
		strlen($data["TIMESTAMP"]).$data["TIMESTAMP"] .
		strlen($data["NONCE"]).$data["NONCE"]; 		
        $p_sign = strtoupper(hash_hmac('sha1', $str_p_sign, pack('H*',$this->config->get('librapay_key'))));            
        if($p_sign == $data["P_SIGN"]) {
			$order_id = $data["ORDER"]-$order_prefix;
			if ($data["RC"] == "00") {
				$this->load->model('checkout/order');			
				$this->model_checkout_order->confirm($order_id, $this->config->get('config_order_status_id'));
				$message = "Comanda ".$order_id." a fost procesata cu succes!";		
				$this->model_checkout_order->update($order_id, 15, $message, false); // processed
				$this->data['continue'] = $this->url->link('checkout/success');
				
				$this->template = $this->config->get('config_template') . '/template/payment/librapay_success.tpl';
				$this->children = array(
					'common/column_left',
					'common/column_right',
					'common/content_top',
					'common/content_bottom',
					'common/footer',
					'common/header'
				);
				$this->response->setOutput($this->render());
			} else {
				$this->data['continue'] = $this->url->link('checkout/cart');
				$this->template = $this->config->get('config_template') . '/template/payment/librapay_failure.tpl';
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
        } else {
        	die("mesaj incorect...");
        }
	}
}
?>