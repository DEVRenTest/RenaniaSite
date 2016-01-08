<?php

class ModelDocumentDocument extends Model
{
    public function getTotalDocuments()
    {
        $query = $this->db->query( "SELECT COUNT(*) AS total FROM ".DB_PREFIX."document  WHERE status = 1" );
        return $query->row['total'];
    }

    public function getDocuments( $start = 0, $limit = 20 )
    {
        if( $start < 0 )
        {
            $start = 0;
        }

        if( $limit < 1 )
        {
            $limit = 1;
        }

        $query = $this->db->query( "SELECT * FROM ".DB_PREFIX."document as doc LEFT JOIN ".DB_PREFIX."document_description as docd ON (docd.iddocument = doc.iddocument) WHERE docd.language_id = '".( int ) $this->config->get( 'config_language_id' )."' ORDER BY doc.sort_order LIMIT ".( int ) $start.",".( int ) $limit );
        return $query->rows;
    }
    
     
}

?>