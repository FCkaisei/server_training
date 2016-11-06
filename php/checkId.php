<?php
ini_set("display_errors", On);
error_reporting(E_ALL);
if(!isset($_POST['login'])) {
  //ログインフォームを表示
  inputForm();
}
else {
  //フォームの値を取得
  $formUserId = $_POST['formUserid'];
  $formPassword = $_POST['formPassword'];
  //ID, PASWORDが未入力の場合
  if(($formUserId == "") || ($formPassword == "")) {
	  //エラー関数の呼び出し
	  error(1);
  }
  else {
  //ID,PASSWORD 入力アリ
  //データベースへ接続
  require_once("baseDB/connect_db.php");

  $dsn = 'mysql:dbname=UserLoginDB;host=localhost';
  $user = "root";
  $password = "";
try{
  $pdo = new PDO($dsn, $user, $password);
  print("DB->PDO接続成功");
  $pdo->query('SET NAMES utf8');
}
catch(PDOException $e){
  print('ERROR:'.$e->getMessage());
  die();
}
$sql = "select * from members";
$sth = $pdo->prepare($sql);
$sth->execute();
$sqlResult = $sth->fetchAll();
//フォームから取得したUSERIDとデータベース内のUSERIDが一致したらデータベースのPASSWORDを変数に格納
foreach($sqlResult as $data){
      if($data['userid'] == $formUserId) {  //フォームから取得したUSERIDとデータベースのUSERIDが一致
          $dbPassword = $data['password'];
      break;
    }
  }

  //$dbPasswordという変数に値が格納されていない場合→formUserIdとデータベースのIDが不一致
  if(!isset($dbPassword)){
    error(2);
  }else {
  //formUserIdとデータベースのIDが一致
  //フォームのパスワードとデータベース内のパスワードが不一致
    if($dbPassword != $formPassword){
	  error(3);
	} else {
	  //ID,パスワードどちらも一致
      //セッション作成
      session_start();
      //セッション変数を作成→セッション変数に　$formUserID を登録
	  $_SESSION['user'] = "aaaaaa";
	  header("Location:./html/tweet_main.html");
      exit();
	  }
	}
  }
}
?>
<?php
  //入力画面表示画面
  function inputForm() {
?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>ログイン</title>
	</head>
	<body>
  		<h1>WELCOM_イケメンクラブ</h1>
		<h2>ログインしてください</h2>
  		<form action="login.php" method="post">
	  		<label for="userid">ユーザーID</label>：
	  		<input type="text" name="formUserid" id="userid"/>
	  		<br>
	  		<label for="password">パスワード</label>：
	  		<input type="text" name="formPassword" id="password"/>
	  		<br>
	  		<input type="submit" name="login" value="ログイン" />
		</form>

		<input type="button" value="登録画面へ" onclick="location.href='http://ec2-54-245-28-75.us-west-2.compute.amazonaws.com/server_training/register/registerManager.php'">
	</body>
</html>

<?php
}

//エラー表示関数
function error($errorType) {
  switch($errorType) {
    case 1:
    $errorMsg = "IDとパスワードを入力してください。";
    break;

    case 2:
    $errorMsg = "IDが違います";
    break;

    case 3:
    $errorMsg = "パスワードが違います";
    break;
}
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>ログイン</title>
	</head>
	<body>
		<h1>エラーページ</h1>
		<?php
  		print $errorMsg;
		?>
	</body>
</html>
<?php
}
?>
