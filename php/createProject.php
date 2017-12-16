
	<?php
		include '../php/dbh.php';

		$sqlLastID ='SELECT tpID FROM tptable ORDER BY tpID DESC LIMIT 1';
		$result = mysqli_query($conn,$sqlLastID);
		$row = mysqli_fetch_assoc($result);

		$id = $row['tpID'] + 1;
		$title = $_POST['nprojectTitle'];
		$fund = $_POST['nprojectcapital'];
		$abstract = $_POST['nprojectAbstract'];
		$start = date("Y-m-d");
		$access = 1;
		$head = $_POST['selectedprojectHead'];
		$members = $_POST['nprojectMembers'];

		print_r($members);

		$lastAdded ='SELECT memberID FROM members ORDER BY memberID DESC LIMIT 1';
		$result = mysqli_query($conn,$lastAdded);
		$row = mysqli_fetch_assoc($result);

		$lastMemberID = $row['memberID'];
		$createProject = "INSERT INTO `tptable` (`tpID`, `tpTitle`, `tpDesc`, `tpSDate`, `tpAccessLVL`, `pHead`, `pVentureC`) VALUES(".$id.",'".$title."','".$abstract."','".$start."',".$access.",'".$head."','".$fund."');";

		$lastMemberID += 1;
		$addMember = "INSERT INTO `members` (`memberID`, `projectID`, `userID`) VALUES('".$lastMemberID."','".$id."','".$head."');";
		mysqli_query($conn, $addMember);
		foreach($members as $m){
			$lastMemberID += 1;
			$addMember = "INSERT INTO `members` (`memberID`, `projectID`, `userID`) VALUES('".$lastMemberID."','".$id."','".$m."');";
			mysqli_query($conn, $addMember);
		}

		if (mysqli_multi_query($conn, $createProject))
			echo "<script type='text/javascript'>alert('New project created');</script>";
		else
			echo "<script type='text/javascript'>alert('Error: ". $createProject."<br>". mysqli_error($conn)."');</script>";
		header("Location: ../html/index.php");
	?>
