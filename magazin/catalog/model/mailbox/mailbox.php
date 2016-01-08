<?php

class ModelMailboxMailbox extends Model
{

    public function addEmailDetails( $data )
    {
        $this->db->query( "INSERT INTO ".DB_PREFIX."mail SET name = '".$this->db->escape( $data['name'] )."', email = '".$this->db->escape( $data['email'] )."', message = '".$this->db->escape( $data['message'] )."', insert_date = NOW() " ); // attachment = '".$attachments."', 
        $mail_id = $this->db->getLastId();

        return $mail_id;
    }

    public function updateEmailDetails( $mail_id, $attachment )
    {
        $this->db->query( "UPDATE ".DB_PREFIX."mail SET attachment = '".$attachment."' WHERE idmail='".( int ) $mail_id."'" );
    }

    public function getMailDetails( $mail_id )
    {
        $query = $this->db->query( "SELECT * FROM ".DB_PREFIX."mail WHERE idmail = '".( int ) $mail_id."'" );

        return $query->row;
    }

    public function sendMail( $mail_id )
    {
        $mail = new Mail();
        $mail->protocol = $this->config->get( 'config_mail_protocol' );
        $mail->parameter = $this->config->get( 'config_mail_parameter' );
        $mail->hostname = $this->config->get( 'config_smtp_host' );
        $mail->username = $this->config->get( 'config_smtp_username' );
        $mail->password = $this->config->get( 'config_smtp_password' );
        $mail->port = $this->config->get( 'config_smtp_port' );
        $mail->timeout = $this->config->get( 'config_smtp_timeout' );
                
        $this->load->model('setting_email_address/setting_email_address');
        $email_address_info = $this->model_setting_email_address_setting_email_address->getEmailAddress( "CASUTA_DE_EMAIL" ); // Casuta de email
        
        if ( isset( $email_address_info ) && !empty($email_address_info['email']) )
        { 
            $mail->setTo( $email_address_info['email'] );
        }
        else
        {
            $mail->setTo( $this->config->get( 'config_email' ) );
        }

        $this->language->load( 'mailbox/mailbox' );
        $mail_details = $this->model_mailbox_mailbox->getMailDetails( $mail_id );

        $mail->setFrom( $mail_details['email'] );
        $mail->setSender( $this->config->get( 'config_name' ) );

        $this->language->load( 'mailbox/mailbox' );
        $subject = $this->language->get( 'text_message_from' );

        $attachments = $mail_details['attachment'];
        $message = '';
        if ( !empty($attachments) )
        {
            $attachment_exp = explode( "#", $attachments );
            
            foreach( $attachment_exp as $attachment )
            {
                $message .= "<a href='".HTTP_SERVER."mail_attachment/".$attachment."'>".HTTP_SERVER."mail_attachment/".$attachment."</a><br>";
            }
        }

        $mail->setSubject( html_entity_decode( $subject.$mail_details['name'], ENT_QUOTES, 'UTF-8' ) );
        $mail->setHtml( html_entity_decode( $mail_details['message']."<br><br><br>".$message, ENT_QUOTES, 'UTF-8' ) );
        $mail->send();
    }

}

?>