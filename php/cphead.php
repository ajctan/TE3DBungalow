<?php
	$email = $_POST['email'];
	$msg = $_POST['message'];
	$result = mail("projectHead@te3dhouse.com", "[TE3DBungalow] Notification", "[".$email." on /*Project Title*/]: ".$msg, "From: te3dAdmin@gmail.com");
	if(!$result){
		echo "<script type='text/javascript'>alert(\"There was an error while sending your request\");</script>";
	}else{
		echo "<script type='text/javascript'>alert(\"Your request was successfully sent\");</script>";
	}
?>