<?php

error_log('一応入りはしているよね', 0);
session_start();
$user_id = $_SESSION['user'];

if (!empty($_POST)) {
    //バイナリデータ
    $fp     = fopen($_FILES['image']['tmp_name'], 'rb');
    $imgdat = fread($fp, filesize($_FILES['image']['tmp_name']));
    fclose($fp);
    $imgdat = addslashes($imgdat);

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

	$img_base64 = base64_encode(file_get_contents($_FILES['image']['tmp_name']));
    error_log('--------------'.$img_base64.'--------------', 0);
    error_log('-------------'.$mime.'--------------', 0);
    error_log('-------------'.$user_id.'--------------', 0);

   require_once '../baseDB/connect_db.php';
    $stmt = $pdo->prepare('UPDATE user_data SET img_base = :user_img, mime = :mime WHERE user_id = :user_id');
    $stmt->bindValue(':user_img', $img_base64, PDO::PARAM_STR);
    $stmt->bindValue(':mime', $mime, PDO::PARAM_STR);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
    $stmt->execute();

?>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../CSS/main.css">
	<meta http-equiv="Content-Script-Type" content="text/javascript">
</head>
<body link="rgb(175,175,175)" alink="rgb(175,175,175)" vlink="rgb(175,175,175)">
	<!--ヘッダー-->
	<div class="flex-container-noheight">
		<div class="flex-item3">
			<div class="m-title">
				プロ画登録
			</div>
		</div>
	</div>

	<!--サイドバーとつぶやきメイン-->
	<div class="flex-container">
		<!--サイドバー-->
		<div class="flex-item">
			<div class="flex-container-column">
				<div class="flex-item">
					<a href="../html/tweet_main.html"><div class="menuBottan">画像編集</div></a>
				</div>
				<div class="flex-item">
					<a href="../html/follow_main.html"><div class="menuBottan">みつける</div></a>
				</div>
				<div class="flex-item">
					<a href="../html/follow_otheres.html"><div class="menuBottan">フォロー</div></a>
				</div>
				<div class="flex-item">
					<a href="../html/Profile.html"><div class="menuBottan">画像変更</div></a>
				</div>
				<div class="flex-item">
					<a href="./login.html"><div class="menuBottan">LOGOUT</div></a>
				</div>
			</div>
		</div>
<?PHP
    if ($stmt == false) {
?>

				<!--ツイートメイン-->
				<div class="flex-item2">
					画像を登録できませんでした。。。
				</div>

<?PHP
		error_log('--------------フォローできませんでした--------------', 0);
    } else {
		?>
		<div class="flex-item2">
			画像登録完了！
		</div>
		<?PHP
        error_log('----------------GOOD! follow QED-----------------', 0);
    }
	?>
	</div>
</body>
<?PHP
} else {
    error_log('ーーーーーーーーーー入れてないねーーーーーーーーーー', 0);
}
?>
