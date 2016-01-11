<?php

class ControllerCatalogSettingEmailAddress extends Controller
{

    private $error = array( );

    public function index()
    {
        $this->language->load( 'catalog/setting_email_address' );

        $this->document->setTitle( $this->language->get( 'heading_title' ) );

        $this->load->model( 'catalog/setting_email_address' );

        $this->getList();
    }

    public function insert()
    {
        $this->language->load( 'catalog/setting_email_address' );

        $this->document->setTitle( $this->language->get( 'heading_title' ) );

        $this->load->model( 'catalog/setting_email_address' );

        if( ($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm() )
        {
            $this->model_catalog_setting_email_address->addEmailAddress( $this->request->post );

            $this->session->data['success'] = $this->language->get( 'text_add_success' );

            $url = '';

            if( isset( $this->request->get['sort'] ) )
            {
                $url .= '&sort='.$this->request->get['sort'];
            }

            if( isset( $this->request->get['order'] ) )
            {
                $url .= '&order='.$this->request->get['order'];
            }

            if( isset( $this->request->get['page'] ) )
            {
                $url .= '&page='.$this->request->get['page'];
            }

            $this->redirect( $this->url->link( 'catalog/setting_email_address', 'token='.$this->session->data['token'].$url, 'SSL' ) );
        }

        $this->getForm();
    }

    public function update()
    {
        $this->language->load( 'catalog/setting_email_address' );

        $this->document->setTitle( $this->language->get( 'heading_title' ) );

        $this->load->model( 'catalog/setting_email_address' );

        if( ($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm( "update" ) )
        {
            $this->model_catalog_setting_email_address->editEmailAddress( $this->request->get['email_id'], $this->request->post );
            $this->session->data['success'] = $this->language->get( 'text_mod_success' );

            $url = '';

            if( isset( $this->request->get['sort'] ) )
            {
                $url .= '&sort='.$this->request->get['sort'];
            }

            if( isset( $this->request->get['order'] ) )
            {
                $url .= '&order='.$this->request->get['order'];
            }

            if( isset( $this->request->get['page'] ) )
            {
                $url .= '&page='.$this->request->get['page'];
            }

            $this->redirect( $this->url->link( 'catalog/setting_email_address', 'token='.$this->session->data['token'].$url, 'SSL' ) );
        }

        $this->getForm();
    }

    public function delete()
    {
        $this->language->load( 'catalog/setting_email_address' );

        $this->document->setTitle( $this->language->get( 'heading_title' ) );

        $this->load->model( 'catalog/setting_email_address' );

        if( isset( $this->request->post['selected'] ) )// && $this->validateDelete()
        {
            foreach( $this->request->post['selected'] as $email_id )
            {
                $this->model_catalog_setting_email_address->deleteEmailAddress( $email_id );
            }

            $this->session->data['success'] = $this->language->get( 'text_delete_success' );

            $url = '';

            if( isset( $this->request->get['sort'] ) )
            {
                $url .= '&sort='.$this->request->get['sort'];
            }

            if( isset( $this->request->get['order'] ) )
            {
                $url .= '&order='.$this->request->get['order'];
            }

            if( isset( $this->request->get['page'] ) )
            {
                $url .= '&page='.$this->request->get['page'];
            }

            $this->redirect( $this->url->link( 'catalog/setting_email_address', 'token='.$this->session->data['token'].$url, 'SSL' ) );
        }

        $this->getList();
    }

    protected function getList()
    {
        if( isset( $this->request->get['sort'] ) )
        {
            $sort = $this->request->get['sort'];
        }
        else
        {
            $sort = 'id.name';
        }

        if( isset( $this->request->get['order'] ) )
        {
            $order = $this->request->get['order'];
        }
        else
        {
            $order = 'ASC';
        }

        if( isset( $this->request->get['page'] ) )
        {
            $page = $this->request->get['page'];
        }
        else
        {
            $page = 1;
        }

        $url = '';

        if( isset( $this->request->get['sort'] ) )
        {
            $url .= '&sort='.$this->request->get['sort'];
        }

        if( isset( $this->request->get['order'] ) )
        {
            $url .= '&order='.$this->request->get['order'];
        }

        if( isset( $this->request->get['page'] ) )
        {
            $url .= '&page='.$this->request->get['page'];
        }

        $this->data['breadcrumbs'] = array( );

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get( 'text_home' ),
            'href' => $this->url->link( 'common/home', 'token='.$this->session->data['token'], 'SSL' ),
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get( 'heading_title' ),
            'href' => $this->url->link( 'catalog/setting_email_address', 'token='.$this->session->data['token'].$url, 'SSL' ),
            'separator' => ' :: '
        );

        $this->data['insert'] = $this->url->link( 'catalog/setting_email_address/insert', 'token='.$this->session->data['token'].$url, 'SSL' );
        $this->data['delete'] = $this->url->link( 'catalog/setting_email_address/delete', 'token='.$this->session->data['token'].$url, 'SSL' );

        $this->data['email_addresses'] = array( );

        $data = array(
            'sort' => $sort,
            'order' => $order,
            'start' => ($page - 1) * $this->config->get( 'config_admin_limit' ),
            'limit' => $this->config->get( 'config_admin_limit' )
        );

        $email_address_total = $this->model_catalog_setting_email_address->getTotalEmails();

        $results = $this->model_catalog_setting_email_address->getEmailAddresses( $data );
        
        foreach( $results as $result )
        {
            $action = array( );

            $action[] = array(
                'text' => $this->language->get( 'text_edit' ),
                'href' => $this->url->link( 'catalog/setting_email_address/update', 'token='.$this->session->data['token'].'&email_id='.$result['idemailaddress'].$url, 'SSL' )
            );

            $this->data['email_addresses'][] = array(
                'email_address_id' => $result['idemailaddress'],
                'name' => $result['name'],
                'email' => $result['email'],
                'insert_date' => $result['insert_date'],
                'sort_order' => $result['sort_order'],  
                'selected' => isset( $this->request->post['selected'] ) && in_array( $result['idemailaddress'], $this->request->post['selected'] ),
                'action' => $action
            );
        }

        $this->data['heading_title'] = $this->language->get( 'heading_title' );
        $this->data['text_no_results'] = $this->language->get( 'text_no_results' );

        $this->data['column_title'] = $this->language->get( 'column_title' );
        $this->data['column_email'] = $this->language->get( 'column_email' );
        $this->data['column_sort_order'] = $this->language->get( 'column_sort_order' );
        $this->data['column_action'] = $this->language->get( 'column_action' );

        $this->data['button_insert'] = $this->language->get( 'button_insert' );
        $this->data['button_delete'] = $this->language->get( 'button_delete' );

        if( isset( $this->error['warning'] ) )
        {
            $this->data['error_warning'] = $this->error['warning'];
        }
        else
        {
            $this->data['error_warning'] = '';
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

        $url = '';

        if( $order == 'ASC' )
        {
            $url .= '&order=DESC';
        }
        else
        {
            $url .= '&order=ASC';
        }

        if( isset( $this->request->get['page'] ) )
        {
            $url .= '&page='.$this->request->get['page'];
        }

        $this->data['sort_title'] = $this->url->link( 'catalog/setting_email_address', 'token='.$this->session->data['token'].'&sort=id.title'.$url, 'SSL' );
        $this->data['sort_sort_order'] = $this->url->link( 'catalog/setting_email_address', 'token='.$this->session->data['token'].'&sort=i.sort_order'.$url, 'SSL' );

        $url = '';

        if( isset( $this->request->get['sort'] ) )
        {
            $url .= '&sort='.$this->request->get['sort'];
        }

        if( isset( $this->request->get['order'] ) )
        {
            $url .= '&order='.$this->request->get['order'];
        }

        $pagination = new Pagination();
        $pagination->total = $email_address_total;
        $pagination->page = $page;
        $pagination->limit = $this->config->get( 'config_admin_limit' );
        $pagination->text = $this->language->get( 'text_pagination' );
        $pagination->url = $this->url->link( 'catalog/setting_email_address', 'token='.$this->session->data['token'].$url.'&page={page}', 'SSL' );

        $this->data['pagination'] = $pagination->render();

        $this->data['sort'] = $sort;
        $this->data['order'] = $order;

        $this->template = 'catalog/setting_email_address_list.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput( $this->render() );
    }

    protected function getForm()
    {
        $this->data['heading_title'] = $this->language->get( 'heading_title' );

        $this->data['text_default'] = $this->language->get( 'text_default' );
        $this->data['text_enabled'] = $this->language->get( 'text_enabled' );
        $this->data['text_disabled'] = $this->language->get( 'text_disabled' );

        $this->data['entry_name'] = $this->language->get( 'entry_name' );
        $this->data['entry_email'] = $this->language->get( 'entry_email' );
        
        $this->data['entry_sort_order'] = $this->language->get( 'entry_sort_order' );
        $this->data['entry_status'] = $this->language->get( 'entry_status' );

        $this->data['button_save'] = $this->language->get( 'button_save' );
        $this->data['button_cancel'] = $this->language->get( 'button_cancel' );

        if( isset( $this->error['warning'] ) )
        {
            $this->data['error_warning'] = $this->error['warning'];
        }
        else
        {
            $this->data['error_warning'] = '';
        }

        if( isset( $this->error['name'] ) )
        {
            $this->data['error_name'] = $this->error['name'];
        }
        else
        {
            $this->data['error_name'] = array( );
        }

        if( isset( $this->error['email'] ) )
        {
            $this->data['error_email'] = $this->error['email'];
        }
        else
        {
            $this->data['error_email'] = '';
        }

        $url = '';

        if( isset( $this->request->get['sort'] ) )
        {
            $url .= '&sort='.$this->request->get['sort'];
        }

        if( isset( $this->request->get['order'] ) )
        {
            $url .= '&order='.$this->request->get['order'];
        }

        if( isset( $this->request->get['page'] ) )
        {
            $url .= '&page='.$this->request->get['page'];
        }

        $this->data['breadcrumbs'] = array( );

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get( 'text_home' ),
            'href' => $this->url->link( 'common/home', 'token='.$this->session->data['token'], 'SSL' ),
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get( 'heading_title' ),
            'href' => $this->url->link( 'catalog/setting_email_address', 'token='.$this->session->data['token'].$url, 'SSL' ),
            'separator' => ' :: '
        );

        if( !isset( $this->request->get['email_id'] ) )
        {
            $this->data['action'] = $this->url->link( 'catalog/setting_email_address/insert', 'token='.$this->session->data['token'].$url, 'SSL' );
        }
        else
        {
            $this->data['action'] = $this->url->link( 'catalog/setting_email_address/update', 'token='.$this->session->data['token'].'&email_id='.$this->request->get['email_id'].$url, 'SSL' );
        }

        $this->data['cancel'] = $this->url->link( 'catalog/setting_email_address', 'token='.$this->session->data['token'].$url, 'SSL' );

        $this->data['token'] = $this->session->data['token'];

        $this->load->model( 'localisation/language' );

        $this->data['languages'] = $this->model_localisation_language->getLanguages();


        if( isset( $this->request->post['setting_email_address_description'] ) )
        {
            $this->data['setting_email_address_description'] = $this->request->post['setting_email_address_description'];
        }
        elseif( isset( $this->request->get['email_id'] ) )
        {
            $this->data['setting_email_address_description'] = $this->model_catalog_setting_email_address->getEmailAddressDescriptions( $this->request->get['email_id'] );
        }
        else
        {
            $this->data['setting_email_address_description'] = array( );
        }

        if( isset( $this->request->get['email_id'] ) && ($this->request->server['REQUEST_METHOD'] != 'POST') )
        {
            $email_address_info = $this->model_catalog_setting_email_address->getEmailInfo( $this->request->get['email_id'] );

//            $this->load->model( 'localisation/language' );
//            $languages = $this->model_localisation_language->getLanguages();
//            $current_language = $this->config->get( 'config_language' );
//            $current_document = $this->data['document_description'][$languages[$current_language]['language_id']]['document'];
//
//            $this->data['text_current_document'] = $this->language->get( 'text_current_document' );
//            $this->data['current_document'] = $current_document;
//            $this->data['href_current_document'] = DIR_DOCUMENT.$current_document;
        }



        if( isset( $this->request->post['status'] ) )
        {
            $this->data['status'] = $this->request->post['status'];
        }
        elseif( !empty( $email_address_info ) )
        {
            $this->data['status'] = $email_address_info['status'];
        }
        else
        {
            $this->data['status'] = 1;
        }

        if( isset( $this->request->post['sort_order'] ) )
        {
            $this->data['sort_order'] = $this->request->post['sort_order'];
        }
        elseif( !empty( $email_address_info ) )
        {
            $this->data['sort_order'] = $email_address_info['sort_order'];
        }
        else
        {
            $this->data['sort_order'] = '';
        }

        $this->template = 'catalog/setting_email_address_form.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput( $this->render() );
    }

    protected function validateForm( $type = '' )
    {
//        if( !$this->user->hasPermission( 'modify', 'catalog/useful_information' ) )
//        {
//            $this->error['warning'] = $this->language->get( 'error_permission' );
//        }

        foreach( $this->request->post['setting_email_address_description'] as $language_id => $value )
        {
            if( (utf8_strlen( $value['name'] ) < 3) || (utf8_strlen( $value['name'] ) > 50) )
            {
                $this->error['name'][$language_id] = $this->language->get( 'error_name' );
            }

            if( (utf8_strlen( $value['email'] ) > 96 ) || !preg_match( '/^[^\@]+@.*\.[a-z]{2,6}$/i', $value['email'] ) )
            {
                $this->error['email'][$language_id] = $this->language->get( 'error_email' );
            }
        }


        if( $this->error && !isset( $this->error['warning'] ) )
        {
                $this->error['warning'] = $this->language->get( 'error_warning' );
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

//    protected function validateDelete()
//    {
////        if( !$this->user->hasPermission( 'modify', 'catalog/information' ) )
////        {
////            $this->error['warning'] = $this->language->get( 'error_permission' );
////        }
//
//        $this->load->model( 'setting/store' );
//
//        foreach( $this->request->post['selected'] as $information_id )
//        {
//            if( $this->config->get( 'config_account_id' ) == $information_id )
//            {
//                $this->error['warning'] = $this->language->get( 'error_account' );
//            }
//
//            if( $this->config->get( 'config_checkout_id' ) == $information_id )
//            {
//                $this->error['warning'] = $this->language->get( 'error_checkout' );
//            }
//
//            if( $this->config->get( 'config_affiliate_id' ) == $information_id )
//            {
//                $this->error['warning'] = $this->language->get( 'error_affiliate' );
//            }
//
//            $store_total = $this->model_setting_store->getTotalStoresByDocumentId( $information_id );
//
//            if( $store_total )
//            {
//                $this->error['warning'] = sprintf( $this->language->get( 'error_store' ), $store_total );
//            }
//        }
//
//        if( !$this->error )
//        {
//            return true;
//        }
//        else
//        {
//            return false;
//        }
//    }
}

?>