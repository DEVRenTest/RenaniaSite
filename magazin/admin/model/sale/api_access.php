<?php
class ModelSaleApiAccess extends Model {

    /* Adauga clientul in tabelul api_customer_access, cu un cod md5 */
    public function addCustomerApiAccess($customer_id, $customer_security_code)
    {
        if ( $this->getCustomerApiAccess($customer_id) == 0 )
        {
          $this->db->query( "INSERT INTO api_customer_access SET customer_id = '" . $this->db->escape( $customer_id ) . "',
          customer_security_code = '" . $this->db->escape( $customer_security_code ) . "'" );
        }
    }

    /* Verifica daca clientul are deja access la API */
    public function getCustomerApiAccess($customer_id)
    {
        $have_access = 0;

        $query = $this->db->query("SELECT api_access_id FROM api_customer_access
                                    WHERE customer_id = '" . (int)$customer_id . "'");
        if( $query->num_rows!= 0 )
        {
            $have_access = 1;
        }

        return $have_access;
    }

    /* Sterge clientul din tabelul  api_customer_access */
    public function deleteCustomerApiAccess($customer_id)
    {
       $this->db->query("DELETE FROM api_customer_access WHERE customer_id = '" . (int)$customer_id . "'");
    }

    /* Verifica daca avem client cu codul de securitate specificata */
/*    public function existCustomer( $customer_id )
    {
        $exist; = false;
        $query = $this->db->query("SELECT customer_id FROM " . DB_PREFIX . "oc_customer
                                   WHERE customer_id = '" . (int)$customer_id . "'");
        if ( $query->num_rows > 0 )
        {
            $exist; = true;
        }

        return $exists;
    }

    public function getCustomerId( $customer_security_code )
    {
        $customer_id = 0;

        $query = $this->db->query("SELECT customer_id FROM ".DB_PREFIX."api_customer_access WHERE customer_security_code = '".$customer_security_code."'");
        if( $query->num_rows!= 0 )
        {
            foreach( $query->rows as $result )
            {
                $customer_id = $result['customer_id'];
            }
        }

        return $customer_id;
    }*/

}