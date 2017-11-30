<?php
	setcookie($_COOKIE['uFName'], "", -1, '/'); 
	setcookie($_COOKIE['uLName'], "", -1, '/'); 
	setcookie($_COOKIE['accType'], "", -1, '/'); 
	setcookie($_COOKIE['eMail'], "", -1, '/');
	setcookie($_COOKIE['loggedIn'], "", -1, '/');  
	header("Location: {$_SERVER['HTTP_REFERER']}");
    exit;
?>