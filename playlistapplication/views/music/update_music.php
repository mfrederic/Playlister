<?= form_open("music/update", array(
	"class" => "update-music",
	"onsubmit" => "update_music($(this)); return false;"
)); ?>
	<img class="poster-preview" src="<?= $music_poster; ?>" />
	<div class="update-fields">
		<div class="readonly-fields">
			<p class="filename"><?= $music_url; ?></p>
			<p class="upload-date"><?= date('d/m/Y G:i', strtotime($music_add)); ?></p>
			<span class="clear"></span>
		</div>

		<input type="hidden" id="music_id" name="music_id" value="<?= $music_id; ?>" />
	<input type="hidden" name="token_for_csrf" value="<?= $token; ?>">

		<div class="update-field">
			<label for="music_title">Titre</label>
			<input placeholder="Titre du morceau" id="music_title" name="music_title" type="text" value="<?= $music_title; ?>" />
			<span class="clear"></span>
		</div>
		<div class="update-field">
			<label for="music_band">Groupe</label>
			<input placeholder="Groupe/Artiste du morceau" id="music_band" name="music_band" type="text" value="<?= $music_band; ?>" />
			<span class="clear"></span>
		</div>
		<div class="update-field">
			<label for="music_year">Année</label>
			<input placeholder="Année de production du morceau" id="music_year" name="music_year" type="text" value="<?= $music_year; ?>" />
			<span class="clear"></span>
		</div>
		<div class="update-field">
			<label for="music_poster">Poster</label>
			<input placeholder="Poster de l'album correspondant" id="music_poster" name="music_poster" type="text" value="<?= $music_poster; ?>" />
			<span class="clear"></span>
		</div>

		<input type="submit" value="Modifier">
		<button onclick="$(this).parents('form').fadeOut(200); return false;">Ne rien modifier</button>
	</div>
	<span class="clear"></span>
	<div class="message"></div>
<?= form_close(); ?>