<?php

class ControllerProductUpdateStoc extends Controller
{

    public function index()
    {
        if (($_SERVER['SERVER_ADDR'] != $_SERVER['REMOTE_ADDR'])
            || (!isset($this->request->get['banana']) || !$this->config->get('config_encryption') || $this->request->get['banana'] != $this->config->get('config_encryption'))) {
            http_response_code(404);
            exit();
        }
        //die('alma');
        // $updating_stock_at_0 = 0;
        // if ( $updating_stock_at_0 == 0 )
        // {
        //     // updated product quantity at 0 in oc_product table
        //     $this->db->query( "UPDATE oc_product SET quantity = 666;" );

        //     // updated product quantity at 0 in oc_product_option_value table
        //     $this->db->query( "UPDATE oc_product_option_value SET quantity = 666;" );

        //     // updated product quantity at 0 in oc_product_option_value table
        //     $this->db->query( "UPDATE oc_product_option_combination SET stock = 666;" );

        //     $updating_stock_at_0++;
        // }
        $this->db->query("UPDATE " . DB_PREFIX . "product p LEFT JOIN (SELECT axc.id FROM _ax_stoc axs INNER JOIN ax_code axc ON axs.concatenat = axc.ax_code WHERE axc.type = '1') AS ax ON p.product_id = ax.id SET p.quantity = '0' WHERE ax.id IS NULL");
        $this->db->query("UPDATE " . DB_PREFIX . "product_option_value pov LEFT JOIN (SELECT axc.id FROM _ax_stoc axs INNER JOIN ax_code axc ON axs.concatenat = axc.ax_code WHERE axc.type = '2') AS ax ON pov.product_option_value_id = ax.id SET pov.quantity = '0' WHERE ax.id IS NULL");
        $this->db->query("UPDATE " . DB_PREFIX . "product_option_combination poc LEFT JOIN (SELECT axc.id FROM _ax_stoc axs INNER JOIN ax_code axc ON axs.concatenat = axc.ax_code WHERE axc.type = '3') AS ax ON poc.product_option_combination_id = ax.id SET poc.stock = '0' WHERE ax.id IS NULL");

        $query = $this->db->query( "SELECT * FROM _AX_STOC" );
        if( $query->num_rows > 0 )
        {
            foreach( $query->rows as $result )
            {
                $data_stoc[] = array(
                    'concatenat' => $result['concatenat'],
                    'stoc' => ( int ) $result['stoc'],
                    // 'stoc' => 8008135,
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