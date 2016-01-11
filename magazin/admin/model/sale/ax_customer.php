<?php

class ModelSaleAxCustomer extends Model
{

    public function adminAxCustomer( $oc_customer_id, $data )
    {
        $row = $this->getCustomer( $oc_customer_id );
        if( sizeof( $row ) == 0 )
        {
            // add new customer in ax_customer table
            $ax_customer_id = $this->addAxCustomer( $oc_customer_id, $data );
        }
        else
        {
            $ax_customer_id = $row['ax_customer_id'];
            // update customer info in ax_customer table
            $this->updateAxCustomer( $ax_customer_id, $data );
        }

        if( isset( $data['address'] ) )
        {
            // if is set address, save in ax_customer table
            $this->setAxCustomerAddress( $ax_customer_id, $data['address'] );
        }

        // save the ip and approved value in ax_customer table
        $this->setAxCustomerOtherInfo( $oc_customer_id, $ax_customer_id );
    }

    public function addAxCustomer( $oc_customer_id, $data )
    {
        $this->db->query( "INSERT INTO ".DB_AX_PREFIX."customer SET oc_customer_id = '".( int ) $oc_customer_id."', 
                           firstname = '".$this->db->escape( $data['firstname'] )."', lastname = '".$this->db->escape( $data['lastname'] )."', 
                           middlename = '".$this->db->escape( $data['middlename'] )."', identity_card_number = '".$this->db->escape( $data['identity_card_number'] )."', mobile_phone = '".$this->db->escape( $data['mobile_phone'] )."',  
                           email = '".$this->db->escape( $data['email'] )."', telephone = '".$this->db->escape( $data['telephone'] )."', fax = '".$this->db->escape( $data['fax'] )."',
                           newsletter = '".( int ) $data['newsletter']."', customer_group_id = '".( int ) $data['customer_group_id']."', 
                           salt = '".$this->db->escape( $salt = substr( md5( uniqid( rand(), true ) ), 0, 9 ) )."', 
                           password = '".$this->db->escape( sha1( $salt.sha1( $salt.sha1( $data['password'] ) ) ) )."', 
                           status = '".( int ) $data['status']."', date_added = NOW(), ax_code = '".$this->db->escape( $data['ax_code'] )."' " );
        //, payment_term = '".$this->db->escape( $data['payment_term'] )."'

        $insert_ax_customer_id = $this->db->getLastId();

        return $insert_ax_customer_id;
    }

    public function updateAxCustomer( $ax_customer_id, $data )
    {
        $this->db->query( "UPDATE ".DB_AX_PREFIX."customer SET firstname = '".$this->db->escape( $data['firstname'] )."', lastname = '".$this->db->escape( $data['lastname'] )."', 
                           middlename = '".$this->db->escape( $data['middlename'] )."', identity_card_number = '".$this->db->escape( $data['identity_card_number'] )."', mobile_phone = '".$this->db->escape( $data['mobile_phone'] )."',
                           email = '".$this->db->escape( $data['email'] )."', telephone = '".$this->db->escape( $data['telephone'] )."', fax = '".$this->db->escape( $data['fax'] )."',
                           newsletter = '".( int ) $data['newsletter']."', customer_group_id = '".( int ) $data['customer_group_id']."', 
                           salt = '".$this->db->escape( $salt = substr( md5( uniqid( rand(), true ) ), 0, 9 ) )."', 
                           password = '".$this->db->escape( sha1( $salt.sha1( $salt.sha1( $data['password'] ) ) ) )."', 
                           status = '".( int ) $data['status']."', date_added = NOW(), ax_code = '".$this->db->escape( $data['ax_code'] )."' WHERE ax_customer_id = '".( int ) $ax_customer_id."'" );
        //, payment_term = '".$this->db->escape( $data['payment_term'] )."'
    }

    public function setAxCustomerAddress( $ax_customer_id, $data )
    {
        foreach( $data as $address )
        {
            if( isset( $address['default'] ) )
            {
                $this->db->query( "UPDATE ".DB_AX_PREFIX."customer SET company = '".$this->db->escape( $address['company'] )."', 
                                       company_id = '".$this->db->escape( $address['company_id'] )."',tax_id = '".$this->db->escape( $address['tax_id'] )."',
                                       address_1 = '".$this->db->escape( $address['address_1'] )."', address_2 = '".$this->db->escape( $address['address_2'] )."',
                                       city = '".$this->db->escape( $address['city'] )."', postcode = '".$this->db->escape( $address['postcode'] )."', 
                                       country_id = '".( int ) $address['country_id']."', zone_id = '".( int ) $address['zone_id']."'
                                       WHERE ax_customer_id = '".( int ) $ax_customer_id."'" );
            }
        }
    }

    public function setAxCustomerOtherInfo( $oc_customer_id, $ax_customer_id )
    {
        $this->load->model( 'sale/customer' );
        $customer_info = $this->model_sale_customer->getCustomer( $oc_customer_id );

        if( $customer_info )
        {
            $this->db->query( "UPDATE ".DB_AX_PREFIX."customer SET ip = '".$customer_info['ip']."', approved = '".$customer_info['approved']."'
                               WHERE $ax_customer_id = '".( int ) $ax_customer_id."'" );
        }
    }

    public function getCustomer( $oc_customer_id )
    {
        $query = $this->db->query( "SELECT ax_customer_id FROM ".DB_AX_PREFIX."customer WHERE oc_customer_id = '".( int ) $oc_customer_id."'" );
        return $query->row;
    }

}

?>