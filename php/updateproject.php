<?php
		include '../php/dbh.php';

		$id = $_POST['nprojectID'];
		$title = $_POST['nprojectTitle'];
		$abstract = $_POST['nprojectAbstract'];
		$head = $_POST['selectedprojectHead'];
		$pVenture = $_POST['nprojectcapital'];
		$members = $_POST['nprojectMembers'];

		print_r($members);

		$removeMembers = "DELETE FROM members WHERE projectID = " .$id;
		mysqli_query($conn, $removeMembers);

		$lastAdded ='SELECT memberID FROM members ORDER BY memberID DESC LIMIT 1';
		$result = mysqli_query($conn,$lastAdded);
		$row = mysqli_fetch_assoc($result);
		$lastMemberID = $row['memberID'];

		echo "<script type='text/javascript'>alert('".$id."');</script>";

		$updateProject = "UPDATE tptable SET tpTitle = '".$title."', tpDesc = '".$abstract."', pHead = ".$head.", pVentureC = '".$pVenture."' WHERE tpID = ".$id;
		print_r($updateProject);
		$lastMemberID += 1;
		$addMember = "INSERT INTO `members` (`memberID`, `projectID`, `userID`) VALUES('".$lastMemberID."','".$id."','".$head."');";
		mysqli_query($conn, $addMember);
		foreach($members as $m){
			$lastMemberID += 1;
			$addMember = "INSERT INTO `members` (`memberID`, `projectID`, `userID`) VALUES('".$lastMemberID."','".$id."','".$m."');";
			mysqli_query($conn, $addMember);
		}

		if (mysqli_multi_query($conn, $updateProject))
			echo "<script type='text/javascript'>alert('Project updated');</script>";
		else
			echo "<script type='text/javascript'>alert('Error: ". $updateProject."<br>". mysqli_error($conn)."');</script>";

		header('Location: ../html/project.php?pid='.$id);
	?>
