var callBack = function(tex) {
	if(!tex){
		execPost();
	} else{
		var jsonObject = JSON.parse(tex);
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
			var imge = document.createElement('img');

			if(!jsonObject[i]['img_base']){
				imge.setAttribute("src","../CSS/bg_1.jpg");
			}
			else{
				imge.setAttribute("src","data:image/"+jsonObject[i]['mime']+";base64,"+jsonObject[i]['img_base']);
			}
			imge.setAttribute("width","90");
			imge.setAttribute("height","90");

			 var div_chat_area = document.createElement('div');
			 div_chat_area.className = "chat-area";

			 var div_chat_hukidashi = document.createElement('div');
			 div_chat_hukidashi.className = "chat-hukidashi someone";
			 var user_id = document.createElement('div');
			 var user_id_div = document.createTextNode(jsonObject[i]["user_id"]);
			 user_id.appendChild(user_id_div);

			 var buttonElement = document.createElement('div');
			 var buttonElement_div = document.createElement("button");
			 var buttonText = document.createTextNode("フォロー");
			 buttonElement_div.appendChild(buttonText);
			 buttonElement_div.onclick = followOther;
			 buttonElement_div.setAttribute("data-userid",jsonObject[i]["user_id"]);
			 buttonElement.appendChild(buttonElement_div);
			 div_chat_hukidashi.appendChild(user_id);
			 div_chat_hukidashi.appendChild(buttonElement);

			 div_chat_area.appendChild(div_chat_hukidashi);

			 div_chat_face.appendChild(imge);

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
	var param = "action=Tweet-getUserSearch&others_id="+textBoxValue;
	req.open('POST', '../php/DAO.php', true);
	req.setRequestHeader( 'Content-Type', 'application/x-www-form-urlencoded' );
	req.send(param);
}

function followOther(){
	var other_id = this.getAttribute("data-userid");
	var textBoxValue = other_id;
	var param = "action=Tweet-setFollowUser&user_id="+textBoxValue;
	req.open('POST', '../php/DAO.php', true);
	// POST 送信の場合は Content-Type は固定.
	req.setRequestHeader( 'Content-Type', 'application/x-www-form-urlencoded' );
	req.send(param);
}
