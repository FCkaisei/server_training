<?php

echo($_SESSION['user']);
$tmpSess = $_SESSION['user'];
require_once("../baseDB/connect_db.php");
$stmt = $pdo->prepare("SELECT * FROM tweets WHERE user_id = ? ORDER BY id DESC");

$stmt->bindValue(1, $tmpSess, PDO::PARAM_STR);
$stmt->execute();
$result = $stmt->fetchAll();

$jsonResult = json_encode($result);
echo "document.write('" . $jsonResult . "');";
?>