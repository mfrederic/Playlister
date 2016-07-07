<?php
	
	function get_media_directory_size() {
		return number_format((disk_free_space('/wamp/www/playlister/public/media/') / 1024 / 1024 / 1024), 2);
	}

?>