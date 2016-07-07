<div id="wrap_update_playlist" class="black_light">
	<div class="wraper-playlist">
		<h3>Mettre la playlist à jour</h3>
		<?= form_open('playlist/update', array(
			'onsubmit' => 'update_playlist($(this)); return false;'
		)); ?>
			<?= form_hidden('playlist_id', $playlist->playlist_id); ?>
		<div class="block-left">
			<div><img src="<?= $playlist->playlist_img; ?>" height='150px'></div>
		</div>
		<table style="margin: 25px auto;" class="block-right table">
			<tbody>
				<tr>
					<td><?= form_label('Nom', 'name'); ?></td>
					<td><?= form_input(array(
						'name' => 'name',
						'id' => 'name',
						'value' => $playlist->playlist_name
					)); ?></td>
				</tr>
				<tr>
					<td><?= form_label('Pochette', 'poster'); ?></td>
					<td><?= form_input(array(
						'name' => 'poster',
						'id' => 'poster',
						'value' => $playlist->playlist_img
					)); ?></td>
				</tr>
				<tr>
					<td colspan="2"></td>
				</tr>
				<tr>
					<td><?= form_submit('save', 'Sauver'); ?></td>
					<td><?= form_button(array(
						'content' => 'Annuler',
						'onclick' => "$('#wrap_update_playlist').fadeOut(100);"
					)); ?></td>
				</tr>
			</tbody>
		</table>
		<?= form_close(); ?>
		<span class="clear"></span>
	</div>
</div>