<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Playlist extends CI_Controller {

	public function index()
	{
		if($this->input->post('json') == 'true') {
			$this->create_playlist();
			return false;
		}

		$this->load->model(array('Style_model', 'Music_model', 'Musicstyle_model', 'Playlist_model', 'Playlistmusic_model'));
		$this->load->helper('form');

		$styles = $this->Style_model->get_all();
		foreach ($styles as $key => $style) {
			$style_music = $this->Musicstyle_model->get_music_of_style($style->style_id);
			$styles{$key}->musics = $style_music;
		}

		$playlists = $this->Playlist_model->get_all();
		foreach($playlists as $key => $playlist) {
			$playlist_music = $this->Playlistmusic_model->get_music_of_playlist($playlist->playlist_id);
			$playlists{$key}->musics = $playlist_music;
		}

		$this->data['title'] = 'Myplaylister - Playlist';
		$this->data['loadedplaylist'] = $this->partial('player/loadplaylist', $this->data);
		$this->data['styles'] = $styles;
		$this->data['playlists'] = $playlists;

		foreach($this->data['styles'] as $style_key => $style) {
			if(empty($style->style_img) || is_null($style->style_img)) {
				$new_img = get_tag_top_album($style->style_name, $this->config->item('lastfm_api'));
				$this->Style_model->update_img($style->style_id, $new_img);
				$style->style_img = $new_img;
				$this->data['styles']{$style_key} = $style;
			}
		}

		$this->data['create_playlist'] = $this->partial('playlist/create_playlist', $this->data);
		$this->data['by_style'] = $this->partial('playlist/by_style', $this->data);
		$this->data['playlists'] = $this->partial('playlist/playlists', $this->data);

		$this->render('playlist/index', $this->data);
	}

	public function show($slug) {
		$this->load->model(array('Playlist_model', 'Playlistmusic_model', 'User_model'));

		$this->data['token_key'] = $this->security->get_csrf_hash();
		$this->data['playlist'] = $this->Playlist_model->get_by_slug($slug);
		$musics = $this->Playlistmusic_model->get_music_of_playlist($this->data['playlist']->playlist_id);
		foreach ($musics as $key => $music) {
			$user = $this->User_model->get_user_from_id($music->music_adder_id);
			$musics{$key}->user_firstname = $user->user_firstname;
		}
		$this->data['musics'] = $musics;

		$this->data['is_creator'] = ($this->session->userdata('user_id') == $this->data['playlist']->playlist_adder || $this->session->userdata('user_admin') == 1) ?
			true : false;

		$this->render('playlist/show', $this->data);
	}

	public function get_music($playlist_id) {
		$this->load->model(array('Musicstyle_model', 'Playlistmusic_model'));
		if($this->input->get('is_style'))
			$musics = $this->Musicstyle_model->get_music_of_style($playlist_id);
		else
			$musics = $this->Playlistmusic_model->get_music_of_playlist($playlist_id);

		$response = array();
		foreach ($musics as $music) {
			$current = new stdClass();
			$current->title = escape_chars($music->music_title);
			$current->artist = escape_chars($music->music_band);
			$current->mp3 = escape_chars(get_music_url($music->music_url));
			$current->poster = (empty($music->music_poster)) ? escape_chars(get_music_poster($music->music_band, $music->music_title)) : escape_chars($music->music_poster);
			$response[] = $current;
		}

		$this->output->set_header('Content-type: application/json');
		echo json_encode($response);
	}

	public function delete($id) {
		$this->load->model(array('Playlist_model', 'Playlistmusic_model'));

		$this->data['response'] = array(
			'response' => true,
			'content' => "La playlist a bien été supprimée."
		);

		$this->Playlistmusic_model->delete_all_of_playlist($id);
		$this->Playlist_model->playlist_id = $id;
		if(!$this->Playlist_model->delete_playlist())
			$this->data['response']['response'] = false;

		$this->output->set_header('Content-type: application/json');
		echo json_encode($this->data['response']);
	}


	private function create_playlist() {
		$this->load->model('Playlist_model');

		$this->Playlist_model->playlist_name = $this->input->post('name');
		$this->Playlist_model->playlist_img = get_tag_top_album($this->input->post('name'));
		$this->Playlist_model->playlist_adder = $this->session->userdata('user_id');
		$this->Playlist_model->playlist_private = 0;
		$this->Playlist_model->playlist_slug = url_title($this->input->post('name'), '-', true);

		$created = $this->Playlist_model->create_playlist();
		$this->data['response'] = array(
			'response' => (!$created) ? false : true,
			'content' => (!$created) ? 'La playlist '.$this->input->post('name').' existe déjà' : $created
		);

		$this->output->set_header('Content-type: application/json');
		echo json_encode($this->data['response']);
	}

	public function listplaylist() {
		$this->load->model('Playlist_model');
		$this->load->helper(array('form'));

		if($this->session->userdata('user_admin') == 1)
			$this->data['playlists'] = $this->Playlist_model->get_all();
		else
			$this->data['playlists'] = $this->Playlist_model->get_all_public_and_by_adder($this->session->userdata('user_id'));

		echo $this->partial('playlist/listing', $this->data);
	}

	public function add_to_playlist() {
		$this->load->model('Playlist_model');
		$this->load->model('Playlistmusic_model');
		$this->load->model('Music_model');

		$tracks = explode(',', $this->input->post('tracks'));
		$playlists = $this->input->post('playlists');
		$failure = array();

		$response = array(
			'response' => true,
			'content' => count($tracks) . ' musiques ont été ajoutées dans ' . count($playlists) . ' playlist(s).'
		);

		foreach ($playlists as $pid) {
			$playlist_title = $this->Playlist_model->get_name($pid);
			foreach ($tracks as $track) {
				$this->Playlistmusic_model->playlist_music_id = $pid;
				$this->Playlistmusic_model->music_playlist_id = $track;
				$this->Playlistmusic_model->adder_id = $this->session->userdata('user_id');
				if($this->Playlistmusic_model->add_music_to_playlist() <= 0) {
					if(!isset($failure[$playlist_title]))
						$failure[$playlist_title] = array();
					array_push($failure[$playlist_title], $this->Music_model->get_title($track));
				}
			}
		}

		if(count($failure) > 0) {
			$response['content'] = '';
			foreach ($failure as $playlist => $musics) {
				if(count($musics) != count($tracks))
					$response['content'] .= '<li>'.(count($tracks) - count($musics)).' musiques ont été ajoutées</li>';
				if(count($musics) <= 5) {
					$response['content'] .= '<li>Erreur d\'ajout dans la playlist "' . $playlist . '" : <br></li>';
					$response['content'] .= implode(', ', $musics)."!<br />";
				} else {
					$response['content'] .= '<li>' . count($musics) . ' erreurs d\'ajout dans la playlist ' . $playlist. '</li>';
				}
			}
		}

		$this->data['response'] = $response;

		$this->output->set_header('Content-type: application/json');
		echo json_encode($this->data['response']);
	}

	public function update_playlist() {
		$this->load->model('Playlist_model');

		$response = array(
			'response' => true,
			'content' => "La playlist a été mise à jour."
		);

		$id = $this->input->post('playlist_id');
		$name = $this->input->post('playlist_name');
		$poster = $this->input->post('playlist_img');

		if(empty($name)) {
			$response = array(
				'response' => false,
				'content' => 'Le nom doit être renseigné'
			);
		} else {
			$poster = (empty($poster)) ? base_url() . 'assets/images/album-art-missing.png' : $poster;
			$this->Playlist_model->playlist_id = $id;
			$returned = $this->Playlist_model->update_playlist(array(
				'playlist_name' => $name,
				'playlist_img' => $poster
			));

			if(!$response)
				$response = array(
					'response' => false,
					'content' => "Une erreur est survenue lors de la tentative de mise à jour de la playlist"
				);
		}

		$this->output->set_header('Content-type: application/json');
		echo json_encode($response);
	}

	public function remove_from_playlist() {
		$this->load->model('Playlist_model');
		$this->load->model('Playlistmusic_model');

		$response = array(
			'response' => false,
			'content' => "Vous n'avez pas les droits requis pour effectuer cette action !"
		);

		$playlist = $this->Playlist_model->get_by_id($this->input->post('playlist_id'));
		if($playlist->playlist_adder == $this->session->userdata('user_id') || $this->session->userdata('user_admin') == 1) {
			$this->Playlistmusic_model->delete_of_playlist($this->input->post('playlist_id'), $this->input->post('music_id'));
			$response = array(
				'response' => true,
				'content' => "La musique a bien été supprimée de la playlist !"
			);
		}

		$this->output->set_header('Content-type: application/json');
		echo json_encode($response);
	}
}