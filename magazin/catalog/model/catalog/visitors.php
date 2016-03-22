<?php
class ModelCatalogVisitors extends Model {

	public function deleteVisitors(){

		$query = $this->db->query("DELETE FROM `" . DB_PREFIX . "visitor_counter` WHERE `date` < UNIX_TIMESTAMP() - 120");
	}

	public function addVisitors(){

		$query = $this->db->query("INSERT INTO `" . DB_PREFIX . "visitor_counter` SET url = MD5('" . $this->db->escape($_SERVER['REQUEST_URI']) . "'), session_id = '" . $this->db->escape(session_id()) . "', date = UNIX_TIMESTAMP() ON DUPLICATE KEY UPDATE `date`= UNIX_TIMESTAMP()"); 
	}

	public function getVisitors($hashed_url) {

		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "visitor_counter` WHERE url = '" . $this->db->escape($hashed_url) . "' AND session_id != '" . $this->db->escape(session_id()) . "' AND `date` > UNIX_TIMESTAMP() - 120");

		if ($query->num_rows) {
			return $query->num_rows;
		} else {
			return 0;
		}
	}
}
?>