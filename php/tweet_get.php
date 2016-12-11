<?php
	require_once("../baseDB/connect_db.php");
	$error = array();
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


	//ツイート呼び出し
    //$stmt = $pdo->prepare('SELECT * FROM tweet_data WHERE user_id = ? OR user_id IN (SELECT user_follow_id FROM follow_data WHERE user_id LIKE ?) ORDER BY user_tweet_time DESC LIMIT ?,?');
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
	?>
