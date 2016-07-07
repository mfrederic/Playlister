<div class="wrap">
	<h3><?= $music->music_title; ?> <span class="right">Ajoutée le : <?= date('d/m/Y à G:i', strtotime($music->music_add)); ?></span></h3>

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
		</div>

		<div class="left">
			<table>
				<tbody>
					<tr>
						<td>Titre</td>
						<td><?= $music->music_title; ?></td>
					</tr>
					<tr>
						<td>Groupe</td>
						<td><?= $music->music_band; ?></td>
					</tr>
					<tr>
						<td>Année</td>
						<td><?= $music->music_year; ?></td>
					</tr>
					<tr>
						<td>Ajoutée par</td>
						<td><?= $addername; ?></td>
					</tr>
					<tr>
						<td>Styles</td>
						<td>
					<?php foreach($music->styles as $style) : ?>
							<?= $style->style_name; ?>
					<?php endforeach; ?>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<span class="clear"></span>
	</div>
</div>