<?php
include 'includes.php';
$hash = isset($_POST['hash'])?$_POST['hash']:"";
$dialog = new dialog($db,time(),$userid,isset($_REQUEST['hash'])?$_REQUEST['hash']:$hash);
function cleanMe($string) {
   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

   return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}

if(!isset($_GET['action'])){
?>

<script src="wp-content/themes/team_fight/libs/videocall/js/RTCMultiConnection.min.js"></script>
<script src="wp-content/themes/team_fight/libs/videocall/js/socket.io.js"></script>
<script src="wp-content/themes/team_fight/libs/videocall/js/getMediaElement.js"></script>
<link rel="stylesheet" href="wp-content/themes/team_fight/libs/videocall/css/style.css"> 
<div class="chat_inf_box">
	<div id="local-audios-container"></div>
	<div id="remote-audios-container"></div>
	<div class="chat_inf"></div>
	<div class="chat_timer_box">
		<div class="chat_timer">
			<p>
				<span id="playMin">00</span>:<span id="playSec">00</span>
			</p>
		</div>
	</div> 
</div>

<div class="chat_team_box">
	<div class="mates_box">
		<div class="chat_img">
			<div class="mate_img_box">
				<img src="<?=$userAvatar?>" alt="Alt" />
			</div>
			<p class="nickname"><?=$userName?></p>
		</div>
		<?php 
		$mates = $dialog->take_user_img($userid);
		
// 		print_r($mates);

		if ($mates['num'] == 1) {
			$mates_boxes = '
			<div class="chat_img">
				<div class="mate_img_box">
					<img src="'.$db->echoUserData("image_full", "#_user", "id", $mates['mate_1']).'" alt="Alt" />
					<span class="mate_vol">
					
						<i class="fa fa-volume-up remoteUser" aria-hidden="true" id="'.md5(htmlentities($db->echoUserData("name", "#_user", "id", $mates['mate_1']))).'"></i>
					</span>
				</div>
				<a class="nickname" href="http://steamcommunity.com/profiles/'.$db->echoUserData("steamid", "#_user", "id", $mates['mate_1']).'/" target="_blank">'.
				htmlentities($db->echoUserData("name", "#_user", "id", $mates['mate_1'])).
				'</a>
			</div>';
			echo $mates_boxes;
		} elseif ($mates['num'] == 4) {
			for ($i=1; $i <5; $i++) { 
				$mate = "mate_".$i;
				$mates_boxes = '
				<div class="chat_img">
					<div class="mate_img_box">
						<img src="'.$db->echoUserData("image_full", "#_user", "id", $mates['$mate']).'" alt="Alt" />
						<span class="mate_vol" onclick="changeVol(this);">
							<i class="fa fa-volume-up" aria-hidden="true"></i>
						</span>
					</div>
					<a class="nickname" href="http://steamcommunity.com/profiles/'.$db->echoUserData("steamid", "#_user", "id", $mates['$mate']).'/" target="_blank">'.$db->echoUserData("name", "#_user", "id", $mates['$mate']).'</a>
				</div>';
				echo $mates_boxes;
			}
		} else {
			$mates_boxes = '
			<div class="chat_img">
				'.$mates['mate_1'].'
			</div>';
			echo $mates_boxes;
		}
		?>
		
		<div class="voice_chat_act box_elem_midd">
			<!--<div class="tools_box" id="avc">-->
			<!--	<i class="fa fa-video-camera" aria-hidden="true"></i>-->
			<!--</div>			-->

			<div class="tools_box">
				<i id="lMirco" class="fa fa-microphone" aria-hidden="true"></i>
			</div>
			<div class="tools_box">
				<i id="lVolume" class="fa fa-volume-up" aria-hidden="true"></i>
			</div>
			
		</div> 
	</div>
	<div class="chat_box">
		<div id="message_box" class="message_scroll">
			
		</div>
		<div id="message_form">
			<div class="alert" style="display:none;" id="alert_box">
			  <strong>Error!</strong><span class="error_message"></span>
			</div>
			<div class="float_left box_elem_midd">
				<div class="massage_area">
					<textarea rows="3" id="message" class="message_scroll" placeholder="Type your message..." name="message"></textarea>
					<input type="hidden" id="dialog_hash" value="<?php echo $hash; ?>"/>
				</div>
				<input onclick="fastChat();" class="btn" type="button" value="SEND"/>
			</div>
			<div class="clearex"></div>
		</div>
	</div>
</div>

<?php
	$cs_go_st = $db->getRowById('user', $steamid, 'steamid', 'cs_go_st');
	$dota_st = $db->getRowById('user', $steamid, 'steamid', 'dota_st');

	if ($cs_go_st == 'in_chat') {
	    if(!file_exists("csgo_caller.txt")){
            $file = fopen("csgo_caller.txt","w");
            fwrite($file,md5($userName));
            fclose($file);
	    }
		include '../site_elements/cs_go_mate_left.php';
	    $caller = file_get_contents("csgo_caller.txt");
	    
	} elseif ($dota_st == 'in_chat') {
        if(!file_exists("dota_caller.txt")){	    
            $file = fopen("dota_caller.txt","w");
            fwrite($file,md5($userName));
            fclose($file);
        }
		include '../site_elements/dota_2_mate_left.php';
		$caller = file_get_contents("dota_caller.txt");
	}
	
	if($caller == ''){
	    $caller = md5($userName);
	}
	
?>


<input id="listencall" type="hidden">
<script src="wp-content/themes/team_fight/libs/videocall/js/custom.js"></script>
<script type="text/javascript">	
    $(document).ready(function(){
    	PlayTime();
    	enterSend();
     	<?php if($caller == ''): ?>
    	    videoCallMessage();
    	<?php endif; ?>
        $.videoCall('<?=md5($userName)?>', '<?=$caller?>');
    });
</script>

<script src="wp-content/themes/team_fight/libs/magnific-popup/jquery.magnific-popup.min.js"></script>
<?php
}else{
	switch($_GET['action']){
		case 'send':
			$dialog->send($_POST['message']);
		break;
	}
	echo json_encode(get_messages(true));
} ?>