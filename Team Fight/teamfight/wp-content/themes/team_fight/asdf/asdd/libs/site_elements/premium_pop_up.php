<div class="hidden">
	<div class="modal_team_find box_elem_midd"  id="premium">
		<div class="modal_content">
			<button class="mfp-close" id="button-close" type="button" title="Закрыть (Esc)">×</button>
			<?php 
			if(isset($_SESSION['steamid'])) {
			?>
			<div class="col-md-12 right">
				<div class="massage">
					<p id="error"></p>
					<p id="complete"></p>
				</div>
				<div class="desc_text">
					<h2>Premium</h2>
					<ul>
						<li>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. </li>
						<li>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. </li>
						<li>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. </li>
					</ul>
				</div>
				<div class="find_box">
					<button class="find_btn btn">Buy Premium</button>
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