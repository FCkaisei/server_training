<?php
	$error = array();
	$userId = $_POST['input_userid'];
	$userPass = $_POST['input_password'];
	$userName = $_POST['input_name'];
	$userEmail = $_POST['input_email'];
	require_once('../baseDB/connect_db.php');
	$stmt = $pdo -> prepare("SELECT userid FROM members WHERE userid = ?");
	$stmt-> bindValue(1, $userId, PDO::PARAM_STR);
	$stmt-> execute();

	if($stmt->rowCount() > 0 ) { //ユーザーIDが存在
		array_push($error,"このユーザーIDはすでに登録されています。");
	}

	if(count($error) == 0) {
		//登録するデーターにエラーがない場合、memberテーブルにデータを追加する。
		//トランザクション開始
		mysql_query("begin");
		$stmt = $pdo -> prepare("INSERT INTO members VALUES(:user_id,:pass,:input_name,:email,'hoge')");
		$stmt-> bindValue(':user_id', $userId, PDO::PARAM_STR);
		$stmt-> bindValue(':pass', $userPass, PDO::PARAM_STR);
		$stmt-> bindValue(':input_name', $userName, PDO::PARAM_STR);
		$stmt-> bindValue(':email', $userEmail, PDO::PARAM_STR);
		$result = $stmt-> execute();
		if($result){  //登録完了
		}
		else {	//データベースへの登録作業失敗
	    //ロールバック
	    mysql_query("rollback");
	    array_push($error, "データベースに登録できませんでした。");
	  }
	}
	if(count($error) == 0) {
?>
	<div>データベース登録完了</div>
	<div class="item">Thanks：</div>
	<div>登録ありがとうございます。</div>
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
