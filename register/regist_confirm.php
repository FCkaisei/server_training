<?php
$error = array();
$formList = array('mode','pre_userid','input_userid','input_password','input_name','input_email');
$requireList = array('mode','input_userid','input_password','input_name');

foreach($formList as $value) {
  $$value = $_POST[$value];
}

/* 必須項目入力チェック */
foreach($requireList as $value) {
	if($$value == "") {
		array_push($error,"入力データが足りません");
		break;
	}
}

/* パスワードチェック */
if(strlen($input_password) < 6 || strlen($input_password) > 16) {
  array_push($error,"pass 6-16");
}
?>
<div>
<?php
if(count($error) > 0) {
	?>
</div>
<?php
}else {
	?>
<form method="post" action="./user_regist.php">
  <table>
    <caption>入力情報確認ページ</caption>
    <tr>
      <td class="item">ユーザー名：</td>
      <td><?php print $input_userid;?><input type="hidden" name="input_userid" value="<?php print $input_userid;?>"></td>
    </tr>
    <tr>
      <td class="item">パスワード：</td>
      <td><?php print $input_password;?><input type="hidden" name="input_password" value="<?php print $input_password;?>"></td>
    </tr>
    <tr>
      <td class="item">名前：</td>
      <td><?php print $input_name;?><input type="hidden" name="input_name" value="<?php print $input_name;?>"></td>
    </tr>
    <tr>
      <td class="item">メールアドレス：</td>
      <td><?php print $input_email;?><input type="hidden" name="input_email" value="<?php print $input_email;?>"></td>
    </tr>
  </table>
  <div><input type="submit" value=" 登 録 "></div>
</form>
<?php
}
?>
