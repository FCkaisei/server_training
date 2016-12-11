<?php
	session_start();
	$tmpSess = $_SESSION['user'];
	require_once("../baseDB/connect_db.php");
	$page = $_POST["page"];
	//ページング処理追加
	error_log($page, 0);
	if($page == ""){
		$page = 1;
	}
	//ページが一より小さい場合は1
	$page = max($page, 1);


	$lowLim = $page * 4 - 4;
	$highLim = 5;

	$stmt = $pdo->prepare("SELECT tweet_data.user_id, tweet_data.user_tweet, user_data.img_base, tweet_data.user_tweet_time
		FROM tweet_data LEFT JOIN user_data ON tweet_data.user_id
		IN (
			SELECT user_id
			FROM follow_data
			WHERE user_follow_id
			LIKE ?
		)
		ORDER BY user_tweet_time");

	$stmt->bindValue(1, $tmpSess, PDO::PARAM_STR);
	$stmt->bindValue(2, $lowLim, PDO::PARAM_INT);
	$stmt->bindValue(3, $highLim, PDO::PARAM_INT);
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
