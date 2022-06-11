<?php
include 'libs/chat/class.db.php';
require ('libs/steamauth/steamauth.php');
unset($_SESSION['steam_uptodate']);
include 'libs/chat/dialog.php';

add_theme_support( 'title-tag' );
add_filter('pmpro_register_redirect', '__return_false');
function OnOffLine($state)
{
    
	if ($state==1 or $state==5 or $state==6) {
		echo '<i class="fa fa-circle on" aria-hidden="true"></i>';
	} else {
		echo '<i class="fa fa-circle off" aria-hidden="true"></i>';
	}
}

function tm_background_image(){
    global $current_user;
    get_currentuserinfo();
    $user_id = $current_user->ID;
    
    if ( ! function_exists( 'wp_handle_upload' ) ) {
        require_once( ABSPATH . 'wp-admin/includes/file.php' );
    }

    if( $_FILES['tm_background']['error'] === UPLOAD_ERR_OK ) {
        $upload_overrides = array( 'test_form' => false );
        $r = wp_handle_upload( $_FILES['tm_background'], $upload_overrides );
        update_user_meta( $user_id, 'bck_picture', $r );
    }
}

function if_tm_background($userId){
    $havemeta = get_user_meta($userId, 'bck_picture', true);
    $url = !empty($havemeta['url']) ? $havemeta['url'] : 'wp-content/themes/team_fight/img/background_main.png';
    return $url;
}

function tm_header_color($userId){
    $havemeta = get_user_meta($userId, 'tm_header_color', true);
    $url = !empty($havemeta) ? $havemeta : '#F5F9FC';
    return $url;
}

function tm_footer_color($userId){
    $havemeta = get_user_meta($userId, 'tm_footer_color', true);
    $url = !empty($havemeta) ? $havemeta : '#F5F9FC';
    return $url;
}
function tm_button_color($userId){
    $havemeta = get_user_meta($userId, 'tm_button_color', true);
    $url = !empty($havemeta) ? $havemeta : '#f8632b';
    return $url;
}

function tm_is_paid_member(){
    $member   = pms_get_member(get_current_user_id() );
    return ($member->subscriptions[0]['status'] == 'active') ? true : false;
}

function is_reset($userId){
    $havemeta = get_user_meta($userId, 'tm_reset', true);
    $o = !empty($havemeta) ? true : false;
    return $o;
}