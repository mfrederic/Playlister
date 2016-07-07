<?php
	
	class Style_model extends CI_Model{

		private static $tablename = 'styles';

		public $style_id = null;
		public $style_name = '';
		public $style_img = null;

		function __construct() {
			parent::__construct();
		}

		function get_all() {
			$query = $this->db->get(self::$tablename);
			return $query->result();
		}

		function get_style($style_identifier) {
			$field = 'style_name';
			if(is_numeric($style_identifier)) 
				$field = 'style_id';
			$query = $this->db->get_where(self::$tablename, array($field => $style_identifier));
			return $query->result();
		}

		function update_img($style_id, $style_img) {
			$this->db->update(self::$tablename, array('style_img' => $style_img), array('style_id' => $style_id));
		}

	}

?>