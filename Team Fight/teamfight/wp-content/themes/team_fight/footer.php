	<footer>
		<!--<a href="#" ><img src="img/logo.svg" alt="" class="logo"></a>-->
		<nav class="mnu_line_btm">
			<ul>
				<li><a class="popup_content" href="#about" >About</a></li>
				<li><a class="popup_content" href="#support" >Support</a></li>
				<li><a class="popup_content" href="#premium" >Premium</a></li>
			</ul>
		</nav>
	</footer>
	
	<?php
		include 'libs/site_elements/about_pop_up.php';
		include 'libs/site_elements/support_pop_up.php';
		include 'libs/site_elements/premium_pop_up.php';
		include 'libs/site_elements/cs_go_search_pop_up.php';
		include 'libs/site_elements/dota_2_search_pop_up.php';
		include 'libs/site_elements/profile_pop_up.php';
	?>

	<div class="hidden"></div>
	<!--[if lt IE 9]>
	<script src="libs/html5shiv/es5-shim.min.js"></script>
	<script src="libs/html5shiv/html5shiv.min.js"></script>
	<script src="libs/html5shiv/html5shiv-printshiv.min.js"></script>
	<script src="libs/respond/respond.min.js"></script>
	<![endif]-->

	<script src="<?php  echo get_stylesheet_directory_uri(); ?>/libs/jquery/jquery-2.1.3.min.js"></script>
	<script src="<?php  echo get_stylesheet_directory_uri(); ?>/libs/magnific-popup/jquery.magnific-popup.min.js"></script>
	<script src="<?php  echo get_stylesheet_directory_uri(); ?>/libs/mixitup/mixitup.min.js"></script>
	<script src="<?php  echo get_stylesheet_directory_uri(); ?>/libs/animate/animate-css.js"></script>
	<script src="<?php  echo get_stylesheet_directory_uri(); ?>/libs/waypoints/waypoints.min.js"></script>
	<script src="<?php  echo get_stylesheet_directory_uri(); ?>/libs/scroll2id/PageScroll2id.min.js"></script>
	<script src="<?php  echo get_stylesheet_directory_uri(); ?>/js/common.js"></script>
	<script src="<?php  echo get_stylesheet_directory_uri(); ?>/js/stopwatch.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<!-- Chat scripts -->
	<script type="text/javascript" src="<?php  echo get_stylesheet_directory_uri(); ?>/js/dialog.js"></script>
	 <script src="<?php  echo get_stylesheet_directory_uri(); ?>/js/bootstrap.min.js"></script> 
	<!-- Yandex.Metrika counter --><!-- /Yandex.Metrika counter -->
	<!-- Google Analytics counter --><!-- /Google Analytics counter -->
<script>
jQuery('input:radio[name=plan]').change(function() {
    var level = this.value;
    jQuery('#premium_buy').attr('href','<?=get_the_permalink(8)?>?level='+level);
});
jQuery('#tm_preview').click(function(){
    jQuery('#tm_upload').trigger('click'); 
});

function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
      jQuery('#tm_preview').attr('src', e.target.result);
    }
    reader.readAsDataURL(input.files[0]);
  }
}

jQuery("#tm_upload").change(function() {
    jQuery(this).attr('name','tm_background');
  readURL(this);
});
</script>
</body>