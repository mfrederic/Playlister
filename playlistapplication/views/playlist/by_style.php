<div id="styles-playlist" class="wrap-playlists wrap">
	<h3>Playlist par style</h3>
	<div class="playlists">
	<?php foreach ($styles as $key => $style):
		if (count($style->musics) > 0) : ?>
		<div class="a-playlist">
			<a class="style" href="<?= site_url('playlist/get_music/'.$style->style_id); ?>" data-is-style="true"
				onclick="<?php if (count($style->musics) >= 0) : ?>playlist_action($(this)); <?php endif; ?>return false;" title="lire">
				<p class="icon-play"></p>
				<img src="<?= $style->style_img; ?>" height='150px'>
				<span><?= $style->style_name; ?></span>
				<i class="nb-titres"><?= count($style->musics) ?> titre(s)</i>
				<b class="added">+<span>ajoutée</span></b>
			</a>
		</div>
	<?php endif; endforeach ?>
	</div>
</div>