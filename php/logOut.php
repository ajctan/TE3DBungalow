<?php
	setcookie("uFName", NULL, -1, "/");
	setcookie("uLName", NULL, -1, "/");
	setcookie("accType", NULL, -1, "/");
	setcookie("eMail", NULL, -1, "/");
	setcookie("loggedIn", NULL, -1, "/");
	setcookie("gender", NULL, -1, "/");
	setcookie("occupation", NULL, -1, "/");
	setcookie("affiliation", NULL, -1, "/");
	setcookie("uID", NULL, -1, "/");
	header("Location: ../html/index.php");
    exit;
?>