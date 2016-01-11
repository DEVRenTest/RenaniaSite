<?php
class ModelCatalogApiCustomerOperation extends Model {

    /* Returneaza numele controllerelor care sunt permise clientului*/
    public function getControllerNames($customer_id)
    {
        $webservice_names = array();

        $query = $this->db->query("SELECT oao.webservice_name as webservice_name FROM api_operation as oao
                                   JOIN api_customer_operation as oaco ON oaco.operation_id = oao.api_operation_id
                                   WHERE oaco.customer_id='". (int)$customer_id ."'");
        if( $query->num_rows!= 0 )
        {
            foreach( $query->rows as $result )
            {
                $webservice_names[] = $result['webservice_name'];
            }
        }

        return $webservice_names;
    }
}