var req = new XMLHttpRequest();
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
			}
		}
	}
//idとpass送信
function execPost() {
	var userIdValue = document.getElementById('userId').value;
	var userPassValue = document.getElementById('userPass').value;
	var param = "user_id="+userIdValue+"user_pass"+userPassValue;
	req.open('POST', '../php/idCheck.php', true);
	req.setRequestHeader( 'Content-Type', 'application/x-www-form-urlencoded' );
	req.send(param);
}
