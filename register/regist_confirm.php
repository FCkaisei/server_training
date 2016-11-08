<?php
	ini_set("display_errors", On);
	error_reporting(E_ALL);
?>

<?php
	$error = array();
	$userId = $_POST['input_userid'];
	$userPass = $_POST['input_password'];
	$userEmail = $_POST['input_email'];


	//パスチェック.強化の必要あり
	if(strlen($userPass) < 6 || strlen($userPass) > 16) {
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
			<td>
				<?php print $userId;?><input type="hidden" name="input_userid" value="<?php print $userId;?>"></td>
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
