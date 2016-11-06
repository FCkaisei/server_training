var req2 = new XMLHttpRequest();

req2.onreadystatechange = function() {
    switch ( req2.readyState ) {
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
            console.log('interactive... '+req2.responseText.length+' bytes.' );
            break;
        case 4:
            if( req2.status == 200 || req2.status == 304 ) {
				var jsonString = req2.responseText;
            } else {
                console.log( 'Failed. HttpStatus: '+req2.statusText );
            }
            break;
		}
	}


function execPost() {
	var userIdValue = document.getElementById('userId').value;
	var userPassValue = document.getElementById('userPass').value;
	var userData = userIdValue;
	var param = "user_data="+userData;
	req2.open('POST', '../php/idCheck.php', true);
	req2.setRequestHeader( 'Content-Type', 'application/x-www-form-urlencoded' );
	req2.send(param);
}
