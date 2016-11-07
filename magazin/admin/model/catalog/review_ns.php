<?php
class ModelCatalogReviewns extends Model {
	public function addReview($data) { 
		
	$ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
	
		$this->db->query("INSERT INTO " . DB_PREFIX . "review SET 
			title = '" . $this->db->escape($data['title']) . "', 
			author = '" . $this->db->escape($data['author']) . "', 
			product_id = '" . $this->db->escape($data['product_id']) . "', 
			text = '" . $this->db->escape(strip_tags($data['text'])) . "', 
			rating = '" . (int)$data['rating'] . "', 
			status = '" . (int)$data['status'] . "', 
			date_added = NOW(), 
			bought = '1', 
			ip = '".$this->db->escape($ipaddress)."'");
	
		$this->cache->delete('product');
	}
	
	public function editReview($review_id, $data) {
		
		$ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
		
		
		$this->db->query("UPDATE " . DB_PREFIX . "review SET 
			title = '" . $this->db->escape($data['title']) . "', 
			author = '" . $this->db->escape($data['author']) . "', 
			product_id = '" . $this->db->escape($data['product_id']) . "', 
			text = '" . $this->db->escape(strip_tags($data['text'])) . "', 
			rating = '" . (int)$data['rating'] . "', 
			status = '" . (int)$data['status'] . "', 
			date_added = NOW(),
			bought = '".$this->db->escape($data['bought'])."', 
			ip = '".$ipaddress."'		
		WHERE review_id = '" . (int)$review_id . "'");
	
		$this->cache->delete('product');
	}
	
	public function deleteReview($review_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "review WHERE review_id = '" . (int)$review_id . "'");
		
		$this->cache->delete('product');
	}
	
	public function activareReview($review_id) {
		$this->db->query("UPDATE " . DB_PREFIX . "review SET status=1 WHERE review_id = '" . (int)$review_id . "'");
		
		$this->cache->delete('product');
	}
	
	public function getReview($review_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT pd.name FROM " . DB_PREFIX . "product_description pd WHERE pd.product_id = r.product_id AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS product,r.text FROM " . DB_PREFIX . "review r WHERE r.review_id = '" . (int)$review_id . "'");
		
		return $query->row;
	}

	public function getReviews($data = array()) {
		$sql = "SELECT r.review_id, pd.name, r.author,r.title, r.rating, r.status, r.date_added,r.bought,r.ip,r.text FROM " . DB_PREFIX . "review r LEFT JOIN " . DB_PREFIX . "product_description pd ON (r.product_id = pd.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";																																					  
		
		$sort_data = array(
			'pd.name',
			'r.author',
			'r.rating',
			'r.status',
			'r.date_added',
			'r.bought'
		);	
			
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY r.date_added";	
		}
			
		if (isset($data['order']) && ($data['order'] == 'ASC')) {
			$sql .= " ASC";
		} else {
			$sql .= " DESC";
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
	
	public function getTotalReviews() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "review");
		
		return $query->row['total'];
	}
	
	public function getTotalReviewsAwaitingApproval() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "review WHERE status = '0'");
		
		return $query->row['total'];
	}	
}
?>