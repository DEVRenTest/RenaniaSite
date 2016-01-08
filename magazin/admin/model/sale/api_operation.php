<?php
class ModelSaleApiOperation extends Model {
    /* Returneaza operatiuniile active din tabelul api_operation a bazei de date */
    public function getActiveOperations()
    {
        $operations = array( );

        $query = $this->db->query( "SELECT * FROM api_operation WHERE active = 1" );
        if( $query->num_rows > 0 )
        {
            foreach( $query->rows as $result )
            {
                $operations[] = array(
                  'api_operation_id' => $result['api_operation_id'],
                  'name' => $result['name']
                );
            }
        }

        return $operations;
    }

}