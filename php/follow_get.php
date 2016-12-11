<?php
	session_start();
	$userId = $_SESSION['user'];
	require_once("../baseDB/connect_db.php");
	$stmt = $pdo->prepare("SELECT * FROM follow_data WHERE user_id LIKE ?");
	$stmt->bindValue(1, $userId, PDO::PARAM_STR);
	$stmt->execute();
	$result = $stmt->fetchAll();
	//string base64_encode ( string $data );
	error_log(var_dump($result),0);
	for ($i = 0; $i <= count($result); $i++) {
    	$result[$i][4] = string base64_encode(string $result[$i][4]);
	}
	error_log(var_dump($result),0);
	$resultJson = json_encode($result);
	echo $resultJson;
?>
