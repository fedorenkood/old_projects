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
	echo json_encode("deleted");
} else {
	echo "eror 404";
}
 
