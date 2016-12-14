<?php
	$error = array();

	$email = $_POST['email'];

	require_once("../../baseDB/connect_db.php");

	if (preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $email)) {
	}
	else{
		array_push($error,"ただいいメールアドレスを入力してください");
	}

	if(empty($email)){
		array_push($error,"addressが入力されていません");
		error_log("アドレスが入力されていません");
	}
	else{
		//仮のユーザーID作成
		$pre_user_id = uniqid("", true);
		$stmt = $pdo -> prepare("INSERT INTO user_data(user_token_id,user_mail)VALUES(:user_token_id,:user_email)");
		$stmt-> bindValue(':user_token_id', $pre_user_id, PDO::PARAM_STR);
		$stmt-> bindValue(':user_email', $email, PDO::PARAM_STR);
		$stmt->execute();
		$result = $stmt->fetchAll();
		$resultJson = json_encode($result);
		if($stmt == false){
			array_push($error,"仮ID登録できず");
		}
	}
	if(count($error)){
		for ($i = 0 ; $i < count($error); $i++) {
			echo("addressを正しく入力してください");
		}
	}
	else{
		echo("<a href='../php/register/regist_form.php?pre_userid=".$pre_user_id."'>ユーザー本登録へ</a>") ;
	}
?>
