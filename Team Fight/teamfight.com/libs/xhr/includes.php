<?php
// includes
require ('../steamauth/steamauth.php');  
require ('../steamauth/userInfo.php');  
include '../chat/class.db.php';
include '../chat/dialog.php';
$db = new db('localhost','teamfight','teamfight','teamfight');


$steamid = $steamprofile['steamid'];  // 76561198105737570
$userid = $db->getRowById('user', $steamid, 'steamid', 'id');
