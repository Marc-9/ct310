<?php
session_start();
require('config.php');
$db= mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE);

$arr = $_GET['id'];
//$arr = $_POST['data'];
$arr2 = explode("_",$arr);
$action = $arr2[0];
$check_num = $db->query("SELECT * FROM comment_actions WHERE userid = ".$_SESSION['id']." AND commentid =$arr2[1]");

if($action == 1){
	if(mysqli_num_rows($check_num) == 0){
		$db->query("INSERT INTO `comment_actions` (`userid`, `commentid`, `val`) VALUES ( ".$_SESSION['id'].", $arr2[1], 1)");
		return True;
	}
	else{
		$check_val = $check_num->fetch_assoc();
		if($check_val['val'] == 1){
			echo $check_val['val'];
			$db->query("UPDATE comment_actions SET val = 0 WHERE commentid = $arr2[1] AND userid = ".$_SESSION['id']." ");
			return True;
		}
		else{
			$db->query("UPDATE comment_actions SET val = 1 WHERE commentid = $arr2[1] AND userid = ".$_SESSION['id']." ");
			return True;
		}
		
	}
}

else if($action == 2){
	if(mysqli_num_rows($check_num) == 0){
		$db->query("INSERT INTO `comment_actions` (`userid`, `commentid`, `val`) VALUES ( ".$_SESSION['id'].", $arr2[1], 2)");
		return True;
	}
	else{
		$check_val = $check_num->fetch_assoc();
		if($check_val['val'] == 2){
			$db->query("UPDATE comment_actions SET val = 0 WHERE commentid = $arr2[1] AND userid= ".$_SESSION['id']." ");
			return True;
		}
		else{
			$db->query("UPDATE comment_actions SET val = 2 WHERE commentid = $arr2[1] AND userid= ".$_SESSION['id']." ");
			return True;
		}
		
	}

}



?>