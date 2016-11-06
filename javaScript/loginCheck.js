var req = new XMLHttpRequest();

//idとpass送信
function execPost() {
	var userIdValue = document.getElementById('userId').value;
	var userPassValue = document.getElementById('userPass').value;
	var userData = [userIdValue,userPassValue];
	var param = "user_data="+userData;
	req.open('POST', 'http://ec2-54-245-28-75.us-west-2.compute.amazonaws.com/server_training/php/idCheck.php', true);
	req.setRequestHeader( 'Content-Type', 'application/x-www-form-urlencoded' );
	req.send(param);
}
