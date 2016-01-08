<?php

class ModelInvoiceAddress extends Model
{

    public function getAddress( $customer_ax_code )
    {
        $address_data = array( );

        $query = $this->db->query( "SELECT * FROM B2B_adresa WHERE accountnum LIKE'%".$customer_ax_code."%' AND tipadresa = 'FACTURARE' " );
        if( $query->row > 0 )
        {
            $address_data[] = array(
                'tipadresa' => $query->row['tipadresa'],
                'nrcrt' => $query->row['nrcrt'],
                'street' => $query->row['street'],
                'city' => $query->row['city'],
                'county' => $query->row['county'],
                'zipcode' => $query->row['zipcode']
            );
        }

        return $address_data;
    }

    public function getAllAddresses( $customer_ax_code )
    {
        $address_data = array( );

        $query = $this->db->query( "SELECT * FROM B2B_adresa WHERE accountnum ='".$customer_ax_code."' " );
        if( $query->row > 0 )
        {
            foreach( $query->rows as $result )
            {
                $address_data[] = array(
                    'accountnum' => $result['accountnum'],
                    'tipadresa' => $result['tipadresa'],
                    'nrcrt' => $result['nrcrt'],
                    'street' => $result['street'],
                    'city' => $result['city'],
                    'county' => $result['county'],
                    'zipcode' => $result['zipcode']
                );
            }
        }

        return $address_data;
    }

    public function getNrCrt( $customer_ax_code )
    {
        $max_nrcrt = 0;

        $query = $this->db->query( "SELECT MAX(nrcrt) as max FROM B2B_adresa WHERE accountnum ='".$customer_ax_code."'" );
        if( $query->row > 0 )
        {
            $max_nrcrt = $query->row['max'];
        }

        return $max_nrcrt;
    }

    public function addAddress( $data, $customer_ax_code )
    {
        $nrcrt = $this->getNrCrt( $customer_ax_code );
        $tipadresa = '';
        if( $data['default'] == 1 )
        {
            $tipadresa = 'FACTURARE';
        }
        else
        {
            $tipadresa = 'LIVRARE';
        }

        $this->load->model( 'localisation/zone' );
        $county_info = $this->model_localisation_zone->getZone( $data['zone_id'] );
        $county = $county_info['code'];

        $this->db->query( "INSERT INTO B2B_adresa SET accountnum = '".$customer_ax_code."', tipadresa = '".$tipadresa."', nrcrt = '".($nrcrt + 1)."', street = '".$this->db->escape( $data['address_1'] )."', zipcode = '".$this->db->escape( $data['postcode'] )."', city = '".$this->db->escape( $data['city'] )."', county = '".$county."' " );
    }

    public function editAddress( $customer_ax_code, $nrcrt, $data )
    {
        $tipadresa = '';
        if( $data['default'] == 1 )
        {
            $tipadresa = 'FACTURARE';
        }
        else
        {
            $tipadresa = 'LIVRARE';
        }
        
        $this->load->model( 'localisation/zone' );
        $county_info = $this->model_localisation_zone->getZone( $data['zone_id'] );
        $county = $county_info['code'];
        
        $this->db->query( "UPDATE B2B_adresa SET tipadresa = '".$tipadresa."',street = '".$this->db->escape( $data['address_1'] )."', zipcode = '".$this->db->escape( $data['postcode'] )."', city = '".$this->db->escape( $data['city'] )."', county = '".$county."' WHERE accountnum = '".$customer_ax_code."' AND nrcrt= '".$nrcrt."' " );
    }

    public function deleteAddress( $accountnum, $nrcrt )
    {
        $this->db->query( "DELETE FROM B2B_adresa WHERE accountnum = '".$accountnum."' AND nrcrt = '".( int ) $nrcrt."'" );
    }

    
    public function getAddressData( $customer_ax_code, $nrcrt )
    {
        $address_data = array( );

        $query = $this->db->query( "SELECT * FROM B2B_adresa WHERE accountnum ='".$customer_ax_code."' AND nrcrt = '".$nrcrt."' " );
        if( $query->row > 0 )
        {
            $address_data = array(
                'tipadresa' => $query->row['tipadresa'],
                'street' => $query->row['street'],
                'city' => $query->row['city'],
                'county' => $query->row['county'],
                'zipcode' => $query->row['zipcode']
            );
        }

        return $address_data;
    }


    public function getTotalB2BAddresses( $accountnum )
    {
        $query = $this->db->query( "SELECT COUNT(*) AS total FROM B2B_adresa WHERE accountnum = '".$accountnum."'" );

        return $query->row['total'];
    }

}

?>