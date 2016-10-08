<?php
ini_set("display_errors", On);
error_reporting(E_ALL);
$pre_userid = $_GET['pre_userid'];
$isErrorFlag = true;
require_once("connect_db.php");
$query = "select email from members where pre_userid = '$pre_userid'";
$result = mysql_query($query);
//データ・ベースにより取得したメールアドレスを表示してみる
if(mysql_num_rows($result) > 0){
	$isErrorFlag = false;
	$data = mysql_fetch_array($result);
	$email = $data['email'];
}
if($isErrorFlag){
?>

<table>
	<caption>メールアドレス</caption>
	<tr>
		<td class = "item">
			Error:
		</td>
		<td>
			このURLは利用できません<br>
			もう一度メールアドレスの登録からお願いします。<br>
			<a href="registerManager.php">会員登録ページ</a>
		</td>
	</tr>
</table>
<?php
}
else{
	?>
	<form method="post" action="registerManager.php">
		<input type="hidden" name="mode" value="regist_confirm">
		<input type="hidden" name="pre_userid" value="<?php print $pre_userid; ?>">
		<table>
			<caption>会員情報登録フォーム</caption>
				<tr>
				<td class="item">
					ユーザー名：
				</td>
				<td>
					<input type="text" size="30" name="input_userid" value="">
				</td>
			</tr>
			<tr>
				<td class="item">
					パスワード：
				</td>
				<td>
					<input type="text" size="30" name="input_password" value="">
					&nbsp;&nbsp;※ 6文字以上16文字以下
				</td>
			</tr>
			<tr>
				<td class="item">
					名前：
				</td>
				<td>
					<input type="text" size="30" name="input_name" value="">
				</td>
			</tr>
			<tr>
				<td class="item">
					E-mail：
				</td>
				<td>
					<?php print $email; ?>
					<input type="hidden" name="input_email" value="<?php print $email; ?>">
				</td>
			</tr>
		</table>
		<div>
			<input type="submit" value="送信">
		</div>
	</form>
	<?php
}
?>
