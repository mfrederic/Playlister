<div role="menu" id="menu">
	<ul>
		<li><a class="active ajax" href="<?php rel_base(); ?>">Bibliothèque</a></li>
		<li><a class="ajax" href="<?php rel_base(); ?>playlist">Playlists</a></li>
		<li><a class="ajax" href="<?php rel_base(); ?>user">Compte</a></li>
		<li><a class="ajax" href="<?php rel_base(); ?>music">Ma Musiques</a></li>
		<li><a class="ajax" href="<?php rel_base(); ?>upload">Upload</a></li>
		<li style="float: right;"><a title="Deconnexion" class="logout fa fa-sign-out" href="<?php rel_base(); ?>logout"></a></li>
	</ul>
</div>

<div id="wrap_loader">
	<img src="<?= base_url(); ?>assets/images/loader.gif" alt="Chargement de données" />
	<h3>Chargement ...</h3>
</div>

<div id="wrap_asking" style="display: none;">
	<h3 data-type="title">Titre</h3>
	<div data-type="message" class="asking">Ma question à poser !</div>
	<div class="answer">
		<button data-action="accept">Ok</button>
		<button data-action="cancel">Annuler</button>
	</div>
</div>