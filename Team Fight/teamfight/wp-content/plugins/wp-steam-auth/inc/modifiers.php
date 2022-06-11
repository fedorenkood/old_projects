<?php

$wpsapConfig['urlLogin'] = 	(!empty($wpsapConfig['slugSteamApp'])) ? '/' . $wpsapConfig['slugSteamApp'] . '/' . user_trailingslashit($wpsapConfig['slugLogin']): '/' . user_trailingslashit($wpsapConfig['slugLogin']);


$wpsapConfig['urlLogged'] = (!empty($wpsapConfig['slugSteamApp'])) ? '/' . $wpsapConfig['slugSteamApp'] . '/' . user_trailingslashit($wpsapConfig['slugLogged']): '/' . user_trailingslashit($wpsapConfig['slugLogged']);
$wpsapConfig['urlSync'] = 	(!empty($wpsapConfig['slugSteamApp'])) ? '/' . $wpsapConfig['slugSteamApp'] . '/' . user_trailingslashit($wpsapConfig['slugSync']): '/' . user_trailingslashit($wpsapConfig['slugSync']);
$wpsapConfig['urlLogout'] = (!empty($wpsapConfig['slugSteamApp'])) ? '/' . $wpsapConfig['slugSteamApp'] . '/' . user_trailingslashit($wpsapConfig['slugLogout']): '/' . user_trailingslashit($wpsapConfig['slugLogout']);

$wpsapConfig['urlLogin'] = 'login';
$wpsapConfig['urlLogged'] = 'logged';
$wpsapConfig['urlSync'] = 'sync';
$wpsapConfig['urlLogout'] = 'logout';


// wpSAP: Login Behavior
if( $wpsapOptions['enablePopup'] ){
	$wpsapConfig['loginRedirect'] = $wpsapConfig['urlLogged'];

// No Popup: Add referer
}else{
	
	// Add referer to Login link
	if($wpsapConfig['loginRedirectReferer']){
		$get_referer = 'http://'.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		$wpsapConfig['urlLogin'] = $wpsapConfig['urlLogin'] . '?referer=' . rawurlencode($get_referer);
		
		// Decode referer for loginRedirect
		if(isset($_GET['referer'])){
			$wpsapConfig['loginRedirect'] = rawurldecode($_GET['referer']);
		}
	}
	
}

// wpSAP: Loggout Behavior
if($wpsapConfig['logoutRedirectReferer']){
	
	// Add referer to Logout link
	$get_referer = 'http://'.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	$wpsapConfig['urlLogout'] = $wpsapConfig['urlLogout'] . '?referer=' . rawurlencode($get_referer);
	
	// Decode referer for loginRedirect
	if(isset($_GET['referer'])){
		$wpsapConfig['logoutRedirect'] = rawurldecode($_GET['referer']);
	}
}