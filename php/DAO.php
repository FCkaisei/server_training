<?php

$action = $_POST["action"];
$dao = new DAO();

switch($action){
	case "setTweet":
		$dao->setTweet();
	break;
}

	class DAO{
		function __construct(){
		}

		public function setTweet(){
			require_once("../baseDB/connect_db.php");
			session_start();
			$session_user_id = $_SESSION['user'];
			$tweet_text = $_POST["tweet_text"];
			$error = array();
			if($tweet_text == ""){
				array_push($error, "ツイートを入力しよう！");
			} else{
				$now = date('Y-m-d H:i:s');
				$stmt = $pdo->prepare("INSERT INTO tweet_data(user_id,user_tweet,user_tweet_time)VALUES(:user_id, :tweet_text, :timer)");
				$stmt->bindValue(':user_id',$session_user_id, PDO::PARAM_STR);
				$stmt->bindValue(':tweet_text', $tweet_text, PDO::PARAM_STR);
				$stmt->bindValue(':timer', $now, PDO::PARAM_STR);
				$stmt->execute();
				if($stmt == false){
					array_push($error, "DBとの接続失敗");
				}
				else{
				}
			}
			if($error){
				for ($i = 0 ; $i < count($error); $i++) {
					error_log("ERROR:".$error,0);
				}
			}

		}


	}
 ?>
