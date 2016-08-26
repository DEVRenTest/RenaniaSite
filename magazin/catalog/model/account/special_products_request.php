<?php 

class ModelAccountSpecialProductsRequest extends Model
{
	public function addSpecialProductsForm($data, $image) 
	{
		$this->db->query( "INSERT INTO " . DB_PREFIX . "special_products_request SET customer_id='".(int)$this->customer->getId()."', product_description = '".$this->db->escape( $data['product_description'] )."', quantity = '".(int)$data['quantity']."', unit = '".(int)$data['unit']."', initial_quantity = '".(int)$data['initial_quantity']."', initial_unit = '".(int)$data['initial_unit']."', total_value = '".(float)$data['total_value']."', target_price = '".(float)$data['target_price']."', target_unit = '".(int)$data['target_unit']."', product_category = '".$this->db->escape( $data['product_category'] )."', sales_arguments = '".$this->db->escape( $data['sales_arguments'] )."', manager_approval = '".(bool)$data['manager_approval']."', first_batch = '".$this->db->escape( $data['first_batch'] )."', second_batch = '".$this->db->escape( $data['second_batch'] )."', third_batch = '".$this->db->escape( $data['third_batch'] )."', fourth_batch = '".$this->db->escape( $data['fourth_batch'] )."', fifth_batch = '".$this->db->escape( $data['fifth_batch'] )."', sixth_batch = '".$this->db->escape( $data['sixth_batch'] )."',  alternative_products = '".$this->db->escape( $data['alternative_products'] )."', customer_feedback = '".$this->db->escape( $data['customer_feedback'] )."', provider_name = '".$this->db->escape( $data['provider_name'] )."', identified_circumstances = '".$this->db->escape( $data['identified_circumstances'] )."', other_informations = '".$this->db->escape( $data['other_informations'] )."', image = '" . $image . "' " );
	}

	public function getSpecialProductsForm($customer_id)
	{
		$query = $this->db->query( "SELECT * FROM " . DB_PREFIX . "special_products_request WHERE customer_id = '" . (int)$customer_id . "' ORDER BY id DESC LIMIT 1");
		return $query->rows;
	}
}

?>