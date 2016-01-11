<?php

class ControllerAccountB2BAddress extends Controller
{

    private $error = array( );

    public function insert()
    {
        if( !$this->customer->isLogged() )
        {
            $this->session->data['redirect'] = $this->url->link( 'account/address', '', 'SSL' );

            $this->redirect( $this->url->link( 'account/login', '', 'SSL' ) );
        }

        $this->language->load( 'account/address' );

        $this->document->setTitle( $this->language->get( 'heading_title' ) );

        $this->load->model( 'invoice/address' );

        if( ($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm() )
        {
            $this->model_invoice_address->addAddress( $this->request->post, $this->customer->getAxCode() );

            $this->session->data['success'] = $this->language->get( 'text_insert' );

            $this->redirect( $this->url->link( 'account/account', '', 'SSL' ) );
        }

        $this->getForm();
    }

    public function update()
    {
        if( !$this->customer->isLogged() )
        {
            $this->session->data['redirect'] = $this->url->link( 'account/address', '', 'SSL' );

            $this->redirect( $this->url->link( 'account/login', '', 'SSL' ) );
        }

        $this->language->load( 'account/address' );

        $this->document->setTitle( $this->language->get( 'heading_title' ) );

        $this->load->model( 'invoice/address' );

        if( ($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm() )
        {
            $this->model_invoice_address->editAddress( $this->request->get['accountnum'], $this->request->get['nrcrt'] , $this->request->post );

            $this->session->data['success'] = $this->language->get( 'text_update' );

            // send a notification message to the site administrator
            $mail = new Mail();
            $mail->protocol = $this->config->get( 'config_mail_protocol' );
            $mail->parameter = $this->config->get( 'config_mail_parameter' );
            $mail->hostname = $this->config->get( 'config_smtp_host' );
            $mail->username = $this->config->get( 'config_smtp_username' );
            $mail->password = $this->config->get( 'config_smtp_password' );
            $mail->port = $this->config->get( 'config_smtp_port' );
            $mail->timeout = $this->config->get( 'config_smtp_timeout' );

            $this->load->model( 'setting_email_address/setting_email_address' );
            $email_address_info = $this->model_setting_email_address_setting_email_address->getEmailAddress( 'MODIFICARI_DATE' ); // Modificari date

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

            $subject = $this->language->get( 'text_subject_notification' );
            $message = $this->language->get( 'text_client' )."<strong>".$this->customer->getAxCode()."</strong> (".$this->customer->getEmail()."), ";
            $message .= $this->language->get( 'text_change_company_info' );

            $mail->setSubject( html_entity_decode( $subject, ENT_QUOTES, 'UTF-8' ) );
            $mail->setHtml( html_entity_decode( $message, ENT_QUOTES, 'UTF-8' ) );
            $mail->send();

            //$this->redirect($this->url->link('account/address', '', 'SSL'));
            $this->redirect( $this->url->link( 'account/account', '', 'SSL' ) );
        }

        $this->getForm();
    }

    public function delete()
    {
        if( !$this->customer->isLogged() )
        {
            $this->session->data['redirect'] = $this->url->link( 'account/address', '', 'SSL' );

            $this->redirect( $this->url->link( 'account/login', '', 'SSL' ) );
        }

        $this->language->load( 'account/address' );

        $this->document->setTitle( $this->language->get( 'heading_title' ) );

        $this->load->model( 'invoice/address' );

        if( isset( $this->request->get['accountnum'] ) && isset( $this->request->get['nrcrt'] ) && $this->validateDelete( $this->request->get['accountnum'] ) )
        {
            $this->model_invoice_address->deleteAddress( $this->request->get['accountnum'], $this->request->get['nrcrt'] );

            $this->session->data['success'] = $this->language->get( 'text_delete' );
            
            $this->redirect( $this->url->link( 'account/account', '', 'SSL' ) );
        }

        $this->getList();
    }

    protected function getForm()
    {
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

        if( !isset( $this->request->get['accountnum'] ) && !isset( $this->request->get['nrcrt'] ) )
        {
            $this->data['breadcrumbs'][] = array(
                'text' => $this->language->get( 'text_add_address' ),
                'href' => $this->url->link( 'account/address/insert', '', 'SSL' ),
                'separator' => $this->language->get( 'text_separator' )
            );
            $this->data['text_address'] = $this->language->get( 'text_add_address' );
        }
        else
        {
            $this->data['breadcrumbs'][] = array(
                'text' => $this->language->get( 'text_edit_address' ),
                'href' => $this->url->link( 'account/b2b_address/update', 'accountnum=' . $this->request->get['accountnum'].'&nrcrt='.$this->request->get['nrcrt'], 'SSL' ),
                'separator' => $this->language->get( 'text_separator' )
            );

            $this->data['text_address'] = $this->language->get( 'text_edit_address' );
        }

        $this->data['heading_title'] = $this->language->get( 'heading_title' );
        $this->data['text_address_book_delivery'] = $this->language->get( 'text_address_book_delivery' );
        $this->data['heading_title_delivery'] = $this->language->get( 'heading_title_delivery' );

        $this->data['text_yes'] = $this->language->get( 'text_yes' );
        $this->data['text_no'] = $this->language->get( 'text_no' );
        $this->data['text_select'] = $this->language->get( 'text_select' );
        $this->data['text_none'] = $this->language->get( 'text_none' );

        $this->data['entry_firstname'] = $this->language->get( 'entry_firstname' );
        $this->data['entry_lastname'] = $this->language->get( 'entry_lastname' );
        $this->data['entry_company'] = $this->language->get( 'entry_company' );
        $this->data['entry_banca'] = $this->language->get( 'entry_banca' );
        $this->data['entry_iban'] = $this->language->get( 'entry_iban' );
        $this->data['entry_company_id'] = $this->language->get( 'entry_company_id' );
        $this->data['entry_tax_id'] = $this->language->get( 'entry_tax_id' );
        $this->data['entry_address_1'] = $this->language->get( 'entry_address_1' );
        $this->data['entry_address_2'] = $this->language->get( 'entry_address_2' );
        $this->data['entry_postcode'] = $this->language->get( 'entry_postcode' );
        $this->data['entry_city'] = $this->language->get( 'entry_city' );
        $this->data['entry_country'] = $this->language->get( 'entry_country' );
        $this->data['entry_zone'] = $this->language->get( 'entry_zone' );
        $this->data['entry_default'] = $this->language->get( 'entry_default' );
        $this->data['entry_address_name'] = $this->language->get( 'entry_address_name' );

        $this->data['button_continue'] = $this->language->get( 'button_continue' );
        $this->data['button_back'] = $this->language->get( 'button_back' );

//        if( isset( $this->error['firstname'] ) )
//        {
//            $this->data['error_firstname'] = $this->error['firstname'];
//        }
//        else
//        {
//            $this->data['error_firstname'] = '';
//        }
//
//        if( isset( $this->error['lastname'] ) )
//        {
//            $this->data['error_lastname'] = $this->error['lastname'];
//        }
//        else
//        {
//            $this->data['error_lastname'] = '';
//        }
//
//        if( isset( $this->error['company_id'] ) )
//        {
//            $this->data['error_company_id'] = $this->error['company_id'];
//        }
//        else
//        {
//            $this->data['error_company_id'] = '';
//        }
//
//        /* balazs */
//        if( isset( $this->error['banca'] ) )
//        {
//            $this->data['error_banca'] = $this->error['banca'];
//        }
//        else
//        {
//            $this->data['error_banca'] = '';
//        }
//        if( isset( $this->error['iban'] ) )
//        {
//            $this->data['error_iban'] = $this->error['iban'];
//        }
//        else
//        {
//            $this->data['error_iban'] = '';
//        }
//        /* balazs */
//
//        if( isset( $this->error['tax_id'] ) )
//        {
//            $this->data['error_tax_id'] = $this->error['tax_id'];
//        }
//        else
//        {
//            $this->data['error_tax_id'] = '';
//        }

        if( isset( $this->error['address_1'] ) )
        {
            $this->data['error_address_1'] = $this->error['address_1'];
        }
        else
        {
            $this->data['error_address_1'] = '';
        }

        if( isset( $this->error['city'] ) )
        {
            $this->data['error_city'] = $this->error['city'];
        }
        else
        {
            $this->data['error_city'] = '';
        }

        if( isset( $this->error['postcode'] ) )
        {
            $this->data['error_postcode'] = $this->error['postcode'];
        }
        else
        {
            $this->data['error_postcode'] = '';
        }

        if( isset( $this->error['country'] ) )
        {
            $this->data['error_country'] = $this->error['country'];
        }
        else
        {
            $this->data['error_country'] = '';
        }

        if( isset( $this->error['zone'] ) )
        {
            $this->data['error_zone'] = $this->error['zone'];
        }
        else
        {
            $this->data['error_zone'] = '';
        }

        if( !isset( $this->request->get['accountnum'] ) && !isset( $this->request->get['nrcrt'] )  )
        {
            $this->data['action'] = $this->url->link( 'account/b2b_address/insert', '', 'SSL' );
        }
        else
        {
            $this->data['action'] = $this->url->link( 'account/b2b_address/update', 'accountnum=' . $this->request->get['accountnum'].'&nrcrt='.$this->request->get['nrcrt'], 'SSL' );
        }

        if( isset( $this->request->get['accountnum'] ) && isset( $this->request->get['nrcrt'] ) && ($this->request->server['REQUEST_METHOD'] != 'POST') )
        {
            $address_info = $this->model_invoice_address->getAddressData( $this->request->get['accountnum'], $this->request->get['nrcrt'] );
        }

//        if( isset( $this->request->post['firstname'] ) )
//        {
//            $this->data['firstname'] = $this->request->post['firstname'];
//        }
//        elseif( !empty( $address_info ) )
//        {
//            $this->data['firstname'] = $address_info['firstname'];
//        }
//        else
//        {
//            $this->data['firstname'] = '';
//        }
//
//        if( isset( $this->request->post['lastname'] ) )
//        {
//            $this->data['lastname'] = $this->request->post['lastname'];
//        }
//        elseif( !empty( $address_info ) )
//        {
//            $this->data['lastname'] = $address_info['lastname'];
//        }
//        else
//        {
//            $this->data['lastname'] = '';
//        }
//
//        if( isset( $this->request->post['company'] ) )
//        {
//            $this->data['company'] = $this->request->post['company'];
//        }
//        elseif( !empty( $address_info ) )
//        {
//            $this->data['company'] = $address_info['company'];
//        }
//        else
//        {
//            $this->data['company'] = '';
//        }
//
//        if( isset( $this->request->post['company_id'] ) )
//        {
//            $this->data['company_id'] = $this->request->post['company_id'];
//        }
//        elseif( !empty( $address_info ) )
//        {
//            $this->data['company_id'] = $address_info['company_id'];
//        }
//        else
//        {
//            $this->data['company_id'] = '';
//        }

        /* balazs */

//        if( isset( $this->request->post['banca'] ) )
//        {
//            $this->data['banca'] = $this->request->post['banca'];
//        }
//        elseif( !empty( $address_info ) )
//        {
//            $this->data['banca'] = $address_info['banca'];
//        }
//        else
//        {
//            $this->data['banca'] = '';
//        }
//
//        if( isset( $this->request->post['iban'] ) )
//        {
//            $this->data['iban'] = $this->request->post['iban'];
//        }
//        elseif( !empty( $address_info ) )
//        {
//            $this->data['iban'] = $address_info['iban'];
//        }
//        else
//        {
//            $this->data['iban'] = '';
//        }

        /* balazs */

//        if( isset( $this->request->post['tax_id'] ) )
//        {
//            $this->data['tax_id'] = $this->request->post['tax_id'];
//        }
//        elseif( !empty( $address_info ) )
//        {
//            $this->data['tax_id'] = $address_info['tax_id'];
//        }
//        else
//        {
//            $this->data['tax_id'] = '';
//        }

//        $this->load->model( 'account/customer_group' );
//
//        $customer_group_info = $this->model_account_customer_group->getCustomerGroup( $this->customer->getCustomerGroupId() );
//
//        if( $customer_group_info )
//        {
//            $this->data['company_id_display'] = $customer_group_info['company_id_display'];
//        }
//        else
//        {
//            $this->data['company_id_display'] = '';
//        }
//
//        if( $customer_group_info )
//        {
//            $this->data['tax_id_display'] = $customer_group_info['tax_id_display'];
//        }
//        else
//        {
//            $this->data['tax_id_display'] = '';
//        }
        

        if( isset( $this->request->post['address_1'] ) )
        {
            $this->data['address_1'] = $this->request->post['address_1'];
        }
        elseif( !empty( $address_info ) )
        {
            $this->data['address_1'] = $address_info['street'];
        }
        else
        {
            $this->data['address_1'] = '';
        }

//        if( isset( $this->request->post['address_2'] ) )
//        {
//            $this->data['address_2'] = $this->request->post['address_2'];
//        }
//        elseif( !empty( $address_info ) )
//        {
//            $this->data['address_2'] = $address_info['address_2'];
//        }
//        else
//        {
//            $this->data['address_2'] = '';
//        }

        if( isset( $this->request->post['postcode'] ) )
        {
            $this->data['postcode'] = $this->request->post['postcode'];
        }
        elseif( !empty( $address_info ) )
        {
            $this->data['postcode'] = $address_info['zipcode'];
        }
        else
        {
            $this->data['postcode'] = '';
        }
        

        if( isset( $this->request->post['city'] ) )
        {
            $this->data['city'] = $this->request->post['city'];
        }
        elseif( !empty( $address_info ) )
        {
            $this->data['city'] = $address_info['city'];
        }
        else
        {
            $this->data['city'] = '';
        }

        if( isset( $this->request->post['country_id'] ) )
        {
            $this->data['country_id'] = $this->request->post['country_id'];
        }
        elseif( !empty( $address_info ) )
        {
            $this->data['country_id'] = 175; // $address_info['country_id']
        }
        else
        {
            $this->data['country_id'] = $this->config->get( 'config_country_id' );
        }

        if( isset( $this->request->post['zone_id'] ) )
        {
            $this->data['zone_id'] = $this->request->post['zone_id'];
        }
        elseif( !empty( $address_info ) )
        {
            $zone_shortcut = $address_info['county'];
            
            $this->load->model( 'localisation/zone' );
            $zone_id = $this->model_localisation_zone->getZoneIdByCode( $zone_shortcut );
            
            $this->data['zone_id'] = $zone_id;
        }
        else
        {
            $this->data['zone_id'] = '';
        }
                        

        $this->load->model( 'localisation/country' );

        $this->data['countries'] = $this->model_localisation_country->getCountries();

        if( isset( $this->request->post['default'] ) )
        {
            $this->data['default'] = $this->request->post['default'];
        }
        elseif( isset( $this->request->get['accountnum'] ) )
        {            
            if ( $address_info['tipadresa'] == 'FACTURARE')
            {
                $this->data['default'] = true;
            }
            else if ( $address_info['tipadresa'] == 'LIVRARE')
            {
                $this->data['default'] = false;
            }
        }
        else
        {
            $this->data['default'] = false;
        }

        $this->data['back'] = $this->url->link( 'account/address', '', 'SSL' );

        if( file_exists( DIR_TEMPLATE.$this->config->get( 'config_template' ).'/template/account/b2b_address_form.tpl' ) )
        {
            $this->template = $this->config->get( 'config_template' ).'/template/account/b2b_address_form.tpl';
        }
        else
        {
            $this->template = 'default/template/account/b2b_address_form.tpl';
        }

        $this->children = array(

        'common/dream_column_header_top', 'common/dream_column_header_bottom', 'common/dream_column_footer_top', 'common/dream_column_footer_bottom',
      
            'common/column_left',
            'common/column_right',
            'common/content_top',
            'common/content_bottom',
            'common/footer',
            'common/header'
        );

        $this->response->setOutput( $this->render() );
    }

    protected function validateForm()
    {
        if( (utf8_strlen( $this->request->post['address_1'] ) < 3) || (utf8_strlen( $this->request->post['address_1'] ) > 128) )
        {
            $this->error['address_1'] = $this->language->get( 'error_address_1' );
        }

        if( (utf8_strlen( $this->request->post['city'] ) < 2) || (utf8_strlen( $this->request->post['city'] ) > 128) )
        {
            $this->error['city'] = $this->language->get( 'error_city' );
        }

        $this->load->model( 'localisation/country' );

        $country_info = $this->model_localisation_country->getCountry( $this->request->post['country_id'] );

        if( $country_info )
        {
            if( $country_info['postcode_required'] && (utf8_strlen( $this->request->post['postcode'] ) < 2) || (utf8_strlen( $this->request->post['postcode'] ) > 10) )
            {
                $this->error['postcode'] = $this->language->get( 'error_postcode' );
            }

            // VAT Validation
            $this->load->helper( 'vat' );

            if( $this->config->get( 'config_vat' ) && !empty( $this->request->post['tax_id'] ) && (vat_validation( $country_info['iso_code_2'], $this->request->post['tax_id'] ) == 'invalid') )
            {
                $this->error['tax_id'] = $this->language->get( 'error_vat' );
            }
        }

        if( $this->request->post['country_id'] == '' )
        {
            $this->error['country'] = $this->language->get( 'error_country' );
        }

        if( !isset( $this->request->post['zone_id'] ) || $this->request->post['zone_id'] == '' )
        {
            $this->error['zone'] = $this->language->get( 'error_zone' );
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

    protected function validateDelete( $accountnum )
    {
        if( $this->model_invoice_address->getTotalB2BAddresses( $accountnum ) == 1 )
        {
            $this->error['warning'] = $this->language->get( 'error_delete' );
        }

//        if( $this->customer->getAddressId() == $this->request->get['address_id'] )
//        {
//            $this->error['warning'] = $this->language->get( 'error_default' );
//        }

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