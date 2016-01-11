<?php

class ControllerReclamationReclamation extends Controller
{

    private $error = array( );

    public function addReclamation()
    {        
        if( !$this->customer->isLogged() )
        {
            $this->session->data['redirect'] = $this->url->link( 'reclamation/reclamation/addreclamation', '', 'SSL' );
            $this->redirect( $this->url->link( 'account/login', '', 'SSL' ) );
        }

        $this->language->load( 'reclamation/reclamation' );
        $this->document->setTitle( $this->language->get( 'heading_title' ) );

        $this->load->model( 'reclamation/reclamation' );

        $post_max_size = $this->return_bytes( ini_get( 'post_max_size' ) );
        $upload_max_filesize = $this->return_bytes( ini_get( 'upload_max_filesize' ) );

        $id = 0;
        if( isset( $this->request->post['id'] ) )
        {
            $id = $this->request->post['id'];
        }

        //134217728 apr. 128M
        if( ($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate( $id ) )
        {
            $reclamation_id = $this->model_reclamation_reclamation->addReclamation( $this->request->post, $id );

            if( $this->request->files['attachment']['size'][0] == 0 )
            {
                $this->session->data['success'] = $this->language->get( 'text_add_success' );
            }
            else
            {
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
                    $this->session->data['success'] = $this->language->get( 'text_add_success' );
                }
                else
                {
                    $this->session->data['error'] = substr($error_file_name, 0, strlen($error_file_name)-2). $this->language->get( 'text_does_not_meet' ); // $this->language->get( 'error_upload' );
                }
                
                $this->model_reclamation_reclamation->updateReclamation( $reclamation_id, substr( $attachments, 0, strlen( $attachments ) - 1 ) );
            }

            //send mail for administrator
            $mail = new Mail();
            $mail->protocol = $this->config->get( 'config_mail_protocol' );
            $mail->parameter = $this->config->get( 'config_mail_parameter' );
            $mail->hostname = $this->config->get( 'config_smtp_host' );
            $mail->username = $this->config->get( 'config_smtp_username' );
            $mail->password = $this->config->get( 'config_smtp_password' );
            $mail->port = $this->config->get( 'config_smtp_port' );
            $mail->timeout = $this->config->get( 'config_smtp_timeout' );  
            
            $this->load->model('setting_email_address/setting_email_address');
            $email_address_info = $this->model_setting_email_address_setting_email_address->getEmailAddress( "RECLAMATII" ); // Reclamatii
            
            if ( isset( $email_address_info ) && !empty($email_address_info['email']) )
            { 
                $mail->setTo( $email_address_info['email'] );
            }
            else
            {
                $mail->setTo( $this->config->get( 'config_email' ) );
            }
            // $mail->admin_email = $this->config->get( 'config_email' );

            $mail->setFrom( $this->customer->getEmail() );
            $mail->setSender( $this->customer->getFirstName()." ".$this->customer->getLastName() );

            $subject = $this->language->get( 'text_notification_complaint_subject' );
            $message = $this->language->get( 'text_hello' );
            $message .= "<br><br>".$this->language->get( 'text_notification_complaint_message' );
                        
            $mail->setSubject( html_entity_decode( $subject, ENT_QUOTES, 'UTF-8' ) );
            $mail->setHtml( html_entity_decode( $message , ENT_QUOTES, 'UTF-8' ) );
            $mail->send();

            //$this->model_reclamation_reclamation->updateReclamation( $reclamation_id, substr( $attachments, 0, strlen( $attachments ) - 1 ) );
            $this->redirect( $this->url->link( 'account/account', '', 'SSL' ) );
        }
        else
        {
            if( !empty( $id ) )
            {
                $this->redirect( $this->url->link( 'reclamation/reclamation/editreclamation', 'id='.$id."&msg=".$this->error['description'], 'SSL' ) );
            }
        }

        $this->data['id'] = $id;

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
            'text' => $this->language->get( 'text_send_reclamation' ),
            'href' => $this->url->link( 'reclamation/reclamation/addreclamation', '', 'SSL' ),
            'separator' => $this->language->get( 'text_separator' )
        );

        if( isset( $this->session->data['success'] ) )
        {
            $this->data['success'] = $this->session->data['success'];

            unset( $this->session->data['success'] );
        }
        else
        {
            $this->data['success'] = '';
        }

