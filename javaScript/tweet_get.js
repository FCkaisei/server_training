var req = new XMLHttpRequest();
var req2 = new XMLHttpRequest();
var pageMax = 0;
var pageCount = 1;
var now_loading = true;
window.onload = function(){
	getTweet();
	getLimit();
	now_loading = false;
};



var callBack2 = function(tex) {
	if(!tex){
	}
	else{
		var jsonObject = JSON.parse(tex);
		console.log(jsonObject);
		pageMax = jsonObject[0][0];
		//カウント数だけボタンを作る。１，２，３，４，５，６
		console.log(pageMax);
		var page_list = document.getElementById("page_list");
		page_list.innerHTML = "";
		pageMax = pageMax/5;
		for(var i = 1; i < pageMax; i++){
			var buttonElement = document.createElement("button");
			var buttonText = document.createTextNode(i);
			buttonElement.appendChild(buttonText);
			buttonElement.onclick = get_bTweet;
			buttonElement.setAttribute("data-pageNumber",i);

			page_list.appendChild(buttonElement);
		}
	}
	now_loading = false;
}

var callBack = function(tex) {
	if(!tex){
		getTweet()
	}
	else{
		var jsonObject = JSON.parse(tex);
		console.log(jsonObject);

		var tweetBox = document.getElementById("tweet");
		tweetBox.innerHTML = "";
		for(var i = 0; i < jsonObject.length; i++){
			//受け取ったバイナリデータをほげほげしたい

			var div_title = document.createElement('div');
			div_title.className = "title";

			var div_mainBox = document.createElement('div');
			div_mainBox.className = "mainBox";

			var div = document.createElement('div');


			var div_chat_box = document.createElement('div');
			div_chat_box.className = "chat-box";


			var div_chat_face = document.createElement('div');
			div_chat_face.className = "chat-face";





			var div_imge = document.createElement('img');
			if(!jsonObject[i]['img_base']){
				div_imge.setAttribute("src","../CSS/bg_1.jpg");
			}
			else{
				div_imge.setAttribute("src","data:image/"+jsonObject[i]['mime']+";base64,"+jsonObject[i]['img_base']);
			}
			div_imge.setAttribute("width","90");
			div_imge.setAttribute("height","90");

			 var div_chat_area = document.createElement('div');
			 div_chat_area.className = "chat-area";

			 var div_chat_hukidashi = document.createElement('div');
			 div_chat_hukidashi.className = "chat-hukidashi someone";
			 var user_id = document.createElement('div');
			 var user_id_div = document.createTextNode(jsonObject[i]["user_id"]);
			 user_id.appendChild(user_id_div);
			 var user_tweet = document.createElement('div');
			 var user_tweet_div = document.createTextNode(jsonObject[i]["user_tweet"]);
			 user_tweet.appendChild(user_tweet_div);

			 div_chat_hukidashi.appendChild(user_id);
			 div_chat_hukidashi.appendChild(user_tweet);

			 div_chat_area.appendChild(div_chat_hukidashi);

			 div_chat_face.appendChild(div_imge);

			 div_chat_box.appendChild(div_chat_face);
			 div_chat_box.appendChild(div_chat_area);

			 div.appendChild(div_chat_box);
			 div_mainBox.appendChild(div);
			 div_title.appendChild(div_mainBox);
			 tweetBox.appendChild(div_title);
		}
	}
	document.getElementsByClassName("m-title").innerHTML = "OK";

}

req.onreadystatechange = function() {
	document.getElementsByClassName("m-title").innerHTML = "LOADING";
	StateChange(req,callBack);
}

req2.onreadystatechange = function() {
	now_loading = true;
	document.getElementsByClassName("m-title").innerHTML = "LOADING";
	StateChange(req2,callBack2);
}

function execPost() {
	if(now_loading ==false){
		var textBoxValue = document.getElementById('tweetText').value;
		var param = "action=setTweet&tweet_text="+textBoxValue;
		document.getElementById('tweetText').value = "";
		req.open('POST', '../php/DAO.php', true);
		// POST 送信の場合は Content-Type は固定.
		req.setRequestHeader( 'Content-Type', 'application/x-www-form-urlencoded' );
		req.send(param);
	}
}

function getTweet(){
		var page = "action=getTweet&page="+pageCount;
		req.open('POST', '../php/DAO.php', true);
		req.setRequestHeader( 'Content-Type', 'application/x-www-form-urlencoded' );
		req.send(page);
}

function get_bTweet(){
	if(now_loading ==false){
		pageCount = this.getAttribute("data-pageNumber");
		var page = "page="+pageCount;
		req.open('POST', '../php/tweet_get.php', true);
		req.setRequestHeader( 'Content-Type', 'application/x-www-form-urlencoded' );
		req.send(page);
	}
}

function getLimit(){
	req2.open('POST', '../php/limit_get.php', true);
	req2.setRequestHeader( 'Content-Type', 'application/x-www-form-urlencoded' );
	req2.send(null);
}
