<?php
    require ('libs/steamauth/steamauth.php');  
    # You would uncomment the line beneath to make it refresh the data every time the page is loaded
	unset($_SESSION['steam_uptodate']);
	include 'libs/chat/class.db.php';
	include 'libs/chat/dialog.php';