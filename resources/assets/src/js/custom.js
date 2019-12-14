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
		if (Modernizr.touch) {
			$('html').addClass('bp-touch');
		}
	}
};

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
