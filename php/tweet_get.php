<?php
echo($_SESSION['user']);

$tmpSess = $_SESSION['user'];
require_once("../baseDB/connect_db.php");
//$sql = "SELECT * FROM tweets WHERE user_id = :id ORDER BY id DESC";
$stmt = $pdo->prepare("SELECT * FROM tweets WHERE user_id = ? ORDER BY id DESC");

$stmt->bindValue(1, $tmpSess, PDO::PARAM_STR);
$stmt->execute();
$result = $stmt->fetchAll();
?>
<table>
        <caption>ツイート一覧</caption>
<?php
foreach($result as $data){
    echo "<tr>";
    echo "<td>" . $data[0];
    echo "</td>";
    echo "<td>" . $data[1];
    echo "</td>";
    echo "<td>" . $data[3];
    echo "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>ツイート内容:" . $data[2];
    echo "</td>";
    echo "</tr>";
}

//$query = "select * from tweets where user_id = '".$tmpSess."'";

 ?>
