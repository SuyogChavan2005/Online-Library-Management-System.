<?php
  include "connection.php";
  include "navbar.php";
?>
<!DOCTYPE html>
<html>
<head>
	<title>Change Password</title>

	<style type="text/css">
		body
		{
			height: 650px;
			background-image: url("image/7.jpg");
			
		}
		.wrapper
		{
			width: 500px;
			height: 400px;
			margin: 100px auto;
			background-color: black;
			opacity: .8;
			color: white;
			padding: 27px 15px;

		}
		.form-control
		{
			width: 350px;
		}
	</style>
</head>
<body>
	<div class="wrapper">
		<div style="text-align: center;">
			<h1 style="text-align: center; font-size: 35px; font-family: Lucida Consol;"> Change Your Password</h1>
		</div>
		<div style="padding-left: 60px;">
		<form action="" method="post">
			<input type="text" name="username" class="form-control" placeholder="Username" required=""><br>
			<input type="text" name="email" class="form-control" placeholder="Email" required=""><br>
			<input type="text" name="password" class="form-control" placeholder="New Password" required=""><br>
			<button class="btn btn-default" type="submit" name="submit">
				Update
			</button>

		</form>
	</div>
	</div>
	<?php 
		if(isset($_POST['submit']))
		{
			if(mysqli_query($db,"UPDATE admin SET password= '$_POST[password]' WHERE username='$_POST[username]' AND email='$_POST[email]' ;"))
			{
				?>
				<script type="text/javascript">
                   window.location="../login.php"
                </script> 

				<?php
			}
		}
	?>
</body>
</html>