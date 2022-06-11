/*-----------------------------------------------------------------------------------*/
/*	MASONRY SETTING
/*-----------------------------------------------------------------------------------*/
function hover_effect(){
    $('.img-hover').each(function(){
        var img_height = $(this).height();
        $('.dh-overlay', this).css('height', img_height + 'px');
		return false;
    });
}

$(document).ready(function(){
    var $container = $('#masonry'); 
    $container.infinitescroll({
        loading: {
            finished: undefined,
            finishedMsg: "<span class='icon icon-checkmark2'></span> Post Loaded",
            img: null,
            msgText: "<span class='icon icon- icon-refresh'></span> Loading more...",
            speed: 'fast',
            start: undefined
          },
		navSelector  	: "#next:last",
		nextSelector 	: "a#next:last",
		itemSelector 	: "#masonry .grid-item",
		debug		 	: true,
		dataType	 	: 'html',
        maxPage         : 3,
		path: function(index) {
			return "post" + index + ".html";
		}
    }, function(newElements, data, url){
        var $newElems = $( newElements );
        $newElems.directionalHover();
        $container.masonry( 'appended', $newElems );
        hover_effect();
		return false;
    });
	return false;
});