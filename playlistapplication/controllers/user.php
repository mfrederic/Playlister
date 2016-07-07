<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

	public function index() {
		$this->load->helper('form', 'security');
		$this->load->model('User_model');
		$this->load->model('Playlist_model');
		$this->load->model('Playlistmusic_model');

		$post = array();
		foreach ( $_POST as $key => $value )
			$post[$key] = $this->input->post($key);

		$this->data['user'] = $this->User_model->get_user_from_id($this->session->userdata('user_id'));
		$this->data['post'] = $post;
		$this->data['token_key'] = $this->security->get_csrf_hash();
		$this->data['playlists'] = $this->Playlist_model->get_by_adder_id($this->session->userdata('user_id'));
		foreach ($this->data['playlists'] as $key => $p)
			$this->data['playlists'][$key]->musics = $this->Playlistmusic_model->get_music_of_playlist($p->playlist_id);

		$this->data['view_informations'] = $this->partial('user/informations', $this->data);
		$this->data['view_playlists'] = $this->partial('user/playlists', $this->data);

		$this->render('user/index', $this->data);
	}

	public function update() {
		$this->load->library('encrypt');
		$this->load->model('User_model');

		$this->User_model->user_id = $this->session->userdata('user_id');
		$response = array('content' => '');
		$user_info = array(
			'user_mail' => $this->input->post('mail'),
			'user_firstname' => $this->input->post('firstname'),
			'user_lastname' => $this->input->post('lastname')
		);

		$pass1 = $this->input->post('password1');
		if(!empty($pass1)) {
			if(strlen($pass1) < 6) {
				$response['content'] = "<li>Le mot de passe fourni est trop court !</li>";
			} elseif($pass1 == $this->input->post('password2')) {
				$user_info['user_password'] = $this->encrypt->encode($pass1);
				$response['content'] .= '<li>Le mot de passe a été mis à jour.</li>';
 			}
		}

		$this->User_model->update_user($user_info);
		$response['content'] .= "<li>Les informations ont été mises à jour.</li>";

		$new_user = $this->User_model->get_user_from_id($this->session->userdata('user_id'));
		$this->session->set_userdata($new_user);

		$this->output->set_header('Content-type: application/json');
		echo json_encode($response);
	}

	public function playlist_poster() {
		$this->load->model('Playlist_model');

		$poster = $this->input->post('playlist_img');
		$poster = (empty($poster)) ? base_url() . 'assets/images/album-art-missing.png' : $poster;
		$this->Playlist_model->playlist_id = $this->input->post('playlist_id');
		$this->Playlist_model->update_poster($poster);

		$response = array(
			'retour' => true,
			'content' => "L'image de la playlist a été mise à jour.",
			'poster' => $poster
		);

		if($this->db->affected_rows() !== 1) {
			$response = array(
				'retour' => false,
				'content' => "Une erreur est survenue lors de la mise à jour de l'image."
			);
		}

		$this->output->set_header('Content-type: application/json');
		echo json_encode($response);
	}

	public function playlist_update($id) {
		$this->load->helper('form', 'security');
		$this->load->model('Playlist_model');
		$this->data['playlist'] = $this->Playlist_model->get_by_id($id);

		echo $this->partial('user/_update_playlist', $this->data);
	}

}

?>