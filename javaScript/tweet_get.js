var req = new XMLHttpRequest();
window.onload = function(){
	getTweet();
};
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
					return;
				}
				var jsonObject = JSON.parse(jsonString);
				console.log(jsonObject);
				var tweetBox = document.getElementById("tweet");
				tweetBox.innerHTML = "";
				for(var i = 0; i < jsonObject.length; i++){
					tweetBox.innerHTML += "<tr>"
					+"<td>"
					+jsonObject[i]['user_id']
					+"</td>"
					+"<td>"
					+jsonObject[i]['time']
					+"</td>"
					+"</tr>"
					+"<tr>"
					+"<td colspan=2>ツイート内容:"
					+jsonObject[i]['tweet_text']
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
	var textBoxValue = document.getElementById('tweetText').value;
	var param = "tweet_text="+textBoxValue;
	req.open('POST', '../php/tweet_post.php', true);
	// POST 送信の場合は Content-Type は固定.
	req.setRequestHeader( 'Content-Type', 'application/x-www-form-urlencoded' );
	req.send(param);
}

function getTweet(){
	req.open('POST', '../php/tweet_get.php', true);
	req.setRequestHeader( 'Content-Type', 'application/x-www-form-urlencoded' );
	req.send(null);
}
