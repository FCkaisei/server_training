<?php
	session_start();
	$userId = $_SESSION['user'];
	$tweet_text = $_POST["others_id"];
	require_once("../baseDB/connect_db.php");
	$stmt = $pdo->prepare("SELECT * FROM members WHERE user_id = ? ORDER BY id DESC");
	$stmt->bindValue(1, $userId, PDO::PARAM_STR);
	$stmt->execute();
	$result = $stmt->fetchAll();
	$resultJson = json_encode($result);
	echo $resultJson;

?>
