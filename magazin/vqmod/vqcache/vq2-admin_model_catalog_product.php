<?php
class ModelCatalogProduct extends Model {

			
			public function create_table(){
				$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "product_description_download_pdf` (
								  `product_description_download_pdf_id` INT(11) NOT NULL AUTO_INCREMENT,
								  `product_id` INT(11) NOT NULL,
								  `language_id` INT(11) NOT NULL,
								  `file_name` TEXT NOT NULL,
								  PRIMARY KEY (`product_description_download_pdf_id`)
								) ENGINE=INNODB DEFAULT CHARSET=latin1;");

				$this->db->query("CREATE TABLE IF NOT EXISTS `oc_product_description_download_pdf_to_customer_group` (
								  `product_description_download_pdf_to_customer_group_id` int(11) NOT NULL AUTO_INCREMENT,
								  `product_description_download_pdf_id` int(11) NOT NULL,
								  `customer_group_id` int(11) NOT NULL,
								  `product_id` INT(11) NOT NULL,
								  PRIMARY KEY (`product_description_download_pdf_to_customer_group_id`)
								) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
			}
			
			
	public function addProduct($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "product SET model = '" . $this->db->escape($data['model']) . "', sku = '" . $this->db->escape($data['sku']) . "', upc = '" . $this->db->escape($data['upc']) . "', ean = '" . $this->db->escape($data['ean']) . "', jan = '" . $this->db->escape($data['jan']) . "', isbn = '" . $this->db->escape($data['isbn']) . "', mpn = '" . $this->db->escape($data['mpn']) . "', location = '" . $this->db->escape($data['location']) . "', quantity = '" . (int)$data['quantity'] . "', minimum = '" . (int)$data['minimum'] . "', subtract = '" . (int)$data['subtract'] . "', stock_status_id = '" . (int)$data['stock_status_id'] . "', date_available = '" . $this->db->escape($data['date_available']) . "', manufacturer_id = '" . (int)$data['manufacturer_id'] . "', shipping = '" . (int)$data['shipping'] . "', price = '" . (float)$data['price'] . "', points = '" . (int)$data['points'] . "', weight = '" . (float)$data['weight'] . "', weight_class_id = '" . (int)$data['weight_class_id'] . "', length = '" . (float)$data['length'] . "', width = '" . (float)$data['width'] . "', height = '" . (float)$data['height'] . "', length_class_id = '" . (int)$data['length_class_id'] . "', status = '" . (int)$data['status'] . "', tax_class_id = '" . $this->db->escape($data['tax_class_id']) . "', sort_order = '" . (int)$data['sort_order'] . "', date_added = NOW()");
		
		$product_id = $this->db->getLastId();

			
		if(isset($data['description_document'])) {

			foreach ($data['description_document'] as $language_id => $value) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_description_download_pdf SET product_id = '" . (int)$product_id . "', language_id = '" . (int)$language_id . "', file_name = '" . $this->db->escape($value['file_name']) . "'");
			}
		}
			
			
		
		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "product SET image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' WHERE product_id = '" . (int)$product_id . "'");

    		  if (isset($data['def_img']) && $data['def_img'] != "") {
                 $q="UPDATE " . DB_PREFIX . "product SET image = '" . $this->db->escape($data['def_img']) . "' WHERE product_id = '" . (int)$product_id . "'";
    		     $this->db->query($q);  
		      }
            
		}
		
		foreach ($data['product_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "product_description SET product_id = '" . (int)$product_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', custom_title = '" . ((isset($value['custom_title']))?($this->db->escape($value['custom_title'])):'') . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', description = '" . $this->db->escape($value['description']) . "', tag = '" . $this->db->escape($value['tag']) . "'");
		}
		
		if (isset($data['product_store'])) {
			foreach ($data['product_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_store SET product_id = '" . (int)$product_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		if (isset($data['product_attribute'])) {
			foreach ($data['product_attribute'] as $product_attribute) {
				if ($product_attribute['attribute_id']) {
					$this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "' AND attribute_id = '" . (int)$product_attribute['attribute_id'] . "'");
					
					foreach ($product_attribute['product_attribute_description'] as $language_id => $product_attribute_description) {				
						$this->db->query("INSERT INTO " . DB_PREFIX . "product_attribute SET product_id = '" . (int)$product_id . "', attribute_id = '" . (int)$product_attribute['attribute_id'] . "', language_id = '" . (int)$language_id . "', text = '" .  $this->db->escape($product_attribute_description['text']) . "'");
					}
				}
			}
		}
	
		if (isset($data['product_option'])) {
			foreach ($data['product_option'] as $product_option) {
				if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
					$this->db->query("INSERT INTO " . DB_PREFIX . "product_option SET product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', required = '" . (int)$product_option['required'] . "'");
				
					$product_option_id = $this->db->getLastId();
				
					if (isset($product_option['product_option_value']) && count($product_option['product_option_value']) > 0 ) {
						foreach ($product_option['product_option_value'] as $product_option_value) {
							$this->db->query("INSERT INTO " . DB_PREFIX . "product_option_value SET product_option_id = '" . (int)$product_option_id . "', product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', option_value_id = '" . (int)$product_option_value['option_value_id'] . "', quantity = '" . (int)$product_option_value['quantity'] . "', subtract = '" . (int)$product_option_value['subtract'] . "', price = '" . (float)$product_option_value['price'] . "', price_prefix = '" . $this->db->escape($product_option_value['price_prefix']) . "', points = '" . (int)$product_option_value['points'] . "', points_prefix = '" . $this->db->escape($product_option_value['points_prefix']) . "', weight = '" . (float)$product_option_value['weight'] . "', weight_prefix = '" . $this->db->escape($product_option_value['weight_prefix']) . "'");
						} 
					}else{
						$this->db->query("DELETE FROM " . DB_PREFIX . "product_option WHERE product_option_id = '".$product_option_id."'");
					}
				} else { 
					$this->db->query("INSERT INTO " . DB_PREFIX . "product_option SET product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', option_value = '" . $this->db->escape($product_option['option_value']) . "', required = '" . (int)$product_option['required'] . "'");
				}
			}
		}
		


                if(isset($data['product_option_combination'])) {

                    foreach($data['product_option_combination'] as $product_option_combination)

                    {

                        $this->db->query("INSERT INTO " . DB_PREFIX . "product_option_combination SET product_id = '" . (int)$product_id . "', stock = '" . (int)$product_option_combination['stock'] . "', subtract = '" . (int)$product_option_combination['subtract'] . "', quantity = '" . (int)$product_option_combination['quantity'] . "', sort_order = '" . (int)$product_option_combination['sort_order'] . "', customer_group_id = '" . (int)$product_option_combination['customer_group_id'] . "', price = '" . $product_option_combination['price'] . "', price_prefix = '" . $product_option_combination['price_prefix'] . "', points = '" . (int)$product_option_combination['points'] . "', points_prefix = '" . $product_option_combination['points_prefix'] . "', weight = '" . $product_option_combination['weight'] . "', weight_prefix = '" . $product_option_combination['weight_prefix'] . "', date_start = '" . $product_option_combination['date_start'] . "', date_end = '" . $product_option_combination['date_end'] . "'");

                        if(isset($product_option_combination['option_values']))

                        {

                            $product_option_combination_id = $this->db->getLastId();

                            foreach($product_option_combination['option_values'] as $option_value)

                            {

                                $this->db->query("INSERT INTO " . DB_PREFIX . "product_option_combination_value SET product_option_combination_id = '" . (int)$product_option_combination_id . "', option_value_id = '" . (int)$option_value['option_value_id'] . "'");

                            }

                        }

                    }

                }

                if(isset($data['product_option_combination_description'])) {

                    foreach($data['product_option_combination_description'] as $lang_id => $product_option_combination_description)

                    {

                        $this->db->query("INSERT INTO " . DB_PREFIX . "product_option_combination_description SET product_id = '" . (int)$product_id . "', language_id = '" . (int)$lang_id . "', description = '" . $this->db->escape($product_option_combination_description['description']) . "'");

                    }

                }

                if(isset($data['product_option_combination_setting'])) {

                    $product_option_combination_setting = $data['product_option_combination_setting'];

                    $this->db->query("INSERT INTO " . DB_PREFIX . "product_option_combination_setting SET product_id = '" . (int)$product_id . "', price_view = '" . (int)$product_option_combination_setting['price_view'] . "', table_view = '" . (int)$product_option_combination_setting['table_view'] . "', option_view = '" . (int)$product_option_combination_setting['option_view'] . "', description_view = '" . (int)$product_option_combination_setting['description_view'] . "', col_select_view = '" . (int)$product_option_combination_setting['col_select_view'] . "', col_quantity_view = '" . (int)$product_option_combination_setting['col_quantity_view'] . "', col_price_view = '" . (int)$product_option_combination_setting['col_price_view'] . "', col_total_price_view = '" . (int)$product_option_combination_setting['col_total_price_view'] . "', col_points_view = '" . (int)$product_option_combination_setting['col_points_view'] . "', col_total_points_view = '" . (int)$product_option_combination_setting['col_total_points_view'] . "', extax_view = '" . (int)$product_option_combination_setting['extax_view'] . "', table_split = '" . (int)$product_option_combination_setting['table_split'] . "', quantity_box = '" . (int)$product_option_combination_setting['quantity_box'] . "', status = '" . (int)$product_option_combination_setting['status'] . "'");

                }

            
		if (isset($data['product_discount'])) {
			foreach ($data['product_discount'] as $product_discount) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_discount SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$product_discount['customer_group_id'] . "', quantity = '" . (int)$product_discount['quantity'] . "', priority = '" . (int)$product_discount['priority'] . "', price = '" . (float)$product_discount['price'] . "', date_start = '" . $this->db->escape($product_discount['date_start']) . "', date_end = '" . $this->db->escape($product_discount['date_end']) . "'");
			}
		}

		if (isset($data['product_special'])) {
			foreach ($data['product_special'] as $product_special) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_special SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$product_special['customer_group_id'] . "', priority = '" . (int)$product_special['priority'] . "', price = '" . (float)$product_special['price'] . "', date_start = '" . $this->db->escape($product_special['date_start']) . "', date_end = '" . $this->db->escape($product_special['date_end']) . "'");
			}
		}
		
		if (isset($data['product_image'])) {
			foreach ($data['product_image'] as $product_image) {

    		  if ($this->config->get('multiimageuploader_deletedef') && isset($data['def_img']) && $data['def_img'] == $product_image['image']) { continue;}
            
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_image SET product_id = '" . (int)$product_id . "', image = '" . $this->db->escape(html_entity_decode($product_image['image'], ENT_QUOTES, 'UTF-8')) . "', sort_order = '" . (int)$product_image['sort_order'] . "'");
			}
		}
		
		if (isset($data['product_download'])) {
			foreach ($data['product_download'] as $download_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_download SET product_id = '" . (int)$product_id . "', download_id = '" . (int)$download_id . "'");
			}
		}
		
		if (isset($data['product_category'])) {
			foreach ($data['product_category'] as $category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_category SET product_id = '" . (int)$product_id . "', category_id = '" . (int)$category_id . "'");
			}
		}
		
		if (isset($data['product_filter'])) {
			foreach ($data['product_filter'] as $filter_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_filter SET product_id = '" . (int)$product_id . "', filter_id = '" . (int)$filter_id . "'");
			}
		}
		
		if (isset($data['product_related'])) {
			foreach ($data['product_related'] as $related_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$product_id . "' AND related_id = '" . (int)$related_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_related SET product_id = '" . (int)$product_id . "', related_id = '" . (int)$related_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$related_id . "' AND related_id = '" . (int)$product_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_related SET product_id = '" . (int)$related_id . "', related_id = '" . (int)$product_id . "'");
			}
		}

		if (isset($data['product_complementary'])) {
			foreach ($data['product_complementary'] as $complementary_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_complementary WHERE product_id = '" . (int)$product_id . "' AND complementary_id = '" . (int)$complementary_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_complementary SET product_id = '" . (int)$product_id . "', complementary_id = '" . (int)$complementary_id . "'");
				//$this->db->query("DELETE FROM " . DB_PREFIX . "product_complementary WHERE product_id = '" . (int)$complementary_id . "' AND complementary_id = '" . (int)$product_id . "'");
				//$this->db->query("INSERT INTO " . DB_PREFIX . "product_complementary SET product_id = '" . (int)$complementary_id . "', complementary_id = '" . (int)$product_id . "'");
			}
		}

		if (isset($data['product_reward'])) {
			foreach ($data['product_reward'] as $customer_group_id => $product_reward) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_reward SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$customer_group_id . "', points = '" . (int)$product_reward['points'] . "'");
			}
		}

		if (isset($data['product_layout'])) {
			foreach ($data['product_layout'] as $store_id => $layout) {
				if ($layout['layout_id']) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_layout SET product_id = '" . (int)$product_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout['layout_id'] . "'");
				}
			}
		}
						
		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'product_id=" . (int) $product_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		if (isset($data['product_profiles'])) {
			foreach ($data['product_profiles'] as $profile) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "product_profile` SET `product_id` = " . (int) $product_id . ", customer_group_id = " . (int) $profile['customer_group_id'] . ", `profile_id` = " . (int) $profile['profile_id']);
			}
		} 
		

				
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE `group` = 'seopack'");
			
				foreach ($query->rows as $result) {
						if (!$result['serialized']) {
							$data[$result['key']] = $result['value'];
						} else {
							$data[$result['key']] = unserialize($result['value']);
						}
					}
					
				if (isset($data)) {$parameters = $data['parameters'];}
					else {
						$parameters['keywords'] = '%c%p';
						$parameters['tags'] = '%c%p';
						$parameters['metas'] = '%p - %f';
						}
				
				
				if (isset($parameters['ext'])) { $ext = $parameters['ext'];}
					else {$ext = '';}
					
				if ((isset($parameters['autokeywords'])) && ($parameters['autokeywords']))
					{	
						$query = $this->db->query("select pd.name as pname, cd.name as cname, pd.language_id as language_id, pd.product_id as product_id, p.sku as sku, p.model as model, p.upc as upc, m.name as brand  from " . DB_PREFIX . "product_description pd
								left join " . DB_PREFIX . "product_to_category pc on pd.product_id = pc.product_id
								inner join " . DB_PREFIX . "product p on pd.product_id = p.product_id
								left join " . DB_PREFIX . "category_description cd on cd.category_id = pc.category_id and cd.language_id = pd.language_id
								left join " . DB_PREFIX . "manufacturer m on m.manufacturer_id = p.manufacturer_id
								where p.product_id = '" . (int)$product_id . "';");
					
								
								//die('z');
						foreach ($query->rows as $product) {
														
							$bef = array("%", "_","\"","'","\\");
							$aft = array("", " ", " ", " ", "");
							
							$included = explode('%', str_replace(array(' ',','), '', $parameters['keywords']));
							
							$tags = array();
							
							if (in_array("p", $included)) {$tags = array_merge($tags, explode(' ',trim(mysql_real_escape_string(htmlspecialchars_decode(str_replace($bef, $aft,$product['pname']))))));}
							if (in_array("c", $included)) {$tags = array_merge($tags, explode(' ',trim(mysql_real_escape_string(htmlspecialchars_decode(str_replace($bef, $aft,$product['cname']))))));}
							if (in_array("s", $included)) {$tags = array_merge($tags, explode(' ',trim(mysql_real_escape_string(htmlspecialchars_decode(str_replace($bef, $aft,$product['sku']))))));}
							if (in_array("m", $included)) {$tags = array_merge($tags, explode(' ',trim(mysql_real_escape_string(htmlspecialchars_decode(str_replace($bef, $aft,$product['model']))))));}
							if (in_array("u", $included)) {$tags = array_merge($tags, explode(' ',trim(mysql_real_escape_string(htmlspecialchars_decode(str_replace($bef, $aft,$product['upc']))))));}
							if (in_array("b", $included)) {$tags = array_merge($tags, explode(' ',trim(mysql_real_escape_string(htmlspecialchars_decode(str_replace($bef, $aft,$product['brand']))))));}
							
							$keywords = '';
							
							foreach ($tags as $tag)
								{
								if (strlen($tag) > 2) 
									{
									
									$keywords = $keywords.' '.strtolower($tag);
									
									}
								}
								
							
							$exists = $this->db->query("select count(*) as times from " . DB_PREFIX . "product_description where product_id = ".$product['product_id']." and language_id = ".$product['language_id']." and meta_keyword like '%".$keywords."%';");
							
									foreach ($exists->rows as $exist)
										{
										$count = $exist['times'];
										}
							$exists = $this->db->query("select length(meta_keyword) as leng from " . DB_PREFIX . "product_description where product_id = ".$product['product_id']." and language_id = ".$product['language_id'].";");
							
									foreach ($exists->rows as $exist)
										{
										$leng = $exist['leng'];
										}

							if (($count == 0) && ($leng < 255)) {$this->db->query("update " . DB_PREFIX . "product_description set meta_keyword = concat(meta_keyword, '". htmlspecialchars($keywords) ."') where product_id = ".$product['product_id']." and language_id = ".$product['language_id'].";");}	
								
														
							}
					}
				if ((isset($parameters['autometa'])) && ($parameters['autometa']))
					{
						$query = $this->db->query("select pd.name as pname, p.price as price, cd.name as cname, pd.description as pdescription, pd.language_id as language_id, pd.product_id as product_id, p.model as model, p.sku as sku, p.upc as upc, m.name as brand from " . DB_PREFIX . "product_description pd
								left join " . DB_PREFIX . "product_to_category pc on pd.product_id = pc.product_id
								inner join " . DB_PREFIX . "product p on pd.product_id = p.product_id
								left join " . DB_PREFIX . "category_description cd on cd.category_id = pc.category_id and cd.language_id = pd.language_id
								left join " . DB_PREFIX . "manufacturer m on m.manufacturer_id = p.manufacturer_id
								where p.product_id = '" . (int)$product_id . "';");

						foreach ($query->rows as $product) {
														
							$bef = array("%", "_","\"","'","\\", "\r", "\n");
							$aft = array("", " ", " ", " ", "", "", "");
							
							$ncategory = trim(mysql_real_escape_string(htmlspecialchars_decode(str_replace($bef, $aft,$product['cname']))));
							$nproduct = trim(mysql_real_escape_string(htmlspecialchars_decode(str_replace($bef, $aft,$product['pname']))));
							$model = trim(mysql_real_escape_string(htmlspecialchars_decode(str_replace($bef, $aft,$product['model']))));
							$sku = trim(mysql_real_escape_string(htmlspecialchars_decode(str_replace($bef, $aft,$product['sku']))));
							$upc = trim(mysql_real_escape_string(htmlspecialchars_decode(str_replace($bef, $aft,$product['upc']))));
							$content = strip_tags(html_entity_decode($product['pdescription']));
							$pos = strpos($content, '.');							   
							if($pos === false) {}
								else { $content =  substr($content, 0, $pos+1);	}
							$sentence = trim(mysql_real_escape_string(htmlspecialchars_decode(str_replace($bef, $aft, $content))));
							$brand = trim(mysql_real_escape_string(htmlspecialchars_decode(str_replace($bef, $aft,$product['brand']))));
							$price = trim(mysql_real_escape_string(htmlspecialchars_decode(str_replace($bef, $aft, number_format($product['price'], 2)))));
							
							$bef = array("%c", "%p", "%m", "%s", "%u", "%f", "%b", "%$");
							$aft = array($ncategory, $nproduct, $model, $sku, $upc, $sentence, $brand, $price);
							
							$meta_description = str_replace($bef, $aft,  $parameters['metas']);
							
							$exists = $this->db->query("select count(*) as times from " . DB_PREFIX . "product_description where product_id = ".$product['product_id']." and language_id = ".$product['language_id']." and meta_description not like '%".htmlspecialchars($meta_description)."%';");
							
									foreach ($exists->rows as $exist)
										{
										$count = $exist['times'];
										}
							
							if ($count) {$this->db->query("update " . DB_PREFIX . "product_description set meta_description = concat(meta_description, '". htmlspecialchars($meta_description) ."') where product_id = ".$product['product_id']." and language_id = ".$product['language_id'].";");}			
														
							}
					}
				if ((isset($parameters['autotags'])) && ($parameters['autotags']))
					{
					$query = $this->db->query("select pd.name as pname, pd.tag, cd.name as cname, pd.language_id as language_id, pd.product_id as product_id, p.sku as sku, p.model as model, p.upc as upc, m.name as brand from " . DB_PREFIX . "product_description pd
							inner join " . DB_PREFIX . "product_to_category pc on pd.product_id = pc.product_id
							inner join " . DB_PREFIX . "product p on pd.product_id = p.product_id
							inner join " . DB_PREFIX . "category_description cd on cd.category_id = pc.category_id and cd.language_id = pd.language_id
							left join " . DB_PREFIX . "manufacturer m on m.manufacturer_id = p.manufacturer_id
							where p.product_id = '" . (int)$product_id . "';");
					
					foreach ($query->rows as $product) {
						
						$newtags ='';
						
						$included = explode('%', str_replace(array(' ',','), '', $parameters['tags']));
						
						$tags = array();
						
						
						$bef = array("%", "_","\"","'","\\");
						$aft = array("", " ", " ", " ", "");
						
							if (in_array("p", $included)) {$tags = array_merge($tags, explode(' ',trim(mysql_real_escape_string(htmlspecialchars_decode(str_replace($bef, $aft,$product['pname']))))));}
							if (in_array("c", $included)) {$tags = array_merge($tags, explode(' ',trim(mysql_real_escape_string(htmlspecialchars_decode(str_replace($bef, $aft,$product['cname']))))));}
							if (in_array("s", $included)) {$tags = array_merge($tags, explode(' ',trim(mysql_real_escape_string(htmlspecialchars_decode(str_replace($bef, $aft,$product['sku']))))));}
							if (in_array("m", $included)) {$tags = array_merge($tags, explode(' ',trim(mysql_real_escape_string(htmlspecialchars_decode(str_replace($bef, $aft,$product['model']))))));}
							if (in_array("u", $included)) {$tags = array_merge($tags, explode(' ',trim(mysql_real_escape_string(htmlspecialchars_decode(str_replace($bef, $aft,$product['upc']))))));}
							if (in_array("b", $included)) {$tags = array_merge($tags, explode(' ',trim(mysql_real_escape_string(htmlspecialchars_decode(str_replace($bef, $aft,$product['brand']))))));}
							
							foreach ($tags as $tag)
								{
								if (strlen($tag) > 2) 
									{
									if ((strpos($product['tag'], strtolower($tag)) === false) && (strpos($newtags, strtolower($tag)) === false))
										{
											$newtags .= ' '.strtolower($tag).',';											
										}			
									}
								}
							
														
							if ($product['tag']) {
								$newtags = trim(mysql_real_escape_string($product['tag']) . $newtags,' ,');
								$this->db->query("update " . DB_PREFIX . "product_description set tag = '$newtags' where product_id = '". $product['product_id'] ."' and language_id = '". $product['language_id'] ."';");
								}
								else {
								$newtags = trim($newtags,' ,');
								$this->db->query("update " . DB_PREFIX . "product_description set tag = '$newtags' where product_id = '". $product['product_id'] ."' and language_id = '". $product['language_id'] ."';");
								}
																				
						}
						
					}
				if ((isset($parameters['autourls'])) && ($parameters['autourls']))
					{
						require_once(DIR_APPLICATION . 'controller/catalog/seopack.php');
						$seo = new ControllerCatalogSeoPack($this->registry);
						
						$query = $this->db->query("SELECT pd.product_id, pd.name, pd.language_id ,l.code FROM ".DB_PREFIX."product p 
								inner join ".DB_PREFIX."product_description pd ON p.product_id = pd.product_id 
								inner join ".DB_PREFIX."language l on l.language_id = pd.language_id 
								where p.product_id = '" . (int)$product_id . "';");

						
						foreach ($query->rows as $product_row ){	

							
							if( strlen($product_row['name']) > 1 ){
							
								$slug = $seo->generateSlug($product_row['name']).$ext;
								$exist_query = $this->db->query("SELECT query FROM " . DB_PREFIX . "url_alias WHERE " . DB_PREFIX . "url_alias.query = 'product_id=" . $product_row['product_id'] . "' and language_id=".$product_row['language_id']);
								
								if(!$exist_query->num_rows){
									
									$exist_keyword = $this->db->query("SELECT query FROM " . DB_PREFIX . "url_alias WHERE " . DB_PREFIX . "url_alias.keyword = '" . $slug . "'");
									if($exist_keyword->num_rows){ 
										$exist_keyword_lang = $this->db->query("SELECT query FROM " . DB_PREFIX . "url_alias WHERE " . DB_PREFIX . "url_alias.keyword = '" . $slug . "' AND " . DB_PREFIX . "url_alias.query <> 'product_id=" . $product_row['product_id'] . "'");
										if($exist_keyword_lang->num_rows){
												$slug = $seo->generateSlug($product_row['name']).'-'.rand().$ext;
											}
											else
											{
												$slug = $seo->generateSlug($product_row['name']).'-'.$product_row['code'].$ext;
											}
										}
										
									
									$add_query = "INSERT INTO " . DB_PREFIX . "url_alias (query, keyword, language_id) VALUES ('product_id=" . $product_row['product_id'] . "', '" . $slug . "', " . $product_row['language_id'] . ")";
									$this->db->query($add_query);
									
								}
							}
						}
					}
				
			
		$this->cache->delete('product');
	}
	

	            public function getProductNames($product_id) {
		            $product_names = array();		
		            $query = $this->db->query("SELECT language_id,name FROM " . DB_PREFIX . "product_description WHERE product_id = '" . (int)$product_id . "'");
		
		            foreach ($query->rows as $result) {
			            $product_names[$result['language_id']] = $result['name'];
		            }		
		            return $product_names;
	            }

            
	public function editProduct($product_id, $data) {


                if(isset($data['option_combo_status'])) {

                    $this->db->query("DELETE FROM " . DB_PREFIX . "product_option_combination_setting WHERE product_id = '" . (int)$product_id . "'");

                    $this->db->query("INSERT INTO " . DB_PREFIX . "product_option_combination_setting SET product_id = '" . (int)$product_id . "', price_view = '" . (int)$data['option_combo_price_view'] . "', table_view = '" . (int)$data['option_combo_table_view'] . "', option_view = '" . (int)$data['option_combo_option_view'] . "', description_view = '" . (int)$data['option_combo_description_view'] . "', col_select_view = '" . (int)$data['option_combo_col_select_view'] . "', col_quantity_view = '" . (int)$data['option_combo_col_quantity_view'] . "', col_price_view = '" . (int)$data['option_combo_col_price_view'] . "', col_total_price_view = '" . (int)$data['option_combo_col_total_price_view'] . "', col_points_view = '" . (int)$data['option_combo_col_points_view'] . "', col_total_points_view = '" . (int)$data['option_combo_col_total_points_view'] . "', extax_view = '" . (int)$data['option_combo_extax_view'] . "', table_split = '" . (int)$data['option_combo_table_split'] . "', quantity_box = '" . (int)$data['option_combo_quantity_box'] . "', status = '" . (int)$data['option_combo_status'] . "'");

                }

                $this->db->query("DELETE FROM " . DB_PREFIX . "product_option_combination_description WHERE product_id = '" . (int)$product_id . "'");

                foreach ($data['product_option_combination_description'] as $language_id => $value) {

        			$this->db->query("INSERT INTO " . DB_PREFIX . "product_option_combination_description SET product_id = '" . (int)$product_id . "', language_id = '" . (int)$language_id . "', description = '" . $this->db->escape($value['description']) . "'");

        		}



                $this->db->query("DELETE poc,pocv FROM " . DB_PREFIX . "product_option_combination poc LEFT JOIN " . DB_PREFIX . "product_option_combination_value pocv ON poc.product_option_combination_id = pocv.product_option_combination_id WHERE product_id = '" . (int)$product_id . "'");



                if (isset($data['product_option_combo'])) {

        			foreach ($data['product_option_combo'] as $product_option_combo) {

        				if (isset($product_option_combo['product_option_combination_id'])) {

        				    $this->db->query("INSERT INTO " . DB_PREFIX . "product_option_combination SET product_option_combination_id = '" . (int)$product_option_combo['product_option_combination_id'] . "', product_id = '" . (int)$product_id . "', stock = '" . (int)$product_option_combo['stock'] . "', subtract = '" . (int)$product_option_combo['subtract'] . "', quantity = '" . (int)$product_option_combo['quantity'] . "', sort_order = '" . (int)$product_option_combo['sort_order'] . "', customer_group_id = '" . (int)$product_option_combo['customer_group_id'] . "', price = '" . $product_option_combo['price'] . "', price_prefix = '" . $product_option_combo['price_prefix'] . "', points = '" . (int)$product_option_combo['points'] . "', points_prefix = '" . $product_option_combo['points_prefix'] . "', weight = '" . $product_option_combo['weight'] . "', weight_prefix = '" . $product_option_combo['weight_prefix'] . "', date_start = '" . $product_option_combo['date_start'] . "', date_end = '" . $product_option_combo['date_end'] . "'");



                            $product_option_combination_id = $product_option_combo['product_option_combination_id'];

                        } else {

                            $this->db->query("INSERT INTO " . DB_PREFIX . "product_option_combination SET product_id = '" . (int)$product_id . "', stock = '" . (int)$product_option_combo['stock'] . "', subtract = '" . (int)$product_option_combo['subtract'] . "', quantity = '" . (int)$product_option_combo['quantity'] . "', sort_order = '" . (int)$product_option_combo['sort_order'] . "', customer_group_id = '" . (int)$product_option_combo['customer_group_id'] . "', price = '" . $product_option_combo['price'] . "', price_prefix = '" . $product_option_combo['price_prefix'] . "', points = '" . (int)$product_option_combo['points'] . "', points_prefix = '" . $product_option_combo['points_prefix'] . "', weight = '" . $product_option_combo['weight'] . "', weight_prefix = '" . $product_option_combo['weight_prefix'] . "', date_start = '" . $product_option_combo['date_start'] . "', date_end = '" . $product_option_combo['date_end'] . "'");



        					$product_option_combination_id = $this->db->getLastId();

                        }



                        if (isset($product_option_combo['product_option_combo_values'])) {

    						foreach ($product_option_combo['product_option_combo_values'] as $product_option_combo_value_id) {

    							$this->db->query("INSERT INTO " . DB_PREFIX . "product_option_combination_value SET product_option_combination_id = '" . (int)$product_option_combination_id . "', option_value_id = '" . (int)$product_option_combo_value_id . "'");

    						}

    					}

        			}

        		}

            
    $stock_status_limit = json_encode( array( "0" => 0, "1" => 2, "2" => 5 ) );
    if( isset( $data["stock_status_limit"] ) )
    {
        $stock_status_limit = json_encode( $data["stock_status_limit"] );
    }
		$this->db->query("UPDATE " . DB_PREFIX . "product SET `stock_status_limits` = '".$stock_status_limit."', model = '" . $this->db->escape($data['model']) . "', sku = '" . $this->db->escape($data['sku']) . "', upc = '" . $this->db->escape($data['upc']) . "', ean = '" . $this->db->escape($data['ean']) . "', jan = '" . $this->db->escape($data['jan']) . "', isbn = '" . $this->db->escape($data['isbn']) . "', mpn = '" . $this->db->escape($data['mpn']) . "', location = '" . $this->db->escape($data['location']) . "', quantity = '" . (int)$data['quantity'] . "', minimum = '" . (int)$data['minimum'] . "', subtract = '" . (int)$data['subtract'] . "', stock_status_id = '" . (int)$data['stock_status_id'] . "', date_available = '" . $this->db->escape($data['date_available']) . "', manufacturer_id = '" . (int)$data['manufacturer_id'] . "', shipping = '" . (int)$data['shipping'] . "', price = '" . (float)$data['price'] . "', points = '" . (int)$data['points'] . "', weight = '" . (float)$data['weight'] . "', weight_class_id = '" . (int)$data['weight_class_id'] . "', length = '" . (float)$data['length'] . "', width = '" . (float)$data['width'] . "', height = '" . (float)$data['height'] . "', length_class_id = '" . (int)$data['length_class_id'] . "', status = '" . (int)$data['status'] . "', tax_class_id = '" . $this->db->escape($data['tax_class_id']) . "', sort_order = '" . (int)$data['sort_order'] . "', date_modified = NOW() WHERE product_id = '" . (int)$product_id . "'");


			

			//echo "<pre>"; print_r($data); die('opencart/vqmod/xml/product_description_pdf.xml:63');

			//$this->db->query("DELETE FROM " . DB_PREFIX . "product_description_download_pdf WHERE product_id = '" . (int)$product_id . "'");
			//$this->db->query("DELETE FROM " . DB_PREFIX . "product_description_download_pdf_to_customer_group WHERE product_id = '" . (int)$product_id . "'");

			foreach ($data['description_document'] as $language_id => $value) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_description_download_pdf SET product_id = '" . (int)$product_id . "', language_id = '" . (int)$language_id . "', file_name = '" . $this->db->escape($value['file_name']) . "'");
			}

			$product_description_download_pdf_id = $this->db->getLastId();

			foreach ($data['description_pdf_to_customer_group'] as $customer_group) {
				$insert_description_pdf_to_customer_group = "INSERT INTO " . DB_PREFIX . "product_description_download_pdf_to_customer_group SET product_description_download_pdf_id = '".(int)$product_description_download_pdf_id."', customer_group_id = '" . (int)$customer_group . "', product_id = '" . (int)$product_id . "';";
				$this->db->query($insert_description_pdf_to_customer_group);
				//echo "<br>".$insert_description_pdf_to_customer_group."<br>";
			}
			//die('opencart/vqmod/xml/product_description_pdf.xml:77');
			
			
		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "product SET image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' WHERE product_id = '" . (int)$product_id . "'");

    		  if (isset($data['def_img']) && $data['def_img'] != "") {
                 $q="UPDATE " . DB_PREFIX . "product SET image = '" . $this->db->escape($data['def_img']) . "' WHERE product_id = '" . (int)$product_id . "'";
    		     $this->db->query($q);  
		      }
            
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_description WHERE product_id = '" . (int)$product_id . "'");
		
		foreach ($data['product_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "product_description SET product_id = '" . (int)$product_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', custom_title = '" . ((isset($value['custom_title']))?($this->db->escape($value['custom_title'])):'') . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', description = '" . $this->db->escape($value['description']) . "', tag = '" . $this->db->escape($value['tag']) . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_store WHERE product_id = '" . (int) $product_id . "'");

		if (isset($data['product_store'])) {
			foreach ($data['product_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_store SET product_id = '" . (int) $product_id . "', store_id = '" . (int) $store_id . "'");
			}
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "'");

		if (!empty($data['product_attribute'])) {
			foreach ($data['product_attribute'] as $product_attribute) {
				if ($product_attribute['attribute_id']) {
					$this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "' AND attribute_id = '" . (int)$product_attribute['attribute_id'] . "'");
					
					foreach ($product_attribute['product_attribute_description'] as $language_id => $product_attribute_description) {				
						$this->db->query("INSERT INTO " . DB_PREFIX . "product_attribute SET product_id = '" . (int)$product_id . "', attribute_id = '" . (int)$product_attribute['attribute_id'] . "', language_id = '" . (int)$language_id . "', text = '" .  $this->db->escape($product_attribute_description['text']) . "'");
					}
				}
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_option WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_option_value WHERE product_id = '" . (int)$product_id . "'");
		
		if (isset($data['product_option'])) {
			foreach ($data['product_option'] as $product_option) {
				if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
					$this->db->query("INSERT INTO " . DB_PREFIX . "product_option SET product_option_id = '" . (int)$product_option['product_option_id'] . "', product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', required = '" . (int)$product_option['required'] . "'");
				
					$product_option_id = $this->db->getLastId();
				
					if (isset($product_option['product_option_value'])  && count($product_option['product_option_value']) > 0 ) {
						foreach ($product_option['product_option_value'] as $product_option_value) {
							$this->db->query("INSERT INTO " . DB_PREFIX . "product_option_value SET product_option_value_id = '" . (int)$product_option_value['product_option_value_id'] . "', product_option_id = '" . (int)$product_option_id . "', product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', option_value_id = '" . (int)$product_option_value['option_value_id'] . "', quantity = '" . (int)$product_option_value['quantity'] . "', subtract = '" . (int)$product_option_value['subtract'] . "', price = '" . (float)$product_option_value['price'] . "', price_prefix = '" . $this->db->escape($product_option_value['price_prefix']) . "', points = '" . (int)$product_option_value['points'] . "', points_prefix = '" . $this->db->escape($product_option_value['points_prefix']) . "', weight = '" . (float)$product_option_value['weight'] . "', weight_prefix = '" . $this->db->escape($product_option_value['weight_prefix']) . "'");
						}
					}else{
						$this->db->query("DELETE FROM " . DB_PREFIX . "product_option WHERE product_option_id = '".$product_option_id."'");
					}
				} else { 
					$this->db->query("INSERT INTO " . DB_PREFIX . "product_option SET product_option_id = '" . (int)$product_option['product_option_id'] . "', product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', option_value = '" . $this->db->escape($product_option['option_value']) . "', required = '" . (int)$product_option['required'] . "'");
				}					
			}
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product_id . "'");
 
		if (isset($data['product_discount'])) {
			foreach ($data['product_discount'] as $product_discount) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_discount SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$product_discount['customer_group_id'] . "', quantity = '" . (int)$product_discount['quantity'] . "', priority = '" . (int)$product_discount['priority'] . "', price = '" . (float)$product_discount['price'] . "', date_start = '" . $this->db->escape($product_discount['date_start']) . "', date_end = '" . $this->db->escape($product_discount['date_end']) . "'");
			}
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "'");
		
		if (isset($data['product_special'])) {
			foreach ($data['product_special'] as $product_special) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_special SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$product_special['customer_group_id'] . "', priority = '" . (int)$product_special['priority'] . "', price = '" . (float)$product_special['price'] . "', date_start = '" . $this->db->escape($product_special['date_start']) . "', date_end = '" . $this->db->escape($product_special['date_end']) . "'");
			}
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$product_id . "'");
		
		if (isset($data['product_image'])) {
			foreach ($data['product_image'] as $product_image) {

    		  if ($this->config->get('multiimageuploader_deletedef') && isset($data['def_img']) && $data['def_img'] == $product_image['image']) { continue;}
            
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_image SET product_id = '" . (int)$product_id . "', image = '" . $this->db->escape(html_entity_decode($product_image['image'], ENT_QUOTES, 'UTF-8')) . "', sort_order = '" . (int)$product_image['sort_order'] . "'");
			}
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_download WHERE product_id = '" . (int)$product_id . "'");
		
		if (isset($data['product_download'])) {
			foreach ($data['product_download'] as $download_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_download SET product_id = '" . (int)$product_id . "', download_id = '" . (int)$download_id . "'");
			}
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");
		
		if (isset($data['product_category'])) {
			foreach ($data['product_category'] as $category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_category SET product_id = '" . (int)$product_id . "', category_id = '" . (int)$category_id . "'");
			}		
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_filter WHERE product_id = '" . (int)$product_id . "'");
		
		if (isset($data['product_filter'])) {
			foreach ($data['product_filter'] as $filter_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_filter SET product_id = '" . (int)$product_id . "', filter_id = '" . (int)$filter_id . "'");
			}		
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE related_id = '" . (int)$product_id . "'");

		if (isset($data['product_related'])) {
			foreach ($data['product_related'] as $related_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$product_id . "' AND related_id = '" . (int)$related_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_related SET product_id = '" . (int)$product_id . "', related_id = '" . (int)$related_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$related_id . "' AND related_id = '" . (int)$product_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_related SET product_id = '" . (int)$related_id . "', related_id = '" . (int)$product_id . "'");
			}
		}

		//print_r( $data['product_complementary']);die();
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_complementary WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_complementary WHERE complementary_id = '" . (int)$product_id . "'");

		if (isset($data['product_complementary'])) {
			foreach ($data['product_complementary'] as $complementary_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_complementary WHERE product_id = '" . (int)$product_id . "' AND complementary_id = '" . (int)$complementary_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_complementary SET product_id = '" . (int)$product_id . "', complementary_id = '" . (int)$complementary_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_complementary WHERE product_id = '" . (int)$complementary_id . "' AND complementary_id = '" . (int)$product_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_complementary SET product_id = '" . (int)$complementary_id . "', complementary_id = '" . (int)$product_id . "'");
			}
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_reward WHERE product_id = '" . (int)$product_id . "'");

		if (isset($data['product_reward'])) {
			foreach ($data['product_reward'] as $customer_group_id => $value) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_reward SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$customer_group_id . "', points = '" . (int)$value['points'] . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_layout WHERE product_id = '" . (int)$product_id . "'");

		if (isset($data['product_layout'])) {
			foreach ($data['product_layout'] as $store_id => $layout) {
				if ($layout['layout_id']) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_layout SET product_id = '" . (int)$product_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout['layout_id'] . "'");
				}
			}
		}
						
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'product_id=" . (int)$product_id. "'");
		
		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'product_id=" . (int)$product_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
						

				
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE `group` = 'seopack'");
			
				foreach ($query->rows as $result) {
						if (!$result['serialized']) {
							$data[$result['key']] = $result['value'];
						} else {
							$data[$result['key']] = unserialize($result['value']);
						}
					}
					
				if (isset($data)) {$parameters = $data['parameters'];}
					else {
						$parameters['keywords'] = '%c%p';
						$parameters['tags'] = '%c%p';
						$parameters['metas'] = '%p - %f';
						}
				
				
				if (isset($parameters['ext'])) { $ext = $parameters['ext'];}
					else {$ext = '';}
					
				if ((isset($parameters['autokeywords'])) && ($parameters['autokeywords']))
					{	
						$query = $this->db->query("select pd.name as pname, cd.name as cname, pd.language_id as language_id, pd.product_id as product_id, p.sku as sku, p.model as model, p.upc as upc, m.name as brand  from " . DB_PREFIX . "product_description pd
								left join " . DB_PREFIX . "product_to_category pc on pd.product_id = pc.product_id
								inner join " . DB_PREFIX . "product p on pd.product_id = p.product_id
								left join " . DB_PREFIX . "category_description cd on cd.category_id = pc.category_id and cd.language_id = pd.language_id
								left join " . DB_PREFIX . "manufacturer m on m.manufacturer_id = p.manufacturer_id
								where p.product_id = '" . (int)$product_id . "';");
					
								
								//die('z');
						foreach ($query->rows as $product) {
														
							$bef = array("%", "_","\"","'","\\");
							$aft = array("", " ", " ", " ", "");
							
							$included = explode('%', str_replace(array(' ',','), '', $parameters['keywords']));
							
							$tags = array();
							
							if (in_array("p", $included)) {$tags = array_merge($tags, explode(' ',trim(mysql_real_escape_string(htmlspecialchars_decode(str_replace($bef, $aft,$product['pname']))))));}
							if (in_array("c", $included)) {$tags = array_merge($tags, explode(' ',trim(mysql_real_escape_string(htmlspecialchars_decode(str_replace($bef, $aft,$product['cname']))))));}
							if (in_array("s", $included)) {$tags = array_merge($tags, explode(' ',trim(mysql_real_escape_string(htmlspecialchars_decode(str_replace($bef, $aft,$product['sku']))))));}
							if (in_array("m", $included)) {$tags = array_merge($tags, explode(' ',trim(mysql_real_escape_string(htmlspecialchars_decode(str_replace($bef, $aft,$product['model']))))));}
							if (in_array("u", $included)) {$tags = array_merge($tags, explode(' ',trim(mysql_real_escape_string(htmlspecialchars_decode(str_replace($bef, $aft,$product['upc']))))));}
							if (in_array("b", $included)) {$tags = array_merge($tags, explode(' ',trim(mysql_real_escape_string(htmlspecialchars_decode(str_replace($bef, $aft,$product['brand']))))));}
							
							$keywords = '';
							
							foreach ($tags as $tag)
								{
								if (strlen($tag) > 2) 
									{
									
									$keywords = $keywords.' '.strtolower($tag);
									
									}
								}
								
							
							$exists = $this->db->query("select count(*) as times from " . DB_PREFIX . "product_description where product_id = ".$product['product_id']." and language_id = ".$product['language_id']." and meta_keyword like '%".$keywords."%';");
							
									foreach ($exists->rows as $exist)
										{
										$count = $exist['times'];
										}
							$exists = $this->db->query("select length(meta_keyword) as leng from " . DB_PREFIX . "product_description where product_id = ".$product['product_id']." and language_id = ".$product['language_id'].";");
							
									foreach ($exists->rows as $exist)
										{
										$leng = $exist['leng'];
										}

							if (($count == 0) && ($leng < 255)) {$this->db->query("update " . DB_PREFIX . "product_description set meta_keyword = concat(meta_keyword, '". htmlspecialchars($keywords) ."') where product_id = ".$product['product_id']." and language_id = ".$product['language_id'].";");}	
								
														
							}
					}
				if ((isset($parameters['autometa'])) && ($parameters['autometa']))
					{
						$query = $this->db->query("select pd.name as pname, p.price as price, cd.name as cname, pd.description as pdescription, pd.language_id as language_id, pd.product_id as product_id, p.model as model, p.sku as sku, p.upc as upc, m.name as brand from " . DB_PREFIX . "product_description pd
								left join " . DB_PREFIX . "product_to_category pc on pd.product_id = pc.product_id
								inner join " . DB_PREFIX . "product p on pd.product_id = p.product_id
								left join " . DB_PREFIX . "category_description cd on cd.category_id = pc.category_id and cd.language_id = pd.language_id
								left join " . DB_PREFIX . "manufacturer m on m.manufacturer_id = p.manufacturer_id
								where p.product_id = '" . (int)$product_id . "';");

						foreach ($query->rows as $product) {
														
							$bef = array("%", "_","\"","'","\\", "\r", "\n");
							$aft = array("", " ", " ", " ", "", "", "");
							
							$ncategory = trim(mysql_real_escape_string(htmlspecialchars_decode(str_replace($bef, $aft,$product['cname']))));
							$nproduct = trim(mysql_real_escape_string(htmlspecialchars_decode(str_replace($bef, $aft,$product['pname']))));
							$model = trim(mysql_real_escape_string(htmlspecialchars_decode(str_replace($bef, $aft,$product['model']))));
							$sku = trim(mysql_real_escape_string(htmlspecialchars_decode(str_replace($bef, $aft,$product['sku']))));
							$upc = trim(mysql_real_escape_string(htmlspecialchars_decode(str_replace($bef, $aft,$product['upc']))));
							$content = strip_tags(html_entity_decode($product['pdescription']));
							$pos = strpos($content, '.');							   
							if($pos === false) {}
								else { $content =  substr($content, 0, $pos+1);	}
							$sentence = trim(mysql_real_escape_string(htmlspecialchars_decode(str_replace($bef, $aft, $content))));
							$brand = trim(mysql_real_escape_string(htmlspecialchars_decode(str_replace($bef, $aft,$product['brand']))));
							$price = trim(mysql_real_escape_string(htmlspecialchars_decode(str_replace($bef, $aft, number_format($product['price'], 2)))));
							
							$bef = array("%c", "%p", "%m", "%s", "%u", "%f", "%b", "%$");
							$aft = array($ncategory, $nproduct, $model, $sku, $upc, $sentence, $brand, $price);
							
							$meta_description = str_replace($bef, $aft,  $parameters['metas']);
							
							$exists = $this->db->query("select count(*) as times from " . DB_PREFIX . "product_description where product_id = ".$product['product_id']." and language_id = ".$product['language_id']." and meta_description not like '%".htmlspecialchars($meta_description)."%';");
							
									foreach ($exists->rows as $exist)
										{
										$count = $exist['times'];
										}
							
							if ($count) {$this->db->query("update " . DB_PREFIX . "product_description set meta_description = concat(meta_description, '". htmlspecialchars($meta_description) ."') where product_id = ".$product['product_id']." and language_id = ".$product['language_id'].";");}			
														
							}
					}
				if ((isset($parameters['autotags'])) && ($parameters['autotags']))
					{
					$query = $this->db->query("select pd.name as pname, pd.tag, cd.name as cname, pd.language_id as language_id, pd.product_id as product_id, p.sku as sku, p.model as model, p.upc as upc, m.name as brand from " . DB_PREFIX . "product_description pd
							inner join " . DB_PREFIX . "product_to_category pc on pd.product_id = pc.product_id
							inner join " . DB_PREFIX . "product p on pd.product_id = p.product_id
							inner join " . DB_PREFIX . "category_description cd on cd.category_id = pc.category_id and cd.language_id = pd.language_id
							left join " . DB_PREFIX . "manufacturer m on m.manufacturer_id = p.manufacturer_id
							where p.product_id = '" . (int)$product_id . "';");
					
					foreach ($query->rows as $product) {
						
						$newtags ='';
						
						$included = explode('%', str_replace(array(' ',','), '', $parameters['tags']));
						
						$tags = array();
						
						
						$bef = array("%", "_","\"","'","\\");
						$aft = array("", " ", " ", " ", "");
						
							if (in_array("p", $included)) {$tags = array_merge($tags, explode(' ',trim(mysql_real_escape_string(htmlspecialchars_decode(str_replace($bef, $aft,$product['pname']))))));}
							if (in_array("c", $included)) {$tags = array_merge($tags, explode(' ',trim(mysql_real_escape_string(htmlspecialchars_decode(str_replace($bef, $aft,$product['cname']))))));}
							if (in_array("s", $included)) {$tags = array_merge($tags, explode(' ',trim(mysql_real_escape_string(htmlspecialchars_decode(str_replace($bef, $aft,$product['sku']))))));}
							if (in_array("m", $included)) {$tags = array_merge($tags, explode(' ',trim(mysql_real_escape_string(htmlspecialchars_decode(str_replace($bef, $aft,$product['model']))))));}
							if (in_array("u", $included)) {$tags = array_merge($tags, explode(' ',trim(mysql_real_escape_string(htmlspecialchars_decode(str_replace($bef, $aft,$product['upc']))))));}
							if (in_array("b", $included)) {$tags = array_merge($tags, explode(' ',trim(mysql_real_escape_string(htmlspecialchars_decode(str_replace($bef, $aft,$product['brand']))))));}
							
							foreach ($tags as $tag)
								{
								if (strlen($tag) > 2) 
									{
									if ((strpos($product['tag'], strtolower($tag)) === false) && (strpos($newtags, strtolower($tag)) === false))
										{
											$newtags .= ' '.strtolower($tag).',';											
										}			
									}
								}
							
														
							if ($product['tag']) {
								$newtags = trim(mysql_real_escape_string($product['tag']) . $newtags,' ,');
								$this->db->query("update " . DB_PREFIX . "product_description set tag = '$newtags' where product_id = '". $product['product_id'] ."' and language_id = '". $product['language_id'] ."';");
								}
								else {
								$newtags = trim($newtags,' ,');
								$this->db->query("update " . DB_PREFIX . "product_description set tag = '$newtags' where product_id = '". $product['product_id'] ."' and language_id = '". $product['language_id'] ."';");
								}
																				
						}
						
					}
				if ((isset($parameters['autourls'])) && ($parameters['autourls']))
					{
						require_once(DIR_APPLICATION . 'controller/catalog/seopack.php');
						$seo = new ControllerCatalogSeoPack($this->registry);
						
						$query = $this->db->query("SELECT pd.product_id, pd.name, pd.language_id ,l.code FROM ".DB_PREFIX."product p 
								inner join ".DB_PREFIX."product_description pd ON p.product_id = pd.product_id 
								inner join ".DB_PREFIX."language l on l.language_id = pd.language_id 
								where p.product_id = '" . (int)$product_id . "';");

						
						foreach ($query->rows as $product_row ){	

							
							if( strlen($product_row['name']) > 1 ){
							
								$slug = $seo->generateSlug($product_row['name']).$ext;
								$exist_query = $this->db->query("SELECT query FROM " . DB_PREFIX . "url_alias WHERE " . DB_PREFIX . "url_alias.query = 'product_id=" . $product_row['product_id'] . "' and language_id=".$product_row['language_id']);
								
								if(!$exist_query->num_rows){
									
									$exist_keyword = $this->db->query("SELECT query FROM " . DB_PREFIX . "url_alias WHERE " . DB_PREFIX . "url_alias.keyword = '" . $slug . "'");
									if($exist_keyword->num_rows){ 
										$exist_keyword_lang = $this->db->query("SELECT query FROM " . DB_PREFIX . "url_alias WHERE " . DB_PREFIX . "url_alias.keyword = '" . $slug . "' AND " . DB_PREFIX . "url_alias.query <> 'product_id=" . $product_row['product_id'] . "'");
										if($exist_keyword_lang->num_rows){
												$slug = $seo->generateSlug($product_row['name']).'-'.rand().$ext;
											}
											else
											{
												$slug = $seo->generateSlug($product_row['name']).'-'.$product_row['code'].$ext;
											}
										}
										
									
									$add_query = "INSERT INTO " . DB_PREFIX . "url_alias (query, keyword, language_id) VALUES ('product_id=" . $product_row['product_id'] . "', '" . $slug . "', " . $product_row['language_id'] . ")";
									$this->db->query($add_query);
									
								}
							}
						}
					}
				
			
		$this->db->query("DELETE FROM `" . DB_PREFIX . "product_profile` WHERE product_id = " . (int) $product_id);		if (isset($data['product_profiles'])) {			foreach ($data['product_profiles'] as $profile) {				$this->db->query("INSERT INTO `" . DB_PREFIX . "product_profile` SET `product_id` = " . (int) $product_id . ", customer_group_id = " . (int) $profile['customer_group_id'] . ", `profile_id` = " . (int) $profile['profile_id']);			}		}		$this->cache->delete('product');
	}
	
	public function copyProduct($product_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p.product_id = '" . (int)$product_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		if ($query->num_rows) {
			$data = array();
			
			$data = $query->row;
			
			$data['sku'] = '';
			$data['upc'] = '';
			$data['viewed'] = '0';
			$data['keyword'] = '';
			$data['status'] = '0';
						
			$data = array_merge($data, array('product_attribute' => $this->getProductAttributes($product_id)));
			$data = array_merge($data, array('product_description' => $this->getProductDescriptions($product_id)));			
			$data = array_merge($data, array('product_discount' => $this->getProductDiscounts($product_id)));
			$data = array_merge($data, array('product_filter' => $this->getProductFilters($product_id)));
			$data = array_merge($data, array('product_image' => $this->getProductImages($product_id)));		
			$data = array_merge($data, array('product_option' => $this->getProductOptions($product_id)));
			$data = array_merge($data, array('product_related' => $this->getProductRelated($product_id)));
			$data = array_merge($data, array('product_reward' => $this->getProductRewards($product_id)));
			$data = array_merge($data, array('product_special' => $this->getProductSpecials($product_id)));
			$data = array_merge($data, array('product_category' => $this->getProductCategories($product_id)));
			$data = array_merge($data, array('product_download' => $this->getProductDownloads($product_id)));
			$data = array_merge($data, array('product_layout' => $this->getProductLayouts($product_id)));
			$data = array_merge($data, array('product_store' => $this->getProductStores($product_id)));
			$data = array_merge($data, array('product_profiles' => $this->getProfiles($product_id)));


                $data = array_merge($data, array('product_option_combination' => $this->getProductOptionCombos($product_id)));

                $data = array_merge($data, array('product_option_combination_description' => $this->getProductOptionComboDescription($product_id)));

                $data = array_merge($data, array('product_option_combination_setting' => $this->getProductOptionComboSetting($product_id)));

            
			$this->addProduct($data);
		}
	}
	
	public function deleteProduct($product_id) {


                $this->db->query("DELETE FROM " . DB_PREFIX . "product_option_combination WHERE product_id = '" . (int)$product_id . "'");

                $this->db->query("DELETE FROM " . DB_PREFIX . "product_option_combination_description WHERE product_id = '" . (int)$product_id . "'");

                $this->db->query("DELETE FROM " . DB_PREFIX . "product_option_combination_setting WHERE product_id = '" . (int)$product_id . "'");

                $this->db->query("DELETE FROM " . DB_PREFIX . "product_option_combination_value WHERE product_option_combination_id NOT IN (SELECT product_option_combination_id FROM " . DB_PREFIX . "product_option_combination)");

            
		$this->db->query("DELETE FROM " . DB_PREFIX . "product WHERE product_id = '" . (int) $product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int) $product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_description WHERE product_id = '" . (int) $product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int) $product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_filter WHERE product_id = '" . (int) $product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int) $product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_option WHERE product_id = '" . (int) $product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_option_value WHERE product_id = '" . (int) $product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int) $product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE related_id = '" . (int) $product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_reward WHERE product_id = '" . (int) $product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int) $product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int) $product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_download WHERE product_id = '" . (int) $product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_layout WHERE product_id = '" . (int) $product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_store WHERE product_id = '" . (int) $product_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "product_profile` WHERE `product_id` = " . (int) $product_id);
		$this->db->query("DELETE FROM " . DB_PREFIX . "review WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_complementary WHERE product_id = '" . (int) $product_id . "'");
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'product_id=" . (int)$product_id. "'");
		

				
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE `group` = 'seopack'");
			
				foreach ($query->rows as $result) {
						if (!$result['serialized']) {
							$data[$result['key']] = $result['value'];
						} else {
							$data[$result['key']] = unserialize($result['value']);
						}
					}
					
				if (isset($data)) {$parameters = $data['parameters'];}
					else {
						$parameters['keywords'] = '%c%p';
						$parameters['tags'] = '%c%p';
						$parameters['metas'] = '%p - %f';
						}
				
				
				if (isset($parameters['ext'])) { $ext = $parameters['ext'];}
					else {$ext = '';}
					
				if ((isset($parameters['autokeywords'])) && ($parameters['autokeywords']))
					{	
						$query = $this->db->query("select pd.name as pname, cd.name as cname, pd.language_id as language_id, pd.product_id as product_id, p.sku as sku, p.model as model, p.upc as upc, m.name as brand  from " . DB_PREFIX . "product_description pd
								left join " . DB_PREFIX . "product_to_category pc on pd.product_id = pc.product_id
								inner join " . DB_PREFIX . "product p on pd.product_id = p.product_id
								left join " . DB_PREFIX . "category_description cd on cd.category_id = pc.category_id and cd.language_id = pd.language_id
								left join " . DB_PREFIX . "manufacturer m on m.manufacturer_id = p.manufacturer_id
								where p.product_id = '" . (int)$product_id . "';");
					
								
								//die('z');
						foreach ($query->rows as $product) {
														
							$bef = array("%", "_","\"","'","\\");
							$aft = array("", " ", " ", " ", "");
							
							$included = explode('%', str_replace(array(' ',','), '', $parameters['keywords']));
							
							$tags = array();
							
							if (in_array("p", $included)) {$tags = array_merge($tags, explode(' ',trim(mysql_real_escape_string(htmlspecialchars_decode(str_replace($bef, $aft,$product['pname']))))));}
							if (in_array("c", $included)) {$tags = array_merge($tags, explode(' ',trim(mysql_real_escape_string(htmlspecialchars_decode(str_replace($bef, $aft,$product['cname']))))));}
							if (in_array("s", $included)) {$tags = array_merge($tags, explode(' ',trim(mysql_real_escape_string(htmlspecialchars_decode(str_replace($bef, $aft,$product['sku']))))));}
							if (in_array("m", $included)) {$tags = array_merge($tags, explode(' ',trim(mysql_real_escape_string(htmlspecialchars_decode(str_replace($bef, $aft,$product['model']))))));}
							if (in_array("u", $included)) {$tags = array_merge($tags, explode(' ',trim(mysql_real_escape_string(htmlspecialchars_decode(str_replace($bef, $aft,$product['upc']))))));}
							if (in_array("b", $included)) {$tags = array_merge($tags, explode(' ',trim(mysql_real_escape_string(htmlspecialchars_decode(str_replace($bef, $aft,$product['brand']))))));}
							
							$keywords = '';
							
							foreach ($tags as $tag)
								{
								if (strlen($tag) > 2) 
									{
									
									$keywords = $keywords.' '.strtolower($tag);
									
									}
								}
								
							
							$exists = $this->db->query("select count(*) as times from " . DB_PREFIX . "product_description where product_id = ".$product['product_id']." and language_id = ".$product['language_id']." and meta_keyword like '%".$keywords."%';");
							
									foreach ($exists->rows as $exist)
										{
										$count = $exist['times'];
										}
							$exists = $this->db->query("select length(meta_keyword) as leng from " . DB_PREFIX . "product_description where product_id = ".$product['product_id']." and language_id = ".$product['language_id'].";");
							
									foreach ($exists->rows as $exist)
										{
										$leng = $exist['leng'];
										}

							if (($count == 0) && ($leng < 255)) {$this->db->query("update " . DB_PREFIX . "product_description set meta_keyword = concat(meta_keyword, '". htmlspecialchars($keywords) ."') where product_id = ".$product['product_id']." and language_id = ".$product['language_id'].";");}	
								
														
							}
					}
				if ((isset($parameters['autometa'])) && ($parameters['autometa']))
					{
						$query = $this->db->query("select pd.name as pname, p.price as price, cd.name as cname, pd.description as pdescription, pd.language_id as language_id, pd.product_id as product_id, p.model as model, p.sku as sku, p.upc as upc, m.name as brand from " . DB_PREFIX . "product_description pd
								left join " . DB_PREFIX . "product_to_category pc on pd.product_id = pc.product_id
								inner join " . DB_PREFIX . "product p on pd.product_id = p.product_id
								left join " . DB_PREFIX . "category_description cd on cd.category_id = pc.category_id and cd.language_id = pd.language_id
								left join " . DB_PREFIX . "manufacturer m on m.manufacturer_id = p.manufacturer_id
								where p.product_id = '" . (int)$product_id . "';");

						foreach ($query->rows as $product) {
														
							$bef = array("%", "_","\"","'","\\", "\r", "\n");
							$aft = array("", " ", " ", " ", "", "", "");
							
							$ncategory = trim(mysql_real_escape_string(htmlspecialchars_decode(str_replace($bef, $aft,$product['cname']))));
							$nproduct = trim(mysql_real_escape_string(htmlspecialchars_decode(str_replace($bef, $aft,$product['pname']))));
							$model = trim(mysql_real_escape_string(htmlspecialchars_decode(str_replace($bef, $aft,$product['model']))));
							$sku = trim(mysql_real_escape_string(htmlspecialchars_decode(str_replace($bef, $aft,$product['sku']))));
							$upc = trim(mysql_real_escape_string(htmlspecialchars_decode(str_replace($bef, $aft,$product['upc']))));
							$content = strip_tags(html_entity_decode($product['pdescription']));
							$pos = strpos($content, '.');							   
							if($pos === false) {}
								else { $content =  substr($content, 0, $pos+1);	}
							$sentence = trim(mysql_real_escape_string(htmlspecialchars_decode(str_replace($bef, $aft, $content))));
							$brand = trim(mysql_real_escape_string(htmlspecialchars_decode(str_replace($bef, $aft,$product['brand']))));
							$price = trim(mysql_real_escape_string(htmlspecialchars_decode(str_replace($bef, $aft, number_format($product['price'], 2)))));
							
							$bef = array("%c", "%p", "%m", "%s", "%u", "%f", "%b", "%$");
							$aft = array($ncategory, $nproduct, $model, $sku, $upc, $sentence, $brand, $price);
							
							$meta_description = str_replace($bef, $aft,  $parameters['metas']);
							
							$exists = $this->db->query("select count(*) as times from " . DB_PREFIX . "product_description where product_id = ".$product['product_id']." and language_id = ".$product['language_id']." and meta_description not like '%".htmlspecialchars($meta_description)."%';");
							
									foreach ($exists->rows as $exist)
										{
										$count = $exist['times'];
										}
							
							if ($count) {$this->db->query("update " . DB_PREFIX . "product_description set meta_description = concat(meta_description, '". htmlspecialchars($meta_description) ."') where product_id = ".$product['product_id']." and language_id = ".$product['language_id'].";");}			
														
							}
					}
				if ((isset($parameters['autotags'])) && ($parameters['autotags']))
					{
					$query = $this->db->query("select pd.name as pname, pd.tag, cd.name as cname, pd.language_id as language_id, pd.product_id as product_id, p.sku as sku, p.model as model, p.upc as upc, m.name as brand from " . DB_PREFIX . "product_description pd
							inner join " . DB_PREFIX . "product_to_category pc on pd.product_id = pc.product_id
							inner join " . DB_PREFIX . "product p on pd.product_id = p.product_id
							inner join " . DB_PREFIX . "category_description cd on cd.category_id = pc.category_id and cd.language_id = pd.language_id
							left join " . DB_PREFIX . "manufacturer m on m.manufacturer_id = p.manufacturer_id
							where p.product_id = '" . (int)$product_id . "';");
					
					foreach ($query->rows as $product) {
						
						$newtags ='';
						
						$included = explode('%', str_replace(array(' ',','), '', $parameters['tags']));
						
						$tags = array();
						
						
						$bef = array("%", "_","\"","'","\\");
						$aft = array("", " ", " ", " ", "");
						
							if (in_array("p", $included)) {$tags = array_merge($tags, explode(' ',trim(mysql_real_escape_string(htmlspecialchars_decode(str_replace($bef, $aft,$product['pname']))))));}
							if (in_array("c", $included)) {$tags = array_merge($tags, explode(' ',trim(mysql_real_escape_string(htmlspecialchars_decode(str_replace($bef, $aft,$product['cname']))))));}
							if (in_array("s", $included)) {$tags = array_merge($tags, explode(' ',trim(mysql_real_escape_string(htmlspecialchars_decode(str_replace($bef, $aft,$product['sku']))))));}
							if (in_array("m", $included)) {$tags = array_merge($tags, explode(' ',trim(mysql_real_escape_string(htmlspecialchars_decode(str_replace($bef, $aft,$product['model']))))));}
							if (in_array("u", $included)) {$tags = array_merge($tags, explode(' ',trim(mysql_real_escape_string(htmlspecialchars_decode(str_replace($bef, $aft,$product['upc']))))));}
							if (in_array("b", $included)) {$tags = array_merge($tags, explode(' ',trim(mysql_real_escape_string(htmlspecialchars_decode(str_replace($bef, $aft,$product['brand']))))));}
							
							foreach ($tags as $tag)
								{
								if (strlen($tag) > 2) 
									{
									if ((strpos($product['tag'], strtolower($tag)) === false) && (strpos($newtags, strtolower($tag)) === false))
										{
											$newtags .= ' '.strtolower($tag).',';											
										}			
									}
								}
							
														
							if ($product['tag']) {
								$newtags = trim(mysql_real_escape_string($product['tag']) . $newtags,' ,');
								$this->db->query("update " . DB_PREFIX . "product_description set tag = '$newtags' where product_id = '". $product['product_id'] ."' and language_id = '". $product['language_id'] ."';");
								}
								else {
								$newtags = trim($newtags,' ,');
								$this->db->query("update " . DB_PREFIX . "product_description set tag = '$newtags' where product_id = '". $product['product_id'] ."' and language_id = '". $product['language_id'] ."';");
								}
																				
						}
						
					}
				if ((isset($parameters['autourls'])) && ($parameters['autourls']))
					{
						require_once(DIR_APPLICATION . 'controller/catalog/seopack.php');
						$seo = new ControllerCatalogSeoPack($this->registry);
						
						$query = $this->db->query("SELECT pd.product_id, pd.name, pd.language_id ,l.code FROM ".DB_PREFIX."product p 
								inner join ".DB_PREFIX."product_description pd ON p.product_id = pd.product_id 
								inner join ".DB_PREFIX."language l on l.language_id = pd.language_id 
								where p.product_id = '" . (int)$product_id . "';");

						
						foreach ($query->rows as $product_row ){	

							
							if( strlen($product_row['name']) > 1 ){
							
								$slug = $seo->generateSlug($product_row['name']).$ext;
								$exist_query = $this->db->query("SELECT query FROM " . DB_PREFIX . "url_alias WHERE " . DB_PREFIX . "url_alias.query = 'product_id=" . $product_row['product_id'] . "' and language_id=".$product_row['language_id']);
								
								if(!$exist_query->num_rows){
									
									$exist_keyword = $this->db->query("SELECT query FROM " . DB_PREFIX . "url_alias WHERE " . DB_PREFIX . "url_alias.keyword = '" . $slug . "'");
									if($exist_keyword->num_rows){ 
										$exist_keyword_lang = $this->db->query("SELECT query FROM " . DB_PREFIX . "url_alias WHERE " . DB_PREFIX . "url_alias.keyword = '" . $slug . "' AND " . DB_PREFIX . "url_alias.query <> 'product_id=" . $product_row['product_id'] . "'");
										if($exist_keyword_lang->num_rows){
												$slug = $seo->generateSlug($product_row['name']).'-'.rand().$ext;
											}
											else
											{
												$slug = $seo->generateSlug($product_row['name']).'-'.$product_row['code'].$ext;
											}
										}
										
									
									$add_query = "INSERT INTO " . DB_PREFIX . "url_alias (query, keyword, language_id) VALUES ('product_id=" . $product_row['product_id'] . "', '" . $slug . "', " . $product_row['language_id'] . ")";
									$this->db->query($add_query);
									
								}
							}
						}
					}
				
			

			
			$this->db->query("DELETE FROM " . DB_PREFIX . "product_description_download_pdf WHERE product_id = '" . (int)$product_id . "'");
			
			
		$this->cache->delete('product');
	}
	
	public function getProduct($product_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'product_id=" . (int)$product_id . "') AS keyword FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p.product_id = '" . (int)$product_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
				
		return $query->row;
	}
	
	public function getProducts($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id)";
		
		if (!empty($data['filter_category_id'])) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id)";			
		}
				
		$sql .= " WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'"; 
		

			if (!empty($data['filter_manufacturer'])) {
				$sql .= " AND p.manufacturer_id = '" . (int)$data['filter_manufacturer'] . "'";
			}
            if (!empty($data['filter_category_id'])) {
				$sql .= " AND p2c.category_id = '" . (int)$data['filter_category_id'] . "'";
			}
            if (!empty($data['filter_upc'])) {
				$sql .= " AND p.upc = '" . $data['filter_upc'] . "'";
			}
            
		if (!empty($data['filter_name'])) {
			$sql .= " AND pd.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}


		        if (!empty($data['filter_upc'])) {
			        $sql .= " AND LCASE(p.upc) LIKE '" . $this->db->escape(utf8_strtolower($data['filter_upc'])) . "%'";
		        }
              
		if (!empty($data['filter_model'])) {
			$sql .= " AND p.model LIKE '" . $this->db->escape($data['filter_model']) . "%'";
		}
		
		if (!empty($data['filter_price'])) {
			$sql .= " AND p.price LIKE '" . $this->db->escape($data['filter_price']) . "%'";
		}
		
		if (isset($data['filter_quantity']) && !is_null($data['filter_quantity'])) {
			$sql .= " AND p.quantity = '" . $this->db->escape($data['filter_quantity']) . "'";
		}
		
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
		}
		
		$sql .= " GROUP BY p.product_id";
					
		$sort_data = array(
'm.name','p.model','p.upc',
            
			'pd.name',
			'p.model',
			'p.price',
			'p.quantity',
			'p.status',
			'p.sort_order'
		);	
		
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY pd.name";	
		}
		
		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
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
		
		$query = $this->db->query($sql);
	
		return $query->rows;
	}
	
	public function getProductsByCategoryId($category_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2c.category_id = '" . (int)$category_id . "' ORDER BY pd.name ASC");
								  
		return $query->rows;
	} 
	
	public function getProductDescriptions($product_id) {
		$product_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_description WHERE product_id = '" . (int)$product_id . "'");
		
		foreach ($query->rows as $result) {
			$product_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
				'description'      => $result['description'],
				'meta_keyword'     => $result['meta_keyword'],
				'custom_title' => $result['custom_title'], 'meta_description' => $result['meta_description'],
				'tag'              => $result['tag']
			);
		}
		
		return $product_description_data;
	}
		
	public function getProductCategories($product_id) {
		$product_category_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");
		
		foreach ($query->rows as $result) {
			$product_category_data[] = $result['category_id'];
		}

		return $product_category_data;
	}
	
	public function getProductFilters($product_id) {
		$product_filter_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_filter WHERE product_id = '" . (int)$product_id . "'");
		
		foreach ($query->rows as $result) {
			$product_filter_data[] = $result['filter_id'];
		}
				
		return $product_filter_data;
	}
	

			
		public function getProductDocument($product_id) {
			$product_document_data = array();

			$product_document_data = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_description_download_pdf WHERE product_id = '" . (int)$product_id . "'")->rows;

			//echo "<pre>"; print_r($product_document_data);  die('opencart/vqmod/xml/product_description_pdf.xml:136');

			foreach($product_document_data as &$doc){
				$get_doc_to_group = "SELECT customer_group_id FROM " . DB_PREFIX . "product_description_download_pdf_to_customer_group WHERE product_description_download_pdf_id = ".$doc['product_description_download_pdf_id']." ;";
				$doc['customer_to_group'] = $this->db->query($get_doc_to_group)->rows;
			}

			return $product_document_data;
		}

		public function get_pr_document_details($pr_document_id) { // Not USED !!!

			$product_document_data_details = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_description_download_pdf WHERE product_description_download_pdf_id = '" . (int)$pr_document_id . "'")->row;

			$description_to_customer_group = "SELECT
												  dtg.*, `cgd`.`name`
												FROM
												  oc_product_description_download_pdf_to_customer_group dtg,
												  oc_customer_group_description cgd
												WHERE dtg.product_description_download_pdf_id = '" . (int)$pr_document_id . "'
												  AND cgd.`customer_group_id` = dtg.`customer_group_id`;";

			//die($description_to_customer_group.'<br>opencart/vqmod/xml/product_description_pdf.xml:127');

			$description_to_customer_group = $this->db->query($description_to_customer_group)->rows;

			$product_document_data_details['customer_to_group'] = $description_to_customer_group;

			$product_document_data_details['file_name'] = trim(substr($product_document_data_details['file_name'],0,strrpos($product_document_data_details['file_name'],'.')));

			/*if ($description_to_customer_group->rows) {
				foreach ($description_to_customer_group->rows as $key => $item) {
					$product_document_data[$result['language_id']]['customer_group'] .= (!$key) ? $item['name'] : ", ".$item['name'];
				}
			}*/

			echo "<pre>"; print_r($product_document_data_details);  die('opencart/vqmod/xml/product_description_pdf.xml:141');

		}

		public function insert_product_document($data) {

			$response = '';

			//echo "<pre>"; print_r($data); die('opencart/vqmod/xml/product_description_pdf.xml:142');

			$insert_product_document_query = "INSERT INTO " . DB_PREFIX . "product_description_download_pdf SET product_id = '" . (int)$data['product_id'] . "', language_id = '" . (int)$data['language_id'] . "', file_name = '" . $this->db->escape($data['file_name']) . "', `document_name` = '" . $this->db->escape($data['document_name']) . "', `document_type` = '" . $this->db->escape($data['document_type']) . "', `document_description` = '" . $this->db->escape($data['document_description']) . "';";

			//die($insert_product_document_query.'<br><br>opencart/vqmod/xml/product_description_pdf.xml:146');

			$insert_product_document_query = $this->db->query($insert_product_document_query);

			if ($insert_product_document_query) {
				$response = true;
			}

			/*foreach ($data['description_document'] as $language_id => $value) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_description_download_pdf SET product_id = '" . (int)$product_id . "', language_id = '" . (int)$language_id . "', file_name = '" . $this->db->escape($value['file_name']) . "'");
			}*/

			$product_description_download_pdf_id = $this->db->getLastId();

			if ($data['customer_group'] && is_array($data['customer_group'])) {
				foreach ($data['customer_group'] as $customer_group) {
					$insert_description_pdf_to_customer_group = "INSERT INTO " . DB_PREFIX . "product_description_download_pdf_to_customer_group SET product_description_download_pdf_id = '".(int)$product_description_download_pdf_id."', customer_group_id = '" . (int)$customer_group . "', product_id = '" . (int)$data['product_id'] . "';";
					$this->db->query($insert_description_pdf_to_customer_group);
					//echo "<br>".$insert_description_pdf_to_customer_group."<br>";
				}
			}
		}

		public function update_pr_document_details($data) {

			$response = '';

			//echo "<pre>"; print_r($data); die('opencart/vqmod/xml/product_description_pdf.xml:181');

			$update_product_document_query = "UPDATE " . DB_PREFIX . "product_description_download_pdf SET product_id = '" . (int)$data['product_id'] . "', language_id = '" . (int)$data['language_id'] . "', file_name = '" . $this->db->escape($data['file_name']) . "', `document_name` = '" . $this->db->escape($data['document_name']) . "', `document_type` = '" . $this->db->escape($data['document_type']) . "', `document_description` = '" . $this->db->escape($data['document_description']) . "' WHERE product_description_download_pdf_id = '".$data['product_document_id']."';";

			//die($update_product_document_query.'<br><br>opencart/vqmod/xml/product_description_pdf.xml:185');

			$update_product_document_query = $this->db->query($update_product_document_query);

			if ($update_product_document_query) {
				$response = true;
			}

			/*foreach ($data['description_document'] as $language_id => $value) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_description_download_pdf SET product_id = '" . (int)$product_id . "', language_id = '" . (int)$language_id . "', file_name = '" . $this->db->escape($value['file_name']) . "'");
			}*/

			$delete_group = "DELETE FROM " . DB_PREFIX . "product_description_download_pdf_to_customer_group WHERE product_description_download_pdf_id = '" . (int)$data['product_document_id'] . "'";
			//die($delete_group);
			$this->db->query($delete_group);

			$product_description_download_pdf_id = $this->db->getLastId();

			if ($data['customer_group'] && is_array($data['customer_group'])) {
				foreach ($data['customer_group'] as $customer_group) {
					$update_description_pdf_to_customer_group = "INSERT INTO " . DB_PREFIX . "product_description_download_pdf_to_customer_group SET product_description_download_pdf_id = '".(int)$data['product_document_id']."', customer_group_id = '" . (int)$customer_group . "', product_id = '" . (int)$data['product_id'] . "';";
					$this->db->query($update_description_pdf_to_customer_group);
					//echo "<br>".$update_description_pdf_to_customer_group."<br>";
				}
			}

			return $response;
		}
			
			
	public function getProductAttributes($product_id) {
		$product_attribute_data = array();
		
		$product_attribute_query = $this->db->query("SELECT attribute_id FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "' GROUP BY attribute_id");
		
		foreach ($product_attribute_query->rows as $product_attribute) {
			$product_attribute_description_data = array();
			
			$product_attribute_description_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "' AND attribute_id = '" . (int)$product_attribute['attribute_id'] . "'");
			
			foreach ($product_attribute_description_query->rows as $product_attribute_description) {
				$product_attribute_description_data[$product_attribute_description['language_id']] = array('text' => $product_attribute_description['text']);
			}
			
			$product_attribute_data[] = array(
				'attribute_id'                  => $product_attribute['attribute_id'],
				'product_attribute_description' => $product_attribute_description_data
			);
		}
		
		return $product_attribute_data;
	}
	
	public function getProductOptions($product_id) {
		$product_option_data = array();
		
		$product_option_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "product_option` po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN `" . DB_PREFIX . "option_description` od ON (o.option_id = od.option_id) WHERE po.product_id = '" . (int)$product_id . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		foreach ($product_option_query->rows as $product_option) {
			$product_option_value_data = array();	
				
			$product_option_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value WHERE product_option_id = '" . (int)$product_option['product_option_id'] . "'");
				
			foreach ($product_option_value_query->rows as $product_option_value) {
				$product_option_value_data[] = array(
					'product_option_value_id' => $product_option_value['product_option_value_id'],
					'option_value_id'         => $product_option_value['option_value_id'],
					'quantity'                => $product_option_value['quantity'],
					'subtract'                => $product_option_value['subtract'],
					'price'                   => $product_option_value['price'],
					'price_prefix'            => $product_option_value['price_prefix'],
					'points'                  => $product_option_value['points'],
					'points_prefix'           => $product_option_value['points_prefix'],						
					'weight'                  => $product_option_value['weight'],
					'weight_prefix'           => $product_option_value['weight_prefix']					
				);
			}
				
			$product_option_data[] = array(
				'product_option_id'    => $product_option['product_option_id'],
				'option_id'            => $product_option['option_id'],
				'name'                 => $product_option['name'],
				'type'                 => $product_option['type'],			
				'product_option_value' => $product_option_value_data,
				'option_value'         => $product_option['option_value'],
				'required'             => $product_option['required']				
			);
		}
		
		return $product_option_data;
	}
			


                public function getProductOptionCombos($product_id) {

                    $product_option_combo_data = array();



            		$product_option_combo_query = $this->db->query("SELECT *,cgd.name AS customer_group FROM " . DB_PREFIX . "product_option_combination poc LEFT JOIN " . DB_PREFIX . "customer_group_description cgd ON poc.customer_group_id = cgd.customer_group_id WHERE cgd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND poc.product_id = '" . (int)$product_id . "' ORDER BY poc.sort_order, poc.product_option_combination_id");



            		foreach ($product_option_combo_query->rows as $product_option_combo) {



                        $product_option_combo_value_query = $this->db->query("SELECT *,ovd.name AS ov_name,od.name AS od_name FROM " . DB_PREFIX . "product_option_combination_value pocv LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON pocv.option_value_id = ovd.option_value_id LEFT JOIN " . DB_PREFIX . "option_description od ON ovd.option_id = od.option_id WHERE pocv.product_option_combination_id = '" . (int)$product_option_combo['product_option_combination_id'] . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "'");



                        $product_option_combo_data[] = array(

    						'product_option_combination_id'   => $product_option_combo['product_option_combination_id'],

    						'product_id'                      => $product_option_combo['product_id'],

    						'option_values'                   => $product_option_combo_value_query->rows,

    						'stock'                           => $product_option_combo['stock'],

    						'subtract'                        => $product_option_combo['subtract'],

    						'quantity'                        => $product_option_combo['quantity'],

    						'price'                           => $product_option_combo['price'],

    						'price_prefix'                    => $product_option_combo['price_prefix'],

    						'points'                          => $product_option_combo['points'],

    						'points_prefix'                   => $product_option_combo['points_prefix'],

    						'weight'                          => $product_option_combo['weight'],

    						'weight_prefix'                   => $product_option_combo['weight_prefix'],

    						'sort_order'                      => $product_option_combo['sort_order'],

    						'customer_group_id'               => $product_option_combo['customer_group_id'],

    						'customer_group'                  => $product_option_combo['customer_group'],

    						'date_start'                      => $product_option_combo['date_start'],

    						'date_end'                        => $product_option_combo['date_end'],

    					);

                    }



            		return $product_option_combo_data;

                }



                public function getProductOptionComboSetting($product_id) {

                    $product_option_combo_setting_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_combination_setting pocs WHERE pocs.product_id = '" . (int)$product_id . "'");



                    return $product_option_combo_setting_query->row;

                }



                public function getProductOptionComboDescription($product_id) {

                    $product_option_combo_description_data = array();



                    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_combination_description WHERE product_id = '" . (int)$product_id . "'");



                    if($query->num_rows > 0) {

                		foreach ($query->rows as $result) {

                			$product_option_combo_description_data[$result['language_id']] = array(

                				'description'      => $result['description'],

                			);

                		}

            		}



            		return $product_option_combo_description_data;

                }

            
	public function getProductImages($product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$product_id . "'");
		
		return $query->rows;
	}
	
	public function getProductDiscounts($product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product_id . "' ORDER BY quantity, priority, price");
		
		return $query->rows;
	}
	
	public function getProductSpecials($product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "' ORDER BY priority, price");
		
		return $query->rows;
	}
	
	public function getProductRewards($product_id) {
		$product_reward_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_reward WHERE product_id = '" . (int)$product_id . "'");
		
		foreach ($query->rows as $result) {
			$product_reward_data[$result['customer_group_id']] = array('points' => $result['points']);
		}
		
		return $product_reward_data;
	}
		
	public function getProductDownloads($product_id) {
		$product_download_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_download WHERE product_id = '" . (int)$product_id . "'");
		
		foreach ($query->rows as $result) {
			$product_download_data[] = $result['download_id'];
		}
		
		return $product_download_data;
	}

	public function getProductStores($product_id) {
		$product_store_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_store WHERE product_id = '" . (int)$product_id . "'");

		foreach ($query->rows as $result) {
			$product_store_data[] = $result['store_id'];
		}
		
		return $product_store_data;
	}

	public function getProductLayouts($product_id) {
		$product_layout_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_layout WHERE product_id = '" . (int)$product_id . "'");
		
		foreach ($query->rows as $result) {
			$product_layout_data[$result['store_id']] = $result['layout_id'];
		}
		
		return $product_layout_data;
	}

	public function getProductRelated($product_id) {
		$product_related_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$product_id . "'");
		
		foreach ($query->rows as $result) {
			$product_related_data[] = $result['related_id'];
		}
		
		return $product_related_data;
	}

	public function getProductComplementary($product_id) {
		$product_complementary_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_complementary WHERE product_id = '" . (int)$product_id . "'");

		foreach ($query->rows as $result) {
			$product_complementary_data[] = $result['complementary_id'];
		}

		return $product_complementary_data;
	}

	public function getProfiles($product_id) {
		return $this->db->query("SELECT * FROM `" . DB_PREFIX . "product_profile` WHERE product_id = " . (int) $product_id)->rows;
	}

	public function getTotalProducts($data = array()) {
		$sql = "SELECT COUNT(DISTINCT p.product_id) AS total FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id)";

		if (!empty($data['filter_category_id'])) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id)";			
		}
		 
		$sql .= " WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		 			

			if (!empty($data['filter_manufacturer'])) {
				$sql .= " AND p.manufacturer_id = '" . (int)$data['filter_manufacturer'] . "'";
			}
            if (!empty($data['filter_category_id'])) {
				$sql .= " AND p2c.category_id = '" . (int)$data['filter_category_id'] . "'";
			}
            if (!empty($data['filter_upc'])) {
				$sql .= " AND p.upc = '" . $data['filter_upc'] . "'";
			}
            
		if (!empty($data['filter_name'])) {
			$sql .= " AND pd.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}


		        if (!empty($data['filter_upc'])) {
			        $sql .= " AND LCASE(p.upc) LIKE '" . $this->db->escape(utf8_strtolower($data['filter_upc'])) . "%'";
		        }
              
		if (!empty($data['filter_model'])) {
			$sql .= " AND p.model LIKE '" . $this->db->escape($data['filter_model']) . "%'";
		}
		
		if (!empty($data['filter_price'])) {
			$sql .= " AND p.price LIKE '" . $this->db->escape($data['filter_price']) . "%'";
		}
		
		if (isset($data['filter_quantity']) && !is_null($data['filter_quantity'])) {
			$sql .= " AND p.quantity = '" . $this->db->escape($data['filter_quantity']) . "'";
		}
		
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
		}
		
		$query = $this->db->query($sql);
		
		return $query->row['total'];
	}	
	
	public function getTotalProductsByTaxClassId($tax_class_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE tax_class_id = '" . (int)$tax_class_id . "'");

		return $query->row['total'];
	}
		
	public function getTotalProductsByStockStatusId($stock_status_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE stock_status_id = '" . (int)$stock_status_id . "'");

		return $query->row['total'];
	}
	
	public function getTotalProductsByWeightClassId($weight_class_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE weight_class_id = '" . (int)$weight_class_id . "'");

		return $query->row['total'];
	}
	
	public function getTotalProductsByLengthClassId($length_class_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE length_class_id = '" . (int)$length_class_id . "'");

		return $query->row['total'];
	}

	public function getTotalProductsByDownloadId($download_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product_to_download WHERE download_id = '" . (int)$download_id . "'");
		
		return $query->row['total'];
	}
	
	public function getTotalProductsByManufacturerId($manufacturer_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE manufacturer_id = '" . (int) $manufacturer_id . "'");

		return $query->row['total'];
	}
	
	public function getTotalProductsByAttributeId($attribute_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product_attribute WHERE attribute_id = '" . (int)$attribute_id . "'");

		return $query->row['total'];
	}	
	
	public function getTotalProductsByOptionId($option_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product_option WHERE option_id = '" . (int)$option_id . "'");

		return $query->row['total'];
	}	
	
	public function getTotalProductsByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product_to_layout WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->row['total'];
	}



	public function mappingAxCode( $product_id )
	{
		$mapping_ax_code = array();

		$prQuery = $this->db->query( "SELECT pr.product_id, pr_desc.name, pr.upc FROM oc_product pr
                                      JOIN oc_product_description pr_desc ON (pr_desc.product_id = pr.product_id ) WHERE pr.product_id='".$product_id."'" );   //335   , WHERE pr.product_id=102;

		if( $prQuery->num_rows > 0 )
		{
			// get option names and value names
			/*foreach( $prQuery->rows as $product )
			{*/

				// initializing array
				$mapping_ax_code = array(
					"product_id" => $product_id,
					"product_upc" => $prQuery->row['upc'],
					"Marimi" => array( ),
					"Culori" => array( ),
					"Configuratie" => array( ),
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
						$mapping_ax_code[$value["o_name"]][$value["ov_id"]] = $value["ov_name"];
					}

					// setting up type to 2
					$mapping_ax_code["type"] = 2;
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
						$mapping_ax_code["Combinatii"][$val["product_option_combination_id"]][$val["o_name"]] = $val["ov_name"];
					}

					// setting up type to 3
					$mapping_ax_code["type"] = 3;
				}


				if( $mapping_ax_code["type"] == 1 )//simple product
				{
					// get ax codes
					$concatenated_code = $this->getProductAxCode( $mapping_ax_code["type"], $mapping_ax_code['product_id'] );

					$mapping_ax_code[ "Marimi" ] = array();
					$mapping_ax_code[ "Culori" ] = array();
					$mapping_ax_code[ "Configuratie" ] = array();
					$mapping_ax_code[ "code_ax" ] = $concatenated_code;

				}
				else if( $mapping_ax_code["type"] == 2 )
				{
					if (  !empty( $mapping_ax_code["Marimi"] ) )
					{
						foreach( $mapping_ax_code["Marimi"] as $key => $value )
						{
							// get ax codes
							$concatenated_code = $this->getProductAxCode( $mapping_ax_code["type"], $mapping_ax_code['product_id'], '',  $key);

							$mapping_ax_code[ "code_ax" ][$key] = $concatenated_code;
						}

						if( $_SERVER['REMOTE_ADDR'] == '188.26.23.46' )
						{
							//print_r( $mapping_ax_code );
							//die();
						}
					}

					if (  !empty( $mapping_ax_code["Culori"] ) )
					{
						foreach( $mapping_ax_code["Culori"] as $key => $value )
						{
							//print "key=".$key."<br>";
							//print "value=".$value."<br><br>";
							// get ax codes
							$concatenated_code = $this->getProductAxCode( $mapping_ax_code["type"], $mapping_ax_code['product_id'], '', $key);//$CSVRow["OptionsForAxCode"][$key]

							//$mapping_ax_code[$key]["Culori" ] = $value;
							//$mapping_ax_code[$key][ "Marimi" ] = array();
							//$mapping_ax_code[$key][ "Configuratie" ] = array();
							$mapping_ax_code[ "code_ax" ][$key] = $concatenated_code;
						}

						if( $_SERVER['REMOTE_ADDR'] == '188.26.23.46' )
						{
							//print_r( $mapping_ax_code );
							//die();
						}
					}

					if (  !empty( $mapping_ax_code["Configuratie"] ) )
					{
						foreach( $mapping_ax_code["Configuratie"] as $key => $value )
						{
							// get ax codes
							$concatenated_code = $this->getProductAxCode( $mapping_ax_code["type"], $mapping_ax_code['product_id'], '', $key );//$CSVRow["OptionsForAxCode"][$key]

							//$mapping_ax_code[ "Culori" ] = array();
							////$mapping_ax_code[ "Marimi" ] = array();
							//$mapping_ax_code[ "Configuratie" ] = $value;
							$mapping_ax_code[ "code_ax" ][$key] = $concatenated_code;
						}
						if( $_SERVER['REMOTE_ADDR'] == '188.26.23.46' )
						{
							//print_r( $mapping_ax_code );
							//die();
						}
					}
				}
				else if( $mapping_ax_code["type"] == 3 )
				{
					foreach( $mapping_ax_code["Combinatii"] as $key => $value )
					{
						// get ax codes
						$concatenated_code = $this->getProductAxCode( $mapping_ax_code["type"], $mapping_ax_code['product_id'], '', $key );

						//$mapping_ax_code[ "Culori" ] = $value['Culori'];
						//$mapping_ax_code[ "Marimi" ] = $value['Marimi'];
						//$mapping_ax_code[ "Configuratie" ] = $value;
						$mapping_ax_code[ "code_ax" ][$key] = $concatenated_code;



					}
					if( $_SERVER['REMOTE_ADDR'] == '188.26.23.46' )
					{
						//print_r( $mapping_ax_code );
						//die();
					}
				}
		}// end if*/

		return $mapping_ax_code;
	}


	public function getProductAxCode( $type, $product_id, $option_data = array( ), $Id = 0 )
	{
		//$sizeof_option = sizeof( $option_data );
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
