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
        $this->data['upload_form_button'] = $this->language->get('upload_form_button');
        $this->data['first_upload_form_button'] = $this->language->get('first_upload_form_button');
        $this->data['add_form_button'] = $this->language->get('add_form_button');

        $this->load->model('account/customer');
        $customer_additional_groups = $this->model_account_customer->getCustomerGroups();

        $customer_all_groups = array_merge(array_flip($customer_additional_groups), array($this->customer->getCustomerGroupId()));
        $allowed_groups = $this->config->get('config_customer_group_access') ? $this->config->get('config_customer_group_access') : array();
        if (!(bool)array_intersect($customer_all_groups, $allowed_groups)) {
            $this->redirect($this->url->link('account/account', '', 'SSL'));
        }

        $this->load->model('account/special_products_request');

        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
            $this->model_account_special_products_request->addSpecialProductsFrom($this->request->post);
            $subject = $this->language->get('mail_subject_special_products');
            $message = $this->language->get('mail_message_special_products');
            $mail = new Mail();
                $mail->protocol = $this->config->get('config_mail_protocol');
                $mail->parameter = $this->config->get('config_mail_parameter');
                $mail->hostname = $this->config->get('config_smtp_host');
                $mail->username = $this->config->get('config_smtp_username');
                $mail->password = $this->config->get('config_smtp_password');
                $mail->port = $this->config->get('config_smtp_port');
                $mail->timeout = $this->config->get('config_smtp_timeout');
                $mail->setTo('claudia.grec@renania.ro');
                $mail->setFrom($this->config->get('config_email'));
                $mail->setSender($this->config->get('config_name'));
                $mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
                $mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
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