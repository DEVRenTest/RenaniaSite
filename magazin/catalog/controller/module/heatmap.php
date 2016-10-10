<?php
class ControllerModuleHeatMap extends Controller {
	protected function index($setting) {
		$this->language->load('module/heatmap');
		
      	$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['button_cart'] = $this->language->get('button_cart');
				
		$this->load->model('catalog/product');
		
		$this->load->model('tool/image');
		
		$this->data['products'] = array();
		
		$data = array(
			'sort'  => 'p.date_added',
			'order' => 'DESC',
			'start' => 0,
			'limit' => $setting['limit']
		);

		$results = $this->model_catalog_product->getProducts($data);

		foreach ($results as $result) {
			if ($result['image']) {
				$image = $this->model_tool_image->resize($result['image'], $setting['image_width'], $setting['image_height']);
			} else {
				$image = false;
			}
						
			if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
				$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
			} else {
				$price = false;
			}
					
			if ((float)$result['special']) {
				$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
			} else {
				$special = false;
			}
			
			if ($this->config->get('config_review_status')) {
				$rating = $result['rating'];
			} else {
				$rating = false;
			}
			
			$this->data['products'][] = array(
				'product_id' => $result['product_id'],
				'thumb'   	 => $image,
				'name'    	 => $result['name'],
				'price'   	 => $price,
				'special' 	 => $special,
				'rating'     => $rating,
				'reviews'    => sprintf($this->language->get('text_reviews'), (int)$result['reviews']),
				'href'    	 => $this->url->link('product/product', 'product_id=' . $result['product_id']),
			);
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/heatmap.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/heatmap.tpl';
		} else {
			$this->template = 'default/template/module/heatmap.tpl';
		}

		$this->render();
	}
	
    public function display_statistics() {
        $this->load->language('module/heatmap');
        $sql_query = "SELECT count(*) AS last_hour FROM `" . DB_PREFIX . "heatmap` WHERE (`inserted_time` > NOW() - INTERVAL 1 HOUR) AND from_page='".$_GET['l']."'";
        $result = $this->db->query($sql_query);
        $last_hour = 0;
        if (list($key,$record) = each($result->rows) ) {
            $last_hour = $record['last_hour'];
        } 
        # $sql_query = "SELECT count(*) AS last_day FROM `" . DB_PREFIX . "heatmap` WHERE (`inserted_time` > NOW() - INTERVAL 24 HOUR) AND from_page='".$_GET['l']."'";
        $sql_query = "SELECT count(*) AS last_day FROM `" . DB_PREFIX . "heatmap` WHERE (`inserted_time` > CURRENT_DATE()) AND from_page='".$_GET['l']."'";
        
        $result = $this->db->query($sql_query);
        $last_day = 0;
        if (list($key,$record) = each($result->rows) ) {
            $last_day = $record['last_day'];
        } 
        $sql_query = "SELECT count(*) AS total_click FROM `" . DB_PREFIX . "heatmap` WHERE from_page='".$_GET['l']."'";
        $result = $this->db->query($sql_query);
        $total_click = 0;
        if (list($key,$record) = each($result->rows) ) {
            $total_click = $record['total_click'];
        } 
        //total_nr_clicks
        $html = $this->language->get('last_hour_nr_clicks')." ".$last_hour."\n".$this->language->get('last_day_nr_clicks')." ".$last_day."\n".$this->language->get('total_nr_clicks')." ".$total_click;
        print $html; 
    }
    
	public function display_clicks() {
		// Your code
		# var_dump($_GET);
        $sql_query = "SELECT * FROM `" . DB_PREFIX . "heatmap`  WHERE from_page='".$_GET['l']."'";
        $result = $this->db->query($sql_query);
        $html = '<div id="clickmap-container">'; 
        while (list($key,$record) = each($result->rows) ) {
            list($width_orig,$height_orig) = explode("x",$record['resolution']);
            if ( $_GET['width'] == $width_orig && $_GET['height'] == $height_orig ) {
                $html .= sprintf('<div style="z-index: 9999;left:%spx;top:%spx"></div>', $record['coord_x'] - 10, $record['coord_y'] - 10); 
                # print "MATCH!\n";
            } else {
                # print "NOT MATCH!\n";
                $coord_x = ($_GET['width']*$record['percent_x'])/100;
                $coord_y = ($_GET['height']*$record['percent_y'])/100;
                $html .= sprintf('<div style="z-index: 9999;left:%spx;top:%spx"></div>', $coord_x - 10, $coord_y - 10); 
            }
        } 
        $html .= '</div>'; 
        print $html; 
    }	

	public function click_register() {
		// Your code
		# var_dump($_POST);
        $percent_x = 0;
        if ( !preg_match("/^0$/",$_POST['width']) ) {
            $percent_x = ($_POST['x']*100)/$_POST['width'];
            $percent_x = round($percent_x);
        }
        $percent_y = 0;
        if ( !preg_match("/^0$/",$_POST['height']) ) {
            $percent_y = ($_POST['y']*100)/$_POST['height'];
            $percent_y = round($percent_y);
        }
		# $result = $this->db->query("INSERT INTO `" . DB_PREFIX . "heatmap` SET coord_x='".$_POST['x']."',coord_y='".$_POST['y']."',from_page='".$_POST['l']."'");
        # $sql_query = "INSERT INTO `" . DB_PREFIX . "heatmap` SET coord_x='".$_POST['x']."',coord_y='".$_POST['y']."',precent_x='".$percent_x."',precent_y='".$percent_y."',resolution='".$_POST['width']."x".$_POST['height']."',from_page='".$_POST['l']."'";
		# print $sql_query."\n";
        $result = $this->db->query("INSERT INTO `" . DB_PREFIX . "heatmap` SET coord_x='".$_POST['x']."',coord_y='".$_POST['y']."',percent_x='".$percent_x."',percent_y='".$percent_y."',resolution='".$_POST['width']."x".$_POST['height']."',from_page='".$_POST['l']."'");
		# var_dump($result);
	}	
}
?>