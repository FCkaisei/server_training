<?php
	session_start();
	$userId = $_SESSION['user'];
	require_once("../baseDB/connect_db.php");
	//画像データも取得できるようにする
	//$stmt = $pdo->prepare("SELECT * FROM follow_data WHERE user_id LIKE ?");
	//user_data.img_base FROM tweet_data INNER JOIN user_data ON tweet_data.user_id = user_data.user_id

	$stmt = $pdo->prepare("SELECT *
		FROM follow_data
		INNER JOIN user_data
		ON follow_data.user_id = user_data.user_id
		WHERE user_id LIKE ?");

	$stmt->bindValue(1, $userId, PDO::PARAM_STR);
	$stmt->execute();
	$result = $stmt->fetchAll();
	$resultJson = json_encode($result);
	echo $resultJson;
?>
