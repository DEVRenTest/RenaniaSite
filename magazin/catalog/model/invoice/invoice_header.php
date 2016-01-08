<?php

class ModelInvoiceInvoiceHeader extends Model
{

    public function getInvoiceHeader( $invoiceid ) // $customer_ax_code, 
    {
        $invoice_header = array( );

        $query = $this->db->query( "SELECT * FROM B2B_antet_factura WHERE  invoiceid='".$invoiceid."'" );// invoiceaccount LIKE'%".$customer_ax_code."%' AND
        if( $query->row > 0 )
        {
            foreach( $query->rows as $result )
            {
                //$result['b2b_antet_factura_id']
                $invoice_header[] = array(
                    'invoiceid' => $result['invoiceid'],
                    'invoicedate' => $result['invoicedate'],
                    'duedate' => $result['duedate'],
                    'currencycode' => $result['currencycode'],
                    'invoiceamount' => $result['invoiceamount']
                );
            }
        }

        return $invoice_header;
    }

 /*   public function getInvoiceId( $customer_ax_code, $b2b_antet_factura_id )
    {
        $invoice_id = 0;

        $query = $this->db->query( "SELECT invoiceid FROM B2B_antet_factura WHERE invoiceaccount LIKE'%".$customer_ax_code."%' AND b2b_antet_factura_id='".$b2b_antet_factura_id."'" );
        if( $query->row > 0 )
        {
            $invoice_id = $query->row['invoiceid'];
        }

        return $invoice_id;
    }
  */
    
    
    public function getInvoiceAccount(  $invoiceid )
    {
        $invoiceaccount = '';

        $query = $this->db->query( "SELECT invoiceaccount FROM B2B_antet_factura WHERE invoiceid='".$invoiceid."'" );
        if( $query->row > 0 )
        {
            $invoiceaccount = $query->row['invoiceaccount'];
        }

        return $invoiceaccount;
    }
}

?>