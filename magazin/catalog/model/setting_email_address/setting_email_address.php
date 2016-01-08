<?php

class ModelSettingEmailAddressSettingEmailAddress extends Model
{
    public function getEmailAddress( $name )
    {
        $query = $this->db->query( "SELECT * FROM ".DB_PREFIX."setting_email_address_description WHERE name = '".$this->db->escape( $name ) ."'" );
        return $query->row;
    }
}

?>
