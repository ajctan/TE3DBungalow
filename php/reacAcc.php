<?php
	include '../php/dbh.php';

	$id = $_POST['accID'];
	$sql = "UPDATE users SET uActive=1 WHERE uID=".$id;
	mysqli_query($conn, $sql);
	header("Location: ../html/profile.php?mID=".$id);
?>
