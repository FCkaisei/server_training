<?php
	$error = array();

	$userId = $_POST['input_user_id'];
	$userName = $_POST['input_user_name'];
	$userPass = $_POST['input_password'];
	$userPass_r = $_POST['input_password_r'];
	$userEmail = $_POST['input_email'];
	$userToken = $_POST['pre_userid'];

	//パスチェック.強化の必要あり
	if(strlen($userPass) < 6 || strlen($userPass) > 40) {
		array_push($error,"パスワードの文字数が足りません");
	}
	if($userId == $userPass){
		array_push($error,"パスワードとIDを同じ値にしてはいけません");
	}
	if($userPass_r != $userPass){
		array_push($error,"パスワードがずれています");
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
<head>
	<link rel="stylesheet" type="text/css" href="../../CSS/main.css">
	<meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title></title>
</head>
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
			<form method="post" action="./user_regist.php" class="flex-formReSize">
				<table>
					<caption>入力情報確認ページ</caption>
					<tr>
						<td class="item">preID：</td>
						<td>
							<?php print $userToken;?>
							<input type="hidden" name="input_token" value="<?php print $userToken;?>">
						</td>
					</tr>
					<tr>
						<td class="item">ユーザーID：</td>
						<td>
							<?php print $userId;?>
							<input type="hidden" name="input_userid" value="<?php print $userId;?>"></td>
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
		</div>
	</div>
</div>

<?php
	}
?>
