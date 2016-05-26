<?php
class ModelAccountCustomer extends Model {
	public function addCustomer($data) {
		if (isset($data['customer_group_id']) && is_array($this->config->get('config_customer_group_display')) && in_array($data['customer_group_id'], $this->config->get('config_customer_group_display'))) {
			$customer_group_id = $data['customer_group_id'];
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}
		
		$this->load->model('account/customer_group');
		
		$customer_group_info = $this->model_account_customer_group->getCustomerGroup($customer_group_id);
		
      	$this->db->query("INSERT INTO " . DB_PREFIX . "customer SET store_id = '" . (int)$this->config->get('config_store_id') . "', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . $this->db->escape($data['fax']) . "', salt = '" . $this->db->escape($salt = substr(md5(uniqid(rand(), true)), 0, 9)) . "', password = '" . $this->db->escape(sha1($salt . sha1($salt . sha1($data['password'])))) . "', newsletter = '" . (isset($data['newsletter']) ? (int)$data['newsletter'] : 0) . "', customer_group_id = '" . (int)$customer_group_id . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "', status = '1', approved = '" . (int)!$customer_group_info['approval'] . "', date_added = NOW(), permission = 'full' ");
      	
		$customer_id = $this->db->getLastId();
			
      	//$this->db->query("INSERT INTO " . DB_PREFIX . "address SET customer_id = '" . (int)$customer_id . "', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', company = '" . $this->db->escape($data['company']) . "', company_id = '" . $this->db->escape($data['company_id']) . "', banca = '" . $this->db->escape( isset($data['banca']) ? $data['banca'] : "") . "', iban = '" . $this->db->escape(isset($data['iban']) ? $data['iban'] : "") . "', tax_id = '" . $this->db->escape($data['tax_id']) . "', address_1 = '" . $this->db->escape($data['address_1']) . "', address_2 = '" . $this->db->escape($data['address_2']) . "', city = '" . $this->db->escape($data['city']) . "', postcode = '" . $this->db->escape($data['postcode']) . "', country_id = '" . (int)$data['country_id'] . "', zone_id = '" . (int)$data['zone_id'] . "'");
        $this->db->query("INSERT INTO " . DB_PREFIX . "address SET customer_id = '" . (int)$customer_id . "', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', company = '" . $this->db->escape($data['company_name']) . "', company_id = '" . $this->db->escape($data['CUI']) . "', tax_id = '" . $this->db->escape($data['CIF']) . "', address_1 = '" . $this->db->escape($data['address_1']) . "', address_2 = '" . $this->db->escape($data['address_2']) . "', city = '" . $this->db->escape($data['city']) . "', postcode = '" . $this->db->escape($data['postcode']) . "', country_id = '" . (int)$data['country_id'] . "', zone_id = '" . (int)$data['zone_id'] . "'");
		
		$address_id = $this->db->getLastId();

      	$this->db->query("UPDATE " . DB_PREFIX . "customer SET address_id = '" . (int)$address_id . "' WHERE customer_id = '" . (int)$customer_id . "'");
		
		$this->language->load('mail/customer');
		
		$subject = sprintf($this->language->get('text_subject'), $this->config->get('config_name'));
		
		$message = sprintf($this->language->get('text_welcome'), $this->config->get('config_name')) . "\n\n";
		
		if (!$customer_group_info['approval']) {
			$message .= $this->language->get('text_login') . "\n";
		} else {
			$message .= $this->language->get('text_approval') . "\n";
		}
		
		$message .= $this->url->link('account/login', '', 'SSL') . "\n\n";
		$message .= $this->language->get('text_services') . "\n\n";
		$message .= $this->language->get('text_thanks') . "\n";
		$message .= $this->config->get('config_name');
		
		$mail = new Mail();
		$mail->protocol = $this->config->get('config_mail_protocol');
		$mail->parameter = $this->config->get('config_mail_parameter');
		$mail->hostname = $this->config->get('config_smtp_host');
		$mail->username = $this->config->get('config_smtp_username');
		$mail->password = $this->config->get('config_smtp_password');
		$mail->port = $this->config->get('config_smtp_port');
		$mail->timeout = $this->config->get('config_smtp_timeout');				
		$mail->setTo($data['email']);
		$mail->setFrom($this->config->get('config_email'));
		$mail->setSender($this->config->get('config_name'));
		$mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
		$mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
		$mail->send();
		
		// Send to main admin email if new account email is enabled
		if ($this->config->get('config_account_mail')) {
			$message  = $this->language->get('text_signup') . "\n\n";
			$message .= $this->language->get('text_website') . ' ' . $this->config->get('config_name') . "\n";
			$message .= $this->language->get('text_firstname') . ' ' . $data['firstname'] . "\n";
			$message .= $this->language->get('text_lastname') . ' ' . $data['lastname'] . "\n";
			$message .= $this->language->get('text_customer_group') . ' ' . $customer_group_info['name'] . "\n";
			
			if ($data['company']) {
				$message .= $this->language->get('text_company') . ' '  . $data['company'] . "\n";
			}
			
			$message .= $this->language->get('text_email') . ' '  .  $data['email'] . "\n";
			$message .= $this->language->get('text_telephone') . ' ' . $data['telephone'] . "\n";
			
			$mail->setTo($this->config->get('config_email'));
			$mail->setSubject(html_entity_decode($this->language->get('text_new_customer'), ENT_QUOTES, 'UTF-8'));
			$mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
			$mail->send();
			
			// Send to additional alert emails if new account email is enabled
			$emails = explode(',', $this->config->get('config_alert_emails'));
			
			foreach ($emails as $email) {
				if (strlen($email) > 0 && preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $email)) {
					$mail->setTo($email);
					$mail->send();
				}
			}
		}
	}
	
