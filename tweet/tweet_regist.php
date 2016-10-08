<?php
// メールアドレス取得
$email = $_POST["email"];

//エラーメッセージ配列
$error = array();

//データ・ベースに接続
require_once("../baseDB/connect_db.php");

if($email == ""){
	array_push($error, "メールアドレスが入力されていません");
}
else{
	$pre_user_id = uniqid(rand(100,999));
	//仮のユーザーID作成
	$query = "insert into members(pre_userid,email)value('$pre_user_id','$email')";
	$result = mysql_query($query);

	if($result == false){
		array_push($error, "DBに登録できません");
	}
	else{
		mb_language("ja");
		mb_internal_encoding("utf-8");

		$to = $email;
		$subject = "先輩クラブ会員登録URL";
		$message = "以下のURLにより、先輩クラブ会員に登録してください。\n".
		"http://ec2-54-245-28-75.us-west-2.compute.amazonaws.com/server/register/regist_form.php?pre_userid=$pre_user_id";
		$header = "From:c011343171@edu.teu.ac.jp";

		if(!mb_send_mail($to, $subject, $message, $header)){
			array_push($error, "メールが送信できませんした");
		}
	}
}

if(count($error)){
	foreach($error as $value){
		?>
		<table>
			<caption>メールアドレス登録エラーらしいよ</caption>
			<tr>
				<td class = "item">Error:</td>
				<td>
					<?php
					print $value;
					?>
				</td>
			</tr>
		</table>
		<?php
	}
}
else{
	?>
	<table>
		<caption>メール送信成功</caption>
		<tr>
			<td class = "item">メールを確認してください</td>
		</tr>
	</table>
	<?php
}
?>
