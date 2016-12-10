<?php
	$dsn = 'mysql:dbname=Twitter;host=localhost';
	$user = "develop";
	$password = "welcomeMySQL";
try{
	$pdo = new PDO($dsn, $user, $password);
	$pdo->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
	$pdo->query('SET NAMES utf8');
}
catch(PDOException $e){
	error_log("cant connect db",0);
	die();
}
 ?>
