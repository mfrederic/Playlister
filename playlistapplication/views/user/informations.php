<div class="wrap half-content">
	<h3>Informations</h3>
	<?= form_open(site_url('user/update'), array(
		'id' => 'update_user',
		'onsubmit' => 'update_user(); return false;'
	)); ?>
	<table class="table">
		<tbody>
			<tr>
				<td><?= form_label('Mail *', 'mail'); ?></td>
				<td><?= form_input(array(
					'name' => 'mail',
					'id' => 'mail',
					'value' => isset($post['mail']) ? $post['mail'] : $user->user_mail,
					'placeholder' => 'email@example.com (obligatoire)',
					'class' => 'large'
				)); ?></td>
			</tr>
			<tr>
				<td><?= form_label('Prénom *', 'firstname'); ?></td>
				<td><?= form_input(array(
					'name' => 'firstname',
					'id' => 'firstname',
					'value' => isset($post['firstname']) ? $post['firstname'] : $user->user_firstname,
					'placeholder' => 'Jean (obligatoire)',
					'class' => 'large'
				)); ?></td>
			</tr>
			<tr>
				<td><?= form_label('Nom', 'lastname'); ?></td>
				<td><?= form_input(array(
					'name' => 'lastname',
					'id' => 'lastname',
					'value' => isset($post['lastname']) ? $post['lastname'] : $user->user_lastname,
					'placeholder' => 'DUPOND',
					'class' => 'large'
				)); ?></td>
			</tr>
			<tr><td colspan="2"><br></td></tr>
			<tr>
				<td><?= form_label('Password', 'password1'); ?></td>
				<td><?= form_password(array(
					'name' => 'password1',
					'id' => 'password1',
					'value' => isset($post['password1']) ? $post['password1'] : '',
					'placeholder' => 'password',
					'class' => 'large'
				)); ?></td>
			</tr>
			<tr>
				<td><?= form_label('Verification password', 'password2'); ?></td>
				<td><?= form_password(array(
					'name' => 'password2',
					'id' => 'password2',
					'placeholder' => 're password',
					'class' => 'large'
				)); ?></td>
			</tr>
		</tbody>
	</table>
	<div>
		<?= form_submit(array(
			'name' => 'save',
			'value' => 'Sauvegarder'
		)); ?>
	</div>
	<?= form_close(); ?>
</div>