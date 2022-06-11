<div class="hidden">
	<div class="modal_team_find box_elem_midd" id="profile">
		<div class="modal_content">
			<button class="mfp-close" id="button-close" type="button" title="Закрыть (Esc)">×</button>
			<?php 
			if(isset($_SESSION['steamid'])) {
			?>
			<div class="col-md-12 left">
				<div>
					<img class="prof_pic" src="<?=$steamprofile['avatarfull']?>" alt="Alt" />
					<p class="nickname"><?=$steamprofile['personaname']?></p>
				</div>
			</div>
			
			<div class="col-md-12 right">
				<div class="massage">
					<p id="error"></p>
					<p id="complete"></p>
				</div>
				<div class="prof_stats">
					<div>
						<div class="prof_game_stats_box">
							<p class="game_name">CS:GO</p>
							<?php 
								include 'cs_go_ranks_element.php';
							?>
						</div>
						<div class="prof_game_stats_box">
							<p class="game_name">Dota 2</p>
							<?php
								include 'dota_2_mmr_element.php';
							?>
						</div>
						
			
					</div>
					<table class="user_stats_table">
						<tbody>
							<tr>
							    <td class="user_st_name">Age</td>
							    <td class="user_stats">
									<input type="number" name="age" oninput="maxLengthCheck(this)" onkeypress="return isNumeric(event)" placeholder="<?php $db->echoUserInfo($steamprofile['steamid'], "age") ?>" min="10" max="99">
							    </td>
							</tr>
							<tr>
							    <td class="user_st_name">Language</td>
							    <td class="user_stats prof_dropdown">
									<select id="language">
										<option value="English" <?php $db->echoUserInfo($steamprofile['steamid'], "lang", "English") ?>>English</option>
										<option value="Russian" <?php $db->echoUserInfo($steamprofile['steamid'], "lang", "Russian") ?>>Russian</option>
										<option value="Ukrainian" <?php $db->echoUserInfo($steamprofile['steamid'], "lang", "Ukrainian") ?>>Ukrainian</option>
									</select>
							    </td>
							</tr>
							<tr>
							    <td class="user_st_name">Account status</td>
							    <td class="user_stats">
							    	<a href="#premium" class="popup_content"><input type="button" value="Premium" class="premium" name="premium"></a>
							    </td>
							</tr>
						</tbody>
					</table>
					<button type="button" onclick="saveData()" name="seve_btn" class="save_btn">Save</button>
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