<?php

class ControllerReportReport extends Controller
{
    public function upload_Report()
    {        
        if( !$this->customer->isLogged() )
        {
            $this->session->data['redirect'] = $this->url->link( 'report/report/upload_report', '', 'SSL' );
            $this->redirect( $this->url->link( 'account/login', '', 'SSL' ) );
        }
        $this->data['invalid_report'] = array();
        if (isset($this->request->files['file']) && in_array($this->request->files['file']['type'], array('text/csv', 'application/vnd.ms-excel')) && isset($this->request->post['report_name'])) {
            $this->load->model('report/report');
            $report_entries = array();
            if (($fhandler = fopen($this->request->files['file']['tmp_name'], 'r')) !== FALSE) {
                while (($row = fgetcsv($fhandler, 1000, ',')) !== FALSE) {
                    $report_entries[] = array_combine(array('customer_name', 'work_address', 'CUI', 'product_code', 'product_name', 'buy_price', 'net_sale_price', 'product_quantity', 'sale_agent_name', 'month'), array_map(function($item) { return trim($item);}, $row));    
                }
                fclose($fhandler);
            }
            array_shift($report_entries);
            $invalid_report = array();
            $counter = 0;
            $input_valid_item = true;
            foreach ($report_entries as $key => $report_entry ) {
                if (!$report_entry['customer_name'] || !$report_entry['work_address'] || !$report_entry['CUI'] || !$report_entry['product_code'] || !$report_entry['product_name'] || !$report_entry['product_quantity'] || !$report_entry['sale_agent_name'] || !$report_entry['month']) {
                    $invalid_report[] = $counter;
                    $input_valid_item = false;
                }
                $counter++;
            }
            if ($input_valid_item) {
                $report_id = $this->model_report_report->addReport($this->request->post['report_name']);
                $this->model_report_report->addReportEntries($report_entries, $report_id);

                $this->redirect($this->url->link('report/report/list_reports', '', 'SSL'));
            }
            $this->data['invalid_report'] = $invalid_report;
        }
        $this->language->load('report/report');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->data['breadcrumbs'] = array( );

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get( 'text_home' ),
            'href' => $this->url->link( 'common/home' ),
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get( 'text_account' ),
            'href' => $this->url->link( 'account/account', '', 'SSL' ),
            'separator' => $this->language->get( 'text_separator' )
        );

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get( 'text_upload_report' ),
            'href' => $this->url->link( 'report/report/upload_report', '', 'SSL' ),
            'separator' => $this->language->get( 'text_separator' )
        );

        $this->data['heading_title'] = $this->language->get('upload_report_heading_title');
        $this->data['text_download_template'] = $this->language->get('text_download_template');
        $this->data['text_report_upload'] = $this->language->get('text_report_upload');
        $this->data['text_report_name'] = $this->language->get('text_report_name');
        $this->data['template_download_button'] = $this->language->get('template_download_button');
        $this->data['upload_report_button'] = $this->language->get('upload_report_button');
        $this->data['error_report'] = $this->language->get('error_report');

        $this->data['upload_report'] = $this->url->link( 'report/report/upload_report', '', 'SSL' );

        $this->data['report_model_download_link'] = 'document/Template_raport.csv';

        if( file_exists( DIR_TEMPLATE.$this->config->get( 'config_template' ).'/template/report/upload_report.tpl' ) )
        {
            $this->template = $this->config->get( 'config_template' ).'/template/report/upload_report.tpl';
        }
        else
        {
            $this->template = 'default/template/report/upload_report.tpl';
        }

        $this->children = array(
            'common/column_left',
            'common/column_right',
            'common/content_top',
            'common/content_bottom',
            'common/footer',
            'common/header'
        );

        $this->response->setOutput( $this->render() );
    }

    public function list_Reports()
    {
        if( !$this->customer->isLogged() )
        {
            $this->session->data['redirect'] = $this->url->link( 'report/report/list_reports', '', 'SSL' );
            $this->redirect( $this->url->link( 'account/login', '', 'SSL' ) );
        }

        if( isset( $this->session->data['success'] ) )
        {
            $this->data['success'] = $this->session->data['success'];

            unset( $this->session->data['success'] );
        }
        else
        {
            $this->data['success'] = '';
        }

        $this->language->load( 'report/report' );
        $this->document->setTitle( $this->language->get( 'heading_title' ) );

        $this->data['breadcrumbs'] = array( );

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get( 'text_home' ),
            'href' => $this->url->link( 'common/home' ),
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get( 'text_account' ),
            'href' => $this->url->link( 'account/account', '', 'SSL' ),
            'separator' => $this->language->get( 'text_separator' )
        );

        $url = '';

        if( isset( $this->request->get['page'] ) )
        {
            $url .= '&page='.$this->request->get['page'];
        }

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get( 'text_list_report' ),
            'href' => $this->url->link( 'report/report/list_reports', $url, 'SSL' ),
            'separator' => $this->language->get( 'text_separator' )
        );

        $this->data['heading_title'] = $this->language->get('list_report_heading_title');
        $this->data['entry_subject'] = $this->language->get('entry_subject');
        $this->data['text_report_name'] = $this->language->get('text_report_name');
        $this->data['text_report_date_added'] = $this->language->get('text_report_date_added');
        $this->data['text_view_report'] = $this->language->get('text_view_report');
        $this->data['text_empty_report'] = $this->language->get('text_empty_report');
        $this->data['button_view_report'] = $this->language->get( 'button_view_report' );
        $this->data['button_back_upload_report'] = $this->language->get( 'button_back_upload_report' );

        $this->data['continue'] = $this->url->link( 'report/report/upload_report', '', 'SSL' );

        if(isset($this->request->get['page']))
        {
            $page = $this->request->get['page'];
        }
        else
        {
            $page = 1;
        }

        $this->data['reports'] = array();

        $this->load->model( 'report/report' );
        $report_total = $this->model_report_report->getTotalReports($this->customer->getId());
        $results = $this->model_report_report->getReports(($page - 1) * 10, 10, $this->customer->getId());

        foreach ( $results as $key => $value ) {

            $view_href = $this->url->link('report/report/view_report', 'id='.$value['report_id'], 'SSL');

            $this->data['reports'][] = array(
                'customer_id' => $value['customer_id'],
                'name' => $value['name'],
                'date_added' => $value['date_added'],
                'view_href' => $view_href,
            );
        }

        $pagination = new Pagination();
        $pagination->total = $report_total;
        $pagination->page = $page;
        $pagination->limit = 10;
        $pagination->text = $this->language->get( 'text_pagination' );
        $pagination->url = $this->url->link( 'report/report/list_reports', 'page={page}', 'SSL' );

        $this->data['pagination'] = $pagination->render();

        $this->data['list_report'] = $this->url->link( 'report/report/list_reports', '', 'SSL' );

        if( file_exists( DIR_TEMPLATE.$this->config->get( 'config_template' ).'/template/report/list_reports.tpl' ) )
        {
            $this->template = $this->config->get( 'config_template' ).'/template/report/list_reports.tpl';
        }
        else
        {
            $this->template = 'default/template/report/list_reports.tpl';
        }

        $this->children = array(
            'common/column_left',
            'common/column_right',
            'common/content_top',
            'common/content_bottom',
            'common/footer',
            'common/header'
        );

        $this->response->setOutput( $this->render() );
    }

    public function view_Report()
    {
        if( !$this->customer->isLogged() )
        {
            $this->session->data['redirect'] = $this->url->link( 'report/report/list_reports', '', 'SSL' );
            $this->redirect( $this->url->link( 'account/login', '', 'SSL' ) );
        }

        $this->language->load( 'report/report' );
        $this->document->setTitle( $this->language->get( 'heading_title' ) );
        $this->load->model( 'report/report' );

        $this->data['breadcrumbs'] = array( );

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get( 'text_home' ),
            'href' => $this->url->link( 'common/home' ),
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get( 'text_account' ),
            'href' => $this->url->link( 'account/account', '', 'SSL' ),
            'separator' => $this->language->get( 'text_separator' )
        );

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get( 'text_view_report' ),
            'href' => $this->url->link( 'report/report/view_report', '', 'SSL' ),
            'separator' => $this->language->get( 'text_separator' )
        );
        $id = $_GET['id'];
        $this->data['reports'] = $this->model_report_report->getReportEntries($id, $this->customer->getId());

        $report_name = $this->model_report_report->getReportName($id);
        $this->data['report_name'] = $report_name;
        $this->data['heading_title'] = $this->language->get('view_report_heading_title');
        $this->data['text_customer_name'] = $this->language->get('text_customer_name');
        $this->data['text_work_address'] = $this->language->get('text_work_address');
        $this->data['text_CUI'] = $this->language->get('text_CUI');
        $this->data['text_product_code'] = $this->language->get('text_product_code');
        $this->data['text_product_name'] = $this->language->get('text_product_name');
        $this->data['text_buy_price'] = $this->language->get('text_buy_price');
        $this->data['text_net_sale_price'] = $this->language->get('text_net_sale_price');
        $this->data['text_product_quantity'] = $this->language->get('text_product_quantity');
        $this->data['text_sale_agent_name'] = $this->language->get('text_sale_agent_name');
        $this->data['text_month'] = $this->language->get('text_month');
        $this->data['button_back_report_list'] = $this->language->get('button_back_report_list');

        $this->data['continue'] = $this->url->link( 'report/report/list_reports', '', 'SSL' );

        if( file_exists( DIR_TEMPLATE.$this->config->get( 'config_template' ).'/template/report/view_report.tpl' ) )
        {
            $this->template = $this->config->get( 'config_template' ).'/template/report/view_report.tpl';
        }
        else
        {
            $this->template = 'default/template/report/view_report.tpl';
        }

        $this->children = array(
            'common/column_left',
            'common/column_right',
            'common/content_top',
            'common/content_bottom',
            'common/footer',
            'common/header'
        );

        $this->response->setOutput( $this->render() );
    }
}

?>