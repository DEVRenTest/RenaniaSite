<?php

class ModelAccountCustomerAutoLogin extends Model
{

    public function getCustomerIdByHash( $login_hash )
    {
        $result = $this->db->query(
            "SELECT * FROM " . DB_PREFIX . "customer_auto_logins
            WHERE login_hash = '" . $this->db->escape( $login_hash ) . "'
            AND status = 1"
        );

        return $result->row;
    }

    public function setUpdateDateNow( $auto_login_id )
    {
        $this->db->query(
          "UPDATE " . DB_PREFIX . "customer_auto_logins
            SET last_login_date = '".date( "Y-m-d H:i:s" )."'
            WHERE user_auto_login_id = '".( int ) $auto_login_id."'
            LIMIT 1"
        );
    }
}