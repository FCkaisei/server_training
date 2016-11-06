<?php
$user_id = $_POST["user_id"];
$user_pass = $_POST["user_pass"];

if(($user_id == "") || ($user_pass == "")) {
	//エラー関数の呼び出し
	error(1);
}
else{
	//ID,PASSWORD 入力アリ
	//データベースへ接続
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
	$sql = "select * from members";
	$sth = $pdo->prepare($sql);
	$sth->execute();
	$sqlResult = $sth->fetchAll();
	//フォームから取得したUSERIDとデータベース内のUSERIDが一致したらデータベースのPASSWORDを変数に格納
	foreach($sqlResult as $data){
		if($data['userid'] == $user_id) {  //フォームから取得したUSERIDとデータベースのUSERIDが一致
			$dbPassword = $data['password'];
			break;
		}
	}

	//$dbPasswordという変数に値が格納されていない場合→formUserIdとデータベースのIDが不一致
	if(!isset($dbPassword)){
	  error(2);
	}else {
	//フォームのパスワードとデータベース内のパスワードが不一致
	  if($dbPassword != $user_pass){
		error(3);
	  } else {
		//セッション作成
		session_start();
		//セッション変数を作成→セッション変数に　$formUserID を登録
		$_SESSION['user'] = $user_id;
		header("Location:./html/tweet_main.html");
		exit();
	}
}
?>
