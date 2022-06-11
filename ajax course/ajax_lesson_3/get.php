<?php
if (isset($_GET['name'], $_GET['sname'])) {
	echo "Hello ".$_GET['name']." ".$_GET['sname']." from GET";
} 