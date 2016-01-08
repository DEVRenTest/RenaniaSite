<?php

class Cart
{

    private $config;
    private $db;
    private $data = array( );
    private $data_recurring = array( );

    public function __construct( $registry )
    {
        $this->config = $registry->get( 'config' );
        $this->customer = $registry->get( 'customer' );
        $this->session = $registry->get( 'session' );
        $this->db = $registry->get( 'db' );
        $this->tax = $registry->get( 'tax' );
        $this->weight = $registry->get( 'weight' );

        if( !isset( $this->session->data['cart'] ) || !is_array( $this->session->data['cart'] ) )
        {
            $this->session->data['cart'] = array( );
        }
    }

    public function getProducts()
    {
        if( !$this->data )
        {
            foreach( $this->session->data['cart'] as $key => $quantity )
            {                
                $product = explode( ':', $key );
                $product_id = $product[0];
                $stock = true;

                // Options
                if( !empty( $product[1] ) )
                {
                    $options = unserialize( base64_decode( $product[1] ) );
                }
                else
                {
                    $options = array( );
                }

                // Profile

                if( !empty( $product[2] ) )
                {
                    $profile_id = $product[2];
                }
                else
                {
                    $profile_id = 0;
                }

                $product_query = $this->db->query( "SELECT * FROM ".DB_PREFIX."product p LEFT JOIN ".DB_PREFIX."product_description pd ON (p.product_id = pd.product_id) WHERE p.product_id = '".( int ) $product_id."' AND pd.language_id = '".( int ) $this->config->get( 'config_language_id' )."' AND p.date_available <= NOW() AND p.status = '1'" );


                if( $product_query->num_rows )
                {
//                    $option_data = array( );
//                    $option_data = $this->buildOptionDataArray( $product_id, $options , $quantity);

                    $option_price = 0;
                    $option_points = 0;
                    $option_weight = 0;

                    $option_data = array( );
                    foreach( $options as $product_option_id => $option_value )
                    {
                        $option_query = $this->db->query( "SELECT po.product_option_id, po.option_id, od.name, o.type FROM ".DB_PREFIX."product_option po LEFT JOIN `".DB_PREFIX."option` o ON (po.option_id = o.option_id) LEFT JOIN ".DB_PREFIX."option_description od ON (o.option_id = od.option_id) WHERE po.product_option_id = '".( int ) $product_option_id."' AND po.product_id = '".( int ) $product_id."' AND od.language_id = '".( int ) $this->config->get( 'config_language_id' )."'" );

                        if( $option_query->num_rows )
                        {
                            if( $option_query->row['type'] == 'select' || $option_query->row['type'] == 'radio' || $option_query->row['type'] == 'image' )
                            {
                                $option_value_query = $this->db->query( "SELECT pov.option_value_id, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix FROM ".DB_PREFIX."product_option_value pov LEFT JOIN ".DB_PREFIX."option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN ".DB_PREFIX."option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_option_value_id = '".( int ) $option_value."' AND pov.product_option_id = '".( int ) $product_option_id."' AND ovd.language_id = '".( int ) $this->config->get( 'config_language_id' )."'" );

                                if( $option_value_query->num_rows )
                                {
                                    if( $option_value_query->row['price_prefix'] == '+' )
                                    {
                                        $option_price += $option_value_query->row['price'];
                                    }
                                    elseif( $option_value_query->row['price_prefix'] == '-' )
                                    {
                                        $option_price -= $option_value_query->row['price'];
                                    }

                                    if( $option_value_query->row['points_prefix'] == '+' )
                                    {
                                        $option_points += $option_value_query->row['points'];
                                    }
                                    elseif( $option_value_query->row['points_prefix'] == '-' )
                                    {
                                        $option_points -= $option_value_query->row['points'];
                                    }

                                    if( $option_value_query->row['weight_prefix'] == '+' )
                                    {
                                        $option_weight += $option_value_query->row['weight'];
                                    }
                                    elseif( $option_value_query->row['weight_prefix'] == '-' )
                                    {
                                        $option_weight -= $option_value_query->row['weight'];
                                    }

                                    if( $option_value_query->row['subtract'] && (!$option_value_query->row['quantity'] || ($option_value_query->row['quantity'] < $quantity)) )
                                    {
                                        $stock = false;
                                    }

                                    $option_data[] = array(
                                        'product_option_id' => $product_option_id,
                                        'product_option_value_id' => $option_value,
                                        'option_id' => $option_query->row['option_id'],
                                        'option_value_id' => $option_value_query->row['option_value_id'],
                                        'name' => $option_query->row['name'],
                                        'option_value' => $option_value_query->row['name'],
                                        'type' => $option_query->row['type'],
                                        'quantity' => $option_value_query->row['quantity'],
                                        'subtract' => $option_value_query->row['subtract'],
                                        'price' => $option_value_query->row['price'],
                                        'price_prefix' => $option_value_query->row['price_prefix'],
                                        'points' => $option_value_query->row['points'],
                                        'points_prefix' => $option_value_query->row['points_prefix'],
                                        'weight' => $option_value_query->row['weight'],
                                        'weight_prefix' => $option_value_query->row['weight_prefix']
                                    );
                                }
                            }
                            elseif( $option_query->row['type'] == 'checkbox' && is_array( $option_value ) )
                            {
                                foreach( $option_value as $product_option_value_id )
                                {
                                    $option_value_query = $this->db->query( "SELECT pov.option_value_id, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix FROM ".DB_PREFIX."product_option_value pov LEFT JOIN ".DB_PREFIX."option_value ov ON( pov.option_value_id = ov.option_value_id ) LEFT JOIN ".DB_PREFIX."option_value_description ovd ON( ov.option_value_id = ovd.option_value_id ) WHERE pov.product_option_value_id = '".( int ) $product_option_value_id."' AND pov.product_option_id = '".( int ) $product_option_id."' AND ovd.language_id = '".( int ) $this->config->get( 'config_language_id' )."'" );

                                    if( $option_value_query->num_rows )
                                    {
                                        if( $option_value_query->row['price_prefix'] == '+' )
                                        {
                                            $option_price += $option_value_query->row['price'];
                                        }
                                        elseif( $option_value_query->row['price_prefix'] == '-' )
                                        {
                                            $option_price -= $option_value_query->row['price'];
                                        }

                                        if( $option_value_query->row['points_prefix'] == '+' )
                                        {
                                            $option_points += $option_value_query->row['points'];
                                        }
                                        elseif( $option_value_query->row['points_prefix'] == '-' )
                                        {
                                            $option_points -= $option_value_query->row['points'];
                                        }

                                        if( $option_value_query->row['weight_prefix'] == '+' )
                                        {
                                            $option_weight += $option_value_query->row['weight'];
                                        }
                                        elseif( $option_value_query->row['weight_prefix'] == '-' )
                                        {
                                            $option_weight -= $option_value_query->row['weight'];
                                        }

                                        if( $option_value_query->row['subtract'] && (!$option_value_query->row['quantity'] || ($option_value_query->row['quantity'] < $quantity)) )
                                        {
                                            $stock = false;
                                        }

                                        $option_data[] = array(
                                            'product_option_id' => $product_option_id,
                                            'product_option_value_id' => $product_option_value_id,
                                            'option_id' => $option_query->row['option_id'],
                                            'option_value_id' => $option_value_query->row['option_value_id'],
                                            'name' => $option_query->row['name'],
                                            'option_value' => $option_value_query->row['name'],
                                            'type' => $option_query->row['type'],
                                            'quantity' => $option_value_query->row['quantity'],
                                            'subtract' => $option_value_query->row['subtract'],
                                            'price' => $option_value_query->row['price'],
                                            'price_prefix' => $option_value_query->row['price_prefix'],
                                            'points' => $option_value_query->row['points'],
                                            'points_prefix' => $option_value_query->row['points_prefix'],
                                            'weight' => $option_value_query->row['weight'],
                                            'weight_prefix' => $option_value_query->row['weight_prefix']
                                        );
                                    }
                                }
                            }
                            elseif( $option_query->row['type'] == 'text' || $option_query->row['type'] == 'textarea' || $option_query->row['type'] == 'file' || $option_query->row['type'] == 'date' || $option_query->row['type'] == 'datetime' || $option_query->row['type'] == 'time' )
                            {
                                $option_data[] = array(
                                    'product_option_id' => $product_option_id,
                                    'product_option_value_id' => '',
                                    'option_id' => $option_query->row['option_id'],
                                    'option_value_id' => '',
                                    'name' => $option_query->row['name'],
                                    'option_value' => $option_value,
                                    'type' => $option_query->row['type'],
                                    'quantity' => '',
                                    'subtract' => '',
                                    'price' => '',
                                    'price_prefix' => '',
                                    'points' => '',
                                    'points_prefix' => '',
                                    'weight' => '',
                                    'weight_prefix' => ''
                                );
                            }
                        }
                    }

                    if( $this->customer->isLogged() )
                    {
                        $customer_group_id = $this->customer->getCustomerGroupId();
                    }
                    else
                    {
                        $customer_group_id = $this->config->get( 'config_customer_group_id' );
                    }

                    $price = $product_query->row['price'];

                    // Product Discounts
                    $discount_quantity = 0;

                    foreach( $this->session->data['cart'] as $key_2 => $quantity_2 )
                    {
                        $product_2 = explode( ':', $key_2 );

                        if( $product_2[0] == $product_id )
                        {
                            $discount_quantity += $quantity_2;
                        }
                    }

                    $product_discount_query = $this->db->query( "SELECT price FROM ".DB_PREFIX."product_discount WHERE product_id = '".( int ) $product_id."' AND customer_group_id = '".( int ) $customer_group_id."' AND quantity <= '".( int ) $discount_quantity."' AND(( date_start = '0000-00-00' OR date_start < NOW( ) ) AND( date_end = '0000-00-00' OR date_end > NOW( ) ) ) ORDER BY quantity DESC, priority ASC, price ASC LIMIT 1" );

                    if( $product_discount_query->num_rows )
                    {
                        $price = $product_discount_query->row['price'];
                    }

                    // Product Specials
                    $product_special_query = $this->db->query( "SELECT price FROM ".DB_PREFIX."product_special WHERE product_id = '".( int ) $product_id."' AND customer_group_id = '".( int ) $customer_group_id."' AND(( date_start = '0000-00-00' OR date_start < NOW( ) ) AND( date_end = '0000-00-00' OR date_end > NOW( ) ) ) ORDER BY priority ASC, price ASC LIMIT 1" );

                    if( $product_special_query->num_rows )
                    {
                        $price = $product_special_query->row['price'];
                    }

                    // Reward Points
                    $product_reward_query = $this->db->query( "SELECT points FROM ".DB_PREFIX."product_reward WHERE product_id = '".( int ) $product_id."' AND customer_group_id = '".( int ) $customer_group_id."'" );

                    if( $product_reward_query->num_rows )
                    {
                        $reward = $product_reward_query->row['points'];
                    }
                    else
                    {
                        $reward = 0;
                    }

                    // Downloads		
                    $download_data = array( );

                    $download_query = $this->db->query( "SELECT * FROM ".DB_PREFIX."product_to_download p2d LEFT JOIN ".DB_PREFIX."download d ON( p2d.download_id = d.download_id ) LEFT JOIN ".DB_PREFIX."download_description dd ON( d.download_id = dd.download_id ) WHERE p2d.product_id = '".( int ) $product_id."' AND dd.language_id = '".( int ) $this->config->get( 'config_language_id' )."'" );

                    foreach( $download_query->rows as $download )
                    {
                        $download_data[] = array(
                            'download_id' => $download['download_id'],
                            'name' => $download['name'],
                            'filename' => $download['filename'],
                            'mask' => $download['mask'],
                            'remaining' => $download['remaining']
                        );
                    }

                    // Stock
                    if( !$product_query->row['quantity'] || ($product_query->row['quantity'] < $quantity) )
                    {
                        $stock = false;
                    }

                    $recurring = false;
                    $recurring_frequency = 0;
                    $recurring_price = 0;
                    $recurring_cycle = 0;
                    $recurring_duration = 0;
                    $recurring_trial_status = 0;
                    $recurring_trial_price = 0;
                    $recurring_trial_cycle = 0;
                    $recurring_trial_duration = 0;
                    $recurring_trial_frequency = 0;
                    $profile_name = '';

                    if( $profile_id )
                    {
                        $profile_info = $this->db->query( "SELECT * FROM `".DB_PREFIX."profile` `p` JOIN `".DB_PREFIX."product_profile` `pp` ON `pp`.`profile_id` = `p`.`profile_id` AND `pp`.`product_id` = ".( int ) $product_query->row['product_id']." JOIN `".DB_PREFIX."profile_description` `pd` ON `pd`.`profile_id` = `p`.`profile_id` AND `pd`.`language_id` = ".( int ) $this->config->get( 'config_language_id' )." WHERE `pp`.`profile_id` = ".( int ) $profile_id." AND `status` = 1 AND `pp`.`customer_group_id` = ".( int ) $customer_group_id )->row;

                        if( $profile_info )
                        {
                            $profile_name = $profile_info['name'];

                            $recurring = true;
                            $recurring_frequency = $profile_info['frequency'];
                            $recurring_price = $profile_info['price'];
                            $recurring_cycle = $profile_info['cycle'];
                            $recurring_duration = $profile_info['duration'];
                            $recurring_trial_frequency = $profile_info['trial_frequency'];
                            $recurring_trial_status = $profile_info['trial_status'];
                            $recurring_trial_price = $profile_info['trial_price'];
                            $recurring_trial_cycle = $profile_info['trial_cycle'];
                            $recurring_trial_duration = $profile_info['trial_duration'];
                        }
                    }

                    // if the logged customer is B2B or Gallery + B2B
                    $priceB2B = 0;
                    $B2B = false;                   
                    if( $this->customer->getCustomerGroupId() == 3 || $this->customer->getCustomerGroupId() == 4 )
                    {
                        $B2B = true;
                        $priceB2B = $this->calculatePriceB2B( $product_query->row['product_id'], $option_data );
                    }


                    // xml ide szur
                    $this->data[$key] = array(
                        'key' => $key,
                        'product_id' => $product_query->row['product_id'],
                        'name' => $product_query->row['name'],
                        'model' => $product_query->row['model'],
                        'shipping' => $product_query->row['shipping'],
                        'image' => $product_query->row['image'],
                        'option' => $option_data,
                        'download' => $download_data,
                        'quantity' => $quantity,
                        'minimum' => $product_query->row['minimum'],
                        'subtract' => $product_query->row['subtract'],
                        'stock' => $stock,
                        'price' => ( $B2B ? $priceB2B : ($price + $option_price) ),
                        'total' => ( $B2B ? $priceB2B * $quantity : ($price + $option_price) * $quantity ),
                        'reward' => $reward * $quantity,
                        'points' => ($product_query->row['points'] ? ($product_query->row['points'] + $option_points) * $quantity : 0),
                        'tax_class_id' => $product_query->row['tax_class_id'],
                        'weight' => ($product_query->row['weight'] + $option_weight) * $quantity,
                        'weight_class_id' => $product_query->row['weight_class_id'],
                        'length' => $product_query->row['length'],
                        'width' => $product_query->row['width'],
                        'height' => $product_query->row['height'],
                        'length_class_id' => $product_query->row['length_class_id'],
                        'profile_id' => $profile_id,
                        'profile_name' => $profile_name,
                        'recurring' => $recurring,
                        'recurring_frequency' => $recurring_frequency,
                        'recurring_price' => $recurring_price,
                        'recurring_cycle' => $recurring_cycle,
                        'recurring_duration' => $recurring_duration,
                        'recurring_trial' => $recurring_trial_status,
                        'recurring_trial_frequency' => $recurring_trial_frequency,
                        'recurring_trial_price' => $recurring_trial_price,
                        'recurring_trial_cycle' => $recurring_trial_cycle,
                        'recurring_trial_duration' => $recurring_trial_duration,
                    );
                }
                else
                {
                    $this->remove( $key );
                }
            }
        }

              
        return $this->data;
    }

