<?php
	include 'dbh.php';

	$uName = $_POST['uname'];
	$pWord = $_POST['pword'];

	$sql = "SELECT * FROM users WHERE uName LIKE '".$uName."' AND uPass LIKE '".$pWord."'";
	$result = mysqli_query($conn,$sql);
	$queryResults = mysqli_num_rows($result);
	if($queryResults > 0){
		while ($row = mysqli_fetch_assoc($result)){
			setcookie("uFName", row['uFName'], 0, "/");
			setcookie("uLName", row['uLName'], 0, "/");
			if(isset($_COOKIE['accType'])){
				setcookie("accType", row['uType'], "/");
			}else{
				setcookie("accType", row['uType'], 0, "/");
			}
			setcookie("eMail", row['uName'], 0, "/");
			setcookie("loggedIn", "1", 0, "/");
		}
	}else{
		setcookie("loggedIn", "0", 0, "/");
	}
	header("Location: {$_SERVER['HTTP_REFERER']}");
    exit;
?>