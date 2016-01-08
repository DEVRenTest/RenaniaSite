<?php

class ControllerProductStoreOrdersReport extends Controller
{

    public function index()
    {
        // delete view if exits
        //$drop_query = $this->db->query( "DROP VIEW orders_2014;" );
        
        // create new view
        $SQL = "";
        //$create_view = "CREATE VIEW orders_2014 AS  ";

        $SQL .= "SELECT oco.order_id, oco.firstname,oco.lastname,oco.payment_company,oco.shipping_address_1,oco.shipping_address_2,oco.shipping_zone,
                     oco.shipping_postcode,oco.shipping_method, oco.shipping_city, oco.date_added, oco.order_status_id,  oco.comment, ";
        $SQL .= "  ocop.order_product_id, ocop.product_id, ocop.name, ocop.model,ocop.quantity,ocop.price,ocop.total, ";
        $SQL .= "  occ.ax_code ";

        $SQL .= " FROM oc_order AS oco ";
        $SQL .= " JOIN  oc_order_product AS ocop ON ocop.order_id =  oco.order_id"; // LEFT JOIN
        $SQL .= " JOIN  oc_customer AS occ ON occ.customer_id =  oco.customer_id WHERE oco.`order_status_id` = 1"; // LEFT JOIN -- WHERE oco.`order_id` = 9
        //$SQL .= " where oco.order_id=507";
       // print $SQL;die();
       //
        //$view_query = $this->db->query( $create_view.$SQL );
        
        $query = $this->db->query( $SQL );

        /*foreach ( $query as $key => $info ) {
            echo $key." <pre>"; print_r($info);
        }
        die('1 end');*/

        $order_info = array();
        if( $query->num_rows > 0 )
        {
            foreach( $query->rows as $key => $result )
            {
                $order_info[ $key ] = array(
                    'order_id' => $result['order_id'],
                    'firstname' => $result['firstname'],
                    'lastname' => $result['lastname'],
                    'payment_company' => $result['payment_company'],
                    'ax_code' => $result['ax_code'],
                    'shipping_address_1' => $result['shipping_address_1'],
                    'shipping_address_2' => $result['shipping_address_2'],
                    'shipping_city' => $result['shipping_city'],
                    'shipping_zone' => $result['shipping_zone'],
                    'shipping_postcode' => $result['shipping_postcode'],
                    'shipping_method' => $result['shipping_method'],
                    'date_added' => $result['date_added'],
                    'order_status_id' => $result['order_status_id'],
                    'product_id' => $result['product_id'],
                    'name' => $result['name'],
                    'code_ax_concatenat' => '',
                    'order_product_id' => $result['order_product_id'],
                    'model' => $result['model'],
                    'quantity' => $result['quantity'],
                    'price' => $result['price'],
                    'total' => $result['total'],
                    'comment' => $result['comment'],
                    'recid' => 0,
                    'recversion' => 0
                );


                $SQL2 = '';
                $SQL2 .= " SELECT b.recid, b.recversion,`b`.`accountnum`, `b`.`street`
                            FROM `B2B_adresa` AS `b`
                            WHERE `b`.`accountnum` = '".$result['ax_code'] ."'  AND `b`.`street`='".str_replace("'","\'",$result['shipping_address_1'])."'";
                $query2 = $this->db->query( $SQL2 );

                    if( $query2->num_rows > 0 ){

                        $order_info[ $key ]['recid'] = $query2->row['recid'];
                        $order_info[ $key ]['recversion'] = $query2->row['recversion'];

                    }

            }
        }

        /*foreach ( $order_info as $key => $info ) {
            echo $key." <pre>"; print_r($info);
        }
        die('end 2');*/

        $this->load->model( 'catalog/product' );

        foreach( $order_info as $key => $info )
        {                        
            // get the option number for product
            $option_data = $this->model_catalog_product->getProductOptions( $info['product_id'] );
            $nr_option_data = sizeof( $option_data );

            $option = array( );
            $option_data = array( );
            $product_ax_code = '';
            $query = $this->db->query( "SELECT * FROM `oc_order_option` WHERE `order_product_id` = '".$info['order_product_id']."' " );            
            if( $query->num_rows > 0 )
            {
                if( $query->num_rows == 1 )
                {
                    $option[$query->row['product_option_id']] = $query->row['product_option_value_id'];
                }
                else if( $query->num_rows == 2 )
                {
                    foreach( $query->rows as $result )
                    {
                        $option[$result['product_option_id']] = $result['product_option_value_id'];
                    }
                }
            }

            /*print "<br><br>name=".$info['name']."===>nr_option_data=".$nr_option_data."<br>";
            print_r( $option );
            print "<br>*****************************"."<br><br>";

            print $info['order_product_id'];
            print "option<br>";
            print_r( $option );
            print "<br>";*/

            $option_data = $this->cart->buildOptionDataArray( $info['product_id'], $option );

            /*print "product_id=".$info['product_id']."<br>";
            print "OPTION_DATA===>";
            print_r( $option_data );*/

            $product_ax_code = $this->cart->getProductAxCode( $info['product_id'], $option_data );
            $order_info[$key]['code_ax_concatenat'] = $product_ax_code;
            
            /*// update view 
            $this->db->query("UPDATE orders_2014 SET order_product_id = '" . $product_ax_code . "' WHERE order_product_id = '" . $info['order_product_id'] . "'");*/
        }
        
        /*
        // write order values in csv file LIVE
        $filename = '/home/renania/public_html/magazin/orders_2014.csv';
        
        // DEV => /var/www/vhosts/renania.ro/httpdocs/magazin/orders_2014.csv
        //$filename = '/var/www/vhosts/renania.ro/httpdocs/magazin/orders_2014.csv';
        
        $fp = fopen( $filename, 'w');
        $fileContent="Order Id;Firstname;Lastname;Payment Company;Ax Code;Shipping Address 1;Shipping Address 2;Shipping city;Shipping zone;Shipping postcode;Shipping method;Date Added;Order status id;Order Product Id;Product Id;Name;Code ax concatenat;Model;Quantity;Price;Total\n";
        fputs($fp, $fileContent);
        
        $list = array ();
        foreach ( $order_info as $info ) 
        {
            array_push($list, 
                                array( $info['order_id'], $info['firstname'], $info['lastname'], $info['payment_company'],
                                        $info['ax_code'], $info['shipping_address_1'], $info['shipping_address_2'], $info['shipping_city'],
                                        $info['shipping_zone'], $info['shipping_postcode'], $info['shipping_method'], $info['date_added'],
                                        $info['order_status_id'], $info['order_product_id'], $info['product_id'], $info['name'], $info['code_ax_concatenat'],
                                        $info['model'], $info['quantity'], $info['price'], $info['total'] )
                    );
        }

        foreach ($list as $fields) 
        {
            fputcsv($fp, $fields, ";");
        }

        fclose($fp);
        
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="orders_2014.csv"');
        readfile( $filename );
        */

        /*foreach ( $order_info as $key => $info ) {
            echo $key." <pre>"; print_r($info);
        }
        die('end');*/


        // delete all orders info from online_shop_orders
        $this->db->query("TRUNCATE TABLE online_shop_orders");
        
        
        // insert into online shop orders table
        foreach ( $order_info as $info ) 
        {
            $insert = "INSERT INTO online_shop_orders SET order_id = '" . $info['order_id'] . "',
                            firstname = '" . $info['firstname'] . "', lastname = '" . $info['lastname'] . "',
                            payment_company = '" . $info['payment_company'] . "', ax_code = '" . $info['ax_code'] . "',
                            shipping_address_1 = '" . $this->db->escape($info['shipping_address_1']) . "', shipping_address_2 = '" . $this->db->escape($info['shipping_address_2']) . "',
                            shipping_city = '" . $info['shipping_city'] . "',  shipping_zone = '" . $info['shipping_zone'] . "',
                            shipping_postcode = '" . $info['shipping_postcode'] . "', shipping_method = '" . $info['shipping_method'] . "',
                            date_added = '".$info['date_added']."', order_status_id = '" . $info['order_status_id'] . "',
                            order_product_id = '".$info['order_product_id']."', product_id = '".$info['product_id']."',
                            `name` = '".$info['name']."', code_ax_concatenat = '".$info['code_ax_concatenat']."',
                            model = '".$info['model']."', quantity = '".$info['quantity']."',price = '".$info['price']."',
                            total = '".$info['total']."', comment = '".$this->db->escape($info['comment'])."' , recid = '".$info['recid']."', recversion = '".$info['recversion']."'";

            $this->db->query($insert);
            //
            
        }




        die('S-a populat tabelul online_shop_orders!');
    }

}

?>