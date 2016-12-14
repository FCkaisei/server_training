<?php
    $action = $_POST['action'];
	$str_array = explode("-",$action);
    switch ($action[0]) {
	    case 'Tweet':
			require_once('./TweetDAO.php');
			$Tweet    = new TweetDAO($_POST,$str_array[1]);
	    break;

		default:
		exit;
	}
 ?>
