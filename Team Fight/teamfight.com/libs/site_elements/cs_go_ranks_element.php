
	<dl id="sample" class="dropdown">
		<dt>
			<a>
				<span class="rank_sec"><img class="rank_def" src="img/ranks_cs/<?php $db->echoUserInfo($steamprofile['steamid'], "cs_go") ?>.png" alt=""><span class="hidden">rank_<?php $db->echoUserInfo($steamprofile['steamid'], "cs_go") ?></span></span>
				<div class="arr_down"></div>
			</a>
		</dt>
		<dd>
		    <ul class="rank_box scroll">
		    	<?php
					$html = '<li class="rank_val"><a href="#"><img class="rank" src="" alt="" /><span class="value"></span></a></li>';
					for( $i = 1; $i<19; $i++ ) {
						echo $html;
					}
				?>
		    </ul>
		</dd>
	</dl>



















































