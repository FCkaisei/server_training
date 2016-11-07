<?php
ini_set("display_errors", On);
error_reporting(E_ALL);
$error = array();
$formList = array('mode', 'input_userid', 'input_password', 'input_name', 'input_email');
foreach($formList as $value) {
	$$value = $_POST[$value];
}

require_once('../baseDB/connect_db.php');

$stmt = $pdo -> prepare("SELECT userid FROM members WHERE userid = ?");
$stmt-> bindValue(1, $input_userid, PDO::PARAM_STR);
$stmt-> execute();

if($stmt->rowCount() > 0 ) { //ユーザーIDが存在
	array_push($error,"このユーザーIDはすでに登録されています。");
}

if(count($error) == 0) {
	//登録するデーターにエラーがない場合、memberテーブルにデータを追加する。
	//トランザクション開始
	mysql_query("begin");
    $stmt = $pdo -> prepare("INSERT INTO members VALUES(:user_id,:pass,:input_name,:email,'hoge')");
	$stmt-> bindValue(':user_id', $input_userid, PDO::PARAM_STR);
	$stmt-> bindValue(':pass', $input_password, PDO::PARAM_STR);
	$stmt-> bindValue(':input_name', $input_name, PDO::PARAM_STR);
	$stmt-> bindValue(':email', $input_email, PDO::PARAM_STR);
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
