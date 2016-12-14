<?php
	session_start();
	$userId = $_SESSION['user'];
	require_once("../baseDB/connect_db.php");
	//INNER JOIN user_data ON tweet_data.user_id = user_data.user_id
	//('SELECT user_id,img_base,mime FROM user_data WHERE user_id LIKE ? AND user_id NOT IN (SELECT user_follow_id FROM follow_data WHERE user_id LIKE ?)')
	$stmt = $pdo->prepare("SELECT * FROM follow_data INNER JOIN user_data ON follow_data.user_id = user_data.user_id WHERE user_id LIKE ?");
	$stmt->bindValue(1, $userId, PDO::PARAM_STR);
	$stmt->execute();
	$result = $stmt->fetchAll();
	$resultJson = json_encode($result);
	echo $resultJson;
?>
