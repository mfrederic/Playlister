<html>
<head>
	<title><?= $title; ?></title>
	<meta charset="utf8">

	<?php foreach ($stylesheet as $style) : echo link_tag('assets/styles/' . $style . '.css', 'stylesheet', 'text/css'); endforeach ?>
</head>
<body>
	<?php if(!empty($flash = $this->session->flashdata('flash'))) : ?>
	<div class="msg-wrap">
		<div class="msg-container">
			<div class="msg-content"><?= $flash; ?></div>
			<a href="javascript:;" class="msg-close icon-cancel" onclick="$('.msg-wrap').fadeOut(200);"></a>
		</div>
	</div>
	<?php endif; ?>

	<div id="content" role="content">
		<?= $content; ?>
	</div>

	<?php foreach ($scripts as $script) : ?>
		<script type="text/javascript" src="<?= base_url() . 'assets/javascript/' . $script . '.js' ?>"></script>
	<?php endforeach ?>
</body>
</html>