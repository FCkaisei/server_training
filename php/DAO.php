<?php
    $action = $_POST['action'];
	$str_array = explode("-",$action);
    switch ($str_array[0]) {
	    case 'Tweet':
			require_once('./TweetDAO.php');
			$Tweet = new TweetDAO($_POST,$str_array[1]);
	    break;

		case 'Resist':
			require_once('./ResistDAO.php');
			$Resist = new ResistDAO($_POST,$str_array[1]);
		break;

		default:
			exit;
	}
 ?>
