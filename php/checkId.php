<?php
$user_data = $POST["user_data"];
$user_id = $user_data;
$user_pass = $user_data;
if(($user_id == "") || ($user_pass == "")) {
	echo "10";
}
else{
	echo "2";
	require_once("../baseDB/connect_db.php");
	$dsn = 'mysql:dbname=UserLoginDB;host=localhost';
	$user = "root";
	$password = "";
	try{
		echo "3";
		$pdo = new PDO($dsn, $user, $password);
		print("DB->PDO接続成功");
		$pdo->query('SET NAMES utf8');
	}
	catch(PDOException $e){
		echo "4";
		print('ERROR:'.$e->getMessage());
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
	}else {
	if($dbPassword != $user_pass){

	}
	else {
		session_start();
		$_SESSION['user'] = $user_id;
		echo "crea";
		header('../html/tweet_main.html');
		exit();
	}
}

}
?>
