<?php
	$error = array();
	$email = $_POST['email'];
	require_once("../../baseDB/connect_db.php");

	if($email == ""){
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
			error_log("仮IDを登録できませんでした ",0);
		}
	}
	if(count($error)){
		echo "アドレス登録エラー:";
	} else{
		echo "../php/register/regist_form.php?pre_userid=".$pre_user_id;
	}
?>
