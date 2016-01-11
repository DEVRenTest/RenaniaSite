<?php 
class ControllerCatalogProduct extends Controller {
	private $error = array(); 
     
  	public function index() {
		$this->language->load('catalog/product');
    	
		$this->document->setTitle($this->language->get('heading_title')); 
		
		$this->load->model('catalog/product');

			
			$this->model_catalog_product->create_table();
			
			
		
		$this->getList();
  	}
  
  	public function insert() {
    	$this->language->load('catalog/product');

    	$this->document->setTitle($this->language->get('heading_title')); 
		
		$this->load->model('catalog/product');

			
			$this->model_catalog_product->create_table();
			
			
		
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_product->addProduct($this->request->post);
	  		
			$this->session->data['success'] = $this->language->get('text_success');
	  
			$url = '';

                if (isset($this->request->get['show_category_column'])) {
                    $url .= '&show_category_column =' . $this->request->get['show_category_column'];
                }
                if (isset($this->request->get['show_manufacturer_column'])) {
                    $url .= '&show_manufacturer_column =' . $this->request->get['show_manufacturer_column'];
                }
                if (isset($this->request->get['show_upc_column'])) {
                    $url .= '&show_upc_column =' . $this->request->get['show_upc_column'];
                }
                
		if (isset($this->request->get['filter_category_id'])) {
			$url .= '&filter_category_id=' . $this->request->get['filter_category_id'];
		}
		if (isset($this->request->get['filter_manufacturer'])) {
			$url .= '&filter_manufacturer=' . $this->request->get['filter_manufacturer'];
		}
		if (isset($this->request->get['filter_upc'])) {
		    $url .= '&filter_upc=' . urlencode(html_entity_decode($this->request->get['filter_upc'], ENT_QUOTES, 'UTF-8'));
		}
            
			
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}
		
			if (isset($this->request->get['filter_model'])) {
				$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_price'])) {
				$url .= '&filter_price=' . $this->request->get['filter_price'];
			}
			
			if (isset($this->request->get['filter_quantity'])) {
				$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
			}
			
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
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
			
