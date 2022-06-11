<?php
function wpsap_shortcode($atts){
    $a = shortcode_atts(array(
		'login_text' 	=> 'Login',
		'login_class' 	=> '',
		'login_image' 	=> false,
		
		'logout_text' 	=> 'Logout',
		'logout_class' 	=> '',
		'logout_image' 	=> '',
		
		'show_sync' 	=> false,
		'sync_text' 	=> 'Synchronize',
		'sync_class' 	=> '',
		'sync_image' 	=> false,
    ), $atts);
	
	$wpsapOption_popupEnabled = get_option('wpsapOption_popupEnabled');
	
	$return = '';
	if(!is_user_logged_in()){
		$return .= '<a href="'.wpsap_button_login_url().'" class="'.$a['login_class'].'" '.(($wpsapOption_popupEnabled == 'checked') ? 'id="wpsapButtonPopup"': '').'>'.((!empty($a['login_image'])) ? '<img src="'.$a['login_image'].'" />' : $a['login_text']).'</a>';
		
	}else{
		$return .= ' <a href="'.wpsap_button_logout_url().'" class="'.$a['logout_class'].'">'.((!empty($a['logout_image'])) ? '<img src="'.$a['logout_image'].'" />' : $a['logout_text']).'</a>';
		if(!wpsap_is_user_synced() && $a['show_sync']){
			$return .= '<a href="'.wpsap_button_sync_url().'" class="'.$a['sync_class'].'" '.(($wpsapOption_popupEnabled == 'checked') ? 'id="wpsapButtonPopup"': '').'>'.((!empty($a['sync_image'])) ? '<img src="'.$a['sync_image'].'" />' : $a['sync_text']).'</a>';
		}
	}
	
	return $return;
	
}
add_shortcode('wp_steam_auth', 'wpsap_shortcode');