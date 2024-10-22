<?php
  include "navbar.php";
  include "connection.php"; 
?>

<!DOCTYPE html>
<html>
<head>
	<title>Feedback</title>
	
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
    <style type="text/css">
    	body {
    		background-image: url("image/66.jpg");
    	}
    	.wrapper {
    		padding: 10px;
    		margin: -20px auto;
    		width: 900px;
    		height: 650px;
    		background-color: black;
    		opacity: .8;
    		color: white;
    	}
    	.form-control {
    		height: 70px;
    		width: 60%;
    	}
    	.scroll {
    		width: 100%;
    		height: 300px;
    		overflow: auto;
    	}
    </style>
</head>
<body>

	<div class="wrapper">
		<h4>If you have any suggestions or questions, please comment below.</h4>
		
		<?php
		if(isset($_SESSION['login_user'])) { // Check if user is logged in
		?>
			<form action="" method="post">
				<input class="form-control" type="text" name="comment" placeholder="Write something..." required><br>	
				<input class="btn btn-default" type="submit" name="submit" value="Comment" style="width: 100px; height: 35px;">
			</form>
		<?php
		} else {
			echo "<p>Please <a href='login.php'>login</a> to comment.</p>";
		}
		?>
		
		<br><br>
		<div class="scroll">
			<?php
			if(isset($_POST['submit'])) {
				if(!empty($_POST['comment'])) {
					$comment = mysqli_real_escape_string($db, $_POST['comment']); // Escape special characters in input
					$sql = "INSERT INTO `comments` (username, comment) VALUES ('$_SESSION[login_user]', '$comment');";
					if(mysqli_query($db, $sql)) {
						echo "<p>Comment added successfully.</p>";
					}
				}
			}

			// Fetch and display comments
			$q = "SELECT * FROM `comments` ORDER BY `id` DESC";
			$res = mysqli_query($db, $q);

			echo "<table class='table table-bordered'>";
			while ($row = mysqli_fetch_assoc($res)) {
				echo "<tr>";
				echo "<td>"; echo $row['username']; echo "</td>";
				echo "<td>"; echo $row['comment']; echo "</td>";
				echo "</tr>";
			}
			echo "</table>";
			?>
		</div>
	</div>
	
</body>
</html>
