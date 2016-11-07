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
				var jsonObject = JSON.parse(jsonString);
				console.log(jsonObject);
				var tweetBox = document.getElementById("user");
				tweetBox.innerHTML = "";
				for(var i = 0; i < jsonObject.length; i++){
					/*
					ユーザーNAME,
					フォローボタン
					*/
					tweetBox.innerHTML += "<tr>"
					+"<td>"
					+jsonObject[i]['userid']
					+"</td>"
					+"<td>"
					//ボタンにしたろ
					+"<button onClick='followOther("+jsonObject[i]['userid']+")' value='フォロー'></button>"
					+"</td>"
					+"</tr>"
				}
            } else {
                console.log( 'Failed. HttpStatus: '+req.statusText );
            }
            break;
		}
	}

function execPost() {
	var textBoxValue = document.getElementById('others_id').value;
	var param = "others_id="+textBoxValue;
	req.open('POST', '../php/user_search.php', true);
	// POST 送信の場合は Content-Type は固定.
	req.setRequestHeader( 'Content-Type', 'application/x-www-form-urlencoded' );
	req.send(param);
}

function followOther(other_id){
	var textBoxValue = other_id;
	var param = "user_id="+textBoxValue;
	req.open('POST', '../php/followEnd.php', true);
	// POST 送信の場合は Content-Type は固定.
	req.setRequestHeader( 'Content-Type', 'application/x-www-form-urlencoded' );
	req.send(param);
}
