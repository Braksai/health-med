<?php

$host	= 'localhost';
$user	= 'root';
$pass	= '';
$dbname = 'health-med';

$con = mysqli_connect($host, $user, $pass) or die('Could not connect to mysql server.');

mysqli_select_db($con, $dbname) or die('Could not select database.');


session_start();
?>
