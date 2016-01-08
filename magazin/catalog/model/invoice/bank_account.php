<?php

class ModelInvoiceBankAccount extends Model
{

    public function getBankAccount( $customer_ax_code )
    {
        $iban_code = array( );

        $query = $this->db->query( "SELECT iban FROM B2B_cont_bancar WHERE custaccount LIKE'%".$customer_ax_code."%' " ); // b2b_cont_bancar_id,
        if( $query->row > 0 )
        {
            foreach( $query->rows as $result )
            {
                //$result['b2b_cont_bancar_id']
                $iban_code[] = array(
                    'iban' => $result['iban']
                );
            }
        }

        return $iban_code;
    }

    public function getAllBankAccount( $customer_ax_code )
    {
        $iban_code = array( );

        $query = $this->db->query( "SELECT * FROM B2B_cont_bancar WHERE custaccount LIKE'%".$customer_ax_code."%' " ); // b2b_cont_bancar_id,
        if( $query->row > 0 )
        {
            foreach( $query->rows as $result )
            {
                $iban_code[] = array(
                    'custaccount' => $result['custaccount'],
                    'iban' => $result['iban']
                );
            }
        }

        return $iban_code;
    }

    public function getTotalBankAccounts( $customer_ax_code )
    {
        $query = $this->db->query( "SELECT COUNT(*) AS total FROM B2B_cont_bancar WHERE custaccount LIKE'%".$customer_ax_code."%' " );

        return $query->row['total'];
    }

    public function deleteBankAccount( $customer_ax_code, $iban )
    {
        $this->db->query( "DELETE FROM B2B_cont_bancar WHERE custaccount = '".$customer_ax_code."' AND iban = '". $iban."'" );
    }
    
    
    public function addBankAccount( $data, $customer_ax_code )
    {

        $this->db->query( "INSERT INTO B2B_cont_bancar SET accountnum = '".$customer_ax_code."', iban = '". $this->db->escape( $data['iban'] )."' " );
    }


}

?>