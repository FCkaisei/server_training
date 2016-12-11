var callBack = function(tex) {
	if(!tex){
		execPost();
	}
	else{
		console.log(tex);
		var jsonObject = JSON.parse(tex);
	  	console.log(jsonObject);
	  	var tweetBox = document.getElementById("tweet");
	  	tweetBox.innerHTML = "";
	  	for(var i = 0; i < jsonObject.length; i++){

			Base64ToImage(jsonObject[i]["img_base"], function(img) {
    			// <img>要素にすることで幅・高さがわかります
    			alert("w=" + img.width + " h=" + img.height);
    			document.getElementById('tweet').appendChild(img);
			});
			var div_title = document.createElement('div');
			div_title.className = "title";

			var div_mainBox = document.createElement('div');
			div_mainBox.className = "mainBox";

			var div = document.createElement('div');

			var div_chat_box = document.createElement('div');
			div_chat_box.className = "chat-box";


			var div_chat_face = document.createElement('div');
			div_chat_face.className = "chat-face";

			var div_img = document.createElement('img');
			 div_img.setAttribute("src", "../CSS/bg_1.jpg");
			 div_img.setAttribute("width","90");
			 div_img.setAttribute("height","90");


			 var div_chat_area = document.createElement('div');
			 div_chat_area.className = "chat-area";

			 var div_chat_hukidashi = document.createElement('div');
			 div_chat_hukidashi.className = "chat-hukidashi someone";

			 var user_id = document.createTextNode(jsonObject[i]["user_id"]);
			 var buttonElement = document.createElement("button");
			 var buttonText = document.createTextNode("フォロー");
			 buttonElement.appendChild(buttonText);
			 buttonElement.onclick = followOther;
			 buttonElement.setAttribute("data-userid",jsonObject[i]["user_id"]);

			 div_chat_hukidashi.appendChild(user_id);
			 div_chat_hukidashi.appendChild(buttonElement);

			 div_chat_area.appendChild(div_chat_hukidashi);

			 div_chat_face.appendChild(div_img);

			 div_chat_box.appendChild(div_chat_face);
			 div_chat_box.appendChild(div_chat_area);

			 div.appendChild(div_chat_box);
			 div_mainBox.appendChild(div);
			 div_title.appendChild(div_mainBox);
			 tweetBox.appendChild(div_title);
		}
	}
}

var req = new XMLHttpRequest();

req.onreadystatechange = function() {
	StateChange(req,callBack);
}

function execPost() {
	var textBoxValue = document.getElementById('others_id').value;
	var param = "others_id="+textBoxValue;
	req.open('POST', '../php/user_search.php', true);
	// POST 送信の場合は Content-Type は固定.
	req.setRequestHeader( 'Content-Type', 'application/x-www-form-urlencoded' );
	req.send(param);
}

function followOther(){
	var other_id = this.getAttribute("data-userid");
	console.log(other_id);
	var textBoxValue = other_id;
	var param = "user_id="+textBoxValue;
	req.open('POST', '../php/followEnd.php', true);
	// POST 送信の場合は Content-Type は固定.
	req.setRequestHeader( 'Content-Type', 'application/x-www-form-urlencoded' );
	req.send(param);
}

function Base64ToImage(base64img, callback) {
    var img = new Image();
    img.onload = function() {
        callback(img);
    };
    img.src = base64img;
}
