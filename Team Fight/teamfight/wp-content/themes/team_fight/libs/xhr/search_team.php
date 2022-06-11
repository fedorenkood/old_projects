<?php
include 'includes.php';
include '../chat/teamSearchEng.php';
$teamSearch = new teamSearchEng($db, $steamId);

if (isset($_POST['cs_go_st'])) {
	$cs_go_st = $_POST['cs_go_st'];
	$column = "cs_go_st";
	
	if ($cs_go_st == 'no') {
		$db->clearAfterChat($userid);
	}
	if ($cs_go_st == 'yes') {
		$cs_go_st_in_base = $db->getRowById('user', $steamid, 'steamid', 'cs_go_st');
		$dialog = new dialog($db,time(),$userid,isset($_REQUEST['hash'])?$_REQUEST['hash']:'');
		if ($_POST['search_st'] == 0 and $cs_go_st_in_base != 'in_chat') {
			$db->saveUserData($steamid, $column, $cs_go_st);  // save YES
			$is_found = $teamSearch->searchTeam('cs_go');

// 			var_dump($is_found);

			if (isset($is_found['mate_1'], $is_found['mate_4'])) {
			 	$mate_id_1 = $db->getRowById('user', $is_found['mate_1'], 'steamid', 'id');
			 	$mate_id_2 = $db->getRowById('user', $is_found['mate_2'], 'steamid', 'id');
			 	$mate_id_3 = $db->getRowById('user', $is_found['mate_3'], 'steamid', 'id');
			 	$mate_id_4 = $db->getRowById('user', $is_found['mate_4'], 'steamid', 'id');
				$dialog->find_suit_dialog( array($userid, $mate_id_1, $mate_id_2, $mate_id_3, $mate_id_4));
				$dialog->add_users_to_dialog( array($userid, $mate_id_1, $mate_id_2, $mate_id_3, $mate_id_4));
				// $db->saveUserData($steamid, "cs_go_st", "no");
				echo $dialog->ret_hash();
			} elseif ($is_found > 0) {
				$mate_id = $db->getRowById('user', $is_found, 'steamid', 'id');
				$dialog->find_suit_dialog( array($userid, $mate_id ));
				$dialog->add_users_to_dialog( array($userid, $mate_id ));
				// $db->saveUserData($steamid, "cs_go_st", "no");
				echo $dialog->ret_hash();
			} elseif ($cs_go_st_in_base == 'in_chat') {
				echo "You can not be in two chats simultaneosly";
			} elseif (!$is_found) {
				echo false; 
			}
		} elseif ($_POST['search_st'] > 0) {
			$found = $dialog->user_was_found($userid);
			if ($found) {
				// $db->saveUserData($steamid, "cs_go_st", "no");
				echo $dialog->ret_hash();
			} else {
				echo false;
			}
		} 
	} 
} elseif (isset($_POST['dota_st'])) {
	$dota_st = $_POST['dota_st'];
	$column = "dota_st";

	if ($dota_st == 'no') {
		$db->clearAfterChat($userid);
	}
	if ($dota_st == 'yes') {
		$dota_st_in_base = $db->getRowById('user', $steamid, 'steamid', 'dota_st');
		$dialog = new dialog($db,time(),$userid,isset($_REQUEST['hash'])?$_REQUEST['hash']:'');
		if ($_POST['search_st'] == 0 and $dota_st_in_base != 'in_chat') {
			$db->saveUserData($steamid, $column, $dota_st);
			$is_found = $teamSearch->searchTeam('dota');
			if (isset($is_found['mate_1'], $is_found['mate_4'])) {
			 	$mate_id_1 = $db->getRowById('user', $is_found['mate_1'], 'steamid', 'id');
			 	$mate_id_2 = $db->getRowById('user', $is_found['mate_2'], 'steamid', 'id');
			 	$mate_id_3 = $db->getRowById('user', $is_found['mate_3'], 'steamid', 'id');
			 	$mate_id_4 = $db->getRowById('user', $is_found['mate_4'], 'steamid', 'id');
				$dialog->find_suit_dialog( array($userid, $mate_id_1, $mate_id_2, $mate_id_3, $mate_id_4));
				$dialog->add_users_to_dialog( array($userid, $mate_id_1, $mate_id_2, $mate_id_3, $mate_id_4));
				echo $dialog->ret_hash();
			} elseif ($is_found > 0) {
				$mate_id = $db->getRowById('user', $is_found, 'steamid', 'id');
				$dialog->find_suit_dialog( array($userid, $mate_id ));
				$dialog->add_users_to_dialog( array($userid, $mate_id ));
				echo $dialog->ret_hash();
			} elseif ($dota_st_in_base == 'in_chat') {
				echo "You can not be in two chats simultaneosly";
			} elseif (!$is_found) {
				echo false;
			}
		} elseif ($_POST['search_st'] > 0) {
			$found = $dialog->user_was_found($userid);
			if ($found) {
				echo $dialog->ret_hash();
			} else {
				echo false;
			}
		} 
	} 
} else {
	echo $steamid;
}
 

/*select utd.dialogid,dg.hash 
from tf_dialog as dg left join tf_user_to_dialog as utd on dg.id=utd.dialogid  
where utd.userid in(select userid from tf_user_to_dialog where userid='256');*/