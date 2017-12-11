<?php

include '../php/dbh.php';

function findContentType($ext){
	switch($ext){
		case 'docx': return 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'; break;
		case 'xlsx':  return 'application/vnd.ms-excel'; break;
		case 'ppt':  return 'application/vnd.ms-powerpoint'; break;
		case 'pdf':  return 'application/pdf'; break;
		case 'html': return 'text/html'; break;
		case 'jpeg': return 'image/jpeg'; break;
		case 'png':  return 'image/png'; break;
		case 'css':  return 'text/css'; break;
		case 'zip':  return 'application/zip'; break;
		case 'rar': return 'application/x-rar-compressed'; break;
		default: return 'application/octet-stream';
	}
}

	$file = $_POST['file_name'];
	$download_file =  "SELECT * , OCTET_LENGTH(tpFile) as file_size FROM files f WHERE f.tpFileName ='".$file."'";
	$found_file = mysqli_query($conn, $download_file);
	$row = mysqli_fetch_assoc($found_file);
	$file_size= $row['file_size'];
	$file_extension = explode(".", $file);
	
	echo $download_file;

    $file_exist = mysqli_num_rows($found_file);

	if ($file_exist > 0){

			header('Content-type: '. findContentType($file_extension[sizeof($file_extension)-1]));
			header('Content-Length:'. $file_size);
			header('Content-Disposition: attachment; filename="'.$file.'"');
			echo $row['tpFile'];
			mysqli_free_result($found_file);

	}

	
	//header('Location: ../html/index.php');
?>