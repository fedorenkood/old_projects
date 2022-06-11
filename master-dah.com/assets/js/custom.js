(function($) {
	'use strict';
	/*
	Header
	=========================== */
	$(window).scroll(function(){
		var scrollTop = $(window).scrollTop();
		if(scrollTop != 0){
			$(".navbar").addClass("top-nav-collapse");
			return false;
		} else {
			$(".navbar").removeClass("top-nav-collapse");
			return false;
		}
	});

    /*
	Img Hover Effect
	=========================== */
    function hover_effect(){
        $('.img-hover').each(function(){
            var img_height = $(this).height();
            $('.dh-overlay', this).css('height', img_height + 'px');
        });
		return false;
    }
    $(window).load(hover_effect);
    $(window).resize(hover_effect);
    
	/*
	Video play
	=========================== */
	$("#ytplayer").css({'opacity':'0','filter':'alpha(opacity=0)'});	
	$( ".start-video" ).on("click",function(){
		$('#ytplayer').fadeTo(900, 1);$( ".video-image" ).fadeOut(800);
		return false;
	});
	$(document).on('click', '.start-video', function () {
		$(this).fadeOut(800);
		player.playVideo();
		return false;
	});
	
    /*
	Input Form
	=========================== */
    $('.input-form').each(function(){
        $(this).on('focusin', function(){
            $('.icon-form', this).addClass('active');
			return false;
        });
        $(this).on('focusout', function(){
            $('.icon-form', this).removeClass('active');
			return false;
        });
    });
    
    /*
	Scrollspy
	=========================== */       
    $(window).on('load',function(){
        // Scrollspy Option
        var $body   = $('body'), 
            $navtop = $('nav.navbar'),
            $offset_section = 89,
            offset  = $navtop.outerHeight();
        
        $body.css('padding-top', offset);
        $body.scrollspy({target: '.navbar', offset: offset });
        
        // Update Offset
        function scrollAnimate(){
            var $window_width = $(window).width();
            if( $window_width < 641 ){
                $offset_section = 74;
            }else if( $window_width > 767 && $window_width < 1025){
                $offset_section = 177;
            }else if( $window_width < 1200 ){
                $offset_section = 89;
            }
        }
        
        // Animation Scrollspy
        scrollAnimate();
        $('.page-scroll').on('click', function(event) {
            event.preventDefault();
            var $anchor = $(this).find('a'),
                $section = $($anchor.attr('href')).offset().top,
                $position = $section - $offset_section;

            $('html, body').stop().animate({
                scrollTop: $position
            }, 1500, 'easeInOutExpo');
			return false;
        });
        
        // Activated Navigation
        function fixSpy() {
            var data = $body.data('bs.scrollspy');
            if (data) {
                offset = $navtop.outerHeight();
                $body.css('padding-top', offset);
                data.options.offset = offset;
                $body.data('bs.scrollspy', data);
                $body.scrollspy('refresh');
            }
        }
        
        // Call function on resize
        var resizeTimer;
        $(this).on('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(fixSpy, 200);
            scrollAnimate();
			return false;
        });
		return false;
    });
    

})(jQuery);