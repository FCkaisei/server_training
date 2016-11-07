<?php
	session_start();
	$tmpSess = $_SESSION['user'];
	require_once("../baseDB/connect_db.php");
	//memberテーブル内のuseridが「kaisei」でありながらuseridが右の式の中の値ではない物
	//'SELECT * FROM members WHERE userid LIKE ? AND userid NOT IN (SELECT follow_id FROM follows WHERE user_id LIKE ?)'
	//SELECT * FROM tweets WHERE user_id IN (SELECT user_id FROM follows WHERE follow_id LIKE "kaisei");
	$stmt = $pdo->prepare("SELECT * FROM tweets WHERE user_id IN (SELECT user_id FROM follows WHERE follow_id LIKE ?) ORDER BY time DESC");
	$stmt->bindValue(1, $tmpSess, PDO::PARAM_STR);
	$stmt->execute();
	$result = $stmt->fetchAll();
	$resultJson = json_encode($result);
	echo $resultJson;
?>
