<?php
error_log("PHP/LOGIN処理に入りました", 0);
$user_id = $_POST['formUserid'];
$user_pass = $_POST['formPassword'];
$user_pass = hash( 'sha256', $user_pass) . "\n";
if(($user_id == "") || ($user_pass == "")){
	error_log("IDもしくはパスワードが未入力です", 0);
	header('Location: ../html/login.html');
	exit;
}

else{
	error_log("user_idとuser_passが入力されています", 0);
	require_once("../baseDB/connect_db.php");
	try{
		error_log("try in", 0);
		$pdo = new PDO($dsn, $user, $password);
		$pdo->query('SET NAMES utf8');
	}
	catch(PDOException $e){
		error_log("tuusin_sippai", 0);
		header('Location: ../html/login.html');
		exit;
		die();
	}

	$sql = "select * from user_data";
	$sth = $pdo->prepare($sql);
	$sth->execute();
	$sqlResult = $sth->fetchAll();

	foreach($sqlResult as $data){
		if($data['user_id'] == $user_id) {
			$dbPassword = $data['user_pass'];
			error_log($dbPassword,0);
			error_log($user_pass,0);
			break;
		}
	}

	if(!isset($dbPassword)){
		error_log("not get DBPass", 0);
		header('Location: ../html/login.html');
		exit;
		error(2);
	}

	else {

		if($dbPassword != $user_pass){
			error_log("dbPass huitti", 0);
			header('Location: ../html/login.html');
			exit;
		}
		else {
			error_log("kokomadekiteru", 0);

			session_start();
			$_SESSION['user'] = $user_id;
			header('Location: ../html/tweet_main.html');
			exit;
		}
	}
}
?>
