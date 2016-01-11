<?php
class ControllerProductProductImport extends Controller {
    private $error = array();

    public function index()
    {
        $debug = '';
        $num_rows = $this->db->query("SELECT COUNT(*) AS `num_rows` FROM `B2B_product_import`;");
        print("<br>Num rows ".$num_rows->row['num_rows']);
        //die('sadvs');
        $offset = 0;
        for ($page = 0; $offset < $num_rows->row['num_rows']; $page++) {
            if($page > 0) {
                $offset = (int)$page*1000;
            } else {
                $offset = 0;
            }

            $products = "SELECT * FROM `B2B_product_import` LIMIT 1000 OFFSET ".$offset.";";
            print("<br>Page ".$page." ".$offset." ".$products);
            $products = $this->db->query($products);
            //echo "<br><pre>"; print_r($products); die('sfbvasfvds');
            //$this->language->load('catalog/product');

            foreach ($products->rows AS $product) {
                echo "<br>-------------------------------------------------------------------------------------------------------------------------------------------------------------------------";
                echo "<br>".date('H:m:s')." ".$page." ".$offset;
                echo "<br>".$product['ITEMGROUPID'] . " " . $product['ITEMID'] . " <b>NAME:</b> " . $product['ITEMNAME'] . " <b>COLOR:</b> " . $product['COLOR'] . " <b>SIZE:</b> " . $product['SIZE'] . " <b>CONFIG:</b> " . $product['CONFIG'] . " <b>AX_CODE:</b> " . $product['COCNATENAT']. " <b>TIP:</b> " . $product['TIP'];
                //echo "<pre>"; print_r($product);

                $exist = $this->db->query("SELECT * FROM `oc_product` WHERE upc = '" . $product['ITEMID'] . "';");

                if (!empty($exist->rows) && (!empty($product['COLOR']) && !empty($product['SIZE']))) // IF PRODUCT EXIST AND HAVE COLOR AND SIZE
                {
                    if ($product['TIP'] == 'B2B') {
                        $this->store_settings($exist->row['product_id']);
                    }

                    if ($product['COLOR'] && $product['SIZE']) {
                        echo " <br><b>Exist product ID</b> color & size ";
                        print($exist->row['product_id']);
                        echo "<br>option combination func 1";
                        $this->option_combination_action($exist->row['product_id'], $product);
                    } elseif ($product['COLOR'] || $product['SIZE'] || $product['CONFIG']) {
                        echo " <br><b>Exist product ID</b> 1 option ";
                        print($exist->row['product_id']);
                        $this->option_action($exist->row['product_id'], $product);
                    } else {
                        echo " <br><b>Exist product ID</b> ";
                        print($exist->row['product_id']);
                    }
                } elseif (!empty($exist->rows) && (!empty($product['COLOR']) || !empty($product['SIZE']))) // IF PRODUCT EXIST AND HAVE COLOR OR SIZE
                {
                    echo "<br>Product exist and have color or size";
                    if (!empty($product['COLOR'])) {
                        $option_description_id_color = $this->db->query("SELECT * FROM `oc_option_description` WHERE `name` LIKE 'Culori';");
                        $check_option_exist = $this->db->query("SELECT * FROM `oc_option_value_description` WHERE `option_id` = " . $option_description_id_color->row['option_id'] . " AND `name` LIKE '" . $product['COLOR'] . "';");
                        if (!empty($check_option_exist->rows)) {
                            $check_product_option_exist = "SELECT * FROM `oc_product_option` WHERE `product_id` = " . $exist->row['product_id'] . " AND `option_id` = 2;";
                            echo "<br>1 ".$check_product_option_exist;
                            $check_product_option_exist = $this->db->query($check_product_option_exist);

                            if($check_product_option_exist->rows) {
                                $new_produst_option_ID = $check_product_option_exist->row['product_option_id'];
                            } else {
                                $new_product_option = "INSERT INTO `oc_product_option` SET `product_id` = " . $exist->row['product_id'] . ", `option_id` = 2, `required` = 1;";
                                echo "<br>" . $new_product_option;
                                $this->db->query($new_product_option);
                                $new_produst_option_ID = $this->db->getLastId();
                            }

                            $new_product_option_value = "INSERT INTO `oc_product_option_value` SET `product_option_id` = " . $new_produst_option_ID . ", `product_id` = " . $exist->row['product_id'] . ", `option_id` = 2, `option_value_id` = " . $check_option_exist->row['option_value_id'] . ";";
                            echo "<br>" . $new_product_option_value;
                            $this->db->query($new_product_option_value);
                            $new_produst_option_value_ID = $this->db->getLastId();

                            if ($product['COCNATENAT']) {
                                echo "<br> 1.2 ax check";
                                $this->check_ax_code($product, $new_produst_option_value_ID);
                            } else {
                                echo "<br>1 DON'T HAVE AX";
                            }
                        } else {
                            $new_option_value = "INSERT INTO `oc_option_value` SET `option_id` = 2";
                            echo "<br>" . $new_option_value;
                            $this->db->query($new_option_value);
                            $new_option_value_ID = $this->db->getLastId();

                            $new_option_value_description = "INSERT INTO `oc_option_value_description` SET `option_value_id` = " . $new_option_value_ID . ", `language_id` = 2, `option_id` = 2, `name` = '" . $product['COLOR'] . "';";
                            echo "<br> " . $new_option_value_description;
                            $this->db->query($new_option_value_description);

                            $check_product_option_exist = "SELECT * FROM `oc_product_option` WHERE `product_id` = " . $exist->row['product_id'] . " AND `option_id` = 2;";
                            echo "<br>1 ".$check_product_option_exist;
                            $check_product_option_exist = $this->db->query($check_product_option_exist);
                            if($check_product_option_exist->rows) {
                                $new_produst_option_ID = $check_product_option_exist->row['product_option_id'];
                            } else {
                                $new_product_option = "INSERT INTO `oc_product_option` SET `product_id` = " . $exist->row['product_id'] . ", `option_id` = 1, `required` = 2;";
                                echo "<br>" . $new_product_option;
                                $this->db->query($new_product_option);
                                $new_produst_option_ID = $this->db->getLastId();
                            }

                            $new_product_option_value = "INSERT INTO `oc_product_option_value` SET `product_option_id` = " . $new_produst_option_ID . ", `product_id` = " . $exist->row['product_id'] . ", `option_id` = 2, `option_value_id` = " . $new_option_value_ID . ";";
                            echo "<br>" . $new_product_option_value;
                            $this->db->query($new_product_option_value);
                            $new_produst_option_value_ID = $this->db->getLastId();

                            if ($product['COCNATENAT']) {
                                echo "<br> 2.2 ax check";
                                $this->check_ax_code($product, $new_produst_option_value_ID);
                            } else {
                                echo "<br>2 DON'T HAVE AX";
                            }
                        }
                    } elseif (!empty($product['SIZE'])) {
                        $option_description_id_color = $this->db->query("SELECT * FROM `oc_option_description` WHERE `name` LIKE 'Marimi';");
                        $check_option_exist = $this->db->query("SELECT * FROM `oc_option_value_description` WHERE `option_id` = " . $option_description_id_color->row['option_id'] . " AND `name` LIKE '" . $product['SIZE'] . "';");
                        if (!empty($check_option_exist->rows)) {
                            $check_product_option_exist = "SELECT * FROM `oc_product_option` WHERE `product_id` = " . $exist->row['product_id'] . " AND `option_id` = 1;";
                            echo "<br>1 ".$check_product_option_exist;
                            $check_product_option_exist = $this->db->query($check_product_option_exist);
                            if($check_product_option_exist->rows) {
                                $new_produst_option_ID = $check_product_option_exist->row['product_option_id'];
                            } else {
                                $new_product_option = "INSERT INTO `oc_product_option` SET `product_id` = " . $exist->row['product_id'] . ", `option_id` = 1, `required` = 1;";
                                echo "<br>" . $new_product_option;
                                $this->db->query($new_product_option);
                                $new_produst_option_ID = $this->db->getLastId();
                            }

                            $new_product_option_value = "INSERT INTO `oc_product_option_value` SET `product_option_id` = " . $new_produst_option_ID . ", `product_id` = " . $exist->row['product_id'] . ", `option_id` = 1, `option_value_id` = " . $check_option_exist->row['option_value_id'] . ";";
                            echo "<br>" . $new_product_option_value;
                            $this->db->query($new_product_option_value);
                            $new_produst_option_value_ID = $this->db->getLastId();

                            if ($product['COCNATENAT']) {
                                echo "<br> 3.2 ax check";
                                $this->check_ax_code($product, $new_produst_option_value_ID);
                            } else {
                                echo "<br>1 DON'T HAVE AX";
                            }
                        } else {
                            $new_option_value = "INSERT INTO `oc_option_value` SET `option_id` = 1";
                            echo "<br>" . $new_option_value;
                            $this->db->query($new_option_value);
                            $new_option_value_ID = $this->db->getLastId();

                            $new_option_value_description = "INSERT INTO `oc_option_value_description` SET `option_value_id` = " . $new_option_value_ID . ", `language_id` = 2, `option_id` = 1, `name` = '" . $product['SIZE'] . "';";
                            echo "<br> " . $new_option_value_description;
                            $this->db->query($new_option_value_description);

                            $check_product_option_exist = "SELECT * FROM `oc_product_option` WHERE `product_id` = " . $exist->row['product_id'] . " AND `option_id` = 1;";
                            echo "<br>1.2 ".$check_product_option_exist;
                            $check_product_option_exist = $this->db->query($check_product_option_exist);
                            if($check_product_option_exist->rows) {
                                $new_produst_option_ID = $check_product_option_exist->row['product_option_id'];
                            } else {
                                $new_product_option = "INSERT INTO `oc_product_option` SET `product_id` = " . $exist->row['product_id'] . ", `option_id` = 1, `required` = 1;";
                                echo "<br>" . $new_product_option;
                                $this->db->query($new_product_option);
                                $new_produst_option_ID = $this->db->getLastId();
                            }

                            $new_product_option_value = "INSERT INTO `oc_product_option_value` SET `product_option_id` = " . $new_produst_option_ID . ", `product_id` = " . $exist->row['product_id'] . ", `option_id` = 1, `option_value_id` = " . $new_option_value_ID . ";";
                            echo "<br>" . $new_product_option_value;
                            $this->db->query($new_product_option_value);
                            $new_produst_option_value_ID = $this->db->getLastId();

                            if ($product['COCNATENAT']) {
                                echo "<br> 4.2 ax check";
                                $this->check_ax_code($product, $new_produst_option_value_ID);
                            } else {
                                echo "<br>1 DON'T HAVE AX";
                            }
                        }
                    }
                } elseif (!empty($exist->rows) && !empty($product['CONFIG']) && (empty($product['COLOR']) && empty($product['SIZE']))) /* IF NEW PRODUCT ONLY CONFIG HAVE */ {
                    echo "<br>Product exist and have only config";
                    $check_option_exist = $this->db->query("SELECT * FROM `oc_option_value_description` WHERE `option_id` = 3 AND `name` LIKE '" . $product['CONFIG'] . "';");
                    if ($check_option_exist->num_rows) {
                        $check_product_option_exist = "SELECT * FROM `oc_product_option` WHERE `product_id` = " . $exist->row['product_id'] . " AND `option_id` = 3;";
                        echo "<br>3.2 ".$check_product_option_exist;
                        $check_product_option_exist = $this->db->query($check_product_option_exist);
                        if($check_product_option_exist->rows) {
                            $new_produst_option_ID = $check_product_option_exist->row['product_option_id'];
                        } else {
                            $new_product_option = "INSERT INTO `oc_product_option` SET `product_id` = " . $exist->row['product_id'] . ", `option_id` = 3, `required` = 1;";
                            echo "<br>" . $new_product_option;
                            $this->db->query($new_product_option);
                            $new_produst_option_ID = $this->db->getLastId();
                        }

                        $new_product_option_value = "INSERT INTO `oc_product_option_value` SET `product_option_id` = " . $new_produst_option_ID . ", `product_id` = " . $exist->row['product_id'] . ", `option_id` = 3, `option_value_id` = " . $check_option_exist->row['option_value_id'] . ";";
                        echo "<br>" . $new_product_option_value;
                        $this->db->query($new_product_option_value);
                        $new_produst_option_value_ID = $this->db->getLastId();

                        if ($product['COCNATENAT']) {
                            echo "<br> 1 ax check";
                            $this->check_ax_code($product, $new_produst_option_value_ID);
                        } else {
                            echo "<br>1 DON'T HAVE AX";
                        }
                    } else {
                        $new_option_value = "INSERT INTO `oc_option_value` SET `option_id` = 3";
                        echo "<br>" . $new_option_value;
                        $this->db->query($new_option_value);
                        $new_option_value_ID = $this->db->getLastId();

                        $new_option_value_description = "INSERT INTO `oc_option_value_description` SET `option_value_id` = " . $new_option_value_ID . ", `language_id` = 2, `option_id` = 3, `name` = '" . $product['CONFIG'] . "';";
                        echo "<br> " . $new_option_value_description;
                        $this->db->query($new_option_value_description);

                        $check_product_option_exist = "SELECT * FROM `oc_product_option` WHERE `product_id` = " . $exist->row['product_id'] . " AND `option_id` = 3;";
                        echo "<br>1.2 ".$check_product_option_exist;
                        $check_product_option_exist = $this->db->query($check_product_option_exist);
                        if($check_product_option_exist->rows) {
                            $new_produst_option_ID = $check_product_option_exist->row['product_option_id'];
                        } else {
                            $new_product_option = "INSERT INTO `oc_product_option` SET `product_id` = " . $exist->row['product_id'] . ", `option_id` = 3, `required` = 1;";
                            echo "<br>" . $new_product_option;
                            $this->db->query($new_product_option);
                            $new_produst_option_ID = $this->db->getLastId();
                        }

                        $new_product_option_value = "INSERT INTO `oc_product_option_value` SET `product_option_id` = " . $new_produst_option_ID . ", `product_id` = " . $exist->row['product_id'] . ", `option_id` = 3, `option_value_id` = " . $new_option_value_ID . ";";
                        echo "<br>" . $new_product_option_value;
                        $this->db->query($new_product_option_value);
                        $new_produst_option_value_ID = $this->db->getLastId();

                        if ($product['COCNATENAT']) {
                            echo "<br> 2 ax check";
                            $this->check_ax_code($product, $new_produst_option_value_ID);
                        } else {
                            echo "<br>2 DON'T HAVE AX";
                        }
                        //die('<br>Option NOT_EXIST config have');
                    }
                } else {
                    $new_product_sql = "INSERT INTO `oc_product` SET `model` = '" . $product['ITEMID'] . "', `upc` = '" . $product['ITEMID'] . "', `status` = 0;";
                    echo "<br><b>NOT Exist product</b><br>" . $new_product_sql;
                    $this->db->query($new_product_sql);
                    $new_product_ID = $this->db->getLastId();

                    $this->check_product_to_category($product['ITEMID'], $product['ITEMGROUPID']);

                    $new_product_description_sql = "INSERT INTO `oc_product_description` SET `product_id` = " . $new_product_ID . ", `language_id` = 2, `name` = '" . $product['ITEMNAME'] . "';";
                    echo "<br>" . $new_product_description_sql;
                    $this->db->query($new_product_description_sql);

                    if ($product['TIP'] == 'B2B') {
                        $this->store_settings($new_product_ID);
                    }

                    if ($product['COCNATENAT'] && empty($product['CONFIG']) && empty($product['COLOR']) && empty($product['SIZE'])) {
                        echo "<br> 3 ax check";
                        $this->check_ax_code($product, $new_product_ID);
                    } elseif (empty($product['COCNATENAT']) && empty($product['CONFIG']) && empty($product['COLOR']) && empty($product['SIZE'])) {
                        echo "<br>3 DON'T HAVE AX";
                    }

                    if ($product['COLOR'] && $product ['SIZE']) {
                        echo "<br>option combination func 2";
                        $this->option_combination_action($new_product_ID, $product);
                    } elseif ($product['COLOR'] || $product ['SIZE'] || $product ['CONFIG']) {
                        $this->option_action($new_product_ID, $product);
                    }
                    //die('<br>new product id: '.$new_product_ID);
                }
            }
        }
        die('STOP');

        if (strpos($exist, "NOT_EXIST") /*|| strpos($exist, "Exist 3")*/ || strpos($exist, "Missing 3")) {
            echo "<br><br><br>Line Product UPC  ".$exist; //die('stop 1'); print_r($import_data_line);
        }

        die('<br><br>asdvs');

    }

