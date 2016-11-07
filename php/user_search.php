<?php
	$othersId = $_POST["others_id"];
	require_once("../baseDB/connect_db.php");
	$stmt = $pdo->prepare("SELECT * FROM members WHERE userid = ? ORDER BY userid DESC");
	$stmt->bindValue(1, "%".$othersId."%", PDO::PARAM_STR);
	$stmt->execute();
	$result = $stmt->fetchAll();
	$resultJson = json_encode($result);
	echo $resultJson;
?>
