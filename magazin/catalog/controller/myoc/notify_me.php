<?php

class ControllerMyocNotifyMe extends Controller
{

    public function index()
    {
        $json = array( );
        $id = 0;
        
        $this->language->load( 'myoc/notify_me' );

        
        if( !$this->customer->isLogged() )
        {
            $json['status'] = "error";
            $json['msg'] = $this->language->get('text_must_login');
        }
        else
        {

            if( isset( $this->request->post['product_id'] ) )
            {
                $product_id = $this->request->post['product_id'];
            }
            else
            {
                $product_id = 0;
            }

            $this->load->model( 'catalog/product' );

            $option = array( );
            if( isset( $this->request->post['option'] ) )
            {
                $option = array_filter( $this->request->post['option'] );
            }
            // [357] = 2593;    
    //        print_r( $option );

            // verify how options have the product
            $optionNr = sizeof( $this->model_catalog_product->getProductOptions($product_id) );    
            $option_data = $this->cart->buildOptionDataArray( $product_id, $option );
    //        print "product_id=".$product_id."<br>";die();
    //        print_r( $option_data );
    //        die();

            $this->load->model( 'account/customer_notification' );     
            $product_info = $this->model_catalog_product->getProduct( $product_id, $option );  

            $description = $product_info['name'];
            $data = array();
            if( $optionNr == 0 ) // simpe product
            {
                $data = array(
                    'type'              => 1,
                    'product_id'        => $product_id,
                    'id'                => $product_id,
                    'customer_id'       => $this->customer->getId(),
                    'customer_email'    => $this->customer->getEmail(),
                    'description'     => $description
                );

                $id = $product_id;
            }
            else if( $optionNr == 1 ) // product with option
            {
                $description .= ", ".$option_data[0]['name'].": ".$option_data[0]['option_value'];

                $data = array(
                        'type'              => 2,
                        'product_id'        => $product_id,
                        'id'                => $option_data[0]['product_option_value_id'],
                        'customer_id'       => $this->customer->getId(),
                        'customer_email'    => $this->customer->getEmail(),
                        'description'       => $description
                    );

                $id = $option_data[0]['product_option_value_id'];
            }
            else if( $optionNr == 2 ) // product with option combination
            {               
                $sql = "SELECT poc.`product_option_combination_id` FROM `oc_product_option_combination` poc";
                $i = 0;
                foreach( $option_data as $option )
                {
                    $sql .= " JOIN `oc_product_option_combination_value` self".$i." 
                            ON ( self".$i.".`product_option_combination_id` = poc.`product_option_combination_id` AND 
                            poc.`product_id` = '".( int ) $product_id."' AND self".$i.".`option_value_id` = '".$option['option_value_id']."')";
                    $i++;

                    $description .= ", ".$option['name'].": ".$option['option_value'];
                }

    //            print "sql=".$sql."<br>";

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
                            if( $query2->row['nr_rows'] == $optionNr )
                            {
                                $ocId = $one_row['product_option_combination_id'];
                                break;
                            }
                        }
                    }
                }

                $data = array(
                    'type'              => 3,
                    'product_id'        => $product_id,
                    'id'                => $ocId,
                    'customer_id'       => $this->customer->getId(),
                    'customer_email'    => $this->customer->getEmail(),
                    'description'       => $description
                );

                $id = $ocId; 
            }

            if ( $id == 0 )
            {
                $json['status'] = "error";
                $json['msg'] = $this->language->get('text_combination_not_defined');
            }
            else
            {
                $this->model_account_customer_notification->addNotification($data);             

                $json['status'] = "ok";
                $json['msg'] = $this->language->get('text_notification_enabled');         
            }
        }
        
        $this->response->setOutput( json_encode( $json ) );
    }
    
}

?>