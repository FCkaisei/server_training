var req = new XMLHttpRequest();
window.onload = function(){
	getTweet();
};
// ハンドラの登録.
req.onreadystatechange = function() {
    switch ( req.readyState ) {
        case 0:
            // 未初期化状態.
            console.log( 'uninitialized!' );
            break;
        case 1: // データ送信中.
            console.log( 'loading...' );
            break;
        case 2: // 応答待ち.
            console.log( 'loaded.' );
            break;
        case 3: // データ受信中.
            console.log('interactive... '+req.responseText.length+' bytes.' );
            break;
        case 4: // データ受信完了.
            if( req.status == 200 || req.status == 304 ) {
				var jsonString = req.responseText; // responseXML もあり
				//var jsonString = '[{"id":"24"},{"id":"23"},{"id":"22"},{"id":"21"},{"id":"20"},{"id":"19"},{"id":"18"},{"id":"17"},{"id":"16"},{"id":"15"},{"id":"14"},{"id":"13"},{"id":"12"},{"id":"10"},{"id":"9"},{"id":"8"},{"id":"7"},{"id":"6"},{"id":"5"},{"id":"4"}]';
				var jsonObject = JSON.parse(jsonString);
				console.log(jsonObject);

				var tweetBox = document.getElementById("tweet");
				tweetBox.innerHTML = "";
				for(var i = 0; i < jsonObject.length; i++){
					tweetBox.innerHTML += "<tr>";
					tweetBox.innerHTML += "<td>" + jsonObject[i]['id'];
					tweetBox.innerHTML += "</td>";
					tweetBox.innerHTML += "<td>" + jsonObject[i]['id'];
					tweetBox.innerHTML += "</td>";
					tweetBox.innerHTML += "<td>" + jsonObject[i]['id'];
					tweetBox.innerHTML += "</td>";
					tweetBox.innerHTML += "</tr>";
					tweetBox.innerHTML += "<tr>";
					tweetBox.innerHTML += "<td>ツイート内容:" +jsonObject[i]['tweet_text'];
					tweetBox.innerHTML += "</td>";
					tweetBox.innerHTML += "</tr>";
					tweetBox.innerHTML += "<tr>";
					tweetBox.innerHTML += "<td>" + jsonObject[i]['tweet_text'];
					tweetBox.innerHTML +="</td>";
				}
            } else {
                console.log( 'Failed. HttpStatus: '+req.statusText );
            }
            break;
		}
	}

//ツイート内容を送信
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
