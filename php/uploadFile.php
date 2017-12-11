<html>
<head>
</head>
<body>
	<?php
		include '../php/dbh.php';
		
		
		$pID = $_POST['projToUpload'];
		$fName = $_FILES['fileToUpload']['name'];
		$fData = mysqli_real_escape_string($conn, file_get_contents($_FILES['fileToUpload']['tmp_name']));
		$dateUploaded = date("Y-m-d");
		
		$uploadFile = "INSERT INTO `files` (`tpID`, `tpFile`, `tpFileName`, `tpModified`) VALUES(".$pID.",'".$fData."','".$fName."','".$dateUploaded."')";
		
		//echo $pID.'<br>';
		//echo $fName.'<br>';
		//echo $_FILES['fileToUpload']['size'];
		//echo $fData.'<br>';
		//echo $dateUploaded;
		
		
		if (mysqli_query($conn, $uploadFile)) {
			echo "<script type='text/javascript'>alert('File uploaded.');</script>";
			header('Location: ../html/project.php?pid='.$pID);
		} else {
			echo "<script type='text/javascript'>alert('Error: ". $uploadFile."<br>". mysqli_error($conn)."');</script>";
			//header('Location: ../html/project.php?pid='.$pID);
		}
		//INSERT INTO `files` (`tpID`, `tpFile`, `tpFileName`, `tpModified`)
	?>
</body>
</html>
