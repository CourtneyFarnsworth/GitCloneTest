<?php 

/* This won't actually work because of spoofing: setting the from fields */

function sendEmail($to, $message, $from){
	$to      = "kortknee04@gmail.com";
	$subject = "Paws Adoption";
	$message = "hello";
	$headers = "From: ". $from . "\r\n" . "Reply-To: ". $from . "\r\n" . "X-Mailer: PHP/" .  phpversion();

	mail($to, $subject, $message, $headers);
}

?> 

