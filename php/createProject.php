<html>
<head></head>
<body>
	<?php
		include '../php/dbh.php';
		
		$sqlLastID ='SELECT tpID FROM tptable ORDER BY tpID DESC LIMIT 1';
		$result = mysqli_query($conn,$sqlLastID);
		$row = mysqli_fetch_assoc($result);
		
		$id = $row['tpID'] + 1;
		$title = $_POST['nprojectTitle'];
		$abstract = $_POST['nprojectAbstract'];
		$start = date("Y-m-d");	
		$access = 1;
		$head = $_POST['selectedprojectHead'];	
		$members = $_POST['nprojectMembers'];
		
		$lastAdded ='SELECT memberID FROM members ORDER BY memberID DESC LIMIT 1';
		$result = mysqli_query($conn,$lastAdded);
		$row = mysqli_fetch_assoc($result);
		
		$lastMemberID = $row['memberID'];
		$createProject = "INSERT INTO `tptable` (`tpID`, `tpTitle`, `tpDesc`, `tpSDate`, `tpAccessLVL`, `pHead`) VALUES(".$id.",'".$title."','".$abstract."','".$start."',".$access.",'".$head."');";
		
		foreach($members as $m){
			$lastMemberID += 1;
			$createProject .= 'INSERT INTO `members` (`memberID`, `projectID`, `userID`) VALUES('.$lastMemberID.','.$id.','.$m.');';
		}

		if (mysqli_multi_query($conn, $createProject)){
				echo "<script type='text/javascript'>alert('New project created');</script>";
				header('Location: ../html/index.php');
			} else {
				echo "<script type='text/javascript'>alert('Error: ". $createProject."<br>". mysqli_error($conn)."');</script>";
				header('Location: ../html/index.php');
			}
		
	?>
</body>
</html>