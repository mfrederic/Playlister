<?php
	
	class Playlistmusic_model extends CI_Model{

		private static $tablename = 'playlists_musics';

		public $playlist_music_id = null;
		public $music_playlist_id = null;
		public $adder_id = null;
		public $playlist_music_added_date = '';

		function __construct() {
			parent::__construct();
		}

		function get_all() {
			$query = $this->db->get(self::$tablename);
			return $query->result();
		}

		function get_music_entries($music_id) {
			$this->db->select('*');
			$this->db->from(self::$tablename);
			$this->db->where('music_playlist_id', $music_id);
			$query = $this->db->get();
			return $query->result();
		}

		function get_music_of_playlist($playlist_id) {
			$this->db->select('*');
			$this->db->from(self::$tablename);
			$this->db->join('musics', 'playlists_musics.music_playlist_id = musics.music_id');
			$this->db->where('playlist_music_id', $playlist_id);

			$query = $this->db->get();
			return $query->result();
		}

		function add_music_to_playlist() {
			$this->db->insert(self::$tablename, array(
				'playlist_music_id' => $this->playlist_music_id,
				'music_playlist_id' => $this->music_playlist_id,
				'adder_id' => $this->adder_id
			));
			return $this->db->affected_rows();
		}

		function delete_all_of_playlist($playlist_id) {
			$this->db->where('playlist_music_id', $playlist_id);
			$this->db->delete(self::$tablename);
		}

		function delete_all_entries_of_music($music_id) {
			$this->db->where('music_playlist_id', $music_id);
			$this->db->delete(self::$tablename);
		}

		function delete_of_playlist($playlist_id, $music_id) {
			$this->db->where(array(
				'playlist_music_id' => $playlist_id,
				'music_playlist_id' => $music_id
			));
			$this->db->delete(self::$tablename);
		}

	}

?>