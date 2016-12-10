window.onload = function(){
		getFollowUser();
};

var callBack = function(tex) {
	if(!tex){
		getFollowUser();
	}
	else{
		var jsonObject = JSON.parse(tex);
		console.log(jsonObject);
		var tweetBox = document.getElementById("tweet");
		tweetBox.innerHTML = "";
		for(var i = 0; i < jsonObject.length; i++){

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
			 var buttonText = document.createTextNode("アンフォロー");
			 buttonElement.appendChild(buttonText);
			 buttonElement.onclick = followOther;
			 buttonElement.setAttribute("data-userid",jsonObject[i]["user_follow_id"]);

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

function getFollowUser(){
	req.open('POST', '../php/follow_get.php', true);
	req.setRequestHeader( 'Content-Type', 'application/x-www-form-urlencoded' );
	req.send(null);
}

function followOther(){
	var other_id = this.getAttribute("data-userid");
	console.log(other_id);
	var textBoxValue = other_id;
	var param = "unfollow_id="+textBoxValue;
	req.open('POST', '../php/unfollow.php', true);
	req.setRequestHeader( 'Content-Type', 'application/x-www-form-urlencoded' );
	req.send(param);
}
