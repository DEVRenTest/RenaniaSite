<?php

class ControllerProductCheckProductsAxdata extends Controller
{
    public function index()
    {
        $rows = $this->db->query("SELECT COUNT(*) AS `rows` FROM oc_product;")->row['rows'];

        $offset = 0;
        $error_count = 0;

        for ($page = 0; $offset < $rows; $page++) {

            if($page > 0) {
                $offset = (int)$page*1000;
            } else {
                $offset = 0;
            }

            //die($rows);

            $prQuery = "SELECT
                      pr.product_id,
                      pr.upc,
                      pr.model,
                      pd.`name`
                    FROM
                      `oc_product` `pr`,
                      `oc_product_description` `pd`
                      WHERE pd.product_id = pr.`product_id`
                    LIMIT 1000 OFFSET ".$offset." ;";
            //die('adfbdsgfb d '.$prQuery);
            $prQuery = $this->db->query($prQuery);   //335   , WHERE pr.product_id=102;

            /*echo "adgfbdsgb<br>";
            print_r($prQuery);
            die('adfbdfb');*/

            $this->load->model('catalog/product');
            $this->load->model('checkout/cart');

            if ($prQuery->num_rows > 0) {
                // get option names and value names
                foreach ($prQuery->rows as $pr_num => $product) {
                    $mainLog = "";

                    $type_by_option_0 = false;
                    $type_by_option_1 = false;
                    $type_by_option_2 = false;
                    $mainLog .= "<br>========================================================================================================";

                    $mainLog .= "<br>" . $pr_num . " <strong>Prdouct_ID</strong> " . $product['product_id'] . " <strong>UPC</strong> " . $product['upc'];

                    if (!sizeof($product['upc'])) {
                        $product['upc'] = $product['model'];
                    }

                    $product['option'] = $this->model_catalog_product->getProductOptions($product['product_id']);

                    /*if ($product['product_id'] == 114) {
                        echo "<pre>".sizeof($product['option']);
                        print_r($product['option']);
                        die('<br>stop here');
                    }*/

                    $mainLog .= "<br>";
                    //print_r($product['option']);

                    if (sizeof($product['option']) == 2) { // Option combination

                        $mainLog .= "<br>PRODUCT_TYPE 3 by option size 2 combination";

                        foreach ($product['option'][0]['option_value'] as $key => $option_one) {

                            foreach ($product['option'][1]['option_value'] as $key_two => $option_two) {

                                $option_data[0]['option_value_id'] = $option_one['option_value_id'];
                                $option_data[0]['option_id'] = $product['option'][0]['option_id'];
                                $option_data[0]['name'] = $option_one['name'];

                                $option_data[1]['option_value_id'] = $option_two['option_value_id'];
                                $option_data[1]['option_id'] = $product['option'][1]['option_id'];
                                $option_data[1]['name'] = $option_two['name'];

                                //echo "<pre> key ".$key." key_two ".$key_two;

                                //print_r($option_one);
                                //print_r($option_two);

                                //print_r($option_data);

                                //print_r($product['option']);

                                //die('asfbdfs');

                                $ax_code = $this->getProductAxCode(3, $product, $option_data, '', $product['option']);
                                if ($ax_code) {
                                    //echo "<br>GOT_IT_TYPE_3 ".$ax_code. "<br> ------------------------------------------------------------------";
                                } else {
                                    $mainLog .= "<br>3 ------------------------------------------------------------------";
                                    $error_count++;
                                }
                            }
                        }
                        //die(' sdvasfbdef');


                    } elseif (sizeof($product['option']) == 1) // Option
                    {

                        $mainLog .= "<br>PRODUCT_TYPE 2 by option size 1 -----------------------------------------------------------";

                        foreach ($product['option'][0]['option_value'] as $key => $option) {

                            $ax_code = $this->getProductAxCode(2, $product, '', $option, $product['option']);

                            if (sizeof($ax_code)) {
                                //echo "<br>GOT_IT_TYPE_2 ".$ax_code. "<br> ------------------------------------------------------------------";
                            } else {
                                $error_count++;
                            }
                        }

                    } elseif (sizeof($product['option']) < 1) // Simple product
                    {

                        $mainLog .= "<br>PRODUCT_TYPE 1 by option size 0 SIMPLE_product";

                        $ax_code = $this->getProductAxCode(1, $product, '', '', '');
                        if ($ax_code) {
                            //echo "<br>GOT_IT_TYPE_1 ".$ax_code;
                        } else {
                            $error_count++;
                        }
                    }
                }
            }// end if

            echo "<br>".$prQuery;
        }

        print "<br><br>FINISH ".$error_count." errors";
    }

