<?php
class ControllerJEditJEdit extends Controller {

	/**
	 * Generic Save function for all textboxes
	 */
  	public function jEditSaveText() {
		$this->updateDB();

		print $_POST['value'];
	}

	/**
	 * Save function for all "Enabled/Disabled" select boxes
	 */
  	public function jEditSaveStatus() {
		$this->updateDB();

		if ($_POST['value'] == 0) {
			print $this->language->get('text_disabled');
		} else {
			print $this->language->get('text_enabled');
		}
	}

	/**
	 * Save function for all "Yes/No" select boxes
	 */
  	public function jEditSaveYesNo() {
		$this->updateDB();

		if ($_POST['value'] == 0) {
			print $this->language->get('text_no');
		} else {
			print $this->language->get('text_yes');
		}
	}


	/**
	 * Generic db update function for all actual data. Uses the id element to grab all data
	 * key|clause|id|table|type
	 * ex. <span id="name|product_id|42|product_description|text">
	 * ex. <span id="status|product_id|42|product|select">
	 */
	private function updateDB() {

		// Explode all the details in order (id="table|key|clause|val")
		$info = explode('|', $_POST['id']);
		if (count($info) < 3 || $info[0] == '' || $info[1] == '' || $info[2] == '' || $info[3] == '') {
			print 'Incorrect parameter count (table|key|clause|val) ex. <span id="product|model|product_id|42">';
			return;
		}

		// Check if table has a language_id field or not
		$tbl = '`' . DB_PREFIX . $info[0] . '`';
		$col = 'language_id';
		$sql = "DESC $tbl $col";
		$query = $this->db->query($sql);
		if ($query->num_rows) { // use the current language id
			$query = "UPDATE `" . DB_PREFIX . $info[0] . "` SET `" . $info[1] . "` = '" . stripslashes($_POST['value']) . "' WHERE `" . $info[2] . "` = '" . $info[3] . "' AND language_id = '" . $this->config->get('config_language_id') . "'";
		} else {
			$query = "UPDATE `" . DB_PREFIX . $info[0] . "` SET `" . $info[1] . "` = '" . stripslashes($_POST['value']) . "' WHERE `" . $info[2] . "` = '" . $info[3] . "'";
		}

		$this->db->query($query);

		// Cache cleanup. Hack assumes first array item is the cache name
		$cache_name = explode('_', $info[0]);
		$this->cache->delete($cache_name[0]);

	}

	/**
	 * Load function for Order Status Select boxes
	 */
	public function jEditLoadOrderStatuses() {

		$this->load->model('localisation/order_status');

		$results = $this->model_localisation_order_status->getOrderStatuses();

		$data = array();

		foreach ($results as $result) {
			$data[] = array(
				$result['order_status_id'] => $result['name']
			);
		}

		$this->load->library('json');

		$output = Json::encode($data);

		// jeditable expects different json format so clean it up
		$output = str_replace(array('[',']','{','}'), '', $output);

		$output = ' {' . $output . '}';

		$this->response->setOutput($output);

	}

	/**
	 * Load function for Order Status Select boxes
	 */
	public function jEditSaveOrderStatuses() {

		$this->updateDB();

		$this->load->model('localisation/order_status');

		$results = $this->model_localisation_order_status->getOrderStatuses();

		$output = $_POST['value'];

		foreach ($results as $result) {
			if($result['order_status_id'] == $_POST['value']) {
				$output = $result['name'];
				break;
			}
		}

		$this->response->setOutput($output);

	}

	/**
	 * Load function for Countries Select boxes
	 */
	public function jEditLoadCountries() {

		$this->load->model('localisation/country');

		$results = $this->model_localisation_country->getCountries();

		$data = array();

		foreach ($results as $result) {
			$data[] = array(
				$result['country_id'] => $result['name']
			);
		}

		$this->load->library('json');

		$output = Json::encode($data);

		// jeditable expects different json format so clean it up
		$output = str_replace(array('[',']','{','}'), '', $output);

		$output = ' {' . $output . '}';

		$this->response->setOutput($output);

	}

	/**
	 * Load function for Customer Groups Select boxes
	 */
	public function jEditLoadCustomerGroups() {

		$this->load->model('sale/customer_group');

		$results = $this->model_sale_customer_group->getCustomerGroups();

		$data = array();

		foreach ($results as $result) {
			$data[] = array(
				$result['customer_group_id'] => $result['name']
			);
		}

		$this->load->library('json');

		$output = Json::encode($data);

		// jeditable expects different json format so clean it up
		$output = str_replace(array('[',']','{','}'), '', $output);

		$output = ' {' . $output . '}';

		$this->response->setOutput($output);

	}

	/**
	 * Save function for Customer Groups Select boxes
	 */
	public function jEditSaveCustomerGroups() {

		$this->updateDB();

		$this->load->model('sale/customer_group');

		$results = $this->model_sale_customer_group->getCustomerGroups();

		$output = $_POST['value'];

		foreach ($results as $result) {
			if($result['customer_group_id'] == $_POST['value']) {
				$output = $result['name'];
				break;
			}
		}

		$this->response->setOutput($output);

	}

}
?>
