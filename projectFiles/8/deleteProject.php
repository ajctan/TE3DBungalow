<?php
	include '../php/dbh.php';
	$pid = $_POST['delete'];

	if (file_exists('../projectFiles/'.$pid)) {
		delete_files('../projectFiles/'.$pid);
	}

	function delete_files($target) {
			if(is_dir($target)){
					$files = glob( $target . '*', GLOB_MARK );

					foreach( $files as $file )
					{
							delete_files( $file );
					}

					rmdir( $target );
			} elseif(is_file($target)) {
					unlink( $target );
			}
	}

	$sql = 'DELETE FROM files WHERE tpID = '.$pid;
  $result = mysqli_query($conn,$sql);
	$sql = 'DELETE FROM tpTable WHERE tpID = '.$pid;
  $result = mysqli_query($conn,$sql);
	$sql = 'DELETE FROM members WHERE tpID = '.$pid;
  $result = mysqli_query($conn,$sql);
  unset($_COOKIE['PID']);
  header('Location: ../html/index.php');
?>
