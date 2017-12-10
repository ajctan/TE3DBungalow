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
		$members= implode(",",$_POST['nprojectMembers']);
		$start = date("Y-m-d");	
		$access = 1;
		$head = $_POST['nprojectHead'];		 
		
		$createProject = 'INSERT INTO `tptable` (`tpID`, `tpTitle`, `tpDesc`, `tpMemberName`, `tpSDate`, `tpAccessLVL`, `pHead`) VALUES('.$id.',"'.$title.'","'.$abstract.'","'.$members.'","'.$start.'",'.$access.',"'.$head.'")';
		
		if (mysqli_query($conn, $createProject)) {
			echo "<script type='text/javascript'>alert('New project created');</script>";
			 header('Location: ../html/index.php');
		} else {
			echo "<script type='text/javascript'>alert('Error: ". $createProject."<br>". mysqli_error($conn)."');</script>";
			header('Location: ../html/index.php');
		}
	?>
</body>
</html>