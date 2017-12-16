<?php
	include 'dbh.php';

	$uName = $_POST['uname'];
	$pWord = $_POST['pword'];
	session_start();
	$_SESSION['error'] = 1;

	$sql = "SELECT * FROM users WHERE uName = '".$uName."' AND uPass = '".$pWord."' AND uActive = 1";
	$result = mysqli_query($conn,$sql);
	$queryResults = mysqli_num_rows($result);
	if($queryResults > 0){
		$user = mysqli_fetch_assoc($result);

		$_SESSION['error'] = 0;
		$_SESSION['uID'] = $user['uID'];
		$_SESSION['uType'] = $user['uType'];
		$_SESSION['uFName'] = $user['uFName'];
		$_SESSION['uLName'] = $user['uLName'];
	}

	header("Location: ../html/index.php");
    exit;
?>