	public function editCustomer($data) {
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . $this->db->escape($data['fax']) . "' WHERE customer_id = '" . (int)$this->customer->getId() . "'");
  }

	public function editPassword($email, $password) {
      	$this->db->query("UPDATE " . DB_PREFIX . "customer SET salt = '" . $this->db->escape($salt = substr(md5(uniqid(rand(), true)), 0, 9)) . "', password = '" . $this->db->escape(sha1($salt . sha1($salt . sha1($password)))) . "' WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");
	}

	public function editNewsletter($newsletter) {
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET newsletter = '" . (int)$newsletter . "' WHERE customer_id = '" . (int)$this->customer->getId() . "'");
	}
					
	public function getCustomer($customer_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int)$customer_id . "'");
		
		return $query->row;
	}
	
	public function getCustomerByEmail($email) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");
		
		return $query->row;
	}
		
	public function getCustomerByToken($token) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE token = '" . $this->db->escape($token) . "' AND token != ''");
		
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET token = ''");
		
		return $query->row;
	}
		
	public function getCustomers($data = array()) {
		$sql = "SELECT *, CONCAT(c.firstname, ' ', c.lastname) AS name, cg.name AS customer_group FROM " . DB_PREFIX . "customer c LEFT JOIN " . DB_PREFIX . "customer_group cg ON (c.customer_group_id = cg.customer_group_id) ";

		$implode = array();
		
		if (isset($data['filter_name']) && !is_null($data['filter_name'])) {
			$implode[] = "LCASE(CONCAT(c.firstname, ' ', c.lastname)) LIKE '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";
		}
		
		if (isset($data['filter_email']) && !is_null($data['filter_email'])) {
			$implode[] = "LCASE(c.email) = '" . $this->db->escape(utf8_strtolower($data['filter_email'])) . "'";
		}
		
		if (isset($data['filter_customer_group_id']) && !is_null($data['filter_customer_group_id'])) {
			$implode[] = "cg.customer_group_id = '" . $this->db->escape($data['filter_customer_group_id']) . "'";
		}	
		
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$implode[] = "c.status = '" . (int)$data['filter_status'] . "'";
		}	
		
		if (isset($data['filter_approved']) && !is_null($data['filter_approved'])) {
			$implode[] = "c.approved = '" . (int)$data['filter_approved'] . "'";
		}	
			
		if (isset($data['filter_ip']) && !is_null($data['filter_ip'])) {
			$implode[] = "c.customer_id IN (SELECT customer_id FROM " . DB_PREFIX . "customer_ip WHERE ip = '" . $this->db->escape($data['filter_ip']) . "')";
		}	
				
		if (isset($data['filter_date_added']) && !is_null($data['filter_date_added'])) {
			$implode[] = "DATE(c.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}
		
		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}
		
		$sort_data = array(
			'name',
			'c.email',
			'customer_group',
			'c.status',
			'c.ip',
			'c.date_added'
		);	
			
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY name";	
		}
			
		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}
		
		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}			

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}	
			
			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}		
		
		$query = $this->db->query($sql);
		
		return $query->rows;	
	}
		
	public function getTotalCustomersByEmail($email) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");
		
		return $query->row['total'];
	}
	
	public function getIps($customer_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "customer_ip` WHERE customer_id = '" . (int)$customer_id . "'");
		
		return $query->rows;
	}	
	
	public function isBanIp($ip) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "customer_ban_ip` WHERE ip = '" . $this->db->escape($ip) . "'");
		
		return $query->num_rows;
	}	
  
  
  public function getAgents($data = array()) {
		
    $sql = "SELECT c.customer_id as id, CONCAT(c.firstname, ' ', c.lastname) AS name FROM " . DB_PREFIX . "customer as c LEFT JOIN " . DB_PREFIX . "address as adr ON ( adr.customer_id = c.customer_id ) ";

		$implode = array();
		
		if (isset($data['ax_code']) && !is_null($data['ax_code'])) {
			$implode[] = "c.ax_code = '" . $this->db->escape($data['ax_code']) . "'";
		}
		
		if (isset($data['tax_id']) && !is_null($data['tax_id'])) {
			$implode[] = "adr.tax_id = '" . $this->db->escape($data['tax_id']) . "'";
		}
		
		if ($implode) 
    {
			$sql .= " WHERE " . implode(" OR ", $implode);
		}    
    
    $sql .=" GROUP BY id ORDER BY name ASC";
    
//    print $sql;
//    die();

		$query = $this->db->query($sql);
		
		return $query->rows;	
	}
  
  public function saveAgentModifiedData($data) 
  {
        $this->db->query("UPDATE " . DB_PREFIX . "customer SET firstname = '" . $this->db->escape($data['firstname']) . "', middlename = '" . $this->db->escape($data['middlename']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', identity_card_number = '" . $this->db->escape($data['identity_card_number']) . "', mobile_phone = '" . $this->db->escape($data['mobile_phone']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . $this->db->escape($data['fax']) . "', status = '" . $this->db->escape($data['status']) . "' WHERE customer_id = '" . (int)$data['id'] . "'");// email = '" . $this->db->escape($data['email']) . "',
	}
  
  
  public function returnDiscoutFromAxCustomerTable( $customer_ax_code ) 
  {
        $query = $this->db->query("SELECT procent_general FROM `_AX_CUSTOMERS` WHERE `accountnum` ='".$customer_ax_code."'");
        
        $discount = 0;

        if( $query->num_rows > 0 )
        {
            $discount = $query->row['procent_general'];
        }
                
        return $discount;
	}
  
  public function returnPaymentTermFromAxCustomerTable( $customer_ax_code ) 
  {
        $query = $this->db->query("SELECT zileplata FROM `B2B_client` WHERE `accountnum` ='".$customer_ax_code."'");
        
        $zileplata = 0;
        if( $query->num_rows > 0 )
        {
            $zileplata = $query->row['zileplata'];
        }
        
        return $zileplata;
	}  
  
  public function returnCreditLimitFromAxCustomerTable( $customer_ax_code ) 
  {
        $query = $this->db->query("SELECT creditmax FROM `B2B_client` WHERE `accountnum` ='".$customer_ax_code."'");
        
        $creditmax = 0;
        if( $query->num_rows > 0 )
        {
            $creditmax = $query->row['creditmax'];
        }
        
        return $creditmax;
	}  
  
  public function updateInvoiceEmail( $customer_ax_code, $invoice_email )
  {
      $this->db->query("UPDATE B2B_client SET emailforinvoice = '" . $invoice_email . "' WHERE accountnum = '" . $customer_ax_code . "'");
  }
  
  public function getInvoiceEmail( $customer_ax_code )
  {
      $query = $this->db->query("SELECT emailforinvoice FROM `B2B_client` WHERE `accountnum` ='".$customer_ax_code."'");
      $emailforinvoice = '';
        if( $query->num_rows > 0 )
        {
            $emailforinvoice = $query->row['emailforinvoice'];
        }
        
        return $emailforinvoice;
  }
  
  public function saveContactPersonInfo($data) {
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', mobile_phone = '" . $this->db->escape($data['mobile_phone']) . "' WHERE customer_id = '" . (int)$this->customer->getId() . "'");
  }

	public function exceedsBudget($customer_id)
	{
		$limit = $this->db->query("SELECT order_limit FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int)$customer_id . "'")->row['order_limit'];
		if ($limit == -1) {
			return false;
		}
		$total_spent = $this->db->query("SELECT COALESCE(SUM(total), 0) as total FROM " . DB_PREFIX . "order WHERE customer_id = '" . (int)$customer_id . "' AND DATE(date_added) = CURDATE()")->row['total'];
		if ($limit < $total_spent) {
			return true;
		} else {
			return false;
		}
	}

	public function getPendingOrders($ax_code) {
		if (!$ax_code) {
			return array();
		}
		$q = $this->db->query("SELECT o.*, os.name AS status FROM " . DB_PREFIX . "order o LEFT JOIN " . DB_PREFIX . "customer c ON o.customer_id = c.customer_id LEFT JOIN " . DB_PREFIX . "order_status os ON o.order_status_id = os.order_status_id WHERE c.ax_code = '" . $this->db->escape($ax_code) . "' AND o.order_status_id = '" . $this->config->get('config_unapproved_order_status_id') . "'");
		if ($q->num_rows) {
			return $q->rows;
		} else {
			return array();
		}
	}

	public function canManageOrder($order_id) {
		if (!$this->customer->getAxCode() || !$this->customer->getOrderLimit() || $this->customer->getOrderLimit() != -1) {
			return false;
		}
		$q = $this->db->query("SELECT o.order_status_id, c.ax_code FROM " . DB_PREFIX . "order o LEFT JOIN " . DB_PREFIX . "customer c ON o.customer_id = c.customer_id WHERE o.order_id = '" . (int)$order_id . "'");
		if ($q->num_rows && $q->row['ax_code'] == $this->customer->getAxCode() && $q->row['order_status_id'] == $this->config->get('config_unapproved_order_status_id')) {
			return true;
		} else {
			return false;
		}
	}

	public function setupLoginToken($customer_id, $url)
	{
		$hash = bin2hex(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM));
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "autologin WHERE token = '" . $hash . "'");
		if (!$query->num_rows) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "autologin SET customer_id = '" . (int)$customer_id . "', token = '" . $hash . "', url = '" . $this->db->escape($url) . "'");
			return $hash;
		} else {
			$this->setupLoginToken($customer_id);
		}
	}

	public function validateLoginToken($hashed_customer_id, $token, $expire_interval = 1800)
	{
		$now = time();
		$sql = "SELECT a.autologin_id, a.customer_id, a.url FROM " . DB_PREFIX . "autologin a LEFT JOIN " . DB_PREFIX . "customer c ON a.customer_id = c.customer_id WHERE MD5(a.customer_id) = '" . $this->db->escape($hashed_customer_id) . "' AND a.token = '" . $this->db->escape($token) . "' AND c.store_id = '" . (int)$this->config->get('config_store_id') . "'";
		if ($expire_interval) {
			$sql .= " AND " . ($now - (int)$expire_interval) . " < UNIX_TIMESTAMP(a.date_added)";
		}
		$query = $this->db->query($sql);
		if ($query->num_rows) {
			$this->db->query("DELETE FROM " . DB_PREFIX . "autologin WHERE autologin_id = '" . $query->row['autologin_id'] . "'");
			return $query->row;
		} else {
			return ['autologin_id' => 0, 'customer_id' => 0, 'url' => ''];
		}
	}

	public function getCustomerBySecretCode($code)
	{
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE secret_code = '" . $this->db->escape($code) . "'");
		if ($query->num_rows) {
			return $query->row;
		}
		return false;
	}
}
?>
