<?php

// wpSAP: Upload Avatar
function wpsap_upload_avatar($url, $userId, $slug){
	$ch = curl_init();
	curl_setopt ( $ch, CURLOPT_URL, $url );
	curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
	curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, 10 );
	curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt( $ch, CURLOPT_FAILONERROR, true );
	$image_contents = curl_exec( $ch );
	curl_close( $ch );
	
	$upload = wp_upload_bits('avatar-' . $userId . '-' . $slug . '.jpg' , null, $image_contents );
	
	return $upload['url'];
}

function wpsap_sync_steam_profile($currentSteamId, $wpUserId = false){
	global $wpsapConfig, $wpsapOptions;
	// SteamAPI call
	$apiUrl = file_get_contents( 'http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=' . $wpsapConfig['apiKey'] . '&steamids=' . $currentSteamId ); 
	$json = json_decode($apiUrl, true);
	
// 	print_r($json);exit;
	
	
	// Generate Meta Data
	foreach($wpsapOptions['metaFields'] as $name){
		if($name == 'realname'){
			$wpsapProfile['steam_realname'] = (isset($json['response']['players'][0]['realname'])) ? $json['response']['players'][0]['realname'] : $wpsapProfile['steam_personaname'];
			
		}else{
			$metaName = 'steam_'.$name;
			$wpsapProfile[$metaName] = $json['response']['players'][0][$name];
			
		}
	}
	$wpsapProfile['steam_uptodate'] = time();
	
	$wpsapProfile['steam_personaname'] = htmlspecialchars($wpsapProfile['steam_personaname']);
	
	if(!empty($wpsapProfile)){
		return $wpsapProfile;
		
	}else{
		return false;
		
	}
}

function wpsap_is_user_synced(){
	if( is_user_logged_in() ){
		$getUserMeta = get_user_meta(get_current_user_id(), 'steam_steamid', true);
		if( !empty($getUserMeta) ){
			return true;
		}else{
			return false;
		}
		
	}
}

function wpsap_button_login_url(){
	global $wpsapConfig;
	return $wpsapConfig['urlLogin'];
}

function wpsap_button_sync_url(){
	global $wpsapConfig;
	return $wpsapConfig['urlSync'];
}

function wpsap_button_logout_url(){
	global $wpsapConfig;
	return $wpsapConfig['urlLogout'];
}

function wpsap_button_login(){
	global $wpsapOptions;
	
	if(!is_user_logged_in()){
		$wpsapButtonPopup = ($wpsapOptions['enablePopup']) ? 'id="wpsapButtonPopup"' : '';
		echo '<a ' . $wpsapButtonPopup . ' class="wpsapButtonLogin" href="' . wpsap_button_login_url() . '"><img src="http://cdn.steamcommunity.com/public/images/signinthroughsteam/sits_01.png"></a>';
	}
}

function wpsap_button_sync(){
	global $wpsapOptions;
	
	if(is_user_logged_in()&& !wpsap_is_user_synced()){
		$wpsapButtonPopup = ($wpsapOptions['enablePopup']) ? 'id="wpsapButtonPopup"' : '';
		echo '<a ' . $wpsapButtonPopup . ' class="wpsapButtonSync" href="' . wpsap_button_sync_url() . '">Synchronize with Steam</a>';
	}
}

function wpsap_button_logout(){
	if(is_user_logged_in()){
		echo '<a class="wpsapButtonLogout" href="' . wpsap_button_logout_url() . '">Logout</a>';
	}
}