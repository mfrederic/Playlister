<?= form_open('', array(
	'class' => 'form-inline',
	'id' => 'create_playlist',
	'onsubmit' => 'create_playlist(); return false;'
)); ?>
	<h3>Créer une playlist</h3>

	<div>
	<?= form_label('Nom', 'name'); ?>
	<?= form_input(array(
		'name' => 'name',
		'id' => 'name',
		'placeholder' => 'Nom playlist'
	)); ?>

	<?= form_submit(array('value' => 'Créer')); ?>
	</div>

	<span class="clear"></span>
<?= form_close(); ?>