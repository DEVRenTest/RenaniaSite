<?php

class ModelInvoiceInvoiceDueDate extends Model
{

    public function getInvoiceDueDate( $customer_ax_code )
    {
        $invoice_due_date = array( );

        $query = $this->db->query( "SELECT * FROM B2B_factura_scadenta WHERE client LIKE'%".$customer_ax_code."%' " );
        if( $query->row > 0 )
        {
            foreach( $query->rows as $result )
            {
                //$result['b2b_factura_scadenta_id']
                $invoice_due_date[] = array(
                    'client' => $result['client'],
                    'tipdoc' => $result['tipdoc'],
                    'nrdoc' => $result['nrdoc'],
                    'datadoc' => $result['datadoc'],
                    'scadentadoc' => $result['scadentadoc'],
                    'moneda' => $result['moneda'],
                    'suma' => $result['suma']
                );
            }
        }

        return $invoice_due_date;
    }

}

?>