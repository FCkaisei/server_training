var req = new XMLHttpRequest();
var callBack = function(tex) {
	if(!tex){
	}
	else{
		var tweetBox = document.getElementById("res");
		tweetBox.innerHTML = "";
			tweetBox.innerHTML += tex;
	}
}

req.onreadystatechange = function() {
	StateChange(req,callBack);
}

function execPost() {
	var textBoxValue = document.getElementById('mail_address').value;
	var param = "action=Resist-registEmail&email="+textBoxValue;
	req.open('POST', '../php/ResistDAO.php', true);
	// POST 送信の場合は Content-Type は固定.
	req.setRequestHeader( 'Content-Type', 'application/x-www-form-urlencoded' );
	req.send(param);
}
