<?php
include 'includes.php';
// print_r($_POST);
// print_r($_FILES);
// exit;
    global $current_user;
    get_currentuserinfo();
    $user_id = $current_user->ID;
if (isset($_POST['cs_go'], $_POST['age'], $_POST['dota'], $_POST['lang'])) {
	$name = $userName;
	$dota = $_POST['dota'];
	$age = $_POST['age'];
	$cs_go = $_POST['cs_go'];
	$lang = $_POST['lang'];
	$db->saveUserInfo($steamid, $name, $dota, $cs_go, $age, $lang, $userAvatar);
	if(isset($_FILES['tm_background']))
	    tm_background_image();
    if(isset($_POST['tm_header_color']))
	    update_user_meta( $user_id, 'tm_header_color', $_POST['tm_header_color'] );
	if(isset($_POST['tm_footer_color']))
	    update_user_meta( $user_id, 'tm_footer_color', $_POST['tm_footer_color'] );
	if(isset($_POST['tm_button_color']))
	    update_user_meta( $user_id, 'tm_button_color', $_POST['tm_button_color'] );	    
	if(isset($_POST['tm_background_default']) && $_POST['tm_background_default'] != 'undefined')
	    update_user_meta( $user_id, 'bck_picture', $_POST['tm_background_default'] );	    
	if(isset($_POST['tm_reset'])){
        update_user_meta( $user_id, 'tm_reset', $_POST['tm_reset'] );
	} else {
        delete_user_meta( $user_id, 'tm_reset');
	}
        
} elseif (isset($_POST['search_st'])) {
	$st = $_POST['search_st'];
	$column_d = "dota_st";
	$column_cs = "cs_go_st";
	$db->saveUserData($steamid, $column_d, $st);
	$db->saveUserData($steamid, $column_cs, $st);
} elseif (isset($_POST['st_off'])) {
	$st = $_POST['st_off'];
	$column_d = "dota_st";
	$column_cs = "cs_go_st";
	$db->saveUserData($steamid, $column_d, $st);
	$db->saveUserData($steamid, $column_cs, $st);
	if ($st == 'no') {
		$userid = $db->getRowById('user', $steamid, 'steamid', 'id');
		$db->clearAfterChat($userid);
	}
} elseif (isset($_POST['cs_go'])) {
	$cs_go = $_POST['cs_go'];
	$game = "cs_go";
	$db->saveUserData($steamid, $game, $cs_go);
} elseif (isset($_POST['dota'])) {
	$dota = $_POST['dota'];
	$game = "dota";
	$db->saveUserData($steamid, $game, $dota);
} elseif (isset($_POST['team_num'])) {
	$team_num = $_POST['team_num'];
	$game = "team_num";
	$db->saveUserData($steamid, $game, $team_num);
} elseif (isset($_POST['active'])) {
	if ($_POST['active'] == 'yes') {
		$db->updateLastVisit($steamid);
	}
} else {
	echo "wtf";
}
/*$result = $db->query('SELECT steamid FROM #_user');
while( $row = mysqli_fetch_assoc( $result ) ){
      echo "<tr><td>{$row['steamid']}</td></tr>\n";
    }
 */

// header("Location: profile.php");