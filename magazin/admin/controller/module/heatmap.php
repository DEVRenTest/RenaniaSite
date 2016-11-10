<?php
class ControllerModuleHeatMap extends Controller {
	private $error = array(); 
	
	public function index() {   
		$this->language->load('module/heatmap');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('heatmap', $this->request->post);		
			
			$this->cache->delete('product');
			
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}
				
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_content_top'] = $this->language->get('text_content_top');
		$this->data['text_content_bottom'] = $this->language->get('text_content_bottom');		
		$this->data['text_column_left'] = $this->language->get('text_column_left');
		$this->data['text_column_right'] = $this->language->get('text_column_right');

		$this->data['entry_limit'] = $this->language->get('entry_limit');
		$this->data['entry_image'] = $this->language->get('entry_image');
		$this->data['entry_layout'] = $this->language->get('entry_layout');
		$this->data['entry_position'] = $this->language->get('entry_position');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_add_module'] = $this->language->get('button_add_module');
		$this->data['button_remove'] = $this->language->get('button_remove');
		
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if (isset($this->error['image'])) {
			$this->data['error_image'] = $this->error['image'];
		} else {
			$this->data['error_image'] = array();
		}
		
  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/heatmap', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link('module/heatmap', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['modules'] = array();
		
		if (isset($this->request->post['heatmap_module'])) {
			$this->data['modules'] = $this->request->post['heatmap_module'];
		} elseif ($this->config->get('heatmap_module')) { 
			$this->data['modules'] = $this->config->get('heatmap_module');
		}				
				
		$this->load->model('design/layout');
		
		$this->data['layouts'] = $this->model_design_layout->getLayouts();

		$this->template = 'module/heatmap.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}
	
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/heatmap')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (isset($this->request->post['heatmap_module'])) {
			foreach ($this->request->post['heatmap_module'] as $key => $value) {
				if (!$value['image_width'] || !$value['image_height']) {
					$this->request->post['heatmap_module']['image_width'] = 5;
					$this->request->post['heatmap_module']['image_height'] = 5;
					# $value['image_width'] = 5;
					# $value['image_height'] = 5;
					# $this->error['image'][$key] = $this->language->get('error_image');
				}
			}
		}	
        $sql_create_table_if_not_exists = "CREATE TABLE IF NOT EXISTS `oc_heatmap` (
            `id_heat` int(11) NOT NULL AUTO_INCREMENT,
            `from_page` varchar(250) NOT NULL,
            `coord_x` int(11) NOT NULL DEFAULT '0',
            `coord_y` int(11) NOT NULL DEFAULT '0',
            `percent_x` int(11) NOT NULL DEFAULT '0',
            `percent_y` int(11) NOT NULL DEFAULT '0',
            `resolution` varchar(100) NOT NULL DEFAULT '',
            `inserted_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id_heat`),
            KEY `from_page` (`from_page`)
        );";
        $result = $this->db->query($sql_create_table_if_not_exists);
        
		# var_dump($this->error);		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
?>