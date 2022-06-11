<?php

$db = new db('localhost','demopane_teamfig','v?%CT10e7F?X','demopane_teamfight');
?><!DOCTYPE html> 
<html>
<head>
	<meta charset="utf-8" />
	<title>Заголовок</title>
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
</head>
<body>
	
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
				if(!isset($_SESSION['steamid'])) {
				    loginbutton();
					}  else {
				    include ('libs/steamauth/userInfo.php');
				    
				    $db->saveUserId($steamprofile['steamid'], $steamprofile['personaname'], $steamprofile['avatarfull']);
				?>	
				<li class="profile list_group">
                    <a href="#profile" class="list_group_item popup_content">
                        <div class="list_picture">
                            <img class="circle" src="<?=$steamprofile['avatarmedium']?>" alt="icon">
                        </div>
                        <div class="list_content box_elem_midd">
                            <p class="list_group_item_nickname">
							<?php
							include ('libs/steamauth/profileFunc.php');
							echo $steamprofile['personaname'];
							?> 
                            </p>
                            <?php
                            OnOffLine($steamprofile['personastate']);
                            ?>
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
						<li><?php logoutbutton(); ?></li>
					</ul>
				</li>
				<?php } ?>
			</div>
		</div>
		<?php 
		include 'libs/site_elements/premium_pop_up.php';
		?>
	</header>