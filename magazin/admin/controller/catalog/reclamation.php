<?php

class ControllerCatalogReclamation extends Controller
{

    private $error = array( );

    public function index()
    {
        $this->language->load( 'catalog/reclamation' );

        $this->document->setTitle( $this->language->get( 'heading_title' ) );

        $this->load->model( 'catalog/reclamation' );

        $this->getList();
    }

    public function update()
    {
        $this->language->load( 'catalog/reclamation' );

        $this->document->setTitle( $this->language->get( 'heading_title' ) );

        $this->load->model( 'catalog/reclamation' );

        if( isset( $this->request->get['id'] ) )
        {
            $id = $this->request->get['id'];
        }
        else
        {
            $id = 0;
        }
        
        if( isset( $this->session->data['msg'] ) )
        {
            $msg = $this->session->data['msg'];
            //print_r( $this->session->data['msg'] );
            
            $this->error['description'] = $this->session->data['msg']['description'];
            if ( isset ($this->session->data['msg']['number']) )
            {
                $this->error['number'] = $this->session->data['msg']['number'];
            }

            unset( $this->session->data['msg'] );
        }
        else
        {
            $msg = '';
        }

        $this->data['id'] = $id;
        $this->data['msg'] = $msg;

        $reclamation_info = $this->model_catalog_reclamation->getReclamationDetails( $id );
        $reclamation_history = $this->model_catalog_reclamation->getReclamationHistory( $reclamation_info['id_parent'] ); // $id

        $this->data['recl_subject'] = $reclamation_info['subject'];
        $this->data['recl_number'] = $reclamation_info['number'];
        $this->data['recl_insert_date'] = $reclamation_info['insert_date'];
        $this->data['id_parent'] = $reclamation_info['id_parent'];

        foreach( $reclamation_history as $history )
        {
            $documents = '';
            if( !empty( $history['attachment'] ) )
            {
                $attachment_exp = explode( "#", $history['attachment'] );
                foreach( $attachment_exp as $attachment )
                {
                    $documents .= "<a href='".HTTP_SERVER."reclamation/".$attachment."' target='_blank'>".HTTP_SERVER."reclamation/".$attachment."</a><br>";
                }
            }

            $this->data['histories'][] = array(
                'idreclamation' => $history['idreclamation'],
                'customer_id' => $history['customer_id'],
                'number' => $history['number'],
                'subject' => $history['subject'],
                'description' => $history['description'],
                'attachment' => $documents,
                'insert_date' => $history['insert_date'],
            );
        }

        $this->data['recl_description'] = $reclamation_info['description'];
        $this->data['recl_status'] = str_replace( "_", " ", $reclamation_info['status'] );
        $this->data['status'] = $reclamation_info['status'];
        $this->data['documents'] = $documents;

        if( ($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm() )
        {
            $reclamation_id = $this->model_catalog_reclamation->addReclamation( $this->request->post, $this->request->post['id'] );

            if( $this->request->files['attachment']['size'][0] == 0 )
            {
                $this->session->data['success'] = $this->language->get( 'text_mod_success' );
            }
            else
            {
                $post_max_size = $this->return_bytes( ini_get( 'post_max_size' ) );
                $upload_max_filesize = $this->return_bytes( ini_get( 'upload_max_filesize' ) );

                $allowedExts = array( "doc", "xls", "xlsx", "pdf", "jpg", "png" );
                $attachments = '';
                $error_nr = 0;
                $error_file_name = $this->language->get( 'text_file' );
                foreach( $this->request->files['attachment']['error'] as $key => $error )
                {
                    $temp = explode( ".", $this->request->files['attachment']['name'][$key] );
                    $extension = end( $temp );

                    if( $error == 0 && ($this->request->files["attachment"]["size"][$key] < $upload_max_filesize) && in_array( $extension, $allowedExts ) )
                    {
                        $tmp_name = $this->request->files['attachment']['tmp_name'][$key];
                        $this->request->post['img'] = $reclamation_id."_".$this->request->files['attachment']['name'][$key];
                        $attachments .= $this->request->post['img']."#";

                        move_uploaded_file( $tmp_name, DIR_RECLAMATION.$this->request->post['img'] );
                    }
                    else
                    {
                        $error_nr++;
                        $error_file_name .= $this->request->files['attachment']['name'][$key]. ", ";
                    }
                }

                if( $error_nr == 0 )
                {
                    $this->session->data['success'] = $this->language->get( 'text_mod_success' );
                }
                else
                {
                    $this->session->data['error'] = substr($error_file_name, 0, strlen($error_file_name)-2). $this->language->get( 'text_does_not_meet' ); // $this->language->get( 'error_upload' );
                }
                
                $this->model_catalog_reclamation->updateReclamation( $reclamation_id, substr( $attachments, 0, strlen( $attachments ) - 1 ) );
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

            //send mail for client
            $mail = new Mail();
            $mail->protocol = $this->config->get( 'config_mail_protocol' );
            $mail->parameter = $this->config->get( 'config_mail_parameter' );
            $mail->hostname = $this->config->get( 'config_smtp_host' );
            $mail->username = $this->config->get( 'config_smtp_username' );
            $mail->password = $this->config->get( 'config_smtp_password' );
            $mail->port = $this->config->get( 'config_smtp_port' );
            $mail->timeout = $this->config->get( 'config_smtp_timeout' );

            // $mail->admin_email = $this->config->get( 'config_email' );
            $parent_reclamation = $this->model_catalog_reclamation->getReclamationDetails( $reclamation_id );
            $id_parent = $parent_reclamation['id_parent'];

            $first_reclamation = $this->model_catalog_reclamation->getReclamationDetails( $id_parent );

            $this->load->model( 'sale/customer' );
            $customer_info = $this->model_sale_customer->getCustomer( $first_reclamation['customer_id'] );

            $mail->setTo( $customer_info['email'] );
            $mail->setFrom( $this->config->get( 'config_email' ) );
            $mail->setSender( $this->config->get( 'config_name' ) );

            $subject = $this->language->get( 'text_notification_complaint_subject' );
            $message = $this->language->get( 'text_hello' );
            $message .= "<br><br>".$this->language->get( 'text_notification_complaint_message' );

            $mail->setSubject( html_entity_decode( $subject, ENT_QUOTES, 'UTF-8' ) );
            $mail->setHtml( html_entity_decode( $message, ENT_QUOTES, 'UTF-8' ) );
            $mail->send();


            $this->redirect( $this->url->link( 'catalog/reclamation/', 'token='.$this->session->data['token'].$url, 'SSL' ) );
        }
        else if( $this->request->server['REQUEST_METHOD'] == 'POST' && !$this->validateForm() )
        {
            $this->session->data['msg'] = $this->error;
            // $this->redirect( $this->url->link( 'catalog/reclamation/update', 'token='.$this->session->data['token'].'&id='.$this->request->post['id']."&msg=".$msg.$url, 'SSL' ) ); // $this->error['description']
            $this->redirect( $this->url->link( 'catalog/reclamation/update', 'token='.$this->session->data['token'].'&id='.$this->request->post['id'], 'SSL' ) ); // $this->error['description']
        }


        $this->getForm();
    }

    public function delete()
    {
        $this->language->load( 'catalog/reclamation' );

        $this->document->setTitle( $this->language->get( 'heading_title' ) );

        $this->load->model( 'catalog/reclamation' );

        if( isset( $this->request->post['selected'] ) )// && $this->validateDelete()
        {
            foreach( $this->request->post['selected'] as $reclamation_id )
            {
                $this->model_catalog_reclamation->deleteReclamation( $reclamation_id );
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

            $this->redirect( $this->url->link( 'catalog/reclamation', 'token='.$this->session->data['token'].$url, 'SSL' ) );
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
            $sort = 'recl.insert_date';
        }

        if( isset( $this->request->get['order'] ) )
        {
            $order = $this->request->get['order'];
        }
        else
        {
            $order = 'DESC';
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
            'href' => $this->url->link( 'catalog/reclamation', 'token='.$this->session->data['token'].$url, 'SSL' ),
            'separator' => ' :: '
        );

        //$this->data['insert'] = $this->url->link( 'catalog/reclamation/insert', 'token='.$this->session->data['token'].$url, 'SSL' );
        $this->data['delete'] = $this->url->link( 'catalog/reclamation/delete', 'token='.$this->session->data['token'].$url, 'SSL' );

        $this->data['reclamations'] = array( );

        $data = array(
            'sort' => $sort,
            'order' => $order,
            'start' => ($page - 1) * $this->config->get( 'config_admin_limit' ),
            'limit' => $this->config->get( 'config_admin_limit' )
        );

        $reclamation_total = $this->model_catalog_reclamation->getTotalReclamations();
        $results = $this->model_catalog_reclamation->getReclamations( $data );

        foreach( $results as $result )
        {
            $action = array( );
            $action[] = array(
                'text' => $this->language->get( 'text_edit' ),
                'href' => $this->url->link( 'catalog/reclamation/update', 'token='.$this->session->data['token'].'&id='.$result['id'].$url, 'SSL' )
            );

            $recl_info = $this->model_catalog_reclamation->getReclamationDetails( $result['id'] );

            $this->data['reclamations'][] = array(
                'reclamation_id' => $recl_info['idreclamation'],
                'name' => $recl_info['subject'],
                'insert_date' => date( $this->language->get( 'date_format_short' ), strtotime( $recl_info['insert_date'] ) ),
                'status' => str_replace( "_", " ", $recl_info['status'] ),
                'selected' => isset( $this->request->post['selected'] ) && in_array( $result['id'], $this->request->post['selected'] ),
                'action' => $action
            );
        }

        $this->data['heading_title'] = $this->language->get( 'heading_title' );
        $this->data['text_no_results'] = $this->language->get( 'text_no_results' );

        $this->data['column_title'] = $this->language->get( 'column_title' );
        $this->data['column_date'] = $this->language->get( 'column_date' );
        $this->data['column_status'] = $this->language->get( 'column_status' );
        $this->data['column_action'] = $this->language->get( 'column_action' );

        $this->data['button_insert'] = $this->language->get( 'button_insert' );
        $this->data['button_delete'] = $this->language->get( 'button_delete' );

        if( isset( $this->session->data['success'] ) )
        {
            $this->data['success'] = $this->session->data['success'];
            unset( $this->session->data['success'] );
        }
        else
        {
            $this->data['success'] = '';
        }


        if( isset( $this->session->data['error'] ) )
        {
            $this->data['error_warning'] = $this->session->data['error'];
            unset( $this->session->data['error'] );
        }
        elseif( isset( $this->error['warning'] ) )
        {
            $this->data['error_warning'] = $this->error['warning'];
        }
        else
        {
            $this->data['error_warning'] = '';
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

        $this->data['sort_title'] = $this->url->link( 'catalog/reclamation', 'token='.$this->session->data['token'].'&sort=recl.subject'.$url, 'SSL' );
        $this->data['sort_insert_date'] = $this->url->link( 'catalog/reclamation', 'token='.$this->session->data['token'].'&sort=recl.insert_date'.$url, 'SSL' );
        $this->data['sort_status'] = $this->url->link( 'catalog/reclamation', 'token='.$this->session->data['token'].'&sort=recl.status'.$url, 'SSL' );

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
        $pagination->total = $reclamation_total;
        $pagination->page = $page;
        $pagination->limit = $this->config->get( 'config_admin_limit' );
        $pagination->text = $this->language->get( 'text_pagination' );
        $pagination->url = $this->url->link( 'catalog/reclamation', 'token='.$this->session->data['token'].$url.'&page={page}', 'SSL' );

        $this->data['pagination'] = $pagination->render();

        $this->data['sort'] = $sort;
        $this->data['order'] = $order;

        $this->template = 'catalog/reclamation_list.tpl';
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

        $this->data['column_title'] = $this->language->get( 'column_title' );
        $this->data['text_insert_date'] = $this->language->get( 'text_insert_date' );
        $this->data['text_status'] = $this->language->get( 'text_status' );
        $this->data['text_new'] = $this->language->get( 'text_new' );
        $this->data['text_in_progress'] = $this->language->get( 'text_in_progress' );
        $this->data['text_resolved'] = $this->language->get( 'text_resolved' );
        $this->data['text_send'] = $this->language->get( 'text_send' );
        $this->data['entry_description'] = $this->language->get( 'entry_description' );
        $this->data['entry_number'] = $this->language->get( 'entry_number' );
        $this->data['entry_documents'] = $this->language->get( 'entry_documents' );
        $this->data['text_add_another_one'] = $this->language->get( 'text_add_another_one' );
        $this->data['text_allowed_extensions'] = $this->language->get( 'text_allowed_extensions' );
        $this->data['text_no_document'] = $this->language->get( 'text_no_document' );
        

        $this->data['text_attached_documents'] = $this->language->get( 'text_attached_documents' );
        $this->data['text_reply'] = $this->language->get( 'text_reply' );
        $this->data['text_cancel'] = $this->language->get( 'text_cancel' );

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

        if( isset( $this->error['description'] ) )
        {
            $this->data['error_description'] = $this->error['description'];
        }
        else
        {
            $this->data['error_description'] = '';
        }

        if( isset( $this->error['number'] ) )
        {
            $this->data['error_number'] = $this->error['number'];
        }
        else
        {
            $this->data['error_number'] = '';
        }


        if( isset( $this->request->post['description'] ) )
        {
            $this->data['description'] = $this->request->post['description'];
        }
        else
        {
            $this->data['description'] = '';
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
            'href' => $this->url->link( 'catalog/reclamation', 'token='.$this->session->data['token'].$url, 'SSL' ),
            'separator' => ' :: '
        );

//        if( !isset( $this->request->get['id'] ) )
//        {
//            $this->data['action'] = $this->url->link( 'catalog/reclamation/insert', 'token='.$this->session->data['token'].$url, 'SSL' );
//        }
//        else
//        {
        $this->data['action'] = $this->url->link( 'catalog/reclamation/update', 'token='.$this->session->data['token'].'&id='.$this->request->get['id'].$url, 'SSL' );
//        }
        $this->data['cancel'] = $this->url->link( 'catalog/reclamation', 'token='.$this->session->data['token'].$url, 'SSL' );


        if( isset( $this->request->get['id'] ) && ($this->request->server['REQUEST_METHOD'] != 'POST') )
        {
            $reclamation_info = $this->model_catalog_reclamation->getReclamationDetails( $this->request->get['id'] );
            
            $recl_id_parent = $reclamation_info['id_parent'];
            $recl_number = $this->model_catalog_reclamation->getReclamationNumber( $recl_id_parent );
        }
        
        if( isset( $this->request->post['number'] ) )
        {
            $this->data['number'] = $this->request->post['number'];
            $this->data['attribute'] = '';
        }
        else if ( !empty( $recl_number ) )
        {
            $this->data['number'] = $recl_number;
            $this->data['attribute'] = '';// disabled';
        }
        else
        {
            $this->data['number'] = '';
            $this->data['attribute'] = '';
        }
        
        $this->data['token'] = $this->session->data['token'];

        if( isset( $this->request->post['status'] ) )
        {
            $this->data['status'] = $this->request->post['status'];
        }
        elseif( !empty( $reclamation_info ) )
        {
            $this->data['status'] = $reclamation_info['status'];
        }
        else
        {
            $this->data['status'] = 1;
        }
                
        $this->template = 'catalog/reclamation_form.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput( $this->render() );
    }

    protected function validateForm()
    {
//        if( !$this->user->hasPermission( 'modify', 'catalog/useful_information' ) )
//        {
//            $this->error['warning'] = $this->language->get( 'error_permission' );
//        }

        if( utf8_strlen( $this->request->post['description'] ) < 1 )
        {
            $this->error['description'] = $this->language->get( 'error_description' );
        }

        if( utf8_strlen( $this->request->post['number'] ) < 1 ) // || (!preg_match( '/^[0-9]+$/', $this->request->post['number'] )) 
        {
            $this->error['number'] = $this->language->get( 'error_number' );
        }
        
//          if( $_SERVER['REMOTE_ADDR'] == '188.26.23.46' )
//          {
//            print_r( $this->request->post ) ; die();
//          }

        if( !$this->error )
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /*  protected function validateDelete()
      {
      //        if( !$this->user->hasPermission( 'modify', 'catalog/information' ) )
      //        {
      //            $this->error['warning'] = $this->language->get( 'error_permission' );
      //        }

      $this->load->model( 'setting/store' );

      foreach( $this->request->post['selected'] as $information_id )
      {
      if( $this->config->get( 'config_account_id' ) == $information_id )
      {
      $this->error['warning'] = $this->language->get( 'error_account' );
      }

      if( $this->config->get( 'config_checkout_id' ) == $information_id )
      {
      $this->error['warning'] = $this->language->get( 'error_checkout' );
      }

      if( $this->config->get( 'config_affiliate_id' ) == $information_id )
      {
      $this->error['warning'] = $this->language->get( 'error_affiliate' );
      }

      $store_total = $this->model_setting_store->getTotalStoresByDocumentId( $information_id );

      if( $store_total )
      {
      $this->error['warning'] = sprintf( $this->language->get( 'error_store' ), $store_total );
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
      } */

    function return_bytes( $val )
    {
        $val = trim( $val );

        switch( strtolower( substr( $val, -1 ) ) )
        {
            case 'm': $val = ( int ) substr( $val, 0, -1 ) * 1048576;
                break;
            case 'k': $val = ( int ) substr( $val, 0, -1 ) * 1024;
                break;
            case 'g': $val = ( int ) substr( $val, 0, -1 ) * 1073741824;
                break;
            case 'b':
                switch( strtolower( substr( $val, -2, 1 ) ) )
                {
                    case 'm': $val = ( int ) substr( $val, 0, -2 ) * 1048576;
                        break;
                    case 'k': $val = ( int ) substr( $val, 0, -2 ) * 1024;
                        break;
                    case 'g': $val = ( int ) substr( $val, 0, -2 ) * 1073741824;
                        break;
                    default : break;
                } break;
            default: break;
        }
        return $val;
    }

}

?>