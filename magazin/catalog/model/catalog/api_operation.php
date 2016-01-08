<?php
class ModelCatalogApiOperation extends Model {

    /* Returneaza datele obligatoriu (pt fisierele csv, xml) ale webservice-ului  */
    public function getMandatoryData( $webservice_name )
    {
        $mandatory_data = array();

        $query = $this->db->query("SELECT mandatory_data FROM api_operation WHERE webservice_name = '".$webservice_name."'");
        if( $query->num_rows!= 0 )
        {
            $mandatory_data = explode("#", $query->row['mandatory_data'] );
        }

        return $mandatory_data;
    }


}