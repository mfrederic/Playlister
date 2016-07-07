<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function index()
	{
		$this->load->helper('form');
		$this->layout = 'auth';

		$this->data['title'] .= ' - Connexion au site';
		$this->data['scripts'] = array('jquery');

		$this->render('auth/index', $this->data);
	}

	public function login() {
		$this->load->library('encrypt');
		$this->load->model('User_model');
		// $this->session->set_flashdata('flash', 'Test');

		$this->User_model->user_mail = $this->input->post('login');
		$user = $this->User_model->get_user_from_mail();

		if(!empty($user)) {
			$decrypt = $this->encrypt->decode($user->user_password);

			if($decrypt == $this->input->post('password')) {
				$this->session->set_userdata($user);
				redirect('/');
			}
		}

		$this->session->set_flashdata('flash', 'Les identifiants indiqués sont incorrectes.');

		redirect('login');
	}

	public function logout() {
		$this->load->model('User_model');
		$user = $this->User_model->get_null();

		$this->session->unset_userdata($user);
		redirect('login');
	}

}