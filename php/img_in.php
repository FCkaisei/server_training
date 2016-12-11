<?php

error_log('一応入りはしているよね', 0);
session_start();
$user_id = $_SESSION['user'];
$user_image = $_POST["image"];
if (!empty($_POST)) {

	$img = base64_encode(file_get_contents($user_img));
    //バイナリデータ
    $fp     = fopen($_FILES['image']['tmp_name'], 'rb');
    $imgdat = fread($fp, filesize($_FILES['image']['tmp_name']));
    fclose($fp);

    // 拡張子
    $dat       = pathinfo($_FILES['image']['name']);
    $extension = $dat['extension'];


    // MIMEタイプ
   if ($extension == 'jpg' || $extension == 'jpeg') {
       $mime = 'image/jpeg';
   } elseif ($extension == 'gif') {
       $mime = 'image/gif';
   } elseif ($extension == 'png') {
       $mime = 'image/png';
   }

    $img_base64 = base64_encode($img);
    error_log('--------------'.$img_base64.'--------------', 0);
    error_log('-------------'.$mime.'--------------', 0);
    error_log('-------------'.$user_id.'--------------', 0);

   require_once '../baseDB/connect_db.php';
    $stmt = $pdo->prepare('UPDATE user_data SET img_base = :user_img, mime = :mime WHERE user_id = :user_id');
    $stmt->bindValue(':user_img', $img_base64, PDO::PARAM_STR);
    $stmt->bindValue(':mime', $mime, PDO::PARAM_STR);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
    $stmt->execute();
    if ($stmt == false) {
        error_log('--------------フォローできませんでした--------------', 0);
    } else {
        error_log('----------------GOOD! follow QED-----------------', 0);
    }
} else {
    error_log('ーーーーーーーーーー入れてないねーーーーーーーーーー', 0);
}
