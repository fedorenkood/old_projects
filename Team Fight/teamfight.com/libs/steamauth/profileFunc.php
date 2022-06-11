<?php 
	
function OnOffLine($state)
{
	if ($state==1 or $state==5 or $state==6) {
		echo '<i class="fa fa-circle on" aria-hidden="true"></i>';
	} else {
		echo '<i class="fa fa-circle off" aria-hidden="true"></i>';
	}
}

?>