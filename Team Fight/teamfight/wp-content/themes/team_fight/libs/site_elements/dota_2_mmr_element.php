<div class="status_print_sec">
	<div class="status_print_box">
		<input type="number" class="status_print" name="dota" oninput="maxLengthCheck(this)" onkeypress="return isNumeric(event)"
		value="<?php $db->echoUserInfo($steamId, "dota") ?>"
		placeholder="<?php $db->echoUserInfo($steamId, "dota") ?>" min="1" max="20000">
		<span class="save_stats_btn"></span>
	</div>	
</div>