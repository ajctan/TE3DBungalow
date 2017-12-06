<?php
	include '../php/dbh.php';
	$email = $_POST['email'];
	$msg = $_POST['message'];

	$sql = "SELECT * FROM tptable WHERE tpID LIKE ".$_POST['projID'];
    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_assoc($result);


    $result = mail("projectHead@te3dhouse.com", "[TE3DBungalow] Notification", "[".$email." on ".$row['tpTitle']."]: ".$msg, "From: te3dAdmin@gmail.com");
	//$result = mail("projectHead@te3dhouse.com", "[TE3DBungalow] Notification", "[".$email." on ".$row['tpTitle']."]: ".$msg, "From: te3dAdmin@gmail.com");
	header('Location: ../html/project.php');
?>