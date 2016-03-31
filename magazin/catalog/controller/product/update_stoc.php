<?php

class ControllerProductUpdateStoc extends Controller
{

    public function index()
    {
        $tables = array('product', 'product_option_value', 'product_option_combination');

        foreach ($tables as $table) {
            $show_create_table_query = $this->db->query("SHOW CREATE TABLE " . DB_PREFIX . $table)->row['Create Table'];
            $this->db->query(str_replace(DB_PREFIX . $table,  DB_PREFIX . $table . "_new", $show_create_table_query));
            $this->db->query("INSERT " . DB_PREFIX . $table . "_new SELECT * FROM " . DB_PREFIX . $table);
        }

        $this->db->query("UPDATE " . DB_PREFIX . "product_new SET quantity = 0");
        $this->db->query("UPDATE " . DB_PREFIX . "product_option_value_new SET quantity = 0");
        $this->db->query("UPDATE " . DB_PREFIX . "product_option_combination_new SET stock = 0");

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
                    $this->db->query( "UPDATE oc_product_new SET quantity='".$data['stoc']."' WHERE product_id='".$id."';" );
                }
                else if( $type == 2 ) // option
                {
//                    print "SELECT * FROM oc_product_option_value WHERE product_option_value_id='".$id."';<br>";
//                    print "PRODUCT_OPTION: UPDATE oc_product_option_value SET quantity = '".$data['stoc']."' WHERE product_option_value_id  = '".$id."';<br><br>";
                    $this->db->query( "UPDATE oc_product_option_value_new SET quantity = '".$data['stoc']."' WHERE product_option_value_id  = '".$id."';" );
                }
                else if( $type == 3 ) // option combination
                {
//                    print "SELECT * FROM oc_product_option_combination WHERE product_option_combination_id='".$id."';<br>";
//                    print "PRODUCT_OPTION_COMBINATION: UPDATE oc_product_option_combination SET quantity = '".$data['stoc']."' WHERE product_option_combination_id  = '".$id."';<br><br>";
                    $this->db->query( "UPDATE oc_product_option_combination_new SET stock = '".$data['stoc']."' WHERE product_option_combination_id  = '".$id."';" );// quantity = '".$data['stoc']."'
                }
            }
            else
            {
                //print "Codul concatenat ".$data['concatenat']." nu figureaza in tabeleul ax_code!<br>";
            }
        }
        foreach ($tables as $table) {
            $this->db->query("DROP TABLE IF EXISTS " . DB_PREFIX . $table);
            $this->db->query("RENAME TABLE " . DB_PREFIX . $table . "_new TO " . DB_PREFIX . $table);
        }
        print "OK";
        
    }

        public function secondsToTime($seconds) {
            $dtF = new DateTime("@0");
            $dtT = new DateTime("@$seconds");
            return $dtF->diff($dtT)->format('%a days, %h hours, %i minutes and %s seconds');
        }

}

?>