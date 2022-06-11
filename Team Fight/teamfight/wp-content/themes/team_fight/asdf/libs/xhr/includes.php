<?php
// includes
require ('../steamauth/steamauth.php');  
require ('../steamauth/userInfo.php');  
include '../chat/class.db.php';
include '../chat/dialog.php';
// $db = new db('localhost','teamfight','teamfight','teamfight');
$db = new db('localhost','demopane_teamfig','v?%CT10e7F?X','demopane_teamfight');


$steamid = $steamprofile['steamid'];  // 76561198105737570
$userid = $db->getRowById('user', $steamid, 'steamid', 'id');
