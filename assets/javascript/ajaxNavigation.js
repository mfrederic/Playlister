function add_playlist(playlist_name, playlist_img) {
	var link = $('<a />');

	var nb_titres = $('<i />').text('0 titre(s)');
	var titre = $('<span />').html(playlist_name);
	var img = $('<img />').attr('src', playlist_img).attr('height', '150px');
	var play = $('<p />').addClass('icon-play');

	link.addClass('style').attr('href', 'javascript:;').append(play).append(img).append(titre).append(nb_titres);
	$('#users-playlist .playlists').append(link);
}

(function($){

	/**
	 *	généralité sur la navigation Ajax, tous les liens qui ont la classe ajax
	 */
	$('body').on('click', 'a.ajax', function(event){
		event.preventDefault();

		$('#wrap_loader').fadeIn(200);
		var url = $(this).attr('href');
		$.get(url, {partial: true}, function(data){
			$('#wrap_content').html(data);
			$('#wrap_loader').fadeOut(200);
		}, 'html');
		
		/*
		if($('#wrap_loader').is(':visible'))
			$('#wrap_loader').fadeOut(200);
		*/
	});

})(jQuery);

function create_playlist() {
	var form = $('#create_playlist');

	$('#wrap_loader').fadeIn(200);
	var playlist_name = form.find('#name').val();
	var token = form.find('input[name=token_for_csrf]').val();

	if(playlist_name !== '' || playlist_name.length > 3) {
		var url = form.attr('action');
		$.post(url, {name: playlist_name, token_for_csrf: token, json: true}, function(data){
			if(!data.response) {
				$('body').alerter(data.content, 'Erreur !');
			} else {
				add_playlist(data.content[0].playlist_name, data.content[0].playlist_img);
				$('body').alerter('La playlist a été créée', 'Message !');
			}
		}, "json");
	} else {
		$('body').alerter('Vous devez indiquer un titre de playlist !', 'Attention !');
	}
	
	if($('#wrap_loader').is(':visible'))
		$('#wrap_loader').fadeOut(200);
}

function update_user() {
	var form = $('#update_user');

	$('#wrap_loader').fadeIn(200);

	var errors = [];
	var p_password1 = form.find('#password1');
	var p_password2 = form.find('#password2');
	var p_mail = form.find('#mail');
	var p_firstname = form.find('#firstname');
	var p_lastname = form.find('#lastname');
	var token = form.find('input[name=token_for_csrf]').val();
	var url = form.attr('action');

	if(p_mail.val() == '')
		errors[errors.length] = 'l\'adresse mail doit être renseignée.';

	if(p_firstname.val() == '')
		errors[errors.length] = 'le prénom doit être renseignée.';

	if(p_password1.val() !== '') {
		if(p_password1.val().length < 6) {
			errors[errors.length] = 'Le password doit faire minimum 6 caractères.';
			p_password1.addClass('error');
		}

		if(p_password1.val() !== p_password2.val()) {
			errors[errors.length] = 'La verification du mot de passe ne correspond pas au mot de passe indiqué.';
			p_password1.addClass('error');
			p_password2.addClass('error');
		}
	}

	if(errors.length > 0) {
		for(i=0; i<errors.length; i++)
			errors[i] = '<li>' + errors[i] + '</li>';
		$('body').alerter(errors.join('<br>'), 'Erreurs');
		$('#wrap_loader').fadeOut(200);
		return false;
	}

	$.post(url, {
		token_for_csrf: token,
		mail: p_mail.val(),
		firstname: p_firstname.val(),
		lastname: p_lastname.val(),
		password1: p_password1.val(),
		password2: p_password2.val(),
		json: true
	}, function(data){
		$('body').alerter(data.content, 'Message !');
	}, "json");

	if($('#wrap_loader').is(':visible'))
		$('#wrap_loader').fadeOut(200);
	return false;
}

