<div id="users-playlist" class="wrap-playlists wrap">
	<h3>Playlists utilisateur</h3>
	<div class="playlists">
	<?php if(count($playlists) > 0) : foreach ($playlists as $key => $playlist): ?>
		<div class="a-playlist">
			<a class="style" href="<?= site_url('playlist/get_music/'.$playlist->playlist_id); ?>" data-is-style="false"
				onclick="<?php if (count($playlist->musics) >= 0) : ?>playlist_action($(this)); <?php endif; ?>return false;" title="lire">
				<p class="icon-play"></p>
				<img src="<?= $playlist->playlist_img; ?>" height='150px'>
				<span><?= $playlist->playlist_name; ?></span>
				<i class="nb-titres"><?= count($playlist->musics) ?> titre(s)</i>
				<b class="added">+<span>ajoutée</span></b>
			</a>
			<div>
				<a title="Ajouter à la lecture" class="add-to-play" href="<?= site_url('playlist/get_music/'.$playlist->playlist_id); ?>"
					onclick="<?php if (count($playlist->musics) >= 0) : ?>playlist_action($(this), true); <?php endif; ?>return false;">+</a>
				<a title="Voir la playlist" class="ajax see-playlist" href="<?= rel_base(); ?>playlist/<?= $playlist->playlist_slug; ?>">Voir</a>
			</div>
		</div>
	<?php endforeach; else : ?>
		<p class="no-entries">Aucune playlist utilisateurs trouvées.</p>
	<?php endif; ?>
	</div>
</div>