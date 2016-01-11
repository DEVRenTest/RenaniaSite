<?php

class ControllerProductPopulateAxCodeTable extends Controller
{

    public function index()
    {
        $dir = '/var/www/vhosts/renania.ro/httpdocs/magazin/';
        //$filename = 'mapare_coduri_simple.csv';
        //$filename = 'mapare_coduri_option.csv';
        $filename = 'mapare_coduri_optioncombination.csv';

        $filerow = array( );
        $filerow = @file( $dir.$filename );
        $size = sizeof( $filerow );

        for( $i = 1; $i < $size; $i++ )
        {
            $webdata = explode( ";", $filerow[$i] );
            //print_r( $webdata );

            if( $filename == 'mapare_coduri_simple.csv' )
            {
                $type = 1;

                // Cod AX concatenat; ID-site; UPC-site; name; categories; sku
                $concatenated_ax_code = trim( $webdata[0] );
                $product_id = ( int ) $webdata[1];
                $upc_site = trim( $webdata[2] );
                $product_name = trim( $webdata[3] );
                //    $category_id = (int)$webdata[4];
                //    $sku = $webdata[5];
                $id = $product_id;
            }
            else if( $filename == 'mapare_coduri_option.csv' )
            {
                $type = 2;

                // Cod AX concatenat; ID-site ;UPC-site; Denumire; OptionId; Marime
                $concatenated_ax_code = trim( $webdata[0] );
                $product_id = ( int ) $webdata[1];
                $upc_site = trim( $webdata[2] );
                $product_name = trim( $webdata[3] );

                $option_id = $webdata[4];
                $option_value = $webdata[5];

                $first_query = $this->db->query( "SELECT option_value_id FROM oc_option_value_description WHERE `option_id` = '".( int ) $option_id."' AND `name` = '".trim( $option_value )."' ;" );
                if( $first_query->num_rows > 0 )
                {
                    $option_value_id = $first_query->row['option_value_id'];

                    $query2 = $this->db->query( "SELECT product_option_value_id FROM `oc_product_option_value` WHERE `product_id` ='".$product_id."' AND `option_value_id` ='".$option_value_id."';" );
                    if( $query2->num_rows > 0 )
                    {
                        $product_option_value_id = $query2->row['product_option_value_id'];
                    }

                    $id = $product_option_value_id;
                }
            }
            else if( $filename == 'mapare_coduri_optioncombination.csv' )
            {
                $type = 3;

                // Cod AX concatenat; ID-site; UPC-site; Denumire; OptionId; Marime; OptionId; Culoare
                $concatenated_ax_code = $webdata[0];
                $product_id = ( int ) $webdata[1];
                $upc_site = trim( $webdata[2] );
                $product_name = trim( $webdata[3] );

                $option_id1 = $webdata[4];
                $option_value1 = trim($webdata[5]);

                $option_id2 = $webdata[6];
                $option_value2 = trim($webdata[7]);
                
                $option_value_id1 = 0; $option_value_id2 = 0;

                $query1 = $this->db->query( "SELECT option_value_id FROM oc_option_value_description WHERE `option_id` = '".( int ) $option_id1."' AND `name` = '".trim( $option_value1 )."' ;" );
                if( $query1->num_rows > 0 )
                {
                    $option_value_id1 = $query1->row['option_value_id'];
                }

                $query2 = $this->db->query( "SELECT option_value_id FROM oc_option_value_description WHERE `option_id` = '".( int ) $option_id2."' AND `name` = '".trim( $option_value2 )."' ;" );
                if( $query2->num_rows > 0 )
                {
                    $option_value_id2 = $query2->row['option_value_id'];
                }
                
//                if ( $option_value_id2 == 0 )
//                {
//                    print "a<br>";
//                }
                
//                if ($product_id == '439')
//                {
//                    print "SELECT option_value_id FROM oc_option_value_description WHERE `option_id` = '".( int ) $option_id2."' AND `name` = '".trim( $option_value2 )."' ;<br>";
//                    print "option_value_id1=".$option_value_id1."<br>";
//                    print "option_value_id2=".$option_value_id2."<br>";
//                    print "****************";
//                }

                $option_data = array( );
                $option_data[1]['option_value_id'] = $option_value_id1;
                $option_data[2]['option_value_id'] = $option_value_id2;
                

                $sql = "SELECT poc.`product_option_combination_id` FROM `oc_product_option_combination` poc";
                $j = 0;
                foreach( $option_data as $option )
                {
                    $sql .= " JOIN `oc_product_option_combination_value` self".$j." 
                           ON ( self".$j.".`product_option_combination_id` = poc.`product_option_combination_id` AND 
                           poc.`product_id` = '".( int ) $product_id."' AND self".$j.".`option_value_id` = '".$option['option_value_id']."')";
                    $j++;
                }
                
//                if ($product_id == '439')
//                {
//                    print "<br>sql=".$sql."<br>";
//                }

                
                $query3 = $this->db->query( $sql );
                $ocId = 0;
                if( $query3->num_rows )
                {
                    foreach( $query3->rows as $one_row )
                    {
                        $query4 = $this->db->query( "SELECT COUNT(*) as nr_rows FROM oc_product_option_combination_value a 
                                                WHERE a.`product_option_combination_id` = '".( int ) $one_row['product_option_combination_id']."'" );

                        if( $query4->num_rows )
                        {
                            if( $query4->row['nr_rows'] == sizeof( $option_data ) )
                            {
                                $ocId = $one_row['product_option_combination_id'];
                                break;
                            }
                        }
                    }
                }
                $id = $ocId;

            }

            $insert = "INSERT INTO ax_code SET type = '".$type."', ax_code = '".$concatenated_ax_code."', id = '".$id."', upc = '".$upc_site."', product_name = '".$product_name."';";
            //print $insert;
            $this->db->query( $insert );
        }

        die( 'Minden rendben!' );
    }

}

?>