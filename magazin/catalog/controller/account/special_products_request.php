<?php

class ControllerAccountSpecialProductsRequest extends Controller
{
    public function specialProductsRequest()
    {
        
        if(!$this->customer->isLogged())
        {
            $this->session->data['redirect'] = $this->url->link('account/special_products_request/specialproductsrequest', '', 'SSL');
            $this->redirect( $this->url->link('account/login', '', 'SSL'));
        }
        $this->language->load('account/special_products_request');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->data['breadcrumbs'] = array( );

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home'),
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_account'),
            'href' => $this->url->link('account/account', '', 'SSL'),
            'separator' => $this->language->get('text_separator')
        );

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_upload_report'),
            'href' => $this->url->link('account/special_products_request/specialproductsrequest', '', 'SSL'),
            'separator' => $this->language->get('text_separator')
        );

        $this->data['heading_title'] = $this->language->get('special_products_request_heading_title');
        $this->data['text_product_description'] = $this->language->get('text_product_description');
        $this->data['text_next_months_quantity'] = $this->language->get('text_next_months_quantity');
        $this->data['text_quantity'] = $this->language->get('text_quantity');
        $this->data['text_unit'] = $this->language->get('text_unit');
        $this->data['text_initial_order_quantity'] = $this->language->get('text_initial_order_quantity');
        $this->data['text_order_total_value'] = $this->language->get('text_order_total_value');
        $this->data['text_ron'] = $this->language->get('text_ron');
        $this->data['text_target_price'] = $this->language->get('text_target_price');
        $this->data['text_sales_arguments'] = $this->language->get('text_sales_arguments');
        $this->data['text_regional_manager_approval'] = $this->language->get('text_regional_manager_approval');
        $this->data['text_yes'] = $this->language->get('text_yes');
        $this->data['text_no'] = $this->language->get('text_no');
        $this->data['text_order_date_estimation'] = $this->language->get('text_order_date_estimation');
        $this->data['text_first_batch'] = $this->language->get('text_first_batch');
        $this->data['text_second_batch'] = $this->language->get('text_second_batch');
        $this->data['text_third_batch'] = $this->language->get('text_third_batch');
        $this->data['text_fourth_batch'] = $this->language->get('text_fourth_batch');
        $this->data['text_fifth_batch'] = $this->language->get('text_fifth_batch');
        $this->data['text_sixth_batch'] = $this->language->get('text_sixth_batch');
        $this->data['text_existent_alternative_products'] = $this->language->get('text_existent_alternative_products');
        $this->data['text_alternative_products'] = $this->language->get('text_alternative_products');
        $this->data['text_customer_feedback'] = $this->language->get('text_customer_feedback');
        $this->data['text_new_provider'] = $this->language->get('text_new_provider');
        $this->data['text_provider_name'] = $this->language->get('text_provider_name');
        $this->data['text_identified_circumstances'] = $this->language->get('text_identified_circumstances');
        $this->data['text_other_informations'] = $this->language->get('text_other_informations');
        $this->data['text_product_category'] = $this->language->get('text_product_category');
        $this->data['text_select_category'] = $this->language->get('text_select_category');
        $this->data['text_special_product_image'] = $this->language->get('text_special_product_image');
        $this->data['upload_form_button'] = $this->language->get('upload_form_button');
        $this->data['first_upload_form_button'] = $this->language->get('first_upload_form_button');
        $this->data['add_form_button'] = $this->language->get('add_form_button');
        $this->data['error_manager_approval'] = $this->language->get('error_manager_approval');

        $this->load->model('catalog/category');
        $product_categories = $this->model_catalog_category->getCategories();

        $this->data['product_categories'] = array();
        foreach ($product_categories as $product_category) {
            if ($product_category['top']) {
                $this->data['product_categories'][] = array(
                    'category_id' => $product_category['category_id'],
                    'name'        => $product_category['name']
                );
            }
        }

        $this->load->model('account/customer');
        $customer_additional_groups = $this->model_account_customer->getCustomerGroups();

        $customer_all_groups = array_merge(array_flip($customer_additional_groups), array($this->customer->getCustomerGroupId()));
        $allowed_groups = $this->config->get('config_customer_group_access') ? $this->config->get('config_customer_group_access') : array();
        if (!(bool)array_intersect($customer_all_groups, $allowed_groups)) {
            $this->redirect($this->url->link('account/account', '', 'SSL'));
        }

        $this->load->model('account/special_products_request');

        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
            $allowedExts = array("jpeg", "jpg", "png");
            $temp = explode( ".", $this->request->files['image']['name']);
            $extension = end( $temp );
            if ($this->request->files['image']['name'] != '' && in_array($extension, $allowedExts)) {
                $name = basename($this->request->files["image"]["name"]);
                $image = $this->request->files['image']['name'];
                move_uploaded_file($this->request->files['image']['tmp_name'], "image/specialProduct/$name");
                $attachment = "image/specialProduct/$name";
            } else {
                $image = '';
            }
            $this->model_account_special_products_request->addSpecialProductsForm($this->request->post, $image);
            $subject = $this->language->get('mail_subject_special_products');
            $message = $this->language->get('mail_message_special_products') . " " . $this->customer->getFirstName() . " " . $this->customer->getLastName();
            $message .= $this->language->get('text_mail_address') . " " . $this->customer->getEmail() . "\n\n";

            $special_product_form_entries = $this->model_account_special_products_request->getSpecialProductsForm($this->customer->getId());
            foreach ($special_product_form_entries as $special_product_form_entrie) {
                $message .= $this->language->get('text_product_description') . "\n\t" . $special_product_form_entrie['product_description'] . "\n";
                $message .= $this->language->get('text_next_months_quantity') . "\n\t" . $this->language->get('text_quantity') . " " . $special_product_form_entrie['quantity'] . "\n\t" .
                            $this->language->get('text_unit') . " " . $special_product_form_entrie['unit'] . "\n";
                $message .= $this->language->get('text_initial_order_quantity') . "\n\t" . $this->language->get('text_quantity') . " " . $special_product_form_entrie['initial_quantity'] . "\n\t" .
                            $this->language->get('text_unit') . " " . $special_product_form_entrie['initial_unit'] . "\n";
                $message .= $this->language->get('text_order_total_value') . " " . $special_product_form_entrie['total_value'] . " " . $this->language->get('text_ron') . "\n";
                $message .= $this->language->get('text_target_price') . " " . $special_product_form_entrie['target_price'] . " " . $this->language->get('text_ron') . "\n\t" .
                            $this->language->get('text_unit') . " " . $special_product_form_entrie['target_unit'] . "\n";
                $message .= $this->language->get('text_product_category') . "\n\t" . $special_product_form_entrie['product_category'] . "\n";
                $message .= $this->language->get('text_sales_arguments') . "\n\t" . $special_product_form_entrie['sales_arguments'] . "\n";
                $message .= $this->language->get('text_regional_manager_approval') . " ";
                if ($special_product_form_entrie['manager_approval'] == 1) {
                    $message .= $this->language->get('text_yes') . "\n";
                } else {
                    $message .= $this->language->get('text_no') . "\n";
                }
                $message .= $this->language->get('text_order_date_estimation') . "\n\t";
                $message .= $this->language->get('text_first_batch') . " ";
                strtotime($special_product_form_entrie['first_batch']) > 0 ? $message .= $special_product_form_entrie['first_batch'] . "\n\t" : $message .= " " . "\n\t";
                $message .= $this->language->get('text_second_batch') . " ";
                strtotime($special_product_form_entrie['second_batch']) > 0 ? $message .= $special_product_form_entrie['second_batch'] . "\n\t" : $message .= " " . "\n\t";
                $message .= $this->language->get('text_third_batch') . " ";
                strtotime($special_product_form_entrie['third_batch']) > 0 ? $message .= $special_product_form_entrie['third_batch'] . "\n\t" : $message .= " " . "\n\t";
                $message .= $this->language->get('text_fourth_batch') . " ";
                strtotime($special_product_form_entrie['fourth_batch']) > 0 ? $message .= $special_product_form_entrie['fourth_batch'] . "\n\t" : $message .= " " . "\n\t";
                $message .= $this->language->get('text_fifth_batch') . " ";
                strtotime($special_product_form_entrie['fifth_batch']) > 0 ? $message .= $special_product_form_entrie['fifth_batch'] . "\n\t" : $message .= " " . "\n\t";
                $message .= $this->language->get('text_sixth_batch') . " ";
                strtotime($special_product_form_entrie['sixth_batch']) > 0 ? $message .= $special_product_form_entrie['sixth_batch'] . "\n" : $message .= " " . "\n";
                $message .= $this->language->get('text_existent_alternative_products') . "\n\t" . $this->language->get('text_alternative_products') . "\n\t\t" . $special_product_form_entrie['alternative_products'] . "\n\t" .
                            $this->language->get('text_customer_feedback') . "\n\t\t" . $special_product_form_entrie['customer_feedback'] . "\n";
                $message .= $this->language->get('text_new_provider') . "\n\t" . $this->language->get('text_provider_name') . " " . $special_product_form_entrie['provider_name'] . "\n\t" .
                            $this->language->get('text_identified_circumstances') . "\n\t\t" . $special_product_form_entrie['identified_circumstances'] . "\n";
                $message .= $this->language->get('text_other_informations') . "\n\t" . $special_product_form_entrie['other_informations'] . "\n";
            }

            $mail = new Mail();
                $mail->protocol = $this->config->get('config_mail_protocol');
                $mail->parameter = $this->config->get('config_mail_parameter');
                $mail->hostname = $this->config->get('config_smtp_host');
                $mail->username = $this->config->get('config_smtp_username');
                $mail->password = $this->config->get('config_smtp_password');
                $mail->port = $this->config->get('config_smtp_port');
                $mail->timeout = $this->config->get('config_smtp_timeout');
				if($special_product_form_entrie['product_category'] == 'INCALTAMINTE'){
					$mail->setTo('incaltaminte@renania.ro');
				}else if($special_product_form_entrie['product_category'] == 'IMBRACAMINTE'){
					$mail->setTo('imbracaminte@renania.ro');
				}else if($special_product_form_entrie['product_category'] == 'CASTI DE PROTECTIE'){
					$mail->setTo('protectia.capului@renania.ro');
				}else if($special_product_form_entrie['product_category'] == 'PROTECTIE VIZUALA'){
					$mail->setTo('protectia.capului@renania.ro');
				}else if($special_product_form_entrie['product_category'] == 'PROTECTIE AUDITIVA'){
					$mail->setTo('protectia.capului@renania.ro');
				}else if($special_product_form_entrie['product_category'] == 'PROTECTIE RESPIRATORIE'){
					$mail->setTo('protectia.capului@renania.ro');
				}else if($special_product_form_entrie['product_category'] == 'LUCRU LA INALTIME'){
					$mail->setTo('lucru.inaltime@renania.ro');
				}else if($special_product_form_entrie['product_category'] == 'ARTICOLE TEHNICE'){
					$mail->setTo('tehnice.curatenie@renania.ro');
				}else if($special_product_form_entrie['product_category'] == 'CURATENIE SI IGIENA'){
					$mail->setTo('tehnice.curatenie@renania.ro');
				}else{
					$mail->setTo('claudia.grec@renania.ro');
				}
               
                $mail->setFrom($this->config->get('config_email'));
                $mail->setSender($this->config->get('config_name'));
                $mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
                $mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
                $mail->AddAttachment($attachment);
                $mail->send();
            $this->redirect($this->url->link('account/account', '', 'SSL'));
        }

        $this->data['add_form'] = $this->url->link('account/special_products_request/specialproductsrequest', '', 'SSL');

        if( file_exists( DIR_TEMPLATE.$this->config->get('config_template').'/template/account/special_products_request_form.tpl'))
        {
            $this->template = $this->config->get('config_template').'/template/account/special_products_request_form.tpl';
        }
        else
        {
            $this->template = 'default/template/account/special_products_request_form.tpl';
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