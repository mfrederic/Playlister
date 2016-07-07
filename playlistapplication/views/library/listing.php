<?php foreach($musics as $key => $music) :
		$poster = empty($music->music_poster) ? get_music_poster($music->music_band, $music->music_title) : $music->music_poster;
?>
UPDATE musics SET music_poster = "<?= $poster; ?>"<br>
WHERE music_id = <?= $music->music_id; ?>;<br><br>
<?php endforeach; ?>