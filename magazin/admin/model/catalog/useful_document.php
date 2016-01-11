<?php

class ModelCatalogUsefulDocument extends Model
{
    public function addDocument( $data, $file )
    {
        $this->db->query( "INSERT INTO ".DB_PREFIX."document SET sort_order = '".( int ) $data['sort_order']."', status = '".( int ) $data['status']."'" );
        $document_id = $this->db->getLastId();


        $tmp_name = $file['document']['tmp_name'];
        $file_document = $document_id."_".$file['document']['name'];
        move_uploaded_file( $tmp_name, DIR_DOCUMENT.$file_document );

        foreach( $data['document_description'] as $language_id => $value )
        {
            $this->db->query( "INSERT INTO ".DB_PREFIX."document_description SET iddocument = '".( int ) $document_id."', language_id = '".( int ) $language_id."', name = '".$this->db->escape( $value['name'] )."', document = '".$file_document."', insert_date = NOW() " );
        }
    }

    public function editDocument( $document_id, $data, $file )
    {
        $this->db->query( "UPDATE ".DB_PREFIX."document SET sort_order = '".( int ) $data['sort_order']."', status = '".( int ) $data['status']."' WHERE iddocument = '".( int ) $document_id."'" );

        $document_info = $this->getDocumentDescriptions( $document_id );

        $this->load->model( 'localisation/language' );
        $languages = $this->model_localisation_language->getLanguages();
        $current_language = $this->config->get( 'config_language' );
        $old_document = $document_info[$languages[$current_language]['language_id']]['document'];

        if( $file["document"]["size"] > 0 )
        {
            if( file_exists( DIR_DOCUMENT.$old_document ) )
            {
                @unlink( DIR_DOCUMENT.$old_document );
            }

            $tmp_name = $file['document']['tmp_name'];
            $file_document = $document_id."_".$file['document']['name'];
            move_uploaded_file( $tmp_name, DIR_DOCUMENT.$file_document );
        }
        else
        {
            $file_document = $old_document;
        }

        $this->db->query( "DELETE FROM ".DB_PREFIX."document_description WHERE iddocument = '".( int ) $document_id."'" );


        foreach( $data['document_description'] as $language_id => $value )
        {
            $this->db->query( "INSERT INTO ".DB_PREFIX."document_description SET iddocument = '".( int ) $document_id."', language_id = '".( int ) $language_id."', name = '".$this->db->escape( $value['name'] )."', document = '".$file_document."' " );
        }
    }

    public function deleteDocument( $document_id )
    {
        $document_info = $this->getDocumentDescriptions( $document_id );

        $this->load->model( 'localisation/language' );
        $languages = $this->model_localisation_language->getLanguages();
        $current_language = $this->config->get( 'config_language' );

        if( file_exists( DIR_DOCUMENT.$document_info[$languages[$current_language]['language_id']]['document'] ) )
        {
            @unlink( DIR_DOCUMENT.$document_info[$languages[$current_language]['language_id']]['document'] );
        }

        $this->db->query( "DELETE FROM ".DB_PREFIX."document WHERE iddocument = '".( int ) $document_id."'" );
        $this->db->query( "DELETE FROM ".DB_PREFIX."document_description WHERE iddocument = '".( int ) $document_id."'" );
    }

    public function getDocument( $document_id )
    {
        $query = $this->db->query( "SELECT * FROM ".DB_PREFIX."document WHERE iddocument = '".( int ) $document_id."'" );
        return $query->row;
    }

    public function getDocuments( $data = array( ) )
    {
        if( $data )
        {
            $sql = "SELECT * FROM ".DB_PREFIX."document i LEFT JOIN ".DB_PREFIX."document_description id ON (i.iddocument = id.iddocument) WHERE id.language_id = '".( int ) $this->config->get( 'config_language_id' )."'";

            $sort_data = array(
                'id.name',
                'i.sort_order'
            );

            if( isset( $data['sort'] ) && in_array( $data['sort'], $sort_data ) )
            {
                $sql .= " ORDER BY ".$data['sort'];
            }
            else
            {
                $sql .= " ORDER BY id.name";
            }

            if( isset( $data['order'] ) && ($data['order'] == 'DESC') )
            {
                $sql .= " DESC";
            }
            else
            {
                $sql .= " ASC";
            }

            if( isset( $data['start'] ) || isset( $data['limit'] ) )
            {
                if( $data['start'] < 0 )
                {
                    $data['start'] = 0;
                }

                if( $data['limit'] < 1 )
                {
                    $data['limit'] = 20;
                }

                $sql .= " LIMIT ".( int ) $data['start'].",".( int ) $data['limit'];
            }

            $query = $this->db->query( $sql );

            return $query->rows;
        }
        else
        {
            $document_data = $this->cache->get( 'document.'.( int ) $this->config->get( 'config_language_id' ) );

            if( !$document_data )
            {
                $query = $this->db->query( "SELECT * FROM ".DB_PREFIX."document ORDER BY id.name" );

                $document_data = $query->rows;

                $this->cache->set( 'document.'.( int ) $this->config->get( 'config_language_id' ), $document_data );
            }

            return $document_data;
        }
    }

    public function getDocumentDescriptions( $document_id )
    {
        $document_description_data = array( );

        $query = $this->db->query( "SELECT * FROM ".DB_PREFIX."document_description WHERE iddocument = '".( int ) $document_id."'" );

        foreach( $query->rows as $result )
        {
            $document_description_data[$result['language_id']] = array(
                'name' => $result['name'],
                'document' => $result['document']
            );
        }

        return $document_description_data;
    }

    public function getTotalDocuments()
    {
        $query = $this->db->query( "SELECT COUNT(*) AS total FROM ".DB_PREFIX."document" );

        return $query->row['total'];
    }

}

?>