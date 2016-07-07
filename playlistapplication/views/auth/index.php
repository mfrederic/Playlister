<?= form_open('auth/login', array('class' => 'form')); ?>
	<h3>Connexion</h3>

	<div>
	<?= form_label('Login', 'login'); ?>
	<?= form_input(array(
		'name' => 'login',
		'placeholder' => 'email@example.com'
	)); ?>
	</div>

	<div>
	<?= form_label('Password', 'password'); ?>
	<?= form_password(array(
		'name' => 'password',
		'placeholder' => 'password'
	)); ?>
	</div>

	<div>
	<?= form_submit(array('value' => 'Connexion')); ?>
	<?= form_reset(array('value' => 'Annuler')); ?>
	</div>
<?= form_close(); ?>