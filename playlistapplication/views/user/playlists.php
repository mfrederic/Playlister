<div class="wrap half-content">
	<h3>Vos playlists</h3>
	<table class="datatable-playlist table">
		<thead>
			<tr>
				<th width="10%"></th>
				<th width="60%">Nom</th>
				<th width="15%">titre</th>
				<th width="15%"></th>
			</tr>
		</thead>
		<tbody>
			<?php if(count($playlists) > 0) : $cycle = true;
				foreach($playlists as $key => $playlist) :
					$cycle = !$cycle; ?>
			<tr class="<?= ($cycle) ? 'odd' : 'even'; ?>" id="playlist_<?= $playlist->playlist_id; ?>">
				<td><a class="poster-update" title="Modifier l'image" href="javascript:;" onclick="$('#playlist_form_<?= $playlist->playlist_id; ?>').stop().fadeIn(100);"><img src="<?= $playlist->playlist_img; ?>" height='50px'><span class="fa fa-upload"></span></a></td>
				<td><a title="Voir la playlist" class="ajax" href="<?php rel_base(); ?>playlist/<?= $playlist->playlist_slug; ?>"><?= $playlist->playlist_name; ?></a></td>
				<td><?= count($playlist->musics) ?> titre(s)</td>
				<td>
					<a onclick="delete_playlist($(this)); return false;" title="Supprimer la playlist"
						style="font-size: 14px;" data-playlist-id="<?= $playlist->playlist_id ?>" data-token-key="<?= $token_key ?>"
						href="<?= site_url('playlist/del/'.$playlist->playlist_id) ?>" class="fa fa-trash-o"></a> - 
					<a onclick="get_playlist_updater($(this)); return false;" title="Modifier la playlist"
						style="font-size: 14px;"
						href="<?= site_url('user/playlist_update/'.$playlist->playlist_id); ?>" class="fa fa-pencil-square-o"></a>
				</td>
			</tr>
			<?php endforeach; else : ?>
			<tr>
				<td colspan="4">Aucune playlist trouvée</td>
			</tr>
			<?php endif; ?>
		</tbody>
	</table>

	<?php foreach($playlists as $key => $playlist) : ?>
	<div id="playlist_form_<?= $playlist->playlist_id; ?>" class="black_light inversed">
		<?= form_open(site_url('user/playlist_poster'), array(
			'class' => 'update_poster',
			'id' => 'update_poster_' . $playlist->playlist_id, 
			'onsubmit' => "update_playlist_poster($('#update_poster_".$playlist->playlist_id."')); return false;"
		)) ?>
			<h3>Modifier l'image de la playlist</h3>
			<?= form_hidden('playlist_id', $playlist->playlist_id); ?>
			<div>
				<?= form_label('Url de l\'image', 'poster_'.$playlist->playlist_id); ?>
				<?= form_input(array(
					'name' => 'poster',
					'id' => 'poster_'.$playlist->playlist_id,
					'value' => isset($post['poster']) ? $post['poster'] : $playlist->playlist_img,
					'placeholder' => 'http://example.com/image.jpg',
					'class' => 'large'
				)); ?>
			</div>
			<div>
				<?= form_submit('save', 'Sauvegarder'); ?>
				<?= form_button(array(
					'content' => 'Annuler',
					'onclick' => "$('#playlist_form_".$playlist->playlist_id."').stop().fadeOut(100);"
				)); ?>
			</div>
		<?= form_close(); ?>
	</div>
	<?php endforeach; ?>

</div>
<script type="text/javascript">
if(typeof(jQuery) !== 'undefined') {
	(function($){

		$('.datatable-playlist').DataTable({
			pageLength : 5,
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