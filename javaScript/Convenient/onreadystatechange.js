function StateChange(req,callBack){
	switch (req.readyState) {
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
				if(req.responseText){
					callBack(req.responseText);
				}
				else if(!req.responseText){
					callBack();
				}
			}
			else {
				console.log( 'Failed. HttpStatus: '+req.statusText );
			}
		break;
	}
}
