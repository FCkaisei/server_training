<?php
	session_start();
	$userId = $_SESSION['user'];
	require_once("../baseDB/connect_db.php");
	$stmt = $pdo->prepare("SELECT * FROM follows WHERE user_id LIKE ?");
	$stmt->bindValue(1, $userId, PDO::PARAM_STR);
	$stmt->execute();
	$result = $stmt->fetchAll();
	$resultJson = json_encode($result);
	echo $resultJson;
?>
