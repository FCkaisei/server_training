<?php
	session_start();
	$tmpSess = $_SESSION['user'];
	require_once("../baseDB/connect_db.php");

	//やること
	//ツイート数を取得してその数を10くらいで割る。
	//算出された数＋1ページの数を返す

	$stmt = $pdo->prepare("SELECT COUNT(*) FROM tweet_data WHERE user_id IN (SELECT user_follow_id FROM follow_data WHERE user_id LIKE ?) ORDER BY user_tweet_time DESC");
	$stmt->bindValue(1, $tmpSess, PDO::PARAM_STR);
	$stmt->execute();
	$result = $stmt->fetchAll();
	$resultJson = json_encode($result);

	if($stmt == false){
		error_log("SQL ミスってるよ",0);
	}
	else{
		error_log("GOOD!",0);
			echo $resultJson;
	}


?>
