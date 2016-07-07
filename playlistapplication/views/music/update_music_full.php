<?= form_open("library/update_music", array(
	"class" => "update-music",
	"onsubmit" => "update_music($(this)); return false;"
)); ?>
	<img class="poster-preview" src="" />
	<div class="update-fields">
		<div class="readonly-fields">
			<p class="filename"></p>
			<p class="upload-date"></p>
			<span class="clear"></span>
		</div>

		<input type="hidden" id="music_id" name="music_id"/>
		<input type="hidden" name="token_for_csrf" value="<?= $token ?>">

		<div class="update-field">
			<label for="music_title">Titre</label>
			<input placeholder="Titre du morceau" id="music_title" name="music_title" type="text" />
			<span class="clear"></span>
		</div>
		<div class="update-field">
			<label for="music_band">Groupe</label>
			<input placeholder="Groupe/Artiste du morceau" id="music_band" name="music_band" type="text" />
			<span class="clear"></span>
		</div>
		<div class="update-field">
			<label for="music_year">Année</label>
			<input placeholder="Année de production du morceau" id="music_year" name="music_year" type="text" />
			<span class="clear"></span>
		</div>
		<div class="update-field">
			<label for="music_poster">Poster</label>
			<input placeholder="Poster de l'album correspondant" id="music_poster" name="music_poster" type="text" />
			<span class="clear"></span>
		</div>

		<input type="submit" value="Modifier">
		<button onclick="$(this).parents('form').fadeOut(200); return false;">Ne rien modifier</button>
	</div>

	<span class="clear"></span>

	<div class="styles">
		<h4>Styles</h4>
	<?php foreach($styles as $style) : ?>
		<div class="style">
			<label for="style_<?= $style->style_id; ?>"><?= $style->style_name; ?></label>
			<input type="checkbox" id="style_<?= $style->style_id; ?>" name="style[]" value="<?= $style->style_id; ?>" />
		</div>
	<?php endforeach; ?>
	</div>

	<span class="clear"></span>
	<div class="message"></div>
<?= form_close(); ?>