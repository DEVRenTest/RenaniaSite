<?php  
class ControllerCommonDreamColumnFooterTop extends Controller {
	protected function index() {
		$this->load->model('design/layout');
		$this->load->model('catalog/category');
		$this->load->model('catalog/product');
		$this->load->model('catalog/information');
		
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
		
		$module_data = array();
		
		$this->load->model('setting/extension');
		
		$extensions = $this->model_setting_extension->getExtensions('module');		
		
		foreach ($extensions as $extension) {
			$modules = $this->config->get($extension['code'] . '_module');
		
			if ($modules) {
				
				foreach ($modules as $module) {
					if (isset($module['layout_id'])) {
					if ($module['layout_id'] == $layout_id && (strpos($module['position'], 'column_footer_top')!==false) && $module['status']) {
						$module_data[$module['position']][] = array(
							'code'       => $extension['code'],
							'setting'    => $module,
							'sort_order' => $module['sort_order']
						);				
					}
					}
				}
			}
		}
		
		foreach ($module_data as &$group) {
		$sort_order = array(); 
		
		foreach ($group as $key => $value) {
      		$sort_order[$key] = $value['sort_order'];
    	}
		array_multisort($sort_order, SORT_ASC, $group);
		}
		
		$modules = array();
		
		foreach ($module_data as $key => $group) {
		foreach ($group as $module) {
			$module = $this->getChild('module/' . $module['code'], $module['setting']);
			
			if ($module) {
				$modules[$key][] = $module;
			}
		}	
		}
		
		$pos_width=$this->config->get("dream_extra_positions_widget");
		if (isset($pos_width['footer_top'])) $this->data['extra_pos_width']=$pos_width['footer_top'];
		
		$extra_pos=array();
		foreach($modules as $key => $arr_modules) {
		$pos1=strpos($key, "row"); $pos2=strpos($key, "col", $pos1); $row=substr($key, $pos1+3, $pos2-$pos1-4); $col=substr($key, $pos2+3, strlen($key)-$pos2-3);
		$extra_pos[$row][$col]=$arr_modules;
		}
		$this->data['modules']=$extra_pos;
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/dream_column_footer_top.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/common/dream_column_footer_top.tpl';
		} else {
			$this->template = 'default/template/common/dream_column_footer_top.tpl';
		}
								
		$this->render();
	}
}
?>