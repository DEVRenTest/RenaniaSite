<?php
class ModelCatalogProduct extends Model {
	public function updateViewed($product_id) {
		$this->db->query("UPDATE " . DB_PREFIX . "product SET viewed = (viewed + 1) WHERE product_id = '" . (int)$product_id . "'");
	}
	
	public function getProduct($product_id, $option = array())
  {
      if ($this->customer->isLogged()) {
			$customer_group_id = $this->customer->getCustomerGroupId();
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}

    // option[172]	1489
    $finalPrice = 0;
    $priceCalculationMethode = "normal";
    if( ! empty( $option ) )
    {
        $pocIdStack = array();
        if( count( $option ) == 1 )
        {
            $priceCalculationMethode = "option";
            $value = end( $option );
            $flippedOption = array_flip( $option );
            $index = end( $flippedOption );
            $query_stock = $this->db->query("SELECT quantity AS `total_stock`, `price` AS `option_price`, `price_prefix` FROM `oc_product_option_value` WHERE `product_id` = '".(int)$product_id."' AND `product_option_value_id` = '".(int)$value."' AND `product_option_id` = '".(int)$index."'");
        }
        else
        {
            $priceCalculationMethode = "optionCombination";
            foreach( $option as $index => $value )
            {
                $query_pocids = $this->db->query("SELECT `option_value_id` FROM `oc_product_option_value` WHERE `product_id` = '".(int)$product_id."' AND `product_option_value_id` = '".(int)$value."' AND `product_option_id` = '".(int)$index."'");
                if($query_pocids->num_rows)
                {            
                    $pocIdStack[] = " JOIN `oc_product_option_combination_value` pocv".$index." ON ( pocv".$index.".product_option_combination_id = poc.product_option_combination_id AND pocv".$index.".`option_value_id` = '".(int)$query_pocids->row['option_value_id']."' ) ";
                }
            }

            if( ! empty( $pocIdStack ) )
            {
                $implodedjoins = implode( " ", $pocIdStack );
                $query_stock = $this->db->query("SELECT SUM( poc.stock ) AS total_stock, `price` AS `option_price`, `price_prefix` FROM `oc_product_option_combination` AS poc ".$implodedjoins." WHERE product_id = '".(int)$product_id."'");
            }            
        }
    }

		$query = $this->db->query("SELECT DISTINCT *, pd.name AS name, p.image, m.name AS manufacturer, (SELECT price FROM " . DB_PREFIX . "product_discount pd2 WHERE pd2.product_id = p.product_id AND pd2.customer_group_id = '" . (int)$customer_group_id . "' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount, (SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '" . (int)$customer_group_id . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special, (SELECT points FROM " . DB_PREFIX . "product_reward pr WHERE pr.product_id = p.product_id AND customer_group_id = '" . (int)$customer_group_id . "') AS reward, (SELECT ss.name FROM " . DB_PREFIX . "stock_status ss WHERE ss.stock_status_id = p.stock_status_id AND ss.language_id = '" . (int)$this->config->get('config_language_id') . "') AS stock_status, (SELECT wcd.unit FROM " . DB_PREFIX . "weight_class_description wcd WHERE p.weight_class_id = wcd.weight_class_id AND wcd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS weight_class, (SELECT lcd.unit FROM " . DB_PREFIX . "length_class_description lcd WHERE p.length_class_id = lcd.length_class_id AND lcd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS length_class, (SELECT AVG(rating) AS total FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = p.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating, (SELECT COUNT(*) AS total FROM " . DB_PREFIX . "review r2 WHERE r2.product_id = p.product_id AND r2.status = '1' GROUP BY r2.product_id) AS reviews, p.sort_order FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) WHERE p.product_id = '" . (int)$product_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");
    
		if($query->num_rows)
    {
      $finalPrice = ($query->row['discount'] ? $query->row['discount'] : $query->row['price']);
      if( isset( $query_stock->row['price_prefix'] ) )
      {
          switch( $query_stock->row['price_prefix'] )
          {
              case "+":
              { 
                  $finalPrice = ( isset( $query_stock->row['option_price'] ) && (float)$query_stock->row['option_price'] != 0 ? $finalPrice + $query_stock->row['option_price'] : $finalPrice );
                  break;
              }
              case "-":
              { 
                  $finalPrice = ( isset( $query_stock->row['option_price'] ) && (float)$query_stock->row['option_price'] != 0 ? $finalPrice - $query_stock->row['option_price'] : $finalPrice );
                  break;
              }
              case "=":
              { 
                  $finalPrice = ( isset( $query_stock->row['option_price'] ) && (float)$query_stock->row['option_price'] != 0 ? $query_stock->row['option_price'] : $finalPrice );
                  break;
              }
          }
      }      

      $uncalculableStock = ( empty( $option ) ? $query->row['quantity'] : 0 );

      $uncalculableStock = ( isset( $query_stock->row['total_stock'] ) ? $query_stock->row['total_stock'] : $uncalculableStock );


      $statusLimmits = array( 0, 0, 0 );
      if( ! empty( $query->row['stock_status_limits'] ) )
      {
          $statusLimmits = json_decode( $query->row['stock_status_limits'] );          
      }


      // if the logged customer is B2B or Gallery + B2B
      $priceB2B = 0;
      $B2B = false;
      /*if( $this->customer->getCustomerGroupId() == 3 || $this->customer->getCustomerGroupId() == 4 )
      {
        $option_data = $this->cart->buildOptionDataArray( $product_id, $option );
        $priceB2B = $this->cart->calculatePriceB2B( $product_id, $option_data );
        
        $B2B = true;
        $pr = 0;

        if( $priceB2B == 0 )
        {
            $pr = "MORE_OPTION_NEEDED";
        }
        else
        {
            $pr = $priceB2B;
        }
      }*/

      $priceVal = ( $B2B ? $pr : $finalPrice );
	  
	  /*if ($_SERVER['REMOTE_ADDR'] == '5.15.59.107') {
		  echo 'priice '.$priceVal;
	  }*/

      $StockStatus = $this->language->get('text_high_stock');
      $StockStatus = ( $uncalculableStock <= $statusLimmits[2] ? $this->language->get('text_medium_stock') : $StockStatus );
      $StockStatus = ( $uncalculableStock <= $statusLimmits[1] ? $this->language->get('text_low_stock') : $StockStatus );
      $StockStatus = ( $uncalculableStock == $statusLimmits[0] ? $this->language->get('text_no_stock') : $StockStatus );

/*        $product_option_array = $this->getProductOptions($query->row['product_id']);
        if ( sizeof($product_option_array) == 0 )
        {
            $product_type = "normal";
        }
        else if ( sizeof($product_option_array) == 1 )
        {
            $product_type = "option";
        }
        else if ( sizeof($product_option_array) == 2 )
        {
            $product_type = "option_combination";
        }*/

			return array(
				'product_id'       => $query->row['product_id'],
				'name'             => $query->row['name'],
				'description'      => $query->row['description'],
				'meta_description' => $query->row['meta_description'],
				'meta_keyword'     => $query->row['meta_keyword'],
				'tag'              => $query->row['tag'],
				'model'            => $query->row['model'],
				'sku'              => $query->row['sku'],
				'upc'              => $query->row['upc'],
				'ean'              => $query->row['ean'],
				'jan'              => $query->row['jan'],
				'isbn'             => $query->row['isbn'],
				'mpn'              => $query->row['mpn'],
				'location'         => $query->row['location'],
				//'quantity'         => $query->row['quantity'],
				'quantity'         => $uncalculableStock,
				'product_option_quantity' => $uncalculableStock,
				'stock_status'     => $StockStatus, //$query->row['stock_status'],
				'image'            => $query->row['image'],
				'video'			   => $query->row['video'],
				'manufacturer_id'  => $query->row['manufacturer_id'],
				'manufacturer'     => $query->row['manufacturer'],
				'price'            => $priceVal,
				'special'          => $query->row['special'],
				'reward'           => $query->row['reward'],
				'points'           => $query->row['points'],
				'tax_class_id'     => $query->row['tax_class_id'],
				'date_available'   => $query->row['date_available'],
				'weight'           => $query->row['weight'],
				'weight_class_id'  => $query->row['weight_class_id'],
				'length'           => $query->row['length'],
				'width'            => $query->row['width'],
				'height'           => $query->row['height'],
				'length_class_id'  => $query->row['length_class_id'],
				'subtract'         => $query->row['subtract'],
				'rating'           => round($query->row['rating']),
				'reviews'          => $query->row['reviews'] ? $query->row['reviews'] : 0,
				'minimum'          => $query->row['minimum'],
				'sort_order'       => $query->row['sort_order'],
				'status'           => $query->row['status'],
				'date_added'       => $query->row['date_added'],
				'date_modified'    => $query->row['date_modified'],
				'viewed'           => $query->row['viewed'],
				'container_size'   => $query->row['container_size'],
				'package_discount' => $query->row['package_discount'],
				'product_new'      => $query->row['flag'],
			);
      
		} else {
			return false;
		}
	}

	public function getProducts($data = array()) {
		if ($this->customer->isLogged()) {
			$customer_group_id = $this->customer->getCustomerGroupId();
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}	
		
		$sql = "SELECT p.product_id, (SELECT AVG(rating) AS total FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = p.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating, (SELECT price FROM " . DB_PREFIX . "product_discount pd2 WHERE pd2.product_id = p.product_id AND pd2.customer_group_id = '" . (int)$customer_group_id . "' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount, (SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '" . (int)$customer_group_id . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special"; 
		
		if (!empty($data['filter_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$sql .= " FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (cp.category_id = p2c.category_id)";			
			} else {
				$sql .= " FROM " . DB_PREFIX . "product_to_category p2c";
			}
		
			if (!empty($data['filter_filter'])) {
				$sql .= " LEFT JOIN " . DB_PREFIX . "product_filter pf ON (p2c.product_id = pf.product_id) LEFT JOIN " . DB_PREFIX . "product p ON (pf.product_id = p.product_id)";
			} else {
				$sql .= " LEFT JOIN " . DB_PREFIX . "product p ON (p2c.product_id = p.product_id)";
			}
		} else {
			$sql .= " FROM " . DB_PREFIX . "product p";
		}
		
		$sql .= " LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";
		
		if (!empty($data['filter_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$sql .= " AND cp.path_id = '" . (int)$data['filter_category_id'] . "'";	
			} else {
				$sql .= " AND p2c.category_id = '" . (int)$data['filter_category_id'] . "'";			
			}	
		
			if (!empty($data['filter_filter'])) {
				$implode = array();
				
				$filters = explode(',', $data['filter_filter']);
				
				foreach ($filters as $filter_id) {
					$implode[] = (int)$filter_id;
				}
				
				$sql .= " AND pf.filter_id IN (" . implode(',', $implode) . ")";				
			}
		}	

		if (isset($data['filter_flag'])) {
			$sql .= " AND p.flag = '" . (int)$data['filter_flag'] . "'";
		}
		
		if (!empty($data['filter_name']) || !empty($data['filter_tag'])) {
			$sql .= " AND (";
			
			if (!empty($data['filter_name'])) {
				$implode = array();

				$words = explode(' ', trim(preg_replace('/\s\s+/', ' ', $data['filter_name'])));

				foreach ($words as $word) {
					$implode[] = "pd.name LIKE '%" . $this->db->escape($word) . "%'";
				}
				
				if ($implode) {
					$sql .= " " . implode(" AND ", $implode) . "";
				}

				if (!empty($data['filter_description'])) {
					$sql .= " OR pd.description LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
				}
			}
			
			if (!empty($data['filter_name']) && !empty($data['filter_tag'])) {
				$sql .= " OR ";
			}
			
			if (!empty($data['filter_tag'])) {
				$sql .= "pd.tag LIKE '%" . $this->db->escape($data['filter_tag']) . "%'";
			}
			
			if (!empty($data['filter_name'])) {
				$sql .= " OR LCASE(p.model) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
			}
			
			if (!empty($data['filter_name'])) {
				$sql .= " OR LCASE(p.sku) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
			}	
			
			if (!empty($data['filter_name'])) {
				$sql .= " OR LCASE(p.upc) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
			}		

			if (!empty($data['filter_name'])) {
				$sql .= " OR LCASE(p.ean) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
			}

			if (!empty($data['filter_name'])) {
				$sql .= " OR LCASE(p.jan) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
			}
			
			if (!empty($data['filter_name'])) {
				$sql .= " OR LCASE(p.isbn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
			}		
			
			if (!empty($data['filter_name'])) {
				$sql .= " OR LCASE(p.mpn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
			}
			
			$sql .= ")";
		}
					
		if (!empty($data['filter_manufacturer_id'])) {
			$sql .= " AND p.manufacturer_id = '" . (int)$data['filter_manufacturer_id'] . "'";
		}

		$sql .= " GROUP BY p.product_id";
		
		$sort_data = array(
			'pd.name',
			'p.model',
			'p.quantity',
			'p.price',
			'rating',
			'p.sort_order',
			'p.date_added'
		);	
		
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			if ($data['sort'] == 'pd.name' || $data['sort'] == 'p.model') {
				$sql .= " ORDER BY LCASE(" . $data['sort'] . ")";
			} elseif ($data['sort'] == 'p.price') {
				$sql .= " ORDER BY (CASE WHEN special IS NOT NULL THEN special WHEN discount IS NOT NULL THEN discount ELSE p.price END)";
			} else {
				# $sql .= " ORDER BY " . $data['sort'];
                //SORT_FIX: (Bela)
				$sql .= " ORDER BY p.flag=1 DESC,p.date_added DESC, LCASE(pd.name),".$data['sort'];
			}
		} else {
			$sql .= " ORDER BY p.sort_order";	
		}
		
		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC, LCASE(pd.name) DESC";
		} else {
			$sql .= " ASC, LCASE(pd.name) ASC";
		}
	
		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}				

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}	
		
			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}
		
		$product_data = array();
				
		$query = $this->db->query($sql);
	
		foreach ($query->rows as $result) {
			$product_data[$result['product_id']] = $this->getProduct($result['product_id']);
		}

		return $product_data;
	}
	
