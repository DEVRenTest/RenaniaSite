<?php
class Customer {
	private $customer_id;
	private $firstname;
	private $lastname;
	private $email;
	private $company_id;
	private $company_name;
	private $multiple_companies;
	private $telephone;
	private $fax;
	private $newsletter;
	private $customer_group_id;
	private $address_id;
	private $ax_code;  
	private $permission;
	private $order_limit;
  
  private $middlename; 
  private $identity_card_number;  
  private $mobile_phone;  
//	private $payment_term;  
	
  	public function __construct($registry) {
		$this->config = $registry->get('config');
		$this->db = $registry->get('db');
		$this->request = $registry->get('request');
		$this->session = $registry->get('session');
				
		if (isset($this->session->data['customer_id'])) { 
			$customer_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int)$this->session->data['customer_id'] . "' AND status = '1'");
			
			if ($customer_query->num_rows) {
				$this->companyData();
				$this->customer_id = $customer_query->row['customer_id'];
				$this->firstname = $customer_query->row['firstname'];
				$this->lastname = $customer_query->row['lastname'];
				$this->email = $customer_query->row['email'];
				$this->telephone = $customer_query->row['telephone'];
				$this->fax = $customer_query->row['fax'];
				$this->newsletter = $customer_query->row['newsletter'];
				$this->customer_group_id = $customer_query->row['customer_group_id'];
				$this->address_id = $customer_query->row['address_id'];
        $this->permission = $customer_query->row['permission'];
        $this->order_limit = $customer_query->row['order_limit'];
//        $this->payment_term = $customer_query->row['payment_term'];
							
        $this->db->query("UPDATE " . DB_PREFIX . "customer SET cart = '" . $this->db->escape(isset($this->session->data['cart']) ? serialize($this->session->data['cart']) : '') . "', wishlist = '" . $this->db->escape(isset($this->session->data['wishlist']) ? serialize($this->session->data['wishlist']) : '') . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "' WHERE customer_id = '" . (int)$this->customer_id . "'");
			
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer_ip WHERE customer_id = '" . (int)$this->session->data['customer_id'] . "' AND ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "'");
				
