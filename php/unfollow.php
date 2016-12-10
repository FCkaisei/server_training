<?php
	//セッション設定
	session_start();
	$session_user_id = $_SESSION['user'];

	$otherId = $_POST['unfollow_id'];

	require_once("../baseDB/connect_db.php");
	$stmt = $pdo->prepare("DELETE FROM follow_data WHERE user_id=? AND user_follow_id=?");
	$stmt->bindValue(1,$session_user_id,PDO::PARAM_STR);
	$stmt->bindValue(2,$otherId,PDO::PARAM_STR);
	$stmt->execute();
	if($stmt == false){
		error_log("UnFollowに失敗しました", 0);
	}
	else{
		error_log("フォローに成功しました", 0);
	}

?>
