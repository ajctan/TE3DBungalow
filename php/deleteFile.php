<html>
<head>
</head>
<body>
	<?php
		include '../php/dbh.php';
		$pID = $_POST['pID'];
		$fileID = $_POST['fileID'];
		$fileName = $_POST['fileName'];

		if (file_exists('../projectFiles/'.$pID.'/'.$fileName)) {
    	unlink('../projectFiles/'.$pID.'/'.$fileName);
		}

		$deleteFile = "DELETE FROM files WHERE fileID = ".$fileID;

		if (mysqli_query($conn, $deleteFile)) {
        	echo "The file ". $fileName. " has been deleted.";
    	} else {
        	echo "Sorry, there was an error deleting your file.";
    }

		header('Location: ../html/project.php?pid='.$pID);

	?>
</body>
</html>
