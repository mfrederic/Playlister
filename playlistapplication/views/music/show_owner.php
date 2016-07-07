<div class="wrap">
	<h3><?= $music->music_title; ?> <span class="right">Ajoutée le : <?= date('d/m/Y à G:i', strtotime($music->music_add)); ?></span></h3>
	
	<?= form_open("music/update", array(
		"class" => "update-music",
		"onsubmit" => "update_music($(this), true); return false;"
	)); ?>
	<input type="hidden" id="music_id" name="music_id" value="<?= $music->music_id; ?>">
	<div class="music-informations">
		<div class="left music-actions">
			<img src="<?= $music->music_poster; ?>" class="music-poster" alt="Poster de '<?= $music->music_title; ?>'">
			<a title="lire" href="javascript:;" onclick="myPlaysliter.add({
							title:'<?= escape_chars($music->music_title); ?>',
							artist:'<?= empty(trim(escape_chars($music->music_band))) ? 'Inconnu' : escape_chars($music->music_band); ?>',
							mp3:'<?= escape_chars(get_music_url($music->music_url)); ?>',
							poster: '<?= (empty($music->music_poster)) ? escape_chars(get_music_poster($music->music_band, $music->music_title)) : escape_chars($music->music_poster); ?>'
						}, true);">Lire</a>
			<a title="ajouter à la lecture" href="javascript:;"
						onclick="myPlaysliter.add({
							title:'<?= escape_chars($music->music_title); ?>',
							artist:'<?= empty(trim(escape_chars($music->music_band))) ? 'Inconnu' : escape_chars($music->music_band); ?>',
							mp3:'<?= escape_chars(get_music_url($music->music_url)); ?>',
							poster: '<?= (empty($music->music_poster)) ? escape_chars(get_music_poster($music->music_band, $music->music_title)) : escape_chars($music->music_poster); ?>'
						}); $('body').alerter('Musique ajoutée à la lecture !', 'Ajout');">Ajouter à la lecture</a>
			<hr>
			<a href="<?= site_url('music/delete/'.$music->music_id); ?>"
				title="Supprimer" data-music-id="<?= $music->music_id; ?>"
				data-check="<?= site_url('music/check/'.$music->music_id); ?>"
				onclick="delete_music($(this), event);">Supprimer</a>
		</div>

		<div class="left">
			<table>
				<tbody>
					<tr>
						<td><?= form_label('Titre', 'music_title'); ?></td>
						<td><?= form_input('music_title', $music->music_title, 'id="music_title"'); ?></td>
					</tr>
					<tr>
						<td><?= form_label('Groupe', 'music_band'); ?></td>
						<td><?= form_input('music_band', $music->music_band, 'id="music_band"'); ?></td>
					</tr>
					<tr>
						<td><?= form_label('Année', 'music_year'); ?></td>
						<td><?= form_input('music_year', $music->music_year, 'id="music_year"'); ?></td>
					</tr>
					<tr>
						<td><?= form_label('Pochette', 'music_poster'); ?></td>
						<td><?= form_input('music_poster', $music->music_poster, 'id="music_poster"'); ?></td>
					</tr>
					<tr>
						<td>Ajoutée par</td>
						<td><?= $addername; ?></td>
					</tr>
					<tr>
						<td>Styles</td>
						<td class="music-styles">
						<?php foreach($styles as $style) : ?>
							<div class="style">
								<?= form_label($style->style_name, "style_{$style->style_name}"); ?>
								<?= form_checkbox(array(
									'name' => 'styles[]',
									'id' => "style_{$style->style_name}",
									'value' => $style->style_id,
									'checked' => (in_array($style, $music->styles)) ? true : false
								)) ?>
							</div>
						<?php endforeach; ?>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<?= form_submit('update', 'Modifier'); ?>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<span class="clear"></span>
	</div>
	<?= form_close(); ?>
</div>