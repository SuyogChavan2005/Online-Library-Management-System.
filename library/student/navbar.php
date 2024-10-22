<?php
  include "connection.php";
  session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <title>
  </title>

    <link rel="stylesheet" type="text/css" href="style.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" >


</head>
<body>
 <?php 
  if(isset($_SESSION['login_user'])) 
  {
    // Query to count unread messages
    $r = mysqli_query($db, "SELECT COUNT(status) as total FROM message WHERE status='no' AND username='$_SESSION[login_user]' AND sender='admin';");
    $c = mysqli_fetch_assoc($r);
    
    //--------------------timer--------------//
    // Query to fetch book details
    $b = mysqli_query($db, "SELECT * FROM issue_book WHERE username='$_SESSION[login_user]' AND approve='Yes' ORDER BY `return` ASC LIMIT 0,1;");
    $bid = mysqli_fetch_assoc($b);
    
    // Check if a book record was found
    if ($bid) {
      // Query to fetch timer details
      $t = mysqli_query($db, "SELECT * FROM `timer` WHERE name='$_SESSION[login_user]' AND bid='$bid[bid]';");
      $res = mysqli_fetch_assoc($t);

      // Check if a timer record was found
      if ($res) {
        // Handle fetched timer data, if needed
        // For example: echo or process $res['column_name'];
      } else {
        
      }
    } else {
    }
  }
?>


      <nav class="navbar navbar-inverse">
      <div class="container-fluid">
          <div class="navbar-header">
            <a class="navbar-brand active">ONLINE LIBRARY MANAGEMENT SYSTEM</a>
          </div>
          <ul class="nav navbar-nav">
            <li><a href="index.php">HOME</a></li>
            <li><a href="books.php">BOOKS</a></li>
            <li><a href="feedback.php">FEEDBACK</a></li>
          </ul>
          <?php
            if(isset($_SESSION['login_user']))
            {
          ?>
<!--------------------------------------------------------------timer--------------------------------------------------->
<!-- Display the countdown timer in an element -->
<script>
// Set the date we're counting down to
var countDownDate = new Date("<?php echo $res['tm']; ?>").getTime();

// Update the count down every 1 second
var x = setInterval(function() {

  // Get today's date and time
  var now = new Date().getTime();

  // Find the distance between now and the count down date
  var distance = countDownDate - now;

  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

  // Display the result in the element with id="demo"
  document.getElementById("demo").innerHTML = days + "d " + hours + "h "
  + minutes + "m " + seconds + "s ";

  // If the count down is finished, write some text
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("demo").innerHTML = "EXPIRED";
  }
}, 1000);
</script>

<!--------------------------------------------------------------timer--------------------------------------------------->

                <ul class="nav navbar-nav">
                  <li><a href="profile.php">PROFILE</a></li>
                  <li><a href="fine.php">FINES</a></li>

                </ul>
                <ul class="nav navbar-nav navbar-right">
                  <li><a><p style="color: #ff1503; font-size: 20px;" id="demo"></p></a></li>
                  <li><a href="message.php"><span class="glyphicon glyphicon-envelope"></span> <span class="badge bg-green">
                    <?php echo $c['total'];?>
                  </span></a></li>
                  <li><a href="">
                    <div style="color: white">
                      <?php
                        echo "<img class='img-circle profile_img' height=30 width=30 src='image/".$_SESSION['pic']."'>";
                        echo " ".$_SESSION['login_user']; 
                      ?>
                    </div>
                  </a></li>
                  <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"> LOGOUT</span></a></li>
                </ul>
              <?php
            }
            else
            {   ?>
              <ul class="nav navbar-nav navbar-right">

                <li><a href="../login.php"><span class="glyphicon glyphicon-log-in"> LOGIN</span></a></li>
                
                <li><a href="../registration.php"><span class="glyphicon glyphicon-user"> SIGN UP</span></a></li>
              </ul>
                <?php
            }
          ?>

      </div>
    </nav>
    <?php
      if(isset($_SESSION['login_user']))
      {
        $day=0;

        $exp='<p style="color:yellow; background-color:red;">EXPIRED</p>';
        $res= mysqli_query($db,"SELECT * FROM `issue_book` where username ='$_SESSION[login_user]' and approve ='$exp' ;");
      
      while($row=mysqli_fetch_assoc($res))
      {
        $d= strtotime($row['return']);
        $c= strtotime(date("Y-m-d"));
        $diff= $c-$d;

        if($diff>=0)
        {
          $day= $day+floor($diff/(60*60*24)); 
        } //Days
        
      }
      $_SESSION['fine']=$day*.10;
    }
    ?>
</body>
</html>