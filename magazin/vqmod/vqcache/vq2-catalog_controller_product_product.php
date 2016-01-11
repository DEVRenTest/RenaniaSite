<?php  
class ControllerProductProduct extends Controller {
	private $error = array(); 
	
	public function index() { 
      
		$this->language->load('product/product');
	
		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),			
			'separator' => false
		);
		
		$this->load->model('catalog/category');	
		
		if (isset($this->request->get['path'])) {
			$path = '';
			
			$parts = explode('_', (string)$this->request->get['path']);
			
			$category_id = (int)array_pop($parts);
				
			foreach ($parts as $path_id) {
				if (!$path) {
					$path = $path_id;
				} else {
					$path .= '_' . $path_id;
				}
				
				$category_info = $this->model_catalog_category->getCategory($path_id);
				
				if ($category_info) {
					$this->data['breadcrumbs'][] = array(
						'text'      => $category_info['name'],
						'href'      => $this->url->link('product/category', 'path=' . $path),
						'separator' => $this->language->get('text_separator')
					);
				}
			}
			
			// Set the last category breadcrumb
			$category_info = $this->model_catalog_category->getCategory($category_id);
				
			if ($category_info) {			
				$url = '';
				
				if (isset($this->request->get['sort'])) {
					$url .= '&sort=' . $this->request->get['sort'];
				}	
	
				if (isset($this->request->get['order'])) {
					$url .= '&order=' . $this->request->get['order'];
				}	
				
				if (isset($this->request->get['page'])) {
					$url .= '&page=' . $this->request->get['page'];
				}
				
				if (isset($this->request->get['limit'])) {
					$url .= '&limit=' . $this->request->get['limit'];
				}
										
				$this->data['breadcrumbs'][] = array(
					'text'      => $category_info['name'],
					'href'      => $this->url->link('product/category', 'path=' . $this->request->get['path']),
					'separator' => $this->language->get('text_separator')
				);
			}
		}
		
		$this->load->model('catalog/manufacturer');	
		
		if (isset($this->request->get['manufacturer_id'])) {
			$this->data['breadcrumbs'][] = array( 
				'text'      => $this->language->get('text_brand'),
				'href'      => $this->url->link('product/manufacturer'),
				'separator' => $this->language->get('text_separator')
			);	
	
			$url = '';
			
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}	

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}	
			
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
						
			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}
							
			$manufacturer_info = $this->model_catalog_manufacturer->getManufacturer($this->request->get['manufacturer_id']);

			if ($manufacturer_info) {	
				$this->data['breadcrumbs'][] = array(
					'text'	    => $manufacturer_info['name'],
					'href'	    => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . $url),					
					'separator' => $this->language->get('text_separator')
				);
			}
		}
		
		if (isset($this->request->get['search']) || isset($this->request->get['tag'])) {
			$url = '';
			
			if (isset($this->request->get['search'])) {
				$url .= '&search=' . $this->request->get['search'];
			}
						
			if (isset($this->request->get['tag'])) {
				$url .= '&tag=' . $this->request->get['tag'];
			}
						
			if (isset($this->request->get['description'])) {
				$url .= '&description=' . $this->request->get['description'];
			}
			
			if (isset($this->request->get['category_id'])) {
				$url .= '&category_id=' . $this->request->get['category_id'];
			}	

			if (isset($this->request->get['sub_category'])) {
				$url .= '&sub_category=' . $this->request->get['sub_category'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}	

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
						
			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}
												
			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_search'),
				'href'      => $this->url->link('product/search', $url),
				'separator' => $this->language->get('text_separator')
			); 	
		}
		
		if (isset($this->request->get['product_id'])) {
			$product_id = (int)$this->request->get['product_id'];
		} else {
			$product_id = 0;
		}
    		
		$this->load->model('catalog/product');


                $this->load->model('journal2/product');

            


                $this->load->model('journal2/product');

            
		
	 	$product_info = $this->model_catalog_product->getProduct($product_id);

		if ($product_info) {
			$url = '';
			
			if (isset($this->request->get['path'])) {
				$url .= '&path=' . $this->request->get['path'];
			}
						
			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}
						
			if (isset($this->request->get['manufacturer_id'])) {
				$url .= '&manufacturer_id=' . $this->request->get['manufacturer_id'];
			}			

			if (isset($this->request->get['search'])) {
				$url .= '&search=' . $this->request->get['search'];
			}
						
			if (isset($this->request->get['tag'])) {
				$url .= '&tag=' . $this->request->get['tag'];
			}
			
			if (isset($this->request->get['description'])) {
				$url .= '&description=' . $this->request->get['description'];
			}	
						
			if (isset($this->request->get['category_id'])) {
				$url .= '&category_id=' . $this->request->get['category_id'];
			}
			
			if (isset($this->request->get['sub_category'])) {
				$url .= '&sub_category=' . $this->request->get['sub_category'];
			}	
			
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}	

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}	
			
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
						
			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}
																		
			$this->data['breadcrumbs'][] = array(
				'text'      => $product_info['name'],
				'href'      => $this->url->link('product/product', $url . '&product_id=' . $this->request->get['product_id']),
				'separator' => $this->language->get('text_separator')
			);			
			
			($product_info['custom_title'] == '')?$this->document->setTitle(((isset($category_info['name']))?($category_info['name'].' : '):'').$product_info['name']):$this->document->setTitle($product_info['custom_title']);
			$this->document->setDescription($product_info['meta_description']);
			$this->document->setKeywords($product_info['meta_keyword']);
			$this->document->addLink($this->url->link('product/product', 'product_id=' . $this->request->get['product_id']), 'canonical');
			$this->document->addScript('catalog/view/javascript/jquery/tabs.js');
			$this->document->addScript('catalog/view/javascript/jquery/colorbox/jquery.colorbox-min.js');
			$this->document->addStyle('catalog/view/javascript/jquery/colorbox/colorbox.css');
			
			$this->data['heading_title'] = $product_info['name'];
			
			$this->data['text_select'] = $this->language->get('text_select');
			$this->data['text_manufacturer'] = $this->language->get('text_manufacturer');
			$this->data['text_model'] = $this->language->get('text_model');
			$this->data['text_reward'] = $this->language->get('text_reward');
			$this->data['text_points'] = $this->language->get('text_points');	
			$this->data['text_discount'] = $this->language->get('text_discount');
			$this->data['text_stock'] = $this->language->get('text_stock');
			$this->data['text_qty'] = $this->language->get('text_qty');
			$this->data['text_price'] = $this->language->get('text_price');
			$this->data['text_tax'] = $this->language->get('text_tax');
			$this->data['text_discount'] = $this->language->get('text_discount');
			$this->data['text_option'] = $this->language->get('text_option');
			$this->data['text_minimum'] = sprintf($this->language->get('text_minimum'), $product_info['minimum']);
			$this->data['text_or'] = $this->language->get('text_or');
			$this->data['text_write'] = $this->language->get('text_write');
			$this->data['text_note'] = $this->language->get('text_note');
			$this->data['text_share'] = $this->language->get('text_share');
			$this->data['text_wait'] = $this->language->get('text_wait');
			$this->data['text_tags'] = $this->language->get('text_tags');
            $this->data['text_no_stock'] = $this->language->get('text_no_stock');
      
            $this->data['text_free_delivery'] = $this->language->get('text_free_delivery');
            $this->data['text_return_guarantee'] = $this->language->get('text_return_guarantee');
            $this->data['text_delivery'] = $this->language->get('text_delivery');
            $this->data['text_see_corresponding_size'] = $this->language->get('text_see_corresponding_size');
      
      //balazs
			$this->data['text_withouth_vat'] = $this->language->get('text_withouth_vat');
      $this->data['text_price_ask'] = $this->language->get('text_price_ask');
			
			$this->data['entry_name'] = $this->language->get('entry_name');
			$this->data['entry_review'] = $this->language->get('entry_review');
			$this->data['entry_rating'] = $this->language->get('entry_rating');
			$this->data['entry_good'] = $this->language->get('entry_good');
			$this->data['entry_bad'] = $this->language->get('entry_bad');
			$this->data['entry_captcha'] = $this->language->get('entry_captcha');

			
			$this->data['download_description'] = $this->language->get('download_description');
			
			
			
			$this->data['button_cart'] = $this->language->get('button_cart');
			$this->data['button_view_product'] = $this->language->get('button_view_product');
			$this->data['button_get_info'] = $this->language->get('button_get_info');
			$this->data['button_wishlist'] = $this->language->get('button_wishlist');
			$this->data['button_compare'] = $this->language->get('button_compare');			
			$this->data['button_upload'] = $this->language->get('button_upload');
			$this->data['button_continue'] = $this->language->get('button_continue');
      
			$this->data['error_cart_content'] = $this->language->get('error_cart_content');
			
			$this->load->model('catalog/review');

			$this->data['tab_description'] = $this->language->get('tab_description');
			$this->data['tab_attribute'] = $this->language->get('tab_attribute');
			$this->data['tab_review'] = sprintf($this->language->get('tab_review'), $product_info['reviews']);
			$this->data['tab_related'] = $this->language->get('tab_related');
			$this->data['tab_complementary'] = $this->language->get('tab_complementary');
			
			$this->data['product_id'] = $this->request->get['product_id'];
			$this->data['manufacturer'] = $product_info['manufacturer'];

			if ($this->config->get('config_template') === 'journal2') {
			    $this->load->model('catalog/manufacturer');
                $manufacturer_info = $this->model_catalog_manufacturer->getManufacturer($product_info['manufacturer_id']);
                if ($manufacturer_info && $manufacturer_info['image'] && $this->journal2->settings->get('manufacturer_image', '0') == '1') {
                    $this->journal2->settings->set('manufacturer_image', 'on');
                    $this->data['manufacturer_image_width'] = $this->journal2->settings->get('manufacturer_image_width', 100);
                    $this->data['manufacturer_image_height'] = $this->journal2->settings->get('manufacturer_image_height', 100);
                    $this->data['manufacturer_image'] = $this->model_tool_image->resize($manufacturer_info['image'], $this->data['manufacturer_image_width'], $this->data['manufacturer_image_height']);
                    switch ($this->journal2->settings->get('manufacturer_image_additional_text', 'none')) {
                        case 'brand':
                            $this->data['manufacturer_image_name'] = $product_info['manufacturer'];
                            break;
                        case 'custom':
                            $this->data['manufacturer_image_name'] = $this->journal2->settings->get('manufacturer_image_custom_text');
                            break;
                    }
                }
			}
            
			$this->data['manufacturers'] = $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $product_info['manufacturer_id']);
			$this->data['model'] = $product_info['model'];
			$this->data['reward'] = $product_info['reward'];
			$this->data['points'] = $product_info['points'];

			
				$this->data['mbreadcrumbs'] = array();

				$this->data['mbreadcrumbs'][] = array(
					'text'      => $this->language->get('text_home'),
					'href'      => $this->url->link('common/home')
				);
				
				if ($this->model_catalog_product->getFullPath($this->request->get['product_id'])) {
					
					$path = '';
			
					$parts = explode('_', (string)$this->model_catalog_product->getFullPath($this->request->get['product_id']));
					
					$category_id = (int)array_pop($parts);
											
					foreach ($parts as $path_id) {
						if (!$path) {
							$path = $path_id;
						} else {
							$path .= '_' . $path_id;
						}
						
						$category_info = $this->model_catalog_category->getCategory($path_id);
						
						if ($category_info) {
							$this->data['mbreadcrumbs'][] = array(
								'text'      => $category_info['name'],
								'href'      => $this->url->link('product/category', 'path=' . $path)								
							);
						}
					}
					
					$category_info = $this->model_catalog_category->getCategory($category_id);
					
					if ($category_info) {			
						$url = '';
											
						$this->data['mbreadcrumbs'][] = array(
							'text'      => $category_info['name'],
							'href'      => $this->url->link('product/category', 'path=' . $this->model_catalog_product->getFullPath($this->request->get['product_id']))						
						);
					}
			
				
				} else {
				$this->data['mbreadcrumb'] = false;
				}
				
				$this->data['review_no'] = $product_info['reviews'];		
				$this->data['quantity'] = $product_info['quantity'];						
			
			
			


                if (true && $product_info['quantity'] <= 0) {

                    $this->data['stock_status'] = 'outofstock';

                }

                if (true && $product_info['quantity'] > 0) {

                    $this->data['stock_status'] = 'instock';

                }

                $this->data['labels'] = $this->model_journal2_product->getLabels($product_info['product_id']);

            
			if ($product_info['quantity'] <= 0) {
				$this->data['stock'] = $product_info['stock_status'];
			} elseif ($this->config->get('config_stock_display')) {
				$this->data['stock'] = $product_info['quantity'];
			} else {
				$this->data['stock'] = $this->language->get('text_instock');
			}
      
      $this->data['quantity'] = $product_info['quantity'];
      // if the logged customer is B2B or Gallery + B2B
      $B2B = false;
      if( $this->customer->getCustomerGroupId() == 3 || $this->customer->getCustomerGroupId() == 4 )
      {
        $B2B = true;
      }
      $this->data['B2B'] = $B2B;
      
			$this->load->model('tool/image');

			if ($product_info['image']) {
$this->data['popup_fixed'] = $this->model_tool_image->resize($product_info['image'], $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height'));
				$this->data['popup'] = $this->model_tool_image->resize($product_info['image'], $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height'));
			} else {
				$this->data['popup'] = $this->model_tool_image->resize('no_image.jpg', $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height'));
			}
			
			if ($product_info['image']) {
$this->data['thumb_fixed'] = $this->model_tool_image->resize($product_info['image'], $this->config->get('config_image_additional_width'), $this->config->get('config_image_additional_height'));
				$this->data['thumb'] = $this->model_tool_image->resize($product_info['image'], $this->config->get('config_image_thumb_width'), $this->config->get('config_image_thumb_height'));
			} else {
				$this->data['thumb'] = $this->model_tool_image->resize('no_image.jpg', $this->config->get('config_image_thumb_width'), $this->config->get('config_image_thumb_height'));
			}
			
			$this->data['images'] = array();
			
			$results = $this->model_catalog_product->getProductImages($this->request->get['product_id']);
			
			foreach ($results as $result) {
				$this->data['images'][] = array(
					'popup' => $this->model_tool_image->resize($result['image'], $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height')),
					'thumb' => $this->model_tool_image->resize($result['image'], $this->config->get('config_image_additional_width'), $this->config->get('config_image_additional_height'))
				);
			}	
						
//			if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
//          
//        $this->language->load('module/cart');  
//        if( $product_info['price'] ==  'NO_B2B_PRICE' )  
//        {
//            $this->data['price'] = $this->language->get('text_no_price_specified_for_b2b');
//        }
//        else if( $product_info['price'] ==  'MORE_OPTION_NEEDED' )  
//        {
//            $this->data['price'] = $this->language->get('text_select_option_to_show_price');
//        }
//        else if( (float)$product_info['price'] == 0)
//        {
//            $this->data['price'] = $this->language->get('text_price_ask');
//        }
//        else 
//        {
//            $this->data['price'] = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')));
//        }
//        
//			} else {
//				$this->data['price'] = false;
//			}
						

			
			if($this->customer->isLogged()){$this->data['cust_reg']=true;}else{$this->data['cust_reg']=false;}
			
			
			if ((float)$product_info['special']) {

                if ($this->config->get('config_template') === 'journal2' && $this->journal2->settings->get('show_countdown_product_page', 'on') == 'on') {
                    $this->load->model('journal2/product');
                    $date_end = $this->model_journal2_product->getSpecialCountdown($this->request->get['product_id']);
                    if ($date_end === '0000-00-00') {
                        $date_end = false;
                    }
                    $this->data['date_end'] = $date_end;
                }
            
				$this->data['special'] = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')));
			} else {
				$this->data['special'] = false;
			}
			
			if ($this->config->get('config_tax')) {
				$this->data['tax'] = $this->currency->format((float)$product_info['special'] ? $product_info['special'] : $product_info['price']);
			} else {
				$this->data['tax'] = false;
			}

			
				//if($this->customer->isLogged()) {
					$product_description_doc = $this->model_catalog_product->getProductDescriptionDocument($this->request->get['product_id'], ($this->customer->getCustomerGroupId()) ? $this->customer->getCustomerGroupId() : 5);

					//echo "<pre>"; print_r($product_description_doc); die('opencart/vqmod/xml/product_description_pdf.xml:774');

					foreach($product_description_doc as $file_name)
					{
						$customer_id = (int)$this->session->data['customer_id'];
						$document_id = (int)$file_name['product_description_download_pdf_id'];

						$sec_id = $customer_id + 17;

						$this->data['product_doc'][]=array(
							'href'=>$this->url->link('product/product/download','&id='.$document_id.'&sec='.$sec_id),
							//'name'=>trim(substr($file_name,0,strrpos($file_name,'.')))
							'name'=>$file_name['document_name'],
							'type'=>$file_name['document_type'],
							'description'=>$file_name['document_description']
						);
					}
					//echo "<pre>"; print_r($this->data['product_doc']); die('opencart/vqmod/xml/product_description_pdf.xml:783');

				//}
			
			
			
			$discounts = $this->model_catalog_product->getProductDiscounts($this->request->get['product_id']);
			
			$this->data['discounts'] = array(); 
			
			foreach ($discounts as $discount) {
				$this->data['discounts'][] = array(
					'quantity' => $discount['quantity'],
					'price'    => $this->currency->format($this->tax->calculate($discount['price'], $product_info['tax_class_id'], $this->config->get('config_tax')))
				);
			}
			
			$this->data['options'] = array();
      
/*      print_r( $this->model_catalog_product->getProductOptions($this->request->get['product_id']) );
      die();*/
			
			foreach ($this->model_catalog_product->getProductOptions($this->request->get['product_id']) as $option) { 
				if ($option['type'] == 'select' || $option['type'] == 'radio' || $option['type'] == 'checkbox' || $option['type'] == 'image') { 
					$option_value_data = array();
					
					foreach ($option['option_value'] as $option_value) {
              
						if (!$option_value['subtract'] || ($option_value['quantity'] >= 0)) {
							if ((($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) && (float)$option_value['price']) {
								$price = $this->currency->format($this->tax->calculate($option_value['price'], $product_info['tax_class_id'], TRUE/* $this->config->get('config_tax') */));
							} else {
								$price = false;
							}
							
							$option_value_data[] = array(
								'product_option_value_id' => $option_value['product_option_value_id'],
								'option_value_id'         => $option_value['option_value_id'],
								'name'                    => $option_value['name'],
								'image'                   => strpos($this->config->get('config_template'), 'journal2') === 0 ? Journal2Utils::resizeImage($this->model_tool_image, $option_value['image'], $this->journal2->settings->get('product_page_options_push_image_width', 30), $this->journal2->settings->get('product_page_options_push_image_height', 30), 'crop') : $this->model_tool_image->resize($option_value['image'], 50, 50),
								'price'                   => $price,
								'price_prefix'            => $option_value['price_prefix']
							);
						}
					}
					
					$this->data['options'][] = array(
						'product_option_id' => $option['product_option_id'],
						'option_id'         => $option['option_id'],
						'name'              => $option['name'],
						'type'              => $option['type'],
						'option_value'      => $option_value_data,
						'required'          => $option['required']
					);					
				} elseif ($option['type'] == 'text' || $option['type'] == 'textarea' || $option['type'] == 'file' || $option['type'] == 'date' || $option['type'] == 'datetime' || $option['type'] == 'time') {
					$this->data['options'][] = array(
						'product_option_id' => $option['product_option_id'],
						'option_id'         => $option['option_id'],
						'name'              => $option['name'],
						'type'              => $option['type'],
						'option_value'      => $option['option_value'],
						'required'          => $option['required']
					);						
				}
			}
            
      if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
          
        $this->language->load('module/cart');  
        if( $product_info['price'] ==  'MORE_OPTION_NEEDED' && sizeof( $this->data['options'] ) == 0 )  
        {
            $this->data['price'] = $this->language->get('text_no_price_specified_for_b2b');
        }
        else if( $product_info['price'] ==  'MORE_OPTION_NEEDED' && sizeof( $this->data['options'] ) > 0)  
        {
            $this->data['price'] = $this->language->get('text_select_option_to_show_price');
        }
        else if( (float)$product_info['price'] == 0)
        {
            $this->data['price'] = $this->language->get('text_price_ask');
        }
        else 
        {
            $this->data['price'] = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')));
        }
        
			} else {
				$this->data['price'] = false;
			}
							
$this->data['error_option_combo'] = $this->language->get('error_option_combo');

			    $option_combo_setting = $this->model_catalog_product->getProductOptionComboSetting($this->request->get['product_id']);



                if(isset($option_combo_setting['status']) && $option_combo_setting['status'])

                {

                    $this->data['text_col_quantity'] = $this->language->get('text_col_quantity');

                    $this->data['text_col_points'] = $this->language->get('text_col_points');

                    $this->data['text_col_total_points'] = $this->language->get('text_col_total_points');

                    $this->data['text_col_price'] = $this->language->get('text_col_price');

                    $this->data['text_col_total_price'] = $this->language->get('text_col_total_price');



    			    $this->data['option_combo_table_view'] = $option_combo_setting['table_view'];

    			    $this->data['option_combo_option_view'] = $option_combo_setting['option_view'];

    			    $this->data['option_combo_description_view'] = $option_combo_setting['description_view'];

                    $this->data['option_combo_col_select_view'] = $option_combo_setting['col_select_view'];

                    $this->data['option_combo_col_quantity_view'] = $option_combo_setting['col_quantity_view'];

                    $this->data['option_combo_col_price_view'] = $option_combo_setting['col_price_view'];

                    $this->data['option_combo_col_total_price_view'] = $option_combo_setting['col_total_price_view'];

                    $this->data['option_combo_extax_view'] = $option_combo_setting['extax_view'];

                    $this->data['option_combo_col_points_view'] = $option_combo_setting['col_points_view'];

                    $this->data['option_combo_col_total_points_view'] = $option_combo_setting['col_total_points_view'];

                    $this->data['option_combo_table_split'] = $option_combo_setting['table_split'];

                    $this->data['option_combo_quantity_box'] = $option_combo_setting['quantity_box'];

                    $this->data['option_combo_status'] = $option_combo_setting['status'];



                    if(!$option_combo_setting['price_view'])

                    {

                        $this->data['price'] = false;

                    }



                    if($option_combo_setting['description_view'])

                    {

                        $option_combo_description = $this->model_catalog_product->getProductOptionComboDescription($this->request->get['product_id']);

                        $this->data['option_combo_description'] = html_entity_decode($option_combo_description['description'], ENT_QUOTES, 'UTF-8');

                    }



    			    $product_option_combos = $this->model_catalog_product->getProductOptionCombos($this->request->get['product_id']);



                    $product_option_combo_headers = $this->model_catalog_product->getProductOptionComboHeaders($product_option_combos);



                    //table split

                    $table_split_option_combos = array();

                    $table_split_options = array();

                    if($option_combo_setting['table_split'])

                    {

                        foreach($product_option_combos as $key => $product_option_combo)

    			        {

                            foreach($product_option_combo['option_values'] as $option_id => $combo_option_value)

        			        {

                                if($option_id == $option_combo_setting['table_split'])

                                {

                                    $temp_keys = array_keys($combo_option_value);

                                    if($product_option_combos[$key]['price_prefix'] == '+')

                                    {

                                        $product_option_combo['price'] += $product_info['price'];

                                    } else if($product_option_combos[$key]['price_prefix'] == '-')

                                    {

                                        $product_option_combo['price'] = $product_info['price'] - $product_option_combo['price'];

                                    } else if($product_option_combos[$key]['price_prefix'] == '0')

                                    {

                                        $product_option_combo['price'] = $product_info['price'] + $product_option_combo['option_price_total'];

                                    }

                                    $product_option_combo['total_price'] = $product_option_combo['price'];

                                    if($product_option_combos[$key]['quantity'] > 0)

                                    {

                                        $product_option_combo['total_price'] = $product_option_combo['price'] * $product_option_combos[$key]['quantity'];

                                    }

                                    $product_option_combos[$key]['price'] = $this->currency->format($this->tax->calculate($product_option_combo['price'], $product_info['tax_class_id'], $this->config->get('config_tax')));

                                    $product_option_combos[$key]['total_price'] = $this->currency->format($this->tax->calculate($product_option_combo['total_price'], $product_info['tax_class_id'], $this->config->get('config_tax')));

                                    $product_option_combos[$key]['extax'] = $this->currency->format($product_option_combo['price']);

                                    $product_option_combos[$key]['total_extax'] = $this->currency->format($product_option_combo['total_price']);



                                    if($product_option_combos[$key]['points_prefix'] == '+')

                                    {

                                        $product_option_combo['points'] += $product_info['reward'];

                                    } else if($product_option_combos[$key]['points_prefix'] == '-')

                                    {

                                        $product_option_combo['points'] = $product_info['reward'] - $product_option_combo['points'];

                                    } else if($product_option_combos[$key]['points_prefix'] == '0')

                                    {

                                        $product_option_combo['points'] = $product_info['reward'];

                                    }

                                    $product_option_combo['total_points'] = $product_option_combo['points'];

                                    if($product_option_combos[$key]['quantity'] > 0)

                                    {

                                        $product_option_combo['total_points'] = $product_option_combo['points'] * $product_option_combos[$key]['quantity'];

                                    }

                                    $product_option_combos[$key]['points'] = $product_option_combo['points'];

                                    $product_option_combos[$key]['total_points'] = $product_option_combo['total_points'];

                                    $table_split_option_combos[$temp_keys[0]][] = $product_option_combos[$key];

                                    $table_split_options += $combo_option_value;

                                }

        			        }

    			        }

    			        $option_values = $this->model_catalog_product->getOptionValues($option_combo_setting['table_split']);

                        $table_split_option_combos_sorted = array();

                        $table_split_options_sorted = array();

                        foreach($option_values as $option_value)

                        {

                            if(isset($table_split_option_combos[$option_value['option_value_id']]) && isset($table_split_options[$option_value['option_value_id']]))

                            {

                                $table_split_option_combos_sorted[$option_value['option_value_id']] = $table_split_option_combos[$option_value['option_value_id']];

                                $table_split_options_sorted[$option_value['option_value_id']] = $table_split_options[$option_value['option_value_id']];

                            }

                        }



                        $this->data['table_split_option_combos'] = $table_split_option_combos_sorted;

                        $this->data['table_split_options'] = $table_split_options_sorted;

                    } else {

                        foreach($product_option_combos as $key => $product_option_combo)

        			    {

                            $this->data['product_option_combos'][$key] = $product_option_combo;

                            if($this->data['product_option_combos'][$key]['price_prefix'] == '+')

                            {

                                $product_option_combo['price'] += $product_info['price'];

                            } else if($this->data['product_option_combos'][$key]['price_prefix'] == '-')

                            {

                                $product_option_combo['price'] = $product_info['price'] - $product_option_combo['price'];

                            } else if($this->data['product_option_combos'][$key]['price_prefix'] == '0')

                            {

                                $product_option_combo['price'] = $product_info['price'] + $product_option_combo['option_price_total'];

                            }

                            $product_option_combo['total_price'] = $product_option_combo['price'];

                            if($product_option_combo['quantity'] > 0)

                            {

                                $product_option_combo['total_price'] = $product_option_combo['price'] * $product_option_combo['quantity'];

                            }

                            $this->data['product_option_combos'][$key]['price'] = $this->currency->format($this->tax->calculate($product_option_combo['price'], $product_info['tax_class_id'], $this->config->get('config_tax')));

                            $this->data['product_option_combos'][$key]['total_price'] = $this->currency->format($this->tax->calculate($product_option_combo['total_price'], $product_info['tax_class_id'], $this->config->get('config_tax')));

                            $this->data['product_option_combos'][$key]['extax'] = $this->currency->format($product_option_combo['price']);

                            $this->data['product_option_combos'][$key]['total_extax'] = $this->currency->format($product_option_combo['total_price']);



                            if($this->data['product_option_combos'][$key]['points_prefix'] == '+')

                            {

                                $product_option_combo['points'] += $product_info['reward'];

                            } else if($this->data['product_option_combos'][$key]['points_prefix'] == '-')

                            {

                                $product_option_combo['points'] = $product_info['reward'] - $product_option_combo['points'];

                            } else if($this->data['product_option_combos'][$key]['points_prefix'] == '0')

                            {

                                $product_option_combo['points'] = $product_info['reward'];

                            }

                            $product_option_combo['total_points'] = $product_option_combo['points'];

                            if($product_option_combo['quantity'] > 0)

                            {

                                $product_option_combo['total_points'] = $product_option_combo['points'] * $product_option_combo['quantity'];

                            }

                            $this->data['product_option_combos'][$key]['points'] = $product_option_combo['points'];

                            $this->data['product_option_combos'][$key]['total_points'] = $product_option_combo['total_points'];

                        }

                    }

                    $this->data['product_option_combo_headers'] = $product_option_combo_headers;

                }

            
			if ($product_info['minimum']) {
				$this->data['minimum'] = $product_info['minimum'];
			} else {
				$this->data['minimum'] = 1;
			}
			
			$this->data['review_status'] = $this->config->get('config_review_status');
			$this->data['reviews'] = sprintf($this->language->get('text_reviews'), (int)$product_info['reviews']);
			$this->data['rating'] = (int)$product_info['rating'];
			
			$this->data['description'] = '<h2 style="display:none;">'.$product_info['name'].'</h2>'.html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8');
			

				$autolinks = $this->config->get('autolinks'); 
				
				if (isset($autolinks) && (strpos($this->data['description'], 'iframe') == false) && (strpos($this->data['description'], 'object') == false)){
				$xdescription = mb_convert_encoding(html_entity_decode($this->data['description'], ENT_COMPAT, "UTF-8"), 'HTML-ENTITIES', "UTF-8"); 
				
				libxml_use_internal_errors(true);
				$dom = new DOMDocument; 			
				$dom->loadHTML('<div>'.$xdescription.'</div>');				
				libxml_use_internal_errors(false);

				
				$xpath = new DOMXPath($dom);
								
				foreach ($autolinks as $autolink)
				{	
					$keyword = $autolink['keyword'];
					$xlink = mb_convert_encoding(html_entity_decode($autolink['link'], ENT_COMPAT, "UTF-8"), 'HTML-ENTITIES', "UTF-8");
					$target = $autolink['target'];
					$tooltip = isset($autolink['tooltip']);
													
					$pTexts = $xpath->query(
						sprintf('///text()[contains(., "%s")]', $keyword)
					);
					
					foreach ($pTexts as $pText) {
						$this->parseText($pText, $keyword, $dom, $xlink, $target, $tooltip);
					}

									
				}
						
				$this->data['description'] = $dom->saveXML($dom->documentElement);
				
				}
				
			
			$this->data['attribute_groups'] = $this->model_catalog_product->getProductAttributes($this->request->get['product_id']);
			
			$this->data['products'] = array();
			
			$results = $this->model_catalog_product->getProductRelated($this->request->get['product_id']);
			
			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_related_width'), $this->config->get('config_image_related_height'));
				} else {
					$image = false;
				}
				
				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], TRUE/* $this->config->get('config_tax') */));
				} else {
					$price = false;
				}
						
				if ((float)$result['special']) {
					$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], TRUE/* $this->config->get('config_tax') */));
				} else {
					$special = false;
				}
				
				if ($this->config->get('config_review_status')) {
					$rating = (int)$result['rating'];
				} else {
					$rating = false;
				}
        
				// if the logged customer is B2B or Gallery + B2B
				//$B2B = false;
				if( $this->customer->getCustomerGroupId() == 3 || $this->customer->getCustomerGroupId() == 4 )
				{
					//$B2B = true;
					$this->data['button_view_product'] = $this->language->get('button_view_product');
				}
				//$this->data['B2B'] = $B2B;
        

                $date_end = false;
                if ($this->config->get('config_template') === 'journal2' && $special && $this->journal2->settings->get('show_countdown', 'never') !== 'never') {
                    $this->load->model('journal2/product');
                    $date_end = $this->model_journal2_product->getSpecialCountdown($result['product_id']);
                    if ($date_end === '0000-00-00') {
                        $date_end = false;
                    }
                }
            

                $additional_images = $this->model_catalog_product->getProductImages($result['product_id']);

                $image2 = false;

                if (count($additional_images) > 0) {
                    $image2 = $this->model_tool_image->resize($additional_images[0]['image'], $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
                }
            
				$this->data['products'][] = array(
					'product_id' => $result['product_id'],
					'thumb'   	 => $image,

                'thumb2'       => $image2,
            


                'labels'        => ($result['product_id']) ? $this->model_journal2_product->getLabels($result['product_id']) : "",

            
					'name'    	 => $result['name'],
					'price'   	 => ( $B2B ? '' : $price), //$price
					'special' 	 => $special,

                'date_end'       => $date_end,
            
					'rating'     => $rating,
					'reviews'    => sprintf($this->language->get('text_reviews'), (int)$result['reviews']),
					'href'    	 => $this->url->link('product/product', 'product_id=' . $result['product_id'])
				);
        
			}

			$this->data['products_complementary'] = array();
			$complementary_products = $this->model_catalog_product->getProductComplementary($this->request->get['product_id']);
			foreach ($complementary_products as $complementary_product) {
				if ($complementary_product['image']) {
					$image = $this->model_tool_image->resize($complementary_product['image'], $this->config->get('config_image_related_width'), $this->config->get('config_image_related_height'));
				} else {
					$image = false;
				}

				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($complementary_product['price'], $complementary_product['tax_class_id'], TRUE/* $this->config->get('config_tax') */));
				} else {
					$price = false;
				}

				if ((float)$complementary_product['special']) {
					$special = $this->currency->format($this->tax->calculate($complementary_product['special'], $complementary_product['tax_class_id'], TRUE/* $this->config->get('config_tax') */));
				} else {
					$special = false;
				}

				if ($this->config->get('config_review_status')) {
					$rating = (int)$complementary_product['rating'];
				} else {
					$rating = false;
				}

				// if the logged customer is B2B or Gallery + B2B
				//$B2B = false;
				if( $this->customer->getCustomerGroupId() == 3 || $this->customer->getCustomerGroupId() == 4 )
				{
					//$B2B = true;
					$this->data['button_view_product'] = $this->language->get('button_view_product');
				}
				//$this->data['B2B'] = $B2B;

				$this->data['products_complementary'][] = array(
					'product_id' => $complementary_product['product_id'],
					'thumb'   	 => $image,

                'thumb2'       => $image2,
            


                'labels'        => ($result['product_id']) ? $this->model_journal2_product->getLabels($result['product_id']) : "",

            
					'name'    	 => $complementary_product['name'],
					'price'   	 => ( $B2B ? '' : $price), //$price
					'special' 	 => $special,

                'date_end'       => $date_end,
            
					'rating'     => $rating,
					'reviews'    => sprintf($this->language->get('text_reviews'), (int)$complementary_product['reviews']),
					'href'    	 => $this->url->link('product/product', 'product_id=' . $complementary_product['product_id'])
				);

			}
			
			$this->data['tags'] = array();
			
			if ($product_info['tag']) {		
				$tags = explode(',', $product_info['tag']);
				
				foreach ($tags as $tag) {
					$this->data['tags'][] = array(
						'tag'  => trim($tag),
						'href' => $this->url->link('product/search', 'tag=' . trim($tag))
					);
				}
			}
            
            $this->data['text_payment_profile'] = $this->language->get('text_payment_profile');
            $this->data['profiles'] = $this->model_catalog_product->getProfiles($product_info['product_id']);
			
			$this->model_catalog_product->updateViewed($this->request->get['product_id']);

            $product_size_chart = $this->model_catalog_product->getProductSizeChart( $this->request->get['product_id'] );
            $this->data['product_size_chart'] = $product_size_chart;
			
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/product.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/product/product.tpl';
			} else {
				$this->template = 'default/template/product/product.tpl';
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
		} else {
			$url = '';
			
			if (isset($this->request->get['path'])) {
				$url .= '&path=' . $this->request->get['path'];
			}
						
			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}	
						
			if (isset($this->request->get['manufacturer_id'])) {
				$url .= '&manufacturer_id=' . $this->request->get['manufacturer_id'];
			}			

			if (isset($this->request->get['search'])) {
				$url .= '&search=' . $this->request->get['search'];
			}	
					
			if (isset($this->request->get['tag'])) {
				$url .= '&tag=' . $this->request->get['tag'];
			}
							
			if (isset($this->request->get['description'])) {
				$url .= '&description=' . $this->request->get['description'];
			}
					
			if (isset($this->request->get['category_id'])) {
				$url .= '&category_id=' . $this->request->get['category_id'];
			}
			
			if (isset($this->request->get['sub_category'])) {
				$url .= '&sub_category=' . $this->request->get['sub_category'];
			}	
			
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}	

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}	
			
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
						
			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}
														
      		$this->data['breadcrumbs'][] = array(
        		'text'      => $this->language->get('text_error'),
				'href'      => $this->url->link('product/product', $url . '&product_id=' . $product_id),
        		'separator' => $this->language->get('text_separator')
      		);			
		
      		$this->document->setTitle($this->language->get('text_error'));

      		$this->data['heading_title'] = $this->language->get('text_error');

      		$this->data['text_error'] = $this->language->get('text_error');

      		$this->data['button_continue'] = $this->language->get('button_continue');

      		$this->data['continue'] = $this->url->link('common/home');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/error/not_found.tpl';
			} else {
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
						
			$this->response->setOutput($this->render());
    	}
  	}
	
	public function review() {
    	$this->language->load('product/product');
		
		$this->load->model('catalog/review');

		$this->data['text_on'] = $this->language->get('text_on');
		$this->data['text_no_reviews'] = $this->language->get('text_no_reviews');

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}  
		
		$this->data['reviews'] = array();
		
		$review_total = $this->model_catalog_review->getTotalReviewsByProductId($this->request->get['product_id']);
			
		$results = $this->model_catalog_review->getReviewsByProductId($this->request->get['product_id'], ($page - 1) * 5, 5);
      		
		foreach ($results as $result) {
        	$this->data['reviews'][] = array(
        		'author'     => $result['author'],
				'text'       => $result['text'],
				'rating'     => (int)$result['rating'],
        		'reviews'    => sprintf($this->language->get('text_reviews'), (int)$review_total),
        		'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added']))
        	);
      	}			
			
		$pagination = new Pagination();
		$pagination->total = $review_total;
		$pagination->page = $page;
		$pagination->limit = 5; 
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('product/product/review', 'product_id=' . $this->request->get['product_id'] . '&page={page}');
			
		$this->data['pagination'] = $pagination->render();
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/review.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/product/review.tpl';
		} else {
			$this->template = 'default/template/product/review.tpl';
		}
		
		$this->response->setOutput($this->render());
	}
	
    public function getRecurringDescription() {
        $this->language->load('product/product');
        $this->load->model('catalog/product');


                $this->load->model('journal2/product');

            


                $this->load->model('journal2/product');

            
        
        if (isset($this->request->post['product_id'])) {
            $product_id = $this->request->post['product_id'];
        } else {
            $product_id = 0;
        }
        
        if (isset($this->request->post['profile_id'])) {
            $profile_id = $this->request->post['profile_id'];
        } else {
            $profile_id = 0;
        }
        
        if (isset($this->request->post['quantity'])) {
            $quantity = $this->request->post['quantity'];
        } else {
            $quantity = 1;
        }

        $product_info = $this->model_catalog_product->getProduct($product_id);
        $profile_info = $this->model_catalog_product->getProfile($product_id, $profile_id);
        
        $json = array();
        
        if ($product_info && $profile_info) {
            
            if (!$json) {
                $frequencies = array(
                    'day' => $this->language->get('text_day'),
                    'week' => $this->language->get('text_week'),
                    'semi_month' => $this->language->get('text_semi_month'),
                    'month' => $this->language->get('text_month'),
                    'year' => $this->language->get('text_year'),
                );
                
                if ($profile_info['trial_status'] == 1) {
                    $price = $this->currency->format($this->tax->calculate($profile_info['trial_price'] * $quantity, $product_info['tax_class_id'], $this->config->get('config_tax')));
                    $trial_text = sprintf($this->language->get('text_trial_description'), $price, $profile_info['trial_cycle'], $frequencies[$profile_info['trial_frequency']], $profile_info['trial_duration']) . ' ';
                } else {
                    $trial_text = '';
                }
                
                $price = $this->currency->format($this->tax->calculate($profile_info['price'] * $quantity, $product_info['tax_class_id'], $this->config->get('config_tax')));
                
                if ($profile_info['duration']) {
                    $text = $trial_text . sprintf($this->language->get('text_payment_description'), $price, $profile_info['cycle'], $frequencies[$profile_info['frequency']], $profile_info['duration']);
                } else {
                    $text = $trial_text . sprintf($this->language->get('text_payment_until_canceled_description'), $price, $profile_info['cycle'], $frequencies[$profile_info['frequency']], $profile_info['duration']);
                }
                
                $json['success'] = $text;
            }
        }
        
        $this->response->setOutput(json_encode($json));	
    }


			
		public function download() {

			$this->load->model('catalog/product');

			/*echo "<pre>";
			var_dump($_GET);
			die('bafbdsfvd');*/

			if (isset($this->request->get['sec'])) {
				$sec_id = (int)$this->request->get['sec'];
				$customer_id = (int)$this->session->data['customer_id'];

				$check = $sec_id - 17;

				/*var_dump($sec_id);
				var_dump($customer_id);
				var_dump($check);
				die('fbdsfbdfb');*/

				if ($check != $customer_id) {
					exit('Error:  Access denied!');
				}

			} else {
				exit('Error: Access denied!');
			}

			if (isset($this->request->get['id'])) {
				$document_id = $this->request->get['id'];
			} else {
				$document_id = 0;
			}

			//var_dump($document_id); die('fbdfbd');

			$document_info = $this->model_catalog_product->getDocumentToDownload($document_id, $this->customer->getCustomerGroupId());
			//echo "<pre>"; print_r($document_info); die('dfbadfbdf');
			if ($document_info) {
				$file = DIR_DOWNLOAD . $document_info['file_name'];
				$mask = basename(trim(substr($document_info['file_name'],0,strrpos($document_info['file_name'],'.'))));

				if (!headers_sent()) {
					if (file_exists($file)) {
						header('Content-Type: application/octet-stream');
						header('Content-Disposition: attachment; filename="' . ($mask ? $mask : basename($file)) . '"');
						header('Expires: 0');
						header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
						header('Pragma: public');
						header('Content-Length: ' . filesize($file));
						if (ob_get_level()) ob_end_clean();
						readfile($file, 'rb');
						exit;
					} else {
						exit('Error: Could not find file ' . $file . '!');
					}
				} else {
					exit('Error: Headers already sent out!');
				}
			} else {
				$this->redirect($this->url->link('account/download', '', 'SSL'));
			}
		}
			
			
    public function write() {
		$this->language->load('product/product');
		
		$this->load->model('catalog/review');
		
		$json = array();
		
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 25)) {
				$json['error'] = $this->language->get('error_name');
			}
			
			if ((utf8_strlen($this->request->post['text']) < 25) || (utf8_strlen($this->request->post['text']) > 1000)) {
				$json['error'] = $this->language->get('error_text');
			}
	
			if (empty($this->request->post['rating'])) {
				$json['error'] = $this->language->get('error_rating');
			}
	
			if (empty($this->session->data['captcha']) || ($this->session->data['captcha'] != $this->request->post['captcha'])) {
				$json['error'] = $this->language->get('error_captcha');
			}
				
			if (!isset($json['error'])) {
				$this->model_catalog_review->addReview($this->request->get['product_id'], $this->request->post);
				
				$json['success'] = $this->language->get('text_success');
			}
		}
		
		$this->response->setOutput(json_encode($json));
	}
	

			private function parseText($node, $keyword, $dom, $link, $target='', $tooltip = 0)
			{
				if (mb_strpos($node->nodeValue, $keyword) !== false)
					{
						$keywordOffset = mb_strpos($node->nodeValue, $keyword, 0, 'UTF-8');
						$newNode = $node->splitText($keywordOffset);
						$newNode->deleteData(0, mb_strlen($keyword, 'UTF-8'));
						$span = $dom->createElement('a', $keyword);
						if ($tooltip)
							{
								$span->setAttribute('href', '#');
								$span->setAttribute('style', 'text-decoration:none');
								$span->setAttribute('class', 'title');
								$span->setAttribute('title', $keyword.'|'.$link);
							}
							else
							{
								$span->setAttribute('href', $link);
								$span->setAttribute('target', $target);
								$span->setAttribute('style', 'text-decoration:none');
							}							
						
						$node->parentNode->insertBefore($span, $newNode);
						$this->parseText($newNode ,$keyword, $dom, $link, $target, $tooltip);
					}					
			}
			
			

			
	public function captcha() {
		$this->load->library('captcha');
		
		$captcha = new Captcha();
		
		$this->session->data['captcha'] = $captcha->getCode();
		
		$captcha->showImage();
	}
	
	public function upload() {
		$this->language->load('product/product');
		
		$json = array();
		
		if (!empty($this->request->files['file']['name'])) {
			$filename = basename(preg_replace('/[^a-zA-Z0-9\.\-\s+]/', '', html_entity_decode($this->request->files['file']['name'], ENT_QUOTES, 'UTF-8')));
			
			if ((utf8_strlen($filename) < 3) || (utf8_strlen($filename) > 64)) {
        		$json['error'] = $this->language->get('error_filename');
	  		}	  	

			// Allowed file extension types
			$allowed = array();
			
			$filetypes = explode("\n", $this->config->get('config_file_extension_allowed'));
			
			foreach ($filetypes as $filetype) {
				$allowed[] = trim($filetype);
			}
			
			if (!in_array(substr(strrchr($filename, '.'), 1), $allowed)) {
				$json['error'] = $this->language->get('error_filetype');
       		}	
			
			// Allowed file mime types		
		    $allowed = array();
			
			$filetypes = explode("\n", $this->config->get('config_file_mime_allowed'));
			
			foreach ($filetypes as $filetype) {
				$allowed[] = trim($filetype);
			}
							
			if (!in_array($this->request->files['file']['type'], $allowed)) {
				$json['error'] = $this->language->get('error_filetype');
			}
						
			if ($this->request->files['file']['error'] != UPLOAD_ERR_OK) {
				$json['error'] = $this->language->get('error_upload_' . $this->request->files['file']['error']);
			}
		} else {
			$json['error'] = $this->language->get('error_upload');
		}
		
		if (!$json && is_uploaded_file($this->request->files['file']['tmp_name']) && file_exists($this->request->files['file']['tmp_name'])) {
			$file = basename($filename) . '.' . md5(mt_rand());
			
			// Hide the uploaded file name so people can not link to it directly.
			$json['file'] = $this->encryption->encrypt($file);
			
			move_uploaded_file($this->request->files['file']['tmp_name'], DIR_DOWNLOAD . $file);
						
			$json['success'] = $this->language->get('text_upload');
		}	
		
		$this->response->setOutput(json_encode($json));		
	}
}
?>