			$this->redirect($this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, 'SSL'));
    	}
	
    	$this->getForm();
  	}

  	public function update()
    {
        $this->language->load('catalog/product');

        $this->document->setTitle($this->language->get('heading_title'));
		
        $this->load->model('catalog/product');

			
			$this->model_catalog_product->create_table();
			
			
	
        if(($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm())
        {
			/*echo "<pre>";
			print_r($_POST);
			die('fdvfd');*/
            $this->model_catalog_product->editProduct($this->request->get['product_id'], $this->request->post);

			// update ax_code
			$this->load->model('catalog/product_ax_code');
			$this->model_catalog_product_ax_code->editProductAxCode( $this->request->post['product_ax_code'], $this->request->post['product_type'], $this->request->post['upc'], $this->request->post['product_description'][2]['name']);

            $this->openbay->productUpdateListen($this->request->get['product_id'], $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

                if (isset($this->request->get['show_category_column'])) {
                    $url .= '&show_category_column =' . $this->request->get['show_category_column'];
                }
                if (isset($this->request->get['show_manufacturer_column'])) {
                    $url .= '&show_manufacturer_column =' . $this->request->get['show_manufacturer_column'];
                }
                if (isset($this->request->get['show_upc_column'])) {
                    $url .= '&show_upc_column =' . $this->request->get['show_upc_column'];
                }
                
		if (isset($this->request->get['filter_category_id'])) {
			$url .= '&filter_category_id=' . $this->request->get['filter_category_id'];
		}
		if (isset($this->request->get['filter_manufacturer'])) {
			$url .= '&filter_manufacturer=' . $this->request->get['filter_manufacturer'];
		}
		if (isset($this->request->get['filter_upc'])) {
		    $url .= '&filter_upc=' . urlencode(html_entity_decode($this->request->get['filter_upc'], ENT_QUOTES, 'UTF-8'));
		}
            

            if (isset($this->request->get['filter_name'])) {
              $url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
            }

            if (isset($this->request->get['filter_model'])) {
              $url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
            }

            if (isset($this->request->get['filter_price'])) {
              $url .= '&filter_price=' . $this->request->get['filter_price'];
            }

            if (isset($this->request->get['filter_quantity'])) {
              $url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
            }	

            if (isset($this->request->get['filter_status'])) {
              $url .= '&filter_status=' . $this->request->get['filter_status'];
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

            $this->redirect($this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, 'SSL'));
      }

    	$this->getForm();
      
  }

  	public function delete() {
    	$this->language->load('catalog/product');

    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('catalog/product');

			
			$this->model_catalog_product->create_table();
			
			
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $product_id) {
				$this->model_catalog_product->deleteProduct($product_id);
                $this->openbay->deleteProduct($product_id);
	  		}

			$this->session->data['success'] = $this->language->get('text_success');
			
			$url = '';

                if (isset($this->request->get['show_category_column'])) {
                    $url .= '&show_category_column =' . $this->request->get['show_category_column'];
                }
                if (isset($this->request->get['show_manufacturer_column'])) {
                    $url .= '&show_manufacturer_column =' . $this->request->get['show_manufacturer_column'];
                }
                if (isset($this->request->get['show_upc_column'])) {
                    $url .= '&show_upc_column =' . $this->request->get['show_upc_column'];
                }
                
		if (isset($this->request->get['filter_category_id'])) {
			$url .= '&filter_category_id=' . $this->request->get['filter_category_id'];
		}
		if (isset($this->request->get['filter_manufacturer'])) {
			$url .= '&filter_manufacturer=' . $this->request->get['filter_manufacturer'];
		}
		if (isset($this->request->get['filter_upc'])) {
		    $url .= '&filter_upc=' . urlencode(html_entity_decode($this->request->get['filter_upc'], ENT_QUOTES, 'UTF-8'));
		}
            
			
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}
		
			if (isset($this->request->get['filter_model'])) {
				$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_price'])) {
				$url .= '&filter_price=' . $this->request->get['filter_price'];
			}
			
			if (isset($this->request->get['filter_quantity'])) {
				$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
			}	
		
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
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
			
			$this->redirect($this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

    	$this->getList();
  	}

  	public function copy() {
    	$this->language->load('catalog/product');

    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('catalog/product');

			
			$this->model_catalog_product->create_table();
			
			
		
		if (isset($this->request->post['selected']) && $this->validateCopy()) {
			foreach ($this->request->post['selected'] as $product_id) {
				$this->model_catalog_product->copyProduct($product_id);
	  		}

			$this->session->data['success'] = $this->language->get('text_success');
			
			$url = '';

                if (isset($this->request->get['show_category_column'])) {
                    $url .= '&show_category_column =' . $this->request->get['show_category_column'];
                }
                if (isset($this->request->get['show_manufacturer_column'])) {
                    $url .= '&show_manufacturer_column =' . $this->request->get['show_manufacturer_column'];
                }
                if (isset($this->request->get['show_upc_column'])) {
                    $url .= '&show_upc_column =' . $this->request->get['show_upc_column'];
                }
                
		if (isset($this->request->get['filter_category_id'])) {
			$url .= '&filter_category_id=' . $this->request->get['filter_category_id'];
		}
		if (isset($this->request->get['filter_manufacturer'])) {
			$url .= '&filter_manufacturer=' . $this->request->get['filter_manufacturer'];
		}
		if (isset($this->request->get['filter_upc'])) {
		    $url .= '&filter_upc=' . urlencode(html_entity_decode($this->request->get['filter_upc'], ENT_QUOTES, 'UTF-8'));
		}
            
			
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}
		  
			if (isset($this->request->get['filter_model'])) {
				$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_price'])) {
				$url .= '&filter_price=' . $this->request->get['filter_price'];
			}
			
			if (isset($this->request->get['filter_quantity'])) {
				$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
			}	
		
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
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
			
			$this->redirect($this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

    	$this->getList();
  	}
	
  	protected function getList() {				

                $this->load->model('catalog/manufacturer');
                $this->load->model('catalog/category');

//  category column
                if (isset($this->request->get['show_category_column'])) {
                    $show_category_column = $this->request->get['show_category_column'];
                } else {
                    $show_category_column = $this->config->get('config_column_category');
                }

                $this->data['show_category_column'] = $show_category_column;
                if (isset($this->request->get['filter_category_id'])) {
                    $filter_category_id = $this->request->get['filter_category_id'];
                } else {
                    $filter_category_id = null;
                }

// manufacturer column
                if (isset($this->request->get['show_manufacturer_column'])) {
                    $show_manufacturer_column = $this->request->get['show_manufacturer_column'];
                } else {
                    $show_manufacturer_column = $this->config->get('config_column_manufacturer');
                }

                $this->data['show_manufacturer_column'] = $show_manufacturer_column;
                if (isset($this->request->get['filter_manufacturer_id'])) {
                    $filter_manufacturer_id = $this->request->get['filter_manufacturer_id'];
                } else {
                    $filter_manufacturer_id = null;
                }

// upc column
                if (isset($this->request->get['show_upc_column'])) {
                    $show_upc_column = $this->request->get['show_upc_column'];
                } else {
                    $show_upc_column = $this->config->get('config_column_upc');
                }

                $this->data['show_upc_column'] = $show_upc_column;
                if (isset($this->request->get['filter_upc_id'])) {
                    $filter_upc_id = $this->request->get['filter_upc_id'];
                } else {
                    $filter_upc_id = null;
                }

                if (isset($this->request->get['filter_manufacturer'])) {
                    $filter_manufacturer = $this->request->get['filter_manufacturer'];
                } else {
                    $filter_manufacturer = null;
                }

		if (isset($this->request->get['filter_upc'])) {
			$filter_upc = $this->request->get['filter_upc'];
		} else {
			$filter_upc = null;
		}

                $url = '';
            
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = null;
		}

		if (isset($this->request->get['filter_model'])) {
			$filter_model = $this->request->get['filter_model'];
		} else {
			$filter_model = null;
		}
		
		if (isset($this->request->get['filter_price'])) {
			$filter_price = $this->request->get['filter_price'];
		} else {
			$filter_price = null;
		}

		if (isset($this->request->get['filter_quantity'])) {
			$filter_quantity = $this->request->get['filter_quantity'];
		} else {
			$filter_quantity = null;
		}

		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'pd.name';
		}
		
		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
						
		$url = '';

                if (isset($this->request->get['show_category_column'])) {
                    $url .= '&show_category_column =' . $this->request->get['show_category_column'];
                }
                if (isset($this->request->get['show_manufacturer_column'])) {
                    $url .= '&show_manufacturer_column =' . $this->request->get['show_manufacturer_column'];
                }
                if (isset($this->request->get['show_upc_column'])) {
                    $url .= '&show_upc_column =' . $this->request->get['show_upc_column'];
                }
                
		if (isset($this->request->get['filter_category_id'])) {
			$url .= '&filter_category_id=' . $this->request->get['filter_category_id'];
		}
		if (isset($this->request->get['filter_manufacturer'])) {
			$url .= '&filter_manufacturer=' . $this->request->get['filter_manufacturer'];
		}
		if (isset($this->request->get['filter_upc'])) {
		    $url .= '&filter_upc=' . urlencode(html_entity_decode($this->request->get['filter_upc'], ENT_QUOTES, 'UTF-8'));
		}
            
						
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_price'])) {
			$url .= '&filter_price=' . $this->request->get['filter_price'];
		}
		
		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
		}		

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
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

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, 'SSL'),       		
      		'separator' => ' :: '
   		);
		
		$this->data['insert'] = $this->url->link('catalog/product/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['copy'] = $this->url->link('catalog/product/copy', 'token=' . $this->session->data['token'] . $url, 'SSL');	
		$this->data['delete'] = $this->url->link('catalog/product/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
    	
		$this->data['products'] = array();

		$data = array(
			'filter_name'	  => $filter_name, 
			'filter_model'	  => $filter_model,
			'filter_price'	  => $filter_price,
			'filter_quantity' => $filter_quantity,
			'filter_status'   => $filter_status,
			'sort'            => $sort,
			'order'           => $order,
			'start'           => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'           => $this->config->get('config_admin_limit')
		);
		
		$this->load->model('tool/image');
		

                $data['filter_manufacturer'] = $filter_manufacturer;
                $data['filter_category_id'] = $filter_category_id;
                $data['filter_upc'] = $filter_upc;
			
		$product_total = $this->model_catalog_product->getTotalProducts($data);
			
		$results = $this->model_catalog_product->getProducts($data);
				    	
		foreach ($results as $result) {
			$action = array();
			
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('catalog/product/update', 'token=' . $this->session->data['token'] . '&product_id=' . $result['product_id'] . $url, 'SSL')
			);
			
			if ($result['image'] && file_exists(DIR_IMAGE . $result['image'])) {
				$image = $this->model_tool_image->resize($result['image'], 40, 40);
			} else {
				$image = $this->model_tool_image->resize('no_image.jpg', 40, 40);
			}
	
			$special = false;
			
			$product_specials = $this->model_catalog_product->getProductSpecials($result['product_id']);
 
                $this->load->model('localisation/language');
                $this->data['languages'] = $this->model_localisation_language->getLanguages();
                $this->load->model('catalog/product');

			
			$this->model_catalog_product->create_table();
			
			
                $product_id = $result['product_id'];
                $this->data['product_description'][$product_id] = $this->model_catalog_product->getProductDescriptions($result['product_id']);
            
			
			foreach ($product_specials  as $product_special) {
				if (($product_special['date_start'] == '0000-00-00' || $product_special['date_start'] < date('Y-m-d')) && ($product_special['date_end'] == '0000-00-00' || $product_special['date_end'] > date('Y-m-d'))) {
					$special = $product_special['price'];
 
                $special_id = $product_special['product_special_id'];
            
			
					break;
				}					
			}
	
 
                $manufacturer = $this->model_catalog_manufacturer->getManufacturer($result['manufacturer_id']);
            
      		$this->data['products'][] = array(
 
               'categories' => $this->model_catalog_product->getProductCategories($result['product_id']),
               'manufacturer_name' => $manufacturer ? $manufacturer['name'] : '- - -',
               'manufacturer_id' => $result['manufacturer_id'],
               'upc' => $result['upc'],
            
				'product_id' => $result['product_id'],
				'name'       => $result['name'],
				'model'      => $result['model'],
				'price'      => $result['price'],
				'special'    => $special,
				'image'      => $image,
				'quantity'   => $result['quantity'],
				'status'     => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
				'selected'   => isset($this->request->post['selected']) && in_array($result['product_id'], $this->request->post['selected']),
				'action'     => $action
			);
    	}
		
		$this->data['heading_title'] = $this->language->get('heading_title');		
				
		$this->data['text_enabled'] = $this->language->get('text_enabled');		
		$this->data['text_disabled'] = $this->language->get('text_disabled');		
		$this->data['text_no_results'] = $this->language->get('text_no_results');		
		$this->data['text_image_manager'] = $this->language->get('text_image_manager');		
			
		$this->data['column_image'] = $this->language->get('column_image');		
		$this->data['column_name'] = $this->language->get('column_name');		

            $this->data['column_category'] = substr($this->language->get('entry_category'),0,strpos($this->language->get('entry_category').':',':'));
            $this->data['column_manufacturer'] = substr($this->language->get('entry_manufacturer'),0,strpos($this->language->get('entry_manufacturer').':',':'));
            $this->data['column_upc'] = substr($this->language->get('entry_upc'),0,strpos($this->language->get('entry_upc').':',':'));        
            
		$this->data['column_model'] = $this->language->get('column_model');		
		$this->data['column_price'] = $this->language->get('column_price');		
		$this->data['column_quantity'] = $this->language->get('column_quantity');		

                $this->data['column_upc'] = 'UPC';
            
		$this->data['column_status'] = $this->language->get('column_status');		
		$this->data['column_action'] = $this->language->get('column_action');		
				
		$this->data['button_copy'] = $this->language->get('button_copy');		
		$this->data['button_insert'] = $this->language->get('button_insert');		
		$this->data['button_delete'] = $this->language->get('button_delete');		
		$this->data['button_filter'] = $this->language->get('button_filter');
		 
 		$this->data['token'] = $this->session->data['token'];
		
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$url = '';

                if (isset($this->request->get['show_category_column'])) {
                    $url .= '&show_category_column =' . $this->request->get['show_category_column'];
                }
                if (isset($this->request->get['show_manufacturer_column'])) {
                    $url .= '&show_manufacturer_column =' . $this->request->get['show_manufacturer_column'];
                }
                if (isset($this->request->get['show_upc_column'])) {
                    $url .= '&show_upc_column =' . $this->request->get['show_upc_column'];
                }
                
		if (isset($this->request->get['filter_category_id'])) {
			$url .= '&filter_category_id=' . $this->request->get['filter_category_id'];
		}
		if (isset($this->request->get['filter_manufacturer'])) {
			$url .= '&filter_manufacturer=' . $this->request->get['filter_manufacturer'];
		}
		if (isset($this->request->get['filter_upc'])) {
		    $url .= '&filter_upc=' . urlencode(html_entity_decode($this->request->get['filter_upc'], ENT_QUOTES, 'UTF-8'));
		}
            

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_price'])) {
			$url .= '&filter_price=' . $this->request->get['filter_price'];
		}
		
		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
		}
		
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}
								
		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
					
 
                $this->data['sort_manufacturer'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . '&sort=m.name' . $url, 'SSL');
                $this->data['sort_upc'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . '&sort=p.upc' . $url, 'SSL');
            
		$this->data['sort_name'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . '&sort=pd.name' . $url, 'SSL');
		$this->data['sort_model'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . '&sort=p.model' . $url, 'SSL');
		$this->data['sort_price'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . '&sort=p.price' . $url, 'SSL');
		$this->data['sort_quantity'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . '&sort=p.quantity' . $url, 'SSL');
		$this->data['sort_status'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . '&sort=p.status' . $url, 'SSL');
		$this->data['sort_order'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . '&sort=p.sort_order' . $url, 'SSL');
		
		$url = '';

                if (isset($this->request->get['show_category_column'])) {
                    $url .= '&show_category_column =' . $this->request->get['show_category_column'];
                }
                if (isset($this->request->get['show_manufacturer_column'])) {
                    $url .= '&show_manufacturer_column =' . $this->request->get['show_manufacturer_column'];
                }
                if (isset($this->request->get['show_upc_column'])) {
                    $url .= '&show_upc_column =' . $this->request->get['show_upc_column'];
                }
                
		if (isset($this->request->get['filter_category_id'])) {
			$url .= '&filter_category_id=' . $this->request->get['filter_category_id'];
		}
		if (isset($this->request->get['filter_manufacturer'])) {
			$url .= '&filter_manufacturer=' . $this->request->get['filter_manufacturer'];
		}
		if (isset($this->request->get['filter_upc'])) {
		    $url .= '&filter_upc=' . urlencode(html_entity_decode($this->request->get['filter_upc'], ENT_QUOTES, 'UTF-8'));
		}
            

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_price'])) {
			$url .= '&filter_price=' . $this->request->get['filter_price'];
		}
		
		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
				
		$pagination = new Pagination();
		$pagination->total = $product_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();

            $this->data['categories'] = $this->model_catalog_category->getCategories(0);
            $this->data['filter_category_id'] = $filter_category_id;
            $this->data['filter_manufacturer'] = $filter_manufacturer;
            $this->data['filter_upc'] = $filter_upc;
                
            $this->data['manufacturers'] = $this->model_catalog_manufacturer->getManufacturers(array('sort' =>'name'));

			
	
		$this->data['filter_name'] = $filter_name;
		$this->data['filter_model'] = $filter_model;
 
               $this->data['filter_upc'] = $filter_upc;
            
		$this->data['filter_price'] = $filter_price;
		$this->data['filter_quantity'] = $filter_quantity;
		$this->data['filter_status'] = $filter_status;
		
		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'catalog/product_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
  	}

  	protected function getForm() {
    	$this->data['heading_title'] = $this->language->get('heading_title');
 
    	$this->data['text_enabled'] = $this->language->get('text_enabled');
    	$this->data['text_disabled'] = $this->language->get('text_disabled');
    	$this->data['text_none'] = $this->language->get('text_none');
    	$this->data['text_yes'] = $this->language->get('text_yes');
    	$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_plus'] = $this->language->get('text_plus');
		$this->data['text_minus'] = $this->language->get('text_minus');
		$this->data['text_default'] = $this->language->get('text_default');
		$this->data['text_image_manager'] = $this->language->get('text_image_manager');
		$this->data['text_browse'] = $this->language->get('text_browse');
		$this->data['text_clear'] = $this->language->get('text_clear');
		$this->data['text_option'] = $this->language->get('text_option');
		$this->data['text_option_value'] = $this->language->get('text_option_value');
		$this->data['text_select'] = $this->language->get('text_select');
		$this->data['text_none'] = $this->language->get('text_none');
		$this->data['text_percent'] = $this->language->get('text_percent');
		$this->data['text_amount'] = $this->language->get('text_amount');

		$this->data['entry_name'] = $this->language->get('entry_name');
$this->data['entry_custom_title'] = $this->language->get('entry_custom_title');
		$this->data['entry_meta_description'] = $this->language->get('entry_meta_description');
		$this->data['entry_meta_keyword'] = $this->language->get('entry_meta_keyword');
		$this->data['entry_description'] = $this->language->get('entry_description');
		$this->data['entry_store'] = $this->language->get('entry_store');
		$this->data['entry_keyword'] = $this->language->get('entry_keyword');
    	$this->data['entry_model'] = $this->language->get('entry_model');
		$this->data['entry_sku'] = $this->language->get('entry_sku');
		$this->data['entry_upc'] = $this->language->get('entry_upc');
		$this->data['entry_ean'] = $this->language->get('entry_ean');
		$this->data['entry_jan'] = $this->language->get('entry_jan');
		$this->data['entry_isbn'] = $this->language->get('entry_isbn');
		$this->data['entry_mpn'] = $this->language->get('entry_mpn');
		$this->data['entry_location'] = $this->language->get('entry_location');
		$this->data['entry_minimum'] = $this->language->get('entry_minimum');
		$this->data['entry_manufacturer'] = $this->language->get('entry_manufacturer');
    	$this->data['entry_shipping'] = $this->language->get('entry_shipping');
    	$this->data['entry_date_available'] = $this->language->get('entry_date_available');
    	$this->data['entry_quantity'] = $this->language->get('entry_quantity');
		$this->data['entry_stock_status'] = $this->language->get('entry_stock_status');
    	$this->data['entry_price'] = $this->language->get('entry_price');
		$this->data['entry_tax_class'] = $this->language->get('entry_tax_class');
		$this->data['entry_points'] = $this->language->get('entry_points');
		$this->data['entry_option_points'] = $this->language->get('entry_option_points');
		$this->data['entry_subtract'] = $this->language->get('entry_subtract');
    	$this->data['entry_weight_class'] = $this->language->get('entry_weight_class');
    	$this->data['entry_weight'] = $this->language->get('entry_weight');
		$this->data['entry_dimension'] = $this->language->get('entry_dimension');
		$this->data['entry_length'] = $this->language->get('entry_length');
    	$this->data['entry_image'] = $this->language->get('entry_image');
    	$this->data['entry_download'] = $this->language->get('entry_download');
    	$this->data['entry_category'] = $this->language->get('entry_category');
		$this->data['entry_filter'] = $this->language->get('entry_filter');
		$this->data['entry_related'] = $this->language->get('entry_related');
		$this->data['entry_attribute'] = $this->language->get('entry_attribute');
		$this->data['entry_text'] = $this->language->get('entry_text');
		$this->data['entry_option'] = $this->language->get('entry_option');
		$this->data['entry_option_value'] = $this->language->get('entry_option_value');
		$this->data['entry_required'] = $this->language->get('entry_required');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_customer_group'] = $this->language->get('entry_customer_group');
		$this->data['entry_date_start'] = $this->language->get('entry_date_start');
		$this->data['entry_date_end'] = $this->language->get('entry_date_end');
		$this->data['entry_priority'] = $this->language->get('entry_priority');
		$this->data['entry_tag'] = $this->language->get('entry_tag');
		$this->data['entry_customer_group'] = $this->language->get('entry_customer_group');
		$this->data['entry_reward'] = $this->language->get('entry_reward');
		$this->data['entry_layout'] = $this->language->get('entry_layout');


                $this->document->addScript('view/javascript/jquery/jquery.qtip-1.0.0-rc3.min.js');

                $this->data['entry_stock_available'] = $this->language->get('entry_stock_available');

                $this->data['entry_combo_option_value'] = $this->language->get('entry_combo_option_value');

                $this->data['entry_combo_option_value_combo'] = $this->language->get('entry_combo_option_value_combo');

                $this->data['entry_combo_stock_available'] = $this->language->get('entry_combo_stock_available');

                $this->data['entry_combo_duration'] = $this->language->get('entry_combo_duration');

                $this->data['entry_combo_table_view'] = $this->language->get('entry_combo_table_view');

                $this->data['entry_combo_option_view'] = $this->language->get('entry_combo_option_view');

                $this->data['entry_combo_description_view'] = $this->language->get('entry_combo_description_view');

                $this->data['entry_combo_price_view'] = $this->language->get('entry_combo_price_view');

                $this->data['entry_combo_extax_view'] = $this->language->get('entry_combo_extax_view');

                $this->data['entry_combo_description'] = $this->language->get('entry_combo_description');

                $this->data['entry_combo_col_select_view'] = $this->language->get('entry_combo_col_select_view');

                $this->data['entry_combo_col_quantity_view'] = $this->language->get('entry_combo_col_quantity_view');

                $this->data['entry_combo_col_price_view'] = $this->language->get('entry_combo_col_price_view');

                $this->data['entry_combo_col_total_price_view'] = $this->language->get('entry_combo_col_total_price_view');

                $this->data['entry_combo_col_points_view'] = $this->language->get('entry_combo_col_points_view');

                $this->data['entry_combo_col_total_points_view'] = $this->language->get('entry_combo_col_total_points_view');

                $this->data['entry_combo_status'] = $this->language->get('entry_combo_status');

                $this->data['entry_combo_table_split'] = $this->language->get('entry_combo_table_split');

                $this->data['entry_combo_quantity_box'] = $this->language->get('entry_combo_quantity_box');

                $this->data['tab_option_combo'] = $this->language->get('tab_option_combo');

                $this->data['button_add_option_combo'] = $this->language->get('button_add_option_combo');

                $this->data['error_option_exist'] = $this->language->get('error_option_exist');

                $this->data['text_ahelp1_price_view'] = $this->language->get('text_ahelp1_price_view');

                $this->data['text_ahelp2_description_view'] = $this->language->get('text_ahelp2_description_view');

                $this->data['text_ahelp3_option_view'] = $this->language->get('text_ahelp3_option_view');

                $this->data['text_ahelp4_table_view'] = $this->language->get('text_ahelp4_table_view');

                $this->data['text_ahelp5_col_select_view'] = $this->language->get('text_ahelp5_col_select_view');

                $this->data['text_ahelp6_col_quantity_view'] = $this->language->get('text_ahelp6_col_quantity_view');

                $this->data['text_ahelp7_col_points_view'] = $this->language->get('text_ahelp7_col_points_view');

                $this->data['text_ahelp8_col_total_points_view'] = $this->language->get('text_ahelp8_col_total_points_view');

                $this->data['text_ahelp9_col_price_view'] = $this->language->get('text_ahelp9_col_price_view');

                $this->data['text_ahelp10_col_total_price_view'] = $this->language->get('text_ahelp10_col_total_price_view');

                $this->data['text_ahelp11_extax_view'] = $this->language->get('text_ahelp11_extax_view');

                $this->data['text_ahelp12_table_split'] = $this->language->get('text_ahelp12_table_split');

                $this->data['text_ahelp13_quantity_box'] = $this->language->get('text_ahelp13_quantity_box');

                $this->data['text_chelp1_option_value'] = $this->language->get('text_chelp1_option_value');

                $this->data['text_chelp2_stock_available'] = $this->language->get('text_chelp2_stock_available');

                $this->data['text_chelp3_quantity'] = $this->language->get('text_chelp3_quantity');

                $this->data['text_chelp4_price'] = $this->language->get('text_chelp4_price');

                $this->data['text_chelp5_points'] = $this->language->get('text_chelp5_points');

                $this->data['text_chelp6_weight'] = $this->language->get('text_chelp6_weight');

                $this->data['text_chelp7_priority'] = $this->language->get('text_chelp7_priority');

                $this->data['text_chelp8_customer_group'] = $this->language->get('text_chelp8_customer_group');

                $this->data['text_chelp9_duration'] = $this->language->get('text_chelp9_duration');

            
		$this->data['entry_profile'] = $this->language->get('entry_profile');
		$this->data['entry_complementary'] = $this->language->get('entry_complementary');
    
		$this->data['entry_stock_status_limits'] = $this->language->get('entry_stock_status_limits');

		$this->data['text_recurring_help'] = $this->language->get('text_recurring_help');
		$this->data['text_recurring_title'] = $this->language->get('text_recurring_title');
		$this->data['text_recurring_trial'] = $this->language->get('text_recurring_trial');
		$this->data['entry_recurring'] = $this->language->get('entry_recurring');
		$this->data['entry_recurring_price'] = $this->language->get('entry_recurring_price');
		$this->data['entry_recurring_freq'] = $this->language->get('entry_recurring_freq');
		$this->data['entry_recurring_cycle'] = $this->language->get('entry_recurring_cycle');
		$this->data['entry_recurring_length'] = $this->language->get('entry_recurring_length');
		$this->data['entry_trial'] = $this->language->get('entry_trial');
		$this->data['entry_trial_price'] = $this->language->get('entry_trial_price');
		$this->data['entry_trial_freq'] = $this->language->get('entry_trial_freq');
		$this->data['entry_trial_length'] = $this->language->get('entry_trial_length');
		$this->data['entry_trial_cycle'] = $this->language->get('entry_trial_cycle');

		$this->data['text_length_day'] = $this->language->get('text_length_day');
		$this->data['text_length_week'] = $this->language->get('text_length_week');
		$this->data['text_length_month'] = $this->language->get('text_length_month');
		$this->data['text_length_month_semi'] = $this->language->get('text_length_month_semi');
		$this->data['text_length_year'] = $this->language->get('text_length_year');

    	$this->data['button_save'] = $this->language->get('button_save');
    	$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_add_attribute'] = $this->language->get('button_add_attribute');
		$this->data['button_add_option'] = $this->language->get('button_add_option');
		$this->data['button_add_option_value'] = $this->language->get('button_add_option_value');
		$this->data['button_add_discount'] = $this->language->get('button_add_discount');
		$this->data['button_add_special'] = $this->language->get('button_add_special');
		$this->data['button_add_image'] = $this->language->get('button_add_image');
		$this->data['button_remove'] = $this->language->get('button_remove');
		$this->data['button_add_profile'] = $this->language->get('button_add_profile');
		
    	$this->data['tab_general'] = $this->language->get('tab_general');
    	$this->data['tab_data'] = $this->language->get('tab_data');
		$this->data['tab_attribute'] = $this->language->get('tab_attribute');
		$this->data['tab_option'] = $this->language->get('tab_option');		
		$this->data['tab_profile'] = $this->language->get('tab_profile');
		$this->data['tab_discount'] = $this->language->get('tab_discount');
		$this->data['tab_special'] = $this->language->get('tab_special');
    	$this->data['tab_image'] = $this->language->get('tab_image');		
		$this->data['tab_links'] = $this->language->get('tab_links');
		$this->data['tab_reward'] = $this->language->get('tab_reward');
		$this->data['tab_design'] = $this->language->get('tab_design');

			
			$this->data['tab_download_pdf'] = $this->language->get('tab_download_pdf');
			$this->data['entry_description_document'] = $this->language->get('entry_description_document');
			$this->data['button_upload'] = $this->language->get('button_upload');
			
			
		$this->data['tab_marketplace_links'] = $this->language->get('tab_marketplace_links');
		$this->data['tab_mapping_ax_code'] = $this->language->get('tab_mapping_ax_code');

		$this->data['text_product_id'] = $this->language->get('text_product_id');
		$this->data['text_product_code'] = $this->language->get('text_product_code');
		$this->data['text_possible_variants'] = $this->language->get('text_possible_variants');
		$this->data['text_size'] = $this->language->get('text_size');
		$this->data['text_colour'] = $this->language->get('text_colour');
		$this->data['text_configuration'] = $this->language->get('text_configuration');
		$this->data['text_concatenated_ax_code'] = $this->language->get('text_concatenated_ax_code');
		$this->data['column_name'] = $this->language->get('column_name');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

 		if (isset($this->error['name'])) {
			$this->data['error_name'] = $this->error['name'];
		} else {
			$this->data['error_name'] = array();
		}

if (isset($this->error['custom_title'])) {
					$this->data['error_custom_title'] = $this->error['custom_title'];
				} else {
					$this->data['error_custom_title'] = array();
				}	
 		if (isset($this->error['meta_description'])) {
			$this->data['error_meta_description'] = $this->error['meta_description'];
		} else {
			$this->data['error_meta_description'] = array();
		}		
   
   		if (isset($this->error['description'])) {
			$this->data['error_description'] = $this->error['description'];
		} else {
			$this->data['error_description'] = array();
		}	
		
   		if (isset($this->error['model'])) {
			$this->data['error_model'] = $this->error['model'];
		} else {
			$this->data['error_model'] = '';
		}		
     	
		if (isset($this->error['date_available'])) {
			$this->data['error_date_available'] = $this->error['date_available'];
		} else {
			$this->data['error_date_available'] = '';
		}	

		$url = '';

                if (isset($this->request->get['show_category_column'])) {
                    $url .= '&show_category_column =' . $this->request->get['show_category_column'];
                }
                if (isset($this->request->get['show_manufacturer_column'])) {
                    $url .= '&show_manufacturer_column =' . $this->request->get['show_manufacturer_column'];
                }
                if (isset($this->request->get['show_upc_column'])) {
                    $url .= '&show_upc_column =' . $this->request->get['show_upc_column'];
                }
                
		if (isset($this->request->get['filter_category_id'])) {
			$url .= '&filter_category_id=' . $this->request->get['filter_category_id'];
		}
		if (isset($this->request->get['filter_manufacturer'])) {
			$url .= '&filter_manufacturer=' . $this->request->get['filter_manufacturer'];
		}
		if (isset($this->request->get['filter_upc'])) {
		    $url .= '&filter_upc=' . urlencode(html_entity_decode($this->request->get['filter_upc'], ENT_QUOTES, 'UTF-8'));
		}
            

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_price'])) {
			$url .= '&filter_price=' . $this->request->get['filter_price'];
		}
		
		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
		}	
		
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
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

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
									
		if (!isset($this->request->get['product_id'])) {
			$this->data['action'] = $this->url->link('catalog/product/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('catalog/product/update', 'token=' . $this->session->data['token'] . '&product_id=' . $this->request->get['product_id'] . $url, 'SSL');
		}
		
		$this->data['cancel'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['product_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$product_info = $this->model_catalog_product->getProduct($this->request->get['product_id']);
    	}

		$this->data['token'] = $this->session->data['token'];
		
		$this->load->model('localisation/language');
		
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		
		if (isset($this->request->post['product_description'])) {
			$this->data['product_description'] = $this->request->post['product_description'];
		} elseif (isset($this->request->get['product_id'])) {
			$this->data['product_description'] = $this->model_catalog_product->getProductDescriptions($this->request->get['product_id']);
		} else {
			$this->data['product_description'] = array();
		}

			
			if (isset($this->request->post['description_document'])) {
				$this->data['description_document'] = $this->request->post['description_document'];
			} elseif (isset($this->request->get['product_id'])) {
				$this->data['description_document'] = $this->model_catalog_product->getProductDocument($this->request->get['product_id']);
			} else {
				$this->data['description_document'] = array();
			}

			if (isset($this->request->get['product_id'])) {
				$this->data['product_id'] = $this->request->get['product_id'];
			} else {
				$this->data['product_id'] = 0;
			}

			
			
		
		if (isset($this->request->post['model'])) {
      		$this->data['model'] = $this->request->post['model'];
    	} elseif (!empty($product_info)) {
			$this->data['model'] = $product_info['model'];
		} else {
      		$this->data['model'] = '';
    	}

		if (isset($this->request->post['sku'])) {
      		$this->data['sku'] = $this->request->post['sku'];
    	} elseif (!empty($product_info)) {
			$this->data['sku'] = $product_info['sku'];
		} else {
      		$this->data['sku'] = '';
    	}
		
		if (isset($this->request->post['upc'])) {
      		$this->data['upc'] = $this->request->post['upc'];
    	} elseif (!empty($product_info)) {
			$this->data['upc'] = $product_info['upc'];
		} else {
      		$this->data['upc'] = '';
    	}
		
		if (isset($this->request->post['ean'])) {
      		$this->data['ean'] = $this->request->post['ean'];
    	} elseif (!empty($product_info)) {
			$this->data['ean'] = $product_info['ean'];
		} else {
      		$this->data['ean'] = '';
    	}
		
		if (isset($this->request->post['jan'])) {
      		$this->data['jan'] = $this->request->post['jan'];
    	} elseif (!empty($product_info)) {
			$this->data['jan'] = $product_info['jan'];
		} else {
      		$this->data['jan'] = '';
    	}
		
		if (isset($this->request->post['isbn'])) {
      		$this->data['isbn'] = $this->request->post['isbn'];
    	} elseif (!empty($product_info)) {
			$this->data['isbn'] = $product_info['isbn'];
		} else {
      		$this->data['isbn'] = '';
    	}
		
		if (isset($this->request->post['mpn'])) {
      		$this->data['mpn'] = $this->request->post['mpn'];
    	} elseif (!empty($product_info)) {
			$this->data['mpn'] = $product_info['mpn'];
		} else {
      		$this->data['mpn'] = '';
    	}								
				
		if (isset($this->request->post['location'])) {
      		$this->data['location'] = $this->request->post['location'];
    	} elseif (!empty($product_info)) {
			$this->data['location'] = $product_info['location'];
		} else {
      		$this->data['location'] = '';
    	}

		$this->load->model('setting/store');
		
		$this->data['stores'] = $this->model_setting_store->getStores();
		
		if (isset($this->request->post['product_store'])) {
			$this->data['product_store'] = $this->request->post['product_store'];
		} elseif (isset($this->request->get['product_id'])) {
			$this->data['product_store'] = $this->model_catalog_product->getProductStores($this->request->get['product_id']);
		} else {
			$this->data['product_store'] = array(0);
		}	
		
		if (isset($this->request->post['stock_status_limit'])) {
			$this->data['stock_status_limit'] = $this->request->post['stock_status_limit'];
		} elseif (!empty($product_info)) {
			$this->data['stock_status_limit'] = json_decode( $product_info['stock_status_limits'] );      
		} else {
			$this->data['stock_status_limit'] = '';
		}
    
		if (isset($this->request->post['keyword'])) {
			$this->data['keyword'] = $this->request->post['keyword'];
		} elseif (!empty($product_info)) {
			$this->data['keyword'] = $product_info['keyword'];
		} else {
			$this->data['keyword'] = '';
		}
		
		if (isset($this->request->post['image'])) {
			$this->data['image'] = $this->request->post['image'];
		} elseif (!empty($product_info)) {
			$this->data['image'] = $product_info['image'];
		} else {
			$this->data['image'] = '';
		}
		
		$this->load->model('tool/image');
		
		if (isset($this->request->post['image']) && file_exists(DIR_IMAGE . $this->request->post['image'])) {
			$this->data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		} elseif (!empty($product_info) && $product_info['image'] && file_exists(DIR_IMAGE . $product_info['image'])) {
			$this->data['thumb'] = $this->model_tool_image->resize($product_info['image'], 100, 100);
		} else {
			$this->data['thumb'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}
		
    	if (isset($this->request->post['shipping'])) {
      		$this->data['shipping'] = $this->request->post['shipping'];
    	} elseif (!empty($product_info)) {
      		$this->data['shipping'] = $product_info['shipping'];
    	} else {
			$this->data['shipping'] = 1;
		}
		
    	if (isset($this->request->post['price'])) {
      		$this->data['price'] = $this->request->post['price'];
    	} elseif (!empty($product_info)) {
			$this->data['price'] = $product_info['price'];
		} else {
      		$this->data['price'] = '';
    	}
		
        $this->load->model('catalog/profile');
        
        $this->data['profiles'] = $this->model_catalog_profile->getProfiles();
        
        if (isset($this->request->post['product_profiles'])) {
      		$this->data['product_profiles'] = $this->request->post['product_profiles'];
    	} elseif (!empty($product_info)) {
			$this->data['product_profiles'] = $this->model_catalog_product->getProfiles($product_info['product_id']);
		} else {
      		$this->data['product_profiles'] = array();
    	}
		
		$this->load->model('localisation/tax_class');
		
		$this->data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();
    	
		if (isset($this->request->post['tax_class_id'])) {
      		$this->data['tax_class_id'] = $this->request->post['tax_class_id'];
    	} elseif (!empty($product_info)) {
			$this->data['tax_class_id'] = $product_info['tax_class_id'];
		} else {
      		$this->data['tax_class_id'] = 0;
    	}
		      	
		if (isset($this->request->post['date_available'])) {
       		$this->data['date_available'] = $this->request->post['date_available'];
		} elseif (!empty($product_info)) {
			$this->data['date_available'] = date('Y-m-d', strtotime($product_info['date_available']));
		} else {
			$this->data['date_available'] = date('Y-m-d', time() - 86400);
		}
											
    	if (isset($this->request->post['quantity'])) {
      		$this->data['quantity'] = $this->request->post['quantity'];
    	} elseif (!empty($product_info)) {
      		$this->data['quantity'] = $product_info['quantity'];
    	} else {
			$this->data['quantity'] = 1;
		}
		
		if (isset($this->request->post['minimum'])) {
      		$this->data['minimum'] = $this->request->post['minimum'];
    	} elseif (!empty($product_info)) {
      		$this->data['minimum'] = $product_info['minimum'];
    	} else {
			$this->data['minimum'] = 1;
		}
		
		if (isset($this->request->post['subtract'])) {
      		$this->data['subtract'] = $this->request->post['subtract'];
    	} elseif (!empty($product_info)) {
      		$this->data['subtract'] = $product_info['subtract'];
    	} else {
			$this->data['subtract'] = 1;
		}
		
		if (isset($this->request->post['sort_order'])) {
      		$this->data['sort_order'] = $this->request->post['sort_order'];
    	} elseif (!empty($product_info)) {
      		$this->data['sort_order'] = $product_info['sort_order'];
    	} else {
			$this->data['sort_order'] = 1;
		}

		$this->load->model('localisation/stock_status');
		
		$this->data['stock_statuses'] = $this->model_localisation_stock_status->getStockStatuses();
    	
		if (isset($this->request->post['stock_status_id'])) {
      		$this->data['stock_status_id'] = $this->request->post['stock_status_id'];
    	} elseif (!empty($product_info)) {
      		$this->data['stock_status_id'] = $product_info['stock_status_id'];
    	} else {
			$this->data['stock_status_id'] = $this->config->get('config_stock_status_id');
		}
				
    	if (isset($this->request->post['status'])) {
      		$this->data['status'] = $this->request->post['status'];
    	} elseif (!empty($product_info)) {
			$this->data['status'] = $product_info['status'];
		} else {
      		$this->data['status'] = 1;
    	}

    	if (isset($this->request->post['weight'])) {
      		$this->data['weight'] = $this->request->post['weight'];
		} elseif (!empty($product_info)) {
			$this->data['weight'] = $product_info['weight'];
    	} else {
      		$this->data['weight'] = '';
    	} 
		
		$this->load->model('localisation/weight_class');
		
		$this->data['weight_classes'] = $this->model_localisation_weight_class->getWeightClasses();
    	
		if (isset($this->request->post['weight_class_id'])) {
      		$this->data['weight_class_id'] = $this->request->post['weight_class_id'];
    	} elseif (!empty($product_info)) {
      		$this->data['weight_class_id'] = $product_info['weight_class_id'];
		} else {
      		$this->data['weight_class_id'] = $this->config->get('config_weight_class_id');
    	}
		
		if (isset($this->request->post['length'])) {
      		$this->data['length'] = $this->request->post['length'];
    	} elseif (!empty($product_info)) {
			$this->data['length'] = $product_info['length'];
		} else {
      		$this->data['length'] = '';
    	}
		
		if (isset($this->request->post['width'])) {
      		$this->data['width'] = $this->request->post['width'];
		} elseif (!empty($product_info)) {	
			$this->data['width'] = $product_info['width'];
    	} else {
      		$this->data['width'] = '';
    	}
		
		if (isset($this->request->post['height'])) {
      		$this->data['height'] = $this->request->post['height'];
		} elseif (!empty($product_info)) {
			$this->data['height'] = $product_info['height'];
    	} else {
      		$this->data['height'] = '';
    	}

		$this->load->model('localisation/length_class');
		
		$this->data['length_classes'] = $this->model_localisation_length_class->getLengthClasses();
    	
		if (isset($this->request->post['length_class_id'])) {
      		$this->data['length_class_id'] = $this->request->post['length_class_id'];
    	} elseif (!empty($product_info)) {
      		$this->data['length_class_id'] = $product_info['length_class_id'];
    	} else {
      		$this->data['length_class_id'] = $this->config->get('config_length_class_id');
		}

		$this->load->model('catalog/manufacturer');
		
    	if (isset($this->request->post['manufacturer_id'])) {
      		$this->data['manufacturer_id'] = $this->request->post['manufacturer_id'];
		} elseif (!empty($product_info)) {
			$this->data['manufacturer_id'] = $product_info['manufacturer_id'];
		} else {
      		$this->data['manufacturer_id'] = 0;
    	} 		
		
    	if (isset($this->request->post['manufacturer'])) {
      		$this->data['manufacturer'] = $this->request->post['manufacturer'];
		} elseif (!empty($product_info)) {
			$manufacturer_info = $this->model_catalog_manufacturer->getManufacturer($product_info['manufacturer_id']);
			
			if ($manufacturer_info) {		
				$this->data['manufacturer'] = $manufacturer_info['name'];
			} else {
				$this->data['manufacturer'] = '';
			}	
		} else {
      		$this->data['manufacturer'] = '';
    	} 
		
		// Categories
		$this->load->model('catalog/category');
		
		if (isset($this->request->post['product_category'])) {
			$categories = $this->request->post['product_category'];
		} elseif (isset($this->request->get['product_id'])) {		
			$categories = $this->model_catalog_product->getProductCategories($this->request->get['product_id']);
		} else {
			$categories = array();
		}
	
		$this->data['product_categories'] = array();
		
		foreach ($categories as $category_id) {
			$category_info = $this->model_catalog_category->getCategory($category_id);
			
			if ($category_info) {
				$this->data['product_categories'][] = array(
					'category_id' => $category_info['category_id'],
					'name'        => ($category_info['path'] ? $category_info['path'] . ' &gt; ' : '') . $category_info['name']
				);
			}
		}
		
		// Filters
		$this->load->model('catalog/filter');
		
		if (isset($this->request->post['product_filter'])) {
			$filters = $this->request->post['product_filter'];
		} elseif (isset($this->request->get['product_id'])) {
			$filters = $this->model_catalog_product->getProductFilters($this->request->get['product_id']);
		} else {
			$filters = array();
		}
		
		$this->data['product_filters'] = array();
		
		foreach ($filters as $filter_id) {
			$filter_info = $this->model_catalog_filter->getFilter($filter_id);
			
			if ($filter_info) {
				$this->data['product_filters'][] = array(
					'filter_id' => $filter_info['filter_id'],
					'name'      => $filter_info['group'] . ' &gt; ' . $filter_info['name']
				);
			}
		}		
		
		// Attributes
		$this->load->model('catalog/attribute');
		
		if (isset($this->request->post['product_attribute'])) {
			$product_attributes = $this->request->post['product_attribute'];
		} elseif (isset($this->request->get['product_id'])) {
			$product_attributes = $this->model_catalog_product->getProductAttributes($this->request->get['product_id']);
		} else {
			$product_attributes = array();
		}
		
		$this->data['product_attributes'] = array();
		
		foreach ($product_attributes as $product_attribute) {
			$attribute_info = $this->model_catalog_attribute->getAttribute($product_attribute['attribute_id']);
			
			if ($attribute_info) {
				$this->data['product_attributes'][] = array(
					'attribute_id'                  => $product_attribute['attribute_id'],
					'name'                          => $attribute_info['name'],
					'product_attribute_description' => $product_attribute['product_attribute_description']
				);
			}
		}		
		
		// Options
		$this->load->model('catalog/option');
		
		if (isset($this->request->post['product_option'])) {
			$product_options = $this->request->post['product_option'];
		} elseif (isset($this->request->get['product_id'])) {
			$product_options = $this->model_catalog_product->getProductOptions($this->request->get['product_id']);			
		} else {
			$product_options = array();
		}			
		


                //description

                if (isset($this->request->post['product_option_combo_description'])) {

        			$this->data['product_option_combo_description'] = $this->request->post['product_option_combo_description'];

        		} elseif (isset($product_info)) {

        			$this->data['product_option_combo_description'] = $this->model_catalog_product->getProductOptionComboDescription($this->request->get['product_id']);

        		} else {

        			$this->data['product_option_combo_description'] = array();

        		}



                //setting

                if(!isset($this->request->get['product_id']))

                {

                    $this->request->get['product_id'] = 0;

                }

                $option_combo_setting = $this->model_catalog_product->getProductOptionComboSetting($this->request->get['product_id']);



                if (isset($this->request->post['option_combo_price_view'])) {

              		$this->data['option_combo_price_view'] = $this->request->post['option_combo_price_view'];

            	} elseif (isset($option_combo_setting['price_view'])) {

        			$this->data['option_combo_price_view'] = $option_combo_setting['price_view'];

        		} else {

              		$this->data['option_combo_price_view'] = '1';

            	}



                if (isset($this->request->post['option_combo_table_view'])) {

              		$this->data['option_combo_table_view'] = $this->request->post['option_combo_table_view'];

            	} elseif (isset($option_combo_setting['table_view'])) {

        			$this->data['option_combo_table_view'] = $option_combo_setting['table_view'];

        		} else {

              		$this->data['option_combo_table_view'] = '0';

            	}



                if (isset($this->request->post['option_combo_option_view'])) {

              		$this->data['option_combo_option_view'] = $this->request->post['option_combo_option_view'];

            	} elseif (isset($option_combo_setting['option_view'])) {

        			$this->data['option_combo_option_view'] = $option_combo_setting['option_view'];

        		} else {

              		$this->data['option_combo_option_view'] = '1';

            	}



                if (isset($this->request->post['option_combo_description_view'])) {

              		$this->data['option_combo_description_view'] = $this->request->post['option_combo_description_view'];

            	} elseif (isset($option_combo_setting['description_view'])) {

        			$this->data['option_combo_description_view'] = $option_combo_setting['description_view'];

        		} else {

              		$this->data['option_combo_description_view'] = '1';

            	}



                if (isset($this->request->post['option_combo_col_select_view'])) {

              		$this->data['option_combo_col_select_view'] = $this->request->post['option_combo_col_select_view'];

            	} elseif (isset($option_combo_setting['col_select_view'])) {

        			$this->data['option_combo_col_select_view'] = $option_combo_setting['col_select_view'];

        		} else {

              		$this->data['option_combo_col_select_view'] = '0';

            	}



                if (isset($this->request->post['option_combo_col_quantity_view'])) {

              		$this->data['option_combo_col_quantity_view'] = $this->request->post['option_combo_col_quantity_view'];

            	} elseif (isset($option_combo_setting['col_quantity_view'])) {

        			$this->data['option_combo_col_quantity_view'] = $option_combo_setting['col_quantity_view'];

        		} else {

              		$this->data['option_combo_col_quantity_view'] = '0';

            	}



                if (isset($this->request->post['option_combo_col_price_view'])) {

              		$this->data['option_combo_col_price_view'] = $this->request->post['option_combo_col_price_view'];

            	} elseif (isset($option_combo_setting['col_price_view'])) {

        			$this->data['option_combo_col_price_view'] = $option_combo_setting['col_price_view'];

        		} else {

              		$this->data['option_combo_col_price_view'] = '0';

            	}



                if (isset($this->request->post['option_combo_col_total_price_view'])) {

              		$this->data['option_combo_col_total_price_view'] = $this->request->post['option_combo_col_total_price_view'];

            	} elseif (isset($option_combo_setting['col_total_price_view'])) {

        			$this->data['option_combo_col_total_price_view'] = $option_combo_setting['col_total_price_view'];

        		} else {

              		$this->data['option_combo_col_total_price_view'] = '0';

            	}



                if (isset($this->request->post['option_combo_col_points_view'])) {

              		$this->data['option_combo_col_points_view'] = $this->request->post['option_combo_col_points_view'];

            	} elseif (isset($option_combo_setting['col_points_view'])) {

        			$this->data['option_combo_col_points_view'] = $option_combo_setting['col_points_view'];

        		} else {

              		$this->data['option_combo_col_points_view'] = '0';

            	}



                if (isset($this->request->post['option_combo_col_total_points_view'])) {

              		$this->data['option_combo_col_total_points_view'] = $this->request->post['option_combo_col_total_points_view'];

            	} elseif (isset($option_combo_setting['col_total_points_view'])) {

        			$this->data['option_combo_col_total_points_view'] = $option_combo_setting['col_total_points_view'];

        		} else {

              		$this->data['option_combo_col_total_points_view'] = '0';

            	}



                if (isset($this->request->post['option_combo_status'])) {

              		$this->data['option_combo_status'] = $this->request->post['option_combo_status'];

            	} elseif (isset($option_combo_setting['status'])) {

        			$this->data['option_combo_status'] = $option_combo_setting['status'];

        		} else {

              		$this->data['option_combo_status'] = '0';

            	}



                if (isset($this->request->post['option_combo_extax_view'])) {

              		$this->data['option_combo_extax_view'] = $this->request->post['option_combo_extax_view'];

            	} elseif (isset($option_combo_setting['extax_view'])) {

        			$this->data['option_combo_extax_view'] = $option_combo_setting['extax_view'];

        		} else {

              		$this->data['option_combo_extax_view'] = '0';

            	}



                if (isset($this->request->post['option_combo_table_split'])) {

              		$this->data['option_combo_table_split'] = $this->request->post['option_combo_table_split'];

            	} elseif (isset($option_combo_setting['table_split'])) {

        			$this->data['option_combo_table_split'] = $option_combo_setting['table_split'];

        		} else {

              		$this->data['option_combo_table_split'] = '0';

            	}



                if (isset($this->request->post['option_combo_quantity_box'])) {

              		$this->data['option_combo_quantity_box'] = $this->request->post['option_combo_quantity_box'];

            	} elseif (isset($option_combo_setting['quantity_box'])) {

        			$this->data['option_combo_quantity_box'] = $option_combo_setting['quantity_box'];

        		} else {

              		$this->data['option_combo_quantity_box'] = '1';

            	}



                /* BALAZS */

                    $this->data['product_option_optionFilter'] = array();

                    $this->data['product_option_optionValueFilter'] = array();

                    $foreachStep = 0;

                    if( ! empty( $product_options ) )

                    {

                        foreach ($product_options as $product_option)

                        {

                            $foreachStep++;

                            $this->data['product_option_optionFilter'][] = $product_option["option_id"];



                            if( ! empty( $product_option["product_option_value"] ) )

                            {

                                foreach( $product_option["product_option_value"] as $oneOptionValue )

                                {

                                    $this->data['product_option_optionValueFilter'][$product_option["option_id"]][] = $oneOptionValue["option_value_id"];

                                }

                            }

                        }

                    }

                /* EOF BALAZS */



 $someThing = "";

			    //option combo

                $this->load->model('catalog/option');



                $options = $this->model_catalog_product->getProductOptions($this->request->get['product_id']);



                $this->data['options'] = '';

                $this->data['table_split_options'] = '<option value="0">' . $this->language->get('text_disabled') . '</option>';

                foreach($options as $option)

                {

                    if($option['type'] == 'checkbox' || $option['type'] == 'radio' || $option['type'] == 'select')

                    {

                        if( in_array( $option['option_id'], $this->data['product_option_optionFilter'] ) ) // if by BALAZS

                        {

                            $this->data['options'] .= '<option value="' . $option['option_id'] . '">' . $option['name'] . '</option>';

                        }

                    }

                    if($option['type'] == 'radio' || $option['type'] == 'select')

                    {

                        $this->data['table_split_options'] .= '<option value="' . $option['option_id'] . '"' . ((isset($option_combo_setting['table_split']) && $option_combo_setting['table_split'] == $option['option_id']) ? 'selected="selected"' : '') . '>' . $option['name'] . '</option>';

                    }

                }



                $this->data['product_option_combo'] = '';



                $product_option_combos = $this->model_catalog_product->getProductOptionCombos($this->request->get['product_id']);

                $this->data['product_option_combo_count'] = count($product_option_combos);

                $this->data['product_id'] = $this->request->get['product_id'];

                $o_count = 0;

                $this->load->model('sale/customer_group');

                $customer_groups = $this->model_sale_customer_group->getCustomerGroups();

                foreach($product_option_combos as $product_option_combo)

                {

                    $this->data['product_option_combo'] .= '<tbody id="combo-row' . $o_count . '"><tr>';

                    $this->data['product_option_combo'] .= '<td class="left"><input type="hidden" name="product_option_combo[' . $o_count . '][product_option_combination_id]" value="' . $product_option_combo['product_option_combination_id'] . '" /><input type="hidden" name="product_option_combo[' . $o_count . '][product_id]" value="' . $product_option_combo['product_id'] . '" />';

                    $this->data['product_option_combo'] .= '<select name="options" id="combo-option' . $o_count . '" style="width: 200px;">'.$this->data['options'].'</select><br /><select name="option-values" id="combo-option' . $o_count . '-value" style="width: 150px;"></select>';

                    // BALAZS

                    // $this->data['product_option_combo'] .= '<input type="hidden" name="product_id" value="'.$this->request->get['product_id'].'">';

                    // EOF BALAZS

                    $this->data['product_option_combo'] .= '<a href="#" class="add-option-value-btn" name="' . $o_count . '"><img src="view/image/add.png" /></a> <a href="#" class="remove-option-value-btn" name="' . $o_count . '"><img src="view/image/delete.png" /></a>';

                    $this->data['product_option_combo'] .= '<br /><select multiple="multiple" name="product_option_combo[' . $o_count . '][product_option_combo_values][]" id="combo-option' . $o_count . '-values-selected" class="option-combo-values-selected" size="5" style="width: 200px;">';

                    $ov_count = 0;



$arrayForStamp = array();

                    foreach($product_option_combo['option_values'] as $combo_values)

                    {

$arrayForStamp[] = $combo_values['option_value_id'];

                        $this->data['product_option_combo'] .= '<option value="' . $combo_values['option_value_id'] . '">' . $combo_values['od_name'] . ' > ' . $combo_values['ov_name'] . '</option>';

                        $ov_count++;

                    }

asort( $arrayForStamp );

if( ! isset( $detectDuplicate ) )

{

        $detectDuplicate = array();

}



if( in_array( implode( "_", $arrayForStamp ), $detectDuplicate ) )

{

    $someThing .= "Duplicated: ".implode( "_", $arrayForStamp );

}

else

{

    $someThing .= ", ".implode( "_", $arrayForStamp );

    $detectDuplicate[] = implode( "_", $arrayForStamp );

}

                    $this->data['product_option_combo'] .= '</select>';

                    $this->data['product_option_combo'] .= '</td>';

                    $this->data['product_option_combo'] .= '<td class="right"><input type="text" name="product_option_combo[' . $o_count . '][stock]" value="'.$product_option_combo['stock'].'" size="3" /><br />';

                    $this->data['product_option_combo'] .= $this->language->get('entry_subtract'). '<select name="product_option_combo[' . $o_count . '][subtract]">';

                    if($product_option_combo['subtract']) {

                        $this->data['product_option_combo'] .= '<option value="1" selected="selected">'.$this->language->get('text_yes').'</option><option value="0">'.$this->language->get('text_no').'</option></select></td>';

                    } else {

                        $this->data['product_option_combo'] .= '<option value="1">'.$this->language->get('text_yes').'</option><option value="0" selected="selected">'.$this->language->get('text_no').'</option></select></td>';

                    }

                    $this->data['product_option_combo'] .= '<td class="right"><input type="text" name="product_option_combo[' . $o_count . '][quantity]" value="'.$product_option_combo['quantity'].'" size="4" /></td>';

                    $this->data['product_option_combo'] .= '<td class="right"><select name="product_option_combo[' . $o_count . '][price_prefix]">';

                    $this->data['product_option_combo'] .= '<option value="="' . ($product_option_combo['price_prefix'] == '=' ? ' selected="selected"' : '') . '>Absolute</option><option value="+"' . ($product_option_combo['price_prefix'] == '+' ? ' selected="selected"' : '') . '>+</option><option value="-"' . ($product_option_combo['price_prefix'] == '-' ? ' selected="selected"' : '') . '>-</option><option value="0"' . ($product_option_combo['price_prefix'] == '0' ? ' selected="selected"' : '') . '>Disable</option></select><input type="text" name="product_option_combo[' . $o_count . '][price]" value="'.$product_option_combo['price'].'" size="8" /></td>';

                    $this->data['product_option_combo'] .= '<td class="right"><select name="product_option_combo[' . $o_count . '][points_prefix]">';

                    $this->data['product_option_combo'] .= '<option value="="' . ($product_option_combo['points_prefix'] == '=' ? ' selected="selected"' : '') . '>Absolute</option><option value="+"' . ($product_option_combo['points_prefix'] == '+' ? ' selected="selected"' : '') . '>+</option><option value="-"' . ($product_option_combo['points_prefix'] == '-' ? ' selected="selected"' : '') . '>-</option><option value="0"' . ($product_option_combo['points_prefix'] == '0' ? ' selected="selected"' : '') . '>Disable</option></select><input type="text" name="product_option_combo[' . $o_count . '][points]" value="'.$product_option_combo['points'].'" size="8" /></td>';

                    $this->data['product_option_combo'] .= '<td class="right"><select name="product_option_combo[' . $o_count . '][weight_prefix]">';

                    $this->data['product_option_combo'] .= '<option value="="' . ($product_option_combo['weight_prefix'] == '=' ? ' selected="selected"' : '') . '>Absolute</option><option value="+"' . ($product_option_combo['weight_prefix'] == '+' ? ' selected="selected"' : '') . '>+</option><option value="-"' . ($product_option_combo['weight_prefix'] == '-' ? ' selected="selected"' : '') . '>-</option><option value="0"' . ($product_option_combo['weight_prefix'] == '0' ? ' selected="selected"' : '') . '>Disable</option></select><input type="text" name="product_option_combo[' . $o_count . '][weight]" value="'.$product_option_combo['weight'].'" size="8" /></td>';

                    $this->data['product_option_combo'] .= '<td class="right"><input type="text" name="product_option_combo[' . $o_count . '][sort_order]" value="'.$product_option_combo['sort_order'].'" size="1" /></td>';

                    $this->data['product_option_combo'] .= '<td class="right"><select name="product_option_combo[' . $o_count . '][customer_group_id]">';

                    foreach ($customer_groups as $customer_group) {

                        $this->data['product_option_combo'] .= '<option value="' . $customer_group['customer_group_id'] . '"' . ($product_option_combo['customer_group_id'] == $customer_group['customer_group_id'] ? ' selected="selected"' : '') . '>' . $customer_group['name'] . '</option>';

                    }

                    $this->data['product_option_combo'] .= '</select></td>';

                    $this->data['product_option_combo'] .= '<td class="center">'.$this->language->get('entry_date_start').'<input type="text" name="product_option_combo[' . $o_count . '][date_start]" class="date" value="'.$product_option_combo['date_start'].'" size="8" /><br /><br />'.$this->language->get('entry_date_end').'<input type="text" name="product_option_combo[' . $o_count . '][date_end]" class="date" value="'.$product_option_combo['date_end'].'" size="8" /></td>';



                    $this->data['product_option_combo'] .= '<td class="center"><a onclick="$(this).parent().parent().find(\'td\').fadeOut(\'slow\', function(){$(this).remove();});" class="button"><span>' . $this->language->get('button_remove') . '</span></a></td></tr></tbody>';



                    $o_count++;

                }



$this->data['product_option_combo'] .= '<script> console.log("Duplications result: '.$someThing.' \n "); </script>';



            
		$this->data['product_options'] = array();
        
		foreach ($product_options as $product_option) {
			if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
				$product_option_value_data = array();
				
				foreach ($product_option['product_option_value'] as $product_option_value) {
					$product_option_value_data[] = array(
						'product_option_value_id' => $product_option_value['product_option_value_id'],
						'option_value_id'         => $product_option_value['option_value_id'],
						'quantity'                => $product_option_value['quantity'],
						'subtract'                => $product_option_value['subtract'],
						'price'                   => $product_option_value['price'],
						'price_prefix'            => $product_option_value['price_prefix'],
						'points'                  => $product_option_value['points'],
						'points_prefix'           => $product_option_value['points_prefix'],						
						'weight'                  => $product_option_value['weight'],
						'weight_prefix'           => $product_option_value['weight_prefix']	
					);
				}
				
				$this->data['product_options'][] = array(
					'product_option_id'    => $product_option['product_option_id'],
					'product_option_value' => $product_option_value_data,
					'option_id'            => $product_option['option_id'],
					'name'                 => $product_option['name'],
					'type'                 => $product_option['type'],
					'required'             => $product_option['required']
				);				
			} else {
				$this->data['product_options'][] = array(
					'product_option_id' => $product_option['product_option_id'],
					'option_id'         => $product_option['option_id'],
					'name'              => $product_option['name'],
					'type'              => $product_option['type'],
					'option_value'      => $product_option['option_value'],
					'required'          => $product_option['required']
				);				
			}
		}
		
		$this->data['option_values'] = array();
		
		foreach ($this->data['product_options'] as $product_option) {
			if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
				if (!isset($this->data['option_values'][$product_option['option_id']])) {
					$this->data['option_values'][$product_option['option_id']] = $this->model_catalog_option->getOptionValues($product_option['option_id']);
				}
			}
		}
		
		$this->load->model('sale/customer_group');
		
		$this->data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups();
		
		if (isset($this->request->post['product_discount'])) {
			$this->data['product_discounts'] = $this->request->post['product_discount'];
		} elseif (isset($this->request->get['product_id'])) {
			$this->data['product_discounts'] = $this->model_catalog_product->getProductDiscounts($this->request->get['product_id']);
		} else {
			$this->data['product_discounts'] = array();
		}

		if (isset($this->request->post['product_special'])) {
			$this->data['product_specials'] = $this->request->post['product_special'];
		} elseif (isset($this->request->get['product_id'])) {
			$this->data['product_specials'] = $this->model_catalog_product->getProductSpecials($this->request->get['product_id']);
		} else {
			$this->data['product_specials'] = array();
		}
		
		// Images
		if (isset($this->request->post['product_image'])) {
			$product_images = $this->request->post['product_image'];
		} elseif (isset($this->request->get['product_id'])) {
			$product_images = $this->model_catalog_product->getProductImages($this->request->get['product_id']);
		} else {
			$product_images = array();
		}
		
		$this->data['product_images'] = array();
		
		foreach ($product_images as $product_image) {
			if ($product_image['image'] && file_exists(DIR_IMAGE . $product_image['image'])) {
				$image = $product_image['image'];
			} else {
				$image = 'no_image.jpg';
			}
			
			$this->data['product_images'][] = array(
				'image'      => $image,
				'thumb'      => $this->model_tool_image->resize($image, 100, 100),
				'sort_order' => $product_image['sort_order']
			);
		}

		$this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);

		// Downloads
		$this->load->model('catalog/download');
		
		if (isset($this->request->post['product_download'])) {
			$product_downloads = $this->request->post['product_download'];
		} elseif (isset($this->request->get['product_id'])) {
			$product_downloads = $this->model_catalog_product->getProductDownloads($this->request->get['product_id']);
		} else {
			$product_downloads = array();
		}
			
		$this->data['product_downloads'] = array();
		
		foreach ($product_downloads as $download_id) {
			$download_info = $this->model_catalog_download->getDownload($download_id);
			
			if ($download_info) {
				$this->data['product_downloads'][] = array(
					'download_id' => $download_info['download_id'],
					'name'        => $download_info['name']
				);
			}
		}
		
		if (isset($this->request->post['product_related'])) {
			$products = $this->request->post['product_related'];
		} elseif (isset($this->request->get['product_id'])) {		
			$products = $this->model_catalog_product->getProductRelated($this->request->get['product_id']);
		} else {
			$products = array();
		}
	
		$this->data['product_related'] = array();
		
		foreach ($products as $product_id) {
			$related_info = $this->model_catalog_product->getProduct($product_id);
			
			if ($related_info) {
				$this->data['product_related'][] = array(
					'product_id' => $related_info['product_id'],
					'name'       => $related_info['name']
				);
			}
		}

		if (isset($this->request->post['product_complementary'])) {
			$products = $this->request->post['product_complementary'];
		} elseif (isset($this->request->get['product_id'])) {
			$products = $this->model_catalog_product->getProductComplementary($this->request->get['product_id']);
		} else {
			$products = array();
		}


		$this->data['product_complementary'] = array();

		foreach ($products as $product_id) {
			$complementary_info = $this->model_catalog_product->getProduct($product_id);

			if ($complementary_info) {
				$this->data['product_complementary'][] = array(
					'product_id' => $complementary_info['product_id'],
					'name'       => $complementary_info['name']
				);
			}
		}

    	if (isset($this->request->post['points'])) {
      		$this->data['points'] = $this->request->post['points'];
    	} elseif (!empty($product_info)) {
			$this->data['points'] = $product_info['points'];
		} else {
      		$this->data['points'] = '';
    	}

		if (isset($this->request->post['product_reward'])) {
			$this->data['product_reward'] = $this->request->post['product_reward'];
		} elseif (isset($this->request->get['product_id'])) {
			$this->data['product_reward'] = $this->model_catalog_product->getProductRewards($this->request->get['product_id']);
		} else {
			$this->data['product_reward'] = array();
		}
		
		if (isset($this->request->post['product_layout'])) {
			$this->data['product_layout'] = $this->request->post['product_layout'];
		} elseif (isset($this->request->get['product_id'])) {
			$this->data['product_layout'] = $this->model_catalog_product->getProductLayouts($this->request->get['product_id']);
		} else {
			$this->data['product_layout'] = array();
		}

		$this->load->model('design/layout');
		
		$this->data['layouts'] = $this->model_design_layout->getLayouts();


		$this->data['mapping'] = $this->model_catalog_product->mappingAxCode( $this->request->get['product_id'] );

