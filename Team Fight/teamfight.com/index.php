	<?php
		include 'header.php';
	?>

	<section>
		<div class="container">
			<div class="row game_box box_elem_midd">
				<div class="game_card">
					<a href="#" class="popup_content">
						<p class="game_name">Counter strike: Global offensive</p>
						<img src="img/game_card/cs_go.png" alt="">
						<p class="status"><i class="fa fa-circle on" aria-hidden="true"></i>online</p>
					</a>
					<?php
						include 'libs/site_elements/cs_go_search_pop_up.php';
					?>
				</div>

				<div class="game_card">
					<a href="#"  class="popup_content">
						<p class="game_name">Dota 2</p>
						<img src="img/game_card/dota_2.png" alt="">
						<p class="status"><i class="fa fa-circle on" aria-hidden="true"></i>online</p>
					</a>
					<?php
						include "libs/site_elements/dota_2_search_pop_up.php";
					?>
				</div>
			</div>
		</div>
	</section>


	<?php 
		include 'footer.php';
	?>

</html>