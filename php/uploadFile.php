<html>
<head>
</head>
<body>
	<?php
		include '../php/dbh.php';

		$pID = $_POST['projToUpload'];
		$target_dir = "../projectFiles/";
		$fileName = basename($_FILES["fileToUpload"]["name"]);
		$target_file = $target_dir . $fileName;
		$size = $_FILES["fileToUpload"]["size"];
		$modified = date("Y-m-d");

		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }

		$uploadFile = "INSERT INTO `files` (`fileID`, `tpID`, `tpFileName`, `tpSize`, `tpModified`) VALUES (NULL, $pID, '$fileName', $size, '$modified');";

		print_r($uploadFile);
		if (mysqli_query($conn, $uploadFile)) {
			echo "<script type='text/javascript'>alert('File uploaded.');</script>";
		} else {
			echo "<script type='text/javascript'>alert('Error: ". $uploadFile."<br>". mysqli_error($conn)."');</script>";
		}

		header('Location: ../html/project.php?pid='.$pID);

	?>
</body>
</html>
