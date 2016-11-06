<?php
	$dsn = 'mysql:dbname=UserLoginDB;host=localhost';
	$user = "root";
	$password = "";
try{
	$pdo = new PDO($dsn, $user, $password);
	print("DB->PDO接続成功");
	$pdo->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
	$pdo->query('SET NAMES utf8');
}
catch(PDOException $e){
	print('ERROR:'.$e->getMessage());
	die();
}

 ?>