    public function buildOptionDataArray( $product_id, $product_option_id )
    {
        $option_data = array( );
        $option_price = 0;
        $option_points = 0;
        $option_weight = 0;
        $quantity = 1;

        if( !empty( $product_option_id ) && is_array( $product_option_id ) && count( $product_option_id ) > 0 )
        {
            foreach( $product_option_id as $product_option_id => $option_value )
            {
                $option_query = $this->db->query( "SELECT po.product_option_id, po.option_id, od.name, o.type FROM ".DB_PREFIX."product_option po LEFT JOIN `".DB_PREFIX."option` o ON (po.option_id = o.option_id) LEFT JOIN ".DB_PREFIX."option_description od ON (o.option_id = od.option_id) WHERE po.product_option_id = '".( int ) $product_option_id."' AND po.product_id = '".( int ) $product_id."' AND od.language_id = '".( int ) $this->config->get( 'config_language_id' )."'" );

                if( $option_query->num_rows )
                {
                    if( $option_query->row['type'] == 'select' || $option_query->row['type'] == 'radio' || $option_query->row['type'] == 'image' )
                    {
                        $option_value_query = $this->db->query( "SELECT pov.option_value_id, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix FROM ".DB_PREFIX."product_option_value pov LEFT JOIN ".DB_PREFIX."option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN ".DB_PREFIX."option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_option_value_id = '".( int ) $option_value."' AND pov.product_option_id = '".( int ) $product_option_id."' AND ovd.language_id = '".( int ) $this->config->get( 'config_language_id' )."'" );

                        if( $option_value_query->num_rows )
                        {
                            if( $option_value_query->row['price_prefix'] == '+' )
                            {
                                $option_price += $option_value_query->row['price'];
                            }
                            elseif( $option_value_query->row['price_prefix'] == '-' )
                            {
                                $option_price -= $option_value_query->row['price'];
                            }

                            if( $option_value_query->row['points_prefix'] == '+' )
                            {
                                $option_points += $option_value_query->row['points'];
                            }
                            elseif( $option_value_query->row['points_prefix'] == '-' )
                            {
                                $option_points -= $option_value_query->row['points'];
                            }

                            if( $option_value_query->row['weight_prefix'] == '+' )
                            {
                                $option_weight += $option_value_query->row['weight'];
                            }
                            elseif( $option_value_query->row['weight_prefix'] == '-' )
                            {
                                $option_weight -= $option_value_query->row['weight'];
                            }

                            if( $option_value_query->row['subtract'] && (!$option_value_query->row['quantity'] || ($option_value_query->row['quantity'] < $quantity)) )
                            {
                                $stock = false;
                            }

                            $option_data[] = array(
                                'product_option_id' => $product_option_id,
                                'product_option_value_id' => $option_value,
                                'option_id' => $option_query->row['option_id'],
                                'option_value_id' => $option_value_query->row['option_value_id'],
                                'name' => $option_query->row['name'],
                                'option_value' => $option_value_query->row['name'],
                                'type' => $option_query->row['type'],
                                'quantity' => $option_value_query->row['quantity'],
                                'subtract' => $option_value_query->row['subtract'],
                                'price' => $option_value_query->row['price'],
                                'price_prefix' => $option_value_query->row['price_prefix'],
                                'points' => $option_value_query->row['points'],
                                'points_prefix' => $option_value_query->row['points_prefix'],
                                'weight' => $option_value_query->row['weight'],
                                'weight_prefix' => $option_value_query->row['weight_prefix']
                            );
                        }
                    }
                    elseif( $option_query->row['type'] == 'checkbox' && is_array( $option_value ) )
                    {
                        foreach( $option_value as $product_option_value_id )
                        {
                            $option_value_query = $this->db->query( "SELECT pov.option_value_id, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix FROM ".DB_PREFIX."product_option_value pov LEFT JOIN ".DB_PREFIX."option_value ov ON( pov.option_value_id = ov.option_value_id ) LEFT JOIN ".DB_PREFIX."option_value_description ovd ON( ov.option_value_id = ovd.option_value_id ) WHERE pov.product_option_value_id = '".( int ) $product_option_value_id."' AND pov.product_option_id = '".( int ) $product_option_id."' AND ovd.language_id = '".( int ) $this->config->get( 'config_language_id' )."'" );

                            if( $option_value_query->num_rows )
                            {
                                if( $option_value_query->row['price_prefix'] == '+' )
                                {
                                    $option_price += $option_value_query->row['price'];
                                }
                                elseif( $option_value_query->row['price_prefix'] == '-' )
                                {
                                    $option_price -= $option_value_query->row['price'];
                                }

                                if( $option_value_query->row['points_prefix'] == '+' )
                                {
                                    $option_points += $option_value_query->row['points'];
                                }
                                elseif( $option_value_query->row['points_prefix'] == '-' )
                                {
                                    $option_points -= $option_value_query->row['points'];
                                }

                                if( $option_value_query->row['weight_prefix'] == '+' )
                                {
                                    $option_weight += $option_value_query->row['weight'];
                                }
                                elseif( $option_value_query->row['weight_prefix'] == '-' )
                                {
                                    $option_weight -= $option_value_query->row['weight'];
                                }

                                if( $option_value_query->row['subtract'] && (!$option_value_query->row['quantity'] || ($option_value_query->row['quantity'] < $quantity)) )
                                {
                                    $stock = false;
                                }

                                $option_data[] = array(
                                    'product_option_id' => $product_option_id,
                                    'product_option_value_id' => $product_option_value_id,
                                    'option_id' => $option_query->row['option_id'],
                                    'option_value_id' => $option_value_query->row['option_value_id'],
                                    'name' => $option_query->row['name'],
                                    'option_value' => $option_value_query->row['name'],
                                    'type' => $option_query->row['type'],
                                    'quantity' => $option_value_query->row['quantity'],
                                    'subtract' => $option_value_query->row['subtract'],
                                    'price' => $option_value_query->row['price'],
                                    'price_prefix' => $option_value_query->row['price_prefix'],
                                    'points' => $option_value_query->row['points'],
                                    'points_prefix' => $option_value_query->row['points_prefix'],
                                    'weight' => $option_value_query->row['weight'],
                                    'weight_prefix' => $option_value_query->row['weight_prefix']
                                );
                            }
                        }
                    }
                    elseif( $option_query->row['type'] == 'text' || $option_query->row['type'] == 'textarea' || $option_query->row['type'] == 'file' || $option_query->row['type'] == 'date' || $option_query->row['type'] == 'datetime' || $option_query->row['type'] == 'time' )
                    {
                        $option_data[] = array(
                            'product_option_id' => $product_option_id,
                            'product_option_value_id' => '',
                            'option_id' => $option_query->row['option_id'],
                            'option_value_id' => '',
                            'name' => $option_query->row['name'],
                            'option_value' => $option_value,
                            'type' => $option_query->row['type'],
                            'quantity' => '',
                            'subtract' => '',
                            'price' => '',
                            'price_prefix' => '',
                            'points' => '',
                            'points_prefix' => '',
                            'weight' => '',
                            'weight_prefix' => ''
                        );
                    }
                }
            }
        }


        return $option_data;
    }

