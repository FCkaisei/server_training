<?php
error_log("一応入りはしているよね",0);
session_start();
$user_id = $_SESSION['user'];

if(!empty($_POST)){
	//バイナリデータ
	$fp = fopen($_FILES["image"]["tmp_name"], "rb");
	$imgdat = fread($fp, filesize($_FILES["image"]["tmp_name"]));
	fclose($fp);
    $imgdat = addslashes($imgdat);

	// 拡張子
    $dat = pathinfo($_FILES["image"]["name"]);
    $extension = $dat['extension'];

	// MIMEタイプ
   if ( $extension == "jpg" || $extension == "jpeg" ) $mime = "image/jpeg";
   else if( $extension == "gif" ) $mime = "image/gif";
   else if ( $extension == "png" ) $mime = "image/png";


	  error_log("--------------".$imgdat."--------------",0);

   	   error_log("-------------".$mime."--------------",0);
	   error_log("-------------".$user_id."--------------",0);
   // MySQL登録（改造しよう)
   require_once("../baseDB/connect_db.php");
   $stmt = $pdo -> prepare("UPDATE user_data SET img_blob = :user_img, mime = :mime WHERE user_id = :user_id");
   $stmt-> bindValue(':user_img', $imgdat, PDO::PARAM_LOB);
   $stmt-> bindValue(':mine', $mime, PDO::PARAM_STR);
   $stmt-> bindValue(':user_id', $user_id, PDO::PARAM_STR);
   $stmt->execute();

   if($stmt == false){
	   error_log("--------------フォローできませんでした--------------",0);
   }
   else{
	   error_log("----------------GOOD! follow QED-----------------",0);
   }
}
else{
   error_log("ーーーーーーーーーー入れてないねーーーーーーーーーー",0);
}
	?>
