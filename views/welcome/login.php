<?php
if(isset($_SESSION['id'])){
	header('location:index');
	}
?>

<style>
	.log {
		text-align: center;
		margin-top: 25%;
	}
	
	#sub {
		margin-left: 5%;
	}
</style>

<div class="log">
	<form method="post">
		<label for="user">Username: </label>
		<input type="text" id="user" name="user" placeholder="username" required>
		
		<br><br>
		
		<label for="pass">Password: </label>
		<input type="password" id="pass" name="pass" placeholder="password" required>
		
		<br><br>
		
		<input type="submit" id="sub" value="Submit">
	</form>
</div>
<br>

<?php
	if(isset($_POST["user"])) {
		foreach($logins as $l) {
			if($_POST["user"] == $l["username"] && $_POST["pass"] == $l["password"]) {
				echo "<p style=\"color:green; margin-left:48%\">Login Successful</p>";
				
				if($l["username"] == "ct310") {
					$_SESSION["id"] = 1;
				}
				else {
					$_SESSION["id"] = 2;
				}
				
				header("refresh:1;url=index");
				return;
			}
		}
		
		echo "<p style=\"color:red; margin-left:43%\">Username or Password Incorrect</p>";
	}
?>