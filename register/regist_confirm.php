<?php
	$error = array();
	$userId = $_POST['input_userid'];
	$userPass = $_POST['input_userpassword'];
	$userEmail = $_POST['input_email'];

	//データ入力チェック
	if($userId == "",$userPass == "", $userEmail == ""){
		array_push($error, "入力データが不足");
	}

	//パスチェック.強化の必要あり
	if(strlen($input_password) < 6 || strlen($input_password) > 16) {
		array_push($error,"pass 6-16");
	}

?>
<div>
<?php
	if(count($error) > 0) {
?>
</div>
<?php
	}else {
?>
<form method="post" action="./user_regist.php">
	<table>
		<caption>入力情報確認ページ</caption>
		<tr>
			<td class="item">ユーザー名：</td>
			<td><?php print $userId;?><input type="hidden" name="input_userid" value="<?php print $userId;?>"></td>
		</tr>
		<tr>
			<td class="item">パスワード：</td>
			<td><?php print $userPass;?><input type="hidden" name="input_password" value="<?php print $userPass;?>"></td>
		</tr>
		<tr>
			<td class="item">メールアドレス：</td>
			<td><?php print $userEmail;?><input type="hidden" name="input_email" value="<?php print $userEmail;?>"></td>
		</tr>
	</table>
	<div><input type="submit" value=" 登 録 "></div>
</form>
<?php
	}
?>
