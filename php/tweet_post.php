<?php
session_start();
$loginUser = $_SESSION['user'];
$tweet_text = $_POST["tweet_text"];
//データ・ベースに接続
require_once("../baseDB/connect_db.php");
else{
	$now = date('Y-m-d H:i:s');
	$stmt = $pdo->prepare("INSERT INTO tweets(user_id,tweet_text,time)VALUES(:user_id, :tweet_text, :timer)");
	$stmt->bindValue(':user_id',$loginUser, PDO::PARAM_STR);
	$stmt->bindValue(':tweet_text', $tweet_text, PDO::PARAM_STR);
	$stmt->bindValue(':timer', $now, PDO::PARAM_STR);
	$stmt->execute();
}
?>
