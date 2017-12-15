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
		echo "<script type='text/javascript'>alert('".$target_dir."');</script>";
		for($i = 0; $i < $count; $i++){
			$fileName = basename($_FILES["fileToUpload"]["name"][$i]);
			$target_file = $target_dir . $fileName;
			$size = $_FILES["fileToUpload"]["size"][$i];


			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], $target_file)) {
	        echo "The file ". basename( $_FILES["fileToUpload"]["name"][$i]). " has been uploaded.";
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
		}

		header('Location: ../html/project.php?pid='.$pID);

	?>
</body>
</html>
