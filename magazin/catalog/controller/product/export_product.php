<?php

class ControllerProductExportProduct extends Controller
{

    public function index()
    {
        // print out in to the CSV
        $cache_dir            = "/home/renania/public_html/magazin/produse_opencart/"; 
        //$cache_dir = "/var/www/vhosts/renania.ro/httpdocs/magazin/produse_opencart/15-02-24/";
        $cache_file = $cache_dir."ListaProduselor.csv";
        $full = array( ); //acesta va fi array-ul de date   

        $out = fopen( $cache_file, 'w' );

        //create table headers
        $full = array(
			"ITEMGROUPID",
            "ITEMID(upc)",
			"ITEMNAME",
            "Culori",
            "Marimi",
            "Configuratie",
            "DIMID",
            "CONCATENAT",
			"ITEMBARCODE",
			"EXTERNALITEMID",
			"UM STOC",
			"UM ACHIZITIE",
			"UM VANZARE",
			"MULTIPLEQTY",
			"LOWESTQTY",
			"LEADTIME",
			"STOPPED",
        );
        fputcsv( $out, $full, ";" );

        $prQuery = $this->db->query( "SELECT `cat`.`category_id`, `cat`.`name` AS ITEMGROUPID, `pr`.`product_id`, `pr`.`upc`, `pr_des`.`name`, `pr`.`minimum`
                                      FROM  `oc_category_description` AS `cat`,
                                            `oc_product_to_category` AS `pr_to_cat`,
                                            `oc_product_description` AS `pr_des`,
                                            `oc_product` AS `pr`
                                        WHERE `pr_to_cat`.`category_id` = `cat`.`category_id` AND
                                            `pr_des`.`product_id` = `pr_to_cat`.`product_id` AND
                                            `pr`.`product_id` = `pr_to_cat`.`product_id`    
                                            ORDER BY `cat`.`category_id` ASC
                                            ; " );   //335   , WHERE pr.product_id=102;         
        if( $prQuery->num_rows > 0 )
        {
            // get option names and value names
            foreach( $prQuery->rows as $product )
            {
                // initializing array
                $CSVRow = array(
					"ITEMGROUPID" => $product['ITEMGROUPID'],
                    
                    "ITEMID(upc)" => $product['upc'],
                    "ITEMNAME" => $product['name'],
                    "Culori" => array( ),
                    "Marimi" => array( ),
                    "Configuratie" => array( ),
                    "DIMID" => "",
					"CONCATENAT" => "",
					"ITEMBARCODE" => "",
					"EXTERNALITEMID" => "",
					"UM STOC" => "",
					"UM ACHIZITIE" => "",
					"UM VANZARE" => "",
					"MULTIPLEQTY" => "",
					"LOWESTQTY" => $product['minimum'],
					"LEADTIME" => "",
					"STOPPED" => "",
					"type" => "1",
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
                        $CSVRow["Configuratie"][$val["product_option_combination_id"]][$val["o_name"]] = $val["ov_name"];
                    }

                    // setting up type to 3
                    $CSVRow["type"] = 3;
                }

               // print_r( $CSVRow );
             //   die();

                if( $CSVRow["type"] == 1 )//simple product
                {
                    // get ax codes
                    $concatenated_code = $this->getProductAxCode( $CSVRow["type"], $product['product_id'] );
                    
                    // put in csv
                    $full = array(
						$CSVRow['ITEMGROUPID'],
                        $CSVRow['ITEMID(upc)'],
						$CSVRow['ITEMNAME'],
                        '   ', //Culori
                        '   ', //Marimi
                        '   ', //Configuratie
                        '   ', //DIMID
/*                        '   ', //DIMID*/
                        $concatenated_code
                    );
                    //print_r($full); print "<br>";
					fputcsv( $out, $full, ";" );
                }
                else if( $CSVRow["type"] == 2 )
                {
                    if (  !empty( $CSVRow["Marimi"] ) )
                    {
                        foreach( $CSVRow["Marimi"] as $key => $value )
                        {
                            // get ax codes
                            $concatenated_code = $this->getProductAxCode( $CSVRow["type"], $product['product_id'], '',  $key);//$CSVRow["OptionsForAxCode"][$key]
                
                            // put in csv
                            $full = array(
                                $CSVRow['ITEMGROUPID'],
								$CSVRow['ITEMID(upc)'],
								$CSVRow['ITEMNAME'],
                                '   ', //Culori
                                $value,
								'   ', //Configuratie
                                '   ', //DIMID
								$concatenated_code
                            );
                            
                            //print_r($full); print "<br>";
							fputcsv( $out, $full, ";" );
                        }
                    }
                    
                    if (  !empty( $CSVRow["Culori"] ) )
                    {
                        foreach( $CSVRow["Culori"] as $key => $value )
                        {
                            // get ax codes
                            $concatenated_code = $this->getProductAxCode( $CSVRow["type"], $product['product_id'], '', $key);//$CSVRow["OptionsForAxCode"][$key]
                
                            // put in csv
                            $full = array(
                                $CSVRow['ITEMGROUPID'],
								$CSVRow['ITEMID(upc)'],
								$CSVRow['ITEMNAME'],
                                $value, //Culori
                                '   ', //Marimi
								'   ', //Configuratie
                                '   ', //DIMID
								$concatenated_code
                            );
                            
                            //print_r($full); print "<br>";
							fputcsv( $out, $full, ";" );
                        }
                    }
                    
                    if (  !empty( $CSVRow["Configuratieuratie"] ) )
                    {
                        foreach( $CSVRow["Configuratieuratie"] as $key => $value )
                        {
                            // get ax codes
                            $concatenated_code = $this->getProductAxCode( $CSVRow["type"], $product['product_id'], '', $key );//$CSVRow["OptionsForAxCode"][$key]
                
                            // put in csv
                            $full = array(
                                $CSVRow['ITEMGROUPID'],
								$CSVRow['ITEMID(upc)'],
								$CSVRow['ITEMNAME'],
                                '	', //Culori
                                //'   ', Marimi
								$value,
                                '   ', //DIMID
								$concatenated_code
                            );
                            
                            //print_r($full); print "<br>";
							fputcsv( $out, $full, ";" );
                        }
                    }
                }
                else if( $CSVRow["type"] == 3 )
                {
                    foreach( $CSVRow["Configuratie"] as $key => $value )
                    {
						//print_r($value); print "111<br>";
                        // get ax codes
                        $concatenated_code = $this->getProductAxCode( $CSVRow["type"], $product['product_id'], '', $key );
                      
                        // put in csv
                        $full = array(
                            $CSVRow['ITEMGROUPID'],
							$CSVRow['ITEMID(upc)'],
							$CSVRow['ITEMNAME'],
                            isset($value['Culori']) ? $value['Culori'] : '	',
                            $value['Marimi'],
							'	',
                            '	', //DIMID
                            $concatenated_code
                        );
                        
                        if( !isset($value['Culori']) || !isset($value['Marimi']) )
                        {
                            //print "product_id=".$CSVRow['product_id']."*** product_name=".$CSVRow['Denumire']."<br>";
                        }

                        //print_r($full); print "<br>";
						fputcsv( $out, $full, ";" );
                        
                    }
                }


            }//end foreach

            // erasing data from memory
            unset( $CSVRow );
        }// end if

        print "Generarea fisierului s-a efectuat cu succes!<br>Pentru a vedea fisierul generat apasati <a href='https://magazin.renania.ro/produse_opencart/ListaProduselor.csv'>aici</a>";
    }

    public function getProductAxCode( $type, $product_id, $option_data = array( ), $Id = 0 )
    {

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
            $query = $this->db->query( "SELECT axc.ax_code as concatenated_code FROM ax_code axc WHERE axc.type= 2 AND axc.id = '".( int ) $Id."' " );
            if( $query->num_rows > 0 )
            {
                $concatenated_code = $query->row['concatenated_code'];
            }
        }
        else if( $type == 3 )  // option_combination
        {
                $query3 = $this->db->query( "SELECT axc.ax_code as concatenated_code FROM ax_code axc WHERE axc.type= 3 AND axc.id = '".( int ) $Id."' " );
                if( $query3->num_rows > 0 )
                {
                    $concatenated_code = $query3->row['concatenated_code'];
                }
        }
        return $concatenated_code;
    }

}

?>