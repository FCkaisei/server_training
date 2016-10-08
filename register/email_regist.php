<?php
	$error = array();
	$email = $_POST['email'];
	require_once("../baseDB/connect_db.php");

	if($email == ""){
		array_push($error, "undefined email");
	}
	else{
		//仮のユーザーID作成
		$pre_user_id = uniqid(rand(100,999));
		$stmt = $pdo -> prepare("INSERT INTO members(pre_userid,email)VALUES(:pre_id,:email)");
		$stmt-> bindValue(':pre_id', $pre_user_id, PDO::PARAM_STR);
		$stmt-> bindValue(':email', $email, PDO::PARAM_STR);
		$result = $stmt-> execute();
		if($result == false){
			array_push($error, "DB ERROR");
		}
		else{
			mb_language("ja");
			mb_internal_encoding("utf-8");
			$to = $email;
			$subject = "つついたー会員登録URL";
			$message = "以下のURLにより、つついたーに登録してください。\n".
			"http://ec2-54-245-28-75.us-west-2.compute.amazonaws.com/server_training/register/regist_form.php?pre_userid=$pre_user_id";
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
	<caption>メールアドレス登録エラー</caption>
	<tr>
		<td class = "item">Error:</td>
		<td><?php print $value; ?></td>
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
