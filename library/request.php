<?php
  include "connection.php";
  include "navbar.php";

  // Start session at the beginning of the script
  if (session_status() === PHP_SESSION_NONE) {
      session_start();
  }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Book Request</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<style type="text/css">
		.srch
		{
			padding-left: 1000px;

		}
		
		body {
  font-family: "Lato", sans-serif;
  transition: background-color .5s;
}

.sidenav {
  height: 100%;
  margin-top: 50px;
  width: 0;
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  background-color: #222;
  overflow-x: hidden;
  transition: 0.5s;
  padding-top: 60px;
}

.sidenav a {
  padding: 8px 8px 8px 32px;
  text-decoration: none;
  font-size: 25px;
  color: #818181;
  display: block;
  transition: 0.3s;
}

.sidenav a:hover {
  color: white;
}

.sidenav .closebtn {
  position: absolute;
  top: 0;
  right: 25px;
  font-size: 36px;
  margin-left: 50px;
}

#main {
  transition: margin-left .5s;
  padding: 16px;
}

@media screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 18px;}
}
.img-circle
{
	margin-left: 20px;
}
.h:hover
{
	color:white;
	width: 300px;
	height: 50px;
	background-color: #00544c;
}
th,td,input
{
	width: 100px;
}
	</style>

</head>
<body>
<!--_________________sidenav_______________-->
	
	<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>

  			<div style="color: white; margin-left: 60px; font-size: 20px;">

                <?php
                // Check if the user is logged in
                if(isset($_SESSION['login_user']))
                {
                	echo "<img class='img-circle profile_img' height=120 width=120 src='image/".$_SESSION['pic']."'>";
                    echo "</br></br>";
                    echo "Welcome ".$_SESSION['login_user']; 
                }
                else
                {
                    echo "Please log in.";
                }
                ?>
            </div><br><br>

  <div class="h"> <a href="books.php">Books</a></div>
  <div class="h"> <a href="request.php">Book Request</a></div>
  <div class="h"> <a href="issue_info.php">Issue Information</a></div>
  <div class="h"><a href="expired.php">Expired List</a></div>

</div>
<div id="main">
  
  <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; open</span>
<div class="container">


	<script>
	function openNav() {
	  document.getElementById("mySidenav").style.width = "300px";
	  document.getElementById("main").style.marginLeft = "300px";
	  document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
	}

	function closeNav() {
	  document.getElementById("mySidenav").style.width = "0";
	  document.getElementById("main").style.marginLeft= "0";
	  document.body.style.backgroundColor = "white";
	}
	</script>
	<br><br>
	
	<?php
    // Ensure the user is logged in before querying the database
	if (isset($_SESSION['login_user'])) {
		$q = mysqli_query($db, "SELECT * FROM issue_book WHERE username='{$_SESSION['login_user']}' AND approve='';");

		if (mysqli_num_rows($q) == 0) {
			echo "<h1>There's no pending request.</h1>";
		} else {
			?>
				<form method="post">
			<?php
			echo "<table class='table table-bordered table-hover'>";
			echo "<tr style='background-color: #6db6b9e6;'>";
			echo "<th>Select</th>";
			echo "<th>Book-ID</th>";
			echo "<th>Approve Status</th>";
			echo "<th>Issue Date</th>";
			echo "<th>Return Date</th>";
			echo "</tr>";

			while ($row = mysqli_fetch_assoc($q)) {
				echo "<tr>";
				echo "<td><input type='checkbox' name='check[]' value='".$row["bid"]."'></td>";
				echo "<td>".$row['bid']."</td>";
				echo "<td>".$row['approve']."</td>";
				echo "<td>".$row['issue']."</td>";
				echo "<td>".$row['return']."</td>";
				echo "</tr>";
			}
			echo "</table>";
			?>
			<p align="center"><button type="submit" name="delete" class="btn btn-success" onclick="location.reload()">Delete</button></p>

			<?php
		}
	} else {
		echo "<h1>Please login to view the book requests.</h1>";
	}
	?>
</div>
</div>

<?php
	if (isset($_POST['delete'])) {
		if (isset($_POST['check'])) {
			foreach ($_POST['check'] as $delete_id) {
				// Delete selected books for the logged-in user
				mysqli_query($db, "DELETE FROM issue_book WHERE bid='$delete_id' AND username='{$_SESSION['login_user']}' LIMIT 1;");
			}
		}
	}
?>

</body>
</html>
