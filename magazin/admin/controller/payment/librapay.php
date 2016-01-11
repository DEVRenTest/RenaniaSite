<?php
class ControllerPaymentLibrapay extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('payment/librapay');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('librapay', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_all_zones'] = $this->language->get('text_all_zones');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_authorization'] = $this->language->get('text_authorization');
		$this->data['text_sale'] = $this->language->get('text_sale');

		$this->data['entry_email'] = $this->language->get('entry_email');
		$this->data['entry_merchant'] = $this->language->get('entry_merchant');
		$this->data['entry_merchant_name'] = $this->language->get('entry_merchant_name');
		$this->data['entry_merchant_url'] = $this->language->get('entry_merchant_url');
		$this->data['entry_key'] = $this->language->get('entry_key');
		$this->data['entry_terminal'] = $this->language->get('entry_terminal');
		$this->data['entry_test'] = $this->language->get('entry_test');
		$this->data['entry_transaction'] = $this->language->get('entry_transaction');
		$this->data['entry_debug'] = $this->language->get('entry_debug');
		$this->data['entry_total'] = $this->language->get('entry_total');	
		$this->data['entry_canceled_reversal_status'] = $this->language->get('entry_canceled_reversal_status');
		$this->data['entry_completed_status'] = $this->language->get('entry_completed_status');
		$this->data['entry_denied_status'] = $this->language->get('entry_denied_status');
		$this->data['entry_expired_status'] = $this->language->get('entry_expired_status');
		$this->data['entry_failed_status'] = $this->language->get('entry_failed_status');
		$this->data['entry_pending_status'] = $this->language->get('entry_pending_status');
		$this->data['entry_processed_status'] = $this->language->get('entry_processed_status');
		$this->data['entry_refunded_status'] = $this->language->get('entry_refunded_status');
		$this->data['entry_reversed_status'] = $this->language->get('entry_reversed_status');
		$this->data['entry_voided_status'] = $this->language->get('entry_voided_status');
		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

 		if (isset($this->error['email'])) {
			$this->data['error_email'] = $this->error['email'];
		} else {
			$this->data['error_email'] = '';
		}

		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),      		
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_payment'),
			'href'      => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('payment/librapay', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

		$this->data['action'] = $this->url->link('payment/librapay', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['librapay_email'])) {
			$this->data['librapay_email'] = $this->request->post['librapay_email'];
		} else {
			$this->data['librapay_email'] = $this->config->get('librapay_email');
		}
		
		if (isset($this->request->post['librapay_merchant'])) {
			$this->data['librapay_merchant'] = $this->request->post['librapay_merchant'];
		} else {
			$this->data['librapay_merchant'] = $this->config->get('librapay_merchant'); 
		}
		
		if (isset($this->request->post['librapay_merchant_name'])) {
			$this->data['librapay_merchant_name'] = $this->request->post['librapay_merchant_name'];
		} else {
			$this->data['librapay_merchant_name'] = $this->config->get('librapay_merchant_name'); 
		}
		
		if (isset($this->request->post['librapay_merchant'])) {
			$this->data['librapay_merchant_url'] = $this->request->post['librapay_merchant_url'];
		} else {
			$this->data['librapay_merchant_url'] = $this->config->get('librapay_merchant_url'); 
		}
		
		if (isset($this->request->post['librapay_terminal'])) {
			$this->data['librapay_terminal'] = $this->request->post['librapay_terminal'];
		} else {
			$this->data['librapay_terminal'] = $this->config->get('librapay_terminal'); 
		}
		
		if (isset($this->request->post['librapay_key'])) {
			$this->data['librapay_key'] = $this->request->post['librapay_key'];
		} else {
			$this->data['librapay_key'] = $this->config->get('librapay_key'); 
		}

		if (isset($this->request->post['librapay_test'])) {
			$this->data['librapay_test'] = $this->request->post['librapay_test'];
		} else {
			$this->data['librapay_test'] = $this->config->get('librapay_test');
		}

		if (isset($this->request->post['librapay_transaction'])) {
			$this->data['librapay_transaction'] = $this->request->post['librapay_transaction'];
		} else {
			$this->data['librapay_transaction'] = $this->config->get('librapay_transaction');
		}

		if (isset($this->request->post['librapay_debug'])) {
			$this->data['librapay_debug'] = $this->request->post['librapay_debug'];
		} else {
			$this->data['librapay_debug'] = $this->config->get('librapay_debug');
		}
		
		if (isset($this->request->post['librapay_total'])) {
			$this->data['librapay_total'] = $this->request->post['librapay_total'];
		} else {
			$this->data['librapay_total'] = $this->config->get('librapay_total'); 
		} 

		if (isset($this->request->post['librapay_canceled_reversal_status_id'])) {
			$this->data['librapay_canceled_reversal_status_id'] = $this->request->post['librapay_canceled_reversal_status_id'];
		} else {
			$this->data['librapay_canceled_reversal_status_id'] = $this->config->get('librapay_canceled_reversal_status_id');
		}
		
		if (isset($this->request->post['librapay_completed_status_id'])) {
			$this->data['librapay_completed_status_id'] = $this->request->post['librapay_completed_status_id'];
		} else {
			$this->data['librapay_completed_status_id'] = $this->config->get('librapay_completed_status_id');
		}	
		
		if (isset($this->request->post['librapay_denied_status_id'])) {
			$this->data['librapay_denied_status_id'] = $this->request->post['librapay_denied_status_id'];
		} else {
			$this->data['librapay_denied_status_id'] = $this->config->get('librapay_denied_status_id');
		}
		
		if (isset($this->request->post['librapay_expired_status_id'])) {
			$this->data['librapay_expired_status_id'] = $this->request->post['librapay_expired_status_id'];
		} else {
			$this->data['librapay_expired_status_id'] = $this->config->get('librapay_expired_status_id');
		}
				
		if (isset($this->request->post['librapay_failed_status_id'])) {
			$this->data['librapay_failed_status_id'] = $this->request->post['librapay_failed_status_id'];
		} else {
			$this->data['librapay_failed_status_id'] = $this->config->get('librapay_failed_status_id');
		}	
								
		if (isset($this->request->post['librapay_pending_status_id'])) {
			$this->data['librapay_pending_status_id'] = $this->request->post['librapay_pending_status_id'];
		} else {
			$this->data['librapay_pending_status_id'] = $this->config->get('librapay_pending_status_id');
		}
									
		if (isset($this->request->post['librapay_processed_status_id'])) {
			$this->data['librapay_processed_status_id'] = $this->request->post['librapay_processed_status_id'];
		} else {
			$this->data['librapay_processed_status_id'] = $this->config->get('librapay_processed_status_id');
		}

		if (isset($this->request->post['librapay_refunded_status_id'])) {
			$this->data['librapay_refunded_status_id'] = $this->request->post['librapay_refunded_status_id'];
		} else {
			$this->data['librapay_refunded_status_id'] = $this->config->get('librapay_refunded_status_id');
		}

		if (isset($this->request->post['librapay_reversed_status_id'])) {
			$this->data['librapay_reversed_status_id'] = $this->request->post['librapay_reversed_status_id'];
		} else {
			$this->data['librapay_reversed_status_id'] = $this->config->get('librapay_reversed_status_id');
		}

		if (isset($this->request->post['librapay_voided_status_id'])) {
			$this->data['librapay_voided_status_id'] = $this->request->post['librapay_voided_status_id'];
		} else {
			$this->data['librapay_voided_status_id'] = $this->config->get('librapay_voided_status_id');
		}

		$this->load->model('localisation/order_status');

		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['librapay_geo_zone_id'])) {
			$this->data['librapay_geo_zone_id'] = $this->request->post['librapay_geo_zone_id'];
		} else {
			$this->data['librapay_geo_zone_id'] = $this->config->get('librapay_geo_zone_id');
		}

		$this->load->model('localisation/geo_zone');

		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['librapay_status'])) {
			$this->data['librapay_status'] = $this->request->post['librapay_status'];
		} else {
			$this->data['librapay_status'] = $this->config->get('librapay_status');
		}
		
		if (isset($this->request->post['librapay_sort_order'])) {
			$this->data['librapay_sort_order'] = $this->request->post['librapay_sort_order'];
		} else {
			$this->data['librapay_sort_order'] = $this->config->get('librapay_sort_order');
		}

		$this->template = 'payment/librapay.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'payment/librapay')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['librapay_email']) {
			$this->error['email'] = $this->language->get('error_email');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}
?>