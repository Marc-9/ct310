<?php
require('config.php');
$db= mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE);

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	$comment = $_POST['reply'];
	echo $comment;

}?>

<hr>
<form role="form" method="post" id="reused_form">

	<div class="row">
		<div class="col-sm-12 form-group">
			<label for="reply">
				Reply:</label>
			<textarea class="form-control" type="textarea" name="comments" id="comments" placeholder="Your Comments" maxlength="6000" rows="7"></textarea>
		</div>
	</div>


				<div class="row">
		<div class="col-sm-12 form-group">
			<button type="submit" class="btn btn-lg btn-warning btn-block" >Post </button>
		</div>
	</div>

</form>
        
