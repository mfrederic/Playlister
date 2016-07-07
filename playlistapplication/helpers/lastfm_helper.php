<?php
	
	function get_tag_top_album($tag) {
		$config = config_item('lastfm');
		$tag = clean_word($tag);

		set_error_handler(function() { /* ignore errors */ });
		$returned_file = file_get_contents("{$config['lastfm_api_url']}?method=tag.gettopalbums&tag=$tag&api_key=${$config['lastfm_api_key']}&format=json");
		restore_error_handler();

		if(!$returned_file) {
			return base_url() . 'assets/images/album-art-missing.png';
		}

		$json_file = json_decode($returned_file);
		if(!isset($json_file->topalbums))
			return base_url() . 'assets/images/album-art-missing.png';
		return get_object_vars($json_file->topalbums->album[0]->image[3])['#text'];
	}

	function get_music_poster($music_band, $music_title) {
		$config = config_item('lastfm');
		$music_title = clean_word($music_title);
		$music_band = clean_word($music_band);

		set_error_handler(function() { /* ignore errors */ });
		$returned_file = file_get_contents("{$config['lastfm_api_url']}?method=track.getInfo&api_key={$config['lastfm_api_key']}&artist=$music_band&track=$music_title&format=json");
		restore_error_handler();

		if(!$returned_file) {
			return base_url() . 'assets/images/album-art-missing.png';
		}

		$json_file = json_decode($returned_file);
		if(!isset($json_file->track->album))
			return base_url() . 'assets/images/album-art-missing.png';
		return get_object_vars($json_file->track->album->image[3])['#text'];
	}

	function search_music_infos($music_search) {
		$config = config_item('lastfm');
		$music_search = clean_word($music_search);

		set_error_handler(function() { /* ignore errors */ });
		$returned_file = file_get_contents("{$config['lastfm_api_url']}?method=track.search&api_key={$config['lastfm_api_key']}&track=$music_search&format=json");
		restore_error_handler();

		if(!$returned_file)
			return null;

		$json_file = json_decode($returned_file)->results;
		$track = $json_file->trackmatches->track;

		if(is_a($track, 'stdClass'))
			return null;
		else
			$track = $track[0];

		$music_infos = new stdClass();
		$music_infos->music_title = $track->name;
		$music_infos->music_band = $track->artist;
		$music_infos->music_poster = get_object_vars($track->image[3])['#text'];

		return $music_infos;
	}

	function clean_word($word) {
		$word = htmlspecialchars(mysql_real_escape_string($word));
		$word = preg_replace('/[\/\\\?\&\=\:\.\!\_\-\'\ ]/im', '+', $word);
		$word = preg_replace('/[\+]+/im', '+', $word);
		return $word;
	}

?>