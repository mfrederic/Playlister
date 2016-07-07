<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Library extends CI_Controller {

	public function index($first=0)
	{
		$this->load->model('Music_model');
		$this->load->helper(array('form'));

		$this->load->model('Playlist_model');
		$this->data['playlists'] = $this->Playlist_model->get_all();
		$this->data['list'] = $this->partial('playlist/listing', $this->data);

		$this->data['title'] = 'Bienvenue sur My Playlister';
		$this->data['add_to_playlist'] = $this->partial('library/add_to_playlist', $this->data);
		$this->data['musics'] = $this->Music_model->get_all_order_by_title();

		$this->render('library/index', $this->data);
	}
	
	public function listing() {
		$this->load->model('Music_model');
		$this->data['musics'] = $this->Music_model->get_all_order_by_title();

		$this->data['loadedplaylist'] = $this->partial('player/loadplaylist', $this->data);

		$this->render('library/listing', $this->data);
	}

}