<?php

class ControllerModuleCheckoutConfirmation extends Controller
{
    private $error = array();

    public function index()
    {
        $this->save_files();

        $this->send_mail();

        die( "OK" );
    }

    private function save_files()
    {
        if( ! empty( $_FILES ) )
        {
            if( ! empty( $_FILES["tmp_name"] ) )
            {
                if( empty( $_FILES["tmp_name"] ) || ! empty( $_FILES["error"] ) )
                {
                    return;
                }

                $tmp_name = $_FILES["tmp_name"];
                $name = $_FILES["name"];

                $new_name = md5( basename( $tmp_name ).time() )."_".$name;

                @move_uploaded_file( $tmp_name, DIR_SYSTEM."../xmls/".$new_name );
            }
            else
            {
                foreach( $_FILES as $file )
                {
                    if( empty( $file["tmp_name"] ) || ! empty( $file["error"] ) )
                    {
                        continue;
                    }

                    $tmp_name = $file["tmp_name"];
                    $name = $file["name"];

                    $new_name = md5( basename( $tmp_name ).time() )."_".$name;

                    @move_uploaded_file( $tmp_name, DIR_SYSTEM."../xmls/".$new_name );
                }
            }
        }
    }

    private function send_mail()
    {
        $post = print_r( $_POST, TRUE );
        $get = print_r( $_GET, TRUE );
        $server = print_r( $_SERVER, TRUE );
        $files = print_r( $_FILES, TRUE );


        // send a notification message to the site administrator
        $mail = new Mail();
        $mail->protocol = $this->config->get('config_mail_protocol');
        $mail->parameter = $this->config->get('config_mail_parameter');
        $mail->hostname = $this->config->get('config_smtp_host');
        $mail->username = $this->config->get('config_smtp_username');
        $mail->password = $this->config->get('config_smtp_password');
        $mail->port = $this->config->get('config_smtp_port');
        $mail->timeout = $this->config->get('config_smtp_timeout');

        $email_addresses = array();
        $mail->setTo( "lvalics@grafx.ro" );
        $mail->setTo( "cousin@grafx.ro" );

        //            foreach( $email_addresses as $email_address )
        //            {
        //                $mail->setTo( $email_address  );
        //            }

        $mail->setFrom($this->config->get('config_email'));
        $mail->setSender($this->config->get('config_name'));

        $subject = "Takata confirmation test received";
        $message = "Adatok amik jöttek:<br />"
                    ."POST: ".$post."<br /><br />"
                    ."GET: ".$get."<br /><br />"
                    ."FILES: ".$files."<br /><br />"
                    ."SERVER: ".$server."<br /><br />";

        $mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
        $mail->setHtml(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
        $mail->send();
    }
}