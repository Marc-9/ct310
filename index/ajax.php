<?php 
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    header('Method Not Allowed', true, 405);
    echo "GET method requests are not accepted for this resource";
    exit;
}
session_start();
require('config.php');
$action = $_POST['action'];
if($action == "upvote"){

}
else if($action == "downvote"){

}
else if($action == "edit"){

}

else if($action == "delete"){

}
else{
	return False;
}
return True

?>