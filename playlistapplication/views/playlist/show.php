<div class="wrap">
	<h3>Liste des musiques <button onclick="add_to_playlist_from_button($('#track_list')); return false;">Ajouter à une playlist</button></h3>
	<table data-url="<?= site_url('playlist/list'); ?>" id="track_list" class="table datatable">
		<thead>
			<tr>
				<th width="2%"></th>
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
				<td></td>
				<td class="music_title" title="Ajoutée le <?= date('d/m/Y', strtotime($music->music_add)); ?>">
					<a title="lire" href="javascript:;" onclick="myPlaysliter.add({
							title:'<?= escape_chars($music->music_title); ?>',
							artist:'<?= empty(trim(escape_chars($music->music_band))) ? 'Inconnu' : escape_chars($music->music_band); ?>',
							mp3:'<?= escape_chars(get_music_url($music->music_url)); ?>',
							poster: '<?= (empty($music->music_poster)) ? escape_chars(get_music_poster($music->music_band, $music->music_title)) : escape_chars($music->music_poster); ?>'
						}, true);"><?= $music->music_title; ?></a>
				</td>
				<td><?= $music->music_band; ?></td>
				<td style="text-align: center;"><?= ($music->music_year == null) ? '-' : $music->music_year; ?></td>
				<td style="text-align: center;"><?= $music->user_firstname; ?></td>
				<td>
					<a title="ajouter à la lecture" class="icon-play" href="javascript:;"
						onclick="myPlaysliter.add({
							title:'<?= escape_chars($music->music_title); ?>',
							artist:'<?= empty(trim(escape_chars($music->music_band))) ? 'Inconnu' : escape_chars($music->music_band); ?>',
							mp3:'<?= escape_chars(get_music_url($music->music_url)); ?>',
							poster: '<?= (empty($music->music_poster)) ? escape_chars(get_music_poster($music->music_band, $music->music_title)) : escape_chars($music->music_poster); ?>'
						}); $('#music_<?= $music->music_id; ?>').alertize('ajouter à la lecture');"></a>
					<?php if($is_creator) : ?>
					<a title="enlever de la playlist" class="icon-cancel" href="<?= site_url('playlist/remove'); ?>"
						onclick="remove_from_playlist($(this)); return false;"
						data-token-key="<?= $token_key; ?>" data-playlist-id="<?= $playlist->playlist_id; ?>" data-music-id="<?= $music->music_id; ?>"></a>
					<?php endif; ?>
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