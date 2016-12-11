<?php
	require_once '../baseDB/connect_db.php';
	$error = array();
	function CheckError($error_data){
		for ($i = 0 ; $i < count($error); $i++) {
			error_log("ERROR:".$error,0);
		}
	}
 ?>
