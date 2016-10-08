<form action="tweetManager.php" method="post">
    <input type="hidden" name="mode" value="tweet_regist">
    <table>
        <caption>ツイート登録フォーム</caption>
        <tr>
            <td class="item">ツイート内容：</td>
            <td><input type="text" name="tweet_text" size="40"></td>
        </tr>
    </table>
    <div><input type="submit" name="submit" value="送信"></div>
</form>

<?php
echo($_SESSION['user']);

$tmpSess = $_SESSION['user'];
require_once("../baseDB/connect_db.php");
$query = "SELECT * FROM tweets WHERE user_id = '".$tmpSess."'";
$result = mysql_query($query);

while($data = mysql_fetch_array($result)){
    echo "<TR>";

      //列１を出力//////////////
      echo "<TD>" . $data[0];
      echo "</TD>";
      //////////////////////////

      //列２を出力//////////////
      echo "<TD>" . $data[1];
      echo "</TD>";
      echo "<TD>" . $data[2];
      echo "</TD>";
      echo "<TD>" . $data[3];
      echo "</TD>";
      //////////////////////////

  echo "</TR>";
}

//$query = "select * from tweets where user_id = '".$tmpSess."'";

 ?>
