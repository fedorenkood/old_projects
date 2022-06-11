<div class="status_print_sec">
	<div class="status_print_box">
		<input type="number" class="status_print" name="dota" oninput="maxLengthCheck(this)" onkeypress="return isNumeric(event)" placeholder="<?php $db->echoUserInfo($steamprofile['steamid'], "dota") ?>" min="1" max="20000">
		<span class="save_stats_btn"></span>
	</div>	
</div>