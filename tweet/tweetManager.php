<?php
require_once "../debug/debug.php";
require_once('../chromephp/ChromePhp.php');
DisplayErrorMessage();
session_start();
if(!isset($_SESSION['user'])){
    $userid = $_SESSION['user'];
}

/* 登録処理（終了を知らせる値）によって読み込むファイルを変える */
$mode = $_POST["mode"];

switch($mode) {
  // メールアドレスの登録と仮ID送信
  case"tweet_regist":
  $module = "tweet_regist.php";
  break;

  case "user_search":
  $module = "../follows/follow.php";
  break;

  case "user_follow":
  $module = "../follows/followEnd.php";
  break;
  //メールアドレス登録（初期画面）
  default:
  $module = "tweet_form.php";
  break;
}
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>つぶやき画面</title>
	</head>
	<body>
	<?php
	  //別のPHPファイルを読み込む（Singleton)
	  require_once($module);
	?>
	</body>
</html>
