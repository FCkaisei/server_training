<?php
ini_set("display_errors", On);
error_reporting(E_ALL);
?>

<?php
/* 入力フォームからパラメータを取得 */
$formList = array('mode', 'input_userid', 'input_password', 'input_name', 'input_email');

/* ポストデータを取得しパラメータと同名の変数に格納 */
foreach($formList as $value) {
  $$value = $_POST[$value];
}

/* エラーメッセージの初期化 */
$error = array();

/* データベース接続設定 */
require_once('../baseDB/connect_db.php');

/* ユーザーIDチェック */
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
		/* 登録完了メールを送信 */
		mb_language("japanese");  //言語の設定
		mb_internal_encoding("utf-8");//内部エンコーディングの設定

		$to = $input_email;
		$subject = "会員登録URL送信メール";
		$message = "会員登録ありがとうございました。\n".
		"登録いただいたユーザーIDは[$input_userid]です。\n".
		"↓下記URLからログイン！".
		"http://ec2-54-245-28-75.us-west-2.compute.amazonaws.com/server_training/html/login.html";
		$header = "From:test@test.com";
		if(!mb_send_mail($to, $subject, $message, $header)) {  //メール送信に失敗したら
			array_push($error,"メールが送信できませんでした。<br>ただしデータベースへの登録は完了しています。");
		}
  } else {	//データベースへの登録作業失敗
	  ChromePhp::Log('データ・ベース登録失敗');
    //ロールバック
    mysql_query("rollback");
    array_push($error, "データベースに登録できませんでした。?");
  }
}
if(count($error) == 0) {
?>
<table>
  <caption>データベース登録完了</caption>
  <tr>
    <td class="item">Thanks：</td>
    <td>登録ありがとうございます。<br>登録完了のお知らせをメールで送信しましたので、ご確認ください。</td>
  </tr>
</table>
<?php
/* エラー内容表示 */
} else {
?>
<table>
  <caption>データベース登録エラー</caption>
  <tr>
  <td class="item">Error：</td>
  <td>
  <?php
  foreach($error as $value) {
    print $value;
  ?>
  </td>
  </tr>
</table>
<?php
  }
}
?>
