<?php
class ModelSaleApiCustomerOperation extends Model {
    /* Adauga operatiuniile alese pentru client */
	public function addCustomerOperation($customer_id, $operations )
    {
        // se sterge operatiuniile setate deja pt client
        $this->deleteCustomerOperations( $customer_id );

        // se insereaza noile operatiuni alese
        if ( sizeof($operations) > 0 )
        {
          foreach( $operations as $operation )
          {
              $this->db->query( "INSERT INTO api_customer_operation
                                SET customer_id = '" . $this->db->escape( $customer_id ) . "',
                                operation_id = '" . $this->db->escape( $operation ) . "'" );
          }
        }
	}

    /* Sterge operatiuniiile clientului */
    public function deleteCustomerOperations($customer_id)
    {
        $this->db->query("DELETE FROM api_customer_operation WHERE customer_id = '" . (int)$customer_id . "'");
    }

    /* Returneaza id-urile operatiunilor clientului*/
    public function getCustomerOperations($customer_id)
    {
        $operations_id = array();

        $query = $this->db->query("SELECT oao.name, oao.api_operation_id as api_operation_id FROM api_operation as oao
                                   JOIN api_customer_operation as oaco ON oaco.operation_id = oao.api_operation_id
                                   WHERE oaco.customer_id='". (int)$customer_id ."'");
        if( $query->num_rows!= 0 )
        {
            foreach( $query->rows as $result )
            {
                $operations_id[] = $result['api_operation_id'];
            }
        }

        return $operations_id;
    }
}