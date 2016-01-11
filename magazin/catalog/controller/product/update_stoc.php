<?php

class ControllerProductUpdateStoc extends Controller
{

    public function index()
    {
        //die('alma');
        $updating_stock_at_0 = 0;
        if ( $updating_stock_at_0 == 0 )
        {
            // updated product quantity at 0 in oc_product table
            $this->db->query( "UPDATE oc_product SET quantity = 0;" );

            // updated product quantity at 0 in oc_product_option_value table
            $this->db->query( "UPDATE oc_product_option_value SET quantity = 0;" );

            // updated product quantity at 0 in oc_product_option_value table
            $this->db->query( "UPDATE oc_product_option_combination SET stock = 0;" );

            $updating_stock_at_0++;
        }

        $query = $this->db->query( "SELECT * FROM _AX_STOC" );
        if( $query->num_rows > 0 )
        {
            foreach( $query->rows as $result )
            {
                $data_stoc[] = array(
                    'concatenat' => $result['concatenat'],
                    'stoc' => ( int ) $result['stoc'],
                );
            }
        }

        foreach( $data_stoc as $data )
        {
            $query = $this->db->query( "SELECT * FROM ax_code WHERE ax_code = '".$data['concatenat']."'" );

            if( $query->num_rows > 0 )
            {
                //print "Codul concatenat ".$data['concatenat']."<br>";
                
                $type = $query->row['type'];
                $id = $query->row['id'];
                if( $type == 1 ) // simple product
                {
//                    print "SELECT * FROM oc_product WHERE product_id='".$id."';<br>";
//                    print "PRODUCT: UPDATE oc_product SET quantity='".$data['stoc']."' WHERE product_id='".$id."'; <br><br>";
                    $this->db->query( "UPDATE oc_product SET quantity='".$data['stoc']."' WHERE product_id='".$id."';" );
                }
                else if( $type == 2 ) // option
                {
//                    print "SELECT * FROM oc_product_option_value WHERE product_option_value_id='".$id."';<br>";
//                    print "PRODUCT_OPTION: UPDATE oc_product_option_value SET quantity = '".$data['stoc']."' WHERE product_option_value_id  = '".$id."';<br><br>";
                    $this->db->query( "UPDATE oc_product_option_value SET quantity = '".$data['stoc']."' WHERE product_option_value_id  = '".$id."';" );
                }
                else if( $type == 3 ) // option combination
                {
//                    print "SELECT * FROM oc_product_option_combination WHERE product_option_combination_id='".$id."';<br>";
//                    print "PRODUCT_OPTION_COMBINATION: UPDATE oc_product_option_combination SET quantity = '".$data['stoc']."' WHERE product_option_combination_id  = '".$id."';<br><br>";
                    $this->db->query( "UPDATE oc_product_option_combination SET stock = '".$data['stoc']."' WHERE product_option_combination_id  = '".$id."';" );// quantity = '".$data['stoc']."'
                }
            }
            else
            {
                //print "Codul concatenat ".$data['concatenat']." nu figureaza in tabeleul ax_code!<br>";
            }
        }
        
        print "OK";
        
    }

}

?>