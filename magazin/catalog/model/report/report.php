<?php

class ModelReportReport extends Model
{
	public function addReportEntry($data) 
	{
		$this->db->query( "INSERT INTO " . DB_PREFIX . "report_entry SET customer_name = '".$this->db->escape( $data['customer_name'] )."', work_address = '".$this->db->escape( $data['work_address'] )."', CUI = '".(int)$data['CUI']."', product_code = '".$this->db->escape( $data['product_code'] )."', product_name = '".$this->db->escape( $data['product_name'] )."', buy_price = '".(float)$data['buy_price']."', net_sale_price = '".(float)$data['net_sale_price']."', product_quantity = '".(int)$data['product_quantity']."', sale_agent_name = '".$this->db->escape( $data['sale_agent_name'] )."', month = '".$this->db->escape( $data['month'] )."', date_added = NOW(), report_name = '".$this->db->escape( $data['report_name'] )."' " );
	}

	public function addReportEntries($entries, $report_id)
	{
		$values = array();
		$required = array('customer_name', 'work_address', 'CUI', 'product_code', 'product_name', 'buy_price', 'net_sale_price', 'product_quantity', 'sale_agent_name', 'month');
		foreach ($entries as $entry) {
            $sanitized = array(
            	(int)$report_id,
            	$this->db->escape($entry['customer_name']),
            	$this->db->escape($entry['work_address']),
            	$this->db->escape($entry['CUI']),
            	$this->db->escape($entry['product_code']),
            	$this->db->escape($entry['product_name']),
            	(float)$entry['buy_price'],
            	(float)$entry['net_sale_price'],
            	(int)$entry['product_quantity'],
            	$this->db->escape($entry['sale_agent_name']),
            	$this->db->escape($entry['month']),
            );
            $values[] = "('" . implode("', '", $sanitized) . "')";
		}
		if ($values) {
			$sql = "INSERT INTO `" . DB_PREFIX . "report_entry` (`report_id`, `customer_name`, `work_address`, `CUI`, `product_code`, `product_name`, `buy_price`, `net_sale_price`, `product_quantity`, `sale_agent_name`, `month`) VALUES ";
			$sql .= implode(', ', $values);
			$this->db->query($sql);
		}
	}

	public function addReport($name)
	{
		$this->db->query("INSERT INTO " . DB_PREFIX . "report SET customer_id='".(int)$this->customer->getId()."', name='".$this->db->escape($name)."', date_added=NOW() ");
		return $this->db->getLastId();
	}

	public function getTotalReports( $customer_id )
	{
		$query = $this->db->query( "SELECT COUNT(DISTINCT(report_id)) AS total FROM " . DB_PREFIX . "report WHERE customer_id = '".(int)$customer_id."'" );
		return $query->row['total'];
	}

	public function getReports($start = 0, $limit = 20, $customer_id)
	{
		if($start < 0) {
			$start = 0;
        }

        if ($limit < 1) {
            $limit = 1;
        }

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "report WHERE customer_id = '".(int)$customer_id."' ORDER BY date_added DESC LIMIT ".(int) $start.",".(int) $limit);
		return $query->rows;
	}

	public function getReportName($report_id)
	{
		$query = $this->db->query("SELECT name FROM " . DB_PREFIX . "report WHERE report_id = '".(int)$report_id."' ");
		return $query->row['name'];
	}

	public function getReportEntries($report_id, $customer_id = 0)
	{
		$sql = "SELECT report_entry_id, re.report_id, customer_name, work_address, CUI, product_code, product_name, round(buy_price,2) as buy_price, round(net_sale_price,2) as net_sale_price, product_quantity, sale_agent_name, month FROM " . DB_PREFIX . "report_entry re";

		if ($customer_id) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "report r ON re.report_id = r.report_id";
		}
		$sql .= " WHERE re.report_id = '".(int)$report_id."'";

		if ($customer_id) {
			$sql .= " AND r.customer_id = '".(int)$customer_id."'";
		}
		$sql .= " ORDER BY re.report_entry_id DESC";

		$query = $this->db->query($sql);

		return $query->rows;
	}
}

?>