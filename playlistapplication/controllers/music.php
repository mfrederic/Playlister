<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Music extends CI_Controller {

	public function index() {
		$this->load->helper('form', 'security');
		$this->load->model('Music_model', 'Music');
		$this->load->model('Musicstyle_model', 'Musicstyle');
		$this->load->model('Style_model', 'Style');

		$musics = $this->Music->get_all_by_adder_id($this->session->userdata('user_id'));

		foreach ($musics as $index => $music) {
			$styles = $this->Musicstyle->get_style_of_music($music->music_id);
			$musics{$index}->styles = $styles;
		}

		$this->data['musics'] = $musics;
		$this->data['add_to_playlist'] = $this->partial('library/add_to_playlist', $this->data);
		$this->data['token'] = $this->security->get_csrf_hash();
		$this->data['styles'] = $this->Style->get_all();
		$this->data['update_music'] = $this->partial('music/update_music_full', $this->data);
		
		$this->render('music/index', $this->data);
	}

	public function show($id) {
		$this->load->helper('form', 'security');
		$this->load->model('User_model', 'User');
		$this->load->model('Music_model', 'Music');
		$this->load->model('Musicstyle_model', 'Musicstyle');
		$this->load->model('Style_model', 'Style');

		$music = $this->Music->get($id);
		$music->styles = $this->Musicstyle->get_style_of_music($music->music_id);

		$this->data['music'] = $music;
		$this->data['styles'] = $this->Style->get_all();
		$this->data['addername'] = $this->User->get($music->music_adder_id)->user_firstname;

		if($this->session->userdata('user_id') === $music->music_adder_id ||
			$this->session->userdata('user_admin') === 1)
			$this->render('music/show_owner', $this->data);
		else
			$this->render('music/show', $this->data);
	}

	public function get_music($id) {
		$this->load->model('Music_model', 'Music');
		$music = $this->Music->get($id);

		$response = new stdClass();
		$response->title = escape_chars($music->music_title);
		$response->artist = empty(trim(escape_chars($music->music_band))) ? 'Inconnu' : escape_chars($music->music_band);
		$response->mp3 = escape_chars(get_music_url($music->music_url));
		$response->poster = (empty($music->music_poster)) ? escape_chars(get_music_poster($music->music_band, $music->music_title)) : escape_chars($music->music_poster);
		
		$this->output->set_header('Content-type: application/json');
		echo json_encode($response);
	}

	public function check($id) {
		$this->output->set_header('Content-type: application/json');
		$this->load->model('Music_model', 'Music');
		$this->load->model('Playlistmusic_model', 'Playlistmusic');

		$linked_playlists = $this->Playlistmusic->get_music_entries($id);
		echo json_encode(array('response' => count($linked_playlists)));
	}

	public function update() {
		if(!$this->input->post('json'))
			return false;
		$this->output->set_header('Content-type: application/json');

		$response = array(
			'response' => true,
			'content' => 'Le titre a été mis à jour'
		);

		$this->load->model('Music_model', 'Music');
		$this->Music->music_id 			= $this->input->post('music_id');
		$this->Music->music_title 		= $this->input->post('music_title');
		$this->Music->music_band 		= $this->input->post('music_band');
		$this->Music->music_year 		= $this->input->post('music_year');
		$this->Music->music_poster 		= $this->input->post('music_poster');

		if($this->Music->get($this->Music->music_id)->music_adder_id !== $this->session->userdata('user_id') && $this->session->userdata('user_admin') !== 1) {
			$response = array(
				'response' => false,
				'content' => 'Vous ne pouvez pas faire ça, vous n\'avez pas les droits requis.'
			);
			echo json_encode($response);
			return false;
		}

		if(!empty($this->input->post('styles'))) {
			$this->load->model('Musicstyle_model', 'Musicstyle');
			$this->Musicstyle->ms_music_id = $this->input->post('music_id');
			$this->Musicstyle->update_music_styles($this->input->post('styles'));
		}

		if($this->Music->update() !== 1) {
			$response = array(
				'response' => false,
				'content' => 'Une erreur est survenue, réessayez plus tard !'
			);
		}

		echo json_encode($response);
	}

}