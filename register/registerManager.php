<?php
/* 登録処理（終了を知らせる値）によって読み込むファイルを変える */
$mode = $_POST["mode"];
if($_GET['pre_userid'] !="") {
  $mode = "regist_form";
}

switch($mode) {
	
  	case"email_regist":
		header('Location: ../php/email_regist.php');
    	exit;
	break;
	  //会員登録フォーム画面
	  case"regist_form":
		  header('Location: ../php/regist_form.php');
		  exit;
	  break;

	  //登録内容確認画面
	  case"regist_confirm":
	  	header('Location: ../php/regist_confirm.php');
	  	exit;
	  break;

	  //会員登録画面
	  case"user_regist":
	  $module = "user_regist.php";
	  header('Location: ../html/user_regist.php');
	  exit;
	  break;

	  //メールアドレス登録（初期画面）
	  default:
	  header('Location: ../html/email_form.html');
	  exit;
	  break;
}
?>