    public function check_ax_code($product, $new_product_ID) {
        $check_if_have_ax_code = "SELECT * FROM `ax_code` WHERE `ax_code` LIKE '".$product['COCNATENAT']."' ; ";
        echo "<br>".$check_if_have_ax_code;
        $check_if_have_ax_code = $this->db->query($check_if_have_ax_code);

        if ( !$check_if_have_ax_code->num_rows ) {
            if(empty($product['COLOR']) && empty($product['SIZE']) && empty($product['CONFIG'])) /* If not have any option */ {
                $new_ax_code = "INSERT INTO `ax_code` SET `type` = 1, `ax_code` = '".$product['COCNATENAT']."', `id` = ".$new_product_ID.", `upc` = '".$product['ITEMID']."', `product_name` = '".$product['ITEMNAME']."';";
                echo "<br>AX TYPE 1<br>".$new_ax_code;
                $this->db->query($new_ax_code);
            } elseif(!empty($product['COLOR']) && !empty($product['SIZE']) && empty($product['CONFIG'])) /* If have two option (option combination) */ {
                $new_ax_code = "INSERT INTO `ax_code` SET `type` = 3, `ax_code` = '".$product['COCNATENAT']."', `id` = ".$new_product_ID.", `upc` = '".$product['ITEMID']."', `product_name` = '".$product['ITEMNAME']."';";
                echo "<br>AX TYPE 3<br>".$new_ax_code;
                $this->db->query($new_ax_code);
            } elseif(!empty($product['COLOR']) || !empty($product['SIZE']) || !empty($product['CONFIG'])) /* If have only one option */ {
                if (!empty($product['COLOR'])) {
                    $get_option_value_ID = "SELECT * FROM `oc_option_value_description` WHERE `name` LIKE `".$product['COLOR']."`;";
                } elseif (!empty($product['SIZE'])) {
                    $get_option_value_ID = "SELECT * FROM `oc_option_value_description` WHERE `name` LIKE `".$product['SIZE']."`;";
                } elseif (!empty($product['CONFIG'])) {
                    $get_option_value_ID = "SELECT * FROM `oc_option_value_description` WHERE `name` LIKE `".$product['CONFIG']."`;";
                }
                $new_ax_code = "INSERT INTO `ax_code` SET `type` = 2, `ax_code` = '".$product['COCNATENAT']."', `id` = ".$new_product_ID.", `upc` = '".$product['ITEMID']."', `product_name` = '".$product['ITEMNAME']."';";
                echo "<br>AX TYPE 2<br>".$new_ax_code;
                $this->db->query($new_ax_code);
            } else {
                die('<br>CHECK THIS CASE');
            }
        } else {
            echo "<br> AX CODE exist";
        }
    }

