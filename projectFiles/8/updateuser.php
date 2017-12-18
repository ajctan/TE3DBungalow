<?php
		include '../php/dbh.php';

		$id = $_POST['nuserID'];
		$pass = $_POST['pwd'];
		$fname = $_POST['fname'];
		$lname = $_POST['lname'];
		$gender = $_POST['gender'];
		$occupation = $_POST['occupation'];
		$affiliation = $_POST['affiliation'];

		$size = pathinfo($_FILES['pic']['size']);
		if($size != 0){
			$info = pathinfo($_FILES['pic']['name']);

			$newname = $id;

			$target = '../images/userImages/'.$newname;
			move_uploaded_file( $_FILES['pic']['tmp_name'], $target);
		}

		$updateMember = "UPDATE users SET uPass = '".$pass."', uFName = '".$fname."', uLName = '".$lname."', uGender = '".$gender."', uOccupation = '".$occupation."', uAffiliation = '".$affiliation."' WHERE uID = ".$id;

		print_r($updateMember);
		if (mysqli_query($conn, $updateMember)){
				echo "<script type='text/javascript'>alert('User updated');</script>";
				//header('Location: ../html/index.php');
			} else {
				echo "<script type='text/javascript'>alert('Error: ". $updateMember."<br>". mysqli_error($conn)."');</script>";
				//header('Location: ../html/index.php');
			}
			header("Location: ../html/profile.php?mID=".$id);
	?>
