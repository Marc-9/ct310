<?php
session_start();
require('config.php');
$db= mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE);
//$arr = $_GET['id'];
$action = $_POST['action'];
$commentid = $_POST['commentid'];
$userid = $_SESSION['id'];
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


?>