<?php
	
	class User_model extends CI_Model{

		private static $tablename = 'users';

		public $user_id = null;
		public $user_mail = '';
		public $user_password = '';
		public $user_firstname = '';
		public $user_lastname = '';
		public $user_registeration_date = null;
		public $user_active = null;
		public $user_admin = null;

		public function __construct() {
			parent::__construct();
		}

		public function get_all() {
			$query = $this->db->get(self::$tablename);
			return $query->result();
		}

		public function get_null() {
			$user = new StdClass();
			$user->user_id = '';
			$user->user_mail = '';
			$user->user_password = '';
			$user->user_firstname = '';
			$user->user_lastname = '';
			$user->user_registeration_date = '';
			$user->user_active = '';
			$user->user_level = '';
			return $user;
		}

		public function get($id) {
			$this->db->select('*');
			$this->db->from(self::$tablename);
			$this->db->where(array('user_id' => $id));
			$query = $this->db->get();
			return $query->result()[0];
		}

		public function get_user_from_id($id) {
			return $this->get($id);
		}

		public function get_user_from_mail() {
			$this->db->select('*');
			$this->db->from(self::$tablename);
			$this->db->where(array('user_mail' => $this->user_mail));
			$query = $this->db->get();
			return $query->result()[0];
		}

		public function update_user($user) {
			$this->db->where('user_id', $this->user_id);
			$this->db->update(self::$tablename, $user);
		}

	}

?>