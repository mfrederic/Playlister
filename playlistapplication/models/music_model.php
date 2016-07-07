<?php
	
	class Music_model extends CI_Model{

		private static $tablename = 'musics';
		public $limit = 15;

		public $music_id = null;
		public $music_numero = null;
		public $music_title = '';
		public $music_band = '';
		public $music_year = '';
		public $music_url = '';
		public $music_add = null;
		public $music_adder_id = 0;
		public $music_poster = '';

		function __construct() {
			parent::__construct();
		}

		function get_all() {
			$query = $this->db->get(self::$tablename);
			return $query->result();
		}

		function get($id) {
			$this->db->select('*');
			$this->db->from(self::$tablename);
			$this->db->where('music_id', $id);
			$query = $this->db->get();
			return $query->result()[0];
		}

		function get_all_by_adder_id($user_id) {
			$this->db->select('*');
			$this->db->from(self::$tablename);
			$this->db->where('music_adder_id', $user_id);
			$query = $this->db->get();
			return $query->result();
		}

		function count_all_musics() {
			return $this->db->count_all(self::$tablename);
		}

		function get_all_order_by_title() {
			$this->db->select('*');
			$this->db->from(self::$tablename);
			$this->db->join('users', self::$tablename . '.music_adder_id = users.user_id');
			$this->db->order_by('music_title');
			$query = $this->db->get();
			return $query->result();
		}

		function get_all_order_by_title_with_limit($first) {
			$this->db->select('*');
			$this->db->from(self::$tablename);
			$this->db->join('users', self::$tablename . '.music_adder_id = users.user_id');
			$this->db->order_by('music_title');
			$this->db->limit($this->limit, $first);
			$query = $this->db->get();
			return $query->result();
		}

		function get_by_url($url) {
			$this->db->select('*');
			$this->db->from(self::$tablename);
			$this->db->where('music_url', $url);
			$query = $this->db->get();
			return $query->result();
		}

		function get_title($id) {
			$this->db->select('music_title');
			$this->db->from(self::$tablename);
			$this->db->where('music_id', $id);
			$query = $this->db->get();
			return $query->result()[0]->music_title;
		}

		function add_music($music) {
			$this->db->insert(self::$tablename, $music);
			return $this->db->insert_id();
		}

		function update() {
			$before = $this->db->get($this->music_id);

			$this->db->where('music_id', $this->music_id);
			$this->db->update(self::$tablename, array(
				'music_title' 	=> $this->music_title,
				'music_band' 	=> $this->music_band,
				'music_year'	=> $this->music_year,
				'music_poster'	=> $this->music_poster
			));

			$return = $this->db->affected_rows();
			if($return === 0)
				$return = ($before == $this->db->get($this->music_id)) ? 1 : 0;
			
			return $return;
		}
	}

?>