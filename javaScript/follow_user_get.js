window.onload = function(){
		getFollowUser();
};

var req = new XMLHttpRequest();


req.onreadystatechange = function() {
    switch ( req.readyState ) {
        case 0:
            console.log( 'uninitialized!' );
            break;
        case 1:
            console.log( 'loading...' );
            break;
        case 2:
            console.log( 'loaded.' );
            break;
        case 3:
            console.log('interactive... '+req.responseText.length+' bytes.' );
            break;
        case 4:
            if( req.status == 200 || req.status == 304 ) {
				var jsonString = req.responseText;
				if(jsonString == null || jsonString == "" || jsonString == undefined ){
					execPost();
					return;
				}
				var jsonObject = JSON.parse(jsonString);
				console.log(jsonObject);
				var tweetBox = document.getElementById("user");
				tweetBox.innerHTML = "";
				for(var i = 0; i < jsonObject.length; i++){
					var element = document.createElement('tr');
					var tdElement = document.createElement("td");
					var buttonElement = document.createElement("button");
					var buttonText = document.createTextNode("アンフォロー");
					buttonElement.appendChild(buttonText);
					var td2Element = document.createElement("td");
					var userName = document.createElement("div");
					var newtext = document.createTextNode(jsonObject[i]["follow_id"]);
					userName.appendChild(newtext);

					buttonElement.onclick = followOther;
					buttonElement.setAttribute("data-userid",jsonObject[i]["follow_id"]);

					element.appendChild(tdElement);
					tdElement.appendChild(buttonElement);
					element.appendChild(td2Element);
					td2Element.appendChild(userName);
					tweetBox.appendChild(element);
				}
            } else {
                console.log( 'Failed. HttpStatus: '+req.statusText );
            }
            break;
		}
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
