<?php
class ControllerExtensionForm extends Controller {
	public function index() {

		$this->language->load('extension/form');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			if ($this->config->get('google_form_url') != $this->request->post['google_form_url']) {
				$this->load->model('sale/customer');
				$this->model_sale_customer->resetShowFormStatus();
			}
			$this->model_setting_setting->editSetting('form', $this->request->post);
			$this->redirect($this->url->link('extension/form', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('extension/form', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

   		$this->data['action'] = $this->url->link('extension/form', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['token'] = $this->session->data['token'];

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_customer_groups'] = $this->language->get('text_customer_groups');
		$this->data['text_customer'] = $this->language->get('text_customer');
		$this->data['text_customer_group'] = $this->language->get('text_customer_group');
		$this->data['text_google_form_url'] = $this->language->get('text_google_form_url');
		$this->data['text_page_url'] = $this->language->get('text_page_url');
		$this->data['text_frequency'] = $this->language->get('text_frequency');
		$this->data['text_status'] = $this->language->get('text_status');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['entry_add_group'] = $this->language->get('entry_add_group');
		$this->data['entry_add_customer'] = $this->language->get('entry_add_customer');
		$this->data['tab_google_form'] = $this->language->get('tab_google_form');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_remove'] = $this->language->get('button_remove');

		$this->load->model('sale/customer');

		if (isset($this->request->post['form_customers'])) {
			$this->data['form_customers'] = $this->model_sale_customer->getCustomers(array('filter_ids' => $this->request->post['form_customers']));
		} elseif ($this->config->get('form_customers')) {
			$this->data['form_customers'] = $this->model_sale_customer->getCustomers(array('filter_ids' => $this->config->get('form_customers')));
		} else {
			$this->data['form_customers'] = array();
		}

		$this->load->model('sale/customer_group');

		$this->data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups();
		$this->data['customer_groups_simple_array'] = array();
		foreach ($this->data['customer_groups'] as $group) {
			$this->data['customer_groups_simple_array'][$group['customer_group_id']] = $group['name'];
		}

		$this->data['google_form_simple_array'] = array();
		foreach ($this->data['customer_groups'] as $group) {
			$this->data['google_form_simple_array'][$group['customer_group_id']] = $group['name'];
		}

		if (isset($this->request->post['config_google_form_customer_group'])) {
			$this->data['config_google_form_customer_group'] = $this->request->post['config_google_form_customer_group'];
		} elseif($this->config->get('config_google_form_customer_group')) {
			$this->data['config_google_form_customer_group'] = $this->config->get('config_google_form_customer_group');
		} else {
			$this->data['config_google_form_customer_group'] = array();
		}

		if (isset($this->request->post['google_form_url'])) {
			$this->data['google_form_url'] = $this->request->post['google_form_url'];
		} elseif($this->config->get('google_form_url')) {
			$this->data['google_form_url'] = $this->config->get('google_form_url');
		} else {
			$this->data['google_form_url'] = '';
		}

		if (isset($this->request->post['google_form_page_url'])) {
			$this->data['google_form_page_url'] = $this->request->post['google_form_page_url'];
		} elseif($this->config->get('google_form_page_url')) {
			$this->data['google_form_page_url'] = $this->config->get('google_form_page_url');
		} else {
			$this->data['google_form_page_url'] = '';
		}

		if (isset($this->request->post['google_form_frequency'])) {
			$this->data['google_form_frequency'] = $this->request->post['google_form_frequency'];
		} elseif($this->config->get('google_form_frequency')) {
			$this->data['google_form_frequency'] = $this->config->get('google_form_frequency');
		} else {
			$this->data['google_form_frequency'] = '';
		}

		if (isset($this->request->post['google_form_status'])) {
			$this->data['google_form_status'] = $this->request->post['google_form_status'];
		} else {
			$this->data['google_form_status'] = $this->config->get('google_form_status');
		}

		$this->template = 'extension/form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}
}
?>