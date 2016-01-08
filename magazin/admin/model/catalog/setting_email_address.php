<?php

class ModelCatalogSettingEmailAddress extends Model
{

    public function addEmailAddress( $data )
    {
//        $this->db->query( "INSERT INTO ".DB_PREFIX."setting_email_address SET name = '".$this->db->escape( $data['name'] )."', email = '".$this->db->escape( $data['email'] )."', insert_date = NOW() " );
//        $email_id = $this->db->getLastId();

        $this->db->query( "INSERT INTO ".DB_PREFIX."setting_email_address SET sort_order = '".( int ) $data['sort_order']."', status = '".( int ) $data['status']."'" );
        $emailaddress_id = $this->db->getLastId();


        foreach( $data['setting_email_address_description'] as $language_id => $value )
        {
            $this->db->query( "INSERT INTO ".DB_PREFIX."setting_email_address_description SET idemailaddress = '".( int ) $emailaddress_id."', language_id = '".( int ) $language_id."', name = '".$this->db->escape( $value['name'] )."', email = '".$this->db->escape( $value['email'] )."', insert_date = NOW() " );
        }
    }

    public function editEmailAddress( $email_id, $data )
    {
        //$this->db->query( "UPDATE ".DB_PREFIX."setting_email_address SET name = '".$this->db->escape( $data['name'] )."' , email = '".$this->db->escape( $data['email'] )."' WHERE idemailaddress = '".$email_id."' ");

        $this->db->query( "UPDATE ".DB_PREFIX."setting_email_address SET sort_order = '".( int ) $data['sort_order']."', status = '".( int ) $data['status']."' WHERE idemailaddress = '".( int ) $email_id."'" );
        $this->db->query( "DELETE FROM ".DB_PREFIX."setting_email_address_description WHERE idemailaddress = '".( int ) $email_id."'" );

        foreach( $data['setting_email_address_description'] as $language_id => $value )
        {
            $this->db->query( "INSERT INTO ".DB_PREFIX."setting_email_address_description SET idemailaddress = '".( int ) $email_id."', language_id = '".( int ) $language_id."', name = '".$this->db->escape( $value['name'] )."', email = '".$this->db->escape( $value['email'] )."' " );
        }
    }

    public function deleteEmailAddress( $email_id )
    {                
        $this->db->query( "DELETE FROM ".DB_PREFIX."setting_email_address WHERE idemailaddress = '".( int ) $email_id."'" );
        $this->db->query( "DELETE FROM ".DB_PREFIX."setting_email_address_description WHERE idemailaddress = '".( int ) $email_id."'" );
    }

    public function getEmailInfo( $email_id )
    {
        $query = $this->db->query( "SELECT * FROM ".DB_PREFIX."setting_email_address WHERE idemailaddress = '".( int ) $email_id."'" );
        return $query->row;
    }

    public function getEmailAddresses( $data = array( ) )
    {
        if( $data )
        {
            $sql = "SELECT * FROM ".DB_PREFIX."setting_email_address i LEFT JOIN ".DB_PREFIX."setting_email_address_description id ON (i.idemailaddress = id.idemailaddress) WHERE id.language_id = '".( int ) $this->config->get( 'config_language_id' )."'";

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
            $setting_email_address_data = $this->cache->get( 'email_address.'.( int ) $this->config->get( 'config_language_id' ) );

            if( !$setting_email_address_data )
            {
                $query = $this->db->query( "SELECT * FROM ".DB_PREFIX."setting_email_address ORDER BY id.name" );

                $document_data = $query->rows;

                $this->cache->set( 'email_address.'.( int ) $this->config->get( 'config_language_id' ), $setting_email_address_data );
            }

            return $document_data;
        }
    }

    public function getEmailAddressDescriptions( $email_id )
    {
        $email_address_description_data = array( );

        $query = $this->db->query( "SELECT * FROM ".DB_PREFIX."setting_email_address_description WHERE idemailaddress = '".( int ) $email_id."'" );

        foreach( $query->rows as $result )
        {
            $email_address_description_data[$result['language_id']] = array(
                'name' => $result['name'],
                'email' => $result['email']
            );
        }

        return $email_address_description_data;
    }

    public function getTotalEmails()
    {
        $query = $this->db->query( "SELECT COUNT(*) AS total FROM ".DB_PREFIX."setting_email_address" );

        return $query->row['total'];
    }

}

?>