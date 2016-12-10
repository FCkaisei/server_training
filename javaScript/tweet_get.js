var req = new XMLHttpRequest();
window.onload = function(){
	getTweet();
};


var callBack = function(tex) {

	if(!tex){
		getTweet()
	}
	else{
	  	console.log(jsonObject);
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
 			 var user_tweet = document.createTextNode(jsonObject[i]["user_tweet"]);


			 div_chat_hukidashi.appendChild(user_id);
			 div_chat_hukidashi.appendChild(user_tweet);

			 div_chat_area.appendChild(div_chat_hukidashi);

			 div_chat_face.appendChild(div_img);

			 div_chat_box.appendChild(div_chat_face);
			 div_chat_box.appendChild(div_chat_area);

			 div.appendChild(div_chat_box);
			 div_mainBox.appendChild(div);
			 div_title.appendChild(div_mainBox);
			 tweetBox.appendChild(div_title);



			//tweetBox.innerHTML +=
			//
			// '<div class="title">'
			// +'<div class= "mainBox">'
			// +'<div>'
			// +'<div class="chat-box">'
			// +'<div class="chat-face">'
			// +'<img src="../CSS/bg_1.jpg" alt="誰かのチャット画像です。" width="90" height="90">'
			// +'</div>'
			// +'<div class="chat-area">'
			// +'<div class="chat-hukidashi someone">'
			// +jsonObject[i]['user_id']
			// +'<br>'
			// +jsonObject[i]['user_tweet']
			// +'</div>'
			// +'</div>'
			// +'</div>'
			// +'</div>'
			// +'</div>'
			// +'</div>'
		}
	}
}

req.onreadystatechange = function() {
	StateChange(req,callBack);
}

function execPost() {
	var textBoxValue = document.getElementById('tweetText').value;
	var param = "tweet_text="+textBoxValue;

	req.open('POST', '../php/tweet_post.php', true);
	// POST 送信の場合は Content-Type は固定.
	req.setRequestHeader( 'Content-Type', 'application/x-www-form-urlencoded' );
	req.send(param);
}

function getTweet(){
	var page = "page=1";
	req.open('POST', '../php/tweet_get.php', true);
	req.setRequestHeader( 'Content-Type', 'application/x-www-form-urlencoded' );
	req.send(page);
}
