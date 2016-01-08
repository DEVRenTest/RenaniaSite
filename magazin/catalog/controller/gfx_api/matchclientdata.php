<?php
class ControllerGfxApiMatchClientData extends Controller {

    private $error = array( );
    private $post_max_size;
    private $upload_max_filesize;
    private $allowedExts = array( "xml", "csv" );
    private $mandatory_data = array();
    private $xml_node = array();

    public function fileUpload()
    {
        // se citeste link-ul accesat
        $route = $this->request->get['route'];
        $route_info = explode("/", $route );
        // se citeste webservice-ul apelat
        $webservice_name = $route_info[1];

        // se citeste pentru webservice fieldurile obligatoriu pt fisierele csv sau xml
        $this->load->model( 'catalog/api_operation' );
        $this->mandatory_data = $this->model_catalog_api_operation->getMandatoryData( $webservice_name );

/*        print_r( $this->mandatory_data );
        die();*/

        if( !$this->customer->isLogged() )
        {
            $this->session->data['redirect'] = $this->url->link( 'gfx_api/matchclientdata/fileUpload', '', 'SSL' );
            $this->redirect( $this->url->link( 'account/login', '', 'SSL' ) );
        }

        $this->language->load( 'gfx_api/matchclientdata' );
        $this->document->setTitle( $this->language->get( 'heading_title' ) );

        $this->load->model( 'account/customer_file_for_matching' );

        $this->post_max_size = $this->return_bytes( ini_get( 'post_max_size' ) );
        $this->upload_max_filesize = $this->return_bytes( ini_get( 'upload_max_filesize' ) );

        if( ($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm( $this->request->files ) )
        {
            // save the file in database
            $file_id = $this->model_account_customer_file_for_matching->addFile( $this->request->files, $this->request->post );

            // se citeste numele temporar al fisierului
            $tmp_name = $this->request->files['file_for_matching']['tmp_name'];

            // se citeste extensia fisierului
            $temp = explode( ".", $this->request->files['file_for_matching']['name'] );
            $extension = end( $temp );

            // definirea numelui fisierului
            $file_name = $this->customer->getId()."_".$file_id.".".$extension;//.$this->request->files['file_for_matching']['name']
            move_uploaded_file( $tmp_name, DIR_FILE_FOR_MATCHING.$file_name );

            // update to new file_name
            $this->model_account_customer_file_for_matching->updateFile( $file_id, $file_name );

            if ( $this->validateFile(  $file_name ) )
            {
                $this->session->data['success'] = $this->language->get( 'text_add_success' );
            }
            else
            {
                $this->redirect( $this->url->link( 'gfx_api/matchclientdata/fileUpload', '', 'SSL' ) );
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
            'text' => $this->language->get( 'text_file_upload' ),
            'href' => $this->url->link( 'gfx_api/matchclientdata/fileUpload', '', 'SSL' ),
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

        if( isset( $this->request->post['csv_delimiter'] ) )
        {
            $this->data['csv_delimiter'] = $this->request->post['csv_delimiter'];
        }
        else
        {
            $this->data['csv_delimiter'] = '';
        }

        $this->data['heading_title'] = $this->language->get( 'heading_title' );
        $this->data['text_account'] = $this->language->get( 'text_account' );
        $this->data['text_file_upload'] = $this->language->get( 'text_file_upload' );
        $this->data['text_choose_file'] = $this->language->get( 'text_choose_file' );
        $this->data['text_csv_delimiter'] = $this->language->get( 'text_csv_delimiter' );
        $this->data['text_allowed_extensions'] = $this->language->get( 'text_allowed_extensions' );
        $this->data['text_send'] = $this->language->get( 'text_send' );
        $this->data['error_post_max_size'] = str_replace( '%1', ini_get( 'post_max_size' ), $this->language->get( 'error_post_max_size' ) );
        $this->data['error_upload_max_filesize'] = str_replace( '%1', ini_get( 'upload_max_filesize' ), $this->language->get( 'error_upload_max_filesize' ) );

        $this->data['post_max_size'] = $this->post_max_size;
        $this->data['upload_max_filesize'] = $this->upload_max_filesize;

        $this->data['text_add_another_one'] = $this->language->get( 'text_add_another_one' );
        $this->data['upload_file'] = $this->url->link( 'gfx_api/matchclientdata/fileUpload', '', 'SSL' );

        if( isset( $this->session->data['warning'] ) )
        {
            $this->data['warning'] = $this->session->data['warning'];
            unset( $this->session->data['warning'] );
        }
        else
        {
            $this->data['warning'] = '';
        }

        if( isset( $this->error['file_upload'] ) )
        {
            $this->data['error_file_upload'] = $this->error['file_upload'];
        }
        else
        {
            $this->data['error_file_upload'] = '';
        }

        if( isset( $this->error['csv_delimiter'] ) )
        {
            $this->data['error_csv_delimiter'] = $this->error['csv_delimiter'];
        }
        else
        {
            $this->data['error_csv_delimiter'] = '';
        }


        if( file_exists( DIR_TEMPLATE.$this->config->get( 'config_template' ).'/template/account/add_file_for_matching.tpl' ) )
        {
            $this->template = $this->config->get( 'config_template' ).'/template/account/add_file_for_matching.tpl';
        }
        else
        {
            $this->template = 'default/template/account/add_file_for_matching.tpl';
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

    protected function validateForm( $file_data )
    {
        // verificam daca fisierul adaugat este de tip xml sau csv
        $temp = explode( ".", $file_data['file_for_matching']['name'] );
        $extension = end( $temp );

        if ( $extension == 'csv' )
        {
            if( empty( $this->request->post['csv_delimiter'] ) )
            {
                $this->error['csv_delimiter'] = $this->language->get( 'text_have_not_specified_delimiter' );
                return false;
            }
        }

        if ( $file_data["file_for_matching"]["size"] == 0 )
        {
            $this->error['file_upload'] = $this->language->get( 'text_you_have_not_selected_the_file' );
            return false;
        }

        if( $file_data["file_for_matching"]["error"] == 0 && ($file_data["file_for_matching"]["size"] < $this->upload_max_filesize) && in_array( $extension, $this->allowedExts ) )
        {

            return true;
        }
        else
        {
            $this->error['file_upload'] = $this->language->get( 'error_upload' );
            return false;
        }
    }

    private function validateFile(  $file_name )
    {
        $extension = pathinfo($file_name, PATHINFO_EXTENSION);
        $file_info =explode(".", $file_name);
        $file_info1 =explode("_", $file_info[0]);
        $file_id = $file_info1[1];

        // verificam validitatea fisierului in fctie de extensie
        if ( $extension == "xml")
        {
            $reader = new XMLReader();
            $reader->open( DIR_FILE_FOR_MATCHING . $file_name );

            // Set parser options - you must set this in order to use isValid method
            $reader->setParserProperty( XMLReader::VALIDATE, TRUE );

            $a = 0;
            if( !$reader->isValid() ) // $a == 0
            {
                // se sterge din baza de date si de pe server
                $this->model_account_customer_file_for_matching->deleteFile( $file_id );
                $this->session->data['warning'] = $this->language->get( 'text_xml_file_is_not_valid' );
                return false;
            }
            else
            {
                // in cazul in care xml-ul este valid, verificam daca contine datele obligatorii specificate webservice-ului
                $xml = simplexml_load_file( DIR_FILE_FOR_MATCHING . $file_name );
                foreach($xml->children()->children() as $child)
                {
                    $this->xml_node[] = strtoupper(trim($child->getName()));
                }

                $xml_valid = 1;
                foreach( $this->mandatory_data as $value )
                {
                    if ( !in_array($value, $this->xml_node))
                    {
                        $xml_valid = 0;
                        break;
                    }
                }

                if ( $xml_valid == 0 )
                {
                    // se sterge din baza de date si de pe server
                    $this->model_account_customer_file_for_matching->deleteFile( $file_id );
                    $this->session->data['warning'] = $this->language->get( 'text_xml_file_not_contain_mandatory_data' );
                    return false;
                }
                else
                {
                    return true;
                }

            }
        }
        else if ( $extension == "csv")
        {
            $csv_delimiter = $this->model_account_customer_file_for_matching->getCsvDelimiter( $file_id );

            $filerow = array( );
            $filerow = @file( DIR_FILE_FOR_MATCHING . $file_name );
            $csv_header = explode( $csv_delimiter, $filerow[0] );

            $csv_have_header = 1;
            // verificam daca fisierul csv are header
            foreach( $csv_header as $value )
            {
                if ( is_numeric(trim($value)) )
                {
                    // se sterge din baza de date si de pe server
                    $this->model_account_customer_file_for_matching->deleteFile( $file_id );
                    $this->session->data['warning'] = $this->language->get( 'text_csv_file_without_header' );
                    return false;
                }
            }

            // transformam in litere mari
            $header = array();
            foreach( $csv_header as $value )
            {
                $header[] = strtoupper(trim($value));
            }

            // in cazul in care csv -ul are header, verificam daca headerul contine datele obligatorii specificate webservice-ului
            foreach( $this->mandatory_data as $value )
            {
                if ( !in_array($value, $header))
                {
                    $csv_have_header = 0;
                    break;
                }
            }

            if ( $csv_have_header == 0 )
            {
                // se sterge din baza de date si de pe server
                $this->model_account_customer_file_for_matching->deleteFile( $file_id );
                $this->session->data['warning'] = $this->language->get( 'text_csv_file_not_contain_mandatory_data' );
                return false;
            }
            else
            {
                return true;
            }

        }
    }

    /*$xml = new SimpleXMLElement( $xmlstr );
    $this->RecurseXML($xml);

    print_r( $this->xml_node );
    function RecurseXML($xml,$parent="")
    {

        $child_count = 0;
        foreach($xml as $key=>$value)
        {
            $child_count++;
            if($this->RecurseXML($value,$parent.".".$key) == 0)  // no childern, aka "leaf node"
            {
                //print($parent . "." . $key ."<BR>\n");
                if ( !in_array( $parent . "." . $key, $this->xml_node ))
                  {
                      $this->xml_node[] = $parent . "." . $key;
                  }
            }
        }
        return $child_count;
    }*/
}