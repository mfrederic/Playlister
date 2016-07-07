<?php foreach ($playlists as $playlist) : ?>
<div id="pl_<?= $playlist->playlist_id; ?>">
	<label for="playlist_<?= $playlist->playlist_id ?>">
		<span style="display: inline-block; height: 50px; width: 50px; overflow: hidden;"><img src="<?= $playlist->playlist_img; ?>" height='50px'></span>
		<span class="playlist-name"><?= $playlist->playlist_name ?></span>
		<?= form_checkbox(array(
		    'name'		=> 'playlists[]',
		    'id'		=> 'playlist_'.$playlist->playlist_id,
		    'value'		=> $playlist->playlist_id,
		    'onchange'	=> "if($(this).is(':checked')){ $('#pl_".$playlist->playlist_id."').addClass('checked'); } else { $('#pl_".$playlist->playlist_id."').removeClass('checked'); }"
	    )); ?>
	    <span style="font-size: 30px;" class="checked fa fa-check-circle"></span>
    </label>
</div>
<?php endforeach; ?>