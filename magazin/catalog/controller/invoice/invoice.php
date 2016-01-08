<?php

class ControllerInvoiceInvoice extends Controller
{

    private $error = array( );

    public function listinvoices()
    {
        unset( $this->session->data['filter_by'] );
        unset( $this->session->data['filter_by_error'] );
        unset( $this->session->data['filter_value'] );
        unset( $this->session->data['filter_value_error'] );
        
        if( isset( $this->request->get['invoice_type'] ) )
        {
            $invoice_type = $this->request->get['invoice_type'];
        }
        else
        {
            $invoice_type = "all";
        }
        $this->session->data['invoice_type'] = $invoice_type;

        if( !$this->customer->isLogged() )
        {
            $this->session->data['redirect'] = $this->url->link( 'invoice/invoice/listinvoices', 'invoice_type='.$invoice_type, 'SSL' );
            $this->redirect( $this->url->link( 'account/login', '', 'SSL' ) );
        }

        $this->language->load( 'invoice/invoice' );
        $this->document->setTitle( $this->language->get( 'heading_title' ) );

        $this->data['breadcrumbs'] = array( );

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get( 'text_home' ),
            'href' => $this->url->link( 'common/home' ),
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get( 'text_cust_account' ),
            'href' => $this->url->link( 'account/account', '', 'SSL' ),
            'separator' => $this->language->get( 'text_separator' )
        );

        $url = '';

