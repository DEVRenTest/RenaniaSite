<?php

class ModelCatalogAxTranzit extends Model
{

    function getTransit( $codconcatenat )
    {
        $query = $this->db->query( "SELECT date_format(livrareconfirmata, '%d-%m-%Y') as livrareconfirmata FROM `_AX_TRANZIT` WHERE `codconcatenat` ='".$codconcatenat."'" );
        
        $livrareconfirmata = 0;

        if( $query->num_rows > 0 )
        { 
            $livrareconfirmata = $query->row['livrareconfirmata'];
        }

        return $livrareconfirmata;
    }

}

?>