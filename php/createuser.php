<html>
<head></head>
<body>
	<?php
		include '../php/dbh.php';

		$sqlLastID ='SELECT uID FROM users ORDER BY uID DESC LIMIT 1';
		$result = mysqli_query($conn,$sqlLastID);
		$row = mysqli_fetch_assoc($result);
		$id = $row['uID'] + 1;

		$info = pathinfo($_FILES['pic']['name']);
		$size = $_FIES['pic']['size'];
		$newname = $id;
		$target = '../images/userImages/'.$newname;

		if($size > 0){
			move_uploaded_file( $_FILES['pic']['tmp_name'], $target);
		} else {
			$defaultUserImage = '../images/loginavatar.png';
			copy($defaultUserImage, $target);
		}

		$uName = $_POST['email'];
		$uPass = $_POST['pwd'];
		$uType = 1;
		$uFName = $_POST['fname'];
		$uLName = $_POST['lname'];
		$uGender = $_POST['gender'];
		$uOccupation = $_POST['occupation'];
		$uAffiliation = $_POST['affiliation'];

		$addMember = "INSERT INTO `users` (`uName`, `uPass`, `uID`, `uType`, `uFName`, `uLName`, `uGender`, `uOccupation`, `uAffiliation`) VALUES ('".$uName."', '".$uPass."', ".$id.", ".$uType.", '".$uFName."', '".$uLName."', '".$uGender."', '".$uOccupation."', '".$uAffiliation."');";

		print_r($addMember);
		if (mysqli_query($conn, $addMember)){
				echo "<script type='text/javascript'>alert('New user created');</script>";
				//header('Location: ../html/index.php');
			} else {
				echo "<script type='text/javascript'>alert('Error: ". $addMember."<br>". mysqli_error($conn)."');</script>";
				//header('Location: ../html/index.php');
			}
			header("Location: ../html/index.php");
	?>
</body>
</html>
