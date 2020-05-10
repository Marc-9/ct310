
<?php
/*
I feel like if you read the comments in the file comments.php it should explain what is happening here, but basically here it goes
The action var reffers to the 4 different actions that could be taking place, upvote(1),downvote(2),saving an edit(3) and deleting(4)
Of course many of these actions come with stipulations that need to be checked, so I check what action is occuring and then if
applicable I check the stipulation, I query the databse accordingly and return with an error header code to specify to the caller
page what stipulations were triggered to it may handle the actions on its end.
Basically it allows everything to happen without a refresh, so when I delete a comment I send back the error code stipulation
to reference that and then the comments page will 'delete' the comment by hiding certain elements.
*/
session_start();
require('config.php');
$db= mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE);
//$arr = $_GET['id'];
$action = $_POST['action'];
$commentid = $_POST['commentid'];
$userid = $_SESSION['id'];
if($action == 3){
	$db->query("UPDATE comments set comment = '".$_POST['comment']."', edited = CURRENT_TIMESTAMP WHERE id = $commentid");
}
else if($action == 4){
	$check = $db->query("SELECT * FROM user_comment WHERE replyid = $commentid ");
	if(!$check || mysqli_num_rows($check) == 0){
		$db->query("DELETE FROM comments WHERE id = $commentid");
		$db->query("DELETE FROM user_comment WHERE commentid = $commentid");
		header("Status: 404 Not Found");
	}
	else{
		$db->query("UPDATE comments set comment = '[DELETED]', edited = CURRENT_TIMESTAMP WHERE id = $commentid");
		$db->query("UPDATE user_comment set userid = 0 WHERE commentid = $commentid");
		header("Status: 401 Not Found");
	}
}
else{
$result = $db->query("SELECT * FROM comment_actions WHERE userid = $userid AND commentid = $commentid");
if(mysqli_num_rows($result) > 0){
	$check = $result->fetch_assoc();
	if($action == 1 && $check['val'] == 1){
		$db->query("UPDATE comment_actions SET val = 0 WHERE userid = $userid AND commentid = $commentid");
		$db->query("UPDATE user_comment SET score = score-1 WHERE commentid = $commentid");
		header("Status: 404 Not Found");
	}
	else if($action == 1 && $check['val'] == 2){
		$db->query("UPDATE comment_actions SET val = 1 WHERE userid = $userid AND commentid = $commentid");
		$db->query("UPDATE user_comment SET score = score+2 WHERE commentid = $commentid");
	 	header("Status: 401 Not Found");
	 }
	else if($action == 2 && $check['val'] == 1){
		$db->query("UPDATE comment_actions SET val = 2 WHERE userid = $userid AND commentid = $commentid");
		$db->query("UPDATE user_comment SET score = score-2 WHERE commentid = $commentid");
	 	header("Status: 400 Not Found");
	}
	else if($action == 2 && $check['val'] == 2){
		$db->query("UPDATE comment_actions SET val = 0 WHERE userid = $userid AND commentid = $commentid");
		$db->query("UPDATE user_comment SET score = score+1 WHERE commentid = $commentid");
	 	header("Status: 402 Not Found");
	 }
	 else if($action == 1 && $check['val'] == 0){
		$db->query("UPDATE comment_actions SET val = 1 WHERE userid = $userid AND commentid = $commentid");
		$db->query("UPDATE user_comment SET score = score+1 WHERE commentid = $commentid");
	 	header("Status: 403 Not Found");
	 }
	 else if($action == 2 && $check['val'] == 0){
		$db->query("UPDATE comment_actions SET val = 2 WHERE userid = $userid AND commentid = $commentid");
		$db->query("UPDATE user_comment SET score = score-1 WHERE commentid = $commentid");
	 	header("Status: 405 Not Found");
	 }

}
else if($action == 1){
	$db->query("INSERT INTO `comment_actions` (`userid`, `commentid`, `val`) VALUES ( $userid, $commentid, 1)");
	$db->query("UPDATE user_comment SET score = score + 1 WHERE commentid = $commentid");
}
else if($action == 2){
	$db->query("INSERT INTO `comment_actions` (`userid`, `commentid`, `val`) VALUES ( $userid, $commentid, 2)");
	$db->query("UPDATE user_comment SET score = score - 1 WHERE commentid = $commentid");
}
}

?>