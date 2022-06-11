<?php
include 'includes.php';


$hash = isset($_POST['hash'])?$_POST['hash']:"";
$dialog = new dialog($db,time(),$userid,isset($_REQUEST['hash'])?$_REQUEST['hash']:$hash);


if(!isset($_GET['action'])){
?>

<div class="chat_inf_box">
	
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
				<img src="<?=$steamprofile['avatarfull']?>" alt="Alt" />
			</div>
			<p class="nickname"><?=$steamprofile['personaname']?></p>
		</div>
		<?php 
		$mates = $dialog->take_user_img($userid);
		if ($mates['num'] == 1) {
			$mates_boxes = '
			<div class="chat_img">
				<div class="mate_img_box">
					<img src="'.$db->echoUserData("image_full", "#_user", "id", $mates['mate_1']).'" alt="Alt" />
					<span class="mate_vol" onclick="changeVol(this);">
						<i class="fa fa-volume-up" aria-hidden="true"></i>
					</span>
				</div>
				<a class="nickname" href="http://steamcommunity.com/profiles/'.$db->echoUserData("steamid", "#_user", "id", $mates['mate_1']).'/" target="_blank">'.$db->echoUserData("name", "#_user", "id", $mates['mate_1']).'</a>
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
			<div class="tools_box" onclick="changeMicr(this);">
				<i class="fa fa-microphone" aria-hidden="true"></i>
			</div>
			<div class="tools_box" onclick="changeVol();">
				<i class="fa fa-volume-up" aria-hidden="true"></i>
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
		include '../site_elements/cs_go_mate_left.php';
	} elseif ($dota_st == 'in_chat') {
		include '../site_elements/dota_2_mate_left.php';
	}
	
?>

<script type="text/javascript">	
$(document).ready(function(){
	PlayTime();
	enterSend();
});
</script>
<script src="libs/magnific-popup/jquery.magnific-popup.min.js"></script>
<?php
}else{
	switch($_GET['action']){
		case 'send':
			$dialog->send($_POST['message']);
		break;
	}
	echo json_encode(get_messages(true));
} ?>
