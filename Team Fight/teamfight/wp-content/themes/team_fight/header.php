<!DOCTYPE html> 
<html>
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="shortcut icon" href="" />
	<link rel="stylesheet" href="<?php  echo get_stylesheet_directory_uri(); ?>/libs/bootstrap/bootstrap-grid.min.css" />
	<link rel="stylesheet" href="<?php  echo get_stylesheet_directory_uri(); ?>/libs/animate/animate.min.css" />
	<link rel="stylesheet" href="<?php  echo get_stylesheet_directory_uri(); ?>/libs/font-awesome/css/font-awesome.min.css" />
	<link rel="stylesheet" href="<?php  echo get_stylesheet_directory_uri(); ?>/libs/magnific-popup/magnific-popup.css" />
	<link rel="stylesheet" href="<?php  echo get_stylesheet_directory_uri(); ?>/libs/linea/styles.css" />
	<link rel="stylesheet" href="<?php  echo get_stylesheet_directory_uri(); ?>/css/fonts.css" />
	<link rel="stylesheet" href="<?php  echo get_stylesheet_directory_uri(); ?>/css/main.css" />
	<link rel="stylesheet" href="<?php  echo get_stylesheet_directory_uri(); ?>/css/skins/tomato.css" />
	<link rel="stylesheet" href="<?php  echo get_stylesheet_directory_uri(); ?>/css/media.css" />
	<link rel="stylesheet" href="<?php  echo get_stylesheet_directory_uri(); ?>/style.css" />
	<?php wp_head(); ?>
	<?php $db = new db('localhost','demopane_teamfig','v?%CT10e7F?X','demopane_teamfight'); ?>
</head>
<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
if(tm_is_paid_member()){
    $u__id = get_current_user_id();
    $color = tm_header_color($u__id);
    $font = tm_footer_color($u__id);
    $background = if_tm_background($u__id);
    $button = tm_button_color($u__id);
    $reset = is_reset($u__id);
    if(!$reset):
?>
<style>
    .modal_content,.mates_box,#message_box,.chat_timer p,header,ul,.message_scroll{
        background:<?=$color?> !important;
        color:<?=$font?> !important;
    }
    .chat_timer_box{
        color:<?=$color?> !important;
    }
    header a,p,a,.btn{
        color:<?=$font?> !important;
    }
    .btn{
        color:<?=$font?> !important;
        background:<?=$button?> !important;
    }
    
    .right .num_box_new {
        box-shadow: -346px 0 <?=$button?>, 28px 0 <?=$button?>;
    }
    .num_box_new{
        background:<?=$button?> !important;
    }
</style>
<body style="background-image:url(<?=$background?>)">
<?php endif;
} else { ?>
<body>
<?php } ?>
	<div class="loader">
		<div class="loader_inner"></div>
	</div>
	<header>
		<div class="container mnu_line">
			<div class="col-md-3 logo_box box_elem_midd">
				<a href="index.php" ><img src="<?php  echo get_stylesheet_directory_uri(); ?>/img/logo.svg" alt="" class="logo"></a>
			</div>
			<div class="col-md-9">
				<nav class="navbar-default">
					<ul>
						<li><a href="<?php echo site_url(); ?>">Games</a>
							<!-- <ul>
								<li><a href="#" class="cs_go"><img src="img/icons/cs_go.png" alt="">CS:GO</a></li>
								<li><a href="#" class="dota"><img src="img/icons/dota.png" alt="">Dota 2</a></li>
							</ul> -->
						</li>
						<li class="prem"><a class="popup_content" href="#premium" >Premium</a></li>
					</ul>
				</nav>

				<?php

				if ( !is_user_logged_in() ) { 
				
				echo do_shortcode('[wp_steam_auth login_image="http://cdn.steamcommunity.com/public/images/signinthroughsteam/sits_large_border.png"]');
				

					}  else {
				    
				    $currentUserId = get_current_user_id();
				    $userAvatar = get_avatar_url($currentUserId);
				    $userName = get_user_meta($currentUserId, 'steam_personaname', true);
				    $state = get_user_meta($currentUserId, 'steam_personastate', true);
				    $steamId = get_user_meta($currentUserId, 'steam_steamid', true);
				    
				    $db->saveUserId($steamId,$userName,$userAvatar);
				    
				?>	
				<li class="profile list_group">
                    <a href="#profile" class="list_group_item popup_content">
                        <div class="list_picture">
                            <img class="circle" src="<?=$userAvatar?>" alt="icon">
                        </div>
                        <div class="list_content box_elem_midd">
                            <p class="list_group_item_nickname">
							<?=$userName;?> 
                            </p>
                            <?=OnOffLine($state);?>
                        </div>
                    </a>
                    <ul>
						<li>
							<a href="#profile" class="list_ul_elem popup_content"><img class="icon" src="<?php  echo get_stylesheet_directory_uri(); ?>/img/icons/player_ico.svg" alt="">Profile</a>
							<?php 
								include 'libs/site_elements/profile_pop_up.php';
							?>
						</li>
						<li>
							<a href="#premium" class="list_ul_elem popup_content"><img class="icon" src="<?php  echo get_stylesheet_directory_uri(); ?>/img/icons/premium.svg" alt="">Premium</a>
						</li>
						<li><?php echo '<a href="'.wpsap_button_logout_url().'" class="list_ul_elem"><img class="icon" src="http://in.gl/demo/team_fight/wp-content/themes/team_fight/img/icons/logout.svg" alt="">Logout</a>';?></li>
					</ul>
				</li>
				<?php } ?>
			</div>
		</div>
		<?php 
		include 'libs/site_elements/premium_pop_up.php';
		?>
	</header>