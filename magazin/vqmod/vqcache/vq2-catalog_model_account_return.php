<?php
class ModelAccountReturn extends Model {
	public function addReturn($data) {			      	
		 for ($i = 0; $i < sizeof($data['products']); $i++) {
            $product_data = $this->db->query("SELECT `oc_product`.`product_id`, `oc_product_description`.`name` FROM `" . DB_PREFIX . "product`, `" . DB_PREFIX . "product_description` WHERE `oc_product`.`model` = '".$this->db->escape($data['products'][$i]['model'])."' AND `oc_product_description`.`product_id` = `oc_product`.`product_id` LIMIT 1");
            if(!isset($product_data->row['product_id'])) {
                $product_data->row['product_id'] = "";
            }
            if(!isset($product_data->row['name'])) {
                $product_data->row['name'] = "";
            }
            //$data['location'] = 'a';
            if(!isset($data['company_name'])) $data['company_name'] = '';
            if(!isset($data['location'])) $data['location'] = '';
            if(!isset($data['tax_id'])) $data['tax_id'] = '';

            $this->db->query("INSERT INTO `" . DB_PREFIX . "return` SET order_id = '" . (int)$data['order_id'] . "', product_id = '" . (int)$product_data->row['product_id'] . "', customer_id = '" . (int)$this->customer->getId() . "', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', company = '" . $this->db->escape($data['company_name']) . "', location = '" . $this->db->escape($data['location']) . "', tax_id = '" . $this->db->escape($data['tax_id']) . "', product = '" . $this->db->escape($product_data->row['name']) . "', model = '" . $this->db->escape($data['products'][$i]['model']) . "', color = '" . $this->db->escape($data['products'][$i]['color']) . "', size = '" . $this->db->escape($data['products'][$i]['size']) . "', quantity = '" . (int)$data['products'][$i]['quantity'] . "', opened = '" . (int)$data['products'][$i]['opened'] . "', configuration = '" . $this->db->escape($data['products'][$i]['config']) . "', return_reason_id = '" . (int)$data['products'][$i]['return_reason_id'] . "', return_status_id = '1', comment = '" . $this->db->escape($data['products'][$i]['comment']) . "', date_ordered = '" . $this->db->escape($data['date_ordered']) . "', date_added = NOW(), date_modified = NOW(), date_invoice = '" . $this->db->escape($data['date_invoice']) . "'");
        }
        return $this->db->getLastId();   
	}
	
	public function getReturn($return_id) {
		
        $query = $this->db->query("SELECT r.return_id, r.order_id, r.firstname, r.lastname, r.email, r.telephone, r.product, r.model, r.color, r.size, r.quantity, r.opened, r.configuration, (SELECT rr.name FROM " . DB_PREFIX . "return_reason rr WHERE rr.return_reason_id = r.return_reason_id AND rr.language_id = '" . (int)$this->config->get('config_language_id') . "') AS reason, (SELECT ra.name FROM " . DB_PREFIX . "return_action ra WHERE ra.return_action_id = r.return_action_id AND ra.language_id = '" . (int)$this->config->get('config_language_id') . "') AS action, (SELECT rs.name FROM " . DB_PREFIX . "return_status rs WHERE rs.return_status_id = r.return_status_id AND rs.language_id = '" . (int)$this->config->get('config_language_id') . "') AS status, r.comment, r.date_ordered, r.date_added, r.date_modified FROM `" . DB_PREFIX . "return` r WHERE return_id = '" . (int)$return_id . "' AND customer_id = '" . $this->customer->getId() . "'");
            
		
		return $query->row;
	}
	
	public function getReturns($start = 0, $limit = 20) {
		if ($start < 0) {
			$start = 0;
		}
		
		if ($limit < 1) {
			$limit = 20;
		}	
				
		$query = $this->db->query("SELECT r.return_id, r.order_id, r.firstname, r.lastname, rs.name as status, r.date_added FROM `" . DB_PREFIX . "return` r LEFT JOIN " . DB_PREFIX . "return_status rs ON (r.return_status_id = rs.return_status_id) WHERE r.customer_id = '" . $this->customer->getId() . "' AND rs.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY r.return_id DESC LIMIT " . (int)$start . "," . (int)$limit);
		
		return $query->rows;
	}
			
	public function getTotalReturns() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "return`WHERE customer_id = '" . $this->customer->getId() . "'");
		
		return $query->row['total'];
	}
	
	public function getReturnHistories($return_id) {
		$query = $this->db->query("SELECT rh.date_added, rs.name AS status, rh.comment, rh.notify FROM " . DB_PREFIX . "return_history rh LEFT JOIN " . DB_PREFIX . "return_status rs ON rh.return_status_id = rs.return_status_id WHERE rh.return_id = '" . (int)$return_id . "' AND rs.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY rh.date_added ASC");

		return $query->rows;
	}			
}
?>