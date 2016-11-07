<?php
ini_set("display_errors", On);
error_reporting(E_ALL);

$pre_userid = $_GET['pre_userid'];
$isErrorFlag = true;
include("../baseDB/connect_db.php");
$stmt = $pdo -> prepare("SELECT email FROM members WHERE pre_userid = ?");
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
<form method="post" action="./regist_confirm.php">
	<input type="hidden" name="mode" value="regist_confirm">
	<input type="hidden" name="pre_userid" value="<?php print $pre_userid; ?>">
	<table>
		<caption>会員情報登録フォーム</caption>
		<tr>
			<td class="item">ユーザー名：</td>
			<td><input type="text" size="30" name="input_userid" value=""></td>
		</tr>
		<tr>
			<td class="item">パスワード：</td>
			<td><input type="text" size="30" name="input_password" value=""></td>
		</tr>
		<tr>
			<td class="item">名前：</td>
			<td><input type="text" size="30" name="input_name" value=""></td>
		</tr>
		<tr>
			<td class="item">E-mail：</td>
			<td><input type="hidden" name="input_email" value="<?php print $email; ?>"></td>
		</tr>
	</table>
	<div>
		<input type="submit" value="送信">
	</div>
</form>
<?php
}
?>
