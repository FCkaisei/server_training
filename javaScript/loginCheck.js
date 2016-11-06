var req2 = new XMLHttpRequest();

function execPost() {
	var userIdValue = document.getElementById('userId').value;
	var userPassValue = document.getElementById('userPass').value;
	var userData = userIdValue;
	var param = "user_data="+userData;
	req2.open('POST', '../php/idCheck.php', true);
	req2.setRequestHeader( 'Content-Type', 'application/x-www-form-urlencoded' );
	req2.send(param);
}
