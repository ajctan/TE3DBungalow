<?php
	include '../php/dbh.php';
	$pid = $_POST['delete'];

	$sql = 'DELETE FROM files WHERE tpID = '.$pid;
  $result = mysqli_query($conn,$sql);
	$sql = 'DELETE FROM tpTable WHERE tpID = '.$pid;
  $result = mysqli_query($conn,$sql);
	$sql = 'DELETE FROM members WHERE tpID = '.$pid;
  $result = mysqli_query($conn,$sql);
  unset($_COOKIE['PID']);
  header('Location: ../html/index.php');
?>
