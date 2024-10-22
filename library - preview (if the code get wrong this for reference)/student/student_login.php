<?php
  include "connection.php";
  include "navbar.php";
?>

<!DOCTYPE html>
<html>
<head>

	<title>Student Login</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

	<style type="text/css">
		section
		{
			margin-top: -20px
		}
		
	</style>

</head>
<body>
	<section>
		<div class="log_img">
			<br><br><br>
			<div class="box1">
				<h1 style="text-align: center; font-size: 35px; font-family: Lucida Consol;"> Library Management System</h1>
				<h1 style="text-align: center; font-size: 25px;">User Login Form</h1><br>
				<form name="login" action="" method="post">
					<div class="login">
					 <input class="form-control" type="text" name="username" placeholder="Username" required=""> <br>
					 <input class="form-control" type="password" name="password" placeholder="Password" required=""> <br>
					 <input class="btn btn-default" type="submit" name="submit" value="Login" style="color: black; width: 70px; height: 30px">
					</div>
				 <p style="color: white; padding-left: 15px;">
					<br><br>
					<a style="color: white; text-decoration: none" href="update_password.php">Forgot Password?</a> &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
					New to this website?<a style="color: white;" href="registration.php">&nbspSign Up</a>
				 </p>
				</form>
			</div>
		</div>
	</section>

	<?php

    if(isset($_POST['submit']))
    {
      $count=0;
      $res=mysqli_query($db,"SELECT * FROM `student` WHERE username='$_POST[username]' && password='$_POST[password]';");
      
      $row= mysqli_fetch_assoc($res);
      $count=mysqli_num_rows($res);

      if($count==0)
      {
        ?>
              <!--
              <script type="text/javascript">
                alert("The username and password doesn't match.");
              </script> 
              -->
          <div class="alert alert-danger" style="width: 600px;margin-top:  50px; margin-left: 450px; background-color: #f2dede; color: #a94442">
            <strong>The username and password doesn't match</strong>
          </div>    
        <?php
      }
      else
      {
        $_SESSION['login_user'] = $_POST['username'];
        $_SESSION['pic']= $row['pic'];
        
        ?>
          <script type="text/javascript">
            window.location="index.php"
          </script>
        <?php
      }
    }

  ?>

</body>
</html>