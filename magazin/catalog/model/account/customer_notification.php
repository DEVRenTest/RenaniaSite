<?php

class ModelAccountCustomerNotification extends Model
{

    public function addNotification( $data )
    {
        if ( $this->verifyIfAlreadyExists(  $data['product_id'], $data['id'], $data['customer_id'] ) == 0 )
        {
           // print "addNotification = INSERT INTO ".DB_PREFIX."customer_notification SET type = '".$this->db->escape( $data['type'] )."',product_id = '".( int ) $this->db->escape( $data['product_id'] )."', id = '".$this->db->escape( $data['id'] )."', description = '".$this->db->escape( $data['description'] )."', customer_id = '".$this->db->escape( $data['customer_id'] )."', customer_email = '".$this->db->escape( $data['customer_email'] )."', alert = '0', date_added = NOW()"."<br>";
            $this->db->query( "INSERT INTO ".DB_PREFIX."customer_notification SET type = '".$this->db->escape( $data['type'] )."',product_id = '".( int ) $this->db->escape( $data['product_id'] )."', id = '".$this->db->escape( $data['id'] )."', description = '".$this->db->escape( $data['description'] )."', customer_id = '".$this->db->escape( $data['customer_id'] )."', customer_email = '".$this->db->escape( $data['customer_email'] )."', alert = '0', date_added = NOW()" );
        }
        else
        {
           // print "addNotification = UPDATE ".DB_PREFIX."customer_notification SET alert=0 WHERE customer_id='".$data['customer_id']."' AND id='".$data['id']."'"."<br>";
            $this->db->query( "UPDATE ".DB_PREFIX."customer_notification SET alert=0 WHERE customer_id='".$data['customer_id']."' AND id='".$data['id']."'" );
        }        
    }

    public function updateAlertField( $id )
    {
        $this->db->query( "UPDATE ".DB_PREFIX."customer_notification SET alert=1 WHERE id='".$id."'" );
    }

    private function verifyIfAlreadyExists( $product_id, $id , $customer_id )
    {
        $exists = 0;

        $query = $this->db->query( "SELECT customer_notification_id FROM ".DB_PREFIX."customer_notification WHERE product_id='".$product_id."' AND id='".$id."' AND customer_id='".$customer_id."'" );
                
        if( $query->num_rows > 0 )
        {
            if( $query->row['customer_notification_id'] > 0 )
            {
                $exists = 1;
            }
        }
        
        return $exists;
    }

}

?>