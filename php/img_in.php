<?php
error_log("一応入りはしているよね",0);
session_start();
$user_id = $_SESSION['user'];
$upfile = $_POST["pic"];
$fi = $_FILES["pic"];
error_log("-----あなたのIDーーー".$user_id,0);
error_log("-----あなたのDATAーーー".$upfile,0);
error_log("-----あなたのDATAーーー".$fi,0);


if ($fi){
	error_log("ーーーーーーーーーー入ったよーーーーーーーーーー",0);
	// ファイル取得
	$imgdat = file_get_contents($fi);
	require_once("../baseDB/connect_db.php");
	$stmt = $pdo -> prepare("UPDATE user_data SET user_img = :user_img WHERE user_id = :user_id");
	$stmt-> bindValue(':user_id', $user_id, PDO::PARAM_STR);
	$stmt-> bindValue(':user_img', $imgdat, PDO::PARAM_STR);
	$stmt->execute();

	if($stmt == false){
		error_log("--------------フォローできませんでした--------------",0);
	}
	else{
		error_log("----------------GOOD! follow QED-----------------",0);
	}
} else{
	error_log("ーーーーーーーーーー入れてないねーーーーーーーーーー",0);
}
	?>
