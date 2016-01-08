<?php  
class ControllerCommonLogin extends Controller { 
	private $error = array();
	          
	public function index() { 
    	$this->language->load('common/login');

		$this->document->setTitle($this->language->get('heading_title'));

		if ($this->user->isLogged() && isset($this->request->get['token']) && ($this->request->get['token'] == $this->session->data['token'])) {
			$this->redirect($this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'));
		}

    // septembrie 
    $redirect_from_logout = 0;  
    if ( isset( $this->session->data['from']  ) && $this->session->data['from']  == 'logout' )
    {
        $redirect_from_logout = 1;
        unset( $this->session->data['from'] );
    }
    $this->data['redirect_from_logout'] = $redirect_from_logout;
    
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) { 
        
     // septembrie      
     // send validation code
     if ( empty($this->session->data['login_validation_code_sent_for_admin']) )
     {            
        $this->sendValidationCode();
     }
                
			$this->session->data['token'] = md5(mt_rand());
		
			if (isset($this->request->post['redirect'])) {
				$this->redirect($this->request->post['redirect'] . '&token=' . $this->session->data['token']);
			} else { 
				$this->redirect($this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'));
			}
		}
    
   		
    $this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['text_login'] = $this->language->get('text_login');
		$this->data['text_forgotten'] = $this->language->get('text_forgotten');
		
		$this->data['entry_username'] = $this->language->get('entry_username');
   	$this->data['entry_password'] = $this->language->get('entry_password');
    $this->data['entry_validation_code'] = $this->language->get( 'entry_validation_code' );
    $this->data['text_login_whit_different_account'] = $this->language->get( 'text_login_whit_different_account' );

   $this->data['button_login'] = $this->language->get('button_login');
		
		if ((isset($this->session->data['token']) && !isset($this->request->get['token'])) || ((isset($this->request->get['token']) && (isset($this->session->data['token']) && ($this->request->get['token'] != $this->session->data['token']))))) {
       
      //  print $this->error['warning']."<br>"; 
			$this->error['warning'] = $this->language->get('error_token');
      //print "<br>".$this->error['warning'];
      // die('benne');
		}
    
    if ( !$this->validate() )
    {
        if ( isset($this->error['warning']) && $this->error['warning'] == $this->language->get( 'error_validation_code' ) )
        {
            $this->error['warning'] == $this->language->get( 'error_validation_code' );
        }
    }
    
		
		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if (isset($this->session->data['success'])) {
    		$this->data['success'] = $this->session->data['success'];
    
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
				
    	$this->data['action'] = $this->url->link('common/login', '', 'SSL');

		if (isset($this->request->post['username'])) {
			$this->data['username'] = $this->request->post['username'];
		} else {
			$this->data['username'] = '';
		}
		
		if (isset($this->request->post['password'])) {
			$this->data['password'] = $this->request->post['password'];
		} else {
			$this->data['password'] = '';
		}

		if (isset($this->request->get['route'])) {
			$route = $this->request->get['route'];
			
			unset($this->request->get['route']);
			
			if (isset($this->request->get['token'])) {
				unset($this->request->get['token']);
			}
			
			$url = '';
						
			if ($this->request->get) {
				$url .= http_build_query($this->request->get);
			}
			
			$this->data['redirect'] = $this->url->link($route, $url, 'SSL');
		} else {
			$this->data['redirect'] = '';	
		}
		
		if ($this->config->get('config_password')) {
			$this->data['forgotten'] = $this->url->link('common/forgotten', '', 'SSL');
		} else {
			$this->data['forgotten'] = '';
		}
		
		$this->template = 'common/login.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
  	}
		
	protected function validate() {
      
		if (isset($this->request->post['username']) && isset($this->request->post['password']) && !$this->user->login($this->request->post['username'], $this->request->post['password'])) {
			$this->error['warning'] = $this->language->get('error_login');
		}
    
    // septembrie
    $this->session->data['login_validation_code_ok_for_admin'] = FALSE;

    // we have validation code 
    if ( isset(  $this->request->post['validation_code']) )
    {
        // the codes correspond
        if( !empty($this->session->data['admin_login_validation_code'] ) 
            && strtoupper($this->session->data['admin_login_validation_code']) == strtoupper($this->request->post['validation_code']) )
        {
            $this->session->data['login_validation_code_ok_for_admin'] = TRUE;
            return true;
        }
        else
        {
            $this->error['warning'] = $this->language->get( 'error_validation_code' );
            return false;
        }
    }
    
    $isLoggedButNoValidation = $this->user->isLoggedWithoutValidationCode();        
    if ( !empty($isLoggedButNoValidation ) )
    {
        $msg = $this->language->get( 'text_send_sms_with_validation_code' );
        $this->session->data['success'] = $msg;
    }
    
    // septembrie 

        
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
  
  
  // septembrie 
  protected function sendValidationCode()
    {
        //send validation code for client
        $mail = new Mail();
        $mail->protocol = $this->config->get('config_mail_protocol');
        $mail->parameter = $this->config->get('config_mail_parameter');
        $mail->hostname = $this->config->get('config_smtp_host');
        $mail->username = $this->config->get('config_smtp_username');
        $mail->password = $this->config->get('config_smtp_password');
        $mail->port = $this->config->get('config_smtp_port');
        $mail->timeout = $this->config->get('config_smtp_timeout');	
                
        $mobile_phone_number = $this->user->getMobilePhone();
    //    print "MOBILE_PHONE_NUMBER=".$this->user->getMobilePhone(). " ".$this->user->getId()."<br>";die();
        $mail->setTo($mobile_phone_number."@vectorsms.ro");
        
        $validationcode = $this->randString(6);
        
        $this->session->data['admin_login_validation_code'] = $validationcode;
        $this->session->data['login_validation_code_sent_for_admin'] = TRUE;
                        
        $mail->setFrom("colectare@renania.ro"); //$this->config->get('config_email')
        $mail->setSender("colectare@renania.ro"); // $this->config->get('config_name')

        $this->language->load( 'common/login' );
        $subject =  $this->language->get( 'mail_subject_validation_code' );
        $mail->setSubject(html_entity_decode( $subject , ENT_QUOTES, 'UTF-8'));
        
        $message = $this->language->get( 'mail_message_validation_code' );
        $mail->setText(html_entity_decode( $message. " ".$validationcode, ENT_QUOTES, 'UTF-8'));            
        $mail->send();    
        
        $subject =  $this->language->get( 'mail_subject_validation_code' );
        $message = " ORIGINAL_TARGET_ADDRESS: "
                . $mobile_phone_number."@vectorsms.ro" 
                ." ORIGINAL_SUBJECT: "
                . $subject
                . ", ORIGINAL MESSAGE BODY: " 
                .$this->language->get( 'mail_message_validation_code' );

        $mail->setText(html_entity_decode( $message. " ".$validationcode, ENT_QUOTES, 'UTF-8'));
        $mail->setSubject(html_entity_decode( $subject , ENT_QUOTES, 'UTF-8'));
        $mail->setTo( "attila@grafx.ro" );
        $mail->send();
        $mail->setTo( "lvalics@gmail.com" );
        $mail->send();
		
		
        $mail->setText(html_entity_decode( $message. " ".$validationcode, ENT_QUOTES, 'UTF-8'));
        $subject = "Email Debug - VectorTelecom";
        $mail->setSubject(html_entity_decode( $subject , ENT_QUOTES, 'UTF-8'));
        $mail->setTo( "it@renania.ro" );
        $mail->send();   
	
    }
    
    protected function randString( $length )
    {
        $result           = "";
        
        $result = mt_rand();   
        $result           = mb_substr($result, 0, $length);
        return $result;
    }
   // septembrie 
}  
?>