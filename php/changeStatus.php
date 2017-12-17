<?php
		include '../php/dbh.php';

		$id = $_POST['pID'];
		$newStatus = $_POST['newStatus'];

		$query = 'SELECT tpSDate FROM tptable WHERE tpID = '.$id;
		$project = mysqli_fetch_assoc(mysqli_query($conn, $query));

		if($newStatus == "2")
			$endDate = date("Y-m-d");
		else if($newStatus == "0")
			$endDate = $project['tpSDate'];
		else
			$endDate = NULL;

			print_r($endDate);
		$updateStatus = 'UPDATE tptable SET tpStatus = '.$newStatus.', tpEDate = "'.$endDate.'" WHERE tpID = '.$id;

		if (mysqli_query($conn, $updateStatus))
			echo "<script type='text/javascript'>alert('Project updated');</script>";
		else
			echo "<script type='text/javascript'>alert('Error: ". $updateStatus."<br>". mysqli_error($conn)."');</script>";

		header('Location: ../html/project.php?pid='.$id);
	?>
