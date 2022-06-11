<?php
if (isset($_POST['name'], $_POST['sname'])) {
	echo "Hello ".$_POST['name']." ".$_POST['sname']." from POST";
} 