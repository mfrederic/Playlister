<?php
	
	class Playlist_model extends CI_Model{

		private static $tablename = 'playlists';

		public $playlist_id = null;
		public $playlist_name = '';
		public $playlist_date = '';
		public $playlist_img = '';
		public $playlist_adder = null;
		public $playlist_private = null;
		public $playlist_slug = '';

		function __construct() {
			parent::__construct();
		}

		function get_all() {
			$query = $this->db->get(self::$tablename);
			return $query->result();
		}

		function get_first() {
			return $this->get_all()[0];
		}

		function get_all_public_and_by_adder($adder_id) {
			$this->db->select('*');
			$this->db->where(array(
				'playlist_private' => 0,
				'playlist_adder' => $adder_id
			));
			$query = $this->db->get(self::$tablename);
			return $query->result();
		}

		function get_by_id($id) {
			$this->db->select('*');
			$this->db->from(self::$tablename);
			$this->db->where('playlist_id', $id);
			$query = $this->db->get();
			return $this->return_first($query->result());
		}

		function get_by_name($name) {
			$this->db->select('*');
			$this->db->from(self::$tablename);
			$this->db->where('playlist_name', $name);
			$query = $this->db->get();
			return $this->return_first($query->result());
		}

		function get_by_slug($slug) {
			$this->db->select('*');
			$this->db->from(self::$tablename);
			$this->db->where('playlist_slug', $slug);
			$query = $this->db->get();
			return $this->return_first($query->result());
		}

		function get_by_adder_id($id) {
			$this->db->select('*');
			$this->db->from(self::$tablename);
			$this->db->where('playlist_adder', $id);
			$query = $this->db->get();
			return $query->result();
		}

		function get_name($id) {
			$this->db->select('playlist_name');
			$this->db->from(self::$tablename);
			$this->db->where('playlist_id', $id);
			$query = $this->db->get();
			$result = $this->return_first($query->result());
			return (!$result) ? false : $result->playlist_name;
		}

		function create_playlist() {
			if(empty($this->get_by_name($this->playlist_name))) {
				$this->db->insert(self::$tablename, array(
					'playlist_name' => $this->playlist_name,
					'playlist_img' => $this->playlist_img,
					'playlist_adder' => $this->playlist_adder,
					'playlist_private' => $this->playlist_private,
					'playlist_slug' => $this->playlist_slug
				));

				return $this->db->get_where(self::$tablename, array('playlist_id' => $this->db->insert_id()))->result();
			} else {
				return false;
			}
		}

		function update_poster($poster) {
			$this->db->where('playlist_id', $this->playlist_id);
			$this->db->update(self::$tablename, array('playlist_img' => $poster));
		}

		function update_playlist($info) {
			$this->db->where('playlist_id', $this->playlist_id);
			$this->db->update(self::$tablename, $info);
			return ($this->db->affected_rows() <= 0) ? false : true;
		}

		function delete_playlist() {
			$this->db->where('playlist_id', $this->playlist_id);
			if($this->db->delete(self::$tablename))
				return true;
			else
				return false;
		}

	}

?>