function update_playlist_poster(form) {
	var token = form.find('input[name=token_for_csrf]').val();
	var p_playlist_id = form.find('input[name=playlist_id]').val();
	var p_playlist_poster = form.find('input[name=poster]');
	var url = form.attr('action');

	$('#wrap_loader').fadeIn(200);

	$.post(url, {
		token_for_csrf: token,
		playlist_id: p_playlist_id,
		playlist_img: p_playlist_poster.val()
	}, function(data){
		$('#playlist_form_' + p_playlist_id).fadeOut();
		if(data.retour) {
			p_playlist_poster.val(data.poster);
			$('#playlist_' + p_playlist_id + ' img').attr('src', data.poster);
			$('body').alerter(data.content, 'Message !');
		} else {
			$('body').alerter(data.content, 'Erreur !');
		}
	}, "json");

	$('#wrap_loader').fadeOut(200);

	return false;
}

function delete_playlist(link) {
	var url = link.attr('href');
	var playlist_id = link.data('playlist-id');
	var token = link.data('token-key');

	var confirmation = confirm("Voulez-vous vraiment supprimer la playlist ?");
	if(!confirmation)
		return false;

	$.post(url, {token_for_csrf: token, json: true}, function(data){
		if(data.response) {
			$('body').alerter(data.content, 'Message !');
			$('#playlist_'+playlist_id).fadeOut(50);
		} else {
			$('body').alerter("Une erreur est survenue lors de la tentative de suppression de la playlist.", 'Erreur !');
		}
	}, "json");

	return false;
}


/**
 * Ajout de musique à la playlist (3 méthodes)
 */
function add_to_playlist_from_button(track_list) {
	$('#wrap_loader').fadeIn(200);
	var url = track_list.data('url');

	track_ids = [];
	track_list.find('.music_selector input:checked').each(function(elt) {
		track_ids[track_ids.length] = $(this).val();
	});

	$('#add_to_playlist input[name="track_id[]"]').val(track_ids.join(','));

	$.get(url, {json: true}, function(data){
		$('#add_to_playlist').animate({ right: 0, opacity: 1 });
		$('#add_to_playlist .playlists').html(data);
	}, "html");
	$('#wrap_loader').fadeOut(200);
}

function add_to_playlist_phase_1(link) {
	$('#wrap_loader').fadeIn(200);
	var url = link.data('url');
	$('#add_to_playlist input[name="track_id[]"]').val(link.data('music-id'));

	$.get(url, {json: true}, function(data){
		$('#add_to_playlist').animate({ right: 0, opacity: 1 });
		$('#add_to_playlist .playlists').html(data);
	}, "html");
	$('#wrap_loader').fadeOut(200);
}

function add_to_playlist_phase_2(form) {
	$('#wrap_loader').fadeIn(200);
	var token = form.find('input[name=token_for_csrf]').val();
	var url = form.attr('action');
	var track_ids = form.find('input[name="track_id[]"]').val();

	var playlist_ids = [];
	$('input[name="playlists[]"]:checked').each(function(elt) {
		playlist_ids[playlist_ids.length] = $(this).val();
	})

	if(playlist_ids.length === 0) {
		$('body').alerter('Vous devez choisir au moins une musique !', 'Attention !');
		$('#wrap_loader').fadeOut(200);
		return false;
	}

	$.post(url, {token_for_csrf: token, tracks: track_ids, playlists: playlist_ids, json: true}, function(data){
		$('body').alerter(data.content, 'Message !');
	}, 'json');

	$('#add_to_playlist').animate({ right: -302, opacity: 0 });

	$('#wrap_loader').fadeOut(200);
	return true;
}

function get_playlist_updater(link) {
	var url = link.attr('href');
	$('#wrap_loader').fadeIn(200);
	$.get(url, function(data){
		$('#update_playlist').html(data).find('#wrap_update_playlist').fadeIn(100);
	});
	$('#wrap_loader').fadeOut(200);
}