    public function option_action($product_ID, $product) {
        $details = $this->db->query("SELECT pov.product_option_value_id AS ov_id, pov.product_option_id AS pov_id, od.name AS od_name, ovd.name AS ovd_name
                                            FROM oc_product_option_value AS pov
                                            JOIN oc_option_value_description AS ovd ON ( ovd.option_value_id = pov.option_value_id )
                                            JOIN oc_option_description AS od ON ( od.`option_id` = ovd.`option_id` )
                                            WHERE pov.`product_id` = '".$product_ID."' ORDER BY  ov_id ASC ;");
        $check_option_color_exist = false;
        $check_option_size_exist = false;
        $check_option_config_exist = false;
        if ($product['COLOR']) {
            $check_option_color_exist = "SELECT * FROM `oc_option_value_description` WHERE `option_id` = 2 AND `name` LIKE '" . $product['COLOR'] . "';";
            echo "<br>".$check_option_color_exist;
            $check_option_color_exist = $this->db->query($check_option_color_exist);
        } elseif ($product['SIZE']) {
            $check_option_size_exist = "SELECT * FROM `oc_option_value_description` WHERE `option_id` = 1 AND `name` LIKE '" . $product['SIZE'] . "';";
            echo "<br>".$check_option_size_exist;
            $check_option_size_exist = $this->db->query($check_option_size_exist);
        } elseif ($product['CONFIG']) {
            $check_option_config_exist = "SELECT * FROM `oc_option_value_description` WHERE `option_id` = 3 AND `name` LIKE '" . $product['CONFIG'] . "';";
            echo "<br>".$check_option_config_exist;
            $check_option_config_exist = $this->db->query($check_option_config_exist);
        }

        if ( isset($check_option_color_exist->num_rows) &&  $check_option_color_exist->num_rows) {
            $new_product_option = "INSERT INTO `oc_product_option` SET `product_id` = ".$product_ID.", `option_id` = 2, `required` = 1;";
            echo "<br>".$new_product_option;
            $this->db->query($new_product_option);
            $new_produst_option_ID = $this->db->getLastId();

            $new_product_option_value = "INSERT INTO `oc_product_option_value` SET `product_option_id` = ".$new_produst_option_ID.", `product_id` = ".$product_ID.", `option_id` = 2, `option_value_id` = ".$check_option_color_exist->row['option_value_id'].";";
            echo "<br>22 ".$new_product_option_value;
            $this->db->query($new_product_option_value);
            $new_produst_option_value_ID = $this->db->getLastId();

            if($product['COCNATENAT']) {
                echo "<br> 4 ax check";
                $this->check_ax_code($product, $new_produst_option_value_ID);
            } else {
                echo "<br>4 DON'T HAVE AX";
            }

            //echo "<pre>"; print_r($check_option_exist);
            //die('<br>Option NOT_EXIST BUT_OPTION config have');
        } elseif (isset($check_option_color_exist->num_rows) && !$check_option_color_exist->num_rows && $product['COLOR']) {
            $new_option_value = "INSERT INTO `oc_option_value` SET `option_id` = 2";
            echo "<br>".$new_option_value;
            $this->db->query($new_option_value);
            $new_option_value_ID = $this->db->getLastId();

            $new_option_value_description = "INSERT INTO `oc_option_value_description` SET `option_value_id` = ".$new_option_value_ID.", `language_id` = 2, `option_id` = 2, `name` = '".$product['CONFIG']."';";
            echo "<br> ".$new_option_value_description;
            $this->db->query($new_option_value_description);

            $new_product_option = "INSERT INTO `oc_product_option` SET `product_id` = ".$product_ID.", `option_id` = 1, `required` = 1;";
            echo "<br>".$new_product_option;
            $this->db->query($new_product_option);
            $new_produst_option_ID = $this->db->getLastId();

            $new_product_option_value = "INSERT INTO `oc_product_option_value` SET `product_option_id` = ".$new_produst_option_ID.", `product_id` = ".$product_ID.", `option_id` = 2, `option_value_id` = ".$new_option_value_ID.";";
            echo "<br>".$new_product_option_value;
            $this->db->query($new_product_option_value);
            $new_produst_option_value_ID = $this->db->getLastId();

            if($product['COCNATENAT']) {
                echo "<br> 5 ax check";
                $this->check_ax_code($product, $new_produst_option_value_ID);
            } else {
                echo "<br>5 DON'T HAVE AX";
            }
        }

        if ( isset($check_option_size_exist->num_rows) &&  $check_option_size_exist->num_rows) {
            $new_product_option = "INSERT INTO `oc_product_option` SET `product_id` = ".$product_ID.", `option_id` = 1, `required` = 1;";
            echo "<br>".$new_product_option;
            $this->db->query($new_product_option);
            $new_produst_option_ID = $this->db->getLastId();

            $new_product_option_value = "INSERT INTO `oc_product_option_value` SET `product_option_id` = ".$new_produst_option_ID.", `product_id` = ".$product_ID.", `option_id` = 1, `option_value_id` = ".$check_option_size_exist->row['option_value_id'].";";
            echo "<br>".$new_product_option_value;
            $this->db->query($new_product_option_value);
            $new_produst_option_value_ID = $this->db->getLastId();

            if($product['COCNATENAT']) {
                echo "<br> 6 ax check";
                $this->check_ax_code($product, $new_produst_option_value_ID);
            } else {
                echo "<br>6 DON'T HAVE AX";
            }

            //echo "<pre>"; print_r($check_option_exist);
            //die('<br>Option NOT_EXIST BUT_OPTION config have');
        } elseif (isset($check_option_size_exist->num_rows) && !$check_option_size_exist->num_rows && $product['SIZE']) {
            $new_option_value = "INSERT INTO `oc_option_value` SET `option_id` = 1";
            echo "<br>".$new_option_value;
            $this->db->query($new_option_value);
            $new_option_value_ID = $this->db->getLastId();

            $new_option_value_description = "INSERT INTO `oc_option_value_description` SET `option_value_id` = ".$new_option_value_ID.", `language_id` = 2, `option_id` = 1, `name` = '".$product['CONFIG']."';";
            echo "<br> ".$new_option_value_description;
            $this->db->query($new_option_value_description);

            $new_product_option = "INSERT INTO `oc_product_option` SET `product_id` = ".$product_ID.", `option_id` = 1, `required` = 1;";
            echo "<br>".$new_product_option;
            $this->db->query($new_product_option);
            $new_produst_option_ID = $this->db->getLastId();

            $new_product_option_value = "INSERT INTO `oc_product_option_value` SET `product_option_id` = ".$new_produst_option_ID.", `product_id` = ".$product_ID.", `option_id` = 1, `option_value_id` = ".$new_option_value_ID.";";
            echo "<br>".$new_product_option_value;
            $this->db->query($new_product_option_value);
            $new_produst_option_value_ID = $this->db->getLastId();

            if($product['COCNATENAT']) {
                echo "<br> 7 ax check";
                $this->check_ax_code($product, $new_produst_option_value_ID);
            } else {
                echo "<br>7 DON'T HAVE AX";
            }
        }

        if ( isset($check_option_config_exist->num_rows) && $check_option_config_exist->num_rows ) {
            $new_product_option = "INSERT INTO `oc_product_option` SET `product_id` = ".$product_ID.", `option_id` = 3, `required` = 1;";
            echo "<br>".$new_product_option;
            $this->db->query($new_product_option);
            $new_produst_option_ID = $this->db->getLastId();

            $new_product_option_value = "INSERT INTO `oc_product_option_value` SET `product_option_id` = ".$new_produst_option_ID.", `product_id` = ".$product_ID.", `option_id` = 3, `option_value_id` = ".$check_option_config_exist->row['option_value_id'].";";
            echo "<br>".$new_product_option_value;
            $this->db->query($new_product_option_value);
            $new_produst_option_value_ID = $this->db->getLastId();

            if($product['COCNATENAT']) {
                echo "<br> 8 ax check product option value ID ".$new_produst_option_value_ID;
                $this->check_ax_code($product, $new_produst_option_value_ID);
            } else {
                echo "<br>8 DON'T HAVE AX";
            }

            //echo "<pre>"; print_r($check_option_exist);
            //die('<br>Option NOT_EXIST BUT_OPTION config have');
        } elseif (isset($check_option_config_exist->num_rows) && !$check_option_config_exist->num_rows && $product['CONFIG']) {
            $new_option_value = "INSERT INTO `oc_option_value` SET `option_id` = 3";
            echo "<br>".$new_option_value;
            $this->db->query($new_option_value);
            $new_option_value_ID = $this->db->getLastId();

            $new_option_value_description = "INSERT INTO `oc_option_value_description` SET `option_value_id` = ".$new_option_value_ID.", `language_id` = 2, `option_id` = 3, `name` = '".$product['CONFIG']."';";
            echo "<br> ".$new_option_value_description;
            $this->db->query($new_option_value_description);

            $new_product_option = "INSERT INTO `oc_product_option` SET `product_id` = ".$product_ID.", `option_id` = 3, `required` = 1;";
            echo "<br>".$new_product_option;
            $this->db->query($new_product_option);
            $new_produst_option_ID = $this->db->getLastId();

            $new_product_option_value = "INSERT INTO `oc_product_option_value` SET `product_option_id` = ".$new_produst_option_ID.", `product_id` = ".$product_ID.", `option_id` = 3, `option_value_id` = ".$new_option_value_ID.";";
            echo "<br>".$new_product_option_value;
            $this->db->query($new_product_option_value);
            $new_produst_option_value_ID = $this->db->getLastId();

            if($product['COCNATENAT']) {
                echo "<br> 9 ax check";
                $this->check_ax_code($product, $new_produst_option_value_ID);
            } else {
                echo "<br>9 DON'T HAVE AX";
            }
        }
    }

    public function option_combination_action($product_ID, $product) {

        $details = $this->db->query("SELECT pocv.product_option_combination_id, ovd.name AS ov_name, od.name AS o_name FROM oc_product_option_combination_value pocv
                                            JOIN oc_product_option_combination poc ON (poc.product_option_combination_id = pocv.product_option_combination_id)
                                            JOIN oc_option_value_description AS ovd ON ( ovd.option_value_id = pocv.option_value_id )
                                            JOIN oc_option_description AS od ON ( od.`option_id` = ovd.`option_id` )
                                            WHERE poc.product_id='" . $product_ID . "' ORDER BY product_option_combination_id ASC;");

        $combination_exist = false;
        //print_r($details); die('4 here '.$product_ID);
        if ($details->num_rows) {
            for ($i = 0; $i < sizeof($details->rows); $i++) {
                //die('<br>3 here');
                /*echo $i . " Details <pre>";
                print_r($details->rows[$i]);
                print_r($details->rows[$i + 1]);*/
                if (isset($details->rows[$i + 1]) && !empty($details->rows[$i + 1])) {
                    //die('<br>2 here');
                    if ($details->rows[$i]['product_option_combination_id'] == $details->rows[$i + 1]['product_option_combination_id']) {
                        //die('<br>1 here');
                        if ($details->rows[$i]['ov_name'] == $product['COLOR'] && $details->rows[$i + 1]['ov_name'] == $product['SIZE']) {
                            $combination_exist = true;
                            echo $i . " HAVE " . $details->rows[$i]['ov_name'] . " " . $product['COLOR'] . " " . $details->rows[$i + 1]['ov_name'] . " " . $product['SIZE'] . "<br>";

                            if($product['COCNATENAT']) {
                                echo "<br>Option combination ID ".$details->rows[$i]['product_option_combination_id'];
                                $this->check_ax_code($product, $details->rows[$i]['product_option_combination_id']);
                            } else {
                                echo "<br>NOT AX";
                            }
                            $i++;
                            break;
                        } elseif ($details->rows[$i]['ov_name'] == $product['SIZE'] && $details->rows[$i + 1]['ov_name'] == $product['COLOR']) {
                            $combination_exist = true;
                            echo $i . " HAVE " . $details->rows[$i]['ov_name'] . " " . $product['COLOR'] . " " . $details->rows[$i + 1]['ov_name'] . " " . $product['SIZE'] . "<br>";

                            if($product['COCNATENAT']) {
                                echo "<br>Option combination ID ".$details->rows[$i]['product_option_combination_id'];
                                $this->check_ax_code($product, $details->rows[$i]['product_option_combination_id']);
                            } else {
                                echo "<br>NOT AX";
                            }
                            $i++;
                            break;
                        } else {
                            //echo $i." AA NOT_HAVE ".$details->rows[$i]['ov_name']." ".$product['COLOR']." ".$details->rows[$i+1]['ov_name']." ".$product['SIZE']."<br>";
                            $combination_exist = false;
                            $missing_combination['color']['ov_name'] = $product['COLOR'];
                            $missing_combination['size']['ov_name'] = $product['SIZE'];
                            //echo $i . " Not_HAVE " . $details->rows[$i]['ov_name'] . " " . $product['COLOR'] . " " . $details->rows[$i + 1]['ov_name'] . " " . $product['SIZE'] . "<br>";
                            $i++;
                            //break;
                        }
                    }
                } else {
                    die("fdabfbd " . $details->rows[$i]);
                    break;
                }
            }
        } else {
            $missing_combination['color']['ov_name'] = $product['COLOR'];
            $missing_combination['size']['ov_name'] = $product['SIZE'];
            echo "<br>product id ".$product_ID." don't have option combination";
        }

        if ($combination_exist) {
            echo "<br>Combiantion_exist type 3 Product ID " . $product_ID . " " . $product['COLOR'] . " " . $product['SIZE'];
        }
        elseif (isset($missing_combination)) {

            $option_description_id_color = "SELECT `option_id` FROM `oc_option_description` WHERE `name` LIKE 'Culori';";
            echo "<br>".$option_description_id_color;
            $option_description_id_color = $this->db->query($option_description_id_color);
            $echo_options = '';

            if (isset($option_description_id_color->row['option_id']) && $option_description_id_color->row['option_id'])
            {
                $option_description_id_color = $option_description_id_color->row['option_id'];

                $exist_option_value_description_color = "SELECT * FROM `oc_option_value_description` WHERE `option_id` = " . $option_description_id_color . " AND `name` LIKE '" . $missing_combination['color']['ov_name'] . "';";
                echo "<br>".$exist_option_value_description_color;
                $exist_option_value_description_color = $this->db->query($exist_option_value_description_color);

                if ($exist_option_value_description_color->row)
                {
                    echo " <br>\tExist 3 Color " . $missing_combination['color']['ov_name'] . " "; //print_r($exist_option_value_description_color);
                    $check_product_option = "SELECT * FROM `oc_product_option` WHERE `product_id`=".$product_ID." AND `option_id` = 2;";
                    echo "<br>".$check_product_option;
                    $check_product_option = $this->db->query($check_product_option);

                    if ($check_product_option->rows)
                    {
                        $check_product_option_value = "SELECT * FROM `oc_product_option_value` WHERE `product_option_id` =".$check_product_option->row['product_option_id']." AND `product_id`=".$product_ID." AND `option_id` = 2 AND `option_value_id` = ".$exist_option_value_description_color->row['option_value_id']." ;";
                        echo "<br>".$check_product_option_value;
                        $check_product_option_value = $this->db->query($check_product_option_value);

                        if (!$check_product_option_value->num_rows)
                        {
                            $new_product_option_value = "INSERT INTO `oc_product_option_value` SET `product_option_id` = " . $check_product_option->row['product_option_id'] . ", `product_id` = " . $product_ID . ", `option_id` = 2, `option_value_id` = " . $exist_option_value_description_color->row['option_value_id'] . ";";
                            echo "<br>Product option - No product option value color 2 <br>" . $new_product_option_value;
                            $this->db->query($new_product_option_value);
                        }

                    }
                    else
                    {
                        $new_product_option = "INSERT INTO `oc_product_option` SET `product_id`=".$product_ID.", `option_id` = 2;";
                        echo "<br>".$new_product_option;
                        $this->db->query($new_product_option);
                        $new_product_option_ID = $this->db->getLastId();

                        $new_product_option_value = "INSERT INTO `oc_product_option_value` SET `product_option_id` = " . $new_product_option_ID . ", `product_id` = " . $product_ID . ", `option_id` = 2, `option_value_id` = " . $exist_option_value_description_color->row['option_value_id'] . ";";
                        echo "<br>" . $new_product_option_value;
                        $this->db->query($new_product_option_value);
                    }
                }
                elseif (!$exist_option_value_description_color->row)
                {
                    $new_option_value = "INSERT INTO `oc_option_value` SET `option_id` = 2";
                    echo "<br>".$new_option_value;
                    $this->db->query($new_option_value);
                    $new_option_value_ID = $this->db->getLastId();

                    $new_option_value_description = "INSERT INTO `oc_option_value_description` SET `option_value_id` = ".$new_option_value_ID.", `language_id` = 2, `option_id` = 2, `name` = '".$product['COLOR']."';";
                    echo "<br> ".$new_option_value_description;
                    $this->db->query($new_option_value_description);
                    $exist_option_value_description_color->row['option_value_id'] = $new_option_value_ID;
                    echo " <br>\tMissing 3 Color " . $missing_combination['color']['ov_name'] . " "; //print_r($exist_option_value_description_color);

                    $check_product_option = "SELECT * FROM `oc_product_option` WHERE `product_id`=".$product_ID." AND `option_id` = 2;";
                    echo "<br>".$check_product_option;
                    $check_product_option = $this->db->query($check_product_option);

                    if ($check_product_option->rows)
                    {
                        $check_product_option_value = "SELECT * FROM `oc_product_option_value` WHERE `product_option_id` =".$check_product_option->row['product_option_id']." AND `product_id`=".$product_ID." AND `option_id` = 2 AND `option_value_id` = ".$exist_option_value_description_color->row['option_value_id']." ;";
                        echo "<br>".$check_product_option_value;
                        $check_product_option_value = $this->db->query($check_product_option_value);

                        if (!$check_product_option_value->num_rows)
                        {
                            $new_product_option_value = "INSERT INTO `oc_product_option_value` SET `product_option_id` = " . $check_product_option->row['product_option_id'] . ", `product_id` = " . $product_ID . ", `option_id` = 2, `option_value_id` = " . $exist_option_value_description_color->row['option_value_id'] . ";";
                            echo "<br>Product option - No product option value color<br>" . $new_product_option_value;
                            $this->db->query($new_product_option_value);
                        }

                    }
                    else
                    {
                        $new_product_option = "INSERT INTO `oc_product_option` SET `product_id`=".$product_ID.", `option_id` = 2;";
                        echo "<br>".$new_product_option;
                        $this->db->query($new_product_option);
                        $new_product_option_ID = $this->db->getLastId();

                        $new_product_option_value = "INSERT INTO `oc_product_option_value` SET `product_option_id` = " . $new_product_option_ID . ", `product_id` = " . $product_ID . ", `option_id` = 2, `option_value_id` = " . $exist_option_value_description_color->row['option_value_id'] . ";";
                        echo "<br>" . $new_product_option_value;
                        $this->db->query($new_product_option_value);
                    }
                }
            }

            $option_description_id_size = "SELECT `option_id` FROM `oc_option_description` WHERE `name` LIKE 'Marimi';";
            echo "<br>".$option_description_id_size;
            $option_description_id_size = $this->db->query($option_description_id_size);

            if (isset($option_description_id_size->row['option_id']) && $option_description_id_size->row['option_id'])
            {
                $option_description_id_size = $option_description_id_size->row['option_id'];
                $exist_option_value_description_size = "SELECT * FROM `oc_option_value_description` WHERE `option_id` = " . $option_description_id_size . " AND `name` LIKE '" . $missing_combination['size']['ov_name'] . "';";
                echo "<br>".$exist_option_value_description_size;
                $exist_option_value_description_size = $this->db->query($exist_option_value_description_size);

                if ($exist_option_value_description_size->row)
                {
                    $echo_options .= " <br>\tExist 3 Size " . $missing_combination['size']['ov_name'] . " "; //print_r($exist_option_value_description_color);

                    $check_product_option = "SELECT * FROM `oc_product_option` WHERE `product_id`=".$product_ID." AND `option_id` = 1;";
                    echo "<br>".$check_product_option;
                    $check_product_option = $this->db->query($check_product_option);
                    if ($check_product_option->rows)
                    {
                        $check_product_option_value = "SELECT * FROM `oc_product_option_value` WHERE `product_option_id` =".$check_product_option->row['product_option_id']." AND `product_id`=".$product_ID." AND `option_id` = 1 AND `option_value_id` = ".$exist_option_value_description_size->row['option_value_id']." ;";
                        echo "<br>".$check_product_option_value;
                        $check_product_option_value = $this->db->query($check_product_option_value);

                        if (!$check_product_option_value->num_rows)
                        {
                            $new_product_option_value = "INSERT INTO `oc_product_option_value` SET `product_option_id` = " . $check_product_option->row['product_option_id'] . ", `product_id` = " . $product_ID . ", `option_id` = 1, `option_value_id` = " . $exist_option_value_description_size->row['option_value_id'] . ";";
                            echo "<br>Product option - No product option value size<br>" . $new_product_option_value;
                            $this->db->query($new_product_option_value);
                        }

                    }
                    else
                    {
                        $new_product_option = "INSERT INTO `oc_product_option` SET `product_id`=".$product_ID.", `option_id` = 1;";
                        echo "<br>".$new_product_option;
                        $this->db->query($new_product_option);
                        $new_product_option_ID = $this->db->getLastId();

                        $new_product_option_value = "INSERT INTO `oc_product_option_value` SET `product_option_id` = " . $new_product_option_ID . ", `product_id` = " . $product_ID . ", `option_id` = 1, `option_value_id` = " . $exist_option_value_description_size->row['option_value_id'] . ";";
                        echo "<br>" . $new_product_option_value;
                        $this->db->query($new_product_option_value);
                    }
                }
                elseif (!$exist_option_value_description_size->row)
                {
                    $new_option_value = "INSERT INTO `oc_option_value` SET `option_id` = 1";
                    echo "<br>".$new_option_value;
                    $this->db->query($new_option_value);
                    $new_option_value_ID = $this->db->getLastId();

                    $new_option_value_description = "INSERT INTO `oc_option_value_description` SET `option_value_id` = ".$new_option_value_ID.", `language_id` = 2, `option_id` = 1, `name` = '".$product['SIZE']."';";
                    echo "<br> ".$new_option_value_description;
                    $this->db->query($new_option_value_description);
                    $exist_option_value_description_size->row['option_value_id'] = $new_option_value_ID;
                    echo " <br>\tMissing 3 Size " . $missing_combination['size']['ov_name'] . " "; //print_r($exist_option_value_description_color);

                    $check_product_option = "SELECT * FROM `oc_product_option` WHERE `product_id`=".$product_ID." AND `option_id` = 1;";
                    echo "<br>".$check_product_option;
                    $check_product_option = $this->db->query($check_product_option);

                    if ($check_product_option->rows)
                    {
                        $check_product_option_value = "SELECT * FROM `oc_product_option_value` WHERE `product_option_id` =".$check_product_option->row['product_option_id']." AND `product_id`=".$product_ID." AND `option_id` = 1 AND `option_value_id` = ".$exist_option_value_description_size->row['option_value_id']." ;";
                        echo "<br>".$check_product_option_value;
                        $check_product_option_value = $this->db->query($check_product_option_value);

                        if (!$check_product_option_value->num_rows)
                        {
                            $new_product_option_value = "INSERT INTO `oc_product_option_value` SET `product_option_id` = " . $check_product_option->row['product_option_id'] . ", `product_id` = " . $product_ID . ", `option_id` = 1, `option_value_id` = " . $exist_option_value_description_size->row['option_value_id'] . ";";
                            echo "<br>Product option - No product option value color<br>" . $new_product_option_value;
                            $this->db->query($new_product_option_value);
                        }

                    }
                    else
                    {
                        $new_product_option = "INSERT INTO `oc_product_option` SET `product_id`=".$product_ID.", `option_id` = 1;";
                        echo "<br>".$new_product_option;
                        $this->db->query($new_product_option);
                        $new_product_option_ID = $this->db->getLastId();

                        $new_product_option_value = "INSERT INTO `oc_product_option_value` SET `product_option_id` = " . $new_product_option_ID . ", `product_id` = " . $product_ID . ", `option_id` = 1, `option_value_id` = " . $exist_option_value_description_size->row['option_value_id'] . ";";
                        echo "<br>" . $new_product_option_value;
                        $this->db->query($new_product_option_value);
                    }
                }
            }

            echo $echo_options;

            if (isset($exist_option_value_description_color->row['option_value_id']) && isset($exist_option_value_description_size->row['option_value_id']))
            {
                if ($product['TIP'] == 'B2B') {
                    $sql_opt_comb = "INSERT INTO `oc_product_option_combination` SET `product_id` = " . $product_ID . ", `customer_group_id` = 3;";
                } else {
                    $sql_opt_comb = "INSERT INTO `oc_product_option_combination` SET `product_id` = " . $product_ID . ", `customer_group_id` = 1;";
                }

                echo "<br>".$sql_opt_comb;
                $this->db->query($sql_opt_comb);
                $new_product_option_combination_id = $this->db->getLastId();
                $this->product_option_combination_setting($product_ID);

                if ($new_product_option_combination_id)
                {
                    $sql_opt_comb_val_1 = "INSERT INTO `oc_product_option_combination_value` SET `product_option_combination_id` = " . $new_product_option_combination_id . ", `option_value_id` = " . $exist_option_value_description_color->row['option_value_id'] . ";";
                    echo "<br>color ".$sql_opt_comb_val_1;
                    $this->db->query($sql_opt_comb_val_1);
                    $sql_opt_comb_val_2 = "INSERT INTO `oc_product_option_combination_value` SET `product_option_combination_id` = " . $new_product_option_combination_id . ", `option_value_id` = " . $exist_option_value_description_size->row['option_value_id'] . ";";
                    echo "<br>size ".$sql_opt_comb_val_2;
                    $this->db->query($sql_opt_comb_val_2);

                    if($product['COCNATENAT'])
                    {
                        echo "<br>Option combination ID ".$new_product_option_combination_id;
                        $this->check_ax_code($product, $new_product_option_combination_id);
                    }
                    else
                    {
                        echo "<br>NOT AX";
                    }
                    echo "<br> NOT_EXIST " . $missing_combination['color']['ov_name'] . " " . $missing_combination['size']['ov_name'] . "<br>" . $sql_opt_comb;
                }
            } else {
                die("<br>don't exist option value description");
            }
            //echo "<br>Combination type 3 missing Product ID ".$product_ID." ".$product['COLOR']." ".$product['SIZE'];
            echo "<br><b>Combiantion_NOT_exist " . sizeof($details->rows) . " </b> Product ID " . $product_ID . " Culoare [" . $product['COLOR'] . "] Marime [" . $product['SIZE'] . "] ";
        } else {
            echo "<br><b>Type 3 in progress</b>";
        }
    }

    public function product_option_combination_setting($product_ID) {
        $check_product_option_combination_setting = "SELECT * FROM `oc_product_option_combination_setting` WHERE `product_id`=".$product_ID.";";
        $check_product_option_combination_setting = $this->db->query($check_product_option_combination_setting);

        if (!$check_product_option_combination_setting->rows) {
            $new_product_option_combination_setting = "INSERT INTO `oc_product_option_combination_setting` SET `product_id` = ".$product_ID.", price_view = 1, description_view = 1, option_view=1, quantity_box = 1;";
            $this->db->query($new_product_option_combination_setting);
        }
    }

    public function store_settings($product_ID) {
        $check_if_ID_exist = "SELECT * FROM `oc_product_to_store` WHERE `product_id` = ".$product_ID." AND `store_id` = 1;";
        echo "<br>".$check_if_ID_exist;
        $check_if_ID_exist = $this->db->query($check_if_ID_exist);

        if (!$check_if_ID_exist->num_rows) {
            $set_store = "INSERT INTO `oc_product_to_store` SET `product_id` = ".$product_ID.", `store_id` = 1 ;";
            echo "<br>".$set_store;
            $this->db->query($set_store);
        }
    }

    public function check_product_to_category($product_upc, $category_name) {

        $get_product_ID = "SELECT * FROM `oc_product` WHERE `upc` = '".$product_upc."';";
        echo "<br>".$get_product_ID;
        $get_product_ID  = $this->db->query($get_product_ID);

        if ($get_product_ID->num_rows == 1) {

            $check_product_to_category = "SELECT * FROM `oc_product_to_category` WHERE `product_id` = ".$get_product_ID->row['product_id'].";";
            echo "<br><b>NOT Exist product to category</b><br>" . $check_product_to_category;
            $check_product_to_category = $this->db->query($check_product_to_category);

            if (empty($check_product_to_category->rows)) {

                if ($category_name == 'L.Inaltime') {
                    $get_category_id = "SELECT * FROM `oc_category_description` WHERE `name` LIKE 'LUCRU LA INALTIME';";
                } else {
                    $get_category_id = "SELECT * FROM `oc_category_description` WHERE `name` LIKE '%".$category_name."%';";
                }

                echo "<br>".$get_category_id;
                $get_category_id = $this->db->query($get_category_id);

                if (sizeof($get_category_id->rows) == 1) {
                    echo "<br>Got 1 category for new product";
                    $new_product_to_category_sql = "INSERT INTO `oc_product_to_category` SET `product_id` = ".$get_product_ID->row['product_id'].", `category_id` = ".$get_category_id->rows[0]['category_id'].";";
                    $this->db->query($new_product_to_category_sql);
                    echo "<br>".$new_product_to_category_sql;

                } elseif (sizeof($get_category_id->rows) > 1) {

                    echo "<br>Error More than 1 category found";

                } else {

                    echo "<br>Error finding category";

                }
            }

        } elseif ($get_product_ID->num_rows > 1) {

            echo "<br>Dublicate upc";

        } else {

            echo "<br>No upc";

        }
    }
}
?>