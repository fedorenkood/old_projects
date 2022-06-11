<div class="hidden pop_up_box">
	<div id="#pop_up_con"  class="modal_team_find box_elem_midd">
		<div class="modal_content">
			<button class="mfp-close" id="button-close" type="button" title="Закрыть (Esc)">×</button>
			<div class="col-md-12 left">
				<div>
					<img class="prof_pic" src="<?=$steamprofile['avatarfull']?>" alt="Alt" />
					<p class="nickname"><?=$steamprofile['personaname']?></p>
				</div>
			</div>
			
			<div class="col-md-12 right">
				<div class="massage">
					<p id="error" style="display: block;">Error! Mate has left chat. You may start new search now.</p>
					<p id="complete"></p>
				</div>
				
				<div class="num_box_new">
					<p>Team of:</p>
					<input onclick="selectTeamNum(this)" type="button" value="2" class="num_new btn <?php $db->echoUserInfo($steamprofile['steamid'], "team_num", false, 2) ?>">
					<input onclick="selectTeamNum(this)" type="button" value="5" class="num_new btn <?php $db->echoUserInfo($steamprofile['steamid'], "team_num", false, 5) ?>">
				</div>

				<div class="find_box" id="dota">
					<div class="search_sel">
						<p class="stopwatch btn"><span id="minutes">00</span>:<span id="seconds">00</span></p>
						<button href="" class="cancel_btn btn" id="button-reset">Cancel</button>
					</div>
					<button href="#" class="find_btn btn" onclick="StopWatch('start');" id="button-start">Find</button>
				</div>
			</div>
		</div>
	</div>
</div>