<?php
ini_set("display_errors", On);
error_reporting(E_ALL);

$user_data = $POST["user_data"];
$user_id = $user_data;
$user_pass = $user_data;
if(($user_id == "") || ($user_pass == "")) {
}
else{
	require_once("../baseDB/connect_db.php");
	$dsn = 'mysql:dbname=UserLoginDB;host=localhost';
	$user = "root";
	$password = "";
	try{
		$pdo = new PDO($dsn, $user, $password);
		print("DB->PDO接続成功");
		$pdo->query('SET NAMES utf8');
	}
	catch(PDOException $e){
		print('ERROR:'.$e->getMessage());
		die();
	}

print('hoge');
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
}
// 	if(!isset($dbPassword)){
// 	  error(2);
// 	}else {
// 	//フォームのパスワードとデータベース内のパスワードが不一致
// 	  if($dbPassword != $user_pass){
// 		error(3);
// 	  } else {
// 		//セッション作成
// 		session_start();
// 		$_SESSION['user'] = $user_id;
// 		header('location:./html/tweet_main.html');
// 		exit();
// 	}
// }
?>
