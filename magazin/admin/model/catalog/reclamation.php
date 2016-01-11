<?php

class ModelCatalogReclamation extends Model
{

    public function getTotalReclamations()
    {
        $query = $this->db->query( "SELECT COUNT(DISTINCT(id_parent)) AS total FROM ".DB_PREFIX."reclamation" );
        return $query->row['total'];
    }

    public function getReclamations( $data )
    {
        if( $data )
        {
            $sql = "SELECT MAX( idreclamation ) AS id FROM ".DB_PREFIX."reclamation as recl GROUP BY id_parent ";

            $sort_data = array(
                'recl.insert_date',
                'recl.subject',
                'recl.status',
            );

            if( isset( $data['sort'] ) && in_array( $data['sort'], $sort_data ) )
            {
                $sql .= " ORDER BY ".$data['sort'];
            }
            else
            {
                $sql .= " ORDER BY recl.subject";
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
    }

    public function getReclamationHistory( $id_parent )
    {
        $query = $this->db->query( "SELECT * FROM ".DB_PREFIX."reclamation WHERE id_parent = '".( int ) $id_parent."' ORDER BY insert_date DESC, idreclamation DESC " );
        return $query->rows;
    }

    public function getReclamationDetails( $reclamation_id )
    {
        $query = $this->db->query( "SELECT * FROM ".DB_PREFIX."reclamation WHERE idreclamation = '".( int ) $reclamation_id."'" );
        return $query->row;
    }

    /* public function addReclamation( $data, $file )
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

      //		$this->cache->delete('document');
      } */

    /*  public function editReclamation( $reclamation_id, $data, $file )
      {
      $this->db->query( "UPDATE ".DB_PREFIX."reclamation SET sort_order = '".( int ) $data['sort_order']."', status = '".( int ) $data['status']."' WHERE idreclamation = '".( int ) $reclamation_id."'" );
      //$reclamation_info = $this->getDocumentDescriptions( $document_id );

      //        $this->load->model( 'localisation/language' );
      //        $languages = $this->model_localisation_language->getLanguages();
      //        $current_language = $this->config->get( 'config_language' );
      $old_document = $document_info[$languages[$current_language]['language_id']]['document'];

      if( $file["document"]["size"] > 0 )
      {
      if( file_exists( DIR_DOCUMENT.$old_document ) )
      {
      @unlink( DIR_DOCUMENT.$old_document );
      }

      $tmp_name = $file['document']['tmp_name'];
      $files = $document_id."_".$file['document']['name'];
      move_uploaded_file( $tmp_name, DIR_DOCUMENT.$files );
      }
      else
      {
      $files = $old_document;
      }

      //        $this->db->query( "DELETE FROM ".DB_PREFIX."document_description WHERE iddocument = '".( int ) $document_id."'" );
      //
      //
      //        foreach( $data['document_description'] as $language_id => $value )
      //        {
      //            $this->db->query( "INSERT INTO ".DB_PREFIX."document_description SET iddocument = '".( int ) $document_id."', language_id = '".( int ) $language_id."', name = '".$this->db->escape( $value['name'] )."', document = '".$file_document."' " );
      //        }

      $this->db->query( "INSERT INTO ".DB_PREFIX."reclamation SET idreclamation = '".( int ) $reclamation_id."', employee_attachment = '".$files."' " );

      //$this->cache->delete('document');
      } */

    /* public function deleteDocument( $reclamation_id )
      {
      $reclamation_info = $this->getDocumentDescriptions( $document_id );

      $this->load->model( 'localisation/language' );
      $languages = $this->model_localisation_language->getLanguages();
      $current_language = $this->config->get( 'config_language' );

      if( file_exists( DIR_DOCUMENT.$document_info[$languages[$current_language]['language_id']]['document'] ) )
      {
      @unlink( DIR_DOCUMENT.$document_info[$languages[$current_language]['language_id']]['document'] );
      }

      $this->db->query( "DELETE FROM ".DB_PREFIX."document WHERE iddocument = '".( int ) $document_id."'" );
      $this->db->query( "DELETE FROM ".DB_PREFIX."document_description WHERE iddocument = '".( int ) $document_id."'" );

      //$this->cache->delete('document');
      } */

    public function addReclamation( $data, $idreclamation )
    {
        $parent_reclamation = $this->getReclamationDetails( $idreclamation );
        $subject = $parent_reclamation['subject'];
        $id_parent = $parent_reclamation['id_parent'];
        
        $this->db->query( "INSERT INTO ".DB_PREFIX."reclamation SET subject = '".$subject."', description = '".$this->db->escape( $data['description'] )."', number = '".$this->db->escape( $data['number'] )."', customer_id='-99999', status = '".$this->db->escape( $data['status'] )."', insert_date = NOW(), id_parent = '".$id_parent."' " );
        $new_reclamation_id = $this->db->getLastId();
        
        // update status for reclamation with same id_parent
        $this->db->query( "UPDATE ".DB_PREFIX."reclamation SET status = '".$this->db->escape( $data['status'] )."' WHERE id_parent='".( int ) $id_parent."'" );
        
        // update number for reclamation with same id_parent
        $this->db->query( "UPDATE ".DB_PREFIX."reclamation SET number = '".$this->db->escape( $data['number'] )."' WHERE id_parent='".( int ) $id_parent."'" );
        

        return $new_reclamation_id;
    }

    public function updateReclamation( $reclamation_id, $attachment )
    {
        $this->db->query( "UPDATE ".DB_PREFIX."reclamation SET attachment = '".$attachment."' WHERE idreclamation='".( int ) $reclamation_id."'" );
    }

    public function deleteReclamation( $id_reclamation )
    {
        $reclamation_info = $this->getReclamationDetails( $id_reclamation );
        $reclamations_with_same_idp = $this->getReclamationsWithSameIdParent( $reclamation_info['id_parent'] );

        foreach( $reclamations_with_same_idp as $reclamation_with_same_idp )
        {            
            $attachments = $reclamation_with_same_idp['attachment'];
            if( !empty( $attachments ) )
            {
                $attachment_exp = explode( "#", $attachments );
                foreach( $attachment_exp as $attachment )
                {
                    if( file_exists( DIR_RECLAMATION.$attachment ) )
                    {
                        @unlink( DIR_RECLAMATION.$attachment );
                    }
                }
            }
            $this->db->query( "DELETE FROM ".DB_PREFIX."reclamation WHERE idreclamation = '".( int ) $reclamation_with_same_idp['idreclamation']."'" );
        }
    }

    public function getIdsWithSameIdParent( $id_parent )
    {
        $query = $this->db->query( "SELECT idreclamation FROM ".DB_PREFIX."reclamation WHERE id_parent = '".( int ) $id_parent."' " );
        return $query->rows;
    }

    public function getReclamationsWithSameIdParent( $id_parent )
    {
        $query = $this->db->query( "SELECT * FROM ".DB_PREFIX."reclamation WHERE id_parent = '".( int ) $id_parent."' " );
        return $query->rows;
    }
    
    public function getReclamationNumber( $idreclamation )
    {
        $number = '';
        $query = $this->db->query( "SELECT number FROM ".DB_PREFIX."reclamation WHERE idreclamation = '".( int ) $idreclamation."' " );
        if ( $query->num_rows > 0 )
        {
            $number = $query->row['number'];
        }
        return $number;
    }

}

?>