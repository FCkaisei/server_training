<?php
	$error = array();
	session_start();
	$user_id = $_SESSION['user'];

	if(empty($user_id)){
		array_push($error,"セッション切れ");
	}

	if(empty($_POST)){
		array_push($error,"POSTを受け取っていません");
	}

	$othersId = $_POST["others_id"];
	if(empty($_POST)){
		array_push($error,"others_idが入力されていません");
	}

	require_once("../baseDB/connect_db.php");
		// 拡張子によってMIMEタイプを切り替えるための配列
	$MIMETypes = array(
	   'png'  => 'image/png',
	   'jpg'  => 'image/jpeg',
	   'jpeg' => 'image/jpeg',
	   'gif'  => 'image/gif',
	   'bmp'  => 'image/bmp',
	);

	$stmt = $pdo->prepare('SELECT user_id,img_base,mime FROM user_data WHERE user_id LIKE ? AND user_id NOT IN (SELECT user_follow_id FROM follow_data WHERE user_id LIKE ?)');
	$stmt->bindValue(1, '%'.$othersId.'%', PDO::PARAM_STR);
	$stmt->bindValue(2, $user_id, PDO::PARAM_STR);

	$stmt->execute();
	$result = $stmt->fetchAll();
	header('Content-type: ' . $MIMETypes[$result['mime']]);

	$resultJson = json_encode($result);
	echo $resultJson;
?>
