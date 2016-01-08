<?php

class ControllerAccountNotifyCustomerAboutStock extends Controller
{
    public function index()
    {
        $query = $this->db->query( "SELECT * FROM " . DB_PREFIX . "customer_notification WHERE alert = 0 " );
        if( $query->num_rows > 0 )
        {
            foreach( $query->rows as $result )
            {
                $notification_data[] = array(
                    'type' => $result['type'],
                    'product_id' => $result['product_id'],
                    'id' => ( int ) $result['id'],
                    'description' => $result['description'],
                    'customer_id' => ( int ) $result['customer_id'],
                    'customer_email' => $result['customer_email']
                );
            }
        }

        $this->load->model( 'account/customer_notification' );
        foreach( $notification_data as $data )
        {
            if ( $data['type'] == 1 )// simple product
            {
                $query = $this->db->query( "SELECT quantity FROM " . DB_PREFIX . "product WHERE product_id='".$data['id']."'" );
                if( $query->num_rows > 0 )
                {
                    if( $query->row['quantity'] > 0)
                    {
                        $this->sendNotification( $data['customer_email'], $data['description'], $data['product_id'] );
                         $this->model_account_customer_notification->updateAlertField( $data['id'] );   
                    }
                }
            }
            else if ( $data['type'] == 2 )// product with option
            {
                $query = $this->db->query( "SELECT quantity FROM " . DB_PREFIX . "product_option_value WHERE product_option_value_id='".$data['id']."'");
                if( $query->num_rows > 0 )
                {
                    if( $query->row['quantity'] > 0)
                    {
                        $this->sendNotification( $data['customer_email'], $data['description'], $data['product_id'] );
                         $this->model_account_customer_notification->updateAlertField( $data['id'] );   
                    }
                }
            }
            else if ( $data['type'] == 3 )// product with option combination
            {
                $query = $this->db->query( "SELECT stock FROM " . DB_PREFIX . "product_option_combination WHERE product_option_combination_id='".$data['id']."'");
                if( $query->num_rows > 0 )
                {
                    if( $query->row['stock'] > 0)
                    {
                        $this->sendNotification( $data['customer_email'], $data['description'], $data['product_id'] );
                        $this->model_account_customer_notification->updateAlertField( $data['id'] );   
                    }
                }
            }
        }
        
        print "OK";
        
    }
    
    
    private function sendNotification( $email, $description, $product_id )
    {
        $mail = new Mail();
        $mail->protocol = $this->config->get('config_mail_protocol');
        $mail->parameter = $this->config->get('config_mail_parameter');
        $mail->hostname = $this->config->get('config_smtp_host');
        $mail->username = $this->config->get('config_smtp_username');
        $mail->password = $this->config->get('config_smtp_password');
        $mail->port = $this->config->get('config_smtp_port');
        $mail->timeout = $this->config->get('config_smtp_timeout');			
                    
        $mail->setTo( $email);
        $mail->setFrom($this->config->get('config_email'));
        $mail->setSender($this->config->get('config_name'));

        $this->language->load( 'account/notify_customer_about_stock' );    
        
        $subject = $this->language->get('text_mail_subject');
        $message = $this->language->get('text_hello')."<br><br>";
        $message .= $this->language->get('text_product_you_are_looking')." - <strong>";
        $message .= $description;
        $message .= " - </strong>".$this->language->get('text_reached_in_stock')."<br>";
        $message .= $this->language->get('text_you_can_visit')."<br>";
        $message .= '<a href="'.$this->url->link( 'product/product', 'product_id='.$product_id).'">'.$this->url->link( 'product/product', 'product_id='.$product_id).'</a><br>';
        $message .= $this->language->get('text_to_order')."<br><br>";
        $message .= $this->language->get('text_best_regards')."<br>";
        $message .= $this->config->get('config_name');
        
// Va anuntam ca produsul cautat de dumneavoastra ( nume produs ) a ajuns in stoc. Puteti vizita ( pagina produsului ) pentru a-l comanda.

        $mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
        $mail->setHtml(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
        $mail->send();   
    }

}

?>