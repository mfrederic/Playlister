<?php
	
	class Musicstyle_model extends CI_Model{

		private static $tablename = 'musics_styles';

		public $ms_music_id = null;
		public $ms_style_id = null;

		function __construct() {
			parent::__construct();
		}

		function get_all() {
			$query = $this->db->get(self::$tablename);
			return $query->result();
		}

		function get($music_id, $style_id) {
			$this->db->select('*');
			$this->db->from(self::$tablename);
			$this->db->where('ms_music_id', $music_id);
			$this->db->where('ms_style_id', $style_id);
			$query = $this->db->get();
			return $query->result()[0];
		}

		function get_music_of_style($style_id) {
			$this->db->select('music_id, music_title, music_band, music_url');
			$this->db->from(self::$tablename);
			$this->db->join('musics', 'musics_styles.ms_music_id = musics.music_id');
			$this->db->where('ms_style_id', $style_id);
			$query = $this->db->get();
			return $query->result();
		}

		function get_style_of_music($music_id) {
			$this->db->select('styles.*');
			$this->db->from(self::$tablename);
			$this->db->join('styles', 'musics_styles.ms_style_id = styles.style_id');
			$this->db->where('ms_music_id', $music_id);
			$query = $this->db->get();
			return $query->result();
		}

		function insert() {
			$this->db->insert(self::$tablename, array(
				'ms_music_id' => $this->ms_music_id,
				'ms_style_id' => $this->ms_style_id
			));
			return $this->db->insert_id();
		}

		function delete() {
			return $this->db->delete(self::$tablename, array(
				'ms_music_id' => $this->ms_music_id,
				'ms_style_id' => $this->ms_style_id
			));
		}

		function delete_by_music_id($music_id) {
			return $this->db->delete(self::$tablename, array(
				'ms_music_id' => $music_id
			));
		}
 
		function update_music_styles($styles) {
			$this->delete_by_music_id($this->ms_music_id);
			foreach ($styles as $key => $style_id) {
				$this->ms_style_id = $style_id;
				$this->insert();
			}
		}

	}

?>