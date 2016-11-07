<?php
	session_start();
	$tmpSess = $_SESSION['user'];
	$othersId = $_POST["others_id"];
	require_once("../baseDB/connect_db.php");
	//SELECT * FROM members WHERE userid LIKE "%kaisei%" AND userid NOT IN (SELECT follow_id FROM follows WHERE user_id="aaaaaa");
	$stmt = $pdo->prepare('SELECT * FROM members WHERE userid LIKE "%"?"%" AND userid NOT IN (SELECT follow_id FROM follows WHERE user_id LIKE ?)');

	$stmt = $pdo->prepare("SELECT * FROM members WHERE userid LIKE ? ORDER BY userid DESC");
	$stmt->bindValue(1, $othersId, PDO::PARAM_STR);
	$stmt->bindValue(2, $tmpSess, PDO::PARAM_STR);

	$stmt->execute();
	$result = $stmt->fetchAll();
	$resultJson = json_encode($result);
	echo $resultJson;
?>
