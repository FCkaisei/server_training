<?php
class ResistDAO {
	private $PostData;
	private $error = array();
	private $pdo;
	private $s_user_id;
	public function __construct($POS,$FUNC) {
		$this->PostData = $POS;

		//ポストを受け取っているか
		if(empty($this->PostData)){
			exit;
		}
		//セッションを取得
		if(!isset($_SESSION)){
			session_start();
		}
		$this->s_user_id = $_SESSION['user'];

		//DBとの接続
		$dsn = 'mysql:dbname=Twitter;host=localhost';
		$user = "develop";
		$password = "welcomeMySQL";

		try{
			$this->pdo = new PDO($dsn, $user, $password);
			$this->pdo->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
			$this->pdo->query('SET NAMES utf8');
		} catch(PDOException $e){
			exit;
		}
		switch($FUNC){
			case "resistEmail":
				$this->resistEmail();
			break;

			case "registConfirm":
				$this->resistConfirm();
			break;
			case "resistUser":
				$this->resistUser();
			break;
		}
	}
	private function resistUser(){
		$userId = $this->PostData['input_userid'];
		$userPass = $this->PostData['input_password'];
		$userEmail = $this->PostData['input_email'];
		$userToken = $this->PostData['input_token'];

		require_once('../../baseDB/connect_db.php');
		$stmt = $pdo -> prepare("SELECT user_id FROM user_data WHERE user_id = ?");
		$stmt-> bindValue(1, $userId, PDO::PARAM_STR);
		$stmt-> execute();

		if($stmt->rowCount() > 0 ) { //ユーザーIDが存在
			array_push($this->error,"このユーザーIDはすでに登録されています。");
		}

		$stmt = $pdo -> prepare("SELECT * FROM user_data WHERE user_token_id = ? AND user_mail = ?");
		$stmt-> bindValue(1, $userToken, PDO::PARAM_STR);
		$stmt-> bindValue(2, $userEmail, PDO::PARAM_STR);
		$stmt-> execute();

		if($stmt->rowCount() == 0 ) { //ユーザーIDが存在
			array_push($this->error,"メールアドレスとプレIDが一致しない。不正なことスナ！");
		}

		if(count($this->error) == 0) {
			mysql_query("begin");
			$data = 'yutakikuchi';
			$userPass = hash( 'sha256', $userPass) . "\n";
			//$stmt = $pdo -> prepare("INSERT IGNORE INTO user_data(user_id,user_pass,user_mail)VALUES(:user_id, :user_pass, :user_email)");
			$stmt = $pdo -> prepare("UPDATE user_data SET user_id = :user_id, user_pass = :user_pass, user_mail = :user_email WHERE user_token_id = :user_token");
			$stmt-> bindValue(':user_id', $userId, PDO::PARAM_STR);
			$stmt-> bindValue(':user_pass', $userPass, PDO::PARAM_STR);
			$stmt-> bindValue(':user_email', $userEmail, PDO::PARAM_STR);
			$stmt-> bindValue(':user_token', $userToken, PDO::PARAM_STR);
			$result = $stmt-> execute();
			if($result){  //登録完了
				error_log("ID登録完了",0);
			}
			else {	//データベースへの登録作業失敗
				mysql_query("rollback");
				array_push($this->error, "データベースに登録できませんでした。");
		  }
		}
		if(count($this->error) == 0) {
	?>

	<head>
		<link rel="stylesheet" type="text/css" href="../../CSS/main.css">
		<meta charset="utf-8">
	</head>
	<!--ヘッダー-->
	<div class="flex-container-noheight">
		<div class="flex-item3">
			<div class="m-title">
				THANK U
			</div>
		</div>
	</div>

	<div class="flex-container-center">
		<!--ツイートメイン-->
		<div class="flex-item-center">
			<div class="flex-container-center">
				<form action="../php/login.php" method="post" class="flex-formReSize">
						<div>登録ありがとうございます。</div>
						<div>
							<a href="../../html/login.html">ログイン画面へ</a>
						</div>
				</form>
			</div>
		</div>
	</div>

	<?php
		}
		else {
	?>
		<div class="item">Error：</div>
		<div>
	<?php
			foreach($this->error as $value) {
				print $value;
	?>
		</div>
	<?php
			}
		}


	}



	private function resistConfirm(){
		$userId = $this->PostData['input_user_id'];
		$userName = $this->PostData['input_user_name'];
		$userPass = $this->PostData['input_password'];
		$userPass_r = $this->PostData['input_password_r'];
		$userEmail = $this->PostData['input_email'];
		$userToken = $this->PostData['pre_userid'];

		//パスチェック.強化の必要あり
		if(strlen($userPass) < 6 || strlen($userPass) > 40) {
			array_push($this->error,"パスワードの文字数が足りません");
		}
		if($userId == $userPass){
			array_push($this->error,"パスワードとIDを同じ値にしてはいけません");
		}
		if($userPass_r != $userPass){
			array_push($this->error,"パスワードがずれています");
		}
	?>
	<div>
	<?php
		if(count($this->error) > 0) {
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
				<form method="post" action="./DAO.php" class="flex-formReSize">
					<table>
						<caption>入力情報確認ページ</caption>
							<input type="hidden" name="action" value="Resist-resistUser">

							<input type="hidden" name="input_token" value="<?php print $userToken;?>">
							<input type="hidden" name="input_password" value="<?php print $userPass;?>">
						<tr>
							<td class="item">ユーザーID：</td>
							<td>
								<?php print $userId;?>
								<input type="hidden" name="input_userid" value="<?php print $userId;?>">
							</td>
						</tr>
						<tr>
							<td class="item">メールアドレス：</td>
							<td><?php print $userEmail;?><input type="hidden" name="input_email" value="<?php print $userEmail;?>"></td>
						</tr>
					</table>
					<div>
						<input type="submit" value=" 登 録 ">
					</div>
				</form>
			</div>
		</div>
	</div>

	<?php
		}

	}

	private function resistEmail() {
		$email = $this->PostData['email'];
		if (preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $email)) {
		}
		else{
			array_push($this->error,"ただいいメールアドレスを入力してください");
		}

		if(empty($email)){
			array_push($this->error,"addressが入力されていません");
			error_log("アドレスが入力されていません");
		}
		else{
			//仮のユーザーID作成
			$pre_user_id = uniqid("", true);
			$stmt = $this->pdo -> prepare("INSERT INTO user_data(user_token_id,user_mail)VALUES(:user_token_id,:user_email)");
			$stmt-> bindValue(':user_token_id', $pre_user_id, PDO::PARAM_STR);
			$stmt-> bindValue(':user_email', $email, PDO::PARAM_STR);
			$stmt->execute();
			$result = $stmt->fetchAll();
			$resultJson = json_encode($result);
			if($stmt == false){
				array_push($this->error,"仮ID登録できず");
			}
		}

		if(count($this->error)){
			for ($i = 0 ; $i < count($this->error); $i++) {
				echo("addressを正しく入力してください");
			}
		}
		else{
			echo("<a href='../php/register/regist_form.php?pre_userid=".$pre_user_id."'>ユーザー本登録へ</a>") ;
		}
	}
}
