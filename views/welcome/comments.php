<?php
// Ok this code is very gross, but with finals a couple days away I had to finish, so I apologize for that
// The good thing about this is this code is EXTERMELLY portable, any page with an ?id= just needs to include this file 
// and comments will work seemelsy
require('config.php');
//Only one database was allocated per student, so all queries go to their respective tables their
$db= mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE);

// New comments are sent via post request so lets check if one was sent with this
if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	// Replies and comments send their comments through this post variable
	$comment = $_POST['reply'];

	// Start by inserting the comment into the datavase with the current time
	$db->query("INSERT INTO `comments` (`comment`, `created`) VALUES ('".$comment."', CURRENT_TIMESTAMP)");
	//Ya I know this is a bad implementation but come on cut me some slack here
	//I then need to grab the id of the comment I just inserted by grabbing the most recent comment
	$id = mysqli_fetch_assoc($db->query("SELECT id FROM comments ORDER BY id DESC LIMIT 0, 1"));
	// Replies also send a secret extra post variable which I check for here
	if(isset($_POST['replyid'])){
		$reply = $_POST['replyid'];
		// If it is set I need to set the replyid and not the parent id 
		$db->query("INSERT INTO `user_comment` (`userid`, `commentid`, `replyid`, `score`) VALUES (".$_SESSION['id'].", ".$id['id'].", $reply, '0')");
	}
	else{
		// If not it means it is a top level comment an no reply id but a parent id (the page id) is set
		$db->query("INSERT INTO `user_comment` (`userid`, `commentid`, `parentid`, `score`) VALUES (".$_SESSION['id'].", ".$id['id'].", ".$_GET['id'].", '0')");
	}

}?>

<?php

// Only allows logged in users to view/make a commnet
if(!isset($_SESSION['id'])){
	echo
	"<hr><h2>To leave a comment please login</h2>";
}
else{
//This is the post a comment section
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
//Here is where I check for replies, any top level comments have their parent id set to the page id, so I get that and look it up
$result = $db->query("SELECT * FROM user_comment WHERE parentid=".$_GET['id']." ");
echo "<div class='comments'>";
//This while loop goes through each row of the resultant sql query
while($comment = $result->fetch_assoc()){
	// This table doesnt have the comment, just data about it and the comment id, so I look it up to get the actual comment
	$res_comment = mysqli_fetch_assoc($db->query("SELECT * FROM comments WHERE id = ".$comment['commentid']." "));
	// Yes this is realy weird and hacky but we are being graded on cmpletion, I PROMISE I woudl never do this in real life.
	// but this is due the day before 3 exams so I need to be able to study
	// This variable is altered for each child comment to give it an indent
	$width = 0;
	//Start of the recursive function to print all comments
	print_comment($res_comment,$db,$width,$comment);
	
}
echo "</div>";
}

/*
How comments work, each comment gets generated a random id and all comment buttons and divs are assigned this id with their prefix
like like$ran $dislike$ran so I may modify them with jquery in the script below, does this work, yes is it gross, a bit I guess
its possible to get the same number generated but you could always increase the bounds, Im not sure of any other way to just interact
with one thing especialy whne I use a loop to print them out.
*/

