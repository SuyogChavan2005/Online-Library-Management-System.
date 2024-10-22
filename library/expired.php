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
      padding-left: 70%;

    }
    .form-control
    {
      width: 300px;
      height: 40px;
      background-color: black;
      color: white;
    }
    
    body {
      background-image: url("images/aa.jpg");
      background-repeat: no-repeat;
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
  padding-left: 15px;
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
.container
{
  height: 800px;
  width: 85%;
  background-color: black;
  opacity: .8;
  color: white;
  margin-top: -65px;
}
.scroll
{
  width: 100%;
  height: 400px;
  overflow: auto;
}
th,td
{
  width: 10%;
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
    
    <div class="container">
      <?php
      // Check if the user is logged in before displaying content
      if (isset($_SESSION['login_user'])) {
        ?>
        <div style="float: left; padding-left:  5px; padding-top: 20px;">
          <form method="post" action="">
            <button name="submit2" type="submit" class="btn btn-default" style="background-color: #06861a; color: yellow;">RETURNED</button>
            &nbsp&nbsp
            <button name="submit3" type="submit" class="btn btn-default" style="background-color: red; color: yellow;">EXPIRED</button>
          </form>
        </div>
        
        <div style="float: right; padding-top: 10px;">
          <?php 
          $var = 0;
          $result = mysqli_query($db, "SELECT * FROM `fine` WHERE username='{$_SESSION['login_user']}' AND status='not paid';");
          while ($r = mysqli_fetch_assoc($result)) {
            $var = $var + $r['fine'];
          }
          $var2 = $var + $_SESSION['fine'];
          ?>
          <h3>Your fine is: 
          <?php
            echo "$ ".$var2;
          ?>
          </h3>
        </div>

        <br><br><br><br>

        <?php
        $ret = '<p style="color:yellow; background-color:green;">RETURNED</p>';
        $exp = '<p style="color:yellow; background-color:red;">EXPIRED</p>';

        if (isset($_POST['submit2'])) {
          $sql = "SELECT student.username, roll, books.bid, name, authors, edition, approve, issue, issue_book.return 
              FROM student 
              INNER JOIN issue_book ON student.username = issue_book.username 
              INNER JOIN books ON issue_book.bid = books.bid 
              WHERE issue_book.approve ='$ret' AND issue_book.username = '{$_SESSION['login_user']}'  
              ORDER BY `issue_book`.`return` DESC";
          $res = mysqli_query($db, $sql);
        } elseif (isset($_POST['submit3'])) {
          $sql = "SELECT student.username, roll, books.bid, name, authors, edition, approve, issue, issue_book.return 
              FROM student 
              INNER JOIN issue_book ON student.username = issue_book.username 
              INNER JOIN books ON issue_book.bid = books.bid 
              WHERE issue_book.approve ='$exp' AND issue_book.username = '{$_SESSION['login_user']}'  
              ORDER BY `issue_book`.`return` DESC";
          $res = mysqli_query($db, $sql);
        } else {
          $sql = "SELECT student.username, roll, books.bid, name, authors, edition, approve, issue, issue_book.return 
              FROM student 
              INNER JOIN issue_book ON student.username = issue_book.username 
              INNER JOIN books ON issue_book.bid = books.bid 
              WHERE issue_book.approve != '' AND issue_book.approve != 'Yes'  
              AND issue_book.username = '{$_SESSION['login_user']}'  
              ORDER BY `issue_book`.`return` DESC";
          $res = mysqli_query($db, $sql);
        }

        echo "<table class='table table-bordered' style='width:100%;' >";
        echo "<tr style='background-color: #6db6b9e6;'>";
        echo "<th>Username</th>";
        echo "<th>Roll No</th>";
        echo "<th>BID</th>";
        echo "<th>Book Name</th>";
        echo "<th>Authors Name</th>";
        echo "<th>Edition</th>";
        echo "<th>Status</th>";
        echo "<th>Issue Date</th>";
        echo "<th>Return Date</th>";
        echo "</tr>"; 
        echo "</table>";

        echo "<div class='scroll'>";
        echo "<table class='table table-bordered'>";
        while ($row = mysqli_fetch_assoc($res)) {
          echo "<tr>";
          echo "<td>".$row['username']."</td>";
          echo "<td>".$row['roll']."</td>";
          echo "<td>".$row['bid']."</td>";
          echo "<td>".$row['name']."</td>";
          echo "<td>".$row['authors']."</td>";
          echo "<td>".$row['edition']."</td>";
          echo "<td>".$row['approve']."</td>";
          echo "<td>".$row['issue']."</td>";
          echo "<td>".$row['return']."</td>";
          echo "</tr>";
        }
        echo "</table>";
        echo "</div>";
      } else {
        // If the user is not logged in, display a message
        echo "<h3>Please login to view your book requests.</h3>";
      }
      ?>
    </div>
  </div>
</body>
</html>
