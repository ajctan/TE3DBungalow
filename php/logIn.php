<?php
	include 'dbh.php';

	$uName = $_POST['uname'];
	$pWord = $_POST['pword'];

	$sql = "SELECT * FROM users WHERE uName = '".$uName."' AND uPass = '".$pWord."' AND uActive = 1";
	$result = mysqli_query($conn,$sql);
	$queryResults = mysqli_num_rows($result);
	if($queryResults > 0){
		while ($row = mysqli_fetch_assoc($result)){
			setcookie("uFName", $row['uFName'], 0, "/");
			setcookie("uLName", $row['uLName'], 0, "/");
			if(isset($_COOKIE['accType'])){
				unset($_COOKIE['accType']);
				setcookie("accType", $row['uType'], 0, "/");
			}else{
				setcookie("accType", $row['uType'], 0, "/");
			}
			setcookie("eMail", $row['uName'], 0, "/");
			setcookie("loggedIn", "1", 0, "/");
			setcookie("gender", $row['uGender'], 0, "/");
			setcookie("occupation", $row['uOccupation'], 0, "/");
			setcookie("affiliation", $row['uAffiliation'], 0, "/");
			setcookie("uID", $row['uID'], 0, "/");
		}
	}else{
		setcookie("loggedIn", "0", 0, "/");
	}
	//header("Location: {$_SERVER['HTTP_REFERER']}");
	header("Location: ../html/index.php");
    exit;
?>