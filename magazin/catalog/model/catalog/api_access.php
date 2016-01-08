<?php
class ModelCatalogApiAccess extends Model {

    /* Returneaza id-ul clientului dupa codul de securitate */
    public function getCustomerId( $customer_security_code )
    {
        $customer_id = 0;

        $query = $this->db->query("SELECT customer_id FROM api_customer_access WHERE customer_security_code = '".$customer_security_code."'");
        if( $query->num_rows!= 0 )
        {
            foreach( $query->rows as $result )
            {
                $customer_id = $result['customer_id'];
            }
        }

        return $customer_id;
    }

    /* Returneaza codul de securitate a clientului dupa customer_id */
    public function getCustomerSecurityCode( $customer_id )
    {
        $customer_security_code = '';

        $query = $this->db->query("SELECT customer_security_code FROM api_customer_access WHERE customer_id = '".$customer_id."'");
        if( $query->num_rows!= 0 )
        {
            foreach( $query->rows as $result )
            {
                $customer_security_code = $result['customer_security_code'];
            }
        }

        return $customer_security_code;
    }

}