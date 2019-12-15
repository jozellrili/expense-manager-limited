var globalFunc = {
	init: function(){
		globalFunc.resize();
	},
	get_biggest: function(elements){
		//get all elements with class and get the biggest box
		var biggest_height = 0;
		for ( var i = 0; i < elements.length ; i++ ){
			var element_height = $(elements[i]).outerHeight();
			//compare the height, if bigger, assign to variable
			if(element_height > biggest_height ) biggest_height = element_height;
		}
		return biggest_height;
	},
	resize: function(){
		var windowWidth = $(window).width();
		var windowHeight = $(window).height();

		// STICKY FOOTER
		var headerHeight = $('header').outerHeight();
		var footerHeight = $('footer').outerHeight();
		var footerTop = (footerHeight) * -1;
		$('footer').css({marginTop: footerTop});
		$('#main-wrapper').css({paddingBottom: footerHeight});

		// for vertically middle content
		$('.bp-middle').each(function() {
			var bpMiddleHeight = $(this).outerHeight() / 2 * - 1;
			$(this).css({marginTop: bpMiddleHeight});
		});

		// for equalizer
		$('.classname').css({minHeight: 0});
		var ClassName = globalFunc.get_biggest($('.classname'));
		$('.classname').css({minHeight: ClassName});
	},
	touch: function(){
		// if (Modernizr.touch) {
		// 	$('html').addClass('bp-touch');
		// }
	}
};

function notify(options) {
	// defaults
	if (typeof options.type == "undefined") options.type = 'success';
	if (typeof options.title == "undefined") options.title = 'Success';

	$.notify({
		// options
		title: options.title,
		message: options.msg
	}, {
		// settings
		type: options.type,
		delay: options.delay,
		animate: {
			enter: 'animated fadeInDown',
			exit: 'animated fadeOutUp'
		},
		template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
			'<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
			'<span data-notify="icon"></span> ' +
			'<span data-notify="title"><strong>{1}</strong></span><br>' +
			'<span data-notify="message">{2}</span>' +
			'<div class="progress" data-notify="progressbar">' +
			'<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
			'</div>' +
			'<a href="{3}" target="{4}" data-notify="url"></a>' +
			'</div>'
	});

	if (options.scrollToTop) {
		$('html, body').animate({scrollTop: $('section.content').top - 100}, 1000, 'swing', function () {
			// do nothing
		});
	}
}

$(window).resize(function() {
	globalFunc.init();
});

$(document).ready(function() {
	globalFunc.touch();
	globalFunc.init();
});

$(window).on('load', function() {
	globalFunc.init();
});

// preloader once done
// Pace.on('done', function() {
// 	// totally hide the preloader especially for IE
// 	setTimeout(function() {
// 		$('.pace-inactive').hide();
// 	}, 500);
// });
