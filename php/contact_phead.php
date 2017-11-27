<?php
	$mailTo = $_POST('guest_mail');
	$mailMsg = $_POST('guest_msg');

	require 'PHPMailer/PHPMailerAutoload.php';

	$mail = new PHPMailer();
	$mail -> IsSmtp();
	$mail -> SMTPDebug = 1;
	$mail -> SMTPAuth = true;
	$mail -> SMTPSecure = 'ssl';
	$mail -> Host = "smtp.gmail.com";
	$mail -> Port = 465;
	$mail -> IsHTML(true);
	$mail -> Username = "aron_tan@dlsu.edu.ph";
	$mail -> Password = "Pandas1*";
	$mail -> SentFrom("TE3DBungalow");
	$mail -> Subject = "[TE3DBungalow] ".$mailTo." has requested contact with you";
	$mail -> Body = $mailMsg;
	$mail -> AddAddress($mailTo);

	$result;
	if(!$mail -> Send()){
		$result = "An error occured, Please contact the admin regarding this notification";
		echo "<script type='text/javascript'>alert(<?php echo $result; ??>);</script>";
	}else{
		$result = "Your request has been sent to the Project Head, you may or may not be contacted via email";
		echo "<script type='text/javascript'>alert(<?php echo $result; ??>);</script>";
	}
>