	public function getProductSpecials($data = array()) {
		if ($this->customer->isLogged()) {
			$customer_group_id = $this->customer->getCustomerGroupId();
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}	
				
		$sql = "SELECT DISTINCT ps.product_id, (SELECT AVG(rating) FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = ps.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating FROM " . DB_PREFIX . "product_special ps LEFT JOIN " . DB_PREFIX . "product p ON (ps.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND ps.customer_group_id = '" . (int)$customer_group_id . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) GROUP BY ps.product_id";

		$sort_data = array(
			'pd.name',
			'p.model',
			'ps.price',
			'rating',
			'p.sort_order'
		);
		
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			if ($data['sort'] == 'pd.name' || $data['sort'] == 'p.model') {
				$sql .= " ORDER BY LCASE(" . $data['sort'] . ")";
			} else {
				$sql .= " ORDER BY " . $data['sort'];
			}
		} else {
			$sql .= " ORDER BY p.sort_order";	
		}
		
		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC, LCASE(pd.name) DESC";
		} else {
			$sql .= " ASC, LCASE(pd.name) ASC";
		}
	
		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}				

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}	
		
			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$product_data = array();
		
		$query = $this->db->query($sql);
		
		foreach ($query->rows as $result) { 		
			$product_data[$result['product_id']] = $this->getProduct($result['product_id']);
		}
		
		return $product_data;
	}
		
	public function getLatestProducts($limit) {
		if ($this->customer->isLogged()) {
			$customer_group_id = $this->customer->getCustomerGroupId();
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}	
				
		$product_data = $this->cache->get('product.latest.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $customer_group_id . '.' . (int)$limit);

		if (!$product_data) { 
			$query = $this->db->query("SELECT p.product_id FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY p.date_added DESC LIMIT " . (int)$limit);
		 	 
			foreach ($query->rows as $result) {
				$product_data[$result['product_id']] = $this->getProduct($result['product_id']);
			}
			
			$this->cache->set('product.latest.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id'). '.' . $customer_group_id . '.' . (int)$limit, $product_data);
		}
		
		return $product_data;
	}
	
	public function getPopularProducts($limit) {
		$product_data = array();
		
		$query = $this->db->query("SELECT p.product_id FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY p.viewed, p.date_added DESC LIMIT " . (int)$limit);
		
		foreach ($query->rows as $result) { 		
			$product_data[$result['product_id']] = $this->getProduct($result['product_id']);
		}
					 	 		
		return $product_data;
	}

	public function getBestSellerProducts($limit) {
		if ($this->customer->isLogged()) {
			$customer_group_id = $this->customer->getCustomerGroupId();
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}	
				
		$product_data = $this->cache->get('product.bestseller.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id'). '.' . $customer_group_id . '.' . (int)$limit);

		if (!$product_data) { 
			$product_data = array();
			
			$query = $this->db->query("SELECT op.product_id, COUNT(*) AS total FROM " . DB_PREFIX . "order_product op LEFT JOIN `" . DB_PREFIX . "order` o ON (op.order_id = o.order_id) LEFT JOIN `" . DB_PREFIX . "product` p ON (op.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE o.order_status_id > '0' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' GROUP BY op.product_id ORDER BY total DESC LIMIT " . (int)$limit);
			
			foreach ($query->rows as $result) { 		
				$product_data[$result['product_id']] = $this->getProduct($result['product_id']);
			}
			
			$this->cache->set('product.bestseller.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id'). '.' . $customer_group_id . '.' . (int)$limit, $product_data);
		}
		
		return $product_data;
	}
	
	public function getProductAttributes($product_id) {
		$product_attribute_group_data = array();
		
		$product_attribute_group_query = $this->db->query("SELECT ag.attribute_group_id, agd.name FROM " . DB_PREFIX . "product_attribute pa LEFT JOIN " . DB_PREFIX . "attribute a ON (pa.attribute_id = a.attribute_id) LEFT JOIN " . DB_PREFIX . "attribute_group ag ON (a.attribute_group_id = ag.attribute_group_id) LEFT JOIN " . DB_PREFIX . "attribute_group_description agd ON (ag.attribute_group_id = agd.attribute_group_id) WHERE pa.product_id = '" . (int)$product_id . "' AND agd.language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY ag.attribute_group_id ORDER BY ag.sort_order, agd.name");
		
		foreach ($product_attribute_group_query->rows as $product_attribute_group) {
			$product_attribute_data = array();
			
			$product_attribute_query = $this->db->query("SELECT a.attribute_id, ad.name, pa.text FROM " . DB_PREFIX . "product_attribute pa LEFT JOIN " . DB_PREFIX . "attribute a ON (pa.attribute_id = a.attribute_id) LEFT JOIN " . DB_PREFIX . "attribute_description ad ON (a.attribute_id = ad.attribute_id) WHERE pa.product_id = '" . (int)$product_id . "' AND a.attribute_group_id = '" . (int)$product_attribute_group['attribute_group_id'] . "' AND ad.language_id = '" . (int)$this->config->get('config_language_id') . "' AND pa.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY a.sort_order, ad.name");
			
			foreach ($product_attribute_query->rows as $product_attribute) {
				$product_attribute_data[] = array(
					'attribute_id' => $product_attribute['attribute_id'],
					'name'         => $product_attribute['name'],
					'text'         => $product_attribute['text']		 	
				);
			}
			
			$product_attribute_group_data[] = array(
				'attribute_group_id' => $product_attribute_group['attribute_group_id'],
				'name'               => $product_attribute_group['name'],
				'attribute'          => $product_attribute_data
			);			
		}
		
		return $product_attribute_group_data;
	}
			
	public function getProductOptions($product_id) {
		$product_option_data = array();

    
  //  print "SELECT * FROM " . DB_PREFIX . "product_option po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) WHERE po.product_id = '" . (int)$product_id . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY o.sort_order";
            
		$product_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) WHERE po.product_id = '" . (int)$product_id . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY o.sort_order");
		
		foreach ($product_option_query->rows as $product_option) {
			if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
				$product_option_value_data = array();
			
        
        //print "SELECT * FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_id = '" . (int)$product_id . "' AND pov.product_option_id = '" . (int)$product_option['product_option_id'] . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY ov.sort_order";
        
				$product_option_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_id = '" . (int)$product_id . "' AND pov.product_option_id = '" . (int)$product_option['product_option_id'] . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY ov.sort_order");
				
				foreach ($product_option_value_query->rows as $product_option_value) {
					$product_option_value_data[] = array(
						'product_option_value_id' => $product_option_value['product_option_value_id'],
						'option_value_id'         => $product_option_value['option_value_id'],
						'name'                    => $product_option_value['name'],
						'image'                   => $product_option_value['image'],
						'quantity'                => $product_option_value['quantity'],
						'subtract'                => $product_option_value['subtract'],
						'price'                   => $product_option_value['price'],
						'price_prefix'            => $product_option_value['price_prefix'],
						'weight'                  => $product_option_value['weight'],
						'weight_prefix'           => $product_option_value['weight_prefix']
					);
				}
									
				$product_option_data[] = array(
					'product_option_id' => $product_option['product_option_id'],
					'option_id'         => $product_option['option_id'],
					'name'              => $product_option['name'],
					'type'              => $product_option['type'],
					'option_value'      => $product_option_value_data,
					'required'          => $product_option['required']
				);
			} else {
				$product_option_data[] = array(
					'product_option_id' => $product_option['product_option_id'],
					'option_id'         => $product_option['option_id'],
					'name'              => $product_option['name'],
					'type'              => $product_option['type'],
					'option_value'      => $product_option['option_value'],
					'required'          => $product_option['required']
				);				
			}
      	}

		
		return $product_option_data;
	}
	
	public function getProductDiscounts($product_id) {
		if ($this->customer->isLogged()) {
			$customer_group_id = $this->customer->getCustomerGroupId();
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}	
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product_id . "' AND customer_group_id = '" . (int)$customer_group_id . "' AND quantity > 1 AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY quantity ASC, priority ASC, price ASC");

		return $query->rows;		
	}
		
	public function getProductImages($product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$product_id . "' ORDER BY sort_order ASC");

		return $query->rows;
	}
	
	public function getProductRelated($product_id) {
		$product_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_related pr LEFT JOIN " . DB_PREFIX . "product p ON (pr.related_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE pr.product_id = '" . (int)$product_id . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");
		
		foreach ($query->rows as $result) { 
			$product_data[$result['related_id']] = $this->getProduct($result['related_id']);
		}
		
		return $product_data;
	}

	public function getProductComplementary($product_id) {
		$product_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_complementary pc LEFT JOIN " . DB_PREFIX . "product p ON (pc.product_id = p.product_id)
		LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id)
		WHERE pc.product_id = '" . (int)$product_id . "' AND p.status = '1' AND p.date_available <= NOW()
		AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");

		foreach ($query->rows as $result) {
			$product_data[$result['complementary_id']] = $this->getProduct($result['complementary_id']);
		}

		return $product_data;
	}
		
	public function getProductLayoutId($product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_layout WHERE product_id = '" . (int)$product_id . "' AND store_id = '" . (int)$this->config->get('config_store_id') . "'");
		
		if ($query->num_rows) {
			return $query->row['layout_id'];
		} else {
			return  $this->config->get('config_layout_product');
		}
	}
	
	public function getCategories($product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");
		
		return $query->rows;
	}	
		
	public function getTotalProducts($data = array()) {
		if ($this->customer->isLogged()) {
			$customer_group_id = $this->customer->getCustomerGroupId();
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}	

		$sql = "SELECT COUNT(DISTINCT p.product_id) AS total"; 
		
		if (!empty($data['filter_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$sql .= " FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (cp.category_id = p2c.category_id)";			
			} else {
				$sql .= " FROM " . DB_PREFIX . "product_to_category p2c";
			}
		
			if (!empty($data['filter_filter'])) {
				$sql .= " LEFT JOIN " . DB_PREFIX . "product_filter pf ON (p2c.product_id = pf.product_id) LEFT JOIN " . DB_PREFIX . "product p ON (pf.product_id = p.product_id)";
			} else {
				$sql .= " LEFT JOIN " . DB_PREFIX . "product p ON (p2c.product_id = p.product_id)";
			}
		} else {
			$sql .= " FROM " . DB_PREFIX . "product p";
		}
		
		$sql .= " LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";
		
		if (!empty($data['filter_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$sql .= " AND cp.path_id = '" . (int)$data['filter_category_id'] . "'";	
			} else {
				$sql .= " AND p2c.category_id = '" . (int)$data['filter_category_id'] . "'";			
			}	
		
			if (!empty($data['filter_filter'])) {
				$implode = array();
				
				$filters = explode(',', $data['filter_filter']);
				
				foreach ($filters as $filter_id) {
					$implode[] = (int)$filter_id;
				}
				
				$sql .= " AND pf.filter_id IN (" . implode(',', $implode) . ")";				
			}
		}

		if (isset($data['filter_flag'])) {
			$sql .= " AND p.flag = '" . (int)$data['filter_flag'] . "'";
		}
		
		if (!empty($data['filter_name']) || !empty($data['filter_tag'])) {
			$sql .= " AND (";
			
			if (!empty($data['filter_name'])) {
				$implode = array();

				$words = explode(' ', trim(preg_replace('/\s\s+/', ' ', $data['filter_name'])));

				foreach ($words as $word) {
					$implode[] = "pd.name LIKE '%" . $this->db->escape($word) . "%'";
				}
				
				if ($implode) {
					$sql .= " " . implode(" AND ", $implode) . "";
				}

				if (!empty($data['filter_description'])) {
					$sql .= " OR pd.description LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
				}
			}
			
			if (!empty($data['filter_name']) && !empty($data['filter_tag'])) {
				$sql .= " OR ";
			}
			
			if (!empty($data['filter_tag'])) {
				$sql .= "pd.tag LIKE '%" . $this->db->escape(utf8_strtolower($data['filter_tag'])) . "%'";
			}
		
			if (!empty($data['filter_name'])) {
				$sql .= " OR LCASE(p.model) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
			}
			
			if (!empty($data['filter_name'])) {
				$sql .= " OR LCASE(p.sku) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
			}	
			
			if (!empty($data['filter_name'])) {
				$sql .= " OR LCASE(p.upc) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
			}		

			if (!empty($data['filter_name'])) {
				$sql .= " OR LCASE(p.ean) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
			}

			if (!empty($data['filter_name'])) {
				$sql .= " OR LCASE(p.jan) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
			}
			
			if (!empty($data['filter_name'])) {
				$sql .= " OR LCASE(p.isbn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
			}		
			
			if (!empty($data['filter_name'])) {
				$sql .= " OR LCASE(p.mpn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
			}
			
			$sql .= ")";				
		}
		
		if (!empty($data['filter_manufacturer_id'])) {
			$sql .= " AND p.manufacturer_id = '" . (int)$data['filter_manufacturer_id'] . "'";
		}

        if( $_SERVER['REMOTE_ADDR'] == '188.26.23.46' )
        {
           // print $sql; //die();
        }
		$query = $this->db->query($sql);
		
		return $query->row['total'];
	}
    
    public function getProfiles($product_id) {
        if ($this->customer->isLogged()) {
			$customer_group_id = $this->customer->getCustomerGroupId();
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}		
        
        return $this->db->query("SELECT `pd`.* FROM `" . DB_PREFIX . "product_profile` `pp` JOIN `" . DB_PREFIX . "profile_description` `pd` ON `pd`.`language_id` = " . (int) $this->config->get('config_language_id') . " AND `pd`.`profile_id` = `pp`.`profile_id` JOIN `" . DB_PREFIX . "profile` `p` ON `p`.`profile_id` = `pd`.`profile_id` WHERE `product_id` = " . (int) $product_id . " AND `status` = 1 AND `customer_group_id` = " . (int) $customer_group_id . " ORDER BY `sort_order` ASC")->rows;
        
    }
    
    public function getProfile($product_id, $profile_id) {
        if ($this->customer->isLogged()) {
			$customer_group_id = $this->customer->getCustomerGroupId();
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}		
        
        return $this->db->query("SELECT * FROM `" . DB_PREFIX . "profile` `p` JOIN `" . DB_PREFIX . "product_profile` `pp` ON `pp`.`profile_id` = `p`.`profile_id` AND `pp`.`product_id` = " . (int) $product_id . " WHERE `pp`.`profile_id` = " . (int) $profile_id . " AND `status` = 1 AND `pp`.`customer_group_id` = " . (int) $customer_group_id)->row;
    }
			
	public function getTotalProductSpecials() {
		if ($this->customer->isLogged()) {
			$customer_group_id = $this->customer->getCustomerGroupId();
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}		
		
		$query = $this->db->query("SELECT COUNT(DISTINCT ps.product_id) AS total FROM " . DB_PREFIX . "product_special ps LEFT JOIN " . DB_PREFIX . "product p ON (ps.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND ps.customer_group_id = '" . (int)$customer_group_id . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW()))");
		
		if (isset($query->row['total'])) {
			return $query->row['total'];
		} else {
			return 0;	
		}
	}

    public function getProductSizeChart($product_id) {
        $size_chart_name = '';

        $query = $this->db->query("SELECT product_size_chart_id, size_chart_name FROM " . DB_PREFIX . "product_size_chart WHERE product_id = '". $product_id ."' ");
        if ( $query->num_rows > 0 )
        {
            $size_chart_name = $query->row['size_chart_name'];
        }

        return $size_chart_name;
    }

	public function customerCanBuyPiece($product_id)
	{
		if (!($this->customer->islogged() && $this->getProductContainerSize($product_id))) {
			return true;
		}
		$query = $this->db->query(
			"SELECT COALESCE(
				(SELECT piece FROM " . DB_PREFIX . "bulk_customer WHERE product_id = '" . (int)$product_id . "' AND customer_id = '" . (int)$this->customer->getId() . "'),
				(SELECT piece FROM " . DB_PREFIX . "bulk_group WHERE product_id = '" . (int)$product_id . "' AND customer_group_id = '" . (int)$this->customer->getCustomerGroupId() . "'),
				(SELECT piece FROM " . DB_PREFIX . "customer_group WHERE customer_group_id = '" . (int)$this->customer->getCustomerGroupId() . "')
			) as can_buy_piece"
		);
		return (bool)$query->row['can_buy_piece'];
	}

	public function customerCanBuyBulk($product_id)
	{
		if (!($this->customer->islogged() && $this->getProductContainerSize($product_id))) {
			return false;
		}
		$query = $this->db->query(
			"SELECT COALESCE(
				(SELECT bulk FROM " . DB_PREFIX . "bulk_customer WHERE product_id = '" . (int)$product_id . "' AND customer_id = '" . (int)$this->customer->getId() . "'),
				(SELECT bulk FROM " . DB_PREFIX . "bulk_group WHERE product_id = '" . (int)$product_id . "' AND customer_group_id = '" . (int)$this->customer->getCustomerGroupId() . "'),
				(SELECT bulk FROM " . DB_PREFIX . "customer_group WHERE customer_group_id = '" . (int)$this->customer->getCustomerGroupId() . "')
			) as can_buy_bulk"
		);
		return (bool)$query->row['can_buy_bulk'];
	}

    public function getPackageDiscount($product_id)
    {
    	$result = false;
    	if ($this->customer->isLogged()) {
    		$query = $this->db->query("SELECT package_discount FROM " . DB_PREFIX . "product WHERE product_id = '" . (int)$product_id . "'");
    		if($query->num_rows) {
    			$result = $query->row['package_discount'];
    		}
    	}
    	return $result;
    }
  	public function lastOrderDate($product_id, $min_time_elapsed = 0, $max_time_elapsed = 0)
  	{
  		$now = time();
  		$result = false;
  		$query = $this->db->query("SELECT UNIX_TIMESTAMP(o.date_added) as date_added FROM " . DB_PREFIX . "order o LEFT JOIN " . DB_PREFIX . "order_product op ON o.order_id = op.order_id WHERE op.product_id = '" . (int)$product_id . "' AND o.order_status_id != 0 ORDER BY o.date_added DESC LIMIT 1");
  		if ($query->num_rows) {
  			$result = $query->row['date_added'];
  			if (($min_time_elapsed && $min_time_elapsed > 0 && $now - $min_time_elapsed <= $query->row['date_added'])
  			 || ($max_time_elapsed && $max_time_elapsed > 0 && $now - $max_time_elapsed > $query->row['date_added'])) {
  				$result = false;
  			}
  		}
  		return $result;
  	}
  	public function getProductContainerSize($product_id)
  	{
  		$query = $this->db->query("SELECT container_size FROM " . DB_PREFIX . "product WHERE product_id = '" . (int)$product_id . "'");
  		if ($query->num_rows) {
  			return (int)$query->row['container_size'];
  		}
  		return 0;
  	}

  	public function modelToId($model)
  	{
  		$query = $this->db->query("SELECT product_id FROM " . DB_PREFIX . "product WHERE model = '" . $this->db->escape($model) . "'");
  		if ($query->num_rows) {
  			return $query->row['product_id'];
  		} else {
  			return 0;
  		}
  	}

  	public function getStockByColorAndSize($product_id)
	{
		$stock_by_color_and_size = array();

		$prQuery = $this->db->query( "SELECT pr.product_id, pr_desc.name, pr.upc FROM oc_product pr JOIN oc_product_description pr_desc ON (pr_desc.product_id = pr.product_id ) WHERE pr.product_id='".$product_id."'" );

		if( $prQuery->num_rows > 0 )
		{
				$stock_by_color_and_size = array(
					"product_id" => $product_id,
					"product_upc" => $prQuery->row['upc'],
					"Marimi" => array( ),
					"Culori" => array( ),
					"Denumire" => $prQuery->row['name'],
					"code_ax" => "",
					"type" => "1",
					"Combinatii" => array( )
				);

				$concatenated_code = '';

				// option query
				$optionQuery = $this->db->query( "SELECT pov.product_option_value_id as ov_id, pov.product_option_id as o_id, od.name as o_name, ovd.name as ov_name
                                FROM oc_product_option_value AS pov
                                JOIN oc_option_value_description AS ovd ON ( ovd.option_value_id = pov.option_value_id )
                                JOIN oc_option_description AS od ON ( od.`option_id` = ovd.`option_id` )
                                WHERE pov.`product_id` = '".$product_id."' ORDER BY  ov_id ASC ;" );

				// feching options
				if( $optionQuery->num_rows > 0 )
				{
					foreach( $optionQuery->rows as $value )
					{
						$stock_by_color_and_size[$value["o_name"]][$value["ov_id"]] = $value["ov_name"];
					}

					// setting up type to 2
					$stock_by_color_and_size["type"] = 2;
				}

				// get option combinations
				$optioncombinationQuery = $this->db->query( "SELECT pocv.product_option_combination_id, ovd.name as ov_name, od.name as o_name FROM oc_product_option_combination_value pocv
                                JOIN oc_product_option_combination poc ON (poc.product_option_combination_id = pocv.product_option_combination_id)
                                JOIN oc_option_value_description AS ovd ON ( ovd.option_value_id = pocv.option_value_id )
                                JOIN oc_option_description AS od ON ( od.`option_id` = ovd.`option_id` )
                                WHERE poc.product_id='".$product_id."' ORDER BY product_option_combination_id ASC;" );

				if( $optioncombinationQuery->num_rows > 0 )
				{
					$product_option_combination_id = array( );
					foreach( $optioncombinationQuery->rows as $key => $val )
					{
						$stock_by_color_and_size["Combinatii"][$val["product_option_combination_id"]][$val["o_name"]] = $val["ov_name"];
					}

					// setting up type to 3
					$stock_by_color_and_size["type"] = 3;
				}

				$this->load->model( 'catalog/ax_stoc' );
				if( $stock_by_color_and_size["type"] == 1 )//simple product
				{
					// get ax codes
					$concatenated_code = $this->getProductAxCode( $stock_by_color_and_size["type"], $stock_by_color_and_size['product_id'] );

					$stock_by_color_and_size[ "Marimi" ] = array();
					$stock_by_color_and_size[ "Culori" ] = array();
					$stock_by_color_and_size[ "code_ax" ] = $concatenated_code;

				}
				else if( $stock_by_color_and_size["type"] == 2 )
				{
					if (  !empty( $stock_by_color_and_size["Marimi"] ) )
					{
						foreach( $stock_by_color_and_size["Marimi"] as $key => $value )
						{
							// get ax codes
							$concatenated_code = $this->getProductAxCode( $stock_by_color_and_size["type"], $stock_by_color_and_size['product_id'], '',  $key);
							$stock_by_color_and_size[ "code_ax" ][$key] = $this->model_catalog_ax_stoc->getStoc( $concatenated_code );
						}
					}

					if (  !empty( $stock_by_color_and_size["Culori"] ) )
					{
						foreach( $stock_by_color_and_size["Culori"] as $key => $value )
						{
							// get ax codes
							$concatenated_code = $this->getProductAxCode( $stock_by_color_and_size["type"], $stock_by_color_and_size['product_id'], '', $key);
							$stock_by_color_and_size[ "code_ax" ][$key] = $this->model_catalog_ax_stoc->getStoc( $concatenated_code );
						}
					}
				}
				else if( $stock_by_color_and_size["type"] == 3 )
				{
					foreach( $stock_by_color_and_size["Combinatii"] as $key => $value )
					{
						// get ax codes
						$concatenated_code = $this->getProductAxCode( $stock_by_color_and_size["type"], $stock_by_color_and_size['product_id'], '', $key );
						$stock_by_color_and_size[ "code_ax" ][$key] = $this->model_catalog_ax_stoc->getStoc( $concatenated_code );
					}
				}
		}

		return $stock_by_color_and_size;
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
