<?php
DisplayErrorMessage();
// メールアドレス取得
$tweet_text = $_POST["tweet_text"];

//エラーメッセージ配列
$error = array();

//データ・ベースに接続
require_once("../baseDB/connect_db.php");

if($tweet_text == ""){
	array_push($error, "ツイートを入力しよう！");
}
else{
	$now = date('Y-m-d H:i:s');
	$query = "insert into tweets(user_id,tweet_text,time)value('".$_SESSION['loginUser']."','$tweet_text','$now')";
	$result = mysql_query($query);

	if($result == false){
		array_push($error, "tweetが登録できませんでした");
	}
	else{
		print("OK");
	}
}

if(count($error)){
	foreach($error as $value){
		?>
		<table>
			<caption>ツイートエラーらしいよ</caption>
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
		<caption>ツイート送信成功</caption>
		<tr>
			<td class = "item">ツイート成功だよ</td>
		</tr>
	</table>
	<?php
}
?>