        if( isset( $this->request->get['page'] ) )
        {
            $url .= '&page='.$this->request->get['page'];
        }

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get( 'heading_title' ),
            'href' => $this->url->link( 'invoice/invoice/listinvoices', $url, 'SSL' ),
            'separator' => $this->language->get( 'text_separator' )
        );

        $this->data['heading_title'] = $this->language->get( 'heading_title' );
        $this->data['text_invoice_number'] = $this->language->get( 'text_invoice_number' );
        $this->data['text_release_date'] = $this->language->get( 'text_release_date' );
        $this->data['text_total_invoice'] = $this->language->get( 'text_total_invoice' );
        $this->data['text_view_details'] = $this->language->get( 'text_view_details' );
        $this->data['text_view_copy_of_invoice'] = $this->language->get( 'text_view_copy_of_invoice' );


        $this->data['text_invoice_id'] = $this->language->get( 'text_invoice_id' );
        $this->data['text_date'] = $this->language->get( 'text_date' );
        $this->data['text_due_date'] = $this->language->get( 'text_due_date' );
        $this->data['text_invoice_amount'] = $this->language->get( 'text_invoice_amount' );
        $this->data['text_currencycode'] = $this->language->get( 'text_currencycode' );
        $this->data['text_empty'] = $this->language->get( 'text_empty' );

        $this->data['button_view'] = $this->language->get( 'button_view' );
        $this->data['button_continue'] = $this->language->get( 'button_continue' );

        if( isset( $this->request->get['page'] ) )
        {
            $page = $this->request->get['page'];
        }
        else
        {
            $page = 1;
        }

        $this->data['invoices'] = array( );

        $this->load->model( 'invoice/invoice' );

        $this->load->model( 'account/address' );
		
		//if( $_SERVER['REMOTE_ADDR'] == '5.2.202.87' || $_SERVER['REMOTE_ADDR'] == '81.12.228.226'){
		// print $this->customer->getAddressId();
            $tax_id = $this->db->query("SELECT `vatnum` FROM `B2B_client` WHERE `accountnum` = '".$this->customer->getAxCode()."';");

            if($tax_id->num_rows) {
                $tax_id = $tax_id->row['vatnum'];
            }

            //echo "<pre>"; print_r($tax_id); die('1');

		//}

        //$address = $this->model_account_address->getAddress( $this->customer->getAddressId() );
        //$tax_id = $address['tax_id'];
		
	// if( $_SERVER['REMOTE_ADDR'] == '5.2.202.87' ){
	// print_r( $address); die();
	// }

        if( isset( $this->error['warning'] ) )
        {
            $this->data['error_warning'] = $this->error['warning'];
        }
        else
        {
            $this->data['error_warning'] = '';
        }

        if( isset( $this->error['filter_by'] ) )
        {
            $this->data['error_filter_by'] = $this->error['filter_by'];
        }
        else
        {
            $this->data['error_filter_by'] = '';
        }

        if( isset( $this->error['filter_value'] ) )
        {
            $this->data['error_filter_value'] = $this->error['filter_value'];
        }
        else
        {
            $this->data['error_filter_value'] = '';
        }

        if( isset( $this->request->post['filter_by'] ) )
        {
            $this->data['filter_by'] = $this->request->post['filter_by'];
        }

        if( isset( $this->request->post['filter_value'] ) )
        {
            $this->data['filter_value'] = $this->request->post['filter_value'];
        }

        
        $filter_params = ''; 
        if( $this->request->server['REQUEST_METHOD'] == 'POST' )
        {
            if( $this->validate() )
            {
                               
                if( isset( $this->request->post['filter_by'] ) )
                {
                    $filter_by = $this->request->post['filter_by'];
                    $filter_params .= "&filter_by=".$filter_by;
                }

                if( isset( $this->request->post['filter_value'] ) )
                {
                    $filter_value = $this->request->post['filter_value'];
                    $filter_params .= "&filter_value=".$filter_value;
                }

                $invoice_total = $this->model_invoice_invoice->getTotalInvoices( $this->customer->getAxCode(), $invoice_type, $this->customer->getPermission(), $tax_id, $filter_by, $filter_value );
                $results = $this->model_invoice_invoice->getInvoices( ($page - 1) * 10, 10, $this->customer->getAxCode(), $invoice_type, $this->customer->getPermission(), $tax_id, $filter_by, $filter_value );
                
                
            }
            else
            {                
                if( isset( $this->request->post['filter_by'] ) )
                {
                    $this->session->data['filter_by'] = $this->request->post['filter_by'];
                }
                
                if( isset( $this->request->post['filter_value'] ) )
                {
                    $this->session->data['filter_value'] = $this->request->post['filter_value'];
                }
                
                if( isset( $this->error['filter_by'] ) )
                {
                    $this->session->data['filter_by_error'] = $this->error['filter_by'];
                }
                
                if( isset( $this->error['filter_value'] ) )
                {
                    $this->session->data['filter_value_error'] = $this->error['filter_value'];
                }
               
                $this->redirect( $this->url->link( 'account/account/index', '' , 'SSL' ) );// $params
            }
        }
        else
        {
            $invoice_total = $this->model_invoice_invoice->getTotalInvoices( $this->customer->getAxCode(), $invoice_type, $this->customer->getPermission(), $tax_id );
            $results = $this->model_invoice_invoice->getInvoices( ($page - 1) * 10, 10, $this->customer->getAxCode(), $invoice_type, $this->customer->getPermission(), $tax_id );
        }


