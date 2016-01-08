<?php  
class ControllerModuleCategory extends Controller {
	protected function index($setting) {
		$this->language->load('module/category');
		
    $this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
    
		if (isset($this->request->get['path'])) {
			$parts = explode('_', (string)$this->request->get['path']);
		} else {
			$parts = array();
		}
		
		if (isset($parts[0])) {
			$this->data['category_id'] = $parts[0];
		} else {
			$this->data['category_id'] = 0;
		}
		
		if (isset($parts[1])) {
			$this->data['child_id'] = $parts[1];
		} else {
			$this->data['child_id'] = 0;
		}
							
		$this->load->model('catalog/category');

		$this->load->model('catalog/product');

    $this->load->model('tool/image'); 
    
		$this->data['categories'] = array();

		$categories = $this->model_catalog_category->getCategories(0);

		foreach ($categories as $category) {
			$total = $this->model_catalog_product->getTotalProducts(array('filter_category_id' => $category['category_id']));

			$children_data = array();

			$children = $this->model_catalog_category->getCategories($category['category_id']);

			foreach ($children as $child) {
				$data = array(
					'filter_category_id'  => $child['category_id'],
					'filter_sub_category' => true
				);

				$product_total = $this->model_catalog_product->getTotalProducts($data);

				$total += $product_total;

				$children_data[] = array(
					'category_id' => $child['category_id'],
					'name'        => $child['name'] . ($this->config->get('config_product_count') ? ' (' . $product_total . ')' : ''),
					'href'        => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])	
				);		
			}

      if ($category['image']) {
				$imageThumbForCategory = $this->model_tool_image->resize($category['image'], 47, 47); // $this->config->get('config_image_category_height')
			} else {
				$imageThumbForCategory = '';
			}
      
			$this->data['categories'][] = array(
				'category_id' => $category['category_id'],
				'name'        => $category['name'] . ($this->config->get('config_product_count') ? ' (' . $total . ')' : ''),
				'image'       => $imageThumbForCategory,
				'children'    => $children_data,
				'href'        => $this->url->link('product/category', 'path=' . $category['category_id'])
			);	
		}
    
    // balazs ++
    $this->data["filterProExtra"] = $this->getFilterProExtensionHere();
    // balazs --
    
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/category.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/category.tpl';
		} else {
			$this->template = 'default/template/module/category.tpl';
		}
		
		$this->render();
  	}
    
    /**
     * This module will load another module inside this module if is setted in admin ( position:'inside_categories' )
     * @author Balazs <balazs@grafx.ro>
     * @return array
     */
    private function getFilterProExtensionHere()
    {
      
      if (isset($this->request->get['route'])) {
			$route = (string)$this->request->get['route'];
      } else {
        $route = 'common/home';
      }

      $layout_id = 0;

      if ($route == 'product/category' && isset($this->request->get['path'])) {
        $path = explode('_', (string)$this->request->get['path']);

        $layout_id = $this->model_catalog_category->getCategoryLayoutId(end($path));			
      }
      
      if ($route == 'product/product' && isset($this->request->get['product_id'])) {
        $layout_id = $this->model_catalog_product->getProductLayoutId($this->request->get['product_id']);
      }

      if ($route == 'information/information' && isset($this->request->get['information_id'])) {
        $layout_id = $this->model_catalog_information->getInformationLayoutId($this->request->get['information_id']);
      }

      if (!$layout_id) {
        $layout_id = $this->model_design_layout->getLayout($route);
      }

      if (!$layout_id) {
        $layout_id = $this->config->get('config_layout_id');
      }      
            
      if( $layout_id != 3 )
      {
          return;
      }
      
      $module_data = array();
		
      $this->load->model('setting/extension');

      $extensions = $this->model_setting_extension->getExtensions('module');		

      foreach ($extensions as $extension)
      { 
        if($extension['code'] == "filterpro" )
        {
            $modules = $this->config->get('filterpro_module');
            
            if ($modules) {
              foreach ($modules as $module) {                
                if ( $module['position'] == 'inside_categories' && $module['status']) {
                  $module_data[] = array(
                    'code'       => $extension['code'],
                    'setting'    => $module,
                    'sort_order' => $module['sort_order']
                  );				
                }
              }
            }
        }
      }

      $sort_order = array(); 

      foreach ($module_data as $key => $value) {
            $sort_order[$key] = $value['sort_order'];
        }

      array_multisort($sort_order, SORT_ASC, $module_data);
      
      $returnHtml = array();
      
      foreach ($module_data as $module) 
      {
        $module = $this->getChild('module/' . $module['code'], $module['setting']);

        if ($module) {
          $returnHtml[] = $module;
        }
      }
      return $returnHtml;
    }
}
?>