        $this->data['heading_title'] = $this->language->get( 'heading_title' );
        $this->data['text_account'] = $this->language->get( 'text_account' );
        $this->data['text_add_reclamation'] = $this->language->get( 'text_add_reclamation' );
        $this->data['entry_status'] = $this->language->get( 'entry_status' );
        $this->data['entry_subject'] = $this->language->get( 'entry_subject' );
        $this->data['text_new'] = $this->language->get( 'text_new' );
        $this->data['text_in_progress'] = $this->language->get( 'text_in_progress' );
        $this->data['text_resolved'] = $this->language->get( 'text_resolved' );
        $this->data['text_allowed_extensions'] = $this->language->get( 'text_allowed_extensions' );        

        $this->data['entry_description'] = $this->language->get( 'entry_description' );
        $this->data['entry_documents'] = $this->language->get( 'entry_documents' );
        $this->data['text_send'] = $this->language->get( 'text_send' );
        $this->data['error_post_max_size'] = str_replace( '%1', ini_get( 'post_max_size' ), $this->language->get( 'error_post_max_size' ) );
        $this->data['error_upload_max_filesize'] = str_replace( '%1', ini_get( 'upload_max_filesize' ), $this->language->get( 'error_upload_max_filesize' ) );

        $this->data['post_max_size'] = $post_max_size;
        $this->data['upload_max_filesize'] = $upload_max_filesize;

        $this->data['text_add_another_one'] = $this->language->get( 'text_add_another_one' );
        $this->data['send_reclamation'] = $this->url->link( 'reclamation/reclamation/addreclamation', '', 'SSL' );


        if( isset( $this->error['warning'] ) )
        {
            $this->data['error_warning'] = $this->error['warning'];
        }
        else
        {
            $this->data['error_warning'] = '';
        }

        if( isset( $this->error['subject'] ) )
        {
            $this->data['error_subject'] = $this->error['subject'];
        }
        else
        {
            $this->data['error_subject'] = '';
        }

        if( isset( $this->error['description'] ) )
        {
            $this->data['error_description'] = $this->error['description'];
        }
        else
        {
            $this->data['error_description'] = '';
        }

        if( isset( $this->request->post['subject'] ) )
        {
            $this->data['subject'] = $this->request->post['subject'];
        }
        else
        {
            $this->data['subject'] = '';
        }

        if( isset( $this->request->post['description'] ) )
        {
            $this->data['description'] = $this->request->post['description'];
        }
        else
        {
            $this->data['description'] = '';
        }

        $this->data['add_another_one'] = $this->language->get( 'reclamation/reclamation' ); //text_add_another_one


