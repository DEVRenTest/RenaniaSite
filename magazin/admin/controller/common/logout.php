<?php       
class ControllerCommonLogout extends Controller {   
	public function index() { 
    	$this->user->logout();
 
 		unset($this->session->data['token']);
    
    // septembrie
    unset( $this->session->data['login_validation_code_sent_for_admin'] );
    unset( $this->session->data['login_validation_code_ok_for_admin'] );

    $this->session->data['from'] = 'logout';
		$this->redirect($this->url->link('common/login', '', 'SSL'));
  	}
}  
?>