				if (!$query->num_rows) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "customer_ip SET customer_id = '" . (int)$this->session->data['customer_id'] . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "', date_added = NOW()");
				}
			} else {
				$this->logout();
			}
  		}
	}
		
  	public function login($email, $password, $override = false) {

		if ($override) {
			$customer_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer where LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "' AND status = '1'");
		} else {
			$customer_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "' AND (password = SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1('" . $this->db->escape($password) . "'))))) OR password = '" . $this->db->escape(md5($password)) . "') AND status = '1' AND approved = '1'");
		}
    		                   
		if ($customer_query->num_rows) {
			$this->session->data['customer_id'] = $customer_query->row['customer_id'];	
		    
			if ($customer_query->row['cart'] && is_string($customer_query->row['cart'])) {
				$cart = unserialize($customer_query->row['cart']);
				
				foreach ($cart as $key => $value) {
					$this->session->data['cart'][$key] = $value;
				}			
			}

			if ($customer_query->row['wishlist'] && is_string($customer_query->row['wishlist'])) {
				if (!isset($this->session->data['wishlist'])) {
					$this->session->data['wishlist'] = array();
				}
								
				$wishlist = unserialize($customer_query->row['wishlist']);
			
				foreach ($wishlist as $product_id) {
					if (!in_array($product_id, $this->session->data['wishlist'])) {
						$this->session->data['wishlist'][] = $product_id;
					}
				}			
			}
			$this->companyData();
			$this->customer_id = $customer_query->row['customer_id'];
			$this->firstname = $customer_query->row['firstname'];
			$this->lastname = $customer_query->row['lastname'];
			$this->email = $customer_query->row['email'];
			$this->telephone = $customer_query->row['telephone'];
			$this->fax = $customer_query->row['fax'];
			$this->newsletter = $customer_query->row['newsletter'];
			$this->customer_group_id = $customer_query->row['customer_group_id'];
			$this->address_id = $customer_query->row['address_id'];
      $this->permission = $customer_query->row['permission'];
//      $this->payment_term = $customer_query->row['payment_term'];
      
			$this->db->query("UPDATE " . DB_PREFIX . "customer SET ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "' WHERE customer_id = '" . (int)$this->customer_id . "'");
			            
	  		return true;
    	} else {
      		return false;
    	}
  	}
  	
	public function logout() {
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET cart = '" . $this->db->escape(isset($this->session->data['cart']) ? serialize($this->session->data['cart']) : '') . "', wishlist = '" . $this->db->escape(isset($this->session->data['wishlist']) ? serialize($this->session->data['wishlist']) : '') . "' WHERE customer_id = '" . (int)$this->customer_id . "'");
		
		unset($this->session->data['customer_id']);
		unset($this->session->data['remote_order_url']);
		unset($this->session->data['remote_cookie']);
		unset($this->session->data['company_id']);

		$this->customer_id = '';
		$this->firstname = '';
		$this->lastname = '';
		$this->company_id = 0;
		$this->company_name = '';
		$this->ax_code = '';
		$this->multiple_companies = false;
		$this->email = '';
		$this->telephone = '';
		$this->fax = '';
		$this->newsletter = '';
		$this->customer_group_id = '';
		$this->address_id = '';
    $this->permission = '';
//    $this->payment_term = '';
  	}
  
  	public function isLogged() {        
      $is_logged = NULL;

      if( !empty($this->customer_id) )
      {
            if ( in_array( $this->getCustomerGroupId(), array( 3,4 ) )  && !isset($this->session->data['login_auto_with_hash'] ) )
            {
                if( !empty( $this->session->data['login_validation_code_ok'] ) )
                {
                    // is logged as B2B client, with correct validation code
                    $is_logged = $this->customer_id;
                }
            }
            else 
            {
                // logged as normal client
                $is_logged = $this->customer_id;
            }
      }
    	return $is_logged;
  	}
    
    
     public function isLoggedB2BWithoutValidationCode() {        
      $is_logged = NULL;
      
      if( !empty($this->customer_id) )
      {
            // logged - normal - B2B user (without validation code )
            if ( in_array( $this->getCustomerGroupId(), array( 3,4 ) )  )  
            {
                    $is_logged = $this->customer_id;
            }
      }
    	return $is_logged;
  	}

  	public function getId() {
    	return $this->customer_id;
  	}
      
  	public function getFirstName() {
		return $this->firstname;
  	}
  
  	public function getLastName() {
		return $this->lastname;
  	}
  
  	public function getEmail() {
		return $this->email;
  	}
  
  	public function getTelephone() {
		return $this->telephone;
  	}
  
  	public function getFax() {
		return $this->fax;
  	}
	
  	public function getNewsletter() {
		return $this->newsletter;	
  	}

  	public function getCustomerGroupId() {
		return $this->customer_group_id;	
  	}
	
  	public function getAddressId() {
		return $this->address_id;	
  	}
    
    public function getAxCode() {
		return $this->ax_code;
  	}
    
    public function getPermission() {
        return $this->permission;
  	}

  	public function getOrderLimit() {
        return $this->order_limit;
  	}
    
//    public function getPaymentTerm() {
//        return $this->payment_term;
//  	}
	
  	public function getBalance() {
		$query = $this->db->query("SELECT SUM(amount) AS total FROM " . DB_PREFIX . "customer_transaction WHERE customer_id = '" . (int)$this->customer_id . "'");
	
		return $query->row['total'];
  	}	
		
  	public function getRewardPoints() {
		$query = $this->db->query("SELECT SUM(points) AS total FROM " . DB_PREFIX . "customer_reward WHERE customer_id = '" . (int)$this->customer_id . "'");
	
		return $query->row['total'];	
  	}	

	public function getCompanyId()
	{
		return $this->company_id;
	}

	public function getCompanyName()
	{
		return $this->company_name;
	}

	public function representsMultipleCompanies()
	{
		return $this->multiple_companies;
	}

	protected function companyData()
	{
		$companies = array();
		$company_query = $this->db->query(
			"SELECT c.* FROM " . DB_PREFIX . "customer_to_company ctc LEFT JOIN " . DB_PREFIX . "company c ON ctc.company_id = c.company_id
			WHERE ctc.customer_id = '" . (int)$this->session->data['customer_id'] . "'" 
		);
		foreach ($company_query->rows as $row) {
			$companies[$row['company_id']] = $row;
		}
		$this->multiple_companies = count($companies) > 1;
		if (!empty($companies)) {
			if (isset($this->session->data['company_id']) && array_key_exists($this->session->data['company_id'], $companies)) {
				$company = $companies[$this->session->data['company_id']];
			} else {
				$company = array_shift($companies);
			}
			$this->session->data['company_id'] = $company['company_id'];
			$this->company_id = $company['company_id'];
			$this->company_name = $company['name'];
			$this->ax_code = $company['ax_code'];
		} else {
			$this->company_id = 0;
			$this->company_name = '';
			$this->ax_code = '';
			unset($this->session->data['company_id']);
		}
	}
}
?>
