<?php
	class TweetDAO {
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
				case "getTweet":
					$this->getTweet();
				break;
			}
		}

		public function getTweet() {
				$page    = $this->PostData['page'];
				if (empty($this->s_user_id)) {
					array_push($this->error,'user_idが入ってません');
				}
				if ($page == '') {
					$page = 1;
				}
				//ページが一より小さい場合は1
				$page    = max($page, 1);
				$lowLim  = $page * 4 - 4;
				$highLim = 5;
				$stmt    = $this->pdo->prepare('SELECT tweet_data.user_tweet, tweet_data.user_id,user_data.img_base FROM tweet_data INNER JOIN user_data ON tweet_data.user_id = user_data.user_id WHERE tweet_data.user_id = ? OR tweet_data.user_id IN (SELECT user_follow_id FROM follow_data WHERE user_id LIKE ?) ORDER BY user_tweet_time DESC LIMIT ?,?');
				$stmt->bindValue(1, $this->s_user_id, PDO::PARAM_STR);
				$stmt->bindValue(2, $this->s_user_id, PDO::PARAM_STR);
				$stmt->bindValue(3, $lowLim, PDO::PARAM_INT);
				$stmt->bindValue(4, $highLim, PDO::PARAM_INT);
				$stmt->execute();
				$result     = $stmt->fetchAll();
				$resultJson = json_encode($result);
				if ($stmt == false) {
					array_push($this->error, 'DBを操作できません');
				}
				if ($this->error) {
					for ($i = 0; $i < count($this->error); ++$i) {
						error_log('ERROR:'.$this->error[$i], 0);
					}
				} else {
					echo $resultJson;
				}
		}
	}
?>
