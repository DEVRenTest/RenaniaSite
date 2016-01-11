<?php 
class ModelSettingSetting extends Model {
	public function getSetting($group, $store_id = 0) {
      
//    $query = $this->db->query("SELECT value  FROM `oc_setting` WHERE `group` LIKE '%quickcheckout%' ORDER BY `oc_setting`.`group` ASC ");
//
//    $array = unserialize( $query->row['value'] );
//    $array['step']['payment_address']['fields']['company_id']['sort_order'] = '9'; 
//    $array['step']['payment_address']['fields']['company']['sort_order'] = '10'; 
//    
//    $temp = serialize ( $array );
//    $this->db->query( "UPDATE `" . DB_PREFIX . "setting` SET `value` = '".$temp."'  WHERE `setting_id` = '3049'");
//    
//    print "ok";
//    die('from here');
                
        
		$data = array(); 		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE store_id = '" . (int)$store_id . "' AND `group` = '" . $this->db->escape($group) . "'");
    		
		foreach ($query->rows as $result) {
			if (!$result['serialized']) {
				$data[$result['key']] = $result['value'];
			} else {
				$data[$result['key']] = unserialize($result['value']);
			}
		}
    
//    if ( $_SERVER['REMOTE_ADDR'] == '188.26.23.46' )
//    {
//        print "group=".$group."<br>";
//        print "store_id=".$store_id."<br>";
//        //$store_id
//        print "SELECT * FROM " . DB_PREFIX . "setting WHERE store_id = '" . (int)$store_id . "' AND `group` = '" . $this->db->escape($group) . "'"."***************";
//        print_r( $data['quickcheckout_b2b'] );
//        die();
//    }

		return $data;
	}
}
?>