<div class="wrap">
	<h3>Uploader des musiques
		<span class="size_limit">
			<b style="width: <?= $current_size / $size_limit * 100; ?>%;" class="current"></b>
			<b class="text"><?= $current_size; ?> / <?= $size_limit; ?> <?= $size_unity; ?></b>
		</span>
	</h3>

	<div class="warning"><i class="fa fa-warning"></i> Il est possible de devoir recharger la page pour pouvoir lire les nouvelles musiques !</div>
	
	<?= form_open_multipart('upload/upload_files', array(
			'id' => 'form_upload_musics',
			'class' => 'dropzone'
		)); ?>
		<div class="file-input">
			<?= form_upload(array(
				'name' => 'musics[]',
				'id' => 'musics',
				'multiple' => 1
			)); ?>
		</div>
	<?= form_close(); ?>

	<div class="up-errors"></div>

	<div class="update-musics"></div>
</div>

<script type="text/javascript">
if((typeof jQuery) !== 'undefined') {
	(function($){
		$('#form_upload_musics').dropzone(options_for_dropzone);
	})(jQuery);
}
</script>

