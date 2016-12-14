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
			case "registEmail":
				$this->registEmail();
			break;
		}
	}

	private function registEmail() {
		$email = $this->$PostData['email'];
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
