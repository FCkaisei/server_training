<?php
	session_start();
	$user_id = $_SESSION['user'];
	$follow_id = $_POST["user_id"];
	require_once("../baseDB/connect_db.php");
	$stmt = $pdo->prepare("INSERT INTO follow_data(user_id,user_follow_id)VALUES(:user_id,:follow_id)");
	$stmt->bindValue(':user_id',$user_id,PDO::PARAM_STR);
	$stmt->bindValue(':follow_id', $follow_id,PDO::PARAM_STR);
	$stmt->execute();
	if($stmt == false){
		error_log("フォローできませんでした",0);
	}
	else{
		error_log("GOOD! follow QED",0);
	}
?>
