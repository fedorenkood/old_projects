(function($) {
	'use strict';
      // TabSlider Option
      $('#tab-slider').jwgSlider('both', 400);
      // Navigation Active
      $('.tabbed_navigation').find('li').each(function(){
        $(this).on('click', function(){
            $('.tabbed_navigation').find('li').removeClass('active');
            $(this).addClass('active');
			return false;
        });
		return false;
      });
    
})(jQuery);