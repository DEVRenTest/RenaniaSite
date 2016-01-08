<?php

class ControllerDocumentDocument extends Controller
{

    private $error = array( );

    /*public function index()
    {
        if( !$this->customer->isLogged() )
        {
            $this->session->data['redirect'] = $this->url->link( 'document/document', '', 'SSL' );
            $this->redirect( $this->url->link( 'account/login', '', 'SSL' ) );
        }

        $this->language->load( 'document/document' );
        $this->document->setTitle( $this->language->get( 'heading_title' ) );

        $this->load->model( 'document/document' );

        $post_max_size = $this->return_bytes( ini_get( 'post_max_size' ) );
        $upload_max_filesize = $this->return_bytes( ini_get( 'upload_max_filesize' ) );

        //134217728 apr. 128M
        if( ($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate() )
        {
            $allowedExts = array( "pdf" );
            foreach( $this->request->files['document']['error'] as $key => $error )
            {
                $document_id = $this->model_document_document->addDocument( $this->request->post['name'][$key] );
                
                $temp = explode( ".", $this->request->files['document']['name'][$key] );
                $extension = end( $temp );

                if( $error == 0 && ($this->request->files["document"]["size"][$key] < $upload_max_filesize) && in_array( $extension, $allowedExts ) )
                {
                    $tmp_name = $this->request->files['document']['tmp_name'][$key];
                    $this->request->post['img'] = $document_id."_".$this->request->files['document']['name'][$key];

                    move_uploaded_file( $tmp_name, DIR_DOCUMENT.$this->request->post['img'] );
                    $this->session->data['success'] = $this->language->get( 'text_success' );
                }
                else
                {
                    $this->session->data['error'] = $this->language->get( 'error_upload' );
                }
                $this->model_document_document->updateDocumentDetails( $document_id, $this->request->post['img'] );
            }

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
            'text' => $this->language->get( 'text_useful_documents' ),
            'href' => $this->url->link( 'document/document', '', 'SSL' ),
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
        $this->data['text_useful_documents'] = $this->language->get( 'text_useful_documents' );
        $this->data['text_document'] = $this->language->get( 'text_document' );

        $this->data['entry_name'] = $this->language->get( 'entry_name' );
        $this->data['text_send'] = $this->language->get( 'text_send' );
        $this->data['error_post_max_size'] = str_replace( '%1', ini_get( 'post_max_size' ), $this->language->get( 'error_post_max_size' ) );
        $this->data['error_upload_max_filesize'] = str_replace( '%1', ini_get( 'upload_max_filesize' ), $this->language->get( 'error_upload_max_filesize' ) );

        $this->data['post_max_size'] = $post_max_size;
        $this->data['upload_max_filesize'] = $upload_max_filesize;

        $this->data['text_add_another_one'] = $this->language->get( 'text_add_another_one' );
        $this->data['send_document'] = $this->url->link( 'document/document', '', 'SSL' );

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

        if( isset( $this->request->post['name'] ) )
        {
            $this->data['name'] = $this->request->post['name'];
        }
        else
        {
            $this->data['name'] = '';
        }

        $this->data['add_another_one'] = $this->language->get( 'document/document' );


        if( file_exists( DIR_TEMPLATE.$this->config->get( 'config_template' ).'/template/document/add_document.tpl' ) )
        {
            $this->template = $this->config->get( 'config_template' ).'/template/document/add_document.tpl';
        }
        else
        {
            $this->template = 'default/template/document/add_document.tpl';
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
    }*/
    
    public function listdocuments()
    {
        if( !$this->customer->isLogged() )
        {
            $this->session->data['redirect'] = $this->url->link( 'document/document/listdocuments', '', 'SSL' );
            $this->redirect( $this->url->link( 'account/login', '', 'SSL' ) );
        }

        $this->language->load( 'document/document' );
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
            'text' => $this->language->get( 'heading_title' ),
            'href' => $this->url->link( 'document/document/listdocuments', $url, 'SSL' ),
            'separator' => $this->language->get( 'text_separator' )
        );

        $this->data['heading_title'] = $this->language->get( 'heading_title' );
        $this->data['text_useful_documents_list'] = $this->language->get( 'text_useful_documents_list' );
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
        
        $this->load->model( 'document/document' );
        $document_total = $this->model_document_document->getTotalDocuments();
        $results = $this->model_document_document->getDocuments( ($page - 1) * 10, 10);
        
        $this->data['documents'] = array( );
        foreach( $results as $result )
        {            
            $this->data['documents'][] = array(
                'iddocument' => $result['iddocument'],
                'name' => $result['name'],
                'insert_date' => $result['insert_date'],
                'document' => $result['document'],
                'pdf' =>  DIR_DOCUMENT. $result['document'], 
            );
        }

        $pagination = new Pagination();
        $pagination->total = $document_total;
        $pagination->page = $page;
        $pagination->limit = 10;
        $pagination->text = $this->language->get( 'text_pagination' );
        $pagination->url = $this->url->link( 'document/document/listdocuments', 'page={page}', 'SSL' );

        $this->data['pagination'] = $pagination->render();
        $this->data['continue'] = $this->url->link( 'account/account', '', 'SSL' );

        if( file_exists( DIR_TEMPLATE.$this->config->get( 'config_template' ).'/template/document/list.tpl' ) )
        {
            $this->template = $this->config->get( 'config_template' ).'/template/document/list.tpl';
        }
        else
        {
            $this->template = 'default/template/document/list.tpl';
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
        foreach( $this->request->post['name'] as $key => $name )
        {
            if( (utf8_strlen( $this->request->post['name'][$key] ) < 1) || (utf8_strlen( $this->request->post['name'][$key] ) > 50) )
            {
                $this->error['message'] = $this->language->get( 'error_name' );
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