<?php

class ModelReclamationReclamation extends Model
{

    public function addReclamation( $data, $idreclamation )
    {
        if( $idreclamation == 0 ) // new 
        {
            $this->db->query( "INSERT INTO ".DB_PREFIX."reclamation SET subject = '".$this->db->escape( $data['subject'] )."', description = '".$this->db->escape( $data['description'] )."', customer_id='".$this->customer->getId()."', status = '".$this->db->escape( $data['status'] )."', insert_date = NOW() " );
            $new_reclamation_id = $this->db->getLastId();

            $this->db->query( "UPDATE ".DB_PREFIX."reclamation SET id_parent = '".$new_reclamation_id."' WHERE idreclamation='".( int ) $new_reclamation_id."'" );
        }
        else // reply message
        {
            $parent_reclamation = $this->getReclamationDetails( $idreclamation );
            $subject = $parent_reclamation['subject'];
            $id_parent = $parent_reclamation['id_parent'];
            
            $this->db->query( "INSERT INTO ".DB_PREFIX."reclamation SET subject = '".$subject."', description = '".$this->db->escape( $data['description'] )."', customer_id='".$this->customer->getId()."', status = '".$this->db->escape( $data['status'] )."', insert_date = NOW(), id_parent = '". $id_parent ."' " );
            $new_reclamation_id = $this->db->getLastId();
            
            // update status for reclamation with same id_parent
            $this->db->query( "UPDATE ".DB_PREFIX."reclamation SET status = '".$this->db->escape( $data['status'] )."' WHERE id_parent='".( int ) $id_parent."'" );
        }

        return $new_reclamation_id;
    }

    public function modifyReclamation( $reclamation_id, $data )
    {
        $this->db->query( "UPDATE ".DB_PREFIX."reclamation SET subject = '".$this->db->escape( $data['subject'] )."', description = '".$this->db->escape( $data['description'] )."'  WHERE idreclamation='".( int ) $reclamation_id."'" );
        $reclamation_id = $this->db->getLastId();

        return $reclamation_id;
    }

    public function updateReclamation( $reclamation_id, $attachment )
    {
        $this->db->query( "UPDATE ".DB_PREFIX."reclamation SET attachment = '".$attachment."' WHERE idreclamation='".( int ) $reclamation_id."'" );
    }

    public function getReclamationDetails( $reclamation_id )
    {
        $query = $this->db->query( "SELECT * FROM ".DB_PREFIX."reclamation WHERE idreclamation = '".( int ) $reclamation_id."'" );
        return $query->row;
    }

    public function getTotalReclamations( $customer_id )
    {
        $query = $this->db->query( "SELECT COUNT( DISTINCT(id_parent)) AS total FROM ".DB_PREFIX."reclamation WHERE customer_id = '".$customer_id."'" );
        return $query->row['total'];
    }

    public function getReclamations( $start = 0, $limit = 20, $customer_id )
    {
        if( $start < 0 )
        {
            $start = 0;
        }

        if( $limit < 1 )
        {
            $limit = 1;
        }
       
        $query = $this->db->query( "SELECT MAX( idreclamation ) AS id FROM ".DB_PREFIX."reclamation WHERE customer_id = '".$customer_id."' GROUP BY id_parent ORDER BY idreclamation DESC LIMIT ".( int ) $start.",".( int ) $limit );
        return $query->rows;
    }

    public function deleteReclamation( $reclamation_id )
    {
        $reclamation_info = $this->getReclamationDetails( $reclamation_id );
        $attachments = $reclamation_info['attachment'];
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
        $this->db->query( "DELETE FROM ".DB_PREFIX."reclamation WHERE idreclamation = '".( int ) $reclamation_id."'" );
    }
    
    
    public function getReclamationHistory( $id_parent )
    {
        $query = $this->db->query( "SELECT * FROM ".DB_PREFIX."reclamation WHERE id_parent = '".( int ) $id_parent."' ORDER BY insert_date DESC, idreclamation DESC " );
        return $query->rows;
    }
    
    public function getIdsWithSameIdParent( $id_parent )
    {
        $query = $this->db->query( "SELECT idreclamation FROM ".DB_PREFIX."reclamation WHERE id_parent = '".( int ) $id_parent."' " );
        return $query->rows;
    }

}

?>
