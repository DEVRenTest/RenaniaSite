<?php
class Session {
	public $data = array();
			
  	public function __construct() {		
		if (!session_id()) {
			ini_set('session.use_cookies', 'On');
			ini_set('session.use_trans_sid', 'Off');

            ini_set('session.cookie_domain', substr($_SERVER['SERVER_NAME'],strpos($_SERVER['SERVER_NAME'],"."),100));
            
			
			
                    session_name( "customer_login" );
                    ini_set('session.cookie_domain', '.renania.ro');
                    //session_set_cookie_params(0, rtrim(dirname($_SERVER['PHP_SELF'])), '.' . str_replace('www.', '', $_SERVER['HTTP_HOST']));
                    //session_set_cookie_params(86400, '/', '.renania.ro');
                    session_set_cookie_params(0, '/');
                
			session_start();
		}
			
		$this->data =& $_SESSION;
	}
	
	function getId() {
		return session_id();
	}
}
?>
