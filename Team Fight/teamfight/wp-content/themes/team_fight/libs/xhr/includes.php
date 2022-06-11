<?php
// includes


require_once ('../../../../../wp-load.php');

// require ('../steamauth/steamauth.php');  
require ('../steamauth/userInfo.php');  
// include '../chat/class.db.php';
// include '../chat/dialog.php';
// $db = new db('localhost','teamfight','teamfight','teamfight');
$db = new db('localhost','demopane_teamfig','v?%CT10e7F?X','demopane_teamfight');



$currentUserId = get_current_user_id();
$userAvatar = get_avatar_url($currentUserId);
$userName = get_user_meta($currentUserId, 'steam_personaname', true);
$state = get_user_meta($currentUserId, 'steam_personastate', true);
$steamId = get_user_meta($currentUserId, 'steam_steamid', true);
				    


				    

$steamid = get_user_meta($currentUserId, 'steam_steamid', true);
$userid = $db->getRowById('user', $steamid, 'steamid', 'id');