<html>
<head>
</head>
<body>
	<?php
		include '../php/dbh.php';
		$pID = $_POST['projToUpload'];
		if (!file_exists('../projectFiles/'.$pID)) {
    	mkdir('../projectFiles/'.$pID, 0777, true);
		}
		$target_dir = "../projectFiles/".$pID."/";
		$modified = date("Y-m-d");
		$count = count($_FILES['fileToUpload']['name']);

		for($i = 0; $i < $count; $i++){
			$fileName = basename($_FILES["fileToUpload"]["name"][$i]);
			$target_file = $target_dir . $fileName;
			$size = $_FILES["fileToUpload"]["size"][$i];

			$uploadFile = "INSERT INTO `files` (`fileID`, `tpID`, `tpFileName`, `tpSize`, `tpModified`) VALUES (NULL, $pID, '$fileName', $size, '$modified');";

			if (mysqli_query($conn, $uploadFile) && move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], $target_file)) {
	        	echo "The file ". basename( $_FILES["fileToUpload"]["name"][$i]). " has been uploaded.";
	    	} else {
	        	echo "Sorry, there was an error uploading your file.";
	    }
		}

		header('Location: ../html/project.php?pid='.$pID);

	?>
</body>
</html>
