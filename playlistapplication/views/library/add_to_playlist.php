<div id="add_to_playlist">
	<h3>Ajouter à la playlist <a title="annuler" href="javascript:;"
		onclick="$('#add_to_playlist').animate({ right: -302, opacity: 0 }, 200);" class="icon-cancel"></a></h3>
<?= form_open('playlist/add_to', array(
	'id' => 'add_to',
	'onsubmit' => 'add_to_playlist_phase_2($(this)); return false;'
)); ?>
	<?= form_hidden('track_id[]', ''); ?>
	<div class="playlists">
		<?= $list; ?>
	</div>
	<?= form_submit('add', 'Ajouter'); ?>
	<?= form_button(array(
		'content' => 'Annuler',
		'onclick' => "$('#add_to_playlist').animate({ right: -302, opacity: 0 }, 200);"
	)) ?>
<?= form_close(); ?>
</div>