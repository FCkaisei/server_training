<form action="../tweet/tweetManager.php" method="post">
    <input type="hidden" name="mode" value="user_follow">
    <table>
        <caption>ユーザー検索</caption>
        <tr>
            <td class="item">ユーザー名</td>
            <td><input type="text" name="user_id" size="40"></td>
        </tr>
    </table>
    <div><input type="submit" name="submit" value="登録"></div>
</form>


<?php
// メールアドレス取得
$user_id = $_POST["user_id"];


require_once("../baseDB/connect_db.php");
//$sql = "SELECT * FROM tweets WHERE user_id = :id ORDER BY id DESC";
$stmt = $pdo->prepare("SELECT * FROM members WHERE user_id = ? ORDER BY id DESC");

$stmt->bindValue(1, $user_id, PDO::PARAM_STR);
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
    echo "<td>";

}
 ?>
 </table>
