<?php
class ControllerCheckoutFileOrder extends Controller {
    public function index() {
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('checkout/file_order', '', 'SSL');

            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }       
        $this->data['input_products'] = array();
        $this->data['invalid_model'] = array();
        $this->data['invalid_color'] = array();
        $this->data['invalid_size'] = array();
        if (isset($this->request->files['file'])) {
            $products = array();
            if (($fhandler = fopen($this->request->files['file']['tmp_name'], 'r')) !== FALSE) {
                while (($row = fgetcsv($fhandler, 1000, ',')) !== FALSE) {
                    $products[] = array_combine(array('model', 'color', 'size', 'config', 'quantity'), array_map(function($item) { return trim($item);}, $row));
                }
                fclose($fhandler);
            }
            array_shift($products);
            $this->data['input_products'] = $products;
            $invalid_model = array();
            $invalid_color = array();
            $invalid_size = array();
            $counter = 0;
            $product_to_cart = array();
            foreach ($products as $product) {
                $input_valid_item = true;
                $order_options = array();
                $product_id = $this->model_catalog_product->modelToId($product['model']);
                if (!$product_id) {
                    $invalid_model[] = $counter;
                    $counter++;
                    continue;
                }
                $product_options = $this->model_catalog_product->getProductOptions($product_id);
                $product_options_assotiative_array = array();
                foreach ($product_options as $option) {
                    $product_options_assotiative_array[$option['name']] = $option;
                    $option_values = array();
                    foreach ($option['option_value'] as $opval) {
                        $option_values[$opval['name']] = $opval;
                    }
                    $product_options_assotiative_array[$option['name']]['option_value'] = $option_values;
                }
                if (isset($product_options_assotiative_array['Culori'])) {
                    if ($product_options_assotiative_array['Culori']['required'] && !$product['color']) {
                        $invalid_color[] = $counter;
                    }
                    if ($product['color'] && isset($product_options_assotiative_array['Culori']['option_value'][$product['color']])) {
                        $order_options['option'][$product_options_assotiative_array['Culori']['product_option_id']] = $product_options_assotiative_array['Culori']['option_value'][$product['color']]['product_option_value_id'];
                    } else {
                        $invalid_color[] = $counter;
                        $input_valid_item = false;
                    }
                }
                if (isset($product_options_assotiative_array['Marimi'])) {
                    if ($product_options_assotiative_array['Marimi']['required'] && !$product['size']) {
                        $invalid_size[] = $counter;
                    }
                    if ($product['size'] && isset($product_options_assotiative_array['Marimi']['option_value'][$product['size']])) {
                        $order_options['option'][$product_options_assotiative_array['Marimi']['product_option_id']] = $product_options_assotiative_array['Marimi']['option_value'][$product['size']]['product_option_value_id'];
                    } else {
                        $invalid_size[] = $counter;
                        $input_valid_item = false;
                    }
                }
                if ($input_valid_item) {
                    $product_to_cart[] = array(
                        'product_id'    =>  $product_id,
                        'quantity'      =>  $product['quantity'],
                        'order_options' =>  $order_options,
                        'config'        =>  $product['config']
                    );
                    $counter++;
                }
            }
            if (sizeof($product_to_cart) == sizeof($products)) {
                foreach ($product_to_cart as $prod) {
                    $this->cart->add($prod['product_id'], $prod['quantity'], $prod['order_options'], $prod['config']);
                }
            }
            if (!$invalid_model && !$invalid_color && !$invalid_size) {
                $this->redirect($this->url->link('checkout/cart', '', 'SSL'));
            }
            $this->data['invalid_model'] = $invalid_model;
            $this->data['invalid_color'] = $invalid_color;
            $this->data['invalid_size'] = $invalid_size;

            $this->load->model('catalog/product');
        }

        $this->language->load('checkout/file_order');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
        'text'      => $this->language->get('text_home'),
        'href'      => $this->url->link('common/home'),
        'separator' => false
        ); 

        $this->data['breadcrumbs'][] = array(           
        'text'      => $this->language->get('text_account'),
        'href'      => $this->url->link('account/account', '', 'SSL'),
        'separator' => $this->language->get('text_separator')
        );

        $this->data['breadcrumbs'][] = array(           
        'text'      => $this->language->get('text_file_order'),
        'href'      => $this->url->link('checkout/file_order', '', 'SSL'),
        'separator' => $this->language->get('text_separator')
        );

        $this->data['heading_title'] = $this->language->get('heading_title');
        $this->data['text_file_download'] = $this->language->get('text_file_download');
        $this->data['file_download_button'] = $this->language->get('file_download_button');
        $this->data['text_file_upload'] = $this->language->get('text_file_upload');
        $this->data['upload_order_button'] = $this->language->get('upload_order_button');
        $this->data['text_model'] = $this->language->get('text_model');
        $this->data['text_color'] = $this->language->get('text_color');
        $this->data['text_size'] = $this->language->get('text_size');
        $this->data['text_config'] = $this->language->get('text_config');
        $this->data['text_quantity'] = $this->language->get('text_quantity');
        $this->data['text_model_error'] = $this->language->get('text_model_error');
        $this->data['text_color_error'] = $this->language->get('text_color_error');
        $this->data['text_size_error'] = $this->language->get('text_size_error');

        $this->data['file_order'] = $this->url->link('checkout/file_order', '', 'SSL');

        $this->data['order_model_download_link'] = 'download/Template_plasare_comanda.csv';

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/file_order.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/checkout/file_order.tpl';
        } else {
            $this->template = 'default/template/checkout/file_order.tpl';
        }

        $this->children = array(
        'common/column_left',
        'common/column_right',
        'common/content_top',
        'common/content_bottom',
        'common/footer',
        'common/header' 
        );

        $this->response->setOutput($this->render());        
    }       
}
?>