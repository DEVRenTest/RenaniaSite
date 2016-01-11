<?php

class ModelCatalogAxStoc extends Model
{

    function getStoc( $concatenat )
    {
        $query = $this->db->query( "SELECT stoc FROM `_AX_STOC` WHERE `concatenat` ='".$concatenat."'" );
//        print  "SELECT stoc FROM `_AX_STOC` WHERE `concatenat` ='".$concatenat."'";
//        die();
        
        $stoc = 0;
//        print_r($query);
//        die();
        if( $query->num_rows > 0 )
        { 
            $stoc = $query->row['stoc'];
        }
        
//                print  "stoc".$stoc."'";
//        die();

        return $stoc;
    }

}

?>