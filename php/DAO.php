<?php

$action = $_POST["action"];
$Dao = new DAO();

switch($action){
	case "setTweet":
		$Dao->setTweet();
	break;
	case "getTweet":
		$Dao->getTweet();
	break;
	case "getLimit":
		$Dao->getLimit();
	break;
}

	class DAO{
		private $error = array();
		function __construct(){
		}

		public function setTweet(){
			require_once("../baseDB/connect_db.php");
			session_start();
			$session_user_id = $_SESSION['user'];
			$tweet_text = $_POST["tweet_text"];
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

		public function getTweet(){
			require_once("../baseDB/connect_db.php");
			session_start();
			$user_id = $_SESSION['user'];
			$page = $_POST['page'];
			if(empty($user_id)){
				array_push($error, "user_idが入ってません");
			}
			if ($page == '') {
				$page = 1;
			}
			//ページが一より小さい場合は1
			$page = max($page, 1);
			$lowLim  = $page * 4 - 4;
			$highLim = 5;
			$stmt = $pdo->prepare('SELECT tweet_data.user_tweet, tweet_data.user_id,user_data.img_base FROM tweet_data INNER JOIN user_data ON tweet_data.user_id = user_data.user_id WHERE tweet_data.user_id = ? OR tweet_data.user_id IN (SELECT user_follow_id FROM follow_data WHERE user_id LIKE ?) ORDER BY user_tweet_time DESC LIMIT ?,?');
			$stmt->bindValue(1, $user_id, PDO::PARAM_STR);
			$stmt->bindValue(2, $user_id, PDO::PARAM_STR);
			$stmt->bindValue(3, $lowLim, PDO::PARAM_INT);
			$stmt->bindValue(4, $highLim, PDO::PARAM_INT);
			$stmt->execute();
			$result = $stmt->fetchAll();
			$resultJson = json_encode($result);
			if ($stmt == false) {
				array_push($error, "DBを操作できません");
			}
			if($error){
				for ($i = 0 ; $i < count($error); $i++) {
					error_log("ERROR:".$error,0);
				}
			}
			else {
				echo $resultJson;
			}
		}

		public function getLimit(){
			session_start();
			$tmpSess = $_SESSION['user'];
			require_once("../baseDB/connect_db.php");
			$stmt = $pdo->prepare("SELECT COUNT(*) FROM tweet_data WHERE user_id IN (SELECT user_follow_id FROM follow_data WHERE user_id LIKE ?) ORDER BY user_tweet_time DESC");
			$stmt->bindValue(1, $tmpSess, PDO::PARAM_STR);
			$stmt->execute();
			$result = $stmt->fetchAll();
			$resultJson = json_encode($result);

			if($stmt == false){
				error_log("SQL ミスってるよ",0);
			}
			else{
				error_log("GOOD!",0);
					echo $resultJson;
			}
		}


	}
 ?>
