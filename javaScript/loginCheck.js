var req = new XMLHttpRequest();

//idとpass送信
function execPost() {
	var userIdValue = document.getElementById('userId').value;
	var userPassValue = document.getElementById('userPass').value;
	var userData = [userIdValue,userPassValue];
	var param = "user_data="+userData;
	req.open('POST', '../php/idCheck.php', true);
	req.setRequestHeader( 'Content-Type', 'application/x-www-form-urlencoded' );
	req.send(param);
}
