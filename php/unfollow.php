<?php
	session_start();
	$userId = $_SESSION['user'];
	$otherId = $_POST['unfollow_id'];

	require_once("../baseDB/connect_db.php");
	$stmt = $pdo->prepare("DELETE FROM follows WHERE user_id=? AND follow_id=?");
	$stmt->bindValue(1,$userId,PDO::PARAM_STR);
	$stmt->bindValue(2,$otherId,PDO::PARAM_STR);
	$stmt->execute();
	if($stmt == false){
		array_push($error, "フォロー出来ませんでした");
	}
	else{
	}
?>