    public function getProductAxCode( $type, $product, $option_data = array( ), $Id = 0, $mainOptionData = array() )
    {

        $concatenated_code = '';
        $log = "<br>========================================================================================================";
        $log .= "<br>IN FUNC <strong>Prdouct_ID</strong> ".$product['product_id']." <strong>UPC</strong> ".$product['upc'];
        $showLog = false;
        $showOption = false;
        $insert_ax_code_query = "";
        $add_history = "";

        if( $type == 1 ) // simple product
        {
            $query_one = "SELECT axc.ax_code as concatenated_code FROM ax_code axc WHERE axc.type= 1 AND axc.id = '".( int ) $product['product_id']."' ;";

            $result_one = $this->db->query( $query_one );
            if( $result_one->num_rows > 0 ) {
                //$log .= "<br>RETURN 1 query_one ".$query_one;
                $concatenated_code = $result_one->row['concatenated_code'];
            } else {
                $query_two = "SELECT axc.id_ax_code, axc.`type`, axc.ax_code as concatenated_code FROM ax_code axc WHERE axc.upc = '".( int ) $product['model']."' ;";
                //print('<br>query_two '.$query_two);
                $result_two = $this->db->query( $query_two );
                if( $result_two->num_rows == 1 ) {

                    //$log .= "RETURN query_two ".$query_two;
                    $concatenated_code = $result_one->row['concatenated_code'];
                    //$log .= "<br><strong>AX_CODE_1 </strong>".$concatenated_code." num rows: ".$result_two->num_rows;

                } else {

                    die('<br>Simple product query '.$query_two);

                    //$log .= "<br><strong>WRONG_DATA, simple product has more than one ax_code!</strong>";
                    $showLog = true;

                    foreach ($result_two->rows as $result) {
                        if ($result['type'] != 1){
                            $log .= "<br><strong>AX type not 1!</strong> id_ax_code: ".$result['id_ax_code'];

                            $insert_ax_code_query = "INSERT INTO ax_code SET
                                                `type` = '1',
                                                `ax_code` = '" . $product['model'] . "---',
                                                `id` = '".$product['product_id']."',
                                                `upc` = '".$product['model']."',
                                                `product_name` = '".$product['name']."';";

                            //$insert_ax_code = $this->db->query($insert_ax_code_query);

                            /*if ($insert_ax_code) {
                                $add_history = "INSERT INTO ax_code_correction SET `query` = '".$this->db->escape($insert_ax_code_query)."', added_at = NOW()";
                                $this->db->query($add_history);
                            }*/
                        }
                    }
                    $log .= "NOT_FOUND_1 ".$query_two;
                }
            }
        }
        else if( $type == 2 ) // option
        {
            $query_one = "SELECT axc.ax_code as concatenated_code FROM ax_code axc WHERE axc.type= 2 AND axc.id = '".( int ) $Id['product_option_value_id']."' ;";

            $result_one = $this->db->query( $query_one );

            if( $result_one->num_rows > 0 )
            {
                //$log .= "<br>RETURN 2 query_one ".$query_one;
                $concatenated_code = $result_one->row['concatenated_code'];
                //$log .= "<br><strong>AX_CODE_2 </strong>".$concatenated_code." num rows: ".$result_one->num_rows;
            }
            else
            {
                $query_two = "SELECT axc.ax_code as concatenated_code FROM ax_code axc WHERE axc.upc= '".$product['model']."' AND axc.id = '".( int ) $Id['product_option_value_id']."' ;";
                //print('<br>query_two '.$query_two);
                $result_two = $this->db->query( $query_two );

                if( $result_two->num_rows == 1 )
                {
                    //$log .= "RETURN query_two ".$query_two;
                    $concatenated_code = $result_two->row['concatenated_code'];
                    //$log .= "<br><strong>AX_CODE_2 </strong>".$concatenated_code." num rows: ".$result_two->num_rows;
                }
                else
                {
                    //die('<br>OPTION_PRODUCT '.$query_two);

                    if ($result_two->num_rows > 1) {
                        $log .= "<br><strong>WRONG_DATA, ax type 2 product has more than one ax_code!</strong>";
                        $showLog = true;

                        foreach ($result_two->rows as $result) {
                            if ($result['type'] != 1) {
                                $log .= "<br><strong>AX type not 1!</strong> id_ax_code: " . $result['id_ax_code'];
                            }
                        }
                    }
                    $log .= "<br>NOT_FOUND_2 ".$query_two;
                    $showLog = true;
                    $showOption = true;

                    $check_type_by_upc = "SELECT DISTINCT
                                              *
                                            FROM
                                              ax_code ax
                                            WHERE ax.`upc` = '".$product['model']."'
                                            GROUP BY ax.`type`;";
                    $check_type_by_upc = $this->db->query($check_type_by_upc);

                    if ($check_type_by_upc->num_rows > 0 && $check_type_by_upc->row['type'] != 2)
                    {
                        $log .= "<br><strong>WRONG_TYPE_2</strong> ".$check_type_by_upc->row['type']." should be 2 <strong>Prdouct_ID</strong> ".$product['product_id']." <strong>UPC</strong> ".$product['upc'];
                    }
                    if ($mainOptionData[0]['option_id'] == '1') {
                        $insert_ax_code_query = "INSERT INTO ax_code SET
                                                `type` = '2',
                                                `ax_code` = '" . $product['model'] . "--".$Id['name']."-',
                                                `id` = '".$Id['product_option_value_id']."',
                                                `upc` = '".$product['model']."',
                                                `product_name` = '".$product['name']."';";

                        //$insert_ax_code = $this->db->query($insert_ax_code_query);

                        /*if ($insert_ax_code) {
                            $add_history = "INSERT INTO ax_code_correction SET `query` = '".$this->db->escape($insert_ax_code_query)."', added_at = NOW()";
                            $this->db->query($add_history);
                        }*/
                    } elseif ($mainOptionData[0]['option_id'] == '2') {
                        $insert_ax_code_query = "INSERT INTO ax_code SET
                                                `type` = '2',
                                                `ax_code` = '" . $product['model'] . "-".$Id['name']."--',
                                                `id` = '".$Id['product_option_value_id']."',
                                                `upc` = '".$product['model']."',
                                                `product_name` = '".$product['name']."';";

                        /*$insert_ax_code = $this->db->query($insert_ax_code_query);

                        if ($insert_ax_code) {
                            $add_history = "INSERT INTO ax_code_correction SET `query` = '".$this->db->escape($insert_ax_code_query)."', added_at = NOW()";
                            $this->db->query($add_history);
                        }*/
                    }
                }
            }
        }
        else if( $type == 3 )  // option_combination
        {
            $query3 = "SELECT
                        poc.`product_option_combination_id`,
                        poc.`product_id`,
                        pocv.`option_value_id`,
                        COUNT(
                          poc.`product_option_combination_id`
                        ),
                        (SELECT
                          ax_code.`ax_code`
                          FROM
                          ax_code
                          WHERE `type` = 3
                            AND `id` = `poc`.`product_option_combination_id`
                            AND `upc` LIKE '".$product['model']."') AS concatenated_code
                        FROM
                            `oc_product_option_combination` poc,
                            `oc_product_option_combination_value` pocv
                        WHERE pocv.`option_value_id` IN (".$option_data[0]['option_value_id'].",".$option_data[1]['option_value_id'].")
                            AND poc.`product_option_combination_id` = pocv.`product_option_combination_id`
                            AND poc.`product_id` = ".$product['product_id']."
                        GROUP BY pocv.`product_option_combination_id`
                        HAVING COUNT(poc.`product_option_combination_id`) = 2;";

            $result3 = $this->db->query( $query3 );
            if( $result3->num_rows == '1' && $result3->row['concatenated_code'] )
            {
                $concatenated_code = $result3->row['concatenated_code'];
                //echo "<br>IN_FUNC_GOT_IT ".$concatenated_code;
                //var_dump($concatenated_code);
            }
            else//if($result3->num_rows > 1)
            {
                //die('CONBINATION_PRODUCT '.$query3);

                $log .= "<br><strong>NOT_FOUND_3</strong> product_option_combination_id ".$result3->row['product_option_combination_id']." option_value_id ".$option_data[0]['option_value_id']." option_value_id ".$option_data[1]['option_value_id'];
                $showLog = true;

                if ($option_data[0]['option_id'] == '1') {
                    $insert_ax_code_query = "INSERT INTO ax_code SET
                                                `type` = '3',
                                                `ax_code` = '" . $product['model'] . "-".$option_data[1]['name']."-".$option_data[0]['name']."-',
                                                `id` = '".$result3->row['product_option_combination_id']."',
                                                `upc` = '".$product['model']."',
                                                `product_name` = '".$product['name']."';";

                    /*$insert_ax_code = $this->db->query($insert_ax_code_query);

                    if ($insert_ax_code) {
                        $add_history = "INSERT INTO ax_code_correction SET `query` = '".$this->db->escape($insert_ax_code_query)."', added_at = NOW()";
                        $this->db->query($add_history);
                    }*/
                } elseif ($option_data[0]['option_id'] == '2') {
                    $insert_ax_code_query = "INSERT INTO ax_code SET
                                                `type` = '3',
                                                `ax_code` = '" . $product['model'] . "-".$option_data[0]['name']."-".$option_data[1]['name']."-',
                                                `id` = '".$result3->row['product_option_combination_id']."',
                                                `upc` = '".$product['model']."',
                                                `product_name` = '".$product['name']."';";

                    /*$insert_ax_code = $this->db->query($insert_ax_code_query);

                    if ($insert_ax_code) {
                        $add_history = "INSERT INTO ax_code_correction SET `query` = '".$this->db->escape($insert_ax_code_query)."', added_at = NOW()";
                        $this->db->query($add_history);
                    }*/
                }

                /*echo "<pre>";
                print_r($option_data);
                die('asfbdsf');*/

                //if ($insert_ax_code) {
                //$add_history = "INSERT INTO ax_code_correction SET `query` = '".$this->db->escape($insert_ax_code_query)."', added_at = NOW()";
                //$this->db->query($add_history);
                //}
            }
        }

        if ($showLog){
            echo $log;
        }

        if ($showOption) {
            //echo "<pre>";
            //print_r($Id);
        }

        if ($insert_ax_code_query) {
            echo "<br>".$insert_ax_code_query;
            //print_r($product);
        }

        if ($add_history) {
            echo "<br>".$add_history;
            //print_r($product);
        }

        return $concatenated_code;
    }

    // below OLD
    /*public function getProductAxCode( $type, $product_id, $option_data = array( ), $Id = 0 )
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
    }*/

}

?>