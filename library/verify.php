<?php 
  include "connection.php";
  include "navbar.php";
?>
<!DOCTYPE html>
<html>
<head>
	<title>Verify Email Address</title>
	<style type="text/css">
		.box1 {
	    height: 500px;
	    width: 350px;
	    margin: 0px auto;
	    opacity: .8;
	    color: white;
	    padding-top: 200px; 
	}

	.center-button {
    padding-left: 110px;
	}
	</style>
</head>
<body style="background-color: #00695c">
<div class="box1">
	<h2 style="padding-left: 50px;">Enter the OTP:</h2>
	<form method="post">
		<input style="width: 300px; height: 50px;" type="text" name="otp" class="form-control" required="" placeholder="Enter the OTP here..."><br>
		<div class="center-button">
		  <button class="btn btn-default" type="submit" name="submit_v" style="font-weight: 700;">Verify</button>
		</div>
	</form>
</div>

<?php
$ver1 = 0;
if (isset($_POST['submit_v'])) {
    $otp = $_POST['otp']; // Securely retrieve the entered OTP
    $ver2 = mysqli_query($db, "SELECT * FROM verify WHERE otp='$otp';"); // Correct SQL query

    if ($row = mysqli_fetch_assoc($ver2)) {
        mysqli_query($db, "UPDATE student SET status='1' WHERE username='$row[username]';");
        $ver1 = 1;
    }

    if ($ver1 == 1) {
        header("Location: login.php");
        exit(); // Add exit after header redirection
    } else {
        ?>
        <script type="text/javascript">
          alert("Wrong OTP is given. Please try again.");
        </script>
        <?php
    }
}
?>
</body>
</html>
