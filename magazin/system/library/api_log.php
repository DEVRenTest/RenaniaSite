<?php

class Api_log
{
    private $customer_security_code = '';
    private $content_link = '';
    private $message_types = array('debug', 'info');
    private $is_on = 0;
    private $customer_id = 0;

    public function __construct( $registry )
    {
        $this->config  = $registry->get( 'config' );
        $this->db      = $registry->get( 'db' );
        $this->request = $registry->get( 'request' );

        $this->content_link = $_SERVER['REQUEST_URI'];
        $this->customer_security_code = $this->getCustomerSecurityCode();
        $this->customer_id = $this->getCustomerId();
        $this->is_on = $this->config->get('log_debug');
    }

    /* Se citeste din link codul de securitate a clientului */
    private function getCustomerSecurityCode()
    {
        if( !empty( $this->content_link ) )
        {
            $pos = strpos( $this->content_link, 'key' );
            if( $pos != FALSE )
            {
                $this->customer_security_code = substr( $this->content_link, $pos + strlen( 'key' ) + 1, 10 );
            }
        }

        return $this->customer_security_code;
    }

    /* Este folosit pt validarea tipului mesajului */
    public function write( $message, $type )
    {
        // se verifica daca tipul mesajului se gaseste in array-ul message_types predefinit
        if ( !in_array( $type , $this->message_types ) )
        {
            return;
        }

        // se apeleaza fctia care salveaza datele, in fctie de valoarea variabilei type
        $function = "save".ucfirst( $type );
        $this->$function( $message );
    }

    /* Salvarea mesajelor de tip - debug - */
    private function saveDebug( $message )
    {
        // se verifica daca debug-ul in tabelul oc_setting este activat, si daca este de tip debug
        if( ! $this->is_on || $this->is_on == 2 )
        {
            return;
        }

        $this->saveLog( $message, "debug" );
    }

    /* Salvarea mesajelor de tip - info - */
    private function saveInfo( $message )
    {
        // se verifica daca debug-ul in tabelul oc_setting este activat, si daca este de tip info
        if( ! $this->is_on || $this->is_on == 1 )
        {
            return;
        }

        $this->saveLog( $message, "info" );
    }

    /* Salvarea datelor */
    private function saveLog( $message, $type )
    {
        $this->db->query(
            "INSERT INTO api_log
              SET link = '" . $this->db->escape( $this->content_link ) . "',
              customer_id = '".$this->customer_id."',
              customer_security_code = '" . $this->db->escape( $this->customer_security_code ) . "',
              ip_address = '" . $this->request->server['REMOTE_ADDR'] . "',`type` = '" . $type . "',
              message = '" . $message . "',
              date_added = NOW()" );
    }

    /* Returneaza id-ul clientului care detine codul md5*/
    private function getCustomerId()
    {
        $query = $this->db->query("SELECT customer_id FROM api_customer_access WHERE customer_security_code = '".$this->customer_security_code."'");
        if( $query->num_rows!= 0 )
        {
            foreach( $query->rows as $result )
            {
                $this->customer_id = $result['customer_id'];
            }
        }

        return $this->customer_id;
    }
}
