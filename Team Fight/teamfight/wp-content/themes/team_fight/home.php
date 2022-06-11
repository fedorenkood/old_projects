<?php /* Template Name: Homepage */ ?>
<?php get_header(); ?>
<?php
    $currentUserId = get_current_user_id();
    $userAvatar = get_avatar_url($currentUserId);
    $userName = get_user_meta($currentUserId, 'steam_personaname', true);
    $state = get_user_meta($currentUserId, 'steam_personastate', true);
    $steamId = get_user_meta($currentUserId, 'steam_steamid', true);
?>				    
	<section>
		<div class="container">
			<div class="row game_box box_elem_midd">
				<div class="game_card">
					<a href="#" class="popup_content">
						<p class="game_name">Counter strike: Global offensive</p>
						<img src="<?=get_stylesheet_directory_uri()?>/img/game_card/cs_go.png" alt="">
						<p class="status"><i class="fa fa-circle on" aria-hidden="true"></i>online</p>
					</a>
					<?php
						include 'libs/site_elements/cs_go_search_pop_up.php';
					?>
				</div>
				<div class="game_card">
					<a href="#"  class="popup_content">
						<p class="game_name">Dota 2</p>
						<img src="<?=get_stylesheet_directory_uri()?>/img/game_card/dota_2.png" alt="">
						<p class="status"><i class="fa fa-circle on" aria-hidden="true"></i>online</p>
					</a>
					<?php
						include "libs/site_elements/dota_2_search_pop_up.php";
					?>
				</div>
			</div>
		</div>
	</section>


<?php  get_footer(); ?>
</html>