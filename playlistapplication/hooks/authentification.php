<?php
	
	class Authentification{
		var $CI;

		public function __construct() {
			$this->CI =& get_instance();

			if (!isset($this->CI->session))
		        $this->CI->load->library('session');
		}

		public function check_if_auth() {
			if($this->CI->router->class != 'auth') {
				if(!$this->CI->session->userdata('user_mail')){
					// $this->CI->session->set_flashdata('flash', "Vous devez vous connecter pour accéder au site.");
					redirect('login');
				} else {
					return true;
				}
			} else {
				if($this->CI->router->method == 'index') {
					if($this->CI->session->userdata('user_mail')){
						redirect('/');
					}
				}
			}
		}		

	}

?>