<?php
	session_start();
	$tmpSess = $_SESSION['user'];
	require_once("../baseDB/connect_db.php");
	$stmt = $pdo->prepare("SELECT * FROM tweets WHERE user_id IN (SELECT user_id FROM follows WHERE follow_id LIKE ?) ORDER BY time DESC");
	$stmt->bindValue(1, $tmpSess, PDO::PARAM_STR);
	$stmt->execute();
	$result = $stmt->fetchAll();
	$resultJson = json_encode($result);
	echo $resultJson;
?>
