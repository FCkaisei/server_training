<?php
error_log("エラーログを表示テスト", 0);
$user_id = $_POST['formUserid'];
$user_pass = $_POST['formPassword'];
if(($user_id == "") || ($user_pass == "")){
	header('Location: ../html/login.html');
	exit;
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
		header('Location: ../html/login.html');
		exit;
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
		header('Location: ../html/login.html');
		exit;
		error(2);
	}
	else {
		if($dbPassword != $user_pass){
			header('Location: ../html/login.html');
			exit;
		}
		else {
			session_start();
			$_SESSION['user'] = $user_id;
			header('Location: ../html/tweet_main.html');
			exit;
		}
	}
}
?>
