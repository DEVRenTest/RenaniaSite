<?php
class ModelCheckoutCart Extends Model {

	public function getCarts($customer_id, $customer_group_id, $store_id, $you_are_support) {
		$saved_carts = "SELECT * FROM `" . DB_PREFIX . "cart` WHERE `store_id` = ".$store_id." AND `customer_id` = ".$customer_id." AND `date_deleted` IS NULL ORDER BY cart_id DESC;";
		//echo "<pre>opencart/catalog/model/checkout/cart.php:6"; print_r($saved_carts);

		$saved_carts = $this->db->query($saved_carts)->rows;

        //echo "<pre>"; print_r($saved_carts); die('opencart/catalog/model/checkout/cart.php:6');

        if ($saved_carts) {

			foreach ($saved_carts as &$cart) {
				$cart['products'] = $this->db->query("
					SELECT `cp`.*, ax.`type`, ax.`id`, p.`image`, p.`price`, p.`tax_class_id`, pd.`name`,
					(SELECT points FROM oc_product_reward WHERE product_id = p.product_id AND customer_group_id = ".$customer_group_id.") AS reward
					FROM `oc_cart_product` AS `cp`
					LEFT JOIN ax_code AS ax ON (cp.`ax_code` = ax.`ax_code`)
					LEFT JOIN oc_product AS p ON (cp.`product_id` = p.`product_id`)
					LEFT JOIN `oc_product_description` AS pd ON (cp.`product_id` = pd.`product_id`)
					WHERE `cp`.`cart_id` = ".$cart['cart_id'].";")->rows;

				foreach ($cart['products'] as &$product) {

					$product['href'] = $this->url->link( 'product/product', 'product_id='.$product['product_id'] );

					$product['option'] = array();
					/* $product['option'] = $this->db->query("SELECT * FROM `" . DB_PREFIX . "cart_product_option`
					 											WHERE `cart_id` = ".$cart['cart_id']."
					 											AND `cart_product_id` = ".$product['cart_product_id'].";")->rows;	*/
					if ($product['type'] == 3) {

						$get_options = "SELECT `pocv`.*, ovd.`option_id`, `od`.`name`, `ovd`.`name` AS `value`
										FROM `".DB_PREFIX."product_option_combination_value` AS pocv, `".DB_PREFIX."option_value_description` AS `ovd`, `".DB_PREFIX."option_description` AS `od`
										WHERE pocv.`product_option_combination_id` = ".$product['id']."
										AND ovd.`language_id` = '".( int ) $this->config->get( 'config_language_id' )."'
										AND ovd.`option_value_id` = pocv.`option_value_id`
										AND `od`.`option_id` = `ovd`.`option_id`;";

						$get_options = $this->db->query($get_options)->rows;

						foreach ($get_options as &$option) {
							$option_data = "SELECT * FROM oc_product_option_value WHERE product_id = ".$product['product_id']." AND option_value_id = ".$option['option_value_id'].";";
							$option_data = $this->db->query($option_data)->rows;
							$option = array_merge($option, $option_data[0]);
						}
						$product['option'] = $get_options;

					} elseif ($product['type'] == 2) {
						$get_options = "SELECT `pov`.*, `od`.`name`, `ovd`.`name` AS `value`
										FROM `".DB_PREFIX."product_option_value` AS `pov`, `".DB_PREFIX."option_description` AS `od`, `".DB_PREFIX."option_value_description` AS `ovd`
										WHERE `product_option_value_id` = ".$product['id']."
										AND product_id = ".$product['product_id']."
										AND `od`.`option_id` = `pov`.`option_id`
										AND `ovd`.`option_value_id` = `pov`.`option_value_id`;";

						$product['option'] = $this->db->query($get_options)->rows;
					}

					$option_price = 0;
					$option_points = 0;
					$option_weight = 0;
					$option_data = array();

					foreach( $product['option'] as &$option )
					{
						$option_query = $this->db->query( "SELECT po.product_option_id, po.option_id, od.name, o.type
															FROM ".DB_PREFIX."product_option po
															LEFT JOIN `".DB_PREFIX."option` o ON (po.option_id = o.option_id)
															LEFT JOIN ".DB_PREFIX."option_description od ON (o.option_id = od.option_id)
															WHERE po.product_option_id = '".( int ) $option['product_option_id']."'
															AND po.product_id = '".( int ) $product['product_id']."'
															AND od.language_id = '".( int ) $this->config->get( 'config_language_id' )."'" );

						if( $option_query->num_rows )
						{
							if( $option_query->row['type'] == 'select' || $option_query->row['type'] == 'radio' || $option_query->row['type'] == 'image' )
							{
								$option_value_query = $this->db->query( "
									SELECT pov.option_value_id, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix
									FROM ".DB_PREFIX."product_option_value pov
									LEFT JOIN ".DB_PREFIX."option_value ov ON (pov.option_value_id = ov.option_value_id)
									LEFT JOIN ".DB_PREFIX."option_value_description ovd ON (ov.option_value_id = ovd.option_value_id)
									WHERE pov.product_option_value_id = '".( int ) $option['product_option_value_id']."'
									AND pov.product_option_id = '".( int ) $option['product_option_id']."'
									AND ovd.language_id = '".( int ) $this->config->get( 'config_language_id' )."'" );

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

									if( $option_value_query->row['subtract'] && (!$option_value_query->row['quantity'] || ($option_value_query->row['quantity'] < $product['quantity'])) )
									{
										$stock = false;
									}

									$option_data[] = array(
										'product_option_id' => $option['product_option_id'],
										'product_option_value_id' => $option['product_option_value_id'],
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
									//echo sizeof($cart['products'])." ".$cart['cart_id']." products<pre>"; print_r($option_data);
								}
							}
							elseif( $option_query->row['type'] == 'checkbox' && is_array( $product['product_option_value_id'] ) )
							{
								foreach( $product['product_option_value_id'] as $product_option_value_id )
								{
									$option_value_query = $this->db->query( "
										SELECT pov.option_value_id, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix
										FROM ".DB_PREFIX."product_option_value pov
										LEFT JOIN ".DB_PREFIX."option_value ov ON( pov.option_value_id = ov.option_value_id )
										LEFT JOIN ".DB_PREFIX."option_value_description ovd ON( ov.option_value_id = ovd.option_value_id )
										WHERE pov.product_option_value_id = '".( int ) $option['product_option_value_id']."'
										AND pov.product_option_id = '".( int ) $option['product_option_id']."'
										AND ovd.language_id = '".( int ) $this->config->get( 'config_language_id' )."'" );

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

										if( $option_value_query->row['subtract'] && (!$option_value_query->row['quantity'] || ($option_value_query->row['quantity'] < $product['quantity'])) )
										{
											$stock = false;
										}

										$option_data[] = array(
											'product_option_id' => $option['product_option_id'],
											'product_option_value_id' => $option['product_option_value_id'],
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
									'product_option_id' => $option['product_option_id'],
									'product_option_value_id' => '',
									'option_id' => $option_query->row['option_id'],
									'option_value_id' => '',
									'name' => $option_query->row['name'],
									'option_value' => '',
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
							//echo "option value query<pre>"; print_r($option_value_query);
						}
					}

					$product['price'] = $this->cart->calculatePriceB2B( $product['product_id'], $option_data );

					//echo "MODEL PROGRESS ".$product['model']." ".$product['name']." 2 product price ".$product['price']." <pre>";

					$price = $product['price'];

					// END option price calculation




					//echo "<pre>"; print_r($product['option']); die("1 SELECT * FROM `" . DB_PREFIX . "cart_product_option` WHERE `cart_id` = ".$cart['cart_id']." AND `cart_product_id` = ".$product['cart_product_id'].";");
					//echo "<pre>"; print_r($product);
					$product['total'] = $product['quantity']*$product['price'];

					//echo "MODEL AFTER product<pre>"; print_r($product);
				}
				$get_support_query = "SELECT
										  csm.*,
										  c.`firstname`,
										  c.`lastname`,
										  csp.`cart_support_product_id`,
										  csp.`product_id`,
										  p.tax_class_id,
										  p.price,
										  pd.name,
										  csp.`model`,
										  csp.`ax_code`,
										  csp.`quantity`
										FROM
										  `oc_cart_support_message` `csm`
										  LEFT JOIN `oc_cart_support_product` `csp`
											ON csm.`cart_support_message_id` = csp.`cart_support_message_id`
										  LEFT JOIN `oc_customer` `c`
											ON csm.`customer_id` = c.`customer_id`
										  LEFT JOIN `oc_product_description` `pd`
											ON csp.`product_id` = pd.`product_id`
										  LEFT JOIN `oc_product` `p`
											ON csp.`product_id` = p.`product_id`
										WHERE `csm`.cart_id = ".$cart['cart_id']."
										AND `type` IS NULL;";

				$cart_support = $this->db->query($get_support_query)->rows;

				foreach ($cart_support as &$sup) {
					if($this->customer->getId() == $sup['customer_id']) {
						$sup['cart_owner'] = true;
					} else {
						$sup['cart_owner'] = false;
					}
					if ($sup['cart_support_product_id']) {
						$get_support_option_query = "SELECT `aspo`.*, `od`.`name` AS `od_name`, `ovd`.`name` AS `ovd_name`
												FROM `".DB_PREFIX."cart_support_product_option` `aspo`, `".DB_PREFIX."product_option` `po`, `".DB_PREFIX."option_description` `od`, `".DB_PREFIX."product_option_value` `pov`, `oc_option_value_description` `ovd`
												WHERE `cart_support_product_id` = ".$sup['cart_support_product_id']."
												AND `po`.`product_option_id` = `aspo`.`product_option_id`
												AND `od`.`option_id` = `po`.`option_id`
												AND `od`.`language_id` = 2
												AND `pov`.`product_option_value_id` = `aspo`.`product_option_value_id`
												AND `ovd`.`option_value_id` = `pov`.`option_value_id`;";

						$sup['option'] = $this->db->query($get_support_option_query)->rows;
					}
				};

				$cart['support'] = $cart_support;
			}
		}

        //echo "<pre>"; print_r($saved_carts); die('catalog/model/checkout/cart.php:299');

		return $saved_carts;
	}

	public function getConnectedCarts($customer_id, $customer_group_id) {
		$connected_carts = "SELECT
							  `csac`.*, `cart`.`cart_name`, `c`.`firstname`, `c`.`lastname`, `c`.`ax_code`
							FROM
							  `oc_cart_support_added_customer` `csac`
							  LEFT JOIN `oc_cart` `cart` ON `csac`.`cart_id` = `cart`.`cart_id`
							  LEFT JOIN `oc_customer` `c` ON `csac`.`owner_customer_id` = `c`.`customer_id`
						  	WHERE `csac`.`added_customer_id` = ".$customer_id." LIMIT 0, 25;";

        //die('opencart/catalog/model/checkout/cart.php:310 '.$connected_carts);

		$connected_carts = $this->db->query($connected_carts)->rows;

		//echo "<pre>"; print_r($connected_carts); die('opencart/catalog/model/checkout/cart.php:312');

		if ($connected_carts) {
			//echo sizeof($connected_carts)."<pre>";
			foreach ($connected_carts as &$cart) {
				$cart['products'] = $this->db->query("
					SELECT `cp`.*, ax.`type`, ax.`id`, p.`image`, p.`price`, p.`tax_class_id`, pd.`name`,
					(SELECT points FROM oc_product_reward WHERE product_id = p.product_id AND customer_group_id = ".$customer_group_id.") AS reward
					FROM `oc_cart_product` AS `cp`
					LEFT JOIN ax_code AS ax ON (cp.`ax_code` = ax.`ax_code`)
					LEFT JOIN oc_product AS p ON (cp.`product_id` = p.`product_id`)
					LEFT JOIN `oc_product_description` AS pd ON (cp.`product_id` = pd.`product_id`)
					WHERE `cp`.`cart_id` = ".$cart['cart_id'].";")->rows;

				foreach ($cart['products'] as &$product) {

					//echo "product before <pre>"; print_r($product);

					$product['href'] = $this->url->link( 'product/product', 'product_id='.$product['product_id'] );

					$product['option'] = array();
					/* $product['option'] = $this->db->query("SELECT * FROM `" . DB_PREFIX . "cart_product_option`
					 											WHERE `cart_id` = ".$cart['cart_id']."
					 											AND `cart_product_id` = ".$product['cart_product_id'].";")->rows;	*/
					if ($product['type'] == 3) {

						$get_options = "SELECT `pocv`.*, ovd.`option_id`, `od`.`name`, `ovd`.`name` AS `value`
										FROM `".DB_PREFIX."product_option_combination_value` AS pocv, `".DB_PREFIX."option_value_description` AS `ovd`, `".DB_PREFIX."option_description` AS `od`
										WHERE pocv.`product_option_combination_id` = ".$product['id']."
										AND ovd.`language_id` = '".( int ) $this->config->get( 'config_language_id' )."'
										AND ovd.`option_value_id` = pocv.`option_value_id`
										AND `od`.`option_id` = `ovd`.`option_id`;";

						$get_options = $this->db->query($get_options)->rows;

						foreach ($get_options as &$option) {
							$option_data = "SELECT * FROM oc_product_option_value WHERE product_id = ".$product['product_id']." AND option_value_id = ".$option['option_value_id'].";";
							$option_data = $this->db->query($option_data)->rows;
							$option = array_merge($option, $option_data[0]);
						}
						$product['option'] = $get_options;
						//echo "With options ".$product['name']." ".$product['id']." type ".$product['type']." ".sizeof($product['option'])."<pre>"; print_r($product['option']);
					} elseif ($product['type'] == 2) {
						$get_options = "SELECT `pov`.*, `od`.`name`, `ovd`.`name` AS `value`
										FROM `".DB_PREFIX."product_option_value` AS `pov`, `".DB_PREFIX."option_description` AS `od`, `".DB_PREFIX."option_value_description` AS `ovd`
										WHERE `product_option_value_id` = ".$product['id']."
										AND product_id = ".$product['product_id']."
										AND `od`.`option_id` = `pov`.`option_id`
										AND `ovd`.`option_value_id` = `pov`.`option_value_id`;";

						//echo "type 2 query <pre>"; print_r($get_options);

						$product['option'] = $this->db->query($get_options)->rows;

						//echo "<br>With options ".$product['name']." ".$product['id']." type ".$product['type']." ".sizeof($product['option'])."<pre>"; print_r($product['option']);
					}

					// echo "Options ".$product['type']." <pre>"; print_r($product);

					$option_price = 0;
					$option_points = 0;
					$option_weight = 0;
					$option_data = array();

					foreach( $product['option'] as &$option )
					{
						$option_query = $this->db->query( "SELECT po.product_option_id, po.option_id, od.name, o.type
															FROM ".DB_PREFIX."product_option po
															LEFT JOIN `".DB_PREFIX."option` o ON (po.option_id = o.option_id)
															LEFT JOIN ".DB_PREFIX."option_description od ON (o.option_id = od.option_id)
															WHERE po.product_option_id = '".( int ) $option['product_option_id']."'
															AND po.product_id = '".( int ) $product['product_id']."'
															AND od.language_id = '".( int ) $this->config->get( 'config_language_id' )."'" );

						if( $option_query->num_rows )
						{
							if( $option_query->row['type'] == 'select' || $option_query->row['type'] == 'radio' || $option_query->row['type'] == 'image' )
							{
								$option_value_query = $this->db->query( "
									SELECT pov.option_value_id, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix
									FROM ".DB_PREFIX."product_option_value pov
									LEFT JOIN ".DB_PREFIX."option_value ov ON (pov.option_value_id = ov.option_value_id)
									LEFT JOIN ".DB_PREFIX."option_value_description ovd ON (ov.option_value_id = ovd.option_value_id)
									WHERE pov.product_option_value_id = '".( int ) $option['product_option_value_id']."'
									AND pov.product_option_id = '".( int ) $option['product_option_id']."'
									AND ovd.language_id = '".( int ) $this->config->get( 'config_language_id' )."'" );

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

									if( $option_value_query->row['subtract'] && (!$option_value_query->row['quantity'] || ($option_value_query->row['quantity'] < $product['quantity'])) )
									{
										$stock = false;
									}

									$option_data[] = array(
										'product_option_id' => $option['product_option_id'],
										'product_option_value_id' => $option['product_option_value_id'],
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
									//echo sizeof($cart['products'])." ".$cart['cart_id']." products<pre>"; print_r($option_data);
								}
							}
							elseif( $option_query->row['type'] == 'checkbox' && is_array( $product['product_option_value_id'] ) )
							{
								foreach( $product['product_option_value_id'] as $product_option_value_id )
								{
									$option_value_query = $this->db->query( "
										SELECT pov.option_value_id, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix
										FROM ".DB_PREFIX."product_option_value pov
										LEFT JOIN ".DB_PREFIX."option_value ov ON( pov.option_value_id = ov.option_value_id )
										LEFT JOIN ".DB_PREFIX."option_value_description ovd ON( ov.option_value_id = ovd.option_value_id )
										WHERE pov.product_option_value_id = '".( int ) $option['product_option_value_id']."'
										AND pov.product_option_id = '".( int ) $option['product_option_id']."'
										AND ovd.language_id = '".( int ) $this->config->get( 'config_language_id' )."'" );

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

										if( $option_value_query->row['subtract'] && (!$option_value_query->row['quantity'] || ($option_value_query->row['quantity'] < $product['quantity'])) )
										{
											$stock = false;
										}

										$option_data[] = array(
											'product_option_id' => $option['product_option_id'],
											'product_option_value_id' => $option['product_option_value_id'],
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
									'product_option_id' => $option['product_option_id'],
									'product_option_value_id' => '',
									'option_id' => $option_query->row['option_id'],
									'option_value_id' => '',
									'name' => $option_query->row['name'],
									'option_value' => '',
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
							//echo "option value query<pre>"; print_r($option_value_query);
						}
					}//die('avsf');

					//echo "OPTION DATA <pre>"; print_r($option_data);

					/*$option_array = array(
						$option_data[0]['product_option_id'] => $option_data[0]['product_option_value_id']
					);

					$option_data = $this->cart->buildOptionDataArray( $product['id'], $option_array );*/

					//echo "MODEL PROGRESS ".$product['model']." ".$product['name']." 1 product price ".$product['price']."<pre>"; print_r($option_data);

					$product['price'] = $this->cart->calculatePriceB2B( $product['product_id'], $option_data );

					//echo "MODEL PROGRESS ".$product['model']." ".$product['name']." 2 product price ".$product['price']." <pre>";

					$price = $product['price'];

					// END option price calculation

					/*if ($product['type'] == 3) {
						$combination_data= $this->db->query("
												SELECT price, points FROM `".DB_PREFIX."product_option_combination` WHERE `product_option_combination_id` = ".$product['id'].";
											")->row;
						$product['price'] = $combination_data['price'];
						$product['reward'] = $combination_data['points'];
					} elseif ($product['type'] == 2) {
						$product_option_value_id = $product['id'];
						$all_option_data= $this->db->query("
												SELECT product_option_id, points FROM `".DB_PREFIX."product_option_value` WHERE `product_option_value_id` = ".$product_option_value_id.";
											")->row;

						echo "<br>"."SELECT product_option_id, points FROM `".DB_PREFIX."product_option_value` WHERE `product_option_value_id` = ".$product_option_value_id.";";

						$option_data[$product_option_value_id] = array(
							'key' => $all_option_data['product_option_id']
						);
						//echo $product['name']." opt 1<pre>"; print_r($option_data);
						//print_r($all_option_data);

						$option_data = $this->cart->buildOptionDataArray( $product['id'], $option_data );

						echo $product['name']." opt 2<pre> ".$product['price']; print_r($option_data);

						$product['price'] = $this->cart->calculatePriceB2B( $product['product_id'], $option_data );
						$product['reward'] = $all_option_data['points'];
					} else {
						$product['price'] = $this->cart->calculatePriceB2B( $product['product_id'], $option_data = array() );
						$plus_data= $this->db->query("
												SELECT points FROM `".DB_PREFIX."product_reward` WHERE `product_id` = ".$product['product_id'].";
											")->row;
						if (isset($plus_data['points'])) {
							$product['reward'] = $plus_data['points'];
						} else {
							$product['reward'] = "";
						}

					}*/


					//echo "<pre>"; print_r($product['option']); die("1 SELECT * FROM `" . DB_PREFIX . "cart_product_option` WHERE `cart_id` = ".$cart['cart_id']." AND `cart_product_id` = ".$product['cart_product_id'].";");
					//echo "<pre>"; print_r($product);
					$product['total'] = $product['quantity']*$product['price'];

					//echo "MODEL AFTER product<pre>"; print_r($product);
				}
				$get_support_query = "SELECT
										  csm.*,
										  c.`firstname`,
										  c.`lastname`,
										  csp.`cart_support_product_id`,
										  csp.`product_id`,
										  pd.name,
										  csp.`model`,
										  csp.`quantity`
										FROM
										  `oc_cart_support_message` `csm`
										  LEFT JOIN `oc_cart_support_product` `csp`
											ON csm.`cart_support_message_id` = csp.`cart_support_message_id`
										  LEFT JOIN `oc_customer` `c`
											ON csm.`customer_id` = c.`customer_id`
										  LEFT JOIN `oc_product_description` `pd`
											ON csp.`product_id` = pd.`product_id`
										WHERE `csm`.cart_id = ".$cart['cart_id']."
										AND `type` IS NULL;";

				//die($get_support_query);
				$cart_support = $this->db->query($get_support_query)->rows;
				//print_r($cart_support); die('gfbdgfb');
				foreach ($cart_support as &$sup) {
					if($this->customer->getId() == $sup['customer_id']) {
						$sup['cart_owner'] = true;
					} else {
						$sup['cart_owner'] = false;
					}
					if ($sup['cart_support_product_id']) {
						$get_support_option_query = "SELECT `aspo`.*, `od`.`name` AS `od_name`, `ovd`.`name` AS `ovd_name`
												FROM `".DB_PREFIX."cart_support_product_option` `aspo`, `".DB_PREFIX."product_option` `po`, `".DB_PREFIX."option_description` `od`, `".DB_PREFIX."product_option_value` `pov`, `oc_option_value_description` `ovd`
												WHERE `cart_support_product_id` = ".$sup['cart_support_product_id']."
												AND `po`.`product_option_id` = `aspo`.`product_option_id`
												AND `od`.`option_id` = `po`.`option_id`
												AND `od`.`language_id` = 2
												AND `pov`.`product_option_value_id` = `aspo`.`product_option_value_id`
												AND `ovd`.`option_value_id` = `pov`.`option_value_id`;";
						//die($get_support_option_query);
						$sup['option'] = $this->db->query($get_support_option_query)->rows;

						//print_r($sup['option']); die('gfbdgfb');
					}

				};

				$cart['support'] = $cart_support;
				// echo "<pre>"; print_r($cart['support']); die('12 model ');
			}
		} // echo "<pre>"; print_r($connected_carts); die('1 model ');

		return $connected_carts;
	}

	public function getCartTotalData($customer_group_id, $cart_id) {
		$cart = $this->db->query("
					SELECT `cp`.*, ax.`type`, ax.`id`, p.`image`, p.`price`, p.`tax_class_id`, pd.`name`,
					(SELECT points FROM oc_product_reward WHERE product_id = p.product_id AND customer_group_id = ".$customer_group_id.") AS reward
					FROM `oc_cart_product` AS `cp`
					LEFT JOIN ax_code AS ax ON (cp.`ax_code` = ax.`ax_code`)
					LEFT JOIN oc_product AS p ON (cp.`product_id` = p.`product_id`)
					LEFT JOIN `oc_product_description` AS pd ON (cp.`product_id` = pd.`product_id`)
					WHERE `cp`.`cart_id` = ".$cart_id.";")->rows;

		$cart['sub_total'] = 0;

		foreach ($cart as &$product) {

			$product['option'] = array();

			//$product['option'] = $this->db->query("SELECT * FROM `" . DB_PREFIX . "cart_product_option` WHERE `cart_id` = ".$cart_id." AND `cart_product_id` = ".$product['cart_product_id'].";")->rows;

			if ($product['type'] == 3) {

				$get_options = "SELECT `pocv`.*, ovd.`option_id`, `od`.`name`, `ovd`.`name` AS `value`
										FROM `".DB_PREFIX."product_option_combination_value` AS pocv, `".DB_PREFIX."option_value_description` AS `ovd`, `".DB_PREFIX."option_description` AS `od`
										WHERE pocv.`product_option_combination_id` = ".$product['id']."
										AND ovd.`language_id` = '".( int ) $this->config->get( 'config_language_id' )."'
										AND ovd.`option_value_id` = pocv.`option_value_id`
										AND `od`.`option_id` = `ovd`.`option_id`;";

				$get_options = $this->db->query($get_options)->rows;

				foreach ($get_options as &$option) {
					$option_data = "SELECT * FROM oc_product_option_value WHERE product_id = ".$product['product_id']." AND option_value_id = ".$option['option_value_id'].";";
					$option_data = $this->db->query($option_data)->rows;
					$option = array_merge($option, $option_data[0]);
				}
				$product['option'] = $get_options;
				//echo "With options ".$product['name']." ".$product['id']." type ".$product['type']." ".sizeof($product['option'])."<pre>"; print_r($product['option']);
			} elseif ($product['type'] == 2) {
				$get_options = "SELECT `pov`.*, `od`.`name`, `ovd`.`name` AS `value`
										FROM `".DB_PREFIX."product_option_value` AS `pov`, `".DB_PREFIX."option_description` AS `od`, `".DB_PREFIX."option_value_description` AS `ovd`
										WHERE `product_option_value_id` = ".$product['id']."
										AND product_id = ".$product['product_id']."
										AND `od`.`option_id` = `pov`.`option_id`
										AND `ovd`.`option_value_id` = `pov`.`option_value_id`;";

				$product['option'] = $this->db->query($get_options)->rows;

				//echo "<br>With options ".$product['name']." ".$product['id']." type ".$product['type']." ".sizeof($product['option'])."<pre>"; print_r($product['option']);
			}

			$option_price = 0;
			$option_points = 0;
			$option_weight = 0;
			$option_data = array();

			foreach( $product['option'] as $option ) {

				$option_query = $this->db->query( "SELECT po.product_option_id, po.option_id, od.name, o.type
															FROM ".DB_PREFIX."product_option po
															LEFT JOIN `".DB_PREFIX."option` o ON (po.option_id = o.option_id)
															LEFT JOIN ".DB_PREFIX."option_description od ON (o.option_id = od.option_id)
															WHERE po.product_option_id = '".( int ) $option['product_option_id']."'
															AND po.product_id = '".( int ) $product['product_id']."'
															AND od.language_id = '".( int ) $this->config->get( 'config_language_id' )."'" );

				if( $option_query->num_rows )
				{
					if( $option_query->row['type'] == 'select' || $option_query->row['type'] == 'radio' || $option_query->row['type'] == 'image' )
					{
						$option_value_query = $this->db->query( "
									SELECT pov.option_value_id, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix
									FROM ".DB_PREFIX."product_option_value pov
									LEFT JOIN ".DB_PREFIX."option_value ov ON (pov.option_value_id = ov.option_value_id)
									LEFT JOIN ".DB_PREFIX."option_value_description ovd ON (ov.option_value_id = ovd.option_value_id)
									WHERE pov.product_option_value_id = '".( int ) $option['product_option_value_id']."'
									AND pov.product_option_id = '".( int ) $option['product_option_id']."'
									AND ovd.language_id = '".( int ) $this->config->get( 'config_language_id' )."'" );

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

							if( $option_value_query->row['subtract'] && (!$option_value_query->row['quantity'] || ($option_value_query->row['quantity'] < $product['quantity'])) )
							{
								$stock = false;
							}

							$option_data[] = array(
								'product_option_id' => $option['product_option_id'],
								'product_option_value_id' => $option['product_option_value_id'],
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
							//echo sizeof($cart['products'])." ".$cart['cart_id']." products<pre>"; print_r($option_data);
						}
					}
					elseif( $option_query->row['type'] == 'checkbox' && is_array( $product['product_option_value_id'] ) )
					{
						foreach( $product['product_option_value_id'] as $product_option_value_id )
						{
							$option_value_query = $this->db->query( "
										SELECT pov.option_value_id, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix
										FROM ".DB_PREFIX."product_option_value pov
										LEFT JOIN ".DB_PREFIX."option_value ov ON( pov.option_value_id = ov.option_value_id )
										LEFT JOIN ".DB_PREFIX."option_value_description ovd ON( ov.option_value_id = ovd.option_value_id )
										WHERE pov.product_option_value_id = '".( int ) $option['product_option_value_id']."'
										AND pov.product_option_id = '".( int ) $option['product_option_id']."'
										AND ovd.language_id = '".( int ) $this->config->get( 'config_language_id' )."'" );

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

								if( $option_value_query->row['subtract'] && (!$option_value_query->row['quantity'] || ($option_value_query->row['quantity'] < $product['quantity'])) )
								{
									$stock = false;
								}

								$option_data[] = array(
									'product_option_id' => $option['product_option_id'],
									'product_option_value_id' => $option['product_option_value_id'],
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
							'product_option_id' => $option['product_option_id'],
							'product_option_value_id' => '',
							'option_id' => $option_query->row['option_id'],
							'option_value_id' => '',
							'name' => $option_query->row['name'],
							'option_value' => '',
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
					//echo "option value query<pre>"; print_r($option_value_query);
				}
			}

			$product['price'] = $this->cart->calculatePriceB2B( $product['product_id'], $option_data );

			$product['total'] = $product['quantity']*$product['price'];

			if( $product['tax_class_id'] )
			{
				$tax_rates = $this->tax->getRates( $product['price'], $product['tax_class_id'] );

				foreach( $tax_rates as $tax_rate )
				{
					if( !isset( $tax_data[$tax_rate['tax_rate_id']] ) )
					{
						$cart['tax'] = ($tax_rate['amount'] * $product['quantity']);
					}
					else
					{
						$cart['tax'] += ($tax_rate['amount'] * $product['quantity']);
					}
				}
			}

			if( ($this->config->get( 'config_customer_price' ) && $this->customer->isLogged()) || !$this->config->get( 'config_customer_price' ) )
			{
				$product['total'] = $this->currency->format( $this->tax->calculate( $product['price'], $product['tax_class_id'], $this->config->get( 'config_tax' ) ) * $product['quantity'] );
				$cart['sub_total'] += $product['total'];
			}
			else
			{
				$product['total'] = false;
			}

		}

		//echo "<pre>"; print_r($cart); die('sdvsdv');

		$cart['total'] = $cart['sub_total'] + $cart['tax'];

		return $cart;
	}

	public function saveCart($data) {

		$new_cart = "INSERT INTO `" . DB_PREFIX . "cart` SET cart_name = '" . $this->db->escape($data['cart_name']) . "', store_id = '" . (int)$data['store_id'] . "', customer_id = '" . (int)$data['customer_id'] . "', customer_group_id = '" . (int)$data['customer_group_id'] . "', language_id = '" . (int)$data['language_id'] . "', date_added = NOW(), date_modified = NOW()";

		$this->db->query($new_cart);

		$cart_id = $this->db->getLastId();

		foreach ($data['products'] as $product) {

			$ax_code = '';

			if (sizeof($product['option']) == 0) {
				$ax_code = $this->getProductAxCode(1, $product, '', '');
			} elseif (sizeof($product['option']) == 1) {
				$ax_code = $this->getProductAxCode(2, $product, '', $product['option'][0]['product_option_value_id']);
			} elseif (sizeof($product['option']) == 2) {
				$ax_code = $this->getProductAxCode(3, $product, $product['option'], '');
			}

			$new_product = "INSERT INTO " . DB_PREFIX . "cart_product SET cart_id = '" . (int)$cart_id . "', product_id = '" . (int)$product['product_id'] . "', ax_code = '".$ax_code."', model = '" . $this->db->escape($product['model']) . "', quantity = '" . (int)$product['quantity'] . "';";

			//echo "model save cart<pre>"; print_r($new_product);

			$this->db->query($new_product);
		}

		//die('sdvasdvs');

		return $cart_id;

	}

	public function update_cart($cart_id, $ax_code, $quantity) {

        $query = "SELECT quantity FROM oc_cart_product WHERE cart_id = ".$cart_id." AND ax_code = '".$ax_code."';";
        $old_quantity = $this->db->query($query)->row['quantity'];

        $new_quantity = (int)$old_quantity + (int)$quantity;

		//die($cart_id." ".$ax_code." ".$quantity);
        $query = "UPDATE oc_cart_product SET quantity = ".$new_quantity." WHERE cart_id = ".$cart_id." AND ax_code = '".$ax_code."';";
        //die($old_quantity.'o '.$quantity.'q '.$new_quantity.'n opencart/catalog/model/checkout/cart.php:974 '.$query);
		$response = $this->db->query($query);

        $check_if_cart_have_support = "SELECT * FROM oc_cart_support WHERE cart_id = ".$cart_id.";";
        //echo $check_if_cart_have_support."<br>";
        $check_if_cart_have_support = $this->db->query($check_if_cart_have_support)->row;

        /*
        echo "<pre>";
        print_r($check_if_cart_have_support);
        */

        if($check_if_cart_have_support){

            $get_prod_data_by_ax = "SELECT * FROM ax_code WHERE ax_code = '".$ax_code."';";
            $prod_data_by_ax = $this->db->query($get_prod_data_by_ax)->row;

            $add_action = "INSERT INTO `oc_cart_support_message`
                                SET
                                `cart_support_id` = ".$check_if_cart_have_support['cart_support_id'].",
                                `customer_id` = ".$check_if_cart_have_support['customer_id'].",
                                `cart_id` = ".$cart_id.",
                                `type` = 'history',
                                `message` = 'a adaugat ".$prod_data_by_ax['product_name']." ".$prod_data_by_ax['upc']."',
                                `date_added` = NOW();";

            //die($add_action);

            $this->db->query($add_action);
        }

		return $response;
	}

	public function insert_to_saved_cart($cart_id, $ax_code, $quantity) {
		//die('itt van model '.$cart_id." ".$ax_code." ".$quantity);
		//$upc = substr($ax_code, 0 ,strpos($ax_code, '-'));
		$upc = "SELECT `upc` FROM `ax_code` WHERE `ax_code` = '".$ax_code."';";

		//die($upc);
		$upc = $this->db->query($upc)->row['upc'];
		//var_dump($upc); die("insert");
		$product_data = "SELECT `product_id` FROM `oc_product` WHERE `upc` = '".$upc."';";
		$product_data = $this->db->query($product_data)->row;
		//var_dump($product_data); die("insert");
		$insert = "INSERT INTO " . DB_PREFIX . "cart_product SET cart_id = " . (int)$cart_id . ", product_id = " . (int)$product_data['product_id'] . ", ax_code = '".$ax_code."', model = '" . $this->db->escape($upc) . "', quantity = " . (int)$quantity . ";";

		$response = $this->db->query($insert);

        $check_if_cart_have_support = "SELECT * FROM oc_cart_support WHERE cart_id = ".$cart_id.";";
        //echo $check_if_cart_have_support."<br>";
        $check_if_cart_have_support = $this->db->query($check_if_cart_have_support)->row;

        /*
        echo "<pre>";
        print_r($check_if_cart_have_support);
        */

        if($check_if_cart_have_support){

            $get_prod_data_by_ax = "SELECT * FROM ax_code WHERE ax_code = '".$ax_code."';";
            $prod_data_by_ax = $this->db->query($get_prod_data_by_ax)->row;

            $add_action = "INSERT INTO `oc_cart_support_message`
                                SET
                                `cart_support_id` = ".$check_if_cart_have_support['cart_support_id'].",
                                `customer_id` = ".$check_if_cart_have_support['customer_id'].",
                                `cart_id` = ".$cart_id.",
                                `type` = 'history',
                                `message` = 'a adaugat ".$prod_data_by_ax['product_name']." ".$prod_data_by_ax['upc']."',
                                `date_added` = NOW();";

            //die($add_action);

            $this->db->query($add_action);
        }

		//die($response." inserted ".$insert);
		return $response;
	}

	public function deleteCart($cart_id, $customer_id) {

		//$this->db->query("UPDATE `oc_cart_product_option` SET  WHERE `cart_id` = ".$cart_id.";");
		$this->db->query("UPDATE `oc_cart_product` SET date_deleted = NOW() WHERE `cart_id` = ".$cart_id.";");
		$this->db->query("UPDATE `oc_cart` SET date_deleted = NOW() WHERE `cart_id` = ".$cart_id." AND `customer_id` = ".$customer_id.";");
	}

	public function restore_activated_cart($cart_id){
		$this->db->query("UPDATE `oc_cart_product` SET date_deleted = NULL WHERE `cart_id` = ".$cart_id.";");

		return $this->db->query("UPDATE `oc_cart` SET date_deleted = NULL WHERE `cart_id` = ".$cart_id.";");
	}

	public function getProductAxCode( $type, $product, $option_data = array( ), $Id = 0 )
	{

		$concatenated_code = '';

		if( $type == 1 ) // product
		{
			$query = "SELECT axc.ax_code as concatenated_code FROM ax_code axc WHERE axc.type= 1 AND axc.id = '".( int ) $product['product_id']."' ";
			//die('m1m '.$query);
			$query = $this->db->query( $query );
			if( $query->num_rows > 0 )
			{
				$concatenated_code = $query->row['concatenated_code'];
			}
		}
		else if( $type == 2 ) // option
		{
			$query = "SELECT axc.ax_code as concatenated_code FROM ax_code axc WHERE axc.type= 2 AND axc.id = '".( int ) $Id."' ";
			//print('dzfabdfbm2m '.$query);
			$query = $this->db->query( $query );
			if( $query->num_rows > 0 )
			{
				$concatenated_code = $query->row['concatenated_code'];
			}
		}
		else if( $type == 3 )  // option_combination
		{
			$query3 = "SELECT poc.`product_option_combination_id`, poc.`product_id`, pocv.`option_value_id`, COUNT(poc.`product_option_combination_id`),
											(SELECT ax_code.`ax_code`
											FROM ax_code
											WHERE `type` = 3 AND `id` = `poc`.`product_option_combination_id`AND `upc` LIKE '".$product['model']."') AS concatenated_code
										FROM `oc_product_option_combination` poc, `oc_product_option_combination_value` pocv
										WHERE pocv.`option_value_id` IN (".$option_data[0]['option_value_id'].",".$option_data[1]['option_value_id'].")
												AND poc.`product_option_combination_id` = pocv.`product_option_combination_id`
												AND poc.`product_id` = ".$product['product_id']."
										GROUP BY pocv.`product_option_combination_id`
										HAVING COUNT(poc.`product_option_combination_id`) = 2";
			//die('m3m '.$query3);
			$query3 = $this->db->query( $query3 );
			if( $query3->num_rows > 0 )
			{
				$concatenated_code = $query3->row['concatenated_code'];
			}
		}
		return $concatenated_code;
	}

	public function new_support_content($logged_customer_id, $support_data){
		//print_r($support_data); die('adfbdabf');
		$check_support = "SELECT * FROM " . DB_PREFIX . "cart_support WHERE cart_id = ".$support_data['cart_id'].";";
		$check_support = $this->db->query($check_support);

		if ($check_support->row) {
			$cart_support_id = $check_support->row['cart_support_id'];
		} else {
            $get_cart_products = "SELECT * FROM " . DB_PREFIX . "cart_product WHERE cart_id = " . $support_data['cart_id'] .";";
            $cart_products = $this->db->query($get_cart_products)->rows;
            //die('advdvfasfbdf '.$get_cart_products);

            if($cart_products) {
                foreach ($cart_products as $prod) {
                    $query = "INSERT INTO `" . DB_PREFIX . "cart_support_product_at_begin`
                                SET `cart_id` = " . $prod['cart_id'] . ",
                                `product_id` = ".$prod['product_id'].",
                                `ax_code` = '".$prod['ax_code']."',
                                `model` = '".$prod['model']."',
                                `quantity` = '".$prod['quantity']."';";
                    $this->db->query($query);
                }
            }

			$insert_query = "INSERT INTO " . DB_PREFIX . "cart_support SET customer_id = " . $logged_customer_id . ", cart_id = " . $support_data['cart_id'] . ", `status_id` = 1, date_added = '" . date('Y-m-d H:m:s') . "';";
			$insert_query = $this->db->query($insert_query);
			$cart_support_id = $this->db->getLastId();
		}

		if ($cart_support_id) {

			$insert_message = "INSERT INTO " . DB_PREFIX . "cart_support_message SET cart_support_id = ".$cart_support_id.", customer_id = ".$logged_customer_id.", cart_id = ".$support_data['cart_id'].", subject = '".$support_data['support_subject']."', message = '".$support_data['support_message']."', `status_id` = 1, date_added = '".date('Y-m-d H:m:s')."';";

			$insert_message = $this->db->query($insert_message);

			if ($support_data['product_id'] && $support_data['filter_model'] && $insert_message) {

				if (sizeof($support_data['option']) == 2) {
					$type = 3;
					foreach ($support_data['option'] as $key => $opt) {
						$product_optin_value_id_array[]['option_value_id'] = $opt;
					}

					$get_option_value_id = "SELECT option_value_id FROM oc_product_option_value
											WHERE product_id = ".$support_data['product_id']."
											AND product_option_value_id IN (".$product_optin_value_id_array[0]['option_value_id'].", ".$product_optin_value_id_array[1]['option_value_id'].");" ;

					$option_data = $this->db->query($get_option_value_id)->rows;
					$support_data['model'] = $support_data['filter_model'];

					$ax_code = $this->getProductAxCode(3, $support_data, $option_data, '');
					//die('dfbdgfb '.$ax_code);
				} elseif (sizeof($support_data['option']) == 1) {
					$type = 2;
					$ax_code = $this->getProductAxCode(2, $support_data, '', reset($support_data['option']));
				} else {
					$type = 1;
					$ax_code = $this->getProductAxCode(1, $support_data, '', '');
				}

				$cart_support_message_id = $this->db->getLastId();
				$insert_cart_support_product = "INSERT INTO " . DB_PREFIX . "cart_support_product SET `cart_support_message_id` = ".$cart_support_message_id.", `cart_id` = ".$support_data['cart_id'].", `product_id` = ".$support_data['product_id'].", `model` = '".$support_data['filter_model']."', `ax_code` = '".$ax_code."', `quantity` = ".$support_data['quantity'].";";
				//print('pr '.$insert_cart_support_product);
				$insert_cart_support_product = $this->db->query($insert_cart_support_product);

				$cart_support_product_id = $this->db->getLastId();
				//echo ' product inserted | ';
				if ($insert_cart_support_product && $support_data['option']) {
					//echo ' product have options | ';
					if (is_array($support_data['option']) && sizeof($support_data['option']) > 1) {
						//echo 'option ok before foreach ';
						foreach ($support_data['option'] as $key => $opt) {

							$insert_option = "INSERT INTO " . DB_PREFIX . "cart_support_product_option SET `cart_support_product_id` = ".$cart_support_product_id.", `product_id` = ".$support_data['product_id'].", `product_option_id` = ".$key.", `product_option_value_id` = ".$opt.";";

							$insert_option = $this->db->query($insert_option);
						}

						if ($insert_option) {
							//die('model options inserted');
							return $return['support_product_id'] = $cart_support_product_id;
						} else {
							die('support option error');
						}
					}
					return $return['support_product_id'] = $cart_support_product_id;
					//$insert_option = "INSERT INTO " . DB_PREFIX . "cart_support_product_option SET `cart_support_product_id` = ".$cart_support_product_id.", `product_id` = ".$product_id.", `product_option_id` = ".$product_option_id.", `product_option_value_id` = ".$product_option_value_id.";";
					//$insert_option = $this->db->query($insert_option);

				} elseif ($insert_cart_support_product && !$support_data['option']) {
					return $return['support_product_id'] = $cart_support_product_id;
				} elseif (!$insert_cart_support_product) {
					die('support product error');
				}
			}
			else
			{
				return $cart_support_id;
			}
		} else {
			die('support model error '.$insert_query);
		}
	}

	public function add_customer_to_support($customer_id, $support_new_customer_data) {
		$get_cart_owner_id = "SELECT DISTINCT cart_support_id, customer_id FROM `oc_cart_support` WHERE cart_id = ".$support_new_customer_data['cart_id'].";";
		$get_cart_owner_id = $this->db->query($get_cart_owner_id)->row;

		$get_cart_name = "SELECT cart_name FROM `oc_cart` WHERE cart_id = ".$support_new_customer_data['cart_id'].";";
		$get_cart_name = $this->db->query($get_cart_name)->row['cart_name'];

		if ($get_cart_owner_id) {

			$add_action = "INSERT INTO `".DB_PREFIX."cart_support_added_customer`
							SET `cart_support_id` = ".$get_cart_owner_id['cart_support_id'].",
								`added_customer_id` = ".$support_new_customer_data['customer_to_support'].",
								`cart_id` = ".$support_new_customer_data['cart_id'].",
								`owner_customer_id` = ".$get_cart_owner_id['customer_id'].",
								`date_added` = NOW() ;";

			$add_action = $this->db->query($add_action);

			if($add_action) {

				$get_added_customer_data = "SELECT
											  firstname,
											  lastname,
											  email
											FROM
											  oc_customer
											WHERE customer_id = ".$support_new_customer_data['customer_to_support']."
											  AND `customer_group_id` IN (3, 4) ;";

				$get_added_customer_data = $this->db->query($get_added_customer_data)->row;

				$get_owner_customer_data = "SELECT
											  firstname,
											  lastname,
											  email
											FROM
											  oc_customer
											WHERE customer_id = ".$get_cart_owner_id['customer_id']."
											  AND `customer_group_id` IN (3, 4) ;";

				$get_owner_customer_data = $this->db->query($get_owner_customer_data)->row;

				if($get_added_customer_data && $get_owner_customer_data) {

					$return_array = $get_added_customer_data;
					$return_array['owner_data'] = $get_owner_customer_data;
					$return_array['cart_name'] = $get_cart_name;

					return $return_array;

				} else {

					die('cant find customer data');

				}

				return true;
			} else {
				return false;
			}

		} else {
			return false;
		}
	}

	public function getB2BUsers() {
		$query = "SELECT customer_id, firstname, lastname, ax_code, email FROM `oc_customer` WHERE `customer_group_id` IN (3,4);";
		$query = $this->db->query($query);

		return $query->rows;
	}

	public function getSupportCarts($customer_id = 0) { // If B2B customer is admin too, than get all support from all custmers

		$support_carts = "SELECT `ocs`.*, cus.firstname, cus.lastname, oc.cart_name
							FROM `oc_cart_support` AS `ocs`,
							 	 `oc_customer` AS `cus`,
							 	 `oc_cart` AS `oc`
							WHERE cus.customer_id = ocs.customer_id
							AND oc.cart_id = ocs.cart_id
							AND oc.date_deleted IS NULL
							ORDER BY ocs.cart_support_id DESC
							LIMIT 0, 25;";

		//die($support_carts);

		$support_carts = $this->db->query($support_carts)->rows;
		//echo "<pre>"; print_r($support_carts);

		if ($support_carts) {
			//echo sizeof($saved_carts)."<pre>";
			foreach ($support_carts as &$cart) {

				$cart_products = "SELECT `cp`.*, ax.`type`, ax.`id`, p.`image`, p.`price`, p.`tax_class_id`, pd.`name`,
										(SELECT points FROM oc_product_reward WHERE product_id = p.product_id AND customer_group_id = 3) AS reward
										FROM `oc_cart_product` AS `cp`
										LEFT JOIN ax_code AS ax ON (cp.`ax_code` = ax.`ax_code`)
										LEFT JOIN oc_product AS p ON (cp.`product_id` = p.`product_id`)
										LEFT JOIN `oc_product_description` AS pd ON (cp.`product_id` = pd.`product_id`)
										WHERE `cp`.`cart_id` = ".$cart['cart_id'].";";
				//die('model '.$cart_products);
				$cart['products'] = $this->db->query($cart_products)->rows;
				//echo "<pre>"; print_r($cart['products']); die('model dfbdzfb');

				foreach ($cart['products'] as &$product) {

					//echo "product before <pre>"; print_r($product);

					$product['href'] = $this->url->link( 'product/product', 'product_id='.$product['product_id'] );

					$product['option'] = array();
					/* $product['option'] = $this->db->query("SELECT * FROM `" . DB_PREFIX . "cart_product_option`
																 WHERE `cart_id` = ".$cart['cart_id']."
																 AND `cart_product_id` = ".$product['cart_product_id'].";")->rows;	*/
					if ($product['type'] == 3) {

						$get_options = "SELECT `pocv`.*, ovd.`option_id`, `od`.`name`, `ovd`.`name` AS `value`
									FROM `".DB_PREFIX."product_option_combination_value` AS pocv, `".DB_PREFIX."option_value_description` AS `ovd`, `".DB_PREFIX."option_description` AS `od`
									WHERE pocv.`product_option_combination_id` = ".$product['id']."
									AND ovd.`language_id` = '".( int ) $this->config->get( 'config_language_id' )."'
									AND ovd.`option_value_id` = pocv.`option_value_id`
									AND `od`.`option_id` = `ovd`.`option_id`;";

						$get_options = $this->db->query($get_options)->rows;

						foreach ($get_options as &$option) {
							$option_data = "SELECT * FROM oc_product_option_value WHERE product_id = ".$product['product_id']." AND option_value_id = ".$option['option_value_id'].";";
							$option_data = $this->db->query($option_data)->rows;
							$option = array_merge($option, $option_data[0]);
						}
						$product['option'] = $get_options;
						//echo "With options ".$product['name']." ".$product['id']." type ".$product['type']." ".sizeof($product['option'])."<pre>"; print_r($product['option']);
					} elseif ($product['type'] == 2) {
						$get_options = "SELECT `pov`.*, `od`.`name`, `ovd`.`name` AS `value`
									FROM `".DB_PREFIX."product_option_value` AS `pov`, `".DB_PREFIX."option_description` AS `od`, `".DB_PREFIX."option_value_description` AS `ovd`
									WHERE `product_option_value_id` = ".$product['id']."
									AND product_id = ".$product['product_id']."
									AND `od`.`option_id` = `pov`.`option_id`
									AND `ovd`.`option_value_id` = `pov`.`option_value_id`;";

						//echo "type 2 query <pre>"; print_r($get_options);

						$product['option'] = $this->db->query($get_options)->rows;

						//echo "<br>With options ".$product['name']." ".$product['id']." type ".$product['type']." ".sizeof($product['option'])."<pre>"; print_r($product['option']);
					}

					// echo "Options ".$product['type']." <pre>"; print_r($product);

					$option_price = 0;
					$option_points = 0;
					$option_weight = 0;
					$option_data = array();

					foreach( $product['option'] as &$option ) {
						$option_query = $this->db->query( "SELECT po.product_option_id, po.option_id, od.name, o.type
														FROM ".DB_PREFIX."product_option po
														LEFT JOIN `".DB_PREFIX."option` o ON (po.option_id = o.option_id)
														LEFT JOIN ".DB_PREFIX."option_description od ON (o.option_id = od.option_id)
														WHERE po.product_option_id = '".( int ) $option['product_option_id']."'
														AND po.product_id = '".( int ) $product['product_id']."'
														AND od.language_id = '".( int ) $this->config->get( 'config_language_id' )."'" );

						if( $option_query->num_rows ) {

							if( $option_query->row['type'] == 'select' || $option_query->row['type'] == 'radio' || $option_query->row['type'] == 'image' )
							{
								$option_value_query = $this->db->query( "
								SELECT pov.option_value_id, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix
								FROM ".DB_PREFIX."product_option_value pov
								LEFT JOIN ".DB_PREFIX."option_value ov ON (pov.option_value_id = ov.option_value_id)
								LEFT JOIN ".DB_PREFIX."option_value_description ovd ON (ov.option_value_id = ovd.option_value_id)
								WHERE pov.product_option_value_id = '".( int ) $option['product_option_value_id']."'
								AND pov.product_option_id = '".( int ) $option['product_option_id']."'
								AND ovd.language_id = '".( int ) $this->config->get( 'config_language_id' )."'" );

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

									if( $option_value_query->row['subtract'] && (!$option_value_query->row['quantity'] || ($option_value_query->row['quantity'] < $product['quantity'])) )
									{
										$stock = false;
									}

									$option_data[] = array(
										'product_option_id' => $option['product_option_id'],
										'product_option_value_id' => $option['product_option_value_id'],
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
									//echo sizeof($cart['products'])." ".$cart['cart_id']." products<pre>"; print_r($option_data);
								}
							}
							elseif( $option_query->row['type'] == 'checkbox' && is_array( $product['product_option_value_id'] ) )
							{
								foreach( $product['product_option_value_id'] as $product_option_value_id )
								{
									$option_value_query = $this->db->query( "
									SELECT pov.option_value_id, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix
									FROM ".DB_PREFIX."product_option_value pov
									LEFT JOIN ".DB_PREFIX."option_value ov ON( pov.option_value_id = ov.option_value_id )
									LEFT JOIN ".DB_PREFIX."option_value_description ovd ON( ov.option_value_id = ovd.option_value_id )
									WHERE pov.product_option_value_id = '".( int ) $option['product_option_value_id']."'
									AND pov.product_option_id = '".( int ) $option['product_option_id']."'
									AND ovd.language_id = '".( int ) $this->config->get( 'config_language_id' )."'" );

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

										if( $option_value_query->row['subtract'] && (!$option_value_query->row['quantity'] || ($option_value_query->row['quantity'] < $product['quantity'])) )
										{
											$stock = false;
										}

										$option_data[] = array(
											'product_option_id' => $option['product_option_id'],
											'product_option_value_id' => $option['product_option_value_id'],
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
									'product_option_id' => $option['product_option_id'],
									'product_option_value_id' => '',
									'option_id' => $option_query->row['option_id'],
									'option_value_id' => '',
									'name' => $option_query->row['name'],
									'option_value' => '',
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
							//echo "option value query<pre>"; print_r($option_value_query);
						}
					}//die('avsf');

					//echo "OPTION DATA <pre>"; print_r($option_data);

					/*$option_array = array(
						$option_data[0]['product_option_id'] => $option_data[0]['product_option_value_id']
					);

					$option_data = $this->cart->buildOptionDataArray( $product['id'], $option_array );*/

					//echo "MODEL PROGRESS ".$product['model']." ".$product['name']." 1 product price ".$product['price']."<pre>"; print_r($option_data);

					$product['price'] = $this->cart->calculatePriceB2B( $product['product_id'], $option_data );

					//echo "MODEL PROGRESS ".$product['model']." ".$product['name']." 2 product price ".$product['price']." <pre>";

					$price = $product['price'];

					// END option price calculation

					/*if ($product['type'] == 3) {
						$combination_data= $this->db->query("
												SELECT price, points FROM `".DB_PREFIX."product_option_combination` WHERE `product_option_combination_id` = ".$product['id'].";
											")->row;
						$product['price'] = $combination_data['price'];
						$product['reward'] = $combination_data['points'];
					} elseif ($product['type'] == 2) {
						$product_option_value_id = $product['id'];
						$all_option_data= $this->db->query("
												SELECT product_option_id, points FROM `".DB_PREFIX."product_option_value` WHERE `product_option_value_id` = ".$product_option_value_id.";
											")->row;

						echo "<br>"."SELECT product_option_id, points FROM `".DB_PREFIX."product_option_value` WHERE `product_option_value_id` = ".$product_option_value_id.";";

						$option_data[$product_option_value_id] = array(
							'key' => $all_option_data['product_option_id']
						);
						//echo $product['name']." opt 1<pre>"; print_r($option_data);
						//print_r($all_option_data);

						$option_data = $this->cart->buildOptionDataArray( $product['id'], $option_data );

						echo $product['name']." opt 2<pre> ".$product['price']; print_r($option_data);

						$product['price'] = $this->cart->calculatePriceB2B( $product['product_id'], $option_data );
						$product['reward'] = $all_option_data['points'];
					} else {
						$product['price'] = $this->cart->calculatePriceB2B( $product['product_id'], $option_data = array() );
						$plus_data= $this->db->query("
												SELECT points FROM `".DB_PREFIX."product_reward` WHERE `product_id` = ".$product['product_id'].";
											")->row;
						if (isset($plus_data['points'])) {
							$product['reward'] = $plus_data['points'];
						} else {
							$product['reward'] = "";
						}

					}*/


					//echo "<pre>"; print_r($product['option']); die("1 SELECT * FROM `" . DB_PREFIX . "cart_product_option` WHERE `cart_id` = ".$cart['cart_id']." AND `cart_product_id` = ".$product['cart_product_id'].";");
					//echo "<pre>"; print_r($product);
					$product['total'] = $product['quantity']*$product['price'];

					//echo "MODEL AFTER product<pre>"; print_r($product);
				}
				$get_support_query = "SELECT
									  csm.*,
									  c.`firstname`,
									  c.`lastname`,
									  csp.`cart_support_product_id`,
									  csp.`product_id`,
									  pd.name,
									  csp.`model`,
									  csp.`quantity`,
									  p.`price`,
									  p.`tax_class_id`
									FROM
									  `oc_cart_support_message` `csm`
									  LEFT JOIN `oc_cart_support_product` `csp`
										ON csm.`cart_support_message_id` = csp.`cart_support_message_id`
									  LEFT JOIN `oc_customer` `c`
										ON csm.`customer_id` = c.`customer_id`
									  LEFT JOIN `oc_product` `p`
										ON csp.`product_id` = p.`product_id`
									  LEFT JOIN `oc_product_description` `pd`
										ON csp.`product_id` = pd.`product_id`
									WHERE `csm`.cart_id = ".$cart['cart_id']."
									AND `type` IS NULL;";

				//die($get_support_query);
				$cart_support = $this->db->query($get_support_query)->rows;
				//print_r($cart_support); die('gfbdgfb');
				foreach ($cart_support as &$sup) {
					if($this->customer->getId() == $sup['customer_id']) {
						$sup['cart_owner'] = true;
					} else {
						$sup['cart_owner'] = false;
					}
					if ($sup['cart_support_product_id']) {
						$get_support_option_query = "SELECT `aspo`.*, `od`.`name` AS `od_name`, `ovd`.`name` AS `ovd_name`
											FROM `".DB_PREFIX."cart_support_product_option` `aspo`, `".DB_PREFIX."product_option` `po`, `".DB_PREFIX."option_description` `od`, `".DB_PREFIX."product_option_value` `pov`, `oc_option_value_description` `ovd`
											WHERE `cart_support_product_id` = ".$sup['cart_support_product_id']."
											AND `po`.`product_option_id` = `aspo`.`product_option_id`
											AND `od`.`option_id` = `po`.`option_id`
											AND `od`.`language_id` = 2
											AND `pov`.`product_option_value_id` = `aspo`.`product_option_value_id`
											AND `ovd`.`option_value_id` = `pov`.`option_value_id`;";
						//die($get_support_option_query);
						$sup['option'] = $this->db->query($get_support_option_query)->rows;

						//print_r($sup['option']); die('gfbdgfb');
					}

				};

				$cart['support'] = $cart_support;
				// echo "<pre>"; print_r($cart['support']); die('12 model ');
			}
		}

		return $support_carts;
	}

	public function getMySupportCarts($customer_id = 0) { // If B2B customer is admin too, than get all support from all custmers

		$my_support_carts = "SELECT `ocs`.*, cus.firstname, cus.lastname, oc.cart_name
							FROM `oc_cart_support` AS `ocs`,
							 	 `oc_customer` AS `cus`,
							 	 `oc_cart` AS `oc`
							WHERE ocs.customer_id = ".$customer_id."
							AND cus.customer_id = ocs.customer_id
							AND oc.cart_id = ocs.cart_id
							AND oc.date_deleted IS NULL
							ORDER BY ocs.cart_support_id DESC
							LIMIT 0, 25;";

		//die($my_support_carts);

		$my_support_carts = $this->db->query($my_support_carts)->rows;
		//echo "<pre>"; print_r($support_carts);

		if ($my_support_carts) {
			//echo sizeof($saved_carts)."<pre>";
			foreach ($my_support_carts as &$cart) {

				$cart_products = "SELECT `cp`.*, ax.`type`, ax.`id`, p.`image`, p.`price`, p.`tax_class_id`, pd.`name`,
										(SELECT points FROM oc_product_reward WHERE product_id = p.product_id AND customer_group_id = 3) AS reward
										FROM `oc_cart_product` AS `cp`
										LEFT JOIN ax_code AS ax ON (cp.`ax_code` = ax.`ax_code`)
										LEFT JOIN oc_product AS p ON (cp.`product_id` = p.`product_id`)
										LEFT JOIN `oc_product_description` AS pd ON (cp.`product_id` = pd.`product_id`)
										WHERE `cp`.`cart_id` = ".$cart['cart_id'].";";
				//die('model '.$cart_products);
				$cart['products'] = $this->db->query($cart_products)->rows;
				//echo "<pre>"; print_r($cart['products']); die('model dfbdzfb');

				foreach ($cart['products'] as &$product) {

					//echo "product before <pre>"; print_r($product);

					$product['href'] = $this->url->link( 'product/product', 'product_id='.$product['product_id'] );

					$product['option'] = array();
					/* $product['option'] = $this->db->query("SELECT * FROM `" . DB_PREFIX . "cart_product_option`
																 WHERE `cart_id` = ".$cart['cart_id']."
																 AND `cart_product_id` = ".$product['cart_product_id'].";")->rows;	*/
					if ($product['type'] == 3) {

						$get_options = "SELECT `pocv`.*, ovd.`option_id`, `od`.`name`, `ovd`.`name` AS `value`
									FROM `".DB_PREFIX."product_option_combination_value` AS pocv, `".DB_PREFIX."option_value_description` AS `ovd`, `".DB_PREFIX."option_description` AS `od`
									WHERE pocv.`product_option_combination_id` = ".$product['id']."
									AND ovd.`language_id` = '".( int ) $this->config->get( 'config_language_id' )."'
									AND ovd.`option_value_id` = pocv.`option_value_id`
									AND `od`.`option_id` = `ovd`.`option_id`;";

						$get_options = $this->db->query($get_options)->rows;

						foreach ($get_options as &$option) {
							$option_data = "SELECT * FROM oc_product_option_value WHERE product_id = ".$product['product_id']." AND option_value_id = ".$option['option_value_id'].";";
							$option_data = $this->db->query($option_data)->rows;
							$option = array_merge($option, $option_data[0]);
						}
						$product['option'] = $get_options;
						//echo "With options ".$product['name']." ".$product['id']." type ".$product['type']." ".sizeof($product['option'])."<pre>"; print_r($product['option']);
					} elseif ($product['type'] == 2) {
						$get_options = "SELECT `pov`.*, `od`.`name`, `ovd`.`name` AS `value`
									FROM `".DB_PREFIX."product_option_value` AS `pov`, `".DB_PREFIX."option_description` AS `od`, `".DB_PREFIX."option_value_description` AS `ovd`
									WHERE `product_option_value_id` = ".$product['id']."
									AND product_id = ".$product['product_id']."
									AND `od`.`option_id` = `pov`.`option_id`
									AND `ovd`.`option_value_id` = `pov`.`option_value_id`;";

						//echo "type 2 query <pre>"; print_r($get_options);

						$product['option'] = $this->db->query($get_options)->rows;

						//echo "<br>With options ".$product['name']." ".$product['id']." type ".$product['type']." ".sizeof($product['option'])."<pre>"; print_r($product['option']);
					}

					// echo "Options ".$product['type']." <pre>"; print_r($product);

					$option_price = 0;
					$option_points = 0;
					$option_weight = 0;
					$option_data = array();

					foreach( $product['option'] as &$option ) {
						$option_query = $this->db->query( "SELECT po.product_option_id, po.option_id, od.name, o.type
														FROM ".DB_PREFIX."product_option po
														LEFT JOIN `".DB_PREFIX."option` o ON (po.option_id = o.option_id)
														LEFT JOIN ".DB_PREFIX."option_description od ON (o.option_id = od.option_id)
														WHERE po.product_option_id = '".( int ) $option['product_option_id']."'
														AND po.product_id = '".( int ) $product['product_id']."'
														AND od.language_id = '".( int ) $this->config->get( 'config_language_id' )."'" );

						if( $option_query->num_rows ) {

							if( $option_query->row['type'] == 'select' || $option_query->row['type'] == 'radio' || $option_query->row['type'] == 'image' )
							{
								$option_value_query = $this->db->query( "
								SELECT pov.option_value_id, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix
								FROM ".DB_PREFIX."product_option_value pov
								LEFT JOIN ".DB_PREFIX."option_value ov ON (pov.option_value_id = ov.option_value_id)
								LEFT JOIN ".DB_PREFIX."option_value_description ovd ON (ov.option_value_id = ovd.option_value_id)
								WHERE pov.product_option_value_id = '".( int ) $option['product_option_value_id']."'
								AND pov.product_option_id = '".( int ) $option['product_option_id']."'
								AND ovd.language_id = '".( int ) $this->config->get( 'config_language_id' )."'" );

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

									if( $option_value_query->row['subtract'] && (!$option_value_query->row['quantity'] || ($option_value_query->row['quantity'] < $product['quantity'])) )
									{
										$stock = false;
									}

									$option_data[] = array(
										'product_option_id' => $option['product_option_id'],
										'product_option_value_id' => $option['product_option_value_id'],
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
									//echo sizeof($cart['products'])." ".$cart['cart_id']." products<pre>"; print_r($option_data);
								}
							}
							elseif( $option_query->row['type'] == 'checkbox' && is_array( $product['product_option_value_id'] ) )
							{
								foreach( $product['product_option_value_id'] as $product_option_value_id )
								{
									$option_value_query = $this->db->query( "
									SELECT pov.option_value_id, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix
									FROM ".DB_PREFIX."product_option_value pov
									LEFT JOIN ".DB_PREFIX."option_value ov ON( pov.option_value_id = ov.option_value_id )
									LEFT JOIN ".DB_PREFIX."option_value_description ovd ON( ov.option_value_id = ovd.option_value_id )
									WHERE pov.product_option_value_id = '".( int ) $option['product_option_value_id']."'
									AND pov.product_option_id = '".( int ) $option['product_option_id']."'
									AND ovd.language_id = '".( int ) $this->config->get( 'config_language_id' )."'" );

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

										if( $option_value_query->row['subtract'] && (!$option_value_query->row['quantity'] || ($option_value_query->row['quantity'] < $product['quantity'])) )
										{
											$stock = false;
										}

										$option_data[] = array(
											'product_option_id' => $option['product_option_id'],
											'product_option_value_id' => $option['product_option_value_id'],
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
									'product_option_id' => $option['product_option_id'],
									'product_option_value_id' => '',
									'option_id' => $option_query->row['option_id'],
									'option_value_id' => '',
									'name' => $option_query->row['name'],
									'option_value' => '',
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
							//echo "option value query<pre>"; print_r($option_value_query);
						}
					}//die('avsf');

					//echo "OPTION DATA <pre>"; print_r($option_data);

					/*$option_array = array(
						$option_data[0]['product_option_id'] => $option_data[0]['product_option_value_id']
					);

					$option_data = $this->cart->buildOptionDataArray( $product['id'], $option_array );*/

					//echo "MODEL PROGRESS ".$product['model']." ".$product['name']." 1 product price ".$product['price']."<pre>"; print_r($option_data);

					$product['price'] = $this->cart->calculatePriceB2B( $product['product_id'], $option_data );

					//echo "MODEL PROGRESS ".$product['model']." ".$product['name']." 2 product price ".$product['price']." <pre>";

					$price = $product['price'];

					// END option price calculation

					//echo "<pre>"; print_r($product['option']); die("1 SELECT * FROM `" . DB_PREFIX . "cart_product_option` WHERE `cart_id` = ".$cart['cart_id']." AND `cart_product_id` = ".$product['cart_product_id'].";");
					//echo "<pre>"; print_r($product);
					$product['total'] = $product['quantity']*$product['price'];

					//echo "MODEL AFTER product<pre>"; print_r($product);
				}
				$get_support_query = "SELECT
									  csm.*,
									  c.`firstname`,
									  c.`lastname`,
									  csp.`cart_support_product_id`,
									  csp.`product_id`,
									  pd.name,
									  csp.`model`,
									  csp.`ax_code`,
									  csp.`quantity`,
									  p.`price`,
									  p.`tax_class_id`
									FROM
									  `oc_cart_support_message` `csm`
									  LEFT JOIN `oc_cart_support_product` `csp`
										ON csm.`cart_support_message_id` = csp.`cart_support_message_id`
									  LEFT JOIN `oc_customer` `c`
										ON csm.`customer_id` = c.`customer_id`
									  LEFT JOIN `oc_product` `p`
										ON csp.`product_id` = p.`product_id`
									  LEFT JOIN `oc_product_description` `pd`
										ON csp.`product_id` = pd.`product_id`
									WHERE `csm`.cart_id = ".$cart['cart_id']."
									AND `type` IS NULL;";

				//die($get_support_query);
				$cart_support = $this->db->query($get_support_query)->rows;

				/*echo "<pre>";
				print_r($cart_support);
				die('gfbdgfb');*/

				foreach ($cart_support as &$sup) {
					if($this->customer->getId() == $sup['customer_id']) {
						$sup['cart_owner'] = true;
					} else {
						$sup['cart_owner'] = false;
					}
					if ($sup['cart_support_product_id']) {
						$get_support_option_query = "SELECT
														`aspo`.*,
														`od`.`name` AS `od_name`,
														`ovd`.`name` AS `ovd_name`
													FROM
														`".DB_PREFIX."cart_support_product_option` `aspo`,
														`".DB_PREFIX."product_option` `po`,
														`".DB_PREFIX."option_description` `od`,
														`".DB_PREFIX."product_option_value` `pov`,
														`".DB_PREFIX."option_value_description` `ovd`
													WHERE
													`cart_support_product_id` = ".$sup['cart_support_product_id']."
													AND `po`.`product_option_id` = `aspo`.`product_option_id`
													AND `od`.`option_id` = `po`.`option_id`
													AND `od`.`language_id` = 2
													AND `pov`.`product_option_value_id` = `aspo`.`product_option_value_id`
													AND `ovd`.`option_value_id` = `pov`.`option_value_id`;";
						//die($get_support_option_query);
						$sup['option'] = $this->db->query($get_support_option_query)->rows;

						//print_r($sup['option']); die('gfbdgfb');
					}

				};

				$cart['support'] = $cart_support;
				// echo "<pre>"; print_r($cart['support']); die('12 model ');
			}
		}

		return $my_support_carts;
	}
}
?>
