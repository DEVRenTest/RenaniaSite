<?php
class ControllerModuleAbandonedCartReminder extends Controller {
	private $version = '1.4.1'; 
	private $error = array(); 
	
	public function install(){		
        $this->load->model('module/abandoned_cart_reminder');
		
		$this->model_module_abandoned_cart_reminder->createTables();
	}
	
	public function uninstall(){		
        $this->load->model('module/abandoned_cart_reminder');
		
		$this->model_module_abandoned_cart_reminder->removeTables();
	}
	
	public function index() {   
		$this->load->language('module/abandoned_cart_reminder');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->document->addStyle('view/stylesheet/abandoned_cart_reminder.css');
		
		$this->load->model('setting/setting');
		$this->load->model('tool/image');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('abandoned_cart_reminder', $this->request->post);		
					
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}
				
		$this->data['heading_title'] = $this->language->get('heading_title') . ' ' . $this->version;
		
		$this->data['tab_overview'] = $this->language->get('tab_overview');
		$this->data['tab_setting'] = $this->language->get('tab_setting');
		$this->data['tab_coupon'] = $this->language->get('tab_coupon');
		$this->data['tab_email'] = $this->language->get('tab_email');
		$this->data['tab_abandoned_cart'] = $this->language->get('tab_abandoned_cart');
		$this->data['tab_history'] = $this->language->get('tab_history');
		$this->data['tab_preview'] = $this->language->get('tab_preview');
		$this->data['tab_help']    = $this->language->get('tab_help');
		
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_coupon_fixed'] = $this->language->get('text_coupon_fixed');
		$this->data['text_coupon_percent'] = $this->language->get('text_coupon_percent');
		$this->data['text_coupon_all_products'] = $this->language->get('text_coupon_all_products');
		$this->data['text_coupon_cart_products'] = $this->language->get('text_coupon_cart_products');
		
		$this->data['text_content_top'] = $this->language->get('text_content_top');
		$this->data['text_content_bottom'] = $this->language->get('text_content_bottom');		
		$this->data['text_column_left'] = $this->language->get('text_column_left');
		$this->data['text_column_right'] = $this->language->get('text_column_right');
		
		$this->data['text_preview_info'] = $this->language->get('text_preview_info');
		$this->data['text_special_keyword'] = $this->language->get('text_special_keyword');
		
		$this->data['entry_secret_code']   = $this->language->get('entry_secret_code');
		$this->data['entry_delay']         = $this->language->get('entry_delay');
		$this->data['entry_hide_out_stock']= $this->language->get('entry_hide_out_stock');
		$this->data['entry_max_reminders'] = $this->language->get('entry_max_reminders');
		$this->data['entry_use_html_email'] = $this->language->get('entry_use_html_email');
		$this->data['entry_add_coupon']    = $this->language->get('entry_add_coupon');
		$this->data['entry_coupon_type']   = $this->language->get('entry_coupon_type');
		$this->data['entry_coupon_amount'] = $this->language->get('entry_coupon_amount');
		$this->data['entry_coupon_total']  = $this->language->get('entry_coupon_total');
		$this->data['entry_coupon_expire'] = $this->language->get('entry_coupon_expire');
		$this->data['entry_coupon_usage'] = $this->language->get('entry_coupon_usage');
		$this->data['entry_reward_limit']  = $this->language->get('entry_reward_limit');
		
