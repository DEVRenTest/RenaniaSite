<?php

class ModelAccountCustomerApiMessages extends Model
{

    public function addApiMessage( $data )
    {

        //$this->db->query("INSERT INTO " . DB_PREFIX . "address SET customer_id = '" . (int)$customer_id . "', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', company = '" . $this->db->escape($data['company']) . "', company_id = '" . $this->db->escape($data['company_id']) . "', banca = '" . $this->db->escape( isset($data['banca']) ? $data['banca'] : "") . "', iban = '" . $this->db->escape(isset($data['iban']) ? $data['iban'] : "") . "', tax_id = '" . $this->db->escape($data['tax_id']) . "', address_1 = '" . $this->db->escape($data['address_1']) . "', address_2 = '" . $this->db->escape($data['address_2']) . "', city = '" . $this->db->escape($data['city']) . "', postcode = '" . $this->db->escape($data['postcode']) . "', country_id = '" . (int)$data['country_id'] . "', zone_id = '" . (int)$data['zone_id'] . "'");
        $this->db->query(
          "INSERT INTO " . DB_PREFIX . "customer_api_messages
          SET customer_id = '" . (int)$data["customer_id"]
            . "', push_url = '" . $this->db->escape( $data['push_url'] )
            . "', message_sent = '" . $this->db->escape( $data['message_sent'] )
            . "', message_received = '" . $this->db->escape( $data['message_received'] )
            . "', insert_date = '" . date( "Y-m-d H:i:s" ) . "'"
        );

        $message_id = $this->db->getLastId();

        return $message_id;
    }

    public function getApiMessagesByCustomerId( $customerId )
    {
        $result = $this->db->query(
          "SELECT * FROM " . DB_PREFIX . "customer_api_messages
            WHERE customer_id = '" . ( int ) $customerId . "'
            ORDER BY insert_date DESC"
        );

        return $result->row;
    }
}