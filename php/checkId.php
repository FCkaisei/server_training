<?php
$user_data = $_POST['user_data'];
$user_id = $user_data;
$user_pass = $user_data;
if(($user_id == "") || ($user_pass == "")){
}
else{
	require_once("../baseDB/connect_db.php");
	$dsn = 'mysql:dbname=UserLoginDB;host=localhost';
	$user = "root";
	$password = "";
	try{
		$pdo = new PDO($dsn, $user, $password);
		$pdo->query('SET NAMES utf8');
	}
	catch(PDOException $e){
		die();
	}
	$sql = "select * from members";
	$sth = $pdo->prepare($sql);
	$sth->execute();
	$sqlResult = $sth->fetchAll();
	foreach($sqlResult as $data){
		if($data['userid'] == $user_id) {
			$dbPassword = $data['password'];
			break;
		}
	}
	if(!isset($dbPassword)){
		error(2);
	}
	else {
		if($dbPassword != $user_pass){
		}
		else {
			session_start();
			$_SESSION['user'] = $user_id;
			header('Location: ../html/tweet_main.html');
			exit();
		}
	}
}
?>
