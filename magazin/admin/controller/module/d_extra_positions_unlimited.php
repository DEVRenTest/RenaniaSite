<?php
class ControllerModuleDExtraPositionsUnlimited extends Controller {
	private $error = array(); 
	
	public function index() {   
	
		$this->document->addStyle('view/stylesheet/d_extra_positions_unlimited.css');
		$this->document->addStyle('view/stylesheet/shopunity.css');
		$this->document->addScript('view/javascript/shopunity.js');
		$this->document->addLink('http://fonts.googleapis.com/css?family=PT+Sans:400,700,700italic,400italic&subset=latin,cyrillic-ext,latin-ext,cyrillic', "stylesheet");
		$this->load->language('module/d_extra_positions_unlimited');
		
		$this->document->setTitle($this->language->get('heading_title_main'));
		
		$this->load->model('setting/setting');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('d_extra_positions_unlimited', $this->request->post);	
			
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}
				
		$this->data['heading_title'] = $this->language->get('heading_title_main');
		$this->data['heading_slogan'] = $this->language->get('heading_slogan');
		$this->data['entry_positions'] = $this->language->get('entry_positions');
		$this->data['entry_actions'] = $this->language->get('entry_actions');
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_delcol'] = $this->language->get('button_delcol');
		$this->data['button_addcol'] = $this->language->get('button_addcol');
		$this->data['button_delrow'] = $this->language->get('button_delrow');
		$this->data['button_addrow'] = $this->language->get('button_addrow');
		$this->data['header_top'] = $this->language->get('header_top');
		$this->data['header_bottom'] = $this->language->get('header_bottom');
		$this->data['footer_top'] = $this->language->get('footer_top');
		$this->data['footer_bottom'] = $this->language->get('footer_bottom');
		
		$this->data['tooltip_header_top'] = $this->language->get('tooltip_header_top');
		$this->data['tooltip_header_bottom'] = $this->language->get('tooltip_header_bottom');
		$this->data['tooltip_footer_top'] = $this->language->get('tooltip_footer_top');
		$this->data['tooltip_footer_bottom'] = $this->language->get('tooltip_footer_bottom');
		
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
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
       		'text'      => $this->language->get('heading_title_main'),
			'href'      => $this->url->link('module/d_extra_positions_unlimited', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link('module/d_extra_positions_unlimited', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['modules'] = array();
		$this->data['modules']['header_top'] = array();
		$this->data['modules']['header_bottom'] = array();
		$this->data['modules']['footer_top'] = array();
		$this->data['modules']['footer_bottom'] = array();
		
		if (isset($this->request->post['d_extra_positions_unlimited_widget'])) {
			$this->data['modules'] = $this->request->post['d_extra_positions_unlimited_widget'];
		} elseif ($this->config->get('d_extra_positions_unlimited_widget')) { 
			$this->data['modules'] = $this->config->get('d_extra_positions_unlimited_widget');
		}
			
			
		$this->load->model('design/layout');
		
		$this->data['layouts'] = $this->model_design_layout->getLayouts();
		
		$this->document->addScript('view/javascript/dreamvention/ui-slider/jquery.ui-slider.js');
		
		$this->template = 'module/d_extra_positions_unlimited.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/d_extra_positions_unlimited')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
	
	public function install() {
		$this->load->model('setting/setting');
		$file1 = str_replace("admin", "vqmod/xml", DIR_APPLICATION) . "a_vqmod_extra_positions_unlimited.xml_"; $file2 = str_replace("admin", "vqmod/xml", DIR_APPLICATION) . "a_vqmod_extra_positions_unlimited.xml";
		if (file_exists($file1)) rename($file1, $file2);
		
	}
	
	public function uninstall() {
		$this->load->model('setting/setting');
		$file1 = str_replace("admin", "vqmod/xml", DIR_APPLICATION) . "a_vqmod_extra_positions_unlimited.xml"; $file2 = str_replace("admin", "vqmod/xml", DIR_APPLICATION) . "a_vqmod_extra_positions_unlimited.xml_";
		if (file_exists($file1)) rename($file1, $file2);
		
	}
}
?>