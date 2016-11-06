var req = new XMLHttpRequest();
//idとpass送信
function execPost() {
	var userIdValue = document.getElementById('userId').value;
	var userPassValue = document.getElementById('userPass').value;
	var param = "user_id="+userIdValue+"user_pass"+userPassValue;
	req.open('POST', '../php/idCheck.php', true);
	req.setRequestHeader( 'Content-Type', 'application/x-www-form-urlencoded' );
	req.send(param);
}
