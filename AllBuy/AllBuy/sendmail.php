<?php

	$youremail = "fedorenkoalex23@mail.ru";

	$name = Trim(stripslashes($_POST['name']));
	$email = Trim(stripslashes($_POST['email']));
	$reply = Trim(stripslashes($_POST['reply']));
	$message = Trim(stripslashes($_POST['message']));
	
	$subject = "Message From Your Website";
    $header  = "From: $email \r\n"."MIME-Version: 1.0 \r\n"."Content-type: text/html; charset=UTF-8 \r\n";
    $message  = "Name: $name // E-mail: $email // Wants a reply: $reply // Message: $message";
	
	$content = htmlspecialchars($message);
   
    $content = wordwrap($content,70);
    mail($youremail, $subject, $content, $header);
	
?>
	
<meta http-equiv="refresh" content="0;URL=thankyou.html">