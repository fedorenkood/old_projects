<div class="hidden">
	<div class="modal_team_find box_elem_midd">
		<div class="modal_content">
			<button class="mfp-close" id="button-close" type="button" title="Закрыть (Esc)">×</button>
			<?php 
			if ( is_user_logged_in() ) { 
			?>
			<div class="col-md-12 left">
				<div>
					<img class="prof_pic" src="<?=$userAvatar?>" alt="Alt" />
					<p class="nickname"><?=$userName?></p>
				</div>
				<div class="box_elem_midd">
					<?php
						include "cs_go_ranks_element.php"
					 ?>
				</div>
				
			</div>
			
			<div class="col-md-12 right">
				<div class="massage">
					<p id="error"></p>
					<p id="complete"></p>
				</div>
				
				<div class="num_box_new">
					<p>Team of:</p>
					<input onclick="selectTeamNum(this)" type="button" value="2" class="num_new btn <?php $db->echoUserInfo($steamId, "team_num", false, 2) ?>">
					<input onclick="selectTeamNum(this)" type="button" value="5" class="num_new btn <?php $db->echoUserInfo($steamId, "team_num", false, 5) ?>">
				</div>

				<div class="find_box" id="cs_go">
					<div class="search_sel">
						<p class="stopwatch btn"><span id="minutes">00</span>:<span id="seconds">00</span></p>
						<button href="" class="cancel_btn btn" id="button-reset">Cancel</button>
					</div>
					<button class="find_btn btn" onclick="StopWatch('start');" id="button-start">Find</button>
				</div>
			</div>
			<?php
				} else{
					echo '
					<div class="col-md-12 right">
						<div class="massage">
							<p id="error" style="display: block;">Error! Mate has left chat. You may start new search now.</p>
						</div>
					</div>';
				}
			?>
		</div>
	</div>
</div>