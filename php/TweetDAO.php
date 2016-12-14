<?php
	class TweetDAO {
		private $PostData;
		private $error = array();
		private $pdo;
		private $s_user_id;
		public function __construct($POS,$FUNC) {
			error_log("入って入る",0);
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

				case "setTweet":
					$this->setTweet();
				break;

				case "getLimit":
					$this->getLimit();
				break;

				case "getFollowUser":
					$this->getFollowUser();
				break;

				case "setImage":
					$this->setImage();
				break;

				case "Login":
					$this->Login();
				break;
				case "getUserSearch":
					$this->getUserSearch();
				break;
				case "setUnFollowUser":
					$this->setUnFollowUser();
				break;

				case "setFollowUser":
					$this->setFollowUser();
				break;
			}
		}

		private function getTweet() {
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
			//ツイートを取得
		    private function setTweet() {
		        $tweet_text      = $this->PostData['tweet_text'];
		        if (empty($tweet_text)) {
		            array_push($this->error, 'ツイートを入力しよう！');
		        } else {
		            $now  = date('Y-m-d H:i:s');
		            $stmt = $this->pdo->prepare('INSERT INTO tweet_data(user_id,user_tweet,user_tweet_time)VALUES(:user_id, :tweet_text, :timer)');
		            $stmt->bindValue(':user_id', $this->s_user_id, PDO::PARAM_STR);
		            $stmt->bindValue(':tweet_text', $tweet_text, PDO::PARAM_STR);
		            $stmt->bindValue(':timer', $now, PDO::PARAM_STR);
		            $stmt->execute();
		            if ($stmt == false) {
		                array_push($this->error, 'DBとの接続失敗');
		            }
		        }
				if ($this->error) {
					for ($i = 0; $i < count($this->error); ++$i) {
						error_log('ERROR:'.$this->error, 0);
					}
				}
			}

	        private function getLimit() {
	            $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM tweet_data WHERE user_id IN (SELECT user_follow_id FROM follow_data WHERE user_id LIKE ?) ORDER BY user_tweet_time DESC');
	            $stmt->bindValue(1, $this->s_user_id, PDO::PARAM_STR);
	            $stmt->execute();
	            $result     = $stmt->fetchAll();
	            $resultJson = json_encode($result);
	            if ($stmt == false) {
	                array_push($this->error,'SQL ミスってるよ');
				}
				if(!empty($this->error)){
					for ($i = 0; $i < count($this->error); ++$i) {
						error_log('ERROR:'.$this->error, 0);
					}
				} else {
	                echo $resultJson;
	            }
	        }

	        private function getFollowUser() {
	            $stmt = $this->pdo->prepare(
	                'SELECT follow_data.user_follow_id, user_data.img_base
					FROM follow_data
					INNER JOIN user_data
					ON follow_data.user_follow_id = user_data.user_id
					WHERE follow_data.user_id LIKE ?'
	            );
	            $stmt->bindValue(1, $this->s_user_id, PDO::PARAM_STR);
	            $stmt->execute();
	            $result     = $stmt->fetchAll();
	            $resultJson = json_encode($result);
	            echo $resultJson;
	        }

	        private function setFollowUser() {
	            session_start();
	            $follow_id = $this->PostData['user_id'];
	            $stmt = $this->pdo->prepare('INSERT INTO follow_data(user_id,user_follow_id)VALUES(:user_id,:follow_id)');
	            $stmt->bindValue(':user_id', $this->s_user_id, PDO::PARAM_STR);
	            $stmt->bindValue(':follow_id', $follow_id, PDO::PARAM_STR);
	            $stmt->execute();
	            if ($stmt == false) {
	                error_log('フォローできませんでした', 0);
	            }
	        }

	        private function setUnFollowUser() {
	            $otherId         = $this->PostData['unfollow_id'];
	            $stmt = $this->pdo->prepare('DELETE FROM follow_data WHERE user_id=? AND user_follow_id=?');
	            $stmt->bindValue(1, $this->s_user_id, PDO::PARAM_STR);
	            $stmt->bindValue(2, $otherId, PDO::PARAM_STR);
	            $stmt->execute();
	            if ($stmt == false) {
	                error_log('UnFollowに失敗しました', 0);
	            } else {
	                error_log('フォローに成功しました', 0);
	            }
	        }

	        private function getUserSearch() {
	            if (empty($this->s_user_id)) {
	                array_push($this->error, 'セッション切れ');
	            }
	            $othersId = $this->PostData['others_id'];
	            if (empty($this->PostData)) {
	                array_push($this->error, 'others_idが入力されていません');
	            }
	                // 拡張子によってMIMEタイプを切り替えるための配列
	            $MIMETypes = array(
	               'png' => 'image/png',
	               'jpg' => 'image/jpeg',
	               'jpeg' => 'image/jpeg',
	               'gif' => 'image/gif',
	               'bmp' => 'image/bmp',
	            );

	            $stmt = $this->pdo->prepare('SELECT user_id,img_base,mime FROM user_data WHERE user_id LIKE ? AND user_id NOT IN (SELECT user_follow_id FROM follow_data WHERE user_id LIKE ?)');
	            $stmt->bindValue(1, '%'.$othersId.'%', PDO::PARAM_STR);
	            $stmt->bindValue(2, $this->s_user_id, PDO::PARAM_STR);
	            $stmt->execute();
	            $result = $stmt->fetchAll();
	            //header('Content-type: '.$MIMETypes[$result['mime']]);

	            $resultJson = json_encode($result);
	            echo $resultJson;
	        }

	        private function Login() {
				error_log("LOGIN",0);
	            $user_id   = $this->PostData['formUserid'];
	            $user_pass = $this->PostData['formPassword'];
				//入力されたパスワードをハッシュ化
	            $user_pass = hash('sha256', $user_pass)."\n";
	            if (empty($user_id) || empty($user_pass)) {
	                error_log('IDもしくはパスワードが未入力です', 0);
	                header('Location: ../html/login.html');
	                exit;
	            } else {
	                error_log('user_idとuser_passが入力されています', 0);
	                try {
	                    $this->pdo->query('SET NAMES utf8');
	                } catch (PDOException $e) {
	                    error_log('tuusin_sippai', 0);
	                    header('Location: ../html/login.html');
	                    exit;
	                }

	                $sql = 'select * from user_data';
	                $sth = $this->pdo->prepare($sql);
	                $sth->execute();
	                $sqlResult = $sth->fetchAll();

	                foreach ($sqlResult as $data) {
	                    if ($data['user_id'] == $user_id) {
	                        $dbPassword = $data['user_pass'];
	                        error_log($dbPassword, 0);
	                        error_log($user_pass, 0);
	                        break;
	                    }
	                }

	                if (!isset($dbPassword)) {
	                    error_log('not get DBPass', 0);
	                    header('Location: ../html/login.html');
	                    exit;
	                    error(2);
	                } else {
	                    if ($dbPassword != $user_pass) {
	                        error_log('dbPass huitti', 0);
	                        header('Location: ../html/login.html');
	                        exit;
	                    } else {
	                        error_log('kokomadekiteru', 0);

	                        session_start();
	                        $_SESSION['user'] = $user_id;
	                        header('Location: ../html/tweet_main.html');
	                        exit;
	                    }
	                }
	            }
	        }

	        private function setImage() {
	            $fp     = fopen($_FILES['image']['tmp_name'], 'rb');
	            $imgdat = fread($fp, filesize($_FILES['image']['tmp_name']));
	            fclose($fp);
	            $imgdat = addslashes($imgdat);
	            // 拡張子
	            $dat       = pathinfo($_FILES['image']['name']);
	            $extension = $dat['extension'];
	            // MIMEタイプ
	            if ($extension == 'jpg' || $extension == 'jpeg') {
	                $mime = 'image/jpeg';
	            } elseif ($extension == 'gif') {
	            $mime = 'image/gif';
	            } elseif ($extension == 'png') {
	                $mime = 'image/png';
	            }
	            $img_base64 = base64_encode(file_get_contents($_FILES['image']['tmp_name']));
	            $stmt = $this->pdo->prepare('UPDATE user_data SET img_base = :user_img, mime = :mime WHERE user_id = :user_id');
	            $stmt->bindValue(':user_img', $img_base64, PDO::PARAM_STR);
	            $stmt->bindValue(':mime', $mime, PDO::PARAM_STR);
	            $stmt->bindValue(':user_id', $this->s_user_id, PDO::PARAM_STR);
	            $stmt->execute();
	?>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="../CSS/main.css">
		<meta http-equiv="Content-Script-Type" content="text/javascript">
	</head>
	<body link="rgb(175,175,175)" alink="rgb(175,175,175)" vlink="rgb(175,175,175)">
	<!--ヘッダー-->
		<div class="flex-container-noheight">
			<div class="flex-item3">
				<div class="m-title">
					プロ画登録
				</div>
			</div>
		</div>
	<!--サイドバーとつぶやきメイン-->
		<div class="flex-container">
			<!--サイドバー-->
			<div class="flex-item">
				<div class="flex-container-column">
					<div class="flex-item">
						<a href="../html/tweet_main.html"><div class="menuBottan">画像編集</div></a>
					</div>
					<div class="flex-item">
						<a href="../html/follow_main.html"><div class="menuBottan">みつける</div></a>
					</div>
					<div class="flex-item">
						<a href="../html/follow_otheres.html"><div class="menuBottan">フォロー</div></a>
					</div>
					<div class="flex-item">
						<a href="../html/Profile.html"><div class="menuBottan">画像変更</div></a>
					</div>
					<div class="flex-item">
						<a href="./login.html"><div class="menuBottan">LOGOUT</div></a>
					</div>
				</div>
			</div>
	<?PHP
	                if ($stmt == false) {
	                    ?>
			<!--ツイートメイン-->
			<div class="flex-item2">
				画像を登録できませんでした。。。
			</div>
	<?PHP

	                } else {
	                    ?>
			<div class="flex-item2">
				画像登録完了！
			</div>
	<?PHP
	                    error_log('----------------GOOD! follow QED-----------------', 0);
	                }
	                ?>
		</div>
	</body>
	<?PHP
	        }
	}
?>
