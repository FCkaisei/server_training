<?php
	ini_set("display_errors", On);
	error_reporting(E_ALL);
?>

<?php
	$error = array();
	$userId = $_POST['input_userid'];
	$userPass = $_POST['input_password'];
	$userEmail = $_POST['input_email'];

	//データ入力チェック
	if($userId == ""　|| $userPass == "" || $userEmail == ""){
		array_push($error, "入力データが不足");
	}

?>
