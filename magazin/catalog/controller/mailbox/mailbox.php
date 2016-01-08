<?php

class ControllerMailboxMailbox extends Controller
{
    private $error = array( );

    public function index()
    {
        if( !$this->customer->isLogged() )
        {
            $this->session->data['redirect'] = $this->url->link( 'mailbox/mailbox', '', 'SSL' );

            $this->redirect( $this->url->link( 'account/login', '', 'SSL' ) );
        }

        $this->language->load( 'mailbox/mailbox' );
        $this->document->setTitle( $this->language->get( 'heading_title' ) );

        $this->load->model( 'mailbox/mailbox' );
 
        $post_max_size = $this->return_bytes( ini_get( 'post_max_size' ) );
        $upload_max_filesize = $this->return_bytes( ini_get( 'upload_max_filesize' ) );

        //134217728 apr. 128M
        if( ($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate() )
        {
            $mail_id = $this->model_mailbox_mailbox->addEmailDetails( $this->request->post ); // $this->request->files['attachment']

			$attachments = '';
            if( $this->request->files['attachment']['size'][0] == 0 )
            {
                $this->session->data['success'] = $this->language->get( 'text_success' );
            }
            else
            {
                $allowedExts = array( "doc", "docx", "xls", "xlsx", "csv", "pdf", "jpg","png" );
                
                $error_nr = 0;
                $error_file_name = $this->language->get( 'text_file' );
                
                foreach( $this->request->files['attachment']['error'] as $key => $error )
                {
                    $temp = explode( ".", $this->request->files['attachment']['name'][$key] );
                    $extension = end( $temp );
                                        
                    if( $error == 0 && ($this->request->files["attachment"]["size"][$key] < $upload_max_filesize) && in_array( $extension, $allowedExts )  )
                    {
                        $tmp_name = $this->request->files['attachment']['tmp_name'][$key];
                        $this->request->post['img'] = $mail_id."_".$this->request->files['attachment']['name'][$key];
                        $attachments .= $this->request->post['img']."#";

                        move_uploaded_file( $tmp_name, DIR_MAIL_ATTACHMENT.$this->request->post['img'] );                        
                    }
                    else
                    {
                        $error_nr++;
                        $error_file_name .= $this->request->files['attachment']['name'][$key]. ", ";
                    }
                }
                
                if( $error_nr == 0 )
                {
                    $this->session->data['success'] = $this->language->get( 'text_success' );
                }
                else
                {
                    $this->session->data['error'] = substr($error_file_name, 0, strlen($error_file_name)-2). $this->language->get( 'text_does_not_meet' ); // $this->language->get( 'error_upload' );
                }
            }
  

            $this->model_mailbox_mailbox->updateEmailDetails( $mail_id, substr( $attachments, 0, strlen( $attachments ) - 1 ) );
            // send email with attachments
            $this->model_mailbox_mailbox->sendMail( $mail_id );


            $this->redirect( $this->url->link( 'account/account', '', 'SSL' ) );
        }

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
            'text' => $this->language->get( 'text_send_mail' ),
            'href' => $this->url->link( 'mailbox/mailbox', '', 'SSL' ),
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
        $this->data['text_send_mail'] = $this->language->get( 'text_send_mail' );

        $this->data['entry_name'] = $this->language->get( 'entry_name' );
        $this->data['entry_email'] = $this->language->get( 'entry_email' );
        $this->data['entry_message'] = $this->language->get( 'entry_message' );
        $this->data['entry_attachments'] = $this->language->get( 'entry_attachments' );
        $this->data['text_send'] = $this->language->get( 'text_send' );
        $this->data['error_post_max_size'] = str_replace( '%1', ini_get( 'post_max_size' ), $this->language->get( 'error_post_max_size' ) );
        $this->data['error_upload_max_filesize'] = str_replace( '%1', ini_get( 'upload_max_filesize' ), $this->language->get( 'error_upload_max_filesize' ) );
        $this->data['text_allowed_extensions'] = $this->language->get( 'text_allowed_extensions' );

        $this->data['post_max_size'] = $post_max_size;
        $this->data['upload_max_filesize'] = $upload_max_filesize;

        $this->data['text_add_another_one'] = $this->language->get( 'text_add_another_one' );
        $this->data['send_message'] = $this->url->link( 'mailbox/mailbox', '', 'SSL' );


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
            $this->data['error_name'] = '';
        }

        if( isset( $this->error['email'] ) )
        {
            $this->data['error_email'] = $this->error['email'];
        }
        else
        {
            $this->data['error_email'] = '';
        }

        if( isset( $this->error['message'] ) )
        {
            $this->data['error_message'] = $this->error['message'];
        }
        else
        {
            $this->data['error_message'] = '';
        }

        if( $this->request->server['REQUEST_METHOD'] != 'POST' )
        {
            $this->load->model( 'account/customer' );
            $customer_info = $this->model_account_customer->getCustomer( $this->customer->getId() );
        }

        if( isset( $this->request->post['name'] ) )
        {
            $this->data['name'] = $this->request->post['name'];
        }
        elseif( isset( $customer_info ) )
        {
            $this->data['name'] = $customer_info['firstname']." ".$customer_info['lastname'];
        }
        else
        {
            $this->data['name'] = '';
        }


        if( isset( $this->request->post['email'] ) )
        {
            $this->data['email'] = $this->request->post['email'];
        }
        elseif( isset( $customer_info ) )
        {
            $this->data['email'] = $customer_info['email'];
        }
        else
        {
            $this->data['email'] = '';
        }

        if( isset( $this->request->post['message'] ) )
        {
            $this->data['message'] = $this->request->post['message'];
        }
        else
        {
            $this->data['message'] = '';
        }

        $this->data['add_another_one'] = $this->language->get( 'mailbox/mailbox' );


        if( file_exists( DIR_TEMPLATE.$this->config->get( 'config_template' ).'/template/mailbox/mailbox.tpl' ) )
        {
            $this->template = $this->config->get( 'config_template' ).'/template/mailbox/mailbox.tpl';
        }
        else
        {
            $this->template = 'default/template/mailbox/mailbox.tpl';
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

    protected function validate()
    {
        if( (utf8_strlen( $this->request->post['name'] ) < 1) || (utf8_strlen( $this->request->post['name'] ) > 32) )
        {
            $this->error['name'] = $this->language->get( 'error_name' );
        }

        if( (utf8_strlen( $this->request->post['email'] ) < 1 ) || !preg_match( '/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['email'] ) )
        {
            $this->error['email'] = $this->language->get( 'error_email' );
        }

        if( (utf8_strlen( $this->request->post['message'] ) < 1 ) ) //|| (!preg_match( '/^[a-zA-Z0-9]+$/', $this->request->post['message'] ))
        {
            $this->error['message'] = $this->language->get( 'error_message' );
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

}

?>