    public function calculatePriceB2B( $product_id, $option_data = array( ) )
    {                
        $priceB2B = 0;
        $concatenated_code = '';
        
        $concatenated_code = $this->getProductAxCode( $product_id, $option_data );
                    
//        if( $sizeof_option == 0 ) // product
//        {
//            $query = $this->db->query( "SELECT axc.ax_code as concatenated_code FROM ax_code axc WHERE axc.type= 1 AND axc.id = '".( int ) $product_id."' " ); //( axp.quantity = " . $quantity . " || axp.quantity <= " . $quantity . ")
//            if( $query->num_rows > 0 )
//            {
//                $concatenated_code = $query->row['concatenated_code'];
//            }
//        }
//        else if( $sizeof_option == 1 ) // option
//        {
//            $query = $this->db->query( "SELECT axc.ax_code as concatenated_code FROM ax_code axc WHERE axc.type= 2 AND axc.id = '".( int ) $option_data[0]['product_option_value_id']."' " ); //( axp.quantity = " . $quantity . " || axp.quantity <= " . $quantity . ")
//            if( $query->num_rows > 0 )
//            {
//                $concatenated_code = $query->row['concatenated_code'];
//            }
//        }
//        else if( $sizeof_option == 2 )  // option_combination
//        {
//            $sql = "SELECT poc.`product_option_combination_id` FROM `oc_product_option_combination` poc";
//            $i = 0;
//            foreach( $option_data as $option )
//            {
//                $sql .= " JOIN `oc_product_option_combination_value` self".$i." 
//                           ON ( self".$i.".`product_option_combination_id` = poc.`product_option_combination_id` AND 
//                           poc.`product_id` = '".( int ) $product_id."' AND self".$i.".`option_value_id` = '".$option['option_value_id']."')";
//                $i++;
//            }
//
//
//            $query = $this->db->query( $sql );
//            $ocId = 0;
//            if( $query->num_rows )
//            {
//                foreach( $query->rows as $one_row )
//                {
//                    $query2 = $this->db->query( "SELECT COUNT(*) as nr_rows FROM oc_product_option_combination_value a 
//                                                WHERE a.`product_option_combination_id` = '".( int ) $one_row['product_option_combination_id']."'" );
//
//                    if( $query2->num_rows )
//                    {
//                        if( $query2->row['nr_rows'] == $sizeof_option )
//                        {
//                            $ocId = $one_row['product_option_combination_id'];
//                            break;
//                        }
//                    }
//                }
//            }
//            
//            $query3 = $this->db->query( "SELECT axc.ax_code as concatenated_code FROM ax_code axc WHERE axc.type= 3 AND axc.id = '".( int ) $ocId."' " );
//            if( $query3->num_rows > 0 )
//            {
//                $concatenated_code = $query3->row['concatenated_code'];
//            }
//        }
        
        
        if ( !empty($concatenated_code) )
        {
            $query4 = $this->db->query( "SELECT distinct ZU.CONCATENAT
            ,CASE WHEN ZU.LINEDISC='Disc. N' THEN 'DA' ELSE 'NU' END  as CALCUL_DISCOUNT
            ,ZT.ACCOUNTNUM, ZT.PRICEGROUP, ZU.AMOUNT as PRET_LISTA, IFNULL(ZU1.AMOUNT,0) as PRET_CLIENT
            ,ZU.CURRENCY, ZT.PROCENT_GENERAL
            ,IFNULL((case when ZD1.accountrelation ='' then ZD1.PERCENT1 else 0 end),0)+
            IFNULL((case when ZD.accountrelation = ZT.ACCOUNTNUM then ZD.PERCENT1 else 0 end),0) as PROCENT_SUPLIMENTAR
            ,round(CASE WHEN ZU.LINEDISC = 'Disc. N' THEN ((CASE WHEN ZU1.AMOUNT IS NULL THEN ZU.AMOUNT ELSE ZU1.AMOUNT END)*(1-(ZT.PROCENT_GENERAL + (IFNULL((case when ZD1.accountrelation ='' then ZD1.PERCENT1 else 0 end),0)+
            IFNULL((case when ZD.accountrelation = ZT.ACCOUNTNUM then ZD.PERCENT1 else 0 end),0)))/100)) ELSE (CASE WHEN ZU1.AMOUNT IS NULL THEN ZU.AMOUNT ELSE ZU1.AMOUNT END ) END,2) as PRET_VANZARE
            FROM _AX_CUSTOMERS as ZT
            LEFT JOIN _AX_PRICES as ZU ON ZU.ACCOUNTRELATION=ZT.PRICEGROUP
            LEFT JOIN _AX_DISCOUNTS as ZD ON ZD.ACCOUNTRELATION=ZT.ACCOUNTNUM AND ZD.concatenat=ZU.concatenat
            LEFT JOIN _AX_DISCOUNTS as ZD1 ON ZD1.ACCOUNTRELATION='' AND ZD1.concatenat=ZU.concatenat
            LEFT JOIN _AX_PRICES as ZU1 ON ZU1.ACCOUNTRELATION=ZT.ACCOUNTNUM AND ZU1.concatenat = ZU.concatenat
            WHERE ZT.ACCOUNTNUM = '".$this->customer->getAxCode()."' AND ZU.concatenat = '".$concatenated_code."' ORDER BY `ZU`.`inventdimid` ASC");
            
//            print "SELECT distinct ZU.CONCATENAT
//            ,CASE WHEN ZU.LINEDISC='Disc. N' THEN 'DA' ELSE 'NU' END as CALCUL_DISCOUNT
//            ,ZT.ACCOUNTNUM, ZT.PRICEGROUP, ZU.AMOUNT as PRET_LISTA, IFNULL(ZU1.AMOUNT,0) as PRET_CLIENT
//            ,ZU.CURRENCY, ZT.PROCENT_GENERAL
//            ,IFNULL((case when ZD1.accountrelation ='' then ZD1.PERCENT1 else 0 end),0)+
//            IFNULL((case when ZD.accountrelation = ZT.ACCOUNTNUM then ZD.PERCENT1 else 0 end),0) as PROCENT_SUPLIMENTAR
//            ,round(CASE WHEN ZU.LINEDISC = 'Disc. N' THEN ((CASE WHEN ZU1.AMOUNT IS NULL THEN ZU.AMOUNT ELSE ZU1.AMOUNT END)*(1-(ZT.PROCENT_GENERAL + (IFNULL((case when ZD1.accountrelation ='' then ZD1.PERCENT1 else 0 end),0)+
//            IFNULL((case when ZD.accountrelation = ZT.ACCOUNTNUM then ZD.PERCENT1 else 0 end),0)))/100)) ELSE (CASE WHEN ZU1.AMOUNT IS NULL THEN ZU.AMOUNT ELSE ZU1.AMOUNT END ) END,2) as PRET_VANZARE
//            FROM _AX_CUSTOMERS as ZT
//            LEFT JOIN _AX_PRICES as ZU ON ZU.ACCOUNTRELATION=ZT.PRICEGROUP
//            LEFT JOIN _AX_DISCOUNTS as ZD ON ZD.ACCOUNTRELATION=ZT.ACCOUNTNUM AND ZD.concatenat=ZU.concatenat
//            LEFT JOIN _AX_DISCOUNTS as ZD1 ON ZD1.ACCOUNTRELATION='' AND ZD1.concatenat=ZU.concatenat
//            LEFT JOIN _AX_PRICES as ZU1 ON ZU1.ACCOUNTRELATION=ZT.ACCOUNTNUM AND ZU1.concatenat = ZU.concatenat
//            WHERE ZT.ACCOUNTNUM = '".$this->customer->getAxCode()."' AND ZU.concatenat = '".$concatenated_code."' ";die();
            
            
       /* if ( !empty($concatenated_code) )
        {
            $query4 = $this->db->query( "SELECT DISTINCT
                ZU.CONCATENAT
                ,CASE
                            WHEN ZU.LINEDISC = 'Disc. N'
                                        THEN 'DA'
                            ELSE 'NU'
                            END as CALCUL_DISCOUNT
                ,ZT.ACCOUNTNUM
                ,ZT.PRICEGROUP
                ,ZU.AMOUNT as PRET_LISTA
                ,IFNULL(ZU1.AMOUNT, 0) as PRET_CLIENT
                ,ZU.CURRENCY
                ,ZT.PROCENT_GENERAL
                ,IFNULL(ZD.PERCENT1, 0) as PROCENT_SUPLIMENTAR
                ,round(CASE
                                        WHEN ZU.LINEDISC = 'Disc. N'
                                                    THEN (
                                                                            (
                                                                                        CASE
                                                                                                    WHEN ZU1.AMOUNT IS NULL
                                                                                                                THEN ZU.AMOUNT
                                                                                                    ELSE ZU1.AMOUNT
                                                                                                    END
                                                                                        ) * (1 - (ZT.PROCENT_GENERAL + IFNULL(ZD.PERCENT1, 0)) / 100)
                                                                            )
                                    ELSE (
                                                                CASE
                                                                            WHEN ZU1.AMOUNT IS NULL
                                                                                        THEN ZU.AMOUNT
                                                                            ELSE ZU1.AMOUNT
                                                                            END
                                                        )
                                        END, 2) as PRET_VANZARE

                FROM _AX_CUSTOMERS as ZT
                LEFT JOIN _AX_PRICES as ZU ON ZU.ACCOUNTRELATION = ZT.PRICEGROUP
                LEFT JOIN _AX_DISCOUNTS as ZD ON ZD.ACCOUNTRELATION = ZT.ACCOUNTNUM
                            AND ZD.concatenat = ZU.concatenat
                LEFT JOIN _AX_PRICES ZU1 ON ZU1.ACCOUNTRELATION = ZT.ACCOUNTNUM
                            AND ZU1.concatenat = ZU.concatenat
                WHERE ZT.ACCOUNTNUM = '".$this->customer->getAxCode()."' AND ZU.concatenat = '".$concatenated_code."' " );
        */
            
            if( $query4->num_rows > 0 )
            {
                $priceB2B = $query4->row['PRET_VANZARE'];
            }
            
        }
         
        
       /* if( $sizeof_option == 0 ) // product
        {
            $query = $this->db->query( "SELECT axp.price FROM ax_price axp JOIN ax_code axc ON (axc.ax_code = axp.ax_code) WHERE axc.type= 1 AND axc.id = '".( int ) $product_id."' AND axp.id_customer = '".$this->customer->getId()."' AND (axp.date_available_from < NOW() AND axp.date_available_to > NOW() )  " ); //( axp.quantity = " . $quantity . " || axp.quantity <= " . $quantity . ")
            if( $query->num_rows > 0 )
            {
                $priceB2B = $query->row['price'];
            }
        }
        else if( $sizeof_option == 1 ) // option
        {
            //$first_element = reset( $option_data );
            $query = $this->db->query( "SELECT axp.price FROM ax_price axp JOIN ax_code axc ON (axc.ax_code = axp.ax_code) WHERE axc.type= 2 AND axc.id = '".( int ) $option_data[0]['product_option_value_id']."' AND axp.id_customer = '".$this->customer->getId()."' AND (axp.date_available_from < NOW() AND axp.date_available_to > NOW() )  " ); //( axp.quantity = " . $quantity . " || axp.quantity <= " . $quantity . ")
            if( $query->num_rows > 0 )
            {
                $priceB2B = $query->row['price'];
            }
        }
        else if( $sizeof_option == 2 )  // option_combination
        {
            $sql = "SELECT poc.`product_option_combination_id` FROM `oc_product_option_combination` poc";
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
                }
            }


            $query3 = $this->db->query( "SELECT axp.price FROM ax_price axp JOIN ax_code axc ON (axc.ax_code = axp.ax_code) WHERE axc.type= 3 AND axc.id = '".( int ) $ocId."' AND axp.id_customer = '".$this->customer->getId()."' AND (axp.date_available_from < NOW() AND axp.date_available_to > NOW() )  " );
            if( $query3->num_rows > 0 )
            {
                $priceB2B = $query3->row['price'];
            }
        }*/

        return $priceB2B;
    }
    
    
    public function getProductAxCode( $product_id, $option_data = array( ) )
    {        
  
        $sizeof_option = sizeof( $option_data );
        $concatenated_code = '';
        
        
        if( $sizeof_option == 0 ) // product
        {
            $query = $this->db->query( "SELECT axc.ax_code as concatenated_code FROM ax_code axc WHERE axc.type= 1 AND axc.id = '".( int ) $product_id."' " ); //( axp.quantity = " . $quantity . " || axp.quantity <= " . $quantity . ")
            if( $query->num_rows > 0 )
            {
                $concatenated_code = $query->row['concatenated_code'];
            }
        }
        else if( $sizeof_option == 1 ) // option
        {
            $query = $this->db->query( "SELECT axc.ax_code as concatenated_code FROM ax_code axc WHERE axc.type= 2 AND axc.id = '".( int ) $option_data[0]['product_option_value_id']."' " ); //( axp.quantity = " . $quantity . " || axp.quantity <= " . $quantity . ")
            if( $query->num_rows > 0 )
            {
               $concatenated_code = $query->row['concatenated_code'];
            }
        }
        else if( $sizeof_option == 2 )  // option_combination
        {
            $sql = "SELECT poc.`product_option_combination_id` FROM `oc_product_option_combination` poc";
            $i = 0;
            
//        if( $_SERVER['REMOTE_ADDR'] == '188.26.23.46' )
//        {
//            print "*******************"."\r\n";
//            print_r( $option_data );
//        }

            foreach( $option_data as $option )
            {
                $sql .= " JOIN `oc_product_option_combination_value` self".$i." 
                           ON ( self".$i.".`product_option_combination_id` = poc.`product_option_combination_id` AND 
                           poc.`product_id` = '".( int ) $product_id."' AND self".$i.".`option_value_id` = '".$option['option_value_id']."')";
                $i++;
            }
               
            $query = $this->db->query( $sql );    
            
//        if( $_SERVER['REMOTE_ADDR'] == '188.26.23.46' )
//        {
//            print "sql=".$sql."\r\n" ;
//        }
            
            $ocId = 0;
            if( $query->num_rows )
            {
                foreach( $query->rows as $one_row )
                {                  
                    $query2 = $this->db->query( "SELECT COUNT(*) as nr_rows FROM oc_product_option_combination_value a 
                                                WHERE a.`product_option_combination_id` = '".( int ) $one_row['product_option_combination_id']."'" );
                    
//        if( $_SERVER['REMOTE_ADDR'] == '188.26.23.46' )
//        {
//            print "****************************\r\n";
//            print "SELECT COUNT(*) as nr_rows FROM oc_product_option_combination_value a  WHERE a.`product_option_combination_id` = '".( int ) $one_row['product_option_combination_id']."'"."\r\n" ;
//            //die();
//            
//        }

                    if( $query2->num_rows )
                    {
                        if( $query2->row['nr_rows'] == $sizeof_option )
                        {
                            $ocId = $one_row['product_option_combination_id'];
                            
                            break;
                        }
                    }
                }
                
//        if( $_SERVER['REMOTE_ADDR'] == '188.26.23.46' )
//        {
//            print "ocId=".$ocId."\r\n" ;
//        }
                
                $query3 = $this->db->query( "SELECT axc.ax_code as concatenated_code FROM ax_code axc WHERE axc.type= 3 AND axc.id = '".( int ) $ocId."' " );
                if( $query3->num_rows > 0 )
                {
                    $concatenated_code = $query3->row['concatenated_code'];
                }
            }
        }
        
//            if( $_SERVER['REMOTE_ADDR'] == '188.26.23.46' )
//            {
//                print "concatenated_code=".$concatenated_code;
//            }
        
        return $concatenated_code;
    }

    public function getRecurringProducts()
    {
        $recurring_products = array( );

        foreach( $this->getProducts() as $key => $value )
        {
            if( $value['recurring'] )
            {
                $recurring_products[$key] = $value;
            }
        }

        return $recurring_products;
    }

    public function add( $product_id, $qty = 1, $option, $profile_id )
    {
        $key = ( int ) $product_id.':';

        if( $option )
        {
            $key .= base64_encode( serialize( $option ) ).':';
        }
        else
        {
            $key .= ':';
        }

        if( $profile_id )
        {
            $key .= ( int ) $profile_id;
        }

        if( ( int ) $qty && (( int ) $qty > 0) )
        {
            if( !isset( $this->session->data['cart'][$key] ) )
            {
                $this->session->data['cart'][$key] = ( int ) $qty;
            }
            else
            {
                $this->session->data['cart'][$key] += ( int ) $qty;
            }
        }

        $this->data = array( );
    }

    public function update( $key, $qty )
    {
        if( ( int ) $qty && (( int ) $qty > 0) )
        {
            $this->session->data['cart'][$key] = ( int ) $qty;
        }
        else
        {
            $this->remove( $key );
        }

        $this->data = array( );
    }

    public function remove( $key )
    {
        if( isset( $this->session->data['cart'][$key] ) )
        {
            unset( $this->session->data['cart'][$key] );
        }

        $this->data = array( );
    }

    public function clear()
    {
        $this->session->data['cart'] = array( );
        $this->data = array( );
    }

    public function getWeight()
    {
        $weight = 0;

        foreach( $this->getProducts() as $product )
        {
            if( $product['shipping'] )
            {
                $weight += $this->weight->convert( $product['weight'], $product['weight_class_id'], $this->config->get( 'config_weight_class_id' ) );
            }
        }

        return $weight;
    }

    public function getSubTotal()
    {
        $total = 0;

        foreach( $this->getProducts() as $product )
        {
            $total += $product['total'];
        }

        return $total;
    }

    public function getTaxes()
    {
        $tax_data = array( );

        foreach( $this->getProducts() as $product )
        {
            if( $product['tax_class_id'] )
            {
                $tax_rates = $this->tax->getRates( $product['price'], $product['tax_class_id'] );

                foreach( $tax_rates as $tax_rate )
                {
                    if( !isset( $tax_data[$tax_rate['tax_rate_id']] ) )
                    {
                        $tax_data[$tax_rate['tax_rate_id']] = ($tax_rate['amount'] * $product['quantity']);
                    }
                    else
                    {
                        $tax_data[$tax_rate['tax_rate_id']] += ($tax_rate['amount'] * $product['quantity']);
                    }
                }
            }
        }

        return $tax_data;
    }

    public function getTotal()
    {
        $total = 0;

        foreach( $this->getProducts() as $product )
        {
            $total += $this->tax->calculate( $product['price'], $product['tax_class_id'], $this->config->get( 'config_tax' ) ) * $product['quantity'];
        }

        return $total;
    }

    public function countProducts()
    {
        $product_total = 0;

        $products = $this->getProducts();

        foreach( $products as $product )
        {
            $product_total += $product['quantity'];
        }

        return $product_total;
    }

    public function hasProducts()
    {
        return count( $this->session->data['cart'] );
    }

    public function hasRecurringProducts()
    {
        return count( $this->getRecurringProducts() );
    }

    public function hasStock()
    {
        $stock = true;

        foreach( $this->getProducts() as $product )
        {
            if( !$product['stock'] )
            {
                $stock = false;
            }
        }

        return $stock;
    }

    public function hasShipping()
    {
        $shipping = false;

        foreach( $this->getProducts() as $product )
        {
            if( $product['shipping'] )
            {
                $shipping = true;

                break;
            }
        }

        return $shipping;
    }

    public function hasDownload()
    {
        $download = false;

        foreach( $this->getProducts() as $product )
        {
            if( $product['download'] )
            {
                $download = true;

                break;
            }
        }

        return $download









        ;
    }

}

?>