/*		if( $_SERVER['REMOTE_ADDR'] == '188.26.23.46' )
		{
			print_r( $this->data['mapping'] );
			die();
		}*/
									
		$this->template = 'catalog/product_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
  	}
	
  	protected function validateForm() { 
    	if (!$this->user->hasPermission('modify', 'catalog/product')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}

    	foreach ($this->request->post['product_description'] as $language_id => $value) {
      		if ((utf8_strlen($value['name']) < 1) || (utf8_strlen($value['name']) > 255)) {
        		$this->error['name'][$language_id] = $this->language->get('error_name');
      		}
    	}
		
    	if ((utf8_strlen($this->request->post['model']) < 1) || (utf8_strlen($this->request->post['model']) > 64)) {
      		$this->error['model'] = $this->language->get('error_model');
    	}
		
		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}
					
    	if (!$this->error) {
			return true;
    	} else {
      		return false;
    	}
  	}
	
  	protected function validateDelete() {
    	if (!$this->user->hasPermission('modify', 'catalog/product')) {
      		$this->error['warning'] = $this->language->get('error_permission');  
    	}
		
		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}
  	}
  	
  	protected function validateCopy() {
    	if (!$this->user->hasPermission('modify', 'catalog/product')) {
      		$this->error['warning'] = $this->language->get('error_permission');  
    	}
		
		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}
  	}
		


            	public function option() {

            		$output = '';



            		$this->load->model('catalog/option');



                //BALAZS

                    $availableOptionValueArray = array();

                    if( ! empty( $this->request->get['product_id'] ) )

                    {

                        $this->load->model('catalog/product');

			
			$this->model_catalog_product->create_table();
			
			

                        $options = $this->model_catalog_product->getProductOptions((int)$this->request->get['product_id']);

                        if( ! empty( $options ) )

                        {

                            foreach( $options as $oneOption )

                            {

                                if( $oneOption["product_option_id"] )

                                {

                                    if( ! empty( $oneOption["product_option_value"] ) )

                                    foreach( $oneOption["product_option_value"] as $oneProdOptValue )

                                    {

                                        $availableOptionValueArray[] = $oneProdOptValue['option_value_id'];

                                    }

                                }

                            }

                        }

                    }

                //eof BALAZS



            		$results = $this->model_catalog_option->getOptionValues($this->request->get['option_id']);



            		foreach ($results as $result)

                {

                  // BALAZS

                  if( in_array( $result['option_value_id'], $availableOptionValueArray ) )

                  {

                  // EOF BALAZS

                      $output .= '<option value="' . $result['option_value_id'] . '"';



                      if (isset($this->request->get['option_value_id']) && ($this->request->get['option_value_id'] == $result['option_value_id'])) {

                        $output .= ' selected="selected"';

                      }



                      $output .= '>' . $result['name'] . '</option>';

                  }

            		}



            		$this->response->setOutput($output);

            	}

            

		public function insert_product_document() {

			//echo "<pre>"; print_r($this->request->post); die('opencart/vqmod/xml/product_description_pdf.xml:199');

			if (isset($this->request->post['product_document']) && is_array($this->request->post['product_document'])) {
				$this->load->model('catalog/product');
				$this->model_catalog_product->insert_product_document($this->request->post['product_document']);
			}
		}

		public function update_pr_document_details() {

			if (isset($this->request->post['product_document']) && is_array($this->request->post['product_document']) && $this->request->post['product_document']) {
				$this->load->model('catalog/product');

				//echo 'dfbdfbdfb<pre>'; print_r($this->request->post['product_document']);

				$response = $this->model_catalog_product->update_pr_document_details($this->request->post['product_document']);
			}

			echo $response;
		}

		public function delete_pr_document_details() {

		    $response = false;

	  		if (isset($this->request->post['delete_document']) && $this->request->post['delete_document']) {

	  			if (isset($this->request->post['delete_document']['all']) && $this->request->post['product_document']['all']) {

	  				//die("delete all doc");
	  			} else {
	  			    foreach ($this->request->post['delete_document'] as $doc) {

	  			        $delete_group = "DELETE FROM oc_product_description_download_pdf_to_customer_group WHERE product_description_download_pdf_id = ".$doc." ;";
	  			        $this->db->query($delete_group);

	  			        $delete_pdf = "DELETE FROM oc_product_description_download_pdf WHERE product_description_download_pdf_id = ".$doc." ;";
	  			        $response = $this->db->query($delete_pdf);

	  			        if($response) {
	  			            echo "delete_success";
	  			        } else {
	  			            echo "delete_failed";
	  			        }
	  			    }
	  			}

	  			//var_dump($this->request->post); die('asfbvsdfvs');
	  		}
	  		//die('fail out of validate if');
	  	}
			
	public function autocomplete() {
		$json = array();
		
		if (isset($this->request->get['filter_name']) || isset($this->request->get['filter_model']) || isset($this->request->get['filter_category_id'])) {
			$this->load->model('catalog/product');

			
			$this->model_catalog_product->create_table();
			
			
			$this->load->model('catalog/option');
			
			if (isset($this->request->get['filter_name'])) {
				$filter_name = $this->request->get['filter_name'];
			} else {
				$filter_name = '';
			}
			
			if (isset($this->request->get['filter_model'])) {
				$filter_model = $this->request->get['filter_model'];
			} else {
				$filter_model = '';
			}
			
			if (isset($this->request->get['limit'])) {
				$limit = $this->request->get['limit'];	
			} else {
				$limit = 20;	
			}			
						
			$data = array(
				'filter_name'  => $filter_name,
				'filter_model' => $filter_model,
				'start'        => 0,
				'limit'        => $limit
			);
			
			$results = $this->model_catalog_product->getProducts($data);
			
			foreach ($results as $result) {
				$option_data = array();
				
				$product_options = $this->model_catalog_product->getProductOptions($result['product_id']);	
				
				foreach ($product_options as $product_option) {
					$option_info = $this->model_catalog_option->getOption($product_option['option_id']);
					
					if ($option_info) {				
						if ($option_info['type'] == 'select' || $option_info['type'] == 'radio' || $option_info['type'] == 'checkbox' || $option_info['type'] == 'image') {
							$option_value_data = array();
							
							foreach ($product_option['product_option_value'] as $product_option_value) {
								$option_value_info = $this->model_catalog_option->getOptionValue($product_option_value['option_value_id']);
						
								if ($option_value_info) {
									$option_value_data[] = array(
										'product_option_value_id' => $product_option_value['product_option_value_id'],
										'option_value_id'         => $product_option_value['option_value_id'],
										'name'                    => $option_value_info['name'],
										'price'                   => (float)$product_option_value['price'] ? $this->currency->format($product_option_value['price'], $this->config->get('config_currency')) : false,
										'price_prefix'            => $product_option_value['price_prefix']
									);
								}
							}
						
							$option_data[] = array(
								'product_option_id' => $product_option['product_option_id'],
								'option_id'         => $product_option['option_id'],
								'name'              => $option_info['name'],
								'type'              => $option_info['type'],
								'option_value'      => $option_value_data,
								'required'          => $product_option['required']
							);	
						} else {
							$option_data[] = array(
								'product_option_id' => $product_option['product_option_id'],
								'option_id'         => $product_option['option_id'],
								'name'              => $option_info['name'],
								'type'              => $option_info['type'],
								'option_value'      => $product_option['option_value'],
								'required'          => $product_option['required']
							);				
						}
					}
				}
					
				$json[] = array(
					'product_id' => $result['product_id'],
					'name'       => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),	
					'model'      => $result['model'],
					'option'     => $option_data,
					'price'      => $result['price']
				);	
			}
		}
 
		$this->response->setOutput(json_encode($json));
	}
}
?>