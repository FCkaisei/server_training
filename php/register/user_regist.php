<?php
	$error = array();
	$userId = $_POST['input_userid'];
	$userPass = $_POST['input_password'];
	$userEmail = $_POST['input_email'];
	$userToken = $_POST['input_token'];

	require_once('../../baseDB/connect_db.php');
	$stmt = $pdo -> prepare("SELECT user_id FROM user_data WHERE user_id = ?");
	$stmt-> bindValue(1, $userId, PDO::PARAM_STR);
	$stmt-> execute();

	if($stmt->rowCount() > 0 ) { //ユーザーIDが存在
		array_push($error,"このユーザーIDはすでに登録されています。");
	}

	$stmt = $pdo -> prepare("SELECT * FROM user_data WHERE user_token_id = ? AND user_mail = ?");
	$stmt-> bindValue(1, $userToken, PDO::PARAM_STR);
	$stmt-> bindValue(2, $userEmail, PDO::PARAM_STR);
	$stmt-> execute();

	if($stmt->rowCount() == 0 ) { //ユーザーIDが存在
		array_push($error,"メールアドレスとプレIDが一致しない。不正なことスナ！");
	}

	if(count($error) == 0) {
		mysql_query("begin");
		$data = 'yutakikuchi';
		$userPass = hash( 'sha256', $userPass) . "\n";
		//$stmt = $pdo -> prepare("INSERT IGNORE INTO user_data(user_id,user_pass,user_mail)VALUES(:user_id, :user_pass, :user_email)");
		$stmt = $pdo -> prepare("UPDATE user_data SET user_id = :user_id, user_pass = :user_pass, user_mail = :user_email WHERE user_token_id = :user_token");
		$stmt-> bindValue(':user_id', $userId, PDO::PARAM_STR);
		$stmt-> bindValue(':user_pass', $userPass, PDO::PARAM_STR);
		$stmt-> bindValue(':user_email', $userEmail, PDO::PARAM_STR);
		$stmt-> bindValue(':user_token', $userToken, PDO::PARAM_STR);
		$result = $stmt-> execute();
		if($result){  //登録完了
			error_log("ID登録完了",0);
		}
		else {	//データベースへの登録作業失敗
	    	mysql_query("rollback");
	    	array_push($error, "データベースに登録できませんでした。");
	  }
	}
	if(count($error) == 0) {
?>

<head>
	<link rel="stylesheet" type="text/css" href="../../CSS/main.css">
	<meta charset="utf-8">
</head>
<!--ヘッダー-->
<div class="flex-container-noheight">
	<div class="flex-item3">
		<div class="m-title">
			THANK U
		</div>
	</div>
</div>

<div class="flex-container-center">
	<!--ツイートメイン-->
	<div class="flex-item-center">
		<div class="flex-container-center">
			<form action="../php/login.php" method="post" class="flex-formReSize">
					<div>登録ありがとうございます。</div>
					<div>
						<a href="../../html/login.html">ログイン画面へ</a>
					</div>
			</form>
		</div>
	</div>
</div>

<?php
	}
	else {
?>
	<div class="item">Error：</div>
	<div>
<?php
		foreach($error as $value) {
			print $value;
?>
	</div>
<?php
		}
	}
?>
