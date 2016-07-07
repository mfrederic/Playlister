<div class="wrap">
	<h3>Vos musiques</h3>
	<table id="track_list" class="table datatable">
		<thead>
			<tr>
				<th></th>
				<th>Titre<span></span></th>
				<th>Groupe<span></span></th>
				<th>Année<span></span></th>
				<th>Styles<span></span></th>
				<th>Actions<span></span></th>
			</tr>
		</thead>
		<tbody>
			<?php $cycle = false;
			foreach ($musics as $music) :
				$cycle = !$cycle; ?>
			<tr id="music_<?= $music->music_id; ?>" class="<?= ($cycle) ? 'odd' : 'even'; ?>">
				<td><img height="25" src="<?= $music->music_poster; ?>" alt="poster" /></td>
				<td class="music_title" title="Ajoutée le <?= date('d/m/Y', strtotime($music->music_add)); ?>">
					<a title="lire" href="<?= site_url('music/get_music/'.$music->music_id) ?>"
						onclick="music_action($(this)); return false;"><?= $music->music_title; ?></a>
				</td>
				<td><?= $music->music_band; ?></td>
				<td style="text-align: center;"><?= ($music->music_year == null) ? '-' : $music->music_year; ?></td>
				<td style="text-align: center;"><?php
					if(empty($music->styles)) echo '-';
					else {
						$liststyles = array();
						foreach ($music->styles as $style)
							$liststyles[] = $style->style_name;
						echo implode(', ', $liststyles);
					}
				 ?></td>
				<td>
					<a title="ajouter à la lecture" class="icon-play" href="<?= site_url('music/get_music/'.$music->music_id) ?>"
						onclick="music_action($(this), true); $('#music_<?= $music->music_id; ?>').alertize('ajouter à la lecture'); return false;"></a>
					<a title="ajouter à une playlist" class="icon-plus" href="javascript:;"
						onclick="add_to_playlist_phase_1($(this)); return false;" data-music-id="<?= $music->music_id; ?>" data-url="<?= site_url('playlist/list'); ?>"></a>
					<a title="voir/modifier la musique"
						class="ajax fa fa-pencil-square-o "
						href="<?= site_url('music/show/'.$music->music_id); ?>"></a>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<div id="update_music" style="display: none;" class="update-musics">
		<?= $update_music; ?>
	</div>
</div>

<script type="text/javascript">
if(typeof(jQuery) !== 'undefined') {
	(function($){

		$('.datatable').DataTable({
			pageLength : 25,
			language: lang,
	        autoWidth: false,
	        bRetrieve: true,
	        columnDefs: [
	            { "orderable": false, "targets": 0 }
	        ]
		});

	})(jQuery)
}
</script>

<?= $add_to_playlist; ?>