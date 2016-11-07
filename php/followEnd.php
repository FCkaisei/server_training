<?php
$user_id = $_POST["user_id"];

require_once("../baseDB/connect_db.php");
$stmt = $pdo->prepare("INSERT INTO follows(follow_id,user_id)VALUES(:follow_id, :user_id)");
$stmt->bindValue(':user_id',$_SESSION['loginUser'], PDO::PARAM_STR);
$stmt->bindValue(':follow_id', $user_id, PDO::PARAM_STR);
$stmt->execute();
if($stmt == false){
	array_push($error, "tweetが登録できませんでした");
}
else{
}
 ?>
