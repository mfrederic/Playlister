var options_for_dropzone = {
			maxFilesize: 15, // MB
			clickable: true,
			autoProcessQueue: true,
			addRemoveLinks: true,
			parallelUploads: 1,
			acceptedFiles: 'audio/mp3,audio/mpeg',

			dictDefaultMessage: "Déposez vos musiques ici pour les uploader, ou cliquez !",
			dictInvalidFileType: "impossible d'uploader un fichier de ce type !",
			dictFileTooBig: "Le fichier est trop lourd (15Mo max) !",
			dictCancelUpload: "Annuler",
			dictRemoveFile: "Masquer",
			dictCancelUploadConfirmation: "L'upload a été annulé !",
			dictMaxFilesExceeded: "Vous tentez d'uploader trop de fichier simultanément !",

			init: function() {
				var current = this;

				this.on('error', function(file, error, xhr){
					$(file.previewElement).delay(8000).fadeOut(100);
					setTimeout(function(){
						current.removeFile(file);
					}, 8500);
				});

				this.on('success', function(file, data){
					if(data.response) {
						$('.update-after-upload').append(data.content);
					} else {
						var div = $('<div />');
						var title = div.clone().addClass('error-title').text('Erreur');
						var message = div.clone().addClass('error-message').html(data.content);
						var clear = $('<span />').addClass('clear');
						var error = div.clone().addClass('error-container').append(title).append(message).append(clear);
						$('.up-errors').append(error);
					}
				});
			},

			accept: function(file, done) {
				$.get(
					checker_url_for_dropzone,
					{json: true, filename: file.name},
					function(data){
						if(data.response)
							done();
						else
							done(data.content);
					});
			}
		};

(function($){

	$.fn.alertize = function(message){
		var elt = this;
		var title_field = elt.find('.music_title');
		var bgcolor = elt.css('backgroundColor');
		
		var title = title_field.html();
		title_field.html('<b style="color: #FFF; font-weight: bold;">' + message + '</b>');
		elt.css({ backgroundColor: '#E74C3C' });

		setTimeout(function() {
			elt.css({ backgroundColor: bgcolor });
				title_field.html(title);
		}, 1000);
	}

	$('.jp-playlist-toggle').click(function(){
		var visible = $('.jp-playlist').is(':visible');
		$('.jp-playlist').stop().fadeToggle(100);
		if(!visible) {
			$(this).removeClass('icon-to-end').addClass('icon-to-start');
		} else {
			$(this).removeClass('icon-to-start').addClass('icon-to-end');
		}
	});

	$('input').on('focus', '', function(event){
		if($(this).hasClass('error'))
			$(this).removeClass('error');
		return true;
	});

	var undeployedSize = 10;
	var deployedSize = 40;
	$('.jp-timeline').css('height', undeployedSize).find('.jp-timer').hide(0);
	$('.jp-timeline').on('mouseenter', function(){
		$(this).stop().animate({ height: deployedSize }, 150);
		$(this).find('.jp-timer').stop().fadeIn(150);
	}).mouseleave(function(){
		$(this).stop().delay(1500).animate({ height: undeployedSize }, 150);
		$(this).find('.jp-timer').stop().delay(1200).fadeOut(150);
	});

	Dropzone.autoDiscover = false;
	$('#form_upload_musics').dropzone(options_for_dropzone);

})(jQuery)

function add_to_play(elt) {
	elt.parents('div.a-playlist').find('b.added').stop().fadeIn(50).fadeOut(500);
}