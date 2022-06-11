(function($) {
	'use strict';
      // Client Option
      var client = $("#client");
      client.owlCarousel({
          items : 5,
          itemsMobile : [480,1],
          pagination: false
      });
      $(".next-client").on("click",function(){
        client.trigger('owl.next');
		return false;
      });
      $(".prev-client").on("click",function(){
        client.trigger('owl.prev');
		return false;
      }); 
    
      // Testimonial
      $("#testimonail").owlCarousel({
          autoPlay : 6000,
          items : 3,
          itemsDesktop : [1199,3],
          itemsTablet : [1024,2],
          itemsMobile : [480,1]
      });    
    
      // Team Option
      var team = $("#team-list");
      team.owlCarousel({
          items : 3,
          itemsDesktop : [1024,3],
          itemsDesktopSmall : [979,2],
          itemsMobile : [480,1],
          pagination: false
      });
      $(".next-team").on("click",function(){
        team.trigger('owl.next');
		return false;
      });
      $(".prev-team").on("click",function(){
        team.trigger('owl.prev');
		return false;
      });
    
      // BLog Option
      var post = $("#post");
      post.owlCarousel({
          items : 2,
          itemsDesktop : [1024,2],
          itemsDesktopSmall : [979,1],
          itemsTablet : [768,1],
          pagination: false
      });
      $(".next-blog").on("click",function(){
        post.trigger('owl.next');
		return false;
      });
      $(".prev-blog").on("click",function(){
        post.trigger('owl.prev');
		return false;
      }); 
      
})(jQuery);