jQuery(window).load(function(){fixFooterBottom();callback_menu_align();});jQuery(window).resize(function(){fixFooterBottom();callback_menu_align();});var callback_menu_align=function(){var headerWrap=jQuery('header.header');var navWrap=jQuery('.main-navigation');var logoWrap=jQuery('.navbar-header');var containerWrap=jQuery('.container');var classToAdd='menu-align-center';if(headerWrap.hasClass(classToAdd)){headerWrap.removeClass(classToAdd);}
var logoWidth=logoWrap.outerWidth();var menuWidth=navWrap.outerWidth();var containerWidth=containerWrap.width();if(menuWidth+logoWidth>containerWidth){headerWrap.addClass(classToAdd);}else{if(headerWrap.hasClass(classToAdd)){headerWrap.removeClass(classToAdd);}}
jQuery('.sticky-navigation-open').css('min-height','70');var headerHeight=jQuery('.sticky-navigation').outerHeight();if(headerHeight>70){jQuery('.sticky-navigation-open').css('min-height',headerHeight);}else{jQuery('.sticky-navigation-open').css('min-height',70);}};function fixFooterBottom(){var header=jQuery('header.header');var footer=jQuery('footer.footer');var content=jQuery('.content-wrap');content.css('min-height','1px');var headerHeight=header.outerHeight();var footerHeight=footer.outerHeight();var contentHeight=content.outerHeight();var windowHeight=jQuery(window).height();var totalHeight=headerHeight+footerHeight+contentHeight;if(totalHeight<windowHeight){content.css('min-height',windowHeight-headerHeight-footerHeight);}else{content.css('min-height','1px');}}
jQuery(document).ready(function($){'use strict';var oldSSB=jQuery.fn.modal.Constructor.prototype.setScrollbar;$.fn.modal.Constructor.prototype.setScrollbar=function(){oldSSB.apply(this);if(this.scrollbarWidth){jQuery('.navbar-fixed-top').css('padding-right',this.scrollbarWidth);}};var oldRSB=$.fn.modal.Constructor.prototype.resetScrollbar;$.fn.modal.Constructor.prototype.resetScrollbar=function(){oldRSB.apply(this);jQuery('.navbar-fixed-top').css('padding-right','');};if(navigator.userAgent.match(/IEMobile\/10\.0/)){var msViewportStyle=document.createElement('style');msViewportStyle.appendChild(document.createTextNode('@-ms-viewport{width:auto!important}'));document.querySelector('head').appendChild(msViewportStyle);}});jQuery(document).ready(function(){jQuery('#menu-primary a[href*="#"]:not([href="#"]), a.woocommerce-review-link[href*="#"]:not([href="#"]), a.post-comments[href*="#"]:not([href="#"])').bind('click',function(){var headerHeight;var hash=this.hash;var idName=hash.substring(1);var alink=this;if(jQuery('section [id*='+idName+']').length>0&&jQuery(window).innerWidth()>=767){jQuery('.current').removeClass('current');jQuery(alink).parent('li').addClass('current');}else{jQuery('.current').removeClass('current');}
if(jQuery(window).innerWidth()>=767){headerHeight=jQuery('.sticky-navigation').outerHeight();}else{headerHeight=0;}
if(location.pathname.replace(/^\//,'')===this.pathname.replace(/^\//,'')&&location.hostname===this.hostname){var target=jQuery(this.hash);target=target.length?target:jQuery('[name='+this.hash.slice(1)+']');if(target.length){jQuery('html,body').animate({scrollTop:target.offset().top-headerHeight+10},1200);return false;}}});jQuery('#inpage_scroll_btn').click(function(){var anchor=jQuery('#inpage_scroll_btn').attr('data-anchor');var offset=-60;jQuery('html, body').animate({scrollTop:jQuery(anchor).offset().top+offset},1200);});});function mainNav(){if(jQuery('.overlay-layer-nav').hasClass('sticky-navigation-open')){return false;}
var $llorix_one_lite_header_height;var top=(document.documentElement&&document.documentElement.scrollTop)||document.body.scrollTop;var topMenuClose=-70;var topMenuOpen=0;if(jQuery('.admin-bar').length>0){$llorix_one_lite_header_height=jQuery('.navbar').height();topMenuClose=$llorix_one_lite_header_height*-1;topMenuOpen=32;}
if(top>40){jQuery('.appear-on-scroll').stop().animate({'opacity':'1','top':topMenuOpen});}else{jQuery('.appear-on-scroll').stop().animate({'top':topMenuClose,'opacity':'0'});}}
function scrolled(){if(jQuery(window).width()>=751){var llorix_one_lite_scrollTop=jQuery(window).scrollTop();var headerHeight=jQuery('.sticky-navigation').outerHeight();var isInOneSection='no';jQuery('section').each(function(){var thisID='#'+jQuery(this).attr('id');var llorix_one_lite_offset=jQuery(this).offset().top;var thisHeight=jQuery(this).outerHeight();var thisBegin=llorix_one_lite_offset-headerHeight;var thisEnd=llorix_one_lite_offset+thisHeight-headerHeight;if(llorix_one_lite_scrollTop>=thisBegin&&llorix_one_lite_scrollTop<=thisEnd){isInOneSection='yes';jQuery('.current').removeClass('current');jQuery('#menu-primary a[href$="'+thisID+'"]').parent('li').addClass('current');return false;}
if(isInOneSection==='no'){jQuery('.current').removeClass('current');}});}}
var timer;var $body=jQuery('body');var $nav=jQuery('.sticky-navigation');var veryTopHeaderHeight;var adminBarHeight;var isAdminBar;var limit;jQuery(document).ready(function(){veryTopHeaderHeight=jQuery('.very-top-header').height();adminBarHeight=32;isAdminBar=jQuery('#wpadminbar').length!==0;limit=0;});jQuery(window).scroll(function(){mainNav();if(timer){clearTimeout(timer);}
timer=setTimeout(function(){scrolled();},500);if(window.innerWidth>768){var window_offset=$body.offset().top-jQuery(window).scrollTop();if(typeof $nav!=='undefined'){if(isAdminBar){if(typeof $nav.parent()!=='undefined'){limit=($nav.parent().hasClass('sticky-navigation-open')?-veryTopHeaderHeight:0)+adminBarHeight;}}else{if(typeof $nav.parent()!=='undefined'){limit=$nav.parent().hasClass('sticky-navigation-open')?-veryTopHeaderHeight:0;}}
if(window_offset<limit){$nav.css('top',limit);}else{$nav.css('top',window_offset);}}}});var window_width_old;jQuery(document).ready(function(){window_width_old=jQuery('.container').width();if(window_width_old<=462){jQuery('.post-type-archive-product .products').llorix_one_lite_gridpinterest({columns:1,selector:'.product',calcMin:false});jQuery('.cart-collaterals .products').llorix_one_lite_gridpinterest({columns:1,selector:'.product',calcMin:false});}else if(window_width_old<=750){jQuery('.post-type-archive-product .products').llorix_one_lite_gridpinterest({columns:2,selector:'.product',calcMin:false});jQuery('.cart-collaterals .products').llorix_one_lite_gridpinterest({columns:1,selector:'.product',calcMin:false});}else{jQuery('.post-type-archive-product .products').llorix_one_lite_gridpinterest({columns:4,selector:'.product',calcMin:false});jQuery('.cart-collaterals .products').llorix_one_lite_gridpinterest({columns:2,selector:'.product',calcMin:false});}});jQuery(window).resize(function(){if(window_width_old!==jQuery('.container').outerWidth()){window_width_old=jQuery('.container').outerWidth();if(window_width_old<=462){jQuery('.post-type-archive-product .products').llorix_one_lite_gridpinterest({columns:1,selector:'.product',calcMin:false});jQuery('.cart-collaterals .products').llorix_one_lite_gridpinterest({columns:1,selector:'.product',calcMin:false});}else if(window_width_old<=750){jQuery('.post-type-archive-product .products').llorix_one_lite_gridpinterest({columns:2,selector:'.product',calcMin:false});jQuery('.cart-collaterals .products').llorix_one_lite_gridpinterest({columns:1,selector:'.product',calcMin:false});}else{jQuery('.post-type-archive-product .products').llorix_one_lite_gridpinterest({columns:4,selector:'.product',calcMin:false});jQuery('.cart-collaterals .products').llorix_one_lite_gridpinterest({columns:2,selector:'.product',calcMin:false});}}});(function($,window,document,undefined){var defaults={columns:3,selector:'div',excludeParentClass:'',calcMin:true};function LlorixOneLiteGridPinterest(element,options){this.element=element;this.options=$.extend({},defaults,options);this.defaults=defaults;this.init();}
LlorixOneLiteGridPinterest.prototype.init=function(){var self=this,$container=$(this.element);var $select_options=$(this.element).children();self.make_magic($container,$select_options);};LlorixOneLiteGridPinterest.prototype.make_magic=function(container){var self=this;var $container=$(container),columns_height=[],prefix='llorix_one_lite',unique_class=prefix+'_grid_'+self.make_unique();var local_class=prefix+'_grid';var classname;var substr_index=this.element.className.indexOf(prefix+'_grid_');if(substr_index>-1){classname=this.element.className.substr(0,this.element.className.length-unique_class.length-local_class.length-2);}else{classname=this.element.className;}
var my_id;if(this.element.id===''){my_id=prefix+'_id_'+self.make_unique();}else{my_id=this.element.id;}
$container.after('<div id="'+my_id+'" class="'+classname+' '+local_class+' '+unique_class+'"></div>');var i;for(i=1;i<=this.options.columns;i++){columns_height.push(0);var first_cols='';var last_cols='';if(i%self.options.columns===1){first_cols=prefix+'_grid_first';}
if(i%self.options.columns===0){first_cols=prefix+'_grid_last';}
$('.'+unique_class).append('<div class="'+prefix+'_grid_col_'+this.options.columns+' '+prefix+'_grid_column_'+i+' '+first_cols+' '+last_cols+'"></div>');}
var calcMin=this.options.calcMin;var cols=this.options.columns;if(this.element.className.indexOf(local_class)<0){$container.children(this.options.selector).each(function(index){var this_index;if(calcMin===true){var min=Math.min.apply(null,columns_height);this_index=columns_height.indexOf(min)+1;}else{this_index=index%cols+1;}
$(this).attr(prefix+'grid-attr','this-'+index).appendTo('.'+unique_class+' .'+prefix+'_grid_column_'+this_index);if(calcMin===true){columns_height[this_index-1]=$('.'+unique_class+' .'+prefix+'_grid_column_'+this_index).height();}});}else{var no_boxes=$container.find(this.options.selector).length;for(i=0;i<no_boxes;i++){var this_index;if(calcMin===true){var min=Math.min.apply(null,columns_height);this_index=columns_height.indexOf(min)+1;}
else{this_index=i%cols+1;}
$('#'+this.element.id).find('['+prefix+'grid-attr="this-'+i+'"]').appendTo('.'+unique_class+' .'+prefix+'_grid_column_'+this_index);if(calcMin===true){columns_height[this_index-1]=$('.'+unique_class+' .'+prefix+'_grid_column_'+this_index).height();}}}
$container.remove();};LlorixOneLiteGridPinterest.prototype.make_unique=function(){var text='';var possible='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';for(var i=0;i<10;i++){text+=possible.charAt(Math.floor(Math.random()*possible.length));}
return text;};LlorixOneLiteGridPinterest.prototype.allValuesSame=function(arr){for(var i=1;i<arr.length;i++){if(arr[i]!==arr[0]){return false;}}
return true;};$.fn.llorix_one_lite_gridpinterest=function(options){return this.each(function(){var value='';if(!$.data(this,value)){$.data(this,value,new LlorixOneLiteGridPinterest(this,options));}});};})(jQuery);var isMobile={Android:function(){return navigator.userAgent.match(/Android/i);},BlackBerry:function(){return navigator.userAgent.match(/BlackBerry/i);},iOS:function(){return navigator.userAgent.match(/iPhone|iPad|iPod/i);},Opera:function(){return navigator.userAgent.match(/Opera Mini/i);},Windows:function(){return navigator.userAgent.match(/IEMobile/i);},any:function(){return(isMobile.Android()||isMobile.BlackBerry()||isMobile.iOS()||isMobile.Opera()||isMobile.Windows());}};(function($){$('.menu-item a').on('keydown',function(e){if(e.which===37){e.preventDefault();$(this).parent().prev().children('a').focus();}
else if(e.which===39){e.preventDefault();$(this).parent().next().children('a').focus();}
else if(e.which===40){e.preventDefault();if($(this).next().next().length){$(this).next().next().find('li:first-child a').first().focus();}
else{$(this).parent().next().children('a').focus();}}
else if(e.which===38){e.preventDefault();if($(this).parent().prev().length){$(this).parent().prev().children('a').focus();}
else{$(this).parents('ul').first().prev().prev().focus();}}});})(jQuery);(function($){function initMainNavigation(container){container.find('.menu-item-has-children > a').after('<button class="dropdown-toggle" aria-expanded="false"><span class="dropdown-toggle-inner">'+screenReaderText.expand+'</span></button>');container.find('.current-menu-ancestor > button').addClass('toggled-on');container.find('.current-menu-ancestor > .sub-menu').addClass('toggled-on');container.find('.menu-item-has-children').attr('aria-haspopup','true');container.find('.dropdown-toggle').click(function(e){var _this=$(this);e.preventDefault();_this.toggleClass('toggled-on');_this.next('.children, .sub-menu').toggleClass('toggled-on');_this.attr('aria-expanded',_this.attr('aria-expanded')==='false'?'true':'false');_this.find('.dropdown-toggle-inner').html(_this.html()===screenReaderText.expand?screenReaderText.collapse:screenReaderText.expand);});}
initMainNavigation($('.main-navigation'));var masthead=$('#masthead');var menuToggle=masthead.find('#menu-toggle');var siteHeaderMenu=masthead.find('#site-header-menu');var siteNavigation=masthead.find('#site-navigation');(function(){if(!menuToggle){return;}
menuToggle.click(function(){$(this).add(siteHeaderMenu).toggleClass('toggled-on');});})();(function(){if(!siteNavigation||!siteNavigation.children().length){return;}
if('ontouchstart'in window){siteNavigation.find('.menu-item-has-children > a').on('touchstart.llorix-one-lite',function(e){var el=$(this).parent('li');if(!el.hasClass('focus')){e.preventDefault();el.toggleClass('focus');el.siblings('.focus').removeClass('focus');}});}
siteNavigation.find('a').on('focus.llorix-one-lite blur.llorix-one-lite',function(){$(this).parents('.menu-item').toggleClass('focus');});})();function onResizeARIA(){if(910>window.innerWidth){if(menuToggle.hasClass('toggled-on')){menuToggle.attr('aria-expanded','true');}else{menuToggle.attr('aria-expanded','false');}
if(siteHeaderMenu.hasClass('toggled-on')){siteNavigation.attr('aria-expanded','true');}else{siteNavigation.attr('aria-expanded','false');}
menuToggle.attr('aria-controls','site-navigation social-navigation');}else{menuToggle.removeAttr('aria-expanded');siteNavigation.removeAttr('aria-expanded');menuToggle.removeAttr('aria-controls');}}
$(document).ready(function(){$(window).on('load.llorix-one-lite',onResizeARIA);});})(jQuery);jQuery(document).ready(function(){if(isMobile){fixed_responsive_bg_body();}});function fixed_responsive_bg_body(){if(jQuery('body').hasClass('custom-background')){var thisItem=jQuery('body.custom-background');thisItem.prepend('<div class="mobile-bg-fixed" style="background-image:'+thisItem.css('background-image')+';"></div>');}};var slideWidth;var slideCount;var slideHeight=0;var sliderUlHeight=0;var marginTop=0;jQuery(document).ready(function(){llorix_one_latest_news();jQuery('button.control_prev').click(function(){llorix_one_moveBottom();});jQuery('button.control_next').click(function(){llorix_one_moveTop();});});jQuery(window).resize(function(){slideWidth;slideCount;slideHeight=0;sliderUlHeight=0;marginTop=0;jQuery('#llorix_one_slider > ul > li').css('height','auto').each(function(){if(slideHeight<jQuery(this).height()){slideHeight=jQuery(this).height();}});slideCount=jQuery('#llorix_one_slider > ul > li').length;sliderUlHeight=slideCount*slideHeight;jQuery('#llorix_one_slider').css({width:slideWidth,height:slideHeight});jQuery('#llorix_one_slider > ul > li ').css({height:slideHeight});jQuery('#llorix_one_slider > ul').css({height:sliderUlHeight,top:marginTop});if(jQuery('.control_next').hasClass('fade-btn')){jQuery('.control_next').removeClass('fade-btn');}
if(!jQuery('.control_prev').hasClass('fade-btn')){jQuery('.control_prev').addClass('fade-btn');}});function llorix_one_latest_news(){slideHeight=0;jQuery('#llorix_one_slider > ul > li').css('height','auto').each(function(){if(slideHeight<jQuery(this).height()){slideHeight=jQuery(this).height();}});slideCount=jQuery('#llorix_one_slider > ul > li').length;sliderUlHeight=slideCount*slideHeight;jQuery('#llorix_one_slider').css({width:slideWidth,height:slideHeight});jQuery('#llorix_one_slider > ul > li ').css({height:slideHeight});jQuery('#llorix_one_slider > ul').css({height:sliderUlHeight});}
function llorix_one_moveTop(){if(marginTop-slideHeight>=-sliderUlHeight+slideHeight){marginTop=marginTop-slideHeight;jQuery('#llorix_one_slider > ul').animate({top:marginTop},400);if(marginTop===-slideHeight*(slideCount-1)){jQuery('.control_next').addClass('fade-btn');}
if(jQuery('.control_prev').hasClass('fade-btn')){jQuery('.control_prev').removeClass('fade-btn');}}}
function llorix_one_moveBottom(){if(marginTop+slideHeight<=0){marginTop=marginTop+slideHeight;jQuery('#llorix_one_slider > ul').animate({top:marginTop},400);if(marginTop===0){jQuery('.control_prev').addClass('fade-btn');}
if(jQuery('.control_next').hasClass('fade-btn')){jQuery('.control_next').removeClass('fade-btn');}}}
jQuery(window).load(function(){'use strict';jQuery('.status').fadeOut();jQuery('.preloader').delay(1000).fadeOut('slow');});jQuery(window).resize(function(){'use strict';var ww=jQuery(window).width();if(ww<480){jQuery('.sticky-navigation a').on('click',function(){jQuery('.navbar-toggle').click();});}});jQuery(document).ready(function(){jQuery('html').click(function(){jQuery('.llorix_one_lite_map_overlay').show();});jQuery('#container-fluid').click(function(event){event.stopPropagation();});jQuery('.llorix_one_lite_map_overlay').on('click',function(){jQuery(this).hide();});});jQuery(document).ready(function(){if(jQuery('.overlay-layer-nav').hasClass('sticky-navigation-open')){var llorix_one_lite_header_height=jQuery('.navbar').height();llorix_one_lite_header_height+=84;jQuery('.header .overlay-layer').css('padding-top',llorix_one_lite_header_height);}
if(navigator.userAgent.match(/MSIE 10/i)||navigator.userAgent.match(/Trident\/7\./)){jQuery('body').on('mousewheel',function(){event.preventDefault();var wd=event.wheelDelta;var csp=window.pageYOffset;window.scrollTo(0,csp-wd);});}});;(function(){var is_webkit=navigator.userAgent.toLowerCase().indexOf('webkit')>-1,is_opera=navigator.userAgent.toLowerCase().indexOf('opera')>-1,is_ie=navigator.userAgent.toLowerCase().indexOf('msie')>-1;if((is_webkit||is_opera||is_ie)&&document.getElementById&&window.addEventListener){window.addEventListener('hashchange',function(){var id=location.hash.substring(1),element;if(!(/^[A-z0-9_-]+$/.test(id))){return;}
element=document.getElementById(id);if(element){if(!(/^(?:a|select|input|button|textarea)$/i.test(element.tagName))){element.tabIndex=-1;}
element.focus();}},false);}})();;(function($,window){var isfrontpage=false;$(document).ready(function(){if($('.header-on-frontpage').length>0){isfrontpage=true;if($(window).scrollTop()>200){$('.header-on-frontpage').addClass('header-frontpage-not');}}});$(window).scroll(function(event){if(!isfrontpage)
return;var thisScrollTop=$(this).scrollTop(),frontpageClass=$('.header-on-frontpage'),notClass='header-frontpage-not';if(thisScrollTop>100&&!frontpageClass.hasClass(notClass)){frontpageClass.addClass(notClass);}else if(thisScrollTop<100&&frontpageClass.hasClass(notClass)){frontpageClass.removeClass(notClass);}});})(jQuery,window);
;!function(a,b){"use strict";function c(){if(!e){e=!0;var a,c,d,f,g=-1!==navigator.appVersion.indexOf("MSIE 10"),h=!!navigator.userAgent.match(/Trident.*rv:11\./),i=b.querySelectorAll("iframe.wp-embedded-content");for(c=0;c<i.length;c++){if(d=i[c],!d.getAttribute("data-secret"))f=Math.random().toString(36).substr(2,10),d.src+="#?secret="+f,d.setAttribute("data-secret",f);if(g||h)a=d.cloneNode(!0),a.removeAttribute("security"),d.parentNode.replaceChild(a,d)}}}var d=!1,e=!1;if(b.querySelector)if(a.addEventListener)d=!0;if(a.wp=a.wp||{},!a.wp.receiveEmbedMessage)if(a.wp.receiveEmbedMessage=function(c){var d=c.data;if(d.secret||d.message||d.value)if(!/[^a-zA-Z0-9]/.test(d.secret)){var e,f,g,h,i,j=b.querySelectorAll('iframe[data-secret="'+d.secret+'"]'),k=b.querySelectorAll('blockquote[data-secret="'+d.secret+'"]');for(e=0;e<k.length;e++)k[e].style.display="none";for(e=0;e<j.length;e++)if(f=j[e],c.source===f.contentWindow){if(f.removeAttribute("style"),"height"===d.message){if(g=parseInt(d.value,10),g>1e3)g=1e3;else if(~~g<200)g=200;f.height=g}if("link"===d.message)if(h=b.createElement("a"),i=b.createElement("a"),h.href=f.getAttribute("src"),i.href=d.value,i.host===h.host)if(b.activeElement===f)a.top.location.href=d.value}else;}},d)a.addEventListener("message",a.wp.receiveEmbedMessage,!1),b.addEventListener("DOMContentLoaded",c,!1),a.addEventListener("load",c,!1)}(window,document);