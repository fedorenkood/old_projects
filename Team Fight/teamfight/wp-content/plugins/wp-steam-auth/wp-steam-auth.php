<?php 
/*
Plugin Name: WP Steam Auth
Plugin URI: http://hwk.fr
Description: Register, Login & Synchronize WP Users via Steam Authentification
Author: hwk
Version: 0.6.4
Author URI: http://hwk.fr
Licence: GPLv2
*/

if(!defined('ABSPATH')) {
  die('You are not allowed to call this page directly.');
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

defined( 'WP_STEAM_AUTH_PLUGIN_ABS_PATH' ) || define( 'WP_STEAM_AUTH_PLUGIN_ABS_PATH', plugin_dir_path( __FILE__ ) );

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// wpSAP: Config
$wpsapConfig['domainName'] = 				get_site_url();
$wpsapConfig['apiKey'] = 					get_option('wpsapSettings_apiKey');
$wpsapConfig['logoutRedirect'] = 			get_option('wpsapSettings_logoutRedirect');
$wpsapConfig['loginRedirect'] = 			get_option('wpsapSettings_loginRedirect');
$wpsapConfig['logoutRedirectReferer'] = 	(get_option('wpsapSettings_logoutRedirectReferer') == 'checked') ? 	true : false;
$wpsapConfig['loginRedirectReferer'] = 		(get_option('wpsapSettings_loginRedirectReferer') == 'checked') ? 	true : false;

$wpsapOptions['avatarUpload'] = 			(get_option('wpsapOption_avatarUpload') == 'checked') ? 			true : false;
$wpsapOptions['avatarEnabled'] = 			(get_option('wpsapOption_avatarEnabled') == 'checked') ? 			true : false;
$wpsapOptions['enablePopup'] = 				(get_option('wpsapOption_popupEnabled') == 'checked') ? 			true : false;

$wpsapConfig['slugSteamApp'] = 				get_option('wpsapSettings_steamAppUrl');
$wpsapConfig['slugLogin'] = 				get_option('wpsapSettings_steamAppLoginUrl');
$wpsapConfig['slugLogged'] = 				'logged';
$wpsapConfig['slugSync'] = 					get_option('wpsapSettings_steamAppSyncUrl');
$wpsapConfig['slugLogout'] = 				get_option('wpsapSettings_steamAppLogoutUrl');

$wpsapOptions['metaFields'] = 				array('steamid','communityvisibilitystate','profilestate','personaname','lastlogoff','profileurl','avatar','avatarmedium','avatarfull','personastate','primaryclanid','timecreated','realname','uptodate');

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

require( WP_STEAM_AUTH_PLUGIN_ABS_PATH . 'inc/filters.php');
require( WP_STEAM_AUTH_PLUGIN_ABS_PATH . 'inc/shortcodes.php');

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// wpSAP: init
add_action( 'wp', 'wpsap_init' );
function wpsap_init(){
	
	global $wpsapConfig, $wpsapOptions;
	
	require( WP_STEAM_AUTH_PLUGIN_ABS_PATH . 'inc/modifiers.php');
	require( WP_STEAM_AUTH_PLUGIN_ABS_PATH . 'inc/functions.php');
	
	if( !empty($wpsapConfig['apiKey']) ){
		
		// WpSAP: Register JS
		if($wpsapOptions['enablePopup'] == 'checked'){
			wp_register_script('wpsap-js', plugin_dir_url(__FILE__) . '/js/wp-steam-auth.min.js', '', '', true);
			wp_enqueue_script('wpsap-js');
		}
		

		// wpSAP: Action Login / Sync
		if( get_query_var('wpsap_action') == 'login' || get_query_var('wpsap_action') == 'sync' ){
			
			// OpenID
			if( !class_exists('LightOpenID') ){
				require( WP_STEAM_AUTH_PLUGIN_ABS_PATH . 'library/openid.php');
			}
			
			try{
				$openid = new LightOpenID($wpsapConfig['domainName']);
				
				// Auth
				if(!$openid->mode){
					$openid->identity = 'http://steamcommunity.com/openid';
					wp_redirect( $openid->authUrl() );
					exit;
				
				// Cancel
				}elseif($openid->mode == 'cancel'){
					echo 'User has canceled authentication!';
					
				}else{
					
					// Success!
					if($openid->validate()){
						$identity = $openid->identity;
						$pattern = "/^http:\/\/steamcommunity\.com\/openid\/id\/(7[0-9]{15,25}+)$/";
						preg_match($pattern, $identity, $matches);
						$currentSteamId = $matches[1];
						
						// Wordpress Operations
						// --------------------
						
						// wpUser: steamId Exists?
						$args = array(  
							'meta_key'     => 'steam_steamid',
							'meta_value'   => $currentSteamId,
							'meta_compare' => '='
						);
						$findUser = get_users($args);
						$findUser = $findUser[0];
						
						// wpUser: Create user
						if( empty($findUser) ){
							
							$wpsapProfile = wpsap_sync_steam_profile($currentSteamId);
							
							if(!$wpsapProfile)
								return;
							
							if(get_query_var('wpsap_action') == 'sync' && is_user_logged_in()){
								$wpUserId = get_current_user_id();
								
								
								
							}elseif(get_query_var('wpsap_action') == 'login'){
								$wpUserName = 		$wpsapProfile['steam_personaname'];
								
								
								// var_dump($wpUserName);exit;
								
								
								$wpUserMail = 		$wpsapProfile['steam_steamid'].'@steamuser.com';
								$wpUserPassword = 	wp_generate_password(12, true);
								$wpUserId = 		wp_create_user( $wpUserName, $wpUserPassword, $wpUserMail );
								
								if($wpUserId->errors){
								    $digits = 3;
                                    $rrand = rand(pow(10, $digits-1), pow(10, $digits)-1);
                                    $wpUserId = 		wp_create_user( $wpUserName.'_'.$rrand, $wpUserPassword, $wpUserMail );                                    
								}
								// print_r($wpsapProfile);
								// if(is_string($wpUserId)){
							}
							
							if(!empty($wpUserId)){
								foreach($wpsapProfile as $name => $value){
									update_user_meta( $wpUserId, $name, $value );
								}
							}
							
							
							
							if($wpsapOptions['avatarUpload']){
								$wpsapUserAvatarUrl = wpsap_upload_avatar( $wpsapProfile['steam_avatarfull'], $wpUserId, sanitize_title($wpsapProfile['steam_personaname']) );
								update_user_meta( $wpUserId, 'steam_wp_avatar', $wpsapUserAvatarUrl );
							}
						
						// wpUser: Found user
						}else{
							$wpUserId = $findUser->ID;
							
							$wpsapGetForceResync = get_user_meta($wpUserId, 'steam_force_resync', true);
							if($wpsapGetForceResync == 1){
								
								$wpsapProfile = wpsap_sync_steam_profile($currentSteamId);
								
								if(!$wpsapProfile)
									return;
								
								foreach($wpsapProfile as $name => $value){
									update_user_meta( $wpUserId, $name, $value );
								}
								
								if($wpsapOptions['avatarUpload']){
									$wpsapUserAvatarUrl = wpsap_upload_avatar( $wpsapProfile['steam_avatarfull'], $wpUserId, sanitize_title($wpsapProfile['steam_personaname']) );
									update_user_meta( $wpUserId, 'steam_wp_avatar', $wpsapUserAvatarUrl );
								}
								
								delete_user_meta($wpUserId, 'steam_force_resync');
								
							}
							
						}
						
						// wpUser: Login Auth
						wp_set_auth_cookie( $wpUserId, true );
						
						// Redirect
						if (!headers_sent()) {
							wp_redirect( $wpsapConfig['loginRedirect'] );
							exit;
							
						}else{ ?>
							<script type="text/javascript">
								window.location.href = "<?php echo $wpsapConfig['loginRedirect']; ?>";
							</script>
							<noscript>
								<meta http-equiv="refresh" content="0;url=<?php echo $wpsapConfig['loginRedirect']; ?>" />
							</noscript>
							<?php
							exit;
						}
					
					// Error!
					}else{
						echo 'User is not logged in.'."\n";
						
					}
				}
			
			// Error
			}catch(ErrorException $e){
				echo $e->getMessage();
				
			}

		
		// wpSAP: Logged + Popup
		}elseif( get_query_var('wpsap_action') == 'logged' && $wpsapOptions['enablePopup'] ){
			echo '<script type="text/javascript">';
			echo 'window.close();';
			echo '</script>';
			echo '<meta http-equiv="refresh" content="1;url=' . $wpsapConfig['domainName'] . '" />';
			exit;

		
		
		// wpSAP: Logout
		}elseif( get_query_var('wpsap_action') == 'logout' ){
			wp_logout();
			wp_redirect( $wpsapConfig['logoutRedirect'] );
			exit;

		}
		
	}
	
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

add_action('admin_menu', 'wpsap_admin_menu');
function wpsap_admin_menu(){
    $menu = add_submenu_page('options-general.php', 'WP Steam Auth', 'WP Steam Auth', 'manage_options', 'wp-steam-auth', 'wpsap_admin_page');
	add_action( 'admin_print_styles-' . $menu, 'wpsap_admin_css' );
	add_action( 'admin_print_scripts-' . $menu, 'wpsap_admin_js' );
}

function wpsap_admin_css(){
	wp_enqueue_style( 'stylesheet_admin', plugins_url('/css/admin.css', __FILE__) );
}

function wpsap_admin_js(){
	wp_enqueue_script( 'jquery-functions', plugins_url('/js/admin.js', __FILE__), array( 'jquery' )  );
}

add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'wpsap_admin_plugins_link' );
function wpsap_admin_plugins_link($links){
	$mylinks = array(
		'<a href="' . admin_url( 'options-general.php?page=wp-steam-auth' ) . '">Settings</a>',
	);
	return array_merge($links, $mylinks);
}

add_action( 'admin_init', 'wpsap_admin_settings' );
function wpsap_admin_settings(){
	register_setting( 'wpsap-settings-group', 'wpsapSettings_apiKey' );
	register_setting( 'wpsap-settings-group', 'wpsapSettings_loginRedirect' );
	register_setting( 'wpsap-settings-group', 'wpsapSettings_loginRedirectReferer' );
	register_setting( 'wpsap-settings-group', 'wpsapSettings_logoutRedirect' );
	register_setting( 'wpsap-settings-group', 'wpsapSettings_logoutRedirectReferer' );
	
	register_setting( 'wpsap-settings-group', 'wpsapSettings_steamAppFlush' );
	register_setting( 'wpsap-settings-group', 'wpsapSettings_steamAppUrl' );
	register_setting( 'wpsap-settings-group', 'wpsapSettings_steamAppLoginUrl' );
	register_setting( 'wpsap-settings-group', 'wpsapSettings_steamAppSyncUrl' );
	register_setting( 'wpsap-settings-group', 'wpsapSettings_steamAppLogoutUrl' );
	
	register_setting( 'wpsap-settings-group', 'wpsapOption_avatarUpload' );
	register_setting( 'wpsap-settings-group', 'wpsapOption_avatarEnabled' );
	register_setting( 'wpsap-settings-group', 'wpsapOption_popupEnabled' );
	
	$wpsapSettings_steamAppUrl = 		get_option('wpsapSettings_steamAppUrl');
	$wpsapSettings_steamAppLoginUrl = 	get_option('wpsapSettings_steamAppLoginUrl');
	$wpsapSettings_steamAppSyncUrl = 	get_option('wpsapSettings_steamAppSyncUrl');
	$wpsapSettings_steamAppLogoutUrl = 	get_option('wpsapSettings_steamAppLogoutUrl');
	
	if(get_option('wpsapSettings_steamAppLoginUrl') == false){
		update_option('wpsapSettings_steamAppLoginUrl', 'login');
	}
	
	if(get_option('wpsapSettings_steamAppSyncUrl') == false){
		update_option('wpsapSettings_steamAppSyncUrl', 'sync');
	}
	
	if(get_option('wpsapSettings_steamAppLogoutUrl') == false){
		update_option('wpsapSettings_steamAppLogoutUrl', 'logout');
	}
	
	$wpsapSettings_steamAppUrl = 		get_option('wpsapSettings_steamAppUrl');
	$wpsapSettings_steamAppLoginUrl = 	get_option('wpsapSettings_steamAppLoginUrl');
	$wpsapSettings_steamAppSyncUrl = 	get_option('wpsapSettings_steamAppSyncUrl');
	$wpsapSettings_steamAppLogoutUrl = 	get_option('wpsapSettings_steamAppLogoutUrl');

}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function wpsap_admin_page() {
$wpsapSettings_steamAppUrl = 		get_option('wpsapSettings_steamAppUrl');
$wpsapSettings_steamAppLoginUrl = 	get_option('wpsapSettings_steamAppLoginUrl');
$wpsapSettings_steamAppSyncUrl = 	get_option('wpsapSettings_steamAppSyncUrl');
$wpsapSettings_steamAppLogoutUrl = 	get_option('wpsapSettings_steamAppLogoutUrl');
?>

<div class="wrap">

	<h1>WP Steam Auth Plugin</h1>
	
	<div id="poststuff">
	<div id="post-body" class="metabox-holder">
		<div id="post-body-content">
						
			<form method="post" action="options.php" style="max-width:1530px;">
				<?php settings_fields( 'wpsap-settings-group' ); ?>
				<?php do_settings_sections( 'wpsap-settings-group' ); ?>
				<input type="hidden" name="wpsap_admin_form_hidden" value="settings" />
				
				<div class="row">
					<div class="col-lg-7">
					
						<div class="row">
							<div class="col-lg-12">
								
								<div class="postbox">
									<h2 class="hndle"><span>Settings</span></h2>
									<div class="inside">
										<table class="form-table">
											<tr valign="top">
											<th scope="row" class="settinglabel"><label>Steam API Key <span class="text-danger">*</span></label></th>
											<td class="settingfield">
												<input type="text" name="wpsapSettings_apiKey" class="regular-text" value="<?php echo esc_attr( get_option('wpsapSettings_apiKey') ); ?>" placeholder="XXXXXXXXXXXXXXXXXXXXXXX" required />
												<p>Login to <a href="https://steamcommunity.com/" target="_blank">Steam</a>, go to: <a href="http://steamcommunity.com/dev/apikey" target="_blank">http://steamcommunity.com/dev/apikey</a> & enter your Domain URL</p>
											</td>
											</tr>

											<th scope="row" class="settinglabel"><label>Domain URL</label></th>
											<td class="settingfield">
												<?php echo get_site_url(); ?>
												<p>Full Domain URL. Should be the same as the one provided in your Steam API</p>
											</td>
											</tr>

											<th scope="row" class="settinglabel"><label>Post-Login Redirect <span class="text-danger">*</span></label></th>
											<td class="settingfield">
												<div class="wpsapSettings_loginRedirect">
													<input type="text" name="wpsapSettings_loginRedirect" class="regular-text" value="<?php echo esc_attr( get_option('wpsapSettings_loginRedirect') ); ?>" placeholder="http://" />
													<label><input type="checkbox" name="wpsapSettings_loginRedirectReferer" value="checked" <?php echo esc_attr( get_option('wpsapSettings_loginRedirectReferer') ); ?> /> Use referer instead</label>
													<p>Use Absolute URL</p>
												</div>
												<div class="wpsapSettings_loginRedirect_alt">
													<small><em class="text-muted">Popup Option enabled, no redirection needed</em></small>
												</div>
											</td>
											</tr>

											<th scope="row" class="settinglabel"><label>Post-Logout Redirect <span class="text-danger">*</span></label></th>
											<td class="settingfield">
												<input type="text" name="wpsapSettings_logoutRedirect" class="regular-text" value="<?php echo esc_attr( get_option('wpsapSettings_logoutRedirect') ); ?>" placeholder="http://" />
												<label><input type="checkbox" name="wpsapSettings_logoutRedirectReferer" value="checked" <?php echo esc_attr( get_option('wpsapSettings_logoutRedirectReferer') ); ?> /> Use referer instead</label>
												<p>Use Absolute URL</p>
											</td>
											</tr>

										</table>
									</div>	
								</div>
								

							</div>
							
							<div class="col-lg-12">
								
								<div class="postbox">
									<h2 class="hndle"><span>Permalinks & Rewriting</span></h2>
									<div class="inside">
										<input type="hidden" name="wpsapSettings_steamAppFlush" value="1" />
										<table class="form-table">
											<th scope="row" class="settinglabel"><label>Base URL Slug</label></th>
											<td class="settingfield">
												<input type="text" name="wpsapSettings_steamAppUrl" class="regular-text" value="<?php echo esc_attr( get_option('wpsapSettings_steamAppUrl') ); ?>" placeholder="" />
												<p>Base slug for authentification. Can be blank.</p>
											</td>
											</tr>

											<th scope="row" class="settinglabel"><label>Login slug <span class="text-danger">*</span></label></th>
											<td class="settingfield">
												<input type="text" name="wpsapSettings_steamAppLoginUrl" class="regular-text" value="<?php echo esc_attr( get_option('wpsapSettings_steamAppLoginUrl') ); ?>" placeholder="login" required />
												<p>Login URL: 
													<code>
														<?php 
														echo get_site_url(); 
														echo '<span class="wpsapSettings_steamAppUrl_mirror">';
														echo 	(!empty($wpsapSettings_steamAppUrl)) ? '/'.$wpsapSettings_steamAppUrl : '';
														echo '</span>';
														echo '/';
														echo '<span class="wpsapSettings_steamAppLoginUrl_mirror">';
														echo 	$wpsapSettings_steamAppLoginUrl;
														echo '</span>';
														echo user_trailingslashit('');
														?>
													</code>
												</p>
											</td>
											</tr>

											<th scope="row" class="settinglabel"><label>Synchronize slug <span class="text-danger">*</span></label></th>
											<td class="settingfield">
												<input type="text" name="wpsapSettings_steamAppSyncUrl" class="regular-text" value="<?php echo esc_attr( get_option('wpsapSettings_steamAppSyncUrl') ); ?>" placeholder="sync" required />
												<p>Synchronize URL: 
													<code>
														<?php 
														echo get_site_url(); 
														echo '<span class="wpsapSettings_steamAppUrl_mirror">';
														echo 	(!empty($wpsapSettings_steamAppUrl)) ? '/'.$wpsapSettings_steamAppUrl : '';
														echo '</span>';
														echo '/';
														echo '<span class="wpsapSettings_steamAppSyncUrl_mirror">';
														echo 	$wpsapSettings_steamAppSyncUrl;
														echo '</span>';
														echo user_trailingslashit('');
														
														?>
													</code>
												</p>
											</td>
											</tr>

											<th scope="row" class="settinglabel"><label>Logout slug <span class="text-danger">*</span></label></th>
											<td class="settingfield">
												<input type="text" name="wpsapSettings_steamAppLogoutUrl" class="regular-text" value="<?php echo esc_attr( get_option('wpsapSettings_steamAppLogoutUrl') ); ?>" placeholder="logout" required />
												<p>Logout URL: 
													<code>
														<?php 
														echo get_site_url(); 
														echo '<span class="wpsapSettings_steamAppUrl_mirror">';
														echo 	(!empty($wpsapSettings_steamAppUrl)) ? '/'.$wpsapSettings_steamAppUrl : '';
														echo '</span>';
														echo '/';
														echo '<span class="wpsapSettings_steamAppLogoutUrl_mirror">';
														echo 	$wpsapSettings_steamAppLogoutUrl;
														echo '</span>';
														echo user_trailingslashit('');
														?>
													</code>
												</p>
											</td>
											</tr>

										</table>
									</div>	
								</div>
								

							</div>
							
							<div class="col-lg-12">
								<div class="postbox">
									<h2 class="hndle"><span>Options</span></h2>
									<div class="inside">
										<table class="form-table">
											<tr valign="top">
											<th scope="row" class="settinglabel"><label>Upload Steam Avatar</label></th>
											<td class="settingfield">
												<label>
													<input type="checkbox" name="wpsapOption_avatarUpload" value="checked" <?php echo esc_attr( get_option('wpsapOption_avatarUpload') ); ?> /> Enable
												</label>
												<p>Automatically upload Steam avatar on registration. Adding the local url to the User Meta: <code>steam_wp_avatar</code>.</p>
											</td>
											</tr>
											
											<tr valign="top">
											<th scope="row" class="settinglabel"><label>Enable Steam Avatar</label></th>
											<td class="settingfield">
												<label>
													<input type="checkbox" name="wpsapOption_avatarEnabled" value="checked" <?php echo esc_attr( get_option('wpsapOption_avatarEnabled') ); ?> /> Enable
												</label>
												<p>Filter WP/BP functions <code>get_avatar()</code>, <code>get_avatar_url()</code> & <code>bp_avatar_filter()</code> to display locally uploaded Steam avatar.</p>
											</td>
											</tr>

											<tr valign="top">
											<th scope="row" class="settinglabel"><label>Popup Option</label></th>
											<td class="settingfield">
												<label>
													<input type="checkbox" name="wpsapOption_popupEnabled" value="checked" <?php echo esc_attr( get_option('wpsapOption_popupEnabled') ); ?> /> Enable
												</label>
												<p>Activate the Steam Popup module instead of full page redirect (Login / Sync.)</p>
												<p><u>Notice:</u> Remember to add the ID <code>wpsapButtonPopup</code> to your login button/link.</p>
											</td>
											</tr>

										</table>
									</div>	
								</div>
							</div>
							
							<div class="col-lg-12">
								<div class="postbox">
									<h2 class="hndle"><span>Steam API Data Example</span></h2>
									<div class="inside">
										<table class="form-table">
											<tr valign="top">
											<th scope="row" class="settinglabel"><label>WP User Meta</label></th>
											<td class="settingfield">
												
												<?php 
												$upload_dir = wp_upload_dir();
												$upload_dir = $upload_dir['url'] . '/...';
												
												$wpsapAdminUserMeta = array(	
																	'steamid' => 					'010101010101010101',
																	'communityvisibilitystate' => 	'3',
																	'profilestate' => 				'1',
																	'personaname' => 				'Player',
																	'lastlogoff' => 				'1475386810',
																	'profileurl' => 				'http://steamcommunity.com/id/PlayerURL/',
																	'avatar' => 					'https://steamcdn-a.akamaihd.net/...',
																	'avatarmedium' => 				'https://steamcdn-a.akamaihd.net/...',
																	'avatarfull' => 				'https://steamcdn-a.akamaihd.net/...',
																	'personastate' => 				'1',
																	'primaryclanid' => 				'103582792235138353',
																	'timecreated' => 				'1391105541',
																	'realname' => 					'John Doe',
																	'uptodate' => 					'1475548634',
																	'wp_avatar' => 					$upload_dir
																); ?>
												<?php foreach($wpsapAdminUserMeta as $meta => $value){ ?>
													<div class="form-group"><kbd>steam_<?php echo $meta; ?></kbd><small>: <?php echo $value; ?></small></div>
												<?php } ?>
												<p>Can be retrieved using <code>get_user_meta($user_id, 'steam_steamid', true);</code></p>
											</td>
											</tr>

										</table>
									</div>	
								</div>
							</div>
						</div>
						
						
					</div>
					
					<div class="col-lg-5">
						<div class="postbox">
							<h2 class="hndle"><span>Wordpress Shortcode</span> <span><a href="https://codex.wordpress.org/Shortcode" target="_blank">What is this?</a></span></h2>
							<div class="inside">
							
								<table class="form-table">

									<tr valign="top">
									<th scope="row" class="settinglabel"><label>Shortcode</label></th>
									<td class="settingfield">
										<pre>[wp_steam_auth]</pre>
									</td>
									</tr>
									<tr valign="top">
									<th scope="row" class="settinglabel"><label>Login Options</label></th>
									<td class="settingfield">
										<pre>[wp_steam_auth login_text="Login via Steam"]</pre>
										<pre>[wp_steam_auth login_class="my_class1 my_class2"]</pre>
										<pre>[wp_steam_auth login_image="http://..."]</pre>
									</td>
									</tr>
									
									<tr valign="top">
									<th scope="row" class="settinglabel"><label>Logout Options</label></th>
									<td class="settingfield">
										<pre>[wp_steam_auth logout_text="Logout"]</pre>
										<pre>[wp_steam_auth logout_class="my_class1 my_class2"]</pre>
										<pre>[wp_steam_auth logout_image="http://..."]</pre>
									</td>
									</tr>
									
									<tr valign="top">
									<th scope="row" class="settinglabel"><label>Sync. Options</label></th>
									<td class="settingfield">
										<pre>[wp_steam_auth show_sync="1"]</pre>
										<pre>[wp_steam_auth sync_text="Synchronize"]</pre>
										<pre>[wp_steam_auth sync_class="my_class1 my_class2"]</pre>
										<pre>[wp_steam_auth sync_image="http://..."]</pre>
										<p>All options can be combined together. ie: <code>[wp_steam_auth login_text="Login via Steam" login_class="my_class1 my_class2" logout_text="Logout"]</code></p>
									</td>
									</tr>

								</table>
							</div>	
						</div>
						
						<div class="postbox">
							<h2 class="hndle"><span>PHP Functions: Buttons & Conditions</span></h2>
							<div class="inside">
							
								<table class="form-table">

									<tr valign="top">
									<th scope="row" class="settinglabel"><label>Login button</label></th>
									<td class="settingfield">
										<pre>wpsap_button_login();</pre>
										<p>URL Only: <code>wpsap_button_login_url();</code></p>
									</td>
									</tr>
									<tr valign="top">
									<th scope="row" class="settinglabel"><label>Sync. button</label></th>
									<td class="settingfield">
										<pre>wpsap_button_sync();</pre>
										<p>URL Only: <code>wpsap_button_sync_url();</code></p>
									</td>
									</tr>
									<tr valign="top">
									<th scope="row" class="settinglabel"><label>Logout button</label></th>
									<td class="settingfield">
										<pre>wpsap_button_logout();</pre>
										<p>URL Only: <code>wpsap_button_logout_url();</code></p>
									</td>
									</tr>

									<tr valign="top">
									<th scope="row" class="settinglabel"><label>Logged in?</label></th>
									<td class="settingfield">
										<pre>if ( is_user_logged_in() ) {
echo '&lt;a href=&quot;&apos;.wpsap_button_logout_url().&apos;&quot;&gt;Logout&lt;/a&gt;';
}</pre>
										<p>May use in combination with <code>wpsap_button_logout();</code></p>
									</td>
									</tr>

									<tr valign="top">
									<th scope="row" class="settinglabel"><label>Need Sync.?</label></th>
									<td class="settingfield">
										<pre>if ( is_user_logged_in() && !wpsap_is_user_synced() ) {
echo '&lt;a href=&quot;&apos;.wpsap_button_sync_url().&apos;&quot;&gt;Synchronize&lt;/a&gt;';
}</pre>
										<p>May use in combination with <code>wpsap_button_sync();</code></p>
									</td>
									</tr>
									
									<tr valign="top">
									<th scope="row" class="settinglabel"><label>Logged out?</label></th>
									<td class="settingfield">
										<pre>if ( !is_user_logged_in() ) {
echo '&lt;a href=&quot;&apos;.wpsap_button_login_url().&apos;&quot;&gt;Login&lt;/a&gt;';
}</pre>
										<p>May use in combination with <code>wpsap_button_login();</code></p>
									</td>
									</tr>

								</table>
							</div>	
						</div>
						
						<div class="postbox">
							<h2 class="hndle"><span>Resources</span> <small>Click to get Image URL</small></h2>
							<div class="inside">
							
								<table class="form-table">

									<tr valign="top">
									<th scope="row" class="settinglabel"><label>Small Button 1</label></th>
									<td class="settingfield">
										<a href="http://cdn.steamcommunity.com/public/images/signinthroughsteam/sits_small.png" target="_blank">
											<img src="http://cdn.steamcommunity.com/public/images/signinthroughsteam/sits_small.png" />
										</a>
									</td>
									</tr>
									
									<tr valign="top">
									<th scope="row" class="settinglabel"><label>Small Button 2</label></th>
									<td class="settingfield">
										<a href="https://steamcommunity-a.akamaihd.net/public/images/signinthroughsteam/sits_01.png" target="_blank">
											<img src="https://steamcommunity-a.akamaihd.net/public/images/signinthroughsteam/sits_01.png" />
										</a>
									</td>
									</tr>
									
									<tr valign="top">
									<th scope="row" class="settinglabel"><label>Large Button 1</label></th>
									<td class="settingfield">
										<a href="http://cdn.steamcommunity.com/public/images/signinthroughsteam/sits_large_border.png" target="_blank">
											<img src="http://cdn.steamcommunity.com/public/images/signinthroughsteam/sits_large_border.png" />
										</a>
									</td>
									</tr>
									
									<tr valign="top">
									<th scope="row" class="settinglabel"><label>Large Button 2</label></th>
									<td class="settingfield">
										<a href="https://steamcommunity-a.akamaihd.net/public/images/signinthroughsteam/sits_02.png" target="_blank">
											<img src="https://steamcommunity-a.akamaihd.net/public/images/signinthroughsteam/sits_02.png" />
										</a>
									</td>
									</tr>
									
								</table>
							</div>	
						</div>
					</div>
				
				</div>
				
				<div class="postbox">
					<div class="inside">
						<?php submit_button(); ?>
					</div>
				</div>
				
			</form>
				
		</div>
		
	</div>
	</div>

</div><!-- /end #wrap -->

<?php } ?>