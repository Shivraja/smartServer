<?php
	define('HOST', 'localhost');
	define('USER', 'root');
	define('PASS', 'PradThanga@94');
	define('DB', 'snacs');

	$con = mysqli_connect(HOST,USER,PASS,DB) or die('connection to the DB failed.');

?>