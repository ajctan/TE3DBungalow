<?php
if(isset($_POST['file_name'])){
    $file = $_POST['file_name'];
	$file_extension = explode(".", $file);

	if($file_extension[1] === 'pdf'){
		header('Content-type: application/pdf');
		header('Content-Disposition: attachment; filename="'.$file.'"');
		readfile('uploads/'.$file);
		exit();
	}else
		if($file_extension[1] === 'docx'){
			header('Content-type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
			header('Content-Disposition: attachment; filename="'.$file.'"');
			readfile('uploads/'.$file);
			exit();
		}

}
?>
<form action="index.php" method="post" name="downloadform">
  <input name="file_name" value="SAMPLE_DOCUMENT.pdf" type="hidden">
  <input type="submit" value="Download the PDF">
</form>

<form action="index.php" method="post" name="downloadform">
  <input name="file_name" value="SAMPLE_DOCUMENT.docx" type="hidden">
  <input type="submit" value="Download the DOCX">
</form>
