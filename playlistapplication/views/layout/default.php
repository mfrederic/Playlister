<html>
<head>
	<title><?= $title; ?></title>
	<meta charset="utf8">

	<?php foreach ($stylesheet as $style) : echo link_tag('assets/styles/' . $style . '.css', 'stylesheet', 'text/css'); endforeach ?>
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/javascript/jplayer/skins/playlister/jplayer.playlister.css">
</head>
<body>
	<?= $menu; ?>

	<?php if(!empty($flash = $this->session->flashdata('flash'))) : ?>
	<div class="msg-wrap">
		<div class="msg-container">
			<div class="msg-content"><?= $flash; ?></div>
			<a href="javascript:;" class="msg-close icon-cancel" onclick="$('.msg-wrap').fadeOut(200);"></a>
		</div>
	</div>
	<?php endif; ?>

	<div id="content" role="content">
		<?= $player; ?>

		<div id="wrap_content">
			<?= $content; ?>
		</div>
	</div>

	<div id="alerter_wrap">
		<div id="alerter">
			<div class="alerter-title">
				<h3>Le titre</h3>
			</div>
			<div class="alerter-content">
				Je suis un contenu
			</div>
			<div class="alerter-options">
				<button class="button-ok" onclick="$('#alerter_wrap').stop().fadeOut(50);">OK</button>
			</div>
		</div>
	</div>
	
	<div class="scripts">
		<script type="text/javascript">
		var checker_url_for_dropzone = "<?= $checker_url_for_dropzone; ?>";
		</script>
	<?php foreach ($scripts as $script) : ?>
		<script type="text/javascript" src="<?= base_url() . 'assets/javascript/' . $script . '.js' ?>"></script>
	<?php endforeach ?>
	<?= $loadedplaylist; ?>
	</div>

</body>
</html>