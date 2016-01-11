<?php
class ModelLocalisationZone extends Model {
	public function getZone($zone_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone WHERE zone_id = '" . (int)$zone_id . "' AND status = '1'");
		
		return $query->row;
	}		
	
	public function getZonesByCountryId($country_id) {
		$zone_data = $this->cache->get('zone.' . (int)$country_id);
	
		if (!$zone_data) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone WHERE country_id = '" . (int)$country_id . "' AND status = '1' ORDER BY name");
	
			$zone_data = $query->rows;
			
			$this->cache->set('zone.' . (int)$country_id, $zone_data);
		}
	
		return $zone_data;
	}
  
  	private function changeRomanianCharacters($string) {
        
     $string = str_replace ("ș", "s", $string );  
     $string = str_replace ("Ș", "S", $string );  
     
     $string = str_replace ("ă", "a", $string );  
     $string = str_replace ("Ă", "A", $string );  
     
     $string = str_replace ("ț", "t", $string );  
     $string = str_replace ("Ț", "T", $string );  
     
     $string = str_replace ("â", "a", $string );  
     $string = str_replace ("Â", "A", $string );
     
     $string = str_replace (" ", "-", $string );

		return $string;
	}
  
  
  	public function getZoneId($zone_name) {
        
    $zone_id = '';    
    $zone_name = $this->changeRomanianCharacters($zone_name);
    
		$query = $this->db->query("SELECT zone_id FROM " . DB_PREFIX . "zone WHERE name = '" . $zone_name . "'");
    if( $query->row > 0 )
    {
        $zone_id = $query->row['zone_id'];
    }
    
		return $zone_id;
	}
  
  public function getZoneIdByCode( $zone_code ) {
        
    $zone_id = '';    
        
		$query = $this->db->query("SELECT zone_id FROM " . DB_PREFIX . "zone WHERE code = '" . $zone_code . "' AND country_id=175 ");    
    if( $query->row > 0 )
    {
        $zone_id = $query->row['zone_id'];
    }
    
		return $zone_id;
	}
  
}
?>