		$this->data['entry_subject'] = $this->language->get('entry_subject');
		$this->data['entry_special_keyword'] = $this->language->get('entry_special_keyword');
		$this->data['entry_message_reward'] = $this->language->get('entry_message_reward');
		$this->data['entry_message_no_reward'] = $this->language->get('entry_message_no_reward');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_preview'] = $this->language->get('button_preview');
		$this->data['button_send'] = $this->language->get('button_send');
		
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = array();
		}
				
		if (isset($this->error['secret_code'])) {
			$this->data['error_secret_code'] = $this->error['secret_code'];
		} else {
			$this->data['error_secret_code'] = '';
		}
		
		if (isset($this->error['delay'])) {
			$this->data['error_delay'] = $this->error['delay'];
		} else {
			$this->data['error_delay'] = '';
		}
		
		if (isset($this->error['max_reminders'])) {
			$this->data['error_max_reminders'] = $this->error['max_reminders'];
		} else {
			$this->data['error_max_reminders'] = '';
		}
		
		if (isset($this->error['use_html_email'])) {
			$this->data['error_use_html_email'] = $this->error['use_html_email'];
		} else {
			$this->data['error_use_html_email'] = '';
		}
		
		if (isset($this->error['coupon_amount'])) {
			$this->data['error_coupon_amount'] = $this->error['coupon_amount'];
		} else {
			$this->data['error_coupon_amount'] = '';
		}

		if (isset($this->error['coupon_expire'])) {
			$this->data['error_coupon_expire'] = $this->error['coupon_expire'];
		} else {
			$this->data['error_coupon_expire'] = '';
		}
		
		if (isset($this->error['subject'])) {
			$this->data['error_subject'] = $this->error['subject'];
		} else {
			$this->data['error_subject'] = '';
		}	

		if (isset($this->error['message_reward'])) {
			$this->data['error_message_reward'] = $this->error['message_reward'];
		} else {
			$this->data['error_message_reward'] = array();
		}	

		if (isset($this->error['message_no_reward'])) {
			$this->data['error_message_no_reward'] = $this->error['message_no_reward'];
		} else {
			$this->data['error_message_no_reward'] = array();
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
			'href'      => $this->url->link('module/abandoned_cart_reminder', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link('module/abandoned_cart_reminder', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		
		if (isset($this->request->post['abandoned_cart_reminder_secret_code'])) {
			$this->data['abandoned_cart_reminder_secret_code'] = $this->request->post['abandoned_cart_reminder_secret_code'];
		} elseif ($this->config->get('abandoned_cart_reminder_secret_code')) { 
			$this->data['abandoned_cart_reminder_secret_code'] = $this->config->get('abandoned_cart_reminder_secret_code');
		} else {
			$this->data['abandoned_cart_reminder_secret_code'] = '';
		}
		
		if (isset($this->request->post['abandoned_cart_reminder_delay'])) {
			$this->data['abandoned_cart_reminder_delay'] = $this->request->post['abandoned_cart_reminder_delay'];
		} elseif ($this->config->get('abandoned_cart_reminder_delay')) { 
			$this->data['abandoned_cart_reminder_delay'] = $this->config->get('abandoned_cart_reminder_delay');
		} else {
			$this->data['abandoned_cart_reminder_delay'] = 3;
		}
		
		if (isset($this->request->post['abandoned_cart_reminder_max_reminders'])) {
			$this->data['abandoned_cart_reminder_max_reminders'] = $this->request->post['abandoned_cart_reminder_max_reminders'];
		} elseif ($this->config->get('abandoned_cart_reminder_max_reminders')) { 
			$this->data['abandoned_cart_reminder_max_reminders'] = $this->config->get('abandoned_cart_reminder_max_reminders');
		} else {
			$this->data['abandoned_cart_reminder_max_reminders'] = 3;
		}
		
		if (isset($this->request->post['abandoned_cart_reminder_hide_out_stock'])) {
			$this->data['abandoned_cart_reminder_hide_out_stock'] = $this->request->post['abandoned_cart_reminder_hide_out_stock'];
		} elseif ($this->config->get('abandoned_cart_reminder_hide_out_stock')) { 
			$this->data['abandoned_cart_reminder_hide_out_stock'] = $this->config->get('abandoned_cart_reminder_hide_out_stock');
		} else {
			$this->data['abandoned_cart_reminder_hide_out_stock'] = '';
		}		
		
		if (isset($this->request->post['abandoned_cart_reminder_use_html_email'])) {
			$this->data['abandoned_cart_reminder_use_html_email'] = $this->request->post['abandoned_cart_reminder_use_html_email'];
		} elseif ($this->config->get('abandoned_cart_reminder_use_html_email')) { 
			$this->data['abandoned_cart_reminder_use_html_email'] = $this->config->get('abandoned_cart_reminder_use_html_email');
		} else {
			$this->data['abandoned_cart_reminder_use_html_email'] = '';
		}
		
		if (isset($this->request->post['abandoned_cart_reminder_add_coupon'])) {
			$this->data['abandoned_cart_reminder_add_coupon'] = $this->request->post['abandoned_cart_reminder_add_coupon'];
		} elseif ($this->config->get('abandoned_cart_reminder_add_coupon')) { 
			$this->data['abandoned_cart_reminder_add_coupon'] = $this->config->get('abandoned_cart_reminder_add_coupon');
		} else {
			$this->data['abandoned_cart_reminder_add_coupon'] = 0;
		}
		
		if (isset($this->request->post['abandoned_cart_reminder_coupon_type'])) {
			$this->data['abandoned_cart_reminder_coupon_type'] = $this->request->post['abandoned_cart_reminder_coupon_type'];
		} elseif ($this->config->get('abandoned_cart_reminder_coupon_type')) { 
			$this->data['abandoned_cart_reminder_coupon_type'] = $this->config->get('abandoned_cart_reminder_coupon_type');
		} else {
			$this->data['abandoned_cart_reminder_coupon_type'] = 0;
		}
		
		if (isset($this->request->post['abandoned_cart_reminder_coupon_amount'])) {
			$this->data['abandoned_cart_reminder_coupon_amount'] = $this->request->post['abandoned_cart_reminder_coupon_amount'];
		} elseif ($this->config->get('abandoned_cart_reminder_coupon_amount')) { 
			$this->data['abandoned_cart_reminder_coupon_amount'] = $this->config->get('abandoned_cart_reminder_coupon_amount');
		} else {
			$this->data['abandoned_cart_reminder_coupon_amount'] = '';
		}
		
		if (isset($this->request->post['abandoned_cart_reminder_coupon_total'])) {
			$this->data['abandoned_cart_reminder_coupon_total'] = $this->request->post['abandoned_cart_reminder_coupon_total'];
		} elseif ($this->config->get('abandoned_cart_reminder_coupon_total')) { 
			$this->data['abandoned_cart_reminder_coupon_total'] = $this->config->get('abandoned_cart_reminder_coupon_total');
		} else {
			$this->data['abandoned_cart_reminder_coupon_total'] = '';
		}
		
		if (isset($this->request->post['abandoned_cart_reminder_coupon_usage'])) {
			$this->data['abandoned_cart_reminder_coupon_usage'] = $this->request->post['abandoned_cart_reminder_coupon_usage'];
		} elseif ($this->config->get('abandoned_cart_reminder_coupon_usage')) { 
			$this->data['abandoned_cart_reminder_coupon_usage'] = $this->config->get('abandoned_cart_reminder_coupon_usage');
		} else {
			$this->data['abandoned_cart_reminder_coupon_usage'] = '';
		}
		
		if (isset($this->request->post['abandoned_cart_reminder_coupon_expire'])) {
			$this->data['abandoned_cart_reminder_coupon_expire'] = $this->request->post['abandoned_cart_reminder_coupon_expire'];
		} elseif ($this->config->get('abandoned_cart_reminder_coupon_expire')) { 
			$this->data['abandoned_cart_reminder_coupon_expire'] = $this->config->get('abandoned_cart_reminder_coupon_expire');
		} else {
			$this->data['abandoned_cart_reminder_coupon_expire'] = 2;
		}
		
		if (isset($this->request->post['abandoned_cart_reminder_reward_limit'])) {
			$this->data['abandoned_cart_reminder_reward_limit'] = $this->request->post['abandoned_cart_reminder_reward_limit'];
		} elseif ($this->config->get('abandoned_cart_reminder_reward_limit')) { 
			$this->data['abandoned_cart_reminder_reward_limit'] = $this->config->get('abandoned_cart_reminder_reward_limit');
		} else {
			$this->data['abandoned_cart_reminder_reward_limit'] = '';
		}
		
		if (isset($this->request->post['abandoned_cart_reminder_mail'])) {
			$this->data['abandoned_cart_reminder_mail'] = $this->request->post['abandoned_cart_reminder_mail'];
		} elseif ($this->config->get('abandoned_cart_reminder_mail')) { 
			$this->data['abandoned_cart_reminder_mail'] = $this->config->get('abandoned_cart_reminder_mail');
		} else {
			$this->data['abandoned_cart_reminder_mail'] = array();
		}
		
		$this->load->model('localisation/language');
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$this->data['front_base_url'] = defined('HTTPS_CATALOG')? HTTPS_CATALOG : HTTP_CATALOG;
		} else {
			$this->data['front_base_url'] = HTTP_CATALOG;
		}
		
		$this->data['token'] = $this->session->data['token'];
				
		$this->template = 'module/abandoned_cart_reminder.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/abandoned_cart_reminder')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		$dinamic_strlen = 'utf8_strlen';
		 
		if ( !function_exists('utf8_strlen') ) {
			$dinamic_strlen = 'strlen';
		}
		
		if ($dinamic_strlen($this->request->post['abandoned_cart_reminder_secret_code']) < 5) {
			$this->error['secret_code'] = $this->language->get('error_secret_code');
		}

		if ($dinamic_strlen($this->request->post['abandoned_cart_reminder_delay']) < 1) {
			$this->error['delay'] = $this->language->get('error_delay');
		}	

		if ($dinamic_strlen($this->request->post['abandoned_cart_reminder_max_reminders']) < 1) {
			$this->error['max_reminders'] = $this->language->get('error_max_reminders');
		}	
		
		if ($this->request->post['abandoned_cart_reminder_use_html_email'] == 1 && !$this->isHTMLEmailExtensionInstalled() ) {
			$this->error['use_html_email'] = $this->language->get('error_html_email_not_installed');
			$this->error['warning'] = $this->language->get('error_html_email_not_installed');
		}

		if ($this->request->post['abandoned_cart_reminder_add_coupon']){
			if ($dinamic_strlen($this->request->post['abandoned_cart_reminder_coupon_amount']) < 1) {
				$this->error['coupon_amount'] = $this->language->get('error_coupon_amount');
			}
			
			if ($dinamic_strlen($this->request->post['abandoned_cart_reminder_coupon_expire']) < 1) {
				$this->error['coupon_expire'] = $this->language->get('error_coupon_expire');
			}
		}
		
		foreach ($this->request->post['abandoned_cart_reminder_mail'] as $language_id => $value) {
			if ($dinamic_strlen($value['subject']) < 1) {
        		$this->error['subject'][$language_id] = $this->language->get('error_subject');
      		}
			
			if ($dinamic_strlen($value['message_reward']) < 1) {
        		$this->error['message_reward'][$language_id] = $this->language->get('error_message');
      		}
			
			if ($dinamic_strlen($value['message_no_reward']) < 1) {
        		$this->error['message_no_reward'][$language_id] = $this->language->get('error_message');
      		}
		}		
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
	
	private function isHTMLEmailExtensionInstalled() {
		$installed = false;
		
		if ($this->config->get('html_email_default_word') && file_exists(DIR_APPLICATION . 'model/tool/html_email.php') && file_exists(DIR_CATALOG . 'model/tool/html_email.php')) {
			$installed = true;	
		}
		
		return $installed;
	}
	
	public function getAbandonedCarts() {
	    $this->load->language('module/abandoned_cart_reminder');
		
		$this->load->model('module/abandoned_cart_reminder');
		$this->load->model('catalog/product');
		
		$this->data['column_customer']     = $this->language->get('column_customer');
		$this->data['column_cart_content'] = $this->language->get('column_cart_content');
		$this->data['column_last_visit']   = $this->language->get('column_last_visit');
		$this->data['column_reminder_sent']= $this->language->get('column_reminder_sent');
		$this->data['column_reward_sent']  = $this->language->get('column_reward_sent');
		$this->data['column_action']  = $this->language->get('column_action');
		
		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_send_all'] = $this->language->get('text_send_all');
		
		$this->data['button_preview'] = $this->language->get('button_preview');
		$this->data['button_send'] = $this->language->get('button_send');
		$this->data['button_send_all'] = $this->language->get('button_send_all');
		
		$this->data['reminders'] = array();
		
		$reminders = $this->filterCustomers($this->model_module_abandoned_cart_reminder->getCustomersForReminder());
		
		if ($reminders) {
			foreach ($reminders as $reminder) {
				$this->data['reminders'][] = array(
					'customer_id'   => $reminder['customer_id'],
					'firstname'     => $reminder['firstname'],
					'lastname'      => $reminder['lastname'],
					'email'         => $reminder['email'],
					'telephone'     => $reminder['telephone'],
					'cart_products' => $this->getCartProducts($reminder['cart']), 
					'last_action'   => $reminder['date_last_action'],
					'reminder_sent' => $reminder['number_reminder_sent'],
					'reward_sent'   => $reminder['number_reward_sent']
				);
			}
		}
		
		$this->template = 'module/abandoned_cart_list.tpl';		

		$this->response->setOutput($this->render());
	}
	
	public function getRemindersHistory() {
		$this->load->language('module/abandoned_cart_reminder');
		
		$this->load->model('module/abandoned_cart_reminder');
		$this->load->model('catalog/product');

		if (isset($this->request->get['filter_customer'])) {
			$filter_customer = $this->request->get['filter_customer'];
		} else {
			$filter_customer = null;
		}
		
		if (isset($this->request->get['filter_coupon_code'])) {
			$filter_coupon_code = $this->request->get['filter_coupon_code'];
		} else {
			$filter_coupon_code = null;
		}

		if (isset($this->request->get['filter_date_added'])) {
			$filter_date_added = $this->request->get['filter_date_added'];
		} else {
			$filter_date_added = null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'ah.acr_history_id';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_coupon_code'])) {
			$url .= '&filter_coupon_code=' . urlencode(html_entity_decode($this->request->get['filter_coupon_code'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
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
		
		$this->data['reminders'] = array();
		
		$data = array(
			'filter_customer'	     => $filter_customer,
			'filter_coupon_code'	 => $filter_coupon_code,
			'filter_date_added'      => $filter_date_added,
			'sort'                   => $sort,
			'order'                  => $order,
			'start'                  => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'                  => $this->config->get('config_admin_limit')
		);
		
		$reminder_total = $this->model_module_abandoned_cart_reminder->getTotalHistories($data);
		
		$reminders = $this->model_module_abandoned_cart_reminder->getHistories($data);
		
		if ($reminders) {
			foreach ($reminders as $reminder) {
				$this->data['reminders'][] = array(
					'acr_history_id'=> $reminder['acr_history_id'],
					'customer_id'   => $reminder['customer_id'],
					'customer_name' => $reminder['customer_name'],
					'coupon_code'   => $reminder['coupon_code'],
					//'coupon_link'   => $this->url->link('sale/coupon/update', 'coupon_id=' . $reminder['coupon_id'] . '&token=' . $this->session->data['token'], 'SSL'),
					'coupon_used'   => ($reminder['coupon_used'] == 1)? $this->language->get('text_yes') : $this->language->get('text_no'),
					'date_sent'     => $reminder['date_added']
				);
			}
		}
		
		$this->data['column_customer']     = $this->language->get('column_customer');
		$this->data['column_coupon_code']  = $this->language->get('column_coupon_code');
		$this->data['column_coupon_used']  = $this->language->get('column_coupon_used');
		$this->data['column_email']        = $this->language->get('column_email');
		$this->data['column_date_sent']    = $this->language->get('column_date_sent');
		$this->data['column_action']       = $this->language->get('column_action');
		
		$this->data['text_no_results'] = $this->language->get('text_no_results');
		
		$this->data['button_view_reminder'] = $this->language->get('button_view_reminder');
		$this->data['button_filter']        = $this->language->get('button_filter');
		
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

		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_coupon_code'])) {
			$url .= '&filter_coupon_code=' . urlencode(html_entity_decode($this->request->get['filter_coupon_code'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$pagination = new Pagination();
		$pagination->total = $reminder_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('module/abandoned_cart_reminder/getRemindersHistory', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['filter_customer'] = $filter_customer;
		$this->data['filter_coupon_code'] = $filter_coupon_code;
		$this->data['filter_date_added'] = $filter_date_added;
		
		$this->template = 'module/abandoned_cart_history.tpl';		

		$this->response->setOutput($this->render());
	}
	
	public function getReminderEmail() {	
		$this->load->model('module/abandoned_cart_reminder');
	
		$json = array();
		
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
		
			$reminder_info = $this->model_module_abandoned_cart_reminder->getHistory($this->request->post['acr_history_id']);
			
			if ($reminder_info) {
				$json['customer_name']     = $reminder_info['firstname'] . ' ' . $reminder_info['lastname'];
				$json['date_added']        = $reminder_info['date_added'];
				$json['email_description'] = html_entity_decode($reminder_info['email_description'], ENT_QUOTES, 'UTF-8'); 
			}
		}
		
		$this->response->setOutput(json_encode($json));
	}
	
	public function getTotalRecovered() {	
		$this->load->language('module/abandoned_cart_reminder');
		$this->load->model('module/abandoned_cart_reminder');
	
		$json = array();
		
		$total_recovered = $this->model_module_abandoned_cart_reminder->getTotalRecovered();
		
		if ((int)$total_recovered > 0) {
			$json['total_recovered'] = sprintf($this->language->get('text_total_recovered'), $this->currency->format($total_recovered));
		}	
		
		$this->response->setOutput(json_encode($json));
	}
	
	private function getCartProducts($customer_cart){
		$this->load->model('tool/image');
		
		$cart_products = array();
		
		if ($customer_cart && is_string($customer_cart)) {
			$cart = unserialize($customer_cart);
			
			foreach ($cart as $key => $value) {
				$product = explode(':', $key);
				$product_id = $product[0];
	
				// Options
				if (isset($product[1])) {
					$options = unserialize(base64_decode($product[1]));
				} else {
					$options = array();
				} 
				
				$product_info = $this->model_catalog_product->getProduct($product_id);
				
				if ($product_info){ 
					if ($product_info['image']) {
						$image = $this->model_tool_image->resize($product_info['image'], 30,30);
					} else {
						$image = $this->model_tool_image->resize('no_image.jpg', 30,30);
					}
				
					$option_data = array();

					if ($options) {
						foreach ($options as $product_option_id => $option_value) {
							$option_query = $this->db->query("SELECT po.product_option_id, po.option_id, od.name, o.type FROM " . DB_PREFIX . "product_option po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) WHERE po.product_option_id = '" . (int)$product_option_id . "' AND po.product_id = '" . (int)$product_id . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "'");

							if ($option_query->num_rows) {
								if ($option_query->row['type'] == 'select' || $option_query->row['type'] == 'radio' || $option_query->row['type'] == 'image') {
									$option_value_query = $this->db->query("SELECT pov.option_value_id, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_option_value_id = '" . (int)$option_value . "' AND pov.product_option_id = '" . (int)$product_option_id . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

									if ($option_value_query->num_rows) {

										$option_data[] = array(
											'name'                    => $option_query->row['name'],
											'option_value'            => $option_value_query->row['name']
										);								
									}
								} elseif ($option_query->row['type'] == 'checkbox' && is_array($option_value)) {
									foreach ($option_value as $product_option_value_id) {
										$option_value_query = $this->db->query("SELECT pov.option_value_id, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_option_value_id = '" . (int)$product_option_value_id . "' AND pov.product_option_id = '" . (int)$product_option_id . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

										if ($option_value_query->num_rows) {

											$option_data[] = array(
												'name'                    => $option_query->row['name'],
												'option_value'            => $option_value_query->row['name']
											);								
										}
									}						
								} elseif ($option_query->row['type'] == 'text' || $option_query->row['type'] == 'textarea' || $option_query->row['type'] == 'file' || $option_query->row['type'] == 'date' || $option_query->row['type'] == 'datetime' || $option_query->row['type'] == 'time') {
									$option_data[] = array(
										'name'                    => $option_query->row['name'],
										'option_value'            => $option_value
									);						
								}
							}
						}
					}	
				
					$cart_products[] = array( 
						'name'     => $product_info['name'],
						'image'    => $image,
						'quantity' => $value,
						'options'  => $option_data,
						'href'  => $this->url->link('product/product', 'product_id=' . $product_info['product_id'], 'SSL')
					);
				}
			}			
		}
		
		return $cart_products;
	}	
	
	private function hasActiveProducts($customer_info) {
		$active_products = 0;
		
		if ($customer_info['cart'] && is_string($customer_info['cart'])) {
			$cart = unserialize($customer_info['cart']);
			
			foreach ($cart as $key => $value) {
				$product = explode(':', $key);
				$product_id = $product[0];
				
				$product_info = $this->model_catalog_product->getProduct($product_id);
				
				if ($product_info){ 
					if ($this->config->get('abandoned_cart_reminder_hide_out_stock')) {
						if ($product_info['quantity'] > 0) {
							$active_products++;
						}
					} else {
						$active_products++;
					}	
				}
			}			
		}
		
		return $active_products;
	}
	
	private function isPreviousOrder($customer_info) {
		$is_previous_order = false;
		
		$last_order_id = $this->model_module_abandoned_cart_reminder->getLastOrderId($customer_info['customer_id']);
		
		if ($last_order_id) {
			$last_order_products = $this->model_module_abandoned_cart_reminder->getLastOrderProducts($last_order_id);
		
			if ($customer_info['cart'] && is_string($customer_info['cart'])) {
				$cart = unserialize($customer_info['cart']);
				
				if ($this->hasSameProducts($cart, $last_order_products)) {
					$is_previous_order = true;
				}				
			}
		}
	
		return $is_previous_order;
	}
	
	private function hasSameProducts($cart, $last_order_products) {
		$same_products = true;  
		
		if (count($cart) != count($last_order_products)) {
			$same_products = false;
		} else {
		
			foreach ($cart as $key => $value) {
				$key_split = explode(":", $key);
				$product_id = $key_split[0];
				
				if (!in_array($product_id, $last_order_products)) {
					$same_products = false;
				}
			}	
		}
		
		return $same_products;
	}
	
	private function filterCustomers($customers) {
		$filtred_customers = array();
		
		if ($customers) {
			foreach($customers as $customer) {
				if ($this->hasActiveProducts($customer) && !$this->isPreviousOrder($customer)) {
					$filtred_customers[] = $customer; 
				}
			}			
		}
		
		return $filtred_customers;
	}
	
}
?>