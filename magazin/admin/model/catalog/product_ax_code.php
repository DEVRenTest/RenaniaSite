<?php
class ModelCatalogProductAxCode extends Model {
	public function editProductAxCode($data, $product_type, $upc, $product_name) {

		if (isset($data)) {
			foreach ($data as $key => $value ) {
				//die($key."<br>".$value."<br>".$upc."<br>".$product_name);
				$query = $this->db->query("SELECT * FROM `ax_code` WHERE type = " . $product_type . " AND id=".$key);
				if(!empty($query->num_rows)) {
					//die("1 SELECT * FROM `ax_code` WHERE type = " . $product_type . " AND id=".$key);
					$this->db->query("UPDATE ax_code SET ax_code = '" . $this->db->escape($value) . "' WHERE type = '" . $product_type . "' AND id='" . $key . "'");
				} else {
					//die('2');
					$this->db->query("INSERT INTO ax_code (type, ax_code, id, upc, product_name)
										VALUES('" . $product_type . "', '" . $this->db->escape($value) . "', '" . $key . "', '" . $upc . "', '" . $product_name . "')");
				}
			}
		}
	}
}
?>
