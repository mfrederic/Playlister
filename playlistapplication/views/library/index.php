<div class="wrap">
	<h3>Liste des musiques <button onclick="add_to_playlist_from_button($('#track_list')); return false;">Ajouter à une playlist</button></h3>
	<table data-url="<?= site_url('playlist/list'); ?>" id="track_list" class="table datatable">
		<thead>
			<tr>
				<th width="2%"><input type="checkbox" id="select_all" onclick="
				if($('#select_all').is(':checked')) {
					$('.music_selector input').prop('checked', true);
				} else {
					$('.music_selector input').prop('checked', false);
				}
				" checked="false"/></th>
				<th width="38%">Titre<span></span></th>
				<th width="20%">Groupe<span></span></th>
				<th width="15%">Année<span></span></th>
				<th width="15%">Ajoutée par<span></span></th>
				<th width="10%">Actions<span></span></th>
			</tr>
		</thead>
		<tbody>
			
			
			<?php $cycle = true;
			foreach($musics as $key => $music) : 
				if(file_exists(get_music_path($music->music_url))) :
					$cycle = !$cycle; ?>
			<tr id="music_<?= $music->music_id; ?>" class="<?= ($cycle) ? 'odd' : 'even'; ?>">
				<td class="music_selector" style="text-align: center;"><input type="checkbox" name="musics[]" value="<?= $music->music_id; ?>"></td>
				<td class="music_title" title="Ajoutée le <?= date('d/m/Y', strtotime($music->music_add)); ?>">
					<a title="lire" href="<?= site_url('music/get_music/'.$music->music_id) ?>"
						onclick="music_action($(this)); return false;"><?= $music->music_title; ?></a>
				</td>
				<td><?= $music->music_band; ?></td>
				<td style="text-align: center;"><?= ($music->music_year == null) ? '-' : $music->music_year; ?></td>
				<td style="text-align: center;"><?= $music->user_firstname; ?></td>
				<td>
					<a title="ajouter à la lecture" class="icon-play" href="<?= site_url('music/get_music/'.$music->music_id) ?>"
						onclick="music_action($(this), true); $('#music_<?= $music->music_id; ?>').alertize('ajouter à la lecture'); return false;"></a>
					<a title="ajouter à une playlist" class="icon-plus" href="javascript:;"
						onclick="add_to_playlist_phase_1($(this)); return false;" data-music-id="<?= $music->music_id; ?>" data-url="<?= site_url('playlist/list'); ?>"></a>
				</td>
			</tr>
		<?php endif; endforeach; ?>
		</tbody>
	</table>
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