        if( file_exists( DIR_TEMPLATE.$this->config->get( 'config_template' ).'/template/reclamation/add_reclamation.tpl' ) )
        {
            $this->template = $this->config->get( 'config_template' ).'/template/reclamation/add_reclamation.tpl';
        }
        else
        {
            $this->template = 'default/template/reclamation/add_reclamation.tpl';
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

    public function editReclamation()
    {
        if( !$this->customer->isLogged() )
        {
            $this->session->data['redirect'] = $this->url->link( 'reclamation/reclamation/listreclamation', '', 'SSL' );
            $this->redirect( $this->url->link( 'account/login', '', 'SSL' ) );
        }

        $this->language->load( 'reclamation/reclamation' );
        $this->document->setTitle( $this->language->get( 'heading_title' ) );

        $this->load->model( 'reclamation/reclamation' );

        $post_max_size = $this->return_bytes( ini_get( 'post_max_size' ) );
        $upload_max_filesize = $this->return_bytes( ini_get( 'upload_max_filesize' ) );

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


        if( $this->request->server['REQUEST_METHOD'] != 'POST' )
        {
            if( isset( $this->request->get['id'] ) )
            {
                $id = $this->request->get['id'];
            }
            else
            {
                $id = 0;
            }

            if( isset( $this->request->get['msg'] ) )
            {
                $msg = $this->request->get['msg'];
            }
            else
            {
                $msg = '';
            }

            $this->data['id'] = $id;
            $this->data['msg'] = $msg;
            $this->error['description'] = $msg;
            $this->load->model( 'reclamation/reclamation' );

            $reclamation_info = $this->model_reclamation_reclamation->getReclamationDetails( $id );    
            $this->data['histories'] = array();

            if ( !empty($reclamation_info) )
            {
                $this->data['recl_subject'] = $reclamation_info['subject'];
                $this->data['recl_number'] = $reclamation_info['number'];

                $this->data['recl_status'] = str_replace( "_", " ", $reclamation_info['status'] ); //$reclamation_info['status']    
                $this->data['status'] = $reclamation_info['status'];
                $this->data['recl_insert_date'] = $reclamation_info['insert_date'];
                $this->data['id_parent'] = $reclamation_info['id_parent'];
                
                $reclamation_history = $this->model_reclamation_reclamation->getReclamationHistory( $reclamation_info['id_parent'] ); // $id

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
                        'status' => str_replace( "_", " ", $history['status'] ),
                    );
                }

                $this->data['recl_description'] = $reclamation_info['description'];
                $this->data['documents'] = $documents;
            }
            //$this->data['recl_status'] = $reclamation_info['status'];
        }

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get( 'text_history' ),
            'href' => $this->url->link( 'reclamation/reclamation/editreclamation', 'id='.$id, 'SSL' ),
            'separator' => $this->language->get( 'text_separator' )
        );

        if( isset( $this->session->data['success'] ) )
        {
            $this->data['success'] = $this->session->data['success'];

            unset( $this->session->data['success'] );
        }
        else
        {
            $this->data['success'] = '';
        }

        $this->data['heading_title'] = $this->language->get( 'heading_title' );
        $this->data['text_account'] = $this->language->get( 'text_account' );
        $this->data['text_history'] = $this->language->get( 'text_history' );
        $this->data['text_no_document'] = $this->language->get( 'text_no_document' );

        $this->data['entry_subject'] = $this->language->get( 'entry_subject' );
        $this->data['entry_number'] = $this->language->get( 'entry_number' );
        $this->data['entry_description'] = $this->language->get( 'entry_description' );
        $this->data['entry_documents'] = $this->language->get( 'entry_documents' );
        $this->data['text_history'] = $this->language->get( 'text_history' );
        $this->data['entry_status'] = $this->language->get( 'entry_status' );
        $this->data['text_reply'] = $this->language->get( 'text_reply' );
        $this->data['text_cancel'] = $this->language->get( 'text_cancel' );
        $this->data['entry_status'] = $this->language->get( 'entry_status' );
        $this->data['text_new'] = $this->language->get( 'text_new' );
        $this->data['text_in_progress'] = $this->language->get( 'text_in_progress' );
        $this->data['text_resolved'] = $this->language->get( 'text_resolved' );
        $this->data['text_allowed_extensions'] = $this->language->get( 'text_allowed_extensions' );   
        
        $this->data['text_insert_date'] = $this->language->get( 'text_insert_date' );

        $this->data['text_attached_documents'] = $this->language->get( 'text_attached_documents' );
        $this->data['text_send'] = $this->language->get( 'text_send' );
        $this->data['error_post_max_size'] = str_replace( '%1', ini_get( 'post_max_size' ), $this->language->get( 'error_post_max_size' ) );
        $this->data['error_upload_max_filesize'] = str_replace( '%1', ini_get( 'upload_max_filesize' ), $this->language->get( 'error_upload_max_filesize' ) );
        $this->data['post_max_size'] = $post_max_size;
        $this->data['upload_max_filesize'] = $upload_max_filesize;

        $this->data['text_add_another_one'] = $this->language->get( 'text_add_another_one' );
        $this->data['send_reclamation'] = $this->url->link( 'reclamation/reclamation/addreclamation', '', 'SSL' );

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


        if( isset( $this->request->post['description'] ) )
        {
            $this->data['description'] = $this->request->post['description'];
        }
        else
        {
            $this->data['description'] = '';
        }

        if( file_exists( DIR_TEMPLATE.$this->config->get( 'config_template' ).'/template/reclamation/view_reclamation.tpl' ) )
        {
            $this->template = $this->config->get( 'config_template' ).'/template/reclamation/view_reclamation.tpl';
        }
        else
        {
            $this->template = 'default/template/reclamation/view_reclamation.tpl';
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

    protected function validate( $idreclamation )
    {
        if( $idreclamation == 0 )
        {
            if( (utf8_strlen( $this->request->post['subject'] ) < 1) || (utf8_strlen( $this->request->post['subject'] ) > 100) )
            {
                $this->error['subject'] = $this->language->get( 'error_subject' );
            }
        }

        if( (utf8_strlen( $this->request->post['description'] ) < 1 ) ) //|| (!preg_match( '/^[a-zA-Z0-9]+$/', $this->request->post['message'] ))
        {
            $this->error['description'] = $this->language->get( 'error_description' );
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

    public function listReclamation()
    {
        if( !$this->customer->isLogged() )
        {
            $this->session->data['redirect'] = $this->url->link( 'reclamation/reclamation/listreclamation', '', 'SSL' );
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

        $this->language->load( 'reclamation/reclamation' );
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
            'text' => $this->language->get( 'text_list_reclamation' ),
            'href' => $this->url->link( 'reclamation/reclamation/listreclamation', $url, 'SSL' ),
            'separator' => $this->language->get( 'text_separator' )
        );

        $this->data['heading_title'] = $this->language->get( 'heading_title' );
        $this->data['entry_subject'] = $this->language->get( 'entry_subject' );

        $this->data['entry_subject'] = $this->language->get( 'entry_subject' );
        $this->data['text_insert_date'] = $this->language->get( 'text_insert_date' );
        $this->data['entry_status'] = $this->language->get( 'entry_status' );
        $this->data['text_edit'] = $this->language->get( 'text_edit' );
        $this->data['text_delete'] = $this->language->get( 'text_delete' );
        $this->data['text_empty'] = $this->language->get( 'text_empty' );
        $this->data['text_are_you_sure'] = $this->language->get( 'text_are_you_sure' );

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

        $this->data['reclamations'] = array( );

        $this->load->model( 'reclamation/reclamation' );
        $reclamation_total = $this->model_reclamation_reclamation->getTotalReclamations( $this->customer->getId() );
        $results = $this->model_reclamation_reclamation->getReclamations( ($page - 1) * 10, 10, $this->customer->getId() );

        foreach( $results as $key => $value )
        {
            $recl_info = $this->model_reclamation_reclamation->getReclamationDetails( $value['id'] );

            $edit_href = $this->url->link( 'reclamation/reclamation/editreclamation', 'id='.$value['id'], 'SSL' );
            $delete_href = $this->url->link( 'reclamation/reclamation/deletereclamation', 'id='.$value['id'], 'SSL' );

            $this->data['reclamations'][] = array(
                'reclamation_id' => $value['id'],
                'subject' => $recl_info['subject'],
                'insert_date' => date( $this->language->get( 'date_format_short' ), strtotime( $recl_info['insert_date'] ) ),
                'status' => str_replace( "_", " ", $recl_info['status'] ),
                'edit_href' => $edit_href,
                'delete_href' => $delete_href,
            );
        }

        $pagination = new Pagination();
        $pagination->total = $reclamation_total;
        $pagination->page = $page;
        $pagination->limit = 10;
        $pagination->text = $this->language->get( 'text_pagination' );
        $pagination->url = $this->url->link( 'reclamation/reclamation/listreclamation', 'page={page}', 'SSL' );

        $this->data['pagination'] = $pagination->render();
        $this->data['continue'] = $this->url->link( 'account/account', '', 'SSL' );

        if( file_exists( DIR_TEMPLATE.$this->config->get( 'config_template' ).'/template/reclamation/list_reclamation.tpl' ) )
        {
            $this->template = $this->config->get( 'config_template' ).'/template/reclamation/list_reclamation.tpl';
        }
        else
        {
            $this->template = 'default/template/account/list_reclamation.tpl';
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

    public function deleteReclamation()
    {
        $this->language->load( 'reclamation/reclamation' );
        $this->document->setTitle( $this->language->get( 'heading_title' ) );
        $this->load->model( 'reclamation/reclamation' );

        if( isset( $this->request->get['id'] ) )
        {
            $reclamation_info = $this->model_reclamation_reclamation->getReclamationDetails( $this->request->get['id'] );
            $reclamation_ids = $this->model_reclamation_reclamation->getIdsWithSameIdParent( $reclamation_info['id_parent'] );

            foreach( $reclamation_ids as $reclamation_id )
            {
                //print "value=".$reclamation_id['idreclamation']."<br>";
                $this->model_reclamation_reclamation->deleteReclamation( $reclamation_id['idreclamation'] );
            }

            $this->session->data['success'] = $this->language->get( 'text_delete_success' );
            $this->redirect( $this->url->link( 'reclamation/reclamation/listreclamation', '', 'SSL' ) );
        }

//        if( isset( $this->request->get['id'] ) )
//        {
//            $this->model_reclamation_reclamation->deleteReclamation( $this->request->get['id'] );
//            $this->session->data['success'] = $this->language->get( 'text_delete_success' );
//            $this->redirect( $this->url->link( 'reclamation/reclamation/listreclamation', '', 'SSL' ) );
//        }
    }

}

?>