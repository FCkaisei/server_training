<?php
	$pre_userid = $_GET['pre_userid'];
	$isErrorFlag = true;
	include("../../baseDB/connect_db.php");
	$stmt = $pdo -> prepare("SELECT user_mail FROM user_data WHERE user_token_id = ?");
	$stmt-> bindValue(1, $pre_userid, PDO::PARAM_STR);
	$stmt-> execute();
	$result = $stmt->fetchAll();

	//データ・ベースにより取得したメールアドレスを表示してみる
	if($stmt->rowCount() > 0){
		$isErrorFlag = false;
		$email = $result[0][0];
	}
	if($isErrorFlag){
	}
	else{
?>
<head>
		<link rel="stylesheet" type="text/css" href="../../CSS/main.css">
</head>
<body>
<!--ヘッダー-->
<div class="flex-container-noheight">
	<div class="flex-item3">
		<div class="m-title">
			つついったーログイン
		</div>
	</div>
</div>


<div class="flex-container-center">
	<!--ツイートメイン-->
	<div class="flex-item-center">
		<div class="flex-container-center">
			<form method="post" action="../DAO.php" class="flex-formReSize">
				<input type="hidden" name="pre_userid" value="<?php print $pre_userid; ?>">
					<input type="text" name="action"; value="Resist-resistConfirm">
					<div>会員情報登録フォーム</div>
						<div class="item">ユーザーID</div>
						<div><input type="text" size="30" name="input_user_id" value=""></div>
					<div>
						<div class="item">パスワード：</div>
						<div><input type="password" size="40" name="input_password" value=""></div>
						<div><input type="password" size="40" name="input_password_r" value=""></div>
					</div>
						<div class="item">E-mail：</div>
						<div><input type="hidden" name="input_email" value="<?php print $email; ?>"><?php print $email; ?></div>
				<div>
					<input type="submit" value="送信">
				</div>
			</form>
		</div>
	</div>
</div>

</body>
<?php
	}
?>
