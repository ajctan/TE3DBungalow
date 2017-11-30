<?php
	$email = $_POST['email'];
	$msg = $_POST['message'];
	$result = mail("projectHead@te3dhouse.com", "[TE3DBungalow] Notification", "[".$email." on /*Project Title*/]: ".$msg, "From: te3dAdmin@gmail.com");
?>