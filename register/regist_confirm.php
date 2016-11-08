<?php
	$error = array();
	$userId = $_POST['input_userid'];
	$userPass = $_POST['input_password'];
	$userEmail = $_POST['input_email'];

	//データ入力チェック
	if($userId == ""　|| $userPass == "" || $userEmail == ""){
		array_push($error, "入力データが不足");
	}

	//パスチェック.強化の必要あり
	if(strlen($userPass) < 6 || strlen($userPass) > 16) {
		array_push($error,"pass 6-16");
	}

?>
