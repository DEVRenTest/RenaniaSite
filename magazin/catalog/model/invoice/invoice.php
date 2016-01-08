<?php

class ModelInvoiceInvoice extends Model
{

    public function getTotalInvoices( $customer_ax_code, $invoice_type = '', $permission, $tax_id, $filter_by = '', $filter_value = '' )
    {
        if( empty( $invoice_type ) )
        {
            $invoice_type = "all";
        }

        $sql_plus = "";
        
        $sql_filter = "";
        if( !empty( $filter_by ) )
        {
            if( $filter_by == "invoice_number" ) 
            {
                $sql_filter .= " AND invoiceid LIKE '%".trim($filter_value)."%' ";
            }
            else if( $filter_by == "invoice_date" ) 
            {
                $sql_filter .= " AND invoicedate LIKE '%".$filter_value."%' ";
            }
            else if( $filter_by == "invoice_due_date" ) 
            {
                $sql_filter .= " AND duedate LIKE '%".$filter_value."%' ";
            }
        }

        if( $permission == 'full' )
        {
            $agent_ids = $this->getAgentWithSameTaxId( $tax_id );
            $sql_plus = $this->agentFilter( $agent_ids );
            $where = "WHERE invoiceaccount in ( select accountnum FROM `B2B_client` WHERE `vatnum` = '".$tax_id."')";
        } else {
            $where = "WHERE (invoiceaccount = '".$customer_ax_code."' ".$sql_plus.") ".$sql_filter;
        }
		
	 //if( $_SERVER['REMOTE_ADDR'] == '5.2.202.87' ){
	 //print $sql_filter; die();
	// }
       
        
        if( $invoice_type == "all" )
        {
            $query = $this->db->query( "SELECT COUNT(*) AS total FROM B2B_antet_factura as baf
                                        LEFT JOIN  B2B_factura_scadenta as bfs ON bfs.nrdoc= baf.invoiceid
                                        ".$where.";");

            /*$query = $this->db->query( "SELECT COUNT(*) AS total FROM `B2B_antet_factura` as baf
                                        LEFT JOIN  B2B_factura_scadenta as bfs ON bfs.nrdoc= baf.invoiceid
                                        WHERE invoiceaccount in ( select accountnum FROM `B2B_client` WHERE `vatnum` = '".$tax_id."'". $sql_filter  );*/
        }
        else if( $invoice_type == "unpaid_over_due_date" )
        {
            $query = $this->db->query( "SELECT COUNT(*) AS total FROM `B2B_antet_factura` as baf
                                        JOIN  B2B_factura_scadenta as bfs ON bfs.nrdoc= baf.invoiceid
                                        ".$where." AND duedate < SUBSTRING( NOW(), 1, 10) " );
        }
        else if( $invoice_type == "unpaid_in_due_date" )
        {
            $query = $this->db->query( "SELECT COUNT(*) AS total FROM `B2B_antet_factura` as baf
                                        JOIN  B2B_factura_scadenta as bfs ON bfs.nrdoc= baf.invoiceid
                                        ".$where." AND duedate >= SUBSTRING( NOW(), 1, 10) " );
        }
        else if( $invoice_type == "cashed" )
        {            
            $query = $this->db->query( "SELECT COUNT(*) AS total,bfs.nrdoc as payment_status FROM `B2B_antet_factura` as baf
                                        LEFT JOIN  B2B_factura_scadenta as bfs ON bfs.nrdoc= baf.invoiceid
                                        ".$where." AND bfs.nrdoc is NULL " );
        }
        
//                print "SELECT COUNT(*) AS total FROM B2B_antet_factura as baf
//                                        LEFT JOIN  B2B_factura_scadenta as bfs ON bfs.nrdoc= baf.invoiceid
//                                        WHERE (invoiceaccount = '".$customer_ax_code."' ".$sql_plus.")" . $sql_filter ;
//        die();

        
        return $query->row['total'];
    }

    public function getInvoices( $start = 0, $limit = 20, $customer_ax_code, $invoice_type = '', $permission, $tax_id, $filter_by = '', $filter_value = '' )
    {
        if( $start < 0 )
        {
            $start = 0;
        }

        if( $limit < 1 )
        {
            $limit = 1;
        }

        if( empty( $invoice_type ) )
        {
            $invoice_type = "all";
        }

    /*    if( $invoice_type == "all" )
        {
            $query = $this->db->query( "SELECT baf.*, bfs.b2b_factura_scadenta_id as payment_status FROM B2B_antet_factura as baf
                                        LEFT JOIN  B2B_factura_scadenta as bfs ON bfs.nrdoc= baf.invoiceid
                                        WHERE (invoiceaccount = '".$customer_ax_code."' ".$sql_plus.") ORDER BY invoicedate DESC,invoiceid DESC LIMIT ".( int ) $start.",".( int ) $limit );
        }
        else if( $invoice_type == "unpaid_over_due_date" )
        {
            $query = $this->db->query( "SELECT baf.*, bfs.b2b_factura_scadenta_id as payment_status FROM B2B_antet_factura as baf
                                        JOIN  B2B_factura_scadenta as bfs ON bfs.nrdoc= baf.invoiceid
                                        WHERE (invoiceaccount = '".$customer_ax_code."' ".$sql_plus.") AND duedate < SUBSTRING( NOW(), 1, 10) ORDER BY invoicedate DESC,invoiceid DESC LIMIT ".( int ) $start.",".( int ) $limit );
        }
        else if( $invoice_type == "unpaid_in_due_date" )
        {
            $query = $this->db->query( "SELECT baf.*, bfs.b2b_factura_scadenta_id as payment_status FROM B2B_antet_factura as baf
                                        JOIN  B2B_factura_scadenta as bfs ON bfs.nrdoc= baf.invoiceid
                                        WHERE (invoiceaccount = '".$customer_ax_code."' ".$sql_plus.") AND duedate >= SUBSTRING( NOW(), 1, 10) ORDER BY invoicedate DESC,invoiceid DESC LIMIT ".( int ) $start.",".( int ) $limit );            
        }
        else if( $invoice_type == "cashed" )
        {
            $query = $this->db->query( "SELECT baf.*, bfs.b2b_factura_scadenta_id as payment_status FROM B2B_antet_factura as baf
                                        LEFT JOIN  B2B_factura_scadenta as bfs ON bfs.nrdoc= baf.invoiceid
                                        WHERE (invoiceaccount = '".$customer_ax_code."' ".$sql_plus.") AND bfs.b2b_factura_scadenta_id is NULL ORDER BY invoicedate DESC,invoiceid DESC LIMIT ".( int ) $start.",".( int ) $limit );
        }
     * */
        
        $sql_filter = '';
        //if( $_SERVER['REMOTE_ADDR'] == '188.26.23.46' )        {
            if( !empty( $filter_by ) )
            {
                if( !empty( $filter_by ) )
                {
                    if( $filter_by == "invoice_number" ) 
                    {
                        $sql_filter .= " AND invoiceid LIKE '%".trim($filter_value)."%' ";
                    }
                    else if( $filter_by == "invoice_date" ) 
                    {
                        $sql_filter .= " AND invoicedate LIKE '%".$filter_value."%' ";
                    }
                    else if( $filter_by == "invoice_due_date" ) 
                    {
                        $sql_filter .= " AND duedate LIKE '%".$filter_value."%' ";
                    }

                }
            }   
        //}

        $sql_plus = "";
        if( $permission == 'full' )
        {
            $agent_ids = $this->getAgentWithSameTaxId( $tax_id );
            $sql_plus = $this->agentFilter( $agent_ids );
            $where = "WHERE invoiceaccount in ( select accountnum FROM `B2B_client` WHERE `vatnum` = '".$tax_id."')";
        } else {
            $where = "WHERE (invoiceaccount = '".$customer_ax_code."' ".$sql_plus.") ".$sql_filter;
        }
        
        if( $invoice_type == "all" )
        {
            /*$query = $this->db->query( "SELECT baf.*, bfs.nrdoc as payment_status FROM B2B_antet_factura as baf
                                        LEFT JOIN  B2B_factura_scadenta as bfs ON bfs.nrdoc= baf.invoiceid
                                        WHERE (invoiceaccount = '".$customer_ax_code."' ".$sql_plus.") ".$sql_filter." ORDER BY invoicedate DESC,invoiceid DESC LIMIT ".( int ) $start.",".( int ) $limit );*/

            $query = $this->db->query( "SELECT baf.*, bfs.nrdoc as payment_status FROM `B2B_antet_factura` as baf
                                        LEFT JOIN  B2B_factura_scadenta as bfs ON bfs.nrdoc= baf.invoiceid
                                        ".$where."
                                        ORDER BY invoicedate DESC,invoiceid DESC LIMIT ".( int ) $start.",".( int ) $limit.";");

        }
        else if( $invoice_type == "unpaid_over_due_date" )
        {
            $query = $this->db->query( "SELECT baf.*, bfs.nrdoc as payment_status FROM B2B_antet_factura as baf
                                        JOIN  B2B_factura_scadenta as bfs ON bfs.nrdoc= baf.invoiceid
                                        ".$where." AND duedate < SUBSTRING( NOW(), 1, 10) ORDER BY invoicedate DESC,invoiceid DESC LIMIT ".( int ) $start.",".( int ) $limit );
        }
        else if( $invoice_type == "unpaid_in_due_date" )
        {
            $query = $this->db->query( "SELECT baf.*, bfs.nrdoc as payment_status FROM B2B_antet_factura as baf
                                        JOIN  B2B_factura_scadenta as bfs ON bfs.nrdoc= baf.invoiceid
                                        ".$where." AND duedate >= SUBSTRING( NOW(), 1, 10) ORDER BY invoicedate DESC,invoiceid DESC LIMIT ".( int ) $start.",".( int ) $limit );
        }
        else if( $invoice_type == "cashed" )
        {
            $query = $this->db->query( "SELECT baf.*, bfs.nrdoc as payment_status FROM B2B_antet_factura as baf
                                        LEFT JOIN  B2B_factura_scadenta as bfs ON bfs.nrdoc= baf.invoiceid
                                        ".$where." AND bfs.nrdoc is NULL ORDER BY invoicedate DESC,invoiceid DESC LIMIT ".( int ) $start.",".( int ) $limit );
        }

        return $query->rows;
    }

    private function getAgentWithSameTaxId( $tax_id )
    {
        $agent_id = array( );
        $query = $this->db->query( "SELECT c.customer_id as id, ax_code FROM oc_customer as c LEFT JOIN oc_address as adr ON (c.customer_id = adr.customer_id) WHERE adr.tax_id = '".$tax_id."' " );
        $agent_id = array( );
        if( $query->num_rows > 0 )
        {
            foreach( $query->rows as $result )
            {
                $agent_id[] = array(
                    'id' => $result['id'],
                    'ax_code' => $result['ax_code']
                );
            }
        }


        return $agent_id;
    }

    private function agentFilter( $agent_ids )
    {
        $sql_plus = "";

        foreach( $agent_ids as $agent_id )
        {
//            if( !empty( $agent_id['ax_code'] ) )
//            {
            $sql_plus .= " OR invoiceaccount = '".$agent_id['ax_code']."' ";
//            }
        }

        return $sql_plus;
    }
    
   

}

?>