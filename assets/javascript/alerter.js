(function($){

	$.fn.alerter = function(message, title) {
		var alerter = $('#alerter_wrap');
			title = (title == 'undefined') ? 'Message !' : title;

		alerter.find('.alerter-title h3').text(title);
		alerter.find('.alerter-content').html(message);

		alerter.fadeIn(100).delay(8000).fadeOut(100);
		return $(this);
	}

	$.fn.asking = function() {
		var element = $(this);
		var options = $.extend({
			cancelbtn: 'cancel',
			acceptbtn: 'accept',

			cancel: element.find('button[data-action='+this.cancelbtn+']'),
			accept: element.find('button[data-action='+this.acceptlbtn+']'),

			type: '',
			title: 'Message',
			message: 'Type your question here !',

			callbacks: {
				cancel: function() {},
				accept: function() {}
			}
		}, arguments[0] || {});

		$(this).attr('class', options.type);
		$(this).find('*[data-type=title]').text(options.title);
		$(this).find('*[data-type=message]').html(options.message);

		return this.each(function(){
			if(options.callbacks.cancel)
				options.callbacks.cancel();
			if(options.callbacks.accept)
				options.callbacks.accept();
		});

		return $(this);
	}

})(jQuery)