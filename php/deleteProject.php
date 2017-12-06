<?php
	include '../php/dbh.php';
	$pid = $_POST['dlete'];

	$sql = "DELETE FROM files WHERE tpID LIKE ".$pid;
    $result = mysqli_query($conn,$sql);
    $sql = "DELETE FROM tpTable WHERE tpID LIKE ".$pid;
    $result = mysqli_query($conn,$sql);
    unset($_COOKIE['PID']);
    header('Location: ../html/index.php');
?>