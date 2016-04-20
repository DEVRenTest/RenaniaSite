<?php
class ControllerProductVisitors extends Controller {
	public function index() {
		$response = array();
		$this->load->model('catalog/visitors');

		if (isset($this->request->get['page_hash'])) {
	      	$response['viewcount'] = $this->model_catalog_visitors->getVisitors($this->request->get['page_hash']);
		} else {
			$response['error'] = 'No hash provided';
		}
		$this->response->setOutput(json_encode($response));		
	}
}
?>