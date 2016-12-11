<?php
	session_start();
	$tmpSess = $_SESSION['user'];
	$othersId = $_POST["others_id"];
	require_once("../baseDB/connect_db.php");






		// 拡張子によってMIMEタイプを切り替えるための配列
	$MIMETypes = array(
	   'png'  => 'image/png',
	   'jpg'  => 'image/jpeg',
	   'jpeg' => 'image/jpeg',
	   'gif'  => 'image/gif',
	   'bmp'  => 'image/bmp',
	);




	//memberテーブル内のuseridが「kaisei」でありながらuseridが右の式の中の値ではない物
	$stmt = $pdo->prepare('SELECT * FROM user_data WHERE user_id LIKE ? AND user_id NOT IN (SELECT user_follow_id FROM follow_data WHERE user_id LIKE ?)');

	$stmt->bindValue(1, '%'.$othersId.'%', PDO::PARAM_STR);
	$stmt->bindValue(2, $tmpSess, PDO::PARAM_STR);

	$stmt->execute();
	$result = $stmt->fetchAll();
	header('Content-type: ' . $MIMETypes[$result['mime']]);

	$resultJson = json_encode($result);
	echo $resultJson;
?>