function update_playlist(form) {
	var url = form.attr('action');
	var token = form.find('input[name=token_for_csrf]').val();
	var p_playlist_id = form.find('input[name=playlist_id]').val();
	var p_playlist_name = form.find('input[name=name]').val();
	var p_playlist_poster = form.find('input[name=poster]').val();

	if(p_playlist_name == '') {
		$('body').alerter("Vous devez indiquer un titre !", 'Attention !');
		return false;
	}

	$('#wrap_loader').fadeIn(200);

	$.post(url, {
		token_for_csrf: token,
		playlist_id: p_playlist_id,
		playlist_name: p_playlist_name,
		playlist_img: p_playlist_poster 
	}, function(data) {
		if(data.response) {
			$('body').alerter(data.content, 'Message !');
			if(p_playlist_poster != '')
				$('#playlist_' + p_playlist_id + ' img').attr('src', p_playlist_poster);
			$('#playlist_' + p_playlist_id + ' td:eq(1) a').text(p_playlist_name);
		} else
			$('body').alerter(data.content, 'Erreur !');
		$('#wrap_update_playlist').fadeOut(200);
	}, 'json');

	$('#wrap_loader').fadeOut(200);
}

function remove_from_playlist(link) {
	var url = link.attr('href');
	var p_playlist_id = link.data('playlist-id');
	var p_music_id = link.data('music-id');
	var token = link.data('token-key');
	
	$.post(url, {
		token_for_csrf: token,
		music_id: p_music_id,
		playlist_id: p_playlist_id,
		json: true
	}, function(data){
		if(data.response)
			$('#music_'+p_music_id).slideUp(200);
		$('body').alerter(data.content, 'Message !');
	}, 'json');
}

function update_music(form, complete) {
	complete = (complete == undefined) ? false : complete;
	var url = form.attr('action');
	var values = {
		token_for_csrf: form.find('input[name=token_for_csrf]').val(),
		music_id: form.find('#music_id').val(),
		music_title: form.find('#music_title').val(),
		music_band: form.find('#music_band').val(),
		music_year: form.find('#music_year').val(),
		music_poster: form.find('#music_poster').val(),
		styles: [],
		json: true
	}

	if(complete) {
		var styles = form.find('input[name="styles[]"]:checked');
		styles.each(function(index){
			values.styles[values.styles.length] = $(this).val();
		});
	}

	$('#wrap_loader').fadeIn(200);
	$.post(url, values, function(data){
		$('#wrap_loader').fadeOut(200);
		if(!complete) {
			var color = '#e74c3c';
			if(data.response)
				color = '#2ecc71';
			form.find('.message').text(data.content).css('color', color).fadeIn(100).parent('form.update-music').delay(3000).fadeOut(100);
		} else {
			$('body').alerter(data.content, 'Message !');
		}
	}, 'json');
	$('#wrap_loader').fadeOut(200);
}

function delete_music(link, event) {
	event.preventDefault();
	event.stopPropagation();

	$('#wrap_asking').asking({
		title: 'Attention',
		message: 'Souhaitez-vous vraiment supprimer ce titre ?',
		type: 'warning',

		callbacks: {
			cancel: function (){
				$(this).fadeOut();
			}
		}
	});

	if(confirm("Souhaitez-vous vraiment supprimer ce titre ?")) {
		var check_url = link.data('check');

		$.get(check_url, {json:true}, function(data){
			var continu = true;
			if(data.response > 0)
				if(!confirm("La musique est liée à " + data.response + " playlist(s). Souhaitez-vous continuer ?"))
					continu = false;

			if(continu) {
				real_delete_music(link);
			}
		}, 'json');
	}
}

function real_delete_music(link) {
	var url = link.attr('href');
	var music_id = link.data('music-id');

	
}

function playlist_action(link, add) {
	add = (add == undefined) ? false : true;
	var url = link.attr('href');

	var params = {
		is_style: link.data('is-style'),
		json: true
	}

	$('#wrap_loader').fadeIn(200);
	$.get(url, params, function(data){
		if(add) {
			for(i=0; i<data.length; i++) 
				myPlaysliter.add(data[i]);
			add_to_play(link);
		} else {
			myPlaysliter.setPlaylist(data);
			myPlaysliter.play();
		}
		$('#wrap_loader').fadeOut(200);
	}, 'json');

	return false;
}

function music_action(link, add) {
	add = (add == undefined) ? false : true;
	var url = link.attr('href');

	var params = { json: true }

	$('#wrap_loader').fadeIn(200);
	$.get(url, params, function(data){
		if(add) {
			myPlaysliter.add(data);
		} else {
			myPlaysliter.add(data, true);
		}
		$('#wrap_loader').fadeOut(200);
	}, 'json');

	return false;
}