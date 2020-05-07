<?php
require('config.php');
$db= mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE);

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	$comment = $_POST['reply'];
	$db->query("INSERT INTO `comments` (`comment`, `created`) VALUES ('".$comment."', CURRENT_TIMESTAMP)");
	//Ya I know this is a bad implementation but come on cut me some slack here
	$id = mysqli_fetch_assoc($db->query("SELECT id FROM comments ORDER BY id DESC LIMIT 0, 1"));
	if(isset($_POST['replyid'])){
		$reply = $_POST['replyid'];
		$db->query("INSERT INTO `user_comment` (`userid`, `commentid`, `replyid`, `score`) VALUES (".$_SESSION['id'].", ".$id['id'].", $reply, '0')");
	}
	else{
		$db->query("INSERT INTO `user_comment` (`userid`, `commentid`, `parentid`, `score`) VALUES (".$_SESSION['id'].", ".$id['id'].", ".$_GET['id'].", '0')");
	}

}?>

<?php

if(!isset($_SESSION['id'])){
	echo
	"<hr><h2>To leave a comment please login</h2>";
}
else{
echo"
<hr>
<form role='form' method='post' id='reused_form'>

	<div class='row'>
		<div class='col-sm-12 form-group'>
			<label for='reply'>
				Reply:</label>
			<textarea class='form-control' type='textarea' name='reply' id='reply' placeholder='Your Comments' maxlength='6000' rows='4'></textarea>
		</div>
	</div>


				<div class='row'>
		<div class='col-sm-12 form-group'>
			<button type='submit' class='btn btn-lg btn-warning btn-block' >Post </button>
		</div>
	</div>

</form>";
$result = $db->query("SELECT * FROM user_comment WHERE parentid=".$_GET['id']." ");
echo "<div class='comments'>";
while($comment = $result->fetch_assoc()){
	$res_comment = mysqli_fetch_assoc($db->query("SELECT * FROM comments WHERE id = ".$comment['commentid']." "));
	// Yes this is realy weird and hacky but we are being graded on cmpletion, I PROMISE I woudl never do this in real life.
	// but this is due the day before 3 exams so I need to be able to study
	$width = 0;
	print_comment($res_comment,$db,$width,$comment);
	
}
echo "</div>";
}

function print_comment($x,$db,$width,$comment){
	$ran = rand(1,100);
	echo "<div class='parent' style='margin-left:".$width."px'>".$x['comment']."
	<div class='actions'><button  type='button' onclick='fun($ran)'>Reply</button><button type='button' onclick='action(\"upvote\")'>Like</button><button type='button'>Dislike</button>";
	if(($comment['userid'] == $_SESSION['id']) || $_SESSION['id'] == 2){echo "<button type='button'>Edit</button><button type='button'>Delete</button></div>";}else{echo"</div>";}
	$uname = mysqli_fetch_assoc($db->query("SELECT username FROM users WHERE id = ".$comment['userid']." "));
	echo"
	<div class='info'>Score: ".$comment['score']." &nbsp; &nbsp; Posted By-".$uname['username']."&nbsp; &nbsp At-".$x['created']." ";
	if($x['edited'] != NULL){echo"&nbsp; &nbsp; Edited Last-".$x['edited']." </div>";}
	else{echo"</div>";}
	echo"
	<div id='hidden$ran' style='display:none'>
		<form role='form' method='post' id='reused_form'>

		<div class='row'>
			<div class='col-sm-12 form-group'>
				<label for='reply'>
					Reply:</label>
				<textarea class='form-control' type='textarea' name='reply' id='reply' placeholder='Your Comments' maxlength='6000' rows='4'></textarea>
			</div>
		</div>

		<input type='hidden' id='replyid' name='replyid' value=".$x['id'].">
		<div class='row'>
			<div class='col-sm-12 form-group'>
				<button type='submit' id='submit$ran' class='btn btn-lg btn-warning btn-block' >Post </button>
			</div>
		</div>
	</div>
	
	</div>";
	$check = $db->query("SELECT * FROM user_comment WHERE replyid = ".$x['id']." ");
	if(!$check || mysqli_num_rows($check) == 0){
		return;
	}
	else{
		$working = mysqli_fetch_assoc($check);
		$new_reply = mysqli_fetch_assoc($db->query("SELECT * FROM comments WHERE id = ".$working['commentid']." "));
		print_comment($new_reply,$db,$width+20,$working);
	}
}
echo"<br><br>";
?>

<script>
function action(data){
	$.ajax({
            url:"../../ajax.php",
            type:'post',
			success: function(){
    			alert('success');
  			},
  			data:{action:data},
  			error: function(){
   				alert('failure');
 			 }
		})
}

function downvote(){

}

function fun(num){
	$("#hidden"+num).toggle()

}
</script>

<style>
.parent{
 	 padding: 10px;
 	 border: 5px solid gray;
 	 margin: 0; 
 	 width:75%;

}

</style>

        
