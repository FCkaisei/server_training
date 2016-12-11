<?php
	session_start();
	$tmpSess = $_SESSION['user'];
	$othersId = $_POST["others_id"];
	require_once("../baseDB/connect_db.php");
	//memberテーブル内のuseridが「kaisei」でありながらuseridが右の式の中の値ではない物
	$stmt = $pdo->prepare('SELECT * FROM user_data WHERE user_id LIKE ? AND user_id NOT IN (SELECT user_follow_id FROM follow_data WHERE user_id LIKE ?)');

	$stmt->bindValue(1, '%'.$othersId.'%', PDO::PARAM_STR);
	$stmt->bindValue(2, $tmpSess, PDO::PARAM_STR);

	$stmt->execute();
	$result = $stmt->fetchAll();

	error_log(var_dump($result),0);

	for ($i = 0; $i <= count($result); $i++) {
		$result[$i]["img_blob"] = string base64_encode(string $result[$i]["img_blob"]);
	}
	error_log(var_dump($result),0);
	$resultJson = json_encode($result);
	echo $resultJson;
?>
