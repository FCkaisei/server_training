<?php
	$dsn = 'mysql:dbname=UserLoginDB;host=localhost';
	$user = "root";
	$password = "";
try{
	$pdo = new PDO($dsn, $user, $password);
	$pdo->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
	$pdo->query('SET NAMES utf8');
}
catch(PDOException $e){
	die();
}
 ?>
