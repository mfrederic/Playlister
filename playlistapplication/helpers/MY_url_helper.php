<?php 
	
	function get_music_url($music_name) {
		return base_url() . 'public/media/' . $music_name;
	}

	function get_music_path($music_name) {
		return FCPATH . 'public/media/' . $music_name;
	}

	function rel_base() {
		echo get_rel_base();
	}

	function get_rel_base() {
		return '/playlister/';
	}

?>