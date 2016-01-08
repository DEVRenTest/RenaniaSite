<?php

class ModelInvoiceInvoiceLines extends Model
{

    public function getInvoiceLines( $customer_ax_code )
    {
        $invoice_lines = array( );

        $query = $this->db->query( "SELECT * FROM B2B_linie_factura WHERE invoiceaccount LIKE'%".$customer_ax_code."%' " );
        if( $query->row > 0 )
        {
            foreach( $query->rows as $result )
            {
                //$result['b2b_linie_factura_id']
                $invoice_lines[] = array(
                    'invoiceid' => $result['invoiceid'],
                    'linenum' => $result['linenum'],
                    'codart' => $result['codart'],
                    'itemname' => $result['itemname'],
                    'qty' => $result['qty'],
                    'salesunit' => $result['salesunit'],
                    'calcnetunitprice' => $result['calcnetunitprice'],
                    'lineamount' => $result['lineamount'],
                );
            }
        }

        return $invoice_lines;
    }

    public function getInvoiceLinesForOneInvoice( $customer_ax_code, $invoice_id )
    {
        $invoice_lines = array( );

        $query = $this->db->query( "SELECT * FROM B2B_linie_factura WHERE invoiceaccount LIKE'%".$customer_ax_code."%' AND invoiceid='".$invoice_id."' ORDER BY linenum ASC;" );
        
        if( $query->row > 0 )
        {
            foreach( $query->rows as $result )
            {
                //$result['b2b_linie_factura_id']
                $invoice_lines[] = array(
                    'linenum' => $result['linenum'],
                    'codart' => $result['codart'],
                    'itemname' => $result['itemname'],
                    'qty' => $result['qty'],
                    'salesunit' => $result['salesunit'],
                    'calcnetunitprice' => $result['calcnetunitprice'],
                    'lineamount' => $result['lineamount'],
                );
            }
        }

        return $invoice_lines;
    }

}

?>