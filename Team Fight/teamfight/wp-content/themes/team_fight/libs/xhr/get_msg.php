<?php
include 'includes.php';


$hash = isset($_POST['hash'])?$_POST['hash']:"";


if ($db->sbLeftChat($hash)) {
	$dialog = new dialog($db,time(),$userid,isset($_REQUEST['hash'])?$_REQUEST['hash']:$hash);
	/*if (!isset($_GET['action'])) {
		$msg = $dialog->get_messages();
		echo $msg['html'];
	} else {
		switch($_GET['action']){
			case 'send':
				$dialog->send($_POST['message']);
			break;
		}
		echo json_encode($dialog->get_messages(true));
	}*/
	switch($_GET['action']){
		case 'send':
			$dialog->send($_POST['message']);
		break;
	}
	echo json_encode($dialog->get_messages(true));
} elseif ($hash != '') {
    
    echo json_encode("waiting123");
    
	$cs_go_st = $db->getRowById('user', $steamid, 'steamid', 'cs_go_st');
	$dota_st = $db->getRowById('user', $steamid, 'steamid', 'dota_st');

	if ($cs_go_st == 'in_chat') {
        if(file_exists("csgo_caller.txt"))
            unlink("csgo_caller.txt");
	} elseif ($dota_st == 'in_chat') {
	    if(file_exists("dota_caller.txt"))
	        unlink("dota_caller.txt");

	}
	
// 	echo ($_GET['deleted'])?
// 	     json_encode("deleted"):
	    
} else {
	echo "eror 404";
}
 
