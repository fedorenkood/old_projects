<div class="hidden">
	<div class="modal_team_find box_elem_midd" id="profile">
		<div class="modal_content">
			<button class="mfp-close" id="button-close" type="button" title="Закрыть (Esc)">×</button>
			<?php 
			if ( is_user_logged_in() ) { 
            ?>
            
            <form id="chutiyaform">
			<div class="col-md-12 left">
				<div>
					<img class="prof_pic" src="<?=$userAvatar?>" alt="Alt" />
					<p class="nickname"><?=$userName?></p>
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
									<input type="number" name="age" oninput="maxLengthCheck(this)" onkeypress="return isNumeric(event)" value="<?php $db->echoUserInfo($steamId, "age") ?>" placeholder="<?php $db->echoUserInfo($steamId, "age") ?>" min="10" max="99">
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
							<?php
                                $userID = get_current_user_id();
                                ?>
							<tr>
							    <td>Skin Color</td>
							    <td>
					    <?php if(tm_is_paid_member()){ ?>
                            <input type="color" id="tm_header_color" name="tm_header_color" value="<?=tm_header_color($userID);?>">					    
					    <?php } else { ?>
					            <a href="#premium" class="popup_content"><input type="button" value="Premium" class="premium" name="premium"></a>
					    <?php } ?>
							    </td>
							 </tr>
							 <tr>
							    <td>Font Color</td>
							    <td>
					    <?php if(tm_is_paid_member()){ ?>
                            <input type="color" id="tm_footer_color" name="tm_footer_color" value="<?=tm_footer_color($userID);?>">
					    <?php } else { ?>							        
					            <a href="#premium" class="popup_content"><input type="button" value="Premium" class="premium" name="premium"></a>
					    <?php } ?>							        
							    </td>
							</tr>

							 <tr>
							    <td>Buttons Color</td>
							    <td>
					    <?php if(tm_is_paid_member()){ ?>
                            <input type="color" id="tm_button_color" name="tm_button_color" value="<?=tm_button_color($userID);?>">
					    <?php } else { ?>							        
					            <a href="#premium" class="popup_content"><input type="button" value="Premium" class="premium" name="premium"></a>
					    <?php } ?>							        
							    </td>
							</tr>							
							<tr>
							    <td>Background</td>
							    <td>
                        <?php if(tm_is_paid_member()){ ?>
                        
							       <img id="tm_preview" src="<?=if_tm_background($userID);?>" width="100px">
							       
							       <input type="file" id="tm_upload" style="display:none" accept=".jpg, .jpeg, .png"/>
							       </td>
					    <?php } else { ?>							        
					            <a href="#premium" class="popup_content"><input type="button" value="Premium" class="premium" name="premium"></a>
					    <?php } ?>		       
							</tr>
						</tbody>
					</table>
					<button type="button" onclick="saveData()" name="seve_btn" class="save_btn">Save</button>
					<?php if(tm_is_paid_member()){ ?>
					<button type="button" onclick="resetData()" class="save_btn">Reset Theme</button>
					<?php } ?>
		        </form>			
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