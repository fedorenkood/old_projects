/*-----------------------------------------------------------------------------------*/
/*	MASONRY SETTING
/*-----------------------------------------------------------------------------------*/
$(window).load(function(){
    var $container = $('#masonry');  
    $container.masonry({
        isAnimated: true,
        columnWidth:".grid-sizer",
        itemSelector: ".grid-item"
    });

    $(".filter-items li").on("click",function(e){
        e.preventDefault();

        var filter = $(this).attr("data-filter");
        
        $(".filter-items  li").removeClass('active');
        $(this).addClass('active');
        
        $container.masonryFilter({
            filter: function () {
                if (!filter) return true;
                return $(this).attr("data-filter") == filter;
            }
        });
		return false;
    });
	return false;
});