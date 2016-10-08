<?php
require_once('../chromephp/ChromePhp.php');
ChromePhp::Log('include');

/* 登録処理（終了を知らせる値）によって読み込むファイルを変える */
$mode = $_POST["mode"];
ChromePhp::Log($mode);

switch($mode) {
  // メールアドレスの登録と仮ID送信
  case"email_regist":
  $module = "email_regist.php";
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