function print_comment($x,$db,$width,$comment){
	// Generate a random number from 1 to 100, a weird and gross hack which will becomme apparent
	$ran = rand(1,100);
	//Here the width variable is used to set the margin-left css style and then I print the comment
	echo "<div id='$ran'><div class='parent' style='margin-left:".$width."px'><div id='comment$ran'>".$x['comment']."</div>";
	if($comment['userid'] != 0){echo "<div class='actions'><button type='button' id='reply$ran' onclick='fun($ran)'>Reply</button><button type='button' id='like$ran' onclick='foo(\"".$ran."_1_".$x['id']."\")'>Like</button><button type='button' id='dislike$ran' onclick='foo(\"".$ran."_2_".$x['id']."\")' >Dislike</button>";}else{ echo "<div class='actions'>";}
	//Reply Like and Dislike are all actions every user gets, here I check which user it is to see if they can see the edit/delete
	//Normally I would check for admin rather than id == 2, but there is only 1 admin and he id 2
	if( ( ($comment['userid'] == $_SESSION['id']) || $_SESSION['id'] == 2) && $comment['userid'] != 0) {echo "<button type='button' id='edit$ran' onclick='edit($ran)'>Edit</button><button type='button' id='save$ran' onclick='save(\"".$ran."_3_".$x['id']."\")' style='display:none'>Save</button><button type='button' id='delete$ran' onclick='delete_com(\"".$ran."_4_".$x['id']."\")'>Delete</button></div>";}else{echo"</div>";}
	$uname = mysqli_fetch_assoc($db->query("SELECT username FROM users WHERE id = ".$comment['userid']." "));
	echo"
	<div class='info'>Score: <div id='score$ran' style='display:inline'>".$comment['score']."</div> &nbsp; &nbsp; Posted By-";
	if ($comment['userid'] == 0){ echo "[Deleted]";}else{ echo "<div id='poster$ran' style='display:inline'>".$uname['username']."</div>";}
	echo"&nbsp; &nbsp At-".$x['created']." ";
	if($x['edited'] != NULL){echo"&nbsp; &nbsp; Edited Last-".$x['edited']." </div></div>";}
	else{echo"</div></div>";}
	//Below is a hidden reply form, here I use the random number, and the reply button calls a JS function with the random number
	//So it can find the rpely id and show it contents and not every reply box on the page
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
	//Here are the recurisve function break requirements, making this a tail recursion
	//Using the current comment id check if there are any comments with a reply id matching this id
	// If so continue the recursive function
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
//Lets let the bottom breathe a bit shall we?
echo"<br><br>";
?>

<script>
/* 
All right are you ready for the craziest hack ever, this is really gross but I couldnt think of any other way to do it
Somehow I need to asynchronously change the upvote/downvote but I also need to query the database and wait for its response
to tell me if there is already an upvote/downvote or if they have nulled their previous vote. Ofc if you have to wait for a query 
it is not asynchronous. What I did is I checked each case, and returned an error code that corresponded with a certain action
this allowed me to catch it AND know what actions I needed to take
*/
function foo(data){
var arr = data.split("_");
$.ajax({
    type:     "post",
    data:     {action: arr[1], commentid: arr[2]},
    cache:    false,
    url:      "../../ajax.php",
    dataType: "text",
    error: function(xhr, textStatus, thrownError) {
        if(xhr.status==404) {
        // This error means they have previously upvoted this comment and would like to revoke that decision
       	var prev = $('#score'+arr[0]).text();
		prev = parseInt(prev) - 1;
		$('#score'+arr[0]).text(prev);
   	 }
   	 	else if(xhr.status==401){
   	 	// This error means they had previously downvoted but now want to upvote
   	 	var prev = $('#score'+arr[0]).text();
		prev = parseInt(prev) + 2;
		$('#score'+arr[0]).text(prev);
   	 }
   	 else if(xhr.status==400){
   	 	// This error means they had previously upvoted and now want to downvote
   	 	var prev = $('#score'+arr[0]).text();
		prev = parseInt(prev) - 2;
		$('#score'+arr[0]).text(prev);
   	 }
   	 else if(xhr.status==402){
   	 	// This error means they had previously downvoted and now want to revoke that decision
   	 	var prev = $('#score'+arr[0]).text();
		prev = parseInt(prev) + 1;
		$('#score'+arr[0]).text(prev);
   	 }
   	 else if(xhr.status==403){
   	 	// This error means they had previously nullified their vote and would like to upvote
   	 	var prev = $('#score'+arr[0]).text();
		prev = parseInt(prev) + 1;
		$('#score'+arr[0]).text(prev);
   	 }
   	 else if(xhr.status==405){
   	 	// This error means they had previously nullified their vote and would like to downvote
   	 	var prev = $('#score'+arr[0]).text();
		prev = parseInt(prev) - 1;
		$('#score'+arr[0]).text(prev);
   	 }
    },
    success: function () {
    	// These are separate because as I found out after a long time an ajax 'success' just means 200 file was found
    	// These just check the action id and upvote downvote accordingly
    	if(arr[1] == 1){
       		var prev = $('#score'+arr[0]).text();
			prev = parseInt(prev) + 1;
			$('#score'+arr[0]).text(prev);
		}
		if(arr[1] == 2){
       		var prev = $('#score'+arr[0]).text();
			prev = parseInt(prev) - 1;
			$('#score'+arr[0]).text(prev);
		}
    }
});
};


// Edit was pretty easy, but I needed to make it clear that something had changed so hence the shake and border
function edit(id){
	$('#comment'+id).attr('contenteditable','true');
	$('#comment'+id).css({"border-color": "#C1E0FF", 
             "border-width":"1px", 
             "border-style":"solid"});
	$('#comment'+id).effect( "shake" );
	$('#save'+id).css("display","inline");
}

// Separated the two actions, just cause it was easier, save button only appears when edit is pressed and disappears after you save
function save(data){
	var arr = data.split("_");
	$('#comment'+arr[0]).attr('contenteditable','false');
	$('#save'+arr[0]).css("display","none");
	$('#comment'+arr[0]).css({"border-color": "none", 
             "border-width":"none", 
             "border-style":"none"});
    var comment = $('#comment'+arr[0]).text();
    $.ajax({
   		type:     "post",
    	data:     {action: arr[1], commentid: arr[2], comment: comment},
    	cache:    false,
    	url:      "../../ajax.php",
    	dataType: "text"
    });
}

// A bit tricky like upvote/downvote as you have to check if replies exist, so I implemented the same concept with the erro codes
function delete_com(data){
	var arr = data.split("_");
	 $.ajax({
   		type:     "post",
    	data:     {action: arr[1], commentid: arr[2]},
    	cache:    false,
    	url:      "../../ajax.php",
    	dataType: "text",
    	error: function(xhr, textStatus, thrownError) {
    		// If the comment has no children
        	if(xhr.status==404) {
       			$('#'+arr[0]).css("display","none");
				
   	 		}
   	 		// If the comment has children
   	 		else if(xhr.status==401) {
       			$('#comment'+arr[0]).text('[DELETED]');
       			$('#reply'+arr[0]).css("display","none");
       			$('#like'+arr[0]).css("display","none");
       			$('#dislike'+arr[0]).css("display","none");
       			$('#edit'+arr[0]).css("display","none");
       			$('#delete'+arr[0]).css("display","none");
       			$('#poster'+arr[0]).css("display","none");
   	 		}
   	 	}
    })
}

// Action to show or hide the reply box
function fun(num){
	$("#hidden"+num).toggle();

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

        
