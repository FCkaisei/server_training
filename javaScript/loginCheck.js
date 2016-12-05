var req = new XMLHttpRequest();
var callBack = function(tex) {
}

req.onreadystatechange = function() {
	StateChange(req,callBack);
}

function execPost() {
	var userIdValue = document.getElementById('userId').value;
	var userPassValue = document.getElementById('userPass').value;
	var param = "user_data="+userIdValue;
	req.open('POST', '../php/login.php',true);
	req.setRequestHeader( 'Content-Type', 'application/x-www-form-urlencoded' );
	req.send(param);
}
