<?php
echo($_SESSION['user']);

#$tmpSess = $_SESSION['user'];
$tmpSess = "aaaaaa";
require_once("../baseDB/connect_db.php");
//$sql = "SELECT * FROM tweets WHERE user_id = :id ORDER BY id DESC";
$stmt = $pdo->prepare("SELECT * FROM tweets WHERE user_id = ? ORDER BY id DESC");

$stmt->bindValue(1, $tmpSess, PDO::PARAM_STR);
$stmt->execute();
$result = $stmt->fetchAll();
$resultJson = json_encode($result);
$array = array();
foreach($result as $data){
	$tmpArray = array();

	$tmpArray['id'] = $data[0];
	array_push($array, $tmpArray);
}

echo $array;

 ?>
