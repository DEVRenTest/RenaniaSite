<?php
class ModelCatalogProductAxCode extends Model {
	public function editProductAxCode($data, $product_type) {

		if (isset($data)) {
			foreach ($data as $key => $value ) {
				$this->db->query("UPDATE ax_code SET ax_code = '" . $this->db->escape( $value ) . "' WHERE type = '" . $product_type . "' AND id='".$key."'");
			}
		}
	}
}
?>