//        $invoice_total = $this->model_invoice_invoice->getTotalInvoices( $this->customer->getAxCode(), $invoice_type, $this->customer->getPermission(), $tax_id );
//        $results = $this->model_invoice_invoice->getInvoices( ($page - 1) * 10, 10, $this->customer->getAxCode(), $invoice_type, $this->customer->getPermission(), $tax_id );

        $this->session->data['invoice_type'] = $invoice_type;


        // verify if the invoice header have lines
        $this->load->model( 'invoice/invoice_lines' );

        //$sum = 0;
        $incomplete_invoices = array( );
        $this->load->model( 'invoice/invoice_header' );

        foreach( $results as $result )
        {
            $payment_status = $result['payment_status']."gray";
            $current_date = time(); //date('Y-m-d');
            if( time() <= strtotime( $result['duedate'] ) && !empty( $result['payment_status'] ) ) // facturi neincasate in scadenta, verde inchis
            {
                $payment_status = "green";
            }
            else if( time() > strtotime( $result['duedate'] ) && !empty( $result['payment_status'] ) ) // facturi neincasate de scadenta, rosu
            {
                $payment_status = "red";
            }


            $invoice_lines = $this->model_invoice_invoice_lines->getInvoiceLinesForOneInvoice( $result['invoiceaccount'], $result['invoiceid'] );
            $href = '';
            if( empty( $invoice_lines ) )
            {
                $incomplete_invoices[] = $result['invoiceid'];
                $href = '';
            }
            else
            {
                $href = $this->url->link( 'invoice/invoice/info', 'id='.$result['invoiceid']."&type=".$payment_status, 'SSL' ); // b2b_antet_factura_id
                //$sum += sizeof($invoice_lines);
            }


            $this->data['invoices'][] = array(
                'invoice_id' => $result['invoiceid'],
                'invoiceaccount' => $result['invoiceaccount'],
                'invoicedate' => date( $this->language->get( 'date_format_short' ), strtotime( $result['invoicedate'] ) ),
                'duedate' => date( $this->language->get( 'date_format_short' ), strtotime( $result['duedate'] ) ),
                'invoiceamount' => substr( $this->currency->format( $result['invoiceamount'] ), 0, -3 ),
                'currencycode' => $result['currencycode'],
                'payment_status' => $payment_status, //$this->model_invoice_invoice_header->getInvoiceStatus( $result['b2b_antet_factura_id'] ),
                'pdf' => DIR_INVOICE.$result['invoiceid'].".pdf", //HTTP_SERVER."invoices/".$result['invoiceid'].".pdf",
                'href' => $href
            );
        }

        if( !empty( $incomplete_invoices ) )
        {
            $this->sendIncompleteInvoicesIds( $incomplete_invoices );
        }

        $pagination = new Pagination();
        $pagination->total = $invoice_total;
        $pagination->page = $page;
        $pagination->limit = 10;
        $pagination->text = $this->language->get( 'text_pagination' );
        $pagination->url = $this->url->link( 'invoice/invoice/listinvoices', 'page={page}&invoice_type='.$invoice_type.$filter_params, 'SSL' );

        $this->data['pagination'] = $pagination->render();
        $this->data['continue'] = $this->url->link( 'account/account', '', 'SSL' );

        if( file_exists( DIR_TEMPLATE.$this->config->get( 'config_template' ).'/template/invoice/invoice_list.tpl' ) )
        {
            $this->template = $this->config->get( 'config_template' ).'/template/invoice/invoice_list.tpl';
        }
        else
        {
            $this->template = 'default/template/account/invoice_list.tpl';
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

    public function info()
    {
        $this->language->load( 'invoice/invoice' );

        if( isset( $this->request->get['id'] ) )
        {
            $id = $this->request->get['id'];
        }
        else
        {
            $id = 0;
        }

        if( !$this->customer->isLogged() )
        {
            $this->session->data['redirect'] = $this->url->link( 'invoice/invoice/info', 'id='.$id, 'SSL' );

            $this->redirect( $this->url->link( 'account/login', '', 'SSL' ) );
        }

        if( isset( $this->request->get['type'] ) )
        {
            $invoice_type = $this->request->get['type'];
        }
        $this->data['invoice_type'] = $invoice_type;


        $this->load->model( 'invoice/invoice_header' );

        $customer_ax_code = $this->model_invoice_invoice_header->getInvoiceAccount( $id );
        $invoice_header = $this->model_invoice_invoice_header->getInvoiceHeader( $id ); //$this->customer->getAxCode(),


        if( !empty( $invoice_header ) )
        {
            $this->document->setTitle( $this->language->get( 'text_invoice' ) );

            $this->data['breadcrumbs'] = array( );

            $this->data['breadcrumbs'][] = array(
                'text' => $this->language->get( 'text_home' ),
                'href' => $this->url->link( 'common/home' ),
                'separator' => false
            );

            $this->data['breadcrumbs'][] = array(
                'text' => $this->language->get( 'text_cust_account' ),
                'href' => $this->url->link( 'account/account', '', 'SSL' ),
                'separator' => $this->language->get( 'text_separator' )
            );

            $url = '';

            if( isset( $this->request->get['page'] ) )
            {
                $url .= '&page='.$this->request->get['page'];
            }

            $this->data['breadcrumbs'][] = array(
                'text' => $this->language->get( 'heading_title' ),
                'href' => $this->url->link( 'invoice/invoice/listinvoices', $url, 'SSL' ),
                'separator' => $this->language->get( 'text_separator' )
            );

            $this->data['breadcrumbs'][] = array(
                'text' => $this->language->get( 'text_invoice_detail' ),
                'href' => $this->url->link( 'invoice/invoice/info', 'id='.$id.$url, 'SSL' ),
                'separator' => $this->language->get( 'text_separator' )
            );

            $this->data['heading_title'] = $this->language->get( 'text_invoice' );

            $this->data['text_invoice_detail'] = $this->language->get( 'text_invoice_detail' );
            $this->data['text_invoice'] = $this->language->get( 'text_invoice' );
            $this->data['text_date'] = $this->language->get( 'text_date' );
            $this->data['text_due_date'] = $this->language->get( 'text_due_date' );
            $this->data['text_currencycode'] = $this->language->get( 'text_currencycode' );
            $this->data['text_invoice_amount'] = $this->language->get( 'text_invoice_amount' );

            $this->data['text_billing_address'] = $this->language->get( 'text_billing_address' );
            $this->data['text_bank_accounts'] = $this->language->get( 'text_bank_accounts' );

            $this->data['text_number'] = $this->language->get( 'text_number' );
            $this->data['text_article_code'] = $this->language->get( 'text_article_code' );
            $this->data['text_quantity'] = $this->language->get( 'text_quantity' );
            $this->data['text_article_name'] = $this->language->get( 'text_article_name' );
            $this->data['text_sales_unit'] = $this->language->get( 'text_sales_unit' );
            $this->data['text_calc_net_unit_price'] = $this->language->get( 'text_calc_net_unit_price' );
            $this->data['text_line_amount'] = $this->language->get( 'text_line_amount' );
            $this->data['text_pay_online'] = $this->language->get( 'text_pay_online' );

            $this->data['invoice_id'] = $invoice_header[0]['invoiceid'];
            $this->data['invoice_date'] = date( $this->language->get( 'date_format_short' ), strtotime( $invoice_header[0]['invoicedate'] ) );
            $this->data['invoice_duedate'] = date( $this->language->get( 'date_format_short' ), strtotime( $invoice_header[0]['duedate'] ) );
            $this->data['invoice_currencycode'] = $invoice_header[0]['currencycode'];
            $this->data['invoice_amount'] = $this->currency->format( $invoice_header[0]['invoiceamount'] );


            // address info
            $this->data['billing_address'] = array( );
            $this->load->model( 'invoice/address' );
            $billing_address = $this->model_invoice_address->getAddress( $customer_ax_code ); //$this->customer->getAxCode()
            $billing_address = reset( $billing_address );

            if( !empty( $billing_address ) )
            {
                $format = $this->language->get( 'text_street' ).' {street}'."\n".$this->language->get( 'text_location' ).' {city}'."\n".$this->language->get( 'text_county' ).' {county}'."\n".$this->language->get( 'text_zipcode' ).' {zipcode}';

                $find = array(
                    '{street}',
                    '{city}',
                    '{county}',
                    '{zipcode}'
                );

                $replace = array(
                    'street' => $billing_address['street'],
                    'city' => $billing_address['city'],
                    'county' => $billing_address['county'],
                    'zipcode' => $billing_address['zipcode']
                );

                $this->data['billing_address'] = str_replace( array( "\r\n", "\r", "\n" ), '<br />', preg_replace( array( "/\s\s+/", "/\r\r+/", "/\n\n+/" ), '<br />', trim( str_replace( $find, $replace, $format ) ) ) );
            }

            // Bank accounts info
            $this->data['bank_accounts'] = array( );
            $this->load->model( 'invoice/bank_account' );
            $bank_accounts = $this->model_invoice_bank_account->getBankAccount( $customer_ax_code ); // $this->customer->getAxCode()
            foreach( $bank_accounts as $bank_account )
            {
                $bank_account_data[] = $bank_account['iban'];
            }
            $this->data['bank_accounts'] = $bank_account_data;


            // invoice lines
            $this->data['invoice_lines'] = array( );
            $this->load->model( 'invoice/invoice_lines' );

            $invoice_lines = $this->model_invoice_invoice_lines->getInvoiceLinesForOneInvoice( $customer_ax_code, $this->data['invoice_id'] ); //$this->customer->getAxCode()
            $total = 0;
            foreach( $invoice_lines as $invoice_line )
            {
                $this->data['invoice_lines'][] = array(
                    'linenum' => $this->returnIntegerPart( $invoice_line['linenum'] ),
                    'codart' => $invoice_line['codart'],
                    'itemname' => $invoice_line['itemname'],
                    'qty' => $this->returnIntegerPart( $invoice_line['qty'] ),
                    'salesunit' => $invoice_line['salesunit'],
                    'calcnetunitprice' => $this->currency->format( $invoice_line['calcnetunitprice'] ),
                    'lineamount' => $this->currency->format( $invoice_line['lineamount'] )
                );
                $total += $invoice_line['lineamount'];
            }
            $this->data['total'] = $this->currency->format( $total );


            //$this->data['continue'] = $this->url->link( 'plata', '', 'SSL' );
            $this->load->model( 'account/address' );
            $address = $this->model_account_address->getAddress( $this->customer->getAddressId() );
            $tax_id = $address['tax_id'];

            if( empty( $address['company'] ) )
                $company_name = $this->customer->getFirstName()." ".$this->customer->getLastName();
            else
                $company_name = $address['company'];

            $this->data['company_name'] = $company_name;
            $this->data['company_email'] = $this->customer->getEmail();
            $this->data['company_phone'] = $this->customer->getTelephone();
            $this->data['company_tax_id'] = $address['tax_id'];


            if( file_exists( DIR_TEMPLATE.$this->config->get( 'config_template' ).'/template/invoice/invoice_info.tpl' ) )
            {
                $this->template = $this->config->get( 'config_template' ).'/template/invoice/invoice_info.tpl';
            }
            else
            {
                $this->template = 'default/template/invoice/invoice_info.tpl';
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
        else
        {
            $this->document->setTitle( $this->language->get( 'text_invoice' ) );
            $this->data['heading_title'] = $this->language->get( 'text_invoice' );
            $this->data['text_error'] = $this->language->get( 'text_error' );
            $this->data['button_continue'] = $this->language->get( 'text_button_continue' );

            $this->data['breadcrumbs'] = array( );

            $this->data['breadcrumbs'][] = array(
                'text' => $this->language->get( 'text_home' ),
                'href' => $this->url->link( 'common/home' ),
                'separator' => false
            );

            $this->data['breadcrumbs'][] = array(
                'text' => $this->language->get( 'text_cust_account' ),
                'href' => $this->url->link( 'account/account', '', 'SSL' ),
                'separator' => $this->language->get( 'text_separator' )
            );

            $this->data['breadcrumbs'][] = array(
                'text' => $this->language->get( 'heading_title' ),
                'href' => $this->url->link( 'invoice/invoice/listinvoices', $url, 'SSL' ),
                'separator' => $this->language->get( 'text_separator' )
            );

            $this->data['breadcrumbs'][] = array(
                'text' => $this->language->get( 'text_invoice_detail' ),
                'href' => $this->url->link( 'invoice/invoice/info', 'id='.$id, 'SSL' ),
                'separator' => $this->language->get( 'text_separator' )
            );

            $this->data['continue'] = $this->url->link( 'invoice/invoice/listinvoices', 'invoice_type='.$invoice_type, 'SSL' );

            if( file_exists( DIR_TEMPLATE.$this->config->get( 'config_template' ).'/template/error/not_found.tpl' ) )
            {
                $this->template = $this->config->get( 'config_template' ).'/template/error/not_found.tpl';
            }
            else
            {
                $this->template = 'default/template/error/not_found.tpl';
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
	
	public function export_to_xls() {
        if( isset( $this->request->get['id'] ) )
        {
            $invoice_id = $this->request->get['id'];

            $this->load->model( 'invoice/invoice_header' );

            $invoice_header = $this->model_invoice_invoice_header->getInvoiceHeader( $invoice_id );

            $invoice_date = date( $this->language->get( 'date_format_short' ), strtotime( $invoice_header[0]['invoicedate'] ) );
            $invoice_duedate = date( $this->language->get( 'date_format_short' ), strtotime( $invoice_header[0]['duedate'] ) );
            $invoice_currencycode = $invoice_header[0]['currencycode'];
            $invoice_amount = $this->currency->format( $invoice_header[0]['invoiceamount'] );

            $customer_ax_code = $this->model_invoice_invoice_header->getInvoiceAccount( $invoice_id );

            $this->load->model( 'invoice/invoice_lines' );

            $invoice_lines = $this->model_invoice_invoice_lines->getInvoiceLinesForOneInvoice( $customer_ax_code, $invoice_id );

            //echo "<pre>"; print_r($invoice_lines);


            require_once dirname(__FILE__).'/../../../system/PHPExcel/Classes/PHPExcel.php';

            $objPHPExcel = new PHPExcel();

            // Set document properties
            $objPHPExcel->getProperties()->setCreator("Renania")
                ->setLastModifiedBy("Renania")
                ->setTitle("Renania Factura fiscala")
                ->setSubject("Renania Factura fiscala")
                ->setDescription("Test document for PHPExcel, generated using PHP classes.")
                ->setKeywords("office PHPExcel php")
                ->setCategory("Test result file");

            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:D1')
                ->setCellValue('A1', 'Detalii despre factura fiscala');

            // Define the columns headers
            $objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A2', 'Factura fiscala '.$invoice_id)

                ->setCellValue('E2', 'Suma '.$invoice_amount);

            $objPHPExcel->getActiveSheet()->mergeCells('A3:D3');
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A3', 'Data: '.$invoice_date)
                ->setCellValue('E3', 'Moneda '.$invoice_currencycode);

            $objPHPExcel->getActiveSheet()->mergeCells('A4:D4');
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A4', 'Data scadenta '.$invoice_duedate);

            // Define the columns headers
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A6', 'Nr.')
                ->setCellValue('B6', 'Cod articol')
                ->setCellValue('C6', 'Nume articol')
                ->setCellValue('D6', 'Cantitate')
                ->setCellValue('E6', 'Unitate de vanzare')
                ->setCellValue('F6', 'Pret unitar')
                ->setCellValue('G6', 'Total');

            // row counter variable for foreach
            $rowCounter = 7;
            $total = 0;

            //var_dump($invoice_lines);

            // copy data in to the xls
            foreach( $invoice_lines as $oneUser ) {
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $rowCounter, $oneUser['linenum'])
                    ->setCellValue('B' . $rowCounter, $oneUser['codart'])
                    ->setCellValue('C' . $rowCounter, $oneUser['itemname'])
                    ->setCellValue('D' . $rowCounter, $oneUser['qty'])
                    ->setCellValue('E' . $rowCounter, $oneUser['salesunit'])
                    ->setCellValue('F' . $rowCounter, $this->currency->format( $oneUser['calcnetunitprice'] ))
                    ->setCellValue('G' . $rowCounter, $this->currency->format( $oneUser['lineamount'] ));

                $rowCounter++;
                $total += $oneUser['lineamount'];
            }
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('F' . $rowCounter, "Total")
                ->setCellValue('G' . $rowCounter, $this->currency->format( $total ));

            // Rename worksheet
            $objPHPExcel->getActiveSheet()->setTitle('Simple');


            // Set active sheet index to the first sheet, so Excel opens this as the first sheet
            $objPHPExcel->setActiveSheetIndex(0);

            // automatic column width calculation
            foreach (range('A', $objPHPExcel->getActiveSheet()->getHighestDataColumn()) as $col) {
                $objPHPExcel->getActiveSheet()
                    ->getColumnDimension($col)
                    ->setAutoSize(true);
            }

            //ob_clean();
            // Redirect output to a client�s web browser (Excel5)
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="01simple.xls"');
            header('Content-Disposition: attachment;filename="'.$invoice_id.'.xls"');
            header('Cache-Control: max-age=0');
            // If you're serving to IE 9, then the following may be needed
            header('Cache-Control: max-age=1');

            // If you're serving to IE over SSL, then the following may be needed
            header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
            header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header ('Pragma: public'); // HTTP/1.0
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
            exit;
        }
    }

    private function returnIntegerPart( $number )
    {
        $number_exp = explode( ".", $number );

        return $number_exp[0];
    }

    protected function sendIncompleteInvoicesIds( $invoices_id )
    {
        //send incomplete invoice ids for admin
        $mail = new Mail();
        $mail->protocol = $this->config->get( 'config_mail_protocol' );
        $mail->parameter = $this->config->get( 'config_mail_parameter' );
        $mail->hostname = $this->config->get( 'config_smtp_host' );
        $mail->username = $this->config->get( 'config_smtp_username' );
        $mail->password = $this->config->get( 'config_smtp_password' );
        $mail->port = $this->config->get( 'config_smtp_port' );
        $mail->timeout = $this->config->get( 'config_smtp_timeout' );

        $this->load->model( 'setting_email_address/setting_email_address' );
        $email_address_info = $this->model_setting_email_address_setting_email_address->getEmailAddress( "FACTURE_INCOMPLETE" ); // Facture incomplete

        if( isset( $email_address_info ) && !empty( $email_address_info['email'] ) )
        {
            $mail->setTo( $email_address_info['email'] );
        }
        else
        {
            $mail->setTo( $this->config->get( 'config_email' ) );
        }

        $mail->setFrom( $this->config->get( 'config_email' ) );
        $mail->setSender( $this->config->get( 'config_name' ) );

        $this->language->load( 'invoice/invoice' );
        $subject = $this->language->get( 'text_incomplete_invoices' );
        $mail->setSubject( html_entity_decode( $subject, ENT_QUOTES, 'UTF-8' ) );

        $message = $this->language->get( 'text_incomplete_invoices_msg' )."<br>";
        foreach( $invoices_id as $value )
        {
            $message .= $value."<br>";
        }
        $message = substr( $message, 0, strlen( $message ) - 4 );

        $mail->setHtml( html_entity_decode( $message, ENT_QUOTES, 'UTF-8' ) );

        // mail("apuskas@grafx.ro", $subject , $message);        
        $mail->send();
    }

    protected function validate()
    {

        if( utf8_strlen( $this->request->post['filter_value'] ) < 1  )//|| utf8_strlen( trim($this->request->post['filter_value']) ) == 'AAAA-LL-ZZ'
        {
            $this->error['filter_value'] = $this->language->get( 'error_filter_value' );
        }

        $filter_array = array( "invoice_number", "invoice_date", "invoice_due_date" );
        if( !in_array( $this->request->post['filter_by'], $filter_array ) )
        {
            $this->error['filter_by'] = $this->language->get( 'error_filter_by' );
        }
        
        if ( $this->request->post['filter_by'] == "invoice_date" || $this->request->post['filter_by'] == "invoice_due_date" )
        {         
            if( trim($this->request->post['filter_value'] ) == 'AAAA-LL-ZZ' )
            {
                $this->error['filter_value'] = $this->language->get( 'error_filter_data' );
            }                       
        }

        if( !$this->error )
        {
            return true;
        }
        else
        {
            return false;
        }
    }

}

?>