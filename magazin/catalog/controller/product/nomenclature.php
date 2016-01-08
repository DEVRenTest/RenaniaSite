<?php

class ControllerProductNomenclature extends Controller
{

    public function index()
    {
        // print out in to the CSV
        $cache_dir            = "/home/renania/public_html/magazin/produse_opencart/"; 
        // $cache_dir = "/var/www/vhosts/renania.ro/httpdocs/magazin/produse_opencart/";
        $cache_file = $cache_dir."ListaProduselorDePeSite.csv";
        $full = array( ); //acesta va fi array-ul de date   

        $out = fopen( $cache_file, 'w' );

        //create table headers
        $full = array(
            "COD SITE",
            "UPC SIE",
            "CULOARE SITE",
            "MARIME SITE",
            "CONFIGURATIE",
            "DENUMIRE SITE",
            "COD AX CONCATENAT",
        );
        fputcsv( $out, $full, "\t" );

        $prQuery = $this->db->query( "SELECT pr.product_id, pr_desc.name, pr.upc FROM oc_product pr 
                                      JOIN oc_product_description pr_desc ON (pr_desc.product_id = pr.product_id ) " );   //335   , WHERE pr.product_id=102;         
        if( $prQuery->num_rows > 0 )
        {
            // get option names and value names
            foreach( $prQuery->rows as $product )
            {
                // initializing array
                $CSVRow = array(
                    "product_id" => $product['product_id'],
                    "product_upc" => $product['upc'],
                    "Marimi" => array( ),
                    "Culori" => array( ),
                    "Configuratie" => array( ),
                    "Denumire" => $product['name'],
                    "code_ax" => "",
                    "type" => "1",
                    "Combinatii" => array( )
//                    ,"OptionsForAxCode" => array( )
                );
                $concatenated_code = '';

                // option query
                $optionQuery = $this->db->query( "SELECT pov.product_option_value_id as ov_id, pov.product_option_id as o_id, od.name as o_name, ovd.name as ov_name 
                                FROM oc_product_option_value AS pov
                                JOIN oc_option_value_description AS ovd ON ( ovd.option_value_id = pov.option_value_id )
                                JOIN oc_option_description AS od ON ( od.`option_id` = ovd.`option_id` )
                                WHERE pov.`product_id` = '".$product['product_id']."' ORDER BY  ov_id ASC ;" );

                // feching options
                if( $optionQuery->num_rows > 0 )
                {
                    foreach( $optionQuery->rows as $value )
                    {
                        $CSVRow[$value["o_name"]][$value["ov_id"]] = $value["ov_name"];
//                        $CSVRow["OptionsForAxCode"][][] = array(
//                            'product_option_id' => $value["o_id"],
//                            'product_option_value_id' => $value["ov_id"]
//                        );
                    }

                    // setting up type to 2
                    $CSVRow["type"] = 2;
                }


                // get option combinations
                $optioncombinationQuery = $this->db->query( "SELECT pocv.product_option_combination_id, ovd.name as ov_name, od.name as o_name FROM oc_product_option_combination_value pocv
                                JOIN oc_product_option_combination poc ON (poc.product_option_combination_id = pocv.product_option_combination_id)
                                JOIN oc_option_value_description AS ovd ON ( ovd.option_value_id = pocv.option_value_id )
                                JOIN oc_option_description AS od ON ( od.`option_id` = ovd.`option_id` )
                                WHERE poc.product_id='".$product['product_id']."' ORDER BY product_option_combination_id ASC;" );

                if( $optioncombinationQuery->num_rows > 0 )
                {
                    $product_option_combination_id = array( );
                    foreach( $optioncombinationQuery->rows as $key => $val )
                    {
                        $CSVRow["Combinatii"][$val["product_option_combination_id"]][$val["o_name"]] = $val["ov_name"];
                    }

                    // setting up type to 3
                    $CSVRow["type"] = 3;
                }

//                print_r( $CSVRow );
//                die();

                if( $CSVRow["type"] == 1 )//simple product
                {
                    // get ax codes
                    $concatenated_code = $this->getProductAxCode( $CSVRow["type"], $CSVRow['product_id'] );
                    
                    // put in csv
                    $full = array(
                        $CSVRow['product_id'],
                        $CSVRow['product_upc'],
                        '   ',
                        '   ',
                        '   ',
                        $CSVRow['Denumire'],
                        $concatenated_code,
                    );
                    
                    fputcsv( $out, $full, "\t" );
                }
                else if( $CSVRow["type"] == 2 )
                {
                    if (  !empty( $CSVRow["Marimi"] ) )
                    {
                        foreach( $CSVRow["Marimi"] as $key => $value )
                        {
                            // get ax codes
                            $concatenated_code = $this->getProductAxCode( $CSVRow["type"], $CSVRow['product_id'], '',  $key);//$CSVRow["OptionsForAxCode"][$key]
                
                            // put in csv
                            $full = array(
                                $CSVRow['product_id'],
                                $CSVRow['product_upc'],
                                '   ',
                                $value,
                                '   ',
                                $CSVRow['Denumire'],
                                $concatenated_code,
                            );
                            
                            fputcsv( $out, $full, "\t" );
                        }
                    }
                    
                    if (  !empty( $CSVRow["Culori"] ) )
                    {
                        foreach( $CSVRow["Culori"] as $key => $value )
                        {
                            // get ax codes
                            $concatenated_code = $this->getProductAxCode( $CSVRow["type"], $CSVRow['product_id'], '', $key);//$CSVRow["OptionsForAxCode"][$key]
                
                            // put in csv
                            $full = array(
                                $CSVRow['product_id'],
                                $CSVRow['product_upc'],
                                $value,
                                '   ',
                                '   ',
                                $CSVRow['Denumire'],
                                $concatenated_code,
                            );
                            
                            fputcsv( $out, $full, "\t" );
                        }
                    }
                    
                    if (  !empty( $CSVRow["Configuratie"] ) )
                    {
                        foreach( $CSVRow["Configuratie"] as $key => $value )
                        {
                            // get ax codes
                            $concatenated_code = $this->getProductAxCode( $CSVRow["type"], $CSVRow['product_id'], '', $key );//$CSVRow["OptionsForAxCode"][$key]
                
                            // put in csv
                            $full = array(
                                $CSVRow['product_id'],
                                $CSVRow['product_upc'],
                                '   ',
                                '   ',
                                $value,
                                $CSVRow['Denumire'],
                                $concatenated_code,
                            );
                            
                            fputcsv( $out, $full, "\t" );
                        }
                    }
                }
                else if( $CSVRow["type"] == 3 )
                {
                    foreach( $CSVRow["Combinatii"] as $key => $value )
                    {
                        // get ax codes
                        $concatenated_code = $this->getProductAxCode( $CSVRow["type"], $CSVRow['product_id'], '', $key );
                      
                        // put in csv
                        $full = array(
                            $CSVRow['product_id'],
                            $CSVRow['product_upc'],
                            $value['Culori'],
                            $value['Marimi'],
                            '   ',
                            $CSVRow['Denumire'],
                            $concatenated_code,
                        );
                        
                        if( !isset($value['Culori']) || !isset($value['Marimi']) )
                        {
                            print "product_id=".$CSVRow['product_id']."*** product_name=".$CSVRow['Denumire']."<br>";
                        }

                        fputcsv( $out, $full, "\t" );
                        
                    }
                }


            }//end foreach

            // erasing data from memory
            unset( $CSVRow );
        }// end if

        print "FINISH";
    }

    public function getProductAxCode( $type, $product_id, $option_data = array( ), $Id = 0 )
    {
        $sizeof_option = sizeof( $option_data );
        $concatenated_code = '';

        if( $type == 1 ) // product
        {
            $query = $this->db->query( "SELECT axc.ax_code as concatenated_code FROM ax_code axc WHERE axc.type= 1 AND axc.id = '".( int ) $product_id."' " );
            if( $query->num_rows > 0 )
            {
                $concatenated_code = $query->row['concatenated_code'];
            }
        }
        else if( $type == 2 ) // option
        {
            $query = $this->db->query( "SELECT axc.ax_code as concatenated_code FROM ax_code axc WHERE axc.type= 2 AND axc.id = '".( int ) $Id."' " );// $option_data[0]['product_option_value_id']
            if( $query->num_rows > 0 )
            {
                $concatenated_code = $query->row['concatenated_code'];
            }
        }
        else if( $type == 3 )  // option_combination
        {
            /*$sql = "SELECT poc.`product_option_combination_id` FROM `oc_product_option_combination` poc";
            $i = 0;

            foreach( $option_data as $option )
            {
                $sql .= " JOIN `oc_product_option_combination_value` self".$i." 
                           ON ( self".$i.".`product_option_combination_id` = poc.`product_option_combination_id` AND 
                           poc.`product_id` = '".( int ) $product_id."' AND self".$i.".`option_value_id` = '".$option['option_value_id']."')";
                $i++;
            }
            $query = $this->db->query( $sql );

            $ocId = 0;
            if( $query->num_rows )
            {
                foreach( $query->rows as $one_row )
                {
                    $query2 = $this->db->query( "SELECT COUNT(*) as nr_rows FROM oc_product_option_combination_value a 
                                                WHERE a.`product_option_combination_id` = '".( int ) $one_row['product_option_combination_id']."'" );

                    if( $query2->num_rows )
                    {
                        if( $query2->row['nr_rows'] == $sizeof_option )
                        {
                            $ocId = $one_row['product_option_combination_id'];

                            break;
                        }
                    }
                }*/

                $query3 = $this->db->query( "SELECT axc.ax_code as concatenated_code FROM ax_code axc WHERE axc.type= 3 AND axc.id = '".( int ) $Id."' " );
                if( $query3->num_rows > 0 )
                {
                    $concatenated_code = $query3->row['concatenated_code'];
                }
//            }
        }
        return $concatenated_code